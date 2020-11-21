var _xx_util = require("../../../../resource/js/xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util), _index = require("../../../../resource/apis/index.js");

function _interopRequireDefault(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}

function _toConsumableArray(t) {
    if (Array.isArray(t)) {
        for (var e = 0, r = Array(t.length); e < t.length; e++) r[e] = t[e];
        return r;
    }
    return Array.from(t);
}

function _asyncToGenerator(t) {
    return function() {
        var u = t.apply(this, arguments);
        return new Promise(function(i, o) {
            return function e(t, r) {
                try {
                    var a = u[t](r), n = a.value;
                } catch (t) {
                    return void o(t);
                }
                if (!a.done) return Promise.resolve(n).then(function(t) {
                    e("next", t);
                }, function(t) {
                    e("throw", t);
                });
                i(n);
            }("next");
        });
    };
}

var app = getApp(), regeneratorRuntime = _xx_util2.default.regeneratorRuntime;

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
            count: 0
        },
        refresh: !1,
        loading: !0
    },
    onLoad: function(t) {
        var e = t.uid, r = t.count, a = getApp().globalData, n = {
            logoImg: a.logoImg,
            productDefault: a.productDefault,
            isIphoneX: a.isIphoneX
        }, i = e || wx.getStorageSync("userid"), o = this.data.param;
        r && (o.count = r, o.client_id = e), wx.setNavigationBarTitle({
            title: 0 == r ? "总浏览" : "今日浏览"
        }), this.setData({
            $gd: n,
            to_uid: i,
            param: o
        }), this.getList();
    },
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
        var t = this.data, e = t.loading, r = t.list, a = r.current_page;
        a == r.last_page || e || (this.setData({
            "param.page": a + 1,
            loading: !0
        }), this.getList());
    },
    getList: function() {
        var l = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function t() {
            var e, r, a, n, i, o, u, s;
            return regeneratorRuntime.wrap(function(t) {
                for (;;) switch (t.prev = t.next) {
                  case 0:
                    return r = (e = l).data, a = r.refresh, n = r.param, i = r.list, t.next = 4, _index.pluginModel.getUserRecord(n);

                  case 4:
                    o = t.sent, u = o.data, _xx_util2.default.hideAll(), s = i, a || (u.data = [].concat(_toConsumableArray(s.data), _toConsumableArray(u.data))), 
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