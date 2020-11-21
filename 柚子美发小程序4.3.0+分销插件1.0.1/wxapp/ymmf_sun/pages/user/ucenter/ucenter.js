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
        var n = this;
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), wx.getUserInfo({
            success: function(t) {
                n.setData({
                    thumb: t.userInfo.avatarUrl,
                    nickname: t.userInfo.nickName
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        var n = this, t = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/GetVipData",
            cachetime: "0",
            data: {
                openid: t
            },
            success: function(t) {
                console.log(t.data), n.setData({
                    amount: t.data.amount,
                    curr_vip: t.data.curr_vip,
                    nextLevel: t.data.nextLevel,
                    distance: t.data.distance
                });
            }
        }), app.util.request({
            url: "entry/wxapp/vipsurvey",
            cachetime: "0",
            success: function(t) {
                n.setData({
                    survey: t.data
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});