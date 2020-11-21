var _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function(e) {
    return typeof e;
} : function(e) {
    return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e;
}, _xx_util = require("../../../../../resource/js/xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util), _index = require("../../../../../resource/apis/index.js");

function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

function _asyncToGenerator(e) {
    return function() {
        var u = e.apply(this, arguments);
        return new Promise(function(o, i) {
            return function t(e, r) {
                try {
                    var n = u[e](r), a = n.value;
                } catch (e) {
                    return void i(e);
                }
                if (!n.done) return Promise.resolve(a).then(function(e) {
                    t("next", e);
                }, function(e) {
                    t("throw", e);
                });
                o(a);
            }("next");
        });
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

var app = getApp(), regeneratorRuntime = _xx_util2.default.regeneratorRuntime;

Page({
    data: {
        form: {
            title: "",
            cover: {}
        }
    },
    onLoad: function(e) {
        console.log(e, "options");
        var t = e.title, r = {
            title: t,
            tmpPath: e.tmpPath,
            tmpImg: e.tmpImg
        };
        t && (null != (void 0 === t ? "undefined" : _typeof(t)) && "undefined" != t && t || (r.title = "")), 
        this.setData({
            paramObj: r,
            globalData: app.globalData
        });
    },
    cropperImage: function(e) {
        var t = _xx_util2.default.getData(e), r = t.key, n = t.ratio;
        wx.chooseImage({
            count: 1,
            success: function(e) {
                var t = e.tempFiles;
                wx.navigateTo({
                    url: "/longbing_card/pages/common/cropper/cropper?key=" + r + "&src=" + t[0].path + "&ratio=" + n
                });
            }
        });
    },
    setFormValue: function(e, t) {
        e = "form." + e, this.setData(_defineProperty({}, e, t));
    },
    handerImageChange: function(e, t) {
        this.setFormValue(e, t);
    },
    handerInputChange: function(e) {
        var t = _xx_util2.default.getData(e).key, r = _xx_util2.default.getValue(e);
        this.setFormValue(t, r);
    },
    toDeleteImg: function(e) {
        var t = _xx_util2.default.getData(e), r = (t.index, t.key), n = this.data.form[r];
        n.path = "", n.img = "", r = "form." + r, this.setData(_defineProperty({}, r, n));
    },
    validate: function(e) {
        var t = new _xx_util2.default.Validate(), r = e.title, n = e.img;
        return t.add(r, "isNoEmpty", "请填写海报标题"), t.add(n, "isNoEmpty", "请上传海报"), t.start();
    },
    toSavePoster: function() {
        var u = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t, r, n, a, o, i;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    if (r = (t = u).data.form, n = r.title, a = r.cover, o = {
                        title: n,
                        img: a.img
                    }, !(i = t.validate(o))) {
                        e.next = 7;
                        break;
                    }
                    return _xx_util2.default.showModal({
                        content: i
                    }), e.abrupt("return");

                  case 7:
                    return e.next = 9, _index.userModel.getSavePoster(o);

                  case 9:
                    if (0 == e.sent.errno) {
                        e.next = 12;
                        break;
                    }
                    return e.abrupt("return");

                  case 12:
                    _xx_util2.default.showSuccess("海报上传成功"), setTimeout(function() {
                        wx.navigateBack();
                    }, 500);

                  case 14:
                  case "end":
                    return e.stop();
                }
            }, e, u);
        }))();
    }
});