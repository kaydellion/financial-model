<?php include "header.php"; 
$sql = "SELECT d.*, u.first_name, u.last_name 
        FROM ".$siteprefix."disputes d 
        LEFT JOIN ".$siteprefix."users u ON d.user_id = u.s 
        WHERE d.status='resolved' 
        ORDER BY d.created_at DESC";
$result = mysqli_query($con, $sql);
?>

<div class="container py-5">
<div class="row">
<div class="col-md-12">
<div class="d-flex justify-content-between align-items-center mb-4">
<h3>Resolved Disputes</h3>
</div>
<table id="disputesTable" class="table table-bordered border-primary">
    <thead>
        <tr>
            <th>Ticket ID</th>
            <th>Category</th>
            <th>Reporter</th>
            <th>Reported Date</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?= $row['ticket_number']; ?></td>
                <td><?= $row['category']; ?></td>
                <td><?= $row['first_name']." ".$row['last_name']; ?></td>
                <td><?= $row['created_at']; ?></td>
                <td>
                    <span class="badge bg-<?= htmlspecialchars(getBadgeColor($row['status'])) ?>">
                        <?= htmlspecialchars($row['status']) ?>
                    </span>
                </td>
                <td><a href="ticket.php?ticket_number=<?= $row['ticket_number']; ?>">View Ticket</a></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

</div>
</div>
</div>
<?php include "footer.php"; ?>