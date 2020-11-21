var _request = require("../../../util/request.js"), _request2 = _interopRequireDefault(_request), _cart = require("../../../util/cart.js"), _cart2 = _interopRequireDefault(_cart);

function _interopRequireDefault(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}

Page({
    data: {
        navTile: "限时抢购",
        cartsLen: 0,
        activity_id: 0,
        is_loading: !1
    },
    onLoad: function(t) {
        wx.setNavigationBarTitle({
            title: this.data.navTile
        });
    },
    onReady: function() {},
    onShow: function() {
        var o = this;
        _request2.default.get("getLimitTimeActivity", {
            store_id: wx.getStorageSync("storeId")
        }).then(function(t) {
            console.log(t);
            for (var a = t.goods, e = {}, i = 0; i < a.length; ++i) e.goods_type = 1, e.id = a[i].id, 
            a[i].num = _cart2.default.getNum(e);
            o.setData({
                banner: t.banner,
                goods: a,
                activity_id: t.id
            }), o.update();
        });
    },
    update: function() {
        var t = _cart2.default.getAllNum();
        this.setData({
            cartsLen: t
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    addCart: function(t, a) {
        var e = {};
        if (e.id = a.id, e.price = a.price, e.src = a.src, e.name = a.name, e.num = 1, e.goods_type = 1, 
        e.activity_id = this.data.activity_id, e.activity_goods_id = a.activity_goods_id, 
        _cart2.default.add(e)) {
            _cart2.default.showSuccess();
            var i = this.data.goods;
            i[t].num++, this.setData({
                goods: i
            });
        } else _cart2.default.showFail();
        this.update();
    },
    add: function(t) {
        var a = this, e = t.currentTarget.dataset.index, i = (t.currentTarget.dataset.id, 
        this.data.goods[e]);
        if (!this.data.is_loading) {
            var o = {};
            o.store_id = _cart2.default.getStoreId(), o.goods_id = i.id, o.activity_goods_id = i.activity_goods_id, 
            o.activity_id = this.data.activity_id, o.activity_type = 1;
            var d = {};
            d.id = i.id, d.goods_type = 1, o.cartCount = _cart2.default.getNum(d), this.setData({
                is_loading: !0
            }), console.log(o), _request2.default.get("isValidCart", o).then(function(t) {
                console.log(t), t.is_enable ? (a.addCart(e, i), a.setData({
                    is_loading: !1
                })) : (a.setData({
                    is_loading: !1
                }), wx.showToast({
                    title: t.msg,
                    icon: "none",
                    duration: 2e3
                }));
            });
        }
    },
    reduce: function(t) {
        var e = this, i = t.currentTarget.dataset.index, a = this.data.goods[i], o = {};
        o.id = a.id, o.goods_type = 1;
        var d = _cart2.default.dec(o, 1);
        if (console.log(d), 1 == d) {
            var s = this.data.goods;
            s[i].num--, e.setData({
                goods: s
            }), e.update();
        } else -1 == d ? wx.showModal({
            title: "提示",
            content: "确定删除该商品吗",
            showCancel: !0,
            success: function(t) {
                if (t.confirm) if (t = _cart2.default.dec(o, 1, !0)) {
                    var a = e.data.goods;
                    a[i].num--, e.setData({
                        goods: a
                    }), e.update();
                } else _cart2.default.showFail(); else t.cancel;
            }
        }) : _cart2.default.showFail();
    },
    toCarts: function(t) {
        wx.navigateTo({
            url: "../../carts/carts"
        });
    },
    toGoods: function(t) {
        var a = t.currentTarget.dataset.id;
        wx.navigateTo({
            url: "../goods/goods?id=" + a
        });
    }
});