var app = getApp();

Page({
    data: {
        orderId: 0,
        shopId: 0
    },
    onLoad: function(o) {
        console.log(o.orderId), console.log(o.shopId), this.setData({
            orderId: o.orderId,
            shopId: o.shopId
        }), this.getOrderDateils();
    },
    getOrderDateils: function() {
        var t = this;
        app.ajax({
            url: "Cpin|storeOrderList",
            data: {
                store_id: t.data.shopId,
                state: -1,
                id: t.data.orderId
            },
            success: function(o) {
                console.log(o), t.setData({
                    orderDateilsData: o.data,
                    imgAdd: o.other.img_root
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});