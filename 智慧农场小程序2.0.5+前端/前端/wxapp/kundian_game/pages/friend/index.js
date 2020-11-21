!function(a) {
    a && a.__esModule;
}(require("../../utils/util.js"));

var a = getApp(), t = void 0, e = a.siteInfo.uniacid;

Page({
    data: {
        isIphoneX: a.globalData.isIphoneX,
        statusBarHeight: a.globalData.statusBarHeight,
        titleBarHeight: a.globalData.titleBarHeight,
        showFriend: !1,
        screenHeight: 0,
        Proportion: 0,
        money: "10000.00",
        isFullScreen: !1,
        userAppid: 123456789,
        steal: !1,
        stealMoney: 0,
        showHome: !1,
        showIcon: !0,
        lands: [ {
            is_land_buy: 0,
            steal: !1,
            stealist: [],
            crops: []
        }, {
            is_land_buy: 0,
            steal: !1,
            stealist: [],
            crops: []
        }, {
            is_land_buy: 0,
            steal: !1,
            stealist: [],
            crops: []
        }, {
            is_land_buy: 0,
            steal: !1,
            stealist: [],
            crops: []
        }, {
            is_land_buy: 0,
            steal: !1,
            stealist: [],
            crops: []
        }, {
            is_land_buy: 0,
            steal: !1,
            stealist: [],
            crops: []
        }, {
            is_land_buy: 0,
            steal: !1,
            stealist: [],
            crops: []
        }, {
            is_land_buy: 0,
            steal: !1,
            stealist: [],
            crops: []
        }, {
            is_land_buy: 0,
            steal: !1,
            stealist: [],
            crops: []
        } ],
        friend_uid: "",
        kundianPlaySet: [],
        user: [],
        friendList: []
    },
    onLoad: function(t) {
        var i = this, n = t.friend_uid;
        this.setData({
            screenHeight: a.globalData.screenHeight,
            isFullScreen: a.globalData.isFullScreen,
            Proportion: a.globalData.Proportion,
            friend_uid: n
        }), this.getHomeData(n);
        var s = wx.getStorageSync("kundian_farm_uid"), r = a.util.getNewUrl("entry/wxapp/game", "kundian_farm_plugin_play"), d = "";
        t.form_id && (d = t.form_id), wx.request({
            url: r,
            data: {
                op: "visitFriend",
                action: "friend",
                uid: s,
                friend_uid: n,
                uniacid: e,
                form_id: d
            },
            success: function(a) {
                i.setData({
                    user: a.data.user,
                    friendList: a.data.friendList
                }), 0 == a.data.code && wx.showToast({
                    title: a.data.msg,
                    icon: "none"
                });
            }
        }), a.util.setNavColor(e);
    },
    getHomeData: function(t) {
        var i = this, n = a.util.getNewUrl("entry/wxapp/game", "kundian_farm_plugin_play");
        wx.request({
            url: n,
            data: {
                op: "getHomeData",
                action: "land",
                uniacid: e,
                uid: t
            },
            success: function(a) {
                var t = a.data.playSet;
                wx.setStorageSync("kundianPlaySet", t);
                var e = a.data.allLand;
                i.steal(e), i.setData({
                    lands: e,
                    kundianPlaySet: t
                });
            }
        });
    },
    run: function() {
        var a = this, e = !1;
        t = setTimeout(function() {
            e = !a.data.isrun, a.setData({
                isrun: e
            }), a.run();
        }, 700);
    },
    steal: function(a) {
        var t = wx.getStorageSync("kundian_farm_uid");
        a.map(function(a) {
            a.stealist.map(function(e) {
                e.visit_uid == t && (a.steal = !0);
            });
        }), this.setData({
            lands: a
        });
    },
    mature: function(t) {
        var i = t.currentTarget.dataset.id, n = this.data.lands, s = n.findIndex(function(a) {
            return a.id == i;
        }), r = this, d = wx.getStorageSync("kundian_farm_uid"), o = r.data.friend_uid, u = a.util.getNewUrl("entry/wxapp/game", "kundian_farm_plugin_play");
        wx.request({
            url: u,
            data: {
                op: "matureFriendLand",
                action: "friend",
                uid: o,
                friend_uid: d,
                uniacid: e,
                plant_id: i
            },
            success: function(a) {
                if (-1 == a.data.code) return wx.showModal({
                    title: "提示",
                    content: a.data.msg,
                    showCancel: !1
                }), !1;
                wx.showToast({
                    title: "偷取好友种植成功获得" + a.data.gold + "元",
                    icon: "none"
                }), n[s].steal = !0, n[s].animation = !0, n[s].money = a.data.gold, r.setData({
                    lands: n
                });
            }
        });
    },
    checkFriend: function() {
        var a = this.data.showFriend;
        this.setData({
            showFriend: !a
        });
    },
    visited: function(a) {
        var t = this, e = a.detail.formId, i = a.currentTarget.dataset.frienduid;
        wx.redirectTo({
            url: "../friend/index?friend_uid=" + i + "&form_id=" + e,
            success: function(a) {
                t.setData({
                    showFriend: !1
                });
            }
        });
    },
    shopMall: function() {
        wx.navigateTo({
            url: "../reflect/index"
        });
    },
    goBack: function() {
        wx.reLaunch({
            url: "../farm/index"
        });
    },
    onShow: function() {
        this.run();
    },
    onHide: function() {
        clearTimeout(t);
    },
    onShareAppMessage: function(a) {
        a.from;
        var t = wx.getStorageSync("kundian_farm_uid");
        return {
            title: this.data.kundianPlaySet.farm_share_title,
            path: "kundian_game/pages/farm/index?share_uid=" + t
        };
    }
});