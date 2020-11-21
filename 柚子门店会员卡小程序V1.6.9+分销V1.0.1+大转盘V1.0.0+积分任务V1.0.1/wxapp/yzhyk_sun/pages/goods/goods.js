var app = getApp();

Page({
    data: {
        classify: [],
        curIndex: "0",
        show: !1,
        goods: [],
        curMinIndex: "0",
        curPage: 1,
        hasMore: !0,
        isIpx: app.globalData.isIpx
    },
    onLoad: function(t) {
        var a = this;
        if (app.get_imgroot().then(function(t) {
            a.setData({
                imgroot: t
            });
        }), app.get_store_info().then(function(t) {
            wx.setNavigationBarTitle({
                title: t.name
            }), a.setData({
                store: t
            }), app.util.request({
                url: "entry/wxapp/getclasses",
                cachetime: "0",
                data: {
                    store_id: t.id
                },
                success: function(t) {
                    a.setData({
                        classify: t.data
                    }), a.updategoods();
                }
            }), a.setData({
                cart: app.cart_get()
            });
        }), wx.getStorageSync("tabBar")) {
            var e = wx.getStorageSync("tabBar"), o = getCurrentPages(), s = o[o.length - 1].__route__;
            0 != s.indexOf("/") && (s = "/" + s);
            for (var i = 0; i < e.list.length; i++) e.list[i].active = !1, e.list[i].selectedColor = e.selectedColor, 
            e.list[i].pagePath == s && (e.list[i].active = !0, e.list[i].title && wx.setNavigationBarTitle({
                title: e.list[i].title
            }));
            a.setData({
                tabBar: e
            });
        } else console.log(22), app.editTabBar();
    },
    onReady: function() {},
    onShow: function() {
        this.setData({
            cart: app.cart_get()
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        console.log("xxxx");
    },
    onReachBottom: function() {},
    curNav: function(t) {
        var a = t.currentTarget.dataset.index;
        this.setData({
            curIndex: a,
            curPage: 1,
            hasMore: !0
        }), this.updategoods();
    },
    curMinNav: function(t) {
        var a = t.currentTarget.dataset.index;
        this.setData({
            curMinIndex: a,
            curPage: 1,
            hasMore: !0
        }), this.updategoods();
    },
    show: function(t) {
        var a = t.currentTarget.dataset.statu;
        this.setData({
            show: !a
        });
    },
    add: function(t) {
        var a = this, e = t.currentTarget.dataset.id, o = "id_" + e, s = a.data.goods[o], i = app.cart_add(s), r = a.data.goods;
        r[o].num = i.goodses[e].num, a.setData({
            cart: i,
            goods: r
        });
    },
    reduce: function(t) {
        var a = t.currentTarget.dataset.id, e = "id_" + a, o = app.cart_reduce(a), s = this.data.goods;
        s[e].num = o.goodses[a] ? o.goodses[a].num : 0, this.setData({
            cart: o,
            goods: s
        });
    },
    toGoods: function(t) {
        var a = t.currentTarget.dataset.id, e = t.currentTarget.dataset.activity_id;
        wx.navigateTo({
            url: "../index/goods/goods?id=" + a + "&activity_id=" + e
        });
    },
    toSearch: function(t) {
        wx.navigateTo({
            url: "search/search"
        });
    },
    updategoods: function() {
        var r = this, t = r.data.curIndex, a = r.data.curMinIndex, e = r.data.classify[t].id, o = 0 < r.data.classify[t].group.length ? r.data.classify[t].group[a].id : 0, n = r.data.curPage, s = r.data.store.id;
        app.util.request({
            url: "entry/wxapp/getgoodses",
            cachetime: "0",
            data: {
                root_id: e,
                class_id: o,
                store_id: s,
                page: n
            },
            success: function(t) {
                if (1 == n) var a = {}; else a = r.data.goods;
                var e = app.cart_get();
                for (var o in t.data) {
                    var s = t.data[o].id, i = "id_" + s;
                    a[i] = t.data[o], a[i].num = e.goodses[s] ? e.goodses[s].num : 0;
                }
                r.setData({
                    goods: a
                }), t.data.length < 10 && r.setData({
                    hasMore: !1
                });
            }
        });
    },
    onBottom: function(t) {
        if (!this.data.hasMore) return !1;
        this.setData({
            curPage: this.data.curPage + 1
        }), this.updategoods();
    },
    onTop: function(t) {
        console.log("fffffffff");
    }
});