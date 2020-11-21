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

var regeneratorRuntime = _xx_util2.default.regeneratorRuntime, app = getApp();

Page({
    data: {
        isIphoneX: getApp().globalData.isIphoneX,
        fixBtn: {
            color: "#fc3c3b",
            text: "返回首页",
            url: "",
            method: "reLaunch"
        },
        swiperStatus: {
            indicatorDots: !1,
            autoplay: !0
        },
        swiperIndexCur: 0
    },
    onLoad: function(c) {
        var p = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t, r, n, a, o, i, u, s;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    return t = c.uid, r = {
                        to_uid: t
                    }, e.next = 4, getApp().getConfigInfo();

                  case 4:
                    n = getApp().globalData, a = n.isIphoneX, o = n.productDefault, i = n.price_switch, 
                    u = n.configInfo, s = u.config.btn_talk, p.setData({
                        optionsParam: r,
                        isIphoneX: a,
                        productDefault: o,
                        price_switch: i,
                        btn_talk: s,
                        "fixBtn.url": "/longbing_card/pages/index/index?to_uid=" + t + "&currentTabBar=toCard"
                    }), p.getList();

                  case 8:
                  case "end":
                    return e.stop();
                }
            }, e, p);
        }))();
    },
    onPullDownRefresh: function() {
        var n = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t, r;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    return t = n, e.next = 3, getApp().getConfigInfo(!0);

                  case 3:
                    r = getApp().globalData.price_switch, t.setData({
                        price_switch: r
                    }), t.getList();

                  case 6:
                  case "end":
                    return e.stop();
                }
            }, e, n);
        }))();
    },
    swiperChange: function(e) {
        var t = e.detail.current;
        this.setData({
            swiperIndexCur: t
        });
    },
    getList: function() {
        var s = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t, r, n, a, o, i, u;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    return t = s.data.optionsParam.to_uid, e.next = 3, _index.pluginModel.getPayGoods({
                        to_uid: t
                    });

                  case 3:
                    if (r = e.sent, n = r.data, 0 == r.errno) {
                        for (u in a = n.goods, o = n.carousel, i = n.record, a) a[u].shop_price = _xx_util2.default.getNormalPrice((a[u].price / 1e4).toFixed(4));
                        s.setData({
                            goods: a,
                            carousel: o,
                            record: i
                        });
                    }

                  case 7:
                  case "end":
                    return e.stop();
                }
            }, e, s);
        }))();
    }
});