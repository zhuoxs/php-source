define(['core', 'tpl'], function (core, tpl) {
    var modal = {
        discountmoney:0
    };

    modal.init = function (jie,cashierid,operatorid,type) {
        modal.cashierid = cashierid;
        modal.operatorid = operatorid;
        modal.type = type;
        var $money = $("#money");
        var $no_money = $("#no_money");
        var goodstitle = $money.data('title');

        $("#add_no_money").unbind('click').click(function () {
            var $this = $(this);
            if ($this.data('status')=='0'){
                $this.data('status',1);
                $this.find('i').removeClass('icon-roundadd');
                $this.find('i').addClass('icon-roundclose');
            }else{
                $this.data('status',0);
                $this.find('i').addClass('icon-roundadd');
                $this.find('i').removeClass('icon-roundclose');
                $this.next().find('input').val('');
                modal.discount($money);
            }
            $this.next().toggle();
            if ($("table").hasClass('in')){
                var fui_content = $(".fui-content");
                fui_content.height("60%");
                fui_content.scrollTop(fui_content[0].scrollHeight);
            }
        });

        $("#btn-wechat").unbind('click').click(function () {
            var money = parseFloat($money.val());
            var no_money = parseFloat($no_money.val());
            if (isNaN(money) || money <= 0) {
                FoxUI.toast.show('金额必须大于0!');
                return
            }
            core.json('cashier/couponpay/pay', {
                cashierid: modal.cashierid,
                operatorid: modal.operatorid,
                type: modal.type,
                paytype: '0',
                money: money,
                no_money: no_money,
                goodstitle: goodstitle,
                jie: jie
            }, function (rjson) {
                if (rjson.status != 1) {
                    $('.btn-pay').removeAttr('submit');
                    FoxUI.toast.show(rjson.result.message);
                    return
                }
                var wechat = rjson.result.wechat;
                if (wechat.weixin) {
                    function onBridgeReady(){
                        WeixinJSBridge.invoke('getBrandWCPayRequest', {
                            'appId': wechat.appid ? wechat.appid : wechat.appId,
                            'timeStamp': wechat.timeStamp,
                            'nonceStr': wechat.nonceStr,
                            'package': wechat.package,
                            'signType': wechat.signType,
                            'paySign': wechat.paySign
                        }, function (res) {
                            if (res.err_msg == 'get_brand_wcpay_request:ok') {
                                core.json('cashier/pay/orderquery', {orderid: rjson.result.logid,cashierid: modal.cashierid}, function (pay_json) {
                                    if (pay_json.status == 1) {
                                        location.href = core.getUrl("cashier/pay/success",{cashierid:modal.cashierid,orderid:pay_json.result.list[0]});
                                        return
                                    }
                                    FoxUI.toast.show(pay_json.result.message);
                                    $('.btn-pay').removeAttr('submit')
                                }, true, true)
                            } else if (res.err_msg == 'get_brand_wcpay_request:cancel') {
                                $('.btn-pay').removeAttr('submit');
                                FoxUI.toast.show('取消支付')
                            } else {
                                core.json('cashier/couponpay/pay', {
                                    cashierid: modal.cashierid,
                                    operatorid: modal.operatorid,
                                    type: modal.type,
                                    paytype: '0',
                                    money: money,
                                    no_money: no_money,
                                    jie: 1
                                }, function (wechat_jie) {
                                    modal.payWechatJie(wechat_jie.result, (money-modal.discountmoney).toFixed(2))
                                }, false, true)
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
                if (wechat.weixin_jie || wechat.jie == 1) {
                    modal.payWechatJie(rjson.result,(money-modal.discountmoney).toFixed(2))
                }
            }, true, true);
        });
        $("#btn-alipay").unbind('click').click(function () {
            var money = $money.val();
            var no_money = $no_money.val();
            if (isNaN(money) || money <= 0) {
                FoxUI.toast.show('金额必须大于0!');
                return
            }
            core.json('cashier/couponpay/pay', {
                cashierid: modal.cashierid,
                operatorid: modal.operatorid,
                type: modal.type,
                paytype: '1',
                goodstitle: goodstitle,
                money: money,
                no_money: no_money
            }, function (rjson) {
                if (rjson.status == 1) {
                    var alipay = $("#alipay");
                    var html = '';
                    $.each(rjson.result.list,function (index,item) {
                        html += '<input type="hidden" name=\''+index+'\' value=\''+item+'\'>';
                    });
                    alipay.append(html);
                    alipay.submit();
                }else{
                    FoxUI.toast.show(rjson.result.message)
                }
            });
        });
        var price = parseFloat($money.val());
        if(price != '' && !isNaN(price) && price> 0){
            modal.discount($money);
        }
        var weiKeyBoard = $("#weiKeyBoard");
        var weiKeyNum = $(".weiKeyNum");
        $money.click(function (e) {
            if (modal.money){
                modal.money.parents(".fui-cell").css('border','0px');
            }
            modal.money = $(this);
            modal.money.parents(".fui-cell").css('border','1px solid rgb(108, 220, 107)');
            weiKeyBoard.addClass('in');
            var fui_content = $(".fui-content");
            fui_content.height("60%");
            fui_content.scrollTop(fui_content[0].scrollHeight);
        });
        $no_money.click(function (e) {
            if (modal.money){
                modal.money.parents(".fui-cell").css('border','0px');
            }
            modal.money = $(this);
            modal.money.parents(".fui-cell").css('border','1px solid rgb(108, 220, 107)');
            weiKeyBoard.addClass('in');
            var fui_content = $(".fui-content");
            fui_content.height("60%");
            fui_content.scrollTop(fui_content[0].scrollHeight);
        });
        $("#firstTd").click(function () {
            weiKeyBoard.removeClass('in');
            modal.money.parents(".fui-cell").css('border','0px');
            $(".fui-content").height("100%");
        });
        weiKeyNum.on($.touchEvents.start, function () {
            var $this = $(this);
            $(this).css( {"background-color": "#f8f8f8",'color':'#333333'});
            if ($this.attr('value') == 'back'){
                modal.money.val(modal.money.val().substring(0, modal.money.val().length - 1));
            }
            if ($this.text()){
                if ($this.text() == '.'){
                    if (modal.money.val().indexOf('.') != -1){
                        return;
                    }
                }
                var newValue = modal.money.val() + $this.text();

                if (newValue != -1){
                    var str = newValue.split('.');
                    if (typeof str[1] != 'undefined' && str[1].length>2){
                        return;
                    }
                }
                modal.money.val(newValue);
            }
            modal.discount($money);
        });
        weiKeyNum.on($.touchEvents.end, function () {
            var $this = $(this);
            $(this).css({"background-color":"#ffffff","color":"#555"});
        });
        $money.trigger('click');
    };

    modal.payWechatJie = function (res, money) {
        var img = core.getUrl('index/qr',{url:res.wechat.code_url});
        $('#qrmoney').text(money);
        $('#btnWeixinJieCancel').unbind('click').click(function () {
            $('.btn-pay').removeAttr('submit');
            clearInterval(settime);
            $('.order-weixinpay-hidden').hide()
        });
        $('.order-weixinpay-hidden').show();
        var settime = setInterval(function () {
            core.json('cashier/pay/orderquery', {orderid: res.logid,cashierid:modal.cashierid}, function (pay_json) {
                if (pay_json.status == 1) {
                    $('.order-weixinpay-hidden').hide();
                    $('.btn-pay').removeAttr('submit');
                    clearInterval(settime);
                    location.href = core.getUrl("cashier/pay/success",{cashierid:modal.cashierid,orderid:pay_json.result.list[0]});
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

    modal.discount = function ($money) {
        var $discount = $('#discount');
        var $no_money = $('#no_money');
        $.getJSON(core.getUrl("cashier/couponpay/get_discount"),{cashierid: modal.cashierid,type: modal.type,money:$money.val(),no_money:$no_money.val()},function (json) {
            modal.discountmoney = json.result.discountmoney;
            $discount.text('-￥'+json.result.discountmoney);
        })
    };

    return modal
});