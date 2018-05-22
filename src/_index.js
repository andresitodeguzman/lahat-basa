  $(document).ready(()=>{
    $('.dropdown-trigger').dropdown();
    $('.container').hide();
    
    setButton();
    
    $('.container').fadeIn(2000);
  });

  checkLoginStatus = ()=>{
      return localStorage.getItem('all-wet-login');
  };



  var setButton = ()=>{

    let status = checkLoginStatus();

    let loginButton = `
        <a class="btn btn-large blue darken-4 waves-effect waves-light" href="/authenticate"> Sign-In with Mobile Number
        </a>`;

    if(status == "true"){

      var at = localStorage.getItem("all-wet-account-type");

      if(navigator.onLine){
        $.ajax({
          type:'GET',
          url:'/authenticate/signInStatus.php',
          cache:'false',
          success: result=>{
            if(result.is_signed_in == false){
              localStorage.clear();
              window.location.replace("/authenticate/logout.php");
            }
          }
        }).fail(()=>{
          console.log("Error while checking login status");
        });
      }

      let appButton = `
        <a class="btn btn-large blue darken-4 waves-effect waves-light waves-green" href="/app/">
            Open App
        </a>`;

      if(at == 'employee'){
        let employeeButton = `
        <a class="btn btn-large blue darken-4 waves-effect waves-light waves-green" href="/employee/">
            Open Employee
        </a>`;
        $("#button").html(employeeButton);
      }
      if(at == 'admin'){
        let adminButton = `
        <a class="btn btn-large blue darken-4 waves-effect waves-light waves-green" href="/admin/">
            Open Admin
        </a>`;
        $("#button").html(adminButton);
      }
      if(at === 'customer'){
        $("#button").html(appButton);
      }

    } else {
        $("#button").html(loginButton);
    }
    

  };
