var app = getApp();

Page({
    data: {
        user_info: [],
        distribution_set: []
    },
    onLoad: function(t) {
        var o = this, n = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/IsPromoter",
            data: {
                openid: n,
                m: app.globalData.Plugin_distribution
            },
            showLoading: !1,
            success: function(t) {
                if (console.log(t), t && 9 != t.data) {
                    var n = t.data;
                    o.setData({
                        user_info: n
                    });
                }
            }
        }), app.util.request({
            url: "entry/wxapp/Plugin",
            data: {
                type: 1
            },
            showLoading: !1,
            success: function(t) {
                var n = t.data;
                2 != n && o.setData({
                    distribution_set: n
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
    showusernotice: function() {
        var t = this.data.distribution_set;
        wx.showModal({
            title: "用户须知",
            content: t.withdrawnotice,
            showCancel: !1,
            confirmText: "我已阅读",
            confirmColor: "#ff4544",
            success: function(t) {
                t.confirm && console.log("用户点击确定");
            }
        });
    },
    toFxWd: function(t) {
        wx.navigateTo({
            url: "/wnjz_sun/plugin/distribution/fxWithdraw/fxWithdraw"
        });
    },
    toFxDetail: function(t) {
        wx.navigateTo({
            url: "/wnjz_sun/plugin/distribution/fxDetail/fxDetail"
        });
    }
});