var e = require("../../../../utils/base.js"), t = require("../../../../../api.js"), a = require("../../../../../siteinfo.js"), r = new e.Base(), i = getApp();

Page({
    data: {
        selectedFlag: [ !1, !1, !1 ]
    },
    onLoad: function(e) {
        var t = e.keyword;
        this.setData({
            keyword: t
        }), this.getOrder(t);
    },
    getOrder: function(e) {
        var a = this;
        wx.showLoading({
            title: "请稍后",
            mask: !0
        });
        var i = {
            url: t.default.order_search,
            data: {
                keyword: e
            }
        };
        r.getData(i, function(e) {
            a.setData({
                orderList: e.data
            }), wx.hideLoading();
        });
    },
    cancelOrder: function(e) {
        var a = this, i = e.currentTarget.dataset.id;
        wx.showModal({
            title: "是否取消该订单？",
            success: function(e) {
                if (e.confirm) {
                    var d = {
                        url: t.default.order_cancel,
                        data: {
                            orderId: i
                        }
                    };
                    r.getData(d, function(e) {
                        1 == e.errorCode && a.getOrder(a.data.keyword);
                    });
                }
            }
        });
    },
    confirmOrder: function(e) {
        var a = this, i = e.currentTarget.dataset.id;
        wx.showModal({
            title: "是否确认收货",
            success: function(e) {
                if (e.confirm) {
                    var d = {
                        url: t.default.order_confirm,
                        data: {
                            orderId: i
                        }
                    };
                    r.getData(d, function(e) {
                        a.getOrder(a.data.keyword);
                    });
                }
            }
        });
    },
    topay: function(e) {
        wx.showLoading({
            title: "提交中"
        }), setTimeout(function() {
            wx.hideLoading();
        }, 200);
        var r = e.currentTarget.dataset.id, d = this, o = wx.getStorageSync("token") || "";
        o && wx.request({
            url: i.globalData.api_root + t.default.pay_pre_order,
            method: "POST",
            header: {
                token: o,
                uniacid: a.uniacid
            },
            data: {
                id: r
            },
            success: function(e) {
                if (console.log(e), 0 == e.data.errorCode) wx.showModal({
                    title: "提示",
                    content: e.data.msg,
                    showCancel: !1,
                    complete: function(e) {
                        wx.redirectTo({
                            url: "../order/order?sindex=1&kind=wait"
                        }), d.setData({
                            page: 1,
                            size: 10,
                            orderList: []
                        }), d.getOrder("wait");
                    }
                }); else {
                    var t = e.data;
                    wx.requestPayment({
                        timeStamp: t.timeStamp.toString(),
                        nonceStr: t.nonceStr,
                        package: t.package,
                        signType: t.signType,
                        paySign: t.paySign,
                        success: function(e) {
                            d.getOrder(d.data.keyword);
                        },
                        fail: function(e) {
                            wx.showToast({
                                title: "支付失败"
                            });
                        }
                    });
                }
            }
        });
    },
    moreUp: function(e) {
        var t = e.currentTarget.dataset.index;
        this.data.selectedFlag[t] ? this.data.selectedFlag[t] = !1 : this.data.selectedFlag[t] = !0, 
        this.setData({
            selectedFlag: this.data.selectedFlag
        });
    }
});