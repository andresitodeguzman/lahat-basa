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

// App Functions
var loginCheck = () => {
  return true;
};