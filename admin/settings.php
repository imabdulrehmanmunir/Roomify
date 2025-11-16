<?php require('inc/header.php'); ?>

<div class="container-fluid" id="main-content">
  <div class="row">
    <div class="col-lg-10 ms-auto p-4 overflow-hidden">

      <h3 class="mb-4">SETTINGS</h3>

      <!-- General Settings -->
      <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">

          <div class="d-flex align-items-center justify-content-between mb-3">
            <h5 class="card-title m-0">General Settings</h5>
            <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#gen-settings-modal">
              <i class="bi bi-pencil-square"></i> Edit
            </button>
          </div>

          <h6 class="card-subtitle mb-1 fw-bold">Site Title</h6>
          <p class="card-text" id="site_title"></p>

          <h6 class="card-subtitle mb-1 fw-bold">About us</h6>
          <p class="card-text" id="site_about"></p>

        </div>
      </div>

      <!-- NEW: Contact Settings -->
      <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">

          <div class="d-flex align-items-center justify-content-between mb-3">
            <h5 class="card-title m-0">Contact Settings</h5>
            <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#contacts-modal">
              <i class="bi bi-pencil-square"></i> Edit
            </button>
          </div>

          <div class="row">
            <div class="col-lg-6">
              <div class="mb-3">
                <h6 class="card-subtitle mb-1 fw-bold">Address</h6>
                <p class="card-text" id="address"></p>
              </div>
              <div class="mb-3">
                <h6 class="card-subtitle mb-1 fw-bold">Google Map</h6>
                <p class="card-text" id="gmap"></p>
              </div>
              <div class="mb-3">
                <h6 class="card-subtitle mb-1 fw-bold">Phone Numbers</h6>
                <p class="card-text mb-1"><i class="bi bi-telephone-fill"></i> <span id="pn1"></span></p>
                <p class="card-text"><i class="bi bi-telephone-fill"></i> <span id="pn2"></span></p>
              </div>
              <div class="mb-3">
                <h6 class="card-subtitle mb-1 fw-bold">Email</h6>
                <p class="card-text" id="email"></p>
              </div>
            </div>

            <div class="col-lg-6">
              <div class="mb-3">
                <h6 class="card-subtitle mb-1 fw-bold">Social Links</h6>
                <p class="card-text mb-1"><i class="bi bi-facebook me-1"></i> <span id="fb"></span></p>
                <p class="card-text mb-1"><i class="bi bi-instagram me-1"></i> <span id="insta"></span></p>
                <p class="card-text"><i class="bi bi-twitter-x me-1"></i> <span id="tw"></span></p>
              </div>

              <div class="mb-3">
                <h6 class="card-subtitle mb-1 fw-bold">iFrame</h6>
                <iframe id="iframe" class="border p-2 w-100" loading="lazy"></iframe>
              </div>
            </div>
          </div>

        </div>
      </div>

      <!-- Shutdown -->
      <div class="card border-0 shadow-sm">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between mb-3">
            <h5 class="card-title m-0">Shutdown Website</h5>
            <div class="form-check form-switch">
              <input onchange="upd_shutdown(this.checked)" class="form-check-input" type="checkbox" id="shutdown_toggle">
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

<!-- General Settings Modal -->
<div class="modal fade" id="gen-settings-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
  <div class="modal-dialog">

    <form id="gen_settings_form" onsubmit="upd_general(event)">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title">General Settings</h5>
        </div>

        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label fw-bold">Site Title</label>
            <input type="text" name="site_title" id="site_title_inp" class="form-control shadow-none" required>
          </div>

          <div class="mb-3">
            <label class="form-label fw-bold">About us</label>
            <textarea name="site_about" id="site_about_inp" class="form-control shadow-none" rows="6" required></textarea>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" onclick="site_title_inp.value = general_data.site_title; site_about_inp.value = general_data.site_about;" class="btn text-secondary shadow-none" data-bs-dismiss="modal">
            CANCEL
          </button>
          <button type="submit" class="btn btn-dark shadow-none">SUBMIT</button>
        </div>

      </div>
    </form>

  </div>
</div>

<!-- NEW: Contact Settings Modal -->
<div class="modal fade" id="contacts-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
  <div class="modal-dialog modal-lg">

    <form id="contacts_form" onsubmit="upd_contacts(event)">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title">Contact Settings</h5>
        </div>

        <div class="modal-body">
          <div class="container-fluid p-0">
            <div class="row">

              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label fw-bold">Address</label>
                  <input type="text" name="address" id="address_inp" class="form-control shadow-none" required>
                </div>
                <div class="mb-3">
                  <label class="form-label fw-bold">Google Map Link</label>
                  <input type="text" name="gmap" id="gmap_inp" class="form-control shadow-none" required>
                </div>
                <div class="mb-3">
                  <label class="form-label fw-bold">Phone Number 1</label>
                  <input type="text" name="pn1" id="pn1_inp" class="form-control shadow-none" required>
                </div>
                <div class="mb-3">
                  <label class="form-label fw-bold">Phone Number 2</label>
                  <input type="text" name="pn2" id="pn2_inp" class="form-control shadow-none">
                </div>
                <div class="mb-3">
                  <label class="form-label fw-bold">Email</label>
                  <input type="email" name="email" id="email_inp" class="form-control shadow-none" required>
                </div>
              </div>

              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label fw-bold">Facebook</label>
                  <input type="text" name="fb" id="fb_inp" class="form-control shadow-none" required>
                </div>
                <div class="mb-3">
                  <label class="form-label fw-bold">Instagram</label>
                  <input type="text" name="insta" id="insta_inp" class="form-control shadow-none" required>
                </div>
                <div class="mb-3">
                  <label class="form-label fw-bold">Twitter</label>
                  <input type="text" name="tw" id="tw_inp" class="form-control shadow-none">
                </div>
                <div class="mb-3">
                  <label class="form-label fw-bold">iFrame SRC</label>
                  <input type="text" name="iframe" id="iframe_inp" class="form-control shadow-none" required>
                </div>
              </div>

            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" onclick="reset_contacts()" class="btn text-secondary shadow-none" data-bs-dismiss="modal">
            CANCEL
          </button>
          <button type="submit" class="btn btn-dark shadow-none">SUBMIT</button>
        </div>

      </div>
    </form>

  </div>
</div>

<?php require('inc/script.php'); ?>

<script>
  let general_data, contact_data;

  let gen_settings_form = document.getElementById('gen_settings_form');
  let site_title_inp = document.getElementById('site_title_inp');
  let site_about_inp = document.getElementById('site_about_inp');

  let site_title = document.getElementById('site_title');
  let site_about = document.getElementById('site_about');
  let shutdown_toggle = document.getElementById('shutdown_toggle');

  // NEW: Contact form and display IDs
  let contacts_form = document.getElementById('contacts_form');
  let contacts_display_ids = ['address', 'gmap', 'pn1', 'pn2', 'email', 'fb', 'insta', 'tw'];
  let contacts_input_ids = ['address_inp', 'gmap_inp', 'pn1_inp', 'pn2_inp', 'email_inp', 'fb_inp', 'insta_inp', 'tw_inp', 'iframe_inp'];
  let iframe = document.getElementById('iframe');

  function get_general() {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/crud_settings.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
      if (xhr.status >= 200 && xhr.status < 300) {
        general_data = JSON.parse(this.responseText);
        site_title.innerText = general_data.site_title;
        site_about.innerText = general_data.site_about;
        site_title_inp.value = general_data.site_title;
        site_about_inp.value = general_data.site_about;
        shutdown_toggle.checked = general_data.shutdown == 1;
      }
    }
    xhr.send('get_general');
  }

  function get_contacts() {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/crud_settings.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
      if (xhr.status >= 200 && xhr.status < 300) {
        contact_data = JSON.parse(this.responseText);
        let data_values = Object.values(contact_data);

        for (let i = 0; i < contacts_display_ids.length; i++) {
          document.getElementById(contacts_display_ids[i]).innerText = data_values[i + 1];
        }
        iframe.src = data_values[9];

        reset_contacts();
      }
    }
    xhr.send('get_contacts');
  }

  function reset_contacts() {
    let data_values = Object.values(contact_data);
    for (let i = 0; i < contacts_input_ids.length; i++) {
      document.getElementById(contacts_input_ids[i]).value = data_values[i + 1];
    }
  }

  function upd_contacts(e) {
    e.preventDefault();

    let data = new FormData(contacts_form);
    data.append('upd_contacts', '');

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/crud_settings.php", true);

    xhr.onload = function () {
      var modal = bootstrap.Modal.getInstance(document.getElementById('contacts-modal'));
      modal.hide();

      if (this.responseText == 1) {
        alert('success', 'Contact Settings Saved!');
        get_contacts();
      } else {
        alert('danger', 'No Changes Made!');
      }
    }
    xhr.send(data);
  }

  function upd_general(e) {
    e.preventDefault();

    let data = new FormData(gen_settings_form);
    data.append('upd_general', '');

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/crud_settings.php", true);

    xhr.onload = function () {
      var modal = bootstrap.Modal.getInstance(document.getElementById('gen-settings-modal'));
      modal.hide();

      if (this.responseText == 1) {
        alert('success', 'Changes Saved!');
        get_general();
      } else {
        alert('danger', 'No Changes Made!');
      }
    }
    xhr.send(data);
  }

  function upd_shutdown(val) {
    let state = val ? 1 : 0;

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/crud_settings.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
      if (this.responseText == 1) {
        alert('success', general_data.shutdown == 0 ? 'Website shutdown enabled!' : 'Shutdown disabled!');
        get_general();
      } else {
        alert('danger', 'No changes made!');
      }
    }
    xhr.send('upd_shutdown=' + state);
  }

  window.onload = function () {
    get_general();
    get_contacts();
  }
</script>

</body>
</html>
