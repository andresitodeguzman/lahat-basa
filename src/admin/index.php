<?php
/**
 * All Wet
 * 2018
 * 
 * Admin
 * Index
 */
require_once("../_system/config.php");
?>
  <!Doctype html>
  <html>

  <head>
    <title>All Wet - Admin</title>
    <?php require_once("../_system/head.php"); ?>
    <script type="text/javascript" src="/admin/_app.js"></script>
  </head>

  <body class="grey lighten-4">

    <!--splashscreen-->
    <div class="splashscreen valign-wrapper blue-grey darken-3" id="splashscreen">
      <h3 class="valign center-block white-text">
        <noscript>
                <b class="white-text">
                    <center>
                        <h4>Sorry!</h4>
                        <h5>This application requires Javascript to be turned on.</h5>
                    </center>
                </b>
            </noscript>
        <center>
          <h4>
            <b>All Wet</b> Admin
          </h4>
        </center>
      </h3>
    </div>
    <!--.splashscreen-->

    <!-- sideNav -->
    <ul class="sidenav" id="snav">
      <li>
        <div class="user-view">
          <div class="background blue-grey darken-2">
            <!--img src="/assets/imgs/sidenavbg.jpg"-->
          </div>
          <a href="/app">
                    <span class="white-text name">
                        <b>All Wet Admin</b>
                    </span>
                </a>
          <a href="/app">
                    <span class="white-text email">
                        <span id="sidenav_employee_id"></span>
                    </span>
                </a>
        </div>
      </li>


      </div>

      <li><a href="#" onclick="forDeliveryShow()"><i class="material-icons">local_shipping</i> For Delivery</a></li>
      <li class="divider"></li>
      <li><a href="#" onclick="categoryShow()"><i class="material-icons">view_list</i>Category</a></li>
      <li><a href="#" onclick="productsShow()"><i class="material-icons">local_mall</i> Products</a></li>
      <li class="divider"></li>
      <li><a href="#" onclick="editAccountShow()"><i class="material-icons">info</i> Edit Account</a></li>
      <li class="divider"></li>
      <li><a href="/authenticate/logout.php"><i class="material-icons">person</i> Log-out</a></li>

    </ul>
    <!-- .sideNav-->

    <!-- forDeliveryActivity -->
    <div class="activity col s12" id="forDeliveryActivity">

      <!-- navbar -->
      <div class="navbar-fixed" id="navbar">
        <nav class="blue-grey darken-2 z-depth-2">
          <div class="nav-wrapper">
            <a href="#" data-target="snav" class="show-on-large sidenav-trigger"><i class="material-icons">menu</i></a>
            <a class="title" href="#"><b>All Wet</b> Admin</a>
            <div class="right">
              <a href="#" onclick="setForDelivery()"><i class="material-icons white-text">refresh</i></a>
            </div>
          </div>
        </nav>
      </div>
      <!-- .navbar -->

      <div class="container">
        <h4 class="blue-grey-text text-darken-3">For Delivery</h4>
        <br>
        <div class="cards-container">
          <div id="forDeliveryList"></div>
        </div>
        <br><br><br><br>
      </div>
    </div>
    <!-- forDeliveryActivity -->

    <!-- categoryActivity -->
    <div class="activity col s12" id="categoryActivity">

      <!-- navbar -->
      <div class="navbar-fixed" id="navbar">
        <nav class="blue-grey darken-2 z-depth-2">
          <div class="nav-wrapper">
            <a href="#" data-target="snav" class="show-on-large sidenav-trigger"><i class="material-icons">menu</i></a>
            <a class="title" href="#"><b>All Wet</b> Admin</a>
            <div class="right">
              <a href="#" onclick="setCategory()"><i class="material-icons white-text">refresh</i></a>
            </div>
          </div>
        </nav>
      </div>
      <!-- .navbar -->

      <div class="container">
        <h4 class="blue-grey-text text-darken-3">
          Categories
        </h4>
        <div class="cards-container">
          <div id="categoryList"></div>
        </div>
      </div><br><br><br><br>

      <div class="fixed-action-btn">
        <a id="btnAdd" class="btn-floating btn-large blue-grey darken-2 waves-effect waves-light btn-floating z-depth-3 modal-trigger" href="#" data-target="addCategoryModal">
          <i class="material-icons">add</i>
        </a>
      </div>
    </div>

    <div class="modal modal-fixed-footer" id="addCategoryModal">
      <div class="modal-content">
        <h5>
          Add a Category
        </h5><br>
        <div id="preloaderAddCategory">
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
        <div class="addCategoryActivity">
          <div class="input-field">
            <input type="text" id="categoryName">
            <label for="categoryName">Name</label>
          </div>
          <div class="input-field">
            <input type="text" id="categoryCode">
            <label for="categoryCode">Code</label>
          </div>
          <div class="input-field">
            <input type="text" id="categoryDescription">
            <label for="categoryDescription" class="active">Description</label>
          </div>
        </div>
      </div>
      <div class="modal-footer addCategoryActivity">
        <a href="#" id="addCategoryButton" onclick="addCategory()" class="modal-action waves-effect btn-flat">Add</a>
        <a href="#" class="modal-action modal-close waves-effect waves-red btn-flat">Close</a>
      </div>
    </div>
    <!-- .categoryActivity -->

    <!-- productsActivity -->
    <div class="activity col s12" id="productsActivity">

      <div class="navbar-fixed">
        <nav class="nav-extended blue-grey darken-2 z-depth-2">
          <div class="nav-wrapper">
            <a href="#" data-target="snav" class="show-on-large sidenav-trigger"><i class="material-icons">menu</i></a>
            <a class="title" href="#"><b>All Wet</b> Products</a>
            <div class="right">
              <a href="#" onclick="setProducts()"><i class="material-icons white-text">refresh</i></a>
            </div>
          </div>
          <div class="nav-content">
            <ul class="tabs tabs-transparent" id="categoryTabs"></ul>
          </div>
        </nav>
      </div>
      <!-- .navbar -->

      <div class="container">
        <br><br><br><br>
        <div class="cards-container">
          <div id="productsList"></div>
        </div>
        <br><br><br>
      </div>


      <div class="fixed-action-btn">
        <a id="btnAdd" class="btn-floating btn-large blue-grey darken-2 waves-effect waves-light btn-floating z-depth-3 modal-trigger" href="#" data-target="addProductModal">
          <i class="material-icons">add</i>
        </a>
      </div>
    </div>
    
    <div class="modal modal-fixed-footer" id="addProductModal">
      <div class="modal-content">
        <h5>
          Add a Product
        </h5><br>
        <div id="preloaderAddProduct">
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
        <div class="addProductActivity">
          <div class="input-field">
                <input type="text" id="productName">
                <label for="productName" class="active">Name</label>
              </div>
              <div class="input-field">
                <input type="text" id="productImage">
                <label for="productImage" class="active">Image URL (Relative to Home)</label>
              </div>
              <div class="input-field">
                <input type="text" id="productDescription">
                <label for="productDescription" class="active">Description</label>
              </div>
              <div class="input-field">
                <input type="text" id="productCode">
                <label for="productCode" class="active">Code</label>
              </div>
              <div class="input-field">
                <input type="text" id="productPrice">
                <label for="productPrice" class="active">Price (in Pesos)</label>
              </div>
              <div class="input-field">
                <select id="productAvailable">
                  <option value="True">Available</option>
                  <option value="False">Out of Stock</option>
                </select>
                <label>Availability</label>
              </div>
        </div>
      </div>
      <div class="modal-footer addProductActivity">
        <a href="#" id="addCategoryButton" onclick="addProduct()" class="modal-action waves-effect btn-flat">Add</a>
        <a href="#" class="modal-action modal-close waves-effect waves-red btn-flat">Close</a>
      </div>
    </div>
    <!-- .productsActivity -->

    <!-- editAccountActivity -->
    <div class="activity col s12" id="editAccountActivity">

      <!-- navbar -->
      <div class="navbar-fixed" id="navbar">
        <nav class="blue-grey darken-2 z-depth-2">
          <div class="nav-wrapper">
            <a href="#" data-target="snav" class="show-on-large sidenav-trigger"><i class="material-icons">menu</i></a>
            <a class="title" href="#"><b>All Wet</b> Employee</a>
          </div>
        </nav>
      </div>
      <!-- .navbar -->

      <div class="container">
        <h4 class="blue-grey-text text-darken-3">Edit Account</h4>
        <br>
        <div class="row">
          <div class="input-field col s12">
            <input type="text" id="nameField">
            <label for="name">Name</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s6">
            <input type="text" id="usernameField">
            <label for="username">Username</label>
          </div>
          <div class="input-field col s6">
            <input type="password" id="passwordField">
            <label for="password">Password</label>
          </div>
        </div>
        <br><br>
        <button class="btn btn-large blue-grey darken-2 waves-effect waves-light" onclick="editAccount()">Edit</button>
        <br><br><br><br><br>
      </div>
    </div>
    <!-- .editAccountActivity -->

  </body>

  </html>