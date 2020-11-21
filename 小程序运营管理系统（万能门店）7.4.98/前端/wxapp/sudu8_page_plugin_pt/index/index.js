var app = getApp();

Page({
    data: {
        page_signs: "/sudu8_page_plugin_pt/index/index",
        imgUrls: [],
        indicatorDots: !0,
        autoplay: !0,
        interval: 5e3,
        duration: 1e3,
        styles: 4
    },
    onPullDownRefresh: function() {
        this.getinfos(), wx.stopPullDownRefresh();
    },
    onLoad: function(t) {
        var a = this;
        a.setData({
            isIphoneX: app.globalData.isIphoneX
        });
        var e = 0;
        t.fxsid && (e = t.fxsid, a.setData({
            fxsid: t.fxsid
        })), a.setData({
            msgList: [ {
                src: "/image/about1.jpg",
                title: "秒杀了"
            }, {
                src: "/image/about1.jpg",
                title: "秒杀了"
            }, {
                src: "/image/about1.jpg",
                title: "秒杀了"
            } ],
            msgList2: [ {
                title: "限时秒杀，过时即涨"
            }, {
                title: "更多好货，不在错过"
            }, {
                title: "开枪预约，不在错过"
            } ]
        }), wx.setNavigationBarTitle({
            title: "拼团首页"
        });
        var s = 3600;
        setInterval(function() {
            if (0 <= s) {
                var t = a.dateformat(s);
                a.setData({
                    sytime: t
                }), s--;
            }
        }, 1e3);
        var i = app.util.url("entry/wxapp/BaseMin", {
            m: "sudu8_page"
        });
        wx.request({
            url: i,
            data: {
                vs1: 1
            },
            success: function(t) {
                a.setData({
                    baseinfo: t.data.data
                }), wx.setNavigationBarColor({
                    frontColor: a.data.baseinfo.base_tcolor,
                    backgroundColor: a.data.baseinfo.base_color
                }), a.getpro();
            },
            fail: function(t) {}
        }), app.util.getUserInfo(a.getinfos, e);
    },
    redirectto: function(t) {
        var a = t.currentTarget.dataset.link, e = t.currentTarget.dataset.linktype;
        app.util.redirectto(a, e);
    },
    getinfos: function() {
        var a = this;
        wx.getStorage({
            key: "openid",
            success: function(t) {
                a.setData({
                    openid: t.data
                });
            }
        });
    },
    onShareAppMessage: function() {
        return {
            title: "拼团商城"
        };
    },
    dateformat: function(t) {
        var a = Math.floor(t);
        if (86400 < a) var e = parseInt(a / 86400 / 24); else e = 0;
        e < 10 && (e = "0" + e);
        var s = Math.floor(a / 3600 % 24);
        s < 10 && (s = "0" + s);
        var i = Math.floor(a / 60 % 60);
        i < 10 && (i = "0" + i);
        var r = Math.floor(a % 60);
        return r < 10 && (r = "0" + r), this.setData({
            day: e,
            hr: s,
            min: i,
            sec: r
        }), s + "小时" + i + "分钟" + r + "秒";
    },
    getpro: function() {
        var s = this;
        app.util.request({
            url: "entry/wxapp/ptprolist",
            success: function(t) {
                var a = t.data.data, e = (a.guiz, a.cate[0].id);
                s.sandcid(e);
            }
        });
    },
    sandcid: function(t) {
        var i = this;
        app.util.request({
            url: "entry/wxapp/ptprolist",
            data: {
                cate: t
            },
            success: function(t) {
                var a = t.data.data, e = a.guiz, s = a.cate[0].id;
                i.setData({
                    lists: a.lists,
                    styles: e.types,
                    cate: a.cate,
                    cid: s
                });
            }
        });
    },
    handleTap: function(t) {
        var s = t.currentTarget.dataset.id, i = this;
        app.util.request({
            url: "entry/wxapp/ptprolist",
            data: {
                cate: s
            },
            success: function(t) {
                var a = t.data.data, e = a.guiz;
                i.setData({
                    lists: a.lists,
                    styles: e.types,
                    cate: a.cate,
                    cid: s
                });
            }
        });
    }
});