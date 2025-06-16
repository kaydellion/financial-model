<?php

if (isset($_GET['slug'])) {
    // Convert slug back to title-style for DB lookup
    $raw_slug = $_GET['slug'];

    $title = mysqli_real_escape_string($con, $raw_slug); // Updated to use $raw_slug

    // Get report ID by matching title (case-insensitive)
    $slug_sql = "SELECT id FROM " . $siteprefix . "reports 
                 WHERE LOWER(alt_title) = LOWER('$title') AND status = 'approved' LIMIT 1";

    $slug_result = mysqli_query($con, $slug_sql);

    if ($slug_row = mysqli_fetch_assoc($slug_result)) {
        $id = $slug_row['id'];

        $sql = "SELECT r.*, 
                       l.category_name as category_name, 
                       ri.picture, 
                       sc.category_name as subcategory_name, 
                       u.display_name, 
                       u.profile_picture 
                FROM " . $siteprefix . "reports r 
                LEFT JOIN " . $siteprefix . "categories l ON r.category = l.id 
                LEFT JOIN " . $siteprefix . "users u ON r.user = u.s 
                LEFT JOIN " . $siteprefix . "categories sc ON r.subcategory = sc.id 
                LEFT JOIN " . $siteprefix . "reports_images ri ON r.id = ri.report_id 
                WHERE r.id = '$id' AND r.status = 'approved' 
                GROUP BY r.id";

        $sql2 = mysqli_query($con, $sql);

        if (!$sql2) {
            die("Query failed: " . mysqli_error($con));
        }

        if (mysqli_num_rows($sql2) == 0) {
            header("Location: $previousPage");
            exit();
        }

        $row = mysqli_fetch_assoc($sql2);

        $report_id = $row['id'];
        $title = $row['title'];
        $description = $row['description'];
        $category = $row['category_name'];
        $subcategory = $row['subcategory_name'];
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
        $methodology = $row['methodology'];
        $selected_resource_type = $row['use_case'] ?? '';
        $selected_resource_type_array = explode(',', $selected_resource_type);


    } else {
        header("Location: $previousPage");
        exit();
    }

} else {
    header("Location: $previousPage");
    exit();
}


$rating_data = calculateRating($report_id, $con, $siteprefix);
$average_rating = $rating_data['average_rating'];
$review_count = $rating_data['review_count'];

// $loyalty_id=0;
if($active_log != 1){
$loyalty_id=0;
}
/*
$initialtext = "Add to Wishlist";
$initialbtn = "btn-outline-secondary";
*/
 $theinitialicon="";
        if($active_log==1){
        $checkEmail = mysqli_query($con, "SELECT * FROM ".$siteprefix."wishlist WHERE user='$user_id' AND product='$report_id'");
        if(mysqli_num_rows($checkEmail) >= 1 ) {
        $theinitialicon="added";}}

//getresource_type and education_level
$sql = "SELECT * FROM ".$siteprefix."use_cases WHERE id = '$selected_resource_type' ORDER BY  name ASC ";
$result = $con->query($sql);
$resource_types = [];
while ($row = $result->fetch_assoc()) {
    $resource_type = $row['name'];
}





?>