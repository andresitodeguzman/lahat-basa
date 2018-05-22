$(document).ready(()=>{
	$("meta[name='theme-color']").attr("content","#455a64");
	$("#loader").hide();
	
	loginCheck();
	setInterval(recheckLoginStatus(),300000);

}).keypress(e=>{
  var key = e.which;
  if(key == 13){
    signIn();
  }
});

var signInApi = '/authenticate/process/admin.php';

var checkLoginStatus = ()=>{
	return localStorage.getItem('all-wet-login');
};

var loginCheck = ()=>{
	let status = checkLoginStatus();
	if(status == 'true'){
		window.location.replace('/');
	}
};

var recheckLoginStatus = ()=>{
	$.ajax({
		type:'POST',
		url:'/authenticate/signInStatus.php',
		cache:'false',
		success: result=>{
			try {
				if(result.is_signed_in == 'True'){
					window.location.replace('/');
				}
			} catch(e){
				console.log(e);
			}
		}
	}).fail(()=>{
		console.log({module:"recheckLoginStatus",message:"Cannot check sign-in status"});
	});
};

var signIn = ()=>{
	$("#loader").show();
	$("#entry").hide();
	$(".card-action").hide();
	
	var u = $("#username").val();
	var p = $("#password").val();

	if(!u){
		M.toast({html:"Username is required", durationLength:3000});
		$("#loader").hide();
		$("#entry").show();
		$(".card-action").show();
		
	} else {
		if(!p) {
			M.toast({html:"Password is required", durationLength:3000});
			$("#loader").hide();
			$("#entry").show();
			$(".card-action").show();
		} else {
			$.ajax({
				type:'POST',
				cache: 'false',
				url: signInApi,
				data: {
					username: u,
					password: p
				}, 
				success: result=>{
					try {
						if(result['admin_id']){
							 var ai = result['admin_id'];
							 var an = result['admin_name'];
							 var au = result['admin_username'];
							 
							 localStorage.setItem("all-wet-account-type","admin");
							 localStorage.setItem("all-wet-login",true);
							 localStorage.setItem("all-wet-admin-id",ai);
							 localStorage.setItem("all-wet-admin-name",an);
							 localStorage.setItem("all-wet-admin-userame",au);
							
							 window.location.replace("/admin/");
							
						} else {
							M.toast({html: result, durationLength:3000});
							$("#loader").hide();
							$("#entry").show();
							$(".card-action").show();
						}
						
						if(result.code == 400){
							var rm = result['message'];
							M.toast({html:rm, durationLength:3000});
							$("#loader").hide();
							$("#entry").show();
							$(".card-action").show();
						} else {
							var an = result
						}
					} catch(e) {
						M.toast({html:"Problem processing request", durationLength:3000});
						$("#loader").hide();
						$("#entry").show();
						$(".card-action").show();
					}
				}
			}).fail(()=>{
				M.toast({html:"Cannot connect to server", durationLength:3000});
				$("#loader").hide();
				$("#entry").show();
				$(".card-action").show();
			});
		}
	}
};