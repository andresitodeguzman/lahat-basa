var productsShow = () => {
  clear();
  closeNav();
  $("#productsActivity").fadeIn();
}

var productFilter = (catId) => {
  $(".product").hide();
  $(`.${catId}`).fadeIn();
};

var setProducts = ()=>{
	setCategory();
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
		cache:'false',
		url: productGetAllApi,
		success: result=>{
			localStorage.setItem("all-wet-product", JSON.stringify(result));
		    renderProduct();
		}
	}).fail(()=>{
		renderProduct();
	    M.toast({
	      html: "Cannot get new products",
	      displayLength: 3000
	    });
	});

};

var renderProduct = ()=>{
	try {
		var result = JSON.parse(localStorage.getItem("all-wet-product"));
		$("#productsList").html("");
		$.each(result, (index,value)=>{
			var dlpdapi = productDelete;

			var id = value.product_id;
			var n = value.product_name;
			var c = value.product_code;
			var d = value.product_description;
			var cat = value.category_id;
			var cn = value.category_name;
			var p = value.product_price;
			var a = value.product_available;
			var i = value.product_image;

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
				var ar = "Available";
			} else {
				var ar = "Out of Stock";
			}


			if (p) {
				var pr = `₱${p}`;
			} else {
				var pr = "Price Unavailable";
			}

			if(!cn){
				var cn = "Uncategorized";
			}

			var templ = `
				<div class="card hoverable product cat${cat}">
					${img}
					<div class="card-content">
						<span class="card-title">
							<b>${n}</b><br>
							${pr}
						</span><br>
						<p style="line-height:1.5">
							<i class="material-icons grey-text text-darken-1">info_outline</i> ${c}<br>
							<i class="material-icons grey-text text-darken-1">note</i> ${d}<br>
							<i class="material-icons grey-text text-darken-1">label</i> ${cn}<br>
							<i class="material-icons grey-text text-darken-1">local_offer</i> ${ar}
						</p>
					</div>
					<div class="card-action">
						<a href="#" class="black-text modal-trigger" data-target="editModalProduct${id}"><i class="material-icons">edit</i></a>
						<a href="#" id="deleteProductButton${id}" class="red-text"><i class="material-icons">delete</i></a>
					</div>
				</div>

				<div class="modal modal-fixed-footer" id="editModalProduct${id}">
					<div class="modal-content">

						<h5>Edit Product</h5><br>
						
						<!-- Preloader -->
						<div id="editProductPreloader${id}">
							<center>
								<div class="preloader-wrapper big active">
								<div class="spinner-layer spinner-blue-only">
									<div class="circle-clipper left">
									<div class="circle"></div>
									</div>
									<div class="gap-patch">
									<div class="circle"></div>
									</div>
									<div class="circle-clipper right">
									<div class="circle"></div>
									</div>
								</div>
								</div>
							</center>
						</div>
						<!-- .Preloader -->

						<div class="editProductActivity${id}">

							<div class="input-field">
								<input type="text" id="productName${id}" value="${n}">
								<label for="productName${id}" class="active">Name</label>
							</div>

							<div class="input-field">
								<input type="text" id="productImage${id}" value="${i}">
								<label for="productImage${id}" class="active">Image URL</label>
							</div>

							<div class="input-field">
								<input type="text" id="productDescription${id}" value="${d}">
								<label for="productDescription${id}" class="active">Description</label>
							</div>

							<div class="input-field">
								<input type="text" id="productCode${id}" value="${c}">
								<label for="productCode${id}" class="active">Code</label>
							</div>

							<div class="input-field">
								<input type="text" id="productPrice${id}" value="${p}">
								<label for="productPrice${id}" class="active">Price in Pesos</label>
							</div>

							<div class="input-field">
								<p><font size="-1" class="grey-text">Availability</font></p>
								<select id="productAvailable${id}" class="browser-default">
									<option value="True">Available</option>
									<option value="False">Out of Stock</option>
								</select>
							</div>

							<div class="input-field">
								<p><font size="-1" class="grey-text">Category</font></p>
								<select id="productCategory${id}" class="browser-default">
								</select>
							</div>

						</div>

					</div>

					<div class="modal-footer editProductActivity${id}">
						<a href="#" id="editProductSaveButton${id}" class="modal-action waves-effect btn-flat">Save</a>
						<a href="#" class="modal-action modal-close waves-effect waves-red btn-flat">Close</a>
					</div>

				</div>

				<script type="text/javascript">
					$(document).ready(()=>{
						$("#modal").modal();
						$('select').formSelect();
						$("#productAvailable${id}").val("${a}");
						setProductCategory${id}();
						$("#editProductPreloader${id}").hide();
						$("#productCategory${id}").val("${cat}");
					});

					var setProductCategory${id} = ()=>{
						var cat = JSON.parse(localStorage.getItem("all-wet-categories"));
						$.each(cat,(index,value)=>{
							var n = value.category_name;
							var i = value.category_id;

							var tmpl = "<option value='"+i+"'>"+n+"</option>";

							$("#productCategory${id}").append(tmpl);
						});
					};

					$("#deleteProductButton${id}").click(()=>{
						$.ajax({
							type:'POST',
							cache: 'false',
							url: '${dlpdapi}',
							success: result => {
								setCategory();
							}
						}).fail(()=>{
							M.toast({html:"An Error Occured", durationLength:3000});
						});
					});

					$("#editProductSaveButton${id}").click(()=>{
						var pn = $("#productName${id}").val();
						var pc = $("#productCode${id}").val();
						var pd = $("#productDescription${id}").val();
						var pi = $("#productImage${id}").val();
						var pp = $("#productPrice${id}").val();
						var pa = $("#productAvailable${id}").val();
						var pci = $("#productCategory${id}").val();

						if(!pc){
							M.toast({html:"Product Code cannot be empty", durationLength:3000});
							$("#editProductPreloader${id}").hide();
							$(".editProductActivity${id}").show();
						} else {
							if(!pn){
								M.toast({html:"Product Name cannot be empty", durationLength:3000});
								$("#editProductPreloader${id}").hide();
								$(".editProductActivity${id}").show();
							} else {
								if(!pp){
									M.toast({html:"Product Price cannot be empty", durationLength:3000});
									$("#editProductPreloader${id}").hide();
									$(".editProductActivity${id}").show();
								} else {
									$.ajax({
										type:'POST',
										cache:'false',
										url:'/api/Product/update.php',
										data:{
											product_id: '${id}',
											product_code: pc,
											product_name: pn,
											product_description: pd,
											product_price: pp,
											product_image: pi,
											product_available: pa,
											category_id: pci
										},
										success: result=>{
											try {
												if(result.code == 400){
													M.toast({html: "Error: ${result.message}", durationLength:3000});
												} else {
													M.toast({html: result.message, durationLength:3000});
												}
											} catch(e){
												console.log(e);
												M.toast({html: "A Fatal Error Occured while Saving", durationLength:3000});
											}
										}
									}).fail(()=>{
										M.toast({html:"Cannot edit product", durationLength:3000});
										$("#editProductPreloader${id}").hide();
										$(".editProductActivity${id}").show();										
									});
								}
							}
						}
					});
				</script>
			`;

			$("#productsList").append(templ);
		});
	} catch(e){
		console.log(e);
	    $("#productsList").html(errorCard);
	}
};

var addProduct = ()=>{
	$("#preloaderAddProduct").show();
	$(".addProductActivity").hide();
	
	var pn = $("#productName").val();
	var pi = $("#productImage").val();
	var pd = $("#productDescription").val();
	var pc = $("#productCode").val();
	var pp = $("#productPrice").val();
	var pa = $("#productAvailable").val();
  
	var showAddProductInput = ()=>{
	  $("#preloaderAddProduct").hide();
	  $(".addProductActivity").show();
	};
	
	if(!pc){
	  M.toast({html:"Product Code is Required", durationLength:3000});
	  showAddProductInput();
	} else {
	  if(!pn){
		M.toast({html:"Product Name is Required", durationLength:3000});
		showAddProductInput();
	  } else {
		if(!pp){
		  M.toast({html:"Product Price is Required", durationLength:3000});
		  showAddProductInput();
		} else {
		  $.ajax({
			type:'GET',
			cache:'false',
			url: productAdd,
			data: {
			  product_name: pn,
			  product_image: pi,
			  product_description: pd,
			  category_id:'',
			  product_code: pc,
			  product_price: pp,
			  product_available: pa
			},
			success: result=>{
			  try{
				if(result.code){
				  M.toast({html:result.message,durationLength:3000});
				  showAddProductInput();
				} else {
				  M.toast({html:"An Error Occured", durationLength:3000});
				  $("#productName").val('');
				  $("#categoryId").val('');
				  $("#productImage").val('');
				  $("#productDescription").val('');
				  $("#productCode").val('');
				  $("#productPrice").val('');
				  $("#productAvailable").val('');
				  setProducts();
				  showAddProductInput();
				}
			  } catch(e){
				M.toast({html:"An Error Occurred", durationLength:3000});
				showAddProductInput();
			  }
			}
		  }).fail(()=>{
			M.toast({html:"Cannot connect to server", durationLength:3000});
			showAddProductInput();
		  });
		}
	  }
	}
  };