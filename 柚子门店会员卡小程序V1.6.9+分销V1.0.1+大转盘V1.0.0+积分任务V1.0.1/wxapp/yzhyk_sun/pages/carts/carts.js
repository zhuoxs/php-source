var app = getApp();

Page({
    data: {
        navTile: "购物车",
        carts: [],
        totalPrice: 0,
        fullPrice: "100",
        distribution: "3.00",
        isIpx: app.globalData.isIpx,
        count: 144
    },
    onLoad: function(t) {
        var a = this;
        if (wx.setNavigationBarTitle({
            title: a.data.navTile
        }), wx.getStorageSync("tabBar")) {
            var e = wx.getStorageSync("tabBar"), o = getCurrentPages(), i = o[o.length - 1].__route__;
            0 != i.indexOf("/") && (i = "/" + i);
            for (var n = 0; n < e.list.length; n++) e.list[n].active = !1, e.list[n].selectedColor = e.selectedColor, 
            e.list[n].pagePath == i && (e.list[n].active = !0, e.list[n].title && wx.setNavigationBarTitle({
                title: e.list[n].title
            }));
            a.setData({
                tabBar: e
            });
        } else console.log(22), app.editTabBar();
        app.get_setting().then(function(t) {
            a.setData({
                setting: t,
                distribution: t.postage_base,
                fullPrice: t.min_amount
            });
        });
    },
    onReady: function() {},
    onShow: function() {
        var e = this;
        app.get_imgroot().then(function(t) {
            e.setData({
                imgroot: t
            });
            var a = app.cart_get();
            e.setData({
                cart: a
            }), console.log(a);
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    add: function(t) {
        var a = t.currentTarget.dataset.id, e = this.data.cart.goodses[a], o = app.cart_add(e);
        this.setData({
            cart: o
        });
    },
    reduce: function(t) {
        var a = t.currentTarget.dataset.id, e = app.cart_reduce(a);
        this.setData({
            cart: e
        });
    },
    empty: function(t) {
        var e = this;
        wx.showModal({
            title: "提示",
            content: "确定清空商品吗",
            showCancel: !0,
            success: function(t) {
                if (t.confirm) {
                    var a = app.cart_clear();
                    e.setData({
                        cart: a
                    });
                } else t.cancel;
            }
        });
    },
    toCforder: function(t) {
        var e = this, o = e.data.cart;
        app.get_store_info().then(function(t) {
            app.util.request({
                url: "entry/wxapp/CheckStock",
                cachetime: "0",
                method: "post",
                data: {
                    store_id: t.id,
                    goodses: o.goodses
                },
                success: function(t) {
                    if (console.log(t.data.code), 0 == t.data.code) wx.navigateTo({
                        url: "../index/cforder/cforder"
                    }); else {
                        for (var a in t.data.goodses) o.goodses[t.data.goodses[a].id].stock = t.data.goodses[a].limit;
                        e.setData({
                            cart: o
                        });
                    }
                }
            });
        });
    },
    toClassify: function(t) {
        wx.navigateTo({
            url: "../goods/goods"
        });
    }
});