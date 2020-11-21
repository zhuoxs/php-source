var t = require("../../../../utils/base.js"), e = require("../../../../../api.js"), a = new t.Base();

Page({
    data: {
        isSelect: 0
    },
    onLoad: function(t) {
        this.getUserCoupon();
    },
    changtab: function(t) {
        var e = t.currentTarget.dataset.cur;
        this.setData({
            isSelect: e
        });
    },
    swiperChange: function(t) {
        this.setData({
            isSelect: t.detail.current
        });
    },
    goCoupon: function(t) {
        var e = t.currentTarget.dataset.id;
        wx.navigateTo({
            url: "../coupon_card/coupon_card?couponId=" + e + "&type=2"
        });
    },
    getUserCoupon: function() {
        var t = this, o = {
            url: e.default.user_coupon,
            method: "GET"
        };
        a.getData(o, function(e) {
            console.log(e), 1 == e.errorCode && t.setData({
                userCoupon: e.data
            });
        });
    }
});