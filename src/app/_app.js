$(document).ready(()=>{
	clear();

	$(".sidenav").sidenav();
	$("#btnAdd").hide();

	loginCheck();
	init();
	setMyOrders();
	setProducts();

	$("#myorderActivity").fadeIn();
	$("#btnAdd").slideDown();
});

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


// Activity Loader
var orderShow = ()=>{
	$("#btnAdd").hide();
	clear();
	closeNav();
	$("#myorderActivity").fadeIn();
	$("#btnAdd").slideDown();
}

var productsShow = ()=>{
	clear();
	closeNav();
	$("#productsActivity").fadeIn();
}


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

	var cid = getCustomerId();
	$.ajax({
		type:'GET',
		url:'/api/transaction/get.php',
		cache: 'false',
		data: {
			customer_id: cid
		},
		success: result=>{
			try{
				if(result.code == "400"){
					$("#orderList").html(empty);
				} else {
					$.each(result, (index,order)=>{
						//
					});
				}				
			}
			catch(e) {
				$("#orderList").html(errorCard);
			}
		}
	}).fail(()=>{
		$("#orderList").html(errorCard);
	});
};

var setProducts = ()=>{
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
		url: '/api/Product/getAll.php',
		data: {
			a: 1
		},
		success: result=>{
			try{
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
						var a = "Yes";
					} else {
						var a = "Out of Stock";
					}


					if(p){
						var p = `PHP ${p}`;
					} else {
						var p = "Price Unavailable";
					}

					var templ = `
						<div class="card hoverable">
							${img}
							<div class="card-content">
								<p>
									<b class='blue-text text-darken-1'>${n}</b> (${c})<br><br>
									${d}<br>
									<br>
									<font size="-1">${cn}</font>
									<br>
									${p}
								</p>
							</div>
						</div>
					`;

					$("#productsList").append(templ);					
				});
			}
			catch(e){
				$("#productsList").html(e);
			}
		}
	}).fail(()=>{
		$("#productsList").html(errorCard);
	});

}