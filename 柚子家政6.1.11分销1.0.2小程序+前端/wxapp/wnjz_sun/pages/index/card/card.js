var app = getApp();

Page({
    data: {
        indicatorDots: !1,
        autoplay: !1,
        interval: 3e3,
        duration: 800,
        cards: []
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
    },
    onReady: function() {},
    onShow: function() {
        var t = wx.getStorageSync("openid"), a = wx.getStorageSync("build_id"), n = this;
        app.util.request({
            url: "entry/wxapp/CounpIndex",
            method: "GET",
            data: {
                userid: t,
                build_id: a
            },
            success: function(t) {
                var a = t.data ? t.data : [];
                n.setData({
                    cards: a
                });
            }
        });
    },
    coupon: function(t) {
        var n = this, a = t.currentTarget.dataset.id, o = (t.currentTarget.dataset.isuse, 
        t.currentTarget.dataset.index), e = wx.getStorageSync("openid"), s = n.data.cards;
        app.util.request({
            url: "entry/wxapp/Counpadd",
            method: "GET",
            data: {
                userid: e,
                id: a
            },
            success: function(t) {
                var a = t.data.status;
                t.data;
                "1" == a || 1 == a ? wx.showModal({
                    content: "领取成功",
                    showCancel: !1,
                    success: function(t) {
                        s[o].isused = "1", n.setData({
                            cards: s
                        }), console.log(s[o].isused);
                    }
                }) : wx.showModal({
                    content: "您已经领取过优惠券啦~",
                    showCancel: !1,
                    success: function(t) {}
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});