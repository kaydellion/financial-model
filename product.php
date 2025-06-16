<?php include "header.php"; include "product_details.php";  include "sellers-info.php"; 

//get and decode affliate_id if it exists
$affliate_id = isset($_GET['affiliate']) ? base64_decode($_GET['affiliate']) : 0;

// Check if user has purchased THIS product
$purchase_query = "SELECT * FROM ".$siteprefix."orders o 
JOIN ".$siteprefix."order_items oi ON o.order_id = oi.order_id 
WHERE o.user = ? AND oi.report_id = ?";
$stmt = $con->prepare($purchase_query);
$stmt->bind_param("ss", $user_id, $report_id);
$stmt->execute();
$purchase_result = $stmt->get_result();
$user_purchased = $purchase_result->num_rows > 0;


// Check if user already left a review
$existing_review_query = "SELECT * FROM ".$siteprefix."reviews WHERE user = ? AND report_id = ?";
$stmt = $con->prepare($existing_review_query);
$stmt->bind_param("si", $user_id, $report_id);
$stmt->execute();
$existing_review_result = $stmt->get_result();
$user_review = $existing_review_result->fetch_assoc();

?>

<?php
// Log the view of the resource
if (isset($user_id) && isset($report_id)) {
    $log_view_query = "INSERT INTO ".$siteprefix."product_views  (user_id, report_id) VALUES ('$user_id', '$report_id')";
    mysqli_query($con, $log_view_query);
}
?>
 <main class="main">

    <!-- Page Title -->
    <div class="page-title light-background">
      <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">Product</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index">Home</a></li>
            <li class="current">Product</li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

      <!-- Product Details Section -->
    <section id="product-details" class="product-details section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row">
          <!-- Product Images -->
          <div class="col-lg-6 mb-5 mb-lg-0" data-aos="fade-right" data-aos-delay="200">
            <div class="product-images">
              <div class="main-image-container mb-3">
                <div class="image-zoom-container">
                  <img src="<?php echo $siteurl.$image_path; ?>" alt="Product Image" class="img-fluid main-image drift-zoom" id="main-product-image" data-zoom="<?php echo $siteurl.$image_path; ?>">
                </div>
              </div>
                <div class="product-thumbnails">
                <div class="swiper product-thumbnails-slider init-swiper">
                  <script type="application/json" class="swiper-config">
                    {
                      "loop": false,
                      "speed": 400,
                      "slidesPerView": 4,
                      "spaceBetween": 10,
                      "navigation": {
                        "nextEl": ".swiper-button-next",
                        "prevEl": ".swiper-button-prev"
                      },
                      "breakpoints": {
                        "320": {
                          "slidesPerView": 3
                        },
                        "576": {
                          "slidesPerView": 4
                        }
                      }
                    }
                  </script>
                  <?php
$sql3 = "SELECT * FROM ".$siteprefix."reports_images WHERE report_id = '$report_id'";
$sql4 = mysqli_query($con, $sql3);
if (!$sql4) { die("Query failed: " . mysqli_error($con)); }

$allImages = [];
while ($row = mysqli_fetch_array($sql4)) {
    $allImages[] = $imagePath . $row['picture'];
}
?>

<div class="swiper-wrapper">
  <?php foreach ($allImages as $index => $img): ?>
    <div class="swiper-slide thumbnail-item<?php echo $index === 0 ? ' active' : ''; ?>" data-image="<?php echo htmlspecialchars($img); ?>">
      <img src="<?php echo htmlspecialchars($img); ?>" alt="Product Thumbnail" class="img-fluid">
    </div>
  <?php endforeach; ?>
</div>
                  <div class="swiper-button-next"></div>
                  <div class="swiper-button-prev"></div>
                </div>
              </div>
            </div>
          </div>

          <!-- Product Info -->
          <div class="col-lg-6" data-aos="fade-left" data-aos-delay="200">
            <div class="product-info">
              <div class="product-meta mb-2">
                <span class="product-category"><?php echo $category; ?></span>
				</div>
                <!---
                <div class="product-rating">
                  <i class="bi bi-star-fill"></i>
                  <i class="bi bi-star-fill"></i>
                  <i class="bi bi-star-fill"></i>
                  <i class="bi bi-star-fill"></i>
                  <i class="bi bi-star-half"></i>
                  <span class="rating-count">(42)</span>
                </div>

                -->
              <h1 class="product-title"><?php echo $title; ?></h1>

              <div class="product-price-container">
    <span class="current-price">
        <?php echo $sitecurrency; ?><span id="mainProductPriceTop"><?php echo formatNumber($price, 2); ?></span>
    </span>
</div>
              <div class="mb-1">
                 <?php if ($loyalty == 1): ?>
        <span class="badge text-light bg-danger mb-1">Loyalty Material</span>
        <?php endif; ?>
        <?php if ($loyalty_id < 1 && $price > 0 ): ?>
        <h6>Buy for Less – <a href="<?php echo $siteurl;?>loyalty-program.php">Sign up</a> as a loyalty member today!</h6>
       <div class="product-loyalty-container mb-4">
            
             <?php
// Fetch all loyalty plans
$loyalty_query = "SELECT name, discount FROM {$siteprefix}subscription_plans WHERE status = 'active'";
$loyalty_result = mysqli_query($con, $loyalty_query);

if ($loyalty_result && mysqli_num_rows($loyalty_result) > 0) {
    $loyalty_badges = [];
    while ($row = mysqli_fetch_assoc($loyalty_result)) {
        $plan_name = $row['name'];
        $discount = $row['discount']; // Discount percentage
        $discounted_price = $price - ($price * ($discount / 100)); // Calculate discounted price
        // Add a data-discount attribute for JS
        ?>
        <span class="badge text-light bg-accent me-1 loyalty-badge"
              data-discount="<?php echo $discount; ?>"
              data-plan="<?php echo htmlspecialchars($plan_name); ?>">
            <a href="<?php echo $siteurl;?>loyalty-program.php" class="text-white text-decoration-none">
                <span class="loyalty-plan-name"><?php echo $plan_name; ?></span> - ₦
                <span class="loyalty-price"><?php echo formatNumber($discounted_price, 2); ?></span>
            </a>
        </span>
        <?php
    }
} ?>
          </div>

    <?php endif; ?>
	
	</div>


          
                    <!-- Hidden full description -->
<div class="product-short-description mb-4">
    <?php 
    $words = explode(' ', $description);
    $shortDesc = implode(' ', array_slice($words, 0, 10));
    $isLong = str_word_count($description) > 10;
    ?>

    <span class="short-description"><?php echo htmlspecialchars($shortDesc); ?><?php if ($isLong) echo '...'; ?></span>

    <?php if ($isLong): ?>
        <span class="full-description" style="display: none;"><?php echo nl2br(htmlspecialchars($description)); ?></span>
        <br>
        <button type="button" class="btn btn-link btn-sm p-0 read-more-btn" style="text-decoration: none;">Read More</button>
        <button type="button" class="btn btn-link btn-sm p-0 read-less-btn" style="text-decoration: none; display:none;">Read Less</button>
    <?php endif; ?>
</div>



			  
            <form method="post">
     <input type="hidden" id="defaultPrice" value="<?php echo formatNumber($price, 2); ?>">
    <input type="hidden" id="basePrice" value="<?php echo $price; ?>">
            <div class="mb-3">
                <div class="btn-group mb-3" role="group" aria-label="Basic radio toggle button group">
<?php 
$sql = "SELECT * FROM ".$siteprefix."reports_files WHERE report_id = '$report_id'";
$sql2 = mysqli_query($con, $sql);
if (!$sql2) {die("Query failed: " . mysqli_error($con)); }
$first = true;
while ($row = mysqli_fetch_array($sql2)) {
    $file_id = $row['id'];
    $file_title = $row['title'];
    $file_pages = $row['pages'];
    $file_updated_at = $row['updated_at'];
    $file_extension = getFileExtension($file_title);
?>
    <input type="radio" class="btn-check" value="<?php echo $file_id; ?>" name="btnradio" id="btnradio<?php echo $file_id; ?>" autocomplete="off" <?php if ($first) { echo 'checked'; $first = false; } ?>>
<?php } ?>
            </div>
<?php
            // Fetch support documents for this report
$supportDocs = [];
$sql = "SELECT s, doc_typeid, price, filename FROM {$siteprefix}doc_file WHERE report_id = '$report_id'";
$result = mysqli_query($con, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    // Get the name of the doc_typeid
    $typeRes = mysqli_query($con, "SELECT name FROM {$siteprefix}type_business_docs WHERE id = '{$row['doc_typeid']}' LIMIT 1");
    $typeRow = mysqli_fetch_assoc($typeRes);
    $row['type_name'] = $typeRow ? $typeRow['name'] : 'Unknown';
    $supportDocs[] = $row;
}

?>

<?php if (!empty($supportDocs)): ?> 
    <div class="mb-3">
        <h6 class="mb-3">Available Support Document Formats</h6>
        <?php foreach ($supportDocs as $i => $doc): ?>
            <input type="radio"
                   class="btn-check"
                   name="supportDocRadio"
                   id="supportDocRadio<?php echo $doc['doc_typeid']; ?>"
                   value="<?php echo htmlspecialchars($doc['s']); ?>"
                   data-price="<?php echo htmlspecialchars($doc['price']); ?>">
            <label class="btn btn-outline-primary mb-1" for="supportDocRadio<?php echo $doc['doc_typeid']; ?>">
                <?php echo htmlspecialchars($doc['type_name']); ?> (₦<?php echo formatNumber($doc['price'], 2); ?>)
            </label>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
			
			 <!-- Action Buttons -->
              <div class="product-actions">
			    <!-- Add to Cart Button -->
    <input type="hidden" name="report_id" id="current_report_id" value="<?php echo $report_id; ?>">
    <input type="hidden" name="affliate_id" id="affliate_id" value="<?php echo $affliate_id; ?>">
                <button class="btn btn-primary add-to-cart-btn"  type="button" data-report="<?php echo $report_id; ?>" name="add" id="addCart">
                  <i class="bi bi-cart-plus"></i> Add to Cart
                </button>
                <button type="button" class="btn btn-outline-secondary wishlist-btn<?php echo $theinitialicon ? ' '.$theinitialicon : ''; ?>" data-product-id="<?php echo $report_id; ?>">
            <i class="bi <?php echo $theinitialicon ? 'bi-heart-fill' : 'bi-heart'; ?>"></i>
          </button>
              </div>

               <!-- Additional Info -->
              <div class="additional-info mt-4">
               <?php if ($active_log == 1): ?>
       <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#reportProductModal">
  <i class="bi bi-flag"></i> Report
</button>

    <?php else: ?>
        <button class="btn btn-secondary" disabled>
            <i class="bi bi-flag"></i> Report
        </button>
    </form>
    <?php endif; ?>

          <!-- Seller Information -->

<div class="mt-3">
    <div class="card p-3">
        <div class="d-flex align-items-center">
            <!-- Seller's Photo -->
            <img src="<?php echo $siteurl.$seller_photo; ?>" alt="Seller Photo" class="rounded-circle me-3" style="width: 60px; height: 60px; object-fit: cover;">
            <div>
                <!-- Seller's Name -->
                <h5 class="mb-1"><?php echo $seller_name;  ?></h5>
                <p class="mb-1 text-muted">
                    About the Seller: 
                    <span class="seller-bio-preview">
                        <?php 
                        $words = explode(' ', $seller_about);
                        echo implode(' ', array_slice($words, 0, 4)); // Display first 4 words
                        ?>
                    </span>
                    
                    <span class="seller-bio-full" style="display: none;">
                        <?php echo $seller_about; ?>
                    </span>
                    <?php if (str_word_count($seller_about) > 4) { ?>
        <button class="btn btn-link btn-sm p-0 read-mores-btn" style="text-decoration: none;">Read More</button>
    <?php } ?>
                
                </p>
                <!-- Resources Count -->
                <p class="mt-2 mb-0"><strong>Resources:</strong> <?php echo $seller_resources_count; ?> resources available</p>

                <!-- Follow Seller Button
                <button class="btn btn-outline-primary btn-sm follow-seller" data-seller-id="<?php echo $seller_id; ?>">Follow Seller</button>
             -->
            
            </div>
        </div>
        <div class="d-flex align-items-center mt-3 gap-2">
    <!-- View Merchant Store Link -->
    <a href="<?php echo $siteurl;?>merchant-store.php?seller_id=<?php echo $seller_id; ?>" class="btn btn-primary btn-sm">
        View Merchant Store
    </a>

    <?php if ($active_log == 1): ?>

    <?php
    // Check if the user is already following the seller
    $followQuery = "SELECT * FROM {$siteprefix}followers WHERE user_id = ? AND seller_id = ?";
    $stmt = $con->prepare($followQuery);
    $stmt->bind_param("ii", $user_id, $seller_id);
    $stmt->execute();
    $followResult = $stmt->get_result();
    $isFollowing = $followResult->num_rows > 0;
    ?>

    <form method="POST" class="d-inline">
        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
        <input type="hidden" name="seller_id" value="<?php echo $seller_id; ?>">
        <input type="hidden" name="follow_seller_submit" value="1">

        <?php if ($isFollowing): ?>
            <!-- Following Dropdown -->
            <div class="dropdown">
                <button class="btn btn-outline-success btn-sm dropdown-toggle" type="button" id="followingDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    Following
                </button>
                <ul class="dropdown-menu" aria-labelledby="followingDropdown">
                    <li>
                        <button type="submit" name="actioning" value="unfollow" class="dropdown-item">
                            Unfollow
                        </button>
                    </li>
                </ul>
            </div>
        <?php else: ?>
            <!-- Follow Button -->
            <button type="submit" name="actioning" value="follow" class="btn btn-outline-primary btn-sm">
                Follow Seller
            </button>
        <?php endif; ?>
    </form>
    <?php endif; ?>
                 
</div>


        <div class="mt-3">
    <h6>Connect with the Seller:</h6>
    <div class="d-flex">
        <?php if (!empty($seller_facebook)) { ?>
            <a href="https://www.facebook.com/<?php echo str_replace(' ', '-', $seller_facebook); ?>" target="_blank" class="text-decoration-none me-3">
                <i class="fab fa-facebook text-primary" style="font-size: 1.5rem;"></i>
            </a>
        <?php } ?>
        <?php if (!empty($seller_twitter)) { ?>
            <a href="https://twitter.com/<?php echo str_replace(' ', '-', $seller_twitter); ?>" target="_blank" class="text-decoration-none me-3">
                <i class="fab fa-twitter text-info" style="font-size: 1.5rem;"></i>
            </a>
        <?php } ?>
        <?php if (!empty($seller_instagram)) { ?>
            <a href="https://www.instagram.com/<?php echo str_replace(' ', '-', $seller_instagram); ?>" target="_blank" class="text-decoration-none me-3">
                <i class="fab fa-instagram text-danger" style="font-size: 1.5rem;"></i>
            </a>
        <?php } ?>
        <?php if (!empty($seller_linkedin)) { ?>
            <a href="https://www.linkedin.com/in/<?php echo str_replace(' ', '-', $seller_linkedin); ?>" target="_blank" class="text-decoration-none me-3">
                <i class="fab fa-linkedin text-primary" style="font-size: 1.5rem;"></i>
            </a>
        <?php } ?>

        <span class="product-count me-2" style="background-color: orange; color: white; padding: 5px 10px; border-radius: 5px;">Followers:<?php echo $totalFollowers; ?></span>
    <span class="product-count me-2" style="background-color: orange; color: white; padding: 5px 10px; border-radius: 5px;">Followings: <?php echo $totalFollowings; ?></span>
      
    </div>
</div>
    </div>
</div>
    
</div>



          </div>
        </div>
		</div>
</div>
        <!-- Product Details Tabs -->
       <!-- Product Details Tabs -->
        <div class="row mt-5" data-aos="fade-up">
          <div class="col-12">
            <div class="product-details-tabs">
              <ul class="nav nav-tabs" id="productTabs" role="tablist">
                  <?php if ($user_purchased) { ?>
                <li class="nav-item" role="presentation">
                  <button  class="nav-link active" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab" aria-controls="reviews" aria-selected="false">Reviews</button>
                </li>
                  <?php } ?>
              </ul>
 <!-- Reviews Tab -->
                <div class="tab-pane fade show active" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                  <div class="product-reviews">
                          <div class="review-form-container">
                      <h4>Write a Review</h4>
                      <form class="review-form" method="POST">
                         <input type="hidden" name="report_id" value="<?php echo $report_id; ?>">
                        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                        <div class="rating-select mb-4">
                          <label class="form-label">Your Rating</label>
                          <div class="star-rating">
                            <input type="radio" id="star5" name="rating" value="5"><label for="star5" title="5 stars"><i class="bi bi-star-fill"></i></label>
                            <input type="radio" id="star4" name="rating" value="4"><label for="star4" title="4 stars"><i class="bi bi-star-fill"></i></label>
                            <input type="radio" id="star3" name="rating" value="3"><label for="star3" title="3 stars"><i class="bi bi-star-fill"></i></label>
                            <input type="radio" id="star2" name="rating" value="2"><label for="star2" title="2 stars"><i class="bi bi-star-fill"></i></label>
                            <input type="radio" id="star1" name="rating" value="1"><label for="star1" title="1 star"><i class="bi bi-star-fill"></i></label>
                          </div>
                        </div>


                        <div class="mb-4">
                          <label for="review-content" class="form-label">Your Review</label>
                          <textarea class="form-control" id="review-content" rows="4" name="review" required=""></textarea>
                         
                        </div>

                        <div class="d-grid">
                          <button type="submit" name="submit-review" class="btn btn-primary">Submit Review</button>
                        </div>
                      </form>
                    </div>
                     <!-- Display All User Reviews -->
      <?php
// Fetch all reviews for the product
$all_reviews_query = "SELECT r.*, u.display_name AS user_name 
                      FROM {$siteprefix}reviews r
                      JOIN {$siteprefix}users u ON r.user = u.s
                      WHERE r.report_id = ?
                      ORDER BY r.date DESC";

$stmt = $con->prepare($all_reviews_query);
$stmt->bind_param("i", $report_id);
$stmt->execute();
$all_reviews_result = $stmt->get_result();
$all_reviews = $all_reviews_result->fetch_all(MYSQLI_ASSOC);
?>

<!-- Display All User Reviews -->
  <?php if (!empty($all_reviews)): ?>
<div class="reviews-list mt-5">
  <h4>Customer Reviews</h4>

    <?php foreach ($all_reviews as $review): ?>
      <div class="review-item mb-4">
        <div class="review-header d-flex justify-content-between align-items-center">
          <div class="reviewer-info d-flex align-items-center">
            <div>
              <h5 class="reviewer-name mb-0"><?php echo htmlspecialchars($review['user_name']); ?></h5>
              <div class="review-date"><?php echo date('m/d/Y', strtotime($review['date'])); ?></div>
            </div>
          </div>
          <div class="review-rating">
            <?php
              $rating = (int)$review['rating'];
              for ($i = 1; $i <= 5; $i++) {
                if ($i <= $rating) {
                  echo '<i class="bi bi-star-fill"></i>';
                } else {
                  echo '<i class="bi bi-star"></i>';
                }
              }
            ?>
          </div>
        </div>
        <div class="review-content mt-2">
          <p><?php echo nl2br(htmlspecialchars($review['review'])); ?></p>
        </div>
      </div>
    <?php endforeach; ?>
  <?php else: ?>
    <p>No reviews yet.</p>

</div>
  <?php endif; ?>
                    </div>
                    </div>
                    </div>
                    </div>
					</div>
                    </div>

		   </section><!-- /Product Details Section -->



           <!-- Report Product Modal -->
<div class="modal fade" id="reportProductModal" tabindex="-1" aria-labelledby="reportProductModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="reportForm" method="POST">
        <div class="modal-header">
          <h5 class="modal-title" id="reportProductModalLabel">Report <?php echo htmlspecialchars($title); ?></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($report_id); ?>">
          <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user_id); ?>">
          <div class="mb-3">
            <label for="reason" class="form-label">Reason for Reporting</label>
            <select class="form-select" name="reason" id="reason" required>
              <option value="Inappropriate Content">Inappropriate Content</option>
              <option value="Copyright Violation">Copyright Violation</option>
              <option value="Spam or Misleading">Spam or Misleading</option>
              <option value="Other">Other</option>
            </select>
          </div>
          <div class="mb-3" id="customReasonContainer" style="display: none;">
            <label for="custom_reason" class="form-label">Custom Reason</label>
            <textarea class="form-control" name="custom_reason" id="custom_reason" rows="3"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" name="submit_report" class="btn btn-danger">Submit Report</button>
        </div>
      </form>
    </div>
  </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const reasonSelect = document.getElementById("reason");
        const customReasonContainer = document.getElementById("customReasonContainer");

        reasonSelect.addEventListener("change", function () {
            if (this.value === "Other") {
                customReasonContainer.style.display = "block";
            } else {
                customReasonContainer.style.display = "none";
            }
        });
    });
</script>


    <!-- Related Product Section -->
    <section id="best-sellers" class="best-sellers section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Related Products</h2>
        <p></p>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4">
          <?php
$sql = "SELECT r.*, u.display_name, u.profile_picture, l.category_name AS category, sc.category_name AS subcategory, ri.picture 
    FROM ".$siteprefix."reports r 
    LEFT JOIN ".$siteprefix."categories l ON r.category = l.id 
    LEFT JOIN ".$siteprefix."users u ON r.user = u.s 
    LEFT JOIN ".$siteprefix."categories sc ON r.subcategory = sc.id 
    LEFT JOIN ".$siteprefix."reports_images ri ON r.id = ri.report_id 
     WHERE r.category = '$category' AND r.subcategory = '$subcategory' 
        AND r.id != '$report_id' AND r.status = 'approved' 
        GROUP BY r.id 
        LIMIT 4";
$sql2 = mysqli_query($con, $sql);
if (!$sql2) {die("Query failed: " . mysqli_error($con)); }
if (mysqli_num_rows($sql2) > 0) {
    while ($row = mysqli_fetch_assoc($sql2)) {
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
		  
		  <?php } else { echo '<div class="alert alert-warning" role="alert">
    No related products found. <a href="'.$siteurl.'.marketplace.php" class="alert-link">View more reports in marketplace</a>
      </div>';
       }?>
        </div>
      </div>

    </section><!-- /Related Products Section -->


  </main>



		<?php include "footer.php"; ?>