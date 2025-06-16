
<?php
include "header.php";
?>

  <main class="main">

    <!-- Page Title -->
    <div class="page-title light-background">
      <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">Checkout</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index">Home</a></li>
            <li class="current">Checkout</li>
          </ol>
        </nav>
      </div>
    </div>
    <!-- Checkout Section -->
    <section id="checkout" class="checkout section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row">
          <div class="col-lg-7">
            <!-- Checkout Form -->
            <div class="checkout-container" data-aos="fade-up">
              <form class="checkout-form" method="POST" id="paymentForm" novalidate="novalidate">
                <!-- Customer Information -->
                <div class="checkout-section" id="customer-info">
                  <div class="section-header">
                    <div class="section-number">1</div>
                    <h3>Customer Information</h3>
                  </div>
                  <div class="section-content">
                  <div class="row">
  <div class="col-md-6 form-group">
    <label for="first-name">First Name<?php if (!empty($company_name)) echo " / Company Name"; ?></label>
    <?php if (!empty($company_name)): ?>
      <input type="text" class="form-control" placeholder="Company Name" id="first-name" value="<?php echo htmlspecialchars($company_name); ?>" name="name" required>
    <?php else: ?>
      <input type="text" class="form-control" placeholder="Your First Name" id="first-name" value="<?php echo htmlspecialchars($first_name); ?>" name="name" required>
    <?php endif; ?>
  </div>
  <div class="col-md-6 form-group">
    <label for="last-name">Last Name</label>
    <?php if (!empty($company_name)): ?>
      <input type="text" class="form-control" id="last-name" value="" name="last-name" readonly>
    <?php else: ?>
      <input type="text" class="form-control" id="last-name" value="<?php echo htmlspecialchars($last_name); ?>" name="last-name" required>
    <?php endif; ?>
  </div>
</div>
                    <div class="form-group">
                      <label for="email">Email Address</label>
                      <input type="email" class="form-control" name="email" id="email-address" placeholder="Your Email"  required="" value="<?php echo $email;?>" >
                    </div>
                    <input type="hidden" id="amount" value="<?php echo $order_total; ?>"/>
              <input type="hidden" id="ref"   value="<?php echo  $order_id; ?>  "  />
              <input type="hidden" id="refer" value="<?php echo $siteurl; ?>/pay_success.php?ref=<?php echo $order_id; ?> " />
                    <div class="form-group">
                      <label for="phone">Phone Number</label>
                      <input type="tel" class="form-control" name="phone" id="mobile-number" placeholder="Your Phone Number" required="" value="<?php echo $mobile_number;?>">
                    </div>
                  </div>
                </div>
                   
            </div>
          </div>

  <div class="col-lg-5">
            <!-- Order Summary -->
            <div class="order-summary" data-aos="fade-left" data-aos-delay="200">
              <div class="order-summary-header">
                <h3>Order Summary</h3>
                <span class="item-count">2 Items</span>
              </div>

              <div class="order-summary-content">
                <div class="order-items">
                          <?php 
        // Initialize
        $is_free_order = false;
        $item_count = 0;

        $sql = "SELECT oi.*, rf.title as file, r.title as report_title, r.pricing, oi.price, ri.picture 
                FROM ".$siteprefix."order_items oi
                JOIN ".$siteprefix."reports r ON oi.report_id = r.id
                LEFT JOIN ".$siteprefix."reports_images ri ON r.id = ri.report_id
                LEFT JOIN ".$siteprefix."reports_files rf ON r.id = rf.report_id
                WHERE oi.order_id = ? 
                GROUP BY oi.s";

        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, 's', $order_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        while ($item = mysqli_fetch_assoc($result)):
          $item_count++;
          if ($item['pricing'] == 'free') {
            $is_free_order = true;
          }
      ?>
                  <div class="order-item">
                    <div class="order-item-image">
                      <img src="<?php echo htmlspecialchars($imagePath.$item['picture']); ?>" alt="Product" class="img-fluid">
                    </div>
                    <div class="order-item-details">
                      <h4><?php echo htmlspecialchars($item['report_title']); ?></h4>
                      <p class="order-item-variant">Type: <?php echo htmlspecialchars($item['file']); ?></p>
                      <div class="order-item-price">
                        <span class="quantity">1 ×</span>
                        <span class="price"><?php echo $sitecurrency; echo formatNumber($item['price'], 2); ?></span> 
                      </div>
                    </div>
                  </div>
            <?php endwhile; mysqli_stmt_close($stmt); ?>
                    </div>

                     <div class="order-totals">
                  <div class="order-subtotal d-flex justify-content-between">
                    <span>Subtotal</span>
                    <span><?php echo $sitecurrency; echo $order_total; ?></span>
                  </div>
                  
                  
                  <div class="order-total d-flex justify-content-between">
                    <span>Total</span>
                    <span><?php echo $sitecurrency; echo $order_total; ?></span>
                  </div>
                </div>

                <div class="order-actions">
                 
    <?php if ($order_total > 0) { ?>
 
      <div class="payment_methods">
        <h4>Select Payment Method</h4>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="payment_method" id="paystack" value="paystack" checked>
          <label class="form-check-label" for="paystack">Pay with Paystack</label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="payment_method" id="manual" value="manual">
          <label class="form-check-label" for="manual">Manual Bank Transfer</label>
        </div>
      </div>

      <!-- Paystack Button -->
       
      <button class="btn_1 w-100 text-center paystack-button btn btn-primary" onClick="payWithPaystack()">Proceed to Payment</button>

     <button type="button" class="btn_1 w-100 text-center manual-button btn btn-primary" data-bs-toggle="modal" data-bs-target="#manualPaymentModal" style="display: none;">
  Proceed with Manual Payment
</button>
      </form>
    <?php } elseif ($order_total == 0 && $item_count > 0) { ?>
      <!-- Place order for free product -->
    </form>
      <form method="post" >
        <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
        <button type="submit" value="proceed" name="place_order" class="btn_1 w-100 text-center">Place Order</button>
      </form>
    <?php } else { 
        displayMessage('<a href="marketplace.php">Shop More</a>'); 
      } ?>
                </div>
              </div>
            </div>
          </div>
        </div>

</div></section>






<div class="modal fade" id="manualPaymentModal" tabindex="-1" aria-labelledby="manualPaymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="manualPaymentModalLabel">Manual Bank Transfer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <p>Please transfer the total amount to the following bank account:</p>
                    <ul>
                        <li><strong>Bank Name:</strong> <?php echo $site_bank; ?></li>
                        <li><strong>Account Name:</strong> <?php echo $siteaccname; ?></li>
                        <li><strong>Account Number:</strong> <?php echo $siteaccno; ?></li>
                    </ul>
                    <p><strong>Total Amount:</strong> <?php echo $sitecurrency . formatNumber($order_total, 2); ?></p>
                    <p>After making the payment, upload the proof of payment below:</p>
                    <div class="mb-3">
                        <label for="proof_of_payment" class="form-label">Upload Proof of Payment</label>
                        <input type="file" class="form-control" id="proof_of_payment" name="proof_of_payment" required>
                    </div>
                    <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
                    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                    <input type="hidden" name="amount" value="<?php echo $order_total; ?>">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="submit_manual_payment" class="btn btn-primary">Submit Payment</button>
                </div>
            </form>
        </div>
    </div>
</div>



<?php
include "footer.php";
?>