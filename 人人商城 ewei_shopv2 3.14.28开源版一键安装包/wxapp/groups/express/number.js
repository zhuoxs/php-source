var e = getApp(), s = e.requirejs("core");

e.requirejs("foxui"), e.requirejs("jquery");

Page({
    data: {
        express: "",
        expresscom: "",
        expresssn: "",
        orderid: ""
    },
    onLoad: function(e) {
        var r = this;
        s.post("groups.refund", {
            orderid: e.orderid
        }, function(t) {
            0 == t.error ? (t.show = !0, r.setData(t), r.setData({
                options: e
            })) : s.toast(t.message, "loading");
        });
    },
    inputPrickChange: function(e) {
        var s = this, r = s.data.express_list, t = e.detail.value, a = r[t].name, o = r[t].express;
        s.setData({
            expresscom: a,
            express: o,
            index: t
        });
    },
    inputChange: function(e) {
        var s = e.detail.value;
        this.setData({
            expresssn: s
        });
    },
    back: function() {
        wx.navigateBack();
    },
    submit: function(e) {
        var r = this, t = r.data.expresssn, a = (r.data.options.refundid, r.data.options.orderid);
        if ("" != t) {
            var o = {
                express: r.data.express,
                expresscom: r.data.expresscom,
                expresssn: t,
                orderid: a
            };
            s.post("groups.refund.express", o, function(e) {
                0 == e.error ? wx.navigateBack() : wx.showToast({
                    title: e.error,
                    icon: "none",
                    duration: 2e3
                });
            }, !0);
        } else wx.showToast({
            title: "请填写快递单号",
            icon: "none",
            duration: 2e3
        });
    }
});