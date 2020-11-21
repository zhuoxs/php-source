var wxbarcode = require("../../../../style/utils/index.js"), app = getApp();

Page({
    data: {
        orderinfo: [],
        url: "",
        navTile: "订单详情",
        statusstr: [ "", "已取消订单", "待支付", "未使用", "待收货", "已完成" ],
        statusstr_ground: [ "", "已取消订单", "待支付", "拼团中", "未使用", "已完成", "待收货" ],
        statusstr_card: [ "待付款", "未使用", "已完成", "待收货" ],
        ordertype: 0,
        showModel: !1,
        oid: 0,
        order_id: 0
    },
    onLoad: function(o) {
        var t = this;
        wx.setNavigationBarTitle({
            title: t.data.navTile
        });
        var e = app.getSiteUrl();
        e ? t.setData({
            url: e
        }) : app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            success: function(o) {
                wx.setStorageSync("url", o.data), e = o.data, t.setData({
                    url: e
                });
            }
        }), wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("System").fontcolor,
            backgroundColor: wx.getStorageSync("System").color,
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
        var a = o.ordertype ? o.ordertype : 0, n = o.order_id;
        app.util.request({
            url: "entry/wxapp/GetOrderDetail",
            cachetime: "30",
            data: {
                order_id: n,
                ordertype: a
            },
            success: function(o) {
                console.log("查看order——id:" + n), console.log(o.data), t.setData({
                    orderinfo: o.data,
                    ordertype: a,
                    order_id: n
                });
            }
        });
        var r = '{ "id": ' + n + ', "ordertype": ' + a + "}";
        wxbarcode.qrcode("qrcode", r, 420, 420);
    },
    toAgreeRefund: function(o) {
        var t = this, e = t.data.order_id, a = t.data.ordertype, n = (o.currentTarget.dataset.f_index, 
        t.data.orderinfo), r = wx.getStorageSync("brand_info");
        wx.showModal({
            title: "提示",
            content: "确认同意退款吗",
            showCancel: !0,
            success: function(o) {
                o.confirm && app.util.request({
                    url: "entry/wxapp/SetBrandOrderStatus",
                    data: {
                        order_id: e,
                        g_order_id: e,
                        bid: r.bid,
                        ordertype: a,
                        refund: 2
                    },
                    success: function(o) {
                        console.log(123456), console.log(o.data), console.log(789456), 2 == o.data ? wx.showToast({
                            title: "退款失败！",
                            icon: "none",
                            duration: 2e3
                        }) : (wx.showToast({
                            title: "退款成功！",
                            icon: "success",
                            duration: 500
                        }), n.isrefund = 2, console.log(n), t.setData({
                            orderinfo: n
                        }));
                    }
                });
            }
        });
    },
    toRefuseRefund: function(o) {
        var t = this, e = t.data.order_id, a = t.data.ordertype, n = (o.currentTarget.dataset.f_index, 
        t.data.orderinfo), r = wx.getStorageSync("brand_info");
        wx.showModal({
            title: "提示",
            content: "确认拒绝退款吗",
            showCancel: !0,
            success: function(o) {
                o.confirm && app.util.request({
                    url: "entry/wxapp/SetBrandOrderStatus",
                    data: {
                        order_id: e,
                        g_order_id: e,
                        bid: r.bid,
                        ordertype: a,
                        refund: 3
                    },
                    success: function(o) {
                        console.log(123456), console.log(o.data), console.log(789456), 2 == o.data ? wx.showToast({
                            title: "拒绝退款失败！",
                            icon: "none",
                            duration: 2e3
                        }) : (wx.showToast({
                            title: "拒绝退款成功！",
                            icon: "success",
                            duration: 500
                        }), n.isrefund = 3, console.log(n), t.setData({
                            orderinfo: n
                        }));
                    }
                });
            },
            fail: function(o) {},
            complete: function(o) {}
        });
    },
    toShip: function(o) {
        var t = this, e = t.data.order_id, a = o.currentTarget.dataset.sincetype, n = t.data.ordertype, r = o.currentTarget.dataset.f_index, i = t.data.orderinfo, d = wx.getStorageSync("brand_info");
        if ("快递" == a) {
            var s = e;
            this.setData({
                showModel: !0,
                oid: s,
                shipindex: r
            });
        } else "送货上门" == a ? wx.showModal({
            title: "提示",
            content: "确认发货吗",
            showCancel: !0,
            success: function(o) {
                o.confirm && app.util.request({
                    url: "entry/wxapp/SetBrandOrderStatus",
                    data: {
                        order_id: e,
                        g_order_id: e,
                        bid: d.bid,
                        ordertype: n,
                        ship: 2
                    },
                    success: function(o) {
                        console.log(123456), console.log(o.data), console.log(789456), 2 == o.data ? wx.showToast({
                            title: "发货失败！",
                            icon: "none",
                            duration: 2e3
                        }) : (wx.showToast({
                            title: "发货成功！",
                            icon: "success",
                            duration: 500
                        }), i.status = 1 == n ? 6 : 3 == n ? 3 : 4, console.log(i), t.setData({
                            orderinfo: i
                        }));
                    }
                });
            },
            fail: function(o) {},
            complete: function(o) {}
        }) : wx.showToast({
            title: "参数错误",
            icon: "none",
            duration: 2e3
        });
    },
    formSubmit: function(o) {
        var t = this, e = (wx.getStorageSync("openid"), o.detail.value.shipname), a = o.detail.value.shipnum, n = o.detail.value.oid, r = (t.data.shipindex, 
        t.data.orderinfo), i = wx.getStorageSync("brand_info"), d = t.data.ordertype;
        return n <= 0 ? (wx.showToast({
            title: "参数错误",
            icon: "none",
            duration: 2e3
        }), !1) : "" == e || "" == a ? (wx.showToast({
            title: "快递名称或快递单号不能为空",
            icon: "none",
            duration: 2e3
        }), !1) : (console.log(n), void app.util.request({
            url: "entry/wxapp/SetBrandOrderStatus",
            data: {
                order_id: n,
                g_order_id: n,
                bid: i.bid,
                shipname: e,
                shipnum: a,
                ordertype: d,
                ship: 1
            },
            success: function(o) {
                console.log(123456), console.log(o.data), console.log(789456), 2 == o.data ? wx.showToast({
                    title: "发货失败！",
                    icon: "none",
                    duration: 2e3
                }) : (wx.showToast({
                    title: "发货成功！",
                    icon: "success",
                    duration: 500
                }), r.status = 1 == d ? 6 : 4, console.log(r), t.setData({
                    orderinfo: r,
                    showModel: !1
                }));
            }
        }));
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});