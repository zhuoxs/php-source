var a = require("../../../../utils/base.js"), t = require("../../../../../api.js"), e = new a.Base();

Page({
    data: {
        loadmore: !0,
        loadnot: !1
    },
    onLoad: function(a) {
        this.couponGoods(a.couponId);
        var t = wx.getStorageSync("userData");
        t.user_info ? this.setData({
            is_vip: t.user_info.is_vip
        }) : this.getUserData();
    },
    couponGoods: function(a) {
        var o = this, r = {
            url: t.default.coupon_product,
            data: {
                couponId: a
            },
            method: "GET"
        };
        e.getData(r, function(a) {
            if (1 == a.errorCode) {
                if (a.data.length > 0) for (var t in a.data) a.data[t].price = parseFloat(a.data[t].price), 
                a.data[t].o_price = parseFloat(a.data[t].o_price), a.data[t].vip_price = parseFloat(a.data[t].vip_price);
                o.setData({
                    couponGoods: a.data
                });
            }
        });
    },
    getUserData: function() {
        var a = this, o = {
            url: t.default.user
        };
        e.getData(o, function(t) {
            var e = 0;
            1 == t.errorCode && (wx.setStorageSync("userData", t), e = t.user_info.is_vip), 
            a.setData({
                userData: t,
                is_vip: e
            });
        });
    }
});