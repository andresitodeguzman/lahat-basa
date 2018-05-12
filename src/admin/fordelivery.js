// Activity Loader
var forDeliveryShow = () => {
  clear();
  closeNav();
  $("#forDeliveryActivity").fadeIn();
}

var setForDelivery = () => {

  $("#forDeliveryList").html(preloader);

  if(Navigator.onLine){
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

        if (tc <= 1) {
          var qv = "item";
        } else {
          var qv = "items";
        }

        if (tlo) {
          var mpimg = `
                        <div class="card-img">
                            <img src="https://maps.googleapis.com/maps/api/staticmap?center=${tlt},${tlo}&zoom=17&size=800x300&markers=color:blue%7C${tlt},${tlo}&key=AIzaSyCuNfQSkwl85bk38k4de_QR-DwBGL-069o" width="100%">
                        </div>
                    `;
        }

        var templ = `
                    <div class="card hoverable">
                        ${mpimg}
                        <div class="card-content">
							<span class="card-title">${ta}</span>
							<p><font size="3pt" class="grey-text">${td} ${tt}</font></p>
							<br>
							<p style="line-height:1.5">
								<i class="material-icons grey-text text-darken-1">local_offer</i> ₱${tp} for ${tc} ${qv}<br>
								<i class="material-icons grey-text text-darken-1">payment</i> ${tpm}<br>
								<i class="material-icons grey-text text-darken-1">linear_scale</i> ${ts}
							</p>
                        </div>
                        <div class="card-action">
                            <a href="#" onclick="setAsDelivered(${tid})" class="grey-text"><i class="material-icons">done</i></a>
                            <a href="https://www.google.com/maps/dir/?api=1&destination=${tlt},${tlo}" class="grey-text"><i class="material-icons">map</i></a>
                            <a href="#" class="grey-text"><i class="material-icons">call</i></a>
                        </div>
                    </div>
                `;

        $("#forDeliveryList").append(templ);

      });

    }
  } catch (e) {
    alert(e);
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