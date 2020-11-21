var app = getApp();

Page({
    data: {
        tab: [ "未回答", "已回答" ],
        hide: !0,
        daIndex: null,
        current: 0,
        values: ""
    },
    close: function() {
        this.setData({
            hide: !0
        });
    },
    tab: function(t) {
        var a = this, e = wx.getStorageSync("openid");
        console.log(t.currentTarget.dataset.index), 0 == t.currentTarget.dataset.index ? app.util.request({
            url: "entry/wxapp/Allquestwei",
            data: {
                openid: e
            },
            success: function(t) {
                console.log(t);
                var e = t.data.data;
                a.setData({
                    wenda: e
                });
            },
            fail: function(t) {
                console.log(t);
            }
        }) : app.util.request({
            url: "entry/wxapp/Allquestyi",
            data: {
                openid: e
            },
            success: function(t) {
                console.log(t);
                var e = t.data.data;
                a.setData({
                    wenda: e
                });
            },
            fail: function(t) {
                console.log(t);
            }
        }), this.setData({
            current: t.currentTarget.dataset.index
        });
    },
    huida: function(t) {
        console.log(t);
        var e = t.currentTarget.dataset.id, a = t.currentTarget.dataset.index;
        this.setData({
            daIndex: a,
            hide: !1,
            qid: e
        });
    },
    onLoad: function(t) {
        var e = wx.getStorageSync("color");
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: e
        });
        var a = this, n = wx.getStorageSync("openid"), r = t.zid;
        a.setData({
            zid: r
        }), app.util.request({
            url: "entry/wxapp/Allquestwei",
            data: {
                openid: n
            },
            success: function(t) {
                console.log(t);
                var e = t.data.data;
                a.setData({
                    wenda: e
                });
            },
            fail: function(t) {
                console.log(t);
            }
        });
    },
    answerDetailClick: function(t) {
        console.log(t);
        var e = t.currentTarget.dataset.zid, a = t.currentTarget.dataset.openid, n = t.currentTarget.dataset.qid;
        wx.navigateTo({
            url: "/hyb_yl/zhuan_da/zhuan_da?zid=" + e + "&user_openid=" + a + "&qid=" + n
        });
    },
    previewImages: function(t) {
        for (var e = t.currentTarget.dataset.src, a = t.currentTarget.dataset.qid, n = this.data.wenda, r = [], o = 0; o < n.length; o++) n[o].qid == a && (r = n[o].user_picture);
        wx.previewImage({
            current: e,
            urls: r
        });
    },
    previewImage: function(t) {
        for (var e = t.currentTarget.dataset.src, a = t.currentTarget.dataset.qid, n = this.data.wenda, r = [], o = 0; o < n.length; o++) n[o].qid == a && (r = n[o].user_picture);
        wx.previewImage({
            current: e,
            urls: r
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});