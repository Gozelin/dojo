<?php
require_once('../src/defines.php');
require_once(PATH_SRC.'function.php');
require_once(PATH_CLASS.'Prof.Class.php');
require_once('./content/content.php');

$dataBase = new cDataBase(DATABASE_HOST, DATABASE_ADMIN_LOG, DATABASE_ADMIN_PASSWORD, DATABASE_ADMIN_NAME);

$categ = new cCategorie($_GET["id"]);

$color = $categ->getColor();

$categName = $categ->getName();

$categId = $categ->getId();

$desc = $categ->getDesc();
$desc = htmlspecialchars_decode($desc);
$desc = str_replace('"', "'", $desc);

$tabSelected['disc'] = "tab-selected";

?>

<html>
	<head>
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<link rel="stylesheet" type="text/css" href="librairies/slick/slick.css">
		<link rel="stylesheet" type="text/css" href="librairies/slick/slick-theme.css">
		<script src="js/jquery-3.1.1.min.js"></script>
		<script src="js/function.js"></script>
		<script src="./librairies/parallax.js"></script>
		<script src="librairies/slick/slick.js"></script>
	</head>
	<body>
		<div class="parallax-window" data-parallax="scroll" data-image-src="./images/site/background.png">
			<?php include("header.php"); ?>
			<div id="content">
				<div style="background-color: white; display:flex; margin-top: 40px;">
					<div id="categ-desc">
						<h1 style="background-color: <?php echo $color ?>" class="big-title" ><?php echo $categName ?></h1>
					</div>
					<div id="categ-info"><?php echo getCategInfo($categ); ?></div> 
				</div>
				<h1 class="categ-disc-big-title" >Disciplines associées</h1>
				<div class="categ-boxu categ-disc-box">
				</div>
				<?php include("footer.php"); ?>
			</div>
		</div>
	</body>
</html>

<script>
$(document).ready(function(){

	$("body").fadeIn();

	$('.parallax-window').parallax({imageSrc: "./images/site/background.png"});

	$("#categ-desc").append("<?php echo $desc ?>");

	$(document).on({
	    mouseenter: function () {
	        $(this).children("img").addClass("disc-img-effect");
	        $(this).children("h1").addClass("disc-title-hovered");
	    },
	    mouseleave: function () {
	        $(this).children("img").removeClass("disc-img-effect");
	        $(this).children("h1").removeClass("disc-title-hovered");
	    }
	}, ".disc-box");

	$(document).on("click", ".disc-box", function(){
		id = $(this).attr("id");
		window.location.href = 'discipline.php?id='+id;
	});

});
	
</script>