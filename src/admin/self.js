var editAccountShow = () => {
  clear();
  closeNav();
  $("#editAccountActivity").fadeIn();
};

var getUserInfo = ()=>{
  var i = localStorage.getItem("all-wet-admin-id");

  $.ajax({
    type:'GET',
    cache:'false',
    url:'/api/admin/get.php',
    data: {
      admin_id:i
    },
    success: result=>{
      var ai = result['admin_id'];
      var an = result['admin_name'];
      var au = result['admin_username'];
      
      localStorage.setItem("all-wet-admin-info", JSON.stringify(result));
      localStorage.setItem("all-wet-admin-id",ai);
      localStorage.setItem("all-wet-admin-name",an);
      localStorage.setItem("all-wet-admin-username",au);
    }
  })
};

var renderUserFields = ()=>{
  var n = localStorage.getItem("all-wet-admin-name");
  var u = localStorage.getItem("all-wet-admin-username");

  $("#admName").html(`<b>${n}</b>`);
  $("#admUsername").html(`@${u}`);

  $("#nameField").val(n);
  $("#usernameField").val(u);
};

var editAccount = ()=>{
  var i = localStorage.getItem("all-wet-admin-id");
  var n = $("#nameField").val();
  var u = $("#usernameField").val();
  var p = $("#passwordField").val();

  $.ajax({
    type:'POST',
    cache:'false',
    url:adminUpdate,
    data: {
      admin_id:i,
      admin_name:n,
      admin_username:u,
      admin_password:p
    },
    success: result=>{
      try {
        M.toast({html:result.message,durationLength:3000});
        if(result.code == 200){
          getUserInfo();
          renderUserFields();
        }
      } catch(e){
        console.log(e);
        M.toast({html:"An Error Occurred", durationLength:3000});
      }
    }
  });
};