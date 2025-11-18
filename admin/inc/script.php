<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<!-- (VI) New Reusable Alert Function -->
<script>
  // NEW: Auto-remove alert function
  function rem_alert(){
    let all_alerts = document.getElementsByClassName('alert');
    if(all_alerts.length > 0){
      setTimeout(() => {
        all_alerts[0].remove();
      }, 2000); // 2 seconds
    }
  }

  function alert(type, msg, position='body') { // Add position parameter
    // Determine bootstrap class based on type
    let bs_class = (type == 'success') ? 'alert-success' : 'alert-danger';
    
    // Create the alert element
    let element = document.createElement('div');
    element.innerHTML = `
      <div class="alert ${bs_class} alert-dismissible fade show" role="alert">
        <strong class="me-3">${msg}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    `;
    
    // Check where to append the alert
    if(position == 'body'){
        // Make it fixed for the main body
        element.firstElementChild.classList.add('custom-alert'); // custom-alert is fixed position
        document.body.append(element);
    } else {
        // Append inside a specific element (like the modal)
        document.getElementById(position).innerHTML = ''; // Clear previous alerts in modal
        document.getElementById(position).append(element);
    }
    
    // MODIFIED: Call rem_alert to auto-dismiss
    rem_alert();
  }

  // NEW: setActive function for admin dashboard menu
  function setActive() {
    let navbar = document.getElementById('dashboard-menu'); // ID of the admin sidebar
    let a_tags = navbar.getElementsByTagName('a');

    for (let i = 0; i < a_tags.length; i++) {
      let file = a_tags[i].href.split('/').pop();
      let file_name = file.split('.')[0];

      // Check if the current page URL contains the file name
      if (document.location.href.indexOf(file_name) >= 0) {
        a_tags[i].classList.add('active'); // Add 'active' class
      }
    }
  }
  setActive(); // Call the function on page load
</script>