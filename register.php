
<?php include "header.php"; ?>
  <main class="main">
    <!-- Page Title -->
    <div class="page-title light-background">
      <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">Register</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.php">Home</a></li>
            <li class="current">Register</li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->
    <!-- Checkout Section -->
    <section id="checkout" class="checkout section">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row">
          <div class="col-lg-9 mx-auto">
            <div class="checkout-container" data-aos="fade-up">
              <form method="POST" enctype="multipart/form-data">
                <!-- Customer Information -->
                <div class="checkout-section">
                  <div class="section-header">
                   <!--- <div class="section-number">1</div>
                    <h3>Customer Information</h3>  --->
                  </div>
                       <div class="section-content">
                <div class="row mb-3">
                  <div class="col-md-12 form-group">
                <div id="typeSelector" class="selection-prompt" style="display: none;">
               <label for="register-type">How would you like to register?</label>
              <select id="registrationType" style="padding: 10px; font-size: 16px;" class="form-control">
                <option value="">-- Select an option --</option>
                <option value="individual">Register as Individual</option>
                <option value="company">Register as Company</option>
              </select>
              <br><br>
            <button onclick="continueWithSelection()" class="btn btn-primary">Continue</button>
            </div>
                </div>
                </div>
                </div>
                  <div class="section-content" id="individualSection" style="display: none;">
                    <div class="row">
                      <div class="col-md-6 form-group">
                       <label for="title">Title</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Mr, Ms, Dr, etc." >
                      </div>
                      <div class="col-md-6 form-group">
                         <label for="photo">Photo</label>
                   <input type="file" class="form-control" id="profile_picture" name="profile_picture">
                      </div>
                    </div>
                      <!-- Name Fields -->
                <div class="row mb-3">
                  <div class="col-md-3 form-group">
                    <label for="first-name">First Name </label>
                    <input type="text" class="form-control" id="first-name" name="first-name" >
                  </div>
                  <div class="col-md-3 form-group">
                    <label for="middle-name">Middle Name</label>
                    <input type="text" class="form-control" id="middle-name" name="middle-name">
                  </div>
                  <div class="col-md-3 form-group">
                    <label for="last-name">Last Name</label>
                    <input type="text" class="form-control" id="last-name" name="last-name" >
                  </div>
                  <div class="col-md-3 form-group">
                     <label for="display-name">Display Name</label>
                  <input type="text" class="form-control" id="display-name" name="display-name">
                  </div>
                </div>
                     <div class="row mb-3">
                  <div class="col-md-4 form-group">
                     <label for="email">Email Address</label>
                      <input type="email" class="form-control" name="email" id="email">
                  </div>
                  <div class="col-md-4 form-group">
                   <label for="phone">Phone Number</label>
                      <input type="tel" class="form-control" name="phone" id="phone">
                  </div>
                  <div class="col-md-4 form-group">
                    <label for="last-name">Address</label>
                   <input type="text" class="form-control" name="address" id="address">
                  </div>
                </div>
                 <div class="mb-3 form-group">
                  <label for="about-me">About Me</label>
                  <textarea class="form-control" id="about-me" name="about-me" rows="3"></textarea>
                </div>
                <!-- Gender -->
               <div class="row mb-3">
                  <div class="col-md-12 form-group">
                  <label>Gender:</label>
                 <select class="form-control" id="gender" name="gender">
                                    <option value="">-Select Gender-</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    </select> 
                </div>
				</div>
				</div>
				    <div class="section-content" id="companySection" style="display: none;">
                    <div class="row">
                      <div class="col-md-6 form-group">
                        <label for="Company-Name">Company Name</label>
                    <input type="text" class="form-control" id="Company-Name" name="Company-Name">
                      </div>
                      <div class="col-md-6 form-group">
					  <label for="Display Name">Display Name</label>
                    <input type="text" class="form-control" id="Display-Name" name="Display-Name"> 
                      </div>
                      </div>
                <div class="row">
                       <div class="col-md-6 form-group">
                     <label for="email">Email Address</label>
                      <input type="email" class="form-control" name="company_email" id="email">
                  </div>
                  <div class="col-md-6 form-group">
                     <label for="email">Mobile Number</label>
                      <input type="tel" class="form-control" name="company_mobile" id="company_mobile" >
                  </div>
                    </div>
					  <div class="row">
                    <div class="col-md-4 form-group">
          <label for="country">Country</label>
          <select class="form-control" name="country" id="country">
              <option value="">-- Select Country --</option>
              <?php
              $result = mysqli_query($con, "SELECT id, name FROM fm_country ORDER BY name ASC");
              if ($result && mysqli_num_rows($result) > 0) {
                  while ($row = mysqli_fetch_assoc($result)) {
                      echo '<option value="' . htmlspecialchars($row['id']) . '">' . htmlspecialchars($row['name']) . '</option>';
                  }
              }
              ?>
          </select>
      </div>

                      <div class="col-md-4 form-group">
                        <label for="last-name">Company Address</label>
                   <input type="text" class="form-control" name="comaddress" id="comaddress">
                      </div>
                      <div class="col-md-4 form-group">
				
					
                         <label for="photo">Company Logo</label>
                   <input type="file" class="form-control" id="company_profile_picture" name="company_profile_picture">
                      </div>
                    </div>
					 <div class="mb-3 form-group">
                  <label for="about-me">Company Profile</label>
                  <textarea class="form-control" id="about-me" name="comabout-me" rows="3"></textarea>
                </div>
         
				</div>
				
				  <div id="sharedSection" style="display: none;">
				  <div class="checkout-section">
				     <div class="section-content">
				 <div class="row">
                 <div class="col-md-12 form-group">
                    <div class="mb-3">
				  <label>Area of Specialization:</label>
				  <select class="form-control" name="category" aria-label="Default select example" required>
                          <option selected>- Select Category -</option>
                          <?php
                     $sql = "SELECT * FROM " . $siteprefix . "categories WHERE parent_id IS NULL ";
                     $sql2 = mysqli_query($con, $sql);
                     while ($row = mysqli_fetch_array($sql2)) {
                     echo '<option value="' . $row['id'] . '">' . $row['category_name'] . '</option>'; }?>
                        </select>
                        </div>
                         </div>
                          </div>
						  <div class="row mb-3">
					  <div class="col-md-6 form-group">
					  <label>Password:</label>
				   <div class="input-group">
					<input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
					<div class="input-group-append">
					<span class="input-group-text p-3" onclick="togglePasswordVisibility('password')">
						<i class="bi bi-eye" id="togglePasswordIcon"></i>
														</span>
													</div>
												</div>
					</div>
                   <div class="col-md-6 form-group">
                  <label>Password:</label>
                                  <div class="input-group">
                                        <input type="password" class="form-control" id="retypePassword" name="retypePassword" placeholder="Password" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text p-3" onclick="togglePasswordVisibility('retypePassword')">
                                                <i class="bi bi-eye" id="toggleRetypePasswordIcon"></i>
                                            </span>
                                        </div>
                                    </div>
                                  </div>
                                </div>
								 </div>
                                    </div>
								
                    <div class="checkout-section">
                  <div class="section-header">
                    <h3>Banking Details</h3>
                  </div>
                  <div class="section-content">
                <div class="row mb-3">
                  <div class="col-md-6 form-group">
                    <label for="bank-name">Bank Name</label>
                    <input type="text" class="form-control" id="bank-name" name="bank-name">
                  </div>
                  <div class="col-md-6 form-group">
                    <label for="account-name">Account Name</label>
                    <input type="text" class="form-control" id="account-name" name="account-name">
                  </div>
                </div>
                <div class="row mb-3">
                  <div class="col-md-6 form-group">
                    <label for="account-number">Account Number</label>
                    <input type="text" class="form-control" id="account-number" name="account-number">
                  </div>
                  <div class="col-md-6 form-group">
                    <label for="branch-name">Branch Name</label>
                    <input type="text" class="form-control" id="branch-name" name="branch-name">
                  </div>
                </div>
                <div class="row mb-3">
                  <div class="col-md-6 form-group">
                    <label for="account-type">Account Type</label>
                    <input type="text" class="form-control" id="account-type" name="account-type">
                  </div>
                  <div class="col-md-6 form-group">
                    <label for="aba-ach">ABA/ACH Routing Code</label>
                    <input type="text" class="form-control" id="aba-ach" name="aba-ach">
                  </div>
                </div>
                <div class="row mb-3">
                  <div class="col-md-6 form-group">
                    <label for="sort-code">Sort Code</label>
                    <input type="text" class="form-control" id="sort-code" name="sort-code">
                  </div>
                  <div class="col-md-6 form-group">
                    <label for="ifsc-code">IFSC Code</label>
                    <input type="text" class="form-control" id="ifsc-code" name="ifsc-code">
                  </div>
                </div>
                <div class="row mb-3">
                  <div class="col-md-6 form-group">
                    <label for="iban">IBAN</label>
                    <input type="text" class="form-control" id="iban" name="iban">
                  </div>
                  <div class="col-md-6 form-group">
                    <label for="swift-bic">SWIFT/BIC Code</label>
                    <input type="text" class="form-control" id="swift-bic" name="swift-bic">
                  </div>
                </div>
                </div>
				</div>

                     <!-- Social Media Handles -->
                    <div class="checkout-section" id="shipping-address">
                  <div class="section-header">
                    
                    <h3>Social Media Handles</h3>
                  </div>
                  <div class="section-content">
                  <div class="row mb-3">
                  <div class="col-md-6 form-group">
                    <label for="facebook">Facebook</label>
                    <input type="text" class="form-control" id="facebook" name="facebook">
                  </div>
                  <div class="col-md-6 form-group">
                    <label for="twitter">Twitter</label>
                    <input type="text" class="form-control" id="twitter" name="twitter">
                  </div>
                </div>
                <div class="row mb-3">
                  <div class="col-md-6 form-group">
                    <label for="instagram">Instagram</label>
                    <input type="text" class="form-control" id="instagram" name="instagram">
                  </div>
                  <div class="col-md-6 form-group">
                    <label for="linkedin">Linkedin</label>
                    <input type="text" class="form-control" id="linkedin" name="linkedin">
                  </div>
                </div>
				 </div>
                </div>
                <!-- Contact Persons / Departments -->
                <div class="checkout-section">
                  <div class="section-header">
               
                    <h3>Contact Persons / Departments</h3>
                  </div>
                  <div class="section-content">
                    <div class="row mb-3">
                  <div class="col-md-3 form-group">
                    <label for="contact-name">Name</label>
                    <input type="text" class="form-control" id="contact-name" name="contact-name" required>
                  </div>
                  <div class="col-md-3 form-group">
                    <label for="designation">Designation</label>
                    <input type="text" class="form-control" id="designation" name="designation" required>
                  </div>
                  <div class="col-md-3 form-group">
                    <label for="contact-mobile">Mobile Number</label>
                    <input type="text" class="form-control" id="contact-mobile" name="contact-mobile" required>
                  </div>
                  <div class="col-md-3 form-group">
                    <label for="contact-email">E-Mail Address</label>
                    <input type="email" class="form-control" id="contact-email" name="contact-email" required>
                  </div>
                </div>
                <div class="mb-3 form-group d-flex align-items-center">
                <input type="checkbox" value="1" id="register_as_seller" name="register_as_seller" <?php echo isset($_POST['register_as_seller']) ? 'checked' : ''; ?> class="me-2">
                <label for="register_as_seller" class="mb-0">Register as a seller</label>
            </div>

                  <button type="submit" name="register-user" class="btn btn-primary w-100">
                    <span class="btn-text">Submit</span>
                  </button>
               </div>
			    </div>
				 </div>
              </form>
           		</div>
			    </div>
				</div>
			    </div>

    </section><!-- /Checkout Section -->

  </main>


<?php include 'footer.php'; ?>