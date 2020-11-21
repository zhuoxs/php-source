var app = getApp();

Page({
    data: {
        ulist: [ {
            iconsrc: "../../../../style/images/icon15.png",
            title: "专项折扣",
            det: "当前等级折扣8折"
        }, {
            iconsrc: "../../../../style/images/icon10.png",
            title: "会员等级",
            det: "消费越多等级越高"
        } ]
    },
    onLoad: function(t) {
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
        var n = wx.getStorageSync("settings");
        this.setData({
            settings: n
        });
    },
    onReady: function() {},
    onShow: function() {
        var n = this, t = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/getUser",
            cachetime: "0",
            data: {
                openid: t
            },
            success: function(t) {
                n.setData({
                    user: t.data
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    toMybill: function(t) {
        wx.navigateTo({
            url: "/yzmdwsc_sun/pages/user/mybill/mybill"
        });
    }
});