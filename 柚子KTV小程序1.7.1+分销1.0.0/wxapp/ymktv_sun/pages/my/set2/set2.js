Page({
    data: {
        switchShow: !0
    },
    onLoad: function(n) {
        this.setData({
            b_name: n.b_name
        });
    },
    getout: function(n) {
        wx.setStorageSync("account", ""), wx.setStorageSync("password", ""), wx.redirectTo({
            url: "/ymktv_sun/pages/my/admin/admin"
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    shangeSwich: function() {
        var n = this.data.switchShow;
        n = !n, this.setData({
            switchShow: n
        });
    },
    goOrdery: function() {
        var n = wx.getStorageSync("bid");
        wx.redirectTo({
            url: "../order2/order2?bid=" + n + "&b_name=" + this.data.b_name
        });
    },
    goWork: function() {
        var n = wx.getStorageSync("bid");
        wx.redirectTo({
            url: "../work2/work2?bid=" + n + "&b_name=" + this.data.b_name
        });
    }
});