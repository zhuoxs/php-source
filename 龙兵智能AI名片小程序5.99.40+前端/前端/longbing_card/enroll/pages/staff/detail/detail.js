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

var regeneratorRuntime = _xx_util2.default.regeneratorRuntime;

Page({
    data: {
        dataList: {
            list: [],
            page: 1,
            total_page: 20
        },
        param: {
            page: 1
        },
        refresh: !1,
        loading: !0
    },
    onLoad: function(o) {
        var u = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t, r, a, n, i;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    t = o.id, r = o.index, a = _xx_util2.default.getPage(-1).data.dataList.list[r], 
                    n = getApp().globalData.isIphoneX, i = {
                        isIphoneX: n
                    }, u.setData({
                        "param.activity_id": t,
                        $gd: i,
                        data: a
                    }), u.onPullDownRefresh();

                  case 6:
                  case "end":
                    return e.stop();
                }
            }, e, u);
        }))();
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
        var e = this.data, t = e.loading, r = e.dataList, a = r.page;
        a == r.total_page || t || (this.setData({
            "param.page": a + 1,
            loading: !0
        }), this.getList());
    },
    onShareAppMessage: function(e) {
        var t = wx.getStorageSync("userid"), r = this.data.data, a = r.id, n = r.title, i = r.cover, o = r.carousel, u = "/longbing_card/enroll/pages/detail/detail?id=" + a + "&uid=" + t + "&fid=" + t;
        return console.log(u, "tmp_path"), {
            title: n,
            path: u,
            imageUrl: i || o[0]
        };
    },
    getList: function() {
        var l = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t, r, a, n, i, o, u, s;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    return r = (t = l).data, a = r.refresh, n = r.param, i = r.dataList, e.next = 4, 
                    _index.pluginModel.getEnrSignDetail(n);

                  case 4:
                    o = e.sent, u = o.data, _xx_util2.default.hideAll(), s = i, a || (u.list = [].concat(_toConsumableArray(s.list), _toConsumableArray(u.list))), 
                    u.page = 1 * u.page, t.setData({
                        dataList: u,
                        loading: !1,
                        refresh: !1
                    });

                  case 11:
                  case "end":
                    return e.stop();
                }
            }, e, l);
        }))();
    }
});