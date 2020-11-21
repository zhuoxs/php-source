var app = getApp();

Page({
    data: {
        guanzhu: []
    },
    guanzhu: function(n) {
        var a = n.currentTarget.dataset.index, t = this.data.guanzhu;
        0 == t[a].guanzhu ? (wx.showToast({
            title: "关注成功"
        }), t[a].guanzhu = 1) : (wx.showToast({
            title: "已取消关注"
        }), t[a].guanzhu = 0), this.setData({
            guanzhu: t
        });
    },
    onLoad: function(n) {
        var a = this, t = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/Myguan",
            data: {
                openid: t
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
    onShareAppMessage: function() {}
});