<?php include "header.php"; 

$user_id = $_GET['user'] ?? null;
if (!$user_id) {
  header("Location: users.php");
  exit();
}

$sql = "SELECT * FROM " . $siteprefix . "users WHERE s = '" .$user_id. "'";
$sql2 = mysqli_query($con, $sql);
if ($sql2 && mysqli_num_rows($sql2) > 0) {
    while ($row = mysqli_fetch_array($sql2)) {
        $userid = $row["s"];
        $title = $row['title'];
        $display_name = $row['display_name'];
        $first_name = $row['first_name']; 
        $middle_name = $row['middle_name'];
        $last_name = $row['last_name'];
        $company_name = $row['company_name'];
        $company_profile = $row['company_profile'];
        $profile_picture = !empty($row['profile_picture']) ? $row['profile_picture'] : 'user.png';
        $mobile_number = $row['mobile_number'];
        $email = $row['email'];
        $password = $row['password'];
        $gender = $row['gender'];
        $address = $row['address'];
        $type = $row['type'];
        $seller = $row['seller'];
        $status = $row['status'];
        $last_login = $row['last_login'];
        $created_date = $row['created_date'];
        $preference = $row['preference'];
        $bank_name = $row['bank_name'];
        $country = $row['country'];
        $bank_accname = $row['bank_accname'];
        $bank_number = $row['bank_number'];
        $branch_name = $row['branch_name'];
        $account_type = $row['account_type'];
        $aba_ach = $row['aba_ach'];
        $sort_code = $row['sort_code'];
        $ifsc_code = $row['ifsc_code'];
        $iban = $row['iban'];
        $swift_bic = $row['swift_bic'];
        $loyalty = $row['loyalty'];
        $wallet = $row['wallet'];
        $affliate = $row['affliate'];
        $facebook = $row['facebook'];
        $twitter = $row['twitter'];
        $instagram = $row['instagram'];
        $linkedln = $row['linkedln'];
        $kin_name = $row['kin_name'];
        $kin_number = $row['kin_number'];
        $kin_email = $row['kin_email'];
        $biography = $row['biography'];
         $specialization= $row['specialization'];
        $designation = $row['designation'];     
        $kin_relationship = $row['kin_relationship'];
        $active_log = 1;
        $user_reg_date = formatDateTime($created_date);
        $user_lastseen = formatDateTime($last_login);
    }
} else {
    // Redirect to users page if no matching record is found
    header("Location: users.php");
    exit;
}


?>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <p class="text-bold text-dark">Edit User Account</p>
                <div class="row">
                    <input type="hidden" name="user_id" value="<?php echo $userid; ?>">
                    <?php
                    if ($company_name == '') {
                    $required = 'required';
                    ?>

                    <div class="col-md-3 form-group p_star mb-3">
                               <input type="text" class="form-control" id="title" name="title" placeholder="Mr, Ms, Dr, etc." value="<?php echo $title; ?>" <?php echo $required; ?>>
                            </div>
                            <div class="col-md-3 form-group p_star mb-3">
                                <input type="text" class="form-control" name="first_name" placeholder="First Name" value="<?php echo htmlspecialchars($first_name); ?>" <?php echo $required; ?>>
                            </div>
                            <div class="col-md-3 form-group p_star mb-3">
                              
                                <input type="text" class="form-control" name="middle_name" placeholder="Middle Name" value="<?php echo htmlspecialchars($middle_name); ?>" <?php echo $required; ?>>
                            </div>

                            <div class="col-md-3 form-group p_star mb-3">
                                <input type="text" class="form-control" name="last_name" placeholder="Last Name" value="<?php echo htmlspecialchars($last_name); ?>" <?php echo $required; ?>>
                            </div>
                            <div class="col-md-4 form-group p_star mb-3">
                                <input type="email" class="form-control" name="email" placeholder="Email Address" value="<?php echo htmlspecialchars($email); ?>" <?php echo $required; ?>>
                            </div>
                            <div class="col-md-4 form-group p_star mb-3">
                                <input type="text" class="form-control" name="mobile_number" placeholder="Phone Number" value="<?php echo htmlspecialchars($mobile_number); ?>" <?php echo $required; ?>>
                            </div>
                            <div class="col-md-4 form-group p_star mb-3">
                                <input type="text" class="form-control" name="address" placeholder="Address" value="<?php echo htmlspecialchars($address); ?>" <?php echo $required; ?>>
                            </div>
                            <div class="col-md-12 form-group p_star mb-3">
                                <textarea class="form-control" name="biography" placeholder="Biography" <?php echo $required; ?>><?php echo htmlspecialchars($biography); ?></textarea>
                            </div>
                             <div class="col-md-6 form-group p_star mb-3">
                <select class="form-control" id="gender" name="gender" required>
                <option value="" <?php echo empty($gender) ? 'selected' : ''; ?>>-Select Gender-</option>
                <option value="Male" <?php echo ($gender == 'Male') ? 'selected' : ''; ?>>Male</option>
                <option value="Female" <?php echo ($gender == 'Female') ? 'selected' : ''; ?>>Female</option>
                </select></div>
             

                            <?php }  else { $required = 'required'; ?>

                    <div class="col-md-6 form-group p_star mb-3">
                    <input type="text" class="form-control" id="Company-Name" name="company-name" value="<?php echo $company_name; ?>" <?php echo $required; ?> placeholder="Company Name">
                      </div>
                      <div class="col-md-6 form-group  p_star mb-3">
                    <input type="text" class="form-control" id="Display-Name" name="company-display-name" value="<?php echo $display_name; ?>" <?php echo $required; ?> placeholder="Display Name"> 
                      </div>
                  
                          <div class="col-md-6 form-group p_star mb-3">   
                      <input type="email" class="form-control" name="company_email" id="email" value="<?php echo $email; ?>" <?php echo $required; ?> placeholder="Email Address">
                  </div>
                      <div class="col-md-6 form-group p_star mb-3">   
                      <input type="tel" class="form-control" name="company_phone" id="company_mobile"  value="<?php echo $mobile_number; ?>" <?php echo $required; ?> placeholder="Phone Number">
                  </div>

                  <div class="col-md-6 form-group p_star mb-3">   
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

                    <div class="col-md-6 form-group p_star mb-3">   
                      <input type="text" class="form-control" name="comaddress" id="comaddress" value="<?php echo $address; ?>" <?php echo $required; ?> placeholder="Company Address">
                  </div>
                  <div class="col-md-6 form-group p_star mb-3">   
                     <input type="file" class="form-control" id="company_profile_picture" name="company_profile_picture">
                  </div>

                   <div class="col-md-6 form-group p_star mb-3">   
                  <textarea class="form-control" id="about-me" name="comabout-me" rows="3"><?php echo $company_profile; ?></textarea>
                  </div>
                   <?php } ?>
        <div class="col-md-6 form-group p_star mb-3">
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
                            <div class="col-md-6 form-group p_star mb-3">
                                <input type="text" class="form-control" name="bank_name" placeholder="Bank Name" value="<?php echo htmlspecialchars($bank_name); ?>" <?php echo $required; ?>>
                            </div>
                            <div class="col-md-6 form-group p_star mb-3">
                                <input type="text" class="form-control" name="bank_accname" placeholder="Bank Account Name" value="<?php echo htmlspecialchars($bank_accname); ?>">
                            </div>
                            <div class="col-md-6 form-group p_star mb-3">
                                <input type="text" class="form-control" name="bank_number" placeholder="Bank Account Number" value="<?php echo htmlspecialchars($bank_number); ?>">
                            </div>
                            <div class="col-md-6 form-group p_star mb-3">
                                <input type="text" class="form-control" name="facebook" placeholder="Facebook Profile" value="<?php echo htmlspecialchars($facebook); ?>">
                            </div>
                            <div class="col-md-6 form-group p_star mb-3">
                                <input type="text" class="form-control" name="twitter" placeholder="Twitter Profile" value="<?php echo htmlspecialchars($twitter); ?>">
                            </div>
                            <div class="col-md-6 form-group p_star mb-3">
                                <input type="text" class="form-control" name="instagram" placeholder="Instagram Profile" value="<?php echo htmlspecialchars($instagram); ?>">
                            </div>
                            <div class="col-md-6 form-group p_star mb-3">
                                <input type="text" class="form-control" name="linkedin" placeholder="LinkedIn Profile" value="<?php echo htmlspecialchars($linkedln); ?>">
                            </div>
                            <div class="col-md-6 form-group p_star mb-3">
                                <input type="text" class="form-control" name="kin_name" placeholder="Next of Kin Name" value="<?php echo htmlspecialchars($kin_name); ?>">
                            </div>
                            <div class="col-md-6 form-group p_star mb-3">
                                <input type="text" class="form-control" name="kin_number" placeholder="Next of Kin Phone" value="<?php echo htmlspecialchars($kin_number); ?>">
                            </div>
                            <div class="col-md-6 form-group p_star mb-3">
                                <input type="email" class="form-control" name="kin_email" placeholder="Next of Kin Email" value="<?php echo htmlspecialchars($kin_email); ?>">
                            </div>
                            <div class="col-md-6 form-group p_star mb-3">
                             
                    <input type="text" class="form-control" id="designation" name="designation" placeholder="Designation" value="<?php echo $designation; ?> ">
                  </div>
                            
                            
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
                            <div class="form-group col-md-6 mb-3">
                        <label for="type">User Type</label>
                        <select class="form-select p-3" name="type" id="type" required <?= getReadonlyAttribute() ?>>
                            <option value="user" <?php if ($type === 'user') echo 'selected'; ?>>User</option>
                            <option value="affiliate" <?php if ($type === 'affiliate') echo 'selected'; ?>>Affliate</option>
                            <option value="sub-admin" <?php if ($type === 'sub-admin') echo 'selected'; ?>>Sub Admin</option>
                        </select>
                    </div>
                <div class="form-group col-md-6 mb-3">
                    <label for="status">Status</label>
                    <select class="form-select p-3" name="status" id="status" <?php if ($status !== 'suspended') echo 'required'; ?>>
                        <option value="active" <?php if ($status === 'active') echo 'selected'; ?>>Active</option>
                        <option value="inactive" <?php if ($status === 'inactive') echo 'selected'; ?>>Inactive</option>
                       <option value="" <?php if ($status === 'suspended') echo 'selected'; ?> disabled>User is currently suspended</option>
                       <?php ; ?>
                    </select>
                </div> 
               
                <div class="mb-3">
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="seller" name="seller"  <?php echo ($seller) ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="seller">Make user a seller</label>
                          </div>
                        </div>
                <p><button class="w-100 btn btn-primary" name="update_profile_admin" value="update-user">Update Account</button></p>
                <input type="hidden" name="userid" value="<?php echo htmlspecialchars($userid, ENT_QUOTES, 'UTF-8'); ?>">
            </form>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>
