Page({
    data: {},
    onLoad: function(n) {
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), console.log(n), this.setData({
            current: n.currentIndex
        });
    },
    goTap: function(n) {
        console.log(n);
        var t = this;
        t.setData({
            current: n.currentTarget.dataset.index
        }), 0 == t.data.current && wx.redirectTo({
            url: "../tabbar/gongzuotai"
        }), 1 == t.data.current && wx.redirectTo({
            url: "../tabbar/dingdan?currentIndex=1"
        }), 2 == t.data.current && wx.redirectTo({
            url: "../tabbar/setting?currentIndex=2"
        });
    },
    logTab: function(n) {
        wx.switchTab({
            url: "../mine/index"
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