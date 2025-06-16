

<?php include "header.php"; ?>



    <section id="account" class="account section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

    

        <div class="row">
            <div class="col-lg-12">
                 <div class="profile-menu">
                 <div class="row">
          <!-- Profile Menu -->
          <div class="col-lg-2">
           
      <!-- User Info -->
              <div class="user-info" data-aos="fade-right">
                <div class="user-avatar">
                  <img src="<?php echo $imagePath.'/'; echo $profile_picture; ?>" alt="Profile" loading="lazy">
                </div>
                <h3> <?php echo htmlspecialchars($username); ?></h3>
           </div>
           </div>
		   
		   <div class="col-lg-10">
		   <div class="profile-links" data-aos="fade-left">
		     <?php include "links.php"; ?>
            </div>
		   </div>
              </div>		
			   </div>
           </div>
              </div>

				 </div>

</section>



<?php include "footer.php"; ?>