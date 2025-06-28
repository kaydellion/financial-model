
<?php

$total_amount = $total_withdrawal = $total_cleared = $totalDisputeAmount= $totalEarnedAmount = 0;
$total_resources_sold = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['place_order'])) {
    $order_id = $_POST['order_id'];
    header("Location: $siteurl/pay_success.php?ref=$order_id");
    exit;
}


//get total order amount
if($active_log==1){
    $sql = "SELECT SUM(price) as total FROM ".$siteprefix."order_items WHERE order_id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $order_total = empty($row['total']) ? 0 : $row['total'];

    //update total orders in orders table
    $sql = "UPDATE ".$siteprefix."orders SET total_amount = ? WHERE order_id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ds", $order_total, $order_id);
    $stmt->execute();
    $stmt->close();

    // Fetch data for the cards
$withdrawal_query = "SELECT SUM(amount) AS total_withdrawal FROM ".$siteprefix."withdrawal WHERE user='$user_id' AND status='pending'";
$withdrawal_result = mysqli_query($con, $withdrawal_query);
$withdrawal_row = mysqli_fetch_assoc($withdrawal_result);
$total_withdrawal = $withdrawal_row['total_withdrawal'] ?? 0;

// Fetch Cleared Transactions
$cleared_query = "SELECT SUM(amount) AS total_cleared FROM ".$siteprefix."withdrawal WHERE user='$user_id' AND status='paid'";
$cleared_result = mysqli_query($con, $cleared_query);
$cleared_row = mysqli_fetch_assoc($cleared_result);
$total_cleared = $cleared_row['total_cleared'] ?? 0;
$userId = $user_id; 


$sql = "
    SELECT
        SUM(CASE
            WHEN reason LIKE '%Dispute Resolution:%' AND status = 'credit' THEN amount
            ELSE 0
        END) AS total_dispute_amount,
        
        SUM(CASE
            WHEN reason LIKE '%Payment from Order ID%' AND status = 'credit' THEN amount
            ELSE 0
        END) AS total_earned_amount
    FROM {$siteprefix}wallet_history
    WHERE user = '$userId'
";
$result = mysqli_query($con, $sql);
if ($result) {
    $row = mysqli_fetch_assoc($result);
    $totalDisputeAmount = $row['total_dispute_amount'] ?? 0;
    $totalEarnedAmount = $row['total_earned_amount'] ?? 0;
} else {
    echo "Error: " . mysqli_error($con);
}

// Get count of paid orders
$sql = "SELECT COUNT(*) as count FROM ".$siteprefix."orders WHERE user = ? AND status = 'paid'";
$stmt = $con->prepare($sql);
$stmt->bind_param("s", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$paid_orders_count = $row['count'];

// Get count of pending manual payments
$pendingOrResendQuery = "SELECT COUNT(*) as count FROM ".$siteprefix."manual_payments WHERE user_id = ?";
$stmt = $con->prepare($pendingOrResendQuery);
$stmt->bind_param("s", $user_id);
$stmt->execute(); 
$pendingOrResendResult = $stmt->get_result();
$pendingOrResendRow = $pendingOrResendResult->fetch_assoc();
$pending_payments_count = $pendingOrResendRow['count'];

// Get count of reviews received
$sql = "SELECT COUNT(*) as count 
    FROM ".$siteprefix."reviews r
    JOIN ".$siteprefix."reports p ON r.report_id = p.id
    WHERE p.user = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("s", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$reviews_count = $row['count'];

// Get count of resources sold
$sql = "SELECT COUNT(DISTINCT r.id) as count
    FROM {$siteprefix}reports r
    JOIN {$siteprefix}order_items oi ON r.id = oi.report_id
    JOIN {$siteprefix}orders o ON oi.order_id = o.order_id
    WHERE r.user = ? AND o.status = 'paid'";
$stmt = $con->prepare($sql);
$stmt->bind_param("s", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$resources_sold_count = $row['count'];

$total_resources_sold = $resources_sold_count;


} else ($order_total = 0);


if(isset($_POST['register-user'])){

    // Detect registration type
    $isCompany = isset($_POST['Company-Name']) && !empty($_POST['Company-Name']);
  //   $company_email = mysqli_real_escape_string($con, $_POST['company_email']);
    // Shared fields

    $password = $_POST['password'];
    $retypePassword = $_POST['retypePassword'];
    $seller = !empty($_POST['register_as_seller']) ? 1 : 0;
    $loyalty = '0';
    $wallet = '0';
    $affiliate = '0';
    $status = 'inactive';
    $date = date('Y-m-d H:i:s');
    $uploadDir = 'uploads/';
    $profilePicture = '';
	$type = 'user';
    $company_profile_picture = $_FILES['company_profile_picture']['name'];

       //profile picture
       $uploadDir = 'uploads/';
       $fileKey='company_profile_picture';
       global $fileName;
   

    // Handle profile/company logo upload
    // Update profile picture if a new one is uploaded
       if (!empty($company_profile_picture)) {
           $company_profile_picture = handleFileUpload($fileKey, $uploadDir, $fileName);
       } else {
           $company_profile_picture = 'user.png'; // Use the current profile picture if no new one is uploaded
       }


    // Password length
    if (strlen($password) < 8){
        $statusAction="Try Again";
        $statusMessage="Password must have 8 or more characters";
        showErrorModal($statusAction, $statusMessage);
    }
    // Password match
    else if ($password !== $retypePassword ){
        $statusAction="Ooops!";
        $statusMessage="Passwords do not match!";
        showErrorModal($statusAction, $statusMessage);
    }
    else {
        $password = hashPassword($password);

        // Prepare and bind
        if ($isCompany) {
            // Company registration fields



            $company_name = mysqli_real_escape_string($con, $_POST['Company-Name']);
            $display_name = mysqli_real_escape_string($con, $_POST['Display-Name']);
            $company_email = mysqli_real_escape_string($con, $_POST['company_email']);
            $country = mysqli_real_escape_string($con, $_POST['country']);
            $comaddress = mysqli_real_escape_string($con, $_POST['comaddress']);
            $company_profile = mysqli_real_escape_string($con, $_POST['comabout-me']);
            $specialization = mysqli_real_escape_string($con, $_POST['category']); // single select
            // You may add more company-specific fields here
			$preference = '';
            // Shared/Bank/Social fields
			
            $bank_name = mysqli_real_escape_string($con, $_POST['bank-name']);
            $bank_accname = mysqli_real_escape_string($con, $_POST['account-name']);
            $bank_number = mysqli_real_escape_string($con, $_POST['account-number']);
            $branch_name = mysqli_real_escape_string($con, $_POST['branch-name']);
            $account_type = mysqli_real_escape_string($con, $_POST['account-type']);
            $aba_ach  = mysqli_real_escape_string($con, $_POST['aba-ach']);
            $sort_code = mysqli_real_escape_string($con, $_POST['sort-code']);
            $ifsc_code = mysqli_real_escape_string($con, $_POST['ifsc-code']);
            $iban = mysqli_real_escape_string($con, $_POST['iban']);
            $swift_bic = mysqli_real_escape_string($con, $_POST['swift-bic']);
            $facebook = mysqli_real_escape_string($con, $_POST['facebook']);
            $twitter = mysqli_real_escape_string($con, $_POST['twitter']);
            $instagram = mysqli_real_escape_string($con, $_POST['instagram']);
            $linkedln = mysqli_real_escape_string($con, $_POST['linkedin']);
            $contact_name = mysqli_real_escape_string($con, $_POST['contact-name']);
            $contact_mobile = mysqli_real_escape_string($con, $_POST['contact-mobile']);
            $contact_email = mysqli_real_escape_string($con, $_POST['contact-email']);
            $designation = mysqli_real_escape_string($con, $_POST['designation']);
			$company_mobile = mysqli_real_escape_string($con, $_POST['company_mobile']);

            $final_display_name = $company_name; // or $display_name if you prefer
            $final_email = $company_email;
            $final_address = $comaddress;
            $final_profile = $company_profile;
            $final_mobile = $company_mobile;

                // Check for duplicate email
            $checkEmail = mysqli_query($con, "SELECT * FROM ".$siteprefix."users WHERE email='$company_email'");
            if(mysqli_num_rows($checkEmail) >= 1 ) {
                $statusAction="Ooops!";
                $statusMessage="This email has already been registered. Please try registering another email.";
                showErrorModal($statusAction, $statusMessage);
            }

            else{

            // Insert for company
					 $query = "INSERT INTO ".$siteprefix."users (
				title, display_name, first_name, middle_name, last_name,
				company_name, company_profile, country, profile_picture, specialization,
				mobile_number, email, password, gender, address,
				type, status, last_login, created_date, preference,
				bank_name, bank_accname, bank_number, branch_name, account_type,
				aba_ach, sort_code, ifsc_code, iban, swift_bic,
				loyalty, wallet, affliate, seller,
				facebook, twitter, instagram, linkedln,
				kin_name, kin_number, kin_email, biography, designation, kin_relationship,
				downloads, reset_token, reset_token_expiry
			) VALUES (
				'', '$display_name', '', '', '',
				'$company_name', '$company_profile', '$country', '$company_profile_picture', '$specialization',
				'$company_mobile', '$company_email', '$password', '', '$comaddress',
				'$type', '$status', '$date', '$date', '$preference',
				'$bank_name', '$bank_accname', '$bank_number', '$branch_name', '$account_type',
				'$aba_ach', '$sort_code', '$ifsc_code', '$iban', '$swift_bic',
				'$loyalty', '$wallet', '$affliate', '0',
				'$facebook', '$twitter', '$instagram', '$linkedln',
				'$contact_name', '$contact_mobile', '$contact_email', '', '$designation', '',
				'0', '', ''
			)";
            }

        } else {
            // Individual registration fields
            $email = mysqli_real_escape_string($con, $_POST['email']);
            $title = mysqli_real_escape_string($con, $_POST['title']);
            $display_name = mysqli_real_escape_string($con, $_POST['display-name']);
            $first_name = mysqli_real_escape_string($con, $_POST['first-name']);
            $middle_name = mysqli_real_escape_string($con, $_POST['middle-name']);
            $last_name = mysqli_real_escape_string($con, $_POST['last-name']);
            $specialization = mysqli_real_escape_string($con, $_POST['category']); // single select
            $mobile_number = mysqli_real_escape_string($con, $_POST['phone']);
            $gender = mysqli_real_escape_string($con, $_POST['gender']);
            $address = mysqli_real_escape_string($con, $_POST['address']);
            $biography = mysqli_real_escape_string($con, $_POST['about-me']);
			
			$preference = '';
            // Shared/Bank/Social fields
            $bank_name = mysqli_real_escape_string($con, $_POST['bank-name']);
            $bank_accname = mysqli_real_escape_string($con, $_POST['account-name']);
            $bank_number = mysqli_real_escape_string($con, $_POST['account-number']);
            $branch_name = mysqli_real_escape_string($con, $_POST['branch-name']);
            $account_type = mysqli_real_escape_string($con, $_POST['account-type']);
            $aba_ach  = mysqli_real_escape_string($con, $_POST['aba-ach']);
            $sort_code = mysqli_real_escape_string($con, $_POST['sort-code']);
            $ifsc_code = mysqli_real_escape_string($con, $_POST['ifsc-code']);
            $iban = mysqli_real_escape_string($con, $_POST['iban']);
            $swift_bic = mysqli_real_escape_string($con, $_POST['swift-bic']);
            $facebook = mysqli_real_escape_string($con, $_POST['facebook']);
            $twitter = mysqli_real_escape_string($con, $_POST['twitter']);
            $instagram = mysqli_real_escape_string($con, $_POST['instagram']);
            $linkedln = mysqli_real_escape_string($con, $_POST['linkedin']);
            $kin_name = mysqli_real_escape_string($con, $_POST['contact-name']);
            $kin_number = mysqli_real_escape_string($con, $_POST['contact-mobile']);
            $kin_email = mysqli_real_escape_string($con, $_POST['contact-email']);
            $designation = mysqli_real_escape_string($con, $_POST['designation']);

            $profile_picture = $_FILES['profile_picture']['name'];
             $final_display_name = $display_name;
            $final_email = $email;
            $final_address = $address;
            $final_profile = $biography;
            $final_mobile = $mobile_number;
            $fileKey='profile_picture';

                 if (!empty($profile_picture)) {
           $profile_picture = handleFileUpload($fileKey, $uploadDir, $fileName);
       } else {
           $profile_picture = 'user.png'; // Use the current profile picture if no new one is uploaded
       }

         // Check for duplicate email
            $checkEmail = mysqli_query($con, "SELECT * FROM ".$siteprefix."users WHERE email='$email'");
            if(mysqli_num_rows($checkEmail) >= 1 ) {
                $statusAction="Ooops!";
                $statusMessage="This email has already been registered. Please try registering another email.";
                showErrorModal($statusAction, $statusMessage);
            }
            else{
            // Insert for individual
			  $query = "INSERT INTO ".$siteprefix."users (
				title, display_name, first_name, middle_name, last_name,
				company_name, company_profile, country, profile_picture, specialization,
				mobile_number, email, password, gender, address,
				type, status, last_login, created_date, preference,
				bank_name, bank_accname, bank_number, branch_name, account_type,
				aba_ach, sort_code, ifsc_code, iban, swift_bic,
				loyalty, wallet, affliate, seller,
				facebook, twitter, instagram, linkedln,
				kin_name, kin_number, kin_email, biography, designation, kin_relationship,
				downloads, reset_token, reset_token_expiry
			) VALUES (
				'$title', '$display_name', '$first_name', '$middle_name', '$last_name',
				'', '', '', '$profile_picture', '$specialization',
				'$mobile_number', '$email', '$password', '$gender', '$address',
				'$type', '$status', '$date', '$date', '$preference',
				'$bank_name', '$bank_accname', '$bank_number', '$branch_name', '$account_type',
				'$aba_ach', '$sort_code', '$ifsc_code', '$iban', '$swift_bic',
				'$loyalty', '$wallet', '$affliate', '0',
				'$facebook', '$twitter', '$instagram', '$linkedln',
				'$kin_name', '$kin_number', '$kin_email', '$biography', '$designation', '',
				'0', '', ''
			)";

        }
    }
        if (mysqli_query($con, $query)) {
            $user_id = mysqli_insert_id($con);
        } else {
            $statusAction = "Error!";
            $statusMessage = "There was an error registering the user: " . mysqli_error($con);
            showErrorModal($statusAction, $statusMessage);
            exit();
        }

        $emailSubject = "Confirm Your Email";
        $emailMessage = "
        <p>Thank you for signing up on <strong>Financial Models Store</strong>! To complete your registration
        and start exploring our platform, please verify your email address by clicking the link below:</p>
        <p><a href='$siteurl/verifymail.php?verify_status=$user_id'>Click here to verify your email</a></p>
        <p>Once verified, you can log in and start accessing premium reports, upload your content,
        or manage your dashboard.</p>";

        $adminmessage = "A new user has been registered($display_name)";
        $link="users.php";
        $msgtype='New User';
        $message_status=1;
        $emailMessage_admin="<p>A new user has been successfully registered!</p>";
        $emailSubject_admin="New User Registeration";
        insertadminAlert($con, $adminmessage, $link, $date, $msgtype, $message_status); 
        sendEmail($email, $display_name, $siteName, $siteMail, $emailMessage, $emailSubject);
        sendEmail($siteMail, $adminName, $siteName, $siteMail, $emailMessage_admin, $emailSubject_admin);
        if($seller==1){
            echo header("location:contract.php?user_login=$user_id&name=$final_display_name&address=$final_address&display_name=$final_display_name&email=$final_email&phone=$final_mobile");
        }else{
            echo header("location:login.php?user_login=$user_id");
        }
    }
}

//register affiliate
// Affiliate Registration
if (isset($_POST['register-affiliate'])) {
    // Sanitize and validate input fields
    $first_name = mysqli_real_escape_string($con, $_POST['first_name']);
    $middle_name = mysqli_real_escape_string($con, $_POST['middle_name']);
    $last_name = mysqli_real_escape_string($con, $_POST['last_name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $country = mysqli_real_escape_string($con, $_POST['country']);
    $address = mysqli_real_escape_string($con, $_POST['address']);
    $referral_source = mysqli_real_escape_string($con, $_POST['referral_source']);
    $gender = mysqli_real_escape_string($con, $_POST['gender']);
    $agree_terms = isset($_POST['agree_terms']) ? 1 : 0;
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $retypePassword = mysqli_real_escape_string($con, $_POST['retypePassword']);
    $date = date('Y-m-d H:i:s');
    $status = 'active';
    $type = 'affiliate';
    $affiliate = 'AFF-' . strtoupper(substr(bin2hex(random_bytes(6)), 0, 12));
    // Generate unique affiliate ID

    // Validate email uniqueness
    $checkEmail = mysqli_query($con, "SELECT * FROM " . $siteprefix . "users WHERE email='$email'");
    if (mysqli_num_rows($checkEmail) >= 1) {
        $statusAction = "Ooops!";
        $statusMessage = "This email has already been registered. Please try registering with another email.";
        showErrorModal($statusAction, $statusMessage); 
    }

    // Validate password length
    if (strlen($password) < 6) {
        $statusAction = "Try Again";
        $statusMessage = "Password must have 6 or more characters.";
        showErrorModal($statusAction, $statusMessage);
        
    }

    // Validate password match
    if ($password !== $retypePassword) {
        $statusAction = "Ooops!";
        $statusMessage = "Passwords do not match!";
        showErrorModal($statusAction, $statusMessage);
        
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
/*
    // Handle file upload for ID
    $id_upload = '';
    if (!empty($_FILES['id_upload']['name'])) {
        $uploadDir = 'uploads/';
        $fileName = basename($_FILES['id_upload']['name']);
        $id_upload = $uploadDir . $fileName;

        // Validate file type and size
        $allowed_types = ['image/jpeg', 'image/png', 'application/pdf'];
        if (!in_array($_FILES['id_upload']['type'], $allowed_types)) {
            $statusAction = "Invalid File!";
            $statusMessage = "Only JPG, PNG, and PDF files are allowed.";
            showErrorModal($statusAction, $statusMessage);
        }

        if ($_FILES['id_upload']['size'] > 2000000) { // Limit to 2MB
            $statusAction = "File Too Large!";
            $statusMessage = "File size exceeds the limit of 2MB.";
            showErrorModal($statusAction, $statusMessage);
        }

        // Move uploaded file to the uploads directory
        if (!move_uploaded_file($_FILES['id_upload']['tmp_name'], $id_upload)) {
            $statusAction = "Upload Failed!";
            $statusMessage = "Failed to upload the file. Please try again.";
            showErrorModal($statusAction, $statusMessage);
        }
    }
*/
    // Insert affiliate details into the database
   // Insert for company
$query = "INSERT INTO " . $siteprefix . "users (
    title, display_name, first_name, middle_name, last_name,
    company_name, company_profile, country, profile_picture, specialization,
    mobile_number, email, password, gender, address,
    type, status, last_login, created_date, preference,
    bank_name, bank_accname, bank_number, branch_name, account_type,
    aba_ach, sort_code, ifsc_code, iban, swift_bic,
    loyalty, wallet, affliate, seller,
    facebook, twitter, instagram, linkedln,
    kin_name, kin_number, kin_email, biography, designation, kin_relationship,
    downloads, reset_token, reset_token_expiry
) VALUES (
    '', '$first_name', '$first_name', '$middle_name', '$last_name',
    '', '', '$country', '', '',
    '$phone', '$email', '$hashedPassword', '$gender', '$address',
    '$type', '$status', '$date', '$date', '',
    '', '', '', '', '',
    '', '', '', '', '',
    '0', '0', '$affiliate', '0',
    '', '', '', '',
    '', '', '', '', '', '',
    '0', '', ''
)";

if (mysqli_query($con, $query)) {
$user_id = mysqli_insert_id($con);

 // Send Welcome Email
 $emailSubject = "Welcome to the Financial Models Store Affiliate Program!";
 $emailMessage = "
 <p>Welcome aboard! We're excited to have you as part of the Financial Models Store Affiliate Program — where your network meets opportunity. By joining our platform, you now have the chance to earn commissions by simply sharing high-quality, ready-made academic resources with your audience.</p>
 <p><strong>Here’s what to do next:</strong></p>
 <ol>
     <li>Log in to your affiliate dashboard to access your unique referral link and track your performance.</li>
     <li>Promote any product on our website using your referral link.</li>
     <li>Earn a commission of eight percent (8%) for every successful sale made through your link—easy, transparent, and rewarding!</li>
 </ol>
 <p>If you ever need help, tips, or content to promote, feel free to reach out to our team at <a href='mailto:hello@financialmodels.store.'>hello@financialmodels.store.</a>. We're here to support your growth.</p>
 <p>Thanks for partnering with us—we look forward to growing together!</p>
 ";

 sendEmail($email, $first_name, $siteName, $siteMail, $emailMessage, $emailSubject);

$statusAction = "Success!";
$message = "Affiliate registration successful! A confirmation email has been sent to $email.";
showSuccessModal($statusAction, $message); // Correctly pass the variable
header("refresh:1; url=$affiliateurl"); 
    } else {
        $statusAction = "Error!";
        $statusMessage = "There was an error registering the affiliate: " . mysqli_error($con);
        showErrorModal($statusAction, $statusMessage);
    }
}

//login user
if (isset( $_POST['signin'])){
    $code= $_POST['email'];
    $password = $_POST['password'];
          
    $sql = "SELECT * from ".$siteprefix."users where type='user' AND email='$code'";
    $sql2 = mysqli_query($con,$sql);
    if (mysqli_affected_rows($con) == 0){
    $statusAction="Try Again!";
    $statusMessage='Invalid Email address or Display Name!';
    showErrorModal($statusAction, $statusMessage);  
    }
                
    else {  
    while($row = mysqli_fetch_array($sql2)){
    $id = $row["s"]; 
    $hashedPassword = $row['password'];
    $status = $row['status'];
    $type = $row['type'];
    }
     
    if($type!='user'){
        $statusAction="Ooops!";
        $statusMessage='Invalid Credentials!';
        showErrorModal($statusAction, $statusMessage);  
    }

     else if (!checkPassword($password, $hashedPassword)) {
     $statusAction="Ooops!";
     $statusMessage='Incorrect Password for this account! <a href="forgot_password.php" style="color:red;">Forgot password? Recover here</a>';
     showErrorModal($statusAction, $statusMessage);  
    }
     
    
    else if($status == "inactive"){
        $statusAction="Ooops!";
        $statusMessage=' Email Address have not been verified. we have sent you a mail which contains verification link. kindly check your email and verify your email address.';
        showErrorModal($statusAction, $statusMessage);  
    }
    elseif ($status == "suspended") {
        // Check suspension details
        $suspend_query = "SELECT suspend_end FROM " . $siteprefix . "suspend WHERE user_id = '$id' ORDER BY suspend_end DESC LIMIT 1";
        $suspend_result = mysqli_query($con, $suspend_query);

        if ($suspend_result && mysqli_num_rows($suspend_result) > 0) {
            $suspend_row = mysqli_fetch_assoc($suspend_result);
            $suspend_end_date = $suspend_row['suspend_end'];

            // Check if the suspension has ended
            if (strtotime($suspend_end_date) <= time()) {
                // Update user status to active
                $update_status_query = "UPDATE " . $siteprefix . "users SET status = 'active' WHERE s = '$id'";
                mysqli_query($con, $update_status_query);

                // Proceed with login
                $date = date('Y-m-d H:i:s');
                $insert = mysqli_query($con, "UPDATE " . $siteprefix . "users SET last_login = '$date' WHERE s = '$id'") or die('Could not connect: ' . mysqli_error($con));

             
                $_SESSION['id'] = $id;
                setcookie("userID", $id, time() + (10 * 365 * 24 * 60 * 60));
                $message = "Logged In Successfully";

                showToast($message);

                // Redirection
                if (isset($_SESSION['previous_page'])) {
                    $previousPage = $_SESSION['previous_page'];
                    header("location: $previousPage");
                } else {
                    header("location: dashboard.php");
                }
            } else {
                // Suspension is still active
                $statusAction = "Account Suspended!";
                $statusMessage = "Your account is suspended until " . date('d M Y', strtotime($suspend_end_date)) . ". Please contact support for further assistance.";
                showErrorModal($statusAction, $statusMessage);
            }
        } else {
            // No suspension details found, fallback to error
            $statusAction = "Error!";
            $statusMessage = "Your account is suspended, but no suspension details were found. Please contact support.";
            showErrorModal($statusAction, $statusMessage);
        }
    } elseif ($status == "active") {
        // Proceed with login
        $date = date('Y-m-d H:i:s');
        $insert = mysqli_query($con, "UPDATE " . $siteprefix . "users SET last_login = '$date' WHERE s = '$id'") or die('Could not connect: ' . mysqli_error($con));

      
        $_SESSION['id'] = $id;
        setcookie("userID", $id, time() + (10 * 365 * 24 * 60 * 60));
        $message = "Logged In Successfully";

        showToast($message);

        // Redirection
        if (isset($_SESSION['previous_page'])) {
            $previousPage = $_SESSION['previous_page'];
            header("location: $previousPage");
        } else {
            header("location: dashboard.php");
        }
    }
}
}


// Handle Product Review Submission


// Add review
if (isset($_POST['submit-review'])) {
    $user_id = mysqli_real_escape_string($con, $_POST['user_id']);
    $report_id = mysqli_real_escape_string($con, $_POST['report_id']);
    $rating = mysqli_real_escape_string($con, $_POST['rating']);
    $review = mysqli_real_escape_string($con, trim($_POST['review']));

    // Check if user already has a review
    $check_query = "SELECT * FROM " . $siteprefix . "reviews WHERE user = '$user_id' AND report_id = '$report_id'";
    $result = mysqli_query($con, $check_query);

    if (mysqli_num_rows($result) > 0) {
        // Update existing review
        $update_query = "UPDATE " . $siteprefix . "reviews 
                         SET rating = '$rating', review = '$review', date = NOW() 
                         WHERE user = '$user_id' AND report_id = '$report_id'";
        if (mysqli_query($con, $update_query)) {
            $statusAction = "Successful";
            $statusMessage = "Your review has been updated successfully!";
            showSuccessModal($statusAction, $statusMessage);
        } else {
            $statusAction = "Error";
            $statusMessage = "An error occurred while updating your review. Please try again.";
            showErrorModal($statusAction, $statusMessage);
        }
    } else {
        // Insert new review
        $insert_query = "INSERT INTO " . $siteprefix . "reviews (report_id, user, rating, review, date) 
                         VALUES ('$report_id', '$user_id', '$rating', '$review', NOW())";
        if (mysqli_query($con, $insert_query)) {
            $statusAction = "Successful";
            $statusMessage = "Your review has been submitted successfully!";
            showSuccessModal($statusAction, $statusMessage);
        } else {
            $statusAction = "Error";
            $statusMessage = "An error occurred while submitting your review. Please try again.";
            showErrorModal($statusAction, $statusMessage);
        }
    }
}
   // Handle Report Product Submission
if (isset($_POST['submit_report'])) {
    $product_id = mysqli_real_escape_string($con, $_POST['product_id']);
    $user_id = mysqli_real_escape_string($con, $_POST['user_id']);
    $reason = mysqli_real_escape_string($con, $_POST['reason']);
    $custom_reason = isset($_POST['custom_reason']) ? mysqli_real_escape_string($con, trim($_POST['custom_reason'])) : null;

    // Use custom reason if "Other" is selected
    if ($reason === "Other" && !empty($custom_reason)) {
        $reason = $custom_reason;
    }

    $date = date('Y-m-d H:i:s');

    // Fetch the product title
    $product_query = "SELECT title,alt_title FROM " . $siteprefix . "reports WHERE id = '$product_id'";
    $product_result = mysqli_query($con, $product_query);

    if ($product_result && mysqli_num_rows($product_result) > 0) {
        $product = mysqli_fetch_assoc($product_result);
        $product_title = $product['title'];
        $product_alt_title = $product['alt_title'];
    } else {
        $statusAction = "Error!";
        $statusMessage = "Product not found.";
        showErrorModal($statusAction, $statusMessage);
        header("refresh:2; url=product.php/$product_alt_title");
        exit();
    }

    // Insert the report into the database
    $insert_query = "INSERT INTO " . $siteprefix . "product_reports (product_id, user_id, reason, report_date) 
                     VALUES ('$product_id', '$user_id', '$reason', '$date')";

    if (mysqli_query($con, $insert_query)) {
        // Fetch admin email
        $admin_email = $siteMail; // Replace with your admin email variable
       
        // Fetch user details
        $user_query = "SELECT display_name, email FROM " . $siteprefix . "users WHERE s = '$user_id'";
        $user_result = mysqli_query($con, $user_query);

        if ($user_result && mysqli_num_rows($user_result) > 0) {
            $user = mysqli_fetch_assoc($user_result);
            $user_name = $user['display_name'];
            $user_email = $user['email'];
        } else {
            $user_name = "Unknown User";
            $user_email = "Unknown Email";
        }

        // Email content
        $emailSubject = "New Product Report Submitted";
        $emailMessage = "
            <p>A new product report has been submitted:</p>
            <p><strong>Product Title:</strong> $product_title</p>
            <p><strong>User:</strong> $user_name ($user_email)</p>
            <p><strong>Reason:</strong> $reason</p>
            <p><strong>Date:</strong> $date</p>
        ";

        // Send email to admin
      //  sendEmail($siteMail, $adminName, $siteName, $siteMail, $emailMessage, $emailSubject);

        // Success message
        $statusAction = "Success!";
        $statusMessage = "Your report for <strong>$product_title</strong> has been submitted successfully.";
        showSuccessModal($statusAction, $statusMessage);
        header("refresh:2; url=product/$product_alt_title");

    } else {
        // Error message
        $statusAction = "Error!";
        $statusMessage = "An error occurred while submitting your report. Please try again.";
        showErrorModal($statusAction, $statusMessage);
        header("refresh:2; url=product/$product_alt_title");

    }
}



//manual payment
if (isset($_POST['submit_manual_payment'])) {
    $order_id = mysqli_real_escape_string($con, $_POST['order_id']);
    $user_id = mysqli_real_escape_string($con, $_POST['user_id']);
    $amount = mysqli_real_escape_string($con, $_POST['amount']);
    $date = date('Y-m-d H:i:s');

    // Handle file upload
    if (isset($_FILES['proof_of_payment']) && $_FILES['proof_of_payment']['error'] === UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['proof_of_payment']['tmp_name'];
        $file_name = $_FILES['proof_of_payment']['name'];
        $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
        $allowed_ext = ['jpg', 'jpeg', 'png', 'pdf'];

        if (in_array($file_ext, $allowed_ext)) {
            $new_file_name = uniqid() . '.' . $file_ext;
            $upload_dir = 'uploads/'; // Subdirectory for payment proofs
            $upload_path = $upload_dir . $new_file_name;

            // Ensure the directory exists
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            if (move_uploaded_file($file_tmp, $upload_path)) {
                // Insert payment proof into the database
                $query = "INSERT INTO " . $siteprefix . "manual_payments (order_id, user_id, amount, proof, status, date_created, rejection_reason) 
                          VALUES ('$order_id', '$user_id', '$amount', '$new_file_name', 'pending', '$date', '')";
                if (mysqli_query($con, $query)) {
                    // Update order status to pending
                    $update_order_query = "UPDATE " . $siteprefix . "orders SET status = 'pending' WHERE order_id = '$order_id'";
                    mysqli_query($con, $update_order_query);

                    // Fetch admin email
                    $admin_email = $siteMail; // Replace with your admin email variable
                    $admin_name = "Admin"; // Replace with your admin name variable

                    // Fetch user details
                    $user_query = "SELECT display_name, email FROM " . $siteprefix . "users WHERE s = '$user_id'";
                    $user_result = mysqli_query($con, $user_query);

                    if ($user_result && mysqli_num_rows($user_result) > 0) {
                        $user = mysqli_fetch_assoc($user_result);
                        $user_name = $user['display_name'];
                        $user_email = $user['email'];
                    } else {
                        $user_name = "Unknown User";
                        $user_email = "Unknown Email";
                    }

                    // Email content for admin
                    $emailSubject = "New Manual Payment Submitted";
                    $emailMessage = "
                        <p>A new manual payment has been submitted:</p>
                        <p><strong>Order ID:</strong> $order_id</p>
                        <p><strong>User:</strong> $user_name ($user_email)</p>
                        <p><strong>Amount:</strong> $sitecurrencyCode" . formatNumber($amount, 2) . "</p>
                        <p><strong>Date:</strong> $date</p>
                        <p>Please log in to the admin panel to verify the payment.</p>
                    ";

                    // Send email to admin
                    sendEmail($admin_email, $admin_name, $siteName, $siteMail, $emailMessage, $emailSubject);

                    // Success message for the user
                    $statusAction = "Success!";
                    $statusMessage = "Your payment proof has been submitted successfully. Your order is now pending verification.";
                    showSuccessModal($statusAction, $statusMessage);
                    header("refresh:2; url=checkout.php");
                
                } else {
                    $statusAction = "Error!";
                    $statusMessage = "An error occurred while submitting your payment proof. Please try again.";
                    showErrorModal($statusAction, $statusMessage);
                    header("refresh:2; url=checkout.php");
                    
                }
            } else {
                $statusAction = "Error!";
                $statusMessage = "Failed to upload the proof of payment. Please try again.";
                showErrorModal($statusAction, $statusMessage);
                header("refresh:2; url=checkout.php");
            
            }
        } else {
            $statusAction = "Error!";
            $statusMessage = "Invalid file type. Only JPG, JPEG, PNG, and PDF files are allowed.";
            showErrorModal($statusAction, $statusMessage);
            header("refresh:2; url=checkout.php");
          
        }
    } else {
        $statusAction = "Error!";
        $statusMessage = "No proof of payment uploaded. Please try again.";
        showErrorModal($statusAction, $statusMessage);
        header("refresh:2; url=checkout.php");
       
    }
}
//remove wishlist
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_wishlist'])) {
    $remove_id = $_POST['remove_wishlist_id'];
    $user_id = $_POST['user_id'];

    mysqli_query($con, "DELETE FROM {$siteprefix}wishlist WHERE user='$user_id' AND product='$remove_id'");

    // Refresh the page
    echo "<script>location.href=location.href;</script>";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_profile'])) {

    $user_id = mysqli_real_escape_string($con, $_POST['user_id']);
    $isCompany = isset($_POST['company-name']) && !empty($_POST['company-name']);

    // Common fields
    $specialization = mysqli_real_escape_string($con, $_POST['category'] ?? '');
    $designation = mysqli_real_escape_string($con, $_POST['designation'] ?? '');
    $facebook = mysqli_real_escape_string($con, $_POST['facebook'] ?? '');
    $twitter = mysqli_real_escape_string($con, $_POST['twitter'] ?? '');
    $instagram = mysqli_real_escape_string($con, $_POST['instagram'] ?? '');
    $linkedln = mysqli_real_escape_string($con, $_POST['linkedin'] ?? '');
    $kin_name = mysqli_real_escape_string($con, $_POST['contact-name'] ?? '');
    $kin_number = mysqli_real_escape_string($con, $_POST['contact-mobile'] ?? '');
    $kin_email = mysqli_real_escape_string($con, $_POST['contact-email'] ?? '');
    $bank_name = mysqli_real_escape_string($con, $_POST['bank-name'] ?? '');
    $bank_accname = mysqli_real_escape_string($con, $_POST['account-name'] ?? '');
    $bank_number = mysqli_real_escape_string($con, $_POST['account-number'] ?? '');
    $branch_name = mysqli_real_escape_string($con, $_POST['branch-name'] ?? '');
    $account_type = mysqli_real_escape_string($con, $_POST['account-type'] ?? '');
    $aba_ach = mysqli_real_escape_string($con, $_POST['aba-ach'] ?? '');
    $sort_code = mysqli_real_escape_string($con, $_POST['sort-code'] ?? '');
    $ifsc_code = mysqli_real_escape_string($con, $_POST['ifsc-code'] ?? '');
    $iban = mysqli_real_escape_string($con, $_POST['iban'] ?? '');
    $swift_bic = mysqli_real_escape_string($con, $_POST['swift-bic'] ?? '');

    // Password change
    $password = !empty($_POST['password']) ? trim($_POST['password']) : null;
    $retypePassword = !empty($_POST['retypePassword']) ? trim($_POST['retypePassword']) : null;
    $oldPassword = !empty($_POST['oldpassword']) ? trim($_POST['oldpassword']) : null;
    $hashedPassword = null;

    if (!empty($password) || !empty($retypePassword) || !empty($oldPassword)) {
        if (empty($password) || empty($retypePassword) || empty($oldPassword)) {
           echo "<script>
            alert('All password fields (Password, Retype Password, and Old Password) must be filled out.');
            window.history.back(); // Go back to previous form state
        </script>";
        exit;
            
        }
        if ($password !== $retypePassword) {
            echo "<script>
            alert('New password and retype password do not match.');
            window.history.back(); // Go back to previous form state
        </script>";
            exit;
        }
        $stmt = $con->prepare("SELECT password FROM {$siteprefix}users WHERE s = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();
        if (!$user || !password_verify($oldPassword, $user['password'])) {
            
            echo "<script>
            alert('Old password is incorrect.');
            window.history.back(); // Go back to previous form state
        </script>";
        exit;
        }
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    }

    // Handle profile/company logo upload
    $uploadDir = 'uploads/';
    $profilePicture = '';
    $companyProfilePicture = '';

    if ($isCompany) {
        // Company fields
        $company_name = mysqli_real_escape_string($con, $_POST['company-name']);
        $display_name = mysqli_real_escape_string($con, $_POST['company-display-name'] ?? '');
        $address = mysqli_real_escape_string($con, $_POST['comaddress'] ?? '');
        $company_profile = mysqli_real_escape_string($con, $_POST['comabout-me'] ?? '');
        $email = mysqli_real_escape_string($con, $_POST['company_email'] ?? '');
        $country = mysqli_real_escape_string($con, $_POST['country'] ?? '');
        $mobile_number = mysqli_real_escape_string($con, $_POST['company_phone'] ?? '');
        $biography = '';
        $title = $first_name = $middle_name = $last_name = $gender = '';

        // Company logo upload
        $fileKey = 'company_profile_picture';
        $companyProfilePicture = $_FILES[$fileKey]['name'] ?? '';
        if (!empty($companyProfilePicture)) {
            $companyProfilePicture = handleFileUpload($fileKey, $uploadDir, $companyProfilePicture);
        } else {
            $query = mysqli_query($con, "SELECT profile_picture FROM {$siteprefix}users WHERE s = '$user_id'");
            $row = mysqli_fetch_assoc($query);
            $companyProfilePicture = $row['profile_picture'];
        }
    } else {
        // Individual fields
        $company_name = '';
        $display_name = mysqli_real_escape_string($con, $_POST['display-name'] ?? '');
        $address = mysqli_real_escape_string($con, $_POST['address'] ?? '');
        $company_profile = '';
        $email = mysqli_real_escape_string($con, $_POST['email'] ?? '');
        $country = '';
        $mobile_number = mysqli_real_escape_string($con, $_POST['phone'] ?? '');
        $biography = mysqli_real_escape_string($con, $_POST['about-me'] ?? '');
        $title = mysqli_real_escape_string($con, $_POST['title'] ?? '');
        $first_name = mysqli_real_escape_string($con, $_POST['first-name'] ?? '');
        $middle_name = mysqli_real_escape_string($con, $_POST['middle-name'] ?? '');
        $last_name = mysqli_real_escape_string($con, $_POST['last-name'] ?? '');
        $gender = mysqli_real_escape_string($con, $_POST['gender'] ?? '');

        // Individual profile picture upload
        $fileKey = 'profile_picture';
        $profilePicture = $_FILES[$fileKey]['name'] ?? '';
        if (!empty($profilePicture)) {
            $profilePicture = handleFileUpload($fileKey, $uploadDir, $profilePicture);
        } else {
            $query = mysqli_query($con, "SELECT profile_picture FROM {$siteprefix}users WHERE s = '$user_id'");
            $row = mysqli_fetch_assoc($query);
            $profilePicture = $row['profile_picture'];
        }
    }

    // Password SQL
    $passwordSql = $hashedPassword ? "password = '" . mysqli_real_escape_string($con, $hashedPassword) . "'," : "";

    // Build the update query
    if ($isCompany) {
        $update_query = "
            UPDATE {$siteprefix}users 
            SET 
                first_name = '$first_name',
                title = '$title',
                display_name = '$display_name',
                company_name = '$company_name',
                company_profile = '$company_profile',
                profile_picture = '$companyProfilePicture',
                country = '$country',
                middle_name = '$middle_name',
                last_name = '$last_name',
                email = '$email',
                $passwordSql
                mobile_number = '$mobile_number',
                address = '$address',
                gender = '$gender',
                bank_name = '$bank_name',
                specialization = '$specialization',
                designation = '$designation',
                bank_accname = '$bank_accname',
                bank_number = '$bank_number',
                branch_name = '$branch_name',
                account_type = '$account_type',
                aba_ach = '$aba_ach',
                sort_code = '$sort_code',
                ifsc_code = '$ifsc_code', 
                iban = '$iban',
                swift_bic = '$swift_bic',
                facebook = '$facebook',
                twitter = '$twitter',
                instagram = '$instagram',
                linkedln = '$linkedln',
                kin_name = '$kin_name',
                kin_number = '$kin_number',
                kin_email = '$kin_email',
                biography = '$biography'
            WHERE s = '$user_id'
        ";
    } else {
        $update_query = "
            UPDATE {$siteprefix}users 
            SET 
                first_name = '$first_name',
                title = '$title',
                display_name = '$display_name',
                company_name = '$company_name',
                company_profile = '$company_profile',
                profile_picture = '$profilePicture',
                country = '$country',
                middle_name = '$middle_name',
                last_name = '$last_name',
                email = '$email',
                $passwordSql
                mobile_number = '$mobile_number',
                address = '$address',
                gender = '$gender',
                bank_name = '$bank_name',
                specialization = '$specialization',
                designation = '$designation',
                bank_accname = '$bank_accname',
                bank_number = '$bank_number',
                branch_name = '$branch_name',
                account_type = '$account_type',
                aba_ach = '$aba_ach',
                sort_code = '$sort_code',
                ifsc_code = '$ifsc_code', 
                iban = '$iban',
                swift_bic = '$swift_bic',
                facebook = '$facebook',
                twitter = '$twitter',
                instagram = '$instagram',
                linkedln = '$linkedln',
                kin_name = '$kin_name',
                kin_number = '$kin_number',
                kin_email = '$kin_email',
                biography = '$biography'
            WHERE s = '$user_id'
        ";
    }

    // Execute query
    if (mysqli_query($con, $update_query)) {
        showSuccessModal("Success!", "Profile updated successfully!");
        header("refresh:1; url=settings.php");
   
    } else {
        showErrorModal("Error!", "Failed to update profile: " . mysqli_error($con));
    }
}

// Handle follow/unfollow actions
   if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    $target_user_id = $_POST['seller_id'];
      $user_id = $_POST['user_id']; // Replace with your session variable for user ID

    if ($action === 'follow') {
        // Add a new follower
        $followQuery = "INSERT INTO ".$siteprefix."followers (user_id, seller_id, followed_at, category_id, subcategory_id) VALUES (?, ?, NOW(), '', '')";
        $stmt = $con->prepare($followQuery);
        $stmt->bind_param("ii", $user_id, $target_user_id);
        $stmt->execute();

        echo "<script>alert('You are now following the seller.');</script>";
    } elseif ($action === 'unfollow') {
        // Remove the follower
        $unfollowQuery = "DELETE FROM {$siteprefix}followers WHERE user_id = ? AND seller_id = ?";
        $stmt = $con->prepare($unfollowQuery);
        $stmt->bind_param("ii", $user_id, $target_user_id);
        $stmt->execute();
        echo "<script>alert('You have unfollowed the seller.');</script>";
    }

}
//follow seller
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['follow_seller_submit'])) {
   

    $user_id = $_POST['user_id']; // Replace with your session variable for user ID
    $seller_id = $_POST['seller_id'];
    $actioning = isset($_POST['actioning']) ? $_POST['actioning'] : null;

    if (empty($user_id) || empty($seller_id)) {
        echo "<script>alert('Invalid request.');</script>";
        exit();
    }

    if ($actioning === "follow") {
        // Add a new follow record
        $insertQuery = "INSERT INTO ".$siteprefix."followers (user_id, seller_id, followed_at, category_id, subcategory_id) VALUES (?, ?, NOW(), '', '')";
        $stmt = $con->prepare($insertQuery);
        $stmt->bind_param("ii", $user_id, $seller_id);
        if ($stmt->execute()) {
            echo "<script>alert('You are now following the seller.');</script>";
        } else {
            echo "<script>alert('Failed to follow the seller.');</script>";
        }
    } elseif ($actioning === "unfollow") {
        // Remove the follow record
        $deleteQuery = "DELETE FROM ".$siteprefix."followers WHERE user_id = ? AND seller_id = ?";
        $stmt = $con->prepare($deleteQuery);
        $stmt->bind_param("ii", $user_id, $seller_id);
        if ($stmt->execute()) {
            echo "<script>alert('You have unfollowed the seller.');</script>";
        } else {
            echo "<script>alert('Failed to unfollow the seller.');</script>";
        }
    }
}

//updateproof
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_proof'])) {
    $order_id = mysqli_real_escape_string($con, $_POST['order_id']);
    $user_id = mysqli_real_escape_string($con, $_POST['user_id']);
    $date = date('Y-m-d H:i:s');

    // Handle file upload
    if (isset($_FILES['proof_of_payment']) && $_FILES['proof_of_payment']['error'] === UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['proof_of_payment']['tmp_name'];
        $file_name = $_FILES['proof_of_payment']['name'];
        $file_ext = pathinfo($file_name, PATHINFO_EXTENSION); // File extension (optional, no validation here)
        $new_file_name = uniqid() . '.' . $file_ext;
        $upload_dir = 'uploads/'; // Subdirectory for payment proofs
        $upload_path = $upload_dir . $new_file_name;

        // Ensure the directory exists
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        if (move_uploaded_file($file_tmp, $upload_path)) {
            // Update the proof of payment in the database
            $update_query = "UPDATE " . $siteprefix . "manual_payments 
                             SET proof = '$new_file_name', status = 'pending', date_created = '$date' 
                             WHERE order_id = '$order_id' AND user_id = '$user_id'";
            if (mysqli_query($con, $update_query)) {
                // Fetch admin email
                $admin_email = $siteMail; // Replace with your admin email variable
                $admin_name = $sitename; // Replace with your admin name variable

                // Fetch user details
                $user_query = "SELECT display_name, email FROM " . $siteprefix . "users WHERE s = '$user_id'";
                $user_result = mysqli_query($con, $user_query);

                if ($user_result && mysqli_num_rows($user_result) > 0) {
                    $user = mysqli_fetch_assoc($user_result);
                    $user_name = $user['display_name'];
                    $user_email = $user['email'];
                } else {
                    $user_name = "Unknown User";
                    $user_email = "Unknown Email";
                }

                // Email content for admin
                $emailSubject = "Payment Resent for Order #$order_id";
                $emailMessage = "
                    <p>A payment has been resent:</p>
                    <p><strong>Order ID:</strong> $order_id</p>
                    <p><strong>User:</strong> $user_name ($user_email)</p>
                    <p><strong>Date:</strong> $date</p>
                    <p>Please log in to the admin panel to verify the payment.</p>
                ";

                // Send email to admin
                sendEmail($admin_email, $admin_name, $siteName, $siteMail, $emailMessage, $emailSubject);

                // Success message for the user
                $statusAction = "Success!";
                $statusMessage = "Proof of payment updated successfully. The admin has been notified.";
                showSuccessModal($statusAction, $statusMessage);
                header("refresh:2;");
                
            } else {
                // Database update error
                $statusAction = "Error!";
                $statusMessage = "An error occurred while updating the proof of payment.";
                showErrorModal($statusAction, $statusMessage);
                header("refresh:2;");
                
            }
        } else {
            // File upload error
            $statusAction = "Error!";
            $statusMessage = "Failed to upload the proof of payment. Please try again.";
            showErrorModal($statusAction, $statusMessage);
            header("refresh:2;");
            
        }
    } else {
        // No file uploaded
        $statusAction = "Error!";
        $statusMessage = "No proof of payment uploaded. Please try again.";
        showErrorModal($statusAction, $statusMessage);
        header("refresh:2;");
        
    }
}


// Blog Comment Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['post_comment'])) {
    $blog_id = mysqli_real_escape_string($con, $_POST['blog_id']);
    $user_id = mysqli_real_escape_string($con, $_POST['user']);
    $comment = mysqli_real_escape_string($con, trim($_POST['comment']));
    $parent_comment_id = '';
    $commented_time = date('Y-m-d H:i:s');

    if ($blog_id && $user_id && $comment) {
        $insert_query = "INSERT INTO fm_comments (blog_id, comments, user_id, commented_time, parent_comment_id) 
                         VALUES ('$blog_id', '$comment', '$user_id', '$commented_time', '$parent_comment_id')";
        if (mysqli_query($con, $insert_query)) {
            $statusAction = "Success!";
            $statusMessage = "Your comment has been posted successfully!";
            showSuccessModal($statusAction, $statusMessage);
            // Redirect to avoid resubmission
            header("refresh:1;");
        
        } else {
            $statusAction = "Error!";
            $statusMessage = "An error occurred while posting your comment. Please try again.";
            showErrorModal($statusAction, $statusMessage);
        }
    } else {
        $statusAction = "Error!";
        $statusMessage = "All fields are required.";
        showErrorModal($statusAction, $statusMessage);
    }
}



if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_comment_id']) && isset($_POST['delete_comment'])) {
    $delete_comment_id = mysqli_real_escape_string($con, $_POST['delete_comment_id']);
    // Check if the logged-in user owns the comment
    $checkRes = mysqli_query($con, "SELECT user_id FROM fm_comments WHERE s='$delete_comment_id' LIMIT 1");
    $checkRow = mysqli_fetch_assoc($checkRes);
    if ($checkRow && $checkRow['user_id'] == $user_id) {
        deleteCommentAndReplies($delete_comment_id, $con);
        $statusAction = "Deleted!";
        $statusMessage = "Comment and all its replies deleted successfully.";
        showSuccessModal($statusAction, $statusMessage);
        header("refresh:1;");
       
    } else {
        $statusAction = "Error!";
        $statusMessage = "You are not allowed to delete this comment.";
        showErrorModal($statusAction, $statusMessage);
    }
}
// Blog Comment Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['post_reply_comment'])) {
    $blog_id = mysqli_real_escape_string($con, $_POST['blog_id']);
    $user_id = mysqli_real_escape_string($con, $_POST['user']);
    $comment = mysqli_real_escape_string($con, trim($_POST['comment']));
    $parent_comment_id = mysqli_real_escape_string($con, trim($_POST['parent_comment_id']));
    $commented_time = date('Y-m-d H:i:s');

    if ($blog_id && $user_id && $comment) {
        $insert_query = "INSERT INTO fm_comments (blog_id, comments, user_id, commented_time, parent_comment_id) 
                         VALUES ('$blog_id', '$comment', '$user_id', '$commented_time', '$parent_comment_id')";
        if (mysqli_query($con, $insert_query)) {
            $statusAction = "Success!";
            $statusMessage = "Your comment has been posted successfully!";
            showSuccessModal($statusAction, $statusMessage);
            // Redirect to avoid resubmission
            header("refresh:1;");
        
        } else {
            $statusAction = "Error!";
            $statusMessage = "An error occurred while posting your comment. Please try again.";
            showErrorModal($statusAction, $statusMessage);
        }
    } else {
        $statusAction = "Error!";
        $statusMessage = "All fields are required.";
        showErrorModal($statusAction, $statusMessage);
    }
}



//upload-report

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['addcourse'])) {
    $reportId = mysqli_real_escape_string($con, $_POST['id']);
    $title = mysqli_real_escape_string($con, $_POST['title']);
     $description = mysqli_real_escape_string($con, $_POST['description']);
    $category = mysqli_real_escape_string($con, $_POST['category']);
    $subcategory = isset($_POST['subcategory']) ? mysqli_real_escape_string($con, $_POST['subcategory']) : null;
    $pricing = mysqli_real_escape_string($con, $_POST['pricing']);
    $price = !empty($_POST['price']) ? mysqli_real_escape_string($con, $_POST['price']) : '0';
    $tags = mysqli_real_escape_string($con, $_POST['tags']);
    $loyalty = '';
    $documentTypes = isset($_POST['documentSelect']) ? $_POST['documentSelect'] : [];
    $status = 'pending'; // Default status
    $methodology = mysqli_real_escape_string($con, $_POST['methodology']);;
    $resource_type = implode(',', $_POST['resource_type']);
    $user_id = $_POST['user'] ?? null;
    


// Replace spaces with hyphens and convert to lowercase
$baseSlug = strtolower(str_replace(' ', '-', $title));

// Start with the cleaned slug
$alt_title = $baseSlug;
$counter = 1;

// Ensure the alt_title is unique
while (true) {
    $query = "SELECT COUNT(*) AS count FROM " . $siteprefix . "reports WHERE alt_title = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("s", $alt_title);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row['count'] == 0) {
        break; // alt_title is unique
    }

    // Append counter to baseSlug if not unique
    $alt_title = $baseSlug . '-' . $counter;
    $counter++;
}


    // Directories for uploads
    $uploadDir = 'uploads/';
    $fileuploadDir = 'documents/';
    $fileKey = 'images';
    $message = "";

    // Handle image uploads
    if (empty($_FILES[$fileKey]['name'][0])) {
        // Use default images if no images are uploaded
        $defaultImages = ['default1.jpg', 'default2.jpg', 'default3.jpg', 'default4.jpg', 'default5.jpg'];
        $randomImage = $defaultImages[array_rand($defaultImages)];
        $reportImages = [$randomImage];
    }else{

    // Insert images into the database
    $reportImages = handleMultipleFileUpload($fileKey, $uploadDir);
    }

    $uploadedFiles = [];
    foreach ($reportImages as $image) {
        $stmt = $con->prepare("INSERT INTO " . $siteprefix . "reports_images (report_id, picture, updated_at) VALUES (?, ?, current_timestamp())");
        $stmt->bind_param("ss", $reportId, $image);
        if ($stmt->execute()) {
            $uploadedFiles[] = $image;
        } else {
            $message .= "Error inserting image: " . $stmt->error . "<br>";
        }
        $stmt->close();
    }

    // Handle file uploads for different document types
    $fileFields = [
        'file_word' => 'word',
        'file_excel' => 'excel',
        'file_pdf' => 'pdf',
        'file_powerpoint' => 'powerpoint',
        'file_text' => 'text'
    ];

    foreach ($fileFields as $fileField => $docType) {
        if (isset($_FILES[$fileField]) && $_FILES[$fileField]['error'] == UPLOAD_ERR_OK) {
            $filePath = handleFileUpload($fileField, $fileuploadDir);
            $pagesField = 'pages_' . $docType;
            $pages = isset($_POST[$pagesField]) ? (int)$_POST[$pagesField] : 0;

            $stmt = $con->prepare("INSERT INTO " . $siteprefix . "reports_files (report_id, title, pages, updated_at) VALUES (?, ?, ?, current_timestamp())");
            $stmt->bind_param("ssi", $reportId, $filePath, $pages);

            if ($stmt->execute()) {
                $message .= ucfirst($docType) . " file uploaded and record added successfully!<br>";
            } else {
                $message .= "Error uploading $docType file: " . $stmt->error . "<br>";
            }

            $stmt->close();
        }
    }

     // 5. Handle guidance video upload
  $guidance_video = '';
if (!empty($_FILES['guidance_video']['name'])) {
    $ext = strtolower(pathinfo($_FILES['guidance_video']['name'], PATHINFO_EXTENSION));
    $guidance_video = uniqid('video_') . '.' . $ext;
    $targetPath = 'documents/' . $guidance_video;

    if (move_uploaded_file($_FILES['guidance_video']['tmp_name'], $targetPath)) {
        // File successfully uploaded
        // Insert into database
        $query = "INSERT INTO {$siteprefix}guidance (report_id,video_filename, uploaded_at) 
                  VALUES ('$reportId','$guidance_video', NOW())";
        mysqli_query($con, $query);
    } else {
        echo "Failed to upload video file.";
    }
}


if (!empty($_POST['supportDocSelect']) && is_array($_POST['supportDocSelect'])) {
    foreach ($_POST['supportDocSelect'] as $docTypeId) {
        $docTypeId = mysqli_real_escape_string($con, $docTypeId);
        $price = isset($_POST['support_prices'][$docTypeId]) ? mysqli_real_escape_string($con, $_POST['support_prices'][$docTypeId]) : '0';

        // Check if a file was uploaded for this doc type
        if (
            isset($_FILES['support_files']['name'][$docTypeId]) &&
            !empty($_FILES['support_files']['name'][$docTypeId]) &&
            $_FILES['support_files']['error'][$docTypeId] == UPLOAD_ERR_OK
        ) {
            $fileName = $_FILES['support_files']['name'][$docTypeId];
            $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $newFileName = uniqid('doc_') . '.' . $ext;
            $targetPath = 'documents/' . $newFileName;
            if (move_uploaded_file($_FILES['support_files']['tmp_name'][$docTypeId], $targetPath)) {
                // Insert into doc_file table, now with price
                $sql = "INSERT INTO {$siteprefix}doc_file (report_id, doc_typeid, filename, price, uploaded_at) 
                        VALUES ('$reportId', '$docTypeId', '$newFileName', '$price', NOW())";
                if (mysqli_query($con, $sql)) {
                    $message .= "Other resource file uploaded and record added successfully!<br>";
                } else {
                    $message .= "Error inserting other resource file: " . mysqli_error($con) . "<br>";
                }
            } else {
                $message .= "Failed to upload other resource file.<br>";
            }
        }
    }
}

// Insert report data into the database
   $sql = "INSERT INTO " . $siteprefix . "reports 
        (id, title, description, methodology, use_case, category, subcategory, pricing, price, tags, loyalty, user, created_date, updated_date, status,alt_title) 
        VALUES 
        ('$reportId', '$title', '$description', '$methodology', '$resource_type', '$category', '$subcategory', '$pricing', '$price', '$tags', '$loyalty', '$user_id', current_timestamp(), current_timestamp(), '$status','$alt_title')";

if (mysqli_query($con, $sql)) {
    $message .= "Report added successfully!<br>";

/*

        if ($status === 'approved') {
            // Notify followers of the seller
            $followersQuery = "SELECT user_id FROM " . $siteprefix . "followers WHERE seller_id = '$user_id'";
            $followersResult = mysqli_query($con, $followersQuery);
    
            if ($followersResult && mysqli_num_rows($followersResult) > 0) {
                // Fetch the seller's name
                $sellerQuery = "SELECT display_name FROM " . $siteprefix . "users WHERE s = '$user_id'";
                $sellerResult = mysqli_query($con, $sellerQuery);
                $sellerRow = mysqli_fetch_assoc($sellerResult);
                $sellerName = $sellerRow['display_name'];
    
                // Notify all followers of the seller
                while ($follower = mysqli_fetch_assoc($followersResult)) {
                    $followerId = $follower['user_id'];
    
                    // Fetch follower details
                    $followerDetailsQuery = "SELECT email, display_name FROM " . $siteprefix . "users WHERE s = '$followerId'";
                    $followerDetailsResult = mysqli_query($con, $followerDetailsQuery);
                    $followerDetails = mysqli_fetch_assoc($followerDetailsResult);
    
                    $followerEmail = $followerDetails['email'];
                    $followerName = $followerDetails['display_name'];
    
                    // Prepare the email
                    $emailSubject = "New Resource Posted by $sellerName";
                    $emailMessage = "
                        <p>We are excited to inform you that $sellerName has just posted a new resource titled <strong>$title</strong>.</p>
                        <p>You can check it out here: <a href='$siteurl/merchant-store.php?seller_id=$user_id'>$sellerName</a></p>
                        <p>Thank you for following $sellerName!</p>";
    
                    // Send the email
                    sendEmail($followerEmail, $followerName, $siteName, $siteMail, $emailMessage, $emailSubject);
                   
                    // Notify user
                   insertAlert($con, $followerId, "New resource titled $title has been posted by $sellerName", $currentdatetime, 0);
                }
            }
    
            // Notify followers of the category
            $categoryFollowersQuery = "SELECT user_id FROM " . $siteprefix . "followers WHERE category_id = '$category'";
            $categoryFollowersResult = mysqli_query($con, $categoryFollowersQuery);
    
            if ($categoryFollowersResult && mysqli_num_rows($categoryFollowersResult) > 0) {
                // Fetch category name for the email
                $categoryQuery = "SELECT category_name FROM " . $siteprefix . "categories WHERE id = '$category'";
                $categoryResult = mysqli_query($con, $categoryQuery);
                $categoryRow = mysqli_fetch_assoc($categoryResult);
                $categoryName = $categoryRow['category_name'];
                $slugs = strtolower(str_replace(' ', '-', $categoryName));
    
                // Notify all users following the category
                while ($follower = mysqli_fetch_assoc($categoryFollowersResult)) {
                    $followerId = $follower['user_id'];
    
                    // Fetch follower details
                    $followerDetailsQuery = "SELECT email, display_name FROM " . $siteprefix . "users WHERE s = '$followerId'";
                    $followerDetailsResult = mysqli_query($con, $followerDetailsQuery);
                    $followerDetails = mysqli_fetch_assoc($followerDetailsResult);
    
                    $followerEmail = $followerDetails['email'];
                    $followerName = $followerDetails['display_name'];
    
                    // Prepare the email
                    $emailSubject = "New Resource in $categoryName";
                    $emailMessage = "
                        <p>We are excited to inform you that a new resource titled <strong>$title</strong> has been added to the <strong>$categoryName</strong> category.</p>
                        <p>You can check it out here: <a href='$siteurl/category.php/$slugs'>$categoryName</a></p>
                        <p>Thank you for following the $categoryName category!</p>
                    ";
    
                    // Send the email
                    sendEmail($followerEmail, $followerName, $siteName, $siteMail, $emailMessage, $emailSubject);

                     // Notify user
                   insertAlert($con, $followerId, "New resource titled $title  under category $categoryName  has been posted", $currentdatetime, 0);
                }
            }
        }

        */
    
    } else {
        $message .= "Error adding report: " . mysqli_error($con) . "<br>";
    }

    // Display success or error message
    showSuccessModal('Processed', $message);
    header("refresh:2; url=add-report.php");
}



if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['savedcourse'])) {
        $reportId = mysqli_real_escape_string($con, $_POST['id']);
    $title = mysqli_real_escape_string($con, $_POST['title']);
     $description = mysqli_real_escape_string($con, $_POST['description']);
    $category = mysqli_real_escape_string($con, $_POST['category']);
    $subcategory = isset($_POST['subcategory']) ? mysqli_real_escape_string($con, $_POST['subcategory']) : null;
    $pricing = mysqli_real_escape_string($con, $_POST['pricing']);
    $price = !empty($_POST['price']) ? mysqli_real_escape_string($con, $_POST['price']) : '0';
    $tags = mysqli_real_escape_string($con, $_POST['tags']);
    $loyalty = '';
    $documentTypes = isset($_POST['documentSelect']) ? $_POST['documentSelect'] : [];
    $status = "draft";
    $methodology = mysqli_real_escape_string($con, $_POST['methodology']);;
    $resource_type = implode(',', $_POST['resource_type']);
    $user_id = $_POST['user'] ?? null;
    


// Replace spaces with hyphens and convert to lowercase
$baseSlug = strtolower(str_replace(' ', '-', $title));

// Start with the cleaned slug
$alt_title = $baseSlug;
$counter = 1;

// Ensure the alt_title is unique
while (true) {
    $query = "SELECT COUNT(*) AS count FROM " . $siteprefix . "reports WHERE alt_title = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("s", $alt_title);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row['count'] == 0) {
        break; // alt_title is unique
    }

    // Append counter to baseSlug if not unique
    $alt_title = $baseSlug . '-' . $counter;
    $counter++;
}


    // Directories for uploads
    $uploadDir = 'uploads/';
    $fileuploadDir = 'documents/';
    $fileKey = 'images';
    $message = "";

    // Handle image uploads
    if (empty($_FILES[$fileKey]['name'][0])) {
        // Use default images if no images are uploaded
        $defaultImages = ['default1.jpg', 'default2.jpg', 'default3.jpg', 'default4.jpg', 'default5.jpg'];
        $randomImage = $defaultImages[array_rand($defaultImages)];
        $reportImages = [$randomImage];
    }else{

    // Insert images into the database
    $reportImages = handleMultipleFileUpload($fileKey, $uploadDir);
    }

    $uploadedFiles = [];
    foreach ($reportImages as $image) {
        $stmt = $con->prepare("INSERT INTO " . $siteprefix . "reports_images (report_id, picture, updated_at) VALUES (?, ?, current_timestamp())");
        $stmt->bind_param("ss", $reportId, $image);
        if ($stmt->execute()) {
            $uploadedFiles[] = $image;
        } else {
            $message .= "Error inserting image: " . $stmt->error . "<br>";
        }
        $stmt->close();
    }

    // Handle file uploads for different document types
    $fileFields = [
        'file_word' => 'word',
        'file_excel' => 'excel',
        'file_pdf' => 'pdf',
        'file_powerpoint' => 'powerpoint',
        'file_text' => 'text'
    ];

    foreach ($fileFields as $fileField => $docType) {
        if (isset($_FILES[$fileField]) && $_FILES[$fileField]['error'] == UPLOAD_ERR_OK) {
            $filePath = handleFileUpload($fileField, $fileuploadDir);
            $pagesField = 'pages_' . $docType;
            $pages = isset($_POST[$pagesField]) ? (int)$_POST[$pagesField] : 0;

            $stmt = $con->prepare("INSERT INTO " . $siteprefix . "reports_files (report_id, title, pages, updated_at) VALUES (?, ?, ?, current_timestamp())");
            $stmt->bind_param("ssi", $reportId, $filePath, $pages);

            if ($stmt->execute()) {
                $message .= ucfirst($docType) . " file uploaded and record added successfully!<br>";
            } else {
                $message .= "Error uploading $docType file: " . $stmt->error . "<br>";
            }

            $stmt->close();
        }
    }

     // 5. Handle guidance video upload
  $guidance_video = '';
if (!empty($_FILES['guidance_video']['name'])) {
    $ext = strtolower(pathinfo($_FILES['guidance_video']['name'], PATHINFO_EXTENSION));
    $guidance_video = uniqid('video_') . '.' . $ext;
    $targetPath = 'documents/' . $guidance_video;

    if (move_uploaded_file($_FILES['guidance_video']['tmp_name'], $targetPath)) {
        // File successfully uploaded
        // Insert into database
        $query = "INSERT INTO {$siteprefix}guidance (report_id,video_filename, uploaded_at) 
                  VALUES ('$reportId','$guidance_video', NOW())";
        mysqli_query($con, $query);
    } else {
        echo "Failed to upload video file.";
    }
}


if (!empty($_POST['supportDocSelect']) && is_array($_POST['supportDocSelect'])) {
    foreach ($_POST['supportDocSelect'] as $docTypeId) {
        $docTypeId = mysqli_real_escape_string($con, $docTypeId);
        $price = isset($_POST['support_prices'][$docTypeId]) ? mysqli_real_escape_string($con, $_POST['support_prices'][$docTypeId]) : '0';

        // Check if a file was uploaded for this doc type
        if (
            isset($_FILES['support_files']['name'][$docTypeId]) &&
            !empty($_FILES['support_files']['name'][$docTypeId]) &&
            $_FILES['support_files']['error'][$docTypeId] == UPLOAD_ERR_OK
        ) {
            $fileName = $_FILES['support_files']['name'][$docTypeId];
            $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $newFileName = uniqid('doc_') . '.' . $ext;
            $targetPath = 'documents/' . $newFileName;
            if (move_uploaded_file($_FILES['support_files']['tmp_name'][$docTypeId], $targetPath)) {
                // Insert into doc_file table, now with price
                $sql = "INSERT INTO {$siteprefix}doc_file (report_id, doc_typeid, filename, price, uploaded_at) 
                        VALUES ('$reportId', '$docTypeId', '$newFileName', '$price', NOW())";
                if (mysqli_query($con, $sql)) {
                    $message .= "Other resource file uploaded and record added successfully!<br>";
                } else {
                    $message .= "Error inserting other resource file: " . mysqli_error($con) . "<br>";
                }
            } else {
                $message .= "Failed to upload other resource file.<br>";
            }
        }
    }
}

// Insert report data into the database
   $sql = "INSERT INTO " . $siteprefix . "reports 
        (id, title, description, methodology, use_case, category, subcategory, pricing, price, tags, loyalty, user, created_date, updated_date, status,alt_title) 
        VALUES 
        ('$reportId', '$title', '$description', '$methodology', '$resource_type', '$category', '$subcategory', '$pricing', '$price', '$tags', '$loyalty', '$user_id', current_timestamp(), current_timestamp(), '$status','$alt_title')";

if (mysqli_query($con, $sql)) {
    $message .= "Saved as draft successfully!<br>";

/*

        if ($status === 'approved') {
            // Notify followers of the seller
            $followersQuery = "SELECT user_id FROM " . $siteprefix . "followers WHERE seller_id = '$user_id'";
            $followersResult = mysqli_query($con, $followersQuery);
    
            if ($followersResult && mysqli_num_rows($followersResult) > 0) {
                // Fetch the seller's name
                $sellerQuery = "SELECT display_name FROM " . $siteprefix . "users WHERE s = '$user_id'";
                $sellerResult = mysqli_query($con, $sellerQuery);
                $sellerRow = mysqli_fetch_assoc($sellerResult);
                $sellerName = $sellerRow['display_name'];
    
                // Notify all followers of the seller
                while ($follower = mysqli_fetch_assoc($followersResult)) {
                    $followerId = $follower['user_id'];
    
                    // Fetch follower details
                    $followerDetailsQuery = "SELECT email, display_name FROM " . $siteprefix . "users WHERE s = '$followerId'";
                    $followerDetailsResult = mysqli_query($con, $followerDetailsQuery);
                    $followerDetails = mysqli_fetch_assoc($followerDetailsResult);
    
                    $followerEmail = $followerDetails['email'];
                    $followerName = $followerDetails['display_name'];
    
                    // Prepare the email
                    $emailSubject = "New Resource Posted by $sellerName";
                    $emailMessage = "
                        <p>We are excited to inform you that $sellerName has just posted a new resource titled <strong>$title</strong>.</p>
                        <p>You can check it out here: <a href='$siteurl/merchant-store.php?seller_id=$user_id'>$sellerName</a></p>
                        <p>Thank you for following $sellerName!</p>";
    
                    // Send the email
                    sendEmail($followerEmail, $followerName, $siteName, $siteMail, $emailMessage, $emailSubject);
                   
                    // Notify user
                   insertAlert($con, $followerId, "New resource titled $title has been posted by $sellerName", $currentdatetime, 0);
                }
            }
    
            // Notify followers of the category
            $categoryFollowersQuery = "SELECT user_id FROM " . $siteprefix . "followers WHERE category_id = '$category'";
            $categoryFollowersResult = mysqli_query($con, $categoryFollowersQuery);
    
            if ($categoryFollowersResult && mysqli_num_rows($categoryFollowersResult) > 0) {
                // Fetch category name for the email
                $categoryQuery = "SELECT category_name FROM " . $siteprefix . "categories WHERE id = '$category'";
                $categoryResult = mysqli_query($con, $categoryQuery);
                $categoryRow = mysqli_fetch_assoc($categoryResult);
                $categoryName = $categoryRow['category_name'];
                $slugs = strtolower(str_replace(' ', '-', $categoryName));
    
                // Notify all users following the category
                while ($follower = mysqli_fetch_assoc($categoryFollowersResult)) {
                    $followerId = $follower['user_id'];
    
                    // Fetch follower details
                    $followerDetailsQuery = "SELECT email, display_name FROM " . $siteprefix . "users WHERE s = '$followerId'";
                    $followerDetailsResult = mysqli_query($con, $followerDetailsQuery);
                    $followerDetails = mysqli_fetch_assoc($followerDetailsResult);
    
                    $followerEmail = $followerDetails['email'];
                    $followerName = $followerDetails['display_name'];
    
                    // Prepare the email
                    $emailSubject = "New Resource in $categoryName";
                    $emailMessage = "
                        <p>We are excited to inform you that a new resource titled <strong>$title</strong> has been added to the <strong>$categoryName</strong> category.</p>
                        <p>You can check it out here: <a href='$siteurl/category.php/$slugs'>$categoryName</a></p>
                        <p>Thank you for following the $categoryName category!</p>
                    ";
    
                    // Send the email
                    sendEmail($followerEmail, $followerName, $siteName, $siteMail, $emailMessage, $emailSubject);

                     // Notify user
                   insertAlert($con, $followerId, "New resource titled $title  under category $categoryName  has been posted", $currentdatetime, 0);
                }
            }
        }

        */
    
    } else {
        $message .= "Error adding report: " . mysqli_error($con) . "<br>";
    }

    // Display success or error message
    showSuccessModal('Processed', $message);
    header("refresh:2; url=models.php");
}


//delete-record
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $table = $_GET['table'];
    $item = $_GET['item'];
    $page = $_GET['page'];
    
    if (deleteRecord($table, $item)) {
        $message="Record deleted successfully.";
    } else {
         $message="Failed to delete the record.";
    }

    showToast($message);
    header("refresh:2; url=$page");
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update-report'])) {
    $message = "";
    $hasError = false;
    $reportId = $_POST['id'];
    $title =  mysqli_real_escape_string($con,$_POST['title']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $category = $_POST['category'];
    $subcategory = isset($_POST['subcategory']) ? $_POST['subcategory'] : null;
    $pricing = $_POST['pricing'];
    $price = !empty($_POST['price']) ? $_POST['price'] : '0';
    $tags = mysqli_real_escape_string($con,$_POST['tags']);
    $loyalty = '';
    $documentTypes = isset($_POST['documentSelect']) ? $_POST['documentSelect'] : [];
  $status = "pending";
    $methodology =  mysqli_real_escape_string($con, $_POST['methodology']);
    $resource_type = implode(',',$_POST['resource_type']);
    $user_id = $_POST['user'];

    $siteline = $siteurl; // Replace with your site URL

    // Upload images
    $uploadDir = 'uploads/';
    $fileuploadDir = 'documents/';
    $fileKey='images';
    global $fileName;
    $message="";

    
    if (empty($_FILES[$fileKey]['name'][0])) {
       // Array of default images
     //  $defaultImages = ['default1.jpg', 'default2.jpg', 'default3.jpg', 'default4.jpg', 'default5.jpg'];
        // Pick a random default image
     //  $randomImage = $defaultImages[array_rand($defaultImages)];
     //   $reportImages = [$randomImage];
        $reportImages = [];
    }else{
    $reportImages = handleMultipleFileUpload($fileKey, $uploadDir);
     }

     $uploadedFiles = [];
    foreach ($reportImages as $image) {
        $stmt = $con->prepare("INSERT INTO  ".$siteprefix."reports_images (report_id, picture, updated_at) VALUES (?, ?, current_timestamp())");
        $stmt->bind_param("ss", $reportId, $image);
        if ($stmt->execute()) {
            $uploadedFiles[] = $image;
        } else {
            $message.="Error: " . $stmt->error;
            $hasError = true;
        }
        $stmt->close();
    }

    // Handle file uploads
    $fileFields = [
        'file_word' => 'word',
        'file_excel' => 'excel',
        'file_pdf' => 'pdf',
        'file_powerpoint' => 'powerpoint',
        'file_text' => 'text'
    ];

    foreach ($fileFields as $fileField => $docType) {
        if (isset($_FILES[$fileField]) && $_FILES[$fileField]['error'] == UPLOAD_ERR_OK) {
            $filePath = handleFileUpload($fileField, $fileuploadDir);
            $pagesField = 'pages_' . $docType;
            $pages = isset($_POST[$pagesField]) ? $_POST[$pagesField] : 0;

            $stmt = $con->prepare("INSERT INTO  ".$siteprefix."reports_files (report_id, title, pages, updated_at) VALUES (?, ?, ?, current_timestamp())");
            $stmt->bind_param("ssi", $reportId, $filePath, $pages);

            if ($stmt->execute()) {
                $message.="File uploaded and record added successfully!";
            } else {
                $message.="Error: " . $stmt->error;
                $hasError = true;
            }

            $stmt->close();
        }
    }

$guidance_video = '';

if (!empty($_FILES['guidance_video']['name'])) {
    $reportId = mysqli_real_escape_string($con, $reportId);

    // Fetch current methodology
    $methodologyCheck = mysqli_query($con, "SELECT methodology FROM {$siteprefix}reports WHERE id = '$reportId' LIMIT 1");
    $methodologyRow = mysqli_fetch_assoc($methodologyCheck);
    $currentMethodology = $methodologyRow['methodology'] ?? '';

    if (!empty(trim($currentMethodology))) {
        // Check if guidance video already exists
        $guidanceCheck = mysqli_query($con, "SELECT video_filename FROM {$siteprefix}guidance WHERE report_id = '$reportId' LIMIT 1");

        if (mysqli_num_rows($guidanceCheck) > 0) {
            $message .= "A guidance video already exists for this report. Please delete the existing video before uploading a new one.<br>";
            $hasError = true;
        } else {
            // No existing guidance video, clear methodology
            $updateMethodology = mysqli_query($con, "UPDATE {$siteprefix}reports SET methodology = '' WHERE id = '$reportId'");
            if (!$updateMethodology) {
                $message .= "Failed to clear methodology.<br>";
                $hasError = true;
            }
        }
    }

    // If no error so far, proceed with video upload
    if (!$hasError) {
        $ext = strtolower(pathinfo($_FILES['guidance_video']['name'], PATHINFO_EXTENSION));
        $allowedExts = ['mp4', 'mov', 'avi', 'mkv'];

        if (!in_array($ext, $allowedExts)) {
            $message .= "Invalid file type. Only video files are allowed.<br>";
            $hasError = true;
        } else {
            $guidance_video = uniqid('video_') . '.' . $ext;
            $targetPath = 'documents/' . $guidance_video;

            if (move_uploaded_file($_FILES['guidance_video']['tmp_name'], $targetPath)) {
                $insertQuery = "INSERT INTO {$siteprefix}guidance (report_id, video_filename, uploaded_at) 
                                VALUES ('$reportId', '$guidance_video', NOW())";

                if (!mysqli_query($con, $insertQuery)) {
                    $message .= "Failed to insert guidance video into the database.<br>";
                    $hasError = true;
                }
            } else {
                $message .= "Failed to upload the video file.<br>";
                $hasError = true;
            }
        }
    }
}

// Check if user is trying to update methodology
if (!empty(trim($methodology))) {
    // Check if a guidance video exists for this report
    $guidanceCheck = mysqli_query($con, "SELECT video_filename FROM {$siteprefix}guidance WHERE report_id = '$reportId' LIMIT 1");
    if ($guidanceCheck && mysqli_num_rows($guidanceCheck) > 0) {
        $message .= "A guidance video already exists for this report. Please delete the existing video before updating the methodology.<br>";
        $hasError = true;
    }
}


// Handle support documents
if (!empty($_POST['supportDocSelect']) && is_array($_POST['supportDocSelect'])) {
   $existingDocs = [];
$existingDocsQuery = mysqli_query($con, "SELECT doc_typeid FROM {$siteprefix}doc_file WHERE report_id = '$reportId'");
while ($row = mysqli_fetch_assoc($existingDocsQuery)) {
    $existingDocs[] = $row['doc_typeid'];
}

// 2. Get selected docs from the form
$selectedDocs = !empty($_POST['supportDocSelect']) && is_array($_POST['supportDocSelect']) ? $_POST['supportDocSelect'] : [];

// 3. Handle update/insert for selected docs
foreach ($selectedDocs as $docTypeId) {
    $docTypeId = mysqli_real_escape_string($con, $docTypeId);
    $supportPrices = isset($_POST['support_prices'][$docTypeId]) ? mysqli_real_escape_string($con, $_POST['support_prices'][$docTypeId]) : '0';

    // Check if this doc already exists for this report
    $checkSql = "SELECT s, filename FROM {$siteprefix}doc_file WHERE report_id = '$reportId' AND doc_typeid = '$docTypeId' LIMIT 1";
    $checkResult = mysqli_query($con, $checkSql);

    if ($checkResult && $row = mysqli_fetch_assoc($checkResult)) {
        // Exists: update price and file if a new file is uploaded
        $updateFile = $row['filename'];
        if (
            isset($_FILES['support_files']['name'][$docTypeId]) &&
            !empty($_FILES['support_files']['name'][$docTypeId]) &&
            $_FILES['support_files']['error'][$docTypeId] == UPLOAD_ERR_OK
        ) {
            $fileName = $_FILES['support_files']['name'][$docTypeId];
            $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $newFileName = uniqid('doc_') . '.' . $ext;
            $targetPath = '../../documents/' . $newFileName;
            if (move_uploaded_file($_FILES['support_files']['tmp_name'][$docTypeId], $targetPath)) {
                $updateFile = $newFileName;
            } else {
                $message .= "Failed to upload new file for support doc.<br>";
                $hasError = true;
            }
        }
        // Update record
        $sql = "UPDATE {$siteprefix}doc_file SET price='$supportPrices', filename='$updateFile', uploaded_at=NOW() WHERE report_id='$reportId' AND doc_typeid='$docTypeId'";
        if (!mysqli_query($con, $sql)) {
            $message .= "Error updating support doc: " . mysqli_error($con) . "<br>";
            $hasError = true;
        }
    } else {
        // Not exists: insert new record if a file is uploaded
        if (
            isset($_FILES['support_files']['name'][$docTypeId]) &&
            !empty($_FILES['support_files']['name'][$docTypeId]) &&
            $_FILES['support_files']['error'][$docTypeId] == UPLOAD_ERR_OK
        ) {
            $fileName = $_FILES['support_files']['name'][$docTypeId];
            $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $newFileName = uniqid('doc_') . '.' . $ext;
            $targetPath = '../../documents/' . $newFileName;
            if (move_uploaded_file($_FILES['support_files']['tmp_name'][$docTypeId], $targetPath)) {
                $sql = "INSERT INTO {$siteprefix}doc_file (report_id, doc_typeid, filename, price, uploaded_at) 
                        VALUES ('$reportId', '$docTypeId', '$newFileName', '$supportPrices', NOW())";
                if (!mysqli_query($con, $sql)) {
                    $message .= "Error inserting new support doc: " . mysqli_error($con) . "<br>";
                    $hasError = true;
                }
            } else {
                $message .= "Failed to upload new support doc file.<br>";
                $hasError = true;
            }
        }
    }
}

// 4. Delete docs that are no longer selected
$docsToDelete = array_diff($existingDocs, $selectedDocs);
foreach ($docsToDelete as $docTypeId) {
    $docTypeId = mysqli_real_escape_string($con, $docTypeId);
    $delSql = "DELETE FROM {$siteprefix}doc_file WHERE report_id='$reportId' AND doc_typeid='$docTypeId'";
    if (!mysqli_query($con, $delSql)) {
        $message .= "Error deleting unselected support doc: " . mysqli_error($con) . "<br>";
        $hasError = true;
    }
}
}
    // Final update only if no error
    if (!$hasError) {
        $sql = "UPDATE ".$siteprefix."reports SET title='$title', description='$description', methodology='$methodology', use_case='$resource_type', category='$category', subcategory='$subcategory', pricing='$pricing', price='$price', tags='$tags', loyalty='$loyalty', user='$user_id', updated_date=current_timestamp(), status='$status' WHERE id = '$reportId'";
        if (mysqli_query($con, $sql)) {
            $message .= "Report updated successfully!";
            showSuccessModal('Processed', $message);
            header("refresh:2; url=models.php");
       
        } else {
            $message .= "Error updating report: " . mysqli_error($con);
            showErrorModal('Update Failed', $message);
            header("refresh:2;");
         
        }
    } else {
        showErrorModal('Error Occurred', $message);
        header("refresh:2;");
      
    }
}


//add dispute
if (isset($_POST['create_dispute'])){
    $category = $_POST['category'];
    $recipient_id = $_POST['seller'];
    $contract_reference = $_POST['order_id'];
    $issue = mysqli_real_escape_string($con, $_POST['issue']);
    $ticket_number = "TKT" . time(); // Unique Ticket ID
    $page="ticket.php?ticket_number=$ticket_number";
    $date = date('Y-m-d H:i:s');

    //

    // Insert dispute into DB
    $sql = "INSERT INTO ".$siteprefix."disputes (user_id, recipient_id, ticket_number, category, order_reference, issue) 
            VALUES ('$user_id', '$recipient_id','$ticket_number', '$category', '$contract_reference', '$issue')";
    
    $fileKey = 'evidence';
    $uploadDir = 'uploads/';
    $reportImages = handleMultipleFileUpload($fileKey, $uploadDir);
    $uploadedFiles = [];

     
    $sql2 = "INSERT INTO ".$siteprefix."dispute_messages (dispute_id, sender_id, message, file) 
    VALUES ('$ticket_number', '$user_id', '$issue', '')";
    mysqli_query($con, $sql2);
    
    
    if (mysqli_query($con, $sql)) {
        $dispute_id = mysqli_insert_id($con); // Get the ID of the just inserted dispute
        foreach ($reportImages as $image) {
            $sql = "INSERT INTO ".$siteprefix."evidence (dispute_id, file_path, uploaded_at) VALUES ('$dispute_id', '$image', NOW())";
            if (mysqli_query($con, $sql)) {
                $uploadedFiles[] = $image;
            } else {
                $message .= "Error: " . mysqli_error($con);
            }
        }

        $emailSubject="Dispute Submitted Successfully – Ticket No:$ticket_number";

        $emailMessage = "
        <p>Thank you for submitting your dispute. We’ve received your request and assigned it the following ticket number: <strong>$ticket_number</strong>.</p>
        <p>Our support team will review the details and get back to you as soon as possible.</p>
        <p>Visit <a href='$siteurl'>ProjectReportHub.ng</a> to track your dispute status or explore more resources.</p>
        ";
        $adminmessage = "A new dispute has been submitted ($ticket_number)";
        $link="ticket.php?ticket_number=$ticket_number";
        $msgtype='New Dispute';
        $message_status=1;
        $emailMessage_admin="<p>Hello Dear Admin,a new dispute has been submitted!</p>";
        $emailSubject_admin="New Dispute";
        insertadminAlert($con, $adminmessage, $link, $date, $msgtype, $message_status);
        sendEmail($email, $display_name, $siteName, $siteMail, $emailMessage, $emailSubject);
        sendEmail($siteMail, $adminName, $siteName, $siteMail, $emailMessage_admin, $emailSubject_admin);
    
            if($recipient_id){
            $rDetails = getUserDetails($con, $siteprefix, $recipient_id);
            $r_email = $rDetails['email'];
            $r_name = $rDetails['display_name'];
            $r_emailSubject="New Dispute ($ticket_number)";
            $r_emailMessage="<p>A new dispute has been submitted with you as the recipient. Login to your dashboard to check</p>";
           sendEmail($r_email, $r_name, $siteName, $siteMail, $r_emailMessage, $r_emailSubject);
           $message = "A new dispute has been submitted with you as the recipient: " . $ticket_number;
           $status=0;
           insertAlert($con, $recipient_id, $message, $date, $status);
        }

       $message= "Dispute submitted successfully. Ticket ID: " . $ticket_number;
       showSuccessModal('Success', $message);
       header("refresh:2; url=$page");
    } else {
       $message="Error: " . mysqli_error($con);
       showErrorModal('Oops', $message);
    }}


//withdrawwallet
if (isset($_POST['withdraw'])){
$date=$currentdatetime;
$bank=$_POST['bank'];
$bankname=$_POST['bankname'];
$bankno=$_POST['bankno'];
$amount=$_POST['amount'];
$status="pending";


$emailMessage="<p>We are writing to confirm that we have successfully received your withdrawal request in the amount of $sitecurrency$amount.<br>
Please note that your request is currently being processed and is expected to be completed within the next twenty-four (24) hours. Once the transaction has been finalized, you will receive a confirmation notification.<br>
Should you have any questions or require further assistance, please do not hesitate to contact our support team.<br>
Thank you for choosing our services.</p>";
$footer="<p>Warm regards,<br>
Ikechukwu Anaekwe<br>
Project Report Hub (Customer Support Team).</p>";

insertWithdraw($con, $user_id, $amount,$bank, $bankname, $bankno, $date, $status);
$emailSubject="Withdrawal Request - Recieved";
$emailMessage_admin="<p>A new withdrawal request has been recieved for ₦$amount. Please login into your dashboard to process it</p>";
$adminmessage = "New Withdrawal Request - &#8358;$amount";
$link="withdrawals.php";
$msgtype='New Withdrawal';
$message_status=1;
insertadminAlert($con, $adminmessage, $link, $date, $msgtype, $message_status); 
sendEmail($email, $display_name, $siteName, $siteMail, $emailMessage, $emailSubject);
sendEmail($siteMail, $adminName, $siteName, $siteMail, $emailMessage_admin, $emailSubject);
    
   
$statusAction="Successful";
$statusMessage="Withdrawal Request Sent Sucessfully!";
showSuccessModal($statusAction,$statusMessage);
header("Refresh: 4; url=wallet.php");
}
    //contact us
if(isset($_POST['contact'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    
    $emailMessage = "From: " . $name . "\nEmail: " . $email . "\nMessage:\n" . $message;
    sendEmail($sitemail, $sitename, $sitename, $sitemail, $emailMessage, $subject);
    
        $message='Message sent successfully. We will get back to you soon.';
        showSuccessModal('Success', $message);
        //$message='Failed to send message';
        //showErrorModal('Error', $message);
}


?>