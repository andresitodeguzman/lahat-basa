$(document).ready(()=>{
	$("meta[name='theme-color']").attr("content","#455a64");
});

var signInApi = '/authenticate/process/admin.php';

var signIn = ()=>{
	var u = $("#username").val();
	var p = $("#password").val();

	if(!u){
		M.toast({html:"Username is required", durationLength:3000});
	} else {
		if(!p) {
			M.toast({html:"Password is required", durationLength:3000});
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
							 
							 localStorage.setItem("all-wet-login",true);
							 localStorage.setItem("all-wet-admin-id",ai);
							 localStorage.setItem("all-wet-admin-name",an);
							 localStorage.setItem("all-wet-admin-userame",au);
							
							
						} else {
							M.toast({html: result, durationLength:3000});
						}
						
						if(result.code == 400){
							var rm = result['message'];
							M.toast({html:rm, durationLength:3000});
						} else {
							var an = result
						}
					} catch(e) {
						M.toast({html:"Problem processing request", durationLength:3000});
					}
				}
			}).fail(()=>{
				M.toast({html:"Cannot connect to server", durationLength:3000});
			});
		}
	}
};