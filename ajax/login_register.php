<?php
  require('../admin/inc/db_config.php');
  require('../admin/inc/essentials.php');
  date_default_timezone_set("Asia/Karachi");

  // --- REGISTRATION LOGIC ---
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

  // --- LOGIN LOGIC ---
  if(isset($_POST['login']))
  {
      $data = filteration($_POST);

      // Check email or mobile
      $u_exist = select("SELECT * FROM `user_cred` WHERE `email`=? OR `phonenum`=? LIMIT 1", 
        [$data['email_mob'], $data['email_mob']], "ss");

      if(mysqli_num_rows($u_exist) == 0){
          echo 'inv_email_mob';
      } 
      else {
          $u_fetch = mysqli_fetch_assoc($u_exist);
          
          if($u_fetch['is_verified'] == 0){
              echo 'not_verified';
          }
          else if($u_fetch['status'] == 0){
              echo 'inactive';
          }
          else {
              if(!password_verify($data['pass'], $u_fetch['password'])){
                  echo 'invalid_pass';
              }
              else {
                  // Login Successful
                  // session_start(); REMOVED DUPLICATE
                  $_SESSION['login'] = true;
                  $_SESSION['uId'] = $u_fetch['id'];
                  $_SESSION['uName'] = $u_fetch['name'];
                  $_SESSION['uPic'] = $u_fetch['profile'];
                  $_SESSION['uPhone'] = $u_fetch['phonenum'];
                  echo 1;
              }
          }
      }
  }

  // --- FORGOT PASSWORD RECOVERY LOGIC ---
  if(isset($_POST['recover_user']))
  {
      $data = filteration($_POST);

      $u_exist = select("SELECT * FROM `user_cred` WHERE `email`=? LIMIT 1", [$data['email']], "s");

      if(mysqli_num_rows($u_exist) == 0){
          echo 'inv_email';
      }
      else {
          $u_fetch = mysqli_fetch_assoc($u_exist);
          
          if($u_fetch['is_verified'] == 0){
              echo 'not_verified';
          }
          else if($u_fetch['status'] == 0){
              echo 'inactive';
          }
          else {
              // Generate Token & Expiry
              $token = bin2hex(random_bytes(16));
              $date = date("Y-m-d");

              $query = "UPDATE `user_cred` SET `token`=?, `t_expire`=? WHERE `id`=?";
              $values = [$token, $date, $u_fetch['id']];
              
              if(update($query, $values, 'ssi')){
                  if(send_mail($data['email'], $token, 'account_recovery')){
                      echo 1;
                  } else {
                      echo 'mail_failed';
                  }
              } else {
                  echo 'upd_failed';
              }
          }
      }
  }

  // --- PASSWORD RESET LOGIC ---
  if(isset($_POST['reset_pass']))
  {
      $data = filteration($_POST);

      if($data['pass'] != $data['cpass']){
          echo 'mismatch';
          exit;
      }

      $enc_pass = password_hash($data['pass'], PASSWORD_BCRYPT);

      $query = "UPDATE `user_cred` SET `password`=?, `token`=?, `t_expire`=? WHERE `email`=? AND `token`=?";
      $values = [$enc_pass, null, null, $data['email'], $data['token']];

      if(update($query, $values, 'sssss')){
          echo 1;
      } else {
          echo 'failed';
      }
  }

?>