<?php

  //check if its in wishlist
         $theinitialicon="";
        if($active_log==1){
        $checkEmail = mysqli_query($con, "SELECT * FROM ".$siteprefix."wishlist WHERE user='$user_id' AND product='$report_id'");
        if(mysqli_num_rows($checkEmail) >= 1 ) {
        $theinitialicon="added";}}

        // Fetch all images for this report
$images = [];
$sql_images = "SELECT picture FROM {$siteprefix}reports_images WHERE report_id = '$report_id'";
$result_images = mysqli_query($con, $sql_images);
while ($imgRow = mysqli_fetch_assoc($result_images)) {
    $images[] = $imagePath . $imgRow['picture'];
}


?>

          <!-- Product 1 -->
          <div class="col-sm-6 col-lg-3" data-aos="fade-up" data-aos-delay="100">
            <div class="product-card">
              <div class="product-image">
                  <?php if (!empty($images)): ?>
    <img src="<?php echo $images[0]; ?>" class="img-fluid default-image" alt="Product" loading="lazy">
    <?php if (count($images) > 1): ?>
      <img src="<?php echo $images[1]; ?>" class="img-fluid hover-image" alt="Product hover" loading="lazy">
    <?php endif; ?>

  <?php endif; ?>
                <div class="product-tags">
                  <span class="badge bg-accent"><?php echo $category; ?></span>
                  <span class="badge bg-accent"><?php echo $subcategory; ?></span>
                </div>
                
                <div class="product-actions">
                 <button type="button" class="btn-wishlist<?php echo $theinitialicon ? ' '.$theinitialicon : ''; ?>" data-product-id="<?php echo $report_id; ?>">
            <i class="bi <?php echo $theinitialicon ? 'bi-heart-fill' : 'bi-heart'; ?>"></i>
          </button>
                 
                </div>
              </div>
              <div class="product-info">
                <?php if ($loyalty == 1): ?>
                <span class="badge bg-danger mb-1">Loyalty Material</span>
                <?php endif; ?>
                <h3 class="product-title"><a href="<?php echo $siteurl; ?>product?slug=<?php echo $alt_title; ?>"><?php echo $title; ?></a></h3>
                <p>

    <?php if (!empty($selected_resource_type)) { ?>
        <strong>Use Case:</strong> <?php echo  implode(', ', $resourceTypeNames); ?><br>
    <?php } ?>

    </p>
                  <div class="user_info mb-1">
                            <img src="<?php echo $user_picture; ?>" alt="<?php echo $user; ?>" class="img-fluid user-image">
                            <span><?php echo $user; ?></span>
                            </div>
                <div class="product-price">
                  <span class="current-price"><?php echo $sitecurrency; echo $price; ?></span>
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
                --->
              </div>
            </div>
          </div><!-- End Product 1 -->