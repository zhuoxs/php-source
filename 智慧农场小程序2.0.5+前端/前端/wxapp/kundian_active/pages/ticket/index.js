var a = new getApp(), t = a.siteInfo.uniacid;

Page({
    data: {
        orderData: [],
        active: []
    },
    onLoad: function(e) {
        var i = this, d = wx.getStorageSync("kundian_farm_uid"), o = a.util.url("entry/wxapp/class") + "m=kundian_farm_plugin_active";
        wx.request({
            url: o,
            data: {
                action: "order",
                op: "getQrcode",
                uniacid: t,
                order_id: e.order_id,
                uid: d
            },
            success: function(a) {
                i.setData({
                    orderData: a.data.orderData,
                    active: a.data.active
                });
            }
        }), a.util.setNavColor(t);
    },
    intoMap: function(a) {
        var t = this.data, e = t.latitude, i = (t.longitude, t.address);
        wx.openLocation({
            latitude: parseFloat(e),
            longitude: parseFloat(longitudee),
            address: i,
            scale: 28
        });
    },
    doCall: function(a) {
        var t = this;
        wx.makePhoneCall({
            phoneNumber: t.data.active.phone
        });
    }
});