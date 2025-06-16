 <div class="swiper-slide">
      <?php
  // Always reset the images array for each card
$images = [];
// Always add the main image first
if (!empty($image_path)) {
    $images[] = $image_path;
}

// Fetch additional images from the database
$img_query = mysqli_query($con, "SELECT picture FROM {$siteprefix}reports_images WHERE report_id = '$report_id' ORDER BY id ASC");
while ($img_row = mysqli_fetch_assoc($img_query)) {
    $img_path = $imagePath . $img_row['picture'];
    // Avoid duplicate if main image is already in $images
    if (!in_array($img_path, $images)) {
        $images[] = $img_path;
    }
}
  ?>
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
             </div>