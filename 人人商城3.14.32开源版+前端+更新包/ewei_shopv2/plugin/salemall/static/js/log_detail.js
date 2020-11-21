define(['core', 'tpl'], function (core, tpl) {
    var modal = {goods: false, address: 0, addressid: 0, storeid: 0, canpay: 0, needdispatchpay: 0,settime:0, paying:false};
    modal.init = function (params) {
        modal.goods = goods = params.goods;
        modal.log = goods = params.log;
        modal.storeid = 0;

        if(modal.goods.isverify==0 && modal.log){
            modal.addressid = modal.log.addressid;
        }

        clearInterval(modal.settime);

        var loadAddress = false;
        if (typeof(window.selectedAddressData) !== 'undefined') {
            modal.address = window.selectedAddressData;
            modal.addressid = modal.address.id;
            $("#address_select").val(modal.address.address);
            $("#carrier_realname").show().find("input").val(modal.address.realname);
            $("#carrier_mobile").show().find("input").val(modal.address.mobile);
            delete window.selectedAddressData
        }
        var loadStore = false;
        if (typeof(window.selectedStoreData) !== 'undefined') {
            loadStore = window.selectedStoreData;
            modal.storeid = loadStore.id;
            $('#address_select').val(loadStore.storename);
            delete window.selectedStoreData;
        }
        if (goods.isverify == 0) {
            if (modal.log.dispatchstatus == 0) {
                modal.canpay = 1
            }
            if (modal.goods.isendtime == 1) {
                if (modal.goods.currenttime > goods.endtime) {
                    modal.canpay = false;
                }
            } else {
                modal.canpay = true;
            }
        } else {
            if (modal.log.storeid == 0) {
                modal.canpay = 1
            }
        }
        if (modal.log.status == 3) {
            modal.canpay = false
        }
        if (modal.canpay) {
            $('.fui-footer .btn-1').click(function () {
                if (modal.goods.isverify == 0) {
                    modal.payDispatch()
                } else {
                    modal.setStore()
                }
            })
        }
        if (modal.goods.isverify == 1 && modal.log.status == 2) {
            $('.fui-footer .btn-2').click(function () {
                modal.ExchangeHandler.verify(modal.log.id)
            });
            $(".verify-pop .close").click(function () {
                modal.ExchangeHandler.close()
            })
        }
    };
    modal.payDispatch = function () {
        if (modal.addressid<1) {
            FoxUI.toast.show("请选择收货地址!");
            return
        }
        if (modal.goods.isverify == 0 && modal.goods.dispatch > 0) {
            var tiptext = '确认兑换并支付运费吗？';
            modal.needdispatchpay = 1
        } else {
            var tiptext = '确认兑换吗?';
            modal.needdispatchpay = 0
        }
        FoxUI.message.show({
            icon: 'icon icon-information',
            content: tiptext,
            buttons: [{
                text: '确定', extraClass: 'btn-danger', holdModal: true, onclick: function () {
                    if(modal.paying){
                        return;
                    }
                    $(".fui-message-popup .btn-danger").text('正在处理...');
                    modal.paying = true;

                    setTimeout(function () {
                        core.json('creditshop/log/paydispatch', {
                            id: modal.log.id,
                            addressid: modal.addressid
                        }, function (json) {
                            var result = json.result;

                            if (modal.needdispatchpay && core.ish5app()) {
                                if(json.status<=0){
                                    FoxUI.toast.show(result.message);
                                }else{
                                    appPay('wechat', json.result.dispatchno, json.result.money, false, function () {
                                        modal.settime = setInterval(function () {
                                            FoxUI.toast.show('未支付成功!');
                                            modal.payResult();
                                        },2000);
                                    });
                                }
                                return;
                            }

                            if (modal.needdispatchpay && !result.wechat) {
                                FoxUI.toast.show(result.message);
                                return
                            }
                            if (modal.needdispatchpay) {
                                var wechat = result.wechat;
                                if (wechat.weixin) {
                                    WeixinJSBridge.invoke('getBrandWCPayRequest', {
                                        'appId': wechat.appid ? wechat.appid : wechat.appId,
                                        'timeStamp': wechat.timeStamp,
                                        'nonceStr': wechat.nonceStr,
                                        'package': wechat.package,
                                        'signType': wechat.signType,
                                        'paySign': wechat.paySign,
                                    }, function (res) {
                                        if (res.err_msg == 'get_brand_wcpay_request:ok') {
                                            modal.payResult();
                                        } else if (res.err_msg == 'get_brand_wcpay_request:cancel') {
                                            FoxUI.toast.show('取消支付')
                                        } else {
                                            core.json('creditshop/log/paydispatch', {
                                                id: modal.log.id,
                                                addressid: modal.addressid,
                                                jie:1
                                            },function (wechat_jie) {
                                                modal.payWechatJie(wechat_jie.result.wechat);
                                            },false,true);
                                        }
                                    })
                                }

                                if (wechat.weixin_jie || wechat.jie==1) {
                                    modal.payWechatJie(wechat);
                                }

                            } else {
                                modal.payResult()
                            }
                        }, true, true)
                    }, 1000)
                }
            }, {
                text: '取消', extraClass: 'btn-default', onclick: function () {
                    modal.paying = false;
                    clearInterval(modal.settime);
                }
            }]
        })
    };

    modal.payWechatJie = function (wechat) {
        var img = core.getUrl('index/qr',{url:wechat.code_url});
        $('#qrmoney').text(modal.goods.dispatch);
        $('.fui-header').hide();
        $('#btnWeixinJieCancel').unbind('click').click(function(){
            clearInterval(modal.settime);
            $('.order-weixinpay-hidden').hide();
            $('.fui-header').show();
        });
        $('.order-weixinpay-hidden').show();
        modal.settime = setInterval(function () {
            modal.payResult();
        },2000);
        $('.verify-pop').find('.close').unbind('click').click(function () {
            $('.order-weixinpay-hidden').hide();
            $('.fui-header').show();
            clearInterval(modal.settime);
        });
        $('.verify-pop').find('.qrimg').attr('src', img).show()
    };

    modal.payResult = function () {
        var tiptext = modal.needdispatchpay ? '运费支付成功!' : '兑换成功!';
        core.json('creditshop/log/payresult', {id: modal.log.id}, function (json) {
            var result = json.result;
            if (json.status != 1) {
                if (modal.settime==0){
                    FoxUI.toast.show(result.message);
                }
                return
            }
            $(".fui-message-popup .btn-default").trigger('click');
            clearInterval(modal.settime);
            FoxUI.message.show({
                icon: 'icon icon-success',
                content: tiptext,
                buttons: [{
                    text: '确定', extraClass: 'btn-danger', onclick: function () {
                        location.reload()
                    }
                }]
            })
        }, false, true)
    };
    modal.setStore = function () {
        var mobile = $.trim($("#carrier_mobile").val());
        var realname = $.trim($("#carrier_realname").val());
        if (!modal.storeid) {
            FoxUI.toast.show("请选择兑换门店!");
            return
        }
        if (mobile == '') {
            FoxUI.toast.show("请填写真实姓名!");
            return
        }
        if (realname == '') {
            FoxUI.toast.show("请填写联系电话!");
            return
        }
        FoxUI.message.show({
            icon: 'icon icon-information',
            content: "确认选择此门店进行兑换吗",
            buttons: [{
                text: '确定', extraClass: 'btn-danger', onclick: function () {
                    setTimeout(function () {
                        core.json('creditshop/log/setstore', {
                            id: modal.log.id,
                            storeid: modal.storeid,
                            realname: realname,
                            mobile: mobile
                        }, function (json) {
                            if (json.status == 1) {
                                FoxUI.message.show({
                                    icon: 'icon icon-success',
                                    content: '操作成功，请到您选择的门店进行兑换！',
                                    buttons: [{
                                        text: '确定', extraClass: 'btn-danger', onclick: function () {
                                            location.reload()
                                        }
                                    }]
                                })
                            } else {
                                FoxUI.message.show({
                                    icon: 'icon icon-wrong',
                                    content: '兑换失败，请重试！',
                                    buttons: [{
                                        text: '确定', extraClass: 'btn-danger', onclick: function () {
                                            location.reload()
                                        }
                                    }]
                                })
                            }
                        }, true.true)
                    }, 1000)
                }
            }, {
                text: '取消', extraClass: 'btn-default', onclick: function () {
                }
            }]
        })
    };
    modal.ExchangeHandler = {
        verifytimer: 0, verify: function (logid) {
            core.json('creditshop/exchange/qrcode', {id: logid}, function (json) {
                if (json.status == 0) {
                    FoxUI.toast.show(json.result.message);
                    return
                }
                $('.verify-pop').find('img').attr('src', json.result.qrcode);
                $('#eno').html(json.result.eno);
                FoxUI.mask.show();
                $('.verify-pop').show();
                modal.ExchangeHandler.verifytimer = setInterval(function () {
                    modal.ExchangeHandler.check(logid)
                }, 1000)
            }, true, true)
        }, check: function (logid) {
            core.json('creditshop/exchange/check', {id: logid}, function (json) {
                if (json.status == 0) {
                    return
                }
                clearInterval(modal.ExchangeHandler.verifytimer);
                FoxUI.mask.hide();
                $('.verify-pop').hide();
                FoxUI.message.show({
                    icon: 'icon icon-success',
                    content: '兑换成功!',
                    buttons: [{
                        text: '确定', extraClass: 'btn-danger', onclick: function () {
                            location.href = core.getUrl('creditshop/log')
                        }
                    }]
                })
            }, false, true)
        }, close: function () {
            clearInterval(this.verifytimer);
            FoxUI.mask.hide();
            $('.exchange_qrcode').show();
            $('.exchange_eno').hide();
            $('.verify-pop').hide()
        }
    };
    return modal
});