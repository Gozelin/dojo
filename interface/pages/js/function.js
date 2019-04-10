
$(document).ajaxStart(function() {
	$(".loading-gif").css("display", "block");
}).ajaxStop(function() {
	$(".loading-gif").css("display", "none");
});

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
	$.ajax({
		url : "./ajax/getPostBox.php",
		dataType : "html",
		type : "POST",
		data : { 'limit' : limit, "type" : type },
		success : function(data)
		{
			if(data == 0) {
				$("#more-post h2").html("Plus de posts disponible");
			}
			else {
				$("#container").append(data);
			}
		}
	});
}

function getBox(id)
{
	$.ajax({
		url : "./ajax/getContent.php",
		type : "POST",
		dataType : "html",
		data: {"action":id},
		success : function(data)
		{
			$("#container").append(data);
			initSort(id);
		}
	})
}

function initSort(id) {
	switch (id) {
		case "disc":
			initDiscSort();
		break;
		case "categ":
			initCategSort();
		break;
		case "salle":
			initSalleSort();
		break;
	}
}

function initDiscSort() {
	$(".categ-box").sortable({
		scroll: false,
		tolerance: "pointer",
		containment: "parent",
		placeholder: 'ui-state-highlight',
		forcePlaceholderSize: true,
		axis: "x",
		update: function(event, ui) {
			var disc_order = [];
			$(this).children(".item-box").each(function(){
				disc_order.push($(this).data("id"));
			});
			disc_order = JSON.stringify(disc_order);
			categ_id = $(this).attr("id");
			$.ajax({
				url : "./ajax/orderManager.php",
				type: "POST",
				dataType : "text",
				data: {	"action": "changeOrder",
						"file": "disc",
						"arg": categ_id,
						"order": disc_order},
				success : function(data) {
					return data;
				},
				error : function (data) {
					console.log("error on ajax call");
				}
			});
		}
	});
	$("#container").attr("style","flex-direction:column");
}

function initCategSort() {
	$(".categBox-wrapper").sortable({
		scroll: false,
		tolerance: "pointer",
		containment: "parent",
		placeholder: 'ui-state-highlight',
		forcePlaceholderSize: true,
		axis: "x",
		update: function(event, ui) {
			var categ_order = [];
			$(this).children(".item-box").each(function(){
				categ_order.push($(this).data("id"));
			});
			categ_order = JSON.stringify(categ_order);
			$.ajax({
				url : "./ajax/orderManager.php",
				type: "POST",
				dataType : "text",
				data: {	"action": "changeOrder",
						"file": "categ",
						"order": categ_order},
				success : function(data) {
					return data;
				},
				error : function (data) {
					console.log("error on ajax call");
				}
			});
		}
	});
}

function initSalleSort() {
	$(".salleBox-wrapper").sortable({
		scroll: false,
		tolerance: "pointer",
		containment: "parent",
		placeholder: 'ui-state-highlight',
		forcePlaceholderSize: true,
		axis: "x",
		update: function(event, ui) {
			var salle_order = [];
			$(this).children(".item-box").each(function(){
				salle_order.push($(this).data("id"));
			});
			salle_order = JSON.stringify(salle_order);
			$.ajax({
				url : "./ajax/orderManager.php",
				type: "POST",
				dataType : "text",
				data: {	"action": "changeOrder",
						"file": "salle",
						"order": salle_order},
				success : function(data) {
					return data;
				},
				error : function (data) {
					console.log("error on ajax call");
				}
			});
		}
	});
}

function emptyContainer()
{
	$("#container").empty();
}

function resetFileInput(fileInputBox)
{
	fileInputBox.children(".label-file").html("Choisir une image");
	fileInputBox.children(".input-file").val("");
	fileInputBox.children(".image-preview").children("img").attr("src", "");
	fileInputBox.children(".image-preview").addClass("undisplayed");
}

function getScrollPos()
{
	return $(window).scrollTop() + 70;
}

//----------------------------------------------------------------------------------------------
//----------------------- BLOG FUNCTION --------------------------------------------------------
//----------------------------------------------------------------------------------------------

function post_click()
{
	emptyContainer();
	emptyForm();
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
	type = $(this).parent().attr("id").split("-")[0];
	setNavTab();
	emptyForm(type);
});

$(".jscolor").on("change", function(){
	color = "#"+$(this).val();
	$(this).siblings(".ql-color").val(color);
	$(this).siblings(".ql-color").trigger("click");
});

$(document).on('click', "#upload-btn", function() {
	form = $(this).parent("form")[0];
	data = fetchFormData(form);
	$(form).append("<progress id='progress' value='0'></progress>");
	var request = new XMLHttpRequest();
	folder = $(form).attr("id").split("-")[0];
	type = folder.charAt(0).toUpperCase() + folder.slice(1);
	request.onreadystatechange = function() {
		if (request.readyState === 4) {
			console.log(request.response);
			if (request.response === 0) {
				showReqParam(form);
			} else {
				$("#"+type.toLowerCase()).trigger("click");
			}
		}
	}
	if ($(this).attr("class") == "update")
		request.open("POST", "../src/"+folder+"/modif"+type+".php");
	else if ($(this).attr("class") == "insert")
		request.open("POST", "../src/"+folder+"/add"+type+".php");
	var progressBar = document.getElementById("progress");
	request.upload.onprogress = function (e) {
		if (e.lengthComputable) {
			progressBar.max = e.total;
			progressBar.value = e.loaded;
		}
	}
	request.upload.onloadstart = function (e) {
		progressBar.value = 0;
	}
	request.upload.onloadend = function (e) {
		progressBar.value = e.loaded;
	}
	request.send(data);
});

function fetchFormData(form) {
	data = new FormData(form);
	for(i = 0; i < form.length; i++) {
		if (form[i].name) {
			switch (form[i].type) {
				case "hidden":
				if (form[i].className == 'quillInput') {
					desc = parseQuillDesc(form[i].name);
					descDelta = parseQuillDelta(form[i].name);
					data.append(form[i].name, desc);
					data.append(form[i].name+"Delta", descDelta);
					i++;
				}
				break;
				case "checkbox":
				name = form[i].name;
				while (i < form.length && form[i].name == name) {
					if (form[i].checked) {
						data.append(form[i].name, form[i].value);
					}
					i++;
				}
				case "radio":
				name = form[i].name;
				while (i < form.length && form[i].name == name) {
					if (form[i].checked) {
						data.append(form[i].name, form[i].value);
					}
					i++;
				}
				break;
				case "file":
				data.append(form[i].name, form[i].files, form[i].files.name);
				break;
				default:
				data.append(form[i].name, form[i].value);
				break;
			}
		}
	}
	return (data);
}

function parseQuillDelta(type) {
	arr = aQuill[type].getContents();
	return (JSON.stringify(arr));
}

function parseQuillDesc(type){
	str = document.querySelector("#editor-"+type+">.ql-editor").innerHTML;
	var i = str.length;
	while (i >= 0) {
		var j = i - 11;
		var j_ = j;
		var word = "";
		while (j < i) {
			word += str[j];
			j++;
		}
		if (word == "<p><br></p>") {
			str = str.substr(0, j_);
			i -= 10;
		}
		else
			break;
		i--;
	}
	return (str);
}

function showReqParam(form) {
	data = new FormData(form);
	for(i = 0; i < form.length; i++) {
		if (form[i].required) {
			switch (form[i].type) {
				case "hidden", "text":
					if (form[i].value == "") {
						input = $("input[name='"+form[i].name+"']");
						showText(input);
					}
				break;
			}
		}
	}

	function showText(input) {
		$(input).on("change", function(){
			if ($(this).val() != "")
				$(this).css("border", "none");
			else
				$(this).css("border", "solid 1px red");
		});
		$(input).trigger("change");
	}
} 

$(document).on("change", ".input-file", function(){
	fileName = $(this).val();
	$(this).siblings(".image-preview").children("img").attr("src", "");
	$(this).siblings(".image-preview").addClass("undisplayed");
	fileName = fileName.split("\\");
	$(this).siblings("label").html(fileName[2]);
});


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
	inputBox = "<div data-no='"+no+"' class='file-input-box'><div class='remove-input'><h3 class='image-label'>X</h3></div>\
	<label for='post-image-"+no+"' class='label-file'>Choisir une image</label>\
	<input id='post-image-"+no+"' class='input-file' type='file' name='image[]'/>\
	<div class='image-preview undisplayed'><img width='200px' height='200px' src='' ></div></div>";

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
		let link = $("#link-input-container").children(".link-input").last().val();
		if(link != "") {
			let id = $("#link-input-container").children(".link-input").last().attr("id");
			id = id.split("-")[1];
			addLinkInput();
			getYTTitle(link, id);
		}
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
	$("#link-"+no).next("h3").remove();
	$("#link-"+no).remove();
}

function getYTTitle(link) {
	if (link != "") {
		$.ajax({
			url : "../src/getYTTitle.php",
			dataType : "text",
			type : "POST",
			data : { 'link' : link },
			success : function(str)
			{
				let matches = str.match(/(?<=\<title\>)(.+)(?=\<\/title\>)/i)
				let title = matches.title;
				title = matches[0].substring(0, matches[0].length - 10);
				return (title);
			}
		});
	}
}

function quillSetup(type) {
		aQuill[type] = new Quill('#editor-'+type, {
		modules: {
			toolbar: '#toolbar-'+type
		},
		theme: 'snow'
	 });
}

function setNavTab() {
	$.ajax({
		url: "./ajax/getSession.php",
		dataType : "text",
		type : "POST",
		data : {'index': "nav-click"},
		success : function(index) {
			if (!index)
				index = "0";
			activateTab(index);
			$("#"+index).trigger("click");
		}
	})
}

