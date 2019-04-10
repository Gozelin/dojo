<?php
require_once('../src/defines.php');
require_once(PATH_P_SRC.'function.php');
require_once('./content/content.php');

$dataBase = new cDataBase(DATABASE_HOST, DATABASE_ADMIN_LOG, DATABASE_ADMIN_PASSWORD, DATABASE_ADMIN_NAME);
?>

<html>
	<head>
		<link rel="stylesheet" type="text/css" href="css/style_test.css">
		<script src="js/jquery-3.1.1.min.js"></script>
		<script src="js/function.js"></script>
	</head>
	<body>
		<?php include("header.php"); ?>
		<div id="homeContent">
			<?php
				echo getAdress();
				echo getAccroche();
			?>
			<div id="plan-btn" class="small-btn"><a href="./contact.php"><h3>Voir le plan</h3></a></div>
		</div>
	</body>
</html>

<script>
$(document).ready(function(){
	$("#banner").removeClass("undisplayed");
});
</script>