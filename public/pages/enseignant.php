<?php
require_once('../src/defines.php');
require_once(PATH_SRC.'function.php');
require_once('./content/content.php');
require_once(PATH_CLASS.'DataBase.Class.php');
require_once(PATH_CLASS.'Discipline.Class.php');
require_once(PATH_CLASS.'Categorie.Class.php');
require_once(PATH_CLASS.'Prof.Class.php');

$dataBase = new cDataBase(DATABASE_HOST, DATABASE_ADMIN_LOG, DATABASE_ADMIN_PASSWORD, DATABASE_ADMIN_NAME);

$tabSelected["prof"] = "tab-selected";

$profs = getAllProfs();

?>

<html>
	<head>
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<link href="./librairies/light-box/css/lightbox.css" rel="stylesheet">
		<script src="js/jquery-3.1.1.min.js"></script>
		<script src="js/function.js"></script>
		<script src="./librairies/parallax.js"></script>
	</head>
	<body>
		<div class="parallax-window" data-parallax="scroll" data-image-src="./images/site/background.png">
			<div id="content">
				<?php include("header.php"); ?>
				<h1 class="big-title" ><?php echo PROFS ?></h1>
				<div id="prof-container">
				<?php
				$boolReverse = false;
				foreach ($profs as $key => $prof) {
					if($boolReverse)
					{
						$reverse = "-reverse";
						$boolReverse = false;
					}
					else
					{
						$reverse = "";
						$boolReverse = true;
					}

					$id = $prof->getId();
					$name = $prof->getName();
					$name = $name." ".$prof->getSurname();
					$image = $prof->getImage();
					$desc = $prof->getDesc();
					$discs = getAllDiscs();

					$htmlDisc = "";

					foreach ($discs as $key => $disc) {
						$discProf = $disc->getProfs();
						foreach ($discProf as $key => $discProfId) {
							if($discProfId == $id)
							{
							$discId = $disc->getId();
							$discName = $disc->getName();
							$discImage = $disc->getImage();
							$htmlDisc .= "<div class='prof-disc-container'><div id=$discId class='prof-disc-img disc-box'>
									<img class='disc-img' src=./images/disciplines/$discImage[1]>
									<h1 class='disc-title'>$discName</h1>
								</div></div>";
							}
						}
					}

					echo 
					"<div id='prof-$id' class='skew-box$reverse'>
						<div class='prof-box$reverse click-box'>
							<div class='prof-onglet$reverse'>
								<img class='prof-img$reverse' src='./images/profs/$image[0]'>
								<h1 class='prof-name$reverse'>$name</h1>
							</div>
							<div id='Pcontent-$id' class='undisplayed Pcontent-closed Pcontent prof-content$reverse'>
								<div class='prof-desc'></div>
								<h2>Disciplines enseignées : </h2>
								<div class='prof-disc-container'>$htmlDisc</div>
							</div>
						</div>
					</div>";
				}
				?>
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

	$(document).on("click", ".click-box", function(){
		Pcontent = $(this).children(".Pcontent");
		toggleProfOnglet(Pcontent);
	});

	<?php 
		foreach ($profs as $key => $prof) {
			$id = $prof->getId();
			$desc = $prof->getDesc();
			$desc = htmlspecialchars_decode($desc);
			$desc = str_replace('"', "'", $desc);
			$desc = '"'.$desc.'"';
			echo "$('#Pcontent-$id').children('.prof-desc').append($desc); \n";
		}
	?>

	$(document).on({
	    mouseenter: function () {
	        $(this).children("img").addClass("prof-disc-img-effect");
	        $(this).children("h1").addClass("prof-disc-title-hovered");
	    },
	    mouseleave: function () {
	        $(this).children("img").removeClass("prof-disc-img-effect");
	        $(this).children("h1").removeClass("prof-disc-title-hovered");
	    }
	}, ".disc-box");

	$(document).on("click", ".disc-box", function(){
		id = $(this).attr("id");
		window.location.href = 'discipline.php?id='+id;
	});
});
</script>
