var _xx_util = require("../../../../resource/js/xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util), _index = require("../../../../resource/apis/index.js");

function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

function _asyncToGenerator(e) {
    return function() {
        var o = e.apply(this, arguments);
        return new Promise(function(i, u) {
            return function t(e, r) {
                try {
                    var a = o[e](r), n = a.value;
                } catch (e) {
                    return void u(e);
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
        currInd: !1,
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
    onLoad: function(u) {
        var o = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t, r, a, n, i;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    return t = u.id, r = wx.getStorageSync("userid"), e.next = 4, _index.pluginModel.getEnrollCate({
                        to_uid: r
                    });

                  case 4:
                    a = e.sent, n = a.data, (i = o.data.dataList).list = n.classify_list, o.setData({
                        currInd: t || 0,
                        dataList: i
                    });

                  case 9:
                  case "end":
                    return e.stop();
                }
            }, e, o);
        }))();
    },
    toCheck: function(u) {
        var o = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t, r, a, n, i;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    return t = _xx_util2.default.getData(u), r = t.index, e.next = 3, o.setData({
                        currInd: r
                    });

                  case 3:
                    a = o.data.dataList.list[r], n = a.id, i = a.title, _xx_util2.default.getPage(-1).setData({
                        "form.classify_id": n,
                        classify_title: i
                    }), wx.navigateBack({
                        delta: 1
                    });

                  case 6:
                  case "end":
                    return e.stop();
                }
            }, e, o);
        }))();
    }
});