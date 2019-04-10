<?php
require_once('../src/defines.php');
require_once(PATH_P_SRC.'function.php');
require_once('./content/content.php');
$dataBase = new cDataBase(DATABASE_HOST, DATABASE_ADMIN_LOG, DATABASE_ADMIN_PASSWORD, DATABASE_ADMIN_NAME);
?>

<html>
	<head>
		<link rel="stylesheet" type="text/css" href="css/style_test.css">
		<link rel="stylesheet" type="text/css" href="css/contact.css">
		<link rel="stylesheet" type="text/css" href="css/header_light.css">
		<script src="js/jquery-3.1.1.min.js"></script>
		<script src="js/function.js"></script>
	</head>
	<body>
		<?php include("header.php"); ?>
		<div id="content">
			<div id="left-frame" class="contact-info">
				<div class="left-wrapper">
					<div class="info-wrapper">
						<img src="./images/icon/mail.svg" height="40px" width="40px">
						<a href="mailto:"<?php echo MAIL ?>><h2><?php echo MAIL ?></h2></a>
					</div>
					<div class="info-wrapper">
						<img class="contact-icon" src="./images/icon/phone.svg" height="40px" width="40px">
						<div style="display: flex; flex-direction: column;">
							<a style="margin-bottom: 15px" href="tel:<?php echo TEL0?>"><h2><?php echo TEL0 ?></h2></a>
							<a href="tel:<?php echo TEL1?>"><h2><?php echo TEL1 ?></h2></a>
						</div>
					</div>
					<div class="info-wrapper">
						<img class="contact-icon" src="./images/icon/placeholder.svg" height="40px" width="40px">
						<h2><?php echo ADRESSE ?></h2>
					</div>
				</div>
				<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2784.7685089442944!2d4.85481811589086!3d45.73573707910503!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47f4ea37ba52cbd9%3A0xfbf4f833d64c5a17!2sDojo+Yoseikan+Budo!5e0!3m2!1sfr!2sfr!4v1540050532002" width="100%" height="60%" frameborder="0" style="border:0" allowfullscreen></iframe>
			</div>
			<div id="right-frame">
				<div id="form-wrapper">
					<h3 style="margin-bottom: 20px;color: #043465;">CONTACTEZ-NOUS:</h3>
					<form action="../../interface/pages/utility/mail-manager.php" method="POST">
						<input type="hidden" name="action" value="insert">
						<div class="input-wrapper">
							<label for=name>Nom:</label>
							<input required type="text" name="name">
						</div>
						<div class="input-wrapper">
							<label for=usermail>Adresse mail:</label>
							<input required type="text" name="usermail">
						</div>
						<div class="input-wrapper">
							<label for=object>Objet:</label>
							<input required type="text" name="object">
						</div>
						<div class="input-wrapper" style="margin-bottom: 0px!important">
							<label for=mail>Message:</label>
							<textarea required rows="15" maxlength="512" name="mail"></textarea>
						</div>
						<div class="input-wrapper submit-btn">
							<input type="submit" value="Envoyer">
						</div>
					</form>
				</div>
			</div>
		</div>
		<?php include("footer.php"); ?>
	</body>
</html>

<script>

$(document).ready(function(){

	$("#form-wrapper form").submit(function(e){
		usermail = $("input[name='usermail']");
		if (!validateEmail($(usermail).val())) {
			$(usermail).css("background-color", "red");
			e.preventDefault();
		}
	});

	$("input[name='usermail']").on("change", function(){
		if (validateEmail($(this).val()))
			$(this).css("background-color", "white");
	});

});

</script>