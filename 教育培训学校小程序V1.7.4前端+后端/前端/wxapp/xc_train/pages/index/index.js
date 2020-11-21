function a(a) {
    for (var t = 0; t < a.length; t++) "" != a[t].link && null != a[t].link && 1 == a[t].type && (-1 != a[t].link.indexOf("../") ? a[t].app = -1 : (a[t].link = a[t].link.split(","), 
    a[t].app = 1));
    return a;
}

var t = getApp(), n = require("../common/common.js");

Page({
    data: {
        pagePath: "../index/index",
        indicatorDots: !0,
        autoplay: !0,
        interval: 5e3,
        duration: 1e3,
        ad_show: !0
    },
    link: function(a) {
        var t = a.currentTarget.dataset.link;
        "" != t && null != t && (-1 != t.indexOf("https") ? (t = escape(t), wx.navigateTo({
            url: "../about/link?&url=" + t
        })) : wx.navigateTo({
            url: t
        }));
    },
    to_shop: function() {
        t.util.request({
            url: "entry/wxapp/user",
            showLoading: !1,
            data: {
                op: "userinfo"
            },
            success: function(a) {
                var t = a.data;
                "" != t.data && (-1 == t.data.shop ? wx.showModal({
                    title: "错误",
                    content: "没有权限"
                }) : 1 == t.data.shop ? wx.navigateTo({
                    url: "../manage/index"
                }) : 2 == t.data.shop && wx.navigateTo({
                    url: "../manage/index?&shop=" + t.data.shop_id
                }));
            }
        });
    },
    ad_close: function() {
        this.setData({
            yin: !1,
            open_ad: !1
        });
    },
    error: function(a) {
        console.log(a), this.setData({
            ad_show: !1
        });
    },
    adLoad: function(a) {
        console.log(a), this.setData({
            ad_show: !0
        });
    },
    onLoad: function(e) {
        var o = this;
        n.config(o), n.theme(o), t.util.request({
            url: "entry/wxapp/index",
            data: {
                op: "index"
            },
            showLoading: !1,
            success: function(n) {
                var e = n.data;
                if ("" != e.data && ("" != e.data.banner && null != e.data.banner && o.setData({
                    banner: e.data.banner
                }), "" != e.data.ad && null != e.data.ad && o.setData({
                    ad: e.data.ad
                }), "" != e.data.ad_color && null != e.data.ad_color && o.setData({
                    ad_color: e.data.ad_color
                }), "" != e.data.nav && null != e.data.nav && o.setData({
                    nav: a(e.data.nav)
                }), "" != e.data.list && null != e.data.list && o.setData({
                    list: e.data.list
                }), "" != e.data.mall && null != e.data.mall && o.setData({
                    mall: e.data.mall
                }), "" != e.data.open_ad && null != e.data.open_ad && (o.setData({
                    open_list: e.data.open_ad
                }), 1 == e.data.open_ad.login && (o.setData({
                    yin: !0,
                    open_ad: !0
                }), t.util.request({
                    url: "entry/wxapp/index",
                    showLoading: !1,
                    data: {
                        op: "login_log"
                    },
                    success: function(a) {
                        a.data.data;
                    }
                }))), "" != e.data.news && null != e.data.news)) {
                    for (var d = 0; d < e.data.news.length; d++) e.data.news[d].nav = "../about/link?&url=" + escape(e.data.news[d].link);
                    o.setData({
                        news: e.data.news
                    });
                }
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        n.audio_end(this);
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        var n = this;
        t.util.request({
            url: "entry/wxapp/index",
            data: {
                op: "index"
            },
            showLoading: !1,
            success: function(t) {
                var e = t.data;
                "" != e.data && (wx.stopPullDownRefresh(), "" != e.data.banner && null != e.data.banner && n.setData({
                    banner: e.data.banner
                }), "" != e.data.ad && null != e.data.ad && n.setData({
                    ad: e.data.ad
                }), "" != e.data.nav && null != e.data.nav && n.setData({
                    nav: a(e.data.nav)
                }), "" != e.data.list && null != e.data.list && n.setData({
                    list: e.data.list
                }));
            }
        });
    },
    onReachBottom: function() {},
    onShareAppMessage: function() {
        var a = this, t = "/xc_train/pages/index/index";
        return t = escape(t), {
            title: a.data.config.title + "-首页",
            path: "/xc_train/pages/base/base?&share=" + t,
            success: function(a) {
                console.log(a);
            },
            fail: function(a) {
                console.log(a);
            }
        };
    }
});