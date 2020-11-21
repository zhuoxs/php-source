(function ($) {
    $.fn.imgZoom = function () {
        var mask =
            "<div style = 'position: fixed;width: 100%;z-index: 5555; justify-content: center; align-items: center; display: -webkit-flex; height: 100%;top: 0;left: 0;background: rgba(0,0,0,0.5);display:none;' id='imgZoomMask'></div>";
        $("html").append(mask);
        var windowWidth = $(window).width();
        var windowHeight = $(window).height();
        $(window).resize(function () {
            windowWidth = $(window).width();
            windowHeight = $(window).height();
        });
        this.each(function () {
            $(this).click(function () {
                $("#imgZoomMask").show();
                var src = $(this).data("src") == undefined ? $(this).attr("src") : $(this).data("src");
                var img = new Image();
                img.src = src;
                img.onload = function() {
                    var dom = "";
                    var displayWidth = 0;
                    var displayHeight = 0;
                    var style = "";
                    if (img.width > img.height) {
                        displayWidth = windowWidth / 2;
                        displayHeight = img.height * displayWidth / img.width;
                        style = "z-index:6666;position:absolute;top:" +
                            windowHeight / 2 +
                            "px;margin-top:-" +
                            displayHeight / 2 +
                            "px;left:" +
                            windowWidth / 2 +
                            "px;margin-left:-" +
                            displayWidth / 2 +
                            "px;cursor:pointer;";
                        dom = "<img draggable='true' src = '" +
                            src +
                            "' width = '45%' style='" +
                            style +
                            "' id='imgZoomImg'>";
                    } else {
                        displayHeight = windowHeight / 2;
                        displayWidth = displayHeight * img.width / img.height;
                        style = "z-index:6666;position:absolute;top:" +
                            windowHeight / 2 +
                            "px;margin-top:-" +
                            displayHeight / 2 +
                            "px;left:" +
                            windowWidth / 2 +
                            "px;margin-left:-" +
                            displayWidth / 2 +
                            "px;cursor:pointer;";
                        dom = "<img draggable='true' src = '" +
                            src +
                            "' height = '50%' style=' " +
                            style +
                            "' id='imgZoomImg'>";
                    }
                    $("body").append(dom);
//                  $("#imgZoomImg").dragging({
//                      move: "both", //拖动方向，x y both
//                      randomPosition: false //初始位置是否随机
//                  });
                    
                }
            });
        });
        $(document).on("click", "#imgZoomMask", function () {
            $("#imgZoomMask").hide();
            $("#imgZoomImg").fadeOut().remove();
        });
//      $(document).on("mousewheel",function(e,d) {
//          //d 1 上 -1 下
//          if (d === 1) {
//              var width = $("#imgZoomImg").width();
//              var height = $("#imgZoomImg").height();
//              $("#imgZoomImg").css({ "width": width * 1.2, "height": height * 1.2 });
//          }
//          if (d === -1) {
//              var width = $("#imgZoomImg").width();
//              var height = $("#imgZoomImg").height();
//              $("#imgZoomImg").css({ "width": width / 1.2, "height": height / 1.2 });
//          }
//      });
    }
})(window.jQuery)