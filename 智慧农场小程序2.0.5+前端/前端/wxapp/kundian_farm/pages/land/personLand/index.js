var a = new getApp(), t = a.siteInfo.uniacid;

Page({
    data: {
        currentState: "1",
        allLands: [],
        currentLand: [],
        page: 1,
        landData: [],
        farmSetData: [],
        currentIndex: "全部",
        is_load: !0,
        renew_low_time: []
    },
    onLoad: function(n) {
        this.setData({
            currentLand: this.data.allLands
        });
        var e = this, d = wx.getStorageSync("kundian_farm_uid");
        e.data.currentState;
        0 != d ? e.getLandData() : wx.redirectTo({
            url: "../../../login/index"
        }), a.util.setNavColor(t), e.setData({
            farmSetData: wx.getStorageSync("kundian_farm_setData")
        });
    },
    getLandData: function() {
        var n = this, e = wx.getStorageSync("kundian_farm_uid"), d = n.data.currentState;
        a.util.request({
            url: "entry/wxapp/class",
            data: {
                op: "getMineLand",
                control: "land",
                uid: e,
                uniacid: t,
                current: d
            },
            success: function(a) {
                a.data.landData.length > 0 ? n.setData({
                    landData: a.data.landData,
                    is_load: !0,
                    renew_low_time: a.data.renew_low_time
                }) : n.setData({
                    is_load: !1
                });
            }
        });
    },
    changeState: function(a) {
        var t = this, n = [], e = a.currentTarget.dataset.state;
        t.data.allLands.map(function(a) {
            "1" === e ? n.push(a) : "2" === e ? a.plant.length > 0 && n.push(a) : "3" === e && 0 == a.plant.length && n.push(a);
        }), t.setData({
            currentState: e,
            currentLand: n
        }), t.getLandData();
    },
    intoMineLandDetail: function(a) {
        var t = a.currentTarget.dataset.lid;
        if (2 == a.currentTarget.dataset.landstatus) return wx.showModal({
            title: "提示",
            content: "您的土地已过期",
            showCancel: !1
        }), !1;
        wx.navigateTo({
            url: "/kundian_farm/pages/land/mineLandDetail/index?lid=" + t
        });
    },
    gotoBuy: function(a) {
        wx.navigateTo({
            url: "../../../land/landList/index"
        });
    },
    onReachBottom: function(n) {
        var e = this, d = wx.getStorageSync("kundian_farm_uid"), r = e.data, i = r.currentState, u = r.page, l = r.landData;
        a.util.request({
            url: "entry/wxapp/land",
            data: {
                op: "getMineLand",
                uid: d,
                uniacid: t,
                current: i,
                page: u
            },
            success: function(a) {
                if (a.data.landData) {
                    for (var t = a.data.landData, n = 0; n < t.length; n++) l.push(t[n]);
                    e.setData({
                        landData: l,
                        page: parseInt(u) + 1
                    });
                }
            }
        });
    },
    intoBag: function(a) {
        var t = a.detail.formId;
        wx.navigateTo({
            url: "/kundian_farm/pages/land/seedBag/index?formid=" + t
        });
    },
    landRenew: function(a) {
        var t = a.currentTarget.dataset.landid;
        wx.navigateTo({
            url: "/kundian_farm/pages/user/land/payFor/index?land_id=" + t + "&is_renew=2"
        });
    }
});