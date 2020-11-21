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
    onLoad: function(e) {
        var t = e.uid, r = getApp().globalData, a = {
            logoImg: r.logoImg,
            productDefault: r.productDefault,
            isIphoneX: r.isIphoneX
        }, n = wx.getStorageSync("userid"), i = {
            to_uid: t
        };
        this.setData({
            $gd: a,
            curr_user_id: n,
            param: i
        }), this.getList();
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
    getList: function() {
        var l = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t, r, a, n, i, o, u, s;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    return r = (t = l).data, a = r.refresh, n = r.param, i = r.list, e.next = 4, _index.pluginModel.getRankRecord(n);

                  case 4:
                    o = e.sent, u = o.data, _xx_util2.default.hideAll(), s = i, a || (u.data = [].concat(_toConsumableArray(s.data), _toConsumableArray(u.data))), 
                    t.setData({
                        list: u,
                        loading: !1,
                        refresh: !1
                    });

                  case 10:
                  case "end":
                    return e.stop();
                }
            }, e, l);
        }))();
    }
});