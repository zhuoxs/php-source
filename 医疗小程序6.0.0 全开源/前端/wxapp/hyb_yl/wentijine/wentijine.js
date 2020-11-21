var app = getApp();

Page({
    data: {},
    onsubmit: function(o) {
        var t = o.detail.value.z_tw_money, n = (wx.getStorageSync("openid"), this.data.id);
        app.util.request({
            url: "entry/wxapp/Questiommm",
            data: {
                id: n,
                z_tw_money: t
            },
            success: function(o) {
                wx.showToast({
                    title: "设置成功",
                    icon: "success",
                    duration: 800,
                    success: function() {
                        wx.redirectTo({
                            url: "/hyb_yl/my/my"
                        });
                    }
                });
            },
            fail: function(o) {
                console.log(o);
            }
        });
    },
    onLoad: function(o) {
        var t = wx.getStorageSync("color");
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: t
        });
        var n = o.id;
        this.setData({
            id: n
        });
    },
    onReady: function() {
        this.getMymoneysite();
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    getMymoneysite: function() {
        var t = this, o = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/Mymoneysite",
            data: {
                openid: o
            },
            success: function(o) {
                t.setData({
                    z_tw_money: o.data.data.z_tw_money
                });
            },
            fail: function(o) {
                console.log(o);
            }
        });
    }
});