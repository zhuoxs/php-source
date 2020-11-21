var app = getApp();

Page({
    data: {
        isIpx: app.globalData.isIpx
    },
    onLoad: function(t) {
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
        var o = t.id, n = wx.getStorageSync("url"), a = (wx.getStorageSync("openid"), wx.getStorageSync("settings"));
        this.setData({
            url: n,
            settings: a,
            id: o
        }), this.getcoupondetail(o);
    },
    getcoupondetail: function(t) {
        var o = this;
        app.util.request({
            url: "entry/wxapp/getCouponDetail",
            cachetime: "0",
            data: {
                id: t
            },
            success: function(t) {
                o.setData({
                    coupondetail: t.data.data
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    toConfirm: function(t) {
        var o = this, n = t.currentTarget.dataset.id;
        app.util.request({
            url: "entry/wxapp/checkUserCoupon",
            cachetime: "0",
            data: {
                id: n,
                uid: wx.getStorageSync("openid")
            },
            success: function(t) {
                0 == t.data.errcode && wx.showModal({
                    title: "提示",
                    content: t.data.errmsg,
                    showCancel: !1,
                    success: function(t) {
                        o.getcoupondetail(n);
                    }
                });
            }
        });
    },
    toOrderlist: function(t) {
        wx.navigateBack({});
    }
});