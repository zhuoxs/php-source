var e = new getApp(), t = e.siteInfo.uniacid;

Page({
    data: {
        isShow: !1,
        express: [ "圆通快递", "顺丰快递", "中通快递", "韵达快递", "百世汇通", "菜鸟裹裹", "申通快递", "EMS", "天天快递", "宅急送", "邮政包裹" ],
        expressName: "",
        send_number: "",
        borderImg: "../../../../images/icon/address-line.png",
        orderData: [],
        type: 1,
        farmSetData: []
    },
    onLoad: function(a) {
        e.util.setNavColor(t);
        var r = a.orderid, n = a.type;
        this.getOrderDetail(r, n), this.setData({
            farmSetData: wx.getStorageSync("kundian_farm_setData")
        });
    },
    getOrderDetail: function(a, r) {
        var n = this;
        wx.showLoading({
            title: "玩命加载中..."
        }), e.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "manager",
                op: "getOrderDetail",
                orderid: a,
                uniacid: t,
                type: r
            },
            success: function(e) {
                n.setData({
                    orderData: e.data.orderData,
                    type: r
                }), wx.hideLoading();
            }
        });
    },
    preventTouchMove: function() {},
    fahuo: function() {
        this.setData({
            isShow: !this.data.isShow
        });
    },
    closeModel: function() {
        this.setData({
            isShow: !1
        });
    },
    bindPickerChange: function(e) {
        var t = e.detail.value;
        this.setData({
            expressName: this.data.express[t]
        });
    },
    scanCode: function() {
        var e = this;
        wx.scanCode({
            success: function(t) {
                e.setData({
                    send_number: t.result
                });
            }
        });
    },
    sendRequest: function(t, a, r) {
        var n = this;
        wx.showModal({
            title: "提示",
            content: t,
            success: function(t) {
                t.confirm && e.util.request({
                    url: "entry/wxapp/class",
                    data: a,
                    success: function(e) {
                        wx.showModal({
                            title: "提示",
                            content: e.data.msg,
                            success: function() {
                                n.getOrderDetail(a.orderid, n.data.type);
                            }
                        });
                    }
                });
            }
        });
    },
    sendOrder: function(e) {
        var a = this.data, r = a.orderData, n = a.expressName, s = a.send_number, i = a.type;
        "" == s && (s = e.detail.value.send_number);
        var d = {
            control: "manager",
            op: "sureSend",
            uniacid: t,
            orderid: r.id,
            express_company: n,
            send_number: s,
            type: i
        };
        this.sendRequest("确认发货吗？", d, 2);
    },
    cancelOrder: function(e) {
        var a = this, r = e.currentTarget.dataset.orderid, n = a.data, s = n.type;
        n.orderData;
        if (1 == s) {
            var i = {
                control: "manager",
                op: "cancelOrder",
                uniacid: t,
                orderid: r,
                type: s
            };
            this.sendRequest("确认取消订单吗？", i, 1);
        }
        if (2 == s) {
            var d = {
                control: "manager",
                op: "cancelGroupOrder",
                uniacid: t,
                orderid: r,
                type: s
            };
            this.sendRequest("确认取消订单吗？", d, 1);
        }
        if (3 == s) {
            var o = {
                control: "manager",
                op: "cancelIntrgralOrder",
                uniacid: t,
                orderid: r,
                type: s
            };
            this.sendRequest("确认取消订单吗？", o, 1);
        }
    }
});