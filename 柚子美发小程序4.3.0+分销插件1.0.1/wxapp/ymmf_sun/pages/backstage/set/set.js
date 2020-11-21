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
    onLoad: function(t) {
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    switchChange: function(t) {
        var n = t.detail.value, o = t.currentTarget.dataset.index, e = this.data.sets;
        e[o].status = !n, this.setData({
            sets: e
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