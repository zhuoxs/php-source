var _xx_util = require("../../../resource/js/xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util), _index = require("../../../resource/apis/index.js");

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

var regeneratorRuntime = _xx_util2.default.regeneratorRuntime;

Page({
    data: {
        nowPageIndex: 2,
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
        color: "#fc3c3b",
        tabList: [ {
            name: "全部",
            status: "toOrder"
        }, {
            name: "未开始",
            status: "toOrder"
        }, {
            name: "已开始",
            status: "toOrder"
        }, {
            name: "已结束",
            status: "toOrder"
        } ],
        currentIndex: 0,
        scrollNav: "scrollNav0",
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
    onLoad: function(a) {
        var n = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t, r;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    t = a.s, r = getApp().globalData.isIphoneX, n.setData({
                        status: t || "",
                        isIphoneX: r
                    });

                  case 3:
                  case "end":
                    return e.stop();
                }
            }, e, n);
        }))();
    },
    onShow: function() {
        this.onPullDownRefresh();
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
    getList: function() {
        var l = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t, r, a, n, o, i, s, u, c;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    return r = (t = l).data, a = r.refresh, n = r.param, o = r.currentIndex, i = r.dataList, 
                    n.type = 1 * o, e.next = 5, _index.pluginModel.getMyEnrList(n);

                  case 5:
                    s = e.sent, u = s.data, _xx_util2.default.hideAll(), c = i, a || (u.list = [].concat(_toConsumableArray(c.list), _toConsumableArray(u.list))), 
                    u.page = 1 * u.page, t.setData({
                        dataList: u,
                        loading: !1,
                        refresh: !1
                    });

                  case 12:
                  case "end":
                    return e.stop();
                }
            }, e, l);
        }))();
    },
    toTabClick: function(e) {
        var t = _xx_util2.default.getData(e).index;
        this.setData({
            currentIndex: t,
            scrollNav: "scrollNav" + t
        }), this.onPullDownRefresh();
    }
});