var e = getApp(), t = e.requirejs("core"), r = e.requirejs("foxui");

Page({
    data: {
        icons: e.requirejs("icons"),
        success: !1,
        successData: {},
        coupon: !1,
        show: !0
    },
    onLoad: function(e) {
        this.setData({
            options: e
        });
    },
    onShow: function() {
        this.get_list();
    },
    get_list: function() {
        var e = this;
        this.setData({
            order_id: e.data.options.order_id
        }), t.post("membercard.order.pay", {
            order_id: e.data.options.order_id
        }, function(r) {
            console.error(r), 1 == r.error && t.alert(r.message), e.setData({
                wechat: r.wechat,
                credit: r.credit,
                order: r.order,
                show: !0
            });
        });
    },
    pay: function(e) {
        var r = t.pdata(e).type, o = this, a = this.data.wechat;
        "wechat" == r ? t.pay(a.payinfo, function(e) {
            "requestPayment:ok" == e.errMsg && o.complete(r);
        }) : "credit" == r ? t.confirm("确认要支付吗?", function() {
            o.complete(r);
        }, function() {}) : o.complete(r);
    },
    complete: function(e) {
        var o = this;
        t.post("membercard/order/complete", {
            id: o.data.order.id,
            type: e
        }, function(e) {
            0 == e.error ? (0 == e.error && (wx.setNavigationBarTitle({
                title: "支付成功"
            }), o.setData({
                success: !0,
                pay_type: e.type,
                pay_fee: e.fee,
                orderno: e.orderno,
                pay_msg: e.msg
            })), r.toast(o, e.msg), setTimeout(function() {
                wx.reLaunch({
                    url: "/pages/member/membercard/index?cate=my"
                });
            }, 500)) : r.toast(o, e.message);
        }, !0, !0);
    }
});