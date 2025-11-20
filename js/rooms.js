let rooms_data = document.getElementById('rooms-data');
let checkin = document.getElementById('checkin');
let checkout = document.getElementById('checkout');
let chk_avail_btn = document.getElementById('chk_avail_btn');

let adults = document.getElementById('adults');
let children = document.getElementById('children');
let guests_btn = document.getElementById('guests_btn');

let facilities_btn = document.getElementById('facilities_btn');

function fetch_rooms()
{
    let chk_avail = JSON.stringify({
        checkin: checkin.value,
        checkout: checkout.value
    });

    let guests = JSON.stringify({
        adults: adults.value,
        children: children.value
    });

    let facility_list = {"facility_list": []};
    let get_facilities = document.querySelectorAll('[name="facilities"]:checked');
    if(get_facilities.length > 0){
        get_facilities.forEach((facility)=>{
            facility_list.facility_list.push(facility.value);
        });
        facilities_btn.classList.remove('d-none');
    } else {
        facilities_btn.classList.add('d-none');
    }
    facility_list = JSON.stringify(facility_list.facility_list);

    let xhr = new XMLHttpRequest();
    xhr.open("GET", "ajax/rooms.php?fetch_rooms&chk_avail="+chk_avail+"&guests="+guests+"&facility_list="+facility_list, true);

    xhr.onprogress = function(){
        rooms_data.innerHTML = `<div class="spinner-border text-info mb-3 d-block mx-auto" id="loader" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>`;
    }

    xhr.onload = function(){
        rooms_data.innerHTML = this.responseText;
    }
    xhr.send();
}

function chk_avail_filter(){
    if(checkin.value != '' && checkout.value != ''){
        fetch_rooms();
        chk_avail_btn.classList.remove('d-none');
    }
}

function chk_avail_clear(){
    checkin.value = '';
    checkout.value = '';
    chk_avail_btn.classList.add('d-none');
    fetch_rooms();
}

function guests_filter(){
    if(adults.value > 0 || children.value > 0){
        fetch_rooms();
        guests_btn.classList.remove('d-none');
    }
}

function guests_clear(){
    adults.value = '';
    children.value = '';
    guests_btn.classList.add('d-none');
    fetch_rooms();
}

function facilities_clear(){
    let get_facilities = document.querySelectorAll('[name="facilities"]:checked');
    get_facilities.forEach((facility)=>{
        facility.checked = false;
    });
    facilities_btn.classList.add('d-none');
    fetch_rooms();
}

// Load rooms when window loads
window.onload = function(){
    fetch_rooms();
}