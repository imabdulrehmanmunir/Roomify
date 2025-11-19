<?php
// (VII, IX) Start session at the very top
session_start();
date_default_timezone_set("Asia/Karachi"); // Set timezone for Pakistan

// Base URL
define('SITE_URL', 'http://localhost/Roomify/Roomify/'); 
// Absolute server path
define('UPLOAD_IMAGE_PATH', $_SERVER['DOCUMENT_ROOT'].'/Roomify/Roomify/images/');

// Folder Constants
define('ABOUT_FOLDER', 'About/');
define('CAROUSEL_FOLDER', 'Carousel/');
define('FACILITIES_FOLDER', 'Facilities/');
define('ROOMS_FOLDER', 'Rooms/');
define('USERS_FOLDER', 'users/');

// Gmail Credentials
define('SMTP_EMAIL', "imabdulrehmanmuneer@gmail.com"); 
define('SMTP_PASS', "aquw gpoq abix ajfc"); 
define('SMTP_NAME', "Roomify"); // Centralized Name

function alert($type, $msg, $position='body'){
    $bs_class = ($type == 'success') ? 'alert-success' : 'alert-danger';
    $element = <<<alert
        <div class="alert $bs_class alert-dismissible fade show" role="alert">
            <strong class="me-3">$msg</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    alert;

    if($position == 'body'){
        echo '<div class="custom-alert">'.$element.'</div>';
    } else {
        echo $element;
    }
}

function redirect($url){
    echo "<script> window.location.href = '$url'; </script>";
    exit();
}

function adminLogin(){
    if(!(isset($_SESSION['adminLogin']) && $_SESSION['adminLogin'] == true)){
        redirect('index.php');
    }
}

function upload_image($image, $folder)
{
    $valid_mime = ['image/jpeg', 'image/png', 'image/webp', 'image/jpg'];
    $img_mime = $image['type'];

    if(!in_array($img_mime, $valid_mime)){
        return 'inv_img'; 
    }
    else if(($image['size'] / (1024*1024)) > 2){
        return 'inv_size'; 
    }
    else {
        $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
        $rname = 'IMG_'.rand(11111, 99999).".$ext";
        $img_path = UPLOAD_IMAGE_PATH.$folder.$rname;
        if(move_uploaded_file($image['tmp_name'], $img_path)){
            return $rname;
        } else {
            return 'up_failed';
        }
    }
}

function delete_image($image, $folder)
{
    $img_path = UPLOAD_IMAGE_PATH.$folder.$image;
    if(file_exists($img_path)) {
        if(unlink($img_path)){
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function upload_svg_image($image, $folder)
{
    $valid_mime = ['image/svg+xml'];
    $img_mime = $image['type'];

    if(!in_array($img_mime, $valid_mime)){
        return 'inv_img'; 
    }
    else if(($image['size'] / (1024*1024)) > 1){ 
        return 'inv_size'; 
    }
    else {
        $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
        $rname = 'IMG_'.rand(11111, 99999).".$ext";
        $img_path = UPLOAD_IMAGE_PATH.$folder.$rname;
        if(move_uploaded_file($image['tmp_name'], $img_path)){
            return $rname;
        } else {
            return 'up_failed';
        }
    }
}

function upload_user_image($image)
{
    $valid_mime = ['image/jpeg', 'image/png', 'image/webp', 'image/jpg'];
    $img_mime = $image['type'];

    if(!in_array($img_mime, $valid_mime)){
        return 'inv_img'; 
    }
    else {
        $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
        $rname = 'IMG_'.rand(11111, 99999).".jpeg"; 
        
        $img_path = UPLOAD_IMAGE_PATH.USERS_FOLDER.$rname;

        if($ext == 'png' || $ext == 'PNG'){
            $img = imagecreatefrompng($image['tmp_name']);
        } else if($ext == 'webp' || $ext == 'WEBP'){
            $img = imagecreatefromwebp($image['tmp_name']);
        } else {
            $img = imagecreatefromjpeg($image['tmp_name']);
        }

        if(imagejpeg($img, $img_path, 75)){
            return $rname;
        } else {
            return 'up_failed';
        }
    }
}

// MODIFIED: PHPMailer with dynamic Types
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function send_mail($email, $token, $type){
    if($type == 'email_confirmation'){
        $page = 'email_confirm.php';
        $subject = "Account Verification Link";
        $content = "confirm your email";
    } else {
        $page = 'index.php'; 
        $subject = "Account Reset Link";
        $content = "reset your account";
    }

    $email_body = "
        Click the link below to $content: <br>
        <a href='".SITE_URL."$page?$type&email=$email&token=$token'>
            CLICK ME
        </a>
    ";

    require __DIR__ . '/../../vendor/autoload.php';

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();                                            
        $mail->Host       = 'smtp.gmail.com';                     
        $mail->SMTPAuth   = true;                                   
        $mail->Username   = SMTP_EMAIL;                     
        $mail->Password   = SMTP_PASS;                               
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            
        $mail->Port       = 587;                                    

        $mail->setFrom(SMTP_EMAIL, SMTP_NAME);
        $mail->addAddress($email);     

        $mail->isHTML(true);                                  
        $mail->Subject = $subject;
        $mail->Body    = $email_body;

        $mail->send();
        return 1;
    } catch (Exception $e) {
        return 0;
    }
}

?>