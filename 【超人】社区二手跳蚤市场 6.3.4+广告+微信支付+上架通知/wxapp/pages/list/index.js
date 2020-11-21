var app = getApp(), Toast = require("../../libs/zanui/toast/toast");

Page({
    data: {
        autoplay: !0,
        interval: 3e3,
        duration: 500,
        category: [],
        selectedId: "",
        scroll: !0,
        fixed: !0,
        cate_height: 45,
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
        orderId: "location",
        od_height: 35,
        pages: 1,
        hide: !0,
        more: !0,
        refresh: !0,
        showCategoryPopup: !1,
        recycle: {
            open: !1,
            style: []
        }
    },
    onLoad: function(t) {
        var a = this, e = wx.getStorageSync("loading_img"), o = wx.getStorageSync("post_time"), s = wx.getStorageSync("sold_img"), i = wx.getStorageSync("cube_open"), r = wx.getStorageSync("post_open");
        if (e ? a.setData({
            loadingImg: e
        }) : a.setData({
            loadingImg: "../../libs/images/loading.gif"
        }), o && a.setData({
            post_time: o
        }), s && a.setData({
            soldImg: s
        }), i && a.setData({
            showCube: !0
        }), r) {
            var l = wx.getStorageSync("post_btn_data");
            a.setData({
                showPostBtn: !0,
                post_appid: l.appid,
                post_url: l.url,
                post_img: l.thumb
            });
        }
        app.viewCount(), a.setData({
            credit_title: app.globalData.credit_title
        }), a.getList(t.id), app.util.footer(a), app.setTabBar(a);
    },
    getList: function(g) {
        var c = this, t = app.globalData.lat || "", a = app.globalData.lng || "";
        app.util.request({
            url: "entry/wxapp/item",
            cachetime: "0",
            data: {
                cid: g,
                act: "list",
                lat: t,
                lng: a,
                district: app.globalData.district,
                op: c.data.orderId,
                m: "superman_hand2"
            },
            success: function(t) {
                if (t.data.errno) c.showIconToast(t.data.errmsg); else {
                    var a = t.data.data, e = [];
                    if ("location" != c.data.orderId) {
                        var o = a.top_items, s = app.globalData.district, i = 1;
                        if ("popular" == c.data.orderId && (i = 2), o && 0 < o.length) for (var r = 0; r < o.length; r++) for (var l = o[r].set_top_fields, n = 0; n < l.length; n++) if (l[n].district == s && (3 == l[n].position || l[n].position == i)) {
                            o[r].top_position = l[n].position, e.push(o[r]);
                            break;
                        }
                    }
                    var d = a.list ? a.list : [], p = e.concat(d);
                    c.setData({
                        category: a.category,
                        list: p,
                        listAd: a.banner,
                        total: p.length,
                        thumb_open: 1 == a.thumb,
                        selectedId: g,
                        completed: !0
                    });
                }
            },
            fail: function(t) {
                c.setData({
                    completed: !0
                }), c.showIconToast(t.data.errmsg);
            }
        });
    },
    handleTabChange: function(t) {
        this.getList(t.detail), this.setData({
            pages: 1,
            more: !0,
            refresh: !0
        });
    },
    displayOrderChange: function(t) {
        this.setData({
            orderId: t.detail,
            pages: 1,
            more: !0,
            refresh: !0
        }), this.getList(this.data.selectedId);
    },
    goTop: function() {
        wx.pageScrollTo({
            scrollTop: 0,
            duration: 500
        });
    },
    onReachBottom: function() {
        var s = this;
        if (s.data.refresh) {
            s.setData({
                hide: !1
            });
            var t = app.globalData.lat || "", a = app.globalData.lng || "", i = s.data.pages + 1;
            app.util.request({
                url: "entry/wxapp/item",
                cachetime: "0",
                data: {
                    page: i,
                    op: s.data.orderId,
                    lat: t,
                    lng: a,
                    cid: s.data.selectedId,
                    district: app.globalData.district,
                    m: "superman_hand2"
                },
                success: function(t) {
                    if (s.setData({
                        hide: !0
                    }), 0 == t.data.errno) {
                        var a = t.data.data.list;
                        if (0 < a.length) {
                            var e = s.data.list;
                            s.setData({
                                total: e.length
                            });
                            var o = e.concat(a);
                            s.setData({
                                list: o,
                                pages: i
                            });
                        } else s.setData({
                            more: !1,
                            refresh: !1
                        });
                    } else s.showIconToast(t.data.errmsg);
                },
                fail: function(t) {
                    s.showIconToast(t.data.errmsg);
                }
            });
        }
    },
    toggleCategoryPopup: function() {
        this.setData({
            category: wx.getStorageSync("category") ? wx.getStorageSync("category") : [],
            showCategoryPopup: !this.data.showCategoryPopup
        });
    },
    jumpToPage: function(t) {
        var a = t.currentTarget.dataset.url;
        -1 != a.indexOf("http") ? wx.navigateTo({
            url: "../ad/index?path=" + encodeURIComponent(a)
        }) : wx.navigateTo({
            url: a
        });
    },
    showIconToast: function(t) {
        var a = 1 < arguments.length && void 0 !== arguments[1] ? arguments[1] : "fail";
        Toast({
            type: a,
            message: t,
            selector: "#zan-toast"
        });
    }
});