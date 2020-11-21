var app = getApp(), Page = require("../../../../zhy/sdk/qitui/oddpush.js").oddPush(Page).Page;

Page({
    data: {
        goId: 0
    },
    onLoad: function(t) {
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), this.url(), wx.getStorage({
            key: "openid",
            success: function(t) {}
        });
    },
    url: function(t) {
        var e = this;
        app.util.request({
            url: "entry/wxapp/Url2",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url2", t.data);
            }
        }), app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url", t.data), e.setData({
                    url: t.data
                });
            }
        });
    },
    onShow: function() {
        var e = this, t = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/Giftorder",
            cachetime: "0",
            data: {
                openid: t
            },
            success: function(t) {
                console.log(t.data), e.setData({
                    gift: t.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/WGiftorder",
            cachetime: "0",
            data: {
                openid: t
            },
            success: function(t) {
                console.log(t.data), e.setData({
                    WGiftorder: t.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/YGiftorder",
            cachetime: "0",
            data: {
                openid: t
            },
            success: function(t) {
                e.setData({
                    YGiftorder: t.data
                });
            }
        });
    },
    del: function(e) {
        var a = this;
        wx.showModal({
            title: "提示",
            content: "是否删除该订单",
            success: function(t) {
                t.confirm ? wx.getStorage({
                    key: "openid",
                    success: function(t) {
                        app.util.request({
                            url: "entry/wxapp/Gdelorder",
                            cachetime: "0",
                            data: {
                                openid: t.data,
                                id: e.currentTarget.dataset.id
                            },
                            success: function(t) {
                                console.log(t.data), 1 == t.data && a.onShow();
                            }
                        });
                    }
                }) : t.cancel && console.log("用户点击取消");
            }
        });
    },
    orderTab: function(t) {
        var e = Number(t.currentTarget.dataset.id);
        this.setData({
            goId: e
        }), console.log(this.data);
    },
    goTakeorder: function(t) {
        var e = this;
        app.util.request({
            url: "entry/wxapp/completiont",
            cachetime: "0",
            data: {
                id: t.currentTarget.dataset.id
            },
            success: function(t) {
                t.data && wx.showToast({
                    title: "成功",
                    icon: "success",
                    duration: 2e3
                }), e.onShow();
            }
        });
    }
});