var app = getApp();

Page({
    data: {},
    onLoad: function(n) {
        console.log(n), this.requestPayment(n);
    },
    requestPayment: function(n) {
        var a = n.money, e = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/Pay",
            header: {
                "Content-Type": "application/xml"
            },
            method: "GET",
            data: {
                openid: e,
                z_tw_money: a
            },
            success: function(n) {
                console.log(n), wx.requestPayment({
                    timeStamp: n.data.timeStamp,
                    nonceStr: n.data.nonceStr,
                    package: n.data.package,
                    signType: n.data.signType,
                    paySign: n.data.paySign,
                    success: function(n) {
                        wx.navigateTo({
                            url: "/hyb_yl/zhuan_liao/zhuan_liao?zid=" + zid + "&user_openid=" + user_openid
                        });
                    },
                    fail: function(n) {
                        wx.navigateBack();
                    }
                });
            },
            fail: function(n) {
                console.log(n);
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