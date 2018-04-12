$(document).ready(()=>{
	clear();
	loginCheck();

	locateLocation();
});

var checkLoginStatus = ()=>{
	return localStorage.getItem('all-wet-login');
};

var loginCheck = ()=>{
	let status = checkLoginStatus();
	if(status != "true"){
		window.location.replace("/authenticate");
	}
};

// UI Functions
var clear = ()=> {
	$(".activity").hide();
};

var locateLocation = ()=>{
	$("#locationLoaderActivity").fadeIn();
	if("geolocation" in navigator){
		navigator.geolocation.getCurrentPosition(pos=>{
			var coo = pos.coords;
			var ltlo = `${coo.latitude},${coo.longitude}`;

			$.ajax({
				type:'GET',
				url:'https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyBDOL-nNs8SKrlnkr97ByrLwJZ6PHLXeas',
				data: {
					latlng: ltlo
				},
				success: result=>{
					var ad = result['results'][0]['formatted_address'];
                    var exactLoc = result['results'][0]['address_components'][0]['long_name'];
                    var city = result['results'][0]['address_components'][1]['long_name'];

					sessionStorage.setItem("latitude",coo.latitude);
                    sessionStorage.setItem("longitude",coo.longitude);
                    sessionStorage.setItem("formatted_address",ad);
                    sessionStorage.setItem("exact_location",exactLoc);
					sessionStorage.setItem("city",city);

					console.log(result['results']);

					setInitialLocation();

				}
			}).catch(()=>{
				clear();
				$("#locationServiceErrorActivity").fadeIn();
			});
		}, err => {
			error = err.code;
			if(error == 1){
				clear();
				$("#locationErrorActivity").fadeIn();
			}
			if(error == 2){
				clear();
				$("#locationProblemActivity").fadeIn();
			}
			if(error == 3){
				clear();
				$("#locationProblemActivity").fadeIn();
			}
		});
	} else {
		clear();
		$("#locationProblemActivity").fadeIn();
	}
};


var setInitialLocation = ()=> {
	var lat = sessionStorage.getItem("latitude");
    var lon = sessionStorage.getItem("longitude");
    var adr = sessionStorage.getItem("formatted_address");
    var exactloc = sessionStorage.getItem("exact_location");
    var cty = sessionStorage.getItem("city");
    var eAdr = encodeURI(adr);
    var showThis = `
        <h3 id="loc" class="white-text">
            Are you at <b>${exactloc}</b> in ${cty}?
        </h3>
        <img src="https://maps.googleapis.com/maps/api/staticmap?center=${lat},${lon}&zoom=17&size=800x300&markers=color:blue%7C${lat},${lon}&key=AIzaSyCuNfQSkwl85bk38k4de_QR-DwBGL-069o" width="100%"><br><br>

    `;
    $("#locationResult").html(showThis);
    $("#locationLoaderActivity").hide();
    $("#locationActivity").fadeIn();
};