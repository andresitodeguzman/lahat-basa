$(document).ready(()=>{
    // Initialize everything here
    $(".sidenav").sidenav();
    getTransactions();
    
    
});


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

var clear = ()=>{
    $(".activity").hide();
}

var closeNav = ()=>{
    $(".sidebar").sidenav('close');
};

var checkLoginStatus = ()=>{
  return localStorage.getItem('all-wet-login');
};

var loginCheck = ()=>{
    let status = checkLoginStatus();
    if(status != "true"){
        window.location.replace("/authenticate");
    }
};


// App Functions

var getTransactions = ()=>{
    
    $.ajax({
       type: 'GET',
        url: '/api/Transaction/getAll.php',
        cache: 'false',
        data: {
            id: 0
        },
        success: result=>{
            //console.log(result);
            try{
                 
                $.each(result,(index,value)=>{
                    var i = value['admin_id'];
                    var n = value['admin_name'];
                    var usr = value['transaction_username'];
                    var pas = value['customer_password'];
                    var img = value['customer_image'];
                                      
                    
                    var transactionCard = `
                        <div class="card hoverable">
                        </div>
                    `;
                    
                    $("#transaction").append(transactionCard);
                }); 
            }
            catch(e){ 
                $("#transaction").html(errorCard);          
            }
                
        }
    }).fail(()=>{
        $("#transaction").html(errorCard);
    });
};