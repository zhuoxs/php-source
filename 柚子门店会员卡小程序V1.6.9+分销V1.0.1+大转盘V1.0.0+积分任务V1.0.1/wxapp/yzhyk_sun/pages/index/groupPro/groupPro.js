Page({
    data: {
        navTile: "拼团流程",
        process: "开团方式：选择你喜欢的商品支付开团成功后可分享商品给好友，或通过参团码参团；参团方式：进入到朋友分享的页面，点击“立即参团”的按钮，付款后即可成功，也可以通过参团人分享的参团码来进行拼团；"
    },
    onLoad: function(n) {
        wx.setNavigationBarTitle({
            title: this.data.navTile
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