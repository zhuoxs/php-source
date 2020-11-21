var _request = require("../../../util/request.js"), _request2 = _interopRequireDefault(_request), _cart = require("../../../util/cart"), _cart2 = _interopRequireDefault(_cart);

function _interopRequireDefault(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}

Page({
    data: {
        navTile: "商品搜索",
        cartsLen: 0
    },
    onLoad: function(t) {
        wx.setNavigationBarTitle({
            title: this.data.navTile
        });
        var e = t.keyword;
        this.search(e);
    },
    search: function(t) {
        var o = this;
        _request2.default.get("searchGoods", {
            store_id: _cart2.default.getStoreId(),
            keyword: t
        }).then(function(t) {
            console.log(t);
            for (var e = {}, a = 0; a < t.length; ++a) e.id = t[a].id, t[a].num = _cart2.default.getNum(e);
            o.setData({
                goods: t
            }), o.update();
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
        var t = _cart2.default.getAllNum();
        this.setData({
            cartsLen: t
        });
    },
    formSubmit: function(t) {
        var e = t.detail.value.keyword;
        "" == e ? wx.showModal({
            title: "提示",
            showCancel: !1,
            content: "商品名称不得为空"
        }) : this.search(e);
    },
    add: function(t) {
        var e = t.currentTarget.dataset.index, a = this.data.goods[e], o = {};
        if (o.id = a.id, o.price = a.price, o.src = a.src, o.name = a.name, o.num = 1, _cart2.default.add(o)) {
            _cart2.default.showSuccess();
            var n = this.data.goods;
            n[e].num++, this.setData({
                goods: n
            }), this.update();
        } else _cart2.default.showFail();
    },
    reduce: function(t) {
        var a = this, o = t.currentTarget.dataset.index, e = this.data.goods[o], n = {};
        n.id = e.id;
        var r = _cart2.default.dec(n, 1);
        if (console.log(r), 1 == r) {
            var s = this.data.goods;
            s[o].num--, a.setData({
                goods: s
            }), a.update();
        } else -1 == r ? wx.showModal({
            title: "提示",
            content: "确定删除该商品吗",
            showCancel: !0,
            success: function(t) {
                if (t.confirm) if (t = _cart2.default.dec(n, 1, !0)) {
                    var e = a.data.goods;
                    e[o].num--, a.setData({
                        goods: e
                    }), a.update();
                } else _cart2.default.showFail(); else t.cancel;
            }
        }) : _cart2.default.showFail();
    },
    toGoods: function(t) {
        var e = t.currentTarget.dataset.id;
        wx.navigateTo({
            url: "../../index/goods/goods?id=" + e
        });
    },
    toCarts: function(t) {
        wx.navigateTo({
            url: "../../carts/carts"
        });
    }
});