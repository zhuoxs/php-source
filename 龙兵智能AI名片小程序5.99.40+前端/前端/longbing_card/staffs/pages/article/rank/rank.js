var _xx_util = require("../../../../resource/js/xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util), _index = require("../../../../resource/apis/index.js");

function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

function _toConsumableArray(e) {
    if (Array.isArray(e)) {
        for (var t = 0, r = Array(e.length); t < e.length; t++) r[t] = e[t];
        return r;
    }
    return Array.from(e);
}

function _defineProperty(e, t, r) {
    return t in e ? Object.defineProperty(e, t, {
        value: r,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : e[t] = r, e;
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

var app = getApp(), echarts = require("../../../../templates/ec-canvas/echarts"), regeneratorRuntime = _xx_util2.default.regeneratorRuntime;

Page({
    data: {
        tabList: [ {
            modelMethod: "getUserRank",
            param: {
                page: 1,
                type: 0
            },
            list: {
                total: 0,
                per_page: 20,
                current_page: 1,
                last_page: 1,
                data: []
            }
        }, {
            modelMethod: "getArticleRank",
            param: {
                page: 1
            },
            list: {
                total: 0,
                per_page: 20,
                current_page: 1,
                last_page: 0,
                data: []
            }
        } ],
        rankOrder: [ {
            title: "汇总",
            day: 0
        }, {
            title: "昨日",
            day: 29
        }, {
            title: "近7天",
            day: 23
        }, {
            title: "近15天",
            day: 15
        } ],
        tabActiveIndex: 0,
        refresh: !1,
        loading: !0
    },
    onLoad: function(c) {
        var l = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t, r, a, n, i, o, u, s;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    return t = l, r = c.uid, a = r || wx.getStorageSync("userid"), n = getApp().globalData, 
                    i = n.logoImg, o = n.productDefault, u = n.isIphoneX, s = {
                        logoImg: i,
                        productDefault: o,
                        isIphoneX: u
                    }, t.setData({
                        to_uid: a,
                        $gd: s
                    }), e.next = 8, t.getList();

                  case 8:
                  case "end":
                    return e.stop();
                }
            }, e, l);
        }))();
    },
    onPullDownRefresh: function() {
        var n = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t, r, a;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    r = (t = n).data.tabActiveIndex, a = "tabList[" + r + "].param.page", t.setData(_defineProperty({
                        refresh: !0
                    }, a, 1), function() {
                        wx.showNavigationBarLoading(), t.getList();
                    });

                  case 4:
                  case "end":
                    return e.stop();
                }
            }, e, n);
        }))();
    },
    onReachBottom: function() {
        var e = this, t = this.data, r = t.loading, a = t.tabList, n = t.tabActiveIndex, i = a[n].list, o = i.current_page;
        if (o != i.last_page && !r) {
            var u, s = "tabList[" + n + "].param.page";
            e.setData((_defineProperty(u = {}, s, o + 1), _defineProperty(u, "loading", !0), 
            u), function() {
                e.getList();
            });
        }
    },
    getList: function() {
        var f = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t, r, a, n, i, o, u, s, c, l, d, p;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    return a = (r = f).data, n = a.refresh, i = a.tabList, o = a.tabActiveIndex, u = i[o].list, 
                    s = i[o].param, e.next = 6, _index.pluginModel[i[o].modelMethod](s);

                  case 6:
                    c = e.sent, l = c.data, _xx_util2.default.hideAll(), n || (l.data = [].concat(_toConsumableArray(u.data), _toConsumableArray(l.data))), 
                    d = "tabList[" + o + "].list", r.setData((_defineProperty(t = {}, d, l), _defineProperty(t, "loading", !1), 
                    _defineProperty(t, "refresh", !1), t)), 0 == o && (p = l.daysArr, f.init_echart(p, 1));

                  case 13:
                  case "end":
                    return e.stop();
                }
            }, e, f);
        }))();
    },
    init_echart: function(n, i) {
        var o = this;
        o.selectComponent("#mychart" + i).init(function(e, t, r) {
            var a = echarts.init(e, null, {
                width: t,
                height: r
            });
            return 1 == i && a.setOption(o.getLineOption(n, i)), a;
        });
    },
    getLineOption: function(e, t) {
        var r = [], a = [];
        for (var n in e) r.push(e[n].date), a.push(e[n].count);
        for (var i = a[0], o = 0, u = a.length; o < u; o++) a[o] > i && (i = a[o]);
        return {
            legend: {
                data: []
            },
            color: [ "#11c95e" ],
            background: [ "#fff" ],
            grid: {
                top: "10",
                left: "3%",
                right: "5%",
                bottom: "10",
                containLabel: !0
            },
            xAxis: [ {
                type: "category",
                boundaryGap: !1,
                data: r
            } ],
            yAxis: [ {
                type: "value",
                max: 2 * i
            } ],
            series: [ {
                name: "",
                type: "line",
                hoverAnimation: !1,
                label: {
                    normal: {
                        show: !0,
                        position: "top"
                    }
                },
                data: a
            } ]
        };
    },
    toSetTab: function(a) {
        var n = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t, r;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    t = _xx_util2.default.getData(a), r = t.type, n.setData({
                        tabActiveIndex: r
                    }), wx.setNavigationBarTitle({
                        title: 0 == r ? "获客排行榜" : "文章排行榜"
                    }), n.onPullDownRefresh();

                  case 4:
                  case "end":
                    return e.stop();
                }
            }, e, n);
        }))();
    },
    toCount: function(i) {
        var o = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t, r, a, n;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    t = _xx_util2.default.getData(i), r = t.index, a = o.data.tabActiveIndex, n = "tabList[" + a + "].param.type", 
                    o.setData(_defineProperty({}, n, r)), o.onPullDownRefresh();

                  case 5:
                  case "end":
                    return e.stop();
                }
            }, e, o);
        }))();
    }
});