var app = getApp();

Page({
    data: {
        navTile: "优惠券详情",
        orderNum: "",
        title: "",
        time: "",
        remark: "",
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
                    url: "entry/wxapp/getCouponDetail",
                    cachetime: "0",
                    data: {
                        openid: o,
                        id: n.id
                    },
                    success: function(o) {
                        a.setData({
                            imgroot: t,
                            coupon: o.data.data
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