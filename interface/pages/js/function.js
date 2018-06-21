//met le text de la tab en blanc et affiche le titre dans le container
function activateTab(tabId)
{
	$(".menu-tab").removeClass("tab-activ");
	$("#interface-content h1").empty();

	$("#"+tabId).addClass("tab-activ");
	html = $("#"+tabId).html();
	$("#interface-content h1").append(html);
}

function displayPost(limit, type)
{
	var promise = $.ajax({
		url : "./ajax/getPostBox.php",
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
			$("#container").append(data);
		}
	}
}

//récup et affiche le html des box : ajax getDiscBox.php
function getDiscBox()
{

	var promise = $.ajax({
		url : "./ajax/getDiscBox.php",
		dataType : "html",
		success : function(status)
		{
			return status;
		}
	});

	promise.done(data => load_data(data));

	function load_data(data)
	{
		$("#container").append(data);
		$("#container").attr("style","flex-direction:column");
	}
}

//récup et affiche le html des box : ajax getCategBox.php
function getCategBox()
{
	var promise = $.ajax({
		url : "./ajax/getCategBox.php",
		dataType : "html",
		success : function(status)
		{
			return status;
		}
	});

	promise.done(data => load_data(data));

	function load_data(data)
	{
		$("#container").append(data);
		$("#container").attr("style","flex-direction:initial")
	}
}

function getProfBox()
{

	var promise = $.ajax({
		url : "./ajax/getProfBox.php",
		dataType : "html",
		success : function(status)
		{
			return status;
		}
	});

	promise.done(data => load_data(data));

	function load_data(data)
	{
		$("#container").append(data);
		$("#container").attr("style","flex-direction:initial");
	}
}

//vide le container
function emptyContainer()
{
	$("#container").empty();
}

//affiche le formulaire d'ajout correspondant au type d'objet en param
function displayAddForm(type)
{
	type = type.split("-");
	popup = "#"+type[0]+"-form-box";
	form = "#"+type[0]+"-form";
	$(popup).css("top", getScrollPos());
	$(popup).removeClass("undisplayed");
	$("#cache-container").removeClass("undisplayed");
	$(form).children("input[type=submit]").val("ajouter");
	switch(type[0])
	{
		//DISCIPLINE
		case "disc" :
			$(form).attr("action", "../src/disc/addDisc.php");
			addLinkInput();
			$(form).children(".file-input-container").children(".file-input-box").children(".image-preview").addClass("undisplayed");
			$(".categ-input-box").children("label").first().addClass("label-radio-categ-activ");
			$(".categ-input-box").children("input").first().prop("checked", true);
		break;
		//HORAIRE
		case "horaire" :
			$(form).attr("action", "../src/horaire/addHoraire.php");
			$(form).children(".file-input-container").children(".file-input-box").children(".image-preview").children("img").each(function(index){
				$(this).attr("src", "../../public/pages/images/horaire/horaire"+index+".jpg");
			});
			$(form).children(".file-input-container").children(".file-input-box").children(".image-preview").removeClass("undisplayed");
		break;
		//CATEG
		case "categ" :
			$(form).attr("action", "../src/categ/addCateg.php");
			$(form).children(".file-input-box").children(".image-preview").addClass("undisplayed");
		break;
		//PROF
		case "prof" :
			$(form).attr("action", "../src/prof/addProf.php");
			$(form).children(".file-input-box").children(".image-preview").addClass("undisplayed");
			$(form).children(".file-input-box").children(".image-preview").children("img").attr("src", " ");
			$(form).children(".file-input-box").children(".label-file").html("Choisir une image");
		break;
		case "post" :
			$(form).attr("action", "../src/post/addPost.php");
			$(form).children(".file-input-container").children(".file-input-box").children(".image-preview").addClass("undisplayed");
			$(form).children(".file-input-container").children(".file-input-box").children(".image-preview").children("img").attr("src", " ");
			$(form).children(".file-input-container").children(".file-input-box").children(".label-file").html("Choisir une image");
		break;
	}
}

//AFFICHE LE FORMULAIRE EN FONCTION DU TYPE ET DE L'OBJET
//<!> A CHANGER : NAME EN ID <!>
function displayModifForm(type, id)
{
	type = type.split("-");
	popup = "#"+type[0]+"-form-box";
	form = "#"+type[0]+"-form";
	$(popup).css("top", getScrollPos());
	$("#cache-container").removeClass("undisplayed");
	switch(type[0])
	{
		//HOME
		case "home":
			var promise = $.ajax({
					url : "../src/home/getHome.php",
					dataType : "text",
					success : function(home)
					{
						return home
					}
				});

			promise.done(home => load_home(home));

			function load_home(home)
			{
				home = JSON.parse(home)
				$(popup).removeClass("undisplayed");
				$(form).attr("action", "../src/home/modifHome.php");
				$(form).children("input[name=title]").val(home["title"]);
				aQuill["home"].setContents(home["descDelta"]);
				$(form).children("input[type=submit]").val("modifier");
			}
		break;
		//DISCIPLINE
		case "disc":
			var promise = $.ajax({
					url : "../src/disc/getDisc.php",
					dataType : "text",
					type : "POST",
					data : { 'id' : id },
					success : function(disc)
					{
						return disc
					}
				});

			promise.done(disc => load_disc(disc));

			function load_disc(disc)
			{
				disc = JSON.parse(disc);
				$(popup).removeClass("undisplayed");
				$(form).attr("action", "../src/disc/modifDisc.php");
				$(form).children("input[name=id]").val(disc["id"]);
				$(form).children("input[name=title]").val(disc["name"]);
				aQuill["disc"].setContents(disc["descDelta"]);

				if (disc["link"] != "undefined")
					addLinkInput();
				else {
					linkNo = disc["link"].length;
					for(i=0;i<linkNo;i++)
					{
						addLinkInput();
						$("#link-"+i).val(disc["link"][i]);
					}
				}

				$(form).children(".info-input-container").children(".categ-input-box").children("input[value="+disc["categ"]+"]").prop("checked", true);
				$(form).children(".info-input-container").children(".categ-input-box").children("input[value="+disc["categ"]+"]").trigger("change");
				for(i=0;i<disc["profs"].length;i++)
				{
					$("#"+disc["profs"][i]+"-prof").prop("checked", true);
					$("#"+disc["profs"][i]+"-prof").prev("label").addClass("prof-label-activ");
				}
				$(form).children(".file-input-container").children(".file-input-box").children(".image-preview").each(function(index){
					if(disc["image"][index] != "")
					{
						$(this).children("img").attr("src", "../../public/pages/images/disciplines/"+disc["image"][index]);
						$(this).siblings(".label-file").html(disc["image"][index]);
						$(this).removeClass("undisplayed");
					}
					else
					{
						$(this).addClass("undisplayed");
					}
				});
				$(form).children("input[type=submit]").val("modifier");
			}
		break;
		//CATEG
		case "categ":
			var promise = $.ajax({
					url : "../src/categ/getCateg.php",
					dataType : "text",
					type : "POST",
					data : { 'id' : id },
					success : function(categ)
					{
						return categ
					}
				});

			promise.done(categ => load_categ(categ));

			function load_categ(categ)
			{
				categ = JSON.parse(categ);
				$(popup).removeClass("undisplayed");
				$(form).attr("action", "../src/categ/modifCateg.php");
				$(form).children("input[name=id]").val(categ["id"]);
				$(form).children("input[name=title]").val(categ["name"]);
				aQuill["categ"].setContents(categ["descDelta"]);
				$(form).children("input[name=color]").val(categ["color"]);
				$(form).children("input[name=color]").css("background-color", categ["color"]);
				$(form).children("input[type=submit]").val("modifier");
				img = $(form).children(".file-input-box").children(".image-preview");
				if(categ["image"] != "")
				{
					img.children("img").attr("src", "../../public/pages/images/categorie/"+categ["image"]);
					img.siblings(".label-file").html(categ["image"]);
					img.removeClass("undisplayed");
				}
				else
				{
					img.addClass("undisplayed");
				}
			}
		break;
		//PROF
		case "prof":
			var promise = $.ajax({
					url : "../src/prof/getProf.php",
					dataType : "text",
					type : "POST",
					data : { 'id' : id },
					success : function(prof)
					{
						return prof
					}
				});

			promise.done(prof => load_prof(prof));

			function load_prof(prof)
			{
				prof = JSON.parse(prof);
				$(popup).removeClass("undisplayed");
				$(form).attr("action", "../src/prof/modifProf.php");
				$(form).children("input[name=id]").val(prof["id"]);
				$(form).children("input[name=name]").val(prof["name"]);
				$(form).children("input[name=surname]").val(prof["surname"]);
				aQuill["prof"].setContents(prof["descDelta"]);
				$(form).children(".file-input-box").children(".image-preview").each(function(index){
					if(prof["image"][index] != "")
					{
						$(this).children("img").attr("src", "../../public/pages/images/profs/"+prof["image"][index]);
						$(this).siblings(".label-file").html(prof["image"][index]);
						$(this).removeClass("undisplayed");
					}
					else
					{
						$(this).addClass("undisplayed");
					}
				});
				$(form).children("input[type=submit]").val("modifier");
			}
		break;
		//POST
		case "post":
			var promise = $.ajax({
					url : "../src/post/getPost.php",
					dataType : "text",
					type : "POST",
					data : { 'id' : id },
					success : function(post)
					{
						return post
					}
				});

			promise.done(post => load_post(post));

			function load_post(post)
			{
				post = JSON.parse(post);
				$(popup).removeClass("undisplayed");
				$(form).attr("action", "../src/post/modifPost.php");
				$(form).children("input[name=id]").val(post["id"]);
				$(form).children("input[name=title]").val(post["title"]);
				$(form).children("input[value="+post['type']+"]").attr("checked", "checked");
				aQuill["post"].setContents(post["descDelta"]);

				for(i=0;i<post["image"].length;i++)
				{
					console.log(i);
					addFileInput(i-1);
				}

				$(form).children(".file-input-container").children(".file-input-box").children(".image-preview").each(function(index){
					if(typeof post["image"][index] !== 'undefined')
					{
						$(this).children("img").attr("src", "../../public/pages/images/posts/"+post["image"][index]);
						$(this).siblings(".label-file").html(post["image"][index]);
						$(this).removeClass("undisplayed");
					}
					else
					{
						$(this).addClass("undisplayed");
					}
				});
				$(form).children("input[type=submit]").val("modifier");
			}
		break;
	}
}

function resetFileInput(fileInputBox)
{
	console.log(fileInputBox);
	fileInputBox.children(".label-file").html("Choisir une image");
	fileInputBox.children(".input-file").val("");
	fileInputBox.children(".image-preview").children("img").attr("src", "");
	fileInputBox.children(".image-preview").addClass("undisplayed");
}

//cache le formulaire affiché et vide ses inputs
function undisplayForm()
{
	type = $(".form-popup").not(".undisplayed").attr("id");
	$("#cache-container").addClass("undisplayed");
	if(typeof  type !== 'undefined')
	{
		type = type.split("-");
		popup = "#"+type[0]+"-form-box";
		form = "#"+type[0]+"-form";
		$(popup).addClass("undisplayed");
		switch(type[0])
		{
			//DISCIPLINE
			case "disc":
				$(form).children("input[type=text]").val("");
				aQuill["disc"].setContents(" ");
				$("#link-input-container").empty();
				resetFileInput($(form).children(".file-input-container").children(".file-input-box"));
				$(form).children(".info-input-container").children(".categ-input-box").children("input[type=radio]").prop("checked", false);
				$(form).children(".info-input-container").children(".categ-input-box").children(".label-radio-categ").removeClass("label-radio-categ-activ");
				$(".prof-label").removeClass("prof-label-activ");
				$(".prof-chkbox").prop("checked", false);
				$(form).children("input[type=submit]").val("");
			break;
			//HORAIRE
			case "horaire":
				$(form).children(".file-input-container").children(".file-input-box").children(".label-file").html("Choisir une image");
				$(form).children(".file-input-container").children(".file-input-box").children(".input-file").val("");
				$(form).children(".file-input-container").children(".file-input-box").children(".image-preview").children("img").attr("src", "");
				$(form).children(".file-input-container").children(".file-input-box").children(".image-preview").addClass("undisplayed");
			break;
			//CATEG
			case "categ":
				$(form).children("input[type=text]").val("");
				aQuill["categ"].setContents(" ");
				resetFileInput($(form).children(".file-input-box"));
				$(form).children("input[type=submit]").val("");
				$(form).children("input[name=color]").val("");
				$(form).children("input[name=color]").css("background-color", "white");
			break;
			//PROF
			case "prof":
				$(form).children("input[type=text]").val("");
				aQuill["prof"].setContents(" ");
				$(form).children("input[type=submit]").val("");
				$(form).children("input[name=color]").val("");
				$(form).children("input[name=color]").css("background-color", "white");
				$(form).children(".file-input-container").children(".file-input-box").children(".image-preview").children("img").attr("src", " ");
				$(form).children(".file-input-container").children(".file-input-box").children(".image-preview").addClass("undisplayed");
			break;
			//POST
			case "post":
				$(form).children("input[type=text]").val("");
				$(form).children(".link-input-container").children("input[type=text]").val("");
				aQuill["post"].setContents(" ");
				$(form).children("input[type=submit]").val("");
				$(form).children("input[name=color]").val("");
				$(form).children("input[name=color]").css("background-color", "white");
				$(form).children(".file-input-container").children(".file-input-box").children(".label-file").html("Choisir une image");
				$(form).children(".file-input-container").children(".file-input-box").children(".input-file").val("");
				$(form).children(".file-input-container").children(".file-input-box").children(".image-preview").children("img").attr("src", " ");
				$(form).children(".file-input-container").children(".file-input-box").children(".image-preview").addClass("undisplayed");
				$(form).children(".file-input-container").children(".file-input-box").each(function(){
					no = $(this).data("no");
					removeFileInput(no);
				});
			break;
		}
	}

}

function getScrollPos()
{
	return $(window).scrollTop() + 70;
}

function home_click()
{
	emptyContainer();
	undisplayForm();
	displayModifForm("home");
}

function disc_click()
{
	emptyContainer();
	undisplayForm();
	getDiscBox();
}

function horaire_click()
{
	emptyContainer();
	undisplayForm();
	displayAddForm("horaire");
}

function categ_click()
{
	emptyContainer();
	undisplayForm();
	getCategBox();
}

function prof_click()
{
	emptyContainer()
	undisplayForm();
	getProfBox();
}
//----------------------------------------------------------------------------------------------
//----------------------- BLOG FUNCTION --------------------------------------------------------
//----------------------------------------------------------------------------------------------

function post_click()
{
	emptyContainer();
	undisplayForm();
	resetMoreButton();
	$("#container").append("<div id='post' class='item-box add-btn disc-add-btn'><h1 class='add-title'>ADD</h1></div>");
	displayPost(0, "");
}

function resetMoreButton()
{
	limit = 0;
	$("#more-post h2").html("Afficher plus");
}

//----------------------------------------------------------------------------------------------
//----------------------- CONTENT FUNCTION -----------------------------------------------------
//----------------------------------------------------------------------------------------------

//ITEM MANAGEMENT BUTTONS
$(document).on("click",".add-btn", function(){
	type = $(this).attr("id");
	displayAddForm(type);
});

$(document).on("click",".modif-btn", function(){
	id = $(this).parent().parent().data("id");
	type = $(this).parent().parent().attr('class').split(" ")[0];
	displayModifForm(type, id);
});

$(document).on("click",".close-btn", function(){
	type = $(this).parent().attr("id").split("-")[0];;
	undisplayForm(type);
});

//initialise le color picker
$(".jscolor").on("change", function(){
	color = "#"+$(this).val();
	$(this).siblings(".ql-color").val(color);
	$(this).siblings(".ql-color").trigger("click");
});

//rempli les hidden input avec les donné quill avant l'envoi vers le php
$(".submit-btn").click(function(){
	type = $(this).parent().attr("id");
	type = type.split("-");
	desc = document.querySelector("#editor-"+type[0]+">.ql-editor").innerHTML;
	switch(type[0])
	{
		case "home":
			descDelta = aQuill["home"].getContents();
			descDelta = JSON.stringify(descDelta);
		break;
		case "disc":
			descDelta = aQuill["disc"].getContents();
			descDelta = JSON.stringify(descDelta);
		break;
		case "categ":
			descDelta = aQuill["categ"].getContents();
			descDelta = JSON.stringify(descDelta);
		break;
		case "prof":
			descDelta = aQuill["prof"].getContents();
			descDelta = JSON.stringify(descDelta);
		break;
		case "post":
			descDelta = aQuill["post"].getContents();
			descDelta = JSON.stringify(descDelta);
		break;
	}

	console.log(desc);
	$(this).siblings("input[name=desc]").val(desc);
	$(this).siblings("input[name=descDelta]").val(descDelta);
});

//style les inputs file
$(document).on("change", ".input-file", function(){
	fileName = $(this).val();
	$(this).siblings(".image-preview").children("img").attr("src", "");
	$(this).siblings(".image-preview").addClass("undisplayed");
	fileName = fileName.split("\\");
	$(this).siblings("label").html(fileName[2]);
});


//sélectionne un menu au chargement de la page si demandé
switch("<?php echo $_SESSION['tab-click'] ?>")
{
	case "home":
		activateTab("home");
		home_click();
	break;
	case "disc":
		activateTab("disc");
		disc_click();
	break;
	case "categ":
		activateTab("categ");
		categ_click();
	break;
	case "horaire":
		activateTab("horaire");
		horaire_click();
	break;
	case "prof":
		activateTab("prof");
		prof_click();
	break;
	case "post":
		activateTab("post");
		displayPost(0, "");
	break;
}

$("#more-image").click(function(){
	no = $(".file-input-container").children(".file-input-box").last().data("no");
	if(typeof no == "undefined")
		no = -1;
	addFileInput(no);
});

$(document).on("click", ".remove-input", function(){
	no = $(this).parent(".file-input-box").data("no");
	removeFileInput(no);
});

function addFileInput(no)
{
	no = no+1;
	inputBox = "<div data-no='"+no+"' class='file-input-box'><div class='remove-input'><h3 class='image-label'>X</h3></div><label for='post-image-"+no+"' class='label-file'>Choisir une image</label><input id='post-image-"+no+"' class='input-file' type='file' name='image[]'/><div class='image-preview undisplayed'><img width='200px' height='200px' src='' ></div></div>";
	$(".hidden-input-box").append("<input class='hidden-input' type='hidden' value='"+no+"' name='hidden-image[]' >");
	$("#more-image").before(inputBox);
}

function removeFileInput(no)
{
	$(".hidden-input[value='"+no+"']").remove();
	$(".file-input-box[data-no='"+no+"']").remove();
}

$(document).on("change", ".link-input", function(){
	if($(this).val() == "")
	{
		no = $(this).attr("id").split("-");
		if($(".link-input").length > 1)
		{
			if($("#link-input-container").children(".link-input").last().attr("id").split("-")[1] != no[1])
				removeLinkInput(no[1]);
		}
	}
	else
	{
		if($("#link-input-container").children(".link-input").last().val() != "")
			addLinkInput();
	}
});

function addLinkInput()
{
	if($("#link-input-container").has(".link-input").length > 0)
	{
		no = $("#link-input-container").children(".link-input").last().attr("id").split("-");
		no = parseInt(no[1]);
	}
	else
		no = -1;

	no = no + 1;
	$("#link-input-container").append("<input id='link-"+no+"' class='link-input' type='text' name='link[]' placeholder='Lien vers la vidéo'/>");
}

function removeLinkInput(no)
{
	console.log(no);
	$("#link-"+no).remove();
}

