<?php
if (!isset($noheader))
	$categs = getAllCategs();
?>

<div id="header">
	<div id="header-upper">
		<a href="contact.php">Contact</a>
		<a href="horaire.php">Horaire</a>
	</div>
	<div id="nav-bar">
		<div id="banner-container"><a href="home.php"><img src="./images/site/banner.png" id="banner-img"></a></div>
		<?php if (!isset($noheader)) echo "<div id='nav-container'>".get_header($categs)."</div>"; ?>
	</div>
</div>