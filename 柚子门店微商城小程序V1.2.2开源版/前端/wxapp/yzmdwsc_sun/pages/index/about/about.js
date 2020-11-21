var app = getApp();

Page({
    data: {
        navTile: "关于我们",
        banner: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152542031597.png",
        address: "福建省厦门市集美区杏林湾街道",
        phone: "1300000",
        openTime: "09:00-21:00",
        isIpx: app.globalData.isIpx,
        provide: [ "停车位", "wifi", "支付宝支付", "微信支付" ],
        shopDes: "柚子鲜花坊位于福建省厦门市集美区，是一家主要经营礼品化妆品柚子鲜花坊位于福建省厦门市集美区，是一家主要经营礼品化妆品柚子鲜花坊位于福建省厦门市集美区，是一家主要经营礼品化妆品",
        shopDet: [ "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152542031605.png", "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152542031605.png" ]
    },
    onLoad: function(t) {
        wx.setNavigationBarTitle({
            title: this.data.navTile
        });
        var e = getCurrentPages(), a = e[e.length - 1].route;
        console.log("当前路径为:" + a), this.setData({
            current_url: a
        });
        var n = wx.getStorageSync("settings"), o = wx.getStorageSync("url"), i = wx.getStorageSync("tab");
        console.log(o), this.setData({
            settings: n,
            url: o,
            tab: i
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    toDialog: function(t) {
        wx.makePhoneCall({
            phoneNumber: this.data.settings.tel
        });
    },
    toMap: function(t) {
        console.log(t);
        var e = parseFloat(t.currentTarget.dataset.latitude), a = parseFloat(t.currentTarget.dataset.longitude);
        wx.openLocation({
            latitude: e,
            longitude: a,
            scale: 28
        });
    },
    toTab: function(t) {
        var e = t.currentTarget.dataset.url;
        e = "/" + e, wx.redirectTo({
            url: e
        });
    }
});