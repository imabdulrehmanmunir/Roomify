<?php
  // (IX) Include essentials to use session functions
  include "inc/essentials.php";

  // (IX) Destroy the session
  session_destroy();

  // (IX) Redirect back to the login page
  redirect('index.php');
?>