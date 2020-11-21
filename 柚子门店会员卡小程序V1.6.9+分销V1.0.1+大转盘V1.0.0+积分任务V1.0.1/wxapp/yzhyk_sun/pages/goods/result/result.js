var app = getApp();

Page({
    data: {
        navTile: "商品搜索",
        goods: [],
        keyword: "",
        curPage: 1,
        hasMore: !0
    },
    onLoad: function(t) {
        var a = this;
        wx.setNavigationBarTitle({
            title: a.data.navTile
        }), a.setData({
            keyword: t.keyword
        }), app.get_imgroot().then(function(t) {
            a.setData({
                imgroot: t
            });
        }), a.updateresult();
    },
    onReady: function() {},
    onShow: function() {
        var e = this;
        app.get_store_info().then(function(t) {
            var a = app.cart_get();
            e.setData({
                navTile: t.name,
                cart: a
            });
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {
        var t = this;
        if (!t.data.hasMore) return !1;
        var a = t.data.curPage + 1;
        t.setData({
            curPage: a
        }), t.updateresult();
    },
    onShareAppMessage: function() {},
    add: function(t) {
        var a = this, e = t.currentTarget.dataset.id, o = a.data.goods[e], n = app.cart_add(o), r = a.data.goods;
        r[e].num = n.goodses[e].num, a.setData({
            cart: n,
            goods: r
        });
    },
    reduce: function(t) {
        var a = t.currentTarget.dataset.id, e = app.cart_reduce(a), o = this.data.goods;
        o[a].num = e.goodses[a] ? e.goodses[a].num : 0, this.setData({
            cart: e,
            goods: o
        });
    },
    toGoods: function(t) {
        var a = t.currentTarget.dataset.id;
        console.log(a), wx.navigateTo({
            url: "../../index/goods/goods?id=" + a
        });
    },
    toCarts: function(t) {
        wx.navigateTo({
            url: "../../carts/carts"
        });
    },
    toResult: function(t) {
        var a = this, e = e = a.data.keyword;
        if ("" == e) wx.showModal({
            title: "提示",
            showCancel: !1,
            content: "商品名称不得为空"
        }); else {
            var o = wx.getStorageSync("hisword") || [];
            -1 == o.indexOf(e) && (o.push(e), wx.setStorageSync("hisword", o)), app.get_user_info().then(function(t) {
                app.util.request({
                    url: "entry/wxapp/addsearchrecord",
                    cachetime: "0",
                    data: {
                        user_id: t.id,
                        keyword: e
                    },
                    success: function(t) {}
                });
            }), a.setData({
                curPage: 1
            }), a.updateresult();
        }
    },
    onKeywordInput: function(t) {
        this.setData({
            keyword: t.detail.value
        });
    },
    updateresult: function() {
        var r = this, s = r.data.curPage, a = r.data.keyword;
        app.get_store_info().then(function(t) {
            app.util.request({
                url: "entry/wxapp/getsearchresult",
                cachetime: "0",
                data: {
                    store_id: t.id,
                    page: s,
                    keyword: a
                },
                success: function(t) {
                    if (1 == s) var a = {}; else a = r.data.goods;
                    var e = app.cart_get();
                    for (var o in t.data) {
                        var n = t.data[o].id;
                        a[n] = t.data[o], a[n].num = e.goodses[n] ? e.goodses[n].num : 0;
                    }
                    r.setData({
                        goods: a
                    }), t.data.length < 10 && r.setData({
                        hasMore: !1
                    });
                }
            });
        });
    }
});