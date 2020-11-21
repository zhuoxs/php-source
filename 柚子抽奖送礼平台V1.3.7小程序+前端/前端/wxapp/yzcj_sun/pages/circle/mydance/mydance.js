function _defineProperty(t, e, a) {
    return e in t ? Object.defineProperty(t, e, {
        value: a,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[e] = a, t;
}

var app = getApp();

Page({
    data: {
        navIndex: 0,
        list: []
    },
    onLoad: function(t) {
        var e = this;
        wx.getUserInfo({
            success: function(t) {
                e.setData({
                    userInfo: t.userInfo
                });
            }
        });
    },
    previewImage: function(t) {
        for (var e = this, a = t.currentTarget.dataset.index, n = t.currentTarget.dataset.idx, r = (e.data.list, 
        []), i = 0; i < e.data.list[a].img.length; i++) r.push(e.data.url + e.data.list[a].img[i]);
        console.log(r), wx.previewImage({
            current: r[n],
            urls: r
        });
    },
    getlove: function(t) {
        var a = this, e = t.currentTarget.dataset.index, n = t.currentTarget.dataset.id, r = wx.getStorageSync("users").openid, i = (a.data.list, 
        a.data.list[e].lovestate), s = a.data.list[e].lovenum, o = "list[" + e + "].lovestate", c = "list[" + e + "].lovenum";
        1 == i ? wx.showModal({
            title: "提示",
            content: "确定取消点赞吗？",
            success: function(t) {
                s--, t.confirm && app.util.request({
                    url: "entry/wxapp/DelParise",
                    data: {
                        openid: r,
                        id: n
                    },
                    success: function(t) {
                        var e;
                        a.setData((_defineProperty(e = {}, o, !1), _defineProperty(e, c, s), e));
                    }
                });
            }
        }) : app.util.request({
            url: "entry/wxapp/DelParise",
            data: {
                openid: r,
                id: n
            },
            success: function(t) {
                var e;
                s++, a.setData((_defineProperty(e = {}, o, !0), _defineProperty(e, c, s), e));
            }
        });
    },
    closeitem: function(t) {
        var e = this, a = t.currentTarget.dataset.index;
        e.data.list;
        wx.showModal({
            title: "提示",
            content: "确定删除吗？",
            success: function(t) {
                t.confirm && app.util.request({
                    url: "entry/wxapp/DelCircle",
                    data: {
                        id: a
                    },
                    success: function(t) {
                        e.onShow();
                    }
                });
            }
        });
    },
    goMydancedetail: function(t) {
        var e = t.currentTarget.dataset.id;
        wx.navigateTo({
            url: "../mydancedetail/mydancedetail?id=" + e
        });
    },
    onReady: function() {},
    onShow: function() {
        var e = this, t = wx.getStorageSync("users").openid;
        app.util.request({
            url: "entry/wxapp/ShowMyCircle",
            data: {
                openid: t
            },
            success: function(t) {
                console.log(t.data), e.setData({
                    list: t.data.res,
                    list1: t.data.res1
                }), e.getUrl();
            }
        });
    },
    getUrl: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/url",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url", t.data), e.setData({
                    url: t.data
                });
            }
        });
    },
    changeindex: function(t) {
        var e = t.currentTarget.dataset.index;
        this.setData({
            navIndex: e
        });
    },
    goCircledetail: function(t) {
        var e = t.currentTarget.dataset.id;
        wx.navigateTo({
            url: "../circledetail/circledetail?id=" + e
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});