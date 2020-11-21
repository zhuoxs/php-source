define(['core'], function (core) {
    var modal = {couponid: 0, couponmerchid: 0, coupondiv: null};
    modal.init = function (jie, cashierid, operatorid, id) {
        modal.cashierid = cashierid;
        modal.operatorid = operatorid;
        modal.coupondiv = $('#coupondiv');
        var $money = $("#money");
        var goodstitle = $money.data('title');
        $(document).off('click','#btn-wechat').on('click','#btn-wechat',function () {
            var money = parseFloat($money.val());
            if (isNaN(money) || money <= 0) {
                FoxUI.toast.show('金额必须大于0!');
                return
            }
            setTimeout(function () {
                FoxUI.confirm('确认要支付 '+money+' 元吗?', '提醒', function () {
                    core.json('cashier/pay/pay', {
                        cashierid: modal.cashierid,
                        operatorid: modal.operatorid,
                        couponid: modal.couponid,
                        couponmerchid: modal.couponmerchid,
                        paytype: '0',
                        money: money,
                        goodstitle: goodstitle,
                        jie: jie
                    }, function (rjson) {
                        if (rjson.status != 1) {
                            $('.btn-pay').removeAttr('submit');
                            FoxUI.toast.show(rjson.result.message);
                            return
                        }
                        if (typeof rjson.result.success == 'boolean' && rjson.result.success) {
                            location.href = core.getUrl("cashier/pay/success", {
                                cashierid: modal.cashierid,
                                orderid: rjson.result.logid
                            });
                            return
                        }
                        var wechat = rjson.result.wechat;
                        if (wechat.weixin) {
                            function onBridgeReady() {
                                WeixinJSBridge.invoke('getBrandWCPayRequest', {
                                    'appId': wechat.appid ? wechat.appid : wechat.appId,
                                    'timeStamp': wechat.timeStamp,
                                    'nonceStr': wechat.nonceStr,
                                    'package': wechat.package,
                                    'signType': wechat.signType,
                                    'paySign': wechat.paySign
                                }, function (res) {
                                    if (res.err_msg == 'get_brand_wcpay_request:ok') {
                                        core.json('cashier/pay/orderquery', {
                                            orderid: rjson.result.logid,
                                            cashierid: modal.cashierid
                                        }, function (pay_json) {
                                            if (pay_json.status == 1) {
                                                location.href = core.getUrl("cashier/pay/success", {
                                                    cashierid: modal.cashierid,
                                                    orderid: pay_json.result.list[0]
                                                });
                                                return
                                            }
                                            FoxUI.toast.show(pay_json.result.message);
                                            $('.btn-pay').removeAttr('submit')
                                        }, true, true)
                                    } else if (res.err_msg == 'get_brand_wcpay_request:cancel') {
                                        $('.btn-pay').removeAttr('submit');
                                        FoxUI.toast.show('取消支付')
                                    } else {
                                        FoxUI.toast.show(res.err_msg)
                                    }
                                })
                            }

                            if (typeof WeixinJSBridge == "undefined") {
                                if (document.addEventListener) {
                                    document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false)
                                } else if (document.attachEvent) {
                                    document.attachEvent('WeixinJSBridgeReady', onBridgeReady);
                                    document.attachEvent('onWeixinJSBridgeReady', onBridgeReady)
                                }
                            } else {
                                onBridgeReady()
                            }
                        }
                        if (wechat.weixin_jie || wechat.jie == 1) {
                            modal.payWechatJie(rjson.result)
                        }
                    }, true, true)
                });
            },100);
        });
        $(document).off('click','#btn-alipay').on('click','#btn-alipay',function () {
            var money = parseFloat($money.val());
            var $this = $(this);
            var paytype = $this.data('paytype');
            if (isNaN(money) || money <= 0) {
                FoxUI.toast.show('金额必须大于0!');
                return
            }
            setTimeout(function () {
                FoxUI.confirm('确认要支付 '+money+' 元吗?','提醒',function () {
                    core.json('cashier/pay/pay', {
                        cashierid: modal.cashierid,
                        operatorid: modal.operatorid,
                        couponid: modal.couponid,
                        couponmerchid: modal.couponmerchid,
                        paytype: paytype,
                        goodstitle: goodstitle,
                        money: money
                    }, function (rjson) {
                        if (rjson.status == 1) {
                            if (typeof rjson.result.code_url != 'undefined') {
                                var ua = navigator.userAgent.toLowerCase();
                                if (/iphone|ipad|ipod/.test(ua)) {
                                    location.href = rjson.result.code_url
                                } else if (/android/.test(ua)) {
                                    // $("#ali").prop('src', rjson.result.code_url);
                                    location.href = rjson.result.code_url;
                                    var settime = setInterval(function () {
                                        core.json('cashier/pay/orderquery', {
                                            orderid: rjson.result.out_trade_no,
                                            cashierid: modal.cashierid
                                        }, function (pay_json) {
                                            if (pay_json.status == 1) {
                                                $('.order-weixinpay-hidden').hide();
                                                $('.btn-pay').removeAttr('submit');
                                                clearInterval(settime);
                                                location.href = core.getUrl("cashier/pay/success", {
                                                    cashierid: modal.cashierid,
                                                    orderid: pay_json.result.list[0]
                                                });
                                                return
                                            }
                                        }, false, true)
                                    }, 3000)
                                }
                            } else {
                                var alipay = $("#alipay");
                                var html = '';
                                $.each(rjson.result.list, function (index, item) {
                                    html += '<input type="hidden" name=\'' + index + '\' value=\'' + item + '\'>'
                                });
                                alipay.append(html);
                                alipay.submit()
                            }
                        } else {
                            FoxUI.toast.show(rjson.result.message)
                        }
                    },true)
                })
            },100);
        });
        if (id != false) {
                var price = parseFloat($money.val());
                if (price != '' && !isNaN(price) && price > 0) {
                    $(".weiKeyNum1").trigger("click")
                }
        }
        if (id == false) {
            var weiKeyBoard = $("#weiKeyBoard");
            var weiKeyNum = $(".weiKeyNum");
            $money.click(function (e) {
                weiKeyBoard.addClass('in');
                var fui_content = $(".fui-content");
                fui_content.height("60%");
                fui_content.scrollTop(fui_content[0].scrollHeight)
            });
            $("#firstTd").click(function () {
                weiKeyBoard.removeClass('in');
                $(".fui-content").height("100%")
            });
            weiKeyNum.on($.touchEvents.start, function () {
                var $this = $(this);
                $(this).css({"background-color": "#f8f8f8", 'color': '#333333'});
                if ($this.attr('value') == 'back') {
                    $money.val($money.val().substring(0, $money.val().length - 1))
                }
                if ($this.text() == '.') {
                    if ($money.val().indexOf('.') != -1) {
                        return
                    }
                }
                var newValue = $money.val() + $this.text();
                if (newValue != -1) {
                    var str = newValue.split('.');
                    if (typeof str[1] != 'undefined' && str[1].length > 2) {
                        return
                    }
                }
                $money.val(newValue);
                modal.getcoupon(newValue)
            });
            weiKeyNum.on($.touchEvents.end, function () {
                var $this = $(this);
                $(this).css({"background-color": "#ffffff", "color": "#555"})
            });
            $money.trigger('click')
        }
    };
    modal.payWechatJie = function (res) {
        var img = core.getUrl('index/qr', {url: res.wechat.code_url});
        $('#qrmoney').text(res.log.money);
        $('#btnWeixinJieCancel').unbind('click').click(function () {
            $('.btn-pay').removeAttr('submit');
            clearInterval(settime);
            $('.order-weixinpay-hidden').hide()
        });
        $('.order-weixinpay-hidden').show();
        var settime = setInterval(function () {
            core.json('cashier/pay/orderquery', {orderid: res.logid, cashierid: modal.cashierid}, function (pay_json) {
                if (pay_json.status == 1) {
                    $('.order-weixinpay-hidden').hide();
                    $('.btn-pay').removeAttr('submit');
                    clearInterval(settime);
                    location.href = core.getUrl("cashier/pay/success", {
                        cashierid: modal.cashierid,
                        orderid: pay_json.result.list[0]
                    });
                    return
                }
            }, false, true)
        }, 3000);
        $('.verify-pop').find('.close').unbind('click').click(function () {
            $('.order-weixinpay-hidden').hide();
            $('.btn-pay').removeAttr('submit');
            clearInterval(settime)
        });
        $('.verify-pop').find('.qrimg').attr('src', img).show()
    };
    modal.bindCoupon = function (money) {
        var coupondiv = modal.coupondiv;
        coupondiv.unbind('click').click(function () {
            core.json('cashier/pay/getcoupon', {money: money, cashierid: modal.cashierid}, function (rjson) {
                if (rjson.result.coupons.length > 0) {
                    coupondiv.show().find('.badge').html(rjson.result.coupons.length).show();
                    coupondiv.find('.text').hide();
                    require(['biz/sale/coupon/picker'], function (picker) {
                        picker.show({
                            couponid: modal.couponid, coupons: rjson.result.coupons, onCancel: function () {
                                modal.couponid = 0;
                                modal.couponmerchid = 0;
                                coupondiv.find('.fui-cell-label').html('优惠券');
                                coupondiv.find('.fui-cell-info').html('')
                            }, onSelected: function (data) {
                                modal.couponid = data.id || data.couponid;
                                modal.couponmerchid = data.merchid;
                                coupondiv.find('.fui-cell-label').html('已选择');
                                coupondiv.find('.fui-cell-info').html(data.couponname);
                                coupondiv.data(data)
                            }
                        })
                    })
                } else {
                    FoxUI.toast.show('未找到优惠券!');
                    modal.hideCoupon()
                }
            }, false, true)
        })
    };
    modal.hideCoupon = function () {
        modal.coupondiv.hide();
        modal.coupondiv.find('.badge').html('0').hide();
        modal.coupondiv.find('.text').show()
    };
    modal.getcoupon = function (money) {
        core.json('cashier/pay/getcoupon', {money: money, cashierid: modal.cashierid}, function (rjson) {
            if (rjson.result.coupons.length > 0) {
                modal.coupondiv.find(".badge-danger").text(rjson.result.coupons.length);
                modal.coupondiv.show();
                var fui_content = $(".fui-content");
                fui_content.scrollTop(fui_content[0].scrollHeight);
                modal.bindCoupon(money)
            } else {
                modal.coupondiv.hide()
            }
        }, false, true)
    };
    return modal
});