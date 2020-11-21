var app = getApp();

Page({
    data: {
        navTile: "联系客服",
        phone: "0592-6666666",
        diaName: "蜗牛客服"
    },
    onLoad: function(n) {
        var a = this;
        wx.setNavigationBarTitle({
            title: a.data.navTile
        }), app.util.request({
            url: "entry/wxapp/GetPlatformInfo",
            cachetime: "0",
            success: function(n) {
                a.setData({
                    phone: n.data.tel,
                    diaName: n.data.pt_name + "客服"
                }), console.log(n);
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
    dialog: function(n) {
        wx.makePhoneCall({
            phoneNumber: this.data.phone
        });
    }
});