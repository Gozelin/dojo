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

<html>
	<head>
		<link href="//cdn.quilljs.com/1.3.2/quill.snow.css" rel="stylesheet">
		<link href="//cdn.quilljs.com/1.3.2/quill.bubble.css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<script src="../../public/pages/js/jquery-3.1.1.min.js"></script>
		<script src="../../public/pages/js/jscolor.js"></script>
		<script src="//cdn.quilljs.com/1.3.2/quill.js"></script>
		<script src="//cdn.quilljs.com/1.3.2/quill.min.js"></script>
	</head>
	<body>
		<nav id="side-menu">
			<ul>
				<li id="deco-btn" class="menu-tab"><a href="../src/deconnect.php" text="deconnect">Deconnexion</a></li>
				<li id="retour-btn" class="menu-tab"><a href="./interface.php" text="retour">Retour</a></li>
				<li id="post" class="menu-tab" >post</li>
			</ul>
		</nav>
		<div id="cache-container" class="undisplayed"></div>
		<div id="interface-content">
			<h1 id="content-title">Gestion du blog</h1>
			<div id="container">
			</div>
			<div data-no='' id='more-post' class='more-post-btn'><h2>Afficher plus</h2></div>
		</div>
		<!-- POST FORM -->
		<div id="post-form-box" class="form-popup undisplayed">
			<form id="post-form" method="POST" enctype="multipart/form-data"/>
				<input type="hidden" name="id">
				<input type="hidden" name="desc">
				<input type="hidden" name="descDelta">
				<input type="text" name="title" placeholder="titre"/>
				<label for="type1">Blog</label>
				<input id="type1" type="radio" name="type" value="blog" checked="checked">
				<label for="type2">Stage</label>
				<input id="type2" type="radio" name="type" value="stage">
				<!-- QUILL TOOLBAR -->
				<div id="toolbar-post">
					<select class="ql-size">
				    	<option value="15px">small</option>
				    	<option value="20px">normal</option>
				    	<option value="25px">big</option>
				    	<option value="30px">huge</option>
				  	</select>
				 	<select class="ql-font">
				  		<option selected value="Comfortaa">Comfortaa</option>
				  		<option value="Jura">Jura</option>
				  	</select>
				  	<button class="ql-bold"></button>
				  	<button class="ql-italic"></button>
				  	<button class="ql-underline"></button>
				  	<input readonly="true"  class="jscolor"></input>
					<select class="ql-color"></select>
				  	<button style="display:none" class="ql-color"></button>
				</div>
				<!-- FIN TOOLBAR -->
				<!-- QUILL EDITOR -->
				<div id="editor-post" class="editor"></div>
				<!-- FIN EDITOR -->
				<div class="file-input-container">
					<div id="more-image" class="image-btn"><h3 class="image-label">+</h3></div>
					<div class="hidden-input-box undisplayed">
					</div>
				</div>
				<input class="submit-btn" type="submit">
			</form>
			<div class="close-btn"><img src="../../public/pages/images/icon/cross.svg"></div>
		</div>
		<!-- FIN POST FORM -->
	</body>
</html>

<script src="./js/function.js"></script>
<script>
limit = 0;

$(document).ready(function(){

	activateTab("post");
	post_click();

	//text editor font
	var Font = Quill.import('formats/font');
	Font.whitelist = ['Comfortaa', 'Jura'];
	Quill.register(Font, true);

	//text editor size
	var SizeStyle = Quill.import('attributors/style/size');
	SizeStyle.whitelist = ['15px', '20px', '25px', '30px'];
	Quill.register(SizeStyle, true);

	//disc text editor
	quillPost = new Quill('#editor-post', {
		modules: {
			toolbar: '#toolbar-post'
		},
		theme: 'snow'
	 });

	$("#post").on("click", function(){
		activateTab("post");
		post_click();
	});

	$(document).on("click", "#more-post", function(){
		limit = limit+4;
		displayPost(limit, "");
	});

});
</script>

<?php
$_SESSION['tab-click'] = "undefined";
?>