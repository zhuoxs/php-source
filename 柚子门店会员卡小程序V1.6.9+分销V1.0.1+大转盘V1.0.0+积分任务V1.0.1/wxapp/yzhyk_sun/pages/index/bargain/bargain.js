var cdInterval, _slicedToArray = function(t, a) {
    if (Array.isArray(t)) return t;
    if (Symbol.iterator in Object(t)) return function(t, a) {
        var e = [], r = !0, n = !1, o = void 0;
        try {
            for (var i, s = t[Symbol.iterator](); !(r = (i = s.next()).done) && (e.push(i.value), 
            !a || e.length !== a); r = !0) ;
        } catch (t) {
            n = !0, o = t;
        } finally {
            try {
                !r && s.return && s.return();
            } finally {
                if (n) throw o;
            }
        }
        return e;
    }(t, a);
    throw new TypeError("Invalid attempt to destructure non-iterable instance");
}, app = getApp();

Page({
    data: {
        navTile: "砍价",
        show: "0",
        curPage: 1,
        priceFlag: !0,
        remind: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152542355884.png",
        hasMore: !0
    },
    onLoad: function(t) {
        var n = this;
        setInterval(function() {
            n.setData({
                curr: Date.now()
            });
        }, 1e3), wx.setNavigationBarTitle({
            title: n.data.navTile
        }), app.full_setting(), Promise.all([ app.api.get_store_info(), app.api.get_user_info() ]).then(function(t) {
            var a = _slicedToArray(t, 2), e = a[0], r = a[1];
            n.setData({
                store: e,
                user: r
            }), n.updategoods();
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {
        var t = this;
        if (!t.data.hasMore) return wx.showToast({
            title: "没有更多数据啦~",
            icon: "none",
            duration: 3e3
        }), !1;
        t.setData({
            curPage: t.data.curPage + 1
        }), t.updategoods();
    },
    onShareAppMessage: function() {},
    toBardet: function(t) {
        var a = t.currentTarget.dataset.id;
        wx.navigateTo({
            url: "../bardet/bardet?id=" + a
        });
    },
    updategoods: function() {
        var r = this, n = r.data.curPage, t = r.data.store.id, a = r.data.user.id;
        app.util.request({
            url: "entry/wxapp/GetCutGoodses",
            cachetime: "0",
            data: {
                store_id: t,
                page: n,
                user_id: a
            },
            success: function(t) {
                if (console.log(t), 1 == n) var a = {}; else a = r.data.goodsList;
                for (var e in t.data) {
                    a["id_" + t.data[e].id] = t.data[e];
                }
                r.setData({
                    goodsList: a
                }), t.data.length < 10 && r.setData({
                    hasMore: !1
                });
            }
        });
    }
});