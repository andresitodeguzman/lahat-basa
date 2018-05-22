// Activity Loader
var forDeliveryShow = () => {
  clear();
  closeNav();
  $("#forDeliveryActivity").fadeIn();
}

var setForDelivery = () => {

  $("#forDeliveryList").html(preloader);

  if(navigator.onLine){
    $.ajax({
      type: 'GET',
      cache: 'false',
      url: transactionGetAll,
      success: result => {
        try {
          localStorage.setItem("all-wet-for-delivery", JSON.stringify(result));
          renderForDelivery();
        } catch (e) {
          $("#forDeliveryList").html(errorCard);
          M.toast({
            html: "Error processing request",
            displayLength: 3000
          });
        }
      }
    }).fail(() => {
      renderForDelivery();
      M.toast({
        html: "Cannot get new 'for delivery' list",
        displayLength: 3000
      });
    });
  } else {
    renderForDelivery();
  }
  
}

var renderForDelivery = () => {
  var empty = `
	<div class='card'>
		<div class='card-content'>
			<center>Nothing to Deliver Yet</center>
		</div>
	</div>
    `;

  try {
    var result = JSON.parse(localStorage.getItem("all-wet-for-delivery"));

    if (result.code == 400) {
      $("#forDeliveryList").html(empty);
    } else {
      $("#forDeliveryList").html(" ");

      $.each(result, (index, order) => {
        var mpimg = " ";

        var tid = order['transaction_id'];
        var td = order['transaction_date'];
        var tt = order['transaction_time'];
        var cid = order['customer_id'];
        var tc = order['transaction_count'];
        var tp = order['transaction_price'];
        var tpm = order['transaction_payment_method'];
        var ts = order['transaction_status'];
        var tlo = order['transaction_longitude'];
        var tlt = order['transaction_latitude'];
        var ta = order['transaction_address'];
        var c = order.customer;
        var cname = c.customer_name;
        var cnum = c.customer_number;
        var ti = order.transitem;

        if (tc <= 1) {
          var qv = "item";
        } else {
          var qv = "items";
        }

        if(tpm === "CASH_ON_DELIVERY"){
          var tpm = "Cash on Delivery";
        }

        if(tpm === "CREDIT_CARD"){
          var tpm = "Credit Card";
        }

        if(ts === "PROCESS"){
          var ts = "Processing Order";
        }

        if(ts === "PROCESSING"){
          var ts = "Processing";
        }

        if(ts === "FOR_DELIVERY"){
          var ts = "For Delivery";
        }

        if(ts === "CANCELLED"){
          var ts = "Cancelled Delivery";
        }

        if(ts === "DELIVERED"){
          var ts = "Delivered";
        }

        if (tlo) {
          var mpimg = `
            <div class="card-img">
              <img src="https://maps.googleapis.com/maps/api/staticmap?center=${tlt},${tlo}&zoom=17&size=800x300&markers=color:blue%7C${tlt},${tlo}&key=AIzaSyCuNfQSkwl85bk38k4de_QR-DwBGL-069o" width="100%">
            </div>
          `;
      
          var dest = `https://www.google.com/maps/dir/?api=1&destination=${tlt},${tlo}`;
          } else {
    
          var mpimg = `
            <div class="card-img">
              <img src="https://maps.googleapis.com/maps/api/staticmap?center=${ta}&zoom=17&size=800x300&markers=color:blue%7C${ta}&key=AIzaSyCuNfQSkwl85bk38k4de_QR-DwBGL-069o" width="100%">
            </div>
          `;
    
          var dest = `https://www.google.com/maps/dir/?api=1&destination=${ta}`;
          }

          if(!cname){
            var cname = "Unknown Customer";
          }

        var templ = `
          <div class="card hoverable">
            ${mpimg}
            <div class="card-content">
              <span class="card-title">${ta}</span>
              <p><font size="3pt" class="grey-text">${td} ${tt}</font></p>
              <br>
              <p style="line-height:1.5">
              <i class="material-icons grey-text text-darken-1">person</i> ${cname}<br>
              <i class="material-icons grey-text text-darken-1">local_offer</i> ₱${tp} for ${tc} ${qv}<br>
              <i class="material-icons grey-text text-darken-1">payment</i> ${tpm}<br>
              <i class="material-icons grey-text text-darken-1">linear_scale</i> ${ts}
              </p>
            </div>
            <div class="card-action">
              <a href="#fdChangeStatus${tid}" class="grey-text modal-trigger" data-trigger="fdChangeStatus${tid}"><i class="material-icons">library_add</i></a>
              <a href="#fdItems${tid}" class="grey-text modal-trigger" data-trigger="fdItems${tid}"><i class="material-icons">list</i></a>
              <a href="${dest}" class="grey-text"><i class="material-icons">map</i></a>
              <a href="tel:+63${cnum}" class="grey-text"><i class="material-icons">call</i></a>
            </div>
          </div>

          <div class="modal modal-fixed-footer" id="fdItems${tid}">
            <div class="modal-content">
                <h5 class="blue-grey-text text-darken-4">Items</h5><br>
                <ul class="collection" id="fdItemsList${tid}"></ul>
            </div>
            <div class="modal-footer addProductActivity">
                <a href="#" class="modal-action modal-close waves-effect waves-red btn-flat">Close</a>
            </div>
          </div>

          <div class="modal modal-fixed-footer" id="fdChangeStatus${tid}">
            <div class="modal-content">
              <h5 class="blue-grey-text text-darken-4">Change Status</h5><br>
              <ul class="collection">
                <li class="collection-item">
                  <a class="black-text" href="#csa${tid}" onclick="changeTransactionStatus(${tid},'PROCESSING')">Processing</a>
                </li>
                <li class="collection-item">
                  <a class="black-text" href="#csb${tid}" onclick="changeTransactionStatus(${tid},'FOR_DELIVERY')">For Delivery</a>              
                </li>
                <li class="collection-item">
                  <a class="black-text" href="#csc${tid}" onclick="changeTransactionStatus(${tid},'CANCELLED')">Cancelled Delivery</a>              
                </li>
                <li class="collection-item">
                  <a class="black-text" href="#csd${tid}" onclick="changeTransactionStatus(${tid},'DELIVERED')">Set as Delivered</a>
                </li>
              </ul>
            </div>
            <div class="modal-footer">
                <a href="#" class="modal-action modal-close waves-effect waves-red btn-flat">Close</a>
            </div>
          </div>

        `;

        if(ts !== "DELIVERED"){
          $("#forDeliveryList").append(templ);
          $.each(ti, (index,value)=>{
            var pn = value.product_name;
            var tiq = value.transitem_quantity;
      
            if(tiq > 1){
              var qv = "pieces";
            } else {
              var qv = "piece";
            }
      
            var tpl = `<li class="collection-item">${pn} (${tiq} ${qv})</li>`;
            $(`#fdItemsList${tid}`).append(tpl);
          });
        }

      });

    }
  } catch (e) {
    console.log(e);
    $("#forDeliveryList").html(errorCard);
  }
};

var setAsDelivered = tid=>{
  $.ajax({
    type:'GET',
    cache: 'false',
    url: '/api/Transaction/updateStatus.php',
    data: {
      transaction_id: tid,
      transaction_status: 'DELIVERED'
    },
    success: result=>{
      if(result.code == 200){
        M.toast({html:"Successfully Set as Delivered", durationLength:3000});
        setForDelivery();
      }
    }
  }).fail(()=>{
    M.toast({html:"An Error Occurred", durationLength:3000});
  });  
}

var changeTransactionStatus = (tid,status)=>{
  $.ajax({
    type:'GET',
    cache: 'false',
    url: '/api/Transaction/updateStatus.php',
    data: {
      transaction_id: tid,
      transaction_status:status
    },
    success: result=>{
      if(result.code == 200){
        M.toast({html:`Successfully set as "${status}"`, durationLength:3000});
        setForDelivery();
      }
    }
  }).fail(()=>{
    M.toast({html:"An Error Occurred", durationLength:3000});
  });  
}

