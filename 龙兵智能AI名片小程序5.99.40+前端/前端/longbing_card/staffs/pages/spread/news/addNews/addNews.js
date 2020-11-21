var _xx_util = require("../../../../../resource/js/xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util), _index = require("../../../../../resource/apis/index.js");

function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

function _defineProperty(e, t, a) {
    return t in e ? Object.defineProperty(e, t, {
        value: a,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : e[t] = a, e;
}

function _asyncToGenerator(e) {
    return function() {
        var u = e.apply(this, arguments);
        return new Promise(function(o, i) {
            return function t(e, a) {
                try {
                    var n = u[e](a), r = n.value;
                } catch (e) {
                    return void i(e);
                }
                if (!n.done) return Promise.resolve(r).then(function(e) {
                    t("next", e);
                }, function(e) {
                    t("throw", e);
                });
                o(r);
            }("next");
        });
    };
}

var app = getApp(), regeneratorRuntime = _xx_util2.default.regeneratorRuntime;

Page({
    data: {
        dataList: [],
        globalData: {},
        status: "",
        currentIndex: 0,
        imgCountNum: 9,
        tempFilePaths: [],
        tempFileImgs: [],
        form: {
            number: "",
            title: "",
            content: "",
            cover: []
        }
    },
    onLoad: function(e) {
        var t = e.status, a = e.opengid, n = e.number;
        wx.setNavigationBarTitle({
            title: "news" == t ? "动态发布" : "code" == t ? "自定义码" : "群成员数(人)"
        });
        var r = {
            status: t,
            openGId: a,
            number: n,
            modelMethod: "news" == t ? "getAddTimeLine" : "code" == t ? "getReleaseQr" : "setGroupNum"
        }, o = this.data.form;
        n && (o.number = n), this.setData({
            paramData: r,
            form: o,
            globalData: app.globalData
        });
    },
    chooseImage: function(c) {
        var f = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t, a, n, r, o, i, u, s, l, d;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    return t = f, a = _xx_util2.default.getData(c), n = a.key, r = a.size, o = t.data.form[n] || [], 
                    e.next = 5, wx.pro.chooseImage({
                        count: r - 1 * o.length
                    });

                  case 5:
                    i = e.sent, u = i.tempFiles, _xx_util2.default.showLoading({
                        title: "上传中"
                    }), s = 0;

                  case 9:
                    if (!(s < u.length)) {
                        e.next = 17;
                        break;
                    }
                    return e.next = 12, _index.baseModel.toUpload({
                        filePath: u[s].path
                    });

                  case 12:
                    l = e.sent, o.push({
                        path: l.path,
                        img: l.img
                    });

                  case 14:
                    s++, e.next = 9;
                    break;

                  case 17:
                    _xx_util2.default.hideAll(), d = "form." + n, f.setData(_defineProperty({}, d, o));

                  case 20:
                  case "end":
                    return e.stop();
                }
            }, e, f);
        }))();
    },
    toDeleteImg: function(e) {
        var t = _xx_util2.default.getData(e), a = t.index, n = t.key, r = this.data.form[n];
        r.splice(a, 1), n = "form." + n, this.setData(_defineProperty({}, n, r));
    },
    setFormValue: function(e, t) {
        e = "form." + e, this.setData(_defineProperty({}, e, t));
    },
    handerImageChange: function(e, t) {
        this.setFormValue(e, t);
    },
    handerInputChange: function(e) {
        var t = _xx_util2.default.getData(e).key, a = _xx_util2.default.getValue(e);
        this.setFormValue(t, a);
    },
    validate: function(e) {
        var t = new _xx_util2.default.Validate(), a = e.title, n = e.content, r = e.cover, o = e.number, i = this.data.paramData.status;
        return "group" == i && t.add(o, "isNumber", "请填写群成员数"), "group" != i && (t.add(a, "isNoEmpty", "news" == i ? "请填写名称" : "请填写自定义码标题"), 
        t.add(n, "isNoEmpty", "请填写内容"), "news" == i && t.add(r, "isNoEmpty", "请上传图片")), 
        t.start();
    },
    toSaveBtn: function() {
        var v = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t, a, n, r, o, i, u, s, l, d, c, f, m, x, p, _, g, h;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    if (a = (t = v).data, n = a.paramData, r = a.form, o = r.title, i = r.content, u = r.number, 
                    s = r.cover, l = n.status, d = n.openGId, c = n.modelMethod, f = "", "news" == l) {
                        for (m in s) f += s[m].img + ",";
                        f = f.slice(0, -1);
                    }
                    if (x = "news" == l ? {
                        title: o,
                        content: i,
                        cover: f
                    } : "code" == l ? {
                        title: o,
                        content: i
                    } : {
                        number: u,
                        openGId: d
                    }, !(p = t.validate(x))) {
                        e.next = 11;
                        break;
                    }
                    return _xx_util2.default.showModal({
                        content: p
                    }), e.abrupt("return");

                  case 11:
                    return e.next = 13, _index.staffModel[c](x);

                  case 13:
                    _ = e.sent, g = _.errno, h = _.message, 0 != g ? "group" == l ? t.setData({
                        showAddUseSec: !1
                    }) : _xx_util2.default.showModal({
                        title: h
                    }) : (_xx_util2.default.showFail("news" == l ? "动态发布成功！" : "code" == l ? "自定义码发布成功！" : "已成功设置群成员数！"), 
                    setTimeout(function() {
                        wx.navigateBack({
                            delta: 1
                        });
                    }, 1500));

                  case 16:
                  case "end":
                    return e.stop();
                }
            }, e, v);
        }))();
    }
});