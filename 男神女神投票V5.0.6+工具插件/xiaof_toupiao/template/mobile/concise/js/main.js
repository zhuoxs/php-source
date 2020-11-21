define(['jquery', 'xiaof'], function ($) {
    return {
        indexLoad: function (loadUrl, type, Masonry, groups) {
            var masonry;
            var container = $('#container');
            container.imagesLoaded(function () {
                masonry = new Masonry('.grid', {
                    itemSelector: '.grid-item',
                    percentPosition: true
                });
            });
            var page = 1;
            var ajaxLock = false;
            function ajaxload(reload) {
                if (ajaxLock == false) {
                    ajaxLock = true;
                    setTimeout(function () {
                        ajaxLock = false;
                    }, 1000);
                    page++;
                    $("#pagination").html('正在努力加载中...');
                    $.get(loadUrl, {
                        'page': page,
                        'type': type,
                        'groups': groups
                    }, function (data) {
                        if (data == "") {
                            if (reload === true) {
                                container.find(".grid").html("");
                                masonry.destroy();
                            }
                            $("#pagination").unbind();
                            $("#pagination").html('没有更多内容了');
                            ajaxLock = false;
                            return;
                        }
                        result = $(data);
                        if (reload === true) {
                            $("#pagination").click(function () {
                                ajaxload(false);
                            });
                            container.find(".grid").html(result);
                            masonry.destroy();
                            container.imagesLoaded(function () {
                                masonry = new Masonry('.grid', {
                                    itemSelector: '.grid-item',
                                    percentPosition: true
                                });
                            });
                        } else {
                            container.find(".grid").append(result);
                            newElems = result.css({
                                opacity: 0
                            });
                            newElems.imagesLoaded(function () {
                                masonry.appended(newElems, true);
                                newElems.animate({
                                    opacity: 1
                                });
                            });
                        }
                        $("#pagination").html('点击加载更多...');
                        ajaxLock = false;

                    });
                }
            }

            $("#dataload .nav").click(function () {
                $(this).addClass('cur').siblings('.cur').removeClass('cur');
                type = $(this).attr("data-type");
                page = 0;
                ajaxload(true);
            });

            $("#groupload .nav").click(function () {
                if (groups == $(this).attr("data-type")) {
                    $(this).removeClass('cur');
                    groups = "";
                    page = 0;
                    ajaxload(true);
                    return false;
                }
                $("#groupload").find('.cur').removeClass('cur');
                $(this).addClass('cur');
                groups = $(this).attr("data-type");
                page = 0;
                ajaxload(true);
            });

            $("#pagination").click(function () {
                ajaxload(false);
            });
        },
        registerVote: function (goodnode, Swiper) {
            var phonereg = /^((0\d{2,3}-\d{7,8})|(1([358][0-9]|4[579]|66|7[0135678]|9[89])[0-9]{8}))$/;
            var smslock = true;
            var This = this;
            var wait = 60;

            function smstime(_this) {
                if (wait == 0) {
                    _this.html("获取验证码");
                    _this.css("background", _this.attr("bgcolor"));
                    smslock = true;
                    wait = 60;
                } else {
                    _this.attr("bgcolor", _this.css("background-color"));
                    _this.css("background", "#ccc");
                    _this.html("重新发送(" + wait + ")");
                    wait--;
                    setTimeout(function () {
                        smstime(_this);
                    }, 1000);
                }
            }

            function vote(id, _this, parameter) {
                if($(".loadtips").length > 0){
                    $(".loadtips").css("display",'block');
                    setInterval("loadicon()",10);
                }
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
                        var num = result.message.match(/了([0-9]*)[票|赞]/i);
                        var addnum = parseInt(num[1]);
                        _this.html(parseInt(_this.html()) + addnum);

                        var redpacknum = result.message.match(/获得了([0-9|\.]*)元红包/i);
                        if (redpacknum != null) {
                            redpacknum = parseFloat(redpacknum[1]);
                            if(redpacknum > 0){
                                var redpackhtml = '<div id="redpack-layer" onclick="this.parentNode.removeChild(this)"><div class="redpack"><div class="redpack-bg"><div class="redpack-amount">' + redpacknum + '元</div><div class="redpack-tips">红包已发送至您微信账号,查看消息打开领取</div></div></div></div>';
                            }else if(parseInt(redpacknum) == 0){
                                var redpackhtml = '<div id="redpack-layer" onclick="this.parentNode.removeChild(this)"><div class="redpack"><div class="redpack-bg-no"><div class="redpack-amount-no" style="font-size: 16px;">红包擦肩而过<br>谢谢你的参与</div></div></div></div>';
                            }
                            $("body").append(redpackhtml);
                        }
                    } else if (result.errno == 133) {
                        $.xiaof.customconfirm(tips, result.message, {'close': '关闭提示'}, function (data) {
                            vote(id, _this, "&closetips=1");
                        });
                        return;
                    } else if (result.errno == 104) {
                        $.xiaof.alert(tips, '活动仅限本地区参与投票');
                        return;
                    } else if (result.errno == 176) {
                        $.xiaof.customconfirm('随机问答验证', result.message, result.button, function (data) {
                            vote(id, _this, "&verifyask=" + data);
                        });
                        return;
                    } else if (result.errno == 115) {
                        wx.ready(function () {
                            wx.getLocation({
                                success: function (res) {
                                    $.post(window.sysinfo.siteroot + "app/index.php?c=entry&do=verifylocation&m=xiaof_toupiao&sid=" + window.sysinfo.sid + "&i=" + window.sysinfo.uniacid, {
                                        latitude: res.latitude,
                                        longitude: res.longitude
                                    }, function (data) {
                                        var result = $.parseJSON(data);
                                        if (result.errno == 0) {
                                            vote(id, _this);
                                        } else {
                                            $.xiaof.alert(tips, result.message);
                                        }
                                    });
                                },
                                fail: function () {
                                    $.xiaof.alert(tips, "地理位置获取失败。");
                                },
                                cancel: function () {
                                    $.xiaof.alert(tips, "放弃定位");
                                }
                            });
                        });
                        return;
                    } else if (result.errno == 111) {
                        var xphone;
                        var lock = false;
                        var smshtml = ['		<div class="xiaof-form-group">', '			<div class="xiaof-input-group xiaof-box">', '				<div class="xiaof-form-label"><label>手机号</label></div>', '				<div class="xiaof-form-control xiaof-box-item">', '					<input class="xiaof-form-input" type="tel" id="xphone" name="phone" placeholder="请输入您的手机号"/>', '				</div>', '			</div>	', '		</div>	', '		<div class="xiaof-form-group">', '			<div class="xiaof-input-group xiaof-box">', '				<div class="xiaof-form-label"><label>验证码</label></div>', '				<div class="xiaof-form-control xiaof-box-item">', '					<input class="xiaof-form-input" id="xverifycode" type="number" name="code" placeholder="请输入您收到的验证码"/>', '				</div>', '			</div>	', '		</div>	', '		<span class="xiaof-button-small getcode">获取验证码</span>'].join("");
                        $.xiaof.confirm('手机号验证', smshtml, function () {
                            if (lock) {
                                var xverifycode = $("#xverifycode").val();
                                if (xverifycode.length != 4) {
                                    alert("验证码格式错误");
                                } else {
                                    vote(id, _this, "&verifycode=" + xverifycode + "&phone=" + xphone);
                                }
                            } else {
                                alert("请先获取验证码");
                            }
                        });
                        $(".getcode").click(function () {
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
                        return;
                    } else if (result.errno == 1331) {
                        var captchahtml = ['		<div class="xiaof-form-group" style="margin-top: 5px;">', '			<div class="xiaof-input-group xiaof-box">', '				<div class="xiaof-form-label"><label>验证码</label></div>', '				<div class="xiaof-form-control xiaof-box-item">', '					<input class="xiaof-form-input" id="captchavalue" type="number" name="captchavalue" placeholder="输入上图4位数字"/>', '				</div>', '			</div>	', '		</div>	'].join("");
                        $.xiaof.confirm('验证', result.message + captchahtml, function (status) {
                            if (status == 'success') {
                                var captchacodevalue = $("#captchavalue").val();
                                if (captchacodevalue.length != 4) {
                                    $.xiaof.alert(tips, '请输入正确四位数字验证码');
                                } else {
                                    vote(id, _this, "&captchacodevalue=" + captchacodevalue);
                                }
                            }
                        });
                        return;
                    }

                    $.xiaof.alert(tips, result.message);
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

            $(document).on('click', ".vote", function (event) {
                if($(".loadtips").length > 0){
                    $(".loadtips").css("display",'block');
                    setInterval("loadicon()",10);
                }
                event.preventDefault();
                var id = $(this).attr("data-id");
                var _this = goodnode ? goodnode : $(this).siblings('.ballot').find('.goods');

                if (verifycode == true) {

                    var handlerPopupMobile = function (captchaObj) {
                        if($(".loadtips").length > 0){
                            $(".loadtips").css("display",'none');
                            window.clearInterval("loadicon()");
                        }
                        $.xiaof.alert('滑动验证', '<div id="popup-captcha-mobile"></div>');
                        captchaObj.appendTo("#popup-captcha-mobile");
                        captchaObj.onSuccess(function () {
                            var validate = captchaObj.getValidate();
                            vote(id, _this, "&geetest_challenge=" + validate.geetest_challenge + "&geetest_validate=" + validate.geetest_validate + "&geetest_seccode=" + validate.geetest_seccode);
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
                    vote(id, _this);
                }
            });
        },
        imagefileUpload: function (imgvalue) {
            localNum = imgvalue.length;
            if ($("#imagefile").length > 0 && localNum > 0) {
                $.ajaxFileUpload({
                    url: window.sysinfo.siteroot + "app/index.php?c=entry&do=uploadimage&m=xiaof_toupiao&sid=" + window.sysinfo.sid + "&i=" + window.sysinfo.uniacid,
                    secureuri: false,
                    fileElementId: 'imagefile',
                    dataType: 'text',
                    success: function (data) {
                        var result = $.parseJSON(data);
                        if (result.errno == 0) {
                            $.each(result.message, function (k, v) {
                                $("#pic-container").append("<span class='picid' onclick='$(this).remove();'><input type='hidden' name='pics[]' value='" + v + "'/><div class='pic-close'>x</div><img src='" + window.sysinfo.attachurl + v + "'/></span>");
                            });
                        } else {
                            $.xiaof.alert(tips, result.message);
                        }
                    },
                    error: function (data, status, e) {
                        $.xiaof.alert(tips, e);
                    }
                });
            }
        },
        iupload: function (reloadurl, limitpic, phonerequired) {
            function ajaxPost() {
                $.post(window.sysinfo.siteroot + "app/index.php?c=entry&do=save&m=xiaof_toupiao&sid=" + window.sysinfo.sid + "&i=" + window.sysinfo.uniacid, $("#join-form").serialize(), function (data) {
                    var result = $.parseJSON(data);
                    $(".xiaof-tips-loader").hide();
                    if (result.errno == 0) {
                        $.xiaof.alert(tips, result.message, function () {
                            if (reloadurl) {
                                window.location.href = reloadurl;
                            } else {
                                location.reload();
                            }
                        });
                    } else if (result.errno == 109) {
                        feetips();
                    } else {
                        $.xiaof.alert(tips, result.message);
                    }
                });
            }

            $("#form-submit").click(function () {
                localNum = $("#pic-container .picid").length;

                if (localNum <= 0) {
                    $.xiaof.alert(tips, "没有选择照片，不能为空");
                    return;
                }
                if($("#opensound").val() == 1  && $("#mustsound").val() == 1){
                    if ($("#sound").val() == "") {
                        $.xiaof.alert(tips, "没有上传语音，不能为空");
                        return;
                    }
                }
                if($("#openvideo").val() == 1  && $("#mustvideo").val() == 1){
                    if ($("#videofile").val() == "") {
                        $.xiaof.alert(tips, "没有上传视频，不能为空");
                        return;
                    }
                }

                var phonereg = /^((0\d{2,3}-\d{7,8})|(1([358][0-9]|4[579]|66|7[0135678]|9[89])[0-9]{8}))$/;
                var phonereg_mo =  /^((((0?)|((00)?))(((\s){0,2})|([-_－—\s\(]?)))|([+]?))(853)?([\)]?)([-_－—\s]?)(28[0-9]{2}|((6|8)[0-9]{3}))[-_－—\s]?[0-9]{4}$/;//澳门手机号码验证

                if ($("#name").val() == "") {
                    $.xiaof.alert(tips, "名称不能为空");
                } else if (phonerequired && $("#phone").val() == "") {
                    $.xiaof.alert(tips, "手机号不能为空");
                } else if (phonerequired && !phonereg.test($("#phone").val()) && !phonereg_mo.test($("#phone").val())) {
                    $.xiaof.alert(tips, "不是正确手机号");
                } else if (localNum > limitpic) {
                    $.xiaof.alert(tips, "照片最多不超过" + limitpic + "张");
                } else {
                    $.xiaof.loader('正在报名...');
                    if ($("#videofile").length > 0 && $("#videofile").val().length > 0) {
                        $.get(window.sysinfo.siteroot + "app/index.php?c=entry&do=token&m=xiaof_toupiao&sid=" + window.sysinfo.sid + "&i=" + window.sysinfo.uniacid, function (data, status) {
                            if (status == 'success') {
                                var formData = new FormData();
                                formData.append('file', $("#videofile")[0].files[0]);
                                formData.append('token', data);
                                formData.append('accept', 'text/plain; charset=utf-8');
                                $.ajax({
                                    url: 'https://upload.qiniup.com/',
                                    type: 'POST',
                                    data: formData,
                                    contentType: false,
                                    processData: false,
                                    success: function (data) {
                                        var result = $.parseJSON(data);
                                        $("#video-input").val(result.key);
                                        ajaxPost();
                                    },
                                    error: function (xhr, data, err) {
                                        if (xhr.status === 413) {
                                            $.xiaof.alert(tips, '上传视频文件超过大小限制');
                                        } else if (xhr.status === 403) {
                                            $.xiaof.alert(tips, '必须是视频格式文件');
                                        } else {
                                            $.xiaof.alert(tips, '视频上传失败');
                                        }
                                    }
                                });
                            } else {
                                $.xiaof.alert(tips, '上传视频参数错误');
                            }
                        });
                    } else {
                        ajaxPost();
                    }
                }
            });
        },
        upload: function (reloadurl, limitpic, phonerequired) {
            var tempPicUrls = Array();

            function ajaxPost(picUrls) {

                var pics = '';
                $.each(picUrls, function (k, v) {
                    pics = pics + '&pics[]=' + encodeURI(v);
                });

                $.post(window.sysinfo.siteroot + "app/index.php?c=entry&do=save&m=xiaof_toupiao&sid=" + window.sysinfo.sid + "&i=" + window.sysinfo.uniacid, $("#join-form").serialize() + pics, function (data) {
                    var result = $.parseJSON(data);
                    $(".xiaof-tips-loader").hide();
                    if (result.errno == 0) {
                        $.xiaof.alert(tips, result.message, function () {
                            if (reloadurl) {
                                window.location.href = reloadurl;
                            } else {
                                location.reload();
                            }
                        });
                    } else if (result.errno == 109) {
                        feetips();
                    } else {
                        $.xiaof.alert(tips, result.message);
                        tempPicUrls = picUrls;
                    }
                });
            }

            wx.ready(function () {
                var localIds = Array();
                var picUrls = Array();

                $('#filepicker').on('click', function () {
                    wx.chooseImage({
                        success: function (res) {
                            $.each(res.localIds, function (k, v) {
                                $("#pic-container").append("<span class='picid new-picid' data-id='" + k + "'><div class='pic-close'>x</div><img src='" + v + "'/></span>");
                            });
                            localIds = localIds.concat(res.localIds);
                            $(".new-picid").click(function () {
                                var pid = $(this).attr("data-id");
                                localIds.splice(pid, 1);
                                tempPicUrls.splice(pid, 1);
                                $(this).remove();
                            });
                        }
                    });
                });

                $("#form-submit").click(function () {

                    localNum = $("#pic-container .picid").length;

                    if (localNum <= 0) {
                        $.xiaof.alert(tips, "没有选择照片，不能为空");
                        return;
                    }
                    if($("#opensound").val() == 1  && $("#mustsound").val() == 1){
                        if ($("#sound").val() == "") {
                            $.xiaof.alert(tips, "没有上传语音，不能为空");
                            return;
                        }
                    }
                    if($("#openvideo").val() == 1  && $("#mustvideo").val() == 1){
                        if ($("#videofile").val() == "") {
                            $.xiaof.alert(tips, "没有上传视频，不能为空");
                            return;
                        }
                    }

                    var phonereg = /^((0\d{2,3}-\d{7,8})|(1([358][0-9]|4[579]|66|7[0135678]|9[89])[0-9]{8}))$/;
                    var phonereg_mo =  /^((((0?)|((00)?))(((\s){0,2})|([-_－—\s\(]?)))|([+]?))(853)?([\)]?)([-_－—\s]?)(28[0-9]{2}|((6|8)[0-9]{3}))[-_－—\s]?[0-9]{4}$/;//澳门手机号码验证

                    if ($("#name").val() == "") {
                        $.xiaof.alert(tips, "名称不能为空");
                    } else if (phonerequired && $("#phone").val() == "") {
                        $.xiaof.alert(tips, "手机号不能为空");
                    } else if (phonerequired && !phonereg.test($("#phone").val()) && !phonereg_mo.test($("#phone").val())) {
                        $.xiaof.alert(tips, "不是正确手机号");
                    } else if (localNum > limitpic) {
                        $.xiaof.alert(tips, "照片最多不超过" + limitpic + "张");
                    } else {
                        $.xiaof.loader('正在报名...');
                        if ($("#videofile").length > 0 && $("#videofile").val().length > 0) {
                            $.get(window.sysinfo.siteroot + "app/index.php?c=entry&do=token&m=xiaof_toupiao&sid=" + window.sysinfo.sid + "&i=" + window.sysinfo.uniacid, function (data, status) {
                                if (status == 'success') {
                                    var formData = new FormData();
                                    formData.append('file', $("#videofile")[0].files[0]);
                                    formData.append('token', data);
                                    formData.append('accept', 'text/plain; charset=utf-8');
                                    $.ajax({
                                        url: 'https://upload.qiniup.com/',
                                        type: 'POST',
                                        data: formData,
                                        contentType: false,
                                        processData: false,
                                        success: function (data) {
                                            var result = $.parseJSON(data);
                                            $("#video-input").val(result.key);
                                            if (localIds == "" || localIds == undefined || localIds == null || localIds.length <= 0) {
                                                ajaxPost(tempPicUrls);
                                            } else {
                                                syncUpload(localIds);
                                            }
                                        },
                                        error: function (xhr, data, err) {
                                            if (xhr.status === 413) {
                                                $.xiaof.alert(tips, '上传视频文件超过大小限制');
                                            } else if (xhr.status === 403) {
                                                $.xiaof.alert(tips, '必须是视频格式文件');
                                            } else {
                                                $.xiaof.alert(tips, '视频上传失败');
                                            }
                                        }
                                    });
                                } else {
                                    $.xiaof.alert(tips, '上传视频参数错误');
                                }
                            });
                        } else {
                            if (localIds == "" || localIds == undefined || localIds == null || localIds.length <= 0) {
                                ajaxPost(tempPicUrls);
                            } else {
                                syncUpload(localIds);
                            }
                        }
                    }
                });

                var i = 0;

                function syncUpload(localIds) {
                    var localId = localIds.pop();
                    setTimeout(function () {
                        wx.uploadImage({
                            localId: localId,
                            isShowProgressTips: 1,
                            success: function (res) {

                                $.get(window.sysinfo.siteroot + "app/index.php?c=entry&do=uploadimg&m=xiaof_toupiao&sid=" + window.sysinfo.sid + "&i=" + window.sysinfo.uniacid, {
                                    'serverid': encodeURI(res.serverId)
                                }, function (data) {
                                    var result = $.parseJSON(data);

                                    if (result.errno == 0) {
                                        picUrls.push(result.message);

                                    } else {
                                        $.xiaof.alert(tips, result.message);
                                        return false;
                                    }

                                    if (localIds.length > 0) {
                                        syncUpload(localIds);
                                    } else {
                                        ajaxPost(picUrls);
                                    }
                                });

                            }
                        });
                        i++;
                    }, 200);
                };

            });
        },
        soundUpload: function () {

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
                                            }, function (data) {
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
                                                    $.xiaof.alert(tips, result.message);
                                                }
                                            });
                                        }
                                    });
                                }
                            });
                        }, 300);
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
                                            }, function (data) {
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
                                                    $.xiaof.alert(tips, result.message);
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

        },
        draw: function (drawUrl) {
            var lockClick = 1;
            var index;
            $(".start").click(function () {

                if (lockClick != 1) {
                    return;
                }
                var math;

                $.get(drawUrl, function (data) {
                    var result = $.parseJSON(data);
                    if (result.errno == 999) {
                        $.xiaof.alert(tips, result.message);
                    } else {
                        math = result.errno;

                        lockClick = 0;
                        $(".draw-box .cur-shade").css({
                            opacity: "0"
                        });
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
                                $("#draw10 .cur-shade").css({
                                    opacity: "0"
                                });
                            }
                            $("#draw" + i + " .cur-shade").css({
                                opacity: "1"
                            });
                            $("#draw" + (i * 1 - 1) + " .cur-shade").css({
                                opacity: "0"
                            });
                            ;
                            if (T == 3) {
                                if (i == (parseInt(math) + 1)) {
                                    $("#draw" + i + " .cur-shade").addClass("draw-cur");
                                    clearInterval(time);
                                    lockClick = 1;
                                    $.xiaof.alert(tips, result.message.tips);
                                    $("#credit-num").html(result.message.credit);
                                    $("#draw-history").prepend(result.message.logs);
                                }
                            }
                        }, 200);
                    }
                });
            });
        },
        showSwiper: function (Swiper) {
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
        },
        showSound: function (src) {
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
        },
        playVoice: function (src) {
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
        },
        indexSound: function () {

            $("body").append('<audio id="sound-play" onended="$(\'.sound-on\').show();$(\'.sound-off\').hide();soundStatus=0;" controls="controls" preload="auto" style="position:absolute; visibility:hidden;"></audio>');
            var soundNode = $("#sound-play");

            $("#container").on('click', '.index-show-sound', function (event) {
                event.preventDefault();
                var src = $(this).attr("data-src");
                var offsrc = $(this).find(".sound-off");
                var onsrc = $(this).find(".sound-on");
                $(".sound-off").hide();
                if (soundStatus == 0) {
                    soundNode.attr("src", src);
                    soundNode[0].play();
                    onsrc.hide();
                    offsrc.show();
                    soundStatus = 1;
                } else if (soundStatus == 1) {
                    soundNode[0].pause();
                    $(".sound-on").show();
                    $(".sound-off").hide();
                    soundStatus = 0;
                }
            });
        },
        indexBgsound: function (audioSrc) {

            $("body").append('<div class="video_exist play_yinfu" id="audio_btn" style="display: block;"><div id="yinfu" class="rotate"></div><audio preload="auto" autoplay="autoplay" id="media" src="' + audioSrc + '" loop></audio></div>');
            var audio = $('#media');
            audio[0].play();
            $("#audio_btn").click(function () {
                $(this).hasClass("off") ? ($(this).addClass("play_yinfu").removeClass("off"), $("#yinfu").addClass("rotate"), $("#media")[0].play()) : ($(this).addClass("off").removeClass("play_yinfu"), $("#yinfu").removeClass("rotate"), $("#media")[0].pause());
            });
        }
    }
});