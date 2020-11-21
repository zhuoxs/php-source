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
        var e = this, a = wx.getStorageSync("bid");
        wx.getStorage({
            key: "openid",
            success: function(t) {
                app.util.request({
                    url: "entry/wxapp/weiroomorder",
                    cachetime: "0",
                    data: {
                        openid: t.data,
                        bid: a
                    },
                    success: function(t) {
                        e.setData({
                            weiRoom: t.data
                        });
                    }
                }), app.util.request({
                    url: "entry/wxapp/yiroomorder",
                    cachetime: "0",
                    data: {
                        openid: t.data,
                        bid: a
                    },
                    success: function(t) {
                        e.setData({
                            yiRoom: t.data
                        });
                    }
                }), app.util.request({
                    url: "entry/wxapp/RoomorderData",
                    cachetime: "0",
                    data: {
                        openid: t.data,
                        bid: a
                    },
                    success: function(t) {
                        console.log(t.data), e.setData({
                            Room: t.data
                        });
                    }
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
                            url: "entry/wxapp/delorder",
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
    goDetails: function(t) {
        var e = t.currentTarget.dataset.id;
        wx.navigateTo({
            url: "../orderDetail/orderDetail?id=" + e
        });
    },
    orderTab: function(t) {
        var e = Number(t.currentTarget.dataset.id);
        this.setData({
            goId: e
        });
    },
    goTakeorder: function(t) {
        var e = this;
        app.util.request({
            url: "entry/wxapp/completion",
            cachetime: "0",
            data: {
                id: t.currentTarget.dataset.id
            },
            success: function(t) {
                1 == t.data && wx.showToast({
                    title: "成功",
                    icon: "success",
                    duration: 2e3
                }), e.onShow();
            }
        });
    }
});