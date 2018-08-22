
var currd = 0;

function start_widget(dId) {
    $(".wc-displayed").html($("#disc-content-box").children().clone()[0]);
    display_dot();
    
    setTitle();

    $(document).on("click", "#widg-arr-right", function(){
        disp = $(".wc-displayed");
        disp.hide();
        currd++;
        if (currd >= nbd)
            currd = 0;
        widg_switch(currd);
    });

    $(document).on("click", "#widg-arr-left", function(){
        disp = $(".wc-displayed");
        disp.hide();
        currd--;
        if (currd < 0)
            currd = nbd;
        widg_switch(currd);
    });
}

function widg_switch(nb) {
    disp.html($("#disc-content-box").children().clone()[nb]);
    disp.fadeIn();
    $(".widg-dot").removeClass("widg-dot-activ");
    $("#widg-dot-"+nb).addClass("widg-dot-activ");
    setTitle();

}

function display_dot() {
    var i = 0;
    var activ = "widg-dot-activ";
    while (i < nbd) {
        $(".widg-dot-wrapper").append("<div id='widg-dot-"+i+"' class='widg-dot "+activ+"'></div>");
        i++;
        activ = "";
    }
}

function setTitle() {
    id = $(".widg-dot-activ").attr("id").split("-")[2];
    dTitle = $("#disc-content-"+id).children("h1").html();
    $("#widg-title").html(dTitle);
}