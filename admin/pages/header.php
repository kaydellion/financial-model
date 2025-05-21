<?php include "../../backend/connect.php"; 

error_reporting(E_ALL); ini_set('display_errors', 1); ini_set('log_errors', 1);
$_SESSION['previous_page'] = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$previousPage=$_SESSION['previous_page'];
$current_page = str_replace('.php', '', basename($_SERVER['PHP_SELF']));
 
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
        $display_name = $row['display_name'];
        $first_name = $row['first_name']; 
        $middle_name = $row['middle_name'];
        $last_name = $row['last_name'];
        $profile_picture = !empty($row['profile_picture']) ? $row['profile_picture'] : 'user.png';
        $mobile_number = $row['mobile_number'];
        $email = $row['email'];
        $password = $row['password'];
        $gender = $row['gender'];
        $address = $row['address'];
        $user_type = $row['type'];
        $status = $row['status'];
        $last_login = $row['last_login'];
        $created_date = $row['created_date'];
        $preference = $row['preference'];
        $bank_name = $row['bank_name'];
        $bank_accname = $row['bank_accname'];
        $bank_number = $row['bank_number'];
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
        $kin_relationship = $row['kin_relationship'];

        $_SESSION['user_role'] = $user_type;
        

        
        $active_log = 1;
        $user_id=$id;
        $user_reg_date=formatDateTime($created_date);
        $user_lastseen=formatDateTime($last_login);

}}

if ($active_log == 0 && $user_type != 'admin') {
  header("location: ../../index.php");
  exit;
}
include "actions.php"; ?>


<!DOCTYPE html>
<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>Administration | <?php echo $sitename; ?></title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?php echo $siteurl;?>img/<?php echo $siteimg; ?>" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="../assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <link rel="stylesheet" href="../assets/vendor/libs/apex-charts/apex-charts.css" />

    <!-- Page CSS -->
    <!-- Include CodeMirror CSS & Theme -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.0/codemirror.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.0/theme/dracula.min.css">

<!-- CodeMirror JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.0/codemirror.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.0/mode/python/python.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.0/mode/javascript/javascript.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.0/mode/php/php.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.0/mode/clike/clike.min.js"></script> <!-- For Java, C++, C# -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.0/mode/xml/xml.min.js"></script> <!-- For HTML -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.0/mode/css/css.min.js"></script> <!-- For CSS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.0/mode/sql/sql.min.js"></script> <!-- For SQL -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.0/mode/ruby/ruby.min.js"></script> <!-- For Ruby -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.0/mode/r/r.min.js"></script> <!-- For R -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.0/mode/swift/swift.min.js"></script> <!-- For Swift -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.0/mode/kotlin/kotlin.min.js"></script> <!-- For Kotlin -->
    <!-- Page CSS -->

    <!-- Helpers -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="../assets/vendor/js/helpers.js"></script>
    <script src="../assets/js/config.js"></script>
<?php include '../../backend/tinymce.php'; ?>
  </head>

  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->

        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
          <div class="app-brand demo">
            <a href="index.php" class="app-brand-link">
              <img src="<?php echo $siteurl;?>img/<?php echo $siteimg; ?>" alt="">
            </a>

            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
              <i class="bx bx-chevron-left bx-sm align-middle"></i>
            </a>
          </div>

          <div class="menu-inner-shadow"></div>

          <ul class="menu-inner py-1">
            <!-- Dashboard -->
            <li class="menu-item active">
              <a href="index.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
              </a>
            </li>

            <li class="menu-header small text-uppercase">
              <span class="menu-header-text">Features</span>
            </li>
            <!-- Courses -->
            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-folder-open"></i>
                <div data-i18n="Layouts">Reports</div>
              </a>

              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="add-report.php" class="menu-link">
                    <div data-i18n="Without menu">Add New</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="categories.php" class="menu-link">
                    <div data-i18n="Without menu">Manage Categories</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="reports.php" class="menu-link">
                    <div data-i18n="Without navbar">Manage Reports</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="drafts.php" class="menu-link">
                    <div data-i18n="Without navbar">Drafts</div>
                  </a>
                <li class="menu-item">
                  <a href="admin-report.php" class="menu-link">
                    <div data-i18n="Without navbar">Admin Reports</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="pending-reports.php" class="menu-link">
                    <div data-i18n="Container">Pending Reports</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="product_reports.php" class="menu-link">
                    <div data-i18n="Container">Product Reports</div>
                  </a>
                </li>
              </ul>
            </li>
            <!--  manual payment --->
            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-folder-open"></i>
                <div data-i18n="Layouts">Manual Payment</div>
              </a>

              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="pending-orders.php" class="menu-link">
                    <div data-i18n="Without menu">Pending Payment</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="payment_resend.php" class="menu-link">
                    <div data-i18n="Without navbar">Payment Resent</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="approve_payment.php" class="menu-link">
                    <div data-i18n="Container">Approved</div>
                  </a>
                </li>
              </ul>
            </li>

            
                <!-- Plans -->
                <li class="menu-item <?= getDisplayClass() ?>">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-folder-open"></i>
                <div data-i18n="Layouts">Subscription Plans</div>
              </a>

              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="add-plan.php" class="menu-link">
                    <div data-i18n="Without menu">Add New</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="plans.php" class="menu-link">
                    <div data-i18n="Without navbar">Manage Plans</div>
                  </a>
                </li>
              
              </ul>
            </li>

              <!-- Plans -->
              <li class="menu-item <?= getDisplayClass() ?>">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-folder-open"></i>
                <div data-i18n="Layouts">Transactions</div>
              </a>

              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="transactions.php" class="menu-link">
                    <div data-i18n="Without menu">All Transactions</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="profits.php" class="menu-link">
                    <div data-i18n="Without navbar">Profits</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="withdrawals.php" class="menu-link">
                    <div data-i18n="Without menu">All Withdrawals</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="pending-withdrawals.php" class="menu-link">
                    <div data-i18n="Without navbar">Pending Withdrawals</div>
                  </a>
                </li>
              
              </ul>
            </li>

             <!-- Components -->           
             <li class="menu-header small text-uppercase"><span class="menu-header-text">Users</span></li>
            <li class="menu-item"> <a href="users.php" class="menu-link"><i class="menu-icon tf-icons bx bxs-user-account"></i> <div data-i18n="Spinners">All Users</div></a></li>
            <li class="menu-item <?= getDisplayClass() ?>"> <a href="send-message.php" class="menu-link"><i class="menu-icon tf-icons bx bx-mail-send"></i> <div data-i18n="Spinners">Send Message</div></a></li>

        

             <!-- Courses -->
             <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-notepad"></i>
                <div data-i18n="Layouts">Affliate</div>
              </a>

              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="manage.php" class="menu-link">
                    <div data-i18n="Without navbar">Manage Affliates</div>
                  </a>
                </li>
              </ul>
            </li>

          

            
            <!-- Components -->           
            <li class="menu-header small text-uppercase"><span class="menu-header-text">Resolution Module</span></li>
            <li class="menu-item"><a href="new-disputes.php" class="menu-link"><i class="menu-icon tf-icons bx bx-user-plus"></i><div data-i18n="Spinners">New Disputes</div></a></li>
            <li class="menu-item"> <a href="disputes.php" class="menu-link"><i class="menu-icon tf-icons bx bxs-user-account"></i> <div data-i18n="Spinners">Ongoing Disputes</div></a></li>
            <li class="menu-item"> <a href="closed-disputes.php" class="menu-link"><i class="menu-icon tf-icons bx bxs-user-account"></i> <div data-i18n="Spinners">Closed Disputes</div></a></li>

        
            <!-- Misc -->
            <li class="menu-header small text-uppercase"><span class="menu-header-text">ADMIN</span></li>
            <li class="menu-item"> <a href="notifications.php" class="menu-link"><i class="menu-icon tf-icons bx bx-bell"></i> <div data-i18n="Spinners">Notifications</div></a></li>
            <li class="menu-item <?= getDisplayClass() ?>"> <a href="settings.php" class="menu-link"><i class="menu-icon tf-icons bx bx-cog"></i> <div data-i18n="Spinners">Settings</div></a></li>
            <li class="menu-item"> <a href="logout.php" class="menu-link"><i class="menu-icon tf-icons bx bx-log-out"></i> <div data-i18n="Spinners">Log Out</div></a></li>
            
        </aside>
        <!-- / Menu -->





        <!-- Layout container -->
        <div class="layout-page">
          <!-- Navbar -->
          <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
              <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="bx bx-menu bx-sm"></i>
              </a>
            </div>

            <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
              <!-- Search -->
              <div class="navbar-nav align-items-center">
                <div class="nav-item d-flex align-items-center">
                  <i class="bx bx-search fs-4 lh-0"></i>
                  <input
                    type="text"
                    class="form-control border-0 shadow-none"
                    placeholder="Search..."
                    aria-label="Search..."
                  />
                </div>
              </div>
              <!-- /Search -->

              <ul class="navbar-nav flex-row align-items-center ms-auto">
              <li class="nav-item lh-1 me-3">
                  <?php if(isset($notification_count) && $notification_count > 0): ?>
                    <a href="notifications.php" class="position-relative">
                      <i class="bx bx-bell fs-4"></i>
                      <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        <?php echo $notification_count; ?>
                      </span>
                    </a>
                  <?php else: ?>
                    <a href="notifications.php">
                      <i class="bx bx-bell fs-4"></i>
                    </a>
                  <?php endif; ?>
                </li>

                <!-- User -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                  <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                      <img src="<?php echo $siteurl;?>uploads/<?php echo htmlspecialchars($profile_picture); ?>" alt class="w-px-40 h-auto rounded-circle" />
                    </div>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                      <a class="dropdown-item" href="#">
                        <div class="d-flex">
                          <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-online">
                              <img src="<?php echo $siteurl;?>uploads/<?php echo htmlspecialchars($profile_picture); ?>" alt class="w-px-40 h-auto rounded-circle" />
                            </div>
                          </div>
                          <div class="flex-grow-1">
                            <span class="fw-semibold d-block"><?php echo $display_name; ?></span>
                            <small class="text-muted"><?php echo $display_name; ?></small>
                          </div>
                        </div>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider"></div>
                    </li>
                    <li>
                      <a class="dropdown-item" href="<?php echo $siteurl; ?>" target="_blank">
                        <i class="bx bx-log-in me-2"></i>
                        <span class="align-middle">Visit Site</span>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider"></div>
                    </li>
                    <li>
                      <a class="dropdown-item" href="profile.php">
                        <i class="bx bx-user me-2"></i>
                        <span class="align-middle">My Profile</span>
                      </a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="settings.php">
                        <i class="bx bx-cog me-2"></i>
                        <span class="align-middle">Settings</span>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider"></div>
                    </li>
                    <li>
                      <a class="dropdown-item" href="logout.php">
                        <i class="bx bx-power-off me-2"></i>
                        <span class="align-middle">Log Out</span>
                      </a>
                    </li>
                  </ul>
                </li>
                <!--/ User -->
              </ul>
            </div>
          </nav> <!-- / Navbar -->

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->