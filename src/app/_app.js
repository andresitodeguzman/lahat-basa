$(document).ready(()=>{
	loginCheck();
	
	clear();

	$(".sidenav").sidenav();
	$('.modal').modal();

	$("#btnAdd").hide();

	init();

	setMyOrders();
	setProducts();

	splash(1000);
	$("#myorderActivity").fadeIn();
	$("#btnAdd").slideDown();

	
});

// API URLS
let transactionGetApi = '/sample_data/transaction.getall.php'; 
let productGetAllApi = '/sample_data/product.getall.php';
let transitemGetByProductIdApi = '/sample_data/transitem.getByProductId.php';
let categoryGetAll = '/sample_data/category.getall.php';

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
		window.location.replace("/authenticate");
	}
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

	//var cid = getCustomerId();
	var cid = 1;
	$.ajax({
		type:'GET',
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
				M.toast({html:"An error fetching data",displayLength:3000});
			}
		}
	}).fail(()=>{
		renderMyOrder();
		M.toast({html:"Cannot get new orders",displayLength:3000});
	});
};

var renderMyOrder = ()=>{
	try {
		var result = JSON.parse(localStorage.getItem("all-wet-myorders"));
		
		$("#orderList").html(" ");

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
						<ul class="collection" id="${tid}items">
							<li class="collection-item">
								<center>
									${preloader} 
								</center>
							</li>
						</ul>
					</div>
				</div>
			`;

			$("#orderList").append(tmpl);

			$.ajax({
				type:'GET',
				cache: 'false',
				url: transitemGetByProductIdApi,
				data: {
					transaction_id: tid
				},
				success: result => {

					try{
						if(result.code == 400){
							$(`#${tid}items`).html(`<li class="collection-item"><center>Error Processing Items</center></li>`);
						} else {
							$(`#${tid}items`).html(" ");
							$.each(result, (index,item)=>{
								var pid = item['product_id'];
								var pn = item['product_name'];
								var tq = item['transitem_quantity'];

								if(tq <= 1) {
									var qv = "piece";
								} else {
									var qv = "pieces";
								}

								var templ = `
									<li class="collection-item">
										<b>${pn}</b> (${tq} ${qv})
									</li>
								`;
								$(`#${tid}items`).append(templ);
							});
						}
					}
					catch(e){
						$(`#${tid}items`).html(`<li class="collection-item"><center>Error Processing Items</center></li>`);
					}
				}
			}).fail(()=>{
				$(`#${tid}items`).html(`<li class="collection-item"><center>Error Fetching Items</center></li>`);
			});

		});

	} catch(e){
		console.log(`My Orders Error: ${e}`);
		$("#orderList").html(errorCard);
	}
};


var setCategories = ()=>{
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
		M.toast({html:'Cannot get categories', displayLength:2000});
	});
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
				M.toast({html:"An error occured while fetching data",displayLength:3000});
			}
		}
	}).fail(()=>{
		renderProduct();
		M.toast({html:"Cannot get new products",displayLength:3000});
	});

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
			url: 'api/Customer/update.php',
			data: {
				customer_id: i,
				customer_name: n,
				customer_address: a
			},
			success: result=>{
				M.toast({html:result, displayLength: 3000});
			}
		}).fail(()=>{
			M.toast({html:"Cannot connect to server", displayLength: 3000});
		});
	}
};