var t = new getApp(), a = t.util.getNewUrl("entry/wxapp/store", "kundian_farm_plugin_store");

Page({
    data: {
        slide: [],
        cardCur: 0,
        page: 1,
        store: [],
        lat: "",
        lng: "",
        name: "",
        setData: []
    },
    onLoad: function(a) {
        var e = this, n = wx.getStorageSync("kundian_farm_setData");
        t.util.setNavColor(t.siteInfo.uniacid), e.setData({
            setData: n
        }), wx.getLocation({
            success: function(t) {
                e.setData({
                    lat: t.latitude,
                    lng: t.longitude
                }), e.getInit();
            },
            fail: function(t) {
                console.log(t), e.getInit();
            }
        });
    },
    getInit: function(t) {
        wx.showLoading({
            title: "玩命加载中..."
        });
        var e = this, n = e.data, i = n.lng, o = n.lat;
        wx.request({
            url: a,
            data: {
                control: "index",
                op: "homeData",
                lat: o,
                lng: i
            },
            success: function(t) {
                wx.hideLoading(), e.setData({
                    slide: t.data.slide,
                    store: t.data.store,
                    page: 1
                }), wx.stopPullDownRefresh();
            }
        });
    },
    onPullDownRefresh: function() {
        this.getInit();
    },
    cardSwiper: function(t) {
        this.setData({
            cardCur: t.detail.current
        });
    },
    searchStore: function(t) {
        var e = this, n = t.detail.value.name, i = e.data, o = i.lng, r = i.lat;
        wx.request({
            url: a,
            data: {
                control: "index",
                op: "homeData",
                lat: r,
                lng: o,
                name: n
            },
            success: function(t) {
                e.setData({
                    store: t.data.store,
                    name: n,
                    page: 1
                });
            }
        });
    },
    toDetail: function(t) {
        var a = t.currentTarget.dataset.storeid;
        wx.navigateTo({
            url: "../detail/index?store_id=" + a
        });
    },
    toSlide: function(t) {
        var a = t.currentTarget.dataset, e = a.linktype, n = a.linkparam;
        0 == e || 0 == n ? 0 != e && wx.navigateTo({
            url: "/" + e
        }) : wx.navigateTo({
            url: "/" + n
        });
    },
    toAppply: function() {
        wx.navigateTo({
            url: "../apply/index"
        });
    },
    onShareAppMessage: function() {}
});