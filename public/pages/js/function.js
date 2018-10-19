/*
TRIGGER
*/

$(document).ready(function(){
	$(document).on("click", ".tab-wrapper", function(){
		if ($(this).children(".list-wrapper").css("display") == "none") {
			$(".list-wrapper").css("display", "none");
			$(".tab-wrapper").css("background", "#96bdce");
			$(this).css("background", "#5fb3d8");
			$(this).children(".list-wrapper").css("display", "block");
		} else {
			$(".tab-wrapper").css("background", "#96bdce");
			$(this).children(".list-wrapper").css("display", "none");
		}
	});
});

$("#more-post").click(function(){
	type = $(this).data("type");
	limit = limit+4;
	displayPost(limit, type);
});

$(document).on("click", ".right-arrow", function(){
	container = $(this).siblings(".post-image");
	scrollPos = $(container).scrollLeft()+300;
	$(container).animate({
		scrollLeft:scrollPos
	}, 500);
});

$(document).on("click", ".left-arrow", function(){
	container = $(this).siblings(".post-image");
	scrollPos = $(container).scrollLeft()-300;
	$(container).animate({
		scrollLeft: scrollPos
	}, 500);
});

function toggleProfOnglet(Pcontent)
{
	onglet = Pcontent.parent().parent();
	if(Pcontent.hasClass("Pcontent-closed"))
	{
		$('html, body').animate({
			scrollTop: onglet.offset().top-30
		}, 500);
		Pcontent.removeClass("Pcontent-closed");
		Pcontent.removeClass("undisplayed");
	}
	else
	{
		$('html, body').animate({
			scrollTop: onglet.offset().top-200
		}, 500);
		Pcontent.addClass("Pcontent-closed");
		setTimeout(function() {
    		Pcontent.addClass('undisplayed');
		}, 300);
	}

}

function displayPost(limit, type)
{
	var promise = $.ajax({
		url : "../src/ajax/getPosts.php",
		dataType : "html",
		type : "POST",
		data : { 'limit' : limit, "type" : type },
		success : function(status)
		{
			return status;
		}
	});

	promise.done(data => load_data(data));

	function load_data(data)
	{
		if(data == 0)
		{
			$("#more-post h2").html("Plus de posts disponible");
		}
		else
		{
			$("#post-item-container").append(data);
		}
	}
}