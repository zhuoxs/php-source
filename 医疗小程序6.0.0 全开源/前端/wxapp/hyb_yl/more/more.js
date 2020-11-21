var app = getApp();

Page({
    data: {
        keArr: [ {
            con: "感冒症状"
        }, {
            con: "发烧"
        }, {
            con: "发冷，寒颤"
        }, {
            con: "感冒症状"
        }, {
            con: "发烧"
        }, {
            con: "发冷，寒颤"
        }, {
            con: "感冒症状"
        }, {
            con: "发烧"
        }, {
            con: "发冷，寒颤"
        } ],
        keArr1: [ {
            con: "感冒症状"
        }, {
            con: "发烧"
        }, {
            con: "发冷，寒颤"
        }, {
            con: "感冒症状"
        }, {
            con: "发烧"
        } ],
        titleArr: [ "全身", "皮肤", "头面部", "鼻部" ],
        current: 0,
        pageWrapCount: [],
        pIndex: []
    },
    onLoad: function(a) {
        var e = this, t = wx.getStorageSync("color");
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: t
        }), app.util.request({
            url: "entry/wxapp/Categoryself",
            success: function(a) {
                console.log(a.data.data);
                var t = a.data.data[0].id;
                app.util.request({
                    url: "entry/wxapp/Categoryselffl2",
                    data: {
                        id: t
                    },
                    success: function(a) {
                        console.log(a.data.data), e.setData({
                            categoryfl2: a.data.data
                        }), app.globalData.skuList = a.data.data;
                        var t = e.data.pIndex;
                        t.push(0), e.setData({
                            pageWrapCount: e.data.pageWrapCount.concat([ 1 ]),
                            pIndex: t
                        });
                    }
                }), e.setData({
                    category: a.data.data
                });
            }
        });
    },
    huoqu: function(a) {
        var e = this;
        console.log(app);
        var n = a.currentTarget.dataset.index;
        if (e.existence(n, e.data.pIndex)) {
            var t = a.currentTarget.dataset.id;
            app.util.request({
                url: "entry/wxapp/Categoryselffl2",
                data: {
                    id: t
                },
                success: function(a) {
                    console.log(a.data.data), e.setData({
                        categoryfl2: a.data.data
                    }), app.globalData.skuList = a.data.data;
                    var t = e.data.pIndex;
                    t.push(n), console.log(t, n), e.setData({
                        pageWrapCount: e.data.pageWrapCount.concat([ 1 ]),
                        current: n,
                        pIndex: t
                    });
                }
            });
        } else e.setData({
            current: n
        });
    },
    existence: function(a, t) {
        for (var e = 0, n = t.length; e < n; e++) if (t[e] == a) return !1;
        return !0;
    },
    searchClick: function() {
        wx.navigateTo({
            url: "/hyb_yl/search/search"
        });
    },
    checkClick: function(a) {
        console.log(a);
        var t = a.detail.id, e = a.detail.title;
        wx.navigateTo({
            url: "/hyb_yl/check/check?id=" + t + "&title=" + e
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});