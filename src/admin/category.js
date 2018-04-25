// Activity Loader
var categoryShow = () => {
  clear();
  closeNav();
  $("#categoryActivity").fadeIn();
};

var setCategory = () => {
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
				
				<div class="modal modal-fixed-footer" id="editModalCategory${cid}">
					<div class="modal-content">
						<h5>Edit Category</h5><br>
            <div id="editCategoryPreloader${cid}">
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
            <div class="editCategoryActivity${cid}">
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
					</div>
					<div class="modal-footer editCategoryActivity${cid}">
						<a href="#" id="editCategorySaveButton${cid}" class="modal-action waves-effect btn-flat">Save</a>
						<a href="#" class="modal-action modal-close waves-effect waves-red btn-flat">Close</a>
					</div>
				</div>

				<script type="text/javascript">
					$(document).ready(()=>{
						$(".modal").modal();

            $("#editCategoryPreloader${cid}").hide();
					});

					$("#deleteCategoryButton${cid}").click(()=>{
						
						$.ajax({
							type:'POST',
							cache: 'false',
							url: '${dlapi}',
              data:{
                category_id:${cid}
              },
							success: result => {
								setCategory();
							}
						}).fail(()=>{
							M.toast({html:"An Error Occured", durationLength:3000});
						});
					});

					$("#editCategorySaveButton${cid}").click(()=>{
            $("#editCategoryPreloader${cid}").show();
            $(".editCategoryActivity${cid}").hide();

						var cn${cid} = $("#categoryName${cid}").val();
						var cc${cid} = $("#categoryCode${cid}").val();
						var cd${cid} = $("#category_description${cid}").val();
						
            var reshowCategoryEditInput${cid} = ()=>{
              $("#editCategoryPreloader${cid}").hide();
              $(".editCategoryActivity${cid}").show();
            };

						if(!cc${cid}){
							M.toast({html: 'Category code is required', durationLength:3000});
              reshowCategoryEditInput${cid}();
						} else {
							if(!cn${cid}){
								M.toast({html: 'Category name is required', durationLength:3000});
                reshowCategoryEditInput${cid}();
							} else {
								$.ajax({
									type:'POST',
									cache:'false',
									url: "${catup}",
									data: {
										category_id: ${cid},
										category_name: cn${cid},
										category_code: cc${cid},
										category_description: cd${cid}
									},
									success: result=>{
                    try{
                      if(result.message){
                        var rm = result.message;
                        M.toast({html:rm, durationLength:3000});
                        setCategory();
                      } else {
                        M.toast({html: "Unknown error occured", durationLength:3000});
                      }
                    } catch(e){
                      M.toast({html:"A Fatal Error Occured", durationLength:3000});
                    }	
                    reshowCategoryEditInput${cid}();
									}
								}).fail(()=>{
                   M.toast({html:"Cannot connect to server", durationLength:3000});
                   reshowCategoryEditInput${cid}();
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
      html: `Fatal error: ${e}`,
      durationLength: 3000
    });
  }
}

var addCategory = () => {

  $(".addCategoryActivity").hide();
  $("#preloaderAddCategory").show();

  var catn = $("#categoryName").val();
  var catc = $("#categoryCode").val();
  var catd = $("#categoryDescription").val();


  if (!catc) {
    M.toast({
      html: "Category Code is Required",
      durationLength: 3000
    });
    $(".addContainerActivity").show();
    $("#preloaderAddCategory").hide();
  } else {
    if (!catn) {
      M.toast({
        html: "Category Name is Required",
        durationLength: 3000
      });
      $(".aaddCategoryActivity").show();
      $("#preloaderAddCategory").hide();

    } else {
      $.ajax({
        type: 'POST',
        cache: 'false',
        url: categoryAdd,
        data: {
          category_name: catn,
          category_code: catc,
          category_description: catd
        },
        success: result => {
          try {
            
            if(result.code){
              M.toast({html:result.message, durationLength:3000});
              $("#categoryName").val("");
              $("#categoryCode").val("");
              $("#categoryDescription").val("");
              setCategory();
            } else {
              M.toast({html:"An Error Occurred", durationLength:3000});
            }
            
            $(".addCategoryActivity").show();
            $("#preloaderAddCategory").hide();

          } catch (e) {
            M.toast({
              html: `A Fatal Error Occurred: ${e}`,
              durationLength: 3000
            });
          }
          $(".addCategoryActivity").show();
          $("#preloaderAddCategory").hide();
        }

      }).fail(() => {
        M.toast({
          html: "Cannot add category",
          durationLength: 3000
        });
        $(".addContainerActivity").show();
        $("#preloaderAddCategory").hide();
      });
    }
  }
};
