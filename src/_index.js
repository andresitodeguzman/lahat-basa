  $(document).ready(()=>{
    $('.parallax').parallax();
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
    
    let appButton = `
        <a class="btn btn-large blue darken-4 waves-effect waves-light waves-green" href="/app">
            Open App
        </a>`;

    if(status == "true"){
        var at = localStorage.getItem("all-wet-account-type");
        if(at == 'customer'){
          window.location.replace('/app');
        }
        if(at == 'employee'){
          window.location.replace('/employee');
        }
        if(at == 'admin'){
          window.location.replace('/admin');
        }
    } else {
        $("#button").html(loginButton);
    }
    

  };
