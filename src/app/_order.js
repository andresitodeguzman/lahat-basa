$(document).ready(()=>{
	loginCheck();
	clear();

	locateLocation();
	$('select').formSelect();
});

var checkLoginStatus = ()=>{
	return localStorage.getItem('all-wet-login');
};

var loginCheck = ()=>{
	let status = checkLoginStatus();
	if(status != "true"){
		window.location.replace('/');
	}
};

// UI Functions
var clear = ()=> {
	$(".activity").hide();
};
var productFilter = (catId)=>{
	$(".product").hide();
	$(`.${catId}`).fadeIn();
};



// Button Handlers
var otherLoc = ()=>{
	clear();
	overrideLocation();
	$("#enterAddressActivity").fadeIn();
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

var overrideLocation = ()=>{
	sessionStorage.setItem("city","");
	sessionStorage.setItem("exact_location","");
	sessionStorage.setItem("formatted_address","");
	sessionStorage.setItem("latitude","");
	sessionStorage.setItem("longitude","");
};

var processAddressCoordinates = ()=>{
	setOrderActivity();

	var exactloc = $("#manualAddress").val();
	sessionStorage.setItem("exact_location",exactloc);
	$.ajax({
		type:'GET',
		cache: 'false',
		data: {
			address:exactloc
		},
		url: 'https://maps.google.com/maps/api/geocode/json?key=AIzaSyBDOL-nNs8SKrlnkr97ByrLwJZ6PHLXeas',
		success: result=>{
			console.log(result['results']);
			var lat = result['results'][0]['geometry']['location']['lat'];
			var lon = result['results'][0]['geometry']['location']['lng'];
			var cty = result['results'][0]['address_components'][1]['long_name'];
			var adr = result['results'][0]['formatted_address'];

			sessionStorage.setItem("latitude",lat);
			sessionStorage.setItem("longitude",lon);
			sessionStorage.setItem("formatted_address",adr);
			sessionStorage.setItem("city",cty);
		}
	}).fail(()=>{
		M.toast({html:"Cannot get coordinates of location", durationLength:3000});
	});

}

var setOrderActivity = ()=>{
	setCategories();
	clear();
	$("#orderActivity").fadeIn();

	$.ajax({
		type:'GET',
		cache:'false',
		url:'/api/Product/getAll.php',
		success: result=>{
			localStorage.setItem("all-wet-product",JSON.stringify(result));
			renderProducts();
		}
	}).fail(()=>{
		renderProducts();
	});

};

var renderProducts = ()=>{
	try{
		var result = JSON.parse(localStorage.getItem("all-wet-product"));

		$.each(result, (index,value)=>{
			var id = value.product_id;
			var c = value.product_code;
			var n = value.product_name;
			var d = value.product_description;
			var cid = value.category_id;
			var cn = value.category_name;
			var p = value.product_price;
			var a = value.product_available;
			var i = value.product_image;

			if(!i){
				var img = `<img src="/assets/images/icon/icon-192x192.png" width="100%">`;
			} else {
				var img = `<img src="${i}">`;
			}

			if(p){
				var p = `₱${p}`;
			} else {
				var p = "Price Unavailable";
			}

			var tmpl = `
				<div class="card hoverable product cat${cid}" width="100%">
					<div class="card-img">
						${img}
					</div>
					<div class="card-content">
						<span class="card-title">
							<b>${n}</b><br>
							${p}
						</span>
						<br>
						<p>
							<i class="material-icons grey-text text-darken-1">info_outline</i> ${c}<br>
							<i class="material-icons grey-text text-darken-1">note</i> ${d}<br>
							<i class="material-icons grey-text text-darken-1">label</i> ${cn}<br>
						</p><br><br>
						<div class="input-field col s12">
							<select id="">
								<option value="0" selected>Quantity</option>
								<option value="1">One (1)</option>
								<option value="2">Two (2)</option>
								<option value="3">Three (3)</option>
								<option value="4">Four (4)</option>
								<option value="5">Five (5)</option>
								<option value="6">Six (6)</option>
								<option value="7">Seven (7)</option>
								<option value="8">Eight (8)</option>
								<option value="9">Nine (9)</option>
								<option value="10">Ten (10)</option>
							</select>
						</div>
					</div>
				</div>
				<script>
					$(document).ready(()=>{
						$('select').formSelect();
					});
				</script>
			`;

			$("#productsList").append(tmpl);
		});

	} catch(e){
		M.toast({html:"Cannot display products", completeCallback: ()=>{window.location.replace('/app');}});
	}
}

var setCategories = ()=>{
	$.ajax({
		type: 'GET',
		cache: 'false',
		url: '/api/Category/getAll.php',
		data: {
			a: 1
		},
		success: result=>{
			try{
				localStorage.setItem("all-wet-categories",JSON.stringify(result));
				renderCategories();
			} catch(e){
				console.log(`Categories Error: ${e}`);
				M.toast({html:"An error occured while fetching data",displayLength:3000});
			}
		}
	}).fail(()=>{
		renderCategories();
		M.toast({html:'Cannot get categories', displayLength:2000});
	});
};

var renderCategories = ()=>{
	try {
		var addAllCategories = `<li class="tab"><a href="#" class="blue-text text-darken-3" onclick="productFilter('product')">All</a></li>`;
		var result = JSON.parse(localStorage.getItem("all-wet-categories"));

		$("#categoryTabs").html(addAllCategories);

		$.each(result,(index,value)=>{
			var cid = value['category_id'];
			var cn = value['category_name'];
			var cd = value['category_description'];
			var cc = value['category_code'];

			var tmpl = `
				<li class="tab">
					<a href="#" class="blue-text text-darken-3" onclick="productFilter('cat${cid}')">${cn}</a>
				</li>`;
			$("#categoryTabs").append(tmpl);
		});
	} catch(e){
		M.toast({html:"Fatal error: Cannot processs categories"});
	}
}