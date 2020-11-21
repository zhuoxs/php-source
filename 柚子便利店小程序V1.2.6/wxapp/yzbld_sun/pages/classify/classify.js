var _request = require("../../util/request.js"), _request2 = _interopRequireDefault(_request), _cart = require("../../util/cart.js"), _cart2 = _interopRequireDefault(_cart);

function _interopRequireDefault(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}

Page({
    data: {
        navTile: "分类",
        curMinIndex: "-1",
        curIndex: "0",
        show: !1,
        cartCount: 0
    },
    onLoad: function(t) {
        var a = this, e = this;
        wx.setNavigationBarTitle({
            title: e.data.navTile
        });
        var s = t.id || 0;
        e = this;
        _request2.default.get("getGoodsClass").then(function(t) {
            console.log(t), e.setData({
                classify: t,
                curIndex: s,
                curMinIndex: -1
            }), e.update(), a.updateCart();
        });
    },
    onReady: function() {},
    onShow: function() {},
    updateCart: function() {
        this.setData({
            cartCount: _cart2.default.getAllNum()
        });
    },
    getGoodsFromClass: function(t) {
        console.log("class_id:" + t);
        var s = this, a = this.data.curIndex;
        -1 == this.data.curMinIndex ? t = this.data.classify[a].id : t = this.data.classify[a].group[this.data.curMinIndex].id;
        _request2.default.get("getGoodsList", {
            store_id: _cart2.default.getStoreId(),
            class_id: t
        }).then(function(t) {
            console.log(t);
            for (var a = {}, e = 0; e < t.length; ++e) a.id = t[e].id, t[e].num = _cart2.default.getNum(a);
            s.setData({
                goods: t
            });
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    update: function() {
        this.getGoodsFromClass();
    },
    curNav: function(t) {
        var a = t.currentTarget.dataset.index;
        this.setData({
            curIndex: a,
            curMinIndex: -1
        }), this.update();
    },
    curMinNav: function(t) {
        var a = t.currentTarget.dataset.index;
        this.setData({
            curMinIndex: a
        }), this.update();
    },
    show: function(t) {
        var a = t.currentTarget.dataset.statu;
        this.setData({
            show: !a
        });
    },
    add: function(t) {
        var a = t.currentTarget.dataset.index, e = this.data.goods[a], s = {};
        if (s.id = e.id, s.price = e.price, s.src = e.src, s.name = e.name, s.num = 1, s.store_goods_id = e.store_goods_id, 
        _cart2.default.add(s)) {
            _cart2.default.showSuccess();
            var o = this.data.goods;
            o[a].num++, this.setData({
                goods: o
            }), this.updateCart();
        } else _cart2.default.showFail();
    },
    reduce: function(t) {
        var e = this, s = t.currentTarget.dataset.index, a = this.data.goods[s], o = {};
        o.id = a.id;
        var n = _cart2.default.dec(o, 1);
        if (console.log(n), 1 == n) {
            var i = this.data.goods;
            i[s].num--, e.setData({
                goods: i
            }), e.updateCart();
        } else -1 == n ? wx.showModal({
            title: "提示",
            content: "确定删除该商品吗",
            showCancel: !0,
            success: function(t) {
                if (t.confirm) if (t = _cart2.default.dec(o, 1, !0)) {
                    var a = e.data.goods;
                    a[s].num--, e.setData({
                        goods: a
                    }), e.updateCart();
                } else _cart2.default.showFail(); else t.cancel;
            }
        }) : _cart2.default.showFail();
    },
    toGoods: function(t) {
        wx.navigateTo({
            url: "../index/goods/goods?id=" + t.currentTarget.id
        });
    },
    toSearch: function(t) {
        wx.navigateTo({
            url: "search/search"
        });
    }
});