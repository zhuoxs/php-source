var e = getApp(), r = e.requirejs("core"), t = e.requirejs("biz/group_order");

Page({
    data: function(e, r, t) {
        return r in e ? Object.defineProperty(e, r, {
            value: t,
            enumerable: !0,
            configurable: !0,
            writable: !0
        }) : e[r] = t, e;
    }({
        code: !1,
        consume: !1,
        store: !1,
        cancel: t.cancelArray,
        cancelindex: 0,
        diyshow: {},
        city_express_state: 0,
        order_id: 0,
        order: [],
        address: []
    }, "cancel", t.cancelArray),
    onLoad: function(e) {
        this.setData({
            order_id: e.order_id
        });
    },
    onShow: function() {
        this.get_list();
        var r = this;
        e.getCache("isIpx") ? r.setData({
            isIpx: !0,
            iphonexnavbar: "fui-iphonex-navbar",
            paddingb: "padding-b"
        }) : r.setData({
            isIpx: !1,
            iphonexnavbar: "",
            paddingb: ""
        });
    },
    get_list: function() {
        var e = this;
        r.get("groups/order/details", {
            orderid: e.data.order_id
        }, function(t) {
            t.error > 0 && (5e4 != t.error && r.toast(t.message, "loading"), wx.redirectTo({
                url: "../order/index"
            })), e.setData({
                show: !0,
                express: t.express,
                order: t.order,
                address: t.address,
                store: t.store,
                verify: t.verify,
                verifynum: t.verifynum,
                verifytotal: t.verifytotal,
                carrier: t.carrier,
                shop_name: t.sysset.shopname,
                goods: t.goods,
                goodRefund: t.goodRefund
            });
        });
    },
    more: function() {
        this.setData({
            all: !0
        });
    },
    code: function(e) {
        var t = this;
        r.post("groups/verify/qrcode", {
            id: t.data.order.id,
            verifycode: t.data.order.verifycode
        }, function(e) {
            0 == e.error ? t.setData({
                code: !0,
                qrcode: e.url
            }) : r.alert(e.message);
        }, !0);
    },
    diyshow: function(e) {
        var t = this.data.diyshow, o = r.data(e).id;
        t[o] = !t[o], this.setData({
            diyshow: t
        });
    },
    close: function() {
        this.setData({
            code: !1
        });
    },
    toggle: function(e) {
        var t = r.pdata(e), o = t.id, a = t.type, i = {};
        i[a] = 0 == o || void 0 === o ? 1 : 0, this.setData(i);
    },
    phone: function(e) {
        r.phone(e);
    },
    finish: function(e) {
        var t = this, o = e.target.dataset.orderid;
        r.confirm("是否确认收货", function() {
            r.get("groups/order/finish", {
                id: o
            }, function(e) {
                0 == e.error ? t.get_list(!0) : r.alert(e.message);
            });
        });
    },
    delete_: function(e) {
        var t = e.target.dataset.orderid;
        r.confirm("是否确认删除", function() {
            r.get("groups/order/delete", {
                id: t
            }, function(e) {
                0 == e.error ? wx.reLaunch({
                    url: "../order/index"
                }) : r.alert(e.message);
            });
        });
    },
    cancel: function(e) {
        var r = this.data.order_id;
        t.cancel(r, e.detail.value, "../order_detail/index?order_id=" + r);
    },
    refundcancel: function(e) {
        r.post("groups.refund.cancel", {
            orderid: this.data.order_id
        }, function(e) {
            0 == e.error ? wx.navigateBack() : wx.showToast({
                title: e.error,
                icon: "none",
                duration: 2e3
            });
        });
    },
    onShareAppMessage: function() {
        return r.onShareAppMessage();
    }
});