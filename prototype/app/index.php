<?php
/*
All Wet
2018
*/
session_start();

require_once("../_class/Account.class.php");
require_once("../_system/config.php");

$account = new Account();

if($account->isLoggedIn() == False) header("Location:../authenticate");

$subscriber_number = $_SESSION['globe_subscriber_number'];
if($subscriber_number[0] == 9) $subscriber_number = "0$subscriber_number";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?=$site_title?></title>
    <?php
        require_once("../_system/styles.php");
    ?>
    <style>
        .nav-wrapper{
            padding-left:1%;
            padding-right: 3%;
        }
        .title {
            padding-left: 1%;
            font-size: 18pt;
        }
    </style>
</head>
<body class="grey lighten-4">

    <div class="navbar-fixed">
        <nav class="blue darken-3">
            <div class="nav-wrapper">
            <a href="#" data-target="snav" class="show-on-large sidenav-trigger"><i class="material-icons">menu</i></a>
                <a class="title" href="#"><b>All Wet</b></a>
            </div>
        </nav>
    </div>
    
    <ul class="sidenav" id="snav">
        <li>
            <div class="user-view">
                <div class="background blue darken-2">
                    <!--img src="/assets/imgs/sidenavbg.jpg"-->
                </div>
                <a href="app/profile.php">
                    <span class="white-text name">
                        <b>All Wet Customer</b>
                    </span>
                </a>
                <a href="/app">
                    <span class="white-text email">
                        <?=$subscriber_number?>
                    </span>
                </a>
            </div>
        </li>
        <li><a href="/app/order.php"><i class="material-icons">add</i> Order</a></li>
        <li><a href="/app"><i class="material-icons">list</i> My Order</a></li>
        <li><a href="/authentication/logout.php"><i class="material-icons">person</i> Log-out</a></li>
    </ul>

    <div class="container">
        <h3 class="blue-text text-darken-2">
            My Order
        </h3>
        <center>
            <br><br>
            <h5 class="grey-text">
                <b>No Order Yet</b><br>
                Tap the + to start a transaction
            </h5>
        </center>
    </div>

    <div class="fixed-action-btn">
        <a class="btn-floating btn-large blue darken-3 waves-effect waves-light" href="/app/order.php">
            <i class="material-icons">add</i>
        </a>
    </div>
</body>
</html>
<script>
$(document).ready(()=>{
    $(".sidenav").sidenav();
});
</script>