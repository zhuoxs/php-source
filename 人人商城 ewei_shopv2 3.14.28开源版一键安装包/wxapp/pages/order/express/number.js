var e = getApp(), s = e.requirejs("core"), r = e.requirejs("foxui");

e.requirejs("jquery");

Page({
    data: {
        express: "",
        expresscom: "",
        express_number: ""
    },
    onLoad: function(s) {
        this.setData({
            options: s
        }), e.url(s), this.get_list();
    },
    get_list: function() {
        var e = this;
        void 0 === e.data.options.singlerefund ? s.get("order/express_number", e.data.options, function(r) {
            0 == r.error ? (r.show = !0, e.setData(r)) : s.toast(r.message, "loading");
        }) : s.get("order/single_express_number", e.data.options, function(r) {
            0 == r.error ? (r.show = !0, e.setData(r)) : s.toast(r.message, "loading");
        });
    },
    inputPrickChange: function(e) {
        var s = this, r = s.data.express_list, t = e.detail.value, a = r[t].name, i = r[t].express;
        s.setData({
            expresscom: a,
            express: i,
            index: t
        });
    },
    inputChange: function(e) {
        var s = e.detail.value;
        this.setData({
            express_number: s
        });
    },
    back: function() {
        wx.navigateBack();
    },
    submit: function(e) {
        var t = this, a = e.currentTarget.dataset.refund, i = t.data.express_number, a = t.data.options.refundid, n = t.data.options.id;
        if ("" != i) {
            var o = t.data.express, d = t.data.expresscom;
            void 0 === t.data.options.singlerefund ? s.get("order/express_number", {
                submit: 1,
                refundid: a,
                orderid: n,
                express_number: i,
                express: o,
                expresscom: d
            }, function(e) {
                0 == e.error && wx.navigateTo({
                    url: "/pages/order/detail/index?id=" + n
                });
            }) : s.get("order/single_express_number", {
                submit: 1,
                refundid: a,
                orderid: n,
                express_number: i,
                express: o,
                expresscom: d
            }, function(e) {
                0 == e.error && wx.navigateTo({
                    url: "/pages/order/detail/index?id=" + n
                });
            });
        } else r.toast(t, "请填写快递单号");
    }
});