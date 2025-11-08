<?php
  // (V) Include DB config and essentials
  require('../inc/db_config.php');
  require('../inc/essentials.php');
  
  // (V) Security check
  adminLogin();

  // (V) Get General Settings Logic
  if(isset($_POST['get_general']))
  {
    $q = "SELECT * FROM `settings` WHERE `sr_no`=?";
    $values = [1];
    $res = select($q, $values, "i"); // 'i' for integer
    $data = mysqli_fetch_assoc($res);
    $json_data = json_encode($data);
    echo $json_data;
  }

  // (VI) Update General Settings Logic
  if(isset($_POST['upd_general']))
  {
    // (VI) Filter the incoming data
    $frm_data = filteration($_POST);
    
    $q = "UPDATE `settings` SET `site_title`=?, `site_about`=? WHERE `sr_no`=?";
    $values = [$frm_data['site_title'], $frm_data['site_about'], 1];
    $res = update($q, $values, 'ssi'); // 'ssi' for string, string, integer
    echo $res;
  }
  
  // (VII) Update Shutdown Mode Logic
  if(isset($_POST['upd_shutdown']))
  {
    $frm_data = filteration($_POST);
    
    // (VII) Use ternary operator to flip the value
    $q = "UPDATE `settings` SET `shutdown`=? WHERE `sr_no`=?";
    // If incoming value is 0 (off), set to 1 (on). If 1 (on), set to 0 (off).
    $values = [($frm_data['upd_shutdown'] == 0) ? 1 : 0, 1]; 
    $res = update($q, $values, 'ii'); // 'ii' for integer, integer
    echo $res;
  }

?>