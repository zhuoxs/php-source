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
        var s = t.apply(this, arguments);
        return new Promise(function(i, o) {
            return function e(t, r) {
                try {
                    var a = s[t](r), n = a.value;
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
        dataList: {
            list: [],
            page: 1,
            total_page: 20
        },
        param: {
            page: 1,
            classify_id: 0
        },
        refresh: !1,
        loading: !0,
        currentIndex: 0,
        scrollNav: "scrollNav0"
    },
    onLoad: function(t) {
        var c = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function t() {
            var e, r, a, n, i, o, s, u;
            return regeneratorRuntime.wrap(function(t) {
                for (;;) switch (t.prev = t.next) {
                  case 0:
                    return _xx_util2.default.showLoading(), e = c, t.next = 4, getApp().getConfigInfo();

                  case 4:
                    return r = getApp().globalData, a = r.isIphoneX, n = r.configInfo, i = r.price_switch, 
                    o = n.config, s = o.btn_talk, u = o.myshop_switch, e.setData({
                        price_switch: i,
                        isIphoneX: a,
                        btn_talk: s,
                        myshop_switch: u,
                        to_uid: wx.getStorageSync("userid")
                    }), t.next = 9, Promise.all([ e.getCate(), e.getList() ]);

                  case 9:
                    _xx_util2.default.hideAll();

                  case 10:
                  case "end":
                    return t.stop();
                }
            }, t, c);
        }))();
    },
    onPullDownRefresh: function() {
        var r = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function t() {
            var e;
            return regeneratorRuntime.wrap(function(t) {
                for (;;) switch (t.prev = t.next) {
                  case 0:
                    (e = r).setData({
                        refresh: !0,
                        "param.page": 1
                    }, function() {
                        wx.showNavigationBarLoading(), e.getList();
                    });

                  case 2:
                  case "end":
                    return t.stop();
                }
            }, t, r);
        }))();
    },
    onReachBottom: function() {
        var t = this.data, e = t.loading, r = t.dataList, a = r.page;
        a == r.total_page || e || (this.setData({
            "param.page": a + 1,
            loading: !0
        }), this.getList());
    },
    onShareAppMessage: function(t) {
        if ("button" === t.from) {
            var e = t.target.dataset.index, r = this.data.dataList.list[e], a = r.id, n = r.name, i = r.cover, o = getApp().globalData.nickName, s = "/longbing_card/pages/shop/detail/detail?to_uid=" + to_uid + "&from_id=" + to_uid + "&id=" + a + "&type=2&nickName=" + o;
            return console.log(s, "tmp_path"), {
                title: n,
                path: s,
                imageUrl: i
            };
        }
    },
    onPageScroll: function(t) {
        this.setData({
            scrollTop: t.scrollTop
        });
    },
    getCate: function() {
        var o = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function t() {
            var e, r, a, n, i;
            return regeneratorRuntime.wrap(function(t) {
                for (;;) switch (t.prev = t.next) {
                  case 0:
                    return r = (e = o).data.to_uid, t.next = 4, _index.userModel.getShopTypes({
                        to_uid: r
                    });

                  case 4:
                    a = t.sent, n = a.data, _xx_util2.default.hideAll(), i = n.shop_type, e.setData({
                        shop_type: i
                    });

                  case 9:
                  case "end":
                    return t.stop();
                }
            }, t, o);
        }))();
    },
    getList: function() {
        var _ = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function t() {
            var e, r, a, n, i, o, s, u, c, l, d;
            return regeneratorRuntime.wrap(function(t) {
                for (;;) switch (t.prev = t.next) {
                  case 0:
                    return r = (e = _).data, a = r.refresh, n = r.param, i = r.dataList, o = r.currentIndex, 
                    s = r.shop_type, n.classify_id = 0 < o ? s[1 * o - 1].id : 0, t.next = 5, _index.staffModel.getExtensions(n);

                  case 5:
                    for (d in u = t.sent, c = u.data, _xx_util2.default.hideAll(), l = i, a || (c.list = [].concat(_toConsumableArray(l.list), _toConsumableArray(c.list))), 
                    c.list) c.list[d].shop_price = _xx_util2.default.getNormalPrice((c.list[d].price / 1e4).toFixed(4));
                    c.page = 1 * c.page, e.setData({
                        dataList: c,
                        loading: !1,
                        refresh: !1
                    });

                  case 13:
                  case "end":
                    return t.stop();
                }
            }, t, _);
        }))();
    },
    toSetExtension: function(i) {
        var o = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function t() {
            var e, r, a, n;
            return regeneratorRuntime.wrap(function(t) {
                for (;;) switch (t.prev = t.next) {
                  case 0:
                    e = o, r = _xx_util2.default.getData(i), a = r.index, n = e.data.dataList.list, 
                    _index.staffModel.setExtension({
                        goods_id: n[a].id
                    }).then(function(t) {
                        _xx_util2.default.hideAll(), 0 == t.errno && (1 == t.data.sign && (n[a].is_my_shop = 1), 
                        n[a].is_extension = 0 == n[a].is_extension ? 1 : 0, e.setData({
                            "dataList.list": n
                        }));
                    });

                  case 4:
                  case "end":
                    return t.stop();
                }
            }, t, o);
        }))();
    },
    toSetMyShop: function(u) {
        var c = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function t() {
            var e, r, a, n, i, o, s;
            return regeneratorRuntime.wrap(function(t) {
                for (;;) switch (t.prev = t.next) {
                  case 0:
                    return e = c, r = _xx_util2.default.getData(u), a = r.index, n = r.type, i = r.ids, 
                    o = e.data.dataList.list, t.next = 5, _index.staffModel[n]({
                        ids: i
                    });

                  case 5:
                    if (s = t.sent, !s.data.msg) {
                        t.next = 9;
                        break;
                    }
                    return t.abrupt("return", !1);

                  case 9:
                    0 == o[a].is_my_shop ? o[a].is_extension = 1 : 1 == o[a].is_my_shop && (o[a].is_extension = 0, 
                    o[a].is_my_shop = 0), e.setData({
                        "dataList.list": o
                    });

                  case 11:
                  case "end":
                    return t.stop();
                }
            }, t, c);
        }))();
    },
    toTabClick: function(t) {
        var e = _xx_util2.default.getData(t).index;
        this.setData({
            currentIndex: e,
            scrollNav: "scrollNav" + e
        }), this.onPullDownRefresh();
    }
});