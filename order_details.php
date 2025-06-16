
<?php include "header.php";


// Get Order ID from URL
if (!isset($_GET['order_id'])) {
    echo "Invalid Order ID.";
    exit();
}

$order_id = $_GET['order_id'];

// Fetch order details
$sql = "SELECT * FROM ".$siteprefix."orders WHERE order_id = ? AND user = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("ss", $order_id, $user_id);
$stmt->execute();
$order_result = $stmt->get_result();

if ($order_result->num_rows == 0) {
    echo "Order not found.";
    exit();
}

$order = $order_result->fetch_assoc();

// Fetch ordered items
$sql_items = "SELECT 
    oi.*, 
    r.title as resource_title,r.alt_title as alt_title,
    rf.title as main_file, 
  
    df.filename as support_file, 
    tbd.name as support_type_name,
    ri.picture
FROM {$siteprefix}order_items oi
JOIN {$siteprefix}reports r ON oi.report_id = r.id
LEFT JOIN {$siteprefix}reports_files rf ON oi.item_id = rf.id AND oi.item_type = 'main_file'
LEFT JOIN {$siteprefix}doc_file df ON oi.item_id = df.s AND oi.item_type = 'support_doc'
LEFT JOIN {$siteprefix}type_business_docs tbd ON df.doc_typeid = tbd.id AND oi.item_type = 'support_doc'
LEFT JOIN {$siteprefix}reports_images ri ON r.id = ri.report_id
WHERE oi.order_id = ?
";
$stmt = $con->prepare($sql_items);
$stmt->bind_param("s", $order_id);
$stmt->execute();
$items_result = $stmt->get_result();

?>


<div class="container mt-5 mb-5">
    <h2 class="mb-4">Order Details</h2>
    
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Order ID: #<?php echo $order['order_id']; ?></h5>  
            <p><strong>Date:</strong> <?php echo formatDateTime($order['date']); ?></p>
            <p><strong>Status:</strong> 
                <span class="badge bg-<?php echo ($order['status'] == 'Completed'|| $order['status'] == 'paid') ? 'success' : 'warning'; ?>">
                    <?php echo ucfirst($order['status']); ?>
                </span>
            </p>
            <p><strong>Total Amount:</strong> ₦<?php echo formatNumber($order['total_amount'], 2); ?></p>
        </div>
    </div>

    <h4>Items Purchased</h4>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Item</th>
                    <th>Image</th>
                    <th>Original Price</th>
                    <th>Discounted Price</th>
                    <th>Quantity</th>
                    <th>Review</th>
                    <th>download</th>
                </tr>
            </thead>
    <tbody>
<?php while ($item = $items_result->fetch_assoc()) { ?>
    <tr>
        <td>
            <?php
            if ($item['item_type'] == 'main_file') {
            
                echo htmlspecialchars($item['resource_title']);
            } elseif ($item['item_type'] == 'support_doc') {
             
                echo htmlspecialchars($item['support_type_name']) . ' - ' . htmlspecialchars($item['resource_title']);
            }
            ?>
        </td>
        <td>
            <img src="<?php echo $imagePath.'/'. $item['picture']; ?>" alt="Product Image" style="width:50px; height:auto;">
        </td>
        <td>₦<?php echo formatNumber($item['original_price'], 2); ?></td>
        <td>₦<?php echo formatNumber($item['price'], 2); ?></td>
        <td>1</td>
        <td>
            <a href="<?php echo $siteurl.'/product/'.$item['alt_title']; ?>">Give Review</a>
        </td>
        <td>
            <?php
            if ($item['item_type'] == 'main_file' && !empty($item['main_file'])) {
                echo "<a href='{$siteurl}{$documentPath}{$item['main_file']}' class='btn btn-success' download>Download</a>";
            } elseif ($item['item_type'] == 'support_doc' && !empty($item['support_file'])) {
                echo "<a href='{$siteurl}{$documentPath}{$item['support_file']}' class='btn btn-info' download>Download</a>";
            }
            ?>
        </td>
    </tr>
<?php } ?>
</tbody>
        </table>
    </div>

    <a href="my_orders.php" class="btn btn-primary mt-3">Back to My Orders</a>
</div>








<?php include "footer.php"; ?>