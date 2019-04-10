<?php
	$page_name = explode("/", $_SERVER['PHP_SELF']);
	$page_name = end($page_name);
?>

<div id="header">
	<div id="upper-bar">
		<a class="logo-home" href="home.php"><img id="logo-img"src="./images/site/logo_bleu.png"></a>
		<a class='media-logo' href="https://www.facebook.com/Dojo-Yoseikan-Budo-338728042878806/" target="_blank"><img src="images/icon/facebook.png" width="33" height="33"></a>
		<a class='media-logo' href="https://www.youtube.com/user/GILLESMORARD" target="_blank"><img src="images/icon/youtube.png" width="33" height="33"></a>
		<a class='media-logo' href="https://www.instagram.com/explore/locations/304101099/dojo-yoseikan-budo/?hl=fr" target="_blank"><img src="images/icon/instagram.png" width="33" height="33"></a>
		<div class='upper-link'>
			<div class="resp-btn-wrapper"><img class="resp-btn" src="./images/site/responsive_dd.png" width="50px" height="50px"></div>
			<div id="resp-dropdown" class="dd-closed">
				<!-- <a href="./news.php"><h3 class="news">News</h3></a> -->
				<!-- <div class='vert-line'></div> -->
				<a href="./location.php"><h3 class="location">Location</h3></a>
				<div class='vert-line'></div>
				<a href="./association.php"><h3 class="association">Association</h3></a>
				<div class='vert-line'></div>
				<a href="./horaire.php"><h3 class="horaire">Horaires/Tarifs</h3></a>
				<div class='vert-line'></div>
				<a href="./contact.php"><h3 class="contact">Contact</h3></a>
			</div>
		</div>
	</div>
	<?php
		if ($page_name == "home.php")
			echo "<div id='banner-container'><img id='banner-img' src='./images/site/banner.jpg' alt='./images/site/default.png'></div>";
	?>
	<div id="banner" class="undisplayed">
		<img id="cover-img" class="no-opacity" src="">
		<img id="trans-img" class="no-opacity" src="">
	</div>
	<?php
		if ($page_name != "home.php")
			echo getNavBar(1);
		else
			echo getNavBar();
	?>
</div>

<script>
var wrapPoint = 0;
children = $("#upper-bar").children().each(function(){
		wrapPoint += $(this).width();
});
wrapPoint += 100;


var head  = document.getElementsByTagName('head')[0];
var link  = document.createElement('link');
link.id   = "myCss";
link.rel  = 'stylesheet';
link.type = 'text/css';
link.href = './css/upper_light.css';
link.media = '(max-width: '+wrapPoint+'px)';
head.appendChild(link);

$(document).ready(function(){
	$(document).on("click", ".resp-btn", function(){
		var dd = $("#resp-dropdown");
		if (dd.css("height") == "0px") {
			$(".resp-btn-wrapper").css("background-color", "#d8d8d8");
			$("#resp-dropdown").removeClass("dd-closed");
		}
		else {
			$(".resp-btn-wrapper").css("background-color", "transparent");
			$("#resp-dropdown").addClass("dd-closed");
		}
	});

	//color the upper tab for depending on the page we are in
	fn = location.pathname.split("/");
	fn = fn.slice(-1)[0].split(".")[0];
	$("."+fn).parent().css("background-color", "#d8d8d8");

	/*
	primary tab nav-bar hover trigger
	*/
	$(document).on("mouseenter", ".primary-tab", function(){
		$("#tab-display").css("padding-left", $(this).offset().left);
		$(".triangle").addClass("no-opacity");
		$(this).children(".triangle").removeClass("no-opacity");
		tab = $(this).next(".secondary-tab").html();
		$("#tab-display").html(tab);
		$("#tab-display").css("height", "50px");
	});
	$(document).on("mouseleave", "#nav-bar", function(){
		$(".triangle").addClass("no-opacity");
		$("#tab-display").html("");
		$("#tab-display").css("height", 0);
		$("#tab-display").css("padding-left", 0);
	});

	/*
	nav-bar link hover trigger
	*/
	if (window.location.href.split("/").reverse()[0] == "home.php") {
		$(document).on("mouseenter", ".disc-link", function(){
			$(".disc-link").removeClass("second-tab-active");
			newSrc = $(this).next(".disc-img").attr("src");
			if ($("#cover-img").hasClass("no-opacity")) {
				if ($("#cover-img").attr("src") !== "") {
					$("#trans-img").attr("src", $("#cover-img").attr("src"));
					$("#trans-img").removeClass("no-opacity");
				}
				setTimeout(function(){ $("#cover-img").attr("src", newSrc) }, 100);
				$("#banner-img").addClass("no-opacity");
				$("#cover-img").removeClass("no-opacity");
				setTimeout(function(){ $("#trans-img").addClass("no-opacity"); }, 100);
			}
		});
		$(document).on("mouseleave", ".disc-link", function(){
				$("#banner-img").removeClass("no-opacity");
				$("#cover-img").addClass("no-opacity");
		});
		$(document).on("mouseleave", "#tab-display", function() {
			$("#cover-img").attr("src", "");
		});
	}
});
</script>