var t = getApp(), e = t.requirejs("core"), a = (t.requirejs("icons"), t.requirejs("foxui"));

t.requirejs("wxParse/wxParse"), t.requirejs("jquery");

Page({
    data: {
        paymentmodal: !1,
        showmodal: !1,
        successmodal: !1,
        member: [],
        goods: [],
        options: [],
        carrierInfo: [],
        stores: [],
        is_openmerch: !1,
        isverify: !1,
        iswechat: !0,
        iscredit: !0,
        paytype: "",
        togglestore: "",
        addressid: 0,
        dispatchprice: 0,
        allprice: 0,
        logid: 0,
        successmessage: "",
        successstatus: !1
    },
    onLoad: function(t) {
        var e = this;
        t = t || {}, wx.getSystemInfo({
            success: function(t) {
                e.setData({
                    windowWidth: t.windowWidth,
                    windowHeight: t.windowHeight
                });
            }
        }), e.setData({
            options: t
        });
    },
    onShow: function() {
        var e = this, a = t.getCache("isIpx"), s = t.getCache("orderAddress"), o = t.getCache("orderShop");
        o && e.setData({
            carrierInfo: o
        });
        e.data.addressid;
        s.id > 0 && (e.addressid = s.id, e.setData({
            addressid: s.id
        }), e.getDetail()), a ? e.setData({
            isIpx: !0,
            iphonexnavbar: "fui-iphonex-navbar"
        }) : e.setData({
            isIpx: !1,
            iphonexnavbar: ""
        }), "" == e.data.member && e.getDetail(), wx.getSetting({
            success: function(t) {
                var a = t.authSetting["scope.userInfo"];
                e.setData({
                    limits: a
                });
            }
        });
    },
    listChange: function(t) {
        var e = this.data.member;
        switch (t.target.id) {
          case "realname":
            e.realname = t.detail.value;
            break;

          case "mobile":
            e.mobile = t.detail.value;
        }
        this.setData({
            member: e
        });
    },
    getDetail: function() {
        var t = this, a = t.data.options;
        e.get("creditshop/create", a, function(a) {
            if (0 == a.error) {
                a.goods.num = 1, t.setData({
                    goods: a.goods,
                    address: a.address,
                    shop: a.shop,
                    stores: a.stores,
                    isverify: a.goods.isverify,
                    member: a.member,
                    addressid: a.address.id
                });
                0 == a.goods.isverify && 0 == a.goods.type && a.address.id > 0 ? (e.get("creditshop/create/getaddress", {
                    addressid: t.addressid
                }, function(e) {
                    0 == e.error && t.setData({
                        address: e.address
                    });
                }), t.dispatch()) : t.setData({
                    allprice: a.goods.money
                });
            }
        });
    },
    dispatch: function() {
        var t = this;
        e.get("creditshop/create/dispatch", {
            goodsid: t.data.goods.id,
            optionid: t.data.options.optionid
        }, function(e) {
            var a = e.dispatch;
            a = parseFloat(a) + parseFloat(t.data.goods.money), t.setData({
                dispatchprice: e.dispatch,
                allprice: a
            });
        });
    },
    number: function(t) {
        var s = this, o = s.data.goods, i = s.data.options, d = t.target.dataset.action;
        "minus" == d ? o.num = parseInt(o.num) - 1 : "plus" == d && (o.num = parseInt(o.num) + 1), 
        o.num < 1 && (o.num = 1);
        var r = o.num;
        e.get("creditshop/create/number", {
            goodsid: o.id,
            optionid: i.id,
            num: r
        }, function(t) {
            if (0 == t.goods.canbuy) return o.num > 1 && (o.num = parseInt(o.num) - 1), s.setData({
                goods: o
            }), void a.toast(s, t.goods.buymsg);
            (o = t.goods).num = r;
            var e = parseFloat(o.money * r) + parseFloat(o.dispatch);
            s.setData({
                goods: o,
                allprice: e
            });
        });
    },
    pay: function() {
        var t = this, e = t.data.goods;
        if (e.canbuy) {
            if (e.isverify > 0) {
                var s = t.data.member;
                if ("" == s.realname) return void a.toast(t, "请填写真实姓名");
                if ("" == s.mobile) return void a.toast(t, "请填写联系电话");
                if (0 == t.data.carrierInfo.length) return void a.toast(t, "请选择兑换门店");
            }
            if (0 == e.isverify && 0 == e.goodstype && 0 == e.type) {
                var o = t.data.addressid;
                if (0 == o || void 0 == o) return void a.toast(t, "请选择收货地址");
            }
            1 == e.type && t.setData({
                addressid: 0
            }), t.setData({
                paymentmodal: !0
            });
        } else a.toast(t, t.data.goods.buymsg);
    },
    cancel: function() {
        this.setData({
            paymentmodal: !1,
            showmodal: !1
        });
    },
    payClick: function(t) {
        var e = this, a = t.target.dataset.type;
        e.setData({
            paymentmodal: !1,
            showmodal: !0,
            paytype: a
        });
    },
    confirm: function() {
        var t = this, s = t.data.paytype;
        e.get("creditshop/detail/pay", {
            id: t.data.goods.id,
            optionid: t.data.optionid,
            num: t.data.goods.num,
            paytype: t.data.paytype,
            addressid: t.data.addressid,
            storeid: t.data.carrierInfo.id
        }, function(o) {
            o.error > 0 ? a.toast(t, o.message) : (t.setData({
                logid: o.logid
            }), o.wechat && o.wechat.success && e.pay(o.wechat.payinfo, function(e) {
                "requestPayment:ok" == e.errMsg && t.lottery();
            }), "credit" == s && o.logid > 0 && t.lottery());
        });
    },
    success: function() {
        var t = this.data.logid;
        wx.redirectTo({
            url: "/pages/creditshop/log/detail/index?id=" + t
        });
    },
    lottery: function() {
        var t = this, s = "";
        0 == t.data.goods.type ? e.get("creditshop/detail/lottery", {
            id: t.data.goods.id,
            logid: t.data.logid
        }, function(e) {
            e.error > 0 ? a.toast(t, e.message) : (2 == e.status && (s = "恭喜您，商品兑换成功"), 3 == e.status && (1 == e.goodstype ? s = "恭喜您，优惠券兑换成功" : 2 == e.goodstype ? s = "恭喜您，余额兑换成功" : 3 == e.goodstype && (s = "恭喜您，红包兑换成功")), 
            t.setData({
                successmessage: s,
                successstatus: !0
            }));
        }) : (s = "努力抽奖中，请稍后....", t.setData({
            successmessage: s,
            successstatus: !0
        }), setTimeout(function() {
            e.get("creditshop/detail/lottery", {
                id: t.data.goods.id,
                logid: t.data.logid
            }, function(e) {
                e.error > 0 ? a.toast(t, e.message) : (2 == e.status ? s = "恭喜您，您中奖啦" : 3 == e.status ? 1 == e.goodstype ? s = "恭喜您，优惠券已经发到您账户啦" : 2 == e.goodstype ? s = "恭喜您，余额已经发到您账户啦" : 3 == e.goodstype && (s = "恭喜您，红包兑换成功") : s = "很遗憾，您没有中奖", 
                t.setData({
                    successmessage: s,
                    successstatus: !0
                }));
            });
        }, 1e3)), t.setData({
            successmodal: !0
        });
    },
    toggle: function(t) {
        var e = this;
        "" == e.data.togglestore ? e.setData({
            togglestore: "toggleSend-group"
        }) : e.setData({
            togglestore: ""
        });
    }
});