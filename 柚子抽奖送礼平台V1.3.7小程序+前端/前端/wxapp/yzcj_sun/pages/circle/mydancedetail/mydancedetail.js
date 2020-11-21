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
        releaseFocus: !1,
        list: []
    },
    onLoad: function(t) {
        var e = this, a = t.id;
        wx.setStorageSync("id", a), wx.getUserInfo({
            success: function(t) {
                e.setData({
                    userInfo: t.userInfo
                });
            }
        });
    },
    previewImage: function(t) {
        for (var e = this, a = (t.currentTarget.dataset.index, t.currentTarget.dataset.idx), n = (e.data.list, 
        []), i = 0; i < e.data.list.img.length; i++) n.push(e.data.url + e.data.list.img[i]);
        wx.previewImage({
            current: n[a],
            urls: n
        });
    },
    getlove: function(t) {
        var a = this, e = t.currentTarget.dataset.id, n = wx.getStorageSync("users").openid, i = (a.data.list, 
        a.data.list.lovestate), s = a.data.list.lovenum, o = "list.lovestate", r = "list.lovenum";
        1 == i ? wx.showModal({
            title: "提示",
            content: "确定取消点赞吗？",
            success: function(t) {
                s--, t.confirm && app.util.request({
                    url: "entry/wxapp/DelParise",
                    data: {
                        openid: n,
                        id: e
                    },
                    success: function(t) {
                        var e;
                        a.setData((_defineProperty(e = {}, o, !1), _defineProperty(e, r, s), e));
                    }
                });
            }
        }) : app.util.request({
            url: "entry/wxapp/DelParise",
            data: {
                openid: n,
                id: e
            },
            success: function(t) {
                var e;
                s++, a.setData((_defineProperty(e = {}, o, !0), _defineProperty(e, r, s), e));
            }
        });
    },
    bindReply: function(t) {
        this.setData({
            releaseFocus: !0
        });
    },
    bindReplyclose: function(t) {
        var e = this, a = e.data.value, n = t.currentTarget.dataset.id, i = wx.getStorageSync("users").openid;
        console.log(e.data.length), e.data.length < 1 || null == e.data.length ? wx.showToast({
            title: "内容不得为空！",
            icon: "loading",
            duration: 1e3,
            mask: !0
        }) : wx.showModal({
            title: "提示",
            content: "确定发送吗？",
            success: function(t) {
                t.confirm && app.util.request({
                    url: "entry/wxapp/PutContent",
                    data: {
                        openid: i,
                        id: n,
                        content: a
                    },
                    success: function(t) {
                        e.setData({
                            releaseFocus: !1,
                            searchinput: ""
                        }), e.onShow();
                    }
                });
            }
        });
    },
    bindKeyInput: function(t) {
        this.setData({
            length: t.detail.value.length,
            value: t.detail.value
        });
    },
    onReady: function() {},
    onShow: function() {
        var e = this, t = wx.getStorageSync("users").openid, a = wx.getStorageSync("id");
        app.util.request({
            url: "entry/wxapp/CircleDetail",
            data: {
                openid: t,
                id: a
            },
            success: function(t) {
                console.log(t.data), e.setData({
                    list: t.data.res,
                    conmment: t.data.res1
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
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});