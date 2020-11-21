var _xx_util = require("../../../resource/js/xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util), _index = require("../../../resource/apis/index.js");

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

var regeneratorRuntime = _xx_util2.default.regeneratorRuntime;

Page({
    data: {
        openType: "getUserInfo",
        swiperIndexCur: 1,
        swiperStatus: {
            indicatorDots: !1,
            autoplay: !0
        }
    },
    onLoad: function(p) {
        var f = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t, r, n, a, o, i, u, s, c, d, l;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    return f, wx.showShareMenu({
                        withShareTicket: !0
                    }), t = p.scene ? _xx_util2.default.getSceneParam(decodeURIComponent(p.scene)) : p, 
                    r = t.id, n = t.uid, a = {
                        activity_id: r,
                        to_uid: n,
                        from_id: wx.getStorageSync("userid")
                    }, e.next = 6, f.setData({
                        optionsParam: a
                    });

                  case 6:
                    return e.next = 8, getApp().getConfigInfo();

                  case 8:
                    return o = getApp().globalData, i = o.isIphoneX, u = o.logoImg, s = o.productDefault, 
                    c = o.auth, d = c.authPhoneStatus, l = c.authStatus, f.setData({
                        isIphoneX: i,
                        logoImg: u,
                        productDefault: s,
                        authPhoneStatus: d,
                        authStatus: l
                    }), e.next = 13, f.onShow(a);

                  case 13:
                  case "end":
                    return e.stop();
                }
            }, e, f);
        }))();
    },
    onShow: function(e) {
        var t = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    return e.next = 2, t.getEnrollDetail();

                  case 2:
                  case "end":
                    return e.stop();
                }
            }, e, t);
        }))();
    },
    getAuthInfoSuc: function(e) {
        console.log(e, "getAuthInfoSuc");
        var t = this.data.openType, r = this.data.optionsParam.to_uid, n = getApp().getCurUserInfo(r, t);
        this.setData(n);
    },
    swiperChange: function(e) {
        var t = e.detail.current + 1;
        this.setData({
            swiperIndexCur: t
        });
    },
    onShareAppMessage: function(e) {
        var t = this.data.optionsParam, r = t.to_uid, n = t.from_id, a = this.data.data, o = a.id, i = a.title, u = a.cover, s = a.carousel, c = "/longbing_card/enroll/pages/detail/detail?id=" + o + "&uid=" + r + "&fid=" + n;
        return console.log(c, "tmp_path"), {
            title: i,
            path: c,
            imageUrl: u || s[0]
        };
    },
    getEnrollDetail: function() {
        var c = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t, r, n, a, o, i, u, s;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    return r = (t = c).data.optionsParam, n = r.activity_id, a = r.to_uid, o = r.from_id, 
                    e.next = 4, _index.pluginModel.getEnrollDetail({
                        activity_id: n,
                        to_uid: a
                    });

                  case 4:
                    if (i = e.sent, u = i.errno, s = i.message, -2 != u) {
                        e.next = 9;
                        break;
                    }
                    return wx.showModal({
                        title: "",
                        content: s,
                        showCancel: !1,
                        success: function(e) {
                            e.confirm && wx.redirectTo({
                                url: "/longbing_card/enroll/pages/index?uid=" + a + "&fid=" + o
                            });
                        }
                    }), e.abrupt("return", !1);

                  case 9:
                    t.setData({
                        data: i.data
                    });

                  case 10:
                  case "end":
                    return e.stop();
                }
            }, e, c);
        }))();
    },
    toSharePanel: function() {
        this.setData({
            sharePanel: !0
        });
    },
    previewImage: function(a) {
        var o = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t, r, n;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    t = _xx_util2.default.getData(a), r = t.src, n = o.data.data.detail_images, wx.previewImage({
                        current: r,
                        urls: n
                    });

                  case 3:
                  case "end":
                    return e.stop();
                }
            }, e, o);
        }))();
    },
    toMap: function(u) {
        var s = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var r, t, n, a, o, i;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    r = s, t = _xx_util2.default.getData(u), n = t.address, a = n.address, o = n.latitude, 
                    i = n.longitude, wx.authorize({
                        scope: "scope.userLocation",
                        success: function(e) {
                            wx.getLocation({
                                type: "gcj02",
                                success: function(e) {
                                    wx.openLocation({
                                        latitude: +o,
                                        longitude: +i,
                                        name: a,
                                        scale: 28
                                    });
                                }
                            });
                        },
                        fail: function(e) {
                            console.log(e, "**************fail  scope.userLocation");
                            var t = e.errMsg;
                            r.setData({
                                isSetting: t.includes("auth"),
                                settingText: [ "地理位置", "你的地理位置将用于地图导航" ]
                            });
                        }
                    });

                  case 4:
                  case "end":
                    return e.stop();
                }
            }, e, s);
        }))();
    }
});