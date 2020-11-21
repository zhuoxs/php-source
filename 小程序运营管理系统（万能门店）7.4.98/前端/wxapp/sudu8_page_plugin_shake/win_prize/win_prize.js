var app = getApp();

Page({
    data: {},
    onPullDownRefresh: function() {
        wx.stopPullDownRefresh();
    },
    onLoad: function(o) {
        var n = this;
        o.id && (n.data.id = o.id), wx.setNavigationBarTitle({
            title: "中奖列表"
        }), wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: o.nav_color ? o.nav_color : "#FEA049"
        }), app.util.request({
            url: "entry/wxapp/getRecordList",
            data: {
                openid: wx.getStorageSync("openid"),
                id: o.id
            },
            success: function(o) {
                n.setData({
                    records: o.data.data.records,
                    userinfo: o.data.data.userinfo
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});