var app = getApp(), Toast = require("../../libs/zanui/toast/toast");

Page({
    data: {
        pages: 1,
        hide: !0,
        more: !0,
        refresh: !0,
        focus: !0,
        display: [ {
            id: "location",
            title: "附近"
        }, {
            id: "popular",
            title: "人气"
        }, {
            id: "new",
            title: "最新"
        } ],
        selectedId: "location"
    },
    onLoad: function() {
        var a = wx.getStorageSync("post_time"), t = wx.getStorageSync("sold_img"), e = wx.getStorageSync("loading_img");
        e ? this.setData({
            loadingImg: e
        }) : this.setData({
            loadingImg: "../../libs/images/loading.gif"
        }), a && this.setData({
            post_time: a
        }), t && this.setData({
            soldImg: t
        }), this.setData({
            credit_title: app.globalData.credit_title
        });
    },
    doSearch: function(a) {
        var s = this, t = a.detail.value.search;
        if ("" != t) {
            s.setData({
                keyword: t
            });
            var e = app.globalData.lat, o = app.globalData.lng;
            app.util.request({
                url: "entry/wxapp/home",
                cachetime: "0",
                data: {
                    kw: s.data.keyword,
                    act: "search",
                    op: s.data.selectedId,
                    lat: e,
                    lng: o,
                    m: "superman_hand2"
                },
                success: function(a) {
                    if (a.data.errno) s.showIconToast(a.errmsg); else {
                        var t = a.data.data.list;
                        s.setData({
                            list: t,
                            total: t ? t.length : 0
                        });
                        var e = a.data.data.plugin_notice;
                        0 == s.data.total && e && 1 == e.switch && s.setData({
                            showStockNotice: !0,
                            askId: e.askid
                        });
                    }
                }
            });
        } else s.showIconToast("请填写要搜索的关键词");
    },
    handleTabChange: function(a) {
        var e = this;
        e.setData({
            selectedId: a.currentTarget.dataset.id,
            pages: 1,
            more: !0
        });
        var t = app.globalData.lat, s = app.globalData.lng;
        app.util.request({
            url: "entry/wxapp/home",
            cachetime: "0",
            data: {
                kw: e.data.keyword,
                act: "search",
                op: e.data.selectedId,
                lat: t,
                lng: s,
                m: "superman_hand2"
            },
            success: function(a) {
                if (a.data.errno) e.showIconToast(a.errmsg); else {
                    var t = a.data.data.list;
                    e.setData({
                        list: t,
                        total: t ? t.length : 0
                    });
                }
            }
        });
    },
    goTop: function() {
        wx.pageScrollTo({
            scrollTop: 0,
            duration: 500
        });
    },
    onReachBottom: function() {
        var s = this;
        if (s.data.refresh && 0 != s.data.list.length) if (s.data.total < 10) s.setData({
            more: !1
        }); else {
            s.setData({
                hide: !1
            });
            var o = s.data.pages + 1, a = s.data.keyword, t = app.globalData.lat, e = app.globalData.lng;
            app.util.request({
                url: "entry/wxapp/home",
                cachetime: "0",
                data: {
                    page: o,
                    act: "search",
                    kw: a,
                    op: s.data.selectedId,
                    lat: t,
                    lng: e,
                    m: "superman_hand2"
                },
                success: function(a) {
                    if (s.setData({
                        hide: !0
                    }), 0 == a.data.errno) {
                        var t = a.data.data.list;
                        if (0 < t.length) {
                            var e = s.data.list.concat(t);
                            s.setData({
                                total: t.length,
                                list: e,
                                pages: o
                            });
                        } else s.setData({
                            more: !1,
                            refresh: !1
                        });
                    } else s.showIconToast(a.errmsg);
                }
            });
        }
    },
    showIconToast: function(a) {
        var t = 1 < arguments.length && void 0 !== arguments[1] ? arguments[1] : "fail";
        Toast({
            type: t,
            message: a,
            selector: "#zan-toast"
        });
    }
});