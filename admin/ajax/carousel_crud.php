<?php
  // (I) Include config and essentials
  // MODIFIED: Changed to require_once to prevent redeclaration errors
  require_once('../inc/db_config.php');
  require('../inc/essentials.php');

  // (I) Check if admin is logged in
  adminLogin();

  /**
   * NEW: Handle add_image POST request
   * Adds a new carousel image
   */
  if (isset($_POST['add_image'])) {
    $frm_data = filteration($_POST);

    // Upload image
    // Pass file data and folder name to upload_image function
    $img_r = upload_image($_FILES['carousel_picture'], CAROUSEL_FOLDER);

    if ($img_r == 'inv_img' || $img_r == 'inv_size' || $img_r == 'up_failed') {
      echo $img_r; // Echo error code back to JS
    } else {
      // Insert into db
      $q = "INSERT INTO `carousel` (`image`) VALUES (?)";
      $values = [$img_r];
      $res = insert($q, $values, 's');
      echo $res; // Echo 1 for success
    }
  }

  /**
   * NEW: Handle get_carousel POST request
   * Fetches all carousel images and builds HTML
   */
  if (isset($_POST['get_carousel'])) {
    $res = select_all('carousel');

    // Construct the URL path to the images folder
    $path = SITE_URL . 'images/' . CAROUSEL_FOLDER;

    while ($row = mysqli_fetch_assoc($res)) {
      // Output HTML for each team member card
      echo <<<data
        <div class="col-md-3 mb-3">
            <div class="card bg-dark text-white">
                <img src="$path$row[image]" class="card-img" style="height: 200px; object-fit: cover;">
                <div class="card-img-overlay text-end">
                    <button type="button" onclick="rem_image($row[sr_no])" class="btn btn-danger btn-sm shadow-none">
                        <i class="bi bi-trash"></i> Delete
                    </button>
                </div>
            </div>
        </div>
data;
    }
  }

  /**
   * NEW: Handle rem_image POST request
   * Removes a carousel image
   */
  if (isset($_POST['rem_image'])) {
    $frm_data = filteration($_POST);
    $values = [$frm_data['rem_image']];

    // 1. Get the image name to delete it from folder
    $q_select = "SELECT * FROM `carousel` WHERE `sr_no`=?";
    $res_select = select($q_select, $values, 'i');
    $img = mysqli_fetch_assoc($res_select);

    if ($img) {
      // 2. Delete the image from server folder
      if (delete_image($img['image'], CAROUSEL_FOLDER)) {
        // 3. Delete the record from database
        $q_delete = "DELETE FROM `carousel` WHERE `sr_no`=?";
        $res_delete = delete($q_delete, $values, 'i');
        echo $res_delete; // Echo 1 if successful
      } else {
        echo 0; // Echo 0 if image deletion failed
      }
    } else {
      echo 0; // Member not found
    }
  }

?>