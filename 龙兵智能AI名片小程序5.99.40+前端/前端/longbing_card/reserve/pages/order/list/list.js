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
                    var n = s[t](r), a = n.value;
                } catch (t) {
                    return void o(t);
                }
                if (!n.done) return Promise.resolve(a).then(function(t) {
                    e("next", t);
                }, function(t) {
                    e("throw", t);
                });
                i(a);
            }("next");
        });
    };
}

var regeneratorRuntime = _xx_util2.default.regeneratorRuntime, app = getApp();

Page({
    data: {
        color: "#fc3c3b",
        tabList: [ {
            title: "未使用"
        }, {
            title: "已完成"
        } ],
        tabActiveIndex: 0,
        modelMethod: "",
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
        var s = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function t() {
            var e, r, n, a, i;
            return regeneratorRuntime.wrap(function(t) {
                for (;;) switch (t.prev = t.next) {
                  case 0:
                    e = s, r = o.s, n = "user" == r ? "getUserResList" : "getStaffResList", a = {
                        status: r || "user"
                    }, i = e.data.tabList, "staff" == r && (wx.setNavigationBarTitle({
                        title: "预约表单"
                    }), i = [ {
                        title: "未服务"
                    }, {
                        title: "已服务"
                    }, {
                        title: "已过期"
                    }, {
                        title: "已取消"
                    } ]), e.setData({
                        optionsParam: a,
                        modelMethod: n,
                        tabList: i
                    });

                  case 7:
                  case "end":
                    return t.stop();
                }
            }, t, s);
        }))();
    },
    onShow: function() {
        this.onPullDownRefresh();
    },
    tabChange: function(e) {
        var r = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function t() {
            return regeneratorRuntime.wrap(function(t) {
                for (;;) switch (t.prev = t.next) {
                  case 0:
                    return r.setData({
                        tabActiveIndex: e.detail.index
                    }), t.next = 4, r.onPullDownRefresh();

                  case 4:
                  case "end":
                    return t.stop();
                }
            }, t, r);
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
        var t = this.data, e = t.loading, r = t.dataList, n = r.page;
        n == r.total_page || e || (this.setData({
            "param.page": n + 1,
            loading: !0
        }), this.getList());
    },
    getList: function() {
        var f = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function t() {
            var e, r, n, a, i, o, s, u, c, l;
            return regeneratorRuntime.wrap(function(t) {
                for (;;) switch (t.prev = t.next) {
                  case 0:
                    return r = (e = f).data, n = r.refresh, a = r.param, i = r.tabActiveIndex, o = r.modelMethod, 
                    s = r.dataList, a.type = 1 * i + 1, t.next = 5, _index.pluginModel[o](a);

                  case 5:
                    u = t.sent, c = u.data, _xx_util2.default.hideAll(), l = s, n || (c.list = [].concat(_toConsumableArray(l.list), _toConsumableArray(c.list))), 
                    c.page = 1 * c.page, e.setData({
                        dataList: c,
                        loading: !1,
                        refresh: !1
                    });

                  case 12:
                  case "end":
                    return t.stop();
                }
            }, t, f);
        }))();
    },
    toConfirm: function(o) {
        var s = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function t() {
            var n, e, r, a, i;
            return regeneratorRuntime.wrap(function(t) {
                for (;;) switch (t.prev = t.next) {
                  case 0:
                    n = s, e = _xx_util2.default.getData(o), r = e.id, a = e.index, i = n.data.dataList, 
                    wx.showModal({
                        title: "",
                        content: "是否确认已使用此预约",
                        success: function(t) {
                            t.confirm && _index.pluginModel.toResConfirm({
                                id: r
                            }).then(function(t) {
                                var e = t.errno, r = t.message;
                                0 == e && (_xx_util2.default.showToast("success", r), setTimeout(function() {
                                    i.list.splice(a, 1), n.setData({
                                        dataList: i
                                    });
                                }, 1500));
                            });
                        }
                    });

                  case 4:
                  case "end":
                    return t.stop();
                }
            }, t, s);
        }))();
    },
    toCancel: function(o) {
        var s = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function t() {
            var n, e, r, a, i;
            return regeneratorRuntime.wrap(function(t) {
                for (;;) switch (t.prev = t.next) {
                  case 0:
                    n = s, e = _xx_util2.default.getData(o), r = e.id, a = e.index, i = n.data.dataList, 
                    wx.showModal({
                        title: "",
                        content: "是否确认要取消此次预约",
                        success: function(t) {
                            t.confirm && _index.pluginModel.toResCancel({
                                id: r
                            }).then(function(t) {
                                var e = t.errno, r = t.message;
                                0 == e && (_xx_util2.default.showToast("success", r), setTimeout(function() {
                                    i.list.splice(a, 1), n.setData({
                                        dataList: i
                                    });
                                }, 1500));
                            });
                        }
                    });

                  case 4:
                  case "end":
                    return t.stop();
                }
            }, t, s);
        }))();
    },
    goUrl: function(t) {
        _xx_util2.default.goUrl(t);
    }
});