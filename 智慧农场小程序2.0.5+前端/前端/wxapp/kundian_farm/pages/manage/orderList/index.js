var e = new getApp(), t = e.siteInfo.uniacid;

Page({
    data: {
        status: 0,
        page: 1,
        is_show_send: 1,
        orderid: "",
        express_company: "",
        send_number: "",
        type: 1,
        config: [],
        isContent: !0
    },
    onLoad: function(a) {
        e.util.setNavColor(t);
        var r = a.type;
        this.setData({
            type: r,
            config: wx.getStorageSync("kundian_farm_setData")
        }), this.getOrder(this, t, r);
    },
    changeIndex: function(e) {
        this.setData({
            status: e.currentTarget.dataset.index
        });
        var a = this;
        a.getOrder(a, t, a.data.type);
    },
    showSend: function(e) {
        var t = e.currentTarget.dataset.orderid;
        this.setData({
            orderid: t,
            is_show_send: 2
        });
    },
    hideSend: function(e) {
        this.setData({
            is_show_send: 1
        });
    },
    scan: function(e) {
        var t = this;
        wx.scanCode({
            success: function(e) {
                t.setData({
                    send_number: e.result
                });
            }
        });
    },
    getOrder: function(t, a, r) {
        wx.showLoading({
            title: "玩命加载中...."
        });
        var n = this.data, s = n.isContent, d = n.status;
        e.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "manager",
                op: "order_list",
                uniacid: a,
                current: d,
                type: r
            },
            success: function(e) {
                var a = e.data.orderData;
                s = a.length > 0, t.setData({
                    orderData: a,
                    page: 1,
                    isContent: s
                }), wx.hideLoading();
            }
        });
    },
    onReachBottom: function(a) {
        var r = this, n = r.data, s = n.page, d = n.orderData, i = n.type;
        e.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "manager",
                op: "order_list",
                uniacid: t,
                current: r.data.status,
                page: s,
                type: i
            },
            success: function(e) {
                e.data.orderData && e.data.orderData.map(function(e) {
                    d.push(e);
                }), r.setData({
                    orderData: d,
                    page: parseInt(s) + 1
                });
            }
        });
    },
    intoOrderDetail: function(e) {
        var t = e.currentTarget.dataset, a = t.orderid, r = (t.status, this.data.type);
        wx.navigateTo({
            url: "../orderState/index?orderid=" + a + "&type=" + r
        });
    },
    sendRequest: function(a, r, n) {
        var s = this;
        wx.showModal({
            title: "提示",
            content: a,
            success: function(a) {
                a.confirm && e.util.request({
                    url: "entry/wxapp/class",
                    data: r,
                    success: function(e) {
                        0 != e.data.code ? wx.showToast({
                            title: e.data.msg
                        }) : wx.showModal({
                            title: "提示",
                            content: e.data.msg,
                            confirmText: "朕知道了",
                            showCancel: !1,
                            success: function() {
                                s.getOrder(s, t, s.data.type), 2 == n && s.setData({
                                    is_show_send: 1,
                                    send_number: ""
                                });
                            }
                        });
                    }
                });
            }
        });
    },
    cancelOrder: function(e) {
        var a = e.currentTarget.dataset.orderid, r = this.data.type, n = {
            control: "manager",
            op: "cancelOrder",
            uniacid: t,
            orderid: a,
            type: r
        };
        this.sendRequest("确认取消该订单吗？", n, 1);
    },
    sureSend: function(e) {
        var a = this.data, r = a.orderid, n = a.send_number, s = a.type, d = e.detail.value.express_company;
        "" == n && (n = e.detail.value.send_number);
        var i = {
            control: "manager",
            op: "sureSend",
            uniacid: t,
            orderid: r,
            express_company: d,
            send_number: n,
            type: s
        };
        this.sendRequest("确认发货吗？", i, 2);
    },
    deleteOrder: function(e) {
        var a = this.data.type, r = {
            control: "manager",
            op: "deleteOrder",
            orderid: e.currentTarget.dataset.orderid,
            uniacid: t,
            type: a
        };
        this.sendRequest("确认删除该订单吗？删除后将不可找回！", r, 3);
    },
    refundOrder: function(e) {
        var a = e.currentTarget.dataset.orderid, r = this.data.type, n = {
            control: "manager",
            op: "refundOrder",
            uniacid: t,
            orderid: a,
            type: r
        };
        this.sendRequest("确定对该订单进行退款操作吗？", n, 4);
    },
    verifyOrder: function(e) {
        var a = e.currentTarget.dataset.orderid, r = {
            control: "manager",
            op: "verifyOrder",
            uniacid: t,
            orderid: a
        };
        this.sendRequest("确定核销该订单吗？", r, 5);
    }
});