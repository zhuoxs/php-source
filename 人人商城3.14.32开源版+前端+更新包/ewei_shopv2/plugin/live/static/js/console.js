define([], function () {
    var modal = {
        wsClient: false,
        wsConfig: {},
        wsConnected: false,
        wsBannedList: {},
        wsBanned: false,
        wsUserList: {},
        wsOnline: 0,
        wsFd: 0,
        settings: {},
        msgAt: {}
    };
    modal.init = function (params) {
        modal.wsConfig = params.wsConfig || {};
        modal.initWs();
        modal.initClick();
        setInterval(function () {
            if (modal.wsConnected) {
                modal.wsSend('communication', {toUser: 'system'})
            }else{
                modal.initWs();
            }
        }, 20000)
    };
    modal.initWs = function () {
        if (!modal.wsConfig || !modal.wsConfig.address) {
            modal.liveMsg('notice', '通讯服务器配置错误');
            return
        } else {
            modal.liveMsg('notice', '初始化通讯服务...')
        }
        var wsConfig = modal.wsConfig;
        var wsClient = new WebSocket(wsConfig.address);
        wsClient.onopen = function () {
            modal.wsSend('login', {toUser: 'system'})
        };
        wsClient.onmessage = function (evt) {
            var data = JSON.parse(evt.data);
            if (data.type == 'connected') {
                modal.liveMsg('notice', '聊天服务器连接成功...');
                modal.wsConnected = true;
                modal.wsFd = data.toUser;
                modal.settings = data.settings;
                if (data.banned.all == 1) {
                    modal.wsBanned = true;
                    $('.btn-bannedall').text('解除全员禁言')
                }
                $('#online').text(data.online);
                $('#banned').text(data.bannedNum);
                modal.wsOnline = data.online;
                if (!$.isArray(data.userList)) {
                    modal.wsUserList = data.userList
                }
                if (!$.isArray(data.bannedList)) {
                    modal.wsBannedList = data.bannedList
                }
                modal.wsBannedNum = data.bannedNum;
                modal.initUserList();
                modal.initBannedList();
                modal.initSetting();
                modal.initOnline()
            } else if (data.type == 'notice') {
                modal.liveMsg('notice', data.text)
            } else if (data.type == 'userEnter') {
                modal.liveMsg('notice', data.nickname + '进入直播间！掌声欢迎~');
                modal.wsUserList[data.fromUser] = {nickname: data.nickname, role: data.role, banned: data.banned};
                modal.initUserList();
                modal.wsOnline++;
                if (modal.settings.virtualadd > 1) {
                    modal.settings.virtual += modal.settings.virtualadd || 1;
                    modal.initSetting()
                }
                $('#online').text(modal.wsOnline);
                modal.initOnline()
            } else if (data.type == 'userLeave') {
                modal.liveMsg('notice', data.nickname + '离开了直播间...');
                if (!$.isEmptyObject(modal.wsUserList)) {
                    delete modal.wsUserList[data.fromUser];
                    modal.initUserList();
                    if (modal.wsOnline > 0) {
                        modal.wsOnline--;
                        $('#online').text(modal.wsOnline);
                        modal.initOnline()
                    }
                }
            } else if (data.type == 'text' || data.type == 'sent') {
                modal.liveMsg('text', data)
            } else if (data.type == 'image') {
                modal.liveMsg('image', data)
            } else if (data.type == 'repeal') {
                if (data.msgid) {
                    var text = '"' + data.nickname + '"';
                    if (data.self == 1) {
                        text = '我'
                    }
                    $('.panel-chat[data-tab="chat"] p[data-msgid="' + data.msgid + '"]').html('<span class="tip"><span class="text">' + text + '撤回了一条消息</span></span>')
                }
            } else if (data.type == 'delete') {
                if (data.msgid) {
                    if (data.self == 1) {
                        data.nickname = '我'
                    }
                    $('.panel-chat[data-tab="chat"] p[data-msgid="' + data.msgid + '"]').html('<span class="tip"><span class="text">' + data.nickname + '删除了"' + data.deleteNick + '"的一条消息</span></span>')
                }
            } else if (data.type == 'banned') {
                if (data.banned == 1) {
                    modal.wsBannedList[data.bannedUid] = {nickname: data.bannedNick, banned: 1};
                    modal.initBannedList();
                    modal.wsBannedNum++;
                    $('#banned').text(modal.wsBannedNum)
                } else {
                    if ($.isEmptyObject(modal.wsBannedList)) {
                        return
                    }
                    if (modal.wsBannedList[data.bannedUid]) {
                        delete modal.wsBannedList[data.bannedUid];
                        modal.initBannedList();
                        if (modal.wsBannedNum > 0) {
                            modal.wsBannedNum--;
                            $('#banned').text(modal.wsBannedNum)
                        }
                    }
                }
                $('.panel-chat p').each(function () {
                    var nick = $(this).find('.nickname'), btn = $(this).find('.btn-banned');
                    if (nick.data('uid') == data.bannedFd || nick.data('uid') == data.bannedUid) {
                        if (data.banned == 1) {
                            btn.text('解除禁言').data('banned', 1).attr('title', '允许此用户发言')
                        } else {
                            btn.text('禁言').data('banned', 0).attr('title', '禁止此用户发言')
                        }
                    }
                })
            } else if (data.type == 'bannedAll') {
                if (data.banned == 1) {
                    modal.wsBanned = true;
                    $('.btn-bannedall').text('解除全员禁言');
                    modal.liveMsg('notice', data.nickname + '设置了全员禁言')
                } else {
                    modal.wsBanned = false;
                    $('.btn-bannedall').text('全员禁言');
                    modal.liveMsg('notice', data.nickname + '解除了全员禁言')
                }
            } else if (data.type == 'setting') {
                if (!$.isEmptyObject(data.settings)) {
                    modal.settings = data.settings;
                    modal.initSetting();
                    modal.initOnline()
                }
            } else if (data.type == 'goods') {
                modal.liveMsg('goods', data);
                if (data.self == 1) {
                    tip.msgbox.suc('推送成功')
                }
            } else if (data.type == 'redpack') {
                modal.liveMsg('redpack', data);
                if (data.self == 1) {
                    tip.msgbox.suc('推送成功')
                }
                modal.liveMsgPush('redpack', data)
            } else if (data.type == 'redpackdraw') {
                var elm = $('.panel-push tbody').find('tr[data-pushid="' + data.redpackid + '"]');
                if (elm.length < 1) {
                    return
                }
                elm.find('.total_remain').text(data.redpack.total_remain);
                elm.find('.money_remain').text(data.redpack.money_remain)
            } else if (data.type == 'coupon') {
                modal.liveMsg('coupon', data);
                if (data.self == 1) {
                    tip.msgbox.suc('推送成功')
                }
                modal.liveMsgPush('coupon', data)
            } else if (data.type == 'coupondraw') {
                var elm = $('.panel-push tbody').find('tr[data-pushid="' + data.couponid + '"]');
                if (elm.length < 1) {
                    return
                }
                elm.find('.total_remain').text(data.coupon.total_remain);
                elm.find('.money_remain').text(data.coupon.money_remain)
            }
        };
        wsClient.onclose = function (evt) {
            if (!modal.wsConnected) {
                return
            }
            modal.liveMsg('notice', '与通讯服务器断开 <a class="btn-reconnect">点击重连</a>');
            modal.wsConnected = false
        };
        wsClient.onerror = function (evt) {
            modal.liveMsg('notice', '与通讯服务器连接失败 <a class="btn-reconnect">点击重连</a>');
            modal.wsConnected = false
        };
        modal.wsClient = wsClient
    };
    modal.wsSend = function (type, obj) {
        if (!type || $.isEmptyObject(obj)) {
            return false
        }
        if (type != 'login' && !modal.wsConnected) {
            tip.msgbox.err('与通讯服务器连接失败');
            return false
        }
        var wsConfig = modal.wsConfig;
        obj.type = type;
        obj.role = 'manage';
        obj.scene = wsConfig.scene;
        obj.roomid = wsConfig.roomid;
        obj.uniacid = wsConfig.uniacid;
        obj.uid = wsConfig.uid;
        if (!obj.nickname) {
            obj.nickname = modal.settings.nickname || wsConfig.nickname
        }
        if (modal.msgAt) {
            obj.at = modal.msgAt
        }
        modal.wsClient.send(JSON.stringify(obj));
        return obj
    };
    modal.initClick = function () {
        $(document).click(function (e) {
            var emojiList = $(e.target).closest('.emoji-list').length;
            var btnEmoji = $(e.target).closest('.btn-emoji').length;
            var input = $(e.target).closest('#input').length;
            if (!emojiList && !btnEmoji && !input) {
                $('.btn-emoji').removeClass('active');
                $('.emoji-list').hide()
            }
        });
        $('.panel-chat-tab a').click(function () {
            var tab = $(this).data('tab');
            $(this).addClass('active').siblings().removeClass('active');
            $('.panel-chat').hide();
            $('.panel-chat[data-tab="' + tab + '"]').show()
        });
        $(document).on('click', '.btn-reconnect', function () {
            if (modal.wsConnected) {
                return
            }
            modal.initWs()
        });
        $('.btn-play').click(function () {
            tip.confirm('确定要开启直播？开启直播后用户可看到直播画面', function () {
                modal.wsSend('setstatus', {toUser: 'system', status: 1})
            })
        });
        $('.btn-pause').click(function () {
            tip.confirm('确定要暂停直播？暂停直播后用户将隐藏直播画面', function () {
                modal.wsSend('setstatus', {toUser: 'system', status: 2})
            })
        });
        $('.btn-stop').click(function () {
            tip.confirm('确定要关闭直播？', function () {
                modal.wsSend('setstatus', {toUser: 'system', status: 0})
            })
        });
        $(document).on('click', '.btn-delete', function () {
            var _this = $(this);
            tip.confirm('确定删除此条发言吗？', function () {
                var msgid = _this.closest('p').data('msgid');
                if (msgid) {
                    var nickname = _this.closest('p').find('.nickname').data('nickname');
                    var uid = _this.closest('p').find('.nickname').data('uid');
                    modal.wsSend('delete', {toUser: 'system', deleteNick: nickname, deleteUid: uid, msgid: msgid})
                }
            })
        });
        $(document).on('click', '.btn-repeal', function () {
            var _this = $(this);
            tip.confirm('确定撤回发言吗？', function () {
                var msgid = _this.closest('p').data('msgid');
                if (msgid) {
                    modal.wsSend('repeal', {toUser: 'system', msgid: msgid})
                }
            })
        });
        $(document).on('click', '.btn-banned', function () {
            var _this = $(this), elm = $(this).closest('p').find('.nickname');
            var nickname = elm.data('nickname'), uid = elm.data('uid'), banned = _this.data('banned') || 0;
            var text = banned == 1 ? '确定解除禁言用户' : '确定禁言用户';
            if (uid) {
                tip.confirm(text + nickname + '"？', function () {
                    modal.wsSend('banned', {banned: banned == 1 ? 0 : 1, bannedUid: uid, bannedNick: nickname})
                })
            }
        });
        $('.btn-bannedall').click(function () {
            var _this = $(this);
            var text = modal.wsBanned ? '确定要解除禁言' : '确定要全员(除管理员外)禁言';
            tip.confirm(text + '？', function () {
                if (!modal.wsConnected) {
                    tip.msgbox.err('与通讯服务器连接失败');
                    return false
                }
                modal.wsSend('bannedAll', {toUser: 'all', banned: modal.wsBanned ? 0 : 1});
                if (modal.wsBanned) {
                    modal.wsBanned = false;
                    tip.msgbox.suc('取消全员禁言');
                    _this.text('全员禁言')
                } else {
                    modal.wsBanned = true;
                    tip.msgbox.suc('设置全员禁言');
                    _this.text('取消全员禁言')
                }
            })
        });
        $('.btn-setting').click(function () {
            tip.confirm('确定设置并推送给所有用户吗？', function () {
                var manageNick = $.trim($('.managenick').val()) || modal.wsConfig.nickname;
                var canAt = $('.canat:checked').val();
                var canRepeal = $('.canrepeal:checked').val();
                var virtualNum = $('.virtual').val();
                var virtualAddNum = $('.virtualadd').val();
                modal.wsSend('setting', {
                    toUser: 'system',
                    manageNick: manageNick,
                    canAt: canAt,
                    canRepeal: canRepeal,
                    virtualNum: virtualNum,
                    virtualAddNum: virtualAddNum
                })
            })
        });
        $('.btn-emoji').click(function () {
            if ($(this).hasClass('active')) {
                $(this).removeClass('active');
                $('.emoji-list').hide()
            } else {
                $(this).addClass('active');
                $('.emoji-list').show()
            }
        });
        $('.emoji-list .item').click(function () {
            var text = $(this).attr('title');
            modal.insertAtCaret('#input', '[' + text + ']');
            $('.btn-emoji').removeClass('active');
            $('.emoji-list').hide();
            $('#btn-send').removeClass('disabled')
        });
        $(document).on('click', '.nickname', function () {
            if ($(this).hasClass('noclick')) {
                return
            }
            if ($(this).hasClass('self')) {
                tip.msgbox.err('你不能@自己');
                return
            } else {
                var uid = $(this).data('uid'), nickname = $(this).data('nickname');
                var atLeng = modal.objectLength(modal.msgAt);
                if (atLeng >= 5) {
                    tip.msgbox.err('单次最多@5个用户');
                    return
                }
                if (modal.msgAt[uid]) {
                    return
                }
                modal.msgAt[uid] = nickname;
                if (atLeng < 1) {
                    $('.btn-ats .item.big').data('uid', uid).attr('title', nickname).find('.text').text('@' + nickname);
                    $('.btn-ats').show().removeClass('more');
                    $('.btn-ats .at-list').empty()
                } else {
                    $('.btn-ats .item.big').data('uid', 'all').attr('title', '移除全部').find('.text').text('@2个用户');
                    $('.btn-ats .at-list').empty();
                    $.each(modal.msgAt, function (uid, nickname) {
                        $('.btn-ats .at-list').append('<div class="item" data-uid="' + uid + '" title="' + nickname + '"><div class="text">' + nickname + '</div><div class="at-remove" title="点击移除">×</div></div>')
                    });
                    $('.btn-ats').show().addClass('more')
                }
            }
        });
        $(document).on('click', '.at-remove', function () {
            var uid = $(this).closest('.item').data('uid');
            var atLeng = modal.objectLength(modal.msgAt);
            if (uid == 'all' || atLeng < 2) {
                $('.btn-ats .item.big').data('uid', '').attr('title', '').find('.text').text('');
                $('.btn-ats').hide().removeClass('more');
                $('.btn-ats .at-list').empty();
                modal.msgAt = {}
            } else if (atLeng == 2) {
                delete modal.msgAt[uid];
                var user = modal.getIndex(0, modal.msgAt);
                $('.btn-ats .at-list').empty();
                $('.btn-ats .item.big').data('uid', user.key).attr('title', user.val).find('.text').text('@' + user.val);
                $('.btn-ats').removeClass('more');
                return
            } else {
                $(this).closest('.item').remove();
                $('.btn-ats .item.big').data('uid', 'all').attr('title', '').find('.text').text('@' + atLeng + '个用户')
            }
            delete modal.msgAt[uid];
            $('.btn-ats').mouseenter()
        });
        $('#input').keydown(function (e) {
            if (e.keyCode == 229 && e.shiftKey) {
            } else if (e.keyCode == 13) {
                $('#btn-send').click()
            } else if (event.keyCode == 8) {
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
                        if (res[0]) {
                            var emojiLen = $('.emoji-list .item[title="' + res[0].replace('[', '') + '"]').length;
                            if (emojiLen > 0) {
                                textValue = tempStr1.substring(0, tempStr1.lastIndexOf("[")) + tempStr2
                            }
                        }
                    } else if (delValue == " " && tempStr1.indexOf("@") > -1) {
                        var atText = tempStr1.substring(tempStr1.lastIndexOf("@"), rangeEnd);
                        var matchNull = atText.match(/(\s)/g);
                        if (!matchNull || matchNull.length < 1) {
                            textValue = tempStr1.substring(0, tempStr1.lastIndexOf("@")) + tempStr2;
                            var nickname = atText.replace('@', '');
                            nickname = nickname.replace(' ', '');
                            modal.deleteAt(nickname)
                        }
                    }
                    textObj.value = textValue;
                    textObj.focus();
                    textObj.setSelectionRange(rangeStart - 1, rangeStart - 1);
                    $(this).change();
                    modal.handleAt();
                    return false
                } else {
                    modal.handleAt();
                    return true
                }
            }
        });
        $('#btn-send').click(function () {
            if (!modal.wsConnected) {
                tip.msgbox.err('通讯服务器连接失败');
                return
            }
            var value = $.trim($("#input").val());
            if (!value) {
                return
            }
            var msg = modal.wsSend('text', {toUser: 'all', text: value});
            $(this).addClass('disabled');
            $("#input").val('');
            $('.panel-chat-tab a[data-tab="chat"]').addClass('active').siblings().removeClass('active');
            $('.panel-chat[data-tab="chat"]').show().siblings('.panel-chat').hide()
        });
        $('#input').on('input propertychange, change', function () {
            var value = $.trim($(this).val());
            if (value && modal.wsConnected) {
                $('#btn-send').removeClass('disabled')
            } else {
                $('#btn-send').addClass('disabled');
                modal.msgAt = {}
            }
        });
        $('.btn-image').click(function () {
            require(['jquery', 'util'], function ($, util) {
                util.image('', function (data) {
                    var msg = modal.wsSend('image', {toUser: 'all', text: data.attachment});
                    $("#input").val('')
                })
            })
        });
        $('.btn-push').click(function () {
            if (!modal.wsConnected) {
                tip.msgbox.err('与通讯服务器连接失败');
                return
            }
            var action = $(this).data('action');
            if (action == 'redpack') {
                $('#pushRedpackModal').modal({backdrop: 'static', keyboard: false})
            } else if (action == 'coupon') {
                $('#pushCouponModal').modal({backdrop: 'static', keyboard: false})
            } else if (action == 'link') {
                var url = biz.url('goods/query', {live: 1});
                $(this).attr({'id': 'goods_selector', 'data-url': url, 'data-callback': 'callbackGoods'});
                biz.selector.select({name: 'goods'})
            }
        });
        $('.submit-push').click(function () {
            var action = $(this).data('action');
            if (action == 'redpack') {
                var type = $('.repacktype:checked').val();
                var money = $('#redpackmoney').val();
                var total = $('#redpacktotal').val();
                var title = $('#redpacktitle').val();
                var confirm = $('#redpackconfirm').is(':checked');
                if (money == '' || money == 0) {
                    tip.msgbox.err('请设置正确的金额');
                    $('#redpackmoney').focus();
                    return
                }
                if (total > 100) {
                    tip.msgbox.err('单次发送红包个数不能大于100');
                    $('#redpacktotal').focus();
                    return
                }
                if (type == 1 && money > 500) {
                    tip.msgbox.err('单次发送金额不能大于500');
                    $('#redpackmoney').focus();
                    return
                }
                if (type == 0 && money < 0.01) {
                    tip.msgbox.err('每个红包最低0.01元');
                    $('#redpacktotal').focus();
                    return
                }
                if (total == '' || total == 0) {
                    tip.msgbox.err('请设置正确的红包个数');
                    $('#redpacktotal').focus();
                    return
                }
                if (type == 1 && (money / total) < 0.01) {
                    tip.msgbox.err('每个红包最低0.01元');
                    $('#redpacktotal').focus();
                    return
                }
                if (type == 0 && (money * total) > 500) {
                    tip.msgbox.err('单次发送金额不能大于500');
                    $('#redpackmoney').focus();
                    return
                }
                if (!confirm) {
                    tip.msgbox.err('请勾选确认按钮');
                    return
                }
                modal.wsSend('redpack', {
                    toUser: 'all',
                    redPackType: type,
                    redPackMoney: money,
                    redPackTotal: total,
                    redPackTitle: title
                });
                $('#pushRedpackModal').modal('hide');
                $('#redpackmoney').val('0');
                $('#redpacktotal').val('0');
                $('#redpacktitle').val('');
                $('.repacktype[value="0"]').prop('checked', true).siblings().removeAttr('checked');
                $('#redpackconfirm').removeAttr('checked');
                $('.repacktype').text('单个')
            } else if (action == 'coupon') {
                var couponid = $('input[name="couponid"]').val();
                var name = $('#couponid_text').val();
                var total = $('#coupontotal').val();
                var valuetext = $('#coupon_value_text').val();
                var valuetotal = $('#coupon_value_total').val();
                var uselimit = $('#coupon_uselimit').val();
                if (!couponid || couponid == 0) {
                    tip.msgbox.err('请选择优惠券');
                    return
                }
                if (total == '' || total < 1) {
                    tip.msgbox.err('最低发送1张优惠券');
                    return
                }
                if (total > 200) {
                    tip.msgbox.err('最高发送200张优惠券');
                    return
                }
                var confirm = $('#couponconfirm').is(':checked');
                if (!confirm) {
                    tip.msgbox.err('请勾选确认按钮');
                    return
                }
                modal.wsSend('coupon', {
                    toUser: 'all',
                    couponId: couponid,
                    couponTotal: total,
                    couponName: name,
                    couponValueText: valuetext,
                    couponValueTotal: valuetotal,
                    couponUseLimit: uselimit
                });
                $('#pushCouponModal').modal('hide');
                $('#coupontotal').val('0');
                $('#coupon_value_text').val('');
                $('#coupon_value_total').val('');
                $('#coupon_uselimit').val('');
                $('#couponconfirm').removeAttr('checked');
                $('#couponid_selector').find('.close').click()
            } else {
                tip.msgbox.err('未知类型')
            }
        });
        $('input[name="repacktype"]').click(function () {
            if ($(this).val() == 1) {
                $('.repacktype').text('总')
            } else {
                $('.repacktype').text('单个')
            }
        })
    };
    modal.callbackGoods = function (data) {
        modal.wsSend('goods', {
            toUser: 'all',
            goodsTitle: data.title,
            goodsThumb: data.thumb,
            goodsPrice: data.islive == 1 && data.liveprice < data.minprice ? data.liveprice : data.minprice,
            goodsId: data.id
        })
    };
    modal.callbackCoupon = function (data) {
        $('#coupon_value_text').val(data.value_text);
        $('#coupon_value_total').val(data.value_total)
    };
    modal.initSetting = function () {
        if (modal.settings.nickname) {
            $('.managenick').val(modal.settings.nickname);
            var oldUser = modal.wsUserList[modal.wsConfig.uid];
            if (!oldUser) {
                return
            }
            if (typeof oldUser != 'object') {
                oldUser = JSON.parse(oldUser)
            }
            oldUser.nickname = modal.settings.nickname;
            oldUser.nickname_old = modal.settings.nickname_old;
            modal.wsUserList[modal.wsConfig.uid] = oldUser;
            modal.initUserList();
            if (oldUser.nickname_old) {
                modal.liveMsg('notice', '管理员"' + oldUser.nickname_old + '"改名为"' + oldUser.nickname + '"')
            }
        }
        $('.canat[value="' + modal.settings.canat + '"]').attr('checked', 1);
        $('.canrepeal[value="' + modal.settings.canrepeal + '"]').attr('checked', 1);
        $('.virtual').val(modal.settings.virtual);
        $('.virtualadd').val(modal.settings.virtualadd || 1);
        modal.settings.status = modal.settings.status || 0;
        if (modal.settings.status == 0) {
            $('.online').addClass('stop').find('.status').text('未开播');
            $('.btn-play').show().siblings().hide()
        } else if (modal.settings.status == 1) {
            $('.online').removeClass('stop').removeClass('pause').find('.status').text('直播中');
            $('.btn-play').hide().siblings().show().siblings('.btn-loading').hide()
        } else if (modal.settings.status == 2) {
            $('.online').removeClass('stop').addClass('pause').find('.status').text('暂停中');
            $('.btn-pause').hide().siblings().show().siblings('.btn-loading').hide()
        }
    };
    modal.initOnline = function () {
        var online = parseInt(modal.settings.virtual) + parseInt(modal.wsOnline);
        $('#showOnline').text(online)
    };
    modal.initUserList = function () {
        if ($.isEmptyObject(modal.wsUserList)) {
            $('.panel-chat[data-tab="visitor"]').find('.empty-data').show();
            return
        }
        var manage = '', html = '';
        $.each(modal.wsUserList, function (uid, user) {
            if (typeof user != 'object') {
                user = JSON.parse(user)
            }
            var userHtml = '<p><span class="nickname noclick" data-uid="' + uid + '" data-nickname="' + user.nickname + '">' + user.nickname + '</span>';
            if (user.role != 'manage') {
                userHtml += '<span class="pull-right">';
                if (modal.wsBannedList[uid]) {
                    userHtml += '<a class="btn-banned" data-banned="1">解除禁言</a>'
                } else {
                    userHtml += '<a class="btn-banned">禁言</a>'
                }
                userHtml += ' / <a class="nickname" data-uid="' + uid + '" data-nickname="' + user.nickname + '">@TA</a></span>'
            }
            userHtml += '</p>';
            if (user.role == 'manage') {
                manage += userHtml
            } else {
                html += userHtml
            }
        });
        $('.panel-chat[data-tab="visitor"] .empty-data').hide();
        $('.panel-chat[data-tab="visitor"] .inner').html(manage + html)
    };
    modal.initBannedList = function () {
        if ($.isEmptyObject(modal.wsBannedList)) {
            $('.panel-chat[data-tab="bannedlist"]').find('.empty-data').show();
            return
        }
        var html = '';
        $.each(modal.wsBannedList, function (uid, user) {
            if (typeof user != 'object') {
                user = JSON.parse(user)
            }
            user.nickname = user.nickname || '未获取到用户昵称';
            html += '<p><span class="nickname noclick" data-uid="' + uid + '" data-nickname="' + user.nickname + '">' + user.nickname + '(' + uid + ')</span><span class="pull-right"><a class="btn-banned" data-banned="1">解除禁言</a> </span> </p>'
        });
        $('.panel-chat[data-tab="bannedlist"] .empty-data').hide();
        $('.panel-chat[data-tab="bannedlist"] .inner').html(html)
    };
    modal.deleteAt = function (nickname) {
        if (!modal.msgAt || $.isEmptyObject(modal.msgAt) || !nickname) {
            return
        }
        $.each(modal.msgAt, function (uid, nick) {
            if (nick == nickname) {
                delete modal.msgAt[uid]
            }
        })
    };
    modal.handleAt = function () {
        if (!modal.msgAt || $.isEmptyObject(modal.msgAt)) {
            return
        }
        var value = $.trim($('#input').val());
        if (!value) {
            return
        }
        var res = value.match(/@(\S*)(\s){1}/g)
    };
    modal.handleAtText = function (text, at) {
        if (at && !$.isEmptyObject(at)) {
            $.each(at, function (uid, nickname) {
                var replace = '<span class="nickname" data-nickname="' + nickname + '" data-uid="' + uid + '">@' + nickname + ' </span>';
                text = text.replace('@' + nickname + ' ', replace)
            })
        }
        return text
    };
    modal.liveMsg = function (type, msg) {
        var atText = '';
        if (msg.atUsers && !$.isEmptyObject(msg.atUsers)) {
            $.each(msg.atUsers, function (uid, nickname) {
                atText += '<span class="nickname';
                if (uid == modal.wsConfig.uid) {
                    atText += ' self', nickname = '我'
                }
                atText += '" data-uid="' + uid + '" data-nickname="' + nickname + '">@' + nickname + '</span> '
            })
        }
        if (type == 'image') {
            msg.text = modal.tomedia(msg.text);
            msg.text = '<a href="' + msg.text + '" target="_blank"><img src="' + msg.text + '" /></a>'
        } else if (type == 'text' && msg.text) {
            if (msg.text.indexOf("[") > -1 && msg.text.indexOf("]") > -1) {
                var res = msg.text.match(/\[([^\]]+)\]/g);
                if (res) {
                    $.each(res, function (index, val) {
                        var text = val.replace('[', '');
                        text = text.replace(']', '');
                        var elm = $('.emoji-list .item[title="' + text + '"]');
                        if (elm.length > 0) {
                            var face = '<img class="face" src="../addons/ewei_shopv2/plugin/live/static/images/face/' + elm.data('index') + '.gif?v=2" />';
                            msg.text = msg.text.replace(val, face)
                        }
                    })
                }
            }
        }
        var elm = $('.panel-chat[data-tab="chat"]'), text = typeof(msg) == 'object' ? msg.text : msg;
        var html = '<p data-msgid="';
        if (msg.msgid) {
            html += msg.msgid
        }
        html += '">';
        if (type != 'notice') {
            var date = modal.time2date(msg.time);
            html += '<span class="time">[' + date + '] </span>';
            if (type == 'goods') {
                text = '<a class="goods" href="' + biz.url('goods/edit', {id: msg.goodsId}) + '" target="_blank">';
                text += '<span class="thumb"><img src="' + modal.tomedia(msg.goodsThumb) + '"/></span>';
                text += '<span class="info"><span class="title">' + msg.goodsTitle + '</span><span class="price">￥' + msg.goodsPrice + '</span></span>';
                text += '</span></a>'
            } else if (type == 'redpack') {
                text = '[余额红包] ' + msg.redpack.title + '，请到手机端查看'
            } else if (type == 'coupon') {
                text = '[优惠券] ' + msg.coupon.title + '，请到手机端查看'
            }
            if (msg.self) {
                if (modal.msgAt) {
                    text = modal.handleAtText(text, modal.msgAt)
                }
                html += '<span class="nickname self" title="点击修改昵称">' + msg.nickname + '(我)</span>：' + atText + text;
                if (type != 'goods' && type != 'redpack' && type != 'coupon') {
                    html += '<a class="btn-repeal" title="撤回此条消息"> 撤回</a>'
                }
            } else {
                if (msg.at) {
                    text = modal.handleAtText(text, msg.at)
                }
                html += '<span class="nickname" title="点击@Ta" data-nickname="' + msg.nickname + '" data-uid="' + msg.fromUser + '">' + msg.nickname + '</span>：' + atText + text;
                if (type != 'goods' && type != 'redpack') {
                    html += '\n<a class="btn-delete" title="删除此条消息"> 删除</a>';
                    html += '\n<a class="btn-banned" title="禁止此用户发言"> 禁言</a>'
                }
            }
        } else {
            html += '<span class="notice">系统提醒：' + text + '</span>'
        }
        html += '<p>';
        elm.append(html);
        if (elm[0].scrollHeight > elm.height()) {
            elm.stop(true).animate({scrollTop: elm[0].scrollHeight + "px"}, 1)
        }
    };
    modal.liveMsgPush = function (type, data) {
        if (type == 'coupon') {
            var typetext = '-'
        } else {
            var typetext = data.redpack.type == 1 ? '拼手气红包' : '普通红包'
        }
        var pushtype = type == 'coupon' ? '优惠券' : '红包(余额)';
        var pushid = type == 'coupon' ? data.coupon.id : data.redpack.id;
        var title = type == 'coupon' ? data.coupon.title : data.redpack.title;
        var total = type == 'coupon' ? data.coupon.total : data.redpack.total;
        var total = type == 'coupon' ? data.coupon.total : data.redpack.total;
        var money = type == 'coupon' ? '-' : data.redpack.money;
        var label = type == 'coupon' ? 'label-warning' : 'label-danger';
        var html = '<tr data-pushid="' + pushid + '" data-type="' + type + '"><td><label class="label ' + label + '">' + pushtype + '</label></td>';
        html += '<td>' + title + '</td><td>' + modal.formatDateTime(pushid) + '</td><td>' + total + '</td>';
        html += '<td class="total_remain">' + total + '</td><td>' + money + '</td>';
        html += '<td class="money_remain">' + money + '</td><td>' + typetext + '</td>';
        var href = biz.url('live/room/console_record', {
            pushid: pushid,
            type: type == 'coupon' ? 2 : data.redpack.type,
            id: modal.wsConfig.roomid
        });
        html += '<td><a href="' + href + '" data-toggle="ajaxModal">领取记录</a></td></tr>';
        $('.panel-push tbody').prepend(html).animate({scrollTop: "0px"}, 100).closest('.panel-body').find('.table').show();
        $('.panel-body .empty-data').hide();
        var pushcount = parseInt($('#pushcount').text());
        $('#pushcount').text(pushcount + 1)
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
    modal.objectLength = function (obj) {
        if (typeof obj != 'object') {
            return
        }
        var length = 0;
        $.each(obj, function (key, val) {
            if (key) {
                length++
            }
        });
        return length
    };
    modal.getIndex = function (index, obj) {
        if (typeof obj != 'object' || $.isEmptyObject(obj)) {
            return
        }
        var i = 0, k = '', r = {};
        $.each(obj, function (key, val) {
            if (i == index) {
                k = key;
                return false
            }
            if (key) {
                i++
            }
        });
        if (modal.msgAt[k]) {
            r = {key: k, val: modal.msgAt[k]}
        }
        return r
    };
    modal.time2date = function (time) {
        if (!time) {
            return
        }
        var date = new Date(time * 1000), ret = '';
        if (date.getHours() < 10) {
            ret += '0'
        }
        ret += date.getHours() + ':';
        if (date.getMinutes() < 10) {
            ret += '0'
        }
        ret += date.getMinutes() + ':';
        if (date.getSeconds() < 10) {
            ret += '0'
        }
        ret += date.getSeconds() + '';
        return ret
    };
    modal.formatDateTime = function (inputTime) {
        var date = new Date(inputTime * 1000);
        var y = date.getFullYear();
        var m = date.getMonth() + 1;
        m = m < 10 ? ('0' + m) : m;
        var d = date.getDate();
        d = d < 10 ? ('0' + d) : d;
        var h = date.getHours();
        h = h < 10 ? ('0' + h) : h;
        var minute = date.getMinutes();
        var second = date.getSeconds();
        minute = minute < 10 ? ('0' + minute) : minute;
        second = second < 10 ? ('0' + second) : second;
        return y + '-' + m + '-' + d + ' ' + h + ':' + minute + ':' + second
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
    return modal
});