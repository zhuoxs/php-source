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
        }), this.url();
    },
    onShow: function() {
        var e = this, a = wx.getStorageSync("bid");
        wx.getStorage({
            key: "openid",
            success: function(t) {
                app.util.request({
                    url: "entry/wxapp/usergift",
                    cachetime: "0",
                    data: {
                        openid: t.data,
                        bid: a
                    },
                    success: function(t) {
                        console.log(t.data), e.setData({
                            prize: t.data
                        });
                    }
                }), app.util.request({
                    url: "entry/wxapp/Wusergift",
                    cachetime: "0",
                    data: {
                        openid: t.data,
                        bid: a
                    },
                    success: function(t) {
                        e.setData({
                            Wprize: t.data
                        });
                    }
                }), app.util.request({
                    url: "entry/wxapp/Yusergift",
                    cachetime: "0",
                    data: {
                        openid: t.data,
                        bid: a
                    },
                    success: function(t) {
                        e.setData({
                            Yprize: t.data
                        });
                    }
                });
            }
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
    orderTab: function(t) {
        var e = Number(t.currentTarget.dataset.id);
        this.setData({
            goId: e
        });
    },
    godetails: function(t) {
        var e = wx.getStorageSync("bid");
        wx.navigateTo({
            url: "../../booking/card/card?id=" + t.currentTarget.dataset.pid + "&bid=" + e
        });
    },
    goTakeorder: function(t) {
        var e = this, a = t.currentTarget.dataset.id;
        wx.showModal({
            title: "提示",
            content: "是否确认完成",
            success: function(t) {
                t.confirm ? wx.getStorage({
                    key: "openid",
                    success: function(t) {
                        app.util.request({
                            url: "entry/wxapp/giftqueren",
                            cachetime: "0",
                            data: {
                                openid: t.data,
                                id: a
                            },
                            success: function(t) {
                                e.onShow();
                            }
                        });
                    }
                }) : t.cancel && console.log("用户点击取消");
            }
        });
    },
    del: function(t) {
        var e = this, a = t.currentTarget.dataset.id;
        wx.showModal({
            title: "提示",
            content: "是否删除该领奖",
            success: function(t) {
                t.confirm ? wx.getStorage({
                    key: "openid",
                    success: function(t) {
                        app.util.request({
                            url: "entry/wxapp/delgift",
                            cachetime: "0",
                            data: {
                                openid: t.data,
                                id: a
                            },
                            success: function(t) {
                                e.onShow();
                            }
                        });
                    }
                }) : t.cancel && console.log("用户点击取消");
            }
        });
    }
});