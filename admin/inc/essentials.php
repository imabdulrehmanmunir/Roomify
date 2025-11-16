<?php
// Start session at the top
session_start();

// --- CORRECTED PATHS BASED ON YOUR URL ---
// Base URL for accessing the site from the browser
define('SITE_URL', 'http://localhost/Roomify/Roomify/'); 
// Absolute server path for PHP file operations
define('UPLOAD_IMAGE_PATH', $_SERVER['DOCUMENT_ROOT'].'/Roomify/Roomify/images/');
// Specific subfolder for team images
define('ABOUT_FOLDER', 'About/');

// Show alert messages (Bootstrap styled)
function alert($type, $msg)
{
    $bs_class = 'alert-warning'; // Default

    if ($type == 'success') {
        $bs_class = 'alert-success';
    } elseif ($type == 'erorr' || $type == 'error' || $type == 'danger') {
        $bs_class = 'alert-danger';
    }

    echo <<<alert
        <div class="alert $bs_class alert-dismissible fade show custom-alert" role="alert">
            <strong class="me-3">$msg</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    alert;
}


// Redirect function
function redirect($url)
{
    echo "<script>
        window.location.href = '$url';
    </script>";
    exit();
}


// Admin login check
function adminLogin()
{
    if (!(isset($_SESSION['adminLogin']) && $_SESSION['adminLogin'] === true)) {
        redirect('index.php');
    }
}


// Upload image function
function upload_image($image, $folder)
{
    $valid_mime = ['image/jpeg', 'image/png', 'image/webp', 'image/jpg'];
    $img_mime = $image['type'];

    if (!in_array($img_mime, $valid_mime)) {
        return 'inv_img';
    } elseif (($image['size'] / (1024 * 1024)) > 2) {
        return 'inv_size';
    } else {
        $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
        $rname = 'IMG_' . rand(11111, 99999) . ".$ext";
        
        $img_path = UPLOAD_IMAGE_PATH . $folder . $rname;

        return move_uploaded_file($image['tmp_name'], $img_path) ? $rname : 'up_failed';
    }
}


// Delete image function
function delete_image($image, $folder)
{
    $img_path = UPLOAD_IMAGE_PATH.$folder.$image;

    if (file_exists($img_path)) {
        return unlink($img_path);
    }

    return false;
}

?>
