<?php
  require_once('admin/inc/db_config.php');
  require_once('admin/inc/essentials.php');

  // Fetch contact details
  $q = "SELECT * FROM `contact_details` WHERE `sr_no`=?";
  $values = [2];
  $contact_r = mysqli_fetch_assoc(select($q, $values, "i"));

  // Fetch Settings
  $settings_q = "SELECT * FROM `settings` WHERE `sr_no`=?";
  $values = [2];
  $settings_r = mysqli_fetch_assoc(select($settings_q, $values, "i"));

  // Check login session for User Image
  if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
    $path = USERS_FOLDER;
    $uPic = $_SESSION['uPic'];
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
  <title><?php echo $settings_r['site_title'] ?> - Roomify</title>
  <link href="https://fonts.googleapis.com/css2?family=Merienda&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="css/common.css">
</head>

<body class="bg-light">

  <nav class="navbar navbar-expand-lg navbar-light bg-white px-lg-3 py-lg-2 shadow-sm sticky-top">
    <div class="container-fluid">
      <a class="navbar-brand me-5 fw-bold fs-3 h-font" href="index.php"><?php echo $settings_r['site_title'] ?></a>
      <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#nav-bar">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="nav-bar">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link" href="index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link me-2" href="rooms.php">Rooms</a>
          </li>
          <li class="nav-item">
            <a class="nav-link me-2" href="facilities.php">Facilites</a>
          </li>
          <li class="nav-item">
            <a class="nav-link me-2" href="contact.php">Contact Us</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="about.php">About</a>
          </li>
        </ul>
        <div class="d-flex">
          <?php
            if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
              // Show User Dropdown if logged in
              echo <<<data
                <div class="btn-group">
                  <button type="button" class="btn btn-outline-dark shadow-none dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                    <img src="$path$uPic" style="width: 25px; height: 25px;" class="me-1 rounded-circle">
                    $_SESSION[uName]
                  </button>
                  <ul class="dropdown-menu dropdown-menu-lg-end">
                    <li><a class="dropdown-item" href="profile.php">Profile</a></li>
                    <li><a class="dropdown-item" href="bookings.php">Bookings</a></li>
                    <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                  </ul>
                </div>
              data;
            } else {
              // Show Login/Register buttons
              echo <<<data
                <button type="button" class="btn btn-outline-dark shadow-none me-lg-2 me-3" data-bs-toggle="modal" data-bs-target="#loginModal">
                  Login
                </button>
                <button type="button" class="btn btn-outline-dark shadow-none" data-bs-toggle="modal" data-bs-target="#registerModal">
                  Register
                </button>
              data;
            }
          ?>
        </div>
      </div>
    </div>
  </nav>

  <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form id="login-form">
          <div class="modal-header">
            <h5 class="modal-title d-flex align-items-center">
              <i class="bi bi-person-circle me-2"></i>User Login
            </h5>
            <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label">Email / Mobile</label>
              <input type="text" name="email_mob" class="form-control shadow-none" required>
            </div>
            <div class="mb-4">
              <label class="form-label">Password</label>
              <input type="password" name="pass" class="form-control shadow-none" required>
            </div>
            <div class="d-flex w-100 align-items-center justify-content-between mb-2">
              <button type="submit" class="btn btn-dark shadow-none">Login</button>
              <button type="button" class="btn text-secondary text-decoration-none shadow-none p-0" data-bs-toggle="modal" data-bs-target="#forgotModal" data-bs-dismiss="modal">
                Forgot Password?
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="modal fade" id="forgotModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form id="forgot-form">
          <div class="modal-header">
            <h5 class="modal-title d-flex align-items-center">
              <i class="bi bi-person-circle me-2"></i>Forgot Password
            </h5>
            <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">
              Note: A link will be sent to your email to reset your password.
            </span>
            <div class="mb-4">
              <label class="form-label">Email</label>
              <input type="email" name="email" class="form-control shadow-none" required>
            </div>
            <div class="mb-2 text-end">
              <button type="button" class="btn shadow-none p-0 me-2" data-bs-toggle="modal" data-bs-target="#loginModal" data-bs-dismiss="modal">
                CANCEL
              </button>
              <button type="submit" class="btn btn-dark shadow-none">SEND LINK</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="modal fade" id="recoveryModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form id="recovery-form">
          <div class="modal-header">
            <h5 class="modal-title d-flex align-items-center">
              <i class="bi bi-shield-lock me-2"></i>Set New Password
            </h5>
            <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="mb-4">
              <label class="form-label">New Password</label>
              <input type="password" name="pass" class="form-control shadow-none" required>
            </div>
            <div class="mb-4">
              <label class="form-label">Confirm Password</label>
              <input type="password" name="cpass" class="form-control shadow-none" required>
            </div>
            <input type="hidden" name="email">
            <input type="hidden" name="token">

            <div class="mb-2 text-center">
              <button type="submit" class="btn btn-dark shadow-none">RESET PASSWORD</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form id="register-form">
          <div class="modal-header">
            <h5 class="modal-title d-flex align-items-center">
              <i class="bi bi-person-lines-fill me-2"></i>Register User
            </h5>
            <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">
              Note: Your details must match with your ID (Aadhaar card, passport, driving license, etc.)
              that will be required during check-in.
            </span>
            <div class="container-fluid">
              <div class="row">
                <div class="col-md-6 ps-0 mb-3">
                  <label class="form-label">Name</label>
                  <input type="text" name="name" class="form-control shadow-none" required>
                </div>
                <div class="col-md-6 p-0 mb-3">
                  <label class="form-label">Email address</label>
                  <input type="email" name="email" class="form-control shadow-none" required>
                </div>
                <div class="col-md-6 ps-0 mb-3">
                  <label class="form-label">Phone Number</label>
                  <input type="number" name="phonenum" class="form-control shadow-none" required>
                </div>
                <div class="col-md-6 p-0 mb-3">
                  <label class="form-label">Picture</label>
                  <input type="file" name="profile" accept=".jpg, .jpeg, .png, .webp" class="form-control shadow-none" required>
                </div>
                <div class="col-md-12 p-0 mb-3">
                  <label class="form-label">Address</label>
                  <textarea name="address" class="form-control shadow-none" rows="1" required></textarea>
                </div>
                <div class="col-md-6 ps-0 mb-3">
                  <label class="form-label">Pincode</label>
                  <input type="number" name="pincode" class="form-control shadow-none" required>
                </div>
                <div class="col-md-6 p-0 mb-3">
                  <label class="form-label">Date of birth</label>
                  <input type="date" name="dob" class="form-control shadow-none" required>
                </div>
                <div class="col-md-6 ps-0 mb-3">
                  <label class="form-label">Password</label>
                  <input type="password" name="pass" class="form-control shadow-none" required>
                </div>
                <div class="col-md-6 p-0 mb-3">
                  <label class="form-label">Confirm Password</label>
                  <input type="password" name="cpass" class="form-control shadow-none" required>
                </div>
              </div>
            </div>
            <div class="text-center my-1">
              <button type="submit" class="btn btn-dark shadow-none">Register</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    // --- Register Script ---
    let register_form = document.getElementById('register-form');

    register_form.addEventListener('submit', (e) => {
      e.preventDefault();

      let data = new FormData();
      data.append('name', register_form.elements['name'].value);
      data.append('email', register_form.elements['email'].value);
      data.append('phonenum', register_form.elements['phonenum'].value);
      data.append('address', register_form.elements['address'].value);
      data.append('pincode', register_form.elements['pincode'].value);
      data.append('dob', register_form.elements['dob'].value);
      data.append('pass', register_form.elements['pass'].value);
      data.append('cpass', register_form.elements['cpass'].value);
      data.append('profile', register_form.elements['profile'].files[0]);
      data.append('register', '');

      var myModal = document.getElementById('registerModal');
      var modal = bootstrap.Modal.getInstance(myModal);
      modal.hide();

      let xhr = new XMLHttpRequest();
      xhr.open("POST", "ajax/login_register.php", true);

      xhr.onload = function() {
        if (this.responseText == 'pass_mismatch') {
          alert('Password Mismatch!');
        } else if (this.responseText == 'email_already') {
          alert('Email is already registered!');
        } else if (this.responseText == 'phone_already') {
          alert('Phone number is already registered!');
        } else if (this.responseText == 'inv_img') {
          alert('Only JPG, WEBP & PNG images are allowed!');
        } else if (this.responseText == 'upd_failed') {
          alert('Image upload failed!');
        } else if (this.responseText == 'mail_failed') {
          alert('Cannot send confirmation email! Server down?');
        } else if (this.responseText == 'ins_failed') {
          alert('Registration failed! Server down?');
        } else {
          alert('Registration successful & Confirmation link sent to your email!');
          register_form.reset();
        }
      }
      xhr.send(data);
    });

    // --- Login Script ---
    let login_form = document.getElementById('login-form');

    login_form.addEventListener('submit', (e) => {
      e.preventDefault();

      let data = new FormData();
      data.append('email_mob', login_form.elements['email_mob'].value);
      data.append('pass', login_form.elements['pass'].value);
      data.append('login', '');

      var myModal = document.getElementById('loginModal');
      var modal = bootstrap.Modal.getInstance(myModal);
      modal.hide();

      let xhr = new XMLHttpRequest();
      xhr.open("POST", "ajax/login_register.php", true);

      xhr.onload = function() {
        if (this.responseText == 'inv_email_mob') {
          alert('Invalid Email or Mobile Number!');
        } else if (this.responseText == 'not_verified') {
          alert('Email is not verified!');
        } else if (this.responseText == 'inactive') {
          alert('Account Suspended! Please contact Admin.');
        } else if (this.responseText == 'invalid_pass') {
          alert('Incorrect Password!');
        } else if (this.responseText == 1) {
          // Refresh page to update UI (show dropdown)
          window.location = window.location.pathname;
        }
      }
      xhr.send(data);
    });

    // --- Forgot Password Script ---
    let forgot_form = document.getElementById('forgot-form');

    forgot_form.addEventListener('submit', (e) => {
      e.preventDefault();

      let data = new FormData();
      data.append('email', forgot_form.elements['email'].value);
      data.append('recover_user', '');

      var myModal = document.getElementById('forgotModal');
      var modal = bootstrap.Modal.getInstance(myModal);
      modal.hide();

      let xhr = new XMLHttpRequest();
      xhr.open("POST", "ajax/login_register.php", true);

      xhr.onload = function() {
        if (this.responseText == 'inv_email') {
          alert('Invalid Email!');
        } else if (this.responseText == 'not_verified') {
          alert('Email is not verified! Please verify first.');
        } else if (this.responseText == 'inactive') {
          alert('Account Suspended! Please contact Admin.');
        } else if (this.responseText == 'mail_failed') {
          alert('Cannot send email. Server Down!');
        } else if (this.responseText == 'upd_failed') {
          alert('Account recovery failed. Server Down!');
        } else {
          alert('Reset link sent to email!');
          forgot_form.reset();
        }
      }
      xhr.send(data);
    });

    // --- Reset Password Script ---
    let recovery_form = document.getElementById('recovery-form');

    recovery_form.addEventListener('submit', (e) => {
      e.preventDefault();

      let data = new FormData();
      data.append('email', recovery_form.elements['email'].value);
      data.append('token', recovery_form.elements['token'].value);
      data.append('pass', recovery_form.elements['pass'].value);
      data.append('cpass', recovery_form.elements['cpass'].value);
      data.append('reset_pass', '');

      var myModal = document.getElementById('recoveryModal');
      var modal = bootstrap.Modal.getInstance(myModal);
      modal.hide();

      let xhr = new XMLHttpRequest();
      xhr.open("POST", "ajax/login_register.php", true);

      xhr.onload = function() {
        if (this.responseText == 'mismatch') {
          alert('Password Mismatch!');
        } else if (this.responseText == 'failed') {
          alert('Reset Failed! Server Down.');
        } else {
          alert('Account Reset Successful!');
          recovery_form.reset();
        }
      }
      xhr.send(data);
    });
  </script>