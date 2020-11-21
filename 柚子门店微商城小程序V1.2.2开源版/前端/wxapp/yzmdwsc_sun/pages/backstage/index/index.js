var app = getApp();

Page({
    data: {
        list: [ {
            title: "今日总访客数",
            detail: "0"
        }, {
            title: "今日总成交额",
            detail: "0"
        }, {
            title: "今日订单数",
            detail: "0"
        }, {
            title: "待接单",
            detail: "0"
        }, {
            title: "代配送",
            detail: "0"
        }, {
            title: "退款订单",
            detail: "0"
        } ],
        finance: [ {
            title: "今日收益",
            detail: "0"
        }, {
            title: "昨日收益",
            detail: "0"
        }, {
            title: "总计收益",
            detail: "0"
        } ],
        isIpx: app.globalData.isIpx
    },
    onLoad: function(t) {
        var e = this;
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), wx.getUserInfo({
            success: function(t) {
                e.setData({
                    thumb: t.userInfo.avatarUrl,
                    nickname: t.userInfo.nickName
                });
            }
        }), console.log(wx.getStorageSync("settings"));
        var a = wx.getStorageSync("openid");
        e.setData({
            uid: a,
            settings: wx.getStorageSync("settings")
        });
    },
    onReady: function() {},
    onShow: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/gettongji",
            cachetime: "0",
            success: function(t) {
                console.log(t.data), e.setData({
                    data: t.data
                });
            }
        });
        var t = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/isHxstaff",
            cachetime: "0",
            data: {
                uid: t
            },
            success: function(t) {
                e.setData({
                    isHxstaff: t.data
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    toMessage: function(t) {
        wx.redirectTo({
            url: "../publish/publish"
        });
    },
    toSet: function(t) {
        wx.redirectTo({
            url: "../set/set"
        });
    },
    scanCode: function(t) {
        var a = wx.getStorageSync("openid");
        wx.scanCode({
            success: function(t) {
                var e = t.result;
                app.util.request({
                    url: "entry/wxapp/setCheckCoupon",
                    cachetime: "0",
                    data: {
                        uid: a,
                        result: e
                    },
                    success: function(t) {
                        if (1 == t.data.errcode) {
                            var e = "/yzmdwsc_sun/pages/backstage/coupon/coupon?id=" + t.data.user_coupon_id;
                            wx.navigateTo({
                                url: e
                            });
                        } else if (2 == t.data.errcode) {
                            e = "/yzmdwsc_sun/pages/backstage/writeoff/writeoff?orderid=" + t.data.orderid + "&uid=" + t.data.uid;
                            wx.navigateTo({
                                url: e
                            });
                        }
                    }
                });
            }
        });
    },
    toOrderlist: function(t) {
        4 == t.currentTarget.dataset.index && wx.navigateTo({
            url: "../orderlist/orderlist"
        });
    },
    toManager: function(t) {
        wx.navigateTo({
            url: "../manager/manager"
        });
    }
});