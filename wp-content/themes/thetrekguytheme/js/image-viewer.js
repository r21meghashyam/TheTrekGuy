$(document).ready(function() {
    var temp = '<div class="image-viewer full hide">' +
        '<div class="title-bar full">' +
        '<span class="description">' +
        '</span>' +
        '<span class="closer"><img src="' + $('meta[name=template_url]').attr("value") + '/media/close.png"></span>' +
        '</div>' +
        '<div class="view full">' +
        '<img src="">' +
        '</div>' +
        '<div class="gallery">' +
        '</div>' +
        '</div>';
    $("body").append(temp);
    $(".post-content img").each(function() {
        $(".image-viewer .gallery").append('<div><img src="' + $(this).attr('src') + '"></div>');
    });
    $(".post-content img, .gallery img").click(function() {
        var bimg = $(this);
        $(".image-viewer .view img").attr('src', bimg.attr('src'))
        $(".image-viewer .description").html(bimg.attr('title'));
        $(".image-viewer").removeClass("hide");
    })
    $(".image-viewer .closer").click(function() {
        $(".image-viewer").addClass("hide");
    })

    /* $("body").append("<div class='image-viewer'></div>")
     $(".post-content img").click(function() {
         var bimg = $(this);
         $(".image-viewer").html('<img src="' + bimg.attr('src') + '">')
         $(".image-viewer img").addClass("load");
         $(".image-viewer").show().finish().animate({
             backgroundColor: "rgba(0,0,0,0.9)"
         }, 10);
     })

     $(".image-viewer").click(function() {

         $(this).finish().animate({
             backgroundColor: "transparent"
         }, 1000, function() {
             $(this).hide();
         });
     })*/
});