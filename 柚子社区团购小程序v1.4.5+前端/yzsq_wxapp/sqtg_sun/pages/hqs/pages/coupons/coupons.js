var app = getApp();

Page({
    data: {
        show: !1,
        padding: !1,
        page: 1,
        limit: 5,
        coupon: [],
        isLogin: !0
    },
    onLoad: function() {
        wx.getStorageSync("userInfo") || wx.redirectTo({
            url: "/sqtg_sun/pages/home/login/login?id=/sqtg_sun/pages/hqs/pages/coupons/coupons"
        }), this.loadData();
    },
    loadData: function() {
        var n = this, s = wx.getStorageSync("userInfo") || {}, e = n.data.coupon, i = n.data.page;
        app.ajax({
            url: "Ccoupon|getCoupon",
            data: {
                user_id: s.id || "",
                page: i,
                limit: n.data.limit
            },
            success: function(a) {
                var t = a.data.length == n.data.limit;
                if (1 == i) e = a.data; else for (var o in a.data) e.push(a.data[o]);
                i += 1, n.setData({
                    coupon: e,
                    isLogin: null != s.id,
                    user_id: s.id || "",
                    page: i,
                    hasMore: t,
                    show: !0
                });
            }
        });
    },
    onReachBottom: function() {
        this.data.hasMore ? this.loadData() : wx.showToast({
            title: "没有更多优惠券啦~",
            icon: "none"
        });
    },
    onShareAppMessage: function() {},
    getCoupon: function(a) {
        var t = this, o = t.data.isLogin, n = a.currentTarget.dataset.id, s = a.currentTarget.dataset.index, e = a.currentTarget.dataset.status, i = t.data.coupon;
        o ? 0 == e ? app.ajax({
            url: "Ccoupon|receiveCoupon",
            data: {
                user_id: t.data.user_id,
                coupon_id: n
            },
            success: function(a) {
                wx.showToast({
                    title: "领取成功",
                    icon: "none"
                }), i[s].status = 2, t.setData({
                    coupon: i
                });
            }
        }) : 1 == e ? wx.showToast({
            title: "该优惠券已领完",
            icon: "none"
        }) : wx.showToast({
            title: "您已领取该优惠券",
            icon: "none"
        }) : wx.showModal({
            title: "提示",
            content: "您尚未登陆小程序",
            confirmText: "去登陆",
            success: function(a) {
                a.confirm && app.lunchTo("/sqtg_sun/pages/home/login/login?url=/sqtg_sun/pages/hqs/pages/coupons/coupons");
            }
        });
    },
    getPadding: function(a) {
        this.setData({
            padding: a.detail
        });
    }
});