<?php 
  // (VII) Include essentials first to start session
  include "inc/essentials.php";
  require_once("inc/db_config.php");

  // (IX) Check if user is already logged in, redirect to dashboard
  if(isset($_SESSION['adminLogin']) && $_SESSION['adminLogin'] == true){
    redirect('dashboard.php');
  }
?>
<?php 
  if(isset($_POST['login'])){
    $flr_data = filteration($_POST);
    $query = "SELECT * FROM `admin_cred` WHERE `admin_name`=? AND `admin_pass`=?";
    $values = [$flr_data['admin_name'],$flr_data['admin_pass']];
    $res = select($query,$values,"ss");
    if ($res->num_rows==1) {
      // (VII) Successful Login: Fetch user data
      $row = mysqli_fetch_assoc($res);
      
      // (VII) Set session variables
      $_SESSION['adminLogin'] = true;
      $_SESSION['adminId'] = $row['sr_no']; // Use sr_no as per your steps

      // (VII) Regenerate session ID
      session_regenerate_id(true);

      // (VII) Redirect to dashboard
      redirect('dashboard.php');
    } else {
      alert("erorr",'Login Failed - INVALID Credentials!');
    }
    

  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Roomify | Admin Login</title>
  <?php require('inc/links.php'); ?>
  <style>
    /* ===== GLOBAL STYLES ===== */
    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      padding: 0;
      font-family: "Poppins", sans-serif;
      background: #0d0d0d;
      color: #fff;
      overflow: hidden;
    }

    /* ===== BACKGROUND ANIMATION ===== */
    .background-blur {
      position: absolute;
      width: 100%;
      height: 100%;
      overflow: hidden;
      z-index: 0;
    }

    .blur-circle {
      position: absolute;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.04);
      filter: blur(60px);
      animation: float 12s ease-in-out infinite;
    }

    .blur-circle:nth-child(1) {
      width: 300px;
      height: 300px;
      top: 10%;
      left: 15%;
      animation-delay: 0s;
    }

    .blur-circle:nth-child(2) {
      width: 250px;
      height: 250px;
      bottom: 10%;
      right: 10%;
      animation-delay: 3s;
    }

    .blur-circle:nth-child(3) {
      width: 200px;
      height: 200px;
      top: 60%;
      left: 50%;
      animation-delay: 6s;
    }

    @keyframes float {
      0% { transform: translateY(0); opacity: 0.7; }
      50% { transform: translateY(-20px); opacity: 1; }
      100% { transform: translateY(0); opacity: 0.7; }
    }

    /* ===== LAYOUT ===== */
    .login-wrapper {
      position: relative;
      z-index: 2;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 20px;
    }

    .login-box {
      width: 100%;
      max-width: 420px;
      background: rgba(255, 255, 255, 0.05);
      backdrop-filter: blur(20px);
      border: 1px solid rgba(255, 255, 255, 0.1);
      border-radius: 20px;
      padding: 40px 35px;
      box-shadow: 0 8px 35px rgba(0, 0, 0, 0.4);
      animation: fadeUp 1s ease-out;
      transition: 0.3s;
    }

    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(40px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .login-box:hover {
      transform: scale(1.01);
      box-shadow: 0 10px 40px rgba(255, 255, 255, 0.05);
    }

    /* ===== BRANDING ===== */
    .brand {
      text-align: center;
      margin-bottom: 35px;
    }

    .brand h1 {
      font-weight: 700;
      font-size: 2.7rem;
      color: #eaeaea;
      letter-spacing: 1px;
    }

    .brand p {
      font-weight: 300;
      color: #aaa;
      font-size: 1rem;
    }

    /* ===== FORM INPUTS ===== */
      .form-control {
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 10px;
        color: #fff !important;           /* Ensures text always visible */
        caret-color: #fff;                /* White blinking cursor */
        transition: all 0.3s ease;
      }

      .form-control::placeholder {
        color: rgba(255, 255, 255, 0.6);    /* Slightly visible placeholder */
      }

      .form-control:focus {
        border-color: #fff;
        background: rgba(255, 255, 255, 0.12); /* Slightly brighter while typing */
        box-shadow: 0 0 10px rgba(255, 255, 255, 0.25);
        color: #fff;                       /* Keeps text visible during typing */
      }


    /* ===== BUTTON ===== */
    .btn-login {
      background: #fff;
      color: #000;
      border: none;
      border-radius: 10px;
      font-size: 1.05rem;
      font-weight: 600;
      padding: 12px 0;
      margin-top: 10px;
      transition: all 0.3s ease;
    }

    .btn-login:hover {
      background: #eaeaea;
      transform: translateY(-2px);
      box-shadow: 0 5px 20px rgba(255, 255, 255, 0.15);
    }

    .bi {
      color: #eaeaea;
    }

    /* ===== RESPONSIVE DESIGN ===== */
    @media (max-width: 768px) {
      body {
        background: #0f0f0f;
        overflow-y: auto;
      }

      .login-box {
        padding: 30px 25px;
        max-width: 360px;
      }

      .brand h1 {
        font-size: 2.2rem;
      }

      .btn-login {
        font-size: 1rem;
      }
    }

    @media (max-width: 480px) {
      .login-box {
        max-width: 320px;
        padding: 25px 20px;
      }

      .brand h1 {
        font-size: 1.9rem;
      }
    }
  </style>
</head>
<body>

  <!-- Background Glow Animation -->
  <div class="background-blur">
    <div class="blur-circle"></div>
    <div class="blur-circle"></div>
    <div class="blur-circle"></div>
  </div>

  <!-- Login Form -->
  <div class="login-wrapper">
    <div class="login-box">
      <div class="brand">
        <h1>Roomify</h1>
        <p>Admin Control Panel</p>
      </div>

      <form id="login-form" method="POST">
        <div class="text-center mb-4">
          <i class="bi bi-shield-lock-fill" style="font-size: 3.5rem;"></i>
        </div>

        <div class="form-floating mb-3">
          <input type="text" name="admin_name" class="form-control shadow-none" id="adminNameInput" placeholder="Admin Name" required>
          <label for="adminNameInput"><i class="bi bi-person-circle me-2"></i>Admin Name</label>
        </div>

        <div class="form-floating mb-4">
          <input type="password" name="admin_pass" class="form-control shadow-none" id="adminPassInput" placeholder="Password" required>
          <label for="adminPassInput"><i class="bi bi-key-fill me-2"></i>Password</label>
        </div>

        <button name="login" type="submit" class="btn btn-login w-100">LOGIN</button>
      </form>
    </div>
  </div>
  
  <?php require('inc/script.php'); ?>
</body>
</html>