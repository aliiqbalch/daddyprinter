
$(document).ready(function(){

  $('#cssmenu > ul > li ul').each(function(index, element){
  var count = $(element).find('li').length;
  
  $(element).closest('li').children('a').append(content);
});


$('#cssmenu > ul > li > a').click(function() {

  var checkElement = $(this).next();

  $('#cssmenu li').removeClass('active');
  $(this).closest('li').addClass('active'); 

  if((checkElement.is('ul')) && (checkElement.is(':visible'))) {
    $(this).closest('li').removeClass('active');
    checkElement.slideUp('normal');
  }
  if((checkElement.is('ul')) && (!checkElement.is(':visible'))) {
    $('#cssmenu ul ul:visible').slideUp('normal');
    checkElement.slideDown('normal');
  }

  if($(this).closest('li').find('ul').children().length == 0) {
    return true;
  } else {
    return false; 
  }

});

});

