$(document).ready(() => {
  $("meta[name='theme-color']").attr("content", "#455a64");
  clear();
  
  loginCheck();

  $(".sidenav").sidenav();
  $('.modal').modal();

  setForDelivery();
  setProducts();
  setCustomer();
  setEmployee();
  setAdmin();

  splash(1000);
  forDeliveryShow();
  
  setInterval(recheckLoginStatus(),300000);
});