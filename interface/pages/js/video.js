
/*
	INIT
*/
function getVideoForm(id, init = 0) {
	$(".dId").remove();
	data = new FormData();
	data.append("id", id);
	data.append("action", "getVideoForm");
	var req = new XMLHttpRequest();
	req.onreadystatechange = function() {
		if (req.readyState === 4) {
			$("#upload-btn").before(req.response);
			if (init)
				initTrigger();
			$("#video-input-container tbody").sortable({
				scroll: false,
				tolerance: "pointer",
				containment: "parent",
				axis: "y",
				update: function(event, ui) {
					var vid_order = [];
					$(this).children(".single-input-container:not('.ui-state-disabled')").each(function(){
						vid_order.push($(this).children("input[name='vId']").val());
					});
					vid_order = JSON.stringify(vid_order);
					id = $(this).parent().parent().attr("id");
					console.log(id);
					$.ajax({
						url : "./ajax/manageVideo.php",
						type: "POST",
						dataType : "text",
						data: {	"action": "updateOrder",
								"id": id,
								"order": vid_order},
						success : function(data) {
							console.log(data);
							return data;
						},
						error : function (data) {
							console.log("error on ajax call");
						}
					});
				}
			});
		}
	}
	req.open("POST", "./ajax/manageVideo.php");
	req.send(data);
}

/*
	TRIGGER
*/
function initTrigger() {
	$(document).on("click", ".addVideo", function(){
		popup = $("#video-popup");
		file = $(popup).children("input[type='file']");
		link = $(popup).children("input[type='text']");
		id = $(".dId").attr("id");
		if ($(link).val() == "") {
			insert_vfile(id);
		}
		else {
			insert_vlink(id);
		}
	});
	
	$(document).on("click", ".del-btn", function() {
		dId = $(".dId").attr("id");
		vId = $(this).prevAll("input[type='hidden']").val();
		delete_video(dId, vId);
	});

	$(document).on("change", ".vInput", function() {
		vId = $(this).parent().siblings("input[type='hidden']").val();
		dId = $(".dId").attr("id");
		attr = $(this).attr("name");
		data = new FormData();
		data.append("dId", dId);
		data.append("vId", vId);
		data.append("action", "update");
		data.append(attr, $(this).val());
		req = new XMLHttpRequest();
		req.onreadystatechange = function() {
			if (req.readyState === 4) {
				console.log(req.response);
			}
		}
		req.open("POST", "./ajax/manageVideo.php");
		req.send(data);
	});

	$(document).on("click", ".watch-btn", function() {
		id = $(this).parent().siblings("input[type='hidden']").val();
		getPreview(id);
	});

	$(document).on("click", ".closePreview-btn", function() {
		$(this).parent().remove();
	});
}

/*
	PREVIEW DISPLAY
*/

function getPreview(id) {
	data = new FormData();
	data.append("action", "getPreview");
	data.append("id", id);
	req = new XMLHttpRequest();
	req.onreadystatechange = function() {
		if (req.readyState === 4) {
			console.log(req.response);
			$("body").append(req.response);
		}
	}
	req.open("POST", "./ajax/manageVideo.php");
	req.send(data);
}

/*
	FILE INSERTION
*/
function insert_vfile(id) {
	form = $(".vfile")[0];
	data = new FormData();
	data.append("id", id);
	data.append("action", "insert");
	data.append(form.name, form.files[0], form.files[0].name);
	req = new XMLHttpRequest();
	req.onreadystatechange = function() {
		if (req.readyState === 4) {
			console.log(req.response);
			getVideoForm($(".dId").attr("id"));
		}
	}
	req.open("POST", "./ajax/manageVideo.php");
	req.send(data);
	$("html, body").animate({ scrollTop: $(document).height() });
}

/*
	LINK INSERTION
*/
function insert_vlink(id) {
	form = $(".vlink");
	data = new FormData(form);
	link = $(".vlink").val();
	data.append("id", id);
	data.append("action", "insert");
	data.append("video-link", link);
	prepare_send(data, link);

	function prepare_send(data, link) {
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
					data.append("video-title", title);
					req = new XMLHttpRequest();
					req.onreadystatechange = function() {
						if (req.readyState === 4) {
							getVideoForm($(".dId").attr("id"));
						}
					}
					req.open("POST", "./ajax/manageVideo.php");
					req.send(data);
				}
			});
		}
	}
}

/*
	VIDEO DELETION
*/
function delete_video(dId, vId) {
	data = new FormData();
	data.append("action", "delete");
	data.append("dId", dId);
	data.append("vId", vId);
	var req = new XMLHttpRequest();
	req.onreadystatechange = function() {
		if (req.readyState === XMLHttpRequest.DONE) {
			if (req.status == 200) {
				getVideoForm($(".dId").attr("id"));
			}
		}
	}
	req.open("POST", "./ajax/manageVideo.php");
	req.send(data);
}

//front
function displayVideoPopup(mod) {
	popup = $("#video-popup");
	$(popup).css("display", "flex");
	file = $(popup).children("input[type='file']");
	link = $(popup).children("input[type='text']");
	$("#video-choice").css("display", "none");
	if (mod == 1) {
		$(file).css("display", "block");
		$(link).css("display", "none");
	}
	else {
		$(link).css("display", "block");
		$(file).css("display", "none");
	}
}

function logFormData(fd) {
	if (fd != "undefined") {
		for(var pair of fd.entries()) {
			console.log(pair[0]+ ', '+ pair[1]); 
		}
	}
}