  <footer id="footer" class="footer">

    <div class="footer-main">
      <div class="container">
        <div class="row gy-4">
          <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="footer-widget footer-about">
              <a href="index.html" class="logo">
                <span class="sitename"><?php echo $sitename; ?></span>
              </a>
              <p><?php echo $sitedescription; ?></p>
              <div class="footer-contact mt-4">
           
                <div class="contact-item">
                  <i class="bi bi-telephone"></i>
                  <span><?php echo $sitenumber; ?></span>
                </div>
                <div class="contact-item">
                  <i class="bi bi-envelope"></i>
                  <span>
                    <?php echo $sitemail; ?>
                  </span>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-2 col-md-6 col-sm-6">
            <div class="footer-widget">
              <h4>Company</h4>
              <ul class="footer-links">
                <li><a href="<?php echo $siteurl; ?>about.php">About Us</a></li>
                <li><a href="<?php echo $siteurl; ?>contact.php">Contact Us</a></li>
                <li><a href="<?php echo $siteurl; ?>privacy.php">Privacy Policy</a></li>
                <li><a href="<?php echo $siteurl; ?>cookie-policy">Cookie Policy</a></li>
                <li><a href="<?php echo $siteurl; ?>terms">Terms of Use</a></li>
                <li><a href="<?php echo $siteurl; ?>why-us">Why Us?</a></li>
                <li><a href="<?php echo $siteurl; ?>blog">News and Press Releases</a></li>
                <li><a href="category.html">FAQ</a></li>
              </ul>
            </div>
          </div>

          <div class="col-lg-2 col-md-6 col-sm-6">
            <div class="footer-widget">
              <h4>Use Cases</h4>
              <ul class="footer-links">
              <?php
                $sql = "SELECT * FROM " . $siteprefix . "use_cases WHERE parent_id IS NULL LIMIT 6";
                $sql2 = mysqli_query($con, $sql);
                while ($row = mysqli_fetch_array($sql2)) {
                    $category_name = $row['name'];
                    $alt_names = $row['slug'];
                    $slugs = $alt_names;
                    echo '<li><a href="'.$siteurl.'use-case/' . $slugs . '">' . $category_name . '</a></li>';
                }
                ?>
              </ul>
            </div>
          </div>

          <div class="col-lg-2 col-md-6 col-sm-6">
            <div class="footer-widget">
              <h4>Categories</h4>
              <ul class="footer-links">
                  <?php
                $sql = "SELECT * FROM " . $siteprefix . "categories WHERE parent_id IS NULL LIMIT 6";
                $sql2 = mysqli_query($con, $sql);
                while ($row = mysqli_fetch_array($sql2)) {
                    $category_name = $row['category_name'];
                    $alt_names = $row['slug'];
                    $slugs = $alt_names;
                    echo '<li><a href="'.$siteurl.'category/' . $slugs . '">' . $category_name . '</a></li>';
                }
                ?>
              </ul>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="footer-widget">
              <div class="social-links mt-4">
                <h5>Follow Us</h5>
                <div class="social-icons">
                  <a href="#" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                  <a href="#" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                  <a href="#" aria-label="Twitter"><i class="bi bi-twitter-x"></i></a>
                  <a href="#" aria-label="TikTok"><i class="bi bi-tiktok"></i></a>
                  <a href="#" aria-label="Pinterest"><i class="bi bi-pinterest"></i></a>
                  <a href="#" aria-label="YouTube"><i class="bi bi-youtube"></i></a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="footer-bottom">
      <div class="container">

        <div class="payment-methods d-flex align-items-center justify-content-center">
          <span>We Accept:</span>
          <div class="payment-icons">
            <i class="bi bi-credit-card" aria-label="Credit Card"></i>
            <i class="bi bi-paypal" aria-label="PayPal"></i>
            <i class="bi bi-apple" aria-label="Apple Pay"></i>
            <i class="bi bi-google" aria-label="Google Pay"></i>
            <i class="bi bi-shop" aria-label="Shop Pay"></i>
            <i class="bi bi-cash" aria-label="Cash on Delivery"></i>
          </div>
        </div>

        <div class="legal-links">
          <a href="<?php echo $siteurl; ?>terms">Terms of Service</a>
          <a href="<?php echo $siteurl; ?>privacy">Privacy Policy</a>
          <a href="<?php echo $siteurl; ?>cookie-policy">Cookies Settings</a>
        </div>

        <div class="copyright text-center">
          <p>© <span>Copyright</span> <strong class="sitename"><?php echo $sitename; ?></strong>. All Rights Reserved.</p>
        </div>

        <div class="credits">
          <!-- All the links in the footer should remain intact. -->
          <!-- You can delete the links only if you've purchased the pro version. -->
          <!-- Licensing information: https://bootstrapmade.com/license/ -->
          <!-- Purchase the pro version with working PHP/AJAX contact form: [buy-url] -->
       
        </div>

      </div>

    </div>
  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
   <script src="https://js.paystack.co/v1/inline.js"></script> 
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="<?php echo $siteurl;?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo $siteurl;?>assets/vendor/php-email-form/validate.js"></script>
  <script src="<?php echo $siteurl;?>assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="<?php echo $siteurl;?>assets/vendor/aos/aos.js"></script>
  <script src="<?php echo $siteurl;?>assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
  <script src="<?php echo $siteurl;?>assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="<?php echo $siteurl;?>assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="<?php echo $siteurl;?>assets/vendor/drift-zoom/Drift.min.js"></script>
  <script src="<?php echo $siteurl;?>assets/vendor/purecounter/purecounter_vanilla.js"></script>

  <!-- Main JS File -->
  <script src="<?php echo $siteurl;?>assets/js/main.js"></script>
<script type="text/javascript">const paymentForm = document.getElementById('paymentForm');
paymentForm.addEventListener("submit", payWithPaystack, false);
function payWithPaystack(e) {
  e.preventDefault();
  let handler = PaystackPop.setup({
    key: '<?php echo $apikey; ?>', // Replace with your public key
    email:  document.getElementById("email-address").value,
    amount: document.getElementById("amount").value * 100,
    ref: document.getElementById("ref").Value, // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
    // label: "Optional string that replaces customer email"
    metadata: {
               custom_fields: [
                  {
                      display_name: "Mobile Number",
                      variable_name: "mobile_number",
                      value: document.getElementById("mobile-number").value,
                  }
               ]
            },
    onClose: function(){
      alert('Window closed.');
    },
    callback: function(response){ 
	window.location.href = document.getElementById("refer").value;
	}
  });
  handler.openIframe();
}</script>
</body>

</html>