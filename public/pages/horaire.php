<?php
require_once('../src/defines.php');
require_once(PATH_P_SRC.'function.php');
require_once('./content/content.php');
$dataBase = new cDataBase(DATABASE_HOST, DATABASE_ADMIN_LOG, DATABASE_ADMIN_PASSWORD, DATABASE_ADMIN_NAME);
?>

<html>
	<head>
		<link rel="stylesheet" type="text/css" href="css/style_test.css">
		<link rel="stylesheet" type="text/css" href="css/horaire.css">
		<link rel="stylesheet" type="text/css" href="css/header_light.css">
		<script src="js/jquery-3.1.1.min.js"></script>
		<script src="js/function.js"></script>
		</head>
	<body>
		<?php include("header.php"); ?>
		<div id="content">
			<div id="horaireWrapper">
				<a class="link-img" href="./images/horaire/horaire0.jpg">
					<img class="horaire-img" src="./images/horaire/horaire0.jpg">
				</a>
				<a class="link-img" href="./images/horaire/horaire1.jpg">
					<img class="horaire-img" src="./images/horaire/horaire1.jpg">
				</a>
			</div>
			<div class="up-btn"><h3>Remonter</h3></div>
		</div>
		<?php include("footer.php"); ?>
	</body>
</html>

<script>
$(".up-btn").on("click", function(){
	$('html, body').animate({ scrollTop: 0 }, 'fast');
});
</script>