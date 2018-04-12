<?php
session_start();

require_once("_class/Account.class.php");

require_once("_system/config.php");

$account = new Account();

$isLoggedIn = $account->isLoggedIn();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Welcome - <?=$site_title?></title>
  <?php
    require_once("_system/styles.php");
  ?>
  <style>
    html,body{
      height: 100%;
    }
    .parallax-container {
      height: 100%;
    }
  </style>
</head>
<body>
  <div class="parallax-container">
    <div class="parallax">
      <img src="assets/imgs/heroimg.jpg">
    </div>
    <div class="container">
    <br><br><br>
      <h2 class="white-text">
        <b>All Wet</b>
      </h2>
      <h5 class="white-text">
        Purified Drinking <a href="/manage" class="white-text">Water</a>
      </h5>
      <br><br><br>
      <?php
        if($isLoggedIn == True){
          echo "
            <a class='btn btn-large blue darken-4 waves-effect waves-light' href='app'>
              Open App
            </a>
          ";
        } else {
          echo "
            <a class='btn btn-large blue darken-4 waves-effect waves-light' href='authentication'>
              Sign-In with your Mobile Number
            </a>
          ";
        }
      ?>
    </div>
  </div>
</body>
</html>
<script>
  $(document).ready(()=>{
    $('.parallax').parallax();
    $(".btn").hide();
    $(".btn").fadeIn();
  });
</script>