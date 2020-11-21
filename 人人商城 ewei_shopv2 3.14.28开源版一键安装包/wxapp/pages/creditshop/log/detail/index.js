function e(e, t, o) {
    return t in e ? Object.defineProperty(e, t, {
        value: o,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : e[t] = o, e;
}

var t = getApp(), o = t.requirejs("core"), s = (t.requirejs("icons"), t.requirejs("foxui"));

t.requirejs("wxParse/wxParse"), t.requirejs("jquery");

Page({
    data: {
        options: [],
        log: [],
        logid: 0,
        store: [],
        stores: [],
        goods: [],
        verifynum: 0,
        replyset: [],
        ordercredit: 0,
        ordermoney: 0,
        address: [],
        carrier: [],
        shop: [],
        allmoney: [],
        togglestore: "",
        togglecode: "",
        verify: [],
        iswechat: !0,
        paymentmodal: !1
    },
    onLoad: function(e) {
        var t = this;
        e = e || {}, wx.getSystemInfo({
            success: function(e) {
                t.setData({
                    windowWidth: e.windowWidth,
                    windowHeight: e.windowHeight
                });
            }
        }), t.setData({
            options: e,
            logid: e.id
        });
    },
    onReady: function() {},
    onShow: function() {
        var e = this;
        t.getCache("isIpx") ? e.setData({
            isIpx: !0,
            iphonexnavbar: "fui-iphonex-navbar"
        }) : e.setData({
            isIpx: !1,
            iphonexnavbar: ""
        }), e.getDetail(), wx.getSetting({
            success: function(t) {
                var o = t.authSetting["scope.userInfo"];
                e.setData({
                    limits: o
                });
            }
        });
    },
    getDetail: function() {
        var t = this, s = t.data.options;
        o.get("creditshop/log/detail", s, function(a) {
            if (0 == a.error) {
                var i, r = parseFloat(a.ordermoney) + parseFloat(a.log.dispatch);
                t.setData((i = {
                    log: a.log,
                    store: a.store,
                    stores: a.stores,
                    goods: a.goods,
                    verifynum: a.verifynum
                }, e(i, "log", a.log), e(i, "replyset", a.set), e(i, "ordercredit", a.ordercredit), 
                e(i, "ordermoney", a.ordermoney), e(i, "address", a.address), e(i, "carrier", a.carrier), 
                e(i, "shop", a.shop), e(i, "allmoney", r), e(i, "verify", a.verify), i));
                var n = 0;
                0 == a.goods.isverify && a.address.lenght > 0 && o.get("creditshop/dispatch", {
                    goodsid: a.goods.id,
                    optionid: s.id
                }, function(e) {
                    n = e.dispatch, t.setData({
                        dispatchprice: n
                    });
                }), n = parseFloat(n) + parseFloat(a.goods.money), t.setData({
                    allprice: n
                });
            }
        });
    },
    toggle: function(e) {
        var t = this;
        "" == t.data.togglestore ? t.setData({
            togglestore: "toggleSend-group"
        }) : t.setData({
            togglestore: ""
        });
    },
    togglecode: function(e) {
        var t = this, o = t.data.togglecode;
        "" == o ? t.setData({
            togglecode: "toggleSend-group"
        }) : t.setData({
            togglecode: ""
        });
    },
    finish: function() {
        var e = this;
        wx.showModal({
            title: "提示",
            content: "确认已收到货了吗？",
            success: function(t) {
                if (t.confirm) {
                    var a = e.data.log.id;
                    o.get("creditshop/log/finish", {
                        id: a
                    }, function(t) {
                        0 == t.error ? (s.toast(e, "确认收货"), e.onShow()) : s.toast(e, t.message);
                    });
                }
            }
        });
    },
    paydispatch: function(e) {
        var t = this, s = "";
        s = "dispatch" == e.currentTarget.dataset.paytype ? "确认兑换并支付运费吗" : "确认兑换吗", wx.showModal({
            title: "提示",
            content: s,
            success: function(e) {
                if (e.confirm) {
                    var s = t.data.log.id, a = t.data.goods.dispatch;
                    o.get("creditshop/log/paydispatch", {
                        id: s,
                        addressid: t.data.address.id,
                        dispatchprice: a
                    }, function(e) {
                        e.error > 0 ? fui.toast(t, e.message) : e.wechat && e.wechat.success && o.pay(e.wechat.payinfo, function(e) {
                            "requestPayment:ok" == e.errMsg && t.payResult();
                        });
                    });
                }
            }
        });
    },
    payResult: function() {
        var e = this;
        o.get("creditshop/log/paydispatchresult", {
            id: e.data.log.id
        }, function(t) {
            t.error > 0 ? fui.toast(e, t.message) : e.onShow();
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});