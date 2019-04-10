$(document).ready(function(){

    $("#mail-btn").on("click", function(){
        toggleInbox();
    });

    $(document).on("click", ".mail-preview", function(){
        toggleMail($(this));
    });

    $(document).on("click", ".mail-del-btn", function(){
        id = ($(this).parent(".mailWrapper").attr("id"));
        $.ajax({
            url: "./utility/mail-manager.php",
            dataType: "text",
            type: "POST",
            data: {"action": "delete", "id": id},
            success: function(ret) {
                removeContent();
                getContent();
            }
        });
    });

    function toggleMail(preview) {
        content = $(preview).siblings(".mail-content");
        if ($(content).css("height") == "0px") {
            $(content).css("height", "auto");
            $(content).css("padding", "15px");
        } else {
            $(content).css("height", "0px");
            $(content).css("padding", "0px");
        }
    }

    function toggleInbox() {
        var side = $("#side-menu");
        if ($(side).css("width") == "150px") {
            $(side).animate({
                "width": "70%",
                "position": "absolute",
            }, 200, getContent());
            $("#mail-btn").addClass("bc-white")
        } else {
            $(side).animate({
                "width": "150px",
                "position": "fixed",
            }, 200, removeContent());
            $("#mail-btn").removeClass("bc-white");
        }
    }

    function getContent() {
        $.ajax({
            url: "./utility/mail-manager.php",
            dataType: "text",
            type: "POST",
            data: {"action": "get"},
            success : function(content) {
                $("#side-menu").append(content);
            }
        });
    }

    function removeContent() {
        $("#inbox").remove();
    }
});