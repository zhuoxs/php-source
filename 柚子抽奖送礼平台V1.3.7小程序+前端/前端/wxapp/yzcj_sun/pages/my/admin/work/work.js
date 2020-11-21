var app = getApp(), Page = require("../../../../../zhy/sdk/qitui/oddpush.js").oddPush(Page).Page;

Page({
    data: {},
    onLoad: function(e) {
        var t = this, a = e.sid;
        wx.setStorageSync("sid", a), wx.getUserInfo({
            success: function(e) {
                t.setData({
                    userInfo: e.userInfo
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        var t = this, e = wx.getStorageSync("sid");
        app.util.request({
            url: "entry/wxapp/AdminIndex",
            data: {
                sid: e
            },
            success: function(e) {
                t.setData({
                    completeorder: e.data.completeorder,
                    completeorder1: e.data.completeorder1,
                    noshelves: e.data.noshelves,
                    shelves: e.data.shelves,
                    waitorder: e.data.waitorder,
                    yiorder: e.data.yiorder,
                    waitorder1: e.data.waitorder1,
                    yiorder1: e.data.yiorder1,
                    sponsor: e.data.sponsor
                });
            }
        }), t.getUrl();
    },
    getUrl: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/url",
            cachetime: "0",
            success: function(e) {
                wx.setStorageSync("url", e.data), t.setData({
                    url: e.data
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    goSell: function(e) {
        var t = e.currentTarget.dataset.index;
        wx.navigateTo({
            url: "../sell/sell?nav=" + t
        });
    },
    goLower: function() {
        wx.navigateTo({
            url: "../lower/lower"
        });
    },
    goOrdery: function(e) {
        var t = e.currentTarget.dataset.index;
        wx.navigateTo({
            url: "../order/order?nav=" + t
        });
    },
    goOrdery1: function(e) {
        var t = e.currentTarget.dataset.index;
        wx.navigateTo({
            url: "../orderthree/orderthree?nav=" + t
        });
    },
    goSignout: function() {
        wx.reLaunch({
            url: "../../../ticket/ticketmy/ticketmy"
        });
    },
    codes: function() {
        var e = this;
        wx.scanCode({
            success: function(t) {
                console.log(t), app.util.request({
                    url: "entry/wxapp/sureScan",
                    data: {
                        ordernum: t.result,
                        sid: e.data.sponsor.sid
                    },
                    success: function(e) {
                        1 == e.data ? wx.navigateTo({
                            url: "../scan/scan?ordernum=" + t.result
                        }) : 2 == e.data ? wx.showToast({
                            title: "二维码出错啦！",
                            icon: "none",
                            duration: 2e3
                        }) : wx.showToast({
                            title: "赞助商不符！",
                            icon: "none",
                            duration: 2e3
                        });
                    }
                });
            }
        });
    }
});