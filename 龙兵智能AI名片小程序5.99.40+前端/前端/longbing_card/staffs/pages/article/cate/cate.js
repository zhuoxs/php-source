var _xx_util = require("../../../../resource/js/xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util), _index = require("../../../../resource/apis/index.js");

function _interopRequireDefault(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}

function _asyncToGenerator(t) {
    return function() {
        var o = t.apply(this, arguments);
        return new Promise(function(a, u) {
            return function e(t, n) {
                try {
                    var r = o[t](n), i = r.value;
                } catch (t) {
                    return void u(t);
                }
                if (!r.done) return Promise.resolve(i).then(function(t) {
                    e("next", t);
                }, function(t) {
                    e("throw", t);
                });
                a(i);
            }("next");
        });
    };
}

var app = getApp(), regeneratorRuntime = _xx_util2.default.regeneratorRuntime;

Page({
    data: {},
    onLoad: function(t) {
        var e = t.uid, n = t.id, r = e || wx.getStorageSync("userid");
        this.setData({
            to_uid: r,
            id: n
        }), this.getList();
    },
    onPullDownRefresh: function() {
        var t = this;
        t.setData({
            nav: []
        }, function() {
            wx.showNavigationBarLoading(), t.getList();
        });
    },
    getList: function() {
        var r = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function t() {
            var e, n;
            return regeneratorRuntime.wrap(function(t) {
                for (;;) switch (t.prev = t.next) {
                  case 0:
                    return e = r, _xx_util2.default.showLoading(), t.next = 4, _index.pluginModel.getArticleCate();

                  case 4:
                    n = t.sent, _xx_util2.default.hideAll(), e.setData({
                        nav: n.data
                    });

                  case 7:
                  case "end":
                    return t.stop();
                }
            }, t, r);
        }))();
    },
    toCheck: function(t) {
        var e = _xx_util2.default.getData(t), n = e.id, r = e.title;
        _xx_util2.default.getPage(-1).setData({
            classify_id: n,
            classify_title: r
        }), wx.navigateBack();
    }
});