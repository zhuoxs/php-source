var _xx_util = require("../../../../resource/js/xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util), _index = require("../../../../resource/apis/index.js");

function _interopRequireDefault(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}

function _toConsumableArray(t) {
    if (Array.isArray(t)) {
        for (var e = 0, a = Array(t.length); e < t.length; e++) a[e] = t[e];
        return a;
    }
    return Array.from(t);
}

function _asyncToGenerator(t) {
    return function() {
        var u = t.apply(this, arguments);
        return new Promise(function(i, o) {
            return function e(t, a) {
                try {
                    var r = u[t](a), n = r.value;
                } catch (t) {
                    return void o(t);
                }
                if (!r.done) return Promise.resolve(n).then(function(t) {
                    e("next", t);
                }, function(t) {
                    e("throw", t);
                });
                i(n);
            }("next");
        });
    };
}

var app = getApp(), echarts = require("../../../../templates/ec-canvas/echarts"), regeneratorRuntime = _xx_util2.default.regeneratorRuntime;

Page({
    data: {
        list: {
            data: [],
            total: 0,
            per_page: 20,
            current_page: 0,
            last_page: 0
        },
        param: {
            page: 1,
            article_id: 0
        },
        refresh: !1,
        loading: !0
    },
    onLoad: function(t) {
        var e = t.id, a = getApp().globalData, r = {
            logoImg: a.logoImg,
            productDefault: a.productDefault,
            isIphoneX: a.isIphoneX
        }, n = this.data.param;
        n.article_id = e, this.setData({
            $gd: r,
            param: n
        }), this.getList();
    },
    onShow: function() {},
    onPullDownRefresh: function() {
        var t = this;
        t.setData({
            refresh: !0,
            "param.page": 1
        }, function() {
            wx.showNavigationBarLoading(), t.getList();
        });
    },
    onReachBottom: function() {
        var t = this.data, e = t.loading, a = t.list, r = a.current_page;
        r == a.last_page || e || (this.setData({
            "param.page": r + 1,
            loading: !0
        }), this.getList());
    },
    getList: function() {
        var l = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function t() {
            var e, a, r, n, i, o, u, s;
            return regeneratorRuntime.wrap(function(t) {
                for (;;) switch (t.prev = t.next) {
                  case 0:
                    return a = (e = l).data, r = a.refresh, n = a.param, i = a.list, t.next = 4, _index.pluginModel.getArticleRankList(n);

                  case 4:
                    o = t.sent, u = o.data, _xx_util2.default.hideAll(), s = i, r || (u.data = [].concat(_toConsumableArray(s.data), _toConsumableArray(u.data))), 
                    e.setData({
                        list: u,
                        loading: !1,
                        refresh: !1
                    });

                  case 10:
                  case "end":
                    return t.stop();
                }
            }, t, l);
        }))();
    }
});