//实现图片的滚屏加载


var lastTime = 0;
var prefixes = 'webkit moz ms o'.split(' '); //各浏览器前缀

var requestAnimationFrame = window.requestAnimationFrame;
var cancelAnimationFrame = window.cancelAnimationFrame;

//通过遍历各浏览器前缀，来得到requestAnimationFrame和cancelAnimationFrame在当前浏览器的实现形式
for (var i = 0; i < prefixes.length; i++) {
    if (requestAnimationFrame && cancelAnimationFrame) {
        break;
    }
    prefix = prefixes[i];
    requestAnimationFrame = requestAnimationFrame || window[prefix + 'RequestAnimationFrame'];
    cancelAnimationFrame = cancelAnimationFrame || window[prefix + 'CancelAnimationFrame'] || window[prefix + 'CancelRequestAnimationFrame'];
}

//如果当前浏览器不支持requestAnimationFrame和cancelAnimationFrame，则会退到setTimeout
if (!requestAnimationFrame || !cancelAnimationFrame) {
    requestAnimationFrame = function (callback, element) {
        var currTime = new Date().getTime();
        //为了使setTimteout的尽可能的接近每秒60帧的效果
        var timeToCall = Math.max(0, 16 - (currTime - lastTime));
        var id = window.setTimeout(function () {
            callback(currTime + timeToCall);
        }, timeToCall);
        lastTime = currTime + timeToCall;
        return id;
    };

    cancelAnimationFrame = function (id) {
        window.clearTimeout(id);
    };
}

//得到兼容各浏览器的API
window.requestAnimationFrame = requestAnimationFrame;
window.cancelAnimationFrame = cancelAnimationFrame;


function bannerslider(obj) {
    if (obj.length > 0) {
        obj.each(function () {
            var _this = $(this);
            var _winW = $('body').width();
            var _oBox = _this.find('.fullscreen-box');
            var _oUl = _oBox.find('.fullscreen-box-in');
            var _oW = _this.width();
            var _oLen = _oBox.find('li').length;
            var _oBtn = _this.find('.fullscreen-btn');
            var _oCount = 0;
            var _oAutoplay, startX = 0, endX, distance, autoPlay;//触摸开始时手势横坐标
            var isMove = true;
            var original_left = 0;
            _oUl.css({width: _oW * _oLen});
            for (var i = 0; i < _oLen; i++) {
                _oBtn.append('<span></span>');
            }
            ;
            function _Original() {
                _oBtn.find('span').eq(_oCount).addClass('active').siblings().removeClass('active');
                _oUl.stop().animate({left: -_oCount * _oW}, 800);
            }

            _Original();
            _oBtn.find('span').click(function () {
                _oCount = $(this).index();
                _Original();
            });
            function _autoplay() {
                _oAutoplay = setInterval(function () {
                    _oCount++
                    if (_oCount >= _oLen) {
                        _oCount = 0;
                    }
                    _Original()
                }, 6000);
            }

            _autoplay();
            obj.mouseover(function () {
                clearInterval(_oAutoplay)
            }).mouseleave(function () {
                _oCount = _oCount;
                _autoplay();
            });
            function blindtouchevent() {
                document.getElementById('banner').addEventListener('touchstart', touchStartFunc, false);
                document.getElementById('banner').addEventListener('touchmove', touchMoveFunc, false);
                document.getElementById('banner').addEventListener('touchend', touchEndFunc, false);
            }

            // 获取触摸时的位置

            function touchStartFunc(e) {
                event.preventDefault();
                clearInterval(_autoplay)
                var touch = e.touches[0];
                _startx = Number(touch.pageX);
                original_left = _this.position.left;
            };
            function touchMoveFunc(e) {
                event.preventDefault();
                clearInterval(_autoplay)
                if (isMove) {

                    distance = Number(_startx - e.touches[0].pageX);
                    // console.log("distance----"+distance);
                }

            };
            function leftSlider() {
                _oCount--;
                if (_oCount < 0) {
                    _oCount = 0;
                }
                _Original()

            };
            function rightSlider() {
                _oCount++;
                if (_oCount >= _oLen) {
                    _oCount = 0;
                }
                _Original();

            };
            function touchEndFunc(e) {
                event.preventDefault();
                clearInterval(_autoplay)
                // _oCount =_oCount;
                // _autoplay()

                isMove = false;
                endX = e.changedTouches[0].pageX;

                distance = Number(endX - _startx);
                // alert(distance)
                if (Math.abs(distance) > _winW / 10) { //exceed 1/7
                    if (distance > 0) { //right
                        // alert('向左滑动')
                        leftSlider();
                    } else { //left
                        // alert('向右滑动')
                        rightSlider();
                    }
                } else {
                    MotoToOriginal();
                }
                ;
            };
            blindtouchevent();

        });
    }
    ;
};

function closeview() {
    var close = document.createElement("a");
    close.className = "close";
    if (!document.querySelector(".close")) {
        document.body.appendChild(close);
        close.href = "javascript:;";
        close.style.display = "block";
        close.style.width = "7.5rem";
        close.style.height = "45px";
        close.style.position = "fixed";
        close.style.left = "0";
        close.style.bottom = "0";
        close.style.lineHeight = "45px";
        close.style.textAlign = "center";
        close.style.color = "#888";
        close.style.zIndex = "1000000";
    } else {

        $(".close").removeClass("none");
    }
}

var setScrT;

var openveiewani;


function prevent(event) {
    event.preventDefault();
}

function slideOpen(resource, target) {
    resource.click(function () {
        if (target.attr("src") == "javascript:;") {
            target.attr("src",target.data("url"))
        }
        if($(".hbbox").length > 0) {
            $(".hbbox").hide();
        }
        window.sct = document.body.scrollTop;
        $("#menu").hide();
        Array.prototype.slice.call(document.querySelectorAll(".iframew")).forEach(function (item) {
            item.contentWindow.document.addEventListener("touchmove", prevent, false);
        })
        target.addClass("openview");
        var _top = 100;
        cancelAnimationFrame(openveiewani);
        var _reqAni = function () {
            openveiewani = requestAnimationFrame(_reqAni);
            target.css({
                top: (_top -= (_top / 5)) + "%"
            });
            if (_top <= 0.1) {
                target.css({
                    top: "0%"
                });
                cancelAnimationFrame(openveiewani);
            }
        };
        _reqAni();
        //target.siblings("div").addClass("alpha");
        setTimeout(function () {
            //target.siblings("div").addClass("none");
            closeview()
        }, 400);

    });
}
function slideClose() {
    $(document).delegate(".close", "click", function () {

        if($(".hbbox").length > 0) {
            $(".hbbox").show();
        }

        $(".openview").siblings("div").removeClass("none alpha");

        var target = $(".openview");
        var _top = 0;
        var _basespeed = 10;
        cancelAnimationFrame(openveiewani);
        var _reqAni = function () {
            openveiewani = requestAnimationFrame(_reqAni);
            target.css({
                top: (_top += (_basespeed -= 0.1)) + "%"
            });
            if (_top >= 99.1) {
                target.css({
                    top: "100%"
                });
                cancelAnimationFrame(openveiewani);
            }
        };
        _reqAni();
        $(this).remove();
        setTimeout(function () {
            $(".openview").removeClass("openview");
            $(".scroll-wrapper").html("");
            $(".container").not(".scroll-wrapper .container").css({
                position: "relative",
                overflow: "auto"
            });
            document.body.scrollTop = window.sct;
            setTimeout(function () {
                $(".container").not(".scroll-wrapper .container").css({
                    opacity: 1
                })
            }, 200)
            $("#menu").show();
        }, 300);
    })
}


function backToTop() {

    var backTop = document.createElement("div");
    backTop.className = "backTop";
    backTop.innerHTML = '<div class="go-top top-button-hide" data-reactid="343"><span data-reactid="344">顶部</span></div>';
    document.body.appendChild(backTop);
    window.addEventListener("scroll", function (event) {
        if (document.body.scrollTop > 800) {
            $(".go-top").removeClass("top-button-hide").addClass("top-button-show")
        } else {
            $(".go-top").addClass("top-button-hide").removeClass("top-button-show")
        }
    });
    goTop();
}


function goTop() {
    var imgtimer;
    $(".go-top").click(function () {
        var _scr = $("body").scrollTop();
        var _reqAni = function () {
            imgtimer = requestAnimationFrame(_reqAni);
            if (_scr > 5000) {
                $("body").scrollTop(_scr -= _scr);
            } else {
                $("body").scrollTop(_scr -= _scr / 5);
            }

            if (_scr <= 1) {
                $("body").scrollTop(0);
                cancelAnimationFrame(imgtimer);
            }
        };
        _reqAni();

        document.addEventListener("touchmove", function (event) {
            cancelAnimationFrame(imgtimer);
        }, false);
    });
}

    var i = 0;
    if (window.location.href.indexOf("index") > -1) {
        setInterval(function () {
            userAction(fixeddata[i].name, fixeddata[i].content, fixeddata[i].headerportarit);
            setTimeout(function () {
                $(".useract").removeClass("useractshow");
            }, 3000)
            i++;
            if (i == fixeddata.length) {
                i = 0;
            }
        }, 5000)
    }


//var fixeddata = [
//    {
//        name: "west",
//        content: "成功领取了100元优惠券一张",
//        headerportarit: "http://t.mec-ty.com/chuan/chacha/images/01.jpg"
//    },
//    {
//        name: "萨尔发",
//        content: "成功领取了50元优惠券一张",
//        headerportarit: "http://t.mec-ty.com/chuan/chacha/images/02.jpg"
//    },
//    {
//        name: "三个人",
//        content: "成功领取了10元优惠券一张",
//        headerportarit: "http://t.mec-ty.com/chuan/chacha/images/03.jpg"
//    },
//    {
//        name: "如果",
//        content: "成功领取了100元优惠券一张",
//        headerportarit: "http://t.mec-ty.com/chuan/chacha/images/04.jpg"
//    },
//    {
//        name: "的推介会的",
//        content: "成功领取了10元优惠券一张",
//        headerportarit: "http://t.mec-ty.com/chuan/chacha/images/05.jpg"
//    },
//    {
//        name: "认识",
//        content: "成功领取了50元优惠券一张",
//        headerportarit: "http://t.mec-ty.com/chuan/chacha/images/06.jpg"
//    }
//
//
//];


/*流量闪充*/
function flow() {
    var flowtel = $(".flowtel");
    var val;
    var reg = /^\d*$/;
    flowtel.on("input", function () {
        val = $(this).val();
        if (!reg.test(val)) {
            $(this).val("");
        }
        if (val.length == 11) {
            $(".disable").removeClass("disable");
            $(".nobtn").css({
                display: "none"
            })
        } else {
            $(".flow-btn").addClass("disable");
            $(".nobtn").css({
                display: "block"
            })
        }
    });

    $(".flow-slide").click(function () {
        if ($(this).attr("choosen") == "true") {
            $(this).find("span").removeClass("flow-slide-rg").addClass("flow-slide-lf");
            $(this).removeClass("flow-slide-red").addClass("flow-slide-gray");
            setTimeout(function () {
                $(this).find("span").removeClass("flow-slide-lf");
                $(this).removeClass("flow-slide-gray");
            }.bind(this), 300);
            $(this).attr("choosen", "false");
        } else {
            $(this).find("span").addClass("flow-slide-rg");
            $(this).addClass("flow-slide-red");
            $(this).attr("choosen", "true");
        }

    })
}


/*动效弹出框*/
function popwindow(title, content) {
    var pop;
    if (!document.querySelector(".popw")) {
        var popw = document.createElement("div");
        document.body.appendChild(popw);
        popw.className = "popw";
        popw.innerHTML = "<div class='popwbg'></div><div class='popwbox'><div class='popwtitle'></div><div class='popwcontent'></div><div><div class='popwcc'><a href='javascript:;' class='popwcancel'>取消</a><a href='javascript:;' class='popwcomfirm tixiancomfirm'>确定</a></div></div></div>"
        canclepopw();
    }
    $(".popwtitle").html(title);
    $(".popwcontent").html(content);
    pop = document.querySelector(".popw")
    pop.style.display = "-webkit-box";
    $(".popwbox").addClass("popwboxshow");

    $(".tixiancomfirm").click(function () {
        $.ajax({
            type: "post",
            url: "/Customer/Settlement",
            dataType: "json",
            success: function (data) {
                if (data.statusCode == "200") {
                    alert("提现成功");
                }
                else {
                    alert(data.message);
                }
            }
        });

    })
}


/*淘口令*/
function popTao(img, title, content, tip,iosmsg) {
    var pop;
    if (!document.querySelector(".popw")) {
        var frag = document.createDocumentFragment(), html = "";
        var popw = document.createElement("div");
        frag.appendChild(popw);
        popw.className = "popw";
        html += "<div class='popwbg'></div>";
        html += "<div class='popwbox taobox'>";
        //html += "<div class='taologo' style='background-image:url(" + img + ")'></div>";
		html += "<div class='taologo'><img src=" + img + " style='border-radius:50%'></div>";
        html += "<div class='taocon'>";
        html += "<div class='taotitle'>";
        html += "<div class='popwtitle taotitle'>长按虚线框内文字——>>全选——>>复制</div>";
        html += "<div class='popwcontent' id='taocontent'></div>";
        html += "</div></div>";
        html += "<div class='taotip'>提示：复制成功，打开淘宝将会自动跳转相应页面</div>";
        html += "<div class='taokaobox'>";
        if (!tip) {
            if (isIos()) {
                html += "<textarea class='copybox1' style='display:none'>" + content + "</textarea><a href='javascript:;' class='taokao taokaocopy'><img src='../addons/tiger_taoke/template/mobile/tbgoods/style9/images/copy.png'></a>";
            } else {
                html += "<textarea class='copybox1' style='display:none'>" + content + "</textarea><a href='javascript:;' class='taokao taokaocopy'><img src='../addons/tiger_taoke/template/mobile/tbgoods/style9/images/copy.png'></a>";
            }
        } else {
            html += "<a href='javascript:;' class='taokao'>" + tip + "</a>";
        }

        html += "</div>";
        html += "</div>";
        popw.innerHTML = html;
        document.body.appendChild(frag);
        canclepopw();

    }
    //$(".popwtitle").html(title);
	 if (isIos()) {
		 content=content.replace(/\r\n/g, "<br/>")
	    $(".popwcontent").html("<div id='copy_key_ios'>" + iosmsg + "</div>" + "<textarea class='copybox' style='text-align:left' id='copy_key_android'>" + iosmsg + "</textarea>");
	 }
	  $(".popwcontent").html("<div id='copy_key_ios'>" + content + "</div>" + "<textarea class='copybox' style='text-align:left' id='copy_key_android'>" + content + "</textarea>");
    
    pop = document.querySelector(".popw");
    pop.style.display = "-webkit-box";
    $(".popwbox").addClass("popwboxshow");
    $(".copybox").on("input", function () {
        $(this).val(content);
    });

    //个人中心伙伴页面区分
    if($(".partnerwx").length < 1) {
        selection()
    } else {
        $(".copybox").hide();
    }

}




/*取消*/
function canclepopw() {
    $(".popwcancel,.popwbg,.popwcomfirm").click(function () {
        $(".popwbox").removeClass("popwboxshow");
        $(".popw").remove();
    })
}


/*点击搜索热门*/
function searchList() {
    $(document).delegate(".searchlist a", "click", function () {
        $(".searchcon").val($(this).html())
    })
}

/*悬浮提示框*/
function userAction(name, content, headerportrait) {
    var act;
    if (!document.querySelector(".useract")) {
        var useract = document.createElement("div");
        document.body.appendChild(useract);
        useract.className = "useract";

    }
    act = document.querySelector(".useract");
    act.innerHTML = "<img src='" + headerportrait + "'>" + name + ":" + content;
    act.classList.add("useractshow");
}


/*掉微信图集*/
function openWXimg() {

    $(".pjimg").each(function (index) {
        var imgsObj = $(this).find("div");
        var imgs = new Array();
        for (var i = 0; i < imgsObj.size(); i++) {
            imgs.push(imgsObj.eq(i).attr('src'));
        }

        $(this).find("div").on('click', function () {
            WeixinJSBridge.invoke('imagePreview', {
                'current': $(this).attr('src'),
                'urls': imgs
            });
        });
    })

}

function selection() {
    if (isIos()) {
		$("#copy_key_ios").css({
            "display": "block",
			"text-align": "left"
        });
        $("#copy_key_android").css("display", "none");
    } else {
        $("#copy_key_ios").css({
            "display": "block",
			"text-align": "left",
            opacity: 0,
            position: "relative",
            "z-index": 1
        });
        $("#copy_key_android").height($("#copy_key_ios").height() + "px");
        $("#copy_key_ios").hide();

    }
    document.addEventListener("selectionchange", function (e) {
        if (window.getSelection().anchorNode.parentNode.id == 'copy_key_ios' || window.getSelection().anchorNode.id == 'copy_key_ios') {
            var key = document.getElementById('copy_key_ios');
            window.getSelection().selectAllChildren(key);
        }
    }, false);

}



function replyAsking() {

    var fy = $(".fenyong");
    var tg = $(".taogu");
    var rs = $(".replyasking");
    var hc = $(".ordercopyhow");
    var wdl = $(".whydaylong");
    fy.click(function () {
        $(".replyasking").html("i am the fenyong ");

    });
    tg.click(function () {
        $(".replyasking").html("i am the 淘宝鼓励金");

    });
    hc.click(function () {
        $(".replyasking").html("就是这么复制的");

    });
    wdl.click(function () {
        $(".replyasking").html("因为时间就是这么久");

    });
    //slideOpen(fy, rs);
    //slideOpen(tg, rs);
    slideOpen(hc, rs);
    slideOpen(wdl, rs);
}

window.addEventListener("scroll", function () {
    imgScrollIndex = 0;
    scrollLoadingImg(null, document.documentElement.clientHeight);
}, false);


//延时监听
setTimeout(function () {
    //监听物理返回按钮
    window.addEventListener("popstate", function (e) {
        $(".close").click();
        $(".close").hide();
        $("#menu").show();
    }, false);

}, 300);
/**
 * [pushHistory 写入空白历史记录]
 * @author 邱先生
 * @copyright 烟火里的尘埃
 * @version [V1.0版本]
 * @date 2016-07-30
 * @return {[type]} [description]
 */
function pushHistory() {
    var state = {
        title: "title",
        url: "#"
    };
    window.history.pushState(state, "title", "#");
}



function getReturnMuch() {
    var id = $(".goodsget").data("id");
    $.ajax({
        type: "post",
        url: "../app/index.php?i="+weid+"&c=entry&do=GetCoupon&m=tiger_taoke",
        dataType: "json",
        data: { commodityID: id },
        success: function (data) {
            $(".detailfanmoney").html(data.commission + "");

        }
    });
}

$(function () {
    bannerslider($('.fullscreen-contain'));
    backToTop();
    searchList();
    openWXimg();
    flow();
    replyAsking();

    $(".comefrom").each(function() {
        if($(this).html() == "去淘宝") {
            $(this).css({
                "background-image": "url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEYAAABGCAYAAABxLuKEAAAKHElEQVR42u2bC1MUVxbH+xvwAayKOAPGV0WlkuxurF2wNlqrYRGNiboa4tsoIqiASkBBEYEy+Fh1TTRqjLgmPmdEjUmpUTEJ6ytirMR3fKMozvRrprun++y5IztuM9O3u4eRUuFf9Ssu3HMf59/dZ26DMlblGeSMQ1KRSsSN1CMNCIfAcwbXvLf65r1WNu89jomVPIOdKYgLURB4wVGac0mJ3pB3HJ0QNwIvKW6Soz1TUh0pSCMCLzmNSIo1U/7uSENkBNoJMpJGNyXNkYLICLQzZCTFyJROSCMC7ZRGJLzmeNMdbgTaOW69KUMdyQh0ECTlqTHDHC4EOgjiemLKu444REGggyAKEsd4hjtSEehARyrjec9RgUBb4M3oQ76+CFQwnve7uBCIBu+4JBAWTwCxKhu4ecPBMyKBGq/euQbq3esg7d8MQtlE8I7uGep7znAxnhHOegTs4B3TK5gcBBT4f2kNN0AonxJxDDd3GLSUJvlBOXMUfBtLgZ38Fol7XqhnPCOdDQhYZlQCKOdqwVCaCkJVVtg46WA10MTlpVpa3zs+Cbjcd4AvGgH8ogzgF48noPHpwE5PAc8/Eklca2kgxnB2BokrZ4GZVM9D8Izu9jSZsb1BE1gwkvzjN2HrsFkpICzNBP+O1aCcPATq7SugiTyYSZP9oF79BS/EVmIY7uPVaIzhGM8oJ9hBrq0BK+IXjAyN8W1cSHFRBXbWQLwLBoPv8xKQ674FzdsEsZL6qAF8m5eAJ6OHrTwZz2gH2EE5fRisSKiY9GRMRlfQ7t8wvsI+HtSm+/Cspd6+DNy8NKt52jdG2v0vMJWm4fPeLxgvfloAMZEiQ+DyzyAd2ga+LUtA/OdM4MvG4uOSgY93Dvi3r4TAxTNAE3kU+eKRFo35wAF2YGf0wwU4oEk+tpvEYqHsCeqDW9Ff5esX8EKsweTHgGdcd0v74xeNoq6psU0kB9N5GG+GA+wiLPkANM4T+cKeOwbspF7BOGnnCvtmXDsP0tdVwOUNIHNEBTfzL2R/lGJfYzoH4/3QAdHATn8TpB3LQak/HrzF5R/2grgiEz+BnKQfE/srOafYf1zO14J/6xLgZvcn80SNv7qMXvCz/kAdz3jHOiDmTEjE5/2kaR0iRhhJrJrUmj1g4m8CTeKqGdTxjHe8A2wxsSvwJcOoMdL+9cZ+CCyeMTbh3TU1eOUiSak/RuZpNWpTAxhJ2rWcOpbxTnCAHaQdVZhQAPzbytEkZ1i/f4vxmUX9/QKwmX2CcYFfThgcDhuBzfkjiWk16s3fjOtM7S7KWJvGcAUDARTp6ZU9/V0oUQJfMtTwLtC8D7HuJAfjxDU5xhs+vhN8G+a1Cu+UbqbGBH6tMzFmogMsMckZsW6od66gYQNCcXxJOgQunQo7pvOlw4P9bFYfUB8/2wMdOyMJ16Ibo927Rs2X8U5ygBV8X8w3XoR7jGeN4U/jJztB/GwWqA/vBt/AhWXjQ33y8R3wrMVmJwXXUm9RjOE91HwZ75QuYIXAtZ8BRT3aC1VjdWPY6T3xThka+l5cPQ3aQuzMJLIe1Rgi79QEo3ytGoNkdgdp7yrqR6wm+YAvfz/ieK5wAGiCN8In0FE0Lz2IfOwroAn7SZwpmLAlY9BAijEfYcMGfPEgrCEnqXcOXzJYN4bN6gHqvavhBfBiHdaDXqE4qWYV0IT9NvZqbgxXkGw4lvFOxYZdpmHN2TIfNJE1eMepJzG6Mf5dS3Ux5NFks3vpYiwYY2Of5sbwCwcbjmW807ARJeycP+GjcCTyouXvhsX7NuaSYhw0jp3dN6xf2kc3Bvtt7U+9bWJMWbrhWIbN7AKtYnoCKGcPQkv5t5eFYvjit0E6spmAppzDl7jdpB0G6aMJ+0mcKVxOD1zX3BhhSbpBXrEwBuHmvKE7+BHJ+1aF+sXlGdCW4nKTYmDMdGzEgMDFn/S3/d7loT5xRRsbk5eE61owpnyIYT4Mm4WNGBC4VKdb1LcpN9QnrmxjY/KTcF1LxhjkEyNjuLze5NivL2ylg2zPI+2nF1/sNxxLkuRyX9P9zLT4LvobxZgZ8dBapEMbWrwiNAGb7XjSn5OINahvZHJ76uc5QDeG9Ifis534iI4G6fAmUB/dBiL/tvm6+UyNKe5vmBPDZmOjFQifDA97o5br9oT6pb1VYCT56Je6uSwYE4r1by2I8JeAX3XzmRnDFbxumBfD5mAjSriPXwe16R60lG/d1FCM/ON2yoFtmW4+6Ru6MdgfiuUX9o9cN6reC8Wod0yMye9pmBvDzsRGNOS+CoErJyO+ErB53UJxyvnDYCT/V0W6OS0Yo4tXH94Ivwt/2hnqpxqj+Kn5MdysLmCb2U5QTtdEXq9upy42QDNmW6EuVjq4GmjC/lCs+Ek6uVsjv8gW9CExVGPUx3dpOUZnjHz0CzCSuHSILlb5zx7Kb+uqbRsjlA3Ex/NrUteM43aWmhtz64KJMbOxYQPp2zVgpMDluvD4Ayspt7ME/up84PISMdbcGE3wgBVp9y7hfHRjAr/VUvNkuFxsWETeVwU0+dZPDhsjrh5jnojIgnr9LGgProEtaSqO9Rr8eWQU1Rjl5B5qrgyXhw0LyPvppqh3L2KVd4SPzU8AtfF3iLW0hsvB5KUj6yInfmoPaNwjSiFfQc2XsW4KXf6t+YbjfRs+iuE/67iJNaQYD4iJT+b+bLzeMD8Pcm01PqKz6Xf32g9NjMnHBgVyRcykNt0Bbm4ifZ5dxRgYgGik+ThQzh0A3+eTcZ0E/dwF3YO1Srt/FaTdC4Ev6hP8uXLGTa1V3Lyu1P0y3BxsGCCUp+BZ4SaYSXKVknhThGVpeIvvBs37wLhmsA/xxHohmJhUUwni2jGYRCJ1XnF5GhrmCH0vuRcDTXixTffKmCZU2AOk79eRq23oPl/Yy2A8fV6+OEkHNy+BOoYveg3UG+dAPoGPyr/zQKh8+2nfgr74Rj8V3/JPAE1oPIm1YMxcbFiAXBX11vlw979bRfrbBN/6cREOdGIQSwooIH46xtJaDF8QzyFgiUInyDVloY1osg+E0jdIX5sgH1kL0UrzseDfOMHqWhwxpsHuBsXKZDwgfQ/yD9WUuNijXj8FtoUlQDnrxnr5ZztrNTD8x/H1CETFgu7ka5vh35IJ8vENoF6twwJ+j1L3HmOtqcVTdyUa0i+ateoZvjDehcALSZEThIq3QFw2EA97Q0Bc2h+ERb1jMbeL4YviKxDoQEcFMSaV7zCiJakMPz8+DlEQ6CCIgsQxRPyCeBcCHQRxMUTNxiTzHYb8D/3/v+aLO7sRaOe4mZYSSjp3QhoRaKc0Eg+YSMKOZERuh6bISApDk7CocxoiI9BOkJE0xoowMBlpbAemNCIpjB0JpZ07IW4EXlLcJEcmWgmLX0lGXIiCwAuO0pxLMhMrCWWvxCGpSAXiQuqRBoRF4DmDbd5bffNeK5r3HsdY1H8BKsNfGepiaRAAAAAASUVORK5CYII=)"
            })
        }
    });

    var chirldCategory = getId("chirldCategory");

    $(".alltopnavbar a,.index_navbar a").each(function () {
        if (chirldCategory != undefined && $(this).data("id") == chirldCategory) {
            $(this).addClass("cur");
        }
    });





    var topnavopen = false;

    $(".topnavlistbtn,.blackbg").click(function () {
        topnavopen = !topnavopen;

        var i = 0;
        var allnav = $(".alltopnavbar");
        var btnimg = $(".topnavlistbtn img");
        var _h = allnav.outerHeight(true) + 45;
        var blbg = $(".blackbg");
        if (topnavopen) {
            allnav.css({
                transform: "translate(0," + (_h + 1) + "px)",
                webkitTransform: "translate(0," + (_h + 1) + "px)",
                transition: "all 0.3s",
                webkitTransition: "all 0.3s"
            });

            btnimg.css({
                transform: "rotate(180deg)",
                webkitTransform: "rotate(180deg)",
                transition: "all 0.3s",
                webkitTransition: "all 0.3s"
            });
            blbg.show();
        } else {
            allnav.css({
                transform: "translate(0,-" + 0 + "px)",
                webkitTransform: "translate(0,-" + 0 + "px)",
                transition: "all 0.3s",
                webkitTransition: "all 0.3s"
            });
            btnimg.css({
                transform: "rotate(0)",
                webkitTransform: "rotate(0)",
                transition: "all 0.3s",
                webkitTransition: "all 0.3s"
            });
            blbg.hide();
        }
    })

    $(".fankuitypelist a").click(function () {
        $(this).addClass("cur").siblings().removeClass("cur");
    })
    $(".ideaintrotext").on("input", function () {
        var val = $(this).val();
        $(".idearule").html(val.length + "/200")
        if (val.length >= 10 && val.length <= 200) {
            $(".ideasub").addClass("ideacansub");
        } else {
            $(".ideasub").removeClass("ideacansub");
        }
    })

    setTimeout(function () {
        scrollLoadingImg(null, screen.availHeight);
    }, 1000)


    $(".flow-down-up li").click(function () {
        $(this).addClass("active").siblings().removeClass("active")
    })

    $(".newusertx").click(function () {
        popwindow("提现", "点击确定剩余款项将会全部转入您的微信账号")
    })

    $(document).delegate(".partnerwx", "click", function () {

        if ($(this).attr('data-wx') == "") {
            popTao($(this).attr("data-img"), "", "暂未上传微信号", "长按复制微信号，在微信app内添加朋友");
        } else {
            popTao($(this).attr("data-img"), "", $(this).attr("data-wx"), "长按复制微信号，在微信app内添加朋友");
        }


        $(".taokaobox").html('<a href="javascript:;" class="taokao">长按复制微信号，在微信app内添加朋友</a>')

        $(".popwcontent").css({
            "text-align": "center"
        })
    });

    $(document).delegate(".partnerphone", "click", function () {
        if ($(this).attr('data-phone') == "") {
            popTao($(this).attr("data-img"), "", "暂无电话号码");
        } else {
            popTao($(this).attr("data-img"), "", $(this).attr("data-phone"));
        }

        $(".taokaobox").html("<div class='popwcc'><a href='javascript:;' class='popwcancel' onclick='$(\".popwbg\").click()'>取消</a><a href='tel:" + $(this).attr("data-phone") + "' class='popwcomfirm'>拨打</a></div>")
        $(".popwcontent").css({
            "text-align": "center"
        })
    })


    $(".userlist06").click(function () {
        if ($(this).attr('data-phone') == "") {
            popTao($(this).attr("data-img"), "", "cs88888888");
        } else {
            popTao($(this).attr("data-img"), "", $(this).attr("data-phone"));
        }

        $(".taokaobox").html("<div class='popwcc'><a href='javascript:;' class='popwcancel' onclick='$(\".popwbg\").click()'>取消</a><a href='tel:" + $(this).attr("data-phone") + "' class='popwcomfirm'>拨打</a></div>")
        $(".popwcontent").css({
            "text-align": "center"
        })
    })

    var i = 0;

    $(".upgood_icon").click(function () {
        $(this).toggleClass("bezan");
        var num = Number($(this).parent().find(".upgood_num").html());
        if ($(this).hasClass("bezan")) {
            $(this).parent().find(".upgood_num").html(++num)
        } else {
            $(this).parent().find(".upgood_num").html(--num)
        }
    });


	
//    $(document).delegate(".goods_list a", "click", function () {
//        if ($(this).hasClass("new-coupon")) return;
//		if ($(this).hasClass("new-coupon")) return;
//		var fxtitle=$(this).attr("fxtitle");
//		var fxlink=$(this).attr("fxlink");
//		var fximg=$(this).attr("fxlink");
//		fxdata={"title":fxtitle,"imgUrl":imgUrl,"desc":fxtitle,"link":fxlink};
//		alert(fxdata['title']);
//
//         $(selector).undelegate(selector,event,function)
//        event.preventDefault();
//        isLoadingOrIsLoaded("", true, false);
//        window.sct = document.body.scrollTop;
//
//        if ($(".scroll-wrapper").length < 1) {
//            var scroll = document.createElement("div");
//            scroll.className = "scroll-wrapper";
//            document.body.appendChild(scroll);
//        }
//
//
//        $.ajax({
//            type: "get",
//            url: $(this).attr("href"),
//            dataType: "text",
//            success: function (data) {
//                pushHistory();
//                var tscroll = $(".scroll-wrapper");
//                var bodystart = data.indexOf("<body>");
//                var bodyend = data.indexOf("</body>");
//                tscroll.html(data.slice(bodystart + 7, bodyend));
//                /*var frame = $(".goodsframe");
//
//                 frame.attr("src", $(this).attr("href"));*/
//
//                tscroll.addClass("openview");
//
//                $(".container").not(".scroll-wrapper .container").css({
//                    opacity: 0,
//                    position: "fixed",
//                    overflow: "hidden"
//                });
//
//                var _top = 100;
//                cancelAnimationFrame(openveiewani);
//                var _reqAni = function () {
//                    openveiewani = requestAnimationFrame(_reqAni);
//                    tscroll.css({
//                        top: (_top -= (_top / 5)) + "%"
//                    });
//                    if (_top <= 0.1) {
//                        tscroll.css({
//                            top: "0%",
//                        });
//                        cancelAnimationFrame(openveiewani);
//                    }
//                };
//                _reqAni();
//                getReturnMuch();
//                target.siblings("div").addClass("alpha");
//                setTimeout(function () {
//                    target.siblings("div").addClass("none");
//                    closeview();
//                    $(".close").addClass("none");
//                }, 400);
//
//                isLoadingOrIsLoaded("", false, true);
//                scrollLoadingImg(null, screen.availHeight);
//
//                $("#menu").hide();
//
//            }
//        });
//    })

   $(document).delegate("a", "click", function (e) {
        if ($(this).hasClass("new-coupon")) return;

        var url = $(this).attr("href");
        if($("#list_box").length == 0) return;
        //e.preventDefault();
        //$(this).attr("target", "_blank");

        //isLoadingOrIsLoaded("", true, false);
	
        window.localStorage.setItem("top", document.body.scrollTop);
        window.localStorage.setItem("html", $("#list_box").parent().html());
        window.localStorage.setItem("url", window.location.href);
			 
		
    });
	

    if(window.localStorage.getItem("url") == window.location.href && window.localStorage.getItem("top") != "null") {
		
        $("#list_box").parent().html(window.localStorage.getItem("html"));
        document.body.scrollTop = window.localStorage.getItem("top");
        window.localStorage.setItem("top", "null");
        window.localStorage.setItem("html", "null");
        window.localStorage.setItem("url", "null");		
		 	//alert(limit);
		var le=$("#list_box li").length;
		limit=1+Math.ceil(le/10);
			//alert(limit);
		//alert( $("#list_box li").length);
    }	
	


    $(".type_each").each(function (index) {
        $(this).click(function () {
            $(this).addClass("type_each_red").siblings().removeClass("type_each_red").find(".type_box").removeClass("type_box_red");
            $(this).addClass("type_each_red").siblings().find(".red_bottom").css("display", "none");
            $(this).find(".type_box").addClass("type_box_red");
            $(this).find(".red_bottom").css("display", "block");
            var type = $(this).attr("type");
            $("." + type).css("display", "block").siblings().css("display", "none");
        })
    });

    slideOpen($(".shaidan"), $(".publish"));
    slideOpen($(".miaofabu"), $(".publish"));
    slideOpen($(".topsearch"), $(".searchpage"));
    slideOpen($(".questionsearch"), $(".searchpage"));
    slideClose();

});


//收藏删除
function Delcard(ele) {
    this.ele = ele;
};
Delcard.prototype = {
    constructor: Delcard,
    _x: 0,
    _y: 0,
    _movex: 0,
    _movey: 0,
    _touch: null,
    movetimes: 0,
    canmove: false,
    canend: true,
    pNode: function () {
        return this.ele.parentNode;
    },
    prevent: function (event) {
        event.preventDefault()
    },
    isMoved: function () {
        var _ismoved = this.pNode().getAttribute("ismoved");
        if (_ismoved == "true") {
            return true;
        } else {
            this.canmove = false;
            this.movetimes = 0;
            return false;
        }
    },
    getPoint: function (event) {
        var touches = event.targetTouches;
        if (touches.length == 1) {
            var _touch = this._touch = touches[0];
            if (event.type == "touchstart") {
                this._x = _touch.pageX;
                this._y = _touch.pageY;
            }
            return _touch;
        } else {
            return false;
        }
    },
    start: function (event) {
        var that = this;
        this.getPoint(event);
        var _ismoved = this.isMoved(this.pNode());
        if (_ismoved) {
            this.pNode().style.transform = "translate3d(0px,0,0)";
            this.pNode().setAttribute("ismoved", "false");
            setTimeout(function () {
                that.ele.removeChild(document.querySelector(".collzhe"))
            }, 500)

        }
        this.ele.addEventListener("touchmove", that.move.bind(that), false);

    },
    move: function (event) {
        var that = this;
        var _touch = this.getPoint(event);
        if (!_touch) {
            return;
        }
        this._movex = _touch.pageX - this._x;
        this._movey = _touch.pageY - this._y;
        console.log(_touch.pageX, this._movex)
        if (this.movetimes == 0) {
            setTimeout(function () {
                if (Math.abs(that._movex) / Math.abs(that._movey) > 2) {
                    that.ele.addEventListener("touchmove", that.prevent, false);
                    that.pNode().style.transition = "all 0s";
                    that.canmove = true;
                    if (that.canend == true) {
                        that.ele.addEventListener("touchend", that.end.bind(that), false);
                        that.canend = false;
                    }
                    return;
                }
                that.ele.removeEventListener("touchmove", that.move.bind(that), false);
                //that.ele.removeEventListener("touchend", that.end.bind(that), false);
            }, 25);
            that.movetimes++;
        }
        if (that.canmove && this._movex > -100 && this._movex < 0) {
            this.pNode().style.transform = "translate3d(" + that._movex + "px,0,0)";
        }
    },
    end: function (event) {
        console.log(this);
        this.canmove = false;
        this.movetimes = 0;
        this.pNode().style.transition = "all 0.3s";
        if (this._movex < -50) {
            this.pNode().setAttribute("ismoved", "true");
            this.pNode().style.transform = "translate3d(-100px,0,0)";
            var collzhe = document.createElement("div");
            collzhe.className = "collzhe";
            this.ele.appendChild(collzhe)
        } else {
            this.pNode().style.transform = "translate3d(0px,0,0)";
        }
        this._movex = 0;
        this._movey = 0;
        this.ele.removeEventListener("touchmove", this.prevent, false);
    },
    setMove: function () {
        var that = this;
        this.ele.addEventListener("touchstart", function (event) {

            that.start(event);
        }, false);
        /*this.pNode().addEventListener("touchend", function(event) {
         that.end(event);
         }, false);*/
    }
}


Array.prototype.slice.call(document.querySelectorAll(".libox")).forEach(function (ele) {

    var del = new Delcard(ele);
    del.setMove();

});


