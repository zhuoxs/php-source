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
    onLoad: function(n) {},
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});