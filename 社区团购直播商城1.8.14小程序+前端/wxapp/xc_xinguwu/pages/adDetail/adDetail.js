var app = getApp(), WxParse = require("../../../wxParse/wxParse.js"), TxvContext = requirePlugin("tencentvideo");

Page({
    data: {},
    toAgree: function() {
        this.setData({
            liked: 1
        }), app.util.request({
            url: "entry/wxapp/special",
            showLoading: !1,
            method: "POST",
            data: {
                op: "special_like",
                id: this.data.options.id
            }
        });
    },
    cancelAgree: function() {
        this.setData({
            liked: -1
        }), app.util.request({
            url: "entry/wxapp/special",
            showLoading: !1,
            method: "POST",
            data: {
                op: "special_like_cancel",
                id: this.data.options.id
            }
        });
    },
    adLink: function() {
        var t = this.data.list.ad_link;
        app.look.istrue(t) && wx.redirectTo({
            url: t
        });
    },
    onLoad: function(t) {
        this.setData({
            "goHome.blackhomeimg": app.globalData.blackhomeimg
        });
        var e = this;
        e.setData({
            options: t
        }), app.util.request({
            url: "entry/wxapp/special",
            showLoading: !1,
            method: "POST",
            data: {
                op: "special_detail",
                id: t.id
            },
            success: function(t) {
                var a = t.data;
                a.data.list && (console.log(a.data.list), WxParse.wxParse("article", "html", a.data.list.contents, e, 10), 
                console.log(a.data.list.video_type), e.setData({
                    list: a.data.list
                }), 2 == a.data.list.video_type && app.look.txvideo), a.data.liked && e.setData({
                    liked: a.data.liked
                }), a.data.about && e.setData({
                    about: a.data.about
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    toGood: function(t) {
        console.log(t);
        var a = this.data.list.recom[t.currentTarget.dataset.index], e = "";
        1 == a.cid && (e = "../detail/detail?id=" + a.id), wx.navigateTo({
            url: e
        });
    },
    onShareAppMessage: function() {
        wx.showShareMenu({
            withShareTicket: !0
        });
        var t = "";
        return t = "../adDetail/adDetail?id=" + this.data.list.id, t = encodeURIComponent(t), 
        {
            title: this.data.list.name,
            path: "/xc_xinguwu/pages/base/base?share=" + t,
            imageUrl: "",
            success: function(t) {
                wx.showToast({
                    title: "转发成功"
                });
            },
            fail: function(t) {}
        };
    }
});