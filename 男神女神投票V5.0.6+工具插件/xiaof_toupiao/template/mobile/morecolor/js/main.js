var phonereg = /^1([38]\d|4[57]|5[0-35-9]|7[0-9]|8[0-9])\d{8}$/;
var smslock = true;
$(document).ready(function(){

});
function xfdialog(content, isclose) {

    if (isclose) {
        $("#popup-close").show();
    } else {
        $("#popup-close").hide();
    }
    $(".popup-container").html(content);
    $("#dialog").addClass("is-visible");
}

var wait = 60;

function smstime(This) {
    if (wait == 0) {
        This.html("获取验证码");
        smslock = true;
        wait = 60;
    } else {
        This.html("重新发送(" + wait + ")");
        wait--;
        setTimeout(function () {
            smstime(This)
        }, 1000);
    }
}

function playVoice(src) {
    $("body").append('<audio id="voice-play" controls="controls" preload="auto" style="position:absolute; visibility:hidden;" loop></audio>');
    var soundNode = $("#voice-play");
    var soundStatus = 0;
    var offsrc = $(".voice-off");
    var onsrc = $(".voice-on");
    $(".play-voice").click(function () {
        if (soundStatus == 0) {
            soundNode.attr("src", src);
            soundNode[0].play();
            onsrc.hide();
            offsrc.show();
            soundStatus = 1;
        } else if (soundStatus == 1) {
            soundNode[0].pause();
            onsrc.show();
            offsrc.hide();
            soundStatus = 2;
        } else if (soundStatus == 2) {
            soundNode[0].play();
            onsrc.hide();
            offsrc.show();
            soundStatus = 1;
        }
    });
}

function soundPlay(src) {
    $("body").append('<audio id="sound-play" controls="controls" preload="auto" style="position:absolute; visibility:hidden;" loop></audio>');
    var soundNode = $("#sound-play");
    var soundStatus = 0;
    var offsrc = $(".sound-off");
    var onsrc = $(".sound-on");
    $(".show-sound").click(function () {
        if (soundStatus == 0) {
            soundNode.attr("src", src);
            soundNode[0].play();
            onsrc.hide();
            offsrc.show();
            soundStatus = 1;
        } else if (soundStatus == 1) {
            soundNode[0].pause();
            onsrc.show();
            offsrc.hide();
            soundStatus = 2;
        } else if (soundStatus == 2) {
            soundNode[0].play();
            onsrc.hide();
            offsrc.show();
            soundStatus = 1;
        }
    });
}

function showSwiper() {
    var tabsSwiper = new Swiper('#show-container', {
        pagination: '.swiper-pagination',
        paginationClickable: true,
        autoplay: 3000,
        onImagesReady: function () {
            var imgHeight = $(".slide-img").eq(0).height();
            $(".show-lists").height(imgHeight);
        },
        onSlideChangeStart: function () {
            var imgHeight = $(".slide-img").eq(tabsSwiper.activeIndex).height();
            $(".show-lists").height(imgHeight);
        }
    });
}

function vote(id, This, parameter) {
    if($(".loadtips").length > 0){
        $(".loadtips").css("display",'block');
        setInterval("loadicon()",10);
    }
    if (verifycode == true) {
        var handlerPopupMobile = function (captchaObj) {
            xfdialog("滑动验证", true);
            captchaObj.appendTo(".popup-container");
            if($(".loadtips").length > 0){
                $(".loadtips").css("display",'none');
                window.clearInterval("loadicon()");
            }
            captchaObj.onSuccess(function () {
                var validate = captchaObj.getValidate();
                votes(id, This, "&geetest_challenge=" + validate.geetest_challenge + "&geetest_validate=" + validate.geetest_validate + "&geetest_seccode=" + validate.geetest_seccode);
            });
        };
        $.ajax({
            url: window.sysinfo.siteroot + "app/index.php?c=entry&do=captcha&m=xiaof_toupiao&sid=" + window.sysinfo.sid + "&i=" + window.sysinfo.uniacid + "&s=" + (new Date()).getTime(),
            type: "get",
            dataType: "json",
            success: function (data) {
                initGeetest({
                    gt: data.gt,
                    width: "100%",
                    challenge: data.challenge,
                    offline: !data.success,
                    new_captcha: data.new_captcha,
                    product: "float"
                }, handlerPopupMobile);
            }
        });
    } else {
        votes(id, This, parameter);
    }
}

function votes(id, This, parameter) {
    if (!arguments[2]) {
        parameter = "";
    }
    var voteurl = window.sysinfo.siteroot + "app/index.php?c=entry&do=vote&m=xiaof_toupiao&sid=" + window.sysinfo.sid + "&i=" + window.sysinfo.uniacid + "&type=good&id=" + id + parameter;

    $.get(voteurl, function (data) {
        var result = $.parseJSON(data);
        if($(".loadtips").length > 0){
            $(".loadtips").css("display",'none');
            window.clearInterval("loadicon()");
        }
        if (result.errno == 0) {
            //console.log(result.message);
            var num = result.message.match(/了([0-9]*)[票|赞|个]/i);
            var addnum = parseInt(num[1]);
            This.html(parseInt(This.html()) + addnum);

            var redpacknum = result.message.match(/获得了([0-9|\.]*)元红包/i);
            if (redpacknum != null) {
                redpacknum = parseFloat(redpacknum[1]);
                if(redpacknum > 0){
                    var redpackhtml = '<div id="redpack-layer" onclick="this.parentNode.removeChild(this)"><div class="redpack"><div class="redpack-bg"><div class="redpack-amount">' + redpacknum + '元</div><div class="redpack-tips">红包已发送至您微信账号,查看消息打开领取</div></div></div></div>';
                }else {
                    var redpackhtml = '<div id="redpack-layer" onclick="this.parentNode.removeChild(this)"><div class="redpack"><div class="redpack-bg-no"><div class="redpack-amount-no" style="font-size: 16px;">红包擦肩而过<br>谢谢你的参与</div></div></div></div>';
                }
                $("body").append(redpackhtml);
            }
        }
        if (result.errno == 133) {
            xfdialog(result.message, true);
            $("#popup-close").one("click", function () {
                votes(id, This, '&closetips=1');
            });
            return;
        }
        if (result.errno == 104) {
            xfdialog("活动仅限本地区参与投票", true);
            return;
        }
        if (result.errno == 115) {
            wx.ready(function () {
                wx.getLocation({
                    success: function (res) {
                        $.post(window.sysinfo.siteroot + "app/index.php?c=entry&do=verifyLocation&m=xiaof_toupiao&sid=" + window.sysinfo.sid + "&i=" + window.sysinfo.uniacid, {
                            latitude: res.latitude,
                            longitude: res.longitude
                        }, function (data) {
                            var result = $.parseJSON(data);
                            if (result.errno == 0) {
                                votes(id, This);
                            } else {
                                xfdialog(result.message, true);
                            }
                        });
                    },
                    fail: function () {
                        xfdialog('地理位置获取失败', true);
                    },
                    cancel: function () {
                        xfdialog('放弃定位', true);
                    }
                });
            });
            return;
        }

        if (result.errno == 176) {
            var dialogbutton = '<div class="verifycode-button" style="text-align: center; margin-bottom: 12px;">';
            $.each(result.button, function (key, value) {
                dialogbutton = dialogbutton + '<span class="complete-button complete button-bg-color verifyask" style="width: 76%;" data="' + key + '">' + value + '</span>';
            });
            result.message = '<div style="text-align: center; margin-bottom: 8px;"><h3>随机问答验证</h3></div>' + result.message + dialogbutton + '</div>';
            xfdialog(result.message, true);
            $(".verifyask").click(function () {
                votes(id, This, '&verifyask=' + $(this).attr('data'));
            });
            return;
        }
        if (result.errno == 111) {
            var xphone;
            var lock = false;
            var smshtml = '<h3>手机号验证</h3><div class="verifycode"><p>手机号：<input type="tel" id="xphone" name="phone"></p><p>验证码：<input type="number" id="xverifycode" name="v"><span class="getsms">获取验证码</span></p></div><div class="verifycode-button"><span class="complete-button complete button-bg-color">确定</span><span class="complete" onclick=\'$("#dialog").removeClass("is-visible");\'>取消</span></div>';
            xfdialog(smshtml, true);
            $(".getsms").click(function () {
                xphone = $("#xphone").val();
                if (!phonereg.test(xphone)) {
                    alert("不是正确手机号");
                } else {
                    if (smslock == true) {
                        smslock = false;
                        smstime($(this));
                        $.get(window.sysinfo.siteroot + "app/index.php?c=entry&do=getsms&m=xiaof_toupiao&sid=" + window.sysinfo.sid + "&i=" + window.sysinfo.uniacid + "&phone=" + xphone, function (data) {
                            var result = $.parseJSON(data);
                            if (result.errno != 0) {
                                alert(result.message);
                            } else {
                                lock = true;
                            }
                        });
                    }
                }
            });
            $(".complete-button").click(function () {
                if (lock) {
                    var xverifycode = $("#xverifycode").val();
                    if (xverifycode.length != 4) {
                        alert("验证码格式错误");
                    } else {
                        votes(id, This, "&verifycode=" + xverifycode + "&phone=" + xphone);
                    }
                } else {
                    alert("请先获取验证码");
                }
            });
            return;
        }

        if (result.errno == 1331) {
            var captchahtml = '<div class="verifycode"><p>验证码：<input style="width: 108px;" type="number" id="captchavalue" name="captchavalue" placeholder="输入上图4位数字"></p></div><div class="verifycode-button"><span class="captcha-button complete button-bg-color">确定</span><span class="complete" onclick=\'$("#dialog").removeClass("is-visible");\'>取消</span></div>';
            xfdialog('<h3>验证</h3><div style="text-align: center;">' + result.message + captchahtml + '</div>', true);
            $(".captcha-button").click(function () {
                var captchacodevalue = $("#captchavalue").val();
                console.log(captchacodevalue);
                if (captchacodevalue.length != 4) {
                    xfdialog('请输入正确四位数字验证码', true);
                } else {
                    votes(id, This, "&captchacodevalue=" + captchacodevalue);
                }
            });
            return;
        }

        xfdialog(result.message, true);
        if (result.message.indexOf("acid-lists")) {
            new Swiper('.acid-lists', {
                scrollbar: '.swiper-scrollbar',
                autoplay: 3000,
                scrollbarHide: true,
                slidesPerView: 1
            });
        }
    });
}

function soundUpload() {
    wx.ready(function () {
        var START, END, soundlocalId;
        var soundstatus = false;
        $("#sound").click(function () {
            if (!soundstatus) {
                soundstatus = true;
                START = new Date().getTime();
                recordTimer = setTimeout(function () {
                        wx.startRecord({
                            success: function () {
                                localStorage.rainAllowRecord = 'true';
                                $("#sound").html("录音中，点击完成");
                            },
                            cancel: function () {
                                alert('授权录音被拒绝');
                            }
                        });
                        wx.onVoiceRecordEnd({
                            complete: function (res) {
                                $("#sound").html("录制成功，正在上传");
                                soundlocalId = res.localId;
                                wx.uploadVoice({
                                    localId: soundlocalId,
                                    isShowProgressTips: 1,
                                    success: function (res) {
                                        $.get(window.sysinfo.siteroot + "app/index.php?c=entry&do=uploadimg&type=voice&m=xiaof_toupiao&sid=" + window.sysinfo.sid + "&i=" + window.sysinfo.uniacid, {
                                                'serverid': encodeURI(res.serverId)
                                            },
                                            function (data) {
                                                var result = $.parseJSON(data);
                                                if (result.errno == 0) {
                                                    $("#sound").html("录制完成，点击重录");
                                                    $("#sound-container").html("<span class='sound-play'><i class='fa fa-volume-up'></i></span><input type='hidden' name='sound' value='" + result.message + "'/>");
                                                    $(".sound-play").click(function () {
                                                        wx.playVoice({
                                                            localId: soundlocalId
                                                        });
                                                    });
                                                } else {
                                                    xfdialog(result.message, true);
                                                }
                                            });
                                    }
                                });
                            }
                        });
                    },
                    300);
            } else {
                soundstatus = false;
                END = new Date().getTime();

                if ((END - START) < 300) {
                    END = 0;
                    START = 0;
                    clearTimeout(recordTimer);
                } else {
                    wx.stopRecord({
                        success: function (res) {
                            $("#sound").html("录制成功，正在上传");
                            soundlocalId = res.localId;
                            wx.uploadVoice({
                                localId: soundlocalId,
                                isShowProgressTips: 1,
                                success: function (res) {
                                    $.get(window.sysinfo.siteroot + "app/index.php?c=entry&do=uploadimg&type=voice&m=xiaof_toupiao&sid=" + window.sysinfo.sid + "&i=" + window.sysinfo.uniacid, {
                                            'serverid': encodeURI(res.serverId)
                                        },
                                        function (data) {
                                            var result = $.parseJSON(data);
                                            if (result.errno == 0) {
                                                $("#sound").html("录制完成，点击重录");
                                                $("#sound-container").html("<span class='sound-play'><i class='fa fa-volume-up'></i></span><input type='hidden' name='sound' value='" + result.message + "'/>");
                                                $(".sound-play").click(function () {
                                                    wx.playVoice({
                                                        localId: soundlocalId
                                                    });
                                                });
                                            } else {
                                                xfdialog(result.message, true);
                                            }
                                        });
                                }
                            });
                        },
                        fail: function (res) {
                            alert(JSON.stringify(res));
                        }
                    });
                }
            }
        });

        if (!localStorage.rainAllowRecord || localStorage.rainAllowRecord !== 'true') {
            wx.startRecord({
                success: function () {
                    localStorage.rainAllowRecord = 'true';
                    wx.stopRecord({});
                },
                cancel: function () {
                    alert('授权录音被拒绝');
                }
            });
        }
    });
}

function draw(drawUrl) {
    var lockClick = 1;
    $(".start").click(function () {

        if (lockClick != 1) {
            return;
        }
        var math;

        $.get(drawUrl, function (data) {
            var result = new Function('return' + data)();
            if (result.errno == 999) {
                xfdialog(result.message, true);
            } else {
                math = result.errno;

                lockClick = 0;
                $(".draw-box .cur-shade").css({opacity: "0"});
                $(".draw-cur").removeClass("draw-cur");

                var i = 1;
                var T = 1;
                var time = setInterval(function () {
                    i++;
                    if (i > 10) {
                        i = 1;
                        T++;
                    }
                    if (i == 1) {
                        $("#draw10 .cur-shade").css({opacity: "0"});
                    }
                    $("#draw" + i + " .cur-shade").css({opacity: "1"});
                    $("#draw" + (i * 1 - 1) + " .cur-shade").css({opacity: "0"});
                    if (T == 3) {
                        if (i == (parseInt(math) + 1)) {
                            $("#draw" + i + " .cur-shade").addClass("draw-cur");
                            clearInterval(time);
                            lockClick = 1;
                            xfdialog(result.message.tips, true);
                            $("#credit-num").html(result.message.credit);
                            $("#draw-history").prepend(result.message.logs);
                        }
                    }
                }, 200);
            }
        });
    });
}
//选手海报
$('.alert_share_poster').click(function () {
    var item_poster = $('input[name=item_poster]').val();
    var poster_url = $(this).attr('data-poster-url');
    var item_poster_open = $(this).attr('data-item-poster-open');
    //选手照片
    var player_img = $(this).attr('data-poster-img');
    //选手编号
    var player_uid = $(this).attr('data-poster-uid');
    //选手名称
    var player_name = $(this).attr('data-poster-name');
    //二维码图片
    var poster_qrcode = $(this).attr('data-poster-qrcode');
    //文字描述
    poster_font = '截屏保存分享给你的朋友';
    var html = '';
    html += '<div class="member_introduce">';
    html += '<div style="clear:both"></div>';
    html += '</div>';
    html += '<div class="commodity_picture" style="text-align: center; max-height: 280px; overflow: hidden;">';
    html += '<img src="'+player_img+'" alt="" style="width: 100%;">';html += '</div>';
    html += '<div class="commodity">';
    html += '<div class="qrcode col-20" style="width: 55%; float: left;"><img width="100%" src="'+poster_qrcode+'"></div>';
    html += '<div class="col-80" style="width: 45%; float: left; margin-top: 30px; font-size: 16px;">';
    html += '<div class="commodity_name font7" style="word-break:break-all">编号：'+player_uid+'</div>';
    html += '<div class="text-left commodity_price font7" style="word-break:break-all; margin-top: 15px;">姓名：'+player_name+'</div>';
    html += '</div>';
    html += '<div style="clear:both"></div>';
    html += '</div>';
    html += '<div class="text-center prompt_content font5" style="text-align: center;">'+poster_font+'</div>';
    xfdialog(html, true);
    var modal_marginTop = $('.modal').css('marginTop');
    var modal_Top = Math.abs(parseInt(modal_marginTop));
    $('.modal').css('marginTop','-200px');
    if (modal_Top >= 229) {
        $('.modal').css('marginTop','-200px');
    }
    $('.modal .modal-inner').addClass('inner').css('background','#fff');
    $('.modal .modal-buttons').addClass('buttons');
    $('.modal .modal-button').css('border-radius','0 !important').html('关闭').addClass('icon iconfont');

});