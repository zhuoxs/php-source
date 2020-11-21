require("../../../../style/utils/util.js");

var app = getApp();

Page({
    data: {},
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
        var a = this, n = wx.getStorageSync("build_id");
        wx.getStorage({
            key: "openid",
            success: function(t) {
                app.util.request({
                    url: "entry/wxapp/Counpkaq",
                    cachetime: "0",
                    data: {
                        uid: t.data,
                        build_id: n
                    },
                    success: function(t) {
                        console.log(t.data.data), a.setData({
                            cards: t.data.data
                        });
                    }
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    coupon: function(t) {
        var a = t.currentTarget.dataset.status, n = t.currentTarget.dataset.index, o = t.currentTarget.dataset.id, e = this.data.cards;
        if (console.log(e[n].status + "" + a), "1" == a) e[n].status = 2, this.setData({
            cards: e
        }), wx.getStorage({
            key: "openid",
            success: function(t) {
                app.util.request({
                    url: "entry/wxapp/lingCounp",
                    cachetime: "0",
                    data: {
                        id: o,
                        uid: t.data,
                        status: a
                    },
                    success: function(t) {
                        console.log(t.data.data), t.data.data && wx.showToast({
                            title: "领取成功！"
                        });
                    }
                });
            }
        }); else {
            if ("2" != a) return !1;
            wx.showModal({
                content: "您已经领取过优惠券啦~",
                showCancel: !1,
                success: function(t) {}
            });
        }
    }
});