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
        var s = e.apply(this, arguments);
        return new Promise(function(i, o) {
            return function t(e, r) {
                try {
                    var a = s[e](r), n = a.value;
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
        tabList1: [ {
            type: 0,
            name: "全部"
        }, {
            type: 1,
            name: "待付款"
        }, {
            type: 2,
            name: "待发货"
        }, {
            type: 4,
            name: "已完成"
        } ],
        tabList2: [ {
            type: 3,
            name: "退款审核中"
        }, {
            type: 5,
            name: "已退款"
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
    onLoad: function(p) {
        var f = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t, r, a, n, i, o, s, u, l, c;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    return console.log(p, "options"), t = f, r = p.s, wx.setNavigationBarTitle({
                        title: 1 == r ? "订单管理" : "退款管理"
                    }), a = {
                        status: r
                    }, n = getApp().globalData.isIphoneX, i = f.data, o = i.tabList1, s = i.tabList2, 
                    u = 1 == r ? o : s, l = 1 == r ? "padding:0rpx 36rpx;" : "padding:0rpx 80rpx;", 
                    c = {
                        isIphoneX: n
                    }, t.setData({
                        optionsParam: a,
                        scroll_item_de: l,
                        tabList: u,
                        $gd: c
                    }), e.next = 13, f.onPullDownRefresh();

                  case 13:
                  case "end":
                    return e.stop();
                }
            }, e, f);
        }))();
    },
    onPullDownRefresh: function() {
        var r = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    return t = r, e.next = 3, getApp().getConfigInfo(!0);

                  case 3:
                    t.setData({
                        refresh: !0,
                        "param.page": 1
                    }, function() {
                        wx.showNavigationBarLoading(), t.getList();
                    });

                  case 4:
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
        var p = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t, r, a, n, i, o, s, u, l, c;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    return r = (t = p).data, a = r.refresh, n = r.param, i = r.dataList, o = r.tabList, 
                    s = r.currentIndex, n.type = o[s].type, e.next = 5, _index.staffModel.getOrderManage(n);

                  case 5:
                    u = e.sent, l = u.data, _xx_util2.default.hideAll(), c = i, a || (l.list = [].concat(_toConsumableArray(c.list), _toConsumableArray(l.list))), 
                    l.page = 1 * l.page, t.setData({
                        dataList: l,
                        loading: !1,
                        refresh: !1
                    });

                  case 13:
                  case "end":
                    return e.stop();
                }
            }, e, p);
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