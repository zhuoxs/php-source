var tool = require("../../../../we7/js/utils/countDown.js"), app = getApp(), Page = require("../../../../zhy/sdk/qitui/oddpush.js").oddPush(Page).Page;

Page({
    data: {
        indicatorDots: !1,
        autoplay: !1,
        interval: 5e3,
        duration: 1e3,
        bannerHeight: 0,
        showplay: 1,
        progress: 1,
        kanjia: 0,
        originalprice: 150,
        reduceprice: 3
    },
    onLoad: function(t) {
        var n = this;
        app.util.request({
            url: "entry/wxapp/System",
            cachetime: "0",
            success: function(t) {
                console.log("你的背景图片是多少"), console.log(t.data.jithumb);
                var a = t.data.jithumb;
                n.setData({
                    jithumb: a
                });
            }
        }), wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), n.url(), t.price ? n.setData({
            kanjia: t.price
        }) : n.setData({
            kanjia: 0
        }), wx.setStorageSync("bid", t.bid), wx.setStorageSync("gid", t.id), app.util.request({
            url: "entry/wxapp/Nowkangood",
            cachetime: "0",
            data: {
                id: t.id
            },
            success: function(e) {
                console.log(e.data);
                var o = e.data;
                setInterval(function() {
                    for (var t = 0; t < o.length; t++) {
                        var a = tool.countDown(n, o[t].endtime);
                        o[t].clock = a ? "距离结束还剩：" + a[0] + "天" + a[1] + "时" + a[3] + "分" + a[4] + "秒" : "已经截止", 
                        wx.setStorageSync("marprice", e.data[0].marketprice), wx.setStorageSync("shopprice", e.data[0].shopprice), 
                        n.setData({
                            bargainList: o,
                            countDownDay: a[0],
                            countDownHour: a[1],
                            countDownMinute: a[3],
                            countDownSecond: a[4]
                        });
                    }
                }, 1e3);
                n.setData({
                    nowgood: e.data[0]
                });
            }
        }), app.util.request({
            url: "entry/wxapp/system",
            cachetime: "0",
            success: function(t) {
                n.setData({
                    shop: t.data
                });
            }
        }), wx.getSystemInfo({
            success: function(t) {
                n.setData({
                    bannerHeight: 36 * t.screenWidth / 75,
                    cardheight: 495 * t.screenWidth / 750
                });
            }
        }), wx.getUserInfo({
            success: function(t) {
                n.setData({
                    userInfo: t.userInfo
                }), n.update();
            }
        }), n.setData({});
    },
    goindex: function(t) {
        wx.reLaunch({
            url: "/ymktv_sun/pages/booking/index/index"
        });
    },
    url: function(t) {
        var a = this;
        app.util.request({
            url: "entry/wxapp/Url2",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url2", t.data);
            }
        }), app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url", t.data), a.setData({
                    url: t.data
                });
            }
        });
    },
    goTakeorder: function(t) {
        var a = this, e = t.currentTarget.dataset.id, o = wx.getStorageSync("openid");
        console.log(e), app.util.request({
            url: "entry/wxapp/EndActive",
            cachetime: "10",
            data: {
                gid: e,
                openid: o
            },
            success: function(t) {
                console.log(t.data), 0 == t.data ? wx.showModal({
                    title: "提示",
                    content: "该活动已结束！",
                    showCancel: !1
                }) : 2 == t.data ? wx.showModal({
                    title: "提示",
                    content: "您已购买过该商品！",
                    showCancel: !1
                }) : wx.navigateTo({
                    url: "/ymktv_sun/pages/booking/takeorder/takeorder?id=" + e + "&price=" + a.data.userData.now_price
                });
            }
        });
    },
    showplay: function() {
        this.data.showplay;
        this.setData({
            showplay: 1
        });
    },
    closeplay: function() {
        var t = this;
        t.data.showplay;
        t.setData({
            showplay: 0
        }), t.onShow();
    },
    onShareAppMessage: function(t) {
        var a = this, e = wx.getStorageSync("openid"), o = wx.getStorageSync("bid"), n = wx.getStorageSync("gid");
        return "button" === t.from && console.log(t.target), {
            title: a.data.shop.share_title,
            path: "ymktv_sun/pages/booking/sharedetail/sharedetail?uid=" + e + "&id=" + n + "&bid=" + o,
            success: function(t) {
                a.closeplay();
            },
            fail: function(t) {
                a.closeplay();
            }
        };
    },
    onReady: function() {},
    onShow: function() {
        var a = this, e = wx.getStorageSync("gid"), o = wx.getStorageSync("marprice") - wx.getStorageSync("shopprice");
        console.log(o), wx.getStorage({
            key: "openid",
            success: function(t) {
                app.util.request({
                    url: "entry/wxapp/kanmasterData",
                    cachetime: "0",
                    data: {
                        openid: t.data,
                        gid: e
                    },
                    success: function(t) {
                        console.log(t.data), a.setData({
                            userData: t.data,
                            progress: Math.round((o - t.data.kanjia) / o * 1e4) / 100 + "%"
                        });
                    }
                });
            }
        });
    },
    gobangkan: function(t) {
        var a = wx.getStorageSync("openid"), e = wx.getStorageSync("gid");
        wx.navigateTo({
            url: "/ymktv_sun/pages/booking/sharedetail/sharedetail?uid=" + a + "&id=" + e
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});