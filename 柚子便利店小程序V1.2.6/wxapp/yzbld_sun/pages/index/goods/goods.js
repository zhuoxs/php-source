var _request = require("../../../util/request.js"), _request2 = _interopRequireDefault(_request), _cart = require("../../../util/cart"), _cart2 = _interopRequireDefault(_cart);

function _interopRequireDefault(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}

var WxParse = require("../../wxParse/wxParse.js");

Page({
    data: {
        navTile: "",
        indicatorDots: !1,
        autoplay: !1,
        interval: 3e3,
        duration: 800,
        cartsLen: 0
    },
    onLoad: function(t) {
        var e = t.id, s = this;
        s.setData({
            navTile: wx.getStorageSync("storeName")
        }), wx.setNavigationBarTitle({
            title: s.data.navTile
        }), _request2.default.get("getGoodsDetail", {
            goods_id: e,
            store_id: _cart2.default.getStoreId()
        }).then(function(t) {
            console.log(t);
            var e = {};
            e.id = t.id, t.num = _cart2.default.getNum(e);
            var a = _cart2.default.getAllNum();
            s.setData({
                goods: t,
                imgUrls: t.images,
                cartsLen: a
            });
            var o = s.data.goods.content;
            WxParse.wxParse("desc", "html", o, s, 0);
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function(t) {
        return {
            title: this.data.goods.name,
            imageUrl: this.data.goods.src
        };
    },
    update: function() {
        var t = _cart2.default.getAllNum();
        this.setData({
            cartsLen: t
        });
    },
    add: function(t) {
        var e = {}, a = this.data.goods;
        if (e.id = a.id, e.price = a.price, e.src = a.src, e.name = a.name, e.num = 1, e.store_goods_id = a.store_goods_id, 
        _cart2.default.add(e)) {
            _cart2.default.showSuccess();
            var o = this.data.goods;
            o.num++, this.setData({
                goods: o
            });
        } else _cart2.default.showFail();
        this.update();
    },
    reduce: function(t) {
        var a = this, e = (t.currentTarget.dataset.index, this.data.goods), o = {};
        o.id = e.id;
        var s = _cart2.default.dec(o, 1);
        if (console.log(s), 1 == s) {
            var r = this.data.goods;
            r.num--, a.setData({
                goods: r
            }), a.update();
        } else -1 == s ? wx.showModal({
            title: "提示",
            content: "确定删除该商品吗",
            showCancel: !0,
            success: function(t) {
                if (t.confirm) if (t = _cart2.default.dec(o, 1, !0)) {
                    var e = a.data.goods;
                    e.num--, a.setData({
                        goods: e
                    }), a.update();
                } else _cart2.default.showFail(); else t.cancel;
            }
        }) : _cart2.default.showFail();
    },
    toCarts: function(t) {
        wx.navigateTo({
            url: "../../carts/carts"
        });
    }
});