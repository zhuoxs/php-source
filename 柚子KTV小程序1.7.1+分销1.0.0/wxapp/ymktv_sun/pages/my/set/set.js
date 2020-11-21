Page({
    data: {
        switchShow: !0
    },
    onLoad: function(o) {},
    getout: function(o) {
        wx.redirectTo({
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
        var o = this.data.switchShow;
        o = !o, this.setData({
            switchShow: o
        });
    },
    goOrdery: function() {
        wx.redirectTo({
            url: "../order/order"
        });
    },
    goWork: function() {
        wx.redirectTo({
            url: "../work/work"
        });
    }
});