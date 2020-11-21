;(function (factory) {
    if (typeof define === "function" && define.amd) {
        define(["jquery"], factory);
    } else {
        factory(jQuery);
    }
}(function ($) {
    $.extend({
        xiaof: {
            /**
             * 全局变量
             */
            vars: {},
            /**
             * 拼装url
             *
             * @param d
             * @param parameter
             * @returns {string}
             */
            appUrl: function (d, parameter) {
                if (!arguments[1]) {
                    parameter = "";1331
                }
                return window.sysinfo.siteroot + "app/index.php?c=entry&do=" + d + "&m=xiaof_toupiao&sid=" + window.sysinfo.sid + "&i=" + window.sysinfo.uniacid + parameter;
            },
            /**
             * 首页ajax加载选手
             *
             * @param loadUrl
             * @param type
             */
            registerLoadpic: function (type, groups) {
                var masonry;
                var container = $('#container');
                var gridcontainer = container.find('#grid-container');
                var loadmore = $(".weui-loadmore");
                /*container.imagesLoaded(function () {
                    masonry = new Masonry('.grid', {
                        itemSelector: '.grid-item',
                        percentPosition: true
                    });
                });*/
                var page = 1;
                var ajaxLock = false;

                function ajaxload(reload) {
                    if (ajaxLock == false) {
                        ajaxLock = true;
                        page++;

                        $.get($.xiaof.appUrl("index"), {'page': page, 'type': type, 'groups': groups}, function (data) {
                            if (data.replace(/(^\s*)|(\s*$)/g, "").length == "") {
                                if (reload === true) {
                                    gridcontainer.html("");
                                    masonry.destroy();
                                }
                                $(document.body).destroyInfinite();
                                loadmore.hide();
                                $(".weui-loadmore_line").show();
                                ajaxLock = false;
                                return;
                            }
                            var result = $(data);
                            if (reload === true) {
                                gridcontainer.html(result);
                                masonry.destroy();
                                /*container.imagesLoaded(function () {
                                    masonry = new Masonry('.grid', {
                                        itemSelector: '.grid-item',
                                        percentPosition: true
                                    });
                                });*/
                            } else {
                                gridcontainer.append(result);
                                var newElems = result.css({
                                    opacity: 0
                                });
                                /*newElems.imagesLoaded(function () {
                                    masonry.appended(newElems, true);
                                    newElems.animate({
                                        opacity: 1
                                    });
                                });*/
                            }
                            ajaxLock = false;
                            $(".weui-loadmore_start").hide();
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
                    } else {
                        $("#groupload").find('.cur').removeClass('cur');
                        $(this).addClass('cur');
                        groups = $(this).attr("data-type");
                    }
                    page = 0;
                    ajaxload(true);
                });

                var loading = false;
                /*$(document.body).infinite().on("infinite", function () {
                    if (loading) return;
                    loading = true;
                    $(".weui-loadmore_start").show();
                    setTimeout(function () {
                        ajaxload(false);
                        loading = false;
                    }, 1500);
                });*/
            },

            /**
             * 选手图片滚动
             */
            picList: function () {
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
            /**
             * 投票
             *
             * @param id
             * @param goodnode
             * @param parameter
             */
            vote: function (id, goodnode, parameter) {
                if($(".loadtips").length > 0){
                    $(".loadtips").css("display",'block');
                    setInterval("loadicon()",10);
                }
                var phonereg = /^((0\d{2,3}-\d{7,8})|(1([358][0-9]|4[579]|66|7[0135678]|9[89])[0-9]{8}))$/;
                var smslock = true;

                if (!arguments[2]) {
                    parameter = "";
                }

                $.get($.xiaof.appUrl("vote", "&type=good&id=" + id + parameter), function (data) {
                    var result = $.parseJSON(data);
                    if($(".loadtips").length > 0){
                        $(".loadtips").css("display",'none');
                        window.clearInterval("loadicon()");
                    }
                    if (result.errno == 0) {
                        var num = result.message.match(/了([0-9]*)[票|赞]/i);
                        var addnum = parseInt(num[1]);
                        goodnode.html(parseInt(goodnode.html()) + addnum);

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
                    } else if (result.errno == 133) {
                        $.modal({
                            title: tips,
                            text: result.message,
                            buttons: [
                                {
                                    text: "关闭提示", onClick: function () {
                                        $.xiaof.vote(id, goodnode, "&closetips=1");
                                    }
                                }
                            ]
                        });
                        return;
                    } else if (result.errno == 104) {
                        $.alert('活动仅限本地区参与投票');
                        return;
                    } else if (result.errno == 176) {
                        var button;
                        var buttons = new Array();
                        $.each(result.button, function (index, value) {
                            button = {};
                            button.text = value;
                            button.onClick = function () {
                                $.xiaof.vote(id, goodnode, "&verifyask=" + index);
                            };
                            buttons.push(button);
                        });

                        $.modal({
                            title: "随机问答验证",
                            text: result.message,
                            buttons: buttons
                        });
                        return;
                    } else if (result.errno == 115) {
                        wx.ready(function () {
                            wx.getLocation({
                                success: function (res) {
                                    $.post($.xiaof.appUrl("verifylocation"), {
                                        latitude: res.latitude,
                                        longitude: res.longitude
                                    }, function (data) {
                                        var result = $.parseJSON(data);
                                        if (result.errno == 0) {
                                            $.xiaof.vote(id, goodnode);
                                        } else {
                                            $.alert(result.message);
                                        }
                                    });
                                },
                                fail: function () {
                                    $.alert("地理位置获取失败。请检查安全域名是否设置正确");
                                },
                                cancel: function () {
                                    $.toast("放弃定位", "cancel");
                                }
                            });
                        });
                        return;
                    } else if (result.errno == 111) {
                        var xphone;
                        $.prompt('输入手机号验证',
                            function (input) {
                                xphone = input;
                                if (!phonereg.test(xphone)) {
                                    $.alert("不是正确手机号");
                                    var icon = $('.cry-icon').val();
                                    var html = '<div class="tips-info-icon-c"><img src="'+icon+'"></div>';
                                    $('.modal-text').append(html);
                                    $('.modal-button').html('<span class="modal-button-text">确定</span>');
                                } else {
                                    if (smslock == true) {
                                        smslock = false;
                                        $.get($.xiaof.appUrl("getsms", "&phone=" + xphone), function (data) {
                                            var result = $.parseJSON(data);
                                            if (result.errno != 0) {
                                                $.alert(result.message);
                                            } else {
                                                $.prompt('填写收到的短信验证码',
                                                    function (input) {
                                                        var xverifycode = input;
                                                        if (xverifycode.length != 4) {
                                                            $.alert("验证码格式错误");
                                                        } else {
                                                            $.xiaof.vote(id, goodnode, "&verifycode=" + xverifycode + "&phone=" + xphone);
                                                        }
                                                    },
                                                    function (value) {
                                                        $.toast("取消验证", "cancel");
                                                    }
                                                );
                                            }
                                            smslock = true;
                                        });
                                    }
                                }
                            },
                            function (value) {
                                $.toast("取消验证", "cancel");
                            }
                        );
                        var btnlist = $('.modal-button');
                        for(var i=0;i<btnlist.length;i++){
                            var btnname = $(btnlist[i]).html();
                            if(btnname == 'Cancel'){
                                $(btnlist[i]).html('<span class="modal-button-text">取消</span>');
                            }else{
                                $(btnlist[i]).html('<span class="modal-button-text">确定</span>');
                            }
                        }
                        /*$.prompt({
                            title: '手机号验证',
                            text: '输入手机号验证',
                            input: '',
                            empty: false,
                            onOK: function (input) {
                                xphone = input;
                                if (!phonereg.test(xphone)) {
                                    $.alert("不是正确手机号");
                                } else {
                                    if (smslock == true) {
                                        smslock = false;
                                        $.get($.xiaof.appUrl("getsms", "&phone=" + xphone), function (data) {
                                            var result = $.parseJSON(data);
                                            if (result.errno != 0) {
                                                $.alert(result.message);
                                            } else {
                                                $.prompt({
                                                    title: '手机号验证',
                                                    text: '填写收到的短信验证码',
                                                    input: '',
                                                    empty: false,
                                                    onOK: function (input) {
                                                        var xverifycode = input;
                                                        if (xverifycode.length != 4) {
                                                            $.alert("验证码格式错误");
                                                        } else {
                                                            $.xiaof.vote(id, goodnode, "&verifycode=" + xverifycode + "&phone=" + xphone);
                                                        }
                                                    },
                                                    onCancel: function () {
                                                        $.toast("取消验证", "cancel");
                                                    }
                                                });
                                            }
                                            smslock = true;
                                        });
                                    }
                                }
                            },
                            onCancel: function () {
                                $.toast("取消验证", "cancel");
                            }
                        });*/
                        return;
                    } else if (result.errno == 1331) {
                        $.prompt(result.message,
                            function (value) {
                                $.xiaof.vote(id, goodnode, "&captchacodevalue=" + value);
                            },
                            function (value) {
                                $.toast("取消验证", "cancel");
                            }
                        );
                        var btnlist = $('.modal-button');
                        for(var i=0;i<btnlist.length;i++){
                            var btnname = $(btnlist[i]).html();
                            if(btnname == 'Cancel'){
                                $(btnlist[i]).html('<span class="modal-button-text">取消</span>');
                            }else if(btnname == 'OK'){
                                $(btnlist[i]).html('<span class="modal-button-text">确定</span>');
                            }
                        }
                        /*$.prompt({
                            title: '验证',
                            text: result.message,
                            input: '',
                            empty: false,
                            onOK: function (input) {
                                $.xiaof.vote(id, goodnode, "&captchacodevalue=" + input);
                            },
                            onCancel: function () {
                                $.toast("取消验证", "cancel");
                            }
                        });*/
                        return;
                    }

                    if (result.message.indexOf("您还可以赠送" + window.sysinfo.gifename + "给ta") >= 0) {
                        $.modal({
                            title: tips,
                            text: result.message,
                            buttons: [
                                {
                                    text: "送" + window.sysinfo.gifename, onClick: function () {
                                        window.location.href = $.xiaof.appUrl("givingopt", "&pid=" + id);
                                    }
                                },
                                {
                                    text: "取消", className: "default", onClick: function () {
                                    }
                                },
                            ]
                        });
                    }else if(result.message.indexOf("您可以到抽奖页面进行抽奖") >= 0){
                        $.modal({
                            title: tips,
                            text: result.message,
                            buttons: [
                                {
                                    text: "抽奖", onClick: function () {
                                        window.location.href = $.xiaof.appUrl("creditdraw", "");
                                    }
                                },
                                {
                                    text: "取消", className: "default", onClick: function () {
                                    }
                                },
                            ]
                        });
                    } else {
                        $.alert(result.message);
                    }
                    if (result.message.indexOf("acid-lists") >= 0) {
                        new Swiper('.acid-lists', {
                            scrollbar: '.swiper-scrollbar',
                            autoplay: 3000,
                            scrollbarHide: true,
                            slidesPerView: 1
                        });
                    }
                    if (result.message.indexOf("您今天已经给") >= 0) {
                        var icon = $('.daze-icon').val();
                        var html = '<div class="tips-info-icon-c"><img src="'+icon+'"></div>';
                        $('.modal-text').append(html);
                    }
                    if (result.message.indexOf("您成功给编号") >= 0) {
                        var icon = $('.happy-icon').val();
                        var html = '<div class="tips-info-icon-c"><img src="'+icon+'"></div>';
                        $('.modal-text').append(html);
                    }
                    console.log(result.errno);
                    if (result.errno >= 0 && result.errno != 107) {
                        var icon = $('.happy-icon').val();
                        var html = '<div class="tips-info-icon-c"><img src="'+icon+'"></div>';
                        $('.modal-text').append(html);
                    }
                    var btnlist = $('.modal-button');
                    for(var i=0;i<btnlist.length;i++){
                        var btnname = $(btnlist[i]).html();
                        if(btnname == 'Cancel'){
                            $(btnlist[i]).html('<span class="modal-button-text">取消</span>');
                        }else if(btnname == 'OK'){
                            $(btnlist[i]).html('<span class="modal-button-text">确定</span>');
                        }
                    }
                    if (result.errno == 101) {
                        var icon = $('.cry-icon').val();
                        var html = '<div class="tips-info-icon-c"><img src="'+icon+'"></div>';
                        $('.modal-text').append(html);
                        $('.modal-button').html('<span class="modal-button-text">确定</span>');
                    }
                });
            },
            /**
             * 绑定投票动作
             *
             * @param votebutton
             * @param goodnum
             * @param verifycode
             */
            registerVote: function (votebutton, goodnum, verifycode) {
                var goodnode;
                $(document).on('click', votebutton, function (event) {
                    if($(".loadtips").length > 0){
                        $(".loadtips").css("display",'block');
                        setInterval("loadicon()",10);
                    }
                    event.preventDefault();
                    var id = $(this).attr("data-id");
                    if (goodnum == 'bind') {
                        goodnode = $(this).siblings('.ballot').find('.good-num');
                    } else {
                        goodnode = $(goodnum);
                    }
                    if (verifycode == true) {

                        var handlerPopupMobile = function (captchaObj) {
                            if($(".loadtips").length > 0){
                                $(".loadtips").css("display",'none');
                                window.clearInterval("loadicon()");
                            }
                            var captchaid = (new Date()).getTime();
                            $.alert('<div id="popup-captcha-mobile' + captchaid + '"></div>');
                            captchaObj.appendTo('#popup-captcha-mobile' + captchaid);
                            captchaObj.onSuccess(function () {
                                var validate = captchaObj.getValidate();
                                $.xiaof.vote(id, goodnode, "&geetest_challenge=" + validate.geetest_challenge + "&geetest_validate=" + validate.geetest_validate + "&geetest_seccode=" + validate.geetest_seccode);
                            });
                        };
                        $.ajax({
                            url: $.xiaof.appUrl("captcha", "&s=" + (new Date()).getTime()),
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
                        $.xiaof.vote(id, goodnode);
                    }
                });
            },
            imageUpload: function (imgvalue) {
                localNum = imgvalue.length;
                if ($("#imagefile").length > 0 && localNum > 0) {
                    $.ajaxFileUpload({
                        url: this.appUrl("uploadimage"),
                        secureuri: false,
                        fileElementId: 'imagefile',
                        dataType: 'text',
                        success: function (data) {
                            var result = $.parseJSON(data);
                            if (result.errno == 0) {
                                $.each(result.message, function (k, v) {
                                    $("#pic-container").append("<li class='picid weui-uploader__file' onclick='$(this).remove();'><input type='hidden' name='pics[]' value='" + v + "'/><div class='pic-close'>x</div><img src='" + window.sysinfo.attachurl + v + "'/></li>");
                                });
                            } else {
                                $.alert(result.message);
                            }
                        },
                        error: function (data, status, e) {
                            $.alert(e);
                        }
                    });
                }
            },
            imageWechatupload: function () {
                wx.ready(function () {
                    var localIds = Array();
                    $('#filepicker').on('click', function () {
                        wx.chooseImage({
                            success: function (res) {
                                localIds = localIds.concat(res.localIds);
                                syncUpload(localIds);
                            }
                        });
                    });

                    function syncUpload(localIds) {
                        var localId = localIds.pop();
                        setTimeout(function () {
                            wx.uploadImage({
                                localId: localId,
                                isShowProgressTips: 1,
                                success: function (res) {
                                    $.get($.xiaof.appUrl("uploadimg"), {'serverid': encodeURI(res.serverId)}, function (data) {
                                        var result = $.parseJSON(data);
                                        if (result.errno == 0) {
                                            $("#pic-container").append("<li class='picid weui-uploader__file' onclick='$(this).remove();'><input type='hidden' name='pics[]' value='" + result.message + "'/><div class='pic-close'>x</div><img src='" + localId + "'/></li>");
                                        } else {
                                            $.alert(result.message);
                                            return false;
                                        }

                                        if (localIds.length > 0) {
                                            syncUpload(localIds);
                                        }
                                    });
                                }
                            });
                        }, 200);
                    };
                });
            },
            videoUpload: function (reloadurl) {
                $.get(this.appUrl("token"), function (data, status) {
                    if (status == 'success') {
                        //$.showLoading("上传视频");
                        $.toast('上传视频');
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
                                //$.hideLoading();
                                var result = $.parseJSON(data);
                                console.log(result);
                                $("#video-input").val(result.key);
                                $.xiaof.ajaxJoin(reloadurl);
                            },
                            error: function (xhr, data, err) {
                                //$.hideLoading();
                                if (xhr.status === 413) {
                                    $.alert('上传视频文件超过大小限制');
                                } else if (xhr.status === 403) {
                                    $.alert('必须是视频格式文件');
                                } else {
                                    $.alert('视频上传失败');
                                }
                            }
                        });
                    } else {
                        $.alert('上传视频参数错误');
                    }
                });
            },
            ajaxJoin: function (reloadurl) {
                //$.showLoading("正在报名");
                $.toast('正在报名...');
                $.post(this.appUrl("save"), $("#join-form").serialize(), function (data) {
                    var result = $.parseJSON(data);
                    //$.hideLoading();
                    if (result.errno == 0) {
                        $.alert(result.message, function () {
                            //window.location.href =  joinurl;//报名结束后跳转至首页
                            if ($.xiaof.vars.reloadurl) {
                                window.location.href = $.xiaof.vars.reloadurl;
                            } else {
                                var url = $('.joinjump').val();
                                if(url){
                                    window.location.href = url;
                                }else{
                                    location.reload();
                                }
                            }
                        });
                    } else if (result.errno == 109) {
                        feetips();
                    } else {
                        $.alert(result.message, function () {
                            if ($.xiaof.vars.reloadurl) {
                                window.location.href = $.xiaof.vars.reloadurl;
                            } else {
                                var url = $('.joinjump').val();
                                if(url){
                                    window.location.href = url;
                                }else{
                                    location.reload();
                                }
                            }
                        });
                    }
                });
            },
            videoChange: function (val) {
                var arr = val.split('\\');
                var fileName = arr[arr.length - 1];
                //$(".video-tips").html('已选视频文件: ' + fileName);
                $(".video_continer").css('display','block');
            },
            registerJoin: function (reloadurl, limitpic, phonerequired) {
                this.vars.reloadurl = reloadurl;
                $("#form-submit").click(function () {

                    var videourl = '';
                    if($("#videourl").length > 0){
                        if($('#videourl').val() == ''){
                            $.alert("拍摄视频抖音链接为空！");
                            return;
                        }else{
                            videourl = $('#videourl').val();
                        }
                    }
                    if (videourl != '') {
                        //有抖音视频地址
                        if(videourl.indexOf("https") >= '0'){
                            var attr = videourl.split('https://');
                        }else{
                            var attr = videourl.split('http://');
                        }
                        var attr2 = attr[1].split('/');
                        var url = 'http://' + attr2[0] + '/' + attr2[1] + '/';
                        $.ajax({
                            url: 'https://www.huyahaha.com/index/douyinvideo',
                            type: "post",
                            data: 'videourl=' + url,
                            dataType: "json",
                            success: function (data) {
                                console.log(data['data']);
                                var html = '<li class="picid weui-uploader__file" onclick="$(this).remove();"><input type="hidden" name="pics[]" value="' + data['data']['videopic'] + '"><div class="pic-close">x</div><img src="' + data['data']['videopic'] + '"></li>';
                                $("#pic-container").append(html);
                                $('#video_url').val(data['data']['videourl']);
                                $('#title').val(data['data']['title']);
                                $("#originaurl").val(url);
                                $.xiaof.checkJoin(reloadurl, limitpic, phonerequired);
                            }
                        });
                    } else {
                        $.xiaof.checkJoin(reloadurl, limitpic, phonerequired);
                    }
                })
            },
            checkJoin: function (reloadurl, limitpic, phonerequired) {
                if ($("#name").val() == "") {
                    $.alert("名称不能为空");
                }
                if($("#joinphone").val() == 1  && $("#phone").val() == ""){
                    $.alert("手机号不能为空");
                    return;
                }
                if($("#emptydescribe").val() == 1  && $("#describe").val() == ""){
                    $.alert("选手描述不能为空");
                    return;
                }

                localNum = $("#pic-container .picid").length;
                if($("#player_pic").val() == 1  && localNum <= 0) {
                    $.alert("没有选择照片，不能为空");
                    return;
                }
                if($("#player_voice").val() == 1  && $("#sound").val() == ""){
                    $.alert("没有上传语音，不能为空");
                    return;
                }
                if($("#player_video").val() == 1  && $("#videofile").val() == ""){
                    $.alert("没有上传视频，不能为空");
                    return;
                }

                var phonereg = /^((0\d{2,3}-\d{7,8})|(1([358][0-9]|4[579]|66|7[0135678]|9[89])[0-9]{8}))$/;
                var phonereg_mo =  /^((((0?)|((00)?))(((\s){0,2})|([-_－—\s\(]?)))|([+]?))(853)?([\)]?)([-_－—\s]?)(28[0-9]{2}|((6|8)[0-9]{3}))[-_－—\s]?[0-9]{4}$/;//澳门手机号码验证
                if($("#phone").val() != ""){
                    if (phonerequired && !phonereg.test($("#phone").val()) && !phonereg_mo.test($("#phone").val())) {
                        $.alert("不是正确手机号");
                    }
                }

                if (localNum > limitpic) {
                    $.alert("照片最多不超过" + limitpic + "张");
                } else {
                    if ($("#videofile").length > 0 && $("#videofile").val().length > 0) {
                        $.xiaof.videoUpload(reloadurl);
                    } else {
                        $.xiaof.ajaxJoin(reloadurl);
                    }
                }
            },
            soundUpload: function (res) {
                //$.showLoading("上传录音");
                $.toast('上传录音');
                soundlocalId = res.localId;
                wx.uploadVoice({
                    localId: soundlocalId,
                    isShowProgressTips: 1,
                    success: function (res) {
                        $.get($.xiaof.appUrl("uploadimg", "&type=voice"), {
                            'serverid': encodeURI(res.serverId)
                        }, function (data) {
                            $(".sound-info").html("允许60秒");
                            $(".sound-tips").hide();
                            var result = $.parseJSON(data);
                            if (result.errno == 0) {
                                //$.hideLoading();
                                $(".sound-start").html('<span class="iconfont iconplay-voice play_music"></span><br/>重录');

                                $(".sound-play").show();
                                $("#sound-container").html("<input type='hidden' name='sound' value='" + result.message + "'/>");
                                $(".sound-play").click(function () {
                                    wx.playVoice({
                                        localId: soundlocalId
                                    });
                                    $(".sound-tips").show();
                                    wx.onVoicePlayEnd({
                                        success: function (res) {
                                            $(".sound-tips").hide();
                                        }
                                    });
                                });
                            } else {
                                $.alert(tips, result.message);
                            }
                        });
                    }
                });
            },
            registerSoundupload: function (soundstart, soundend) {

                wx.ready(function () {
                    var startTime, endTime, soundlocalId;
                    var soundstatus = false;
                    $(soundstart).click(function () {
                        if (!soundstatus) {
                            soundstatus = true;
                            startTime = new Date().getTime();
                            recordTimer = setTimeout(function () {
                                wx.startRecord({
                                    success: function () {
                                        localStorage.rainAllowRecord = 'true';
                                        $(".sound-tips").show();
                                        $(".sound-info").html("录音中");
                                        $(soundstart).html('<span class="iconfont iconplay-voice play_music"></span><br/>完成');
                                    },
                                    cancel: function () {
                                        $.alert('授权录音被拒绝');
                                    }
                                });
                                wx.onVoiceRecordEnd({
                                    complete: function (res) {
                                        $.xiaof.soundUpload(res);
                                    }
                                });
                            }, 300);
                        } else {
                            soundstatus = false;
                            endTime = new Date().getTime();
                            if ((endTime - startTime) < 300) {
                                endTime = 0;
                                startTime = 0;
                                clearTimeout(recordTimer);
                            } else {
                                wx.stopRecord({
                                    success: function (res) {
                                        $.xiaof.soundUpload(res);
                                    },
                                    fail: function (res) {
                                        $.alert(JSON.stringify(res));
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
                                $.alert('授权录音被拒绝');
                            }
                        });
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
            registerDraw: function (startbutton) {
                var lockClick = 1;
                //var click = 0
                //$(startbutton).click(function () {

                /*if(click > 0){
                    return false;
                }
                click ++;*/
                var imgurl = $("#clickimg").attr('src');
                var newimgurl = imgurl.replace('clickno.png',"click.jpg");
                if (lockClick != 1) {
                    return;
                }
                var math;
                $.get($.xiaof.appUrl("draw"), function (data) {
                    var result = $.parseJSON(data);
                    if (result.errno == 999) {
                        $.alert(result.message);
                        $(".startbutton").attr('disabled',false);
                        $("#clickimg").attr('src',newimgurl);
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

                            if (T == 3) {
                                if (i == (parseInt(math) + 1)) {
                                    $("#draw" + i + " .cur-shade").addClass("draw-cur");
                                    clearInterval(time);
                                    lockClick = 1;
                                    $.alert(result.message.tips);
                                    $("#credit-num").html(result.message.credit);
                                    var logshtml = '\t\t\t<div class="weui-media-box weui-media-box_appmsg">\n' +
                                        '\t\t\t\t<div class="weui-cell__bd">\n' +
                                        '\t\t\t\t\t抽到了' + result.message.name + '\n' +
                                        '\t\t\t\t</div>\n' +
                                        '\t\t\t\t<div class="weui-cell__ft">\n' +
                                        '\t\t\t\t\t' + result.message.time + '\n' +
                                        '\t\t\t\t</div>\n' +
                                        '\t\t\t</div>';
                                    $("#draw-history").prepend(logshtml);
                                }
                            }
                        }, 200);
                        $(".startbutton").attr('disabled',false);
                        $("#clickimg").attr('src',newimgurl);
                    }
                });
                //});
            },
            registerGivegiving: function (uname, pid) {
                var gid = null;
                var type = null;
                var buycredit = null;
                var givingnum = 1;
                var addnum = 0;
                var addmaxnum = 0;
                var addingnum = 0;

                $("#givingnum").change(function () {
                    givingnum = $(this).val();
                    $(".pay-num").html(buycredit * givingnum);
                    if (addmaxnum >= 1) {
                        addingnum = '随机' + givingnum * addnum + '至' + givingnum * addmaxnum;
                    } else {
                        addingnum = givingnum * addnum;
                    }
                    $(".data-adding").html(addingnum);
                });

                $("#givingnum").change();

                $(".giving-box-item").click(function () {
                    /*var addnumdata = $(this).attr('data-adding');
                    if (addnumdata.indexOf('-') >= 0) {
                        var addnumarr = addnumdata.split('-');
                        addnum = parseInt(addnumarr[0]);
                        addmaxnum = parseInt(addnumarr[1]);
                        addingnum = '随机' + givingnum * addnum + '至' + givingnum * addmaxnum;
                    } else {
                        addnum = parseInt(addnumdata);
                        addmaxnum = 0;
                        addingnum = givingnum * addnum;
                    }*/

                    //var tiphtml = '送<span class="giving-toname">' + uname + '</span>' + window.sysinfo.gifename + '<span class="giving-name">' + $(this).attr('data-name') + '</span>，票加 <span class="data-adding">' + addingnum + '</span>';
                    //$(".giving-tips").html(tiphtml);
                    //$(".giving-box .cur").removeClass('cur');
                    //$(this).addClass('cur');
                    gid = $(this).attr('data-id');
                    type = $(this).attr('data-type');
                    buycredit = parseFloat($(this).attr('data-buycredit'));
                    $(".pay-num").html(buycredit * givingnum);
                });

                $(".wechat-pay").click(function () {
                    if (gid == null) {
                        $.toast("未选择" + window.sysinfo.gifename);
                        return;
                    }
                    if($(".choosegiftnum-active").length > 0){
                        givingnum = $(".choosegiftnum-active").attr("num");
                    }

                    /*$('.wechat-pay').attr("disabled",true);
                    $('.wechat-pay').addClass('weui-btn_disabled');
                    $('.wechat-pay').removeClass('weui-btn_primary');
                    if($(".loadtips").length > 0){
                        $(".loadtips").css("display",'block');
                        setInterval("loadicon()",10);
                    }
                    var screen_height = $(window).height();
                    var screen_width = $(window).width();
                    var card_height = screen_height - 32;
                    $('#layout').css('top', card_height/2 +100);

                    var url = $.xiaof.appUrl('paygiving', "&gid=" + gid + "&type=" + type + "&pid=" + pid + "&num=" + givingnum);
                    var data = '';
                    $.ajax({
                        type: 'post',
                        url: url,
                        data: data,
                        dataType: 'json',
                        success: function(resp){
                            if (resp.errno == 0) {
                                $(".wechat-pay").attr("disabled",false);
                                $('.wechat-pay').removeClass('weui-btn_disabled');
                                $('.wechat-pay').addClass('weui-btn_primary');

                                if($(".loadtips").length > 0){
                                    $(".loadtips").css("display",'none');
                                    window.clearInterval("loadicon()");
                                }
                                WeixinJSBridge.invoke('getBrandWCPayRequest', {
                                    "appId": resp.data.appId, //公众号名称，由商户传入
                                    "timeStamp": resp.data.timeStamp, //时间戳，自1970 年以来的秒数
                                    "nonceStr": resp.data.nonceStr, //随机串
                                    "package": resp.data.package,
                                    "signType": resp.data.signType, //微信签名方式:
                                    "paySign": resp.data.paySign //微信签名
                                }, function (res) {
                                    if (res.err_msg == "get_brand_wcpay_request:ok") {
                                        window.location.href = resp.data.redirect_url;
                                    } else {
                                        if(res.err_msg == 'get_brand_wcpay_request:cancel') {
                                            $.toast('您取消了本次支付！');
                                        } else {
                                            $.toast('启动微信支付失败, 请检查你的支付参数. 详细错误为: ' + res.err_msg);
                                        }
                                    }
                                });
                            } else {
                                $(".wechat-pay").attr("disabled",false);
                                $('.wechat-pay').removeClass('weui-btn_disabled');
                                $('.wechat-pay').addClass('weui-btn_primary');
                                $.toast(resp.errmsg);
                            }
                        }
                    });*/
                    window.location.href = $.xiaof.appUrl('paygiving', "&gid=" + gid + "&type=" + type + "&pid=" + pid + "&num=" + givingnum);
                })
            },
            searchUser: function (d) {
                $("#searchCancel").click(function () {
                    $(".search-result").html('');
                    $(".search-result").hide();
                });
                $("#searchInput").bind("input", function () {
                    $(window).scrollTop($("#searchBar").offset().top);
                    $.get($.xiaof.appUrl("ajaxsearch", "&key=" + $(this).val()), function (data) {
                        var result = $.parseJSON(data);
                        if (result.errno == 0) {
                            $(".search-result").show();
                            $(".search-result").html('');
                            var parameter;
                            if (d == 'show') {
                                parameter = "&id=";
                            } else {
                                parameter = "&pid=";
                            }
                            $.each(result.message, function (key, value) {
                                var searchhtml = '<a class="weui-cell weui-cell_access" href="' + $.xiaof.appUrl(d, parameter + value.id) + '"><div class="weui-cell__hd"><img height="20" width="20" src="' + value.pic + '"></div><div class="weui-cell__bd"><p style="max-width: 162px;height: 24px;overflow: hidden;">' + value.name + '</p></div><div class="weui-cell__ft">编号 ' + value.uid + '</div></a>';
                                $(".search-result").append(searchhtml);
                            });
                        } else {
                            $.alert(result.message);
                        }
                    });
                });
            },
            registerMenu: function (openidhistory) {
                $(".xiaof-tabbar-menu").click(function () {
                    var _this = $(this);
                    $(".xiaof-menu").slideToggle("fast", "swing", function () {
                        if ($(this).is(':hidden')) {
                            _this.find(".icon").html('<i class="fa fa-navicon"></i>');
                        } else {
                            _this.find(".icon").html('<i class="fa fa-angle-down"></i>');
                        }
                    });
                });

                $(".xiaof-menu-overlay").click(function () {
                    $(".xiaof-menu").slideUp();
                    $(".xiaof-tabbar-menu").find(".icon").html('<i class="fa fa-navicon"></i>');
                });

                if (openidhistory == true) {
                    if (window.history.length > 1) {
                        $(".history-back").css("color", '#999');
                        $(".history-back").click(function () {
                            window.history.back();
                        });
                    }

                    $(".history-forward").css("color", '#999');
                    $(".history-forward").click(function () {
                        window.history.forward();
                    });
                }
            },
        }
    })
}));