Page({
    data: {
        status: !0,
        order_id: 0
    },
    onLoad: function(t) {
        var e = t.status, a = t.order_id;
        "true" == e ? wx.setNavigationBarTitle({
            title: "支付成功"
        }) : wx.setNavigationBarTitle({
            title: "支付失败"
        }), this.setData({
            status: e,
            order_id: a
        });
    },
    seeQrcode: function(t) {
        wx.redirectTo({
            url: "../ticket/index?order_id=" + this.data.order_id
        });
    },
    goBack: function(t) {
        wx.navigateBack({
            delta: 1
        });
    },
    goHome: function(t) {
        wx.reLaunch({
            url: "../../HomePage/index?is_tarbar=true"
        });
    }
});