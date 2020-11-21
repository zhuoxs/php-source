// JavaScript Document

//图片切换

document.charset = "utf-8" 

function focus(index,elem){

    var els=$('#focusnum span');

    els.removeClass('active');

    els.eq(index).addClass('active');

}



function ppt(index,elem){

    var els=$('#pptnum span');

    els.removeClass('active');

    els.eq(index).addClass('active');

}
$(window).load(function(){
 $(".newstext img").each(function(){
 var winwidth = document.body.offsetWidth ;

 if(winwidth>640){
 var biwidth = 640;
 }else if(winwidth>=320){
 var biwidth = 280;
 }else{
 var biwidth = 200;
 }
  var w = $(this).width();
  var h = $(this).height();
   if( w > biwidth ){
     var h = Math.ceil(h*(biwidth/w));
    $(this).width(biwidth);
    $(this).height(h);
}

})
})




function elemclick(elem1,elem2){

    elem1.each(function(i){

        var self=this;

        (function(j){

            $(self).on('click',function(){

                elem2.showelem(j);

            })

        })(i)

    })

}