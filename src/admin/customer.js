var customerShow = ()=>{
  clear();
  closeNav();
  $("#customerActivity").fadeIn();
};

var setCustomer = ()=>{
  $("#customerList").html(preloader);

  if(navigator.onLine){
    $.ajax({
      type:'GET',
      cache:'false',
      url: customerGetAll,
      success: result=>{
           try {
             localStorage.setItem("all-wet-customer",JSON.stringify(result));
             renderCustomer();
           } catch(e){
             console.log(e);
             renderCustomer();
             M.toast({html:"Cannot get new customers", durationLength:3000});
           }
       }
    }).fail(()=>{
      renderCustomer();
      M.toast({html: "Cannot get new customers", durationLength:3000});
    });
  } else {
    renderCustomer();
  }
};

var renderCustomer = ()=>{
  try {
    var result = JSON.parse(localStorage.getItem("all-wet-customer"));
    
    $("#customerList").html(" ");
    $.each(result, (index,value)=>{
      
      var cid = value.customer_id;
      var cnu = value.customer_number;
      var cn = value.customer_name;
      var clo = value.customer_longitude;
      var clt = value.customer_latitude;
      var ca = value.customer_address;
      var ci = value.customer_image;
      
      if(!cn){
        cn = "Unknown Customer";
      }
      
      if(ci){
        var img = `
          <div class="card-img">
            <img src="${ci}" width="100%">
          </div>
        `;
      } else {
        var img = "";
      }
      
      if(!ca){
       var ca = "Unknown Address"; 
      }
      
      var tmpl = `
        <div class="card hoverable">
            ${img}
          <div class="card-content">
            <span class="card-title">${cn}</span><br>
            <p>
              <i class="material-icons">phone</i> 0${cnu}<br>
              <i class="material-icons">map</i> ${ca}
            </p>
          </div>
          <div class="card-action">
            <a href="tel:+69${cnu}" class="black-text"><i class="material-icons">phone</i></a>
            <a href="sms:+69${cnu}" class="black-text"><i class="material-icons">message</i></a>
          </div>
        </div>
      `;
      
      $("#customerList").append(tmpl);
      
    });
  } catch(e){
    console.log(e);
    $("#customerList").html(errorCard);
  }
};