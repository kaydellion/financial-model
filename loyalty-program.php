<?php include "header.php";

?>

 <div class="container mt-5">
        <div class="row">
        <div class="col-lg-12">
            <h3>Loyalty Program</h3>
            <p>
               Financial Model Store is a leading platform specializing in delivering high-quality, up-to-date financial models across various industries. Leveraging an extensive network of analysts and data sources, the platform offers a diverse range of models covering market trends, forecasts, competitive landscapes, and strategic insights.
</p>
<p>Our subscription program offers a cost-effective and convenient way for users to access a repository of financial models without the hassle of individual purchases. This model ensures continuous access to the latest information, empowering users to make timely and well-informed choices.
            </p>
            <p>
               Buyers on our platform can subscribe to any of the plans below and enjoy massive discounts on our reports, services, and trainings.
            </p>
        </div>
</div>
       
        <div class="row mt-3 plans">
        <?php
$query = "SELECT * FROM ".$siteprefix."subscription_plans WHERE status = 'active' ORDER BY s DESC";
$result = mysqli_query($con, $query);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $plan_id = $row['s'];
        $name = $row['name'];
        $description = $row['description'];
        $price = $row['price'];
        $discount = $row['discount'];
        $downloads = $row['downloads'];
        $duration = $row['duration'];
        $benefits = explode(',', $row['benefits']); // Convert benefits into an array
        $status = $row['status'];
        $no_of_duration = $row['no_of_duration'];
        $image_path = !empty($row['image']) ? $imagePath.$row['image'] : $imagePath."default4.jpg";
        $created_at = $row['created_at'];

        include "plan-card.php"; // Include your plan display template
    }
} else {
    debug('No subscription plans found.');
}
?>

</div></div>
<!-- Modal for login prompt -->
<!-- Modal for login prompt -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="loginModalLabel">Login Required</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>You need to be logged in to subscribe to a plan.</p>
        <a href="login.php" class="btn btn-primary w-100">Go to Login</a>
      </div>
    </div>
  </div>
</div>

<?php include "footer.php"; ?>
<script>
document.addEventListener("DOMContentLoaded", function () {
    let payButtons = document.querySelectorAll(".payButton");

    payButtons.forEach(function(button) {
        button.addEventListener("click", function () {
            let planId = button.dataset.planId;
            let amount = parseFloat(button.dataset.amount) * 100; // Convert to kobo
            let planName = button.dataset.planName;
            let userId = button.dataset.userId;
            let email = button.dataset.email;

            if (!email || isNaN(amount)) {
                alert("Invalid payment details. Please try again.");
                return;
            }

            var handler = PaystackPop.setup({
                key: '<?php echo $apikey; ?>', // Replace with live key in production
                email: email,
                amount: amount,
                currency: 'NGN',
                ref: 'PH-' + Date.now() + '-' + Math.floor(Math.random() * 1000),
                metadata: {
                    custom_fields: [{
                        display_name: "Plan Name",
                        variable_name: "plan_name",
                        value: planName
                    }]
                },
                callback: function (response) {
               var siteurl = document.getElementById('siteurl').value;
                window.location.href = siteurl + 'backend/verify_payment.php?action=verify_payment&reference=' + response.reference + '&plan_id=' + planId + '&user_id=' + userId;
                },
                onClose: function () {
                    alert('Payment was canceled.');
                }
            });
            handler.openIframe();
        });
    });
});

</script>

