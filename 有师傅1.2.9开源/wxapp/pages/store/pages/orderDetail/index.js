var e = getApp();

Page({
    data: {
        detail: "",
        imgs: []
    },
    onLoad: function(t) {
        var a = this;
        e.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_master",
                r: "store.orderDetail",
                order_id: t.orderid,
                uid: wx.getStorageSync("uid")
            },
            success: function(e) {
                a.setData({
                    detail: e.data.data.detail,
                    imgs: e.data.data.imgs,
                    prevImgs: e.data.data.prevImgs
                });
            }
        });
    },
    call: function(e) {
        isNaN(e.target.dataset.phone) ? wx.showModal({
            title: "系统消息",
            content: "未竞标无法联系雇主",
            showCancel: !0,
            success: function(e) {},
            fail: function(e) {},
            complete: function(e) {}
        }) : wx.makePhoneCall({
            phoneNumber: e.target.dataset.phone
        });
    },
    preview: function(e) {
        wx.previewImage({
            current: e.target.dataset.url,
            urls: this.data.prevImgs
        });
    },
    orderTakers: function(t) {
        e.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_master",
                r: "store.orderTakers",
                repair_uid: wx.getStorageSync("uid"),
                order_id: t.target.dataset.orderid
            },
            success: function(t) {
                e.util.message({
                    title: "抢单成功",
                    redirect: "redirect:/pages/store/pages/order/index"
                });
            }
        });
    }
});