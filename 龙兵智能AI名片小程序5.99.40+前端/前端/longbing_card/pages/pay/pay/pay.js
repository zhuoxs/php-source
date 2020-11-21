var _xx_util = require("../../../resource/js/xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util), _index = require("../../../resource/apis/index.js");

function _interopRequireDefault(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}

function _asyncToGenerator(t) {
    return function() {
        var u = t.apply(this, arguments);
        return new Promise(function(r, i) {
            return function e(t, a) {
                try {
                    var n = u[t](a), o = n.value;
                } catch (t) {
                    return void i(t);
                }
                if (!n.done) return Promise.resolve(o).then(function(t) {
                    e("next", t);
                }, function(t) {
                    e("throw", t);
                });
                r(o);
            }("next");
        });
    };
}

var app = getApp(), regeneratorRuntime = _xx_util2.default.regeneratorRuntime;

Page({
    data: {
        show_keyboard: !1,
        money: "",
        pay_money: 0,
        authStatus: !1,
        is_pay: !1
    },
    onLoad: function(t) {
        var e = {
            to_uid: t.uid
        }, a = getApp().globalData.logoImg;
        wx.getSystemInfo({
            success: function(t) {
                e.windowHeight = t.windowHeight;
            }
        });
        var n = wx.getStorageSync("user").nickName;
        this.setData({
            optionsParam: e,
            logoImg: a,
            nickName: n,
            authStatus: !n
        }), this.getPayConfig();
    },
    getUserInfo: function(t) {
        var a = this;
        if (t.detail.userInfo) {
            var n = t.detail.userInfo;
            console.log("获取微信用户信息 ==>>", n), getApp().globalData.auth.authStatus = !0, _index.baseModel.getUpdateUserInfo(n).then(function(t) {
                _xx_util2.default.hideAll();
                var e = wx.getStorageSync("user");
                e.nickName = n.nickName, e.avatarUrl = n.avatarUrl, wx.setStorageSync("user", e), 
                a.setData({
                    authStatus: !1
                });
            });
        } else console.log("拒绝授权"), this.setData({
            authStatus: !1
        });
    },
    getPayConfig: function() {
        var o = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function t() {
            var e, a, n;
            return regeneratorRuntime.wrap(function(t) {
                for (;;) switch (t.prev = t.next) {
                  case 0:
                    return e = o.data.optionsParam.to_uid, t.next = 3, _index.pluginModel.getPayConfig({
                        to_uid: e
                    });

                  case 3:
                    a = t.sent, n = a.data, wx.setNavigationBarTitle({
                        title: n.title || "向商户付款"
                    }), o.setData({
                        pay_config: n
                    });

                  case 7:
                  case "end":
                    return t.stop();
                }
            }, t, o);
        }))();
    },
    getPhoneNumber: function(c) {
        var f = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function t() {
            var e, o, a, n, r, i, u, s, l;
            return regeneratorRuntime.wrap(function(t) {
                for (;;) switch (t.prev = t.next) {
                  case 0:
                    if (e = _xx_util2.default.getData(c), o = e.key, a = c.detail, n = a.encryptedData, 
                    r = a.iv, console.log(n, r, c), i = f.data.pay_config, u = i.first_full, s = i.first_reduce, 
                    !("1" == o && 0 < 1 * s)) {
                        t.next = 9;
                        break;
                    }
                    return f.toWxPay(), t.abrupt("return", !1);

                  case 9:
                    n && r ? (console.log("同意授权获取电话号码"), l = f.data.optionsParam.to_uid, _index.baseModel.getPhone({
                        encryptedData: n,
                        iv: r,
                        to_uid: l
                    }).then(function(t) {
                        _xx_util2.default.hideAll();
                        var e = t.data;
                        if (e) {
                            var a = wx.getStorageSync("user");
                            a.phone = e.phone, wx.setStorageSync("user", a), console.log(e.phone, "phone");
                        }
                        (getApp().globalData.hasClientPhone = !0, getApp().globalData.auth.authPhoneStatus = !0, 
                        f.setData({
                            "pay_config.phone": e.phone,
                            "pay_config.is_first": 1
                        }), "1" == o && f.toCancel(), "2" == o) && (1 * f.data.money < 1 * u ? (console.log("未达到满减金额"), 
                        f.setData({
                            showModal: "more",
                            is_not_full: "not_full"
                        })) : f.toCancel());
                        var n = f.data.money;
                        f.toCount(n);
                    })) : (console.log("拒绝授权获取电话号码"), f.toCancel());

                  case 10:
                  case "end":
                    return t.stop();
                }
            }, t, f);
        }))();
    },
    toShowKeyboard: function(t) {
        var e = _xx_util2.default.getData(t).val;
        this.setData({
            show_keyboard: e
        });
    },
    toAdd: function(t) {
        var e = _xx_util2.default.getData(t).val, a = this.data.money;
        a += e, this.toCount(a);
    },
    toDel: function() {
        var t = this.data.money;
        t = t.slice(0, t.length - 1), this.toCount(t);
    },
    toCount: function(t) {
        var e = this.data, a = e.pay_money, n = e.pay_config, o = e.is_pay, r = n.first_full, i = n.first_reduce, u = n.is_first, s = n.phone;
        if ("00" == t || "0.00" == t) return _xx_util2.default.showFail("请输入正确的金额！"), !1;
        if (!t.includes(".") && 7 < t.length) return _xx_util2.default.showFail("不能输入更大的金额了！"), 
        !1;
        if ("0" == t.slice(0, 1) && 0 < t.slice(1, 2) && (t = t.slice(1, 2)), "." == t.slice(0, 1) && (t = "0."), 
        t.includes(".")) {
            var l = t.split(".");
            if (2 < l.length) return _xx_util2.default.showFail("请输入正确的金额！"), !1;
            if (7 < l[0].length) return _xx_util2.default.showFail("不能输入更大的金额了！"), !1;
            if (2 < l[1].length) return _xx_util2.default.showFail("只能输入两位小数哦！"), !1;
        }
        1 * (a = t) < 1 * r || 1 == u && s && (a = (1 * t - 1 * i).toFixed(2));
        var c = 1 * t < 1 * r ? "not_full" : "full";
        if (o) return !1;
        this.setData({
            money: t,
            pay_money: a,
            is_not_full: c
        });
    },
    toCancel: function() {
        this.setData({
            showModal: !1,
            is_not_full: "not_full"
        }), this.toPayQrPay();
    },
    toMore: function() {
        this.setData({
            is_pay: !1,
            showModal: !1,
            is_not_full: "not_full"
        });
    },
    toWxPay: function() {
        var s = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function t() {
            var e, a, n, o, r, i, u;
            return regeneratorRuntime.wrap(function(t) {
                for (;;) switch (t.prev = t.next) {
                  case 0:
                    if (a = (e = s).data.pay_config, n = a.phone, o = a.first_reduce, r = s.data, i = r.money, 
                    u = r.is_pay, i && "0" != i && "0." != i && "0.0" != i) {
                        t.next = 6;
                        break;
                    }
                    return _xx_util2.default.showFail("请输入正确的金额！"), t.abrupt("return", !1);

                  case 6:
                    if (!u) {
                        t.next = 8;
                        break;
                    }
                    return t.abrupt("return", !1);

                  case 8:
                    if (n || !(0 < 1 * o)) {
                        t.next = 11;
                        break;
                    }
                    return e.setData({
                        is_pay: !0,
                        showModal: "phone"
                    }), t.abrupt("return", !1);

                  case 11:
                    e.toPayQrPay();

                  case 12:
                  case "end":
                    return t.stop();
                }
            }, t, s);
        }))();
    },
    toPayQrPay: function(p) {
        var h = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function t() {
            var e, a, n, o, r, i, u, s, l, c, f, _, d, g;
            return regeneratorRuntime.wrap(function(t) {
                for (;;) switch (t.prev = t.next) {
                  case 0:
                    if (a = (e = h).data, n = a.money, o = a.optionsParam, r = a.pay_config, i = a.is_not_full, 
                    u = o.to_uid, s = r.is_first, l = r.first_full, c = r.phone, s = 1 == s && c ? 1 : 0, 
                    n && "0" != n && "0." != n && "0.0" != n) {
                        t.next = 8;
                        break;
                    }
                    return _xx_util2.default.showFail("请输入正确的金额！"), t.abrupt("return", !1);

                  case 8:
                    if (p && (f = _xx_util2.default.getData(p), _ = f.key, i = _), !("not_full" == i && 1 == s && 1 * n < 1 * l)) {
                        t.next = 13;
                        break;
                    }
                    return console.log("未达到满减金额"), h.setData({
                        showModal: "more"
                    }), t.abrupt("return", !1);

                  case 13:
                    return h.setData({
                        showModal: !1,
                        is_pay: !0
                    }), t.next = 16, _index.pluginModel.toPayQrPay({
                        to_uid: u,
                        is_first: s,
                        money: n
                    });

                  case 16:
                    d = t.sent, g = d.data, wx.requestPayment({
                        timeStamp: g.timeStamp,
                        nonceStr: g.nonceStr,
                        package: g.package,
                        signType: "MD5",
                        paySign: g.paySign,
                        success: function(t) {
                            wx.showToast({
                                icon: "none",
                                image: "/longbing_card/resource/images/alert.png",
                                title: "支付成功",
                                duration: 2e3,
                                success: function() {
                                    setTimeout(function() {
                                        e.setData({
                                            is_pay: !1
                                        });
                                        var t = e.data.optionsParam.to_uid;
                                        wx.redirectTo({
                                            url: "/longbing_card/pages/pay/list/list?uid=" + t
                                        });
                                    }, 1500);
                                }
                            });
                        },
                        fail: function(t) {
                            wx.showToast({
                                icon: "none",
                                image: "/longbing_card/resource/images/error.png",
                                title: "支付失败",
                                duration: 2e3,
                                success: function() {
                                    e.setData({
                                        is_pay: !1
                                    });
                                }
                            });
                        }
                    });

                  case 19:
                  case "end":
                    return t.stop();
                }
            }, t, h);
        }))();
    }
});