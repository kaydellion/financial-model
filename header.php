<?php include "backend/connect.php"; 


//previous page

$_SESSION['previous_page'] = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$previousPage=$_SESSION['previous_page'];
$current_page = urlencode(pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME) . '?' . $_SERVER['QUERY_STRING']);;

$code = "";
if (isset($_COOKIE['userID'])) {$code = $_COOKIE['userID'];}
$check = "SELECT * FROM ".$siteprefix."users WHERE s = '" . $code . "'";
$query = mysqli_query($con, $check);
if (mysqli_affected_rows($con) == 0) {
    $active_log = 0;
} else {
    $sql = "SELECT * FROM ".$siteprefix."users  WHERE s  = '".$code."'";
    $sql2 = mysqli_query($con, $sql);
    while ($row = mysqli_fetch_array($sql2)) {
        $id = $row["s"];
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
        $country = $row['country'];
        $gender = $row['gender'];
        $address = $row['address'];
        $user_type = $row['type'];
        $seller = $row['seller'];
        $status = $row['status'];
        $last_login = $row['last_login'];
        $created_date = $row['created_date'];
        $preference = $row['preference'];
        $bank_name = $row['bank_name'];
        $bank_accname = $row['bank_accname'];
        $bank_number = $row['bank_number'];
        $branch_name = $row['branch_name'];
        $account_type = $row['account_type'];
        $aba_ach = $row['aba_ach'];
        $sort_code = $row['sort_code'];
        $ifsc_code = $row['ifsc_code'];
        $iban = $row['iban'];
        $swift_bic = $row['swift_bic'];
        $loyalty_id = $row['loyalty'];
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
        $kin_relationship = $row['kin_relationship'];
        $specialization= $row['specialization'];
        $designation = $row['designation'];         
        $_SESSION['user_role'] = $user_type;
        $_SESSION['user_id'] = $id;
        $_SESSION['user_seller']=$seller;

        $active_log = 1;
        $user_id=$id;
        $username=$display_name;
        $user_reg_date=formatDateTime($created_date);
        $user_lastseen=formatDateTime($last_login);


}}


//if($active_log==0){header("location: signup.php");}
//$adminlink=$siteurl.'/admin';
 include "backend/start_order.php";
include "backend/actions.php"; 

//exclude pages tht require user to be logged in
$current_page = basename($_SERVER['PHP_SELF']);
$excluded_pages = array('cart.php', 'pay_success.php', 'pay_failed.php', 'checkout.php', 'free_order_handler.php',
'dashboard.php','loyalty-status.php','saved-reports.php','my_orders.php','manual_orders.php', 'wallet.php','view-blog.php','blog.php',
'notifications.php','tickets.php','models.php','sales.php','reviews.php','my_orders.php','order_details.php','settings.php','tickets.php',
'resources-sold.php','resource.php','edit-report.php','change-password.php','create_ticket.php','add-report.php','delete.php','saved-models.php',
'withdrawhistory.php','my_wishlist.php');
if (in_array($current_page, $excluded_pages)) {
    checkActiveLog($active_log); 
} else {
    //ifLoggedin($active_log);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title><?php echo $sitename; ?></title>
  <meta name="description" content="">
  <meta name="keywords" content=""> 

  <!-- Favicons -->
  <link href="<?php echo $siteurl;?>assets/img/favicon.png" rel="icon">
  <link href="<?php echo $siteurl;?>assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="<?php echo $siteurl;?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo $siteurl;?>assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="<?php echo $siteurl;?>assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="<?php echo $siteurl;?>assets/vendor/aos/aos.css" rel="stylesheet">
  
  <link href="<?php echo $siteurl;?>assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="<?php echo $siteurl;?>assets/vendor/drift-zoom/drift-basic.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
   

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">
  

  <!-- =======================================================
  * Template Name: eStore
  * Template URL: https://bootstrapmade.com/estore-bootstrap-ecommerce-template/
  * Updated: Apr 26 2025 with Bootstrap v5.3.5
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body class="index-page">

  <header id="header" class="header position-relative">
    <!-- Top Bar -->
    <div class="top-bar py-2">
      <div class="container-fluid container-xl">
        <div class="row align-items-center">
          <!-- Add this block for your links, visible on all screens -->
<div class="col-12 my-2 my-lg-0">
  <ul class="list-unstyled d-flex flex-wrap mb-0 justify-content-center justify-content-lg-end">
    <li class="bg-secondary text-white p-2 me-2">
      <a class="text-white text-small" href="<?php echo $siteurl; ?>loyalty-program.php">Loyalty Program</a>
    </li>
    <li class="bg-primary text-white p-2 me-2">
      <a class="text-white text-small" href="<?php echo $siteurl; ?>affiliate-details.php">Affiliate Program</a>
    </li>
    <li class="bg-secondary text-white p-2 me-2 ">
      <a class="text-white text-small" href="<?php echo $siteurl; ?>marketplace.php">Marketplace</a>
    </li>
  </ul>
</div>
          
        </div>
      </div>
    </div>

    <!-- Main Header -->
    <div class="main-header">
      <div class="container-fluid container-xl">
        <div class="d-flex py-3 align-items-center justify-content-between">

          <!-- Logo -->
          <a href="index" class="logo d-flex align-items-center">
            <!-- Uncomment the line below if you also wish to use an image logo -->
            <!-- <img src="assets/img/logo.webp" alt=""> -->
            <h1 class="sitename"><?php echo $sitename; ?></h1>
          </a>

          <!-- Search -->
          <form class="search-form desktop-search-form" action="<?php echo $siteurl;?>search.php" method="get">
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Search for products" name="searchterm" class="form-control" id="search_input">
              <button class="btn" type="submit">
                <i class="bi bi-search"></i>
              </button>
            </div>
          </form>

          <!-- Actions -->
          <div class="header-actions d-flex align-items-center justify-content-end">

            <!-- Mobile Search Toggle -->
            <button class="header-action-btn mobile-search-toggle d-xl-none" type="button" data-bs-toggle="collapse" data-bs-target="#mobileSearch" aria-expanded="false" aria-controls="mobileSearch">
              <i class="bi bi-search"></i>
            </button>

            <!-- Account -->
            <div class="dropdown account-dropdown">
              <button class="header-action-btn" data-bs-toggle="dropdown">
                <i class="bi bi-person"></i>
              </button>
            <div class="dropdown-menu">
  <div class="dropdown-header">
    <h6>Welcome to <span class="sitename"><?php echo $sitename; ?></span></h6>
    <?php if($active_log==0){ ?>
      <p class="mb-0">Access account &amp; manage orders</p>
  </div>
  <div class="dropdown-footer">
    <a href="<?php echo $siteurl; ?>login" class="btn btn-primary w-100 mb-2">Sign In</a>
    <a href="<?php echo $siteurl; ?>register" class="btn btn-outline-primary w-100">Register</a>
  </div>
    <?php } else { ?>
      </div>
      <div class="dropdown-body">
        <a class="dropdown-item d-flex align-items-center" href="<?php echo $siteurl; ?>dashboard">
          <i class="bi bi-person-circle me-2"></i>
          <span>My Profile</span>
        </a>
        <a class="dropdown-item d-flex align-items-center" href="<?php echo $siteurl; ?>my_orders">
          <i class="bi bi-bag-check me-2"></i>
          <span>My Orders</span>
        </a>
        <a class="dropdown-item d-flex align-items-center" href="<?php echo $siteurl; ?>my_wishlist">
          <i class="bi bi-heart me-2"></i>
          <span>My Wishlist</span>
        </a>
        <a class="dropdown-item d-flex align-items-center" href="<?php echo $siteurl; ?>settings">
          <i class="bi bi-gear me-2"></i>
          <span>Settings</span>
        </a>
      </div>
      <div class="dropdown-footer">
        <a href="logout.php" class="btn btn-primary w-100 mb-2">Log Out</a>
      </div>
    <?php } ?>
</div>
            </div>

            <!-- Wishlist -->
             <?php
$wishlist_count = 0;
if (isset($user_id) && !empty($user_id)) {
    $wishlist_count = getWishlistCountByUser($con, $user_id);
    if ($wishlist_count === null) $wishlist_count = 0;
}
?>
          <a href="my_wishlist" class="header-action-btn d-none d-md-block">
  <i class="bi bi-heart"></i>
  <span class="badge wishlist-count"><?php echo $wishlist_count; ?></span>
</a>

            <!-- Cart -->
            <a href="cart.php" class="header-action-btn">
               <?php
                $cart_count = getCartCount($con, $siteprefix, $order_id);
                     ?>
              <i class="bi bi-cart3"></i>
               <?php if($cart_count >= 0): ?>
              <span class="badge cart-count"><?php echo $cart_count; ?></span>
              <?php endif; ?>
            </a>

            <!-- Mobile Navigation Toggle -->
            <i class="mobile-nav-toggle d-xl-none bi bi-list me-0"></i>

          </div>
        </div>
      </div>
    </div>

    <!-- Navigation -->
    <div class="header-nav">
      <div class="container-fluid container-xl">
        <div class="position-relative">
          <nav id="navmenu" class="navmenu">
            <ul>
              <li><a href="<?php echo $siteurl; ?>index.php" class="active">Home</a></li>
              <li><a href="<?php echo $siteurl; ?>about.php">About Us</a></li>
              <li><a href="<?php echo $siteurl; ?>blog.php">Blog</a></li>
              <li><a href="<?php echo $siteurl; ?>loyalty-program.php">Loyalty Program</a></li>


              <li class="products-megamenu-2">
  <a href="#">
    <span>Marketplace</span>
    <i class="bi bi-chevron-down toggle-dropdown"></i>
  </a>
  <!-- Mobile Mega Menu for Marketplace -->
  <ul class="mobile-megamenu">
    <?php
      $sql = "SELECT * FROM " . $siteprefix . "categories WHERE parent_id IS NULL";
      $sql2 = mysqli_query($con, $sql);
      while ($row = mysqli_fetch_array($sql2)) {
          $category_name = $row['category_name'];
          $slugs = $row['slug'];
          echo '<li><a href="' . $siteurl . 'category/' . $slugs . '">' . $category_name . '</a></li>';
      }
    ?>
    <li>
      <a class="font-weight-bold" href="<?php echo $siteurl; ?>marketplace.php">View Marketplace</a>
    </li>
  </ul>
  <!-- Desktop Mega Menu for Marketplace -->
  <div class="desktop-megamenu">
    <div class="row py-4 px-3">
      <?php
        $sql = "SELECT * FROM " . $siteprefix . "categories WHERE parent_id IS NULL";
        $sql2 = mysqli_query($con, $sql);
        $count = 0;
        while ($row = mysqli_fetch_array($sql2)) {
            $category_name = $row['category_name'];
            $slugs = $row['slug'];
            echo '<div class="col-md-4 col-6 mb-1">';
            echo '<a class="dropdown-item" style="white-space: normal;" href="' . $siteurl . 'category/' . $slugs . '">' . $category_name . '</a>';
            echo '</div>';
            $count++;
        }
      ?>
      <div class="col-12 mt-2">
        <a class="dropdown-item font-weight-bold" style="white-space: normal;" href="<?php echo $siteurl; ?>marketplace.php">View Marketplace</a>
      </div>
    </div>
  </div>
</li>

              <li><a href="<?php echo $siteurl; ?>contact.php">Contact</a></li>

            </ul>
          </nav>
        </div>
      </div>
    </div>

    <!-- Mobile Search Form -->
    <div class="collapse" id="mobileSearch">
      <div class="container">
        <form class="search-form">
          <div class="input-group">
            <input type="text" class="form-control" placeholder="Search for products">
            <button class="btn" type="submit">
              <i class="bi bi-search"></i>
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- hidden form input ---->
         <input type="hidden" id="order_id" value="<?php echo $order_id; ?>">
     <input type="hidden" id="user_id" value="<?php if($active_log==1){echo $user_id; }?>">
     <!--- site url --->
    <input type="hidden" id="siteurl" value="<?php echo $siteurl; ?>">

  </header>