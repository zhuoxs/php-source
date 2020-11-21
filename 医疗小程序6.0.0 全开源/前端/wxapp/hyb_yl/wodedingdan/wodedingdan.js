var app = getApp();

Page({
    data: {
        taocan: [ "已支付", "待评价", "已评价" ],
        currentTab: 0
    },
    taocan: function(t) {
        var a = this, n = parseInt(t.currentTarget.dataset.index), e = wx.getStorageSync("openid");
        if (0 == n && app.util.request({
            url: "entry/wxapp/Allordersyi",
            data: {
                openid: e
            },
            success: function(t) {
                a.setData({
                    dingdan: t.data.data
                });
            },
            fail: function(t) {
                console.log(t);
            }
        }), 1 == n) {
            console.log("待评价");
            e = wx.getStorageSync("openid");
            app.util.request({
                url: "entry/wxapp/Allorderspingj",
                data: {
                    openid: e
                },
                success: function(t) {
                    console.log(t), a.setData({
                        dingdan: t.data.data,
                        index: n
                    });
                },
                fail: function(t) {
                    console.log(t);
                }
            });
        }
        if (2 == n) {
            e = wx.getStorageSync("openid");
            app.util.request({
                url: "entry/wxapp/Allordersypj",
                data: {
                    openid: e
                },
                success: function(t) {
                    console.log(t), a.setData({
                        dingdan: t.data.data,
                        index: n
                    });
                },
                fail: function(t) {
                    console.log(t);
                }
            });
        }
        this.setData({
            currentTab: t.currentTarget.dataset.index + 1
        });
    },
    taocan1: function(t) {
        var a = this, n = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/Allorders",
            data: {
                openid: n
            },
            success: function(t) {
                a.setData({
                    dingdan: t.data.data
                });
            },
            fail: function(t) {
                console.log(t);
            }
        });
        t.currentTarget.dataset.index;
        this.setData({
            currentTab: 0
        });
    },
    deleteProduct: function(t) {
        var a = t.currentTarget.dataset.index, n = this.data.dingdan, e = t.currentTarget.dataset.id, o = wx.getStorageSync("openid");
        console.log(e);
        var i = app.siteInfo.uniacid;
        n.splice(a, 1), app.util.request({
            url: "entry/wxapp/Delvideo",
            data: {
                id: e,
                uniacid: i,
                openid: o
            },
            success: function(t) {
                console.log(t);
            },
            fail: function(t) {
                console.log(t);
            }
        }), this.setData({
            dingdan: n
        });
    },
    onLoad: function(t) {
        var a = wx.getStorageSync("color");
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: a
        });
        var n = this, e = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/Allorders",
            data: {
                openid: e
            },
            success: function(t) {
                console.log(t), n.setData({
                    dingdan: t.data.data
                });
            },
            fail: function(t) {
                console.log(t);
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        var a = this, t = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/Allorders",
            data: {
                openid: t
            },
            success: function(t) {
                console.log(t), a.setData({
                    dingdan: t.data.data
                });
            },
            fail: function(t) {
                console.log(t);
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    pingjia: function(t) {
        t.currentTarget.dataset.id;
        var a = t.currentTarget.dataset.data;
        wx.navigateTo({
            url: "/hyb_yl/jibingxq/jibingxq?id=" + t.currentTarget.dataset.id + "&sroomtitle=" + a
        });
    }
});