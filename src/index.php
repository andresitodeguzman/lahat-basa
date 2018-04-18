<?php
/**
 * All Wet
 * 2018 hahaha
 * 
 * Index
 */

session_start();
require_once("_system/config.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?=$app_name?></title>
    <?php require_once("_system/head.php"); ?>
    <style>
        html,body{
            height: 100%;
        }
        .parallax-container {
            height: 100%;
        }		
        h2,h5, .wt {
            text-shadow: 1px 1px #424242;
        }
      .right {
        margin-right: 1.5% !important;
      }
    </style>
    <script src="/_index.js" type="text/javascript"></script>
</head>
<body>
    <div class="parallax-container">
        <div class="navbar-fixed">
          <nav class="transparent z-depth-0">
            <div class="right">
               <a class='dropdown-trigger' href='#' data-target='dropdown1'><i class="material-icons">more_vert</i></a>
            </div>
          </nav>
        </div>
        
        <!-- Dropdown Structure -->
        <ul id='dropdown1' class='dropdown-content'>
          <li><a href="/authenticate/?account_type=admin" class="black-text">Admin Area</a></li>
          <li><a href="/authenticate/?account_type=employee" class="black-text">Employee Area</a></li>
        </ul>
        
        <div class="parallax">
            <img src="/assets/images/heroimg2.jpg">
        </div>
        <div class="container"><br><br>
            <center>
                <h2 class="white-text"><b>All Wet</b></h2>
                <h5 class="white-text">
                    Purified Drinking Water
                </h5><br><br>
                <div id="button"></div>
            </center>
        </div>
    </div>
</body>
</html>