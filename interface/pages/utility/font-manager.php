<?php
    include("../src/secure.php");

    fopen("./utility/font.json", "c");
    $f = file_get_contents("./utility/font.json");
    if($f)
        $fonts = json_decode($f);
?>

<div id="font-manager">
    <h2>Polices</h2>
    <input type="file" name="font-input" id="font-input">
    <label id="font-add-btn" for="font-input">add</label>
    <ul id="font-wrap">
        <?php
            foreach($fonts as $font)
            {
                echo "<li class='font-tab'>";
                echo "<p>" . $font . "</p>";
                echo "<div class='font-del-btn'>del</div>";
                echo "</li>";
            }
        ?>
    </ul>
</div>

<script>
$(document).ready(function(){
    addInput = $("#font-add-btn");
    addInput.on("click", function(){
        console.log("trigger");
    });
    $("#font-input").on("change", function(){
        console.log("on change");
        var file = $(this)[0].files[0];
        var upload = new Upload(file);
        upload.doUpload("./ajax/addFont.php");
    });
});

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
            console.log(data);
        },
        error: function (error) {
            console.log("error");
        },
        async: true,
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        timeout: 60000
    });
};

Upload.prototype.progressHandling = function (event) {
    var percent = 0;
    var position = event.loaded || event.position;
    var total = event.total;
    var progress_bar_id = "#progress-wrp";
    if (event.lengthComputable) {
        percent = Math.ceil(position / total * 100);
    }
    // update progressbars classes so it fits your code
    $(progress_bar_id + " .progress-bar").css("width", +percent + "%");
    $(progress_bar_id + " .status").text(percent + "%");
};
</script>