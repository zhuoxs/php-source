var app = getApp();

Page({
    data: {
        tab: [ "已回答", "未回答" ],
        hide: !0,
        daIndex: null,
        current: 0,
        values: "",
        wenda: [],
        wenda1: [ {
            da: [ "" ]
        } ]
    },
    close: function() {
        this.setData({
            hide: !0
        });
    },
    tab: function(e) {
        this.setData({
            current: e.currentTarget.dataset.index
        });
    },
    huida: function(e) {
        console.log(e);
        var t = e.currentTarget.dataset.id, a = e.currentTarget.dataset.index;
        this.setData({
            daIndex: a,
            hide: !1,
            qid: t
        });
    },
    formsubmit: function(e) {
        var t = this, a = t.data.qid;
        console.log(a);
        var n = wx.getStorageSync("openid"), r = parseInt(t.data.current), i = e.detail.value, u = parseInt(t.data.daIndex), s = t.data.wenda, o = t.data.wenda1, d = i.wenti;
        console.log(d), 0 == r && (s[u].da.unshift(i.wenti), t.setData({
            hide: !0,
            wenda: s
        }), app.util.request({
            url: "entry/wxapp/Insertvalue",
            data: {
                qid: a,
                openid: n,
                hd_question: d
            },
            success: function(e) {
                console.log(e);
            },
            fail: function(e) {
                console.log(e);
            }
        })), 1 == r && (o[u].hd_question = i.wenti, app.util.request({
            url: "entry/wxapp/Insertvalue",
            data: {
                qid: a,
                openid: n,
                hd_question: d
            },
            success: function(e) {
                console.log(e);
            },
            fail: function(e) {
                console.log(e);
            }
        }), t.setData({
            hide: !0,
            wenda1: o
        })), t.setData({
            values: ""
        });
    },
    onLoad: function(e) {
        var i = this, t = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/Allquestyi",
            data: {
                openid: t
            },
            success: function(e) {
                for (var t = e.data.data, a = 0; a < t.length; a++) {
                    var n = t[a];
                    n.da = [], n.user_picture = n.user_picture.split(";");
                }
                var r = n.user_picture;
                i.setData({
                    wenda: t,
                    url: r
                });
            },
            fail: function(e) {
                console.log(e);
            }
        }), app.util.request({
            url: "entry/wxapp/Allquestwei",
            data: {
                openid: t
            },
            success: function(e) {
                for (var t = e.data.data, a = 0; a < t.length; a++) {
                    var n = t[a];
                    n.da = [], n.user_picture = n.user_picture.split(";");
                }
                var r = n.user_picture;
                i.setData({
                    wenda1: t,
                    url: r
                });
            },
            fail: function(e) {
                console.log(e);
            }
        });
    },
    previewImages: function(e) {
        for (var t = e.currentTarget.dataset.src, a = e.currentTarget.dataset.qid, n = this.data.wenda, r = [], i = 0; i < n.length; i++) n[i].qid == a && (r = n[i].user_picture);
        wx.previewImage({
            current: t,
            urls: r
        });
    },
    previewImage: function(e) {
        for (var t = e.currentTarget.dataset.src, a = e.currentTarget.dataset.qid, n = this.data.wenda1, r = [], i = 0; i < n.length; i++) n[i].qid == a && (r = n[i].user_picture);
        wx.previewImage({
            current: t,
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