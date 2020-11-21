var _slicedToArray = function(e, t) {
    if (Array.isArray(e)) return e;
    if (Symbol.iterator in Object(e)) return function(e, t) {
        var r = [], a = !0, n = !1, i = void 0;
        try {
            for (var o, u = e[Symbol.iterator](); !(a = (o = u.next()).done) && (r.push(o.value), 
            !t || r.length !== t); a = !0) ;
        } catch (e) {
            n = !0, i = e;
        } finally {
            try {
                !a && u.return && u.return();
            } finally {
                if (n) throw i;
            }
        }
        return r;
    }(e, t);
    throw new TypeError("Invalid attempt to destructure non-iterable instance");
}, _xx_util = require("../../../../resource/js/xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util), _index = require("../../../../resource/apis/index.js");

function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

function _defineProperty(e, t, r) {
    return t in e ? Object.defineProperty(e, t, {
        value: r,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : e[t] = r, e;
}

function _toConsumableArray(e) {
    if (Array.isArray(e)) {
        for (var t = 0, r = Array(e.length); t < e.length; t++) r[t] = e[t];
        return r;
    }
    return Array.from(e);
}

function _asyncToGenerator(e) {
    return function() {
        var u = e.apply(this, arguments);
        return new Promise(function(i, o) {
            return function t(e, r) {
                try {
                    var a = u[e](r), n = a.value;
                } catch (e) {
                    return void o(e);
                }
                if (!a.done) return Promise.resolve(n).then(function(e) {
                    t("next", e);
                }, function(e) {
                    t("throw", e);
                });
                i(n);
            }("next");
        });
    };
}

var app = getApp(), regeneratorRuntime = _xx_util2.default.regeneratorRuntime;

Page({
    data: {
        order: [ {
            count: 0,
            title: "浏览"
        }, {
            count: 0,
            title: "转发"
        }, {
            count: 0,
            title: "海报"
        } ],
        type: 0,
        orderDay: [ "查看统计", "七天分析" ],
        count: 0,
        list: {
            data: [],
            total: 0,
            per_page: 20,
            current_page: 0,
            last_page: 0
        },
        param: {
            page: 1,
            article_id: 0,
            type: 0,
            count: 0
        },
        refresh: !1,
        loading: !0
    },
    onLoad: function(h) {
        var x = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t, r, a, n, i, o, u, s, c, l, d, f, p, _, g;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    return wx.showShareMenu({
                        withShareTicket: !0
                    }), t = h.index, e.next = 4, _xx_util2.default.getPage(-1).data.list.data[t];

                  case 4:
                    return r = e.sent, a = r.id, n = wx.getStorageSync("userid"), e.next = 9, Promise.all([ _index.userModel.getCardShow({
                        to_uid: n
                    }), _index.pluginModel.getArticleQr({
                        id: a,
                        to_uid: n
                    }) ]);

                  case 9:
                    i = e.sent, o = _slicedToArray(i, 2), u = o[0], s = o[1], c = u.data, l = s.data.image, 
                    d = getApp().globalData, f = d.isIphoneX, p = d.userDefault, _ = d.productDefault, 
                    g = {
                        isIphoneX: f,
                        userDefault: p,
                        productDefault: _
                    }, x.setData({
                        to_uid: n,
                        "optionsParam.uid": n,
                        staffInfo: c,
                        article_id: a,
                        "param.article_id": a,
                        article: r,
                        qr: l,
                        $gd: g
                    }), x.getList();

                  case 19:
                  case "end":
                    return e.stop();
                }
            }, e, x);
        }))();
    },
    onPullDownRefresh: function() {
        var e = this;
        e.setData({
            refresh: !0,
            "param.page": 1
        }, function() {
            wx.showNavigationBarLoading(), e.getList();
        });
    },
    onReachBottom: function() {
        var e = this.data, t = e.loading, r = e.list, a = r.current_page;
        a == r.last_page || t || (this.setData({
            "param.page": a + 1,
            loading: !0
        }), this.getList());
    },
    onShareAppMessage: function(e) {
        var t = this.data, r = t.to_uid, a = t.article, n = a.id, i = a.title, o = a.cover;
        _index.pluginModel.toArticleShare({
            id: n,
            to_uid: r
        });
        var u = "/longbing_card/staffs/pages/article/detail/detail?id=" + n + "&uid=" + r + "&fid=" + r;
        return console.log(u, "==> share_path"), {
            title: i,
            path: u,
            imageUrl: o
        };
    },
    getList: function() {
        var p = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t, r, a, n, i, o, u, s, c, l, d, f;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    return r = (t = p).data, a = r.refresh, n = r.param, i = r.list, o = r.order, e.next = 4, 
                    _index.pluginModel.getViewRecord(n);

                  case 4:
                    u = e.sent, s = u.data, _xx_util2.default.hideAll(), c = i, a || (s.data = [].concat(_toConsumableArray(c.data), _toConsumableArray(s.data))), 
                    l = s.view_count, d = s.share_count, f = s.poster_count, o[0].count = l, o[1].count = d, 
                    o[2].count = f, t.setData({
                        list: s,
                        order: o,
                        loading: !1,
                        refresh: !1
                    });

                  case 14:
                  case "end":
                    return e.stop();
                }
            }, e, p);
        }))();
    },
    toSetTab: function(i) {
        var o = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t, r, a, n;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    return r = _xx_util2.default.getData(i), a = r.key, n = r.index, a = "param." + a, 
                    o.setData((_defineProperty(t = {}, a, n), _defineProperty(t, "refresh", !0), _defineProperty(t, "param.page", 1), 
                    t)), e.next = 5, o.getList();

                  case 5:
                  case "end":
                    return e.stop();
                }
            }, e, o);
        }))();
    },
    toSyncMyNews: function() {
        var a = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t, r;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    return t = a.data.article.id, e.next = 3, _index.pluginModel.toSyncMyNews({
                        id: t
                    });

                  case 3:
                    r = e.sent, 0 == r.errno && _xx_util2.default.showToast("success", "同步成功");

                  case 6:
                  case "end":
                    return e.stop();
                }
            }, e, a);
        }))();
    }
});