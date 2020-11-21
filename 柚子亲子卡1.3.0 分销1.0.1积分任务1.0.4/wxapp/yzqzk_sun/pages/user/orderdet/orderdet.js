var app = getApp();

Page({
    data: {
        navTile: "订单详情",
        status: 2
    },
    onLoad: function(n) {
        var a = this;
        wx.setNavigationBarTitle({
            title: a.data.navTile
        });
        var o = wx.getStorageSync("setting");
        o ? wx.setNavigationBarColor({
            frontColor: o.fontcolor,
            backgroundColor: o.color
        }) : app.get_setting(!0).then(function(o) {
            wx.setNavigationBarColor({
                frontColor: o.fontcolor,
                backgroundColor: o.color
            });
        }), app.get_imgroot().then(function(t) {
            app.get_openid().then(function(o) {
                app.util.request({
                    url: "entry/wxapp/getOrderDetail",
                    cachetime: "0",
                    data: {
                        openid: o,
                        id: n.id
                    },
                    success: function(o) {
                        a.setData({
                            imgroot: t,
                            order: o.data.data
                        }), console.log(o.data.data);
                    }
                });
            });
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});