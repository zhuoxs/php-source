/*   time:2019-08-09 13:18:40*/
var app = getApp();
Page({
    data: {
        content: [],
        list: []
    },
    onLoad: function(t) {
        var n = this,
            a = t.fid,
            o = t.bid,
            i = wx.getStorageSync("openid");
        a && o && i && app.util.request({
            url: "entry/wxapp/GetUserFission",
            showLoading: !1,
            data: {
                fid: a,
                bid: o,
                openid: i,
                type: 2,
                m: app.globalData.Plugin_fission
            },
            success: function(t) {
                console.log(t.data), t.data.activation ? n.setData({
                    content: t.data,
                    list: t.data.activation
                }) : n.setData({
                    content: [],
                    list: []
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
    toHelp: function(t) {
        var n = parseInt(t.currentTarget.dataset.bid),
            a = parseInt(t.currentTarget.dataset.fid);
        wx.navigateTo({
            url: "/mzhk_sun/plugin/fission/help/help?fid=" + a + "&bid=" + n
        })
    }
});