<div id="sidebar">
        <img src="images/icon/menu.svg" width="45px" height="45px">
		<a href="contact.php" class="sb-but"><h2>Contact</h2></a>
		<a href="horaire.php" class="sb-but"><h2>Horaire</h2></a>
</div>

<script>
	var sb = $("#sidebar");
	sb.css("left", -sb.width());
	$(document).on("click", "#sidebar", function(){
		if (sb.position().left == 0)
		{
			sb.children("img").css("transform", "rotate(0deg)");
			sb.css("left", -sb.width());
		}
		else
		{
			sb.children("img").css("transform", "rotate(90deg)");
			sb.css("left", "0");
		}
	});
</script>