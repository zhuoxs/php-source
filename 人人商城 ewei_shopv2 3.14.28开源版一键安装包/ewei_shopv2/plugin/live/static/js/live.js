define(['core', 'tpl','./video.js'], function (core, tpl,video) {
     window['videojs'] = video;
    var modal = {
        wsClient: false,
        wsConfig: {},
        wsConnected: false,
        wsBanned: {all: false, self: false},
        status: 0,
        realOnline: 0,
        showOnline: 0,
        wsCanAt: false,
        wsCanRepeal: false,
        msgAt: {},
        lastliketime: 0,
        inputTip: ['跟大家说点什么吧...', '点击键盘回车也可发送信息哦~']
    };
    modal.init = function (params) {
        require(['../addons/ewei_shopv2/plugin/live/static/js/videojs-contrib-hls.js'], function (videojs) {
            modal.initInternal(params);
        });
    };
    modal.initInternal = function (params) {
        modal.wsConfig = params.wsConfig || {};
        modal.roomid = modal.wsConfig.roomcount;
        modal.initWs();
        modal.initClick();
        modal.initPlayer();
        modal.initNotice();

        // 处理安卓播放中跳转后返回
        if(modal.wsConfig.isMobile && !modal.wsConfig.isIos){
            modal.x5videoexitfullscreen();
        }

        setInterval(function () {
            var tipIndex = Math.floor(Math.random() * 3);
            if (tipIndex == 2 && !modal.wsCanAt) {
                tipIndex == 1
            }
            $('#input').attr('placeholder', modal.inputTip[tipIndex]);
            if (modal.wsConnected) {
                modal.wsSend('communication', {toUser: 'system'});
                modal.clickLike();
            }else{
                modal.initWs();
            }
        }, 8000);
        //隐藏对话
        $(".btn-hide").off("click").on("click",function () {
            $(".tab-content").hide();
            $(".btn-hide").hide();
            $(".btn-show").show();
        });
        $(".btn-show").off("click").on("click",function () {
            $(".tab-content").show();
            $(".btn-hide").show();
            $(".btn-show").hide();
        });
        //判断IOS版本兼容
        var ver = (navigator.appVersion).match(/OS (\d+)_(\d+)_?(\d+)?/);
        if (ver){
            ver = parseInt(ver[1], 10);
            if(ver>=10){
                $(".block-video").css("z-index","10");
                return;
            }
        }
    };
    modal.initPlayer = function () {

        // 初始化播放器
        modal.initMyPlayer();

        // 处理播放器位置
        var playerHeight = $('body').width() * 0.56;
        if (!$('.fui-content').hasClass('fullscreen')) {
            setTimeout(function () {
            $('.block-video').css('height', playerHeight + 'px');
            // $('.prompt').css('height', playerHeight + 'px');
            $('.prompt').css({height:playerHeight + 'px',position:'fixed',zIndex:'99',width:'100%'});
            $('.block-content').css('top', playerHeight + $('.block-tab').height() + 'px');
            $('.block-notice').css('top', playerHeight + $('.block-tab').height() + 'px')
            }, 100);
        }
        var player = $('#player_html5_api')[0];
        if (!modal.wsConfig.isMobile || modal.wsConfig.isIos) {
            return
        }
        //进入全屏时触发
        player.addEventListener("x5videoenterfullscreen", function () {
            $('.fui-content').addClass('player-fullscreen');
            var playerHeight = $('body').width() * 0.56;
            if (!$('.fui-content').hasClass('fullscreen')) {
                $('.block-video').css('height', 'auto');

                $('#player_html5_api').css({
                    objectPosition:'0px '+$('.block-title').height()+'px',
                });
                $('.prompt').css('height', 'auto');
                $('.block-tab').css('top', $('.block-title').height() + playerHeight + 'px');
                $('.block-content').css('top', $('.block-title').height() + playerHeight + $('.block-tab').height() + 'px');
                $('.block-content').css('position', 'fixed');
                $('.block-notice').css('top', $('.block-title').height() + playerHeight + $('.block-tab').height() + 'px');
            }
        });
        //退出全屏时触发
        player.addEventListener("x5videoexitfullscreen", function () {
            modal.x5videoexitfullscreen();
        })
    };

    modal.initMyPlayer = function () {

        modal.myPlayer = window.videojs('player',{
            bigPlayButton : false,
            textTrackDisplay : false,
            posterImage: true,
            errorDisplay : false,
            controlBar : false,
            autoplay:true,
        },function(){
            console.log(this);
            this.on('loadedmetadata',function(){
                console.log('loadedmetadata');
                //加载到元数据后开始播放视频
                modal.startVideo();
            })

            this.on('ended',function(){
                console.log('ended')
            })
            this.on('firstplay',function(){
                console.log('firstplay');
                var tryTimes = 0;
                clearInterval(modal.isFirstplay);
                modal.isFirstplay = setInterval(function(){
                    console.log('waiting'+tryTimes);
                    var currentTime = modal.myPlayer.currentTime();
                    if(currentTime == 0){
                        //此时视频已卡主3s
                        modal.myPlayer.play();
                        //尝试6次播放后，如仍未播放成功提示
                        if(++tryTimes >= 6){
                            FoxUI.toast.show('您的网速有点慢，请在自动刷新之后重新点击观看！');
                            tryTimes = 0;
                            var url = $('#player').attr('src');
                            $.get(url, function(){});
                            window.location.reload();
                        }
                    }else{
                        clearInterval(modal.isFirstplay);
                        tryTimes = 0;
                    }
                },1000);
            })
            this.on('loadstart',function(){
                //开始加载
                console.log('loadstart')
            })
            this.on('loadeddata',function(){
                console.log('loadeddata');
                $('.btn-play').hide();
            })
            this.on('seeking',function(){
                //正在去拿视频流的路上
                console.log('seeking')
            })
            this.on('seeked',function(){
                //已经拿到视频流,可以播放
                console.log('seeked')
            })
            this.on('waiting',function(){
                console.log('waiting');
                var tryTimes = 0;
                clearInterval(modal.isWaiting);
                modal.isWaiting = setInterval(function(){
                    console.log('waiting'+tryTimes);
                    var currentTime = modal.myPlayer.currentTime();
                    if(currentTime == 0){
                        //此时视频已卡主3s
                        modal.myPlayer.play();
                        //尝试6次播放后，如仍未播放成功提示
                        if(++tryTimes >= 6){
                            FoxUI.toast.show('您的网速有点慢，请在自动刷新之后重新点击观看！');
                            tryTimes = 0;
                            var url = $('#player').attr('src');
                            $.get(url, function(){});
                            window.location.reload();
                        }
                    }else{
                        clearInterval(modal.isWaiting);
                        tryTimes = 0;
                    }
                },1000);
                // modal.myPlayer.play();
            })
            this.on('pause',function(){
                console.log('pause')
            })
            this.on('play',function(){
                console.log('play');
            })
            this.on('error',function(){
                console.log('error');
            })
        });
    };

    modal.x5videoexitfullscreen = function () {
        var playerHeight = $('body').width() * 0.56;
        $('.block-tab').css('top', playerHeight + 'px');
        $('.block-content').css('top', playerHeight + $('.block-tab').height() + 'px');
        $('.fui-content').removeClass('player-fullscreen');
        if($('.fui-content').hasClass('fullscreen')){
            $('.block-notice').css('top', '100px');
        }else {
            $('.block-notice').css('top', playerHeight + $('.block-tab').height() + 'px');

            $('.prompt').css('height', playerHeight + 'px');
            $('.block-video').css('height', playerHeight + 'px');
            $('#player_html5_api').css({
                objectPosition:'0px 0px',
            });

        };
        $('.btn-play').show();
    };
    modal.initWs = function () {
        if (!modal.wsConfig) {
            modal.liveMsg('notice', '通讯服务器配置错误');
            return
        } else {
            $('.block-input .input-place').html('初始化通讯服务...').show().siblings().hide()
        }
        var wsConfig = modal.wsConfig;
        var wsClient = new WebSocket(wsConfig.address);
        wsClient.onopen = function () {
            modal.wsSend('login', {toUser: 'system'})
        };
        wsClient.onmessage = function (evt) {
            var data = JSON.parse(evt.data);
            console.log(data);
            if (data.type == 'connected') {
                FoxUI.toast.show('连接成功');
                $('.block-input .input-place').html('').hide().siblings().show();
                modal.wsConnected = true;
                modal.wsBanned = data.banned;
                if (data.banned.all == 1) {
                    modal.liveMsg('notice', '管理员禁止任何人发言')
                } else if (data.banned.self != '') {
                    modal.liveMsg('notice', '你被管理员禁止发言')
                }
                modal.status = data.settings.status;
                modal.wsCanAt = data.settings.canat == 1 ? true : false;
                modal.wsCanRepeal = data.settings.canrepeal == 1 ? true : false;
                modal.realOnline = data.online || 0;
                modal.showOnline = data.settings.virtual || 0;
                modal.initStatus();
                modal.initOnline();
                if (modal.wsCanAt) {
                    modal.inputTip.push('点击蓝色昵称可@Ta')
                } else {
                    modal.inputTip.splice(2, 1)
                }
                if (modal.wsCanRepeal) {
                    $('.btn-repeal').addClass('show')
                } else {
                    $('.btn-repeal').removeClass('show')
                }
                setTimeout(function () {
                    modal.scrollBottom()
                }, 10)
            } else if (data.type == 'notice') {
                modal.liveMsg('notice', data.text)
            } else if (data.type == 'setting') {
                var settings = data.settings;
                if (!settings) {
                    return
                }
                if (modal.status != settings.status) {
                    modal.status = settings.status;
                    modal.initStatus()
                }
                if (modal.showOnline != settings.virtual) {
                    modal.showOnline = settings.virtual;
                    modal.initOnline()
                }
                modal.wsCanAt = settings.canat == 1 ? true : false;
                modal.wsCanRepeal = settings.canrepeal == 1 ? true : false;
                if (modal.wsCanAt) {
                    modal.inputTip.push('点击蓝色昵称可@Ta')
                } else {
                    modal.inputTip.splice(2, 1)
                }
                if (modal.wsCanRepeal) {
                    $('.btn-repeal').addClass('show')
                } else {
                    $('.btn-repeal').removeClass('show')
                }
                if (settings.nickname_old) {
                    modal.liveMsg('notice', '管理员"' + settings.nickname_old + '"更名为"' + settings.nickname + '"')
                }
            } else if (data.type == 'userEnter') {
                if (data.role != 'manage') {
                    modal.userEnter(data.nickname)
                }
                modal.realOnline++;
                modal.initOnline()
            } else if (data.type == 'userLeave') {
                modal.realOnline--;
                modal.initOnline()
            } else if (data.type == 'text' || data.type == 'sent') {
                modal.liveMsg('text', data)
            } else if (data.type == 'image') {
                modal.liveMsg('image', data)
            } else if (data.type == 'repeal') {
                if (data.msgid) {
                    var text = '"' + data.nickname + '"';
                    if (data.fromUser == modal.wsConfig.uid) {
                        text = '你'
                    }
                    var fullscreen = '';
                    if (modal.wsConfig.fullscreen) {
                        fullscreen += 'nopadding'
                    }
                    $('.tab-content .msg[data-msgid="' + data.msgid + '"]').addClass(fullscreen).html('<div class="tip"><div class="text">' + text + '撤回了一条消息</div></div></div>')
                }
            } else if (data.type == 'delete') {
                if (data.msgid) {
                    var text = '"' + data.deleteNick + '"撤回了一条消息';
                    if (data.deleteUid == modal.wsConfig.uid) {
                        text = '管理员"' + data.nickname + '"删除了你的一条消息'
                    }
                    var fullscreen = '';
                    if (modal.wsConfig.fullscreen) {
                        fullscreen += 'nopadding'
                    }
                    $('.tab-content .msg[data-msgid="' + data.msgid + '"]').addClass(fullscreen).html('<div class="tip"><div class="text">' + text + '</div></div></div>')
                }
            } else if (data.type == 'banned') {
                if (data.banned == 1) {
                    modal.wsBanned.self = true;
                    modal.liveMsg('notice', '你被管理员禁止发言');
                    $('.btn-send').removeClass('active')
                } else {
                    if (modal.wsBanned.all == '') {
                        var value = $.trim($('#input').val());
                        if (value) {
                            $('.btn-send').addClass('active')
                        }
                    }
                    modal.wsBanned.self = false;
                    modal.liveMsg('notice', '你被管理员允许发言')
                }
            } else if (data.type == 'bannedAll') {
                if (data.banned == 1) {
                    $('.btn-send').removeClass('active');
                    modal.wsBanned.all = true;
                    modal.liveMsg('notice', '管理员禁止任何人发言');
                    $('.btn-send').removeClass('active')
                } else {
                    if (modal.wsBanned.self == '') {
                        var value = $.trim($('#input').val());
                        if (value) {
                            $('.btn-send').addClass('active')
                        }
                    }
                    modal.wsBanned.all = false;
                    modal.liveMsg('notice', '管理员解除全体禁言')
                }
            } else if (data.type == 'clicklike') {
                modal.clickLike()
            } else if (data.type == 'goods') {
                //删除前面带的://app/
                data.goodsUrl = data.goodsUrl.substring(6);
                modal.liveGoods(data)
            } else if (data.type == 'redpack') {
                modal.liveMsg('redpack', data)
            } else if (data.type == 'redpackget') {
                if (data.prestatus == 0) {
                    FoxUI.toast.show('红包不存在或已过期')
                } else if (data.prestatus == 1) {
                    $('.layer-mask').fadeIn(200);
                    $('.layer-redpack').addClass('in open').find('.price').html('<span>￥</span>' + data.money)
                } else if (data.prestatus == 2) {
                    $('.layer-redpack .redpack-info .price').addClass('small').html('手速慢太慢了，没抢到..');
                    $('.msg .content .redpack[data-pushid="' + data.redpackid + '"]').addClass('drew').find('.desc').text('已抢光');
                    $('.layer-mask').fadeIn(200);
                    $('.layer-redpack').addClass('in open')
                } else if (data.prestatus == 3) {
                    $('.layer-mask').fadeIn(200);
                    $('.layer-redpack').removeClass('open').addClass('in')
                }
                modal.initRedpackList(data.list);
                FoxUI.loader.hide();
                $(document).find('.redpack[data-pushid="' + data.redpackid + '"]').removeClass('stop')
            } else if (data.type == 'redpackdraw') {
                if (data.status == 0) {
                    setTimeout(function () {
                        $('.layer-redpack').removeClass('in');
                        $('.layer-mask').fadeOut(200);
                        FoxUI.loader.show('领取失败', 'icon icon-cry');
                        $('.layer-redpack .redpack-draw').removeClass('rotate');
                        setTimeout(function () {
                            FoxUI.loader.hide()
                        }, 1500)
                    }, 1500)
                } else if (data.status == 1 || data.status == 3) {
                    setTimeout(function () {
                        if (data.status == 3) {
                            $('.msg .content .redpack[data-pushid="' + data.redpackid + '"]').addClass('drew').find('.desc').text('已领取')
                        }
                        $('.layer-mask').fadeIn(200);
                        $('.layer-redpack').addClass('in open').find('.price').html('<span>￥</span>' + data.money);
                        $('.layer-redpack .redpack-draw').removeClass('rotate')
                    }, 1500)
                } else if (data.status == 2) {
                    setTimeout(function () {
                        $('.layer-redpack .redpack-info .price').addClass('small').html('手速慢太慢了，没抢到..');
                        $('.layer-mask').fadeIn(200);
                        $('.layer-redpack').addClass('in open');
                        $('.layer-redpack .redpack-draw').removeClass('rotate')
                    }, 1500)
                }
                modal.initRedpackList(data.list);
                $('.layer-redpack').removeClass('stop')
            } else if (data.type == 'coupon') {
                modal.liveMsg('coupon', data)
            } else if (data.type == 'coupondraw') {
                if (data.status == 0) {
                    FoxUI.loader.show('领取失败', 'icon icon-cry');
                    setTimeout(function () {
                        FoxUI.loader.hide()
                    }, 1000)
                } else if (data.status == 1 || data.status == 3) {
                    if (data.status == 3) {
                        $('.msg .content .coupon[data-pushid="' + data.couponid + '"]').addClass('drew').find('.desc').text('已领取')
                    }
                    $('.layer-mask').fadeIn(200);
                    $('.layer-coupon .coupon-title').text('优惠券已到账');
                    var html = '';
                    if (data.couponvaluetext == 0) {
                        html += '￥'
                    }
                    html += '<span class="money">' + data.couponvaluetotal + '</span>';
                    if (data.couponvaluetext != 0) {
                        html += data.couponvaluetext
                    }
                    $('.layer-coupon .price').html(html);
                    $('.layer-coupon .desc').html(data.couponuselimit || '无使用条件');
                    $('.layer-coupon').removeClass('roomcoupon').removeClass('fail').addClass('in')
                } else if (data.status == 2) {
                    $('.layer-mask').fadeIn(200);
                    $('.layer-coupon .coupon-title').text('很遗憾，没抢到');
                    $('.layer-coupon').addClass('fail').addClass('in')
                }
            }
        };
        wsClient.onclose = function (evt) {
            if (!modal.wsConnected) {
                return
            }
            $('.block-input .input-place').html('与通讯服务器断开 <a class="btn-reconnect">点击重连</a>').show().siblings().hide();
            modal.wsConnected = false
        };
        wsClient.onerror = function (evt) {
            $('.block-input .input-place').html('与通讯服务器连接失败 <a class="btn-reconnect"> 点击重连</a>').show().siblings().hide();
            modal.wsConnected = false
        };
        modal.wsClient = wsClient
    };
    modal.wsSend = function (type, obj) {
        if (!type || $.isEmptyObject(obj)) {
            return false
        }
        if (type != 'login') {
            if (!modal.wsConnected) {
                FoxUI.toast.show('通讯服务器连接失败');
                return false
            }
            if (type != 'redpackget' && type != 'redpackdraw' && type != 'coupondraw' && type != 'communication') {
                if (modal.wsBanned.all == 1) {
                    FoxUI.toast.show('管理员禁止任何人发言');
                    return false
                }
                if (modal.wsBanned.self != '') {
                    FoxUI.toast.show('你被管理员禁止发言');
                    return false
                }
            }
        }
        var wsConfig = modal.wsConfig;
        obj.type = type;
        obj.scene = 'live';
        obj.roomid = wsConfig.roomid;
        obj.uniacid = wsConfig.uniacid;
        obj.uid = wsConfig.uid;
        obj.nickname = wsConfig.nickname;
        if (!$.isEmptyObject(modal.msgAt)) {
            obj.at = modal.msgAt;
            obj = modal.handleAtText(obj)
        }
        modal.wsClient.send(JSON.stringify(obj));
        return obj
    };
    modal.liveMsg = function (type, obj) {
        var atText = '', fullscreen = '';
        if (obj.atUsers && !$.isEmptyObject(obj.atUsers)) {
            $.each(obj.atUsers, function (uid, nickname) {
                atText += '<span class="nickname';
                if (uid == modal.wsConfig.uid) {
                    atText += ' self', nickname = '你';
                    modal.liveAt(obj.nickname, obj.msgid)
                }
                atText += '" data-uid="' + uid + '" data-nickname="' + nickname + '">@' + nickname + '</span> '
            })
        }
        if (type == 'image') {
            obj.text = modal.tomedia(obj.text);
            obj.text = '<img src="' + obj.text + '" />'
        } else if (type == 'text' && obj.text) {
            if (obj.text.indexOf("[") > -1 && obj.text.indexOf("]") > -1) {
                var res = obj.text.match(/\[([^\]]+)\]/g);
                if (res) {
                    $.each(res, function (index, val) {
                        var text = val.replace('[', '');
                        text = text.replace(']', '');
                        var elm = $('.block-emoji .item[title="' + text + '"]');
                        if (elm.length > 0) {
                            if (elm.data('index')) {
                                var face = '<img class="face" src="../addons/ewei_shopv2/plugin/live/static/images/face/' + elm.data('index') + '.gif?v=2" />';
                                obj.text = obj.text.replace(val, face)
                            }
                        }
                    })
                }
            }
        } else if (type == 'redpack') {
            var redpackTitle = obj.redpack.title || '红包来袭，手慢无！';
            obj.text = '<div class="redpack" data-pushid="' + obj.redpack.id + '" data-title="' + redpackTitle + '"><p class="name">' + redpackTitle + '</p><p class="desc">点击领取</p></div>';
            if (modal.wsConfig.fullscreen) {
                fullscreen += 'nopadding'
            }
        } else if (type == 'coupon') {
            var couponTitle = obj.coupon.title || '优惠券来袭，手慢无！';
            obj.text = '<div class="coupon" data-pushid="' + obj.coupon.id + '" data-title="' + couponTitle + '">' + couponTitle + '</div>';
            if (modal.wsConfig.fullscreen) {
                fullscreen += 'nopadding'
            }
        }
        var html = '';
        html += '<div data-msgid="' + obj.msgid + '" class="msg ' + fullscreen;
        if (type == 'notice') {
            html += ' notice'
        }
        if (obj.self) {
            html += ' self'
        }
        html += '">';
        if (type == 'notice') {
            html += '系统提醒：' + obj
        } else {
            if (obj.self) {
                obj.nickname += '(你)';
                if (modal.wsCanRepeal) {
                    obj.text += '<span class="btn-repeal show"> <i class="icon icon-chexiao"></i></span>'
                } else {
                    obj.text += '<span class="btn-repeal"> <i class="icon icon-chexiao"></i></span>'
                }
            }
            if (type != 'redpack' || !modal.wsConfig.fullscreen) {
                html += '<div class="nickname ';
                if (obj.self) {
                    html += ' self'
                }
                html += '" data-uid="' + obj.fromUser + '" data-nickname="' + obj.nickname + '">' + obj.nickname + '：</div>'
            }
            html += '<div class="content">' + atText + obj.text + '</div>'
        }
        html += '</div>';
        $('.tab-content[data-tab="interaction"]').append(html);
        if (type == 'redpack') {
            $('.block-content .msg[data-msgid="' + obj.msgid + '"]').find('.redpack').click();
            $('.layer-coupon').removeClass('in')
        }
        if (type != 'redpackget' && type != 'redpackdraw' && type != 'coupondraw') {
            modal.scrollBottom()
        }
    };
    modal.liveGoods = function (obj) {
        var fullscreen = '';
        if (modal.wsConfig.fullscreen) {
            fullscreen += 'nopadding'
        }
        var html = '<a class="msg ' + fullscreen + '" data-msgid="' + obj.msgid + '" href="' + obj.goodsUrl + '" data-nocache="true">';
        html += '<div class="content"><div class="goods"><div class="thumb"><img src="' + obj.goodsThumb + '"></div>';
        html += '<div class="info"><div class="title">' + obj.goodsTitle + '</div>';
        html += '<div class="price"><div class="num">￥' + obj.goodsPrice + '</div><div class="btn-buy">购买</div>';
        html += '</div></div></div></div></div>';
        $('.tab-content[data-tab="interaction"]').append(html);
        modal.scrollBottom()
    };
    modal.liveAt = function (nickname, msgid) {
        if (!nickname || !msgid) {
            return
        }
        var elm = $('.layer-at');
        if (elm.hasClass('in')) {
            clearTimeout(modal.liveAtEnd)
        }
        $('.layer-at .at-text').text(nickname + '@了你');
        $('.layer-at').addClass('in').data('msgid', msgid);
        modal.liveAtEnd = setTimeout(function () {
            elm.removeClass('in').data('msgid', 0).find('.at-text').text('')
        }, 10000)
    };
    modal.handleAtText = function (obj) {
        if (obj.text == '' || !obj.at || $.isEmptyObject(obj.at)) {
            return
        }
        $.each(obj.at, function (key, val) {
            obj.text = obj.text.replace('@' + val + ': ', '')
        });
        return obj
    };
    modal.userEnter = function (nickname) {
        if (!nickname) {
            return
        }
        var elm = $('.layer-enter');
        if (elm.hasClass('in')) {
            clearTimeout(modal.enterEnd)
        }
        elm.removeClass('out');
        elm.addClass('in').find('.name').text(nickname);
        modal.enterEnd = setTimeout(function () {
            elm.removeClass('in').addClass('out').find('.name').text('');
            setTimeout(function () {
                elm.removeClass('out')
            }, 400)
        }, 2500)
    };
    modal.initStatus = function () {
        if (modal.status == 1) {
            $('.live-tips.play').show().siblings('.live-tips').hide()
        } else if (modal.status == 2) {
            $('.live-tips.pause').show().siblings('.live-tips').hide();
            // $('#player')[0].pause()
            modal.myPlayer.pause();
        } else {
            $('.live-tips.stop').show().siblings('.live-tips').hide();
            // $('#player')[0].pause()
            modal.myPlayer.pause();
        }
    };
    modal.initOnline = function () {
        var online = parseInt(modal.realOnline) + parseInt(modal.showOnline);
        if (online > 10000) {
            online = (online / 10000).toFixed(2);
            online += '万'
        }
        $('#online').text(online)
    };
    modal.initVideo = function (status) {
        if (status == 'pause') {
            alert('暂停直播/显示暂停提示')
        } else if (status == 'stop') {
            alert('停止直播/显示直播未开始提示')
        } else {
            alert('开始直播')
        }
    };
    modal.initClick = function () {
        $(document).on('click', '.btn-reconnect', function () {
            if (modal.wsConnected) {
                FoxUI.toast.show('当前已连接，如还提示请刷新');
                return
            }
            modal.initWs()
        });
        $('.block-tab a').click(function () {
            if ($(this).attr('href') != 'javascript:void(0);') {
                return
            }
            ;
            var tab = $(this).data('tab');
            $(this).addClass('active').siblings().removeClass('active');
            $('.block-content .tab-content[data-tab="' + tab + '"]').show().siblings('.tab-content').hide();
            if (tab == 'interaction') {
                $('.block-icon').show();
                $('.block-notice').css('opacity', 1)
            } else {
                $('.block-icon').hide();
                $('.block-notice').css('opacity', 0)
            }
        });
        $('.btn-play').click(function () {
            var url = $('#player').attr('src');
            if (url == '') {
                FoxUI.toast.show('视频获取失败或未设置');
                return
            };
            // $('#player').get(0).play();
            modal.myPlayer.play();
            $('.live-tips').hide();
            // var url = $(this).data('url');
            // $.ajax({
            //     url: url,
            //     type: "GET",
            //     timeout: 1000,
            //     complete : function(XMLHttpRequest,status){ //请求完成后最终执行参数
            //         if(status=='timeout'){//超时,status还有success,error等值的情况
            //             modal.myPlayer.play();
            //         }
            //     }
            // });
        });
        $('#player')[0].addEventListener("ended", function () {
            $('.live-tips.play').show().siblings('.live-tips').hide()
        });
        $("#input").off("click").on("click",function () {
            if (document.documentElement.clientHeight < document.documentElement.offsetHeight){
                $(this).focus(function () {
                    if (document.documentElement.clientHeight < document.documentElement.offsetHeight){
                        $('body').animate({scrollTop: "10000px"}, 500);
                    }
                    $('.block-input').addClass('focus')
                });
            }
        });
        /*$('#input').focus(function () {
            if (document.documentElement.clientHeight < document.documentElement.offsetHeight){
                $('body').animate({scrollTop: "10000px"}, 500);
            }
            $('.block-input').addClass('focus')
        });*/
        $('#input').blur(function () {
            if ($('.fui-content').hasClass('show-emoji')) {
                return
            }
            $('.block-input').removeClass('focus')
        });
        $('#input').keydown(function (event) {
            if (event.keyCode == 8) {
                var textValue = '';
                var textObj = $(this).get(0);
                if (textObj.setSelectionRange) {
                    var rangeStart = textObj.selectionStart;
                    var rangeEnd = textObj.selectionEnd;
                    var delValue = textObj.value.substring(rangeStart - 1, rangeStart);
                    var tempStr1 = textObj.value.substring(0, rangeStart - 1);
                    var tempStr2 = textObj.value.substring(rangeEnd);
                    textValue = tempStr1 + tempStr2;
                    if (delValue == "]" && tempStr1.indexOf("[") > -1) {
                        var res = tempStr1.match(/(\[[\u4E00-\u9FA5]*)$/g);
                        textValue = tempStr1.substring(0, tempStr1.lastIndexOf("[")) + tempStr2
                    } else if (delValue == " " && tempStr1.indexOf("@") > -1) {
                        textValue = tempStr1.substring(0, tempStr1.lastIndexOf("@")) + tempStr2;
                        modal.msgAt = {}
                    }
                    textObj.value = textValue;
                    textObj.focus();
                    textObj.setSelectionRange(rangeStart - 1, rangeStart - 1);
                    return false
                } else {
                    return true
                }
            } else if (event.keyCode == 13) {
                var value = $.trim($("#input").val());
                if (!value) {
                    FoxUI.toast.show('不能发送空消息');
                    return
                }
                var msg = modal.wsSend('text', {toUser: 'all', text: value});
                if (msg) {
                    $(this).removeClass('active');
                    $("#input").val('');
                    modal.msgAt = {}
                }
                $('.fui-content').removeClass('show-emoji')
            }
        });
        $('#input').on('input propertychange, change', function () {
            var value = $.trim($(this).val());
            if (value != '' && modal.wsConnected && modal.wsBanned.all != 1 && modal.wsBanned.self != 1) {
                $(".btn-send").addClass('active')
            } else {
                $(".btn-send").removeClass('active')
            }
        });
        $(document).on('click', '.block-content .msg .btn-repeal', function () {
            if (!modal.wsCanRepeal) {
                FoxUI.toast.show('管理员禁止撤回消息')
            }
            var msgid = $(this).closest('.msg').data('msgid');
            FoxUI.confirm('确定要撤回此条消息吗？', function () {
                modal.wsSend('repeal', {toUser: 'system', msgid: msgid})
            })
        });
        $(document).on('click', '.block-content .msg .nickname', function () {
            if ($(this).hasClass('noat')) {
                return
            }
            if (!modal.wsCanAt) {
                FoxUI.toast.show('管理员禁止@用户');
                return
            }
            if (!$.isEmptyObject(modal.msgAt)) {
                FoxUI.toast.show('每次只能@一位用户');
                return
            }
            var nickname = $.trim($(this).data('nickname'));
            var uid = $(this).data('uid');
            if ($(this).hasClass('self')) {
                FoxUI.toast.show('你不能@自己');
                return
            }
            modal.msgAt[uid] = nickname;
            modal.insertAtCaret('#input', "@" + nickname + ": ")
        });
        $('.btn-emoji').click(function () {
            if ($('.fui-content').hasClass('show-emoji')) {
                $('.block-input').removeClass('focus')
            } else {
                $('.block-input').addClass('focus')
            }
            $('.fui-content').toggleClass('show-emoji');
            $(this).toggleClass('active');
            modal.scrollBottom()
        });
        $(".block-emoji .item").click(function () {
            var id = $(this).attr('title');
            modal.insertAtCaret('#input', '[' + id + ']')
        });
        $('.btn-like').click(function () {
            if (!modal.wsConnected) {
                return
            }
            modal.clickLike();
            var time = new Date().getTime();
            if (modal.lastliketime + 10000 >= time) {
                return
            }
            modal.lastliketime = time;
            modal.wsSend('clicklike', {toUser: 'system'})
        });
        $('.btn-plus').click(function () {
            $('.fui-content').toggleClass('show-plus');
            modal.scrollBottom()
        });
        $('.btn-send').on('touchstart', function () {
            var value = $.trim($("#input").val());
            if (!value) {
                FoxUI.toast.show('不能发送空消息');
                return
            }
            var msg = modal.wsSend('text', {toUser: 'all', text: value});
            if (msg) {
                $(this).removeClass('active');
                $("#input").val('');
                modal.msgAt = {}
            }
            $('.fui-content').removeClass('show-emoji');
            $('.block-input .input .btn-emoji').removeClass('active')
        });
        $('.layer-roominfo .room-btn').click(function () {
            var _this = $(this);
            var roomid = _this.data("roomid");
            core.json('live/room/favorite', {'roomid': roomid}, function (ret) {
                if (ret.status == 0) {
                    FoxUI.loader.show(ret.result.message, 'icon icon-cry');
                    setTimeout(function () {
                        FoxUI.loader.hide()
                    }, 1000);
                    return
                }
                if (ret.result.favorite == 0) {
                    $('.btn-favorite').removeClass('disabled').text('订阅');
                    _this.removeClass('disabled').text('点击订阅');
                    FoxUI.loader.show('取消订阅成功', 'icon icon-check')
                } else {
                    $('.btn-favorite').addClass('disabled').text('取消');
                    _this.addClass('disabled').text('取消订阅');
                    FoxUI.loader.show('订阅成功', 'icon icon-check')
                }
                setTimeout(function () {
                    FoxUI.loader.hide()
                }, 1000)
            }, true, true)
        });
        $('.layer .layer-close').click(function () {
            var layer = $(this).closest('.layer');
            $('.layer-mask').fadeOut(200);
            if (layer.hasClass('in')) {
                layer.removeClass('in');
                if (layer.hasClass('layer-at')) {
                    clearTimeout(modal.liveAtEnd)
                }
            } else {
                $(this).closest('.layer').fadeOut(200)
            }
            $('.layer-mask').fadeOut(200)
        });
        $('.live-info').click(function () {
            $('.layer-mask').fadeIn(200);
            $('.layer-roominfo').addClass('in')
        });
        $(document).on('click', '.block-content .msg .redpack', function () {
            var title = $.trim($(this).data('title'));
            var pushid = $(this).data('pushid');
            if (pushid == '') {
                FoxUI.toast.show('参数错误');
                return
            }
            if ($(this).hasClass('stop')) {
                return
            }
            $('.layer-redpack').attr('data-pushid', pushid);
            $(this).addClass('stop');
            FoxUI.loader.show('loading');
            modal.wsSend('redpackget', {toUser: 'system', pushid: pushid, openid: modal.wsConfig.openid});
            $('.layer-redpack .redpack-title').text(title)
        });
        $(document).on('click', '.block-content .msg .coupon', function () {
            var title = $.trim($(this).text());
            var pushid = $(this).data('pushid');
            if (pushid == '') {
                FoxUI.toast.show('参数错误');
                return
            }
            if ($(this).hasClass('stop')) {
                return
            }
            modal.wsSend('coupondraw', {
                toUser: 'system',
                pushid: pushid,
                openid: modal.wsConfig.openid,
                siteroot: modal.wsConfig.siteroot
            })
        });
        $('.btn-link').click(function () {
            var url = $(this).data('url');
            if ($('#liveframe').length < 1) {
                $('.fui-content').append('<iframe id="liveframe"></iframe>')
            }
            $('#liveframe').attr('src', url).show()
        });
        $('.layer-redpack .redpack-draw').click(function () {
            if (!modal.wsConnected) {
                FoxUI.toast.show('通讯服务器连接失败');
                return false
            }
            var _this = $(this), redpack = $(this).closest('.layer-redpack');
            if (_this.hasClass('rotate')) {
                return
            }
            var pushid = redpack.attr('data-pushid');
            if (pushid == '') {
                FoxUI.toast.show('参数错误');
                return
            }
            redpack.attr('data-pushid', pushid);
            _this.addClass('rotate');
            redpack.addClass('stop');
            modal.wsSend('redpackdraw', {
                toUser: 'system',
                pushid: pushid,
                openid: modal.wsConfig.openid,
                siteroot: modal.wsConfig.siteroot
            })
        });
        $('.btn-goods').click(function () {
            $('.layer-mask').fadeIn(200);
            $('.layer-goods .inner').css('height', $('.layer-goods').height() + 'px');
            $('.layer-goods').show().addClass('in')
        });
        $('.btn-gifts').click(function () {
            $('.layer-mask').fadeIn(200);
            $('.layer-gifts').addClass('in')
        });
        $('.btn-goon').click(function () {
            $('.layer-mask').fadeIn(200);
            $('.layer-gifts').addClass('in');
            $('.layer-coupon').removeClass("in roomcoupon")
        });
        $(document).click(function (e) {
            var input = $(e.target).closest('.block-input').length;
            var emoji = $(e.target).closest('.block-emoji').length;
            var plus = $(e.target).closest('.block-plus').length;
            if (emoji < 1 && input < 1 && plus < 1) {
                $('.fui-content').removeClass('show-emoji');
                $('.block-input .input .btn-emoji').removeClass('active');
                $('.fui-content').removeClass('show-plus');
                $('#input').blur()
            }
        });
        $('.layer-coupon .btn-yellow').click(function () {
            $('.layer-coupon').find('.layer-close').click();
            $('.btn-goods').click()
        });
        $('.btn-refresh').click(function () {
            location.reload()
        });
        $(".roomcoupon").off("click").on("click", function () {
            var _this = $(this);
            var roomid = parseInt(_this.attr("data-roomid"));
            var couponid = parseInt(_this.attr("data-couponid"));
            var livetime = parseInt(_this.attr("data-livetime"));
            var disabled = _this.hasClass("disabled") ? false : true;
            var couponuselimit = _this.find('.subtitle').html() != '' ? _this.find('.subtitle').html() : '无使用条件';
            var couponvaluetext = _this.find('.left').find('span').html();
            if (disabled) {
                core.json('live/room/roomcoupon', {
                    roomid: roomid,
                    livetime: livetime,
                    couponid: couponid
                }, function (ret) {
                    var result = ret.result;
                    if (ret.status < -1) {
                        _this.addClass("disabled").find(".live-mask").text(result.message);
                        $('.layer-gifts').removeClass('in');
                        $('.layer-mask').fadeIn(200);
                        $('.layer-coupon .coupon-title').text(result.message);
                        $('.layer-coupon .coupon-fail-title').text('');
                        $('.layer-coupon').addClass('fail').addClass('in');
                        return
                    } else if (ret.status >= -1 && ret.status <= 0) {
                        FoxUI.toast.show(result.message)
                    } else {
                        $('.msg .content .coupon[data-pushid="' + couponid + '"]').text('优惠券已领取').addClass('drew');
                        $('.layer-mask').fadeIn(200);
                        $('.layer-gifts').removeClass('in');
                        $('.layer-coupon .coupon-title').text('优惠券已到账');
                        var html = '';
                        if (couponvaluetext.indexOf("减") >= 0) {
                            html += "¥"
                        }
                        var re = /[\u4E00-\u9FA5]/g;
                        couponvaluetext = couponvaluetext.replace(re, "");
                        html += ' <span class="money">' + parseFloat(couponvaluetext) + '</span>';
                        if (couponvaluetext.indexOf("折") >= 0) {
                            html += '折'
                        }
                        $('.layer-coupon .price').html(html);
                        $('.layer-coupon .desc').html(couponuselimit);
                        $('.layer-coupon').removeClass('fail').addClass('in').addClass('roomcoupon')
                    }
                })
            }
        })
    };
    modal.initRedpackList = function (arr) {
        var elm = $('.layer-redpack .redpack-list .inner'), html = '';
        elm.empty();
        if ($.isArray(arr)) {
            $.each(arr, function (index, item) {
                html += '<div class="item"><div class="avatar"><img src="../addons/ewei_shopv2/static/images/customer.jpg"></div><div class="nickname">' + item.nickname + '</div><div class="price"><span>￥</span>' + item.money + '</div></div>'
            })
        }
        elm.html(html)
    };
    modal.initNotice = function () {
        if ($('.block-notice').length < 1) {
            return false
        }
        modal.initNoticeScroll();
        setInterval(function () {
            modal.initNoticeScroll(true);
            setTimeout(function () {
                modal.initNoticeScroll()
            }, 30000)
        }, 20000);
    };
    modal.initNoticeScroll = function (hide) {
        var elm = $('.block-notice');
        if (hide) {
            elm.hide();
            clearInterval(modal.notice);
            return
        }
        elm.show();
        var left = $(window).width();
        modal.notice = setInterval(function () {
            left -= 1;
            var width = elm.find('.inner').width();
            if (left < 0 - width) {
                left = $(window).width()
            }
            elm.find('.inner').css({left: left + 'px'}, 200)
        }, 40)
    };
    modal.clickLike = function () {
        var colors = ['#ffc510', '#ff4a4a', '#ff9141', '#fb7c63', '#05e0e8', '#24ec79', '#50b7ff', '#b9f110', '#59e4b5', '#fe76e9', '#b976fe', '#fea2d0', '#918eff'], cindex = Math.floor(Math.random() * 12);
        var icons = ['icon-aixin1', 'icon-gouwudai', 'icon-yifuicon122438', 'icon-juzi', 'icon-liwu', 'icon-aixin', 'icon-flower1', 'icon-shuiguo', 'icon-kafei'], iindex = Math.floor(Math.random() * 8);
        var x = 200, y = 400;
        var rand = parseInt(Math.random() * (x - y + 1) + y);
        $('.fui-content').append('<div class="ico-like" style="color: ' + colors[cindex] + ';"><i class="icon ' + icons[iindex] + '"></i></div>');
        $(".ico-like").animate({bottom: "800px", opacity: "0", right: rand,}, 3000, null, function () {
            $(this).remove()
        })
    };
    modal.scrollBottom = function () {
        var elm = $('.tab-content[data-tab="interaction"]');
        var scrollHeight = elm[0].scrollHeight;
        elm.stop(true).animate({scrollTop: scrollHeight + "px"}, 100)
    };
    modal.tomedia = function (src) {
        if (typeof src != 'string') {
            return ''
        }
        if (src.indexOf('http://') == 0 || src.indexOf('https://') == 0 || src.indexOf('../addons/ewei_shopv2/') == 0) {
            return src
        } else if (src.indexOf('images/') == 0 || src.indexOf('audios/') == 0) {
            return modal.wsConfig.attachurl + src
        }
    };
    modal.insertAtCaret = function (elm, textFeildValue) {
        var textObj = $(elm).get(0);
        if (document.all && textObj.createTextRange && textObj.caretPos) {
            var caretPos = textObj.caretPos;
            caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == '' ? textFeildValue + '' : textFeildValue
        } else if (textObj.setSelectionRange) {
            var rangeStart = textObj.selectionStart;
            var rangeEnd = textObj.selectionEnd;
            var tempStr1 = textObj.value.substring(0, rangeStart);
            var tempStr2 = textObj.value.substring(rangeEnd);
            textObj.value = tempStr1 + textFeildValue + tempStr2;
            textObj.focus();
            var len = textFeildValue.length;
            textObj.setSelectionRange(rangeStart + len, rangeStart + len);
            textObj.blur()
        } else {
            textObj.value += textFeildValue
        }
        $(elm).trigger('change')
    };

    modal.startVideo= function() {
        modal.myPlayer.play();
        //微信内全屏支持
      /*  document.getElementById('player').style.width = window.screen.width + "px";
        document.getElementById('player').style.height = window.screen.height + "px";*/

        //判断开始播放视频，移除高斯模糊等待层
        var isVideoPlaying = setInterval(function(){
            var currentTime = modal.myPlayer.currentTime();
            if(currentTime > 0){
                $('.vjs-poster').remove();
                clearInterval(isVideoPlaying);
            }
        },200);
        //判断视频是否卡住，卡主3s重新load视频
        var lastTime = -1,
            tryTimes = 0;
        clearInterval(modal.isVideoBreak);
        modal.isVideoBreak = setInterval(function(){
            var currentTime = modal.myPlayer.currentTime();
            console.log('currentTime'+currentTime+'lastTime'+lastTime);

            if(currentTime == lastTime){
                //此时视频已卡主3s
                //设置当前播放时间为超时时间，此时videojs会在play()后把currentTime设置为0
                modal.myPlayer.currentTime(currentTime+10000);
                modal.myPlayer.play();

                //尝试6次播放后，如仍未播放成功提示刷新
                if(++tryTimes > 6){
                    FoxUI.toast.show('您的网速有点慢，请在自动刷新之后重新点击观看！');
                    tryTimes = 0;
                }
            }else{
                lastTime = currentTime;
                tryTimes = 0;
            }
        },3000)

    }
    return modal
});