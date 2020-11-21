var _xx_util = require("../../../resource/js/xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util), _index = require("../../../resource/apis/index.js");

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
        var o = e.apply(this, arguments);
        return new Promise(function(a, u) {
            return function t(e, r) {
                try {
                    var n = o[e](r), i = n.value;
                } catch (e) {
                    return void u(e);
                }
                if (!n.done) return Promise.resolve(i).then(function(e) {
                    t("next", e);
                }, function(e) {
                    t("throw", e);
                });
                a(i);
            }("next");
        });
    };
}

var regeneratorRuntime = _xx_util2.default.regeneratorRuntime, app = getApp();

Page({
    data: {},
    onLoad: function(a) {
        var u = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t, r, n, i;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    return t = a.id, r = a.uid, e.next = 3, _index.pluginModel.getEnrollSign({
                        activity_id: t
                    });

                  case 3:
                    n = e.sent, i = n.data, u.setData({
                        activity_id: t,
                        to_uid: r,
                        form: i
                    });

                  case 6:
                  case "end":
                    return e.stop();
                }
            }, e, u);
        }))();
    },
    setFormValue: function(e, t) {
        var r = "form[" + e + "].value";
        this.setData(_defineProperty({}, r, t));
    },
    handerInputChange: function(e) {
        var t = _xx_util2.default.getData(e).index, r = _xx_util2.default.getValue(e);
        this.setFormValue(t, r);
    },
    validate: function(e) {
        var t = new _xx_util2.default.Validate(), r = e.titles, n = e.values;
        for (var i in n) t.add(n[i], "isNoEmpty", "请填写" + r[i]);
        return t.start();
    },
    toOrderBtn: function() {
        var x = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t, r, n, i, a, u, o, s, l, c, d, f, _;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    for (l in r = (t = x).data, n = r.activity_id, i = r.to_uid, a = r.form, u = [], 
                    o = [], s = [], a) u.push(a[l].id), o.push(a[l].title), s.push(a[l].value);
                    if (c = {
                        titles: o,
                        values: s
                    }, !(d = t.validate(c))) {
                        e.next = 11;
                        break;
                    }
                    return _xx_util2.default.showModal({
                        content: d
                    }), e.abrupt("return");

                  case 11:
                    return f = {
                        ids: u,
                        titles: o,
                        values: s,
                        activity_id: n,
                        to_uid: i,
                        sign: 1
                    }, e.next = 14, _index.pluginModel.getEnrollSign(f);

                  case 14:
                    if (_ = e.sent, 0 == _.errno) {
                        e.next = 18;
                        break;
                    }
                    return e.abrupt("return");

                  case 18:
                    _xx_util2.default.showSuccess("报名成功"), setTimeout(function() {
                        wx.redirectTo({
                            url: "/longbing_card/enroll/pages/order/order?s=user"
                        });
                    }, 1500);

                  case 20:
                  case "end":
                    return e.stop();
                }
            }, e, x);
        }))();
    }
});