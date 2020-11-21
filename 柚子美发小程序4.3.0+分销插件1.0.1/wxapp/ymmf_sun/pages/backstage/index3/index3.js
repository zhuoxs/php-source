var app = getApp();

Page({
    data: {
        list: [ {
            title: "今日总访客数",
            detail: "0"
        }, {
            title: "今日总成交额",
            detail: "0"
        }, {
            title: "今日订单数",
            detail: "0"
        }, {
            title: "待接单",
            detail: "0"
        }, {
            title: "代配送",
            detail: "0"
        }, {
            title: "退款订单",
            detail: "0"
        } ],
        finance: [ {
            title: "今日收益",
            detail: "0"
        }, {
            title: "昨日收益",
            detail: "0"
        }, {
            title: "总计收益",
            detail: "0"
        } ],
        uid: 0
    },
    onLoad: function(t) {
        var a = this;
        if (t.b_id) var e = t.b_id; else e = wx.getStorageSync("branch_id");
        var n = wx.getStorageSync("users");
        if (n) {
            var i = n.id;
            this.setData({
                uid: i
            });
        }
        wx.setStorageSync("branch_id", e), wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), wx.getUserInfo({
            success: function(t) {
                a.setData({
                    thumb: t.userInfo.avatarUrl,
                    nickname: t.userInfo.nickName
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        var a = this, t = wx.getStorageSync("branch_id");
        app.util.request({
            url: "entry/wxapp/NowBuildname",
            cachetime: "0",
            data: {
                branch_id: t
            },
            success: function(t) {
                a.setData({
                    branch_data: t.data,
                    pt_name: t.data.name
                });
            }
        }), app.util.request({
            url: "entry/wxapp/Buildtodayfangke",
            cachetime: "0",
            data: {
                branch_id: t
            },
            success: function(t) {
                console.log(t.data), a.setData({
                    oldData: t.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/BuildFinanceData",
            cachetime: "0",
            data: {
                branch_id: t
            },
            success: function(t) {
                console.log(t.data), a.setData({
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
    gotocash: function() {
        wx.navigateTo({
            url: "../cash/cash"
        });
    },
    toMessage: function(t) {
        wx.redirectTo({
            url: "../order/order"
        });
    },
    toSet: function(t) {
        wx.redirectTo({
            url: "../set2/set2"
        });
    },
    scanCode: function(t) {
        wx.scanCode({
            success: function(t) {
                var a = t.result;
                wx.navigateTo({
                    url: a
                });
            }
        });
    }
});