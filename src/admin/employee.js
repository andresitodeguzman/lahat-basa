var employeeShow = ()=>{
  clear();
  closeNav();
  $("#employeeActivity").fadeIn();
};

var setEmployee = ()=>{
  $("#employeeList").html(preloader);
  $.ajax({
    type:'GET',
    cache: 'false',
    url: employeeGetAll,
    data: {
      a:1
    },
    success: result=>{
      try {
        localStorage.setItem("all-wet-employee",JSON.stringify(result));
        renderEmployee();
      } catch(e) {
        console.log(e);
        renderEmployee();
        M.toast({html: "An Error Occurred", durationLength:3000});
      }
    }
  }).fail(()=>{
    renderEmployee();
    M.toast({html:"Cannot get new employees", durationLength:3000});
  });
};

var renderEmployee = ()=>{
  try {
    var result = JSON.parse(localStorage.getItem("all-wet-employee"));
    $("#employeeList").html(" ");
    $.each(result,(index,value)=>{
      var eid = value.employee_id;
      var en = value.employee_name;
      var eu = value.employee_username;
      var ei = value.employee_image;
      var img = " ";

      if(ei){
        var img = `
          <div class="card-img">
            <img src="${ei}" width="100%">
          </div>
        `;
      }

      var tmpl = `
        <div class="card hoverable">
          ${img}
          <div class="card-content">
            <span class="card-title">${en}</span>
            <p><font size="3pt" class="grey-text">@${eu}</font></p>
            <br>
          </div>
          <div class="card-action">
            <a href="#" data-target="modalEditEmployee${eid}" class="black-text modal-trigger">
              <i class="material-icons">edit</i>
            </a>
            <a href="#" onclick="deleteEmployee${eid}" class="red-text">
              <i class="material-icons">delete</i>
            </a>
          </div>
        </div>

        <div class="modal modal-fixed-footer" id="modalEditEmployee${eid}">
          <div class="modal-content">
            <h5>Edit Employee</h5><br>

            <div id="preloaderAddEmployee${eid}">
              <center>
                <div class="preloader-wrapper big active">
                  <div class="spinner-layer spinner-blue-only">
                    <div class="circle-clipper left">
                      <div class="circle"></div>
                    </div>
                    <div class="gap-patch">
                      <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                      <div class="circle"></div>
                    </div>
                  </div>
                </div>
              </center>
            </div>

            <div class="editEmployeeActivity${eid}">
              <div class="input-field">
                <input type="text" id="employeeName${eid}" value="${eid}">
                <label for="employeeName${eid}" class="active">Name</label> 
              </div>
              <div class="input-field">
                <input type="text" id="employeeUsername${eid}" value="${eu}">
                <label for="employeeUsername${eid}" class="active">Username</label>
              </div>
              <div class="input-field">
                <input type="password" id="employeePassword${eid}">
                <label for="employeePassword${eid}" class="active">Password</label>
              </div>
              <div class="input-field">
                <input type="text" id="employeeImage${eid}" value="${ei}">
                <label for="employeeImage${eid}" class="active">Image (Relative from Home)</label> 
              </div>
            </div>

          </div>
          <div class="modal-footer" id="editEmployeeActivity${eid}">
            <a href="#" onclick="saveEditEmployee${id}()" class="modal-action waves-effect btn-flat">Save</a>
            <a href="#" class="modal-action modal-close waves-effect waves-red btn-flat">Close</a>
          </div>
        </div>

        <script type="text/javascript">
          $(document).ready(()=>{
            $(".modal").modal();
          });



          var saveEditEmployee${eid} = ()=>{
            alert("ok");
          };

          var deleteEmployee${eid} = ()=>{

          };
        </script>
      `;
      $("#employeeList").append(tmpl);
    });

  } catch(e){
    console.log(e);
    $("#employeeList").html(errorCard);
  }  
};

var addEmployee = ()=>{
  $("#preloaderAddEmployee").show();
  $(".addEmployeeActivity").hide();

  var showInput = ()=>{
    $("#preloaderAddEmployee").hide();
    $(".addEmployeeActivity").show();
  };

  try {
    var en = $("#employeeName").val();
    var eu = $("#employeeUsername").val();
    var ep = $("#employeePassword").val();
    var ei = $("#employeeImage").val();

    if(!eu){
      M.toast({html:"Username is Required", durationLength:3000});
      showInput();
    } else {
      if(!ep) {
        M.toast({html:"Password is Required", durationLength:3000});
        showInput();
      } else {
        if(!en){
          M.toast({html: "Name is Required", durationLength:3000});
          showInput();
        } else {
          $.ajax({
            type: 'POST',
            cache: 'false',
            url: employeeAdd,
            data: {
              employee_name: en,
              employee_username: eu,
              employee_password: ep,
              employee_image: ei
            },
            success: result=>{
              try {
                if(result.code){
                  M.toast({html:code.message, durationLength:3000});
                  $("#employeeName").val(" ");
                  $("#employeeUsername").val(" ");
                  $("#employeePassword").val(" ");
                  $("#employeeImage").val(" ");
                  showInput();
                } else {
                  M.toast({html: "An Error Occurred", durationLength:3000});
                  showInput();  
                }
              } catch(e) {
                M.toast({html: "An Error Occurred", durationLength:3000});
                showInput();
              }
            }
          }).fail(()=>{
            M.toast({html:"An Error Occurred", durationLength:3000});
            showInput();
          });
        }
      }
    }

  } catch(e){
    console.log(e);
    M.toast({html:"An Error Occured", durationLength:3000});
    showInput();
  }
};