

<?php include "header.php"; 

if (isset($_GET['seller_id'])) {
    $seller_id = $_GET['seller_id'];
    
    // Fetch seller details
    $seller_query = "SELECT display_name, profile_picture, biography, company_name, company_profile FROM ".$siteprefix."users WHERE s = '$seller_id'";
    $seller_result = mysqli_query($con, $seller_query);
    $seller_data = mysqli_fetch_assoc($seller_result);

    if (!$seller_data) {
        echo '<div class="container py-5"><div class="alert alert-danger">Seller not found.</div></div>';
        include "footer.php";
        exit;
    }

    $user = $seller_data['display_name'];
    $user_picture = $imagePath . $seller_data['profile_picture'];
    $seller_about = $seller_data['biography'];
// If company_name is not empty, use company_profile as seller_about
if (!empty($seller_data['company_name'])) {
    $seller_about = $seller_data['company_profile'];
}

} else {
    header("Location: index.php");
    exit;
}

$limit = 16; // Number of reports per page
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;

// Handle sorting
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'relevance';
$order_by = "r.id DESC"; // Default sorting by relevance
if ($sort === 'price_high') {
    $order_by = "r.price DESC";
} elseif ($sort === 'price_low') {
    $order_by = "r.price ASC";
}





// Fetch seller's products
$query = "SELECT r.*, 
       ri.picture, 
       l.category_name AS category, 
       sc.category_name AS subcategory
FROM {$siteprefix}reports r
LEFT JOIN {$siteprefix}reports_images ri ON r.id = ri.report_id
LEFT JOIN {$siteprefix}categories l ON r.category = l.id
LEFT JOIN {$siteprefix}categories sc ON r.subcategory = sc.id
WHERE r.user = '$seller_id' 
  AND r.status = 'approved'
GROUP BY r.id
ORDER BY $order_by
LIMIT $limit OFFSET $offset";
$result = mysqli_query($con, $query);
$report_count = mysqli_num_rows($result);

// Get total number of reports
$total_query = "SELECT COUNT(*) as total FROM ".$siteprefix."reports WHERE status = 'approved' AND user='$seller_id'";
$total_result = mysqli_query($con, $total_query);
$total_row = mysqli_fetch_assoc($total_result);
$total_reports = $total_row['total'];
$total_pages = ceil($total_reports / $limit);
?>
<?php

// Fetch the number of followers
$followersQuery = "SELECT COUNT(*) AS total_followers FROM {$siteprefix}followers WHERE seller_id = '$seller_id'";
$followersResult = mysqli_query($con, $followersQuery);
$followersData = mysqli_fetch_assoc($followersResult);
$totalFollowers = $followersData['total_followers'] ?? 0;

// Fetch the number of followings
$followingsQuery = "SELECT COUNT(*) AS total_followings FROM {$siteprefix}followers WHERE user_id = '$seller_id'";
$followingsResult = mysqli_query($con, $followingsQuery);
$followingsData = mysqli_fetch_assoc($followingsResult);
$totalFollowings = $followingsData['total_followings'] ?? 0;




?>

   <!-- Search Results Header Section -->
    <section id="search-results-header" class="search-results-header section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">
    <!-- Seller Information -->
    <div class="row mb-3">
        <div class="col-lg-12">
            <div class="d-flex align-items-center mb-3">
                <!-- Seller Image -->
                <img src="<?php echo $user_picture; ?>" alt="Seller Photo" class="rounded-circle me-3" style="width: 60px; height: 60px; object-fit: cover;">
                <div>
                    <!-- Seller Name -->
                    <h3><?php echo $user; ?></h3>
                    <!-- About Us -->
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
                    <!-- Follow/Unfollow Button -->
                    </div></div>
					</div></div>

                      <?php
    // Check if the user is already following the seller
    $followQuery = "SELECT * FROM {$siteprefix}followers WHERE user_id = ? AND seller_id = ?";
    $stmt = $con->prepare($followQuery);
    $stmt->bind_param("ii", $user_id, $seller_id);
    $stmt->execute();
    $followResult = $stmt->get_result();
    $isFollowing = $followResult->num_rows > 0;
    ?>

        <div class="search-results-header">
          <div class="row align-items-center">
          
				
                     
    <?php
    // Check if the user is already following the seller
    $followQuery = "SELECT * FROM {$siteprefix}followers WHERE user_id = ? AND seller_id = ?";
    $stmt = $con->prepare($followQuery);
    $stmt->bind_param("ii", $user_id, $seller_id);
    $stmt->execute();
    $followResult = $stmt->get_result();
    $isFollowing = $followResult->num_rows > 0;
    ?>
  <!-- Follow and Sort Controls -->
   
   <div class="col-lg-12">
  <div class="d-flex align-items-center">
     <?php if ($active_log == 1): ?>
                    <!-- Follow Seller -->
                    <form method="POST" class="d-inline me-3">
                        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                        <input type="hidden" name="seller_id" value="<?php echo $seller_id; ?>">
                        <input type="hidden" name="follow_seller_submit" value="1">

                        <?php if ($isFollowing): ?>
                            <div class="dropdown">
                                <button class="btn btn-outline-success btn-sm dropdown-toggle" type="button" id="followingDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    Following
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="followingDropdown">
                                    <li>
                                        <button type="submit" name="action" value="unfollow" class="dropdown-item">
                                            Unfollow
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        <?php else: ?>
                            <button type="submit" name="action" value="follow" class="btn btn-outline-primary btn-sm">
                                Follow Seller
                            </button>
                            
                        <?php endif; ?>
                    </form>
                     <?php endif; ?>
                    <div class="d-flex align-items-center d-none d-md-flex">
                <span class="product-count me-2" style="background-color: orange; color: white; padding: 5px 10px; border-radius: 5px;">Followers: <?php echo $totalFollowers; ?></span>
                <span class="product-count me-2" style="background-color: orange; color: white; padding: 5px 10px; border-radius: 5px;">Followings: <?php echo $totalFollowings; ?></span>
                   </div>
                   
                    <!-- Sort Dropdown -->
                    <div class="d-flex align-items-center me-2">
                        
                        <select id="sort-select" class="form-select form-select-sm" onchange="sortReports(this.value)" style="width: auto;">
                            <option value="relevance" <?php if ($sort === 'relevance') echo 'selected'; ?>>Relevance</option>
                            <option value="price_high" <?php if ($sort === 'price_high') echo 'selected'; ?>>Price - High To Low</option>
                            <option value="price_low" <?php if ($sort === 'price_low') echo 'selected'; ?>>Price - Low To High</option>
                        </select>
                    </div>
                    <div class="product-count me-2" style="background-color: orange; color: white; padding: 5px 10px; border-radius: 5px;">
                        Found <?php echo $report_count; ?> product(s)
                        </div>
                      


                        

                </div>
                <div class="col-lg-12 mt-2 d-block d-md-none">
    <div class="d-flex align-items-center">
        <span class="product-count me-2" style="background-color: orange; color: white; padding: 5px 10px; border-radius: 5px;">Followers: <?php echo $totalFollowers; ?></span>
        <span class="product-count me-2" style="background-color: orange; color: white; padding: 5px 10px; border-radius: 5px;">Followings: <?php echo $totalFollowings; ?></span>
    </div>
</div>
   

        </div>
      </div>
		 </div>
    </section><!-- /Search Results Header Section -->

    
    <section id="best-sellers" class="best-sellers section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row g-4">
          <?php
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
                        include "product-card.php";
                    }
                } else {
                    debug('No reports found.');
                }
                ?>
         

        </div>

      </div>

    </section>

 <!-- Category Pagination Section -->
    <section id="category-pagination" class="category-pagination section">

      <div class="container">
        <nav class="d-flex justify-content-center" aria-label="Page navigation">
          <ul>
                <?php if ($page > 1): ?>
                   <li>
              <a href="?searchterm=<?php echo $filter; ?>&page=<?php echo $page - 1; ?>" aria-label="Previous page">
                <i class="bi bi-arrow-left"></i>
                <span class="d-none d-sm-inline">Previous</span>
              </a>
            </li>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
         <li> <a href="?seller_id=<?php echo $seller_id; ?>&page=<?php echo $i; ?>&sort=<?php echo $sort; ?>" class="btn btn-secondary <?php if ($i == $page) echo 'active'; ?>"><?php echo $i; ?></a>  </li>
    <?php endfor; ?>

    <?php if ($page < $total_pages): ?>
         <li>
              <a href="?seller_id=<?php echo $seller_id; ?>&page=<?php echo $page + 1; ?>&sort=<?php echo $sort; ?>" aria-label="Next page">
                <span class="d-none d-sm-inline">Next</span>
                <i class="bi bi-arrow-right"></i>
              </a>
            </li>
        
    <?php endif; ?>

          
          </ul>
        </nav>
      </div>

    </section><!-- /Category Pagination Section -->

    <script>
    function sortReports(sortValue) {
        const urlParams = new URLSearchParams(window.location.search);
        urlParams.set('sort', sortValue);
        window.location.search = urlParams.toString();
    }
</script>

    <?php include "footer.php"; ?>
