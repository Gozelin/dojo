<?php
require_once('../src/defines.php');
require_once(PATH_SRC.'function.php');
require_once('./content/content.php');
require_once(PATH_CLASS.'DataBase.Class.php');
require_once(PATH_CLASS.'Discipline.Class.php');
require_once(PATH_CLASS.'Categorie.Class.php');

$dataBase = new cDataBase(DATABASE_HOST, DATABASE_ADMIN_LOG, DATABASE_ADMIN_PASSWORD, DATABASE_ADMIN_NAME);

$tabSelected["horaire"] = "tab-selected";

$noheader = 1;

?>

<html>
	<head>
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<link href="./librairies/light-box/css/lightbox.css" rel="stylesheet">
		<script src="js/jquery-3.1.1.min.js"></script>
		<script src="js/function.js"></script>
		<script src="./librairies/parallax.js"></script>
		<script src="./librairies/light-box/js/lightbox.js"></script>
	</head>
	<body>
		<div class="parallax-window" data-parallax="scroll" data-image-src="./images/site/background.png">
			<div id="content">
				<?php include("header.php"); ?>
				<h1 class="big-title border-title" ><?php echo HORAIRE; ?></h1>
				<div id="horaire-box">
					<a data-lightbox="horaire" href="./images/horaire/horaire0.jpg">
						<img data-lightbox="horaire" class="horaire-img" src="./images/horaire/horaire0.jpg">
					</a>
					<a data-lightbox="horaire" href="./images/horaire/horaire1.jpg">
						<img data-lightbox="horaire" class="horaire-img" src="./images/horaire/horaire1.jpg">
					</a>
				</div>
				<a id="horaire-return-link" href="home.php"><h2>Retour</h2></a>
				<?php include("footer.php"); ?>
			</div>
		</div>
	</body>
</html>

<script>
$(document).ready(function(){

	$("body").fadeIn();

	$('.parallax-window').parallax({imageSrc: "./images/site/background.png"});

    lightbox.option({
      'resizeDuration': 200,
      'wrapAround': true
    })
});
</script>