var sel_img = null;

$(document).ready(function() {
	initSortGallery();
	$("body").on("click", function(e) {
		let pclass = $(e.target).parent().attr("class");
		if (pclass) {
			pclass = pclass.split(" ");
			if (Array.isArray(pclass))
				pclass = pclass[0];
		}
		if (pclass != "img-wrapper") {
			sel_img = null;
			$(".img-wrapper").removeClass("img-activ");
		}
	});
	$(document).on("change", ".fileInput", function() {
		if ($(this).attr("name") == "addImage")
			sendFile(this.files);
		else
			updateFile(this.files);
	});
	$(document).on("click", ".img-wrapper", function() {
		id = $(this).attr('id').split("-")[1];
		if (sel_img == null || sel_img != id) {
			sel_img = id;
			$(".img-wrapper").removeClass("img-activ");
			$(this).addClass("img-activ");
		} else {
			delImage();
			sel_img = null;
		}
	});
});

function delImage() {
	if (sel_img != null) {
		$.ajax({
			url: "ajax/manageGallery.php",
			datatype: "text",
			type: "POST",
			data: {"action": "supprImage", "id": $(".g-id").attr("value"), "imgId": sel_img},
			success: function(ret) {
				refreshForm();
			}
		})
	}
}

function updateGallery() {
	let aId = [];
	$(".gForm-wrapper ul").children().each(function() {
		if ($(this).is("li"))
			aId.push($(this).attr('id').split("-")[1]);
	});
	$.ajax({
		url: "ajax/manageGallery.php",
		datatype: "text",
		type: "POST",
		data: {"action": "updateImage", "id": $(".g-id").attr("value"), "image": JSON.stringify(aId)},
		success: function(ret) {
		}
	})
}

function sendFile(file) {
	var formData = new FormData();
	var req = new XMLHttpRequest();
	for (i=0; i < file.length; i++) {
		formData.append("uploads[]", file[i]);
	}
	formData.set("id", $(".g-id").attr("value"));
	formData.set("name", $(".g-name").attr("value"));
	formData.set("action", "insert");
	req.open("POST", "ajax/manageGallery.php");
	req.send(formData)
	req.onreadystatechange = function() {
		if (req.readyState === 4) {
			console.log(req.response);
			if ($.isNumeric(req.response))
				$(".g-id").attr("value", req.response);
			refreshForm();
		}
	}
}

function updateFile(file) {
	var formData = new FormData();
	var req = new XMLHttpRequest();
	for (i=0; i < file.length; i++) {
		formData.append("uploads[]", file[i]);
	}
	formData.set("id", $(".g-id").attr("value"));
	formData.set("action", "addImage");
	req.open("POST", "ajax/manageGallery.php");
	req.send(formData)
	req.onreadystatechange = function() {
		if (req.readyState === 4) {
			console.log(req.response);
			refreshForm();
		}
	}
}

function refreshForm() {
	$.ajax({
		url: "ajax/manageGallery.php",
		datatype: "text",
		type: "POST",
		data: { "action": "getForm", "id": $(".g-id").attr("value")},
		success: function(html) {
			console.log($(".gForm-wrapper").parent());
			formBox = $(".gForm-wrapper").parent();
			$(".gForm-wrapper").remove();
			$(formBox).append(html);
			initSortGallery();
		}
	});
}

function initSortGallery() {
	$(".gForm-wrapper ul").sortable({
		items: "li:not(input)",
		update: function(event, ui) {
			updateGallery();
		}
	});
}

function getImageForm(id) {
	$.ajax({
		url: "ajax/manageImage.php",
		datatype: "text",
		type: "POST",
		data: {"action": "getForm", "id": id},
		success: function(html) {
			$(".img-form").remove();
			$(".gForm-wrapper").append(html);
		}
	})
}