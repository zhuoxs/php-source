var a = new getApp(), t = a.siteInfo.uniacid;

Page({
    data: {
        currentIndex: "6",
        isInput: !1,
        page: 1,
        landData: [],
        plate: 1,
        animalData: [],
        config: []
    },
    onLoad: function(e) {
        a.util.setNavColor(t);
        var n = this.data.currentIndex, i = e.plate;
        this.getInitData(this, t, n, i), this.setData({
            config: wx.getStorageSync("kundian_farm_setData")
        });
    },
    changeIndex: function(a) {
        var e = this.data.plate, n = a.currentTarget.dataset.index;
        this.getInitData(this, t, n, e), this.setData({
            currentIndex: n
        });
    },
    getInitData: function(t, e, n, i) {
        wx.showLoading({
            title: "玩命加载中..."
        }), 1 == i ? a.util.request({
            url: "entry/wxapp/class",
            data: {
                op: "getLand",
                action: "land",
                control: "seller",
                uniacid: e,
                current: n
            },
            success: function(a) {
                t.setData({
                    landData: a.data.landData,
                    page: 1,
                    plate: i
                }), wx.hideLoading();
            }
        }) : a.util.request({
            url: "entry/wxapp/class",
            data: {
                op: "getAnimal",
                action: "adopt",
                control: "seller",
                uniacid: e,
                current: n
            },
            success: function(a) {
                t.setData({
                    animalData: a.data.animalData,
                    page: 1,
                    plate: i
                }), wx.setNavigationBarTitle({
                    title: "认养管理"
                }), wx.hideLoading();
            }
        });
    },
    isInput: function() {
        this.setData({
            isInput: !0
        });
    },
    onReachBottom: function(e) {
        var n = this, i = n.data, l = i.currentIndex, s = i.page;
        if (1 == i.plate) {
            var r = n.data.landData;
            a.util.request({
                url: "entry/wxapp/class",
                data: {
                    op: "getLand",
                    action: "land",
                    control: "seller",
                    uniacid: t,
                    current: l,
                    page: s
                },
                success: function(a) {
                    a.data.landData && (a.data.landData.map(function(a) {
                        r.push(a);
                    }), n.setData({
                        landData: r,
                        page: parseInt(s) + 1
                    }));
                }
            });
        } else {
            var d = n.data.animalData;
            a.util.request({
                url: "entry/wxapp/class",
                data: {
                    op: "getAnimal",
                    action: "adopt",
                    control: "seller",
                    uniacid: t,
                    current: l,
                    page: s
                },
                success: function(a) {
                    a.data.animalData && (a.data.animalData.map(function(a) {
                        d.push(a);
                    }), n.setData({
                        animalData: d,
                        page: parseInt(s) + 1
                    }));
                }
            });
        }
    },
    intoLandDetail: function(a) {
        var t = this.data.plate;
        if (1 == t) {
            var e = a.currentTarget.dataset.mineid;
            wx.navigateTo({
                url: "../myLand/index?mineid=" + e + "&plate=" + t
            });
        } else {
            var n = a.currentTarget.dataset.adoptid;
            wx.navigateTo({
                url: "../myLand/index?adoptid=" + n + "&plate=" + t
            });
        }
    },
    weeding: function(e) {
        var n = this, i = e.currentTarget.dataset.lid, l = this.data.plate;
        a.util.request({
            url: "entry/wxapp/class",
            data: {
                op: "weeding",
                action: "land",
                control: "seller",
                lid: i,
                uniacid: t
            },
            success: function(a) {
                wx.showModal({
                    title: "提示",
                    content: a.data.msg,
                    showCancel: !1,
                    confirmText: "朕知道了"
                }), n.getInitData(n, t, n.data.currentIndex, l);
            }
        });
    },
    killVer: function(e) {
        var n = this, i = e.currentTarget.dataset.lid, l = this.data.plate;
        a.util.request({
            url: "entry/wxapp/class",
            data: {
                op: "killVer",
                action: "land",
                control: "seller",
                lid: i,
                uniacid: t
            },
            success: function(a) {
                wx.showModal({
                    title: "提示",
                    content: a.data.msg,
                    showCancel: !1,
                    confirmText: "朕知道了"
                }), n.getInitData(n, t, n.data.currentIndex, l);
            }
        });
    }
});