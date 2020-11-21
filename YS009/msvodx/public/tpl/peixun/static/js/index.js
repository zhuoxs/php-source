/*排行榜*/
function AutoScroll(obj) {
    $(obj).find("ul:first").stop(false).animate({
        marginLeft: "-200px"
    }, 500, function() {
        $(this).css({ marginLeft: "0px" }).find("li:first").appendTo(this);
    });
}
/*公告*/
function TipsScroll(obj) {
    $(obj).find("ul:first").stop(false).animate({
        marginTop: "-40px"
    }, 500, function() {
        $(this).css({ marginTop: "0px" }).find("li:first").appendTo(this);
    });
}
$(document).ready(function() {
    setInterval('AutoScroll("#focus-nav")',4000);
    //公告
    if($(".copyright-tips li").length != 1){
        setInterval('TipsScroll(".copyright-tips")',3000);
    }
    /*图片轮播*/
    var index = 1;
    var $_picn = $(".pic").length;
    setInterval(function () {
        show(index);
        index++;
        if (index == $_picn) {
            index = 0;
        }
    }, 4000);

   function show(index) {
        $(".pic").siblings(".pic").hide().eq(index).show();
   }


    /*滚动条离开顶部后*/
    var scrollH = $(document).scrollTop();
    if(scrollH >= 100){
        $("#qheader").addClass("qheader");
    }else{
        $("#qheader").removeClass("qheader");
    }
    $(window).scroll(function(){
        var scrollH = $(document).scrollTop();
        if(scrollH >= 100){
            $("#qheader").addClass("qheader");
        }else{
            $("#qheader").removeClass("qheader");
        }
    });

    //打开页面请求打赏排行
    $.get('/api/rewardranking.html',{nums:5},function(e){
        var html='';
     if(e.resultCode==0){
            e.data.forEach(function (t) {
                html +='<li><div class="place-box"><img src="'+t.headimgurl+'"/></div>';
                html += '<p class="name">'+t.nickname+'</p> <span>打赏金币：'+t.sums+'</span> <p class="place"><strong>打赏排行：</strong>NO.'+t.no+'</p></li>';
            })
           $(".ranking").find('ul').append(html);
        }else if(e.resultCode==4003){
         html='<a class="isnull">暂无打赏数据</a>'
         $(".ranking").append(html);
        }

   },'json');






});