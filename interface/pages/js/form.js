/*
	modif form
*/

function getFormHTML(index, callback, id = null) {
	$.ajax({
		url: "./ajax/getForm.php",
		datatype: "text",
		type: "POST",
		data: { "index":  index, "id": id },
		success: function(html) {
			$("#container").append(html);
			callback(index, id);
		}
	});
}

function displayModifForm(type, id)
{
	type = type.split("-")[0];
	getFormHTML(type, function(type, id){
		popup = "#"+type+"-form-box";
		form = $("#"+type+"-form");
		$(popup).css("top", getScrollPos());
		$("#cache-container").removeClass("undisplayed");
		$(popup).removeClass("undisplayed");
		form.children(".submit-btn").val("modifier");
		loadForm(form, type, {"id": id});
	}, id);
}

function loadForm(form, etype, data = null) {
	var url = "../src/"+etype+"/get"+(etype.charAt(0).toUpperCase() + etype.slice(1))+".php";
	$.ajax({
		url : url,
		dataType : "text",
		type : "POST",
		data : { 'data' : data },
		success : function(json)
		{
			d = JSON.parse(json)
			l_quillInput(d);
			if (type == "disc") {
				getVideoForm(id, 1);
			}
		}
	});
}

function l_quillInput() {
	for(var val in d["inputtype"]["quill"]){
		key = d["inputtype"]["quill"][val];
		quillSetup(key);
		aQuill[key].setContents(d[val]);
	}
}

/*
	add form
*/
function displayAddForm(type)
{
	type = type.split("-")[0];
	getFormHTML(type, function(type){
		popup = "#"+type+"-form-box";
		form = $("#"+type+"-form");
		$(popup).css("top", getScrollPos());
		$(popup).removeClass("undisplayed");
		$("#cache-container").removeClass("undisplayed");
		form.children("input[type=submit]").val("ajouter");
		switch(type)
		{
			case "disc" :
				quillSetup("desc");
				quillSetup("horaire");
				form.children(".file-input-container").children(".file-input-box").children(".image-preview").addClass("undisplayed");
				$(".categ-input-box").children("label").first().addClass("label-radio-categ-activ");
				$(".categ-input-box").children("input").first().prop("checked", true);
			break;
			case "horaire" :
				form.attr("action", "../src/horaire/addHoraire.php");
				form.children(".file-input-container").children(".file-input-box").children(".image-preview").children("img").each(function(index){
					$(this).attr("src", "../../public/pages/images/horaire/horaire"+index+".jpg");
				});
				form.children(".file-input-container").children(".file-input-box").children(".image-preview").removeClass("undisplayed");
			break;
			case "categ" :
				quillSetup("desc");
				form.attr("action", "../src/categ/addCateg.php");
				form.children(".file-input-box").children(".image-preview").addClass("undisplayed");
			break;
			case "prof" :
				form.attr("action", "../src/prof/addProf.php");
				quillSetup("desc");
				form.children(".file-input-box").children(".image-preview").addClass("undisplayed");
				form.children(".file-input-box").children(".image-preview").children("img").attr("src", " ");
				form.children(".file-input-box").children(".label-file").html("Choisir une image");
			break;
			case "post" :
				form.attr("action", "../src/post/addPost.php");
				form.children(".file-input-container").children(".file-input-box").children(".image-preview").addClass("undisplayed");
				form.children(".file-input-container").children(".file-input-box").children(".image-preview").children("img").attr("src", " ");
				form.children(".file-input-container").children(".file-input-box").children(".label-file").html("Choisir une image");
			break;
			case "salle":
				form.attr("action", "../src/post/addSalle.php");
				quillSetup("desc");
			break;
		}
	});
}

/*
	empty the form
*/

function emptyForm()
{
	type = $(".form-popup").not(".undisplayed").attr("id");
	$("#cache-container").addClass("undisplayed");
	if(typeof  type !== 'undefined')
	{
		type = type.split("-");
		popup = "#"+type[0]+"-form-box";
		form = $("#"+type[0]+"-form");
		$(popup).addClass("undisplayed");
		switch(type[0])
		{
			case "disc":
				emptyDiscForm(form);
			break;
			case "horaire":
				emptyHoraireForm(form);
			break;
			case "categ":
				emptyCategForm(form);
			break;
			case "prof":
				emptyProfForm(form);
			break;
			case "post":
				emptyPostForm(form);
			break;
		}
	}
}

function emptyDiscForm(form) {
	form.children("input[type=text]").val("");
	aQuill["desc"].setContents(" ");
	aQuill["horaire"].setContents(" ");
	$("#link-input-container").empty();
	resetFileInput(form.children(".file-input-container").children(".file-input-box"));
	form.children(".info-input-container").children(".categ-input-box").children("input[type=radio]").prop("checked", false);
	form.children(".info-input-container").children(".categ-input-box").children(".label-radio-categ").removeClass("label-radio-categ-activ");
	$(".prof-label").removeClass("prof-label-activ");
	$(".prof-chkbox").prop("checked", false);
	form.children("input[type=submit]").val("");
}

function  emptyHoraireForm(form) {
	form.children(".file-input-container").children(".file-input-box").children(".label-file").html("Choisir une image");
	form.children(".file-input-container").children(".file-input-box").children(".input-file").val("");
	form.children(".file-input-container").children(".file-input-box").children(".image-preview").children("img").attr("src", "");
	form.children(".file-input-container").children(".file-input-box").children(".image-preview").addClass("undisplayed");
}

function emptyCategForm(form) {
	form.children("input[type=text]").val("");
	aQuill["desc"].setContents(" ");
	resetFileInput(form.children(".file-input-box"));
	form.children("input[type=submit]").val("");
	form.children("input[name=color]").val("");
	form.children("input[name=color]").css("background-color", "white");
}

function emptyProfForm(form) {
	form.children("input[type=text]").val("");
	aQuill["desc"].setContents(" ");
	form.children("input[type=submit]").val("");
	form.children("input[name=color]").val("");
	form.children("input[name=color]").css("background-color", "white");
	form.children(".file-input-container").children(".file-input-box").children(".image-preview").children("img").attr("src", " ");
	form.children(".file-input-container").children(".file-input-box").children(".image-preview").addClass("undisplayed");
}

function emptyPostForm(form) {
	form.children("input[type=text]").val("");
	form.children(".link-input-container").children("input[type=text]").val("");
	aQuill["post"].setContents(" ");
	form.children("input[type=submit]").val("");
	form.children("input[name=color]").val("");
	form.children("input[name=color]").css("background-color", "white");
	form.children(".file-input-container").children(".file-input-box").children(".label-file").html("Choisir une image");
	form.children(".file-input-container").children(".file-input-box").children(".input-file").val("");
	form.children(".file-input-container").children(".file-input-box").children(".image-preview").children("img").attr("src", " ");
	form.children(".file-input-container").children(".file-input-box").children(".image-preview").addClass("undisplayed");
	form.children(".file-input-container").children(".file-input-box").each(function(){
		no = $(this).data("no");
		removeFileInput(no);
	});
}

// function l_textInput(d) {
// 	d["inputtype"]["text"].forEach(key => {
// 		form.children("input[name='"+key+"']").val(d[key]);
// 	});
// }

// function l_imageInput() {
// 	form.children(".file-input-container").children(".file-input-box").children(".image-preview").each(function(index){
// 		path = "";
// 		if (typeof d["image"] == "string")
// 			path = d["image"];
// 		else
// 			path = d["image"][index];
// 		if(path != "" && typeof path != 'undefined')
// 		{
// 			$(this).children("img").attr("src", "../../public/pages/images/"+d["elemtype"]+"/"+path);
// 			$(this).siblings(".label-file").html(path);
// 			$(this).removeClass("undisplayed");
// 		} else {
// 			$(this).addClass("undisplayed");
// 		}
// 	});
// }

// function l_checkInput() {
// 	if (typeof d["inputtype"]["checkbox"] != "undefined") {
// 		d["inputtype"]["checkbox"].forEach(key => {
// 			for(i=0;i<d[key].length;i++) {
// 				$("#"+d[key][i]+"-"+key).prop("checked", true);
// 				$("#"+d[key][i]+"-"+key).prev("label").addClass("prof-label-activ");
// 			}
// 		});
// 	}
// }

// function l_radioInput() {
// 	if (typeof d["inputtype"]["radio"] != "undefined") {
// 		d["inputtype"]["radio"].forEach(key => {
// 			form.children(".info-input-container").children("."+key+"-input-box").children("input[value="+d[key]+"]").prop("checked", true);
// 			form.children(".info-input-container").children("."+key+"-input-box").children("input[value="+d[key]+"]").trigger("change");
// 		});
// 	}
// }