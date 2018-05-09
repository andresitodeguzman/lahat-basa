// Global Variables
let errorCard = `
	<div class="card">
		<div class="card-content">
			<center><p class="grey-text">An Error Occured</p></center>
		</div>
	</div>
`;

let preloader = `
	<center>
		<div class="preloader-wrapper big active">
			<div class="spinner-layer spinner-blue-only">
				<div class="circle-clipper left">
					<div class="circle"></div>
				</div><div class="gap-patch">
					<div class="circle"></div>
				</div><div class="circle-clipper right">
					<div class="circle"></div>
				</div>
			</div>
		</div>
	</center>
`;

let errorMessage = "An error occurred";

// Global UI Functions
var clear = () => {
  $(".activity").hide();
  $("#preloaderAddCategory").hide();
  $("#preloaderAddProduct").hide();
  $("#preloaderAddEmployee").hide();
}
var closeNav = () => {
  $(".sidenav").sidenav('close');
}

var checkLoginStatus = ()=>{
	return localStorage.getItem('all-wet-login');
};

var loginCheck = ()=>{
	let status = checkLoginStatus();
	if(status != "true"){
		window.location.replace("/");
	} else {
		var at = localStorage.getItem("all-wet-account-type");
		if(at !== "admin"){
			window.location.replace("/");
		}
	}
};

var recheckLoginStatus = ()=>{
	$.ajax({
		type:'POST',
		url:'/authenticate/signInStatus.php',
		cache:'false',
		success: result=>{
			try {
				if(result.is_signed_in == 'False'){
					localStorage.clear();
					window.location.replace("/");
				} else {
					if(result.account_type !== "admin"){
						window.location.replace("/");
					}
				}
			} catch(e){
				console.log(e);
			}
		}
	}).fail(()=>{
		console.log({module:"recheckLoginStatus",message:"Cannot check sign-in status"});
	});
};