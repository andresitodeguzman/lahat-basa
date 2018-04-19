$(document).ready(() => {
	$("meta[name='theme-color']").attr("content", "#455a64");
	clear();

	$(".sidenav").sidenav();
	$('.modal').modal();

	loginCheck();

	setForDelivery();
	setProducts();

	splash(1000);
	forDeliveryShow();
});

// API URLS
let transactionGetApi = '/sample_data/transaction.getall.php';
let productGetAllApi = '/sample_data/product.getall.php';
let transitemGetByProductIdApi = '/sample_data/transitem.getByProductId.php';
let categoryGetAll = '/sample_data/category.getall.php';
let categoryUpdate = '/';
let categoryDelete = '/';

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
var clear = () => {
	$(".activity").hide();
}
var closeNav = () => {
	$(".sidenav").sidenav('close');
}
var productFilter = (catId) => {
	$(".product").hide();
	$(`.${catId}`).fadeIn();
};

// Activity Loader
var forDeliveryShow = () => {
	clear();
	closeNav();
	$("#forDeliveryActivity").fadeIn();
}

var categoryShow = () => {
	clear();
	closeNav();
	$("#categoryActivity").fadeIn();
};

var productsShow = () => {
	clear();
	closeNav();
	$("#productsActivity").fadeIn();
}

var editAccountShow = () => {
	clear();
	closeNav();
	$("#editAccountActivity").fadeIn();
};


// App Functions
var loginCheck = () => {
	return true;
};

var setForDelivery = () => {

	$("#forDeliveryList").html(preloader);

	$.ajax({
		type: 'GET',
		cache: 'false',
		url: transactionGetApi,
		data: {
			a: 1
		},
		success: result => {
			try {
				localStorage.setItem("all-wet-for-delivery", JSON.stringify(result));
				renderForDelivery();
			} catch (e) {
				$("#forDeliveryList").html(errorCard);
				M.toast({
					html: "Error processing request",
					displayLength: 3000
				});
			}
		}
	}).fail(() => {
		renderForDelivery();
		M.toast({
			html: "Cannot get new 'for delivery' list",
			displayLength: 3000
		});
	});
}

var renderForDelivery = () => {
	var empty = `
	<div class='card'>
		<div class='card-content'>
			<center>Nothing to Deliver Yet</center>
		</div>
	</div>
    `;

	try {
		var result = JSON.parse(localStorage.getItem("all-wet-for-delivery"));

		if (result.code == 400) {
			$("#forDeliveryList").html(empty);
		} else {
			$("#forDeliveryList").html(" ");

			$.each(result, (index, order) => {
				var mpimg = " ";

				var tid = order['transaction_id'];
				var td = order['transaction_date'];
				var tt = order['transaction_time'];
				var cid = order['customer_id'];
				var tc = order['transaction_count'];
				var tp = order['transaction_price'];
				var tpm = order['transaction_payment_method'];
				var ts = order['transaction_status'];
				var tlo = order['transaction_longitude'];
				var tlt = order['transaction_latitude'];
				var ta = order['transaction_address'];

				if (tc <= 1) {
					var qv = "item";
				} else {
					var qv = "items";
				}

				if (tlo) {
					var mpimg = `
                        <div class="card-img">
                            <img src="https://maps.googleapis.com/maps/api/staticmap?center=${tlt},${tlo}&zoom=17&size=800x300&markers=color:blue%7C${tlt},${tlo}&key=AIzaSyCuNfQSkwl85bk38k4de_QR-DwBGL-069o" width="100%">
                        </div>
                    `;
				}

				var templ = `
                    <div class="card hoverable">
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
                            <a href="#" onclick="setAsDelivered(${tid})" class="grey-text"><i class="material-icons">done</i></a>
                            <a href="https://www.google.com/maps/dir/?api=1&destination=${tlt},${tlo}" class="grey-text"><i class="material-icons">map</i></a>
                            <a href="#" class="grey-text"><i class="material-icons">call</i></a>
                        </div>
                    </div>
                `;

				$("#forDeliveryList").append(templ);

			});

		}
	} catch (e) {
		alert(e);
		$("#forDeliveryList").html(errorCard);
	}
};

var setCategories = () => {
	$("#categoryList").html(preloader);
	$.ajax({
		type: 'GET',
		cache: 'false',
		url: categoryGetAll,
		data: {
			a: 1
		},
		success: result => {
			try {
				localStorage.setItem("all-wet-categories", JSON.stringify(result));
				renderCategories();
			} catch (e) {
				console.log(`Categories Error: ${e}`);
				$("#categoryList").html(errorCard);
				M.toast({
					html: "An error occured while fetching data",
					displayLength: 3000
				});
			}
		}
	}).fail(() => {
		renderCategories();
		M.toast({
			html: 'Cannot get categories',
			displayLength: 2000
		});
	});
};

var renderCategories = () => {
	try {
		var addAllCategories = `<li class="tab"><a href="#" onclick="productFilter('product')">All</a></li>`;
		var result = JSON.parse(localStorage.getItem("all-wet-categories"));

		$("#categoryTabs").html(addAllCategories);

		$("#categoryList").html(" ");

		$.each(result, (index, value) => {
			var catup = categoryUpdate;
			var dlapi = categoryDelete;
			
			var cid = value['category_id'];
			var cn = value['category_name'];
			var cd = value['category_description'];
			var cc = value['category_code'];

			var tmpl = `
				<li class="tab">
					<a href="#" onclick="productFilter('cat${cid}')">${cn}</a>
				</li>`;

			var tmplCat = `
				<div class="card hoverable" id="categoryCard${cid}">
					<div class="card-content">
						<span class="card-title">${cn}</span><br>
						<p>
							<i class="material-icons">info_outline</i> ${cc}<br>
							<i class="material-icons">note</i> ${cd}
						</p>
					</div>
					<div class="card-action">
						<a href="#" class="black-text modal-trigger" data-target="editModalCategory${cid}"><i class="material-icons">edit</i></a>
						<a href="#" id="deleteCategoryButton${cid}" class="red-text"><i class="material-icons">delete</i></a>
					</div>
				</div>
				
				<div class="modal" id="editModalCategory${cid}">
					<div class="modal-content">
						<h5>Edit Category</h5><br>
						<div class="input-field">
							<input type="text" id="categoryName${cid}" value="${cn}">
							<label for="categoryName${cid}" class="active">Name</label>
						</div>
						<div class="input-field">
							<input type="text" id="categoryCode${cid}" value="${cc}">
							<label for="categoryCode${cid}" class="active">Code</label>
						</div>
						<div class="input-field">
							<input type="text" id="categoryDescription${cid}" value="${cd}">
							<label for="categoryDescription${cid}" class="active">Description</label>
						</div>
					</div>
					<div class="modal-footer">
						<a href="#" id="editCategorySaveButton${cid}" class="modal-action waves-effect btn-flat">Save</a>
						<a href="#" class="modal-action modal-close waves-effect waves-red btn-flat">Close</a>
					</div>
				</div>

				<script type="text/javascript">
					$(document).ready(()=>{
						$(".modal").modal();
					});

					$("#deleteCategoryButton${cid}").click(()=>{
						
						$.ajax({
							type:'POST',
							cache: 'false',
							url: '${dlapi}',
							success: result => {
								setCategories();
							}
						}).fail(()=>{
							M.toast({html:"An Error Occured", durationLength:3000});
						});
					});

					$("#editCategorySaveButton${cid}").click(()=>{
						var cn${cid} = $("#categoryName${cid}").val();
						var cc${cid} = $("#categoryCode${cid}").val();
						var cd${cid} = $("#category_description${cid}").val();
						
						if(!cc${cid}){
							M.toast({html: 'Category code is required', durationLength:3000});
						} else {
							if(!cn${cid}){
								M.toast({html: 'Category name is required', durationLength:3000});
							} else {
								$.ajax({
									type:'POST',
									cache:'false',
									url: "${catup}",
									success: result=>{
										if(result.message){
											var rm = result.message;
											M.toast({html:rm, durationLength:3000});
										} else {
											M.toast({html: "Unknown error occured", durationLength:3000});
										}
									}
								});
							}
						}
					});
				</script>
				`;

			$("#categoryTabs").append(tmpl);
			$("#categoryList").append(tmplCat);
		});
	} catch (e) {
		M.toast({
			html: `Fatal error: ${e}`
		});
	}
}



var setProducts = () => {
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
		type: 'GET',
		cache: 'false',
		url: productGetAllApi,
		data: {
			a: 1
		},
		success: result => {
			try {
				localStorage.setItem("all-wet-product", JSON.stringify(result));
				renderProduct();
			} catch (e) {
				console.log(`Products Error: ${e}`);
				$("#productsList").html(errorCard);
				M.toast({
					html: "An error fetching data",
					displayLength: 3000
				});
			}
		}
	}).fail(() => {
		renderProduct();
		M.toast({
			html: "Cannot get new products",
			displayLength: 3000
		});
	});

}

var renderProduct = () => {
	try {
		var result = JSON.parse(localStorage.getItem("all-wet-product"));

		$("#productsList").html(" ");
		$.each(result, (index, value) => {
			var n = value['product_name'];
			var c = value['product_code'];
			var d = value['product_description'];
			var cat = value['category_id'];
			var cn = value['category_name'];
			var p = value['product_price'];
			var a = value['product_available'];
			var i = value['product_image'];

			if (i) {
				var img = `
				<div class="card-img">
					<img src="${i}" width="100%">
				</div>
				`;
			} else {
				var img = ``;
			}

			if (a == 'True') {
				var a = "Available";
			} else {
				var a = "Out of Stock";
			}


			if (p) {
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


	} catch (e) {
		$("#productsList").html(errorCard);
	}
}