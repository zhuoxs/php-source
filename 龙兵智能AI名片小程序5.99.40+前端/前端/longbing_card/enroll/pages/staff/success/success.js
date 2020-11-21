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
    data: {},
    onLoad: function(a) {
        var u = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t, r, n, i;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    return t = a.id, e.next = 3, _index.pluginModel.getEnrollDetail({
                        activity_id: t
                    });

                  case 3:
                    r = e.sent, n = r.data, i = wx.getStorageSync("userid"), u.setData({
                        to_uid: i,
                        data: n
                    });

                  case 7:
                  case "end":
                    return e.stop();
                }
            }, e, u);
        }))();
    },
    onShareAppMessage: function(e) {
        var t = this.data, r = t.to_uid, n = t.data, i = n.id, a = n.title, u = n.cover, o = n.carousel, s = "/longbing_card/enroll/pages/detail/detail?id=" + i + "&uid=" + r + "&fid=" + r;
        return console.log(s, "tmp_path"), {
            title: a,
            path: s,
            imageUrl: u || o[0]
        };
    }
});