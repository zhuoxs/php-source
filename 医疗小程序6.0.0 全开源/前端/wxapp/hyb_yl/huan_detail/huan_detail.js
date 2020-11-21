var app = getApp();

Page({
    data: {
        guanzhu: []
    },
    onLoad: function(n) {
        var o = wx.getStorageSync("color");
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: o
        });
        var a = this, t = n.id;
        app.util.request({
            url: "entry/wxapp/Orderguan",
            data: {
                zid: t
            },
            success: function(n) {
                console.log(n), a.setData({
                    myguan: n.data.data
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    selck: function(n) {
        console.log(n);
        var o = n.currentTarget.dataset.huzopenid;
        wx.navigateTo({
            url: "/hyb_yl/xinzengyiliao/xinzengyiliao?huzopenid=" + o + "&fuwu_name=患者病程"
        });
    }
});