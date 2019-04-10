<?php
    include("../src/secure.php");
?>

<div id="font-manager">
    <h2>Polices</h2>
    <input type="file" name="font-input" id="font-input">
	<label id="font-add-btn" for="font-input">Ajout</label>
    <ul id="font-wrap">
    </ul>
</div>

<script>
$(document).ready(function(){

	parseFontHMTL();

	//ADD
    $(document).on("change", "#font-input", function(){
		var file = $(this)[0].files[0];
		var upload = new Upload(file);
		upload.doUpload("./ajax/addFont.php");
	});
	//DEL
	$(document).on("click", ".font-del-btn", function(){
		var name = $(this).siblings("p").text();
		$.ajax({
			type: "POST",
			url: "./ajax/delFont.php",
			success: function (data) {
				parseFontHMTL();
				return (data);
			},
			data: {"name":name},
		});
    });
});

//copy/pasted code for uploading the font file
var Upload = function (file) {
    this.file = file;
};

Upload.prototype.getType = function() {
    return this.file.type;
};
Upload.prototype.getSize = function() {
    return this.file.size;
};
Upload.prototype.getName = function() {
    return this.file.name;
};
Upload.prototype.doUpload = function (path) {
    var that = this;
    var formData = new FormData();

    // add assoc key values, this will be posts values
    formData.append("file", this.file, this.getName());
    formData.append("upload_file", true);

    $.ajax({
        type: "POST",
        url: path,
        xhr: function () {
            var myXhr = $.ajaxSettings.xhr();
            if (myXhr.upload) {
                myXhr.upload.addEventListener('progress', that.progressHandling, false);
            }
            return myXhr;
        },
        success: function (data) {
			parseFontHMTL();
            return (data);
        },
        error: function (error) {
            return (false);
        },
        async: true,
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        timeout: 60000
    });
};

//parse font html into the page
function parseFontHMTL() {
	$("#font-wrap").empty();
	var str = "";
	jQuery.get("./utility/font.json", function(fonts) {
		fonts.forEach(font => {
			str += "<li class='font-tab'><p>"+font+"</p><div class='font-del-btn'>suppr</div></li>";
		});
		$("#font-wrap").append(str);
	});
}
</script>