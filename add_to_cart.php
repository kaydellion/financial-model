<?php
// add_to_cart.php

require_once 'backend/connect.php';

// Initialize debug array
$debug = array(
    'post_data' => $_POST,
    'errors' => array(),
    'queries' => array(),
    'results' => array()
);

// Get POST data
$report_id = $_POST['reportId'];
$user_id = $_POST['userId'];
$order_id = $_POST['orderId'];
$file_id = $_POST['file_id'];
$support_doc_id = isset($_POST['support_doc_id']) ? $_POST['support_doc_id'] : null;
$affliate = $_POST['affliateId'];

// Determine which item is being added and get price
$selected_id = null;
$selected_price = null;
$original_price = null;

// Debugging: Log POST data
$debug['post_data'] = $_POST;

// Get cart item count
$sql = "SELECT COUNT(*) as count FROM fm_order_items WHERE order_id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("s", $order_id);
$stmt->execute();
$result = $stmt->get_result();
$cart_count = $result->fetch_assoc()['count'];

// Debugging: Log SQL and result for cart count
$debug['queries'][] = $sql;
$debug['results']['cart_count'] = $cart_count;

// Check if user is a loyalty member
$sql = "SELECT * FROM fm_users WHERE s  = '$user_id'";
$sql2 = mysqli_query($con, $sql);
$loyalty = 0; // Default loyalty value
while ($row = mysqli_fetch_array($sql2)) {
    $loyalty = $row['loyalty'];
}

// Debugging: Log loyalty check data
$debug['loyalty_check'] = [
    'user_id' => $user_id,
    'loyalty' => $loyalty
];

// Get price from reports table
$sql = "SELECT price,loyalty FROM fm_reports WHERE id = '$report_id'";
$result = $con->query($sql);
if (!$result || $result->num_rows == 0) {
    $debug['errors'][] = "Report not found.";
    echo json_encode(['success' => false, 'message' => 'Report not found', 'debug' => $debug]);
    exit();
}
$row = $result->fetch_assoc();

// Debugging: Log price query and result
$debug['queries'][] = $sql;
$debug['results']['price'] = $row['price'];
$report_loyalty=$row['loyalty'];

// Check if price is valid
if ($support_doc_id) {
    $selected_id = $support_doc_id;
    $item_type = 'support_doc';
    $sql = "SELECT price, report_id FROM fm_doc_file WHERE s = '$support_doc_id' LIMIT 1";
    $result = $con->query($sql);
    if (!$result || $result->num_rows == 0) {
        $debug['errors'][] = "Support document not found.";
        echo json_encode(['success' => false, 'message' => 'Support document not found', 'debug' => $debug]);
        exit();
    }
    $row = $result->fetch_assoc();
    $selected_price = floatval($row['price']);
    $original_price = $selected_price;
    $support_report_id = $row['report_id'];

    // Get loyalty from the report for this support doc
    $sql = "SELECT loyalty FROM fm_reports WHERE id = '$support_report_id'";
    $result = $con->query($sql);
    if ($result && $result->num_rows > 0) {
        $report_loyalty = $result->fetch_assoc()['loyalty'];
    }
} elseif ($file_id) {
    $selected_id = $file_id;
    $item_type = 'main_file';
    $sql = "SELECT price, loyalty FROM fm_reports WHERE id = '$report_id'";
    $result = $con->query($sql);
    if (!$result || $result->num_rows == 0) {
        $debug['errors'][] = "Report not found.";
        echo json_encode(['success' => false, 'message' => 'Report not found', 'debug' => $debug]);
        exit();
    }
    $row = $result->fetch_assoc();
    $selected_price = floatval($row['price']);
    $original_price = $selected_price;
    $report_loyalty = $row['loyalty'];
} else {
    $debug['errors'][] = "No file selected.";
    echo json_encode(['success' => false, 'message' => 'No file selected', 'debug' => $debug]);
    exit();
}
$sql_count = "SELECT COUNT(*) as count FROM fm_order_items WHERE item_id = '$selected_id' AND report_id = '$report_id' AND order_id = '$order_id' AND item_type = '$item_type'";
$result_count = mysqli_query($con, $sql_count);
$row_count = mysqli_fetch_assoc($result_count);


// --- Loyalty logic (applies to both main file and support doc) ---
if ($loyalty > 0 && $report_loyalty > 0) {
    $sql = "SELECT discount FROM fm_subscription_plans WHERE s = '$loyalty'";
    $result = $con->query($sql);
    if (!$result || $result->num_rows == 0) {
        $debug['errors'][] = "Loyalty plan not found.";
        echo json_encode(['success' => false, 'message' => 'Loyalty plan not found', 'debug' => $debug]);
        exit();
    }
    $row = $result->fetch_assoc();
    $discount = floatval($row['discount']);
    if ($discount == "") {
        $debug['errors'][] = "Invalid discount value: " . $discount;
        echo json_encode(['success' => false, 'message' => 'Invalid discount value', 'debug' => $debug]);
        exit();
    }
    $selected_price = $selected_price - ($selected_price * $discount / 100);

    // Debugging: Log loyalty discount application
    $debug['loyalty_discount'] = [
        'discount' => $discount,
        'new_price' => $selected_price
    ];

    // Check if the user has reached the maximum number of downloads for their loyalty plan
    $query = "SELECT downloads AS count FROM fm_users WHERE s = '$user_id'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    $count = $row['count'];

    // Debugging: Log download count query
    $debug['queries'][] = $query;
    $debug['results']['download_count'] = $count;

    // Check number of downloads allowed for loyalty plan user
    $query = "SELECT downloads FROM fm_subscription_plans WHERE s = '$loyalty'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    $downloads = $row['downloads'];

    // Debugging: Log downloads limit
    $debug['results']['downloads_limit'] = $downloads;

    if ($count < 1) {
        // Notify user and set loyalty to 0
        $query = "UPDATE fm_users SET loyalty = 0 WHERE s = '$user_id'";
        mysqli_query($con, $query);

        // Debugging: Log loyalty update query
        $debug['queries'][] = $query;

        $query = "SELECT lp.*, u.email, u.name AS display_name
                  FROM fm_loyalty_purchases lp
                  JOIN fm_users u ON lp.user_id = u.s
                  WHERE u.s = '$user_id'";
        $result = mysqli_query($con, $query);

        // Debugging: Log loyalty purchase query
        $debug['queries'][] = $query;

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $user_id = $row['user_id'];
                $email = $row['email'];
                $display_name = $row['display_name'];
                $plan_id = $row['loyalty_id'];
                $end_date = $row['end_date'];

                // Email details
                $emailSubject = "Your Subscription Has Expired";
                $emailMessage = "<p>Dear $display_name,</p>
                                 <p>Your subscription for plan ID $plan_id has expired on $end_date. Please log in to your account to renew your subscription.</p>
                                 <p>Thank you for using our service!</p>";
                // Send email to the user
                sendEmail($email, $display_name, $siteName, $siteMail, $emailMessage, $emailSubject);
                $price = $original_price;
            }
        }
    } else {
            // Deduct from downloads if item has not been added
        $sql_count = "SELECT COUNT(*) as count FROM fm_order_items WHERE item_id = '$selected_id' AND report_id = '$report_id' AND order_id = '$order_id' AND item_type = '$item_type'";
        $result_count = mysqli_query($con, $sql_count);
        $row_count = mysqli_fetch_assoc($result_count);
        if ($row_count['count'] < 1) { decreaseDownloads($con, $user_id); }
    }
} else {
    $loyalty = 0;
}

// Debugging: Log price after loyalty check
$debug['results']['final_price'] = $selected_price;

// Check if item already exists in order
$sql_count = "SELECT COUNT(*) as count FROM fm_order_items WHERE item_id = '$selected_id' AND report_id = '$report_id' AND order_id = '$order_id' AND item_type = '$item_type'";
$result_count = mysqli_query($con, $sql_count);
$row_count = mysqli_fetch_assoc($result_count);

if ($row_count['count'] > 0) {
    $sql = "UPDATE fm_order_items SET price = $selected_price, original_price = $original_price, loyalty_id = '$loyalty' WHERE item_id = '$selected_id' AND report_id = '$report_id' AND order_id = '$order_id' AND item_type = '$item_type'";
    mysqli_query($con, $sql);
    $debug['queries'][] = $sql;
    echo json_encode(['success' => true, 'message' => 'Price updated', 'cartCount' => $cart_count, 'debug' => $debug]);
    exit();
}

// Insert order item
$sql = "INSERT INTO fm_order_items (report_id, item_id, price, original_price, loyalty_id, affiliate_id, order_id, date, item_type) 
        VALUES ('$report_id', '$selected_id', $selected_price, $original_price, $loyalty, '$affliate', '$order_id', CURRENT_TIMESTAMP, '$item_type')";
$con->query($sql);
$debug['queries'][] = $sql;

// Update order total
$sql = "UPDATE fm_orders SET total_amount = total_amount + $selected_price WHERE order_id = '$order_id'";
$con->query($sql);
$debug['queries'][] = $sql;

// Commit transaction
$con->commit();
echo json_encode(['success' => true, 'order_id' => $order_id, 'cartCount' => $cart_count + 1, 'debug' => $debug]);
exit();
?>
