var employeeShow = ()=>{
  clear();
  closeNav();
  $("#employeeActivity").fadeIn();
};

var setEmployee = ()=>{
  $("#employeeList").html(preloader);

  if(navigator.onLine){
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
  } else {
    renderEmployee();
  }
};

var renderEmployee = ()=>{
  try {
    var result = JSON.parse(localStorage.getItem("all-wet-employee"));
    if(result.length < 0){
      var tmpl = `
        <div class="card">
          <div class="card-content"><br>
            <center class="grey-text">No Employees Yet</center><br>
          </div>
        </div>
      `;
      $("#employeeList").html(tmpl);
    } else {
      $("#employeeList").html(" ");
      $.each(result,(index,value)=>{
        var eid = value.employee_id;
        var en = value.employee_name;
        var eu = value.employee_username;
        var ei = value.employee_image;
        var es = value.employee_salary;
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
              <a href="#" onclick="deleteEmployee${eid}()" class="red-text">
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
                  <input type="text" id="employeeName${eid}" value="${en}">
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
                <div class="input-field">
                  <input type="text" id="employeeSalary${eid}" value="${es}">
                  <label for="employeeSalary${eid}" class="active">Salary</label> 
                </div>
              </div>

            </div>
            <div class="modal-footer" id="editEmployeeActivity${eid}">
              <a href="#" onclick="saveEditEmployee${eid}()" class="modal-action waves-effect btn-flat">Save</a>
              <a href="#" class="modal-action modal-close waves-effect waves-red btn-flat">Close</a>
            </div>
          </div>

          <script type="text/javascript">
            $(document).ready(()=>{
              $(".modal").modal();
              $("#preloaderAddEmployee${eid}").hide();
            });

            var saveEditEmployee${eid} = ()=>{
              $("#preloaderAddEmployee${eid}").show();
              $(".editEmployeeActivity${eid}").hide();

              var en${eid} = $("#employeeName${eid}").val();
              var eu${eid} = $("#employeeUsername${eid}").val();
              var ep${eid} = $("#employeePassword${eid}").val();
              var ei${eid} = $("#employeeImage${eid}").val();
              var es${eid} = $("#employeeSalary${eid}").val();

              if(!eu${eid}){
                M.toast({html:"Username is Required",durationLength:3000});
                $("#preloaderAddEmployee${eid}").hide();
                $(".editEmployeeActivity${eid}").show();
              } else {
                if(!en${eid}){
                  M.toast({html:"Username is Required",durationLength:3000});
                  $("#preloaderAddEmployee${eid}").hide();
                  $(".editEmployeeActivity${eid}").show();
                } else {
                  $.ajax({
                    type:'POST',
                    cache:'false',
                    url:'/api/Employee/update.php',
                    data:  {
                      employee_id: '${eid}',
                      employee_name: en${eid},
                      employee_username: eu${eid},
                      employee_password: ep${eid},
                      employee_image: ei${eid},
                      employee_salary: es${eid}
                    },
                    success: result=>{
                     if(result.code === 200){
                      M.toast({html:result.message, durationLength:3000});
                      setEmployee();
                     }  else {
                      M.toast({html:result.message, durationLength:3000});
                     }

                    $("#preloaderAddEmployee${eid}").hide();
                    $(".editEmployeeActivity${eid}").show();
                    }
                  }).fail(()=>{
                    $("#preloaderAddEmployee${eid}").hide();
                    $(".editEmployeeActivity${eid}").show();
                    M.toast({html:"An Error Occurred", durationLength:3000});
                  });
                }
              }
            };

            var deleteEmployee${eid} = ()=>{
              $.ajax({
                type:'POST',
                url:'/api/Employee/delete.php',
                data: {
                  employee_id: ${eid}
                },
                success: result=>{
                  if(result.code){
                    M.toast({html:result.message,durationLength:3000});
                    setEmployee(); 
                  }
                }
               }).fail(()=>{
                  M.toast({html:"An Error Occurred",durationLength:3000});
               });
            };
          </script>
        `;
        $("#employeeList").append(tmpl);
      });
    }

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
    var es = $("#employeeSalary").val();

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
              employee_image: ei,
              employee_salary: es
            },
            success: result=>{
              try {
                if(result.code){                  
                  M.toast({html:result.message, durationLength:3000});
                  $("#employeeName").val("");
                  $("#employeeUsername").val("");
                  $("#employeePassword").val("");                  
                  $("#employeeImage").val("");
                  setEmployee();
                  showInput();
                } else {
                  M.toast({html: "An Error Occurred", durationLength:3000});
                  showInput();  
                }
              } catch(e) {
                console.log(e);
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
    M.toast({html:"An Error Occurred", durationLength:3000});
    showInput();
  }
};