var app = getApp(), Page = require("../../../../zhy/sdk/qitui/oddpush.js").oddPush(Page).Page;

Page({
    data: {
        goId: 0,
        reduceBtn: !1,
        cardBtn: !1,
        open_distribution: !1,
        navlist: [ {
            imgSrc: "../../../resource/images/mypage/icon06.png",
            text: "积分商城",
            url: "goGiftindex"
        }, {
            imgSrc: "../../../resource/images/mypage/icon07.png",
            text: "关于我们",
            url: "goAboutus"
        }, {
            imgSrc: "../../../resource/images/mypage/icon08.png",
            text: "商家入口",
            url: "goMysell"
        } ],
        whichone: 11
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
        }), t.bid && wx.setStorageSync("bid", t.bid);
        var a = wx.getStorageSync("url");
        e.setData({
            url: a
        }), wx.getUserInfo({
            success: function(t) {
                e.setData({
                    userInfo: t.userInfo
                });
            }
        }), app.util.request({
            url: "entry/wxapp/Plugin",
            data: {
                type: 1
            },
            showLoading: !1,
            success: function(t) {
                var a = 2 != t.data && t.data;
                console.log("分销"), console.log(t.data), e.setData({
                    open_distribution: a
                });
            }
        });
    },
    onReady: function() {
        app.getNavList("");
    },
    changereduce: function(t) {
        var a = this.data.reduceBtn;
        this.setData({
            reduceBtn: !a
        });
    },
    changecard: function(t) {
        var a = this.data.cardBtn;
        this.setData({
            cardBtn: !a
        });
    },
    onShow: function() {
        for (var a = this, t = app.globalData.tabBarList, e = wx.getStorageSync("tab"), n = 0; n < t.length; n++) t[n].state = !1;
        console.log(e), console.log(t), 1 == e.is_fbopen ? t[4].state = !0 : t[2].state = !0, 
        a.setData({
            tabBarList: t,
            is_show: e.is_fbopen
        });
        var o = wx.getStorageSync("userid");
        app.util.request({
            url: "entry/wxapp/Personal",
            cachetime: "0",
            data: {
                openid: o
            },
            success: function(t) {
                a.setData({
                    user: t.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/Userdynce",
            cachetime: "0",
            data: {
                openid: o
            },
            success: function(t) {
                console.log(t.data), a.setData({
                    img: t.data
                });
            }
        });
    },
    goMybalance: function() {
        wx.navigateTo({
            url: "../mybalance/mybalance"
        });
    },
    goIndex: function() {
        wx.reLaunch({
            url: "/ymktv_sun/pages/booking/index/index"
        });
    },
    goDrinks: function() {
        var t = wx.getStorageSync("bid");
        wx.reLaunch({
            url: "/ymktv_sun/pages/drinks/drinks/drinks?bid=" + t
        });
    },
    goDiscover: function() {
        wx.reLaunch({
            url: "/ymktv_sun/pages/discover/discover/discover"
        });
    },
    goPublish: function() {
        wx.reLaunch({
            url: "/ymktv_sun/pages/publish/publish/publish"
        });
    },
    orderTab: function(t) {
        var a = Number(t.currentTarget.dataset.id);
        this.setData({
            goId: a
        }), this.getNoPayOrder(a);
    },
    goAttention: function() {
        wx.navigateTo({
            url: "../attention/attention"
        });
    },
    goMgfans: function() {
        wx.navigateTo({
            url: "../mgfans/mgfans"
        });
    },
    goMyorder: function() {
        wx.navigateTo({
            url: "../myorder/myorder"
        });
    },
    goMyreduce: function() {
        wx.navigateTo({
            url: "../myreduce/myreduce"
        });
    },
    goMyreduceses: function() {
        wx.navigateTo({
            url: "../myreduceses/myreduceses"
        });
    },
    goMycollect: function() {
        wx.navigateTo({
            url: "../mycollect/mycollect"
        });
    },
    goMydance: function() {
        wx.navigateTo({
            url: "../mydance/mydance"
        });
    },
    goGiftindex: function() {
        wx.navigateTo({
            url: "../giftindex/giftindex"
        });
    },
    goAboutus: function() {
        wx.navigateTo({
            url: "../aboutus/aboutus"
        });
    },
    goMysell: function() {
        wx.navigateTo({
            url: "../admin/admin"
        });
    },
    goMybooking: function() {
        wx.navigateTo({
            url: "../mybooking/mybooking"
        });
    },
    goMygift: function() {
        wx.navigateTo({
            url: "../mygift/mygift"
        });
    },
    goMycard: function() {
        wx.navigateTo({
            url: "../mygiftdata/mygiftdata"
        });
    },
    toFxCenter: function(t) {
        this.data.open_distribution;
        var a = wx.getStorageSync("openid"), e = t.detail.formId, n = wx.getStorageSync("users");
        app.util.request({
            url: "entry/wxapp/IsPromoter",
            data: {
                openid: a,
                form_id: e,
                uid: n.id,
                status: 3,
                m: app.globalData.Plugin_distribution
            },
            showLoading: !1,
            success: function(t) {
                t && 9 != t.data ? 0 == t.data ? wx.navigateTo({
                    url: "/ymktv_sun/plugin/distribution/fxAddShare/fxAddShare"
                }) : wx.navigateTo({
                    url: "/ymktv_sun/plugin/distribution/fxCenter/fxCenter"
                }) : wx.navigateTo({
                    url: "/ymktv_sun/plugin/distribution/fxAddShare/fxAddShare"
                });
            }
        });
    }
});