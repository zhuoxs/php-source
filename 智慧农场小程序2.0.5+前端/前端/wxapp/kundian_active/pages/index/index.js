var t = new getApp(), a = t.siteInfo.uniacid, e = t.util.url("entry/wxapp/class") + "m=kundian_farm_plugin_active";

Page({
    data: {
        SystemInfo: t.globalData.sysData,
        isIphoneX: t.globalData.isIphoneX,
        activeList: [],
        page: 1,
        activeSet: [],
        currentIndex: 1,
        farmSetData: [],
        tarbar: wx.getStorageSync("kundianFarmTarbar"),
        is_tarbar: !1,
        isContent: !0
    },
    onLoad: function(e) {
        t.util.getUserInfo();
        var i = !1;
        e.is_tarbar && (i = e.is_tarbar);
        var n = wx.getStorageSync("kundian_farm_setData");
        this.setData({
            farmSetData: n,
            tarbar: wx.getStorageSync("kundianFarmTarbar"),
            is_tarbar: i
        }), this.getActiveData(1, 1, 0), t.util.setNavColor(a), wx.checkSession({
            success: function(t) {},
            fail: function(t) {
                wx.login();
            }
        });
    },
    getActiveData: function(t, i, n) {
        wx.showLoading({
            title: "玩命加载中...."
        });
        var r = this, s = r.data.activeList;
        wx.request({
            url: e,
            data: {
                action: "active",
                op: "getActiveList",
                uniacid: a,
                page: t,
                current: i
            },
            success: function(a) {
                if (a.data.activeList) {
                    var e = a.data.activeList;
                    1 == n ? e.map(function(t) {
                        s.push(t);
                    }) : (s = e, t = 1), r.setData({
                        activeList: s,
                        page: t,
                        activeSet: a.data.activeSetData
                    }), wx.stopPullDownRefresh();
                } else r.setData({
                    activeSet: a.data.activeSetData,
                    isContent: !1
                });
                wx.setStorageSync("kundian_farm_active_set", a.data.activeSetData), wx.hideLoading();
            }
        });
    },
    onReachBottom: function(t) {
        var a = parseInt(this.data.page) + 1, e = this.data.currentIndex;
        this.getActiveData(a, e, 1);
    },
    onPullDownRefresh: function(t) {
        var a = this.data.currentIndex;
        this.getActiveData(1, a, 0);
    },
    intoActiveDetail: function(t) {
        var a = t.currentTarget.dataset.activeid;
        console.log(a), wx.navigateTo({
            url: "../details/index?activeid=" + a
        });
    },
    changeIndex: function(t) {
        var a = t.currentTarget.dataset.index;
        this.getActiveData(1, a, 0), this.setData({
            currentIndex: a
        });
    },
    onShareAppMessage: function(t) {}
});