<div id="header">
	<div id="upper-bar">
		<a href="https://www.facebook.com/Dojo-Yoseikan-Budo-338728042878806/" target="_blank"><img style="padding: 2px" src="images/icon/fb.png" width="46" height="46"></a>
		<a href="https://www.youtube.com/user/GILLESMORARD" target="_blank"><img style="padding: 2px" src="images/icon/yt.ico" width="46" height="46"></a>
		<div class='upper-link'>
			<a href="./news.php">News</a>
			<a href="./location.php">Location</a>
			<a href="./assoc.php">l'Association</a>
			<a href="./horaire.php">Horaires/Tarifs</a>
			<a href="./contact.php">Contact</a>
		</div>
	</div>
	<div id="banner">
		<a href="home.php">
			<img id="banner-img" src="./images/site/default-banner.jpg">
			<div id="logo-img"><?php include("./images/site/logo.svg"); ?></div>
		</a>
		<img id="cover-img" class="no-opacity" src="">
		<img id="trans-img" class="no-opacity" src="">
	</div>
	<?php echo getNavBar(); ?>
</div>

<script>
	$(document).ready(function(){

		/*
		primary tab nav-bar trigger
		*/
		$(document).on("mouseenter", ".primary-tab", function(){
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
		});

		/*
		nav-bar link trigger
		*/
		if (window.location.href.split("/").reverse()[0] == "home.php") {
			$(document).on("mouseenter", ".disc-link", function(){
				newSrc = $(this).next(".disc-img").attr("src");
				if ($("#cover-img").hasClass("no-opacity")) {
					if ($("#cover-img").attr("src") !== "") {
						$("#trans-img").attr("src", $("#cover-img").attr("src"));
						$("#trans-img").removeClass("no-opacity");
					}
					setTimeout(function(){ $("#cover-img").attr("src", newSrc) }, 100);
					$("#banner-img").addClass("no-opacity");
					$("#logo-img").addClass("logo-small");
					$("#cover-img").removeClass("no-opacity");
					setTimeout(function(){ $("#trans-img").addClass("no-opacity"); }, 100);
				}
			});
			$(document).on("mouseleave", ".disc-link", function(){
					$("#banner-img").removeClass("no-opacity");
					$("#cover-img").addClass("no-opacity");
					$("#logo-img").removeClass("logo-small");
			});
			$(document).on("mouseleave", "#tab-display", function() {
				$("#cover-img").attr("src", "");
			});
		}
	});

</script>