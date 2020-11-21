$(function() {
    $.main.init()
});
$.main = {
    init: function() {
        var a = this;
        a.simpleScroll();
        a.swipe();
        $(".show-rankList").on("tap", function(b) {
            $(".ShowBox-bg,.rankList").css("display", "block")
        });
        $(".show-eventInfo").on("tap", function(b) {
            $(".ShowBox-bg,.eventInfo").css("display", "block")
        });
        $(".eventInfo-close,.rankList-close").on("tap", function(b) {
            $(".ShowBox-bg,.eventInfo,.rankList").css("display", "none")
        });
        
    },
    swipe: function() {
        var b = window.location.pathname.split("/").length;
        var a = (parseInt(statsindex) - 1) <= 0 ? 0 : parseInt(statsindex) - 1;
        if (b == 4) {
            a = 0
        }
        window.mySwipe = Swipe(document.getElementById("slider"), {
            startSlide: a,
            loop: false,
            speed: 1000,
            transitionEnd: function(c, d) {
                $(".slider-but span").removeClass("cur");
                $(".slider-but span").eq(c).addClass("cur")
            }
        })
    },
    simpleScroll: function() {
        var c = $(".warp-top");
        var b = setInterval(function() {
            a(c)
        },
        2000);
        function a(e) {
            var f = e.find("ul:first");
            var d = f.find("li:first").height();
            f.animate({
                "margin-top": -d + "px"
            },
            600,
            function() {
                f.css({
                    "margin-top": "0px"
                }).find("li:first").appendTo(f)
            })
        }
    },
};