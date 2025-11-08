<?php
  // (II) Include essentials, which starts session and checks login
  require('essentials.php');
  adminLogin(); // Secure all pages that include this header
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Roomify | Admin Panel</title>
  <?php require('links.php'); // (II) Include CSS links ?>
</head>
<body class="bg-light">

  <!-- (II) Top Header Bar -->
  <div class="container-fluid bg-dark text-white p-3 d-flex justify-content-between align-items-center fixed-top">
    <h3 class="mb-0 h-font">ROOMIFY - ADMIN</h3>
    <a href="logout.php" class="btn btn-light btn-sm">LOGOUT</a>
  </div>

  <!-- (II) Sidebar -->
  <div class="col-lg-2 bg-dark border-top border-3 border-secondary" id="dashboard-menu">
    <nav class="navbar navbar-expand-lg navbar-dark">
      <div class="container-fluid flex-lg-column align-items-stretch">
        <h4 class="mt-2 text-light">Admin Panel</h4>
        <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#admin-dropdown" aria-controls="admin-dropdown" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse flex-column align-items-stretch mt-2" id="admin-dropdown">
          <!-- (II) Navigation Links -->
          <ul class="nav nav-pills flex-column">
            <li class="nav-item">
              <a class="nav-link text-white" href="dashboard.php"><i class="bi bi-speedometer2 me-1"></i> Dashboard</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-white" href="#"><i class="bi bi-door-closed-fill me-1"></i> Rooms</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-white" href="#"><i class="bi bi-people-fill me-1"></i> Users</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-white" href="settings.php"><i class="bi bi-gear-fill me-1"></i> Settings</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </div>