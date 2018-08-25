<?php

session_start();

include("../src/secure.php");

require_once('../../public/src/defines.php');
require_once('../../public/src/function.php');
require_once(PATH_CLASS."DataBase.Class.php");
require_once(PATH_CLASS."Categorie.Class.php");
require_once(PATH_CLASS."Prof.Class.php");

$dataBase = new cDataBase(DATABASE_HOST, DATABASE_ADMIN_LOG, DATABASE_ADMIN_PASSWORD, DATABASE_ADMIN_NAME);

$categs = getAllCategs();
$profs = getAllProfs();

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
				<li id="retour-btn" class="menu-tab"><a href="./interface.php" text="retour">Retour</a></li>
				<li id="deco-btn" class="menu-tab"><a href="../src/deconnect.php" text="deconnect">Deconnexion</a></li>
				<li id="home" class="menu-tab" >Accueil</li>
				<li id="horaire" class="menu-tab" >Horaire</li>
				<li id="categ" class="menu-tab" >Sections</li>
				<li id="disc" class="menu-tab" >Disciplines</li>
				<li id="prof" class="menu-tab" >Profs</li>
			</ul>
		</nav>
		<div id="cache-container" class="undisplayed"></div>
		<div id="interface-content">
			<h1 id="content-title"></h1>
			<div id="container"></div>
		</div>
		<!-- HOME FORM -->
		<div id="home-form-box" class="form-popup undisplayed">
			<form id="home-form" method="POST" enctype="multipart/form-data"/>
				<input type="hidden" name="desc">
				<input type="hidden" name="descDelta">
				<!-- <input type="text" name="title" placeholder="Titre"/> -->
				<?php echo getQuill("home"); ?>
				<input class="submit-btn" type="submit">
				<!-- <input class="previ-btn" type="submit" value="Previsualiser"> -->
			</form>
		</div>
		<!-- DISC FORM -->
		<div id="disc-form-box" class="form-popup undisplayed">
			<form id="disc-form" method="POST" enctype="multipart/form-data"/>
				<input type="hidden" name="id">
				<input type="hidden" name="desc">
				<input type="hidden" name="descDelta">
				<input type="text" name="title" placeholder="Intitulé"/>
				<?php echo getQuill("disc"); ?>
				<div id="link-input-container">
				</div>
				<div class="info-input-container">
					<?php
						//AJOUTE UN RADIO POUR CHAQUE CATEG
						echo "<div class='categ-input-box'>";
						echo "<h3>Sections</h3>";
						foreach ($categs as $key => $categ) {
							$id = $categ->getId();
							$name = $categ->getName();
							echo "<label for=radio$id class='label-radio-categ'>$name</label>";
							echo "<input id=radio$id class='undisplayed radio-categ' type='radio' name='categ' value=$id>"	;
						}
						echo "</div>";
					?>
					<div class="prof-input-box">
						<?php
						//AJOUTE UNE CHKBOX POUR CHAQUE PROF
							echo "<h3>Profs</h3>";
							echo "<div class='prof-slider' >";
							if ($profs) { 
								foreach ($profs as $key => $prof) {
									$id = $prof->getId();
									$name = $prof->getName();
									$surname = $prof->getSurname();
									echo "<label class='prof-label' for='$id-prof'>$name $surname</label>";
									echo "<input class='prof-chkbox' value=$id type='checkbox' id='$id-prof' name='profs[]'>";
									}
								}
							 echo "</div>";
						?>
					</div>
				</div>
				<div class="file-input-container">
					<div class="file-input-box">
						<h3>image slider (1650x1000)</h3>
						<label for="disc-image-slider" class="label-file">Choisir une image</label>
						<input id="disc-image-slider" class="input-file" type="file" name="image[]"/>
						<div class="image-preview"><img height="200px" width="200px" src=""></div>
					</div>
					<div class="file-input-box">
						<h3>image page (450x450)</h3>
						<label for="disc-image-page" class="label-file">Choisir une image</label>
						<input id="disc-image-page" class="input-file" type="file" name="image[]"/>
						<div class="image-preview"><img height="200px" width="200px" src=""></div>
					</div>
				</div>
				<input class="submit-btn" type="submit">
			</form>
			<div class="close-btn"><img src="../../public/pages/images/icon/cross.svg"></div>
		</div>
		<!-- FIN DISC FORM -->
		<!-- HORAIRE FORM -->
		<div id="horaire-form-box" class="form-popup undisplayed">
			<form id="horaire-form" method="POST" enctype="multipart/form-data"/>
				<h2>horaire 1</h2>
				<div class="file-input-box">
					<label for="horaire-image1" class="label-file">Choisir une image</label>
					<input id="horaire-image1" class="input-file" type="file" name="horaire[]"/>
					<div class="image-preview"><img width="200px" height="200px" src="../../public/pages/images/horaire/horaire0.jpg"></div>
				</div>
				<h2>horaire 2</h2>
				<div class="file-input-box">
					<label for="horaire-image2" class="label-file">Choisir une image</label>
					<input id="horaire-image2" class="input-file" type="file" name="horaire[]"/>
					<div class="image-preview"><img width="200px" height="200px" src="../../public/pages/images/horaire/horaire1.jpg"></div>
				</div>
				<input class="submit-btn" type="submit">
			</form>
		</div>
		<!-- FIN HORAIRE FORM -->
		<!-- CATEG FORM -->
		<div id="categ-form-box" class="form-popup undisplayed">
			<form id="categ-form" method="POST" enctype="multipart/form-data"/>
				<input type="hidden" name="id">
				<input type="hidden" name="desc">
				<input type="hidden" name="descDelta">
				<input type="text" name="title" placeholder="Intitulé"/>
				<?php echo getQuill("categ"); ?>
				<div class="file-input-box">
					<h3>image home</h3>
					<label for="categ-image-slider" class="label-file">Choisir une image</label>
					<input id="categ-image-slider" class="input-file" type="file" name="image"/>
					<div class="image-preview"><img height="200px" width="200px" src=""></div>
				</div>
				<input class="submit-btn" type="submit">
			</form>
			<div class="close-btn"><img src="../../public/pages/images/icon/cross.svg"></div>
		</div>
		<!-- PROF FORM -->
		<div id="prof-form-box" class="form-popup undisplayed">
			<form id="prof-form" method="POST" enctype="multipart/form-data"/>
				<input type="hidden" name="id">
				<input type="hidden" name="desc">
				<input type="hidden" name="descDelta">
				<input type="text" name="name" placeholder="prénom"/>
				<input type="text" name="surname" placeholder="nom"/>
				<?php echo getQuill("prof"); ?>
				<div class="file-input-box">
					<label for="prof-image" class="label-file">Choisir une image</label>
					<input id="prof-image" class="input-file" type="file" name="image[]"/>
					<div class="image-preview"><img width="200px" height="200px" src=""></div>
				</div>
				<input class="submit-btn" type="submit">
			</form>
			<div class="close-btn"><img src="../../public/pages/images/icon/cross.svg"></div>
		</div>
		<!-- FIN PROF -->
	</body>
</html>

<script src="./js/function.js"></script>
<script>

var aQuill;

$(document).ready(function(){

	//text editor font
	var Font = Quill.import('formats/font');
	Font.whitelist = ['Comfortaa', 'Jura'];
	Quill.register(Font, true);

	//text editor size
	var SizeStyle = Quill.import('attributors/style/size');
	SizeStyle.whitelist = ['15px', '20px', '25px', '30px'];
	Quill.register(SizeStyle, true);

	aQuill = ["home", "disc", "categ", "prof"];

	aQuill.forEach(function(ar) {
		console.log('#editor-'+ar);
		aQuill[ar] = new Quill('#editor-'+ar, {
		modules: {
			toolbar: '#toolbar-'+ar
		},
		theme: 'snow'
	 });
	});

	//categ radio change
	$(document).on("change", ".radio-categ", function(){
		$(".label-radio-categ").removeClass("label-radio-categ-activ");
		$(this).prev(".label-radio-categ").addClass("label-radio-categ-activ");
	});

	//prof radio change
	$(document).on("click", ".prof-label", function(){
		if($(this).hasClass("prof-label-activ"))
		{
			$(this).removeClass("prof-label-activ");
		}
		else
		{
			$(this).addClass("prof-label-activ");
		}
	});

	//active le tab si click
	$(".menu-tab").not("#retour-btn").on("click", function(){
		tabId = $(this).attr("id");
		activateTab(tabId);
	});

	//SIDE MENU BUTTONS
	$("#home").on("click", function(){
		home_click();
	});

	$("#disc").on("click", function(){
		disc_click();
	});

	$("#horaire").on("click", function(){
		horaire_click();
	});

	$("#categ").on("click", function(){
		categ_click();
	});

	$("#prof").on("click", function(){
		prof_click();
	});

	$(".previ-btn").on("click", function() {
		$("#home-form").attr("action", "../../public/pages/home.php");
	});

});
</script>

<?php
$_SESSION['tab-click'] = "undefined";
?>