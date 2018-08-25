<?php

?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<script src="../../public/pages/js/jquery-3.1.1.min.js"></script>
	</head>
	<body>
		<div id="login-box">
			<form id="login-form" action="../src/auth.php" method="POST">
				Login
				<input class="input-style" type="text" name="login">
				Mot de passe
				<input class="input-style" type="password" name="password">
				<input class="login-btn" type="submit" value="LOGIN">
			</form>
		</div>
	</body>
</html>