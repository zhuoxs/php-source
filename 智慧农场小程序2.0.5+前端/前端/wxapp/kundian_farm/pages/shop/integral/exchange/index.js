var a = new getApp(), t = require("../../../../utils/util.js"), e = a.siteInfo.uniacid;

Page({
    data: {
        SystemInfo: a.globalData.sysData,
        isIphoneX: a.globalData.isIphoneX,
        types: [],
        exchanges: [],
        userData: [],
        slideData: [],
        arr: [],
        scrollTop: 0,
        tarrHight: [],
        farmSetData: [],
        tarbar: wx.getStorageSync("kundianFarmTarbar"),
        is_tarbar: !1
    },
    onLoad: function(t) {
        var r = !1;
        t.is_tarbar && (r = t.is_tarbar), this.setData({
            farmSetData: wx.getStorageSync("kundian_farm_setData"),
            tarbar: wx.getStorageSync("kundianFarmTarbar"),
            is_tarbar: r
        }), this.getIntegralData(), a.util.setNavColor(e);
    },
    getIntegralData: function(r) {
        var n = this, i = wx.getStorageSync("kundian_farm_uid");
        a.util.request({
            url: "entry/wxapp/class",
            data: {
                op: "getIntrgralData",
                uid: i,
                uniacid: e,
                control: "integral"
            },
            success: function(a) {
                var e = a.data, r = e.typeData, i = e.userData, o = e.recommendData, s = e.slideData;
                n.setData({
                    types: r,
                    userData: i,
                    exchanges: o,
                    slideData: s
                }), t.computeHeight(n, o, 2);
            }
        });
    },
    onShow: function(a) {
        this.getIntegralData();
    },
    onPageScroll: function(a) {
        for (var t = this, e = a.scrollTop, r = t.data, n = r.tarrHight, i = r.arr, o = r.exchanges, s = 0; s < o.length; s++) n[s] < e && 0 == i[s] && (i[s] = !0);
        t.setData({
            arr: i,
            scrollTop: e
        });
    },
    intoDetail: function(a) {
        var t = a.currentTarget.dataset.goodsid;
        wx.navigateTo({
            url: "../exchangedetails/index?goods_id=" + t
        });
    },
    intoExchangeList: function(a) {
        var t = a.currentTarget.dataset.typeid;
        wx.navigateTo({
            url: "../exchange_list/index?type_id=" + t
        });
    },
    intoIntegralRecord: function(a) {
        wx.navigateTo({
            url: "../orderList/index"
        });
    },
    intoDetailSlide: function(a) {
        var t = a.currentTarget.dataset, e = t.linktype, r = t.linkparam;
        0 == r || "" == r ? wx.navigateTo({
            url: "/" + e
        }) : wx.navigateTo({
            url: "/" + r
        });
    },
    intoIntegral: function(a) {
        wx.navigateTo({
            url: "../record/index"
        });
    }
});