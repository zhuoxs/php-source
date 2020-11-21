/*首页banner动画*/
$(function () {
    /*banner carousel*/
    var btn = $("#slider-btn li");
    var sliderImg = $("#slider-back li");
    var $bannerTxt = $(".banner-text");
    var $sliderTxt = $(".slider-text");
    var $sliderLinkBtn = $(".banner-txt a");
    var iNow = 0;
    btn.each(function (index) {
        $(this).mouseover(function () {
            slide(index);
        });
        $(this).data("index");
    });

    function slide(index) {
        iNow = index;
        btn.eq(index).addClass("active").siblings().removeClass();
        var bannerTxtActive = $bannerTxt.eq(index);
        var slideElements = bannerTxtActive.children();
        bannerTxtActive.siblings(".banner-text").stop(true).fadeOut(100);
        //初始化
        bannerTxtActive.show();
        slideElements.each(function(){
            var $_self = $(this);
            $_self.css({
                opacity: 0,
                top: $_self.data("start_top")||0,
                left: $_self.data("start_left")||0
            });
            $_self.stop(true).delay(400).animate({
                opacity: 1,
                top: $_self.data("to_top"),
                left: $_self.data("to_left")
            }, 1200);
            if($_self.data("class")!==undefined){
                $_self.removeClass($_self.data("class"));
                setTimeout(function(){
                    $_self.addClass($_self.data("class"));
                },0);
            }
        });

        sliderImg.eq(index).siblings().stop().animate({opacity: 0}, 600);
        sliderImg.eq(index).stop().animate({opacity: 1}, 600);

    }

    function autoRun() {
        iNow++;
        if (iNow == btn.length) {
            iNow = 0;
        }
        slide(iNow);
    }
    var timer = null;
    var $_pointsContainer = $("#slider-btn");
    var setBannerInterval = function(){
        var $_activePoint = $_pointsContainer.find(".active");
        timer = setTimeout(function(){
            autoRun();
            setBannerInterval();
        }, $_activePoint.data("delay")||8000);
    };
    setBannerInterval();
    btn.hover(function () {
            clearInterval(timer);
        }, function () {
            setBannerInterval();
        }
    );
    //banner初始化
    slide(0);
});
$(function(){
    //背景跟随鼠标上下动
    var v1 = $(".cloud-service-bgcolor");
    var $window = $(window);
    v1.addClass("bgscroll1");
    var offsetCoords = v1.offset(),
        topOffset = offsetCoords.top,
        boxHeight = v1.outerHeight(),
        bgHeight = 1086,
        speed = 8,
        maxOffset;

    if (bgHeight){
        maxOffset = bgHeight > boxHeight ? bgHeight - boxHeight : 0;
    }
    $(window).scroll(function() {
            if ($window.scrollTop() + $window.height() > topOffset + boxHeight / 2 && topOffset + boxHeight > $window.scrollTop()) {
                var yPos = -(($window.scrollTop() + $window.height() - topOffset) / speed),
                    yCoord = yPos -100;
                if (maxOffset >= 0)
                    yCoord = Math.abs(yPos) < maxOffset ? yPos : -maxOffset;
                var coords = "50% " + yCoord + "px";
                v1.css({
                    backgroundPosition: coords,
                    transition: "background-position 0.3s linear"
                })
            }
        }
    );



    /*行业解决方案*/
    var resizeTimer = "";
    var setPx = 1920;  //设置默认设备的分辨率
    var sexFbl = -790;  //根据默认设备设定的值
    var bodyWidth = $("html").width();
    $(".cloud-scheme-list").css("width",(320*$(".cloud-scheme-list li").length));
    $(".cloud-scheme-list").css("margin-left",(sexFbl-(Math.abs(setPx-bodyWidth)/2)));
    $(window).resize(function() {
        resizeTimer = setTimeout(doResize,0);
    });
    var doResize = function(){
        var changedWidth = $("html").width();
        var margLeft =Math.abs(parseInt($(".cloud-scheme-list").css("marginLeft")));
        var setLeft = "";
        if(bodyWidth>changedWidth)
        {
            setLeft = ((bodyWidth-changedWidth)/2)+margLeft;
            bodyWidth=$("html").width();
        }
        else
        {
            setLeft = margLeft-(changedWidth-bodyWidth)/2;
            bodyWidth=$("html").width();
        }

        $(".cloud-scheme-list").css("margin-left",-setLeft);
    }


    //初始化选中的位置
    $('.cloud-scheme-hidden').marquee({
        auto: false,
        speed: 500,
        showNum: 5,
        stepLen: 1,
        prevElement: $('.scheme-right-btn'),
        nextElement: $('.scheme-left-btn'),
        prevBefore: function() {
            $(".cloud-scheme-list li").removeClass("active");
        },
        prevAfter: function() {
            $(".cloud-scheme-list li").eq(2).addClass("active");
        },
        nextBefore: function() {

            $(".cloud-scheme-list li").removeClass("active");
        },
        nextAfter: function() {
            $(".cloud-scheme-list li").eq(2).addClass("active");
        }
    });


});


