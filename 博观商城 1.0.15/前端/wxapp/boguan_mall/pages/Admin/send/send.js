var e = require("../../../utils/base.js"), t = require("../../../../api.js"), a = (require("../../../../siteinfo.js"), 
new e.Base());

getApp();

Page({
    data: {
        selectedFlag: [ !1, !1, !1 ],
        sendType: 1,
        expressName: "",
        express_no: ""
    },
    onLoad: function(e) {
        this.setData({
            orderId: e.orderId
        }), this.orderDetail(e.orderId);
    },
    orderDetail: function(e) {
        var s = this, r = {
            url: t.default.order_detail,
            data: {
                orderId: e
            }
        };
        a.getData(r, function(e) {
            if (1 == e.errorCode) {
                var t = s.data.sendType;
                t = 2 == e.data.order_type || 3 == e.data.order_type ? 2 : 1, s.setData({
                    orderInfo: e.data,
                    sendType: t,
                    order_type: e.data.order_type
                });
            }
        });
    },
    sendType: function(e) {
        var t = e.currentTarget.dataset.index;
        2 != this.data.order_type && 3 != this.data.order_type || 1 != t ? this.setData({
            sendType: t,
            express_no: "",
            expressName: ""
        }) : wx.showToast({
            title: "同城或自提订单无需物流发货",
            icon: "none",
            duration: 2e3
        });
    },
    send: function(e) {
        var s = {
            url: t.mobile.mobile_delivery,
            data: {
                orderId: this.data.orderId,
                type: this.data.sendType,
                express: this.data.expressName,
                expressNo: this.data.express_no
            }
        };
        a.getData(s, function(e) {
            1 == e.errorCode ? wx.showModal({
                title: "提示",
                showCancel: !1,
                content: e.msg,
                success: function(e) {
                    wx.navigateBack({
                        delta: 1
                    });
                }
            }) : wx.showModal({
                title: "提示",
                showCancel: !1,
                content: e.msg,
                success: function(e) {}
            });
        });
    },
    moreUp: function(e) {
        var t = e.currentTarget.dataset.index;
        this.data.selectedFlag[t] ? this.data.selectedFlag[t] = !1 : this.data.selectedFlag[t] = !0, 
        this.setData({
            selectedFlag: this.data.selectedFlag
        });
    },
    scan: function(e) {
        var t = this;
        wx.scanCode({
            success: function(e) {
                t.setData({
                    express_no: e.result
                });
            }
        });
    },
    getExpressNo: function(e) {
        this.setData({
            express_no: e.detail.value
        });
    }
});