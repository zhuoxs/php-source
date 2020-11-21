var app = getApp();

Page({
    data: {
        curIndex: 0,
        arrLen: [ "0", "0" ],
        curbargain: [],
        bargainOver: [],
        url: []
    },
    onLoad: function(a) {
        (n = this).getUrl();
        var t = n.data.arrLen;
        0 < n.data.curbargain.length && (t[0] = "1"), 0 < n.data.bargainOver.length && (t[1] = "1"), 
        n.setData({
            arrLen: t
        });
        var n = this;
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        var a = wx.getStorageSync("openid"), t = this;
        app.util.request({
            url: "entry/wxapp/zzkanjia",
            cachetime: "20",
            method: "GET",
            data: {
                openid: a
            },
            success: function(a) {
                console.log(a), t.setData({
                    curbargain: a.data
                }), t.getwancheng();
            }
        });
    },
    GotoDetails: function(a) {
        wx.navigateTo({
            url: "../../bargain/detail/detail?id=" + a.currentTarget.dataset.id
        });
    },
    getUrl: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/url",
            cachetime: "0",
            success: function(a) {
                wx.setStorageSync("url", a.data), t.setData({
                    url: a.data
                });
            }
        });
    },
    getwancheng: function() {
        var a = wx.getStorageSync("openid"), t = this;
        app.util.request({
            url: "entry/wxapp/ywckj",
            cachetime: "20",
            method: "GET",
            data: {
                openid: a
            },
            success: function(a) {
                t.setData({
                    bargainOver: a.data
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    bargainTap: function(a) {
        var t = parseInt(a.currentTarget.dataset.index);
        this.setData({
            curIndex: t
        });
    }
});