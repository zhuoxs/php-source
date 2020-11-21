//全局js
$(document).ready(function() {
  //更多
  $('.header-contribute').on('click', function() {
    $('.m-mask').fadeIn();
    $('.dialog-artcle').addClass('dialog-artcle-active');
  })

  $('.dialog-artcle .close,.dialog-artcle .ft p,.m-mask').on('click', function() {
    $('.m-mask').fadeOut();
    $('.dialog-artcle').removeClass('dialog-artcle-active');
  })
});
 
