var app = getApp();

Page({
    data: {
        sets: [ {
            sets: "shop",
            status: !0
        }, {
            sets: "order",
            status: !0
        } ],
        isIpx: app.globalData.isIpx
    },
    onLoad: function(o) {
        var t = wx.getStorageSync("setting");
        t ? wx.setNavigationBarColor({
            frontColor: t.fontcolor,
            backgroundColor: t.color
        }) : app.get_setting(!0).then(function(o) {
            wx.setNavigationBarColor({
                frontColor: o.fontcolor,
                backgroundColor: o.color
            });
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    switchChange: function(o) {
        var t = o.detail.value, n = o.currentTarget.dataset.index, e = this.data.sets;
        e[n].status = !t, this.setData({
            sets: e
        });
    },
    toIndex: function(o) {
        wx.redirectTo({
            url: "../index/index"
        });
    },
    toMessage: function(o) {
        wx.redirectTo({
            url: "../message/message"
        });
    }
});