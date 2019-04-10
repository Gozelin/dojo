<?php
session_start();
require_once(PATH_CLASS."Gallery.Class.php");
require_once(PATH_CLASS."DataBase.Class.php");
require_once(PATH_INTER."src/secure.php");
$dataBase = new cDataBase(DATABASE_HOST, DATABASE_ADMIN_LOG, DATABASE_ADMIN_PASSWORD, DATABASE_ADMIN_NAME);
$g = new cGallery(0);
?>

<link rel="stylesheet" href="css/gallery.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="./js/jquery-ui.min.js"></script>
<script src="./js/gallery.js"></script>

<div id="assoc-form-box" class="form-popup undisplayed" style="top: 70px">
	<button style="display: none" id="restore">restore</button>
	<button style="display: none" id="save">save</button>
	<?php echo getQuill("assoc"); ?>
	<?php echo $g->getForm(); ?>
</div>

<script>

ar = "assoc";
assocQuill = new Quill('#editor-'+ar, {
		modules: {
			toolbar: '#toolbar-'+ar
		},
		theme: 'snow'
});

$(document).ready(function() {
	fillQuillAssocPrim();
	$(document).on("focusout", ".ql-editor", function() {
		updateAssocPrim();
	});
	$("#save").click(function() {
		updateAssocPrim();
	});
	$("#restore").click(function(){
		fillQuillAssocPrim();
	});
});

function updateAssocPrim() {
	text = parseQuillDesc("assoc");
	textDelta = assocQuill.getContents();
	textDelta = JSON.stringify(textDelta);
	$.ajax({
		url: "./ajax/ContentAccess.php",
		dataType: "text",
		type: "POST",
		data: {"action": "updateAssocPrim", "text":text, "textDelta": textDelta},
		success: function(ret) {
			console.log(ret);
		}
	});
}

function fillQuillAssocPrim() {
	$.ajax({
		url: "./ajax/ContentAccess.php",
		dataType: "text",
		type: "POST",
		data: {"action":"getAssocPrim"},
		success: function(ret) {
			ret = JSON.parse(ret);
			textDelta = ret.assoc_primDelta;
			textDelta = JSON.parse(textDelta);
			assocQuill.setContents(textDelta);
		}
	})
}

</script>
