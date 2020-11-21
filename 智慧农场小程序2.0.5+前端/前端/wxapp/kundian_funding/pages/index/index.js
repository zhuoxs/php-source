var t = new getApp(), a = t.util.url("entry/wxapp/funding") + "m=kundian_farm_plugin_funding";

Page({
    data: {
        SystemInfo: t.globalData.sysData,
        isIphoneX: t.globalData.isIphoneX,
        page: 1,
        project: [],
        farmSetData: [],
        currentIndex: 1,
        tarbar: wx.getStorageSync("kundianFarmTarbar"),
        is_tarbar: !1,
        isContent: !0
    },
    onLoad: function(t) {
        var a = !1;
        t.is_tarbar && (a = t.is_tarbar);
        var e = wx.getStorageSync("kundian_farm_setData");
        this.setData({
            farmSetData: e,
            tarbar: wx.getStorageSync("kundianFarmTarbar"),
            is_tarbar: a
        }), this.getProjectData(1, 1, 0);
    },
    getProjectData: function(t, e, r) {
        var n = this, o = n.data.project;
        wx.request({
            url: a,
            data: {
                op: "getProject",
                control: "project",
                page: e,
                current: t
            },
            success: function(t) {
                if (t.data.project) {
                    var a = t.data.project;
                    1 == r ? a.map(function(t) {
                        o.push(t);
                    }) : (o = a, e = 1), wx.stopPullDownRefresh(), n.setData({
                        project: o,
                        page: e
                    });
                } else 1 != r && n.setData({
                    isContent: !1
                });
            }
        });
    },
    onPullDownRefresh: function(t) {
        var a = this.data.currentIndex;
        this.getProjectData(a, 1, 0);
    },
    intoProjectDetail: function(t) {
        var a = t.currentTarget.dataset.id;
        wx.navigateTo({
            url: "../prodetail/index?pid=" + a
        });
    },
    changeIndex: function(t) {
        var a = t.currentTarget.dataset.index;
        this.getProjectData(a, 1, 0), this.setData({
            currentIndex: a
        });
    },
    onReachBottom: function(t) {
        var a = parseInt(this.data.page) + 1, e = this.data.currentIndex;
        this.getProjectData(e, a, 1);
    },
    onShareAppMessage: function(t) {}
});