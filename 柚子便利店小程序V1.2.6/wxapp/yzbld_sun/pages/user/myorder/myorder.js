var _request = require("../../../util/request.js"), _request2 = _interopRequireDefault(_request), _pay = require("../../../util/pay.js"), _pay2 = _interopRequireDefault(_pay);

function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

Page({
    data: {
        navTile: "我的订单",
        curIndex: -1,
        nav: [ "全部", "待付款", "待发货", "已完成" ],
        choose: [ {
            name: "微信",
            enable: !0,
            value: "微信支付",
            icon: "../../../../style/images/wx.png"
        }, {
            name: "余额",
            enable: !0,
            value: "余额支付",
            icon: "../../../../style/images/local.png"
        } ],
        curprice: 0,
        payStatus: !1,
        current: [],
        user_amount: 0,
        order_sn: ""
    },
    onLoad: function(e) {
        var t = this;
        wx.setNavigationBarTitle({
            title: t.data.navTile
        });
        var a = e.index || 0;
        a = parseInt(a), _request2.default.get("getOrderList").then(function(e) {
            console.log(e), t.setData({
                all: e.orders,
                user_amount: e.user_amount
            }), t.switchTab(e.orders, a);
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    dialog: function(e) {
        var t = e.currentTarget.dataset.phone;
        wx.makePhoneCall({
            phoneNumber: t
        });
    },
    powerDrawer: function(e) {
        this.setData({
            payStatus: !this.data.payStatus
        });
    },
    bargainTap: function(e) {
        var t = parseInt(e.currentTarget.dataset.index);
        this.switchTab(this.data.all, t);
    },
    switchTab: function(e, t) {
        if (0 == t) this.setData({
            current: e,
            curIndex: 0
        }); else {
            for (var a = [ 0, 10, 20, 40 ][t], n = e, o = [], r = 0; r < n.length; ++r) n[r].status == a && o.push(n[r]);
            this.setData({
                current: o,
                curIndex: t
            }), console.log("curIndex:" + this.data.curIndex);
        }
    },
    toCancel: function(e) {
        var t = this, a = e.currentTarget.dataset.sn;
        console.log(a), wx.showModal({
            title: "提示",
            content: "确定取消该订单吗？",
            success: function(e) {
                e.confirm ? (console.log("用户点击确定"), _request2.default.post("changeOrderStatus", {
                    order_sn: a,
                    status: 50
                }).then(function(e) {
                    console.log(e), t.setData({
                        all: e.orders,
                        user_amount: e.user_amount
                    }), t.switchTab(e.orders, t.data.curIndex);
                })) : e.cancel && console.log("用户点击取消");
            }
        });
    },
    toFinish: function(e) {
        var t = this, a = this, n = e.currentTarget.dataset.sn;
        console.log(n), _request2.default.post("changeOrderStatus", {
            order_sn: n,
            status: 40
        }).then(function(e) {
            console.log(e), a.setData({
                all: e.orders,
                user_amount: e.user_amount
            }), a.switchTab(e.orders, t.data.curIndex);
        });
    },
    toPay: function(e, t, a) {
        console.log(e), _request2.default.post("payOrder", {
            order_sn: e,
            pay_type: t,
            form_id: a
        }).then(function(e) {
            console.log(e), 1 == e.payed || 0 == e.payed && 1 == e.pay_type ? wx.redirectTo({
                url: "../myorder/myorder"
            }) : _pay2.default.pay(e.sn).then(function(e) {
                console.log("pay success!"), wx.redirectTo({
                    url: "../myorder/myorder"
                });
            }, function(e) {
                console.log("pay fail!");
            });
        });
    },
    toComment: function(e) {
        wx.navigateTo({
            url: "../comment/comment"
        });
    },
    showPay: function(e) {
        var t = e.currentTarget.dataset.statu, a = e.currentTarget.dataset.sn, n = e.currentTarget.dataset.amount, o = this.data.choose;
        parseFloat(n) > parseFloat(this.data.user_amount) ? o[1].enable = !1 : o[1].enable = !0, 
        console.log(o);
        this.setData({
            payStatus: t,
            curprice: n,
            order_sn: a,
            choose: o
        });
    },
    radioChange: function(e) {
        var t = e.detail.value;
        console.log(t), this.setData({
            payType: t
        });
    },
    toDel: function(e) {
        var t = this, a = e.currentTarget.dataset.sn;
        wx.showModal({
            title: "提示",
            content: "订单删除后将不再显示",
            success: function(e) {
                e.confirm ? (console.log("用户点击确定"), _request2.default.post("changeOrderStatus", {
                    order_sn: a,
                    status: -10
                }).then(function(e) {
                    console.log(e), t.setData({
                        all: e.orders,
                        user_amount: e.user_amount
                    }), t.switchTab(e.orders, t.data.curIndex);
                })) : e.cancel && console.log("用户点击取消");
            }
        });
    },
    formSubmit: function(e) {
        var t = this.data.payType;
        if (null != t) {
            var a = "微信" == t ? 0 : 1, n = e.detail.formId;
            this.toPay(this.data.order_sn, a, n);
        } else wx.showToast({
            title: "请选择支付方式",
            icon: "none"
        });
    },
    toMyorderdet: function(e) {
        var t = e.currentTarget.dataset.sn;
        console.log(t), wx.navigateTo({
            url: "/yzbld_sun/pages/user/myorderdet/myorderdet?sn=" + t
        });
    }
});