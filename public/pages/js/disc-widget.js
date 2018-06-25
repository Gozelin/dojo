
function start_widget() {
    $(".wc-displayed").html($("#disc-content-box").children().clone()[0]);
    
    $(document).on("click", "#widg-arr-right", function(){
        disp = $(".wc-displayed");
        disp.hide();
        currd--;
        if (currd < 0)
            currd = nbd;
        disp.html($("#disc-content-box").children().clone()[currd]);
        disp.fadeIn();
    });

    $(document).on("click", "#widg-arr-left", function(){
        disp = $(".wc-displayed");
        disp.hide();
        currd++;
        if (currd > nbd)
            currd = 0;       
        disp.html($("#disc-content-box").children().clone()[currd]);
        disp.fadeIn();
    });
}