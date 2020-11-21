var t = new getApp(), a = t.siteInfo.uniacid, e = t.util.getNewUrl("entry/wxapp/pt", "kundian_farm_plugin_pt");

Page({
    data: {
        SystemInfo: t.globalData.sysData,
        isIphoneX: t.globalData.isIphoneX,
        current: 0,
        imgList: [],
        types: [],
        currentType: 0,
        groupList: [],
        page: 1,
        farmSetData: [],
        is_tarbar: !1,
        cardCur: "index"
    },
    onLoad: function(t) {
        var i = this, r = !1;
        t.is_tarbar && (r = t.is_tarbar), i.setData({
            tarbar: wx.getStorageSync("kundianFarmTarbar"),
            is_tarbar: r
        });
        var n = wx.getStorageSync("kundian_farm_setData");
        wx.showLoading({
            title: "玩命加载中..."
        }), wx.request({
            url: e,
            data: {
                op: "getPtIndex",
                action: "index",
                uniacid: a,
                type_id: 0
            },
            success: function(t) {
                i.setData({
                    imgList: t.data.slideData,
                    types: t.data.typeData,
                    groupList: t.data.goodsData,
                    farmSetData: n
                }), wx.hideLoading();
            }
        });
    },
    currentIndex: function(t) {
        var a = t.detail.current;
        this.setData({
            current: a
        });
    },
    cardSwiper: function(t) {
        this.setData({
            cardCur: t.detail.current
        });
    },
    getPtList: function(t) {
        var i = this, r = i.data, n = r.currentType, s = r.groupList;
        wx.request({
            url: e,
            data: {
                op: "getPtList",
                action: "index",
                type_id: n,
                uniacid: a,
                page: t
            },
            success: function(a) {
                var e = a.data.goodsData;
                t > 1 ? e.lenght > 0 && e.map(function(t) {
                    s.push(t);
                }) : s = e, i.setData({
                    groupList: s,
                    page: t
                });
            }
        });
    },
    selectedType: function(t) {
        var a = t.currentTarget.dataset.type;
        this.data.currentType != a && (this.setData({
            currentType: a
        }), this.getPtList(1));
    },
    onReachBottom: function(t) {
        this.getPtList(parseInt(this.data.page) + 1);
    },
    intoDetail: function(t) {
        var a = t.currentTarget.dataset.goodsid;
        wx.navigateTo({
            url: "../details/index?goodsid=" + a
        });
    },
    toSlide: function(t) {
        var a = t.currentTarget.dataset, e = a.linktype, i = a.linkparam;
        0 == i || "" == i ? wx.navigateTo({
            url: "/" + e
        }) : wx.navigateTo({
            url: "/" + i
        });
    }
});