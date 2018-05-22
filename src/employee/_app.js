$(document).ready(()=>{
	$("meta[name='theme-color']").attr("content","#455a64");
	clear();

	$(".sidenav").sidenav();
	$('.modal').modal();
	loginCheck();

	setForDelivery();
	setProducts();

	splash(1000);
	forDeliveryShow();
	setUserFields();

	setInterval(recheckLoginStatus(),300000);
});

// API URLS
let transactionGetApi = '/api/Transaction/getAll.php';
let transactionUpdateStatus = '/api/Transaction/updateStatus.php';
let productGetAllApi = '/api/Product/getAll.php';
let transitemGetByProductIdApi = '/api/TransItem/getByProductId.php';
let categoryGetAll = '/api/Category/getAll.php';
let employeeUpdate = '/api/Employee/update.php';
let employeeGet = '/api/Employee/get.php';

// Global Variables
let errorCard = `
	<div class="card">
		<div class="card-content">
			<center><p class="grey-text">An Error Occured</p></center>
		</div>
	</div>
`;

let preloader = `
	<center>
		<div class="preloader-wrapper big active">
			<div class="spinner-layer spinner-blue-only">
				<div class="circle-clipper left">
					<div class="circle"></div>
				</div><div class="gap-patch">
					<div class="circle"></div>
				</div><div class="circle-clipper right">
					<div class="circle"></div>
				</div>
			</div>
		</div>
	</center>
`;

// UI Functions
var clear = ()=>{
	$(".activity").hide();
}
var closeNav = ()=>{
	$(".sidenav").sidenav('close');
}
var productFilter = (catId)=>{
	$(".product").hide();
	$(`.${catId}`).fadeIn();
};

// Activity Loader
var forDeliveryShow = ()=>{
	clear();
	closeNav();
	$("#forDeliveryActivity").fadeIn();
}

var productsShow = ()=>{
	clear();
	closeNav();
	$("#productsActivity").fadeIn();
}

var editAccountShow = ()=>{
	clear();
	closeNav();
	$("#editAccountActivity").fadeIn();
};


// App Functions
var checkLoginStatus = ()=>{
	return localStorage.getItem('all-wet-login');
};

var loginCheck = ()=>{
	let status = checkLoginStatus();
	if(status != "true"){
		window.location.replace("/");
	} else {
		var at = localStorage.getItem("all-wet-account-type");
		if(at !== "employee"){
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
					if(result.account_type !== "employee"){
						window.location.replace("/");
					}
				}
			} catch(e){
				console.log(e);
			}
		}
	}).fail(()=>{
		console.log({module:"recheckLoginStatus",message:"Cannot check sign-in status"});
	});
};

var setForDelivery = ()=>{

    $("#forDeliveryList").html(preloader);

    if(navigator.onLine){
    	$.ajax({
	        type:'GET',
	        cache: 'false',
	        url: transactionGetApi,
	        success: result => {
	            try {
	                localStorage.setItem("all-wet-for-delivery",JSON.stringify(result));
	                renderForDelivery();
	            } catch(e) {
	                $("#forDeliveryList").html(errorCard);
	                M.toast({html:"Error processing request", displayLength:3000});
	            }
	        }
	    }).fail(()=>{
	        renderForDelivery();
	        M.toast({html: "Cannot get new for delivery list", displayLength:3000});
	    });
    } else {
    	renderForDelivery();
    }
    
}

var renderForDelivery = ()=>{
    var empty = `
	<div class='card'>
		<div class='card-content'>
			<center>Nothing to Deliver Yet</center>
		</div>
	</div>
    `;

    try {
        var result = JSON.parse(localStorage.getItem("all-wet-for-delivery"));
        if(result.code == 400){
            $("#forDeliveryList").html(empty);
        } else {
            $("#forDeliveryList").html(" ");

            $.each(result,(index,order)=>{
                var mpimg = " ";

                var tid = order['transaction_id'];
                var td = order['transaction_date'];
                var tt= order['transaction_time'];
                var cid = order['customer_id'];
                var tc = order['transaction_count'];
                var tp = order['transaction_price'];
                var tpm = order['transaction_payment_method'];
                var ts = order['transaction_status'];
                var tlo = order['transaction_longitude'];
                var tlt = order['transaction_latitude'];
				var ta = order['transaction_address'];
				var c = order['customer'];
				var cname = c.customer_name;
				var cnum = c.customer_number;

                if (tc <= 1) {
					var qv = "item";
				} else {
					var qv = "items";
				}
		  
				if(tpm === "CASH_ON_DELIVERY"){
					var tpm = "Cash on Delivery";
				}
		  
				if(tpm === "CREDIT_CARD"){
					var tpm = "Credit Card";
				}
		  
				if(ts === "PROCESSING"){
					var ts = "Processing Order";
				}
				if(ts === "FOR_DELIVERY"){
					var ts = "For Delivery";
				}
		  
				if(ts === "CANCELLED"){
					var ts = "Cancelled Delivery";
				}
		  
				if(ts === "DELIVERED"){
					var ts = "Delivered";
				}
		  
				if (tlo) {
					var mpimg = `
					  <div class="card-img">
						  <img src="https://maps.googleapis.com/maps/api/staticmap?center=${tlt},${tlo}&zoom=17&size=800x300&markers=color:blue%7C${tlt},${tlo}&key=AIzaSyCuNfQSkwl85bk38k4de_QR-DwBGL-069o" width="100%">
					  </div>
					`;
		  
					var dest = `https://www.google.com/maps/dir/?api=1&destination=${tlt},${tlo}`;
				} else {
					var mpimg = `
						<div class="card-img">
							<img src="https://maps.googleapis.com/maps/api/staticmap?center=${ta}&zoom=17&size=800x300&markers=color:blue%7C${ta}&key=AIzaSyCuNfQSkwl85bk38k4de_QR-DwBGL-069o" width="100%">
						</div>
					`;
					
					var dest = `https://www.google.com/maps/dir/?api=1&destination=${ta}`;
				}

				if(!cname){
					var cname = "Unknown Customer";
				}

				  var templ = `
				  <div class="card hoverable">
					${mpimg}
					<div class="card-content">
					  <span class="card-title">${ta}</span>
					  <p><font size="3pt" class="grey-text">${td} ${tt}</font></p>
					  <br>
					  <p style="line-height:1.5">
					  <i class="material-icons grey-text text-darken-1">person</i> ${cname}<br>
					  <i class="material-icons grey-text text-darken-1">local_offer</i> ₱${tp} for ${tc} ${qv}<br>
					  <i class="material-icons grey-text text-darken-1">payment</i> ${tpm}<br>
					  <i class="material-icons grey-text text-darken-1">linear_scale</i> ${ts}
					  </p>
					</div>
					<div class="card-action">
					  <a href="#" onclick="deliveryMode('${index}')" class="grey-text"><i class="material-icons">play_arrow</i></a>
					  <a href="${dest}" class="grey-text"><i class="material-icons">map</i></a>
					  <a href="tel:+63${cnum}" class="grey-text"><i class="material-icons">call</i></a>
					</div>
				  </div>
				`;
				
				if(ts !== "Cancelled Delivery"){
					$("#forDeliveryList").append(templ);
				}

            });

        }
    } catch(e){
    	console.log(e);
        $("#forDeliveryList").html(errorCard);
    }
};

var setCategories = ()=>{
	if(navigator.onLine){
		$.ajax({
			type: 'GET',
			cache: 'false',
			url: categoryGetAll,
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
	} else {
		renderCategories();
	}
	
};

var renderCategories = ()=>{
	try {
		var addAllCategories = `<li class="tab"><a href="#" onclick="productFilter('product')">All</a></li>`;
		var result = JSON.parse(localStorage.getItem("all-wet-categories"));

		$("#categoryTabs").html(addAllCategories);

		$.each(result,(index,value)=>{
			var cid = value['category_id'];
			var cn = value['category_name'];
			var cd = value['category_description'];
			var cc = value['category_code'];

			var tmpl = `
				<li class="tab">
					<a href="#" onclick="productFilter('cat${cid}')">${cn}</a>
				</li>`;
			$("#categoryTabs").append(tmpl);
		});
	} catch(e){
		M.toast({html:"Fatal error: Cannot processs categories"});
	}
}



var setProducts = ()=>{
	setCategories();

	var empty = `
	<div class='card'>
		<div class='card-content'>
			<center>No Products Yet</center>
		</div>
	</div>
	`;

	$("#productsList").html(preloader);

	if(navigator.onLine){
		$.ajax({
			type:'GET',
			cache: 'false',
			url: productGetAllApi,
			data: {
				a: 1
			},
			success: result=>{
				try{
					localStorage.setItem("all-wet-product",JSON.stringify(result));
					renderProduct();
				}
				catch(e){
					console.log(`Products Error: ${e}`);
					$("#productsList").html(errorCard);
					M.toast({html:"An error fetching data",displayLength:3000});
				}
			}
		}).fail(()=>{
			renderProduct();
			M.toast({html:"Cannot get new products",displayLength:3000});
		});
	} else {
		renderProduct();
	}

}

var renderProduct = ()=>{
	try{
		var result = JSON.parse(localStorage.getItem("all-wet-product"));

		$("#productsList").html(" ");
		$.each(result, (index,value)=>{
			var n = value['product_name'];
			var c = value['product_code'];
			var d = value['product_description'];
			var cat = value['category_id'];
			var cn = value['category_name'];
			var p = value['product_price'];
			var a = value['product_available'];
			var i = value['product_image'];

			if(i){
				var img = `
				<div class="card-img">
					<img src="${i}" width="100%">
				</div>
				`;
			} else {
				var img = ``;
			}

			if(a == 'True'){
				var a = "Available";
			} else {
				var a = "Out of Stock";
			}


			if(p){
				var p = `₱${p}`;
			} else {
				var p = "Price Unavailable";
			}

			var templ = `
				<div class="card hoverable product cat${cat}">
					${img}
					<div class="card-content">
						<span class="card-title">
							<b>${n}</b><br>
							${p}
						</span>
						<br>
						<p style="line-height:1.5">
							<i class="material-icons grey-text text-darken-1">info_outline</i> ${c}<br>
							<i class="material-icons grey-text text-darken-1">note</i> ${d}<br>
							<i class="material-icons grey-text text-darken-1">label</i> ${cn}<br>
							<i class="material-icons grey-text text-darken-1">local_offer</i> ${a}
						</p>
					</div>
				</div>
			`;

			$("#productsList").append(templ);
		});


	} catch(e){
		$("#productsList").html(errorCard);
	}
}

var getUserFields = ()=>{
	var i = localStorage.getItem("all-wet-employee-id");
	$.ajax({
		type:'GET',
		cache:'false',
		url: employeeGet,
		data:{
			employee_id: i
		},
		success: result=>{
			localStorage.setItem("all-wet-employee-info", JSON.stringify(result));
			localStorage.setItem("all-wet-employee-name",result.employee_name);
			localStorage.setItem("all-wet-employee-username",result.employee_username);
		}
	});
};

var setUserFields = ()=>{
	var n = localStorage.getItem("all-wet-employee-name");
	var u = localStorage.getItem("all-wet-employee-username");

	$("#empName").html(`<b>${n}</b>`);
	$("#empUsername").html(`@${u}`);

	$("#nameField").val(n);
	$("#usernameField").val(u);
};

var editAccount = ()=>{
	var i = localStorage.getItem("all-wet-employee-id");
	var n = $("#nameField").val();
	var u = $("#usernameField").val();
	var p = $("#passwordField").val();

	$.ajax({
		type:'POST',
		cache: 'false',
		url: employeeUpdate,
		data:{
			employee_id: i,
			employee_name: n,
			employee_username: u,
			employee_password: p
		},
		success: result=>{
			if(result.code){
				M.toast({html:result.message,durationLength:3000});
				getUserFields();
				setUserFields();
			}
		}
	}).fail(()=>{
		M.toast({html:"An Error Occurred", durationLength:3000});
	});
};

var setAsDelivered = (id)=>{
	$.ajax({
		type:'POST',
		url: transactionUpdateStatus,
		data: {
			transaction_id:id,
			transaction_status:'DELIVERED',
		},
		cache:'false',
		success: result=>{
			if(result.code === 200){
				clear();
				setForDelivery();
			} else {
				M.toast({html:result.message, durationLength:3000});
			}
		}
	}).fail(()=>{
		M.toast({html:"An Error Occurred", durationLength:3000});
	});
};

var deliveryMode = (index)=>{
	try {
		var transList = JSON.parse(localStorage.getItem("all-wet-for-delivery"));
		var trans = transList[index];
		
		var tid = trans.transaction_id;
		var td = trans.transaction_date;
		var tt= trans.transaction_time;
		var cid = trans.customer_id;
		var tc = trans.transaction_count;
		var tp = trans.transaction_price;
		var tpm = trans.transaction_payment_method;
		var ts = trans.transaction_status;
		var tlo = trans.transaction_longitude;
		var tlt = trans.transaction_latitude;
		var ta = trans.transaction_address;
		var c = trans.customer;
		var cname = c.customer_name;
		var cnum = c.customer_number;
		var ti = trans.transitem;

		if (tc <= 1) {
			var qv = "item";
		  } else {
			var qv = "items";
		  }
  
		  if(tpm === "CASH_ON_DELIVERY"){
			var tpm = "Cash on Delivery";
		  }
  
		  if(tpm === "CREDIT_CARD"){
			var tpm = "Credit Card";
		  }
  
		  if(ts === "PROCESSING"){
			var ts = "Processing Order";
		  }
		  if(ts === "FOR_DELIVERY"){
			var ts = "For Delivery";
		  }
  
		  if(ts === "CANCELLED"){
			var ts = "Cancelled Delivery";
		  }
  
		  if(ts === "DELIVERED"){
			var ts = "Delivered";
		  }
  
		  if (tlo) {
			var mpimg = `
			  <div class="card-img">
				  <img src="https://maps.googleapis.com/maps/api/staticmap?center=${tlt},${tlo}&zoom=17&size=800x300&markers=color:blue%7C${tlt},${tlo}&key=AIzaSyCuNfQSkwl85bk38k4de_QR-DwBGL-069o" width="100%" style="border-radius:15px">
			  </div>
			`;
  
			var dest = `https://www.google.com/maps/dir/?api=1&destination=${tlt},${tlo}`;
		  } else {

			var mpimg = `
			  <div class="card-img">
				  <img src="https://maps.googleapis.com/maps/api/staticmap?center=${ta}&zoom=17&size=800x300&markers=color:blue%7C${ta}&key=AIzaSyCuNfQSkwl85bk38k4de_QR-DwBGL-069o" width="100%" style="border-radius:15px">
			  </div>
			`;

			var dest = `https://www.google.com/maps/dir/?api=1&destination=${ta}`;
		  }

		if(!cname){
			var cname = "Unknown Customer";
		}

		$("#dmAddress").html(ta);
		$("#dmCountPrice").html(`${tc} ${qv} for ₱${tp}`);
		$("#dmCustomerName").html(cname);
		$("#dmDateTime").html(`${td} ${tt}`);
		$("#dmPaymentMethod").html(tpm);
		$("#dmMapImage").html(mpimg);

		var cnt = `
			<a href="tel:+63${cnum}" class="btn btn-large btn-block green darken-2"><i class="material-icons">phone</i></a><br>
			<a href="sms:+63${cnum}" class="btn btn-large btn-block green darken-2"><i class="material-icons">message</i></a>
		`;
		$("#dmContactCustomer").html(cnt);

		$("#dmCancelButton").html(`<a href="#" onclick="setAsCancelled('${tid}'); clear(); setForDelivery();" class="btn btn-large btn-block red darken-2">Cancel</a>`);

		var mainact = `
			<a href="${dest}" target="_blank" class="btn btn-large btn-block blue darken-2">Directions</a><br>
			<a href="#" onclick="setAsDelivered('${tid}'); clear(); setForDelivery();" class="btn btn-large btn-block blue darken-4">Delivered</a>
		`;

		$("#dmMainAct").html(mainact);

		$("#dmTransItem").html("");
		$.each(ti, (index,value)=>{
			var pn = value.product_name;
			var tiq = value.transitem_quantity;

			if(tiq > 1){
				var qv = "pieces";
			} else {
				var qv = "piece";
			}

			var tpl = `<li class="collection-item">${pn} (${tiq} ${qv})</li>`;
			$("#dmTransItem").append(tpl);
		});

		clear();
		$("#deliveryModeActivity").fadeIn();
	} catch(e){
		console.log(e);
		M.toast({html:"Cannot enter delivery mode", durationLength:3000});
	}
};

var setAsCancelled = (id)=>{
	$.ajax({
		type:'POST',
		url: transactionUpdateStatus,
		data: {
			transaction_id:id,
			transaction_status:'CANCELLED',
		},
		cache:'false',
		success: result=>{
			if(result.code === 200){
				clear();
				setForDelivery();
			} else {
				M.toast({html:result.message, durationLength:3000});
			}
		}
	}).fail(()=>{
		M.toast({html:"An Error Occurred", durationLength:3000});
	});
}