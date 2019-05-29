$(document).ready(function() {
    $("a[href^='#']").click(function(e) {
        e.preventDefault();
        location.hash = "";
        console.log($(this).attr("href"));
        $('body').animate({
            scrollTop: $($(this).attr("href")).position().top
        }, 500);
    });
});