var app = getApp(), Page = require("../../../zhy/sdk/qitui/oddpush.js").oddPush(Page).Page;

Page({
    data: {
        show: [ {
            status: !0
        }, {
            status: !0
        } ],
        whichone: 4,
        open_distribution: !1
    },
    onLoad: function(t) {
        app.editTabBar();
        var e = this;
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url", t.data), e.setData({
                    url: t.data
                });
            }
        }), wx.getUserInfo({
            success: function(t) {
                e.setData({
                    thumb: t.userInfo.avatarUrl,
                    nickname: t.userInfo.nickName
                });
            }
        }), wx.getStorage({
            key: "openid",
            success: function(t) {
                app.util.request({
                    url: "entry/wxapp/MoneyData",
                    cachetime: "0",
                    data: {
                        uid: t.data
                    },
                    success: function(t) {
                        if (console.log(t.data.data), null == t.data.data.money) var a = 0; else a = t.data.data.money;
                        e.setData({
                            umoney: a
                        });
                    }
                });
            }
        }), app.util.request({
            url: "entry/wxapp/Shop",
            cachetime: "0",
            success: function(t) {
                console.log(t.data), e.setData({
                    shopData: t.data.data
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
    onShow: function() {
        var a = this;
        wx.getStorage({
            key: "address",
            success: function(t) {
                a.setData({
                    hasAddress: !0,
                    address: t.data
                });
            }
        }), this.onLoad();
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    toOrder: function(t) {
        wx.navigateTo({
            url: "orderlist/orderlist"
        });
    },
    toUcenter: function(t) {
        wx.navigateTo({
            url: "ucenter/ucenter"
        });
    },
    toIntegral: function(t) {
        wx.navigateTo({
            url: "integral/integral"
        });
    },
    toCards: function(t) {
        wx.navigateTo({
            url: "cards/cards"
        });
    },
    toMyorder: function(t) {
        wx.navigateTo({
            url: "myorder/myorder"
        });
    },
    toBargain: function(t) {
        wx.navigateTo({
            url: "bargain/bargain"
        });
    },
    toBgorder: function(t) {
        wx.navigateTo({
            url: "bgorder/bgorder"
        });
    },
    toRecharge: function(t) {
        wx.navigateTo({
            url: "recharge/recharge"
        });
    },
    toBackstage: function(t) {
        wx.navigateTo({
            url: "../backstage/backstage"
        });
    },
    toggle: function(t) {
        var a = t.currentTarget.dataset.status, e = t.currentTarget.dataset.index, n = this.data.show;
        n[e].status = !a, this.setData({
            show: n
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
                    url: "/ymmf_sun/plugin/distribution/fxAddShare/fxAddShare"
                }) : wx.navigateTo({
                    url: "/ymmf_sun/plugin/distribution/fxCenter/fxCenter"
                }) : wx.navigateTo({
                    url: "/ymmf_sun/plugin/distribution/fxAddShare/fxAddShare"
                });
            }
        });
    }
});