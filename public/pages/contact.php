<?php
require_once('../src/defines.php');
require_once(PATH_SRC.'function.php');
require_once('./content/content.php');
$noheader = 1;
?>

<html>
	<head>
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<link href="./librairies/light-box/css/lightbox.css" rel="stylesheet">
		<script src="js/jquery-3.1.1.min.js"></script>
		<script src="./librairies/parallax.js"></script>
        <script src="js/function.js"></script>
	</head>
	<body>
		<div class="parallax-window" data-parallax="scroll" data-image-src="./images/site/background.png">
			<div id="content">
				<?php include("header.php"); ?>
                <h1 class="big-title border-title" >CONTACT</h1>
                <div id="contact-content">
                    <div id="map" class="mapouter"><div class="gmap_canvas"><iframe width="780" height="563" id="gmap_canvas" src="https://maps.google.com/maps?q=69%20Rue%20Audibert%20et%20Lavirotte%2C%2069008%20&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe><a href="https://www.crocothemes.net"></a></div><style>.mapouter{text-align:right;height:563px;width:780px;}.gmap_canvas {overflow:hidden;background:none!important;height:563px;width:780px;}</style></div>
                    <div id="contact-info">
                        <div style="padding: 20px; margin: auto">
                            <img src="./images/icon/mail.svg" height="40px" width="40px">
                            <h2><?php echo MAIL ?></h2>
                            <img class="contact-icon" src="./images/icon/phone.svg" height="40px" width="40px">
                            <h2 style="margin-top: 20px"><?php echo TEL ?></h2>
                            <img class="contact-icon" src="./images/icon/placeholder.svg" height="40px" width="40px">
                            <h2 style="margin-top: 20px"><?php echo ADRESSE ?></h2>
                        </div>
                    </div> 
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
});


</script>