Page({
    data: {
        showplay: 0,
        title: "花迷你满天星勿忘我花束永生花ins礼盒限量100份",
        bookinglong: [ "枚红色水晶草", "红色满天星" ],
        styleindex: 0
    },
    onLoad: function(t) {
        var a = this;
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), wx.getSystemInfo({
            success: function(t) {
                a.setData({
                    bannerHeight: 36 * t.screenWidth / 75
                });
            }
        });
    },
    goIndex: function() {
        this.closeplay(), wx.switchTab({
            url: "../../booking/index/index"
        });
    },
    showplay: function() {
        this.data.showplay;
        this.setData({
            showplay: 1
        });
    },
    closeplay: function() {
        this.data.showplay;
        this.setData({
            showplay: 0
        });
    },
    chosetime: function(t) {
        var a = t.currentTarget.dataset.index, o = this.data.styleindex;
        o = a, this.setData({
            styleindex: o
        });
    }
});