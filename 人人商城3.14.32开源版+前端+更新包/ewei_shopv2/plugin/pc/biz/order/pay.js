define(['core', 'tpl'], function(core, tpl) {
    var modal = {
        params: {}
    };
    modal.init = function(params) {
        var defaults = {
            orderid: 0,
            wechat: {
                success: false
            },
            cash: {
                success: false
            },
            alipay: {
                success: false
            },
        };
        modal.params = $.extend(defaults, params || {});
        $('.pay-btn').unbind('click').click(function() {
            var btn = this;
            core.json('pc.order/pay/check', {
                id: modal.params.orderid
            }, function(pay_json) {
                if (pay_json.status == 1) {
                    modal.pay(btn)
                } else {
                    FoxUI.toast.show(pay_json.result.message)
                }
            }, false, true)
        });
        if (modal.params.wechat.jie == 1) {
            $('.pay-btn[data-type="wechat"]').click()
        }
    };
    modal.pay = function(btn) {
        var type = $(btn).data('type') || '';
        var btn = $('.pay-btn');
        if (type == '') {
            return
        }
        if (btn.attr('stop')) {
            return
        }
        btn.attr('stop', 1);
        if (type == 'wechat') {
            if (core.ish5app()) {
                appPay('wechat', null, null, true);
                return
            }
            modal.payWechat(btn)
        } else if (type == 'alipay') {
            if (core.ish5app()) {
                appPay('alipay', null, null, true);
                return
            }
            modal.payAlipay(btn)
        } else if (type == 'credit') {
            FoxUI.confirm('确认要支付吗?', '提醒', function() {
                modal.complete(btn, type)
            }, function() {
                btn.removeAttr('stop')
            })
        } else {
            modal.complete(btn, type)
        }
    };
    modal.payWechat = function(btn) {
        var wechat = modal.params.wechat;
        if (!wechat.success) {
            return
        }
        if (wechat.weixin) {
            WeixinJSBridge.invoke('getBrandWCPayRequest', {
                'appId': wechat.appid ? wechat.appid : wechat.appId,
                'timeStamp': wechat.timeStamp,
                'nonceStr': wechat.nonceStr,
                'package': wechat.package,
                'signType': wechat.signType,
                'paySign': wechat.paySign,
            }, function(res) {
                if (res.err_msg == 'get_brand_wcpay_request:ok') {
                    modal.complete(btn, 'wechat')
                } else if (res.err_msg == 'get_brand_wcpay_request:cancel') {
                    FoxUI.toast.show('取消支付');
                    btn.removeAttr('stop')
                } else {
                    btn.removeAttr('stop');
                    location.href = core.getUrl('pc.order/pay', {
                        id: modal.params.orderid,
                        jie: 1
                    })
                }
            })
        }
        if (wechat.weixin_jie || wechat.jie == 1) {
            modal.payWechatJie(btn, wechat)
        }
    };
    modal.payWechatJie = function(btn, wechat) {
        var img = "http://paysdk.weixin.qq.com/example/qrcode.php?data=" + wechat.code_url;
        $('#qrmoney').text(modal.params.money);
        $('.order-weixinpay-hidden').show();
        $('#btnWeixinJieCancel').unbind('click').click(function() {
            btn.removeAttr('stop');
            clearInterval(settime);
            $('.order-weixinpay-hidden').hide()
        });
        var settime = setInterval(function() {
            $.getJSON(core.getUrl('pc.order/pay/orderstatus'), {
                id: modal.params.orderid
            }, function(data) {
                if (data.status >= 1) {
                    clearInterval(settime);
                    location.href = core.getUrl('pc.order/pay/success', {
                        id: modal.params.orderid
                    })
                }
            })
        }, 1000);
        $('.verify-pop').find('.close').unbind('click').click(function() {
            $('.order-weixinpay-hidden').hide();
            btn.removeAttr('stop');
            clearInterval(settime)
        });
        $('.verify-pop').find('.qrimg').attr('src', img).show()
    };
    modal.payAlipay = function(btn) {
        var alipay = modal.params.alipay;
        if (!alipay.success) {
            return
        }
        location.href = core.getUrl('pc.order/pay_alipay', {
            url: alipay.url
        })
    };
    modal.complete = function(btn, type) {
        core.json('pc.order/pay/complete', {
            id: modal.params.orderid,
            type: type
        }, function(pay_json) {
            if (pay_json.status == 1) {
                location.href = core.getUrl('pc.order/pay/success', {
                    id: modal.params.orderid
                });
                return
            }
            FoxUI.loader.hide();
            btn.removeAttr('stop');
            FoxUI.toast.show(pay_json.result.message)
        }, false, true)
    };
    return modal
});