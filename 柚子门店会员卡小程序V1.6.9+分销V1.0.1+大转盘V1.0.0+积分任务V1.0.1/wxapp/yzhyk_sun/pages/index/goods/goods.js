var _slicedToArray = function(t, a) {
    if (Array.isArray(t)) return t;
    if (Symbol.iterator in Object(t)) return function(t, a) {
        var r = [], i = !0, e = !1, n = void 0;
        try {
            for (var o, d = t[Symbol.iterator](); !(i = (o = d.next()).done) && (r.push(o.value), 
            !a || r.length !== a); i = !0) ;
        } catch (t) {
            e = !0, n = t;
        } finally {
            try {
                !i && d.return && d.return();
            } finally {
                if (e) throw n;
            }
        }
        return r;
    }(t, a);
    throw new TypeError("Invalid attempt to destructure non-iterable instance");
}, app = getApp();

Page({
    data: {
        navTile: "商品详情",
        imgUrls: [ "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152385811283.png" ],
        indicatorDots: !1,
        autoplay: !1,
        interval: 3e3,
        duration: 800,
        cartsLen: 0,
        detail: [ "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152428255657.png", "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152428255668.png", "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152428255516.png" ],
        clock: "",
        isIpx: app.globalData.isIpx
    },
    onLoad: function(t) {
        var e = this;
        setInterval(function() {
            e.setData({
                curr: Date.now()
            });
        }, 1e3), wx.setNavigationBarTitle({
            title: e.data.navTile
        });
        var n = app.cart_get();
        e.setData({
            cart: n
        });
        var o = t.id, d = t.activity_id || 0;
        t.d_user_id && app.distribution.distribution_parsent(app, t.d_user_id), Promise.all([ app.api.get_imgroot(), app.api.get_store_info() ]).then(function(t) {
            var a = _slicedToArray(t, 2), i = a[0], r = a[1];
            app.util.request({
                url: "entry/wxapp/GetGoodsById",
                cachetime: "0",
                data: {
                    goods_id: o,
                    store_id: r.id,
                    activity_id: d
                },
                success: function(t) {
                    var a = JSON.parse(t.data.pics);
                    t.data.num = n.goodses[o] ? n.goodses[o].num : 0;
                    var r = t.data.price.split(".");
                    e.setData({
                        imgroot: i,
                        imgUrls: a,
                        goods: t.data,
                        detail: t.data.content,
                        arrPrice: r
                    });
                }
            });
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    toindex: function() {
        wx.reLaunch({
            url: "/yzhyk_sun/pages/index/index"
        });
    },
    onShareAppMessage: function() {
        var t = wx.getStorageSync("users"), a = this.data.goods.id;
        return {
            path: "/yzhyk_sun/pages/index/goods/goods?d_user_id=" + t.id + "&id=" + a
        };
    },
    add: function(t) {
        var a = t.currentTarget.dataset.id, r = this.data.goods, i = app.cart_add(r);
        r.num = i.goodses[a].num, this.setData({
            cart: i,
            goods: r
        });
    },
    appointment: function(t) {
        var a = t.currentTarget.dataset.id;
        wx.navigateTo({
            url: "../cforder4/cforder4?id=" + a
        });
    },
    reduce: function(t) {
        var a = t.currentTarget.dataset.id, r = app.cart_reduce(a), i = this.data.goods;
        i.num = r.goodses[a] ? r.goodses[a].num : 0, this.setData({
            cart: r,
            goods: i
        });
    },
    toCarts: function(t) {
        wx.reLaunch({
            url: "../../carts/carts"
        });
    }
});