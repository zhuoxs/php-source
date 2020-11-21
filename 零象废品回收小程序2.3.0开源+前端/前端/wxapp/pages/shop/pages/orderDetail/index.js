var a = getApp();

Page({
    data: {
        detail: "",
        imgs: []
    },
    onLoad: function(t) {
        var e = this;
        a.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_reclaim",
                r: "order.orderDetail",
                uid: wx.getStorageSync("uid"),
                order_id: t.orderid
            },
            success: function(a) {
                e.setData({
                    detail: a.data.data.detail,
                    imgs: a.data.data.imgs,
                    prevImgs: a.data.data.prevImgs
                });
            }
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
    }
});