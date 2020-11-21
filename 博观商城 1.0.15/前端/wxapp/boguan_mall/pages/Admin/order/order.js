var e = require("../../../utils/base.js"), t = require("../../../../api.js"), a = require("../../../../siteinfo.js"), r = new e.Base(), i = getApp();

Page({
    data: {
        orderIndex: 0,
        kind: "all",
        page: 1,
        size: 20,
        loadmore: !0,
        orderList: [],
        selectedFlag: [ !1, !1, !1 ]
    },
    onLoad: function(e) {
        i.pageOnLoad(), this.setData({
            orderIndex: e.sindex || 0,
            kind: e.kind || "all"
        });
    },
    onShow: function() {
        this.setData({
            page: 1,
            size: 20,
            orderList: []
        }), this.getOrder(this.data.kind);
    },
    onReachBottom: function() {
        this.setData({
            page: this.data.page + 1
        }), this.data.loadmore && this.getOrder(this.data.kind);
    },
    switch: function(e) {
        var t = e.currentTarget.dataset.index, a = e.currentTarget.dataset.kind;
        this.setData({
            orderIndex: t,
            kind: a,
            page: 1,
            size: 20,
            orderList: []
        }), this.getOrder(a);
    },
    getOrder: function(e) {
        var a = this;
        wx.showLoading({
            title: "请稍后"
        });
        var i = {
            url: t.mobile.mobile_order,
            data: {
                kind: e || this.data.kind,
                page: this.data.page,
                size: this.data.size
            },
            method: "get"
        };
        r.getData(i, function(e) {
            console.log(e);
            var t = a;
            a.data.orderList;
            1 == e.errorCode ? (t.data.orderList.push.apply(t.data.orderList, e.data.data), 
            t.setData({
                orderList: t.data.orderList,
                loadmore: !0
            }), e.data.data.length < t.data.size && t.setData({
                loadmore: !1
            })) : 10001 == e.error_code || 0 == e.error_code && (t.setData({
                loadmore: !1
            }), wx.showModal({
                title: "提示",
                showCancel: !1,
                content: e.msg,
                success: function(e) {
                    wx.reLaunch({
                        url: "../../Tab/index/index"
                    });
                }
            })), wx.hideLoading();
        });
    },
    search: function(e) {
        var t = e.detail.value;
        "" == t ? wx.showToast({
            title: "请输入搜索内容",
            icon: "none"
        }) : wx.navigateTo({
            url: "../order_search/order_search?keyword=" + t
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
                        0 == e.errorCode ? wx.showToast({
                            title: "取消失败",
                            icon: "none",
                            duration: 2e3
                        }) : (a.setData({
                            page: 1,
                            size: 20,
                            orderList: []
                        }), a.getOrder(a.data.kind));
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
                        a.setData({
                            orderIndex: 4,
                            page: 1,
                            size: 20,
                            orderList: []
                        }), a.getOrder("completed");
                    });
                }
            }
        });
    },
    topay: function(e) {
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
                            size: 20,
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
                            wx.redirectTo({
                                url: "../order/order?sindex=2&kind=send"
                            });
                        },
                        fail: function(e) {
                            wx.showToast({
                                title: "支付失败"
                            }), wx.redirectTo({
                                url: "../order/order?sindex=1&kind=wait"
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
    },
    navigatorLink: function(e) {
        i.navClick(e, this);
    }
});