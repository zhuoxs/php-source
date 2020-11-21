var _xx_util = require("../../../../resource/js/xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util), _index = require("../../../../resource/apis/index.js");

function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

function _asyncToGenerator(e) {
    return function() {
        var u = e.apply(this, arguments);
        return new Promise(function(i, o) {
            return function t(e, n) {
                try {
                    var r = u[e](n), a = r.value;
                } catch (e) {
                    return void o(e);
                }
                if (!r.done) return Promise.resolve(a).then(function(e) {
                    t("next", e);
                }, function(e) {
                    t("throw", e);
                });
                i(a);
            }("next");
        });
    };
}

var regeneratorRuntime = _xx_util2.default.regeneratorRuntime, app = getApp();

Page({
    data: {},
    onLoad: function(i) {
        var o = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t, n, r, a;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    t = o, n = i.s, r = i.id, a = {
                        s: n,
                        id: r
                    }, t.setData({
                        optionsParam: a,
                        isIphoneX: getApp().globalData.isIphoneX
                    }, function() {
                        t.getDetail();
                    });

                  case 4:
                  case "end":
                    return e.stop();
                }
            }, e, o);
        }))();
    },
    getDetail: function() {
        var u = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t, n, r, a, i, o;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    return t = u.data.optionsParam, n = t.id, r = t.s, e.next = 3, _index.pluginModel.getResDetail({
                        id: n
                    });

                  case 3:
                    a = e.sent, i = a.data.status, o = 0 == i ? "已取消" : 1 == i ? "未使用" : 2 == i ? "已使用" : 3 == i ? "已过期" : "", 
                    "staff" == r && (o = 0 == i ? "已取消" : 1 == i ? "未服务" : 2 == i ? "已服务" : 3 == i ? "已过期" : ""), 
                    wx.setNavigationBarTitle({
                        title: o
                    }), u.setData({
                        data: a.data
                    });

                  case 9:
                  case "end":
                    return e.stop();
                }
            }, e, u);
        }))();
    },
    toConfirm: function(e) {
        var n = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    t = n.data.data.id, wx.showModal({
                        title: "",
                        content: "是否确认已使用此预约",
                        success: function(e) {
                            e.confirm && _index.pluginModel.toResConfirm({
                                id: t
                            }).then(function(e) {
                                var t = e.errno, n = e.message;
                                0 == t && (_xx_util2.default.showToast("success", n), setTimeout(function() {
                                    wx.navigateBack({
                                        delta: 1
                                    });
                                }, 1500));
                            });
                        }
                    });

                  case 3:
                  case "end":
                    return e.stop();
                }
            }, e, n);
        }))();
    },
    toCancel: function(e) {
        var n = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var r, t;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    t = (r = n).data.data.id, wx.showModal({
                        title: "",
                        content: "是否确认要取消此次预约",
                        success: function(e) {
                            e.confirm && _index.pluginModel.toResCancel({
                                id: t
                            }).then(function(e) {
                                var t = e.errno, n = e.message;
                                0 == t && (_xx_util2.default.showToast("success", n), setTimeout(function() {
                                    r.setData({
                                        "data.status": 0
                                    });
                                }, 1500));
                            });
                        }
                    });

                  case 3:
                  case "end":
                    return e.stop();
                }
            }, e, n);
        }))();
    }
});