$(document).ready(()=>{
	init();
	loginCheck();
	clear();

	splash(1000);

	locateLocation();
	setSavedLocationButton();
	$('select').formSelect();

	setInterval(recheckLoginStatus(),120000);
});

var checkLoginStatus = ()=>{
	return localStorage.getItem('all-wet-login');
};

var loginCheck = ()=>{
	let status = checkLoginStatus();
	if(status != "true"){
		window.location.replace("/");
	} else {
		var at = localStorage.getItem("all-wet-account-type");
		if(at !== "customer"){
			window.location.replace("/");
		}
	}
};

var recheckLoginStatus = ()=>{
	$.ajax({
		type:'POST',
		url:'/authenticate/signInStatus.php',
		cache:'false',
		success: result=>{
			try {
				if(result.is_signed_in == 'False'){
					localStorage.clear();
					window.location.replace("/");
				} else {
					if(result.account_type !== "customer"){
						window.location.replace("/");
					}
				}
			} catch(e){
				console.log(e);
			}
		}
	}).fail(()=>{
		console.log("Cannot check sign-in status");
	});
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


var setSavedLocationButton  = ()=>{

	var hideButton = ()=>{
		$(".saveAdr").hide();
	};

	if(localStorage.getItem("all-wet-customer-info")){
		var customerInfo = JSON.parse(localStorage.getItem("all-wet-customer-info"));
		try {
			if(!customerInfo.customer_address){
				hideButton();
			}
		} catch(e){
			hideButton();
		}
	} else {
		hideButton();
	}
};

var locateLocation = ()=>{
	$("#locationLoaderActivity").fadeIn();
	if("geolocation" in navigator){
		var opts = {
			enableHighAccuracy: true,
			timeout: 30000
		};

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
		},opts);
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
	var exactloc = $("#manualAddress").val();
	if(!exactloc){
		M.toast({html:"Please Enter a Location", durationLength:3000});
	} else {
			setOrderActivity();
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

					var lat = "";
					var lon = "";
					var cty = "";
					var adr = "";

					try {
						var lat = result['results'][0]['geometry']['location']['lat'];
						var lon = result['results'][0]['geometry']['location']['lng'];
						var cty = result['results'][0]['address_components'][1]['long_name'];
						var adr = result['results'][0]['formatted_address'];
					} catch(e){
						console.log(e);
					}

					sessionStorage.setItem("latitude",lat);
					sessionStorage.setItem("longitude",lon);
					sessionStorage.setItem("formatted_address",adr);
					sessionStorage.setItem("city",cty);
				}
			}).fail(()=>{
        console.log("Cannot get coordinates of location");
			});
	}
}

setLocAsCustomerAddress = ()=>{
	overrideLocation();
	var customer = JSON.parse(localStorage.getItem("all-wet-customer-info"));
	var adr = customer.customer_address;

	sessionStorage.setItem("exact_location",adr);

	setOrderActivity();

	$.ajax({
		type:'GET',
		cache: 'false',
		data: {
			address:adr
		},
		url: 'https://maps.google.com/maps/api/geocode/json?key=AIzaSyBDOL-nNs8SKrlnkr97ByrLwJZ6PHLXeas',
		success: result=>{
		console.log(result['results']);

			var lat = "";
			var lon = "";
			var cty = "";
			var adr = "";

			try {
				var lat = result['results'][0]['geometry']['location']['lat'];
				var lon = result['results'][0]['geometry']['location']['lng'];
				var cty = result['results'][0]['address_components'][1]['long_name'];
				var adr = result['results'][0]['formatted_address'];
			} catch(e){
				console.log(e);
			}

			sessionStorage.setItem("latitude",lat);
			sessionStorage.setItem("longitude",lon);
			sessionStorage.setItem("formatted_address",adr);
			sessionStorage.setItem("city",cty);
		}
	}).fail(()=>{
		console.log({module:"setLocAsCustomerAddress",message:"Cannot get coordinates of location"});
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

	if(Navigator.onLine){
		$.ajax({
			type:'POST',
			cache:'false',
			url:'/api/Product/getAll.php',
			success: result=>{
				localStorage.setItem("all-wet-product",JSON.stringify(result));
				renderProducts();
			}
		}).fail(()=>{
			renderProducts();
		});
	} else {
		renderProducts();
	}
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
			var t10 = (+p * 10);
			var t11 = (+p * 11);
			var t12 = (+p * 12);
			var t13 = (+p * 13);
			var t14 = (+p * 14);
			var t15 = (+p * 15);

			var tmpl = `
				<div class="card hoverable product cat${cid} col s12">
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
								<input type="range" min="0" max="15" id="qty${id}" value="0">
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
						if(q==11){
							$("#totSlider${id}").html("Eleven (11) for ₱${t11}");
							updateItem('${id}','11','${t11}');
						}
						if(q==12){
							$("#totSlider${id}").html("Twelve (12) for ₱${t12}");
							updateItem('${id}','12','${t12}');
						}
						if(q==13){
							$("#totSlider${id}").html("Thirteen (13) for ₱${t13}");
							updateItem('${id}','13','${t13}');
						}
						if(q==14){
							$("#totSlider${id}").html("Fourteen (14) for ₱${t14}");
							updateItem('${id}','14','${t14}');
						}
						if(q==15){
							$("#totSlider${id}").html("Fifteen (15) for ₱${t15}");
							updateItem('${id}','15','${t15}');
						}
					});
				</script>
			`;

			$("#productsList").append(tmpl);
		});

	} catch(e){
		M.toast({html:"Cannot display products", completeCallback: ()=>{window.location.replace('/app/');}});
	}
}

var setCategories = ()=>{
	if(navigator.onLine){
		$.ajax({
			type: 'GET',
			cache: 'false',
			url: '/api/Category/getAll.php',
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
		});
	} else {
		renderCategories();
	}
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
		var t11 = (+p * 11);
		var t12 = (+p * 12);
		var t13 = (+p * 13);
		var t14 = (+p * 14);
		var t15 = (+p * 15);

		var tmpl = `
			<div class="card hoverable product cat${cid} col s12">
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
							<input type="range" min="1" max="15" id="qtys${pid}" value="${qty}">
						</p>
					</div>
				</div>
				<div class="card-action">
					<a href="#" onclick="updateItem('${pid}','0','0'); renderRundown()" class="red-text text-darken-3">Remove</a>
				</div>
			</div>
			<script>
			$("#qtys${pid}").change(()=>{
				qtyChange${pid}();
			});
			$("#qtys${pid}").click(()=>{
				qtyChange${pid}();
			});

			var qtyChange${pid} = ()=>{
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
				if(q==11){
					$("#totSlider${pid}").html("11 items for ₱${t11}");
					updateItem('${pid}','11','${t11}');
				}
				if(q==12){
					$("#totSlider${pid}").html("12 items for ₱${t12}");
					updateItem('${pid}','12','${t12}');
				}
				if(q==13){
					$("#totSlider${pid}").html("13 items for ₱${t13}");
					updateItem('${pid}','13','${t13}');
				}
				if(q==14){
					$("#totSlider${pid}").html("14 items for ₱${t14}");
					updateItem('${pid}','14','${t14}');
				}
				if(q==15){
					$("#totSlider${pid}").html("15 items for ₱${t15}");
					updateItem('${pid}','15','${t15}');
				}

				setTotalPriceRundown();
			};
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
	sessionStorage.setItem("all-wet-order-payment-method","CASH_ON_DELIVERY");
	processTransaction();
	showCompleteActivity();
};

var payWithCard = ()=>{
	var supportedInstruments = [{
		supportedMethods:['basic-card'],
		data:{
			supportedNetworks:['visa','mastercard','amex']
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
				sessionStorage.setItem("all-wet-order-payment-method","CREDIT_CARD");
				processTransaction();
				showCompleteActivity();
			});
		}).catch(e=>{
			console.log(e);
			M.toast({html:"Cannot Proceed with Card Payment", durationLength:3000});
		});

	var processPaymentDetails = uiResult=>{
		return new Promise(resolve=>{
			setTimeout(()=>{
				resolve(uiResult);
			}),2000;
		});
	};
};

var processTransaction = ()=>{
	var ci = localStorage.getItem("all-wet-customer-id");
	var tc = JSON.parse(sessionStorage.getItem("all-wet-order-items")).length;
	var tp = sessionStorage.getItem("all-wet-rundown-total");
	var pm = sessionStorage.getItem("all-wet-order-payment-method");
	var st = "PROCESSING";
	var lt = sessionStorage.getItem("latitude");
	var lo = sessionStorage.getItem("longitude");
	var adr = sessionStorage.getItem("exact_location");	
	if(adr > 5){
		var adr = sessionStorage.getItem("formatted_address");
	}
	var itms = JSON.parse(sessionStorage.getItem("all-wet-order-items"));

	var ar = {
		"customer_id":ci,
		"transaction_count":tc,
		"transaction_price":tp,
		"transaction_payment_method":pm,
		"transaction_status":st,
		"transaction_latitude":lt,
		"transaction_longitude":lo,
		"transaction_address":adr,
		"transaction_items":itms
	};

	sendTransaction(ar);
};

var sendTransaction = (trans)=>{
	$.ajax({
		type:'POST',
		cache:'false',
		url:'/api/Transaction/add.php',
		data:{
			"customer_id": trans.customer_id,
			"transaction_count": trans.transaction_count,
			"transaction_price": trans.transaction_price,
			"transaction_payment_method": trans.transaction_payment_method,
			"transaction_status": trans.transaction_status,
			"transaction_latitude": trans.transaction_latitude,
			"transaction_longitude": trans.transaction_longitude,
			"transaction_address": trans.transaction_address
		},
		success: result=>{
			var tid = result.transaction_id;
			var ti = JSON.stringify(trans.transaction_items);
			$.ajax({
				type:'POST',
				cache:'false',
				url:'/api/TransItem/add.multiple.php',
				data: {
					"transaction_id":tid,
					"transaction_items":ti
				},
				success: result=>{
					console.log(result);
				}

			}).fail(()=>{
				M.toast({html:"Error sending items you ordered, contact All Wet for help", durationLength:3000});
			});
		}
	}).fail(()=>{
		M.toast({html:"Failed to send order, it will be sent automatically when you go online", durationLength:3000});
		addToQueue(trans);
	});
}

var getQueue = ()=>{
	if(localStorage.getItem("all-wet-order-queue")){
		var queue = JSON.parse(localStorage.getItem("all-wet-order-queue"));
	} else {
		var queue = [];
		localStorage.setItem("all-wet-order-queue",JSON.stringify(queue));
	}

	return queue;
}

var addToQueue = (trans)=>{
	var queue = getQueue();
	queue.push(trans);
	localStorage.setItem("all-wet-order-queue",JSON.stringify(queue));
};

var showCompleteActivity = ()=>{
	clear();
	$("#completeActivity").fadeIn();
}
