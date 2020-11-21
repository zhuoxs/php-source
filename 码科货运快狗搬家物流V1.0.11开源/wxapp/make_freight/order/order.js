var _home = require("../../modules/home"), homeModule = new _home.home(), app = getApp();

Page({
    data: {
        swiper_tap: 0,
        fahuo: {},
        shouhou: {},
        goods: {},
        distance: 0,
        price: 0,
        remark: "",
        coupon_id: 0,
        coupon_money: 0,
        loading: !1
    },
    onLoad: function(e) {
        this.init(e);
    },
    onReady: function() {
        app.setNavigation();
    },
    onShow: function() {
        this.isCoupons();
    },
    noUseCoupon: function() {
        wx.removeStorageSync("coupon"), this.isCoupons();
    },
    isCoupons: function() {
        var e = wx.getStorageSync("coupon"), o = this.data.price, t = 0, a = 0;
        e ? ((o = this.data.price - 1 * e.price) < 0 && (o = 0), t = e.id, a = e.price, 
        this.setData({
            coupon: e,
            real_price: o,
            coupon_money: a,
            coupon_id: t
        })) : this.setData({
            coupon: e,
            real_price: o,
            coupon_money: a,
            coupon_id: t
        });
    },
    init: function(e) {
        var o = wx.getStorageSync("time");
        o || (o = "立即取货"), this.setData({
            swiper_tap: e.swiper_tap,
            fahuo: wx.getStorageSync("fahuo"),
            shouhuo: wx.getStorageSync("shouhuo"),
            goods: wx.getStorageSync("goods"),
            time: o,
            distance: e.distance,
            price: e.price,
            real_price: e.price,
            name: e.name,
            volume: e.volume
        });
    },
    remark: function(e) {
        this.setData({
            remark: e.detail.value
        });
    },
    bindCoupon: function() {
        wx.navigateTo({
            url: "../coupon/coupon?use=1&price=" + this.data.price
        });
    },
    confirm: function(e) {
        var t = this;
        app.saveFromId(e.detail.formId), this.setData({
            loading: !0
        });
        var o = this.data.fahuo, a = this.data.shouhuo, n = this.data.goods;
        homeModule.postOrder({
            place_dispatch: o.title,
            start_lot: o.location.lng,
            start_lat: o.location.lat,
            shipper_name: o.person.name,
            shipper_phone: o.person.phone,
            place_receipt: a.title,
            consignee: a.person.name,
            consignee_phone: a.person.phone,
            end_lot: a.location.lng,
            end_lat: a.location.lat,
            price: this.data.price,
            real_price: this.data.price,
            distance: this.data.distance,
            car_id: n.id,
            place_dispatch_detail: o.address + "(" + o.person.des + ")",
            place_receipt_detail: a.address + "(" + a.person.des + ")",
            remark: this.data.remark,
            appointment_time: this.data.time,
            user_coupon_id: this.data.coupon_id,
            type: this.data.swiper_tap,
            goods_name: this.data.name,
            bulk: this.data.volume
        }).then(function(o) {
            1 != t.data.swiper_tap ? t.pay(o) : app.delayHint("跨城单不需要线上支付~").then(function(e) {
                t.setData({
                    loading: !1
                }), wx.redirectTo({
                    url: "../order_detail/order_detail?id=" + o.order_id
                });
            }, function(e) {});
        }, function(e) {
            t.setData({
                loading: !1
            });
        });
    },
    pay: function(o) {
        var t = this;
        homeModule.pay({
            id: o.order_id,
            order_number: o.order_num
        }).then(function(e) {
            homeModule.confirmPayRequest(e).then(function(e) {
                t.setData({
                    loading: !1
                }), wx.redirectTo({
                    url: "../order_detail/order_detail?id=" + o.order_id
                });
            }, function(e) {
                t.setData({
                    loading: !1
                });
            });
        }, function(e) {
            t.setData({
                loading: !1
            });
        });
    },
    onHide: function() {},
    onUnload: function() {
        wx.removeStorageSync("coupon");
    },
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {
        return app.userShare();
    }
});