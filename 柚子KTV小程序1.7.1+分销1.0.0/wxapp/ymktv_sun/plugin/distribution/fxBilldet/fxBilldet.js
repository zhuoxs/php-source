var app = getApp();

Page({
    data: {
        state: 1,
        detail: [],
        wdtype: [ "", "微信", "支付宝", "银行卡", "余额" ]
    },
    onLoad: function(t) {
        t.id || wx.navigateBack({
            delta: 1
        }), this.setData({
            options: t
        });
        var a = wx.getStorageSync("System");
        wx.setNavigationBarColor({
            frontColor: a.fontcolor ? a.fontcolor : "#000000",
            backgroundColor: a.color ? a.color : "#ffffff",
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
    },
    onReady: function() {
        var a = this, t = a.data.options;
        app.util.request({
            url: "entry/wxapp/getWithDrawDetail",
            data: {
                id: t.id,
                m: app.globalData.Plugin_distribution
            },
            success: function(t) {
                console.log("订单数据"), console.log(t.data), 2 == t.data ? a.setData({
                    detail: []
                }) : a.setData({
                    detail: t.data
                });
            }
        });
    },
    onShow: function() {}
});