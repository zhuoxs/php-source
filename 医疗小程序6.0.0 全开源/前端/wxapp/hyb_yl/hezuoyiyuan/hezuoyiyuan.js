var app = getApp();

Page({
    data: {},
    openMap: function(a) {
        var d = this, t = a.currentTarget.dataset.id;
        app.util.request({
            url: "entry/wxapp/Hospatilmap",
            data: {
                id: t
            },
            success: function(a) {
                console.log(a), d.setData({
                    latitude: a.data.data.latitude,
                    longitude: a.data.data.longitude,
                    ty_address: a.data.data.ty_address,
                    ty_name: a.data.data.ty_name
                });
                var t = JSON.parse(d.data.latitude), o = JSON.parse(d.data.longitude);
                console.log(t, o);
                var n = d.data.ty_address, e = d.data.ty_name;
                wx.openLocation({
                    latitude: t,
                    longitude: o,
                    scale: 18,
                    name: e,
                    address: n
                });
            },
            fail: function(a) {
                console.log(a);
            }
        });
    },
    onLoad: function(a) {
        var t = wx.getStorageSync("color");
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: t
        });
        var o = this;
        app.util.request({
            url: "entry/wxapp/Hospatil",
            success: function(a) {
                console.log(a), o.setData({
                    hospatil: a.data.data
                });
            },
            fail: function(a) {
                console.log(a);
            }
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