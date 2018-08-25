<?php
require_once('../src/defines.php');
require_once(PATH_SRC.'function.php');
require_once('./content/content.php');

$dataBase = new cDataBase(DATABASE_HOST, DATABASE_ADMIN_LOG, DATABASE_ADMIN_PASSWORD, DATABASE_ADMIN_NAME);

$tabSelected['home'] = "tab-selected";

$disciplines = getAllDiscs();
$home = new cHome();

if (isset($_POST["desc"])) {
	include("../../interface/src/secure.php");
	$desc = $_POST["desc"];
}

$desc = $home->getDesc();
$desc = htmlspecialchars_decode($desc);
$desc = str_replace('"', "'", $desc);

?>

<html>
	<head>
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<link rel="stylesheet" type="text/css" href="librairies/slick/slick.css">
		<link rel="stylesheet" type="text/css" href="librairies/slick/slick-theme.css">
		<link href="./librairies/light-box/css/lightbox.css" rel="stylesheet">
		<script src="js/jquery-3.1.1.min.js"></script>
		<script src="librairies/slick/slick.js"></script>
		<script src="./librairies/light-box/js/lightbox.js"></script>
	</head>
	<body>
		<div class="parallax">
			<div class="content">
				<?php include("header.php");?>
			</div>
		</div>
		<div class="parallax" style="background-image: url('./images/site/background.png')">
			<div class="content">
				<div id="home-desc"><?php echo $desc;?></div>
				<?php echo getHomeCateg(); ?>
				<?php include("footer.php"); ?>
			</div>
		</div>
	</body>
</html>
<script>

var limit = 0;

$(document).ready(function(){

	$("body").fadeIn();

	displayPost(limit, "");

	$('.fade').slick({
   		autoplay: true,
 		autoplaySpeed: 2500,
 		dots: true,
 		infinite: true,
 		speed: 500,
 		fade: true,
 		cssEase: 'linear'
	});

    lightbox.option({
      'resizeDuration': 200,
      'wrapAround': true
    })


	$(document).on("click", ".slide", function(){
		id = $(this).attr("id");
		window.location.href = 'discipline.php?id='+id;
	});

	window.setTimeout(function(){
    	$(window).resize();
	},100);

});
</script>

<script src="js/function.js"></script>
