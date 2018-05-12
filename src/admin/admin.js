var adminShow = ()=>{
  clear();
  closeNav();
  $("#adminActivity").fadeIn();
};

var setAdmin = ()=>{
  $("#adminList").html(preloader);

  if(Navigator.onLine){
    $.ajax({
       type:'GET',
       cache:'false',
       url: adminGetAll,
       success: result=>{
         try {
           localStorage.setItem("all-wet-admin",JSON.stringify(result));
           renderAdmin();
         } catch(e){
           console.log(e);
           renderAdmin();
           M.toast({html:"An Error Occurred",durationLength:3000});
         }
       }
    }).fail(()=>{
      renderAdmin();
    });
  } else {
    renderAdmin();
  }
  
};

var renderAdmin = ()=>{
  try{
    var result = JSON.parse(localStorage.getItem("all-wet-admin"));
    if(result.length < 0){
      var tmpl = `
        <div class="card">
          <div class="card-content"><br>
            <center class="grey-text">No Admin Yet</center><br>
          </div>
        </div>
      `;
      $("#adminList").html(tmpl);
    } else {
      $("#adminList").html(" ");
      $.each(result, (index,value)=>{
        var aid = value.admin_id;
        var an = value.admin_name;
        var au = value.admin_username;
        var ai = value.admin_image;
        var img = " ";
        
        if(ai){
          var img = `
            <div class="card-img">
              <img src="${ai}" width="100%">
            </div>
          `;
        }
        
        var templ = `
          <div class="card">
            ${img}
            <div class="card-content">
              <span class="card-title">${an}</span>
              <p><font size="3pt" class="grey-text">@${au}</font></p>
            </div>
            <div class="card-action">
              <a href="#" data-target="editAdminModal${aid}" class="black-text modal-trigger"><i class="material-icons">edit</i></a>
              <a href="#" class="red-text" onclick="deleteAdmin('${aid}')"><i class="material-icons">delete</i></a>
            </div>
          </div>

          <div class="modal modal-fixed-footer" id="editAdminModal${aid}">
            <div class="modal-content">
              
              <h5>Edit Admin</h5><br>

              <div id="preloaderEditAdmin${aid}">
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

              <div class="editAdminActivity${aid}">
                <div class="input-field">
                  <input type="text" id="adminName${aid}" value="${an}">
                  <label for="adminName${aid}" class="active">
                    Name
                  </label>
                </div>
                <div class="input-field">
                  <input type="text" id="adminUsername${aid}" value="${au}">
                  <label for="adminUserame${aid}" class="active">
                    Username
                  </label>
                </div>
                <div class="input-field">
                  <input type="password" id="adminPassword${aid}">
                  <label for="adminPassword${aid}">
                    Password
                  </label>
                </div>
                <div class="input-field">
                  <input type="text" id="adminImage${aid}" value="${ai}">
                  <label for="adminImage${aid}" class="active">
                    Image
                  </label>
                </div>
              </div>

            </div>
            <div class="modal-footer" class="editAdminActivity${aid}">
              <a href="#" onclick="saveEditAdmin${aid}()" class="modal-action waves-effect btn-flat">Save</a>
              <a href="#" class="modal-action modal-close waves-effect waves-red btn-flat">Close</a>
            </div>
          </div>

          <script>
            $(document).ready(()=>{
              $(".modal").modal();
              $("#preloaderEditAdmin${aid}").hide();
            });

            var saveEditAdmin${aid} = ()=>{
              $("#preloaderEditAdmin${aid}").show();
              $(".editAdminActivity${aid}").hide();

              var showInput = ()=>{
                $("#preloaderEditAdmin${aid}").hide();
                $(".editAdminActivity${aid}").show();
              }

              var an${aid} = $("#adminName${aid}").val();
              var au${aid} = $("#adminUsername${aid}").val();
              var ap${aid} = $("#adminPassword${aid}").val();
              var ai${aid} = $("#adminImage${aid}").val();

              if(!an${aid}){
                M.toast({html:"Name is Required", durationLength:3000});
                showInput();
              } else {
                if(!au${aid}){
                  M.toast({html:"Username is Required", durationLength:3000});
                  showInput();
                } else {
                  $.ajax({
                    type:'POST',
                    cache:'false',
                    url:'/api/Admin/update.php',
                    data: {
                      admin_id: '${aid}',
                      admin_name: an${aid},
                      admin_username: au${aid},
                      admin_password: ap${aid},
                      admin_image: ai${aid}
                    },
                    success: result=>{
                      if(result.code == 200){
                        setAdmin();
                      }
                      M.toast({html:result.message, durationLength:3000});
                      showInput();
                    }
                  }).fail(()=>{
                    M.toast({html:"An Error Occurred", durationLength:3000});
                    showInput();
                  });
                }
              }

            };
          </script>
        `;
        $("#adminList").append(templ);
        
      });
    }
  } catch(e){
    console.log(e);
    $("#adminList").html(errorCard);
  }
}

var addAdmin = ()=>{
  
  $("#preloaderAddAdmin").show();
  $(".addAdminActivity").hide();

  var showInput = ()=>{
    $("#preloaderAddAdmin").hide();
    $(".addAdminActivity").show();
  };
  
  try{
    var an = $("#adminName").val();
    var au = $("#adminUsername").val();
    var ap = $("#adminPassword").val();
    var ai = $("#adminImage").val();
    
    if(!au){
      M.toast({html:"Username is Required", durationLength:3000});
      showInput();
    } else {
      if(!ap){
        M.toast({html:"Password is Required", durationLength:3000});
        showInput();
      } else {
        if(!an){
          M.toast({html:"Name is Required", durationLength:3000});
          showInput();
        } else {
          $.ajax({
            type:'POST',
            cache:'false',
            url:adminAdd,
            data: {
              admin_name: an,
              admin_username: au,
              admin_password: ap,
              admin_image: ai
            },
            success: result=>{
              if(result.code == 200){
                $("#adminName").val('');
                $("#adminUsername").val('');
                $("#adminPassword").val('');
                $("#adminImage").val('');
              }
              showInput();
              M.toast({html:result.message, durationLength:3000});
            }
          }).fail(()=>{
            M.toast({html:"An Error Occurred", durationLength:3000});
            showInput();
          });
        }
      }
    }
  } catch(e){
    console.log(e);
    M.toast({html:"An Error Occurred", durationLength:3000});
    showInput();
  }
  
};

var deleteAdmin = id=>{
  $.ajax({
    type:'POST',
    cache:'false',
    url:adminDelete,
    data: {
      admin_id: id
    },
    success: result=>{
      if(result.message){
        M.toast({html:result.message,durationLength:3000});
      }
      setAdmin();
    }
  }).fail(()=>{
    M.toast({html:"An Error Occurred", durationLength:3000});
  });
};