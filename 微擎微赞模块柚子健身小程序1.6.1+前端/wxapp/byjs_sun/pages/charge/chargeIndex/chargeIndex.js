var tool = require("../../../../we7/js/countDown.js"), app = getApp();

Page({
    data: {
        scrollBtn: !0,
        navImg: "http://img.zcool.cn/community/0142135541fe180000019ae9b8cf86.jpg@1280w_1l_2o_100sh.png",
        nav: [],
        fight1: [],
        fight2: [],
        type_name: "",
        endTimeOut: null,
        countDownTime: {
            h: "00",
            s: "00",
            m: "00",
            d: "00"
        },
        endTime: "2018-04-12 12:00:00",
        bargainList: [ {
            endTime: "1527519898765",
            clock: ""
        }, {
            endTime: "1521519898765",
            clock: ""
        } ],
        goods: [],
        tabBarList: []
    },
    onLoad: function(t) {
        this.setData({
            tabBarList: app.globalData.tabbar2
        });
        var r = this;
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
                wx.setStorageSync("url", t.data), r.setData({
                    url: t.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/GoodList",
            cachetime: "0",
            success: function(t) {
                console.log(t), r.setData({
                    fight1: t.data.res,
                    bannerList: t.data.banner.lb_imgs,
                    nav: t.data.res1,
                    fight2: t.data.res2[0],
                    type_name: t.data.res2.type_name,
                    status: t.data.status
                });
            }
        }), app.util.request({
            url: "entry/wxapp/GoodsDiscount",
            cachetime: 30,
            success: function(t) {
                console.log("进入抢购"), console.log(t.data);
                var o = t.data;
                setInterval(function() {
                    for (var t = 0; t < o.length; t++) {
                        o[t].clock = "";
                        var e = o[t].endtime.replace(/(-)/g, "/"), n = new Date(e).getTime(), a = tool.countDown(r, n);
                        o[t].clock = a ? a[0] + "天" + a[1] + "时" + a[3] + "分" + a[4] + "秒" : "已经截止", r.setData({
                            goods: o
                        });
                    }
                }, 1e3);
            }
        });
    },
    goIndex: function(t) {
        wx.reLaunch({
            url: "../../product/index/index"
        });
    },
    goPublishTxt: function(t) {
        wx.reLaunch({
            url: "../../publishInfo/publish/publishTxt"
        });
    },
    goFindIndex: function(t) {
        wx.reLaunch({
            url: "../../find/findIndex/findIndex"
        });
    },
    goMy: function(t) {
        wx.reLaunch({
            url: "../../myUser/my/my"
        });
    },
    onReady: function() {
        var t = this.data.endTime;
        this.countdown(t);
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    goUrl: function(t) {
        console.log(t);
        var e = t.currentTarget.dataset.id;
        wx.navigateTo({
            url: "/byjs_sun/pages/charge/chargeProductInfo/chargeProductInfo?id=" + e
        });
    },
    goProductInfo: function(t) {
        var e = t.currentTarget.dataset.id, n = t.currentTarget.dataset.goods_price;
        app.util.request({
            url: "entry/wxapp/isStatus",
            data: {
                id: e
            },
            success: function(t) {
                0 == t.data ? wx.showToast({
                    title: "抢购时间已超过！",
                    icon: "none",
                    duration: 2e3
                }) : wx.navigateTo({
                    url: "/byjs_sun/pages/charge/chargeProductInfo/chargeProductInfo?id=" + e + "&goods_price=" + n
                });
            }
        });
    },
    goType: function(t) {
        var e = t.currentTarget.dataset.id, n = t.currentTarget.dataset.index, a = this.data.nav[n].type_name;
        wx.navigateTo({
            url: "/byjs_sun/pages/charge/equipment/equipment?id=" + e + "&navTitleText=" + a
        });
    },
    goInfo: function(t) {
        var e = t.currentTarget.dataset.id;
        wx.navigateTo({
            url: "/byjs_sun/pages/charge/chargeProductInfo/chargeProductInfo?id=" + e
        });
    },
    countdown: function(t) {
        console.log(new Date().getTime()), console.log(new Date(t).getTime());
        var e = new Date(t).getTime(), n = new Date().getTime();
        if (e < n) return clearInterval(this.data.endTimeOut), this.data.endTimeOut = null, 
        !1;
        this.setCountDown(e);
        var a = this;
        setInterval(function() {
            try {
                a.setCountDown(e);
            } catch (t) {
                console.log(t), clearInterval(a.data.endTimeOut);
            }
        }, 1e3);
    },
    setCountDown: function(t) {
        var e = t - new Date().getTime(), n = parseInt(e / 36e5), a = parseInt(n / 24);
        n %= 24;
        var o = parseInt(e % 36e5 / 6e4), r = parseInt(e % 36e5 % 6e4 / 1e3);
        n < 10 && (n = "0" + n), o < 10 && (o = "0" + o), r < 10 && (r = "0" + r);
        var s = {
            h: n,
            m: o,
            s: r,
            d: a
        };
        this.setData({
            countDownTime: s
        });
    },
    scrollBtnFalse: function() {
        this.setData({
            scrollBtn: !1
        });
    },
    scrollBtnTrue: function() {
        this.setData({
            scrollBtn: !0
        });
    }
});