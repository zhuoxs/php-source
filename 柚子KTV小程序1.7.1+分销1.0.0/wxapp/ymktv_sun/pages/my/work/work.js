var app = getApp();

Page({
    data: {},
    onLoad: function(t) {
        var e = this;
        wx.getUserInfo({
            success: function(t) {
                e.setData({
                    userInfo: t.userInfo
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/todayallorder",
            cachetime: "0",
            success: function(t) {
                e.setData({
                    orderData: t.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/financeallData",
            cachetime: "0",
            success: function(t) {
                e.setData({
                    Finance: t.data
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    goSet: function() {
        wx.redirectTo({
            url: "../set/set"
        });
    },
    goOrdery: function() {
        wx.redirectTo({
            url: "../order/order"
        });
    }
});