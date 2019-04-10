<?php

require_once('../src/defines.php');
require_once(PATH_P_SRC.'function.php');
require_once(PATH_CLASS.'Prof.Class.php');
require_once(PATH_CLASS.'Video.Class.php');

$dataBase = new cDataBase(DATABASE_HOST, DATABASE_ADMIN_LOG, DATABASE_ADMIN_PASSWORD, DATABASE_ADMIN_NAME);

if (isset($_GET["disc"])) {
	$d = new cDiscipline($_GET["disc"]);
} else {
	exit();
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
		<?php
			include("header.php"); 
			echo $d->getVideoGallery();
			include("footer.php");
		?>
	</body>
</html>

