var e = require("../../../utils/base.js"), t = require("../../../../api.js"), s = new e.Base();

Page({
    data: {
        address_index: 0,
        address_list: []
    },
    onLoad: function(e) {
        this.setData({
            options: e
        });
        var t = "";
        "" != e.attr_id_list && (t = e.attr_id_list.split(","), e.attr_id_list = t), this.getRefund(e);
    },
    bindPickerChange: function(e) {
        this.setData({
            address_index: e.detail.value
        });
    },
    getRefund: function(e) {
        var a = this, d = {
            url: t.mobile.mobile_refund_detail,
            data: {
                orderId: e.orderId,
                productId: e.productId,
                attr_id_list: e.attr_id_list
            }
        };
        s.getData(d, function(e) {
            console.log(e), 1 == e.errorCode && (a.setData({
                refund: e.data,
                address_list: e.data.address_list,
                user_send_express: e.data.user_send_express,
                user_send_express_no: e.data.user_send_express_no
            }), a.express(e.data.user_send_express, e.data.user_send_express_no));
        });
    },
    express: function(e, a) {
        var d = this, n = {
            url: t.default.express,
            data: {
                expressName: e,
                expressNumber: a
            }
        };
        console.log(n), s.getData(n, function(e) {
            console.log(e), 0 == e.code ? d.setData({
                expressInfo: e.data
            }) : d.setData({
                expressMsg: e.msg
            });
        });
    },
    openImg: function(e) {
        var t = e.currentTarget.dataset.index, s = this.data.refund.image;
        wx.previewImage({
            current: s[t],
            urls: s
        });
    },
    refuseRefund: function(e) {
        var a = this, d = {
            url: t.mobile.mobile_refuse_refund,
            data: {
                refundId: this.data.refund.id
            },
            method: "GET"
        };
        s.getData(d, function(e) {
            1 == e.errorCode ? wx.showModal({
                title: "提示",
                showCancel: !1,
                content: e.msg,
                success: function(e) {
                    a.getRefund(a.data.options);
                }
            }) : wx.showModal({
                title: "提示",
                showCancel: !1,
                content: e.msg,
                success: function(e) {}
            });
        });
    },
    agreeRefund: function(e) {
        var a = this, d = {
            url: t.mobile.mobile_agree_refund,
            data: {
                refundId: this.data.refund.id,
                addressId: this.data.address_list[this.data.address_index].id
            },
            method: "GET"
        };
        s.getData(d, function(e) {
            1 == e.errorCode ? wx.showModal({
                title: "提示",
                showCancel: !1,
                content: e.msg,
                success: function(e) {
                    a.getRefund(a.data.options);
                }
            }) : wx.showModal({
                title: "提示",
                showCancel: !1,
                content: e.msg,
                success: function(e) {}
            });
        });
    },
    payRefund: function(e) {
        var a = this, d = {
            url: t.mobile.mobile_pay_refund,
            data: {
                refundId: this.data.refund.id
            },
            method: "GET"
        };
        s.getData(d, function(e) {
            1 == e.errorCode ? wx.showModal({
                title: "提示",
                showCancel: !1,
                content: e.msg,
                success: function(e) {
                    a.getRefund(a.data.options);
                }
            }) : wx.showModal({
                title: "提示",
                showCancel: !1,
                content: e.msg,
                success: function(e) {}
            });
        });
    }
});