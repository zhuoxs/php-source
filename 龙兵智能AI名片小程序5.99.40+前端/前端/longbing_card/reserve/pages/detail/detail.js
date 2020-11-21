var _xx_util = require("../../../resource/js/xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util), _index = require("../../../resource/apis/index.js");

function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
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
        openType: "getUserInfo",
        swiperIndexCur: 1,
        swiperStatus: {
            indicatorDots: !1,
            autoplay: !0
        }
    },
    onLoad: function(h) {
        var x = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t, r, a, n, i, o, u, s, d, c, l, g, p, f;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    return t = x, wx.showShareMenu({
                        withShareTicket: !0
                    }), r = h.scene ? _xx_util2.default.getSceneParam(decodeURIComponent(h.scene)) : h, 
                    a = r.id, n = r.to_uid, i = r.uid, o = {
                        id: a,
                        to_uid: i || n,
                        from_id: wx.getStorageSync("userid")
                    }, e.next = 6, getApp().getConfigInfo();

                  case 6:
                    u = getApp().globalData, s = u.isIphoneX, d = u.logoImg, c = u.productDefault, l = u.auth, 
                    g = l.authPhoneStatus, p = l.authStatus, f = _xx_util2.default.getTabTextInd(getApp().globalData.tabBar, "toReserve"), 
                    wx.setNavigationBarTitle({
                        title: f[0]
                    }), t.setData({
                        optionsParam: o,
                        isIphoneX: s,
                        logoImg: d,
                        productDefault: c,
                        authPhoneStatus: g,
                        authStatus: p
                    }), t.getAuthInfoSuc(), t.getReserveDetail();

                  case 13:
                  case "end":
                    return e.stop();
                }
            }, e, x);
        }))();
    },
    getAuthInfoSuc: function(e) {
        console.log(e, "getAuthInfoSuc");
        var t = this.data.openType, r = this.data.optionsParam.to_uid, a = getApp().getCurUserInfo(r, t);
        this.setData(a);
    },
    swiperChange: function(e) {
        var t = e.detail.current + 1;
        this.setData({
            swiperIndexCur: t
        });
    },
    onShareAppMessage: function(e) {
        var t = this.data.optionsParam.to_uid, r = wx.getStorageSync("userid"), a = this.data.data, n = a.id, i = a.title, o = a.cover, u = a.carousel;
        return console.log("/longbing_card/reserve/pages/detail/detail?id=" + n + "&uid=" + t + "&fid=" + r), 
        {
            title: i,
            path: "/longbing_card/reserve/pages/detail/detail?id=" + n + "&uid=" + t + "&fid=" + r,
            imageUrl: o || u[0]
        };
    },
    toSharePanel: function() {
        this.setData({
            sharePanel: !0
        });
    },
    getReserveDetail: function() {
        var s = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var n, t, r, a, i, o, u;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    return t = (n = s).data.optionsParam, r = t.id, a = t.to_uid, e.next = 4, _index.pluginModel.getReserveDetail({
                        id: r,
                        to_uid: a
                    });

                  case 4:
                    if (i = e.sent, o = i.errno, u = i.message, -2 != o) {
                        e.next = 9;
                        break;
                    }
                    return wx.showModal({
                        title: "",
                        content: u,
                        showCancel: !1,
                        success: function(e) {
                            if (e.confirm) {
                                var t = n.data.optionsParam, r = t.to_uid, a = t.from_id;
                                wx.redirectTo({
                                    url: "/longbing_card/reserve/pages/index/index?uid=" + r + "&fid=" + a
                                });
                            }
                        }
                    }), e.abrupt("return", !1);

                  case 9:
                    n.setData({
                        data: i.data
                    });

                  case 10:
                  case "end":
                    return e.stop();
                }
            }, e, s);
        }))();
    }
});