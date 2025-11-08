<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<!-- (VI) New Reusable Alert Function -->
<script>
  function alert(type, msg) {
    // Determine bootstrap class based on type
    let bs_class = (type == 'success') ? 'alert-success' : 'alert-danger';
    
    // Create the alert element
    let element = document.createElement('div');
    element.innerHTML = `
      <div class="alert ${bs_class} alert-dismissible fade show custom-alert" role="alert">
        <strong class="me-3">${msg}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    `;
    
    // Prepend to body
    document.body.append(element);
    
    // Optional: Auto-remove alert after some time
    setTimeout(() => {
        element.remove();
    }, 3000); // 3 seconds
  }
</script>