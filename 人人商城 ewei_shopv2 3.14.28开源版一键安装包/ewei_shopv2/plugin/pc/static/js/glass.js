/*
 show  //正常状态的框
 bigshow   // 放大的框的盒子
 smallshow  //缩小版的框
 mask   //放大的区域（黑色遮罩）
 bigitem  //放大的框

 */
//        var obj = new mag('.show', '.bigshow','.smallshow','.mask','.bigitem');
//        obj.init()
function mag(show, bigshow,smallshow,mask,bigitem) {
    this.show = show;
    this.bigshow = bigshow;
    this.smallshow = smallshow;
    this.mask = mask;
    this.bigitem = bigitem;
    this.obj = {
        glassPrev: '.prev',
        glassNext: '.next',
        middle: '.middle',
        middleBox: '.middle_box'
    }
}
mag.prototype = {
    init: function () {
        var that = this;
        that.start();
        this.showHover();
        this.smallImgHover();
        this.showMove();
        this.prevClick();
        this.nextClick();
    },
    start: function () {
        var that = this;
        var buil=$(that.show).width()/$(that.mask).width()*$(that.bigshow).width();
        $(that.bigitem).css("width",buil);

        $(that.smallshow + ' img').eq(0).css("border","2px solid #f40");

        var midhei=$(that.obj.middle + ' li').innerWidth()*$(that.obj.middle + ' li').length;
        $(that.obj.middle).width(midhei);

    },
    showHover: function () {
        var that = this;
        $(that.show).hover(function(){
            $(that.bigshow).show();
            $(that.mask).show();
        },function(){
            $(that.bigshow).hide();
            $(that.mask).hide();
        });
    },
    smallImgHover: function () {
        var that = this;
        $(that.smallshow + ' img').click(function(){
            var src=$(this).attr("src");
            $(that.smallshow + ' img').css("border","1px solid #e8e8e8");
            $(this).css("border","2px solid #f40");
            $(that.show + '>img').attr("src",src);
            $(that.bigitem+ '>img').attr("src",src);
        });
    },
    showMove:function(){
        var that = this;
        $(that.show).mousemove(function(e){
            var bigx=$(this).offset().left;
            var bigy=$(this).offset().top;
            var x= e.clientX;
            var y= e.clientY;
            var scrollx=window.scrollX;
            var scrolly=window.scrollY;
            var ox=x+scrollx-bigx-$(that.mask).width()/2;
            var oy=y+scrolly-bigy-$(that.mask).height()/2;
            if(ox<=0){
                ox=0
            }
            if(ox>$(that.show).width()-$(that.mask).width()){
                ox=$(that.show).width()-$(that.mask).width();
            }
            if(oy<=0){
                oy=0
            }
            if(oy>$(that.show).height()-$(that.mask).height()){
                oy=$(that.show).height()-$(that.mask).height();
            }
            $(that.mask).css({left:ox});
            $(that.mask).css({top:oy});
            var bei=$(that.show).width()/$(that.mask).width();
            $(that.bigitem+ '>img').css(
                { marginLeft:-bei*ox,
                    marginTop:-bei*oy
                })
        });
    },
    prevClick: function () {
        var that = this;
        $(that.obj.glassPrev).click(function(){
            if($(that.obj.middle).width()-$(that.obj.middleBox).width()>0){
                if(Math.abs(parseInt($(that.obj.middle).css("marginLeft")))>=$(that.obj.middleBox).width()){
                    $(that.obj.middle).css("marginLeft",parseInt($(that.obj.middle).css("marginLeft"))+$(that.obj.middleBox).width())
                }
                if(Math.abs(parseInt($(that.obj.middle).css("marginLeft")))<$(that.obj.middleBox).width()){
                    $(that.obj.middle).css("marginLeft","0px");
                    $(that.obj.glassNext).removeClass("nextnone");
                    $(that.obj.glassPrev).addClass("prevnone");
                }
            }else{
                return;
            }
        });
    },
    nextClick: function () {
        var that = this;
        $(that.obj.glassNext).click(function(){
            if($(that.obj.middle).width()-$(that.obj.middleBox).width()>0){
                var shuzi=$(that.obj.middle).width()-Math.abs(parseInt($(that.obj.middle).css("marginLeft")))-$(that.obj.middleBox).width();
                if(shuzi>=$(that.obj.middleBox).width()){
                    $(that.obj.middle).css("marginLeft",-$(that.obj.middleBox).width()+parseInt($(that.obj.middle).css("marginLeft")))
                }
                $(that.obj.index);
                if(shuzi<$(that.obj.middleBox).width()){
                    $(that.obj.middle).css("marginLeft",-($(that.obj.middle).width()-$(that.obj.middleBox).width()))
                    $(that.obj.glassNext).addClass("nextnone");
                    $(that.obj.glassPrev).removeClass("prevnone");
                }
            }else{
                return;
            }

        });
    }

}
