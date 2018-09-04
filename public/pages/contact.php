<?php
require_once('../src/defines.php');
require_once(PATH_SRC.'function.php');
require_once('./content/content.php');
$dataBase = new cDataBase(DATABASE_HOST, DATABASE_ADMIN_LOG, DATABASE_ADMIN_PASSWORD, DATABASE_ADMIN_NAME);
?>

<html>
	<head>
		<link rel="stylesheet" type="text/css" href="css/style_test.css">
		<link rel="stylesheet" type="text/css" href="css/contact.css">
		<link rel="stylesheet" type="text/css" href="css/header_light.css">
		<script src="js/jquery-3.1.1.min.js"></script>
		<script src="js/function.js"></script>
	</head>
	<body>
		<?php include("header.php"); ?>
		<div id="content">
			<div id="map"><div class="gmap_canvas"><iframe width="100%" height="100%" id="gmap_canvas" src="https://maps.google.com/maps?q=69%20Rue%20Audibert%20et%20Lavirotte%2C%2069008%20&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe><a href="https://www.crocothemes.net"></a></div><style>.mapouter{text-align:right;height:563px;width:780px;}.gmap_canvas {overflow:hidden;background:none!important;height:563px;width:780px;}</style></div>
			<div id="contact-info">
				<div style="margin: auto">
					<img src="./images/icon/mail.svg" height="40px" width="40px">
					<h2><?php echo MAIL ?></h2>
					<img class="contact-icon" src="./images/icon/phone.svg" height="40px" width="40px">
					<a style="margin-bottom: 15px" href="tel:<?php echo TEL0?>"><h2><?php echo TEL0 ?></h2></a>
					<a href="tel:<?php echo TEL1?>"><h2><?php echo TEL1 ?></h2></a>
					<img class="contact-icon" src="./images/icon/placeholder.svg" height="40px" width="40px">
					<h2><?php echo ADRESSE ?></h2>
				</div>
			</div>
		</div>
		<?php include("footer.php"); ?>
	</body>
</html>

<script>

$(document).ready(function(){

	$("#banner").append("<div id='page-title'><h1>CONTACT</h1></div>");

	console.log($("#map").height());

	$(".gmap_canvas").css("height", $("#map").height());
});


</script>