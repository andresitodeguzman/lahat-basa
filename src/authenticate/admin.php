<?php
require_once("../_system/config.php");
?>
<!Doctype html>
<html>
<head>
	<title>All Wet - Admin Sign-In</title>
	<?php require_once("../_system/head.php") ?>
</head>
<body class="blue-grey darken-3">	
	<div class="container">
		<br><br>
		<center>
			<h4 class="white-text"><b>All Wet</b> Admin</h4>
		</center>
		<br>
		<div class="card z-depth-4">
			<div class="card-content">
				<br>
				<div class="input-field">
					<input type="text" id="username">
					<label for="username">Username</label>
				</div>
				<div class="input-field">
					<input type="password" id="password">
					<label for="password">Password</label>
				</div>
			</div>
			<div class="card-action">
				<a href="#" onclick="signIn()" class="blue-grey-text text-darken-2">Sign-In</a>
			</div>
		</div><br><br><br><br><br>
	</div>
</body>
</html>