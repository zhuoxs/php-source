var app = getApp();

Page({
    data: {
        navTile: "优惠券",
        banner: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152541919568.png",
        classify: [ "线上优惠券", "门店优惠券" ],
        curIndex: 0,
        cards: [ {
            money: "5",
            day: "3",
            remark: "5元无门槛",
            status: "1"
        }, {
            money: "8",
            day: "3",
            remark: "8元无门槛",
            status: "0"
        } ]
    },
    onLoad: function(t) {
        var a = this;
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), wx.setNavigationBarTitle({
            title: a.data.navTile
        });
        var e = wx.getStorageSync("settings"), n = wx.getStorageSync("url");
        this.setData({
            url: n,
            settings: e
        }), wx.getStorage({
            key: "openid",
            success: function(t) {
                app.util.request({
                    url: "entry/wxapp/getCoupon",
                    cachetime: "0",
                    data: {
                        uid: t.data
                    },
                    success: function(t) {
                        a.setData({
                            coupon: t.data.data
                        });
                    }
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
    onShareAppMessage: function() {},
    navChange: function(t) {
        var a = this, e = parseInt(t.currentTarget.dataset.index), n = e + 1;
        a.setData({
            curIndex: e
        }), wx.getStorage({
            key: "openid",
            success: function(t) {
                app.util.request({
                    url: "entry/wxapp/getCoupon",
                    cachetime: "0",
                    data: {
                        uid: t.data,
                        signs: n
                    },
                    success: function(t) {
                        a.setData({
                            coupon: t.data.data
                        });
                    }
                });
            }
        });
    },
    receRards: function(t) {
        var e = this, a = t.currentTarget.dataset.status, n = t.currentTarget.dataset.index, o = e.data.coupon, s = t.currentTarget.dataset.gid;
        if ("2" == a) wx.showModal({
            title: "提示",
            content: "您已经领取过该优惠券啦~",
            showCancel: !1
        }); else if (1 == a) wx.showModal({
            title: "提示",
            content: "优惠券已被抢光啦~下次早点来",
            showCancel: !1
        }); else if ("0" == a) return void wx.getStorage({
            key: "openid",
            success: function(t) {
                app.util.request({
                    url: "entry/wxapp/receiveCoupon",
                    cachetime: "0",
                    data: {
                        uid: t.data,
                        gid: s
                    },
                    success: function(t) {
                        var a = t.data.errno;
                        0 == a || 3 == a ? (o[n].status = 2, wx.showModal({
                            title: "提示",
                            content: "恭喜你，领取成功",
                            showCancel: !1,
                            success: function(t) {
                                e.setData({
                                    coupon: o
                                });
                            }
                        })) : 1 != a && 2 != a || (o[n].status = 1), e.setData({
                            coupon: o
                        });
                    }
                });
            }
        });
    }
});