var _slicedToArray = function(e, t) {
    if (Array.isArray(e)) return e;
    if (Symbol.iterator in Object(e)) return function(e, t) {
        var r = [], a = !0, n = !1, o = void 0;
        try {
            for (var i, s = e[Symbol.iterator](); !(a = (i = s.next()).done) && (r.push(i.value), 
            !t || r.length !== t); a = !0) ;
        } catch (e) {
            n = !0, o = e;
        } finally {
            try {
                !a && s.return && s.return();
            } finally {
                if (n) throw o;
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

function _toConsumableArray(e) {
    if (Array.isArray(e)) {
        for (var t = 0, r = Array(e.length); t < e.length; t++) r[t] = e[t];
        return r;
    }
    return Array.from(e);
}

function _asyncToGenerator(e) {
    return function() {
        var s = e.apply(this, arguments);
        return new Promise(function(o, i) {
            return function t(e, r) {
                try {
                    var a = s[e](r), n = a.value;
                } catch (e) {
                    return void i(e);
                }
                if (!a.done) return Promise.resolve(n).then(function(e) {
                    t("next", e);
                }, function(e) {
                    t("throw", e);
                });
                o(n);
            }("next");
        });
    };
}

var app = getApp(), regeneratorRuntime = _xx_util2.default.regeneratorRuntime;

Page({
    data: {
        activeIndex: "100000101",
        showMoreStatus: "",
        nowPageIndex: 0,
        tabbar: {
            color: "#838591",
            selectedColor: "#11c95e",
            backgroundColor: "#fff",
            borderStyle: "white",
            list: [ {
                pagePath: "/longbing_card/staffs/pages/article/index/index",
                text: "获客文章",
                iconPath: "icon-shejiwenzhang201",
                method: "redirectTo"
            }, {
                pagePath: "/longbing_card/staffs/pages/article/import/import",
                text: "发文章",
                iconPath: "/longbing_card/resource/images/article/icon-fabu.png",
                method: "redirectTo"
            }, {
                pagePath: "/longbing_card/staffs/pages/article/myself/myself",
                text: "我的文章",
                iconPath: "icon-wode",
                method: "redirectTo"
            } ]
        },
        classify_id: 0,
        param: {
            page: 1,
            classify_id: 0
        },
        list: {
            data: [],
            total: 0,
            per_page: 20,
            current_page: 0,
            last_page: 0
        },
        refresh: !1,
        loading: !0
    },
    onLoad: function(e) {
        var t = getApp().globalData, r = {
            logoImg: t.logoImg,
            productDefault: t.productDefault,
            isIphoneX: t.isIphoneX
        }, a = wx.getStorageSync("userid");
        this.setData({
            $gd: r,
            to_uid: a
        }), this.getList();
    },
    onPullDownRefresh: function() {
        var r = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    (t = r).setData({
                        refresh: !0,
                        "param.page": 1
                    }, function() {
                        wx.showNavigationBarLoading(), t.getList();
                    });

                  case 2:
                  case "end":
                    return e.stop();
                }
            }, e, r);
        }))();
    },
    onReachBottom: function() {
        var e = this.data, t = e.loading, r = e.list, a = r.current_page;
        a == r.last_page || t || (this.setData({
            "param.page": a + 1,
            loading: !0
        }), this.getList());
    },
    getList: function() {
        var f = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t, r, a, n, o, i, s, u, c, l, d, g;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    return r = (t = f).data, a = r.refresh, n = r.param, o = r.list, e.next = 4, Promise.all([ _index.pluginModel.getArticleCate(), _index.pluginModel.getArticleList(n) ]);

                  case 4:
                    i = e.sent, s = _slicedToArray(i, 2), u = s[0], c = s[1], l = u.data, d = c.data, 
                    _xx_util2.default.hideAll(), g = o, a || (d.data = [].concat(_toConsumableArray(g.data), _toConsumableArray(d.data))), 
                    t.setData({
                        nav: l,
                        list: d,
                        loading: !1,
                        refresh: !1
                    });

                  case 14:
                  case "end":
                    return e.stop();
                }
            }, e, f);
        }))();
    },
    toJump: function(c) {
        var l = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t, r, a, n, o, i, s, u;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    t = l, r = _xx_util2.default.getData(c), a = r.status, n = r.type, o = r.index, 
                    i = r.categoryid, "toShowMore" == a && t.setData({
                        showMoreStatus: 0 == n ? 1 : 0
                    }), "toTabClickMore" != a && "toTabClick" != a || (s = o, u = i, "toTabClickMore" == a && (s = "100000101", 
                    u = "All"), t.setData({
                        activeIndex: s,
                        "param.classify_id": i,
                        scrollNav: "scrollNav" + u,
                        shop_all: [],
                        showMoreStatus: 0,
                        refresh: !0,
                        "param.page": 1
                    }), l.getList());

                  case 4:
                  case "end":
                    return e.stop();
                }
            }, e, l);
        }))();
    }
});