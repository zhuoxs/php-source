var app = getApp();

Page({
    data: {},
    look_detail: function(o) {
        console.log(o);
        var t = o.currentTarget.dataset.data, n = o.currentTarget.dataset.id, a = o.currentTarget.dataset.z_yy_money;
        wx.navigateTo({
            url: "/hyb_yl/patient_detail2/patient_detail2?cid=" + n + "&z_name=" + t + "&money=" + a
        });
    },
    onLoad: function(o) {
        var t = wx.getStorageSync("color");
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: t
        });
        var n = this, a = (wx.getStorageSync("openid"), o.id);
        a && app.util.request({
            url: "entry/wxapp/Selectdoctordocid",
            data: {
                docid: a
            },
            success: function(o) {
                console.log(o), n.setData({
                    infos: o.data.data
                });
            },
            fail: function(o) {
                console.log(o);
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