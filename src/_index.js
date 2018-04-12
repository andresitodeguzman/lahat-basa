  $(document).ready(()=>{
    $('.parallax').parallax();
    
    setButton();
    $(".btn").hide();
    $(".btn").fadeIn();
  });

  checkLoginStatus = ()=>{
      return localStorage.getItem('all-wet-login');
  };

  var setButton = ()=>{

    let status = checkLoginStatus();

    let loginButton = `
        <a class="btn btn-large blue darken-4 waves-effect waves-light" href="/authenticate"> Sign-In with Your Mobile Number <i class="material-icons right">
            smartphone</i>
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
