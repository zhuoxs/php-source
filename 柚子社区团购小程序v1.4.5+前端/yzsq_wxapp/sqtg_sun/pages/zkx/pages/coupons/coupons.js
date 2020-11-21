var app = getApp();

Page({
    data: {},
    onLoad: function(a) {
        var e = this, t = wx.getStorageSync("userInfo");
        t ? e.setData({
            show: !0,
            user_id: t.id
        }) : wx.showModal({
            title: "提示",
            content: "您未登陆，请先登陆！",
            success: function(a) {
                if (a.confirm) {
                    var e = encodeURIComponent("/sqtg_sun/pages/home/my/my?id=123");
                    app.reTo("/sqtg_sun/pages/home/login/login?id=" + e);
                } else a.cancel && app.lunchTo("/sqtg_sun/pages/home/index/index");
            }
        });
        var s = wx.getStorageSync("linkaddress");
        s ? (e.setData({
            linkaddress: s
        }), e.loadData()) : app.reTo("/sqtg_sun/pages/zkx/pages/nearleaders/nearleaders");
    },
    loadData: function() {
        var e = this;
        app.ajax({
            url: "Ccoupon|getAvailableCoupons",
            data: {
                user_id: e.data.user_id || 0,
                page: 1,
                limit: 6
            },
            success: function(a) {
                e.setData({
                    show: !0,
                    coupons: a.data
                });
            }
        }), app.api.getCartCount({
            user_id: e.data.user_id,
            leader_id: e.data.linkaddress.id
        }).then(function(a) {
            e.setData({
                cartCount: a
            });
        });
    },
    receivecoupon: function(a) {
        for (var e = this, t = e.data.coupons, s = [], n = 0; n < t.length; n++) s.push(t[n].id);
        a.currentTarget.dataset.index;
        app.ajax({
            url: "Ccoupon|receiveCoupon",
            data: {
                user_id: e.data.user_id,
                coupon_ids: s.join(",")
            },
            success: function(a) {
                0 == a.code && (app.tips("领取优惠券成功！"), setTimeout(function() {
                    wx.navigateBack({});
                }, 1500));
            },
            fail: function(a) {
                app.tips(a.data.msg), setTimeout(function() {
                    e.setData({
                        flag: !1
                    });
                }, 1e3);
            }
        });
    }
});