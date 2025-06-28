<?php
// Query to count total users
$totalUsersQuery = "SELECT COUNT(*) AS total_users FROM ".$siteprefix."users WHERE type != 'admin'"; 
$totalUsersResult = mysqli_query($con, $totalUsersQuery);
$totalUsers = mysqli_fetch_assoc($totalUsersResult)['total_users'];

// Query to calculate total profit
$totalProfitQuery = "SELECT SUM(amount) AS total_profit FROM ".$siteprefix."profits";
$totalProfitResult = mysqli_query($con, $totalProfitQuery);
$totalProfit = mysqli_fetch_assoc($totalProfitResult)['total_profit'];

// Query to count total reports
$totalReportsQuery = "SELECT COUNT(*) AS total_reports FROM ".$siteprefix."reports";
$totalReportsResult = mysqli_query($con, $totalReportsQuery);
$totalReports = mysqli_fetch_assoc($totalReportsResult)['total_reports'];

// Query to count total sales (paid orders)
$totalSalesQuery = "SELECT COUNT(order_id) AS total_sales FROM ".$siteprefix."orders WHERE status = 'paid'";
$totalSalesResult = mysqli_query($con, $totalSalesQuery);
$totalSales = mysqli_fetch_assoc($totalSalesResult)['total_sales'];

// Query to fetch pending reports count
$pendingReportsQuery = "SELECT COUNT(*) AS count FROM " . $siteprefix . "reports WHERE status = 'pending'";
$pendingReportsResult = mysqli_query($con, $pendingReportsQuery);
$pendingReportsCount = mysqli_fetch_assoc($pendingReportsResult)['count'];

// Query to fetch pending payments count
$pendingPaymentsQuery = "SELECT COUNT(*) AS count FROM " . $siteprefix . "manual_payments WHERE status = 'pending'";
$pendingPaymentsResult = mysqli_query($con, $pendingPaymentsQuery);
$pendingPaymentsCount = mysqli_fetch_assoc($pendingPaymentsResult)['count'];

// Query to fetch pending payments count
$approvedPaymentsQuery = "SELECT COUNT(*) AS count FROM " . $siteprefix . "manual_payments WHERE status = 'approved'";
$approvedPaymentsResult = mysqli_query($con, $approvedPaymentsQuery);
$clearedOrdersCount = mysqli_fetch_assoc($approvedPaymentsResult)['count'];

// Query to fetch pending withdrawals count
$pendingWithdrawalsQuery = "SELECT COUNT(*) AS count FROM " . $siteprefix . "withdrawal WHERE status = 'pending'";
$pendingWithdrawalsResult = mysqli_query($con, $pendingWithdrawalsQuery);
$pendingWithdrawalsCount = mysqli_fetch_assoc($pendingWithdrawalsResult)['count'];

// Query to fetch pending disputes count
$pendingDisputesQuery = "SELECT COUNT(*) AS count FROM " . $siteprefix . "disputes WHERE status = 'pending'";
$pendingDisputesResult = mysqli_query($con, $pendingDisputesQuery);
$pendingDisputesCount = mysqli_fetch_assoc($pendingDisputesResult)['count'];


$sql = "SELECT * FROM  ".$siteprefix."alerts WHERE status='0' ORDER BY s DESC LIMIT 5";
$sql2 = mysqli_query($con,$sql);
$notification_count = mysqli_num_rows($sql2);

//read message

if (isset($_GET['action']) && $_GET['action'] == 'read-message') {
    $sql = "UPDATE ".$siteprefix."alerts SET status='1' WHERE status='0'";
    $sql2 = mysqli_query($con,$sql);
    $message="All notifications marked as read.";
    showToast($message);
    header("refresh:2; url=notifications.php");
}
if(isset($_POST['settings'])){
    $name = $_POST['site_name'];
    $keywords = $_POST['site_keywords'];
    $url = $_POST['site_url']; 
    $description = $_POST['site_description'];
    $email = $_POST['site_mail'];
    $number = $_POST['site_number'];
    $profilePicture = $_FILES['site_logo'];

    $site_bank= $_POST['site_bank'];
    $account_name= $_POST['account_name'];
    $account_number= $_POST['account_number'];
    $google= $_POST['google_map'];
    $com_fee= $_POST['com_fee'];
    $affiliate_percentage= $_POST['affiliate_percentage'];
    
    $uploadDir = '../../img/';
    $fileKey='site_logo';
    global $fileName;

    // Update profile picture if a new one is uploaded
    if (!empty($profilePicture)) {
        $logo = handleFileUpload($fileKey, $uploadDir, $fileName);
    } else {
        $logo = $siteimg; // Use the current picture  
    }

  
    $update = mysqli_query($con,"UPDATE " . $siteprefix . "site_settings SET site_name='$name',site_bank='$site_bank', account_name='$account_name', affliate_percentage='$affiliate_percentage', commision_fee='$com_fee', account_number='$account_number', google_map='$google',  site_logo='$logo',  site_keywords='$keywords', site_url='$url', site_description='$description', site_mail='$email', site_number='$number' WHERE s=1");


    if($update){
     $statusAction = "Successful";
    $statusMessage = "Settings Updated Successfully!";
    showSuccessModal2($statusAction, $statusMessage);
     header("refresh:2; url=settings.php");
    } else {
        $statusAction = "Oops!";
        $statusMessage = "An error has occurred!";
        showErrorModal2($statusAction, $statusMessage);
    }
}


//admin update profile
if(isset($_POST['update-profile'])){
    $fullName = htmlspecialchars($_POST['fullName']);
    $email = htmlspecialchars($_POST['email']);
    $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;
    $retypePassword = !empty($_POST['retypePassword']) ? $_POST['retypePassword'] : null;
    $oldPassword = htmlspecialchars($_POST['oldpassword']);
    $profilePicture = $_FILES['profilePicture']['name'];

    // Validate passwords match
    if ($password && $password !== $retypePassword) {
        $message= "Passwords do not match.";
    }

    // Validate old password
    $stmt = $con->prepare("SELECT password FROM ".$siteprefix."users WHERE s = ?");
    if ($stmt === false) {
        $message = "Error preparing statement: " . $con->error;
    } else {
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        if ($user === null || !checkPassword($oldPassword, $user['password'])) {
            $message = "Old password is incorrect.";
        }
    }

    $uploadDir = '../../uploads/';
    $fileKey='profilePicture';
    global $fileName;

    // Update profile picture if a new one is uploaded
    if (!empty($profilePicture)) {
        $profilePicture = handleFileUpload($fileKey, $uploadDir, $fileName);
    } else {
        $profilePicture = $profile_picture; // Use the current profile picture if no new one is uploaded
    }

    // Update user information in the database
    $query = "UPDATE ".$siteprefix."users SET display_name = ?, email = ?, profile_picture = ?";
    $params = [$fullName, $email, $profilePicture];

    if ($password) {
        $query .= ", password = ?";
        $params[] = $password;
    }

    $query .= " WHERE s = ?";
    $params[] = $user_id;

    $stmt = $con->prepare($query);
    $stmt->bind_param(str_repeat('s', count($params)), ...$params);
    if ($stmt->execute()) {
        $message= "Profile updated successfully.";
    } else {
        $message= "Error updating profile.";
    }
    showToast($message); 
    echo "<meta http-equiv='refresh' content='2'>";
}

// Suspend user
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['suspend_user'])) {
    $user_id = $_POST['user_id'];
    $duration_type = $_POST['duration_type']; // days, months, years
    $duration_value = (int)$_POST['duration_value'];
    $reason = mysqli_real_escape_string($con, $_POST['reason']);

    // Calculate the suspension end date
    $suspend_end_date = null;
    if ($duration_type === 'days') {
        $suspend_end_date = date('Y-m-d H:i:s', strtotime("+$duration_value days"));
    } elseif ($duration_type === 'months') {
        $suspend_end_date = date('Y-m-d H:i:s', strtotime("+$duration_value months"));
    } elseif ($duration_type === 'years') {
        $suspend_end_date = date('Y-m-d H:i:s', strtotime("+$duration_value years"));
    }

    // Update the user's status and suspension details
    $update_query = "UPDATE ".$siteprefix."users 
                     SET status = 'suspended' 
                     WHERE s = '$user_id'";
    if (mysqli_query($con, $update_query)) {
        // Insert suspension details into the suspend table
        $insert_query = "INSERT INTO " . $siteprefix . "suspend (user_id, suspend_date, suspend_reason, suspend_end) 
                         VALUES ('$user_id', NOW(), '$reason', '$suspend_end_date')";
        if (mysqli_query($con, $insert_query)) {
            // Fetch user details for the email
            $user_query = "SELECT email, display_name FROM ".$siteprefix."users WHERE s = '$user_id'";
            $user_result = mysqli_query($con, $user_query);
            if ($user_row = mysqli_fetch_assoc($user_result)) {
                $user_email = $user_row['email'];
                $user_name = $user_row['display_name'];

                // Prepare the email
                $emailSubject = "Account Suspension Notice ";
                $emailMessage = "
                    <p>We regret to inform you that your account on <strong>ProjectReportHub.ng</strong> has been temporarily suspended due to a violation of our platform’s terms of use and seller guidelines.</p>
                    <p>This action has been taken to maintain the integrity and quality of our marketplace for all users.</p>
                    <p><strong>Reason for Suspension:</strong> $reason</p>
                    <p><strong>Duration:</strong> $duration_value $duration_type</p>
                    <p>We kindly request that you review your account and take the necessary corrective steps. If you believe this suspension was made in error or would like to appeal the decision, please contact us at <a href='mailto:hello@projectreporthub.ng'>hello@projectreporthub.ng</a> with relevant details.</p>
                    <p>Your cooperation is appreciated, and we look forward to resolving this matter promptly.</p>
                   
                ";

                // Send the email
                if (sendEmail($user_email, $user_name, $siteName, $siteMail, $emailMessage, $emailSubject)) {
                    // Display success message
                    $message = "User suspended successfully, and an email notification has been sent.";
                    showSuccessModal('Processed', $message);
                    header("refresh:2; url=users.php");
                } else {
                    // Display error message for email failure
                    $message = "User suspended successfully, but the email notification could not be sent.";
                    showErrorModal('Email Error', $message);
                    header("refresh:2; url=users.php");
                }
            }
        } else {
            // Display error message for suspension table insertion failure
            $message = "An error occurred while saving suspension details. Please try again.";
            showErrorModal('Oops', $message);
            header("refresh:2; url=users.php");
        }
    } else {
        // Display error message for user status update failure
        $message = "An error occurred while updating the user's status. Please try again.";
        showErrorModal('Oops', $message);
        header("refresh:2; url=users.php");
    }
}


//delete comment
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_comment_id'])) {
    $delete_comment_id = intval($_POST['delete_comment_id']);
    deleteCommentAndReplies($delete_comment_id, $con);
    echo "<div class='alert alert-success'>Comment deleted</div>";
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
    $loyalty = isset($_POST['loyalty']) ? 1 : 0;
    $documentTypes = isset($_POST['documentSelect']) ? $_POST['documentSelect'] : [];
    $status = mysqli_real_escape_string($con, $_POST['status']);
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
    $uploadDir = '../../uploads/';
    $fileuploadDir = '../../documents/';
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
    $targetPath = '../../documents/' . $guidance_video;

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
            $targetPath = '../../documents/' . $newFileName;
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
    $loyalty = isset($_POST['loyalty']) ? 1 : 0;
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
    $uploadDir = '../../uploads/';
    $fileuploadDir = '../../documents/';
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
    $targetPath = '../../documents/' . $guidance_video;

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
            $targetPath = '../../documents/' . $newFileName;
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
    header("refresh:2; url=drafts.php");
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
    $loyalty = isset($_POST['loyalty']) ? 1 : 0;
    $documentTypes = isset($_POST['documentSelect']) ? $_POST['documentSelect'] : [];
    $status = $_POST['status'];
    $methodology =  mysqli_real_escape_string($con, $_POST['methodology']);
    $resource_type = implode(',',$_POST['resource_type']);
    $user_id = $_POST['user'];

    $siteline = $siteurl; // Replace with your site URL

    // Upload images
    $uploadDir = '../../uploads/';
    $fileuploadDir = '../../documents/';
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
            $targetPath = '../../documents/' . $guidance_video;

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
            header("refresh:2; url=reports.php");
       
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


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['addCategory'])) {
    // Sanitize inputs
    $categoryName = mysqli_real_escape_string($con, $_POST['categoryName']);
    $parentId = isset($_POST['parentId']) ? intval($_POST['parentId']) : 'NULL'; // Default to NULL if not provided

    // Generate base slug
    $baseSlug = strtolower(trim(preg_replace('/[^A-Za-z0-9]+/', '-', $categoryName), '-'));

    // Make slug unique
    $alt_title = $baseSlug;
    $counter = 1;
    while (true) {
        $query = "SELECT COUNT(*) AS count FROM " . $siteprefix . "categories WHERE slug = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("s", $alt_title);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row['count'] == 0) {
            break; // slug is unique
        }

        // Append counter to slug if not unique
        $alt_title = $baseSlug . '-' . $counter;
        $counter++;
    }

    // Check if category name already exists under same parent
    $checkQuery = "SELECT COUNT(*) AS count FROM {$siteprefix}categories WHERE parent_id <=> $parentId AND category_name = '$categoryName'";
    $checkResult = mysqli_query($con, $checkQuery);
    $row = mysqli_fetch_assoc($checkResult);

    if ($row['count'] > 0) {
        // Category already exists
        $statusAction = "Duplicate Category!";
        $statusMessage = "Category \"$categoryName\" already exists under the selected parent.";
        showErrorModal2($statusAction, $statusMessage);
    } else {
        // Insert category with unique slug
        $insertQuery = "INSERT INTO {$siteprefix}categories (parent_id, category_name, slug) VALUES ($parentId, '$categoryName', '$alt_title')";
        if (mysqli_query($con, $insertQuery)) {
            $statusAction = "Success!";
            $statusMessage = "Category \"$categoryName\" created successfully!";
            showSuccessModal2($statusAction, $statusMessage);
            header("refresh:2; url=add-category.php");
        } else {
            $statusAction = "Error!";
            $statusMessage = "Failed to create category: " . mysqli_error($con);
            showErrorModal2($statusAction, $statusMessage);
        }
    }
}

if (isset($_POST['update-category'])) {
    $ids = $_POST['ids'];
    $names = $_POST['category_names'];

    foreach ($ids as $index => $id) {
        $name = mysqli_real_escape_string($con, $names[$index]);
        $id = intval($id);
        $query = "UPDATE " . $siteprefix . "categories SET category_name = '$name' WHERE id = $id";
        mysqli_query($con, $query);
        if (mysqli_error($con)) {
            $statusAction = "Error!";
            $statusMessage = "Failed to update category with $name: " . mysqli_error($con);
            showErrorModal2($statusAction, $statusMessage);
            exit;
        }
    }
    $message = "Categories updated successfully!";
    showToast($message);
    header("refresh:2; url=categories.php");
} 


//edit subategory
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editSubCategory'])) {
    $parentId = $_POST['parentId'];
    $subCategoryName = trim($_POST['subCategoryName']);
    $subcategory_id = intval($_POST['subcategory_id']);

    if ($subCategoryName !== '') {
        $escapedName = mysqli_real_escape_string($con, $subCategoryName);

        // Get the existing sub-category info (name and slug)
        $query = "SELECT category_name, slug FROM {$siteprefix}categories WHERE id = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("i", $subcategory_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $oldSubName = $row['category_name'];
            $oldSlug = $row['slug'];

            // Check if a category with the same name already exists under the same parent except current subcategory
            $checkQuery = "SELECT id FROM {$siteprefix}categories 
                           WHERE category_name = ? 
                           AND " . ($parentId === 'NULL' ? "parent_id IS NULL" : "parent_id = ?") . " 
                           AND id != ?";
            
            if ($parentId === 'NULL') {
                $checkStmt = $con->prepare($checkQuery);
                $checkStmt->bind_param("si", $escapedName, $subcategory_id);
            } else {
                $parentIdInt = intval($parentId);
                $checkStmt = $con->prepare($checkQuery);
                $checkStmt->bind_param("sii", $escapedName, $parentIdInt, $subcategory_id);
            }
            $checkStmt->execute();
            $checkResult = $checkStmt->get_result();

            if ($checkResult->num_rows > 0) {
                $statusAction = "Duplicate!";
                $statusMessage = "A sub-category with the same name already exists under the selected parent category.";
                showErrorModal2($statusAction, $statusMessage);
                exit; // stop execution here
            }

            // If name changed, generate new slug
            if ($subCategoryName !== $oldSubName) {
                $baseSlug = strtolower(trim(preg_replace('/[^A-Za-z0-9]+/', '-', $subCategoryName), '-'));
                $altSlug = $baseSlug;
                $counter = 1;

                // Check slug uniqueness excluding current record
                while (true) {
                    $slugCheckQuery = "SELECT COUNT(*) AS count FROM {$siteprefix}categories WHERE slug = ? AND id != ?";
                    $slugCheckStmt = $con->prepare($slugCheckQuery);
                    $slugCheckStmt->bind_param("si", $altSlug, $subcategory_id);
                    $slugCheckStmt->execute();
                    $slugCheckResult = $slugCheckStmt->get_result();
                    $countRow = $slugCheckResult->fetch_assoc();

                    if ($countRow['count'] == 0) {
                        break; // unique slug found
                    }

                    $altSlug = $baseSlug . '-' . $counter;
                    $counter++;
                }

                // Update name, parent_id, and slug
                $updateQuery = "UPDATE {$siteprefix}categories 
                                SET category_name = ?, 
                                    parent_id = " . ($parentId === 'NULL' ? "NULL" : "?") . ", 
                                    slug = ? 
                                WHERE id = ?";
                if ($parentId === 'NULL') {
                    $updateStmt = $con->prepare($updateQuery);
                    $updateStmt->bind_param("ssi", $escapedName, $altSlug, $subcategory_id);
                } else {
                    $updateStmt = $con->prepare($updateQuery);
                    $parentIdInt = intval($parentId);
                    $updateStmt->bind_param("sisi", $escapedName, $parentIdInt, $altSlug, $subcategory_id);
                }

            } else {
                // Name not changed, only update name and parent_id (slug remains the same)
                $updateQuery = "UPDATE {$siteprefix}categories 
                                SET category_name = ?, 
                                    parent_id = " . ($parentId === 'NULL' ? "NULL" : "?") . " 
                                WHERE id = ?";
                if ($parentId === 'NULL') {
                    $updateStmt = $con->prepare($updateQuery);
                    $updateStmt->bind_param("si", $escapedName, $subcategory_id);
                } else {
                    $updateStmt = $con->prepare($updateQuery);
                    $parentIdInt = intval($parentId);
                    $updateStmt->bind_param("sii", $escapedName, $parentIdInt, $subcategory_id);
                }
            }

            if ($updateStmt->execute()) {
                $statusAction = "Success!";
                $statusMessage = "Sub-category \"$subCategoryName\" updated successfully.";
                showSuccessModal2($statusAction, $statusMessage);
                header("refresh:2;");
             
            } else {
                $statusAction = "Error!";
                $statusMessage = "Failed to update sub-category: " . $updateStmt->error;
                showErrorModal2($statusAction, $statusMessage);
              
            }

        } else {
            $statusAction = "Error!";
            $statusMessage = "Sub-category not found.";
            showErrorModal2($statusAction, $statusMessage);
            exit;
        }
    } else {
        $statusAction = "Warning!";
        $statusMessage = "Please provide a valid sub-category name.";
        showErrorModal2($statusAction, $statusMessage);
        exit;
    }
}



//edit category
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editCategory'])) {
    $category_id = intval($_POST['category_id']);
    $new_category_name = trim($_POST['category_name']);

    if ($category_id > 0 && $new_category_name !== '') {
        // First get the existing category info (name and slug)
        $query = "SELECT category_name, slug FROM {$siteprefix}categories WHERE id = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("i", $category_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $old_category_name = $row['category_name'];
            $old_slug = $row['slug'];

            // If category name changed, regenerate slug
            if ($new_category_name !== $old_category_name) {
                // Sanitize new category name
                $category_name_safe = mysqli_real_escape_string($con, $new_category_name);

                // Generate base slug
                $baseSlug = strtolower(trim(preg_replace('/[^A-Za-z0-9]+/', '-', $new_category_name), '-'));

                // Ensure unique slug (exclude current id)
                $alt_slug = $baseSlug;
                $counter = 1;
                while (true) {
                    $checkQuery = "SELECT COUNT(*) AS count FROM {$siteprefix}categories WHERE slug = ? AND id != ?";
                    $checkStmt = $con->prepare($checkQuery);
                    $checkStmt->bind_param("si", $alt_slug, $category_id);
                    $checkStmt->execute();
                    $checkResult = $checkStmt->get_result();
                    $countRow = $checkResult->fetch_assoc();

                    if ($countRow['count'] == 0) {
                        break; // unique slug found
                    }

                    $alt_slug = $baseSlug . '-' . $counter;
                    $counter++;
                }

                // Update both category_name and slug
                $updateQuery = "UPDATE {$siteprefix}categories SET category_name = ?, slug = ? WHERE id = ?";
                $updateStmt = $con->prepare($updateQuery);
                $updateStmt->bind_param("ssi", $category_name_safe, $alt_slug, $category_id);

                if ($updateStmt->execute()) {
                    $statusAction = "Success!";
                    $statusMessage = "Category \"$new_category_name\" and slug updated successfully.";
                    showSuccessModal2($statusAction, $statusMessage);
                    header("refresh:2; url=manage-category.php");
                } else {
                    $statusAction = "Error!";
                    $statusMessage = "Failed to update category: " . $updateStmt->error;
                    showErrorModal2($statusAction, $statusMessage);
                }
            } else {
                // If category name NOT changed, do nothing or just show success without updating slug
                $statusAction = "No Change!";
                $statusMessage = "Category name unchanged, slug remains the same.";
                showSuccessModal2($statusAction, $statusMessage);
                header("refresh:2; url=manage-category.php");
            }
        } else {
            $statusAction = "Error!";
            $statusMessage = "Category not found.";
            showErrorModal2($statusAction, $statusMessage);
        }
    } else {
        $statusAction = "Warning!";
        $statusMessage = "Please provide a valid category name.";
        showErrorModal2($statusAction, $statusMessage);
    }
}


//ADD SUBCATEGORY
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['addSubCategory'])) {
    // Sanitize and validate inputs
    $parentId = intval($_POST['parentId']); // ensure numeric value
    $subCategoryName = mysqli_real_escape_string($con, trim($_POST['subCategoryName'])); // clean input

    // Generate base slug from sub-category name
    $baseSlug = strtolower(trim(preg_replace('/[^A-Za-z0-9]+/', '-', $subCategoryName), '-'));

    // Ensure slug is unique
    $alt_title = $baseSlug;
    $counter = 1;
    while (true) {
        $query = "SELECT COUNT(*) AS count FROM {$siteprefix}categories WHERE slug = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("s", $alt_title);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row['count'] == 0) {
            break; // slug is unique
        }

        $alt_title = $baseSlug . '-' . $counter;
        $counter++;
    }

    // Check for duplicate sub-category under the same parent (based on name)
    $checkQuery = "SELECT COUNT(*) AS count FROM {$siteprefix}categories WHERE parent_id = $parentId AND category_name = '$subCategoryName'";
    $checkResult = mysqli_query($con, $checkQuery);

    if ($checkResult) {
        $row = mysqli_fetch_assoc($checkResult);

        if ($row['count'] > 0) {
            $statusAction = "Duplicate Sub-Category!";
            $statusMessage = "Sub-category \"$subCategoryName\" already exists under the selected category.";
            showErrorModal2($statusAction, $statusMessage);
        } else {
            // Insert sub-category with unique slug
            $insertQuery = "INSERT INTO {$siteprefix}categories (parent_id, category_name, slug) VALUES ($parentId, '$subCategoryName', '$alt_title')";
            if (mysqli_query($con, $insertQuery)) {
                $statusAction = "Success!";
                $statusMessage = "Sub-category \"$subCategoryName\" added successfully.";
                showSuccessModal2($statusAction, $statusMessage);
                header("refresh:2; url=add-subcategory.php");
            } else {
                $statusAction = "Error!";
                $statusMessage = "Failed to add sub-category: " . mysqli_error($con);
                showErrorModal2($statusAction, $statusMessage);
            }
        }
    } else {
        $statusAction = "Query Failed!";
        $statusMessage = "Could not check for duplicates: " . mysqli_error($con);
        showErrorModal2($statusAction, $statusMessage);
    }
}


//delete-category
if (isset($_GET['action']) && $_GET['action'] == 'deletecategory') {
    $table = $_GET['table'];
    $item = $_GET['item'];
    $page = $_GET['page'];

    // Delete subcategories first
    $sqlSub = "DELETE FROM {$siteprefix}{$table} WHERE parent_id = ?";
    $stmtSub = $con->prepare($sqlSub);
    $stmtSub->bind_param("i", $item);
    $stmtSub->execute();

    // Delete main category
    $sqlMain = "DELETE FROM {$siteprefix}{$table} WHERE id = ?";
    $stmtMain = $con->prepare($sqlMain);
    $stmtMain->bind_param("i", $item);

    if ($stmtMain->execute()) {
        $message = "Category and all its subcategories deleted successfully.";
    } else {
        $message = "Failed to delete the category: " . $stmtMain->error;
    }

    showToast($message);
    header("refresh:1; url=$page");
}


// Approve payment
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['approve_payment'])) {
    $order_id = mysqli_real_escape_string($con, $_POST['order_id']);
    $user_id = mysqli_real_escape_string($con, $_POST['user_id']);
    $amount = mysqli_real_escape_string($con, $_POST['amount']);
    $date = date('Y-m-d H:i:s');

    $attachments = [];
    $attachmentLinks = [];

    // Approve manual payment
    $update_query = "UPDATE {$siteprefix}manual_payments 
                     SET status = 'approved', rejection_reason = '' 
                     WHERE order_id = '$order_id'";
    if (!mysqli_query($con, $update_query)) {
        showErrorModal('Oops', "Error updating payment status.");
        
    }

   
   // Update order status
$updates_query = "UPDATE {$siteprefix}orders 
SET status = 'paid', total_amount = '$amount', date = '$date' 
WHERE order_id = '$order_id'";

if (!mysqli_query($con, $updates_query)) {
    showErrorModal('Oops', "Error updating order status: " . mysqli_error($con));
    exit;
}

    // Fetch buyer details
    $buyer_result = mysqli_query($con, "SELECT email, display_name FROM {$siteprefix}users WHERE s = '$user_id'");
    $buyer = mysqli_fetch_assoc($buyer_result);
    $email = $buyer['email'];
    $username = $buyer['display_name'];

    // Fetch order items
    $items_result = mysqli_query($con, "
        SELECT oi.*, r.title AS resource_title, rf.title AS file_path 
        FROM {$siteprefix}order_items oi
        JOIN {$siteprefix}reports r ON oi.report_id = r.id
        LEFT JOIN {$siteprefix}reports_files rf ON r.id = rf.report_id
        WHERE oi.order_id = '$order_id'
    ");

    $tableRows = "";

    while ($item = mysqli_fetch_assoc($items_result)) {
        $report_id = $item['report_id'];
        $resourceTitle = $item['resource_title'];
        $file_path = $item['file_path'];
        $affiliate_id = $item['affiliate_id'];
        $price = $item['price'];
        $item_row_id = $item['s'];

        // Prepare download attachment
        if (!empty($file_path) && file_exists($file_path)) {
            $attachments[] = $file_path;
            $attachmentLinks[] = $siteurl . $documentPath . $file_path;
        }

        // Handle affiliate
        if ($affiliate_id != 0) {
            $aff_result = mysqli_query($con, "SELECT * FROM {$siteprefix}users WHERE affliate = '$affiliate_id'");
            while ($row_aff = mysqli_fetch_assoc($aff_result)) {
                $affiliate_user_id = $row_aff['s'];
                $affiliate_amount = $price * ($affiliate_percentage / 100);

                mysqli_query($con, "UPDATE {$siteprefix}users SET wallet = wallet + $affiliate_amount WHERE affliate = '$affiliate_id'");
                insertAffliatePurchase($con, $item_row_id, $affiliate_amount, $affiliate_id,$date);
                insertWallet($con, $affiliate_user_id, $affiliate_amount, 'credit', "Affiliate Earnings from Order ID: $order_id", $date);
                insertadminAlert($con, $affiliate_user_id, "You have earned $sitecurrency$affiliate_amount from Order ID: $order_id", "wallet.php", $date, "wallet", 0);
            }
        }

        // Handle seller
        $seller_result = mysqli_query($con, "
            SELECT u.s AS user, u.*, r.title AS report_title 
            FROM {$siteprefix}users u 
            JOIN {$siteprefix}reports r ON r.user = u.s 
            WHERE r.id = '$report_id'
        ");

        while ($row_seller = mysqli_fetch_assoc($seller_result)) {
            $seller_id = $row_seller['user'];
            $vendorEmail = $row_seller['email'];
            $vendorName = $row_seller['display_name'];
            $sellertype = $row_seller['type'];

            $admin_commission = ($sellertype === "user") ? $price * ($escrowfee / 100) : $price;
            $seller_amount = $price - $admin_commission;

            mysqli_query($con, "INSERT INTO {$siteprefix}profits (amount, report_id, order_id, type, date)
                                VALUES ('$admin_commission', '$report_id', '$order_id', 'Order Payment', '$date')");
            insertadminAlert($con, "Admin Commission of $sitecurrency$admin_commission from Order ID: $order_id", "profits.php", $date, "profits", 0);

            mysqli_query($con, "UPDATE {$siteprefix}users SET wallet = wallet + $seller_amount WHERE s = '$seller_id'");
            insertWallet($con, $seller_id, $seller_amount, 'credit', "Payment from Order ID: $order_id", $date);
            insertAlert($con, $seller_id, "You have received $sitecurrency$seller_amount from Order ID: $order_id", $date, 0);

            // Email seller
            $emailSubject = "New Sale on Project Report Hub. Let's Keep the Momentum Going!";
            $emailMessage = "
                <p>Great news! A new sale has just been made on $siteurl.</p>
                <p><strong>Title of Resource:</strong> $resourceTitle</p>
                <p><strong>Price:</strong> $sitecurrencyCode.$price</p>
                <p><strong>Earning:</strong> $sitecurrencyCode.$seller_amount</p>
                <p>If you haven’t updated your listings recently, now is a great time to refresh, promote, or add more resources.</p>";
            sendEmail($vendorEmail, $vendorName, $siteName, $siteMail, $emailMessage, $emailSubject);
        }

        // Add to buyer email table
        $tableRows .= "
            <tr>
                <td>$resourceTitle</td>
                <td><a href='{$siteurl}{$documentPath}{$file_path}'><button class='bg-primary'>Download</button></a></td>
            </tr>";
    }

    // Send confirmation email to buyer
    $emailSubject = "Order Confirmation";
    $emailMessage = "
       <p>Thank you for your order. Below are the resources you purchased:</p>
<table border='1' cellpadding='10' cellspacing='0' style='border-collapse: collapse; width: 100%;'>
    <thead>
        <tr>
            <th style='color: #f8f9fa; text-align: left;'>Report Title</th>
            <th style='color: #f8f9fa; text-align: left;'>Download Link</th>
        </tr>
    </thead>
   
            <tbody>$tableRows</tbody>
</table>
<p>You can also access your purchased reports from your profile on our website.</p>
<p>Feel free to visit our website for more information, updates, or to explore additional services.</p>";

    sendEmail2($email, $username, $siteName, $siteMail, $emailMessage, $emailSubject, $attachmentLinks);

    showSuccessModal('Processed', "Payment for Order ID $order_id has been approved successfully.");
    header("refresh:2;");
}


// manual payment rejection
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['reject_payment'])) {
    $order_id = mysqli_real_escape_string($con, $_POST['order_id']);
    $user_id = mysqli_real_escape_string($con, $_POST['user_id']);
    $rejection_reason = mysqli_real_escape_string($con, $_POST['rejection_reason']);
    $date = date('Y-m-d H:i:s');

    // Update the payment status to "payment resend" and store the rejection reason
    $update_query = "UPDATE " . $siteprefix . "manual_payments SET status = 'payment resend', rejection_reason = '$rejection_reason'  WHERE order_id = '$order_id'";
    if (mysqli_query($con, $update_query)) {
        // Fetch user details
        $user_query = "SELECT display_name, email FROM " . $siteprefix . "users WHERE s = '$user_id'";
        $user_result = mysqli_query($con, $user_query);

        if ($user_result && mysqli_num_rows($user_result) > 0) {
            $user = mysqli_fetch_assoc($user_result);
            $user_name = $user['display_name'];
            $user_email = $user['email'];

            // Send email to the user
            $emailSubject = "Payment Rejected for Order ID  $order_id";
            $emailMessage = "
                <p>We hope this message finds you well.</p>
                <p>Unfortunately, your payment for Order ID: <strong>$order_id</strong> has been rejected for the following reason:</p>
                <p><em>\"$rejection_reason\"</em></p>
                <p>To proceed with your order, kindly resubmit a valid payment proof at your earliest convenience.</p>
                <p>Thank you for your understanding. If you have any questions, feel free to contact our support team.</p> ";

            sendEmail($user_email, $user_name, $siteName, $siteMail, $emailMessage, $emailSubject);
        }

        // Display success message
        $message = "Payment for Order ID $order_id has been rejected successfully.";
        showToast($message); // Use showToast to display the message
        header("refresh:2;");
       
    } else {
        // Display error message
        $message = "An error occurred while rejecting the payment. Please try again.";
        showErrorModal('Oops', $message); // Use showErrorModal to display the error
        header("refresh:2;");
       
    }
}
//sub category
if (isset($_GET['action']) && $_GET['action'] == 'deletesubcategory') {
    $table = $_GET['table'];
    $item = $_GET['item'];
    $page = $_GET['page'];
    
    if (deletecategoryRecord($table, $item)) {
        $message="Subcategory deleted successfully.";
    } else {
         $message="Failed to delete the Subcategory.";
    }

    showToast($message);
    header("refresh:1; url=$page");
}


if(isset($_POST['approvewithdraw'])){
    $action=$_POST['approvewithdraw'];
    $therow=$_POST['therow'];
    $user=$_POST['user'];
    $date = date('Y-m-d H:i:s');
    
    $sql = "SELECT * FROM " . $siteprefix . "withdrawal WHERE s = '$therow'";
    $sql2 = mysqli_query($con, $sql);
    while ($insertedRecord = mysqli_fetch_array($sql2)) {
            $amount = $insertedRecord['amount'];
            $bank = $insertedRecord['bank'];
            $bankname = $insertedRecord['bank_name'];
            $bankno = $insertedRecord['bank_number'];
            $thedate = formatDateTime($insertedRecord['date']);
        }
        
    $sql = "SELECT * FROM  ".$siteprefix."users WHERE s='$user'";
    $result = mysqli_query($con, $sql);
    while ($insertedRecord = mysqli_fetch_array($result)) {
            $host_mail = $insertedRecord['email'];
            $host_name = $insertedRecord['display_name'];
            $thecurrency = $sitecurrency;
            $host_phone= $insertedRecord['mobile_number'];}
            
            
    $message_status = 1;
    $siteName = $sitename;
    $siteMail = $sitemail;
    $vendorEmail = $host_mail;
    $vendorName = $host_name;
    $currency = convertHtmlEntities($thecurrency);
    
    $submit = mysqli_query($con, "UPDATE ".$siteprefix."withdrawal SET status='paid' WHERE s = '$therow'") or die('Could not connect: ' . mysqli_error($con));
    $emailSubject="Withdrawal Request Paid ($currency$amount)";
    $vendor_emailMessage="Your withdrawal requested made on $thedate for an amount of $currency$amount has been paid to your account<br> $bank | $bankno | $bankname.";
    $message = "Your withdrawal requested made on $thedate for an amount of $thecurrency$amount has been paid ";
    
    
    $statusAction="Successful";
    $statusMessage="You have successfully marked this payment as paid";   
    sendEmail($vendorEmail, $vendorName, $siteName, $siteMail, $vendor_emailMessage, $emailSubject);
    insertAlert($con, $user, $message, $date, $message_status);  
    showSuccessModal($statusAction,$statusMessage);
    header('Refresh:3; url=' . $_SERVER['REQUEST_URI']);
    
    
    }


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_profile_admin'])) {

    $user_id = mysqli_real_escape_string($con, $_POST['user_id']);

    // Check if company or individual
    $isCompany = isset($_POST['company-name']) && !empty($_POST['company-name']);

    // Common fields
  
    $status = mysqli_real_escape_string($con, $_POST['status']);
    $specialization = mysqli_real_escape_string($con, $_POST['category'] ?? '');
    $designation = mysqli_real_escape_string($con, $_POST['designation'] ?? '');
    $biography = mysqli_real_escape_string($con, $_POST['biography'] ?? '');
    $seller = isset($_POST['seller']) ? 1 : 0;

    // Bank/Social fields
    $bank_name = mysqli_real_escape_string($con, $_POST['bank-name'] ?? '');
    $bank_accname = mysqli_real_escape_string($con, $_POST['account-name'] ?? '');
    $bank_number = mysqli_real_escape_string($con, $_POST['account-number'] ?? '');
    $branch_name = mysqli_real_escape_string($con, $_POST['branch-name'] ?? '');
    $account_type = mysqli_real_escape_string($con, $_POST['account-type'] ?? '');
    $aba_ach  = mysqli_real_escape_string($con, $_POST['aba-ach'] ?? '');
    $sort_code = mysqli_real_escape_string($con, $_POST['sort-code'] ?? '');
    $ifsc_code = mysqli_real_escape_string($con, $_POST['ifsc-code'] ?? '');
    $iban = mysqli_real_escape_string($con, $_POST['iban'] ?? '');
    $swift_bic = mysqli_real_escape_string($con, $_POST['swift-bic'] ?? '');
    $facebook = mysqli_real_escape_string($con, $_POST['facebook'] ?? '');
    $twitter = mysqli_real_escape_string($con, $_POST['twitter'] ?? '');
    $instagram = mysqli_real_escape_string($con, $_POST['instagram'] ?? '');
    $linkedln = mysqli_real_escape_string($con, $_POST['linkedin'] ?? '');
    $kin_name = mysqli_real_escape_string($con, $_POST['kin_name'] ?? '');
    $kin_number = mysqli_real_escape_string($con, $_POST['kin_number'] ?? '');
    $kin_email = mysqli_real_escape_string($con, $_POST['kin_email'] ?? '');
    $kin_relationship = mysqli_real_escape_string($con, $_POST['kin_relationship'] ?? '');

    // Profile picture upload
    $uploadDir = 'uploads/';
    $profilePicture = '';
    $companyProfilePicture = '';

    if ($isCompany) {
        // Company profile picture
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
        // Individual profile picture
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

    if ($isCompany) {
        // Company fields
          $email = mysqli_real_escape_string($con, $_POST['company_email']);
        $company_name = mysqli_real_escape_string($con, $_POST['company-name']);
        $display_name = mysqli_real_escape_string($con, $_POST['company-display-name'] ?? '');
        $address = mysqli_real_escape_string($con, $_POST['comaddress'] ?? '');
        $company_profile = mysqli_real_escape_string($con, $_POST['comabout-me'] ?? '');
        $country = mysqli_real_escape_string($con, $_POST['country'] ?? '');
        $mobile_number = mysqli_real_escape_string($con, $_POST['company_phone'] ?? '');
        $title = '';
        $first_name = '';
        $middle_name = '';
        $last_name = '';
        $gender = '';
        $update_query = "
            UPDATE {$siteprefix}users 
            SET 
                first_name = '$first_name',
                middle_name = '$middle_name',
                last_name = '$last_name',
                title = '$title',
                display_name = '$display_name',
                company_name = '$company_name',
                company_profile = '$company_profile',
                profile_picture = '$companyProfilePicture',
                country = '$country',
                email = '$email',
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
                kin_relationship = '$kin_relationship',
                biography = '$biography',
                seller = '$seller',
                status = '$status'
            WHERE s = '$user_id'
        ";
    } else {
        // Individual fields
        $company_name = '';
        $display_name = '';
          $email = mysqli_real_escape_string($con, $_POST['email']);
        $address = mysqli_real_escape_string($con, $_POST['address'] ?? '');
        $company_profile = '';
        $country = '';
        $mobile_number = mysqli_real_escape_string($con, $_POST['mobile_number'] ?? '');
        $title = mysqli_real_escape_string($con, $_POST['title'] ?? '');
        $first_name = mysqli_real_escape_string($con, $_POST['first_name'] ?? '');
        $middle_name = mysqli_real_escape_string($con, $_POST['middle_name'] ?? '');
        $last_name = mysqli_real_escape_string($con, $_POST['last_name'] ?? '');
        $gender = mysqli_real_escape_string($con, $_POST['gender'] ?? '');
        $update_query = "
            UPDATE {$siteprefix}users 
            SET 
                first_name = '$first_name',
                middle_name = '$middle_name',
                last_name = '$last_name',
                title = '$title',
                display_name = '$display_name',
                company_name = '$company_name',
                company_profile = '$company_profile',
                profile_picture = '$profilePicture',
                country = '$country',
                email = '$email',
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
                kin_relationship = '$kin_relationship',
                biography = '$biography',
                seller = '$seller',
                status = '$status'
            WHERE s = '$user_id'
        ";
    }

    if (mysqli_query($con, $update_query)) {
        showSuccessModal("Success!", "Profile updated successfully!");
        header("refresh:1; url=edit-user.php?user=$user_id");
        exit;
    } else {
        showErrorModal("Error!", "Failed to update profile: " . mysqli_error($con));
    }
}

//update plans
if (isset($_POST['updatePlan'])) {
    $plan_id = $_POST['id'];
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $price = $_POST['price'];
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $discount = $_POST['discount'];
    $downloads = $_POST['downloads'];
    $duration = $_POST['planDuration'];
    $durationCount = $_POST['durationCount'];
    $status = $_POST['status'];

    // Handle benefits checkboxes
    $benefits = isset($_POST['benefits']) ? implode(", ", $_POST['benefits']) : "";

    // Image Upload Settings
    $uploadDir = '../../uploads/';
    $allowedImageTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg', 'image/webp'];
    $fileKey = 'planImage';
    $uploadedImage = "";
    $message = "";

    // Check if an image is uploaded
    if (!empty($_FILES[$fileKey]['name'])) {
        $fileType = mime_content_type($_FILES[$fileKey]['tmp_name']);
        if (in_array($fileType, $allowedImageTypes)) {
            $fileName = uniqid() . '_' . basename($_FILES[$fileKey]['name']);
            $fileName = preg_replace("/[^a-zA-Z0-9\._-]/", "", $fileName); // Sanitize file name
            $filePath = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES[$fileKey]['tmp_name'], $filePath)) {
                $uploadedImage = $fileName;
            } else {
                $message .= "Error uploading image.<br>";
            }
        } else {
            $message .= "Invalid file type (Only JPG, PNG, GIF, WEBP allowed).<br>";
        }
    }

    // Prepare the update query
    $query = "UPDATE " . $siteprefix . "subscription_plans 
              SET name='$name', price='$price', description='$description', discount='$discount', 
                  downloads='$downloads', duration='$duration', no_of_duration='$durationCount', 
                  status='$status', benefits='$benefits'";

    // Only update the image if a new one was uploaded
    if (!empty($uploadedImage)) {
        $query .= ", image='$uploadedImage'";
    }

    $query .= " WHERE s='$plan_id'";

    // Execute the query
    if (mysqli_query($con, $query)) {
        $message = "Plan updated successfully!";
        showSuccessModal('Processed', $message);
        header("refresh:1; url=edit-plan.php");
    } else {
        $message = "Update failed: " . mysqli_error($con);
        showErrorModal('Oops', $message);
        header("refresh:2; url=edit-plan.php");
        exit;
    }
}

//delete-plans
if (isset($_GET['action']) && $_GET['action'] == 'deleteplans') {
    $table = $_GET['table'];
    $item = $_GET['item'];
    $page = $_GET['page'];
    
    if (deleteRecord($table, $item)) {
        $message="Record deleted successfully.";
    } else {
         $message="Failed to delete the record.";
    }

    showToast($message);
    header("refresh:1; url=$page");
}


//send message
if (isset($_POST['sendmessage'])) {
    $subject = htmlspecialchars(trim($_POST['title']), ENT_QUOTES, 'UTF-8');
    $content = trim($_POST['content']);
    $recipientSelection = isset($_POST['user']) ? (array)$_POST['user'] : [];
    // Initialize recipient list and names
    $recipients = [];
    $recipientNames = [];
    $query = '';    

    // Handle recipient selection
    if (in_array('all', $recipientSelection)) {
        // Query all users excluding admins
        $query = "SELECT email, display_name FROM " . $siteprefix . "users WHERE type != 'admin'";
    } elseif (in_array('affiliate', $recipientSelection)) {
        // Query instructors only
        $query = "SELECT email, display_name FROM " . $siteprefix . "users WHERE type = 'affiliate'";
    } elseif (in_array('user', $recipientSelection)) {
        // Query regular users only
        $query = "SELECT email, display_name FROM " . $siteprefix . "users WHERE type = 'user'";
    } elseif (in_array('buyer', $recipientSelection)) {
        // Query regular users only
        $query = "SELECT email, display_name FROM " . $siteprefix . "users WHERE type = 'user' AND seller ='0'";
    }elseif (in_array('seller', $recipientSelection)) {
        // Query regular users only
        $query = "SELECT email, display_name FROM " . $siteprefix . "users WHERE type = 'user' AND seller ='1'";
    } else {
        // Add specific user emails
        foreach ($recipientSelection as $email) {
            $email = filter_var($email, FILTER_SANITIZE_EMAIL);
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                // Fetch name for individual users
                $individualQuery = "SELECT display_name FROM " . $siteprefix . "users WHERE email = '$email'";
                $result = mysqli_query($con, $individualQuery);
                if ($result && $row = mysqli_fetch_assoc($result)) {
                    $recipients[] = $email;
                    $recipientNames[$email] = htmlspecialchars($row['display_name'], ENT_QUOTES, 'UTF-8');
                } else {
                    $recipients[] = $email;
                    $recipientNames[$email] = 'Valued User'; // Default name
                }
            }
        }
    }

    // If a query is needed for group selections, execute and fetch emails and names
    if (!empty($query)) {
        $result = mysqli_query($con, $query);
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $email = $row['email'];
                $name = htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8');
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $recipients[] = $email;
                    $recipientNames[$email] = $name;
                }
            }
        }
    }

    // Remove duplicates
    $recipients = array_unique($recipients);

    // Send emails
    foreach ($recipients as $email) {
        $name = $recipientNames[$email] ?? 'Valued User'; // Default to "Valued User" if no name
        $personalizedContent = str_replace('{{name}}', $name, $content); // Replace {{name}} in content

        if (sendEmail($email, $name, $siteName, $siteMail, $personalizedContent, $subject)) {
            $message = "Message sent to $name ($email)";
            showToast($message);
        } else {
            $statusAction="Failed";
            $message = "Failed to send message to $name ($email)";
            showErrorModal2($statusAction, $message);
        }
    }
}


//send-message
 if (isset($_POST['send_dispute_message'])) {
    $dispute_id = $_POST['dispute_id'];
    $sender_id = $user_id; // Assume logged-in user
    $message = mysqli_real_escape_string($con, $_POST['message']);
    $page = "ticket.php?ticket_number=$dispute_id";
    $new_status = "awaiting-response";

    $fileKey = 'attachment';
    $uploadDir = '../../uploads/';
    $reportImages = handleMultipleFileUpload($fileKey, $uploadDir);
    $uploadedFiles =  implode(', ', $reportImages);
    if (empty($_FILES[$fileKey]['name'][0])) {
        $uploadedFiles = '';
    }

      //get dispute details
      $sql = "SELECT * FROM ".$siteprefix."disputes WHERE ticket_number='$dispute_id'";
      $sql2 = mysqli_query($con,$sql);
      $row = mysqli_fetch_array($sql2);
      $ticket_number = $row['ticket_number'];
      $recipient_id = $row['recipient_id'];
      $sender_id = $row['user_id'];

    
    $sql = "INSERT INTO ".$siteprefix."dispute_messages (dispute_id, sender_id, message, file) 
        VALUES ('$dispute_id', '$user_id', '$message', '$uploadedFiles')";
    if (mysqli_query($con, $sql)) {
    // Then call the function where needed:
    $emailSubject="Dispute Updated($ticket_number)";
    $emailMessage="<p>This dispute status has been updated to $status</p>";
    $message = "Dispute status updated to $status: " . $ticket_number;
    $status=0;
    $date = date("Y-m-d H:i:s");

    //notify sender and if recipient exists
    $sDetails = getUserDetails($con, $siteprefix, $sender_id);
    $s_email = $sDetails['email'];
    $s_name = $sDetails['display_name'];
    //sendEmail($s_email, $s_name, $siteName, $siteMail, $emailMessage, $emailSubject);
    insertAlert($con, $sender_id, $message, $date, $status);

    if($recipient_id){
        $rDetails = getUserDetails($con, $siteprefix, $recipient_id);
        $r_email = $rDetails['email'];
        $r_name = $rDetails['display_name'];
       //sendEmail($r_email, $r_name, $siteName, $siteMail, $emailMessage, $emailSubject);
       insertAlert($con, $recipient_id, $message, $date, $status);
    }
    updateDisputeStatus($con, $siteprefix, $dispute_id, $new_status);
    showToast("Message sent successfully!");

    } else {
    $message = "Error: " . mysqli_error($con);
    showErrorModal('Oops', $message);
    }
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
    header("refresh:1; url=$page");
}
//delete 
  if (isset($_GET['action']) && $_GET['action'] == 'deleteforum') {
    $table = $_GET['table'];
    $item = $_GET['item'];
    $page = $_GET['page'];
    
    if (deleteRecord($table, $item)) {
        $message="Post deleted successfully.";
    } else {
         $message="Failed to delete the post.";
    }

    showToast($message);
    header("refresh:1; url=$page");
}


// Add forum topic
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['addforum'])) {
    $user_id = mysqli_real_escape_string($con, $_POST['user']);
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $article = mysqli_real_escape_string($con, $_POST['article']);
    $categories = isset($_POST['category']) ? implode(',', array_map('intval', $_POST['category'])) : '';
    $created_at = date('Y-m-d H:i:s');
    $views = 0;


    // Replace spaces with hyphens and convert to lowercase
$baseSlug = strtolower(trim(preg_replace('/[^a-z0-9]+/i', '-', $title), '-'));


// Start with the cleaned slug
$alt_title = $baseSlug;
$counter = 1;

// Ensure the alt_title is unique
while (true) {
    $query = "SELECT COUNT(*) AS count FROM " . $siteprefix . "forum_posts WHERE slug = ?";
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
  
    // Handle image upload
  // Image Upload Settings
    $uploadDir = '../../uploads/';
    $allowedImageTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg', 'image/webp'];
    $fileKey = 'featured_image';
    $uploadedImage = "";
    $message = "";

    // Check if an image is uploaded
    if (!empty($_FILES[$fileKey]['name'])) {
        $fileType = mime_content_type($_FILES[$fileKey]['tmp_name']);
        if (in_array($fileType, $allowedImageTypes)) {
            $fileName = uniqid() . '_' . basename($_FILES[$fileKey]['name']);
            $fileName = preg_replace("/[^a-zA-Z0-9\._-]/", "", $fileName); // Sanitize file name
            $filePath = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES[$fileKey]['tmp_name'], $filePath)) {
                $uploadedImage = $fileName;
            } else {
                $message .= "Error uploading image.<br>";
            }
        } else {
            $message .= "Invalid file type (Only JPG, PNG, GIF, WEBP allowed).<br>";
        }
    }
    // Insert into forum_posts table
    $sql = "INSERT INTO {$siteprefix}forum_posts (user_id, title, article, categories, featured_image, created_at, views,slug)
            VALUES (?, ?, ?, ?, ?, ?, ?,?)";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("isssssis", $user_id, $title, $article, $categories, $uploadedImage, $created_at, $views, $alt_title);

    if ($stmt->execute()) {
        showSuccessModal('Success!', 'Forum topic created successfully!');
        header("refresh:2; url=forum-list.php");
      
    } else {
        showErrorModal('Error!', 'Failed to create forum topic: ' . $stmt->error);
    }
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editforum'])) {
    $forum_id = intval($_POST['forum_id']);
    $user_id = intval($_POST['user']);
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $article = mysqli_real_escape_string($con, $_POST['article']);
    $categories = isset($_POST['category']) ? implode(',', array_map('intval', $_POST['category'])) : '';
    $updated_at = date('Y-m-d H:i:s');
    $message = "";

    // Handle image upload
    $uploadDir = '../../uploads/';
    $allowedImageTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg', 'image/webp'];
    $fileKey = 'featured_image';
    $uploadedImage = "";

    // Fetch current image
    $currentImage = '';
    $imgRes = mysqli_query($con, "SELECT featured_image FROM {$siteprefix}forum_posts WHERE s = $forum_id LIMIT 1");
    if ($imgRes && $imgRow = mysqli_fetch_assoc($imgRes)) {
        $currentImage = $imgRow['featured_image'];
    }

    // Check if a new image is uploaded
    if (!empty($_FILES[$fileKey]['name']) && $_FILES[$fileKey]['error'] === UPLOAD_ERR_OK) {
        $fileType = mime_content_type($_FILES[$fileKey]['tmp_name']);
        if (in_array($fileType, $allowedImageTypes)) {
            $fileName = uniqid() . '_' . basename($_FILES[$fileKey]['name']);
            $fileName = preg_replace("/[^a-zA-Z0-9\._-]/", "", $fileName);
            $filePath = $uploadDir . $fileName;
            if (move_uploaded_file($_FILES[$fileKey]['tmp_name'], $filePath)) {
                $uploadedImage = $fileName;
                // Optionally delete old image file here if you want
            } else {
                $message .= "Error uploading new image.<br>";
                $uploadedImage = $currentImage;
            }
        } else {
            $message .= "Invalid file type (Only JPG, PNG, GIF, WEBP allowed).<br>";
            $uploadedImage = $currentImage;
        }
    } else {
        $uploadedImage = $currentImage;
    }

    // Update the forum post
    $sql = "UPDATE {$siteprefix}forum_posts 
            SET user_id=?, title=?, article=?, categories=?, featured_image=?
            WHERE s=?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("issssi", $user_id, $title, $article, $categories, $uploadedImage,  $forum_id);

    if ($stmt->execute()) {
        showSuccessModal('Success!', 'Forum topic updated successfully!');
        header("refresh:2; url=forum-list.php");
     
    } else {
        showErrorModal('Error!', 'Failed to update forum topic: ' . $stmt->error);
    }
}
?>