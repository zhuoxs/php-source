var _data, _request = require("../../../util/request.js"), _request2 = _interopRequireDefault(_request);

function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

function _defineProperty(e, t, o) {
    return t in e ? Object.defineProperty(e, t, {
        value: o,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : e[t] = o, e;
}

var wxbarcode = require("../../../../style/utils/index.js"), app = getApp();

Page({
    data: (_data = {
        order: {},
        navTile: "订单详情",
        store: {
            name: "柚子商店",
            phone: "12345678903"
        }
    }, _defineProperty(_data, "order", {
        id: "2",
        sn: "20020180806143940",
        user_id: "1",
        store_id: "1",
        amount: "26.00",
        pay_amount: "26.00",
        pay_type: "1",
        pay_at: "2018-08-06 14:39:40",
        distribution_amount: "5.00",
        is_del: "0",
        status: "20",
        distribution_type: "0",
        address: '{"errMsg":"chooseAddress:ok","userName":"张三","nationalCode":"510000","telNumber":"020-81167888","postalCode":"510000","provinceName":"广东省","cityName":"广州市","countyName":"海珠区","detailInfo":"新港中路397号"}',
        take_time: "",
        take_tel: "",
        latitude: "24.57591000",
        longitude: "118.09728000",
        coupon_id: "0",
        remark: "",
        uniacid: "22",
        created_at: "2018-08-06 14:39:40",
        updated_at: "2018-08-06 14:39:40",
        verify_sn: "153ses4123"
    }), _defineProperty(_data, "paytype", "余额支付"), _defineProperty(_data, "choose", [ {
        name: "微信",
        value: "微信支付",
        icon: "../../../../style/images/wx.png"
    }, {
        name: "余额",
        value: "余额支付",
        icon: "../../../../style/images/local.png"
    } ]), _defineProperty(_data, "payStatus", !1), _defineProperty(_data, "isPay", 0), 
    _defineProperty(_data, "amount", 0), _data),
    onLoad: function(e) {
        var o = this;
        wx.setNavigationBarTitle({
            title: o.data.navTile
        });
        var t = e.sn;
        _request2.default.get("getOrderDetail", {
            order_sn: t
        }).then(function(e) {
            var t = Number(e.order.amount - e.order.distribution_amount).toFixed(2);
            console.log(e), o.setData({
                order: e.order,
                goods: e.goods,
                store: e.store,
                amount: t
            }), wxbarcode.qrcode("qrcode", e.order.verify_sn, 420, 420);
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    deletes: function(e) {
        wx.showModal({
            title: "提示",
            content: "订单删除后不再显示!",
            success: function(e) {
                if (e.confirm) ; else if (e.cancel) return;
            }
        });
    },
    cancel: function(e) {
        this.data.order.id;
        wx.showModal({
            title: "提示",
            content: "确定取消该订单吗？",
            success: function(e) {
                e.confirm || e.cancel && console.log("用户点击取消");
            }
        });
    },
    dialog: function(e) {
        wx.makePhoneCall({
            phoneNumber: this.data.store.phone
        });
    },
    powerDrawer: function(e) {
        this.setData({
            payStatus: !this.data.payStatus
        });
    },
    radioChange: function(e) {
        var t = e.detail.value;
        console.log(t), this.setData({
            payType: t
        });
    },
    formSubmit: function(e) {
        null != this.data.payType || wx.showToast({
            title: "请选择支付方式",
            icon: "none"
        });
    },
    paysuccess: function(e) {},
    receive: function(e) {
        var t = e.target.dataset.sn;
        console.log(e), _request2.default.post("userVerifyOrder", {
            order_sn: t
        }).then(function(e) {
            console.log(e);
        });
    }
});