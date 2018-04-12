$(document).ready(()=>{
	clear();

	$(".sidenav").sidenav();
	$("#btnAdd").hide();

	loginCheck();
	setMyOrders();
	setProducts();

	$("#mydeliveryActivity").fadeIn();
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
var deliveryShow = ()=>{
	$("#btnAdd").hide();
	clear();
	closeNav();
	$("#mydeliveryActivity").fadeIn();
	$("#btnAdd").slideDown();
}

var productsShow = ()=>{
	clear();
	closeNav();
	$("#transactionActivity").fadeIn();
}


// App Functions
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

	$("#transactionlist").html(preloader);

	$.ajax({
		type:'GET',
		cache: 'false',
		url: '/api/Transaction/getAll.php',
		data: {
			a: 1
		},
		success: result=>{
			try{
				$("#transactionlist").html(" ");
				
				$.each(result, (index,value)=>{
					var i = value['transaction_id'];
                    var d = value['transaction_date'];
                    var t = value['transaction_time'];
                    var cid = value['customer_id'];
                    var cn = value['customer_name'];
                    var cno = value['customer_number'];
                    var itm = value['transaction_items'];
                    var c = value['transaction_count'];
                    var p = value['transaction_price'];
                    var pm = value['transaction_payment_method'];
                    var s = value['transaction_status'];
                    var lo = value['transaction_longitude'];
                    var lt = value['transaction_latitude'];
					var a = value['transaction_address'];
					var z = "kevin";
console.log(value);
					if(i){
						var img = `
						<div class="card-img">
							<img src="${i}" width="100%">
						</div>
						`;
					} else {
						var img = ``;
					}

			


					if(p){
						var p = `PHP ${p}`;
					} else {
						var p = "Price Unavailable";
					}

					var templ = `
						<div class="card hoverable">
                            <div class="card-img">
                                <img width="100%" src="https://maps.googleapis.com/maps/api/staticmap?center=${lt},${lo}&zoom=17&size=800x300&markers=color:blue%7C${lt},${lo}&key=AIzaSyCuNfQSkwl85bk38k4de_QR-DwBGL-069o">
                            </div>
                            <div class="card-content">
                                <h5 class="blue-grey-text text-darken-3">
                                    <b>${cn}</b>
                                </h5>
                                <p>
                                    Address ${a}<br>
                                    Date: ${d} ${t}
                                    Quantity: ${c}<br>
                                    Items: ${itm}<br>
                                    <br>
                                    <b>${p}</b>
                                    <font size="-1">${pm}</font>
                                </p>
                            </div>
                            <div class="card-action">
                                <a class="black-text" href="#" id="${i}DeliverButton">Delivered</a>
                                <a class="black-text" href="tel:${cn}">Contact</a>
                            </div>
                        </div>
                    `;

					$("#transactionlist").append(templ);					
				});
			}
			catch(e){
				$("#transactionlist").html(e);
			}
		}
	}).fail(()=>{
		$("#transactionlist").html(errorCard);
	});

}