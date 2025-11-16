<?php
  // (VII, IX) Start session at the very top
  session_start();

  // --- CORRECTED PATHS BASED ON YOUR URL ---
  // Base URL for accessing the site from the browser
  define('SITE_URL', 'http://localhost/Roomify/Roomify/');
  // Absolute server path for PHP file operations
  define('UPLOAD_IMAGE_PATH', $_SERVER['DOCUMENT_ROOT'] . '/Roomify/Roomify/images/');
  // Specific subfolder for team images
  define('ABOUT_FOLDER', 'About/');
  // NEW: Specific subfolder for carousel images
  define('CAROUSEL_FOLDER', 'Carousel/');
  // --- END OF CORRECTIONS ---


  function alert($type, $msg)
  {
    // Map our simple $type to the correct Bootstrap class
    $bs_class = 'alert-warning'; // Default

    if ($type == 'success') {
      $bs_class = 'alert-success';
    }
    // Handle your "erorr" typo from index.php and standard 'error' or 'danger'
    else if ($type == 'erorr' || $type == 'error' || $type == 'danger') {
      $bs_class = 'alert-danger';
    }

    // Use the new $bs_class variable
    echo <<<alert
        <div class="alert $bs_class alert-dismissible fade show custom-alert" role="alert">
            <strong class="me-3">$msg</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    alert;
  }

  // (VIII) Create Redirection function
  function redirect($url)
  {
    echo "<script>
        window.location.href = '$url';
    </script>";
    exit(); // NEW: Added exit()
  }

  // (IX) Create adminLogin check function
  function adminLogin()
  {
    // Check if session is started and adminLogin is set
    if (!(isset($_SESSION['adminLogin']) && $_SESSION['adminLogin'] == true)) {
      // If not logged in, redirect to index.php
      redirect('index.php');
    }
  }

  // NEW: upload_image function
  function upload_image($image, $folder)
  {
    $valid_mime = ['image/jpeg', 'image/png', 'image/webp', 'image/jpg'];
    $img_mime = $image['type'];

    if (!in_array($img_mime, $valid_mime)) {
      return 'inv_img'; // Invalid image format
    } else if (($image['size'] / (1024 * 1024)) > 2) {
      return 'inv_size'; // Invalid size (greater than 2MB)
    } else {
      $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
      $rname = 'IMG_' . rand(11111, 99999) . ".$ext";

      $img_path = UPLOAD_IMAGE_PATH . $folder . $rname;

      if (move_uploaded_file($image['tmp_name'], $img_path)) {
        return $rname;
      } else {
        return 'up_failed'; // Upload failed
      }
    }
  }

  // NEW: delete_image function
  function delete_image($image, $folder)
  {
    $img_path = UPLOAD_IMAGE_PATH . $folder . $image;
    if (file_exists($img_path)) {
      if (unlink($img_path)) {
        return true;
      } else {
        return false;
      }
    } else {
      return false; // File not found
    }
  }

?>