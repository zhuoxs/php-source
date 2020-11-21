var app = getApp();

Page({
    data: {},
    onLoad: function(t) {
        var o = this, n = wx.getStorageSync("userInfo");
        o.setData({
            user_id: n.id
        }), o.getDistributionReport(), o.baseset();
    },
    getDistributionReport: function() {
        var o = this, t = o.data.user_id;
        app.ajax({
            url: "Cdistribution|getDistributionReport",
            data: {
                user_id: t
            },
            success: function(t) {
                o.setData({
                    getreport: t.data.distribution,
                    img_root: t.other.img_root
                });
            }
        });
    },
    baseset: function() {
        var t = wx.getStorageSync("appConfig");
        this.setData({
            headerbg: t.personcenter_color_b ? t.personcenter_color_b : "#f87d6d"
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