var _slicedToArray = function(e, t) {
    if (Array.isArray(e)) return e;
    if (Symbol.iterator in Object(e)) return function(e, t) {
        var r = [], a = !0, n = !1, o = void 0;
        try {
            for (var u, i = e[Symbol.iterator](); !(a = (u = i.next()).done) && (r.push(u.value), 
            !t || r.length !== t); a = !0) ;
        } catch (e) {
            n = !0, o = e;
        } finally {
            try {
                !a && i.return && i.return();
            } finally {
                if (n) throw o;
            }
        }
        return r;
    }(e, t);
    throw new TypeError("Invalid attempt to destructure non-iterable instance");
}, _xx_util = require("../../resource/js/xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util), _index = require("../../resource/apis/index.js");

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
        var i = e.apply(this, arguments);
        return new Promise(function(o, u) {
            return function t(e, r) {
                try {
                    var a = i[e](r), n = a.value;
                } catch (e) {
                    return void u(e);
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

var app = getApp(), regeneratorRuntime = _xx_util2.default.regeneratorRuntime, voucher = require("../../templates/voucher/voucher.js");

Page({
    data: {
        voucherStatus: {
            show: !1,
            status: "unreceive"
        },
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
    onLoad: function(n) {
        var o = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t, r, a;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    return t = n.uid, r = {
                        page: 1,
                        to_uid: t
                    }, a = getApp().globalData.isIphoneX, o.setData({
                        param: r,
                        isIphoneX: a
                    }), e.next = 6, o.onPullDownRefresh();

                  case 6:
                    o.getAuthInfoSuc();

                  case 7:
                  case "end":
                    return e.stop();
                }
            }, e, o);
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
    getList: function() {
        var c = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t, r, a, n, o, u, i, s;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    return r = (t = c).data, a = r.refresh, n = r.param, o = r.dataList, e.next = 4, 
                    _index.userModel.getCouponAll(n);

                  case 4:
                    u = e.sent, i = u.data, _xx_util2.default.hideAll(), s = o, a || (i.list = [].concat(_toConsumableArray(s.list), _toConsumableArray(i.list))), 
                    i.page = 1 * i.page, t.setData({
                        dataList: i,
                        loading: !1,
                        refresh: !1
                    });

                  case 11:
                  case "end":
                    return e.stop();
                }
            }, e, c);
        }))();
    },
    getAuthInfoSuc: function(e) {
        console.log(e, "getAuthInfoSuc");
        var t = this.data.openType, r = this.data.param.to_uid, a = getApp().getCurUserInfo(r, t);
        this.setData(a);
    },
    toGetCoupon: function(c) {
        var d = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t, r, a, n, o, u, i, s;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    return t = d, r = _xx_util2.default.getData(c), a = r.index, n = t.data.param.to_uid, 
                    o = t.data.dataList.list, u = o[a].id, _xx_util2.default.showLoading(), e.next = 8, 
                    _index.userModel.getCoupon({
                        to_uid: n,
                        coupon_id: u
                    });

                  case 8:
                    if (i = e.sent, s = i.errno, _xx_util2.default.hideAll(), 0 == s) {
                        e.next = 13;
                        break;
                    }
                    return e.abrupt("return");

                  case 13:
                    o[a].record_status = 1, t.setData({
                        "dataList.list": o
                    });

                  case 15:
                  case "end":
                    return e.stop();
                }
            }, e, d);
        }))();
    },
    toSetInd: function(e) {
        var t = _xx_util2.default.getData(e).index;
        this.setData({
            index: t
        });
    },
    getPhoneNumber: function(f) {
        var p = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t, r, a, n, o, u, i, s, c, d, l;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    if (t = p, r = f.detail, a = r.encryptedData, n = r.iv, o = t.data.param.to_uid, 
                    !a || !n) {
                        e.next = 21;
                        break;
                    }
                    return console.log(a, n), u = t.data.dataList.list, i = t.data.index, s = u[i].id, 
                    e.next = 10, Promise.all([ t.setPhoneInfo(a, n, o), _index.userModel.getCoupon({
                        to_uid: o,
                        coupon_id: s
                    }) ]);

                  case 10:
                    if (c = e.sent, d = _slicedToArray(c, 2), d[0], l = d[1], console.log(l, "res_coupon"), 
                    0 == l.errno) {
                        e.next = 17;
                        break;
                    }
                    return e.abrupt("return");

                  case 17:
                    u[i].record_status = 1, t.setData({
                        "dataList.list": u
                    }), e.next = 21;
                    break;

                  case 21:
                  case "end":
                    return e.stop();
                }
            }, e, p);
        }))();
    },
    setPhoneInfo: function(o, u, i) {
        var s = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t, r, a, n;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    return e.next = 2, _index.baseModel.getPhone({
                        encryptedData: o,
                        iv: u,
                        to_uid: i
                    });

                  case 2:
                    if (t = e.sent, r = t.data, _xx_util2.default.hideAll(), a = r.data.phone) {
                        e.next = 8;
                        break;
                    }
                    return e.abrupt("return");

                  case 8:
                    (n = wx.getStorageSync("user")).phone = a, wx.setStorageSync("user", n), getApp().globalData.hasClientPhone = !0, 
                    getApp().globalData.auth.authPhoneStatus = !0, that.getAuthInfoSuc();

                  case 14:
                  case "end":
                    return e.stop();
                }
            }, e, s);
        }))();
    },
    toUseCoupon: function(d) {
        var l = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t, r, a, n, o, u, i, s, c;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    return t = l, r = _xx_util2.default.getData(d), a = r.index, n = t.data.dataList.list[a], 
                    o = n.record_id, e.next = 6, _index.userModel.getCouponQr({
                        record_id: o
                    });

                  case 6:
                    if (u = e.sent, i = u.errno, s = u.data, _xx_util2.default.hideAll(), 0 == i) {
                        e.next = 12;
                        break;
                    }
                    return e.abrupt("return");

                  case 12:
                    c = s.path, t.setData({
                        tmp_qr: c,
                        currentVoucher: n,
                        "voucherStatus.show": !0,
                        "voucherStatus.status": "unreceive"
                    });

                  case 14:
                  case "end":
                    return e.stop();
                }
            }, e, l);
        }))();
    },
    toCloseVoucher: function() {
        voucher.toCloseVoucher(this);
    }
});