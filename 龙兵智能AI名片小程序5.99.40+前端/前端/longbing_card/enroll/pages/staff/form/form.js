var _xx_util = require("../../../../resource/js/xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util), _index = require("../../../../resource/apis/index.js");

function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

function _asyncToGenerator(e) {
    return function() {
        var u = e.apply(this, arguments);
        return new Promise(function(a, s) {
            return function t(e, r) {
                try {
                    var n = u[e](r), i = n.value;
                } catch (e) {
                    return void s(e);
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
        selectList: [],
        selectObj: {}
    },
    onLoad: function(e) {
        var a = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t, r, n, i;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    t = _xx_util2.default.getPage(-1).data, r = t.selectList, n = t.selectObj, i = t.items, 
                    a.setData({
                        selectObj: n,
                        selectList: r,
                        items: i
                    });

                  case 2:
                  case "end":
                    return e.stop();
                }
            }, e, a);
        }))();
    },
    handerRadioChange: function(e) {
        var t = _xx_util2.default.getData(e), r = t.id, n = t.index, i = this.data, a = i.selectList, s = i.selectObj, u = i.items;
        s[r] ? (delete s[r], a = a.filter(function(e) {
            return e.id != r;
        })) : (s[r] = !0, a.push(u[n])), this.setData({
            selectObj: s,
            selectList: a
        });
    },
    toOrderBtn: function() {
        var o = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t, r, n, i, a, s, u;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    for (s in t = o.data, r = t.selectObj, n = t.selectList, i = [], a = [], n) i.push(n[s].id), 
                    a.push(n[s].title);
                    return e.next = 6, _xx_util2.default.getItems(n, "title");

                  case 6:
                    u = e.sent, _xx_util2.default.getPage(-1).setData({
                        "form.ids": i,
                        "form.titles": a,
                        selectObj: r,
                        selectList: n,
                        form_titles: u
                    }), setTimeout(function() {
                        wx.navigateBack({
                            delta: 1
                        });
                    }, 200);

                  case 9:
                  case "end":
                    return e.stop();
                }
            }, e, o);
        }))();
    }
});