var app = getApp();

Page({
    data: {
        info: "",
        reason1: "",
        reason: "",
        showmodal: !1
    },
    TextArea: function(a) {
        var t = a.detail.value;
        this.setData({
            info: t
        });
    },
    onLoad: function(a) {
        app.look.navbar(this);
        var e = this;
        if (a.id) {
            var t = a.id;
            app.util.request({
                url: "entry/wxapp/my",
                data: {
                    op: "refund",
                    id: t
                },
                success: function(a) {
                    var t = a.data;
                    console.log(t.data.order), t.data.order && e.setData({
                        order: t.data.order
                    }), t.data.refund && e.setData({
                        reason: t.data.refund
                    });
                }
            });
        }
    },
    open: function(a) {
        this.setData({
            showmodal: !0
        });
    },
    colse: function() {
        this.setData({
            showmodal: !1
        });
    },
    radioChange: function(a) {
        console.log("radio发生change事件，携带value值为：", a.detail.value);
        var t = a.detail.value;
        this.setData({
            reason1: t
        });
    },
    myform: function() {
        var a = this.data.order, t = this.data.reason1, e = this.data.info, o = a.id;
        wx.showLoading({
            title: "提交中"
        }), app.util.request({
            url: "entry/wxapp/my",
            data: {
                op: "save_refund",
                id: o,
                info: e,
                reason: t
            },
            success: function(a) {
                wx.hideLoading(), console.log(a), app.util.message({
                    title: a.data.message,
                    redirect: "redirect:../refundDetail2/refundDetail2?id=" + o
                });
            }
        });
    },
    onReady: function() {
        app.look.navbar(this);
    }
});