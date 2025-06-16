
<?php include "header.php"; ?>
<section id="account" class="account section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

    

        <div class="row g-4">
            <div class="col-lg-12">
                 <div class="profile-menu collapse d-lg-block" id="profileMenu">
                 <div class="row">
          <!-- Profile Menu -->
          <div class="col-lg-2">
           
      <!-- User Info -->
              <div class="user-info" data-aos="fade-right">
                <div class="user-avatar">
                  <img src="<?php echo $imagePath.'/'; echo $profile_picture; ?>" alt="Profile" loading="lazy">
               
                </div>
                <h3> <?php echo htmlspecialchars($username); ?></h3>
           </div>
           </div>
		   
		   <div class="col-lg-10">
		   <div class="profile-links" data-aos="fade-left">
		     <?php include "links.php"; ?>
            </div>
		   </div>
              </div>		
			   </div>
           </div>
              </div>

				 </div>

</section>



     
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
                </div>
<?php
if ($company_name == '') {
  $required = 'required';
  ?>
                  <div class="section-content">
                    <div class="row">
                      <div class="col-md-6 form-group">
                       <label for="title">Title</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Mr, Ms, Dr, etc." value="<?php echo $title; ?>" <?php echo $required; ?>>
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
                    <input type="text" class="form-control" id="first-name" name="first-name" value="<?php echo $first_name; ?>" <?php echo $required; ?>>
                  </div>
                  <div class="col-md-3 form-group">
                    <label for="middle-name">Middle Name</label>
                    <input type="text" class="form-control" id="middle-name" name="middle-name" value="<?php echo $middle_name; ?>" <?php echo $required; ?>>
                  </div>
                  <div class="col-md-3 form-group">
                    <label for="last-name">Last Name</label>
                    <input type="text" class="form-control" id="last-name" name="last-name" value="<?php echo $last_name; ?>" <?php echo $required; ?>>
                  </div>
                  <div class="col-md-3 form-group">
                     <label for="display-name">Display Name</label>
                  <input type="text" class="form-control" id="display-name" name="display-name" value="<?php echo $display_name; ?>" <?php echo $required; ?>>
                  </div>
                </div>
                     <div class="row mb-3">
                  <div class="col-md-4 form-group">
                     <label for="email">Email Address</label>
                      <input type="email" class="form-control" name="email" id="email" value="<?php echo $email; ?>" <?php echo $required; ?>>
                  </div>
                  <div class="col-md-4 form-group">
                   <label for="phone">Phone Number</label>
                      <input type="tel" class="form-control" name="phone" id="phone" value="<?php echo $mobile_number; ?>" <?php echo $required; ?>>
                  </div>
                  <div class="col-md-4 form-group">
                    <label for="last-name">Address</label>
                   <input type="text" class="form-control" name="address" id="address" value="<?php echo $address; ?>" <?php echo $required; ?>>
                  </div>
                </div>
                 <div class="mb-3 form-group">
                  <label for="about-me">About Me</label>
                  <textarea class="form-control" id="about-me" name="about-me" rows="3" <?php echo $required; ?>><?php echo $biography; ?></textarea>
                </div>
                <!-- Gender -->
               <div class="row mb-3">
                  <div class="col-md-12 form-group">
                  <label>Gender:</label>
                 <select class="form-control" id="gender" name="gender" <?php echo $required; ?>>
                                    <option value="">-Select Gender-</option>
                                    <option value="Male" <?php echo ($gender == 'Male') ? 'selected' : ''; ?>>Male</option>
                                    <option value="Female" <?php echo ($gender == 'Female') ? 'selected' : ''; ?>>Female</option>
                                    </select> 
                </div>
				</div>
				</div>

                <?php } else { $required = 'required'; ?>
				    <div class="section-content">
                    <div class="row">
                      <div class="col-md-6 form-group">
                        <label for="Company-Name">Company Name</label>
                    <input type="text" class="form-control" id="Company-Name" name="company-name" value="<?php echo $company_name; ?>" <?php echo $required; ?>>
                      </div>
                      <div class="col-md-6 form-group">
					  <label for="Display Name">Display Name</label>
                    <input type="text" class="form-control" id="Display-Name" name="company-display-name" value="<?php echo $display_name; ?>" <?php echo $required; ?>> 
                      </div>
                      </div>
                <div class="row">
                       <div class="col-md-6 form-group">
                     <label for="email">Email Address</label>
                      <input type="email" class="form-control" name="company_email" id="email" value="<?php echo $email; ?>" <?php echo $required; ?>>
                  </div>
                  <div class="col-md-6 form-group">
                     <label for="email">Mobile Number</label>
                      <input type="tel" class="form-control" name="company_phone" id="company_mobile"  value="<?php echo $mobile_number; ?>" <?php echo $required; ?>>
                  </div>
                    </div>
					  <div class="row">
                    <div class="col-md-4 form-group">
          <label for="country">Country</label>
          <select class="form-control" name="country" id="country" <?php echo $required; ?>>
              <option value="">-- Select Country --</option>
<?php
$result = mysqli_query($con, "SELECT id, name FROM fm_country ORDER BY name ASC");
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $selected = ($country == $row['id']) ? 'selected' : '';
        echo '<option value="' . htmlspecialchars($row['id']) . '" ' . $selected . '>' . htmlspecialchars($row['name']) . '</option>';
    }
}
              ?>
          </select>
      </div>

                      <div class="col-md-4 form-group">
                        <label for="last-name">Company Address</label>
                   <input type="text" class="form-control" name="comaddress" id="comaddress" value="<?php echo $address; ?>">
                      </div>
                      <div class="col-md-4 form-group">
				
					
                         <label for="photo">Company Logo</label>
                   <input type="file" class="form-control" id="company_profile_picture" name="company_profile_picture">
                      </div>
                    </div>
					 <div class="mb-3 form-group">
                  <label for="about-me">Company Profile</label>
                  <textarea class="form-control" id="about-me" name="comabout-me" rows="3"><?php echo $company_profile; ?></textarea>
                </div>
         
				</div>
				<?php } ?>
				  <div id="sharedSection">
				  <div class="checkout-section">
				     <div class="section-content">
				 <div class="row">
                 <div class="col-md-12 form-group">
                    <div class="mb-3">
				  <label>Area of Specialization:</label>
				  <select class="form-control" name="category" aria-label="Default select example" required>
    <option value="">- Select Category -</option>
    <?php
    $sql = "SELECT * FROM " . $siteprefix . "categories WHERE parent_id IS NULL ";
    $sql2 = mysqli_query($con, $sql);
    while ($row = mysqli_fetch_array($sql2)) {
        $selected = ($specialization == $row['id']) ? 'selected' : '';
        echo '<option value="' . $row['id'] . '" ' . $selected . '>' . htmlspecialchars($row['category_name']) . '</option>';
    }
    ?>
</select> 
                        </div>
                         </div>
                          </div>
						  <div class="row mb-3">
					  <div class="col-md-4 form-group">
					  <label>Old Password:</label>
				   <div class="input-group">
					<input type="password" class="form-control" id="oldpassword" name="oldpassword" placeholder="Password">
					<div class="input-group-append">
					<span class="input-group-text p-3" onclick="togglePasswordVisibility('oldpassword')">
						<i class="bi bi-eye" id="togglePasswordIcon"></i>
														</span>
													</div>
												</div>
					</div>

          		  <div class="col-md-4 form-group">
					  <label>Password:</label>
				   <div class="input-group">
					<input type="password" class="form-control" id="password" name="password" placeholder="Password">
					<div class="input-group-append">
					<span class="input-group-text p-3" onclick="togglePasswordVisibility('password')">
						<i class="bi bi-eye" id="togglePasswordIcon"></i>
														</span>
													</div>
												</div>
					</div> <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                   <div class="col-md-4 form-group">
                  <label>Retypepassword:</label>
                                  <div class="input-group">
                                        <input type="password" class="form-control" id="retypePassword" name="retypePassword" placeholder="Password">
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
                    <input type="text" class="form-control" id="bank-name" name="bank-name" value="<?php echo $bank_name; ?>">
                  </div>
                  <div class="col-md-6 form-group">
                    <label for="account-name">Account Name</label>
                    <input type="text" class="form-control" id="account-name" name="account-name" value="<?php echo $bank_accname; ?>">
                  </div>
                </div>
                <div class="row mb-3">
                  <div class="col-md-6 form-group">
                    <label for="account-number">Account Number</label>
                    <input type="text" class="form-control" id="account-number" name="account-number" value="<?php echo $bank_number; ?>">
                  </div>
                  <div class="col-md-6 form-group">
                    <label for="branch-name">Branch Name</label>
                    <input type="text" class="form-control" id="branch-name" name="branch-name" value="<?php echo $branch_name; ?>">
                  </div>
                </div>
                <div class="row mb-3">
                  <div class="col-md-6 form-group">
                    <label for="account-type">Account Type</label>
                    <input type="text" class="form-control" id="account-type" name="account-type" value="<?php echo $account_type; ?>">
                  </div>
                  <div class="col-md-6 form-group">
                    <label for="aba-ach">ABA/ACH Routing Code</label>
                    <input type="text" class="form-control" id="aba-ach" name="aba-ach" value="<?php echo $aba_ach; ?> ">
                  </div>
                </div>
                <div class="row mb-3">
                  <div class="col-md-6 form-group">
                    <label for="sort-code">Sort Code</label>
                    <input type="text" class="form-control" id="sort-code" name="sort-code" value="<?php echo $sort_code; ?> ">
                  </div>
                  <div class="col-md-6 form-group">
                    <label for="ifsc-code">IFSC Code</label>
                    <input type="text" class="form-control" id="ifsc-code" name="ifsc-code" value="<?php echo $ifsc_code;  ?>">
                  </div>
                </div>
                <div class="row mb-3">
                  <div class="col-md-6 form-group">
                    <label for="iban">IBAN</label>
                    <input type="text" class="form-control" id="iban" name="iban" value="<?php echo $iban; ?>">
                  </div>
                  <div class="col-md-6 form-group">
                    <label for="swift-bic">SWIFT/BIC Code</label>
                    <input type="text" class="form-control" id="swift-bic" name="swift-bic" value="<?php echo $swift_bic;  ?>">
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
                    <input type="text" class="form-control" id="facebook" name="facebook" value="<?php echo $facebook; ?>">
                  </div>
                  <div class="col-md-6 form-group">
                    <label for="twitter">Twitter</label>
                    <input type="text" class="form-control" id="twitter" name="twitter"  value="<?php echo $twitter; ?>">
                  </div>
                </div>
                <div class="row mb-3">
                  <div class="col-md-6 form-group">
                    <label for="instagram">Instagram</label>
                    <input type="text" class="form-control" id="instagram" name="instagram" value="<?php echo $instagram; ?>">
                  </div>
                  <div class="col-md-6 form-group">
                    <label for="linkedin">Linkedin</label>
                    <input type="text" class="form-control" id="linkedin" name="linkedin" value="<?php echo $linkedln; ?>">
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
                    <input type="text" class="form-control" id="contact-name" name="contact-name" value="<?php echo $kin_name; ?>">
                  </div>
                  <div class="col-md-3 form-group">
                    <label for="designation">Designation</label>
                    <input type="text" class="form-control" id="designation" name="designation" value="<?php echo $designation; ?> ">
                  </div>
                  <div class="col-md-3 form-group">
                    <label for="contact-mobile">Mobile Number</label>
                    <input type="text" class="form-control" id="contact-mobile" name="contact-mobile" value="<?php echo $kin_number;?>">
                  </div>
                  <div class="col-md-3 form-group">
                    <label for="contact-email">E-Mail Address</label>
                    <input type="email" class="form-control" id="contact-email" name="contact-email" value="<?php echo $kin_email; ?>" >
                  </div>
                </div>
            

                  <button type="submit" name="update_profile" class="btn btn-primary w-100">
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

  





<?php include "footer.php"; ?>