define(['core', 'tpl'], function (core, tpl) {
    var modal = {params: {}};
    modal.init = function (params, isteam) {
        var defaults = {
            orderid: 0,
            orderno: 0,
            teamid: 0,
            wechat: {success: false},
            cash: {success: false},
            alipay: {success: false}
        };
        modal.params = $.extend(defaults, params || {});
        $('.pay-btn').click(function () {
            modal.pay(this)
        })
    };
    modal.pay = function (btn) {
        var btn = $(btn), type = btn.data('type') || '';
        if (type == '') {
            return
        }
        if (btn.attr('stop')) {
            return
        }
        btn.attr('stop', 1);

        if(type != 'wechat' && type != 'alipay' && type != 'credit'){
            modal.complete(btn, type);
        }
        $.getJSON(
            core.getUrl('membercard/pay/checkorder'),
            {orderid: modal.params.orderid},
            function (data) {
                if (data.status<=0){
                    FoxUI.toast.show(data.result.message);
                    btn.removeAttr('stop');
                    return;
                }
                if (type == 'wechat') {
                    modal.payWechat(btn)
                } else if (type == 'alipay') {
                    if(core.ish5app()){
                        appPay('alipay', null, null, true);
                        return;
                    }
                    modal.payAlipay(btn)
                } else if (type == 'credit') {
                    FoxUI.confirm('确认要支付吗', '提醒', function () {
                        modal.complete(btn, type)
                    }, function () {
                        btn.removeAttr('stop')
                    })
                } else {
                    modal.complete(btn, type)
                }
        });
    };

    modal.payWechat = function (btn) {

        if(core.ish5app()){
            appPay('wechat', modal.params.orderno, modal.params.money, false, function () {
                var settime = setInterval(function () {
                    $.getJSON(core.getUrl('membercard/pay/orderstatus'),{id: modal.params.orderid},function (data) {
                        if (data.status>=1){
                            clearInterval(settime);
                             modal.complete(btn, 'wechat')
                        }
                    });
                },1000);
            });
            return;
        }

        var wechat = modal.params.wechat;
        if (!wechat.success) {
            return
        }
        if (wechat.weixin) {
            function onBridgeReady(){
                WeixinJSBridge.invoke('getBrandWCPayRequest', {
                    'appId': wechat.appid ? wechat.appid : wechat.appId,
                    'timeStamp': wechat.timeStamp,
                    'nonceStr': wechat.nonceStr,
                    'package': wechat.package,
                    'signType': wechat.signType,
                    'paySign': wechat.paySign,
                }, function (res) {
                    if (res.err_msg == 'get_brand_wcpay_request:ok') {
                        modal.complete(btn, 'wechat')
                    } else if (res.err_msg == 'get_brand_wcpay_request:cancel') {
                        FoxUI.toast.show('取消支付');
                        btn.removeAttr('stop')
                    } else {
                        btn.removeAttr('stop');
                        alert(res.err_msg)
                    }
                })
            }
            if (typeof WeixinJSBridge == "undefined"){
                if( document.addEventListener ){
                    document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);
                }else if (document.attachEvent){
                    document.attachEvent('WeixinJSBridgeReady', onBridgeReady);
                    document.attachEvent('onWeixinJSBridgeReady', onBridgeReady);
                }
            }else{
                onBridgeReady();
            }

        }
        if (wechat.weixin_jie) {
            var img = core.getUrl('index/qr',{url:wechat.code_url});
            $('#qrmoney').text(modal.params.money);
            $('.order-weixinpay-hidden').show();
            $('#btnWeixinJieCancel').unbind('click').click(function(){
                btn.removeAttr('stop');
                clearInterval(settime);
                $('.order-weixinpay-hidden').hide();
            });
            var settime = setInterval(function () {
                $.getJSON(core.getUrl('membercard/pay/orderstatus'),{id: modal.params.orderid},function (data) {
                    if (data.result.status>=1){
                        clearInterval(settime);
                        modal.complete(btn, 'wechat')
                    }
                });
            },1000);
            $('.verify-pop').find('.close').unbind('click').click(function () {
                $('.order-weixinpay-hidden').hide();
                btn.removeAttr('stop');
                clearInterval(settime);
            });
            $('.verify-pop').find('.qrimg').attr('src', img).show()
        }

    };
    modal.payAlipay = function (btn) {
        var alipay = modal.params.alipay;
        if (!alipay.success) {
            return
        }
        location.href = core.getUrl('order/pay_alipay', {orderid: modal.params.orderid, type: 22, url: alipay.url})
    };
    modal.complete = function (btn, type) {
        var href = "";
        var button = "";
        core.json('membercard/pay/complete', {
            orderid: modal.params.orderid,
            type: type,
        }, function (pay_json) {
            if (pay_json.status == 1) {
                document.cookie = "cate=my";
                location.href = core.getUrl('membercard/index', {
                    orderid: modal.params.orderid,
                })
               return
                text = "恭喜您，会员卡已经支付成功";
                button = "立即查看";
                href = core.getUrl('membercard/detail', {
                    id: modal.params.card_id,
                });
                FoxUI.message.show({
                    icon: 'icon icon-success',
                    content: text,
                    buttons: [{
                        text: button, extraClass: 'btn-danger', onclick: function () {
                            location.href = href
                        }
                    }, {
                        text: '取消', extraClass: 'btn-default', onclick: function () {
                            location.href = core.getUrl('membercard/detail')
                        }
                    }]
                });
            }else{
              FoxUI.toast.show(pay_json.result.message)
            }
            FoxUI.loader.hide();
            btn.removeAttr('stop');
          //  FoxUI.toast.show(pay_json.result.message)
        }, false, true)
    };
    return modal
});