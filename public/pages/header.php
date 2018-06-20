<?php
$categs = getAllCategs();
?>

<div id="header">
	<div id="header-upper">
		<a>Contact</a>
		<a>Blog</a>
		<a href="horaire.php">Horaire</a>
	</div>
	<div id="nav-bar">
		<div id="banner-container"><a href="home.php"><img src="./images/site/banner.png" id="banner-img"></a></div>
		<?php echo "<div id='nav-container'>".get_header($categs)."</div>"; ?>
	</div>
</div>