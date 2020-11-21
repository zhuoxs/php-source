var a = getApp(), t = a.requirejs("core");

a.requirejs("jquery");

Page({
    data: {
        swiperCurrent: 0,
        indicatorDots: !0,
        autoplay: !0,
        interval: 3e3,
        duration: 800,
        circular: !0,
        imgUrls: [],
        links: [],
        params: {},
        lotterydraws: [],
        exchanges: [],
        coupons: [],
        balances: [],
        category: [],
        hidden: !1,
        keywords: ""
    },
    onLoad: function(a) {},
    doinput: function(a) {
        this.setData({
            keywords: a.detail.value
        });
    },
    search: function() {
        var a = "/pages/creditshop/lists/index?keywords=" + this.data.keywords;
        wx.navigateTo({
            url: a
        });
    },
    focus: function() {
        this.setData({
            showbtn: "in"
        });
    },
    onReady: function() {
        this.get_index();
    },
    changeTo: function(a) {
        var t = a.currentTarget.dataset.url + "?id=" + a.currentTarget.dataset.gid;
        wx.navigateTo({
            url: t
        });
    },
    get_index: function() {
        var a = this;
        t.post("creditshop/index", a.data.params, function(t) {
            0 == t.error && a.setData({
                imgUrls: t.data.advs,
                category: t.data.category,
                lotterydraws: t.data.lotterydraws,
                exchanges: t.data.exchanges,
                coupons: t.data.coupons,
                balances: t.data.balances,
                redbags: t.data.redbags,
                sysset: t.sysset
            }), a.setData({
                hidden: !0
            });
        });
    }
});