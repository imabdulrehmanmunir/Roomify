<?php
  require('admin/inc/db_config.php');
  require('admin/inc/essentials.php');

  // MODIFIED: Check for 'email' and 'token' directly
  if(isset($_GET['email']) && isset($_GET['token']))
  {
      $data = filteration($_GET);

      $query = select("SELECT * FROM `user_cred` WHERE `email`=? AND `token`=? LIMIT 1", 
        [$data['email'], $data['token']], 'ss');
    
      if(mysqli_num_rows($query) == 1){
          $fetch = mysqli_fetch_assoc($query);
          
          if($fetch['is_verified'] == 1){
              echo "<script>alert('Email already verified!'); window.location.href='index.php';</script>";
          }
          else{
              $update = update("UPDATE `user_cred` SET `is_verified`=? WHERE `id`=?", [1, $fetch['id']], 'ii');
              if($update){
                  echo "<script>alert('Email Verification Successful!'); window.location.href='index.php';</script>";
              }
              else{
                  echo "<script>alert('Email Verification Failed! Server Down!'); window.location.href='index.php';</script>";
              }
          }
      }
      else {
          echo "<script>alert('Invalid Link!'); window.location.href='index.php';</script>";
      }
  }
  else {
      // Redirect if accessed without parameters
      redirect('index.php');
  }
?>