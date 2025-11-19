<?php
  require('../admin/inc/db_config.php');
  require('../admin/inc/essentials.php');

  if(isset($_POST['register']))
  {
    $data = filteration($_POST);

    // Password match check
    if($data['pass'] != $data['cpass']){
        echo 'pass_mismatch';
        exit;
    }

    // User exist check
    $u_exist = select("SELECT * FROM `user_cred` WHERE `email`=? OR `phonenum`=? LIMIT 1", 
        [$data['email'], $data['phonenum']], "ss");

    if(mysqli_num_rows($u_exist) != 0){
        $u_exist_fetch = mysqli_fetch_assoc($u_exist);
        echo ($u_exist_fetch['email'] == $data['email']) ? 'email_already' : 'phone_already';
        exit;
    }

    // Upload user image
    $img = upload_user_image($_FILES['profile']);

    if($img == 'inv_img'){
        echo 'inv_img';
        exit;
    }
    else if($img == 'upd_failed'){
        echo 'upd_failed';
        exit;
    }

    // Send Confirmation Email
    $token = bin2hex(random_bytes(16));

    if(!send_mail($data['email'], $token, "email_confirmation")){
        echo 'mail_failed';
        exit;
    }

    $enc_pass = password_hash($data['pass'], PASSWORD_BCRYPT);

    $query = "INSERT INTO `user_cred`(`name`, `email`, `address`, `phonenum`, `pincode`, `dob`, 
        `profile`, `password`, `token`) VALUES (?,?,?,?,?,?,?,?,?)";
    
    $values = [$data['name'], $data['email'], $data['address'], $data['phonenum'], $data['pincode'], 
        $data['dob'], $img, $enc_pass, $token];
    
    if(insert($query, $values, 'sssssssss')){
        echo 1;
    }
    else {
        echo 'ins_failed';
    }
  }
?>