<?php
  // (III) Include header, which has the adminLogin() check
  require('inc/header.php');
?>

<div class="container-fluid" id="main-content">
  <div class="row">
    <div class="col-lg-10 ms-auto p-4 overflow-hidden">
      <!-- (III) Main Settings Heading -->
      <h3 class="mb-4">SETTINGS</h3>

      <!-- (III) General Settings Section Card -->
      <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
          <!-- (IV) Card Header with Flex -->
          <div class="d-flex align-items-center justify-content-between mb-3">
            <h5 class="card-title m-0">General Settings</h5>
            <!-- (IV) Edit Button to trigger modal -->
            <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#gen-settings-modal">
              <i class="bi bi-pencil-square"></i> Edit
            </button>
          </div>
          <!-- (IV) Site Title Display -->
          <h6 class="card-subtitle mb-1 fw-bold">Site Title</h6>
          <p class="card-text" id="site_title"></p>
          <!-- (IV) Site About Display -->
          <h6 class="card-subtitle mb-1 fw-bold">About us</h6>
          <p class="card-text" id="site_about"></p>
        </div>
      </div>
      
      <!-- (VII) Shutdown Mode Section Card -->
      <div class="card border-0 shadow-sm">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between mb-3">
            <h5 class="card-title m-0">Shutdown Website</h5>
            <div class="form-check form-switch">
              <!-- (VII) Toggle Button -->
              <input onchange="upd_shutdown(this.value)" class="form-check-input" type="checkbox" id="shutdown_toggle">
            </div>
          </div>
          <p class="card-text">
            When shutdown mode is turned on, no users will be allowed to book hotel rooms.
          </p>
        </div>
      </div>

    </div>
  </div>
</div>


<!-- (IV) General Settings Modal -->
<div class="modal fade" id="gen-settings-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <!-- (IV) Modal Form -->
    <form id="gen_settings_form">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">General Settings</h5>
        </div>
        <div class="modal-body">
          <!-- (IV) Site Title Input -->
          <div class="mb-3">
            <label class="form-label fw-bold">Site Title</label>
            <input type="text" name="site_title" id="site_title_inp" class="form-control shadow-none" required>
          </div>
          <!-- (IV) Site About Input -->
          <div class="mb-3">
            <label class="form-label fw-bold">About us</label>
            <textarea name="site_about" id="site_about_inp" class="form-control shadow-none" rows="6" required></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <!-- (V) Cancel button resets form -->
          <button type="button" onclick="site_title_inp.value = general_data.site_title; site_about_inp.value = general_data.site_about;" class="btn text-secondary shadow-none" data-bs-dismiss="modal">CANCEL</button>
          <!-- (VI) Submit button calls upd_general() -->
          <button type="submit" class="btn btn-dark shadow-none">SUBMIT</button>
        </div>
      </div>
    </form>
  </div>
</div>

<?php require('inc/script.php'); ?>

<!-- (V, VI, VII) JavaScript for AJAX operations -->
<script>
  // (V) Global variable to store fetched settings
  let general_data;

  // (V) Get General Settings Function
  function get_general() {
    let site_title = document.getElementById('site_title');
    let site_about = document.getElementById('site_about');
    let site_title_inp = document.getElementById('site_title_inp');
    let site_about_inp = document.getElementById('site_about_inp');
    let shutdown_toggle = document.getElementById('shutdown_toggle');

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/settings_crud.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
      general_data = JSON.parse(this.responseText);

      // (V) Populate display elements
      site_title.innerText = general_data.site_title;
      site_about.innerText = general_data.site_about;

      // (V) Populate modal input fields
      site_title_inp.value = general_data.site_title;
      site_about_inp.value = general_data.site_about;
      
      // (VII) Set shutdown toggle state
      if(general_data.shutdown == 0){
        shutdown_toggle.checked = false;
        shutdown_toggle.value = 0;
      } else {
        shutdown_toggle.checked = true;
        shutdown_toggle.value = 1;
      }
    }

    xhr.send('get_general=1');
  }

  // (VI) Handle General Settings Form Submission
  let gen_settings_form = document.getElementById('gen_settings_form');
  gen_settings_form.addEventListener('submit', function(e) {
    e.preventDefault();
    upd_general(site_title_inp.value, site_about_inp.value);
  });

  // (VI) Update General Settings Function
  function upd_general(site_title_val, site_about_val) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/settings_crud.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
      // (VI) Get the modal instance to hide it
      var myModal = document.getElementById('gen-settings-modal');
      var modal = bootstrap.Modal.getInstance(myModal);
      modal.hide();

      if (this.responseText == 1) {
        // (VI) Show success alert and refresh data
        alert('success', 'Changes saved!');
        get_general();
      } else {
        // (VI) Show error alert
        alert('error', 'No changes made!');
      }
    }

    xhr.send('upd_general=1&site_title=' + site_title_val + '&site_about=' + site_about_val);
  }
  
  // (VII) Update Shutdown Mode Function
  function upd_shutdown(val){
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/settings_crud.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
      if (this.responseText == 1 && general_data.shutdown == 0) {
        // (VII) Show ON alert
        alert('success', 'Site has been Shut Down!');
      } else {
        // (VII) Show OFF alert
        alert('success', 'Shutdown Mode Off!');
      }
      // (VII) Refresh data to update toggle state
      get_general();
    }

    xhr.send('upd_shutdown=' + val);
  }

  // (V) Load the settings data when the page loads
  window.onload = function() {
    get_general();
  }
</script>

</body>
</html>