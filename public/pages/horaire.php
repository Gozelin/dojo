<?php
require_once('../src/defines.php');
require_once(PATH_SRC.'function.php');
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
		</div>
		<?php include("footer.php"); ?>
	</body>
</html>

<script>
$(document).ready(function(){
	$("#banner").append("<div id='page-title'><h1>HORAIRES/TARIFS</h1></div>");
});
</script>