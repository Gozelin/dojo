<?php
require_once('../src/defines.php');
require_once(PATH_SRC.'function.php');
require_once('./content/content.php');
require_once(PATH_CLASS.'DataBase.Class.php');
require_once(PATH_CLASS.'Discipline.Class.php');
require_once(PATH_CLASS.'Categorie.Class.php');

$dataBase = new cDataBase(DATABASE_HOST, DATABASE_ADMIN_LOG, DATABASE_ADMIN_PASSWORD, DATABASE_ADMIN_NAME);

$tabSelected["stages"] = "tab-selected";

?>

<html>
	<head>
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<link href="./librairies/light-box/css/lightbox.css" rel="stylesheet">
		<script src="js/jquery-3.1.1.min.js"></script>
		<script src="./librairies/parallax.js"></script>
		<script src="./librairies/light-box/js/lightbox.js"></script>
	</head>
	<body>
		<div class="parallax-window" data-parallax="scroll" data-image-src="./images/site/background.png">
			<div id="content">
				<?php include("header.php"); ?>
				<h1 class="big-title border-title" ><?php echo STAGES; ?></h1>
				<div class="background-dark-trans">
					<div id="post-item-container">
					</div>
					<div data-type="stage" id="more-post" class="more-post-btn home-more-post"><h2>Afficher plus</h2></div>
				</div>
				<?php include("footer.php"); ?>
			</div>
		</div>
	</body>
</html>

<script src="js/function.js"></script>
<script>

var limit = 0;

$(document).ready(function(){

	$("body").fadeIn();

	$('.parallax-window').parallax({imageSrc: "./images/site/background.png"});

	displayPost(limit, "stage");

    lightbox.option({
      'resizeDuration': 200,
      'wrapAround': true
    })

	window.setTimeout(function(){
    	$(window).resize();
	},100);
});
</script>