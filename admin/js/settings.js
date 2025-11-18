let general_data, contact_data;

let gen_settings_form = document.getElementById('gen_settings_form');
let site_title_inp = document.getElementById('site_title_inp');
let site_about_inp = document.getElementById('site_about_inp');

let site_title = document.getElementById('site_title');
let site_about = document.getElementById('site_about');
let shutdown_toggle = document.getElementById('shutdown_toggle');

// Contact form and display IDs
let contacts_form = document.getElementById('contacts_form');
let contacts_display_ids = ['address', 'gmap', 'pn1', 'pn2', 'email', 'fb', 'insta', 'tw'];
let contacts_input_ids = ['address_inp', 'gmap_inp', 'pn1_inp', 'pn2_inp', 'email_inp', 'fb_inp', 'insta_inp', 'tw_inp', 'iframe_inp'];
let iframe = document.getElementById('iframe');

// Management Team JS variables
let team_add_form = document.getElementById('team_add_form');
let member_name_inp = document.getElementById('member_name_inp');
let member_picture_inp = document.getElementById('member_picture_inp');


// add_member function
function add_member(e) {
  e.preventDefault(); // Prevent default form submission

  let data = new FormData(team_add_form);
  data.append('add_member', ''); // Add action flag
  
  // Note: No Content-Type header is set for FormData
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/crud_settings.php", true);
  
  xhr.onload = function () {
      var modal = bootstrap.Modal.getInstance(document.getElementById('m-t-modal'));
      modal.hide();

      if (this.responseText == 'inv_img') {
          alert('danger', 'Only JPEG, PNG, JPG & WEBP images are allowed!');
      } else if (this.responseText == 'inv_size') {
          alert('danger', 'Image should be less than 2MB!');
      } else if (this.responseText == 'up_failed') {
          alert('danger', 'Image upload failed. Server error!');
      } else if (this.responseText == 1) {
          alert('success', 'New Member Added!');
          // Reset form fields
          member_name_inp.value = '';
          member_picture_inp.value = '';
          get_members(); // Refresh the list of members
      } else {
          alert('danger', 'No Changes Made!');
      }
  }
  xhr.send(data); // Send the FormData
}

// get_members function
function get_members() {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/crud_settings.php", true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  xhr.onload = function () {
      if (xhr.status >= 200 && xhr.status < 300) {
          // Set the innerHTML of the display area with the response (which is HTML)
          document.getElementById('team-data').innerHTML = this.responseText;
      } else {
          console.error('get_members request failed');
      }
  }
  xhr.send('get_members');
}

// rem_member function
function rem_member(sr_no) {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/crud_settings.php", true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  xhr.onload = function () {
      if (xhr.status >= 200 && xhr.status < 300) {
          if(this.responseText == 1) {
              alert('success', 'Member Removed!');
              get_members(); // Refresh the list
          } else {
              alert('danger', 'Server error, member not removed!');
          }
      }
  }
  xhr.send('rem_member=' + sr_no);
}


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

// Get Contact Details
function get_contacts() {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/crud_settings.php", true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  xhr.onload = function () {
    if (xhr.status >= 200 && xhr.status < 300) {
      contact_data = JSON.parse(this.responseText);
      let data_values = Object.values(contact_data);

      // Loop through display IDs and populate
      for(let i = 0; i < contacts_display_ids.length; i++){
        document.getElementById(contacts_display_ids[i]).innerText = data_values[i+1];
      }
      // Update iframe src separately
      iframe.src = data_values[9]; // 9th index is iframe
      
      // Populate modal inputs
      reset_contacts();
    }
  }
  xhr.send('get_contacts');
}

// Reset contacts modal form
function reset_contacts(){
  let data_values = Object.values(contact_data);
  for(let i = 0; i < contacts_input_ids.length; i++){
    document.getElementById(contacts_input_ids[i]).value = data_values[i+1];
  }
}

// Update Contact Details
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
      get_contacts(); // Refresh contacts data
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

// Call all functions on load
window.onload = function(){
  get_general();
  get_contacts();
  get_members(); // Load team members on page load
}