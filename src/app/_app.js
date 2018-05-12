$(document).ready(()=>{
	loginCheck();
	
	clear();

	$(".sidenav").sidenav();
	$('.modal').modal();

	$("#btnAdd").hide();

	init();

	setCustomerInfo();
	setMyOrders();
	setQueue();
	setProducts();


	splash(1000);
	$("#myorderActivity").fadeIn();
	$("#btnAdd").slideDown();

	setInterval(recheckLoginStatus(),300000);
	setInterval(processQueue(),300000);
	
});

// API URLS
let transactionGetApi = '/api/Transaction/getByCustomerId.php'; 
let productGetAllApi = '/api/Product/getAll.php';
let transitemGetByTransactionIdApi = '/api/TransItem/getByTransactionId.php';
let categoryGetAll = '/api/Category/getAll.php';

// Global Cards
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
var orderShow = ()=>{
	$("#btnAdd").hide();
	clear();
	closeNav();
	$("#myorderActivity").fadeIn(); 
	$("meta[name='theme-color']").attr("content","#1565c0");
	$("#btnAdd").slideDown();	
}

var deliveredShow = ()=>{
	clear();
	closeNav();
	$("#deliveredActivity").fadeIn();
};

var queueShow = ()=>{
	clear();
	closeNav();
	$("#queueActivity").fadeIn();
};

var productsShow = ()=>{
	clear();
	closeNav();
	$("#productsActivity").fadeIn();
	$("meta[name='theme-color']").attr("content","#1565c0");
}

var editAccountShow = ()=>{
	clear();
	closeNav();
	$("#editAccountActivity").fadeIn();
	$("meta[name='theme-color']").attr("content","#455a64");
};

var aboutAppShow = ()=>{
	clear();
	closeNav();
	$("#aboutAppActivity").fadeIn();
};

// App Functions
var init = ()=>{

	// Sets mobile number in side nav
	var customer_number = 0 + localStorage.getItem('all-wet-customer-number');
	$('#sidenav_customer_number').html(customer_number);

};


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
		console.log({module:"recheckLoginStatus",message:"Cannot check sign-in status"});
	});
};

var getCustomerId = ()=>{
	return localStorage.getItem('all-wet-customer-id');
}

var setMyOrders = ()=>{
	var empty = `
	<div class='card'>
		<div class='card-content'>
			<center>No Transactions Yet</center>
		</div>
	</div>
	`;

	$("#orderList").html(preloader);
	$("#deliveredList").html(preloader);

	var cid = getCustomerId();

	var doAjax = ()=>{
				$.ajax({
			type:'POST',
			url: transactionGetApi,
			cache: 'false',
			data: {
				customer_id: cid
			},
			success: result=>{
				try{
					
					localStorage.setItem("all-wet-myorders",JSON.stringify(result));

					if(result.code == "400"){
						$("#orderList").html(empty);
					} else {
						renderMyOrder();
					}

				}
				catch(e) {
					console.log(`My Orders Error: ${e}`);
					$("#orderList").html(errorCard);
					console.log({module:"setMyOrders",message:"Error Fetching Data"});
					M.toast({html:"An error fetching data",displayLength:3000});
				}
			}
		}).fail(()=>{
			renderMyOrder();
			console.log({module:"setMyOrders",message:"Cannot get new orders"});
		});

	};

	if(navigator.onLine){
		doAjax();
	} else {
		renderMyOrder();
	}
	
};

var renderMyOrder = ()=>{
	try {
		var result = JSON.parse(localStorage.getItem("all-wet-myorders"));
		
		$("#orderList").html(" ");
		$("#deliveredList").html(" ");

		if(result.length < 0){
			var emptyCard = `
				<div class="card">
					<div class="card-content">
						<center>
							<style>
								.material-icons.md-48 { font-size: 48px; }
							</style>
							<h5 class="grey-text">
								<i class="material-icons md-48">tag_faces</i><br><br>
								Tap the + icon to order
							</h5>
						</center>
					</div>
				</div>
			`;
			$("#orderList").html(emptyCard);
			$("#deliveredList").html(emptyCard);
		} else {
			$.each(result, (index,order)=>{
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

				if(tc <= 1) {
					var qv = "item";
				} else {
					var qv = "items";
				}

				if(tlo){
					var mpimg = `
						<div class="card-img">
							<img src="https://maps.googleapis.com/maps/api/staticmap?center=${tlt},${tlo}&zoom=17&size=800x300&markers=color:blue%7C${tlt},${tlo}&key=AIzaSyCuNfQSkwl85bk38k4de_QR-DwBGL-069o" width="100%">
						</div>
					`;
				}
        
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

				var tmpl = `
					<div class="card hoverable" id="${tid}TransactionCard">
						${mpimg}
						<div class="card-content">
							<span class="card-title">${ta}</span>
							<p><font size="3pt" class="grey-text">${td} ${tt}</font></p>
							<br>
							<p style="line-height:1.5">
								<i class="material-icons grey-text text-darken-1">local_offer</i> ₱${tp} for ${tc} ${qv}<br>
								<i class="material-icons grey-text text-darken-1">payment</i> ${tpm}<br>
								<i class="material-icons grey-text text-darken-1">linear_scale</i> ${ts}
							</p>
						</div>
						<div class="card-action">
							<a class="black-text activator" href="#${tid}ItemsModal">See Items</a>
						</div>
						<div class="card-reveal">
							<span class="card-title grey-text text-darken-4">Items<i class="material-icons right">close</i></span>
							<ul class="collection" id="items${tid}">
								<li class="collection-item">
									<center>
										${preloader} 
									</center>
								</li>
							</ul>
						</div>
					</div>
				`;

				if(ts == 'DELIVERED'){
					$("#deliveredList").append(tmpl);
				} else {
					$("#orderList").append(tmpl);	
				}
				

				$.ajax({
					type:'POST',
					cache: 'false',
					url: transitemGetByTransactionIdApi,
					data: {
						transaction_id: tid
					},
					success: result => {
						if(result.message == 400){
			              $(`#items${tid}`).html(`<li class="collection-item"><center>Error Processing Items</center></li>`);
			            } else {
			              $(`#items${tid}`).html(" ");
			              $.each(result, (index, item)=>{
			              	console.log(item);
			                var pid = item.product_id;
			                var pn = item.product_name;
			                var tq = item.transitem_quantity;
			                
			                if(tq <= 1) {
			                  var qv = "piece";
			                } else {
			                  var qv = "pieces";
			                }
			                
			                var tmpl = `
			                  <li class="collection-item black-text">
			                    <b>${pn}</b> (${tq} ${qv})
			                  </li>
			                `;

			                $(`#items${tid}`).append(tmpl);
			              });
				        }
					}
				}).fail(()=>{
					$(`#items${tid}`).html(`<li class="collection-item"><center>Error Fetching Items</center></li>`);
				});

			});
		}

	} catch(e){
		console.log(`My Orders Error: ${e}`);
		$("#orderList").html(errorCard);
	}
};

var setCategories = ()=>{
	if(navigator.onLine){
		$.ajax({
			type: 'GET',
			cache: 'false',
			url: categoryGetAll,
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
			console.log({module:"setCategories",message:"Cannot get categories"});
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
		console.log({module:"renderCategories",message:"Cannot process categories"});
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
			type:'POST',
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
					console.log({module:"setProducts",message:"An error occured while fetching data"});
					M.toast({html:"An error occured while fetching data",displayLength:3000});
				}
			}
		}).fail(()=>{
			renderProduct();
			console.log({module:"setProducts",message:"Cannot get new products"});
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

var editAccount = ()=>{
	var i = getCustomerId();
	var n = $("#nameField").val();
	var a = $("#addressField").val();

	if(!n){
		M.toast({html:"Name cannot be empty", displayLength: 3000});
	} else {
		$.ajax({
			type: 'POST',
			cache: 'false',
			url: 'api/Customer/updateBasic.php',
			data: {
				customer_id: i,
				customer_name: n,
				customer_address: a
			},
			success: result=>{
				M.toast({html:result.message, displayLength: 3000});
				getCustomerInfo();
				setCustomerInfo();
			}
		}).fail(()=>{
			M.toast({html:"Cannot connect to server", displayLength: 3000});
		});
	}
};

var setQueue = ()=>{
	var emptyQueue = `
		<div class="card hoverable col s12">
			<div class="card-content">
				<br>
				<center>
					<h5 class="grey-text">
					<style>
					.material-icons.md-48 { font-size: 48px; }
					</style>
					<i class="material-icons md-48">tag_faces</i><br><br>
					Nothing in Queue
					</h5>
				</center>
				<br>
			</div>
		</div>
	`;
	if(localStorage.getItem("all-wet-order-queue")){
		var queue = JSON.parse(localStorage.getItem("all-wet-order-queue"));

		if(queue.length < 1){
			$("#queueList").html(emptyQueue);
		} else {
			$("#queueList").html(" ");
			$.each(queue, (index,value)=>{
				var adr = value.transaction_address;
				var tc = value.transaction_count;
				var tpm = value.transaction_payment_method;
				var p = value.transaction_price;

				if(tc <= 1) {
					var qv = "item";
				} else {
					var qv = "items";
				}

				var tmpl = `
					<div class="card hoverable">
						<div class="card-content">
							<span class="card-title">${adr}</span>
							<br>
							<p style="line-height:1.5">
								<i class="material-icons grey-text text-darken-1">local_offer</i> ₱${p} for ${tc} ${qv}<br>
								<i class="material-icons grey-text text-darken-1">payment</i> ${tpm}<br>
							</p>
						</div>
					</div>
				`;
				$("#queueList").append(tmpl);
			});
		}
		
	} else {
		$("#queueList").html(emptyQueue);
	}
};

var processQueue = ()=>{
	if(localStorage.getItem("all-wet-order-queue")){
		try {
			var queue = JSON.parse(localStorage.getItem("all-wet-order-queue"));
			$.each(queue, (index,trans)=>{
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
						removeFromQueue(index);
						setQueue();
					}
				}).fail(()=>{
					console.log({module:"processQueue",message:"Queue Sending Error"});
					setQueue();
				});
			});
		} catch(e){
			console.log(e);
		}		
	}
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

var removeFromQueue = (index)=>{
	var queue = getQueue();
	try {
		queue.splice(index,1);
		localStorage.setItem("all-wet-order-queue",JSON.stringify(queue));
	} catch(e){
		console.log(e);
	}
}

var getCustomerInfo = ()=>{
	var cid = localStorage.getItem("all-wet-customer-id");
	$.ajax({
		type:'POST',
		cache:'false',
		url:'/api/Customer/get.php',
		data:{
			customer_id: cid
		},
		success: result => {
			localStorage.setItem("all-wet-customer-info",JSON.stringify(result));
			setCustomerInfo();
		}
	}).fail(()=>{
		console.log({module:"getCustomerInfo",message:"Failed to get customer information"});
		console.log("Failed to get customer information");
	});
}

var setCustomerInfo = ()=>{
	var customer = JSON.parse(localStorage.getItem("all-wet-customer-info"));
	var cn = customer.customer_name;
	var adr = customer.customer_address;
	
	if(cn){
		$("#nameField").val(cn);
	}
	$("#addressField").val(adr);
	M.updateTextFields();

	$("#customerNamePlaceholder").html(cn);
}