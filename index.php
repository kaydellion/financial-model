<?php include "header.php";  ?>

  <main class="main">


    <!-- Hero Section -->
    <section class="ecommerce-hero-1 hero section hero-bg" id="hero">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-7 content-col" data-aos="fade-right" data-aos-delay="100">
            <div class="content">
              <span class="promo-badge">Financial Models </span>
              <h1>High-Quality <span>Financial Models</span> for Smarter Decisions</h1>
              <p>We provide high-quality, customizable financial models designed to help businesses and individuals make informed financial decisions. Whether you're a startup, an established enterprise, or an individual seeking financial planning tools, our models offer precision, reliability, and ease of use.</p>
              <div class="hero-cta">
                <a href="<?php echo $siteurl; ?> marketplace" class="btn btn-shop">Shop Now <i class="bi bi-arrow-right"></i></a>

              </div>
          
            </div>
          </div>
          <div class="col-lg-3 image-col" data-aos="fade-left" data-aos-delay="200">

          </div>
        </div>
      </div>
    </section><!-- /Hero Section -->



    <!-- Category Cards Section -->
    <section id="category-cards" class="category-cards section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="category-slider swiper init-swiper">
          <script type="application/json" class="swiper-config">
            {
              "loop": true,
              "autoplay": {
                "delay": 5000,
                "disableOnInteraction": false
              },
              "grabCursor": true,
              "speed": 600,
              "slidesPerView": "auto",
              "spaceBetween": 20,
              "navigation": {
                "nextEl": ".swiper-button-next",
                "prevEl": ".swiper-button-prev"
              },
              "breakpoints": {
                "320": {
                  "slidesPerView": 2,
                  "spaceBetween": 15
                },
                "576": {
                  "slidesPerView": 3,
                  "spaceBetween": 15
                },
                "768": {
                  "slidesPerView": 4,
                  "spaceBetween": 20
                },
                "992": {
                  "slidesPerView": 5,
                  "spaceBetween": 20
                },
                "1200": {
                  "slidesPerView": 6,
                  "spaceBetween": 20
                }
              }
            }
          </script>

          <div class="swiper-wrapper">

            <?php
                $query = "SELECT * FROM ".$siteprefix."categories WHERE parent_id IS NULL";
                $result = mysqli_query($con, $query);
                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $category_id = $row['id'];
                        $category_name = $row['category_name'];
                        $alt_names = $row['slug'];
                        $slugs = $alt_names;
                        include "category-card.php"; // Include the category card template
                    }
                }
            ?>
              </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
      

      </div>

    </section><!-- /Category Cards Section -->

    <!-- Best Sellers Section -->
    <section id="best-sellers" class="best-sellers section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Featured Financial Models</h2>
        <p>Explore our most popular, high-performing templates—trusted by startups, businesses, and financial planners.</p>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4">
          <?php
$query = "SELECT r.*, u.display_name, u.profile_picture, l.category_name AS category, sc.category_name AS subcategory, ri.picture 
    FROM ".$siteprefix."reports r 
    LEFT JOIN ".$siteprefix."categories l ON r.category = l.id 
    LEFT JOIN ".$siteprefix."users u ON r.user = u.s 
    LEFT JOIN ".$siteprefix."categories sc ON r.subcategory = sc.id 
    LEFT JOIN ".$siteprefix."reports_images ri ON r.id = ri.report_id 
    WHERE r.status = 'approved' GROUP BY r.id ORDER BY r.id DESC LIMIT 4";
$result = mysqli_query($con, $query);
if ($result) {
while ($row = mysqli_fetch_assoc($result)) {
        $report_id = $row['id'];
        $title = $row['title'];
        $alt_title = $row['alt_title'];
        $description = $row['description'];
        $category = $row['category'];
        $subcategory = $row['subcategory'];
        $pricing = $row['pricing'];
        $price = $row['price'];
        $tags = $row['tags'];
        $loyalty = $row['loyalty'];
        $user = $row['display_name'];
        $user_picture = $imagePath.$row['profile_picture'];
        $created_date = $row['created_date'];
        $updated_date = $row['updated_date'];
        $status = $row['status'];
        $image_path = $imagePath.$row['picture'];
        $slug = $alt_title;
        $selected_resource_type = $row['use_case'] ?? '';
        $resourceTypeNames = [];

        if (!empty($selected_resource_type)) {
            $typeIds = array_map('intval', explode(',', $selected_resource_type)); // Convert to array of ints for safety
            $typeIdsList = implode(',', $typeIds);

            $sql_resource_type = "SELECT name FROM {$siteprefix}use_cases WHERE id IN ($typeIdsList) ORDER BY name ASC";
            $result_resource_type = mysqli_query($con, $sql_resource_type);

            while ($typeRow = mysqli_fetch_assoc($result_resource_type)) {
                $resourceTypeNames[] = $typeRow['name'];
            }
        }
        include "product-card.php"; // Include the product card template
        }
      
?>
       </div>
  <div class="text-center mt-5" data-aos="fade-up">
          <a href="<?php echo $siteurl; ?>marketplace" class="view-all-btn">View All Products <i class="bi bi-arrow-right"></i></a>

		  <?php } else {  debug('No reports not found.'); }?>
        </div>
      </div>

    </section><!-- /Best Sellers Section -->

    

    <!---- register propmt -->

<section class="register-prompt section">
  <div class="container">
    <div class="row align-items-center register-prompt-container">
    
      <!-- Image Column -->
      <div class="col-md-5 mb-4 mb-md-0">
        <img src="<?php echo $siteurl;?>assets/img/Sign up-pana.png" alt="Join Marketplace" class="img-fluid register-prompt-img">
      </div>
      <!-- Content Column -->
      <div class="col-md-7">
        <div class="register-prompt-content text-center text-md-start">
          <h2 class="mb-3">Join Our Marketplace</h2>
          <p class="mb-4">Sign up to access premium financial models, sell your own, or manage your company’s resources.</p>
          <div class="register-buttons d-flex justify-content-center justify-content-md-start gap-3 flex-wrap">
            <a href="<?php echo $siteurl; ?>register.php?type=individual" class="btn btn-primary register-btn">Sign Up as Individual</a>
            <a href="<?php echo $siteurl; ?>register.php?type=company" class="btn btn-outline-primary register-btn">Sign Up as Company</a>
          </div>
          </div>
        </div>
      </div>
    
  </div>
 
</section>
 
</section>
<!-- /register prompt -->


   <!-- Recent Reports Swiper Section -->
<section  id="best-sellers" class="best-sellers section">
  <div class="container" data-aos="fade-up" data-aos-delay="100">
    <div class="section-title text-center mb-4">
      <h2>RECENT FINANCIAL MODELS</h2>
      <p>See the latest financial models and reports added to our marketplace.</p>
    </div>
    <div class="recent-reports-slider swiper init-swiper">
      <script type="application/json" class="swiper-config">
        {
          "loop": true,
          "autoplay": {
            "delay": 4000,
            "disableOnInteraction": false
          },
          "grabCursor": true,
          "speed": 600,
          "slidesPerView": "auto",
          "spaceBetween": 20,
          "navigation": {
            "nextEl": ".recent-swiper-button-next",
            "prevEl": ".recent-swiper-button-prev"
          },
          "breakpoints": {
            "320": {
              "slidesPerView": 2,
              "spaceBetween": 10
            },
            "576": {
              "slidesPerView": 2,
              "spaceBetween": 15
            },
            "768": {
              "slidesPerView": 3,
              "spaceBetween": 20
            },
            "992": {
              "slidesPerView": 4,
              "spaceBetween": 20
            }
          }
        }
      </script>
      <div class="swiper-wrapper">
        <?php
        $query = "SELECT r.*, u.display_name, u.profile_picture, l.category_name AS category, sc.category_name AS subcategory, ri.picture 
          FROM {$siteprefix}reports r
          LEFT JOIN {$siteprefix}categories l ON r.category = l.id
          LEFT JOIN {$siteprefix}users u ON r.user = u.s
          LEFT JOIN {$siteprefix}categories sc ON r.subcategory = sc.id
          LEFT JOIN {$siteprefix}reports_images ri ON r.id = ri.report_id
          WHERE r.status = 'approved'
          GROUP BY r.id
          ORDER BY r.id DESC
          LIMIT 10";
        $result = mysqli_query($con, $query);
        if ($result) {
          while ($row = mysqli_fetch_assoc($result)) {
            // Prepare variables as in your product-card.php
            $report_id = $row['id'];
            $title = $row['title'];
            $alt_title = $row['alt_title'];
            $description = $row['description'];
            $category = $row['category'];
            $subcategory = $row['subcategory'];
            $pricing = $row['pricing'];
            $price = $row['price'];
            $tags = $row['tags'];
            $loyalty = $row['loyalty'];
            $user = $row['display_name'];
            $user_picture = $imagePath . $row['profile_picture'];
            $created_date = $row['created_date'];
            $updated_date = $row['updated_date'];
            $status = $row['status'];
            $image_path = $imagePath . $row['picture'];
            $slug = $alt_title;
            $selected_resource_type = $row['use_case'] ?? '';
            $resourceTypeNames = [];

            // Optionally fetch resource type names if needed
            if (!empty($selected_resource_type)) {
              $typeIds = array_map('intval', explode(',', $selected_resource_type));
              $typeIdsList = implode(',', $typeIds);
              $sql_resource_type = "SELECT name FROM {$siteprefix}use_cases WHERE id IN ($typeIdsList) ORDER BY name ASC";
              $result_resource_type = mysqli_query($con, $sql_resource_type);
              while ($typeRow = mysqli_fetch_assoc($result_resource_type)) {
                $resourceTypeNames[] = $typeRow['name'];
              }
            }

            // Each slide
            include "swiper-card.php"; // Use your existing product card template
          }
        }
        ?>
      </div>
      <div class="recent-swiper-button-next swiper-button-next"></div>
      <div class="recent-swiper-button-prev swiper-button-prev"></div>
    </div>
  </div>
</section>

    <!---- affiliate prompt -->

<section class="affiliate-prompt section">
  <div class="container">
    <div class="row align-items-center affiliate-prompt-container">

      <!-- Image Column -->
      <div class="col-md-5 mb-4 mb-md-0">
        <img src="<?php echo $siteurl;?>assets/img/Marketing-amico.png" alt="Join Marketplace" class="img-fluid affiliate-prompt-img">
      </div>
      <!-- Content Column -->
      <div class="col-md-7">
        <div class="affiliate-prompt-content text-center text-md-start">
          <h2 class="mb-3">Join Affiliate</h2>
          <p class="mb-4">Are you passionate about finance, entrepreneurship, or passive income? Becoming an affiliate of FinancialModels.Store is your chance to turn your network and online presence into a rewarding source of income. By partnering with us, you can promote high-quality, professionally crafted financial models to businesses, startups, and finance enthusiasts worldwide.</p>
          <div class="affiliate-buttons d-flex justify-content-center justify-content-md-start gap-3 flex-wrap">
            <a href="<?php echo $siteurl; ?>affiliate-details" class="btn btn-primary register-btn">Join Affiliate</a>
          
          </div>
          </div>
        </div>
      </div>
    
  </div>
 
</section>
 
</section>
<!-- /affliate prompt -->

  </main>
<?php include "footer.php";  ?>