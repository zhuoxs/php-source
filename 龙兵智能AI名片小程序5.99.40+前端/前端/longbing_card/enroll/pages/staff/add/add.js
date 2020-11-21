var _slicedToArray = function(e, t) {
    if (Array.isArray(e)) return e;
    if (Symbol.iterator in Object(e)) return function(e, t) {
        var r = [], a = !0, n = !1, i = void 0;
        try {
            for (var o, s = e[Symbol.iterator](); !(a = (o = s.next()).done) && (r.push(o.value), 
            !t || r.length !== t); a = !0) ;
        } catch (e) {
            n = !0, i = e;
        } finally {
            try {
                !a && s.return && s.return();
            } finally {
                if (n) throw i;
            }
        }
        return r;
    }(e, t);
    throw new TypeError("Invalid attempt to destructure non-iterable instance");
}, _xx_util = require("../../../../resource/js/xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util), _index = require("../../../../resource/apis/index.js");

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

var regeneratorRuntime = _xx_util2.default.regeneratorRuntime;

Page({
    data: {
        nowPageIndex: 1,
        tabbar: {
            color: "#838591",
            selectedColor: "#fb3447",
            backgroundColor: "#fff",
            borderStyle: "white",
            list: [ {
                pagePath: "/longbing_card/enroll/pages/staff/index",
                text: "发布的活动",
                iconPath: "icon-huodong",
                method: "redirectTo"
            }, {
                pagePath: "/longbing_card/enroll/pages/staff/add/add",
                text: "发活动",
                iconPath: "/longbing_card/enroll/images/2.png",
                method: "redirectTo"
            }, {
                pagePath: "/longbing_card/enroll/pages/order/order?s=staff",
                text: "我报名的活动",
                iconPath: "icon-wode",
                method: "redirectTo"
            } ]
        },
        selectObj: {},
        selectList: [],
        form: {
            classify_id: "",
            cover: {},
            carousel: [],
            detail_images: [],
            start_date: "",
            start_hour: "",
            end_date: "",
            end_hour: "",
            sign_limit: "",
            text_desc: "",
            address: {},
            ids: [],
            titles: []
        },
        form_titles: ""
    },
    onLoad: function(_) {
        var g = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t, r, a, n, i, o, s, d, u, l, c, f;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    return t = _.id, r = g.data, a = r.form, n = r.form_titles, i = getApp().globalData.isIphoneX, 
                    g.setData({
                        isIphoneX: i
                    }), e.next = 6, Promise.all([ getApp().getConfigInfo(!0), _index.pluginModel.getEnrFormItem(), t ? _index.pluginModel.getEnrollDetail({
                        activity_id: t
                    }) : "", t ? _index.pluginModel.getEnrollSign({
                        activity_id: t
                    }) : "" ]);

                  case 6:
                    if (o = e.sent, s = _slicedToArray(o, 4), s[0], d = s[1], u = s[2], l = s[3], !t) {
                        e.next = 19;
                        break;
                    }
                    for (c in u.data.ids = [], u.data.titles = [], l.data) u.data.ids.push(l.data[c].id), 
                    u.data.titles.push(l.data[c].title);
                    return e.next = 18, _xx_util2.default.getItems(l.data, "title");

                  case 18:
                    n = e.sent;

                  case 19:
                    wx.setNavigationBarTitle({
                        title: t ? "编辑活动" : "发布活动"
                    }), f = _xx_util2.default.formatTime(1e3 * (new Date().getTime() / 1e3).toFixed(0), "YY-M-D"), 
                    g.setData({
                        items: d.data,
                        form: t ? u.data : a,
                        classify_title: t ? u.data.classify.title : "",
                        form_titles: t ? n : "",
                        startDate: f
                    });

                  case 22:
                  case "end":
                    return e.stop();
                }
            }, e, g);
        }))();
    },
    toChooseAddr: function(e) {
        var r = this;
        wx.authorize({
            scope: "scope.userLocation",
            success: function(e) {
                wx.chooseLocation({
                    success: function(e) {
                        var t = {
                            address: e.address,
                            latitude: e.latitude,
                            longitude: e.longitude
                        };
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
    cropperImage: function(e) {
        var t = _xx_util2.default.getData(e), r = t.key, a = t.ratio;
        wx.chooseImage({
            count: 1,
            success: function(e) {
                var t = e.tempFiles;
                wx.navigateTo({
                    url: "/longbing_card/pages/common/cropper/cropper?key=" + r + "&src=" + t[0].path + "&ratio=" + a
                });
            }
        });
    },
    chooseImage: function(c) {
        var f = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t, r, a, n, i, o, s, d, u, l;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    return t = f, r = _xx_util2.default.getData(c), a = r.key, n = r.size, i = t.data.form[a] || [], 
                    e.next = 5, wx.pro.chooseImage({
                        count: n - 1 * i.length
                    });

                  case 5:
                    o = e.sent, s = o.tempFiles, _xx_util2.default.showLoading({
                        title: "上传中"
                    }), d = 0;

                  case 9:
                    if (!(d < s.length)) {
                        e.next = 17;
                        break;
                    }
                    return e.next = 12, _index.baseModel.toUpload({
                        filePath: s[d].path
                    });

                  case 12:
                    u = e.sent, i.push({
                        path: u.path,
                        img: u.img
                    });

                  case 14:
                    d++, e.next = 9;
                    break;

                  case 17:
                    _xx_util2.default.hideAll(), l = "form." + a, f.setData(_defineProperty({}, l, i));

                  case 20:
                  case "end":
                    return e.stop();
                }
            }, e, f);
        }))();
    },
    toDeleteImg: function(e) {
        var t = _xx_util2.default.getData(e), r = t.index, a = t.key, n = this.data.form[a];
        n.splice(r, 1), a = "form." + a, this.setData(_defineProperty({}, a, n));
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
    handerDateChange: function(i) {
        var o = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t, r, a, n;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    t = i.detail.value, r = _xx_util2.default.getData(i), a = r.key, n = "form." + a, 
                    o.setData(_defineProperty({}, n, t));

                  case 4:
                  case "end":
                    return e.stop();
                }
            }, e, o);
        }))();
    },
    validate: function(e) {
        var t = new _xx_util2.default.Validate(), r = e.classify_id, a = e.title, n = e.cover, i = e.carousel, o = e.detail_images, s = e.sign_limit, d = e.address, u = e.text_desc, l = e.ids, c = this.data.form, f = c.id, _ = c.start_date, g = c.end_date;
        return t.add(a, "isNoEmpty", "请填写活动标题"), t.add(n, "isNoEmpty", "请上传封面图"), t.add(i, "isNoEmpty", "请上传活动轮播图"), 
        t.add(u, "isNoEmpty", "请填写活动介绍"), t.add(o, "isNoEmpty", "请上传活动详情图"), t.add(s, "isNumber", "请填写活动限制人数"), 
        f || (t.add(r, "isNoEmpty", "请选择活动分类"), t.add(_, "isNoEmpty", "请选择活动开始日期"), t.add(g, "isNoEmpty", "请选择活动结束日期"), 
        t.add(d.address, "isNoEmpty", "请添加活动地址"), t.add(l, "isNoEmpty", "请编辑报名需填写的信息（如：姓名）")), 
        t.start();
    },
    toMsg: function(a) {
        var n = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t, r;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    if (t = _xx_util2.default.getData(a), !(r = t.msg)) {
                        e.next = 4;
                        break;
                    }
                    return _xx_util2.default.showModal({
                        content: r
                    }), e.abrupt("return");

                  case 4:
                  case "end":
                    return e.stop();
                }
            }, e, n);
        }))();
    },
    toOrderBtn: function() {
        var M = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t, r, a, n, i, o, s, d, u, l, c, f, _, g, m, x, p, h, y, v, w, b, D, k, P, T, E, I, R, N;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    for (D in t = M, r = wx.getStorageSync("userid"), a = t.data.form, n = a.id, i = a.classify_id, 
                    o = a.title, s = a.cover, d = a.carousel, u = a.detail_images, l = a.start_date, 
                    c = a.start_hour, f = a.end_date, _ = a.end_hour, g = a.start_time, m = a.end_time, 
                    x = a.sign_limit, p = a.address, h = a.text_desc, y = a.ids, v = a.titles, w = s.img || s, 
                    b = [], d) b.push(d[D].img || d[D]);
                    for (P in k = [], u) k.push(u[P].img || u[P]);
                    if (T = {
                        classify_id: i,
                        title: o,
                        cover: w,
                        carousel: b,
                        detail_images: k,
                        start_time: g = n ? g : l + " " + c,
                        end_time: m = n ? m : f + " " + _,
                        sign_limit: x,
                        address: p,
                        text_desc: h,
                        ids: y,
                        titles: v,
                        to_uid: r
                    }, n && (T.activity_id = n), !(E = t.validate(T))) {
                        e.next = 16;
                        break;
                    }
                    return _xx_util2.default.showModal({
                        content: E
                    }), e.abrupt("return");

                  case 16:
                    return e.next = 18, _index.pluginModel.toAddEnroll(T);

                  case 18:
                    if (I = e.sent, R = I.errno, N = I.data, 0 == R) {
                        e.next = 22;
                        break;
                    }
                    return e.abrupt("return");

                  case 22:
                    _xx_util2.default.showSuccess(n ? "修改成功" : "发布成功"), setTimeout(function() {
                        wx.redirectTo({
                            url: "/longbing_card/enroll/pages/staff/success/success?id=" + N.id
                        });
                    }, 1500);

                  case 24:
                  case "end":
                    return e.stop();
                }
            }, e, M);
        }))();
    }
});