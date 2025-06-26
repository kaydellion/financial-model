
<?php 
include "header.php";
?>


<?php

if (isset($_GET['blogslug'])) {
    // Convert slug back to title-style for DB lookup
    $raw_slug = $_GET['blogslug'];

    $title = mysqli_real_escape_string($con, $raw_slug); // Updated to use $raw_slug

    // Get report ID by matching title (case-insensitive)
    $slug_sql = "SELECT s FROM " . $siteprefix . "forum_posts
                 WHERE LOWER(slug) = LOWER('$title') LIMIT 1";
                   $slug_result = mysqli_query($con, $slug_sql);

    if ($slug_row = mysqli_fetch_assoc($slug_result)) {
        $forum_id = $slug_row['s'];

            $sql = "SELECT * FROM {$siteprefix}forum_posts WHERE s = $forum_id LIMIT 1";
    $result = mysqli_query($con, $sql);
    $forum = mysqli_fetch_assoc($result);

    // Prepare current values
    $current_title = htmlspecialchars($forum['title'] ?? '');
    $current_article = htmlspecialchars($forum['article'] ?? '');
    $categoryNames = [];
if (!empty($current_categories)) {
    $catIds = array_map('intval', $current_categories);
    $catIdList = implode(',', $catIds);
    if ($catIdList) {
        $catSql = "SELECT category_name FROM {$siteprefix}categories WHERE id IN ($catIdList)";
        $catRes = mysqli_query($con, $catSql);
        while ($catRow = mysqli_fetch_assoc($catRes)) {
            $categoryNames[] = $catRow['category_name'];
        }
    }
}
    $current_image = $imagePath.$forum['featured_image'] ?? '';
    $date = date('d M Y', strtotime($forum['created_at'] ?? ''));
}
}
?>
  <main class="main">

    <!-- Page Title -->
    <div class="page-title light-background">
      <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">Blog Details</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index">Home</a></li>
            <li class="blog"><a href="blog">Blog</a></li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

<div class="container">
      <div class="row">

        <div class="col-lg-8">

          <!-- Blog Details Section -->
          <section id="blog-details" class="blog-details section">
            <div class="container" data-aos="fade-up">

              <article class="article">

                <div class="post-img">
         
<img src="<?php echo $current_image; ?>" alt="Featured blog image" class="img-fluid" loading="lazy">
                </div>

                <div class="article-content" data-aos="fade-up" data-aos-delay="100">
                <div class="meta-categories">
    <?php foreach ($categoryNames as $cat): ?>
        <span class="category"><i class="bi bi-folder"></i> <?php echo htmlspecialchars($cat); ?></span>
    <?php endforeach; ?>
    <span class="reading-time"><i class="bi bi-clock-history"></i> <?php echo $date; ?></span>
</div>

                  <h1 class="title"><?php echo $current_title; ?></h1>
 <div class="meta-top">
                    <ul>
                     
                      <li class="d-flex align-items-center">
                        <i class="bi bi-calendar-date"></i>
                        <time datetime="<?php echo $date; ?>"><?php echo $date; ?></time>
                      </li>
                      <li class="d-flex align-items-center">
                        <i class="bi bi-chat-dots"></i>
                        <a href="#comments">24 Comments</a>
                      </li>
                    </ul>
                  </div>
                   <div class="content">
                    <p><?php echo $current_article; ?></p>


                    </div>

                  <div class="meta-bottom">
               
                  <div class="article-share">
  <span>Share:</span>
  <!-- Web Share API Button (for mobile/modern browsers) -->
  <button type="button" class="btn btn-sm btn-primary" id="webShareBtn" title="Share this post">
    <i class="bi bi-share-fill"></i> Share
  </button>
  <!-- Social Links -->
  <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode($siteurl . 'view-blog.php/' . $raw_slug); ?>&text=<?php echo urlencode($current_title); ?>" target="_blank" rel="noopener" title="Share on Twitter">
    <i class="bi bi-twitter"></i>
  </a>
  <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($siteurl . 'view-blog.php/' . $raw_slug); ?>" target="_blank" rel="noopener" title="Share on Facebook">
    <i class="bi bi-facebook"></i>
  </a>
  <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode($siteurl . 'view-blog.php/' . $raw_slug); ?>&title=<?php echo urlencode($current_title); ?>" target="_blank" rel="noopener" title="Share on LinkedIn">
    <i class="bi bi-linkedin"></i>
  </a>
</div>
                  </div>
                </div>

              </article>

            </div>
          </section><!-- /Blog Details Section -->

      <!-- Blog Comment Form Section -->
          <section id="blog-comment-form" class="blog-comment-form section">

            <div class="container" data-aos="fade-up" data-aos-delay="100">

              <form method="post" role="form">

                <div class="form-header">
                  <h3>Leave a Comment</h3>
                 
                </div>

                <div class="row gy-3">
                  <div class="col-md-6">
                    <div class="input-group">
                      <input type="hidden" name="blog_id" value="<?php echo $forum_id; ?>">
                      <input type="hidden" name="user" required="" value="<?php echo htmlspecialchars($user_id); ?>">
                 
                    </div>
                  </div>

                
             
                  <div class="col-12">
                    <div class="input-group">
                      <label for="comment">Your Comment *</label>
                      <textarea name="comment" id="comment" rows="5" placeholder="Write your thoughts here..." name="comments" required=""></textarea>
                      <span class="error-text">Please enter your comment</span>
                    </div>
                  </div>

                  <div class="col-12 text-center">
                    <button type="submit" name="post_comment">Post Comment</button>
                  </div>
                </div>

              </form>

            </div>

          </section><!-- /Blog Comment Form Section -->
          
          <!-- Blog Comments Section -->
   <section id="blog-comments" class="blog-comments section">
  <div class="container mb-5" data-aos="fade-up" data-aos-delay="100">
    <div class="blog-comments-4">
      <div class="comments-header">
        <h3 class="title">All Comments</h3>
        <?php
        $countRes = mysqli_query($con, "SELECT COUNT(*) as cnt FROM fm_comments WHERE blog_id='$forum_id'");
        $countRow = mysqli_fetch_assoc($countRes);
        ?>
        <div class="comments-stats">
          <span class="count"><?php echo $countRow['cnt']; ?></span>
          <span class="label">Comments</span>
        </div>
      </div>
      <div class="comments-container">
        <?php
        // Fetch main comments (parent_comment_id is '' or '0')
        $mainComments = mysqli_query($con, "SELECT * FROM fm_comments WHERE blog_id='$forum_id' AND (parent_comment_id='' OR parent_comment_id='0') ORDER BY commented_time DESC");
        while ($comment = mysqli_fetch_assoc($mainComments)) {
            $userRes = mysqli_query($con, "SELECT display_name, profile_picture FROM {$siteprefix}users WHERE s='{$comment['user_id']}' LIMIT 1");
            $user = mysqli_fetch_assoc($userRes);
            $avatar = !empty($user['profile_picture']) ? $imagePath . $user['profile_picture'] : $imagePath . 'user-avatar.png';
            $username = $user['display_name'] ?? 'User';
            $replyCountRes = mysqli_query($con, "SELECT COUNT(*) as cnt FROM fm_comments WHERE parent_comment_id='{$comment['s']}'");
            $replyCount = mysqli_fetch_assoc($replyCountRes)['cnt'];
        ?>
        <div class="comment-thread" id="comment-<?php echo $comment['s']; ?>">
          <div class="comment-box">
            <div class="comment-wrapper">
              <div class="avatar-wrapper">
                <img src="<?php echo htmlspecialchars($avatar); ?>" alt="Avatar" loading="lazy">
                
              </div>
              <div class="comment-content">
                <div class="comment-header">
                  <div class="user-info">
                    <h4><?php echo htmlspecialchars($username); ?></h4>
                    <span class="time-badge">
                      <i class="bi bi-clock"></i>
                      <?php echo date('M d, Y H:i', strtotime($comment['commented_time'])); ?>
                    </span>
                  </div>
                </div>
                <div class="comment-body">
                  <p><?php echo nl2br(htmlspecialchars($comment['comments'])); ?></p>
                </div>
                <div class="comment-actions">
                  <button class="action-btn reply-btn" aria-label="Reply to comment" onclick="showReplyForm(<?php echo $comment['s']; ?>)">
                    <i class="bi bi-chat"></i>
                    <span>Reply</span>
                  </button>
                  <?php if ($comment['user_id'] == $user_id): ?>
                <form method="post" action="" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this comment and all its replies?');">
                <input type="hidden" name="delete_comment_id" value="<?php echo $comment['s']; ?>">
                <button type="submit" name="delete_comment" class="action-btn delete-btn" aria-label="Delete comment" style="background:none;border:none;">
                    <i class="bi bi-trash"></i>
                    <span>Delete</span>
                </button>
                </form>
                <?php endif; ?>
                  <?php if ($replyCount > 0): ?>
                    <button class="btn btn-link p-0 ms-2" type="button" onclick="toggleReplies(<?php echo $comment['s']; ?>)">
                      View replies (<?php echo $replyCount; ?>)
                    </button>
                  <?php endif; ?>
                </div>
                <!-- Reply form (hidden by default) -->
                <div class="reply-form mt-2" id="reply-form-<?php echo $comment['s']; ?>" style="display:none;">
                  <form method="post" role="form">
                    <input type="hidden" name="blog_id" value="<?php echo $forum_id; ?>">
                    <input type="hidden" name="user" value="<?php echo htmlspecialchars($user_id); ?>">
                    <input type="hidden" name="parent_comment_id" value="<?php echo $comment['s']; ?>">
                    <div class="input-group">
                      <textarea name="comment" rows="2" class="form-control" placeholder="Write your reply..." required></textarea>
                      <button type="submit" name="post_reply_comment" class="btn btn-primary">Reply</button>
                    </div>
                  </form>
                </div>
                <!-- Replies container (hidden by default) -->
                <div class="replies-container mt-2" id="replies-<?php echo $comment['s']; ?>" style="display:none;">
                  <?php renderReplies($comment['s'], $forum_id, $con, $siteprefix, $imagePath, $user_id); ?>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php } ?>
      </div>
    </div>
  </div>
</section>



        </div>

		    

             <div class="col-lg-4 sidebar">

          <div class="widgets-container">

          
           <!-- Categories Widget -->
          
<div class="categories-widget widget-item">
  <h3 class="widget-title">Categories</h3>
  <ul class="mt-3">
    <?php
    $catSql = "SELECT id, category_name FROM {$siteprefix}categories WHERE parent_id IS NULL ORDER BY category_name ASC";
    $catRes = mysqli_query($con, $catSql);
    while ($catRow = mysqli_fetch_assoc($catRes)) {
        // Count posts in this category
        $catId = $catRow['id'];
        $countRes = mysqli_query($con, "SELECT COUNT(*) as cnt FROM {$siteprefix}forum_posts WHERE FIND_IN_SET($catId, categories)");
        $countRow = mysqli_fetch_assoc($countRes);
        $count = $countRow['cnt'];
        echo '<li><a href="blog.php?category='.$catId.'">'.htmlspecialchars($catRow['category_name']).' <span>(' . $count . ')</span></a></li>';
    }
    ?>
  </ul>
</div><!--/Categories Widget -->

           <!-- Recent Posts Widget -->
<div class="recent-posts-widget widget-item">
  <h3 class="widget-title">Recent Posts</h3>
  <?php
  $recentSql = "SELECT title, slug, featured_image, created_at FROM {$siteprefix}forum_posts ORDER BY created_at DESC LIMIT 5";
  $recentRes = mysqli_query($con, $recentSql);
  while ($recent = mysqli_fetch_assoc($recentRes)) {
      $img = $imagePath . $recent['featured_image'];
      $title = htmlspecialchars($recent['title']);
      $slug = htmlspecialchars($recent['slug']);
      $date = date('M j, Y', strtotime($recent['created_at']));
      echo '<div class="post-item">';
      echo '<img src="'.htmlspecialchars($img).'" alt="" class="flex-shrink-0" style="width:60px;height:60px;object-fit:cover;">';
      echo '<div>';
      echo '<h4><a href="view-blog.php/'.$slug.'">'.$title.'</a></h4>';
      echo '<time datetime="'.$recent['created_at'].'">'.$date.'</time>';
      echo '</div></div>';
  }
  ?>
</div><!--/Recent Posts Widget -->

           

          </div>
		  </div>
                  </div>

                </div>
</main>

<?php include "footer.php"; ?>