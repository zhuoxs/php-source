var app = getApp(), Api = require("../../resource/utils/util.js");

Page({
    data: {},
    onLoad: function(o) {
        var t = this, e = wx.getStorageSync("openid");
        console.log(e), wx.getStorage({
            key: "url",
            success: function(o) {
                t.setData({
                    url: o.data
                });
            }
        }), t.diyWinColor();
    },
    chouju: function(t) {
        var e = this;
        console.log(t), wx.showModal({
            title: "提示",
            content: "是否确认拒绝，该操作无法恢复！",
            success: function(o) {
                o.confirm ? (console.log("用户点击确定"), app.util.request({
                    url: "entry/wxapp/reserveNot",
                    cachetime: "0",
                    data: {
                        id: t.currentTarget.dataset.id
                    },
                    success: function(o) {
                        console.log(o), 1 == o.data && wx.showToast({
                            title: "拒绝成功！"
                        }), setTimeout(function() {
                            e.onShow();
                        }, 2e3);
                    }
                })) : o.cancel && console.log("用户点击取消");
            }
        });
    },
    shuaibi: function(t) {
        var e = this;
        console.log(t), wx.showModal({
            title: "提示",
            content: "是否确认，该操作无法恢复！",
            success: function(o) {
                o.confirm ? (console.log("用户点击确定"), app.util.request({
                    url: "entry/wxapp/reserveYes",
                    cachetime: "0",
                    data: {
                        id: t.currentTarget.dataset.id
                    },
                    success: function(o) {
                        console.log(o), 1 == o.data && wx.showToast({
                            title: "确认成功！"
                        }), setTimeout(function() {
                            e.onShow();
                        }, 2e3);
                    }
                })) : o.cancel && console.log("用户点击取消");
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        var t = this, o = wx.getStorageSync("openid");
        console.log(o), app.util.request({
            url: "entry/wxapp/ReverseMana",
            cachetime: "0",
            data: {
                openid: o
            },
            success: function(o) {
                console.log(o), t.setData({
                    reserveRecords: o.data.data
                });
            }
        });
    },
    onHide: function() {},
    diyWinColor: function(o) {
        var t = wx.getStorageSync("system");
        wx.setNavigationBarColor({
            frontColor: t.color,
            backgroundColor: t.fontcolor,
            animation: {
                duration: 400,
                timingFunc: "easeIn"
            }
        }), wx.setNavigationBarTitle({
            title: "订座管理"
        });
    }
});