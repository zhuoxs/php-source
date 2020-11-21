Page({
    data: {
        total: ""
    },
    onLoad: function(n) {
        this.setData({
            total: Number(wx.getStorageSync("total")) || "0"
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function(n) {
        return "button" === n.from && console.log(n.target), {
            title: "快来加入吧",
            path: "/page/user?id=123",
            desc: "最好的健身小程序",
            success: function(n) {},
            fail: function(n) {}
        };
    },
    addEnergy: function(n) {
        wx.navigateTo({
            url: "/byjs_sun/pages/charge/chargeIndex/chargeIndex"
        });
    }
});