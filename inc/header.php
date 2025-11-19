<?php
require_once('admin/inc/db_config.php');
require_once('admin/inc/essentials.php');

// Fetch contact details
$q = "SELECT * FROM `contact_details` WHERE `sr_no`=?";
$values = [2];
$contact_r = mysqli_fetch_assoc(select($q, $values, "i"));

// Fetch settings (Dynamic Title)
$settings_q = "SELECT * FROM `settings` WHERE `sr_no`=?";
$settings_r = mysqli_fetch_assoc(select($settings_q, $values, "i"));
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $settings_r['site_title'] ?> - Roomify</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Merienda&family=Poppins:wght@400;500;600&display=swap"
    rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <link href="css/common.css" rel="stylesheet">
</head>

<body class="bg-light">

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-white px-lg-3 py-lg-2 shadow-sm sticky-top">
    <div class="container-fluid">

      <a class="navbar-brand me-5 fw-bold fs-3 h-font" href="index.php">
        <?= $settings_r['site_title'] ?>
      </a>

      <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#nav-bar">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="nav-bar">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item"><a href="index.php" class="nav-link">Home</a></li>
          <li class="nav-item"><a href="rooms.php" class="nav-link">Rooms</a></li>
          <li class="nav-item"><a href="facilities.php" class="nav-link">Facilities</a></li>
          <li class="nav-item"><a href="contact.php" class="nav-link">Contact Us</a></li>
          <li class="nav-item"><a href="about.php" class="nav-link">About</a></li>
        </ul>

        <div class="d-flex">
          <button class="btn btn-outline-dark shadow-none me-lg-2 me-3" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
          <button class="btn btn-outline-dark shadow-none" data-bs-toggle="modal" data-bs-target="#registerModal">Register</button>
        </div>
      </div>
    </div>
  </nav>

  <!-- Login Modal -->
  <div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form>
          <div class="modal-header">
            <h5 class="modal-title d-flex align-items-center">
              <i class="bi bi-person-circle me-2"></i> User Login
            </h5>
            <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
          </div>

          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label">Email address</label>
              <input type="email" class="form-control shadow-none">
            </div>

            <div class="mb-3">
              <label class="form-label">Password</label>
              <input type="password" class="form-control shadow-none">
            </div>

            <div class="d-flex justify-content-between align-items-center">
              <button type="submit" class="btn btn-dark shadow-none">Login</button>
              <a href="javascript:void(0)" class="text-secondary text-decoration-none">Forgot Password?</a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Register Modal -->
  <div class="modal fade" id="registerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        
        <form id="register-form">
          <div class="modal-header">
            <h5 class="modal-title d-flex align-items-center">
              <i class="bi bi-person-lines-fill me-2"></i> Register User
            </h5>
            <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
          </div>

          <div class="modal-body">
            <span class="badge bg-light text-dark mb-3 text-wrap lh-base">
              Note: Your details must match your ID (passport, driving license, etc.)
            </span>

            <div class="container-fluid">
              <div class="row g-3">

                <div class="col-md-6">
                  <label class="form-label">Name</label>
                  <input type="text" name="name" class="form-control shadow-none" required>
                </div>

                <div class="col-md-6">
                  <label class="form-label">Email</label>
                  <input type="email" name="email" class="form-control shadow-none" required>
                </div>

                <div class="col-md-6">
                  <label class="form-label">Phone</label>
                  <input type="number" name="phonenum" class="form-control shadow-none" required>
                </div>

                <div class="col-md-6">
                  <label class="form-label">Picture</label>
                  <input type="file" name="profile" accept=".jpg, .jpeg, .png, .webp" class="form-control shadow-none" required>
                </div>

                <div class="col-md-12">
                  <label class="form-label">Address</label>
                  <textarea name="address" class="form-control shadow-none" rows="1" required></textarea>
                </div>

                <div class="col-md-6">
                  <label class="form-label">Pincode</label>
                  <input type="number" name="pincode" class="form-control shadow-none" required>
                </div>

                <div class="col-md-6">
                  <label class="form-label">Date of Birth</label>
                  <input type="date" name="dob" class="form-control shadow-none" required>
                </div>

                <div class="col-md-6">
                  <label class="form-label">Password</label>
                  <input type="password" name="pass" class="form-control shadow-none" required>
                </div>

                <div class="col-md-6">
                  <label class="form-label">Confirm Password</label>
                  <input type="password" name="cpass" class="form-control shadow-none" required>
                </div>

              </div>
            </div>

            <div class="text-center mt-3">
              <button type="submit" class="btn btn-dark shadow-none">Register</button>
            </div>

          </div>
        </form>

      </div>
    </div>
  </div>

  <!-- Registration Script -->
  <script>
    const register_form = document.getElementById('register-form');

    register_form.addEventListener('submit', (e) => {
      e.preventDefault();

      let data = new FormData(register_form);
      data.append('register', '');

      let modalInstance = bootstrap.Modal.getInstance(document.getElementById('registerModal'));
      modalInstance.hide();

      let xhr = new XMLHttpRequest();
      xhr.open("POST", "ajax/login_register.php", true);

      xhr.onload = function () {
        let response = this.responseText;

        const messages = {
          pass_mismatch: 'Password mismatch!',
          email_already: 'Email already exists!',
          phone_already: 'Phone already registered!',
          inv_img: 'Invalid image type! Only JPG, PNG, WEBP allowed.',
          upd_failed: 'Image upload failed!',
          mail_failed: 'Email sending failed!',
          ins_failed: 'Database insert failed!'
        };

        alert(messages[response] || "Registered successfully! Check your email to confirm.");
        register_form.reset();
      };

      xhr.send(data);
    });
  </script>

</body>
</html>
