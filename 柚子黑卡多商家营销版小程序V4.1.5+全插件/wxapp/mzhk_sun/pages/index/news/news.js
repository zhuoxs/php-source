var app = getApp(), Page = require("../../../sdk/qitui/oddpush.js").oddPush(Page).Page;

Page({
    data: {
        navTile: "",
        news: [],
        page: 1,
        hiddens: !0,
        show: !0
    },
    onLoad: function(t) {
        var a = this, e = app.getSiteUrl();
        e ? a.setData({
            url: e
        }) : app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            success: function(t) {
                wx.setStorageSync("url", t.data), e = t.data, a.setData({
                    url: e
                });
            }
        }), wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("System").fontcolor ? wx.getStorageSync("System").fontcolor : "",
            backgroundColor: wx.getStorageSync("System").color ? wx.getStorageSync("System").color : "",
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), app.util.request({
            url: "entry/wxapp/GetNews",
            cachetime: "30",
            success: function(t) {
                if (console.log("专题数据"), console.log(t.data), 2 == t.data) a.setData({
                    news: []
                }); else {
                    for (var e in t.data) t.data[e].show = !0, t.data[e].hiddens = !0;
                    a.setData({
                        news: t.data
                    });
                }
            }
        }), app.util.request({
            url: "entry/wxapp/Tbbanner",
            cachetime: "30",
            success: function(t) {
                if (2 != t.data) {
                    var e = t.data, a = e[4].bname ? e[4].bname : "专题";
                    wx.setNavigationBarTitle({
                        title: a
                    });
                } else wx.setNavigationBarTitle({
                    title: "专题"
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {
        var t = this.data.news, e = this.data.play_id;
        t[e].show = !0, t[e].hiddens = !0, wx.createVideoContext(e, this).stop(), this.setData({
            news: t
        });
    },
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {
        var a = this, n = a.data.page, o = a.data.news;
        app.util.request({
            url: "entry/wxapp/GetNews",
            data: {
                page: n
            },
            success: function(t) {
                if (2 == t.data) wx.showToast({
                    title: "已经没有内容了哦！！！",
                    icon: "none"
                }); else {
                    var e = t.data;
                    o = o.concat(e), a.setData({
                        news: o,
                        page: n + 1
                    });
                }
            }
        });
    },
    onShareAppMessage: function() {},
    toArticle: function(t) {
        var e = t.currentTarget.dataset.id;
        this.endVideo(), wx.navigateTo({
            url: "../article/article?id=" + e
        });
    },
    playvedio: function(t) {
        var e = this;
        console.log(t);
        var a = t.currentTarget.id, n = this.data.play_id, o = this.data.news;
        n && (console.log("暂停"), o[n].show = !0, o[n].hiddens = !0, this.setData({
            news: o
        }), wx.createVideoContext(n, this).stop()), this.setData({
            play_id: a
        }), setTimeout(function() {
            o[a].show = !1, o[a].hiddens = !1, e.setData({
                news: o
            }), wx.createVideoContext(a, e).play();
        }, 500);
    },
    endVideo: function() {}
});