var adminShow = ()=>{
  clear();
  closeNav();
  $("#adminActivity").fadeIn();
};

var setAdmin = ()=>{
  $("#adminList").html(preloader);
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
        console.log(value);
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
              <a href="#" class="black-text"><i class="material-icons">edit</i></a>
              <a href="#" class="red-text"><i class="material-icons">delete</i></a>
            </div>
          </div>
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
    
    if(au){
      M.toast({html:"Username is Required", durationLength:3000});
      showInput();
    } else {
      if(ap){
        M.toast({html:"Password is Required", durationLength:3000});
        showInput();
      } else {
        if(an){
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