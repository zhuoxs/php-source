var app = getApp();

Page({
    data: {
        hideRuzhu: !0,
        balance_sj: ""
    },
    onLoad: function(e) {
        console.log(e);
        var t = this, o = (e.userid, wx.getStorageSync("url"));
        t.setData({
            url: o
        });
        var a = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/User_id",
            data: {
                openid: a
            },
            success: function(e) {
                console.log("查看用户id"), console.log(e), wx.setStorageSync("user_id", e.data.id);
            }
        }), setTimeout(function() {
            var e = wx.getStorageSync("user_id");
            app.util.request({
                url: "entry/wxapp/Data_sj",
                data: {
                    user_id: e
                },
                success: function(e) {
                    console.log("查看商家数据"), console.log(e), t.setData({
                        balance_sj: e.data.balance
                    });
                }
            });
        }, 500);
    },
    checkOrderNum: function(e) {
        console.log(e.detail.value), this.setData({
            orderNum: e.detail.value
        });
    },
    withDrawalTap: function(e) {
        console.log(e), wx.navigateTo({
            url: "../withDrawal/withDrawal?balance_sj=" + e.currentTarget.dataset.balance_sj
        });
    },
    deterBtn: function(e) {
        var t = this, o = t.data.orderNum, a = wx.getStorageSync("user_id"), n = wx.getStorageSync("url");
        console.log(a), app.util.request({
            url: "entry/wxapp/WriteOrder",
            data: {
                orderNum: o,
                user_id: a
            },
            success: function(e) {
                console.log(e), t.setData({
                    info: e.data,
                    hideRuzhu: !1,
                    url: n
                });
            }
        });
    },
    applyFor: function(e) {
        console.log(e.currentTarget.dataset.id);
        var t = e.currentTarget.dataset.id;
        app.util.request({
            url: "entry/wxapp/DoWriteOrder",
            cachetime: "30",
            data: {
                id: t
            },
            success: function(e) {
                console.log(e), 1 == e.data && wx.showToast({
                    title: "核销成功！"
                });
            }
        }), this.setData({
            hideRuzhu: !0,
            orderNum: ""
        }), this.onShow();
    },
    saomaCode: function(e) {
        wx.scanCode({
            success: function(e) {
                console.log(e);
            }
        });
    },
    settingTap: function(e) {
        wx.navigateTo({
            url: "../audio/audio"
        });
    },
    backIndex: function() {
        wx.redirectTo({
            url: "../index/index"
        });
    },
    onReady: function() {},
    onShow: function() {
        this.getUserInfo();
    },
    getUserInfo: function() {
        var t = this;
        wx.login({
            success: function() {
                wx.getUserInfo({
                    success: function(e) {
                        console.log(e), t.setData({
                            userInfo: e.userInfo
                        });
                    }
                });
            }
        });
    },
    closePopupTap: function(e) {
        this.setData({
            hideRuzhu: !0
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});