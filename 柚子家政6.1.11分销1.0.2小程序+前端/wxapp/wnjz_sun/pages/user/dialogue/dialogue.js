var app = getApp();

Page({
    data: {
        phone: []
    },
    onLoad: function(t) {},
    onReady: function() {},
    onShow: function() {
        var n = this;
        app.util.request({
            url: "entry/wxapp/Aboutus",
            success: function(t) {
                n.setData({
                    phone: t.data.tel
                });
            }
        }), app.util.request({
            url: "entry/wxapp/system",
            cachetime: "0",
            success: function(t) {
                n.setData({
                    shop: t.data
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    dialog: function(t) {
        wx.makePhoneCall({
            phoneNumber: this.data.shop.tel
        });
    }
});