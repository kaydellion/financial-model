
<?php 

include "header.php"; 

if (isset($_GET['use-cases'])) {
    $raw_slug = $_GET['use-cases'];

    $category_names = $raw_slug; // convert to lowercase for ma


    // Prepare SQL: match using LOWER to handle case insensitivity
    $sql = "SELECT * FROM " . $siteprefix . "use_cases WHERE slug = '$category_names'";
    $sql2 = mysqli_query($con, $sql);

    if (!$sql2) {
        die("Query failed: " . mysqli_error($con));
    }

    $count = 0;
    while ($row = mysqli_fetch_array($sql2)) {
        $id = $row['id'];
        $category_name = $row['name'];
        // You can use other fields here too if needed
    }
} else {
    header("Location: $siteurl.index.php");
    exit();
}
$limit = 16; // Number of reports per page
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Handle sorting
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'relevance';
$order_by = "r.id DESC"; // Default sorting by relevance
if ($sort === 'price_high') {
    $order_by = "r.price DESC";
} elseif ($sort === 'price_low') {
    $order_by = "r.price ASC";
}

// Fetch child categories
$child_query = "SELECT id FROM {$siteprefix}use_cases WHERE parent_id = '$id'";
$child_result = mysqli_query($con, $child_query);

while ($row = mysqli_fetch_assoc($child_result)) {
    $resource_type_ids[] = $row['id'];
}
$resource_conditions = [];
foreach ($resource_type_ids as $id) {
    $resource_conditions[] = "FIND_IN_SET('$id', r.use_case)";
}
$resource_condition_sql = implode(" OR ", $resource_conditions);

// ✅ Query (no subcategory anymore)
$query = "
    SELECT r.*, 
           u.display_name, 
           u.profile_picture, 
           ri.picture, 
           l.category_name AS category, 
           sc.category_name AS subcategory
    FROM {$siteprefix}reports r 
    LEFT JOIN {$siteprefix}users u ON r.user = u.s 
    LEFT JOIN {$siteprefix}reports_images ri ON r.id = ri.report_id 
    LEFT JOIN {$siteprefix}categories l ON r.category = l.id 
    LEFT JOIN {$siteprefix}categories sc ON r.subcategory = sc.id 
    WHERE r.status = 'approved' 
      AND ($resource_condition_sql)
    GROUP BY r.id 
    ORDER BY $order_by 
    LIMIT $limit OFFSET $offset
";

$result = mysqli_query($con, $query);
$report_count = mysqli_num_rows($result);

/* ✅ Count query
$total_query = "
    SELECT COUNT(*) as total 
    FROM {$siteprefix}reports r 
    WHERE r.status = 'approved' 
      AND FIND_IN_SET('$resource_type_id', r.resource_type)
";*/
$total_query = "
    SELECT COUNT(*) as total 
    FROM {$siteprefix}reports r 
    WHERE r.status = 'approved' 
      AND ($resource_condition_sql)
";
$total_result = mysqli_query($con, $total_query);
$total_row = mysqli_fetch_assoc($total_result);
$total_reports = $total_row['total'];
$total_pages = ceil($total_reports / $limit);
?>

  <main class="main">

    <!-- Page Title -->
    <div class="page-title light-background">
      <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0"><?php echo $category_name; ?></h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.html">Home</a></li>
            <li class="current">Use Cases</li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

        <div class="container" data-aos="fade-up">
       <div class="row mb-3">
        <div class="col-lg-12">

          <!-- Category Header Section -->
          <section id="category-header" class="category-header section">

            <div class="container" data-aos="fade-up">


                      <div class="col-12 col-md-6 col-lg-6">
                    <div class="filter-item">
                      <label for="sortBy" class="form-label">Sort By</label>
                      <select id="sort-select" class="form-select" onchange="sortReports(this.value)">
                        <option value="" <?php if ($sort === '') echo 'selected'; ?> disabled>- Sort By -</option>
                <option value="relevance" <?php if ($sort === 'relevance') echo 'selected'; ?>>Relevance</option>
                <option value="price_high" <?php if ($sort === 'price_high') echo 'selected'; ?>>Price - High To Low</option>
                <option value="price_low" <?php if ($sort === 'price_low') echo 'selected'; ?>>Price - Low To High</option>
            </select>
                    </div>
                  </div>
                   </div>

                             <div class="row mt-3">
                  <div class="col-12" data-aos="fade-up" data-aos-delay="200">
                    <div class="active-filters">
                    
                      <div class="filter-tags">
                       
                        <button class="clear-all-btn">Found <?php echo $report_count; ?> report(s)</button>
                      </div>
                    </div>
                  </div>
                </div>
                 </div>

            </div>

          </section><!-- /Category Header Section -->

            <!-- Category Product List Section -->
          <section id="category-product-list" class="best-sellers section">

            <div class="container" data-aos="fade-up" data-aos-delay="100">

              <div class="row gy-4">
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
} else {
    echo "<p>No reports found.</p>";
}
?>
            </div>

                 </div>

      

          </section><!-- /Category Product List Section -->


                  <!-- Category Pagination Section -->
          <section id="category-pagination" class="category-pagination section">

            <div class="container">
              <nav class="d-flex justify-content-center" aria-label="Page navigation">
                <ul>
                      <?php if ($page > 1): ?>
                      <li>
                    <a href="?use-cases=<?php echo $id; ?>&page=<?php echo $page - 1; ?>&sort=<?php echo $sort; ?>" aria-label="Previous page">
                      <i class="bi bi-arrow-left"></i>
                      <span class="d-none d-sm-inline">Previous</span>
                    </a>
                  </li>
                <?php endif; ?>
               

                
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                     <li> <a href="?use-cases=<?php echo $id; ?>&page=<?php echo $i; ?>&sort=<?php echo $sort; ?>" class="btn btn-secondary <?php if ($i == $page) echo 'active'; ?>"><?php echo $i; ?></a></li>
                <?php endfor; ?>

                 <?php if ($page < $total_pages): ?>
                   <li> <a href="?use-cases=<?php echo $id; ?>&page=<?php echo $page + 1; ?>&sort=<?php echo $sort; ?>" class="btn btn-primary"><span class="d-none d-sm-inline">Next</span>
                      <i class="bi bi-arrow-right"></i></a></li>
                <?php endif; ?>
                  
                </ul>
              </nav>
            </div>

          </section><!-- /Category Pagination Section -->
		     </div>
			    </div>
				 </div>

</main>

<script>
    function sortReports(sortValue) {
        const urlParams = new URLSearchParams(window.location.search);
        urlParams.set('sort', sortValue);
        window.location.search = urlParams.toString();
    }
</script>

          <?php include "footer.php"; ?>