var _xx_util = require("../../../resource/js/xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util), _index = require("../../../resource/apis/index.js");

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
        var s = t.apply(this, arguments);
        return new Promise(function(o, i) {
            return function e(t, a) {
                try {
                    var r = s[t](a), n = r.value;
                } catch (t) {
                    return void i(t);
                }
                if (!r.done) return Promise.resolve(n).then(function(t) {
                    e("next", t);
                }, function(t) {
                    e("throw", t);
                });
                o(n);
            }("next");
        });
    };
}

var regeneratorRuntime = _xx_util2.default.regeneratorRuntime;

Page({
    data: {
        nowPageIndex: 0,
        tabbar: {
            color: "#838591",
            selectedColor: "#fb3447",
            backgroundColor: "#fff",
            borderStyle: "white",
            list: [ {
                pagePath: "/longbing_card/enroll/pages/staff/index",
                text: "发布的活动",
                iconPath: "icon-huodong",
                method: "redirectTo"
            }, {
                pagePath: "/longbing_card/enroll/pages/staff/add/add",
                text: "发活动",
                iconPath: "/longbing_card/enroll/images/2.png",
                method: "redirectTo"
            }, {
                pagePath: "/longbing_card/enroll/pages/order/order?s=staff",
                text: "我报名的活动",
                iconPath: "icon-wode",
                method: "redirectTo"
            } ]
        },
        classify_list: [],
        tabActiveIndex: 0,
        scrollNav: "scrollNav0",
        showMoreStatus: "",
        ranks: [ "最新", "附近" ],
        rankInd: 0,
        dataList: {
            list: [],
            page: 1,
            total_page: 20
        },
        param: {
            page: 1,
            staff: 1
        },
        refresh: !1,
        loading: !0
    },
    onLoad: function(t) {
        var s = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function t() {
            var e, a, r, n, o, i;
            return regeneratorRuntime.wrap(function(t) {
                for (;;) switch (t.prev = t.next) {
                  case 0:
                    e = s, a = {
                        to_uid: wx.getStorageSync("userid")
                    }, r = getApp().globalData, n = r.isIphoneX, o = r.logoImg, i = r.productDefault, 
                    e.setData({
                        optionsParam: a,
                        isIphoneX: n,
                        logoImg: o,
                        productDefault: i
                    }, function() {
                        e.getCate(), _xx_util2.default.hideAll();
                    });

                  case 4:
                  case "end":
                    return t.stop();
                }
            }, t, s);
        }))();
    },
    onPullDownRefresh: function() {
        var a = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function t() {
            var e;
            return regeneratorRuntime.wrap(function(t) {
                for (;;) switch (t.prev = t.next) {
                  case 0:
                    (e = a).setData({
                        refresh: !0,
                        "param.page": 1
                    }, function() {
                        wx.showNavigationBarLoading(), 0 < 1 * e.data.tabActiveIndex ? e.getList() : e.getCate();
                    });

                  case 2:
                  case "end":
                    return t.stop();
                }
            }, t, a);
        }))();
    },
    onReachBottom: function() {
        var t = this.data, e = t.loading, a = t.dataList, r = a.page;
        r == a.total_page || e || (this.setData({
            "param.page": r + 1,
            loading: !0
        }), this.getList());
    },
    getCate: function() {
        var f = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function t() {
            var e, a, r, n, o, i, s, u, l, c, d;
            return regeneratorRuntime.wrap(function(t) {
                for (;;) switch (t.prev = t.next) {
                  case 0:
                    return a = (e = f).data, r = a.tabActiveIndex, n = a.optionsParam, o = a.dataList, 
                    i = n.to_uid, t.next = 5, _index.pluginModel.getEnrollCate({
                        to_uid: i,
                        staff: 1
                    });

                  case 5:
                    s = t.sent, u = s.data, l = u.classify_list, c = u.activity_list, d = u.total_page, 
                    _xx_util2.default.hideAll(), 0 == r && (o.list = c, o.total_page = d), e.setData({
                        classify_list: l,
                        dataList: o,
                        refresh: !1,
                        loading: !1
                    });

                  case 10:
                  case "end":
                    return t.stop();
                }
            }, t, f);
        }))();
    },
    getList: function() {
        var d = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function t() {
            var e, a, r, n, o, i, s, u, l, c;
            return regeneratorRuntime.wrap(function(t) {
                for (;;) switch (t.prev = t.next) {
                  case 0:
                    return a = (e = d).data, r = a.refresh, n = a.param, o = a.dataList, i = a.tabActiveIndex, 
                    s = a.classify_list, n.classify_id = 0 < i ? s[1 * i - 1].id : 0, t.next = 5, _index.pluginModel.getEnrollList(n);

                  case 5:
                    u = t.sent, l = u.data, _xx_util2.default.hideAll(), c = o, r || (l.list = [].concat(_toConsumableArray(c.list), _toConsumableArray(l.list))), 
                    l.page = 1 * l.page, e.setData({
                        dataList: l,
                        loading: !1,
                        refresh: !1
                    });

                  case 12:
                  case "end":
                    return t.stop();
                }
            }, t, d);
        }))();
    },
    toShowMore: function(t) {
        var e = _xx_util2.default.getData(t).type;
        this.setData({
            showMoreStatus: 0 == e ? 1 : 0
        });
    },
    toTabClick: function(n) {
        var o = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function t() {
            var e, a, r;
            return regeneratorRuntime.wrap(function(t) {
                for (;;) switch (t.prev = t.next) {
                  case 0:
                    return e = o, a = _xx_util2.default.getData(n), r = a.index, e.setData({
                        tabActiveIndex: r,
                        showMoreStatus: 0,
                        scrollNav: "scrollNav" + r
                    }), t.next = 5, o.onPullDownRefresh();

                  case 5:
                  case "end":
                    return t.stop();
                }
            }, t, o);
        }))();
    }
});