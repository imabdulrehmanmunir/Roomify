// NEW: Carousel JS variables
let carousel_add_form = document.getElementById('carousel_add_form');
let carousel_picture_inp = document.getElementById('carousel_picture_inp');


// NEW: add_image function (adapted from add_member)
function add_image(e) {
  e.preventDefault(); // Prevent default form submission

  let data = new FormData(carousel_add_form);
  data.append('add_image', ''); // Add action flag
  
  // Note: No Content-Type header is set for FormData
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/carousel_crud.php", true);
  
  xhr.onload = function () {
      var modal = bootstrap.Modal.getInstance(document.getElementById('carousel-s-modal'));
      modal.hide();

      if (this.responseText == 'inv_img') {
          alert('danger', 'Only JPEG, PNG, JPG & WEBP images are allowed!');
      } else if (this.responseText == 'inv_size') {
          alert('danger', 'Image should be less than 2MB!');
      } else if (this.responseText == 'up_failed') {
          alert('danger', 'Image upload failed. Server error!');
      } else if (this.responseText == 1) {
          alert('success', 'New Image Added!');
          // Reset form fields
          carousel_picture_inp.value = '';
          get_carousel(); // Refresh the list of images
      } else {
          alert('danger', 'No Changes Made!');
      }
  }
  xhr.send(data); // Send the FormData
}

// NEW: get_carousel function (adapted from get_members)
function get_carousel() {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/carousel_crud.php", true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  xhr.onload = function () {
      if (xhr.status >= 200 && xhr.status < 300) {
          // Set the innerHTML of the display area with the response (which is HTML)
          document.getElementById('carousel-data').innerHTML = this.responseText;
      } else {
          console.error('get_carousel request failed');
      }
  }
  xhr.send('get_carousel');
}

// NEW: rem_image function (adapted from rem_member)
function rem_image(sr_no) {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/carousel_crud.php", true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  xhr.onload = function () {
      if (xhr.status >= 200 && xhr.status < 300) {
          if(this.responseText == 1) {
              alert('success', 'Image Removed!');
              get_carousel(); // Refresh the list
          } else {
              alert('danger', 'Server error, image not removed!');
          }
      }
  }
  xhr.send('rem_image=' + sr_no);
}

// Call all functions on load
window.onload = function(){
  get_carousel(); // Load carousel images on page load
}