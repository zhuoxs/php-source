var t = require("../../../../utils/base.js"), a = require("../../../../../api.js"), o = new t.Base(), e = getApp();

Page({
    data: {},
    onLoad: function(t) {
        e.pageOnLoad(), this.setData({
            couponId: t.couponId,
            cType: t.type
        }), this.couponDetail(t.couponId, t.type);
    },
    couponDetail: function(t, e) {
        var n = this;
        if ("1" == e) {
            u = {
                url: a.default.coupon_detail,
                data: {
                    couponId: t
                },
                method: "GET"
            };
            o.getData(u, function(t) {
                1 == t.errorCode && n.setData({
                    coupon: t.data
                });
            });
        } else {
            var u = {
                url: a.default.user_detail,
                data: {
                    id: t
                },
                method: "GET"
            };
            o.getData(u, function(t) {
                1 == t.errorCode && n.setData({
                    userCoupon: t.data,
                    coupon: t.data.coupon
                });
            });
        }
    },
    lingCoupon: function(t) {
        var e = this, n = {
            url: a.default.ling_coupon,
            data: {
                couponId: t.currentTarget.dataset.id
            }
        };
        o.getData(n, function(t) {
            1 == t.errorCode && e.couponDetail(e.data.couponId, e.data.cType), wx.showToast({
                title: t.msg,
                icon: "none"
            });
        });
    }
});