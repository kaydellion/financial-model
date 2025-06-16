
<?php include "header.php";


// Pagination setup
$limit = 12; // items per page
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;

// Get total count for pagination
$count_query = "SELECT COUNT(*) as total FROM {$siteprefix}wishlist WHERE user = $user_id";
$count_result = mysqli_query($con, $count_query);
$total_row = mysqli_fetch_assoc($count_result);
$total_items = $total_row['total'];
$total_pages = ceil($total_items / $limit);


?>
  <main class="main">

    <!-- Page Title -->
    <div class="page-title light-background">
      <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">Wishlist</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.php">Home</a></li>
            <li class="current">Wishlist</li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->
  <section id="best-sellers" class="best-sellers section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row">

        <?php
$query = "SELECT r.*, u.display_name, u.profile_picture, l.category_name AS category, sc.category_name AS subcategory, ri.picture 
    FROM ".$siteprefix."reports r 
    LEFT JOIN ".$siteprefix."categories l ON r.category = l.id 
    LEFT JOIN ".$siteprefix."users u ON r.user = u.s 
    LEFT JOIN ".$siteprefix."categories sc ON r.subcategory = sc.id 
    LEFT JOIN ".$siteprefix."reports_images ri ON r.id = ri.report_id 
    LEFT JOIN ".$siteprefix."wishlist w ON r.id = w.product
    WHERE r.status = 'approved' AND w.user = $user_id 
    GROUP BY w.s
    LIMIT $limit OFFSET $offset";
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
        include "wishlist-card.php"; // Include the product card template
        }
    }
?>



</div>
</div>
</section><!-- End Product Details Section -->

<?php if ($total_pages > 1): ?>
<section id="category-pagination" class="category-pagination section">
    <div class="container">
        <nav class="d-flex justify-content-center" aria-label="Page navigation">
            <ul class="pagination">
                <?php if ($page > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $page - 1; ?>" aria-label="Previous page">
                            <i class="bi bi-arrow-left"></i>
                            <span class="d-none d-sm-inline">Previous</span>
                        </a>
                    </li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>

                <?php if ($page < $total_pages): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $page + 1; ?>" aria-label="Next page">
                            <span class="d-none d-sm-inline">Next</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</section>
<?php endif; ?>
</main>
<?php include "footer.php"; ?>