var app = getApp();

Page({
    data: {
        navTile: "扫码购物篮",
        shopName: "柚子商店（杏林湾店）",
        cart: {},
        isIpx: app.globalData.isIpx
    },
    onLoad: function(t) {
        var a = this;
        wx.setNavigationBarTitle({
            title: a.data.navTile
        }), app.get_imgroot().then(function(t) {
            a.setData({
                imgroot: t
            });
        });
    },
    onReady: function() {},
    onShow: function() {
        var o = this;
        app.get_store_info().then(function(t) {
            var a = app.offline_cart_get();
            o.setData({
                cart: a,
                shopName: t.name
            });
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    add: function(t) {
        var a = t.currentTarget.dataset.id, o = this.data.cart.goodses[a], e = app.offline_cart_add(o);
        this.setData({
            cart: e
        });
    },
    reduce: function(t) {
        var a = t.currentTarget.dataset.id, o = app.offline_cart_reduce(a);
        this.setData({
            cart: o
        });
    },
    toGoods: function(t) {
        var a = t.currentTarget.dataset.id;
        wx.navigateTo({
            url: "../../index/goods/goods?id=" + a
        });
    },
    toCforder: function(t) {
        0 < this.data.cart.amount && wx.navigateTo({
            url: "../cforder2/cforder2"
        });
    },
    toScan: function(t) {
        var o = this;
        wx.scanCode({
            success: function(t) {
                var a = t.result;
                app.get_store_info().then(function(t) {
                    app.util.request({
                        url: "entry/wxapp/GetGoodsByBarcode",
                        cachetime: "0",
                        data: {
                            barcode: a,
                            store_id: t.id
                        },
                        success: function(t) {
                            if (t.data.id) {
                                var a = app.offline_cart_add(t.data);
                                o.setData({
                                    cart: a
                                });
                            } else wx.showModal({
                                title: "没有找到该商品",
                                content: ""
                            });
                        }
                    });
                });
            }
        });
    }
});