var _xx_util = require("../../../../resource/js/xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util), _index = require("../../../../resource/apis/index.js");

function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
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

var regeneratorRuntime = _xx_util2.default.regeneratorRuntime;

Page({
    data: {
        dataList: {
            list: [],
            page: 1,
            total_page: 1
        },
        param: {
            page: 1
        },
        refresh: !1,
        loading: !1
    },
    onLoad: function(c) {
        var d = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t, r, n, i, a, u, o, s;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    return t = c.id, r = c.uid, n = c.name, wx.setNavigationBarTitle({
                        title: n || "客户"
                    }), i = getApp().globalData.isIphoneX, a = {
                        isIphoneX: i
                    }, e.next = 6, _index.pluginModel.getUserEnrForm({
                        activity_id: t,
                        client_id: r
                    });

                  case 6:
                    u = e.sent, o = u.data, (s = d.data.dataList).list = o, d.setData({
                        activity_id: t,
                        client_id: r,
                        $gd: a,
                        dataList: s
                    });

                  case 11:
                  case "end":
                    return e.stop();
                }
            }, e, d);
        }))();
    }
});