/*   time:2019-08-09 13:18:39*/
var app = getApp();
Page({
    data: {},
    onLoad: function(t) {
        var a = this,
            e = t.fid,
            n = t.bid,
            i = wx.getStorageSync("openid");
        e && n && i && app.util.request({
            url: "entry/wxapp/GetUserFission",
            showLoading: !1,
            data: {
                fid: e,
                bid: n,
                openid: i,
                m: app.globalData.Plugin_fission
            },
            success: function(t) {
                console.log(t.data), a.setData({
                    content: t.data
                })
            }
        })
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    toShop: function(t) {
        var a = parseInt(t.currentTarget.dataset.bid);
        wx.navigateTo({
            url: "/mzhk_sun/pages/index/shop/shop?id=" + a
        })
    },
    callPhone: function(t) {
        var a = t.currentTarget.dataset.phone;
        wx.makePhoneCall({
            phoneNumber: a
        })
    },
    getAddress: function(t) {
        var a = t.currentTarget.dataset.lat,
            e = t.currentTarget.dataset.lng,
            n = t.currentTarget.dataset.address;
        wx.openLocation({
            latitude: a - 0,
            longitude: e - 0,
            address: n,
            scale: 28
        })
    },
    toUse: function(t) {
        var a = parseInt(t.currentTarget.dataset.bid),
            e = parseInt(t.currentTarget.dataset.fid);
        wx.navigateTo({
            url: "/mzhk_sun/plugin/fission/mayuse/mayuse?fid=" + e + "&bid=" + a
        })
    },
    toActivated: function(t) {
        var a = parseInt(t.currentTarget.dataset.bid),
            e = parseInt(t.currentTarget.dataset.fid);
        wx.navigateTo({
            url: "/mzhk_sun/plugin/fission/tobeactivated/tobeactivated?fid=" + e + "&bid=" + a
        })
    },
    toGive: function(t) {
        var a = parseInt(t.currentTarget.dataset.bid),
            e = parseInt(t.currentTarget.dataset.fid);
        wx.navigateTo({
            url: "/mzhk_sun/plugin/fission/give/give?fid=" + e + "&bid=" + a
        })
    },
    toIndex2: function(t) {
        wx.reLaunch({
            url: "/mzhk_sun/pages/index/index"
        })
    }
});