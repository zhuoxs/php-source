var _request = require("../../../util/request.js"), _request2 = _interopRequireDefault(_request), _cart = require("../../../util/cart.js"), _cart2 = _interopRequireDefault(_cart);

function _interopRequireDefault(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}

Page({
    data: {
        navTile: "每日秒杀",
        skIndex: "0",
        cartsLen: "0",
        secKillActivityId: 0
    },
    onLoad: function(t) {
        var e = this;
        wx.setNavigationBarTitle({
            title: e.data.navTile
        }), _request2.default.get("getSecKillActivity", {
            store_id: wx.getStorageSync("storeId")
        }).then(function(t) {
            console.log(t), e.setData({
                seckill: t.secKill,
                secKillActivityId: t.sec_kill_activity_id,
                skIndex: t.currentIndex
            }), e.update();
        });
    },
    update: function() {
        var t = _cart2.default.getAllNum();
        this.setData({
            cartsLen: t
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    seckill: function(t) {
        var e = t.currentTarget.dataset.index;
        this.setData({
            skIndex: e
        }), console.log(this.data.skIndex);
    },
    addCart: function(t) {
        var e = {};
        e.src = t.src, e.name = t.name, e.goods_type = 2, e.id = t.id, e.price = t.price, 
        _cart2.default.add(e) ? (_cart2.default.showSuccess(), this.update()) : _cart2.default.showFail();
    },
    add: function(t) {
        var e = this, a = t.currentTarget.dataset.index, i = (t.currentTarget.dataset.id, 
        this.data.skIndex), n = this.data.seckill[i].goods[a], o = {};
        o.store_id = _cart2.default.getStoreId(), o.goods_id = n.id, o.activity_id = this.data.secKillActivityId, 
        o.activity_type = 2;
        var s = {};
        s.id = n.id, s.goods_type = 2, o.cartCount = _cart2.default.getNum(s), _request2.default.get("isValidCart", o).then(function(t) {
            console.log(t), t.is_enable ? e.addCart(n) : wx.showToast({
                title: t.msg,
                icon: "none",
                duration: 2e3
            });
        });
    },
    toCarts: function(t) {
        wx.navigateTo({
            url: "../../carts/carts"
        });
    },
    toGoods: function(t) {
        wx.navigateTo({
            url: "../goods/goods"
        });
    }
});