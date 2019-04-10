<?php

require_once('../src/defines.php');
require_once(PATH_P_SRC.'function.php');
require_once(PATH_CLASS.'Salle.Class.php');
require_once(PATH_CLASS.'Gallery.Class.php');

$dataBase = new cDataBase(DATABASE_HOST, DATABASE_ADMIN_LOG, DATABASE_ADMIN_PASSWORD, DATABASE_ADMIN_NAME);

$salle = getSalleOrdered();

?>

<html>
	<head>
		<link rel="stylesheet" type="text/css" href="./css/style_test.css">
		<link rel="stylesheet" type="text/css" href="./css/header_light.css">
		<link rel="stylesheet" type="text/css" href="./css/discipline.css">
		<link rel="stylesheet" type="text/css" href="./css/location.css">
		<link rel="stylesheet" type="text/css" href="../../interface/pages/css/shared.css">
		<link rel='stylesheet' type='text/css' href='../../interface/pages/css/gallery.css'>
		<link rel='stylesheet' type='text/css' href='./librairies/light-box/css/lightbox.css'>
		<script src="js/jquery-3.1.1.min.js"></script>
		<script src='librairies/light-box/js/lightbox.js'></script>
		<script src="js/function.js"></script>
	</head>
	<body>
			<?php
				include("header.php");
				echo "<div id='location-container'>";
				$color = "#b6cfe8";
				if (is_array($salle)) {
					foreach ($salle as $key => $s) {
						echo $s->getFront("rgba(182, 207, 232, 0.5)");
					}
				}
				echo "</div>";
				include("footer.php");
				?>
			</div>
	</body>
</html>

<script>
	$(document).ready(() => {
		$(".pic-link").on("click", (param) => {
			let el = param.currentTarget;
			el = $(el).parent().siblings(".g-displayWrapper").children().first();
			console.log(el);
			$(el).trigger("click");
		})
	})
</script>