function _defineProperty(e, a, t) {
    return a in e ? Object.defineProperty(e, a, {
        value: t,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : e[a] = t, e;
}

var app = getApp();

Page({
    data: {
        list: {
            load: !1,
            over: !1,
            page: 1,
            length: 10,
            none: !1,
            data: []
        }
    },
    onLoad: function(e) {
        var a = this, t = app.getSiteUrl();
        t ? a.setData({
            url: t
        }) : app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            success: function(e) {
                wx.setStorageSync("url", e.data), t = e.data, a.setData({
                    url: t
                });
            }
        });
    },
    onShow: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/lotterygoods",
            data: {
                page: t.data.list.page
            },
            success: function(e) {
                var a;
                t.setData((_defineProperty(a = {}, "list.data", e.data.goods), _defineProperty(a, "background", e.data.background), 
                a));
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    toCjGoods: function(e) {
        switch (console.log(e), e.currentTarget.dataset.lid - 0) {
          case 1:
            wx.navigateTo({
                url: "/mzhk_sun/pages/index/goods/goods?gid=" + e.currentTarget.dataset.gid
            });
            break;

          case 5:
            wx.navigateTo({
                url: "/mzhk_sun/pages/index/package/package?id=" + e.currentTarget.dataset.gid
            });
            break;

          case 3:
            wx.navigateTo({
                url: "/mzhk_sun/pages/index/groupdet/groupdet?id=" + e.currentTarget.dataset.gid
            });
            break;

          case 2:
            wx.navigateTo({
                url: "/mzhk_sun/pages/index/bardet/bardet?id=" + e.currentTarget.dataset.gid
            });
        }
    },
    toIndex: function() {
        wx.navigateTo({
            url: "/mzhk_sun/pages/index/index"
        });
    }
});