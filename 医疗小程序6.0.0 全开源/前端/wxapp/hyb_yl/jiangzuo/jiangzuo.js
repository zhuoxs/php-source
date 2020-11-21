Page({
    data: {
        taocan: [ "外科", "腰椎病", "颈椎病", "白癜风", "骨质增生", "精神病" ],
        currentTab: 0
    },
    taocan: function(n) {
        this.setData({
            currentTab: n.currentTarget.dataset.index
        });
    },
    onLoad: function(n) {
        var o = wx.getStorageSync("color");
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: o
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