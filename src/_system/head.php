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
<link
  rel="stylesheet"
  href="/assets/material-refresh/css/material-refresh.min.css">
<link
  rel="stylesheet"
  href="/assets/css/customstyle.css">

<!-- Javascript -->
<script
    type="text/javascript"
    src="/assets/js/jquery-3.3.1.min.js">
</script>
<script
    type="text/javascript"
    src="/assets/materialize/js/materialize.min.js">
</script>
<script
    type="text/javascript"
    src="/assets/material-refresh/js/material-refresh.min.js">
</script>
<script>
/*
    splash
    Splashscreen handler
 */
function splash(param){
    var time = param;
    setTimeout(function(){
        $("#splashscreen").fadeOut();
    },time);
}
</script>