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

var app = getApp(), regeneratorRuntime = _xx_util2.default.regeneratorRuntime;

Page({
    data: {},
    onLoad: function(d) {
        var f = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t, n, r, a, i, o, u, s, l, c;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    return t = f, n = d.id, r = d.fromstatus, e.next = 4, _index.staffModel.getQuestion({
                        client_id: n
                    });

                  case 4:
                    a = e.sent, i = void 0, o = a.data, u = o.id, s = o.title, l = o.questions, u || (i = "暂无问卷开启，请联系管理员开启"), 
                    l && l.length < 1 && (i = "暂无问题，请联系管理员填写问题"), (!u || l.length < 1) && wx.showModal({
                        title: "",
                        content: i,
                        showCancel: !1,
                        success: function(e) {
                            e.confirm && wx.navigateBack();
                        }
                    }), c = getApp().globalData.isIphoneX, t.setData({
                        id: n,
                        fromstatus: r || "",
                        title: s,
                        questions: l,
                        isIphoneX: c
                    }), wx.setNavigationBarTitle({
                        title: getApp().globalData.configInfo.config.question_text
                    });

                  case 13:
                  case "end":
                    return e.stop();
                }
            }, e, f);
        }))();
    },
    setFormValue: function(e, t) {
        var n = this.data.questions;
        n[e].answer = t, this.setData({
            questions: n
        });
    },
    handerInputChange: function(e) {
        var t = _xx_util2.default.getData(e).key, n = _xx_util2.default.getValue(e);
        this.setFormValue(t, n);
    },
    validate: function(e) {
        var t = new _xx_util2.default.Validate(), n = e.answer;
        return t.add(n, "isNoEmpty", "请至少回答一个问题"), t.start();
    },
    toConfirm: function(e) {
        var f = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t, n, r, a, i, o, u, s, l, c, d;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    for (o in t = f.data, n = t.id, r = t.questions, (a = {}).client_id = n, i = "", 
                    _xx_util2.default.showLoading(), r) a["id_" + r[o].id] = r[o].answer, i += r[o].answer;
                    if (console.log(i), i = i.replace(/(^\s*)|(\s*$)/g, ""), u = {
                        answer: i
                    }, !(s = f.validate(u))) {
                        e.next = 13;
                        break;
                    }
                    return _xx_util2.default.showModal({
                        content: s
                    }), e.abrupt("return");

                  case 13:
                    return e.next = 15, _index.staffModel.setQuestion(a);

                  case 15:
                    l = e.sent, _xx_util2.default.hideAll(), c = l.errno, d = l.message, 0 == c ? (_xx_util2.default.showToast("success", d), 
                    setTimeout(function() {
                        wx.navigateBack();
                    }, 1500)) : console.log(d);

                  case 19:
                  case "end":
                    return e.stop();
                }
            }, e, f);
        }))();
    },
    formSubmit: function(e) {
        this.data.form;
        var t = e.detail.formId;
        _index.baseModel.getFormId({
            formId: t
        });
    }
});