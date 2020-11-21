var a = getApp(), t = a.requirejs("core"), e = a.requirejs("biz/order");

Page({
    data: {
        code: !1,
        consume: !1,
        store: !1,
        cancel: e.cancelArray,
        cancelindex: 0,
        diyshow: {},
        city_express_state: 0
    },
    onLoad: function(t) {
        this.setData({
            options: t
        }), a.url(t);
    },
    onShow: function() {
        this.get_list();
        var t = this;
        a.getCache("isIpx") ? t.setData({
            isIpx: !0,
            iphonexnavbar: "fui-iphonex-navbar",
            paddingb: "padding-b"
        }) : t.setData({
            isIpx: !1,
            iphonexnavbar: "",
            paddingb: ""
        });
    },
    get_list: function() {
        var a = this;
        t.get("order/detail", a.data.options, function(e) {
            if (e.error > 0 && (5e4 != e.error && t.toast(e.message, "loading"), wx.redirectTo({
                url: "/pages/order/index"
            })), void 0 != e.nogift[0].fullbackgoods) var i = e.nogift[0].fullbackgoods.fullbackratio, o = e.nogift[0].fullbackgoods.maxallfullbackallratio, i = Math.round(i), o = Math.round(o);
            if (0 == e.error) {
                e.show = !0;
                var r = Array.isArray(e.ordervirtual);
                a.setData(e), a.setData({
                    ordervirtualtype: r,
                    fullbackgoods: e.nogift[0].fullbackgoods,
                    maxallfullbackallratio: o,
                    fullbackratio: i,
                    invoice: e.order.invoicename,
                    membercard_info: e.membercard_info
                });
            }
        });
    },
    more: function() {
        this.setData({
            all: !0
        });
    },
    code: function(a) {
        var e = this, i = t.data(a).orderid;
        t.post("verify/qrcode", {
            id: i
        }, function(a) {
            0 == a.error ? e.setData({
                code: !0,
                qrcode: a.url
            }) : t.alert(a.message);
        }, !0);
    },
    diyshow: function(a) {
        var e = this.data.diyshow, i = t.data(a).id;
        e[i] = !e[i], this.setData({
            diyshow: e
        });
    },
    close: function() {
        this.setData({
            code: !1
        });
    },
    toggle: function(a) {
        var e = t.pdata(a), i = e.id, o = e.type, r = {};
        r[o] = 0 == i || void 0 === i ? 1 : 0, this.setData(r);
    },
    phone: function(a) {
        t.phone(a);
    },
    cancel: function(a) {
        e.cancel(this.data.options.id, a.detail.value, "/pages/order/detail/index?id=" + this.data.options.id);
    },
    delete: function(a) {
        var i = t.data(a).type;
        e.delete(this.data.options.id, i, "/pages/order/index");
    },
    finish: function(a) {
        e.finish(this.data.options.id, "/pages/order/index");
    },
    refundcancel: function(a) {
        var t = this;
        e.refundcancel(this.data.options.id, function() {
            t.get_list();
        });
    },
    onShareAppMessage: function() {
        return t.onShareAppMessage();
    }
});