var app = getApp();

Page({
    data: {
        list: [],
        finance: [],
        isIpx: app.globalData.isIpx
    },
    onLoad: function(t) {
        var e = this;
        app.get_setting().then(function(o) {
            app.get_user_info().then(function(t) {
                e.setData({
                    setting: o,
                    user: t
                });
            });
        });
        var o = wx.getStorageSync("setting");
        o ? wx.setNavigationBarColor({
            frontColor: o.fontcolor,
            backgroundColor: o.color
        }) : app.get_setting(!0).then(function(t) {
            wx.setNavigationBarColor({
                frontColor: t.fontcolor,
                backgroundColor: t.color
            });
        });
    },
    onReady: function() {},
    onShow: function() {
        var o = this;
        app.util.request({
            url: "entry/wxapp/gettongji",
            cachetime: "0",
            success: function(t) {
                console.log(t.data), o.setData({
                    data: t.data
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    toMessage: function(t) {
        wx.redirectTo({
            url: "../message/message"
        });
    },
    toSet: function(t) {
        wx.redirectTo({
            url: "../set/set"
        });
    },
    toManager: function(t) {
        wx.navigateTo({
            url: "../manager/manager"
        });
    },
    scanCode: function(t) {
        app.get_openid().then(function(e) {
            wx.scanCode({
                success: function(t) {
                    var o = t.result;
                    app.util.request({
                        url: "entry/wxapp/setCheckCoupon",
                        cachetime: "0",
                        data: {
                            openid: e,
                            result: o
                        },
                        success: function(t) {
                            if (1 == t.data.errcode) {
                                var o = "/yzqzk_sun/pages/backstage/coupon/coupon?id=" + t.data.user_coupon_id;
                                wx.navigateTo({
                                    url: o
                                });
                            } else if (2 == t.data.errcode) {
                                o = "/yzqzk_sun/pages/backstage/writeoff/writeoff?orderid=" + t.data.orderid + "&uid=" + t.data.uid;
                                wx.navigateTo({
                                    url: o
                                });
                            }
                        }
                    });
                }
            });
        });
    }
});