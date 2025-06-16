<?php
include "../../backend/connect.php"; 
$siteprefix="fm_";
$action = $_GET['action'];


if($action == 'deleteimage'){
    // Fetch the image file name
    $image_id = $_GET['image_id'];
    $query = "SELECT picture FROM ".$siteprefix."reports_images WHERE id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $image_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $image = $result->fetch_assoc();
    $stmt->close();

    if ($image) {
        // Delete the image file from the server
        $file_path = '../../uploads/' . $image['picture'];
        if (file_exists($file_path)) {
            unlink($file_path);
        }

        // Delete the image record from the database
        $delete_query = "DELETE FROM ".$siteprefix."reports_images WHERE id = ?";
        $delete_stmt = $con->prepare($delete_query);
        $delete_stmt->bind_param("i", $image_id);
        $delete_stmt->execute();
        $delete_stmt->close();

        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Image not found.']);
    }
} 


if($action == 'deletefile'){
    // Fetch the image file name
    $image_id = $_GET['image_id'];
    $query = "SELECT * FROM ".$siteprefix."reports_files WHERE id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $image_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $image = $result->fetch_assoc();
    $stmt->close();

    if ($image) {
        // Delete the image record from the database
        $delete_query = "DELETE FROM ".$siteprefix."reports_files WHERE id = ?";
        $delete_stmt = $con->prepare($delete_query);
        $delete_stmt->bind_param("i", $image_id);
        $delete_stmt->execute();
        $delete_stmt->close();

        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'File not found.']);
    }
} 





if($action == 'deleteproduct'){ 
    $imageId = mysqli_real_escape_string($con, $_GET["image_id"]); // Fix to $_GET
    if (mysqli_query($con, "DELETE FROM fg_products_media WHERE s='$imageId'")) {
        echo 'Deleted Successfully.';
    } else {
        echo 'Failed to delete product media: ' . mysqli_error($con);
    }
}

if($action == 'deletegig'){ 
    $imageId = mysqli_real_escape_string($con, $_GET["image_id"]); // Fix to $_GET
    if (mysqli_query($con, "DELETE FROM fg_gigs_media WHERE s='$imageId'")) {
        echo 'Deleted Successfully.';
    } else {
        echo 'Failed to delete gig media: ' . mysqli_error($con);
    }
}

if($action == 'deletecart'){ 
    $imageId = mysqli_real_escape_string($con, $_GET["image_id"]); // Fix to $_GET
    if (mysqli_query($con, "DELETE FROM fg_product_sales WHERE s='$imageId'")) {
        echo 'Deleted Successfully.';
    } else {
        echo 'Failed to delete item: ' . mysqli_error($con);
    }
}



if($action == 'deleteguidancevideo'){
   $image_id = $_GET['image_id'];
    // Fetch the video file name
    $query = "SELECT video_filename FROM ".$siteprefix."guidance WHERE s = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $image_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $video = $result->fetch_assoc();
    $stmt->close();

    if ($video) {
        // Delete the video file from the server
        $file_path = '../../uploads/' . $video['video_filename'];
        if (file_exists($file_path)) {
            unlink($file_path);
        }

        // Delete the video record from the database
        $delete_query = "DELETE FROM ".$siteprefix."guidance WHERE s = ?";
        $delete_stmt = $con->prepare($delete_query);
        $delete_stmt->bind_param("i", $image_id);
        $delete_stmt->execute();
        $delete_stmt->close();

        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Guidance video not found.']);
    }
}

if($action == 'deletedocfile'){
   $image_id = $_GET['image_id'];
    // Fetch the document file name
    $query = "SELECT filename FROM ".$siteprefix."doc_file WHERE s = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $image_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $docfile = $result->fetch_assoc();
    $stmt->close();

    if ($docfile) {
        // Delete the document file from the server
        $file_path = '../../uploads/' . $docfile['filename'];
        if (file_exists($file_path)) {
            unlink($file_path);
        }

        // Delete the document record from the database
        $delete_query = "DELETE FROM ".$siteprefix."doc_file WHERE s = ?";
        $delete_stmt = $con->prepare($delete_query);
        $delete_stmt->bind_param("i", $image_id);
        $delete_stmt->execute();
        $delete_stmt->close();

        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Document file not found.']);
    }
}

?>