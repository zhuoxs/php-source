var a = new getApp(), t = a.siteInfo.uniacid;

Page({
    data: {
        SystemInfo: a.globalData.sysData,
        isIphoneX: a.globalData.isIphoneX,
        landType: [],
        currentLand: [],
        currentIndex: 1,
        page: 1,
        tarbar: wx.getStorageSync("kundianFarmTarbar"),
        is_tarbar: !0,
        farmSetData: wx.getStorageSync("kundian_farm_setData"),
        isContent: !0
    },
    onLoad: function(n) {
        var e = this, r = n.is_tarbar || !1, i = wx.getStorageSync("kundianFarmTarbar");
        if (e.setData({
            is_tarbar: r,
            tarbar: i
        }), wx.showLoading({
            title: "玩命加载中"
        }), a.util.request({
            url: "entry/wxapp/class",
            data: {
                op: "getLandList",
                uniacid: t,
                control: "land"
            },
            success: function(a) {
                var t = a.data, n = t.landType, r = t.landData, i = !0;
                0 == r.length && (i = !1), e.setData({
                    landType: n,
                    currentLand: r,
                    currentIndex: n[0].id || 1,
                    isContent: i
                }), wx.hideLoading();
            }
        }), a.util.setNavColor(t), n.is_play) {
            var d = n.is_play;
            wx.setStorageSync("enter_is_play", d);
        } else wx.removeStorageSync("entry_is_play");
    },
    changeArea: function(a) {
        var t = a.currentTarget.dataset.id;
        this.getLandData(t, 0, 1);
    },
    getLandData: function(n, e, r) {
        var i = this;
        r = parseInt(r) + 1, 1 != e && (r = 1), a.util.request({
            url: "entry/wxapp/class",
            data: {
                op: "getLandByType",
                control: "land",
                uniacid: t,
                type_id: n,
                page: r
            },
            success: function(a) {
                if (1 == e) {
                    var t = i.data.currentLand;
                    a.data.landData && (a.data.landData.map(function(a) {
                        t.push(a);
                    }), i.setData({
                        currentLand: t,
                        page: r,
                        currentIndex: n
                    }));
                } else {
                    var d = !0;
                    0 == a.data.landData.length && (d = !1), i.setData({
                        currentLand: a.data.landData,
                        currentIndex: n,
                        page: 1,
                        isContent: d
                    });
                }
            }
        });
    },
    onReachBottom: function(a) {
        var t = this.data, n = t.page, e = t.currentIndex;
        this.getLandData(e, 1, n);
    },
    intoLandDetail: function(a) {
        var t = a.currentTarget.dataset.lid;
        wx.navigateTo({
            url: "../landDetails/index?lid=" + t
        });
    },
    onShow: function(a) {
        var t = wx.getStorageSync("kundianFarmTarbar");
        this.setData({
            tarbar: t
        });
    }
});