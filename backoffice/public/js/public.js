$(document).ready(function(){
  initHeaderSplashMargins();
  initButtons();
  initMenuLinks();
  initAmountButtons();

  $(window).resize(function(){
    initHeaderSplashMargins();
  });


});


/*
* FUNCTION
* 
* Initialize Buttons
******************************
*/
function initButtons(){
  // this is the menu-button, which opens or closes the menu.
  $('.nav-open').click(function(){
    var navStatus = $(this).hasClass('nav-open-active');

    if (navStatus == true) {
    // the menu is opened, but it has to close:
    $('.nav-open').removeClass('nav-open-active');
    $('.page').removeClass('page-moved');
  } else {
      // the menu is closed, but it has to open:
      $('.nav-open').addClass('nav-open-active');
      $('.page').addClass('page-moved');
    }
  });

  // this is the close-button, inside the navigation. This button can only close the navigation
  $('.nav-close').click(function(){
    $('.nav-open').removeClass('nav-open-active');
    $('.page').removeClass('page-moved');
  });
}


/*
* FUNCTION
* 
* Initialize Heights
******************************
*/
function initHeaderSplashMargins(){
  var logoHeight = $('.lightblue>.header>.row:first-of-type').height();
  var headerHeight = $('.lightblue>.header').height();
  var splashHeight = $('.splash').height();

  var margin = headerHeight - logoHeight;
  margin -= splashHeight;
  margin = margin /2 - logoHeight;

  $('.splash').css('margin-top', margin);


}

/*
 * Initialize Menu Links
 ******************************
 */
function initMenuLinks() {
  $('.nav-main>li>a').click(function(event){
    event.preventDefault();

    href = $(this).attr('href');

    // remove Open class
    $('.nav-open').removeClass('nav-open-active');
    $('.page').removeClass('page-moved');

    // after animation, change location
    setTimeout(function(){
      location.href = href;
    },500);
  })
}

