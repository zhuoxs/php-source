Page({
    data: {},
    onLoad: function(n) {},
    onReady: function() {},
    onShow: function() {
        var n = {
            appId: "wxe13fc2fc632df786",
            timeStamp: "1552025876",
            nonceStr: "plra0vkmwvaibnq53ffvcnrpbl0toc2h",
            package: "prepay_id=wx0814175615804168138b08d92626981131",
            signType: "MD5",
            paySign: "D44E84C9C7AE8FD53A865CD832AD83CC",
            prepay_id: "wx0814175615804168138b08d92626981131",
            order_id: "12"
        };
        wx.requestPayment({
            timeStamp: n.timeStamp,
            nonceStr: n.nonceStr,
            package: n.package,
            signType: "MD5",
            paySign: n.paySign,
            success: function(n) {},
            fail: function(n) {}
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});