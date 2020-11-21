var a = new getApp(), t = a.siteInfo.uniacid, e = a.util.url("entry/wxapp/class") + "m=kundian_farm_plugin_active";

Page({
    data: {
        orderData: [],
        is_check_user: [],
        farmSetData: []
    },
    onLoad: function(r) {
        var i = this, c = r.order_id, d = wx.getStorageSync("kundian_farm_uid"), n = wx.getStorageSync("kundian_farm_setData");
        wx.request({
            url: e,
            data: {
                action: "order",
                op: "getTicketData",
                order_number: c,
                uniacid: t,
                uid: d
            },
            success: function(a) {
                i.setData({
                    orderData: a.data.orderData,
                    is_check_user: a.data.is_check_user,
                    farmSetData: n
                });
            }
        }), a.util.setNavColor(t);
    },
    checkActive: function(a) {
        var r = this, i = wx.getStorageSync("kundian_farm_uid"), c = r.data.orderData;
        wx.showModal({
            title: "提示",
            content: "确认核销该订单吗？",
            success: function(a) {
                a.confirm && wx.request({
                    url: e,
                    data: {
                        action: "order",
                        op: "checkActive",
                        uniacid: t,
                        order_id: r.data.orderData.id,
                        uid: i
                    },
                    success: function(a) {
                        0 == a.data.code && (c.status = 4, r.setData({
                            orderData: c
                        })), wx.showModal({
                            title: "提示",
                            content: a.data.msg,
                            showCancel: !1
                        });
                    }
                });
            }
        });
    }
});