var a = getApp();

Page({
    data: {
        detail: "",
        imgs: []
    },
    onLoad: function(e) {
        var t = this;
        a.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_master",
                r: "order.orderDetail",
                uid: wx.getStorageSync("uid"),
                order_id: e.orderid
            },
            success: function(a) {
                t.setData({
                    detail: a.data.data.detail,
                    imgs: a.data.data.imgs,
                    prevImgs: a.data.data.prevImgs,
                    repairData: a.data.data.repairData
                });
            }
        });
    },
    refound: function(a) {
        wx.navigateTo({
            url: "/pages/order/refound/index?orderid=" + a.currentTarget.dataset.orderid
        });
    },
    call: function(a) {
        wx.makePhoneCall({
            phoneNumber: a.target.dataset.phone
        });
    },
    preview: function(a) {
        wx.previewImage({
            current: a.target.dataset.url,
            urls: this.data.prevImgs
        });
    },
    repairInfo: function(a) {
        wx.navigateTo({
            url: "/pages/store/pages/masterDetail/index?uid=" + a.target.dataset.uid
        });
    }
});