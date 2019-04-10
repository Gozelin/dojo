<?php
require_once('../src/defines.php');
require_once(PATH_P_SRC.'function.php');
require_once(PATH_CLASS.'Prof.Class.php');
require_once(PATH_CLASS.'Video.Class.php');
require_once('./content/content.php');

$dataBase = new cDataBase(DATABASE_HOST, DATABASE_ADMIN_LOG, DATABASE_ADMIN_PASSWORD, DATABASE_ADMIN_NAME);
if (isset($_GET["id"]))
	$id = $_GET["id"];
$d = new cDiscipline($id);
$name = $d->getName();
$desc = $d->getDesc();
$horaire = $d->getHoraire();
$desc = htmlspecialchars_decode($desc);
$desc = str_replace('"', "'", $desc);
$horaire = htmlspecialchars_decode($horaire);
$horaire = str_replace('"', "'", $horaire);
$p = [];
foreach($d->getProfs() as $pId) {
	$p[] = new cProf($pId);
}
?>

<html>
	<head>
		<link rel="stylesheet" type="text/css" href="./css/style_test.css">
		<link rel="stylesheet" type="text/css" href="./css/header_light.css">
		<link rel="stylesheet" type="text/css" href="./css/discipline.css">
		<link rel="stylesheet" type="text/css" href="../../interface/pages/css/shared.css">
		<script src="js/jquery-3.1.1.min.js"></script>
		<script src="js/function.js"></script>
	</head>
	<body>
		<?php include("header.php"); ?>
		<div id="content">
			<div id="c-left">
				<img id='disc-title' src="/dojo/public/pages/images/discipline/<?php echo $d->getImage() ?>">
				<div id="desc"><?php echo $desc ?></div>
				<div id="desc-expand-btn"><h3>Lire la suite</h3></div>
			</div>
			<div id="c-right">
				<?php echo $d->getFrontVideo(); ?>
				<div id="c-video">
					<a href="./video.php?disc=<?php echo $id ?>"><img src="../pages/images/icon/video.png" height="40px" width="40px"></a>
					<h1>Voir toutes les vidéos</h1>
				</div>
				<div id="c-horaire">
					<h1>Horaires des cours</h1>
					<div id="horaireWrapper"><?php echo $horaire; ?></div>
				</div>
				<div id="c-prof">
					<h1>Professeurs</h1>
					<?php echo getProfHTML($p); ?>
				</div>
			</div>
		</div>
		<?php include("footer.php"); ?>
	</body>
</html>

<script>

$(document).ready(function(){

	var sTab = $("#d-<?php echo $id; ?>");sTab

	sTab.addClass("second-tab-active");
	sTab.parent().prev(".primary-tab").trigger("mouseover");
	$(document).on("mouseleave", "#nav-bar", function(){
		sTab.parent().prev(".primary-tab").trigger("mouseover");
	});

	$(document).on("mouseleave", "#tab-display", function(){
		sTab.addClass("second-tab-active");
	});

	$(document).on("mouseenter", ".disc-link", function(){
		$(".disc-link").removeClass("second-tab-active");
	});

	var size = 0;
	$("#desc").children().each(function() {
		size += $(this).height();
	});
	if ($("#desc").height() < size ) {
		$(document).on("click", "#desc-expand-btn", function(){
		if ($("#desc").css("max-height") == "100px") {
			$("#desc-expand-btn h3").text("Réduire");
			$("#desc").css("max-height", "2000px");
		} else {
			$("#desc-expand-btn h3").text("Lire la suite");
			$("#desc").css("max-height", "100px");
		}
	});
	}
	else {
		$("#desc-expand-btn").remove();
		$("#desc").css("overflow", "auto");
		$("#desc").css("max-height", "none");
	}

});
</script>