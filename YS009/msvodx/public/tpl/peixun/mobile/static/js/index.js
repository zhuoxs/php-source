function AutoScroll(obj) {
    $(obj).find("ul:first").animate({
        marginTop: "-44px"
    }, 500, function() {
        $(this).css({ marginTop: "0px" }).find("li:first").appendTo(this);
    });
}
$(document).ready(function() {
    setInterval('AutoScroll("#focus-nav")', 1500);

    $(".mod-col .view-layer").hover(function(){
        $(this).find(".play-bg").show();
        $(this).find("span").addClass("cur");
    },function(){
        $(this).find(".play-bg").hide();
        $(this).find("span").removeClass("cur");
    });


    /*图片轮播*/
    var index = 0;
    var $_picn = $(".pic").length;
    setInterval(function () {
        show(index);
        index++;
        if (index == $_picn) {
            index = 0;
        }
    }, 3000);

    function show(index) {
        $(".pic").siblings(".pic").fadeOut(700).eq(index).fadeIn(800);
    }


});