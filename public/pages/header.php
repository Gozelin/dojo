<?php
if (!isset($noheader))
	$categs = getAllCategs();
?>

<div id="header">
	<div id="social-bar">
		<a href="https://www.facebook.com/Dojo-Yoseikan-Budo-338728042878806/"><img src="images/icon/fb.svg" width="50" height="50"></a>
		<a href="https://www.youtube.com/user/GILLESMORARD"><img src="images/icon/yt.svg" width="50" height="50"></a>
	</div>
	<div id="nav-bar">
		<div id="banner-container"><a href="home.php"><img src="./images/site/banner.png" id="banner-img"></a></div>
		<?php if (!isset($noheader)) echo "<div id='nav-container'>".get_header($categs)."</div>"; ?>
	</div>
</div>