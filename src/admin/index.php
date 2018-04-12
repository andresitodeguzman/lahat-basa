<?php
/**
 * All Wet
 * 2018
 *
 * Admin
 * Index
*/
?>
<!Doctype html>
<html>
    <head>
        <title>All Wet</title>
        <?php require("../_system/head.php"); ?>
        <script text="text/javascript" src="/employee/_app.js"></script>
        <style>
            .nav-wrapper {
                padding-left: 1%;
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
                <a href="/app">
                    <span class="white-text name">
                        <b>All Wet Employee</b>
                    </span>
                </a>
                <a href="/app">
                    <span class="white-text email">
                        <span id="sidenav_customer_number"></span>
                    </span>
                </a>
            </div>
        </li>


		</div>

        <li><a href="#" onclick="deliveryShow()"><i class="material-icons">view_list</i>For Delivery</a></li>
        <li><a href="#" onclick="productsShow()"><i class="material-icons">local_mall</i> Product list</a></li>
        <li class="divider"></li>
        <li><a href="/authenticate/logout.php"><i class="material-icons">person</i> Log-out</a></li>

    </ul>
        
        <!-- transactionActivity -->
        <div class="activity col s12" id="transactionActivity">
            <div class="container">
                <h4 class="grey-text text-darken-3"><b>For Administrative Use Only</b></h4>
                <div id="transactions"></div><br><br><br><br>
            </div>
        </div>
        <!-- .transactionActivity-->
        
    </body>
</html>