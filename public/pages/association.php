<?php
require_once('../src/defines.php');
require_once(PATH_P_SRC.'function.php');
require_once(PATH_CLASS.'Gallery.Class.php');
require_once('./content/content.php');
$dataBase = new cDataBase(DATABASE_HOST, DATABASE_ADMIN_LOG, DATABASE_ADMIN_PASSWORD, DATABASE_ADMIN_NAME);
$g = new cGallery(0);

$gHTML = $g->getDisplay();

function getAssocPrim() {
	global $dataBase;
	$query = "SELECT assoc_prim FROM site_content";
	$ret = $dataBase->query($query, FETCH_ASSOC);
	$ret = $dataBase->unprotect($ret["assoc_prim"], _STRING_);
	$ret = str_replace('"', "'", htmlspecialchars_decode($ret));
	return $ret;
}
?>

<html>
	<head>
		<link rel="stylesheet" type="text/css" href="css/style_test.css">
		<link rel="stylesheet" type="text/css" href="css/header_light.css">
		<link rel="stylesheet" type="text/css" href="../../interface/pages/css/shared.css">
		<link rel="stylesheet" type="text/css" href="css/association.css">
		<link rel='stylesheet' type='text/css' href='../../interface/pages/css/gallery.css'>
		<link rel='stylesheet' type='text/css' href='./librairies/light-box/css/lightbox.css'>
		<script src="js/jquery-3.1.1.min.js"></script>
		<script src='librairies/light-box/js/lightbox.js'></script>
		<script src="js/function.js"></script>
	</head>
	<body>
		<?php include("header.php"); ?>
		<div id="content">
			<div id="c-left">
				<?php echo getAssocPrim() ?>
			</div>
			<div id="c-right">
				<h3 class='c-right-title'>Découvrez le dojo en photo:</h3>
				<?php echo $gHTML; ?>
			</div>
		</div>
		<?php include("footer.php"); ?>
	</body>
</html>

<script>
lightbox.option({
	'resizeDuration': 200,
	'wrapAround': true,
	'fitImagesInViewport': true,
});
</script>