/**
 * Created by tim on 18/11/13.
 */
(function(){
    $('[data-toggle="tooltip"]').tooltip({'placement':'right'});

    console.log($('#main').height());
    var sidebarHeight = $('#sidebar').height();
    $('#main .content').css('min-height',sidebarHeight);
})();