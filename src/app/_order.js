$(document).ready(()=>{
	init();
	loginCheck();
	clear();

	splash(500);

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

var init = ()=>{
	sessionStorage.clear();
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

var returnToOrderActivity = ()=>{
  clear();
	$("#orderActivity").fadeIn();  
};

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
				var pr = `₱${p}`;
			} else {
				var pr = "Price Unavailable";
			}

			var t1 = (p);
			var t2 = (+p * 2);
			var t3 = (+p * 3);
			var t4 = (+p * 4);
			var t5 = (+p * 5);
			var t6 = (+p * 6);
			var t7 = (+p * 7);
			var t8 = (+p * 8);
			var t9 = (+p * 9);
			var t10 = (+p * 10);

			var tmpl = `
				<div class="card hoverable product cat${cid}" width="100%">
					<div class="card-img">
						${img}
					</div>
					<div class="card-content">
						<span class="card-title">
							<b>${n}</b><br>
							${pr}
						</span>
						<br>
						<p>
							<i class="material-icons grey-text text-darken-1">info_outline</i> ${c}<br>
							<i class="material-icons grey-text text-darken-1">note</i> ${d}<br>
							<i class="material-icons grey-text text-darken-1">label</i> ${cn}<br>
						</p><br>
						<div class="input-field col s12">
							<span id="totSlider${id}">Quantity</span>
							<p class="range-field">
								<input type="range" min="0" max="10" id="qty${id}" value="0">
							</p>
						</div>
					</div>
				</div>
				<script>
					$("#qty${id}").change(()=>{
						var q = $("#qty${id}").val();

						if(q==0){
							$("#totSlider${id}").html("Quantity");
							updateItem('${id}','0','0');
						}
						if(q==1){
							$("#totSlider${id}").html("One (1) for ₱${t1}");
							updateItem('${id}','1','${t1}');
						}
						if(q==2){
							$("#totSlider${id}").html("Two (2) for ₱${t2}");
							updateItem('${id}','2','${t2}');
						}
						if(q==3){
							$("#totSlider${id}").html("Three (3) for ₱${t3}");
							updateItem('${id}','3','${t3}');
						}
						if(q==4){
							$("#totSlider${id}").html("Four (4) for ₱${t4}");
							updateItem('${id}','4','${t4}');
						}
						if(q==5){
							$("#totSlider${id}").html("Five (5) for ₱${t5}");
							updateItem('${id}','5','${t5}');
						}
						if(q==6){
							$("#totSlider${id}").html("Six (6) for ₱${t6}");
							updateItem('${id}','6','${t6}');
						}
						if(q==7){
							$("#totSlider${id}").html("Seven (7) for ₱${t7}");
							updateItem('${id}','7','${t7}');
						}
						if(q==8){
							$("#totSlider${id}").html("Eight (8) for ₱${t8}");
							updateItem('${id}','8','${t8}');
						}
						if(q==9){
							$("#totSlider${id}").html("Nine (9) for ₱${t9}");
							updateItem('${id}','9','${t9}');
						}
						if(q==10){
							$("#totSlider${id}").html("Ten (10) for ₱${t10}");
							updateItem('${id}','10','${t10}');
						}
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


var getOrderItems = ()=>{
	if(sessionStorage.getItem("all-wet-order-items")){
		var items = JSON.parse(sessionStorage.getItem("all-wet-order-items"));
	} else {
		var items = [];
		sessionStorage.setItem("all-wet-order-items",JSON.stringify(items));
	}

	return items;
}

var updateItem = (pid,qty, pr)=>{

	var items = getOrderItems();

	var index = items.map((element)=>{return element.product_id}).indexOf(pid);

	if(index !== -1){
		if(qty == 0){      
			items.splice(index,1);
		} else {
			items[index].transitem_quantity = qty;
			items[index].price = pr;
		}
	} else{
		if(qty !== 0){
			items.push({"product_id":pid,"transitem_quantity":qty, "price":pr});
		}
	}

	sessionStorage.setItem("all-wet-order-items",JSON.stringify(items));
  $("#totSlider"+pid).val(qty);
};

var showRundown = ()=>{
	var items = getOrderItems();

	if(items.length > 0){
		clear();
		$("#rundownActivity").fadeIn();
		renderRundown();
	} else {
		M.toast({html:"Please order an item to proceed", durationLength:3000});
	}
};

var renderRundown = ()=>{
	$("#rundownList").html("");

	var items = getOrderItems();
	var products = JSON.parse(localStorage.getItem("all-wet-product"));

	if(items.length <= 0){
		setOrderActivity();
	}

	$.each(items, (index,value)=>{
		var pid = value.product_id;
		var qty = value.transitem_quantity;

		var prodIndex = products.map((element)=>{return element.product_id}).indexOf(pid);

		var prodData = products[prodIndex];

		var n = prodData.product_name;
		var c = prodData.product_code;
		var d = prodData.product_description;
		var cid = prodData.category_id;
		var cn = prodData.category_name;
		var p = prodData.product_price;
		var a = prodData.product_available;
		var i = prodData.product_image;

		if(!i){
			var img = `<img src="/assets/images/icon/icon-192x192.png" width="100%">`;
		} else {
			var img = `<img src="${i}">`;
		}

		if(p){
			var pr = `₱${p}`;
		} else {
			var pr = "Price Unavailable";
		}

		var t1 = (p);
		var t2 = (+p * 2);
		var t3 = (+p * 3);
		var t4 = (+p * 4);
		var t5 = (+p * 5);
		var t6 = (+p * 6);
		var t7 = (+p * 7);
		var t8 = (+p * 8);
		var t9 = (+p * 9);
		var t10 = (+p * 10);

		var tmpl = `
			<div class="card hoverable product cat${cid}" width="100%">
				<div class="card-img">
					${img}
				</div>
				<div class="card-content">
					<span class="card-title">
						<b>${n}</b><br>
						${pr}
					</span>
					<br>
					<p>
						<i class="material-icons grey-text text-darken-1">info_outline</i> ${c}<br>
						<i class="material-icons grey-text text-darken-1">note</i> ${d}<br>
						<i class="material-icons grey-text text-darken-1">label</i> ${cn}<br>
					</p>
					<div class="input-field col s12">
						<span id="totSliders${pid}">${qty} item(s) for ${pr}</span>
						<p class="range-field">
							<input type="range" min="1" max="10" id="qtys${pid}" value="${qty}">
						</p>
					</div>
				</div>
				<div class="card-action">
					<a href="#" onclick="updateItem('${pid}','0','0'); renderRundown()" class="red-text text-darken-3">Remove</a>
				</div>
			</div>
			<script>
			$("#qtys${pid}").change(()=>{
				var q = $("#qtys${pid}").val();

				if(q==0){
					$("#totSliders${pid}").html("Quantity");
					updateItem('${pid}','0','0');
				}
				if(q==1){
					$("#totSliders${pid}").html("1 item for ₱${t1}");
					updateItem('${pid}','1','${t1}');
				}
				if(q==2){
					$("#totSliders${pid}").html("2 items for ₱${t2}");
					updateItem('${pid}','2','${t2}');
				}
				if(q==3){
					$("#totSliders${pid}").html("3 items for ₱${t3}");
					updateItem('${pid}','3','${t3}');
				}
				if(q==4){
					$("#totSliders${pid}").html("4 items for ₱${t4}");
					updateItem('${pid}','4','${t4}');
				}
				if(q==5){
					$("#totSliders${pid}").html("5 items for ₱${t5}");
					updateItem('${pid}','5','${t5}');
				}
				if(q==6){
					$("#totSliders${pid}").html("6 items for ₱${t6}");
					updateItem('${pid}','6','${t6}');
				}
				if(q==7){
					$("#totSliders${pid}").html("7 items for ₱${t7}");
					updateItem('${pid}','7','${t7}');
				}
				if(q==8){
					$("#totSliders${pid}").html("8 items for ₱${t8}");
					updateItem('${pid}','8','${t8}');
				}
				if(q==9){
					$("#totSliders${pid}").html("9 items for ₱${t9}");
					updateItem('${pid}','9','${t9}');
				}
				if(q==10){
					$("#totSliders${pid}").html("10 items for ₱${t10}");
					updateItem('${pid}','10','${t10}');
				}

				setTotalPriceRundown();
			});
		</script>
		`;

		$("#rundownList").append(tmpl);

	});

	setTotalPriceRundown();
};

var setTotalPriceRundown = ()=>{
	var items = getOrderItems();
	sessionStorage.setItem("all-wet-rundown-total",0);
	
	$.each(items, (index,value)=>{
		var pr = value.price;
		var tot = sessionStorage.getItem("all-wet-rundown-total");
		var total = (+tot + +pr);
		sessionStorage.setItem("all-wet-rundown-total",total);
	});

	var tot = sessionStorage.getItem("all-wet-rundown-total");

	var prep = `which has a Total of ₱${tot}`;
	$("#totalAmountRundown").html(prep);
};

var showPaymentActivity = ()=>{
	if(!window.PaymentRequest){
		$("#payWithCardButton").hide();
	}

	clear();
	$("#paymentActivity").fadeIn();
};

var payWithCash = ()=>{
	showCompleteActivity();
};

var payWithCard = ()=>{
	var supportedInstruments = [{
		supportedMethods:['basic-card'],
		data:{
			supportedNetworks:['visa','mastercard']
		}
	}];

	var tot = sessionStorage.getItem("all-wet-rundown-total");

	var details = {
		total: {
			label: 'Total due',
			amount: { currency: 'PHP', value: tot}
		}
	};

	var request = new PaymentRequest(supportedInstruments,details);

	request.show()
		.then(uiResult=>{
			processPaymentDetails(uiResult).then(uiResult=>{
				uiResult.complete('success');
				M.toast({html:"Payment Successful!", durationLength:3000});
				showCompleteActivity();
			});
		}).catch(e=>{
			console.log(e);
			M.toast({html:"An Error Occured While Processing Card Payment", durationLength:3000});
		});

	var processPaymentDetails = uiResult=>{
		return new Promise(resolve=>{
			setTimeout(()=>{
				resolve(uiResult);
			}),2000;
		});
	};
};

var showCompleteActivity = ()=>{
	clear();
	$("#completeActivity").fadeIn();
}
