!function(a) {
    a && a.__esModule;
}(require("../../utils/util.js"));

var a = getApp(), t = a.siteInfo.uniacid;

Page({
    data: {
        isIphoneX: a.globalData.isIphoneX,
        statusBarHeight: a.globalData.statusBarHeight,
        titleBarHeight: a.globalData.titleBarHeight,
        screenHeight: 0,
        Proportion: 0,
        money: "10000.00",
        isFullScreen: !1,
        showFriend: !1,
        animalList: [],
        clearTime: !1,
        currentInfo: {},
        noAnimal: !1,
        friendList: [],
        showHome: !1,
        showIcon: !0
    },
    onLoad: function(i) {
        var e = i.friend_uid, n = !1;
        this.setData({
            screenHeight: a.globalData.screenHeight,
            isFullScreen: a.globalData.isFullScreen,
            Proportion: a.globalData.Proportion
        });
        var r = this, s = a.util.getNewUrl("entry/wxapp/game", "kundian_farm_plugin_play"), o = wx.getStorageSync("kundian_farm_uid");
        wx.request({
            url: s,
            data: {
                op: "getMyAnimal",
                action: "animal",
                uid: e,
                uniacid: t
            },
            success: function(a) {
                0 == a.data.animalList.length && (n = !0), r.setData({
                    animalList: a.data.animalList,
                    userData: a.data.userData,
                    noAnimal: n
                });
            }
        });
        var u = a.util.getNewUrl("entry/wxapp/game", "kundian_farm_plugin_play");
        wx.request({
            url: u,
            data: {
                op: "visitFriend",
                action: "friend",
                uid: o,
                friend_uid: e,
                uniacid: t
            },
            success: function(a) {
                r.setData({
                    user: a.data.user,
                    friendList: a.data.friendList
                }), 0 == a.data.code && wx.showToast({
                    title: a.data.msg,
                    icon: "none"
                });
            }
        }), a.util.setNavColor(t);
    },
    animalDetail: function(a) {
        var t = [ a.detail, this.data.animalList ], i = t[0], e = t[1].find(function(a) {
            return a.id === i;
        });
        this.setData({
            currentInfo: e
        });
    },
    closeDetail: function() {
        this.setData({
            currentInfo: {}
        });
    },
    close: function() {
        this.setData({
            noAnimal: !1
        });
    },
    goBack: function() {
        wx.redirectTo({
            url: "../pasture/index"
        });
    },
    checkFriend: function(i) {
        if (this.setData({
            showFriend: !this.data.showFriend
        }), this.data.showFriend) {
            var e = this, n = wx.getStorageSync("kundian_farm_uid"), r = a.util.getNewUrl("entry/wxapp/game", "kundian_farm_plugin_play");
            wx.request({
                url: r,
                data: {
                    op: "getFriendInfo",
                    action: "friend",
                    uid: n,
                    uniacid: t
                },
                success: function(a) {
                    e.setData({
                        friendList: a.data.friendList
                    });
                }
            });
        }
    },
    visited: function(a) {
        var t = this, i = a.currentTarget.dataset.frienduid;
        wx.redirectTo({
            url: "../pasture_fri/index?friend_uid=" + i,
            success: function(a) {
                t.setData({
                    showFriend: !1
                });
            }
        });
    }
});