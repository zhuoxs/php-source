var app = getApp();

Page({
    data: {
        navTile: "拼团",
        goodsList: [],
        show: "0",
        priceFlag: !0,
        remind: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152542355884.png",
        curPage: 1,
        hasMore: !0
    },
    onLoad: function(t) {
        var a = this;
        wx.setNavigationBarTitle({
            title: a.data.navTile
        }), app.full_setting(), app.get_store_info().then(function(t) {
            a.setData({
                store: t
            }), a.updategoods();
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {
        var t = this;
        if (!t.data.hasMore) return !1;
        t.setData({
            curPage: t.data.curPage + 1
        }), t.updategoods();
    },
    toGroupdet: function(t) {
        var a = t.currentTarget.dataset.id;
        wx.navigateTo({
            url: "../groupDet/groupDet?id=" + a
        });
    },
    toIndex: function(t) {
        wx.redirectTo({
            url: "/yzmdwsc_sun/pages/index/index"
        });
    },
    updategoods: function() {
        var o = this, n = o.data.curPage, t = o.data.store.id;
        app.util.request({
            url: "entry/wxapp/GetGroupGoodses",
            cachetime: "0",
            data: {
                store_id: t,
                page: n
            },
            success: function(t) {
                if (1 == n) var a = {}; else a = o.data.goodsList;
                for (var e in t.data) {
                    a["id_" + t.data[e].id] = t.data[e];
                }
                o.setData({
                    goodsList: a
                }), t.data.length < 5 && o.setData({
                    hasMore: !1
                });
            }
        });
    }
});