// Init Foundation
$(document).foundation();
// Fix for 100% height offpage sidebar
var timer;
$(window).resize(function() {
    clearTimeout(timer);
    timer = setTimeout(function() {
        $('.inner-wrap').css("min-height", $(window).height() + "px" );
        $('#view').css("min-height", ($(window).height()) + "px" );
        $('#view').css("max-height", ($(window).height()) + "px" );
        $('.left-off-canvas-menu').css("max-height", ($(window).height() + 1) + "px" );
        $('body').css("max-height", $(window).height() + "px" );
    }, 40);
}).resize();