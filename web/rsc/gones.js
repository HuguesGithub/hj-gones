$(document).ready(function() {
  $('.separateur').css('border-left-width', $('.main-header').width()+'px');

  $('.main-header .nav li span.hasChildren').unbind().click(function(e){
    e.preventDefault();
    if ($(this).hasClass('active')) {
      $(this).removeClass('active');
      $('.main-header section.submenu').removeClass('active');
      $('.main-header section.submenu > ul').css('display', 'none');
    } else {
      $('.main-header .nav li span').removeClass('active');
      $(this).addClass('active');

      $('.main-header section.submenu').addClass('active');
      $('.main-header section.submenu > ul').css('display', 'none');
      $($(this).data('tab')).css('display', 'flex');
    }
    return false;
  });

  $(window).resize(function(){
    $('.separateur').css('border-left-width', $('.main-header').width()+'px');
  });


  /*
  $('.header_top_but').click(function(){
    var headerTopBut = $(this);
    var headerTopButArrow = headerTopBut.find('> span');
    var headerTopOuter = headerTopBut.parents('.header_top').find('.header_top_outer');
    if (headerTopBut.hasClass('opened')) {
      headerTopOuter.slideUp();
      headerTopBut.removeClass('opened').addClass('closed');
    } else if (headerTopBut.hasClass('closed')) {
      headerTopOuter.slideDown();
      headerTopBut.removeClass('closed').addClass('opened');
    }
  });

  $('.menu-item-mega-container').each(function(){
    $(this).width($('.header_mid_right_wrap').width());
    $(this).css('left', (15-$(this).parent().offset().left));
  });
  $(window).resize(function(){
    $('.menu-item-mega-container').each(function(){
      $(this).width($('.header_mid_right_wrap').width());
      $(this).css('left', (15-$(this).parent().offset().left));
    });
  });
  */

});

