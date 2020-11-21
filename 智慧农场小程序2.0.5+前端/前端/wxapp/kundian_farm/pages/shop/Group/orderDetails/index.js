var a = new getApp(), t = a.siteInfo.uniacid;

Page({
    data: {
        borderImg: "../../../../images/icon/address-line.png",
        orderData: [],
        orderDetail: [],
        aboutData: [],
        farmSetData: []
    },
    onLoad: function(e) {
        var r = this, o = e.order_id, i = wx.getStorageSync("kundian_farm_uid");
        a.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "order",
                op: "getOrderDetail",
                uid: i,
                uniacid: t,
                order_id: o
            },
            success: function(a) {
                var t = a.data, e = t.orderData, o = t.orderDetail, i = t.aboutData;
                r.setData({
                    orderData: e,
                    orderDetail: o,
                    aboutData: i
                });
            }
        }), a.util.setNavColor(t);
        var n = wx.getStorageSync("kundian_farm_setData");
        r.setData({
            farmSetData: n
        });
    },
    copyData: function(a) {
        var t = a.currentTarget.dataset.info;
        wx.setClipboardData({
            data: t,
            success: function(a) {
                wx.showToast({
                    title: "复制成功"
                });
            }
        });
    },
    gotoMerchant: function() {
        var a = this.data.farmSetData;
        wx.openLocation({
            latitude: parseFloat(a.self_lifting_place.lat),
            longitude: parseFloat(a.self_lifting_place.lng),
            name: a.self_lifting_address
        });
    }
});