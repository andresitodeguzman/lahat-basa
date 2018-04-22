$(document).ready(() => {
  $("meta[name='theme-color']").attr("content", "#455a64");
  clear();

  $(".sidenav").sidenav();
  $('.modal').modal();

  loginCheck();

  setForDelivery();
  setProducts();
  setCustomer();
  setEmployee();

  splash(1000);
  forDeliveryShow();
});