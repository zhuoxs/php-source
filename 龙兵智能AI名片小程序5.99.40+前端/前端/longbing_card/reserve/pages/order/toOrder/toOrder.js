var _xx_util = require("../../../../resource/js/xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util), _index = require("../../../../resource/apis/index.js");

function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

function _defineProperty(e, t, r) {
    return t in e ? Object.defineProperty(e, t, {
        value: r,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : e[t] = r, e;
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

var regeneratorRuntime = _xx_util2.default.regeneratorRuntime, app = getApp();

Page({
    data: {
        form: {
            name: "",
            phone: "",
            date: "",
            range: "",
            remark: ""
        }
    },
    onLoad: function(e) {
        var g = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t, r, a, n, i, o, u, s, d, c, l, f, _, p, x;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    t = g, r = _xx_util2.default.getPage(-1).data.data, a = r.id, n = r.title, i = r.appoint_price, 
                    o = r.cover, u = r.desc, s = r.classify_title, d = r.date, c = r.range, l = r.address_switch, 
                    f = _xx_util2.default.getPage(-1).data, _ = f.productDefault, p = f.optionsParam, 
                    x = p.to_uid, t.setData({
                        title: n,
                        appoint_price: i,
                        cover: o,
                        desc: u,
                        classify_title: s,
                        date: d,
                        range: c,
                        address_switch: l,
                        productDefault: _,
                        isIphoneX: getApp().globalData.isIphoneX,
                        "form.id": a,
                        "form.to_uid": x,
                        "form.date": d[0],
                        "form.range": c[0].value
                    });

                  case 5:
                  case "end":
                    return e.stop();
                }
            }, e, g);
        }))();
    },
    pickerSelected: function(e) {
        var t = _xx_util2.default.getData(e).key, r = e.detail.value || this.data.form.range, a = void 0, n = this.data, i = n.date, o = n.range;
        "date" == t && (a = i[r]), "range" == t && (a = o[r].value), this.setFormValue(t, a);
    },
    setFormValue: function(e, t) {
        e = "form." + e, this.setData(_defineProperty({}, e, t));
    },
    handerInputChange: function(e) {
        var t = _xx_util2.default.getData(e).key, r = _xx_util2.default.getValue(e);
        this.setFormValue(t, r);
    },
    toChooseAddr: function(e) {
        var r = this;
        wx.authorize({
            scope: "scope.userLocation",
            success: function(e) {
                wx.chooseLocation({
                    success: function(e) {
                        var t = e.address;
                        r.setData({
                            "form.address": t
                        });
                    }
                });
            },
            fail: function(e) {
                var t = e.errMsg;
                r.setData({
                    isSetting: t.includes("auth")
                });
            }
        });
    },
    validate: function(e) {
        var t = new _xx_util2.default.Validate(), r = e.name, a = e.phone, n = e.date, i = e.range, o = e.address, u = this.data.address_switch;
        return t.add(r, "isNoEmpty", "请填写姓名"), t.add(a, "isNoEmpty", "请填写手机号码"), t.add(a, "isMobile", "请填写11位手机号"), 
        t.add(n, "isNoEmpty", "请选择服务日期"), t.add(i, "isNoEmpty", "请选择服务时间"), 1 == u && t.add(o, "isNoEmpty", "请选择服务地址"), 
        t.start();
    },
    toReserveBtn: function() {
        var u = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t, r, a, n, i, o;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    if (r = (t = u).data.form, !(a = t.validate(r))) {
                        e.next = 6;
                        break;
                    }
                    return _xx_util2.default.showModal({
                        content: a
                    }), e.abrupt("return");

                  case 6:
                    return e.next = 8, _index.pluginModel.toReserveBook(r);

                  case 8:
                    n = e.sent, i = n.errno, o = n.message, 0 == i && (_xx_util2.default.showToast("success", o), 
                    setTimeout(function() {
                        wx.redirectTo({
                            url: "/longbing_card/reserve/pages/order/list/list?s=user"
                        });
                    }, 1500));

                  case 11:
                  case "end":
                    return e.stop();
                }
            }, e, u);
        }))();
    }
});