$(document).ready(()=>{
	$("meta[name='theme-color']").attr("content","#455a64");
});

var signInApi = '';

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
					admin_username: u,
					admin_password: p
				}, 
				success: result=>{
					try {
						if(result.code == 400){
							var rm = result['message'];
							M.toast({html:rm, durationLength:3000});
						} else {
							alert("ok");
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