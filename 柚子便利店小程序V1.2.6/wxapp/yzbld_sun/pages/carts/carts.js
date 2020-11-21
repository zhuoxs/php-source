var _request = require("../../util/request.js"), _request2 = _interopRequireDefault(_request), _cart = require("../../util/cart.js"), _cart2 = _interopRequireDefault(_cart);

function _interopRequireDefault(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}

Page({
    data: {
        navTile: "购物车",
        carts: [],
        totalPrice: 0,
        fullPrice: "0",
        distribution: "0",
        dis_amount_limit: 0,
        remain: 0,
        isIpx: getApp().globalData.isIpx,
        cartCount: 0
    },
    onLoad: function(t) {
        var e = this, a = this;
        wx.setNavigationBarTitle({
            title: a.data.navTile
        });
        var i = _cart2.default.getStoreId();
        _request2.default.get("getCartInfo", {
            store_id: i
        }).then(function(t) {
            console.log(t), a.setData({
                fullPrice: parseFloat(t.fullPrice),
                distribution: parseFloat(t.distribution),
                dis_amount_limit: parseFloat(t.dis_amount_limit)
            }), e.update();
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    update: function() {
        this.setData({
            carts: _cart2.default.get(),
            cartCount: _cart2.default.getAllNum()
        });
        var t = _cart2.default.totalPrice(), e = new Number(this.data.fullPrice - t).toFixed(2);
        console.log("totalPrice:" + t), console.log("remain:" + e), this.setData({
            totalPrice: t,
            remain: e
        });
    },
    addCart: function(t) {
        _cart2.default.add(t) ? (_cart2.default.showSuccess(), this.update()) : _cart2.default.showFail();
    },
    add: function(t) {
        var e = this, a = t.currentTarget.dataset.index, i = this.data.carts[a];
        if (0 < i.goods_type) {
            var o = {};
            o.store_id = _cart2.default.getStoreId(), o.goods_id = i.id, o.activity_id = i.activity_id, 
            o.activity_type = i.goods_type, o.activity_goods_id = i.activity_goods_id, o.cartCount = i.num, 
            console.log(o), _request2.default.get("isValidCart", o).then(function(t) {
                console.log(t), t.is_enable ? e.addCart(i) : wx.showToast({
                    title: t.msg,
                    icon: "none",
                    duration: 2e3
                });
            });
        } else e.addCart(i);
    },
    reduce: function(t) {
        var e = this, a = t.currentTarget.dataset.index, i = _cart2.default.dec(this.data.carts[a], 1);
        1 == i ? e.update() : -1 == i ? wx.showModal({
            title: "提示",
            content: "确定删除该商品吗",
            showCancel: !0,
            success: function(t) {
                t.confirm ? (t = _cart2.default.dec(e.data.carts[a], 1, !0)) ? e.update() : _cart2.default.showFail() : t.cancel;
            }
        }) : _cart2.default.showFail();
    },
    empty: function(t) {
        _cart2.default.clear(), this.update();
    },
    toCforder: function(t) {
        wx.navigateTo({
            url: "../index/cforder/cforder"
        });
    },
    toClassify: function(t) {
        console.log("toClassify"), wx.reLaunch({
            url: "/yzbld_sun/pages/classify/classify",
            success: function(t) {
                console.log(t);
            },
            fail: function(t) {
                console.log(t);
            }
        });
    }
});