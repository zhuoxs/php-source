Object.defineProperty(exports, "__esModule", {
    value: !0
}), exports.formatImageUrl = exports.uploadFile = exports.req = exports.fly = void 0;

var _xx_util = require("./xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util), _siteinfo = require("../../../siteinfo.js"), _siteinfo2 = _interopRequireDefault(_siteinfo);

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

var Fly = require("./wx.js"), fly = new Fly(), tokenFly = new Fly(), regeneratorRuntime = _xx_util2.default.regeneratorRuntime, allSiteInfo = Object.assign({}, {
    time: "2019年07月09日 15:21",
    remark: "update emw/order/mine/plugin/addr ~ "
}, _siteinfo2.default);

console.log(allSiteInfo);

var isWq = !0, formatUrl = function(e) {
    if (isWq) {
        return e = _siteinfo2.default.siteroot + "?i=" + _siteinfo2.default.uniacid + "&t=" + _siteinfo2.default.multiid + "&v=" + _siteinfo2.default.version + "&from=wxapp&c=entry&a=wxapp&m=longbing_card&do=" + e;
    }
    return e = _siteinfo2.default.siteroot + "?i=" + _siteinfo2.default.uniacid + "&do=" + e;
}, formatImageUrl = function(e) {
    return -1 < e.indexOf(_siteinfo2.default.siteroot) ? e : formatUrl("getImage") + "&url=" + encodeURIComponent(e);
};

Promise.prototype.finally = function(t) {
    var r = this.constructor;
    return this.then(function(e) {
        return r.resolve(t()).then(function() {
            return e;
        });
    }, function(e) {
        return r.resolve(t()).then(function() {
            throw e;
        });
    });
};

var tmp_login_time = 0, login = function() {
    var e = _asyncToGenerator(regeneratorRuntime.mark(function e() {
        var t, r, n, a, o;
        return regeneratorRuntime.wrap(function(e) {
            for (;;) switch (e.prev = e.next) {
              case 0:
                return t = formatUrl(t = "inlogin"), _xx_util2.default.showLoading("登录中..."), e.prev = 3, 
                e.next = 6, wx.pro.login();

              case 6:
                if (r = e.sent, n = r.code, !(2 < ++tmp_login_time)) {
                    e.next = 12;
                    break;
                }
                e.next = 20;
                break;

              case 12:
                return e.next = 14, tokenFly.post(t, {
                    code: n
                });

              case 14:
                if (0 == (a = e.sent).errno) {
                    e.next = 17;
                    break;
                }
                throw a;

              case 17:
                return _xx_util2.default.hideAll(), o = a.data, e.abrupt("return", o);

              case 20:
                e.next = 27;
                break;

              case 22:
                return e.prev = 22, e.t0 = e.catch(3), e.next = 26, Promise.reject(e.t0);

              case 26:
                return e.abrupt("return", e.sent);

              case 27:
              case "end":
                return e.stop();
            }
        }, e, this, [ [ 3, 22 ] ]);
    }));
    return function() {
        return e.apply(this, arguments);
    };
}(), bind = function() {
    var e = _asyncToGenerator(regeneratorRuntime.mark(function e() {
        var t, r, n;
        return regeneratorRuntime.wrap(function(e) {
            for (;;) switch (e.prev = e.next) {
              case 0:
                if (t = formatUrl(t = "binduser"), r = wx.getStorageSync("pid"), n = wx.getStorageSync("userid"), 
                r && r != n) {
                    e.next = 6;
                    break;
                }
                return e.abrupt("return", !1);

              case 6:
                return e.next = 8, fly.post(t, {
                    from_id: r
                });

              case 8:
              case "end":
                return e.stop();
            }
        }, e, this);
    }));
    return function() {
        return e.apply(this, arguments);
    };
}();

fly.config.timeout = 3e4, fly.config.headers = tokenFly.config.headers = {
    "content-type": "application/x-www-form-urlencoded"
}, fly.interceptors.request.use(function(a) {
    a.body || (a.body = {});
    var e = wx.getStorageSync("userid") || "", t = wx.getStorageSync("token") || "", o = wx.getStorageSync("lb_token") || "";
    if (!t || !e) return fly.lock(), login().then(function(e) {
        var t = e.token, r = e.user_id, n = e.user;
        return a.headers.token = t, a.headers.lbtoken = o, a.body.user_id = r, getApp().globalData.userid = r, 
        getApp().globalData.hasClientPhone = !!n.phone, wx.setStorageSync("token", t), wx.setStorageSync("userid", r), 
        wx.setStorageSync("user", n), bind(), a;
    }).finally(function() {
        fly.unlock();
    });
    a.headers.token = t, a.headers.lbtoken = o, a.body.user_id = e;
}), tokenFly.interceptors.response.use(function(e) {
    _xx_util2.default.hideAll();
    var t = e.request.url.split("&do=")[1];
    if (-2 == e.data.errno || -2 == e.data.code) {
        if ([ "login", "inlogin" ].includes(t) && 2 < tmp_login_time) {
            var r = e.data.message || e.data.msg;
            -2 == e.data.errno && 2 == r && (-1 < (r = e.data.data.errmsg || e.data.data[0].errmsg).indexOf("invalid appid,") && (r = "AppID填写错误 请检查后重填"), 
            -1 < r.indexOf("invalid appsecret,") && (r = "AppSecret填写错误 请检查后重填")), -1 < r.indexOf("too many") && (r = "小程序数量超过限制"), 
            console.log("errmsg =>", r), _xx_util2.default.showModal({
                content: r
            });
        }
    }
    return e.data;
}, function(e) {
    _xx_util2.default.hideAll();
}), fly.interceptors.response.use(function(o) {
    _xx_util2.default.hideAll();
    var e = o.request.url.split("&do=")[1];
    return 401 == o.data.code || 401 == o.data.errno ? (fly.lock(), login().then(function(e) {
        var t = e.token, r = e.user_id, n = e.user;
        console.log(e, "************保存token和将token动态加入header");
        var a = wx.getStorageSync("lb_token") || "";
        o.request.headers.token = t, o.request.headers.lbtoken = a, o.request.body.user_id = r, 
        getApp().globalData.userid = r, getApp().globalData.hasClientPhone = !!n.phone, 
        wx.setStorageSync("token", t), wx.setStorageSync("userid", r), wx.setStorageSync("user", n), 
        bind();
    }).finally(function() {
        fly.unlock();
    }).then(function() {
        return fly.request(o.request);
    })) : (-2 != o.data.errno && -2 != o.data.code || [ "cardshow", "cardafter", "cardshowv2", "cardafterv2", "binduser", "login", "EditStaffV2", "timelineDetail", "modularInfo", "appointdetail" ].includes(e) || _xx_util2.default.showModal({
        content: o.data.message || o.data.msg
    }), o.data);
}, function(e) {
    return _xx_util2.default.hideAll(), e;
});

var uploadFile = function() {
    var t = _asyncToGenerator(regeneratorRuntime.mark(function e(t) {
        var r, n, a = 1 < arguments.length && void 0 !== arguments[1] ? arguments[1] : {}, o = a.name, i = void 0 === o ? "upfile" : o, u = a.filePath, s = a.header, l = void 0 === s ? {
            token: wx.getStorageSync("token")
        } : s, c = a.formData, f = void 0 === c ? {
            type: "picture"
        } : c;
        return regeneratorRuntime.wrap(function(e) {
            for (;;) switch (e.prev = e.next) {
              case 0:
                return t = formatUrl(t), e.prev = 1, e.next = 4, wx.pro.uploadFile({
                    url: t,
                    filePath: u,
                    name: i,
                    formData: f,
                    header: l
                });

              case 4:
                if (200 == (r = e.sent).statusCode) {
                    e.next = 7;
                    break;
                }
                throw r;

              case 7:
                if (401 == (n = JSON.parse(r.data)).errno && login().then(function(e) {
                    wx.setStorageSync("user", e);
                }).finally(function() {}).then(function() {
                    uploadFile(t, {
                        filePath: u
                    });
                }), 0 == n.errno || 401 == n.errno) {
                    e.next = 11;
                    break;
                }
                throw r;

              case 11:
                return e.abrupt("return", n.data);

              case 14:
                return e.prev = 14, e.t0 = e.catch(1), _xx_util2.default.hideAll(), 200 != e.t0.statusCode ? _xx_util2.default.networkError(e.t0.statusCode) : _xx_util2.default.showFail("上传失败"), 
                e.next = 20, Promise.reject(e.t0);

              case 20:
                return e.abrupt("return", e.sent);

              case 21:
              case "end":
                return e.stop();
            }
        }, e, void 0, [ [ 1, 14 ] ]);
    }));
    return function(e) {
        return t.apply(this, arguments);
    };
}(), req = {
    post: function(r, n) {
        var a = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    return r = formatUrl(r), e.prev = 1, e.next = 4, fly.post(r, n);

                  case 4:
                    if (t = e.sent) {
                        e.next = 9;
                        break;
                    }
                    return e.next = 8, Promise.reject(t);

                  case 8:
                    return e.abrupt("return", e.sent);

                  case 9:
                    return e.abrupt("return", t);

                  case 12:
                    return e.prev = 12, e.t0 = e.catch(1), e.next = 16, Promise.reject(e.t0);

                  case 16:
                    return e.abrupt("return", e.sent);

                  case 17:
                  case "end":
                    return e.stop();
                }
            }, e, a, [ [ 1, 12 ] ]);
        }))();
    },
    get: function(r, n) {
        var a = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    return r = formatUrl(r), e.prev = 1, e.next = 4, fly.post(r, n);

                  case 4:
                    if (t = e.sent) {
                        e.next = 9;
                        break;
                    }
                    return e.next = 8, Promise.reject(t);

                  case 8:
                    return e.abrupt("return", e.sent);

                  case 9:
                    return e.abrupt("return", t);

                  case 12:
                    return e.prev = 12, e.t0 = e.catch(1), e.next = 16, Promise.reject(e.t0);

                  case 16:
                    return e.abrupt("return", e.sent);

                  case 17:
                  case "end":
                    return e.stop();
                }
            }, e, a, [ [ 1, 12 ] ]);
        }))();
    }
};

exports.fly = fly, exports.req = req, exports.uploadFile = uploadFile, exports.formatImageUrl = formatImageUrl;