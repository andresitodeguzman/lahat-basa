<!-- Meta tags -->
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<meta name="theme-color" content="#1565c0">

<link rel="manifest" href="manifest.json">

<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="application-name" content="All Wet">
<meta name="apple-mobile-web-app-title" content="All Wet">
<meta name="msapplication-navbutton-color" content="#1565c0">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="msapplication-starturl" content="/app">

<link rel="icon" type="image/png" sizes="72x72" href="/assets/imgs/icon-72x72.png">
<link rel="apple-touch-icon" type="image/png" sizes="72x72" href="/assets/imgs/icon-72x72.png">
<link rel="icon" type="image/png" sizes="96x96" href="/assets/imgs/icon-96x96.png">
<link rel="apple-touch-icon" type="image/png" sizes="96x96" href="/assets/imgs/icon-96x96.png">
<link rel="icon" type="image/png" sizes="128x128" href="/assets/imgs/icon-128x128.png">
<link rel="apple-touch-icon" type="image/png" sizes="128x128" href="/assets/imgs/icon-128x128.png">
<link rel="icon" type="image/png" sizes="144x144" href="/assets/imgs/icon-144x144.png">
<link rel="apple-touch-icon" type="image/png" sizes="144x144" href="/assets/imgs/icon-144x144.png">
<link rel="icon" type="image/png" sizes="152x152" href="/assets/imgs/icon-152x152.png">
<link rel="apple-touch-icon" type="image/png" sizes="152x152" href="/assets/imgs/icon-152x152.png">
<link rel="icon" type="image/png" sizes="192x192" href="/assets/imgs/icon-192x192.png">
<link rel="apple-touch-icon" type="image/png" sizes="192x192" href="/assets/imgs/icon-192x192.png">
<link rel="icon" type="image/png" sizes="384x384" href="/assets/imgs/icon-384x384.png">
<link rel="apple-touch-icon" type="image/png" sizes="384x384" href="/assets/imgs/icon-384x384.png">
<link rel="icon" type="image/png" sizes="512x512" href="/assets/imgs/icon-512x512.png">
<link rel="apple-touch-icon" type="image/png" sizes="512x512" href="/assets/imgs/icon-512x512.png">

<link rel="manifest" href="/manifest.json">

<script type="text/javascript">
'use strict';

if('serviceWorker' in navigator){
	navigator.serviceWorker.register('/serviceworker.js').then(reg=>{
		console.log('SW Log: Registration was Successful');
	}).catch(err=>{
		var error = err;
		console.log(`SW Log: [Error] ${error}`);
	});
} else {
	console.log(`SW Log: [Error] Feature Not Available on this Browser`);
}
</script>

<style>
     img[src*="https://cdn.rawgit.com/000webhost/logo/e9bd13f7/footer-powered-by-000webhost-white2.png"] {
       display: none !important;
      }
</style>

<!--Import Google Icon Font-->
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<!-- Compiled and minified CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-alpha.3/css/materialize.min.css">

<!--javascript -->
<script
  src="https://code.jquery.com/jquery-3.2.1.min.js"
  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
  crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-alpha.3/js/materialize.min.js"></script>

