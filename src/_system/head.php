<?php
/**
 * All Wet
 * 2018
 * 
 * Head
 */
if(@empty($theme_color_hex)) $theme_color_hex = "";
?>

<!-- Meta tags -->
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<meta name="theme-color" content="<?=$theme_color_hex?>">

<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="application-name" content="<?=$app_name?>">
<meta name="apple-mobile-web-app-title" content="<?=$app_name?>">
<meta name="msapplication-navbutton-color" content="<?=$theme_color_hex?>">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="msapplication-starturl" content="/app">

<link rel="icon" type="image/png" sizes="72x72" href="/assets/images/icon/icon-72x72.png">
<link rel="apple-touch-icon" type="image/png" sizes="72x72" href="/assets/images/icon/icon-72x72.png">
<link rel="icon" type="image/png" sizes="96x96" href="/assets/images/icon/icon-96x96.png">
<link rel="apple-touch-icon" type="image/png" sizes="96x96" href="/assets/images/icon/icon-96x96.png">
<link rel="icon" type="image/png" sizes="128x128" href="/assets/images/icon/icon-128x128.png">
<link rel="apple-touch-icon" type="image/png" sizes="128x128" href="/assets/images/icon/icon-128x128.png">
<link rel="icon" type="image/png" sizes="144x144" href="/assets/images/icon/icon-144x144.png">
<link rel="apple-touch-icon" type="image/png" sizes="144x144" href="/assets/images/icon/icon-144x144.png">
<link rel="icon" type="image/png" sizes="152x152" href="/assets/images/icon/icon-152x152.png">
<link rel="apple-touch-icon" type="image/png" sizes="152x152" href="/assets/images/icon/icon-152x152.png">
<link rel="icon" type="image/png" sizes="192x192" href="/assets/images/icon/icon-192x192.png">
<link rel="apple-touch-icon" type="image/png" sizes="192x192" href="/assets/images/icon/icon-192x192.png">
<link rel="icon" type="image/png" sizes="384x384" href="/assets/images/icon/icon-384x384.png">
<link rel="apple-touch-icon" type="image/png" sizes="384x384" href="/assets/images/icon/icon-384x384.png">
<link rel="icon" type="image/png" sizes="512x512" href="/assets/images/icon/icon-512x512.png">
<link rel="apple-touch-icon" type="image/png" sizes="512x512" href="/assets/images/icon/icon-512x512.png">

<link rel="manifest" href="/manifest.json">

<!-- User Safety Scripts -->
<script type="text/javascript">
	    console.warn(
        "%c\n\nAll Wet\n\n This feature is meant for developer's use only. If someone told you to access this tool, they might be able to gain access to your account and steal personal information.\n\n\n",
        "color: <?=$theme_color_hex?>; padding-left:2%; font-size: x-large; text-align:center"
        );
</script>

<!-- Service Worker -->
<script type="text/javascript">
/*'use strict';

if('serviceWorker' in navigator){
	navigator.serviceWorker.register('/serviceworker.js').then(reg=>{
		console.log('SW Log: Registration was Successful');
	}).catch(err=>{
		var error = err;
		console.log(`SW Log: [Error] ${error}`);
	});
} else {
	console.log(`SW Log: [Error] Feature Not Available on this Browser`);
}*/
</script>

<style>
     img[src*="https://cdn.rawgit.com/000webhost/logo/e9bd13f7/footer-powered-by-000webhost-white2.png"] {
       display: none !important;
      }
</style>

<!-- CSS -->
<link
    rel="stylesheet"
    href="/assets/fonts/iconfont/material-icons.css">
<link
    rel="stylesheet"
    href="/assets/materialize/css/materialize.min.css">
<link
    rel="stylesheet"
    href="/assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<style>
html {
  height: 100%;
}
body {
  overscroll-behavior-y: none !important;
  height: 100%;
}

.cards-container {
  column-break-inside: avoid;
}

.cards-container .card {
  display: inline-block;
  overflow: visible;
  width:100% !important;
}

@media only screen and (max-width: 600px) {
  .cards-container {
    -webkit-column-count: 1;
    -moz-column-count: 1;
    column-count: 1;
  }
}

@media only screen and (min-width: 601px) {
  .cards-container {
    -webkit-column-count: 2;
    -moz-column-count: 2;
    column-count: 2;
  }
}

@media only screen and (min-width: 993px) {
  .cards-container {
    -webkit-column-count: 3;
    -moz-column-count: 3;
    column-count: 3;
  }
}

.nav-wrapper{
  padding-right: 3%;
}        
.title {
  padding-left: 1%;
  font-size: 18pt;
}

.btn-block {
  width:100%;
}
</style>

<!-- Javascript -->
<script
    type="text/javascript"
    src="/assets/js/jquery-3.3.1.min.js">
</script>
<script
    type="text/javascript"
    src="/assets/materialize/js/materialize.min.js">
</script>