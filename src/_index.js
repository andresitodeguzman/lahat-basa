  $(document).ready(()=>{
    $('.parallax').parallax();
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
        <a class="btn btn-large blue darken-4 waves-effect waves-light" href="/app">
            Open App
        </a>`;

    if(status == "true"){
        $("#button").html(appButton);
    } else {
        $("#button").html(loginButton);
    }
    

  };
