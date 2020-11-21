var e = new getApp(), a = e.siteInfo.uniacid;

Page({
    data: {
        orderData: [],
        orderDetail: [],
        is_check: !1
    },
    onLoad: function(r) {
        var t = this, n = r.order_number || "2019021817263261965", i = wx.getStorageSync("kundian_farm_uid");
        e.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "order",
                op: "getOrderDetail",
                uniacid: a,
                order_number: n,
                uid: i
            },
            success: function(e) {
                if (e.data.is_check) {
                    var a = e.data, r = a.orderData, n = a.orderDetail, i = a.is_check;
                    t.setData({
                        orderData: r,
                        orderDetail: n,
                        is_check: i
                    });
                } else wx.showModal({
                    title: "警告",
                    content: "不是核销员禁止核销订单",
                    showCancel: !1,
                    success: function() {
                        wx.reLaunch({
                            url: "/kundian_farm/pages/HomePage/index/index"
                        });
                    }
                });
            }
        });
    },
    verifyOrder: function(r) {
        var t = this.data.orderData;
        wx.showModal({
            title: "提示",
            content: "是否确认核销订单?",
            success: function(r) {
                e.util.request({
                    url: "entry/wxapp/class",
                    data: {
                        control: "order",
                        op: "verifyOrder",
                        order_id: t.id,
                        uniacid: a
                    },
                    success: function(e) {
                        wx.showModal({
                            title: "提示",
                            content: e.data.msg,
                            showCancel: "false",
                            success: function() {
                                0 == e.data.code && wx.reLaunch({
                                    url: "/kundian_farm/pages/HomePage/index/index"
                                });
                            }
                        });
                    }
                });
            }
        });
    }
});