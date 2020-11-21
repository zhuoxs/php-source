Page({
    data: {},
    onLoad: function(n) {
        wx.hideShareMenu();
    },
    bindSave: function(n) {
        console.log(n.detail.value);
        this.data.region;
        var o = n.detail.value;
        "" != o.account ? "" != o.password ? wx.navigateTo({
            url: "../mana-tabbar/gongzuotai/gongzuotai"
        }) : wx.showModal({
            title: "提示",
            content: "请输入密码！",
            showCancel: !1
        }) : wx.showModal({
            title: "提示",
            content: "请输入账号！",
            showCancel: !1
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