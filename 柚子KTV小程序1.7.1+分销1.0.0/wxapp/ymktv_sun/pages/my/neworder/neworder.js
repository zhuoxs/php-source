var app = getApp();

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
        });
        var a = t.sid;
        wx.setStorageSync("sid", a), this.url();
    },
    delorder: function(t) {
        console.log(t);
        var a = this, e = t.currentTarget.dataset.id;
        wx.showModal({
            title: "提示",
            content: "是否删除该订单",
            success: function(t) {
                t.confirm ? wx.getStorage({
                    key: "openid",
                    success: function(t) {
                        app.util.request({
                            url: "entry/wxapp/deldrink",
                            cachetime: "0",
                            data: {
                                openid: t.data,
                                id: e
                            },
                            success: function(t) {
                                1 == t.data && a.onShow();
                            }
                        });
                    }
                }) : t.cancel && console.log("用户点击取消");
            }
        });
    },
    url: function(t) {
        var a = this;
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
                wx.setStorageSync("url", t.data), a.setData({
                    url: t.data
                });
            }
        });
    },
    onShow: function() {
        var a = this, e = wx.getStorageSync("sid");
        wx.getStorage({
            key: "openid",
            success: function(t) {
                t.data;
                app.util.request({
                    url: "entry/wxapp/RDuserData",
                    cachetime: "0",
                    data: {
                        sid: e
                    },
                    success: function(t) {
                        console.log(t.data), a.setData({
                            orderData: t.data
                        });
                    }
                });
            }
        });
    },
    orderTab: function(t) {
        var a = Number(t.currentTarget.dataset.id);
        this.setData({
            goId: a
        });
    },
    goTakeorder: function(t) {
        var a = this;
        app.util.request({
            url: "entry/wxapp/completions",
            cachetime: "0",
            data: {
                id: t.currentTarget.dataset.id
            },
            success: function(t) {
                1 == t.data && wx.showToast({
                    title: "成功",
                    icon: "success",
                    duration: 2e3
                }), a.onShow();
            }
        });
    }
});