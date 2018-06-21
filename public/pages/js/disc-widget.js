
function start_widget() {
    $(".wc-displayed").html($("#disc-content-box").children().clone()[0]);
    
    $(document).on("click", "#widg-arr-right", function(){
        disp = $(".wc-displayed");
        currd--;
        if (currd < 0)
            currd = nbd;
        // console.log(currd);
        disp.empty();
        disp.html($("#disc-content-box").children().clone()[currd]);
    });

    $(document).on("click", "#widg-arr-left", function(){
        disp = $(".wc-displayed");
        currd++;
        if (currd > nbd)
            currd = 0;
        console.log(currd);           
        // disp.empty();
        disp.html($("#disc-content-box").children().clone()[currd]);
    });
}