<?php

session_start();

include("../src/secure.php");

require_once('../../public/src/defines.php');
require_once('../../public/src/function.php');
require_once(PATH_CLASS."DataBase.Class.php");
require_once(PATH_CLASS."Categorie.Class.php");
require_once(PATH_CLASS."Prof.Class.php");

$dataBase = new cDataBase(DATABASE_HOST, DATABASE_ADMIN_LOG, DATABASE_ADMIN_PASSWORD, DATABASE_ADMIN_NAME);

?>

<script src="../../public/pages/js/jquery-3.1.1.min.js"></script>
<script src="./js/function.js"></script>
<script src="./js/jquery-ui.min.js"></script>
<script src="../../public/pages/js/jscolor.js"></script>
<script src="./js/form.js"></script>
<script src="//cdn.quilljs.com/1.3.2/quill.min.js"></script>
<script src="./js/video.js"></script>
<script src="https://vjs.zencdn.net/7.3.0/video.js"></script>
<script>

var aQuill;

$(document).ready(function(){

	/*
	QUILL
	*/
	//text editor font
	var Font = Quill.import('formats/font');
	Font.whitelist = JSON.parse('<?php echo getFontJson(); ?>');
	Quill.register(Font, true);

	//text editor size
	var SizeStyle = Quill.import('attributors/style/size');
	SizeStyle.whitelist = ['15px', '20px', '25px', '30px'];
	Quill.register(SizeStyle, true);

	aQuill = [];

	setNavTab();

	//categ radio change
	$(document).on("change", ".radio-categ", function(){
		$(".label-radio-categ").removeClass("label-radio-categ-activ");
		$(this).prev(".label-radio-categ").addClass("label-radio-categ-activ");
	});

	//prof radio change
	$(document).on("click", ".prof-label", function(){
		if($(this).hasClass("prof-label-activ")) {
			$(this).removeClass("prof-label-activ");
		}
		else {
			$(this).addClass("prof-label-activ");
		}
	});

	$(document).on("click", ".linkSuprrBtn", function(){
		$(this).next("input").val("");
		$(this).parent(".linkInputWrapper").remove();
	});
});
</script>

<html>
	<head>
		<link href="//cdn.quilljs.com/1.3.2/quill.snow.css" rel="stylesheet">
		<link href="//cdn.quilljs.com/1.3.2/quill.bubble.css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<link rel="stylesheet" type="text/css" href="css/shared.css">
		<link rel="stylesheet" type="text/css" href="css/jquery-ui.css">
		<link rel="stylesheet" type="text/css" href="css/gallery.css">
		<link href="https://vjs.zencdn.net/7.3.0/video-js.css" rel="stylesheet">
	</head>
	<body>
		<?php include("sideMenu.php"); ?>
		<div id="cache-container" class="undisplayed"></div>
		<div id="interface-content">
		<img class='loading-gif' src="../../public/pages/images/site/ajax-loader.gif">
		<h1 id="content-title"></h1>
		<div id="container"></div>
		</div>
	</body>
</html>