<?php
session_start();
include("../src/secure.php");
?>

<html>
	<head>
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<link rel="stylesheet" type="text/css" href="css/utility.css">
		<script src="../../public/pages/js/jquery-3.1.1.min.js"></script>
	</head>
	<body>
		<nav id="side-menu">
			<ul>
				<li id="deco-btn"><a href="../src/deconnect.php" text="Deconnexion">Deconnexion</a></li>
				<li class="menu-tab"><a href="content.php" text="">Contenu</a></li>
				<li class="menu-tab"><a href="blog.php" text="">Blog</a></li>
				<li class="menu-tab"><a href="utility.php" text="">Paramètres</a></li>
			</ul>
		</nav>
		<div id="interface-content">
			<h1 class="interface-content-title" >Paramètres du CMS</h1>
			<?php include("./utility/font-manager.php"); ?>
		</div>
	</body>
</html>