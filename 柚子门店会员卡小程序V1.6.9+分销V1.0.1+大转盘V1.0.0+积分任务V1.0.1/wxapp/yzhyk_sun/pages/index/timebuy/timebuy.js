var app = getApp();

Page({
    data: {
        navTile: "限时抢购",
        goods: []
    },
    onLoad: function(t) {
        var a = this;
        setInterval(function() {
            a.setData({
                curr: Date.now()
            });
        }, 1e3), wx.setNavigationBarTitle({
            title: a.data.navTile
        }), app.full_setting();
    },
    onReady: function() {},
    onShow: function() {
        var i = this;
        app.api.get_store_info().then(function(t) {
            app.util.request({
                url: "entry/wxapp/GetActivityGoods",
                cachetime: "0",
                data: {
                    store_id: t.id
                },
                success: function(t) {
                    var a = {}, o = app.cart_get();
                    for (var e in t.data) {
                        var n = t.data[e].id, s = "id_" + n;
                        a[s] = t.data[e], a[s].num = o.goodses[n] ? o.goodses[n].num : 0;
                    }
                    i.setData({
                        goodses: a,
                        cart: o
                    });
                }
            });
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    add: function(t) {
        var a = this, o = t.currentTarget.dataset.id, e = "id_" + o, n = a.data.goodses[e], s = app.cart_add(n), i = a.data.goodses;
        i[e].num = s.goodses[o].num, a.setData({
            cart: s,
            goodses: i
        });
    },
    reduce: function(t) {
        var a = t.currentTarget.dataset.id, o = "id_" + a, e = app.cart_reduce(a), n = this.data.goodses;
        e.goodses[a] ? n[o].num = e.goodses[a].num : n[o].num = 0, this.setData({
            cart: e,
            goodses: n
        });
    },
    toCarts: function(t) {
        wx.reLaunch({
            url: "../../carts/carts"
        });
    },
    toGoods: function(t) {
        var a = t.currentTarget.dataset.id, o = t.currentTarget.dataset.activity_id;
        wx.navigateTo({
            url: "../goods/goods?id=" + a + "&activity_id=" + o
        });
    }
});