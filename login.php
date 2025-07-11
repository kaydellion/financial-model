<?php include "header.php";
$show="none"; $textshow="none";
    if(isset($_GET['user_login'])){
    $user_log=$_GET['user_login'];
    $sql = "SELECT * from ".$siteprefix."users where s='$user_log'";
    $sql2 = mysqli_query($con,$sql);
    while($row = mysqli_fetch_array($sql2))
    {$username = $row['email']; $pass = $row['password']; $status = $row['status']; }
    if($status=="inactive"){$textshow="block";} $show="block"; 
    } ifLoggedin($active_log);
   
   ?>

  <main class="main">

    <!-- Page Title -->
    <div class="page-title light-background">
      <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">Login</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.html">Home</a></li>
            <li class="current">Login</li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

    <!-- Login Register Section -->
    <section id="login-register" class="login-register section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row justify-content-center">
          <div class="col-lg-5">
            <div class="login-register-wraper">

              <!-- Tab Navigation -->
              <ul class="nav nav-tabs nav-tabs-bordered justify-content-center mb-4" role="tablist">
                <li class="nav-item" role="presentation">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#login-register-login-form" type="button" role="tab" aria-selected="true">
                    <i class="bi bi-box-arrow-in-right me-1"></i>Login
                  </button>
                </li>
                
              </ul>

              <!-- Tab Content -->
              <div class="tab-content">

                <!-- Login Form -->
                <div class="tab-pane fade show active" id="login-register-login-form" role="tabpanel">
                  <form method="POST">
                    <div class="alert alert-success alert-dismissible mb-3 fade show" id="myAlert" role="alert" style="display:<?php echo $show; ?>">
                       Congratulations! Your Account Has Been Successfully Created.Thank you for registering with us! To complete your registration, please check your email and click the verification link to activate your account.<span style="display: <?php echo $textshow;?>"> your email to verify your account.</span></div>
                    <div class="mb-4">
                      <label for="login-register-login-email" class="form-label">Email address</label>
                      <input type="email" class="form-control" name="email" id="login-register-login-email" required="">
                    </div>

                    <div class="mb-4">
                      <label for="login-register-login-password" class="form-label">Password</label>
                      <input type="password" class="form-control" name="password" id="login-register-login-password" required="">
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                      <!----
                      <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="login-register-remember-me">
                        <label class="form-check-label" for="login-register-remember-me">Remember me</label>
                      </div>
                      --->
                      <a href="forgot_password.php" class="forgot-password">Forgot Password?</a>
                    </div>

                    <div class="d-grid">
                      <button type="submit" name="signin" class="btn btn-primary">Login</button>
                    </div>
                  </form>
                </div>

              

              </div>

            </div>
          </div>
        </div>

      </div>

    </section><!-- /Login Register Section -->

  </main>
<?php include "footer.php"; ?>