$(document).ready(()=>{
	$("meta[name='theme-color']").attr("content","#455a64");
	$("#loader").hide();
}).keypress(e=>{
  var key = e.which;
  if(key == 13){
    signIn();
  }
});

var signInApi = '/authenticate/process/employee.php';

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
						if(result['employee_id']){
							 var ei = result['employee_id'];
							 var en = result['employee_name'];
							 var eu = result['employee_username'];
							 
							 localStorage.setItem("all-wet-account-type","employee");
							 localStorage.setItem("all-wet-login",true);
							 localStorage.setItem("all-wet-employee-id",ei);
							 localStorage.setItem("all-wet-employee-name",en);
							 localStorage.setItem("all-wet-employee-userame",eu);
							
							 window.location.replace("/employee");
							
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