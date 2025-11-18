// Global variable declarations
let add_room_form, edit_room_form, add_image_form;

// Get All Rooms Logic
function get_all_rooms() {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/rooms_crud.php", true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  xhr.onload = function () {
    if (xhr.status >= 200 && xhr.status < 300) {
      document.getElementById('rooms-data').innerHTML = this.responseText;
    } else {
      console.error('get_all_rooms request failed');
    }
  }
  xhr.send('get_all_rooms');
}

// Toggle Room Status Logic
function toggle_status(id, val) {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/rooms_crud.php", true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  xhr.onload = function () {
    if (this.responseText == 1) {
      alert('success', 'Room status updated!');
      get_all_rooms();
    } else {
      alert('danger', 'Server Error!');
    }
  }
  xhr.send('toggle_status&id=' + id + '&value=' + val);
}

// Get Room Details for Editing
function edit_details(id) {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/rooms_crud.php", true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  xhr.onload = function () {
    let data = JSON.parse(this.responseText);

    // Populate basic data
    edit_room_form.elements['name'].value = data.room_data.name;
    edit_room_form.elements['area'].value = data.room_data.area;
    edit_room_form.elements['price'].value = data.room_data.price;
    edit_room_form.elements['quantity'].value = data.room_data.quantity;
    edit_room_form.elements['adult'].value = data.room_data.adult;
    edit_room_form.elements['children'].value = data.room_data.children;
    edit_room_form.elements['desc'].value = data.room_data.description;
    edit_room_form.elements['room_id'].value = data.room_data.id; 

    // Reset and check features
    edit_room_form.querySelectorAll('input[name="features"]').forEach(el => {
      el.checked = data.features.includes(Number(el.value));
    });

    // Reset and check facilities
    edit_room_form.querySelectorAll('input[name="facilities"]').forEach(el => {
      el.checked = data.facilities.includes(Number(el.value));
    });

    var modal = new bootstrap.Modal(document.getElementById('edit-room-modal'));
    modal.show();
  }
  xhr.send('get_room=' + id);
}

// Room Images Management
function room_images(id, name) {
  document.getElementById('room-images-modal-title').innerText = name + ' - Images';
  add_image_form.elements['room_id'].value = id;

  document.getElementById('img_alert').innerHTML = '';

  get_room_images(id);

  var modal = new bootstrap.Modal(document.getElementById('room-images-modal'));
  modal.show();
}

function get_room_images(id) {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/rooms_crud.php", true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  xhr.onload = function () {
    document.getElementById('room-image-data').innerHTML = this.responseText;
  }
  xhr.send('get_room_images=' + id);
}

function rem_image(img_id, room_id) {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/rooms_crud.php", true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  xhr.onload = function () {
    if (this.responseText == 1) {
      alert('success', 'Image Removed!', 'img_alert');
      get_room_images(room_id);
    } else {
      alert('danger', 'Server error, image not removed!', 'img_alert');
    }
  }
  xhr.send('rem_image=' + img_id);
}

function thumb_image(img_id, room_id) {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/rooms_crud.php", true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  xhr.onload = function () {
    if (this.responseText == 1) {
      alert('success', 'Thumbnail Changed!', 'img_alert');
      get_room_images(room_id);
    } else {
      alert('danger', 'Server error!', 'img_alert');
    }
  }
  xhr.send('thumb_image=' + img_id + '&room_id=' + room_id);
}

function remove_room(id) {
  if(confirm("Are you sure you want to remove this room? This will delete all associated images and data.")){
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/rooms_crud.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
      if (this.responseText == 1) {
        alert('success', 'Room Removed!');
        get_all_rooms();
      } else {
        alert('danger', 'Server error, room not removed!');
      }
    }
    xhr.send('remove_room=' + id);
  }
}

// Initialize on DOM Ready
document.addEventListener('DOMContentLoaded', function() {
  add_room_form = document.getElementById('add_room_form');
  edit_room_form = document.getElementById('edit_room_form');
  add_image_form = document.getElementById('add_image_form');

  // Add Room Logic
  add_room_form.addEventListener('submit', function(e){
    e.preventDefault();

    let data = new FormData(add_room_form);
    data.append('add_room', '');

    let features = [];
    add_room_form.querySelectorAll('input[name="features"]:checked').forEach(el => features.push(el.value));
    data.append('features', JSON.stringify(features));

    let facilities = [];
    add_room_form.querySelectorAll('input[name="facilities"]:checked').forEach(el => facilities.push(el.value));
    data.append('facilities', JSON.stringify(facilities));

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/rooms_crud.php", true);

    xhr.onload = function () {
      var modal = bootstrap.Modal.getInstance(document.getElementById('add-room-modal'));
      modal.hide();

      if (this.responseText == 1) {
        alert('success', 'New Room Added!');
        add_room_form.reset();
        get_all_rooms();
      } else {
        alert('danger', 'Server Error: ' + this.responseText);
      }
    }
    xhr.send(data);
  });

  // Edit Room
  edit_room_form.addEventListener('submit', function(e){
    e.preventDefault();

    let data = new FormData(edit_room_form);
    data.append('edit_room', '');

    let features = [];
    edit_room_form.querySelectorAll('input[name="features"]:checked').forEach(el => features.push(el.value));
    data.append('features', JSON.stringify(features));

    let facilities = [];
    edit_room_form.querySelectorAll('input[name="facilities"]:checked').forEach(el => facilities.push(el.value));
    data.append('facilities', JSON.stringify(facilities));

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/rooms_crud.php", true);

    xhr.onload = function () {
      var modal = bootstrap.Modal.getInstance(document.getElementById('edit-room-modal'));
      modal.hide();

      if (this.responseText == 1) {
        alert('success', 'Room details updated!');
        edit_room_form.reset();
        get_all_rooms();
      } else {
        alert('danger', 'Server Error!');
      }
    }
    xhr.send(data);
  });

  // Add Image
  add_image_form.addEventListener('submit', function(e){
    e.preventDefault();

    let data = new FormData(add_image_form);
    data.append('add_image', '');

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/rooms_crud.php", true);

    xhr.onload = function () {
      if (this.responseText == 'inv_img') {
        alert('danger', 'Only JPEG, PNG, JPG & WEBP allowed!', 'img_alert');
      } else if (this.responseText == 'inv_size') {
        alert('danger', 'Image must be < 2MB!', 'img_alert');
      } else if (this.responseText == 'up_failed') {
        alert('danger', 'Upload failed!', 'img_alert');
      } else if (this.responseText == 1) {
        alert('success', 'Image Added!', 'img_alert');
        add_image_form.reset();
        get_room_images(add_image_form.elements['room_id'].value);
      } else {
        alert('danger', 'Server Error!', 'img_alert');
      }
    }
    xhr.send(data);
  });

  get_all_rooms();
});

// Make functions global so onclick="" works
window.toggle_status = toggle_status;
window.remove_room = remove_room;
window.room_images = room_images;
window.edit_details = edit_details;
