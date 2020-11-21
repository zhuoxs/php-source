var o = require("../../../../utils/base.js"), n = require("../../../../../api.js"), t = new o.Base(), e = getApp();

Page({
    data: {
        linged: !1
    },
    onLoad: function(o) {
        e.pageOnLoad();
    },
    onReady: function() {},
    onShow: function() {
        this.getCoupon();
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    getCoupon: function(o) {
        var e = this, a = {
            url: n.default.getCoupon,
            method: "GET"
        };
        t.getData(a, function(o) {
            1 == o.errorCode && e.setData({
                couponList: o.data
            }), console.log(o);
        });
    },
    goCoupon: function(o) {
        var n = o.currentTarget.dataset.id;
        wx.navigateTo({
            url: "../coupon_card/coupon_card?couponId=" + n + "&type=1"
        });
    },
    lingCoupon: function(o) {
        var e = this;
        console.log(o);
        var a = {
            url: n.default.ling_coupon,
            data: {
                couponId: o.currentTarget.dataset.id
            }
        };
        t.getData(a, function(o) {
            1 == o.errorCode && (e.getCoupon(), e.setData({
                linged: !0
            })), wx.showToast({
                title: o.msg,
                icon: "none"
            });
        });
    },
    navigatorLink: function(o) {
        console.log(o), e.navClick(o, this);
    }
});