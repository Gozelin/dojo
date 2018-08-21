/*
TRIGGER
*/

$(document).ready(function(){
	$(document).on("click", ".tab-wrapper", function(){
		// console.log($(this).children(".list-tab").css("display"));
		if ($(this).children(".list-wrapper").css("display") == "none") {
			$(this).children(".list-wrapper").css("display", "block");
			// $(this).children(".list-wrapper").css("margin-top", $(this).css("height"));
		} else
			$(this).children(".list-wrapper").css("display", "none");
	});
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