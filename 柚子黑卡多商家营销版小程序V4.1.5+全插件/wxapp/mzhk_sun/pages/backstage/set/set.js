Page({
    data: {
        sets: [ {
            sets: "shop",
            status: !0
        }, {
            sets: "order",
            status: !0
        } ]
    },
    onLoad: function(t) {},
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    switchChange: function(t) {
        var n = t.detail.value, e = t.currentTarget.dataset.index, s = this.data.sets;
        s[e].status = !n, this.setData({
            sets: s
        });
    },
    toIndex: function(t) {
        wx.redirectTo({
            url: "../index/index"
        });
    },
    toMessage: function(t) {
        wx.redirectTo({
            url: "../message/message"
        });
    }
});