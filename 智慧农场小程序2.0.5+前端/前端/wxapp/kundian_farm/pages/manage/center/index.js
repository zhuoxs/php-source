var t = new getApp(), i = t.siteInfo.uniacid;

Page({
    data: {
        statistics: [],
        total_user: 0,
        farmSetData: [],
        is_active: 0,
        icon: [],
        plugin_pt: 0
    },
    onLoad: function(n) {
        var a = this;
        t.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "manager",
                op: "getStatisticsData",
                uniacid: i
            },
            success: function(t) {
                var i = t.data, n = i.statistics, e = i.total_user, o = i.is_active, r = i.icon, s = i.plugin_pt;
                a.setData({
                    statistics: n,
                    total_user: e,
                    is_active: o,
                    icon: r,
                    plugin_pt: s
                });
            }
        }), t.util.setNavColor(i), a.setData({
            farmSetData: wx.getStorageSync("kundian_farm_setData")
        });
    },
    intoAdminShopOrder: function(t) {
        wx.navigateTo({
            url: "../../manage/orderList/index?type=1"
        });
    },
    intoAdminGroupOrder: function(t) {
        wx.navigateTo({
            url: "../../manage/orderList/index?type=2"
        });
    },
    intoPtOrder: function(t) {
        wx.navigateTo({
            url: "../../manage/orderList/index?type=4"
        });
    },
    intoAdminIntegralOrder: function(t) {
        wx.navigateTo({
            url: "../../manage/orderList/index?type=3"
        });
    },
    intoAdminLandManager: function(t) {
        wx.navigateTo({
            url: "../myLandlist/index?plate=1"
        });
    },
    intoAdminAnimalManager: function(t) {
        wx.navigateTo({
            url: "../myLandlist/index?plate=2"
        });
    },
    intoAdminApply: function(t) {
        wx.navigateTo({
            url: "/kundian_farm/pages/manage/apply/index"
        });
    },
    testVideo: function(t) {
        wx.navigateTo({
            url: "/kundian_farm/pages/user/test/index"
        });
    },
    getSiteInfo: function(i) {
        var n = t.siteInfo;
        console.log(n);
        var a = "站点信息：uniacid=" + n.uniacid + ";acid=" + n.acid + ";multiid=" + n.multiid + ";version=" + n.version + ";siteroot=" + n.siteroot;
        wx.showModal({
            title: "提示",
            content: a,
            showCancel: !1
        });
    },
    intoDevice: function(t) {
        wx.navigateTo({
            url: "../device/index"
        });
    },
    intoRelays: function(t) {
        wx.navigateTo({
            url: "../relays/index"
        });
    },
    intoCheckActive: function(t) {
        wx.scanCode({
            success: function(t) {
                console.log(t.path);
                var i = "/" + t.path;
                wx.navigateTo({
                    url: i
                });
            }
        });
    }
});