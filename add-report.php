<?php include "header.php"; ?>
<main class="main">
    <!-- Page Title -->
    <div class="page-title light-background">
      <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">Add Report</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.php">Home</a></li>
            <li class="current">Add Models</li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->
    <section id="checkout" class="checkout section">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row">
          <div class="col-lg-9 mx-auto">
            <div class="checkout-container" data-aos="fade-up">
              <form method="POST" enctype="multipart/form-data">
 <div class="checkout-section">
                  <div class="section-header">
                    <h3>Add Models</h3>
                  </div>

<!-- Basic Layout -->
   <div class="section-content">
               <div class="row">

                      <div class="mb-3 form-group">
                      <input type="file" class="form-control" id="imageInput" name="images[]" multiple accept="image/*">
                      <div id="preview" class="preview-container"></div>
                      </div>
                      <input type="hidden" name="user" value="<?php echo $user_id; ?>">

                      <div class="mb-3 form-group">
                          <label class="form-label" for="course-id">Report ID</label>
                            <input type="text" id="course-id" name="id" class="form-control" value="PH<?php echo sprintf('%06d', rand(1, 999999)); ?>" readonly required>
                        </div>

                        <div class="mb-3 form-group">
                          <label class="form-label" for="basic-default-fullname">Title</label>
                          <input type="text" class="form-control" name="title" id="basic-default-fullname" placeholder="Learning loops" required>
                        </div>

                        <div class="mb-3 form-group">
                          <label class="form-label" for="basic-default-message">Description</label>
                          <textarea id="basic-default-message" name="description" class="form-control" placeholder="Write required information or details here...."></textarea>
                        </div>

                        <!-----
                        <div class="mb-3">
                          <label class="form-label" for="basic-default-message">Preview Content</label>
                          <textarea id="basic-default-message" name="preview" class="form-control editor" placeholder="Write required information or details here...."></textarea>
                        </div>

                        <div class="mb-3">
                          <label class="form-label" for="basic-default-message">Table of Contents</label>
                          <textarea id="basic-default-message" name="table_content" class="form-control editor" placeholder="Write required information or details here...."></textarea>
                        </div>

                        <div class="mb-3">
                          <label class="form-label" for="basic-default-message">Methodology</label>
                          <textarea id="basic-default-message" name="methodology" class="form-control editor" placeholder="Write required information or details here...."></textarea>
                        </div>
----->
                        <h6>Area of Specialization:</h6>
                         <div class="mb-3 form-group">
                          <label class="form-label" for="course-category">Category</label>
                        <select class="form-select" name="category" aria-label="Default select example" required>
                          <option selected>- Select Category -</option>
                          <?php
                    $sql = "SELECT * FROM " . $siteprefix . "categories WHERE parent_id IS NULL ";
                     $sql2 = mysqli_query($con, $sql);
                     while ($row = mysqli_fetch_array($sql2)) {
                     echo '<option value="' . $row['id'] . '">' . $row['category_name'] . '</option>'; }?>
                        </select>
                        </div>

                        <div class="mb-3" id="subcategory-container" style="display:none;">
                          <select class="form-select" name="subcategory" id="subcategory-select" required>
                            <option selected>- Select Subcategory -</option>
                          </select>
                        </div>
<?php
$sql = "SELECT * FROM " . $siteprefix . "use_cases ORDER BY parent_id ASC, name ASC";
$result = $con->query($sql);
$resources = [];
while ($row = $result->fetch_assoc()) {
    $resources[$row['parent_id']][] = $row;
}
?>

<div class="mb-3 form-group">
  <label class="form-label" for="resourceType">Use Cases</label>
  <select name="resource_type[]" id="resourceType" multiple class="form-select mb-4 select-multiple" onchange="togglePast()" required>
    <option value="">-- Select Use Cases --</option>
    <?php
    if (isset($resources[NULL])) {
        foreach ($resources[NULL] as $parent) {
            echo '<optgroup label="' . htmlspecialchars($parent['name']) . '">';
            if (!empty($resources[$parent['id']])) {
                foreach ($resources[$parent['id']] as $child) {
                    echo '<option value="' . $child['id'] . '">' . htmlspecialchars($child['name']) . '</option>';
                }
            }
            echo '</optgroup>';
        }
    }
    ?>
  </select>
</div>

  <h6>Pricing and File Upload</h6>
                        <div class="mb-3 form-group">
                          <label class="form-label" for="pricing-type">Pricing Type</label>
                          <select id="pricing-type" name="pricing" class="form-control" onchange="togglePrice()" required>
                            <option value="free">Free</option>
                            <option value="paid">Paid</option>
                          </select>
                        </div>

                        <div class="mb-3" id="price-field" style="display:none;">
                          <label class="form-label" for="course-price">Price</label>
                          <p class="text-muted"></p>
                          <input type="number" id="course-price" name="price" class="form-control" step="0.01">
                        </div>
  <div class="mb-3 form-group">
        <label for="documentSelect" class="form-label ">Select Document Types:</label>
        <select class="form-control" id="documentSelect"  required  onchange="handleDocumentSelect(this)">
             <option value="">  Select Option</option>
          <option value="word">Word Document (.doc, .docx)</option>
          <option value="excel">Excel Spreadsheet (.xls, .xlsx)</option>
          <option value="powerpoint">PowerPoint Presentation (.ppt, .pptx)</option>
          <option value="googleSheets">Google Sheets (.xlsx, .csv, .tsv, .ods, .pdf)</option>
          <option value="pdf">PDF Document (.pdf)</option>
          <option value="text">Text File (.txt)</option>
          <option value="zip">Zip File (.zip)</option>
        </select>
      </div>
      
      <div id="pageInputs"></div>

<h6>Other Resources</h6>
<div class="mb-3 form-group">
  <label class="form-label" for="supportDocSelect">Upload Files:</label>
  <select name="supportDocSelect[]" id="supportDocSelect" multiple class="form-select mb-4 select-multiple" onchange="handleSupportDocSelect(this)">
    <?php
      $sql = "SELECT * FROM {$siteprefix}type_business_docs ORDER BY name ASC";
      $result = mysqli_query($con, $sql);
      $resourceOptions = [];
      while ($row = mysqli_fetch_assoc($result)) {
         $resourceOptions[] = $row;
         echo '<option value="' . $row['id'] . '">' . htmlspecialchars($row['name']) . '</option>';
      }
    ?>
  </select>
</div>

<?php foreach ($resourceOptions as $row): ?>
  <div class="mb-3 supportDocFileInput form-group" id="fileInput_<?php echo $row['id']; ?>" style="display:none;">
    <label class="form-label" for="file_<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['name']); ?> File</label>
    <input type="file" class="form-control mb-2" id="file_<?php echo $row['id']; ?>" name="support_files[<?php echo $row['id']; ?>]">
    <label class="form-label" for="price_<?php echo $row['id']; ?>">Price for <?php echo htmlspecialchars($row['name']); ?></label>
    <input type="number" class="form-control" id="price_<?php echo $row['id']; ?>" name="support_prices[<?php echo $row['id']; ?>]" step="0.01" min="0">
  </div>
<?php endforeach; ?>

<div class="mb-3">
  <label class="form-label" for="guidanceSelect">Guidance:</label>
  <select class="form-select" id="guidanceSelect" onchange="handleGuidanceSelect(this)">
    <option value="">-- Select Guidance Type --</option>
    <option value="methodology">Step-By-Step Methodology</option>
    <option value="video">Explanatory Video</option>
  </select>
</div>

<!-- Methodology Textarea -->
<div class="mb-3" id="methodologyBox" style="display: none;">
  <label class="form-label" for="basic-default-message">Methodology</label>
   <textarea id="basic-default-message" name="methodology" class="form-control" placeholder="Write required information or details here...."></textarea>
</div>

<!-- Video File Input -->
<div class="mb-3" id="videoBox" style="display: none;">
  <label class="form-label" for="guidanceVideo">Upload Video</label>
  <input type="file" class="form-control" id="guidanceVideo" name="guidance_video" accept="video/*">
</div>

   <h6>Additional Information</h6>
                        <div class="mb-3">
                          <label class="form-label" for="course-tags">Tags & Keywords</label>
                          <input type="text" id="course-tags" name="tags" class="form-control" placeholder="Separate tags with commas" required>
                        </div>
                        <p><button type="submit" name="savedcourse" value="savedcourse" class="btn btn-secondary">Save as Draft</button>
                      <button type="submit" name="addcourse" value="course" class="btn btn-primary">Add Report</button></p>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </section>



          
                        <script>
                        document.querySelector('select[name="category"]').addEventListener('change', function() {
                          let parentId = this.value;
                          let subSelect = document.getElementById('subcategory-container');
                          let subcategorySelect = document.getElementById('subcategory-select');
                          
                          fetch(`get_subcategories.php?parent_id=${parentId}`)
                            .then(response => response.json())
                            .then(data => {
                              console.log('Received data:', data);
                              if (data.length > 0) {
                                subcategorySelect.innerHTML = '<option selected>- Select Subcategory -</option>';
                                data.forEach(cat => {
                                  console.log('Processing category:', cat);
                                  subcategorySelect.innerHTML += `<option value="${cat.s}">${cat.title}</option>`;
                                });
                                subSelect.style.display = 'block';
                              } else {
                                console.log('No subcategories found');
                                subSelect.style.display = 'none';
                              }
                            })
                            .catch(error => {
                              console.error('Error fetching subcategories:', error);
                            });
                        });
                        </script>
            <?php include "footer.php"; ?>
