var a = new getApp(), t = require("../../../utils/util.js"), e = a.siteInfo.uniacid;

Page({
    data: {
        SystemInfo: a.globalData.sysData,
        isIphoneX: a.globalData.isIphoneX,
        classify: 1,
        Adopt: [],
        typeData: [],
        recommendData: [],
        user_id: 0,
        newGoodsData: [],
        page: 1,
        farmSetData: [],
        tarbar: wx.getStorageSync("kundianFarmTarbar"),
        is_tarbar: !1
    },
    onLoad: function(t) {
        var n = this, r = t.is_tarbar || !1, o = wx.getStorageSync("kundianFarmTarbar");
        n.setData({
            tarbar: o,
            is_tarbar: r,
            farmSetData: wx.getStorageSync("kundian_farm_setData")
        });
        var i = wx.getStorageSync("kundian_farm_uid");
        wx.showLoading({
            title: "玩命加载中..."
        }), a.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "shop",
                op: "index",
                uniacid: e,
                uid: i
            },
            success: function(a) {
                var t = a.data, e = t.slideData, r = t.typeData, o = t.recommendData;
                n.setData({
                    Adopt: e,
                    typeData: r,
                    recommendData: o
                }), wx.hideLoading();
            }
        }), a.util.setNavColor(e);
        var s = t.user_uid;
        void 0 != s && 0 != s && (a.loginBindParent(s, i), n.setData({
            user_uid: s
        }));
    },
    onShow: function(t) {
        var e = this, n = this.data.user_uid, r = wx.getStorageSync("kundian_farm_uid");
        void 0 != n && 0 != n && (a.loginBindParent(n, r), e.setData({
            user_uid: n
        }));
    },
    intoGoodsList: function(a) {
        var t = a.currentTarget.dataset, e = t.typeid;
        t.urltype;
        wx.navigateTo({
            url: "../proList/index?type_id=" + e
        });
    },
    selectGoods: function(a) {
        wx.navigateTo({
            url: "../search/index"
        });
    },
    intoGoodsDetail: function(a) {
        var t = a.currentTarget.dataset.goodsid;
        wx.navigateTo({
            url: "../prodeteils/index?goodsid=" + t
        });
    },
    intoDetailSlide: function(a) {
        var t = a.currentTarget.dataset, e = t.linktype, n = t.linkparam;
        0 == n || "" == n ? wx.navigateTo({
            url: "/" + e
        }) : wx.navigateTo({
            url: "/" + n
        });
    },
    onShareAppMessage: function() {
        var a = wx.getStorageSync("kundian_farm_setData");
        return {
            path: "/kundian_farm/pages/shop/index/index?&user_uid=" + wx.getStorageSync("kundian_farm_uid"),
            success: function(a) {},
            title: a.share_shop_title
        };
    },
    onPullDownRefresh: function(n) {
        var r = this, o = wx.getStorageSync("kundian_farm_uid");
        a.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "index",
                uniacid: e,
                op: "getCommonData"
            },
            success: function(n) {
                var i = n.data, s = i.tarbar, d = i.farmSetData;
                wx.setStorageSync("kundianFarmTarbar", s), wx.setStorageSync("kundian_farm_setData", d), 
                r.setData({
                    tarbar: s,
                    farmSetData: d
                }), a.util.request({
                    url: "entry/wxapp/class",
                    data: {
                        control: "shop",
                        op: "index",
                        uniacid: e,
                        uid: o
                    },
                    success: function(a) {
                        var e = a.data, n = e.slideData, o = e.typeData, i = e.recommendData;
                        r.setData({
                            Adopt: n,
                            typeData: o,
                            recommendData: i
                        }), t.computeHeight(r, i, 2), wx.stopPullDownRefresh();
                    }
                }), wx.stopPullDownRefresh(), wx.hideLoading();
            }
        });
    },
    changeType: function(a) {
        var t = a.currentTarget.dataset.index;
        this.getGoodsData(1, t), this.setData({
            classify: t
        });
    },
    getGoodsData: function(t, n, r) {
        var o = this, i = o.data, s = i.recommendData, d = i.newGoodsData;
        if (1 != r) if (1 == n) {
            if (s.length > 0) return !1;
        } else if (d.length > 0) return;
        a.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "shop",
                op: "getNewGoods",
                uniacid: e,
                page: t,
                classify: n
            },
            success: function(a) {
                if (1 == r) if (1 == n) {
                    var e = o.data.recommendData;
                    a.data.recommendData.map(function(a) {
                        e.push(a);
                    }), o.setData({
                        recommendData: e,
                        page: parseInt(t) + 1
                    });
                } else {
                    var i = o.data.newGoodsData;
                    a.data.newGoodsData.map(function(a) {
                        i.push(a);
                    }), o.setData({
                        newGoodsData: i,
                        page: parseInt(t) + 1
                    });
                } else 1 == n ? o.setData({
                    recommendData: a.data.recommendData,
                    page: 1
                }) : o.setData({
                    newGoodsData: a.data.newGoodsData,
                    page: 1
                });
            }
        });
    },
    onReachBottom: function(a) {
        var t = this.data.classify, e = parseInt(this.data.page) + 1;
        this.getGoodsData(e, t, 1);
    }
});