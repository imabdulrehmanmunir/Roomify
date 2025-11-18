let feature_add_form = document.getElementById('feature_add_form');
let facility_add_form = document.getElementById('facility_add_form');

// Feature Add Logic
feature_add_form.addEventListener('submit', function (e) {
    e.preventDefault();

    let data = new FormData(feature_add_form);
    data.append('add_feature', ''); // Add action flag

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/features_facilities_crud.php", true);

    xhr.onload = function () {
        var modal = bootstrap.Modal.getInstance(document.getElementById('feature-s-modal'));
        modal.hide();

        if (this.responseText == 1) {
            alert('success', 'New Feature Added!');
            feature_add_form.reset();
            get_features();
        }
        // else if(this.responseText == 'room_added'){
        //     alert('danger', 'This feature is added in one or more rooms!');
        // }
        else {
            alert('danger', 'Server Error!');
        }
    }
    xhr.send(data);
});

// Get Features Logic
function get_features() {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/features_facilities_crud.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        if (xhr.status >= 200 && xhr.status < 300) {
            document.getElementById('features-data').innerHTML = this.responseText;
        } else {
            console.error('get_features request failed');
        }
    }
    xhr.send('get_features');
}

// Remove Feature Logic
function rem_feature(val) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/features_facilities_crud.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        if (xhr.status >= 200 && xhr.status < 300) {
            if (this.responseText == 1) {
                alert('success', 'Feature Removed!');
                get_features();
            }
            // MODIFIED: Handle new error code
            else if (this.responseText == 'room_added') {
                alert('danger', 'This feature is added in one or more rooms and cannot be deleted!');
            }
            else {
                alert('danger', 'Server error, feature not removed!');
            }
        }
    }
    xhr.send('rem_feature=' + val);
}

// Facility Add Logic
facility_add_form.addEventListener('submit', function (e) {
    e.preventDefault();

    let data = new FormData(facility_add_form);
    data.append('add_facility', ''); // Add action flag

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/features_facilities_crud.php", true);

    xhr.onload = function () {
        var modal = bootstrap.Modal.getInstance(document.getElementById('facility-s-modal'));
        modal.hide();

        if (this.responseText == 'inv_img') {
            alert('danger', 'Only SVG images are allowed!');
        } else if (this.responseText == 'inv_size') {
            alert('danger', 'Image should be less than 1MB!');
        } else if (this.responseText == 'up_failed') {
            alert('danger', 'Image upload failed. Server error!');
        } else if (this.responseText == 1) {
            alert('success', 'New Facility Added!');
            facility_add_form.reset();
            get_facilities();
        } else {
            alert('danger', 'Server Error!');
        }
    }
    xhr.send(data);
});

// Get Facilities Logic
function get_facilities() {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/features_facilities_crud.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        if (xhr.status >= 200 && xhr.status < 300) {
            document.getElementById('facilities-data').innerHTML = this.responseText;
        } else {
            console.error('get_facilities request failed');
        }
    }
    xhr.send('get_facilities');
}

// Remove Facility Logic
function rem_facility(val) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/features_facilities_crud.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        if (xhr.status >= 200 && xhr.status < 300) {
            if (this.responseText == 1) {
                alert('success', 'Facility Removed!');
                get_facilities();
            } else if (this.responseText == 'room_added') {
                alert('danger', 'This facility is added in one or more rooms and cannot be deleted!');
            }
            else {
                alert('danger', 'Server error, facility not removed!');
            }
        }
    }
    xhr.send('rem_facility=' + val);
}


// Call functions on load
window.onload = function () {
    get_features();
    get_facilities();
}