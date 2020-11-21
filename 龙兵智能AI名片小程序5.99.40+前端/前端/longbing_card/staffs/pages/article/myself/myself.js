var _xx_util = require("../../../../resource/js/xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util), _index = require("../../../../resource/apis/index.js");

function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

function _toConsumableArray(e) {
    if (Array.isArray(e)) {
        for (var t = 0, r = Array(e.length); t < e.length; t++) r[t] = e[t];
        return r;
    }
    return Array.from(e);
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

var app = getApp(), regeneratorRuntime = _xx_util2.default.regeneratorRuntime;

Page({
    data: {
        nowPageIndex: 2,
        tabbar: {
            color: "#838591",
            selectedColor: "#11c95e",
            backgroundColor: "#fff",
            borderStyle: "white",
            list: [ {
                pagePath: "/longbing_card/staffs/pages/article/index/index",
                text: "获客文章",
                iconPath: "icon-shejiwenzhang201",
                method: "redirectTo"
            }, {
                pagePath: "/longbing_card/staffs/pages/article/import/import",
                text: "发文章",
                iconPath: "/longbing_card/resource/images/article/icon-fabu.png",
                method: "redirectTo"
            }, {
                pagePath: "/longbing_card/staffs/pages/article/myself/myself",
                text: "我的文章",
                iconPath: "icon-wode",
                method: "redirectTo"
            } ]
        },
        param: {
            page: 1
        },
        list: {
            data: [],
            total: 0,
            per_page: 20,
            current_page: 0,
            last_page: 0
        },
        refresh: !1,
        loading: !0
    },
    onLoad: function(e) {
        var t = e.uid, r = getApp().globalData, a = {
            logoImg: r.logoImg,
            productDefault: r.productDefault,
            isIphoneX: r.isIphoneX
        }, n = t || wx.getStorageSync("userid");
        this.setData({
            $gd: a,
            to_uid: n
        }), this.getList();
    },
    onShow: function() {},
    onPullDownRefresh: function() {
        var e = this;
        e.setData({
            refresh: !0,
            "param.page": 1
        }, function() {
            wx.showNavigationBarLoading(), e.getList();
        });
    },
    onReachBottom: function() {
        var e = this.data, t = e.loading, r = e.list, a = r.current_page;
        a == r.last_page || t || (this.setData({
            "param.page": a + 1,
            loading: !0
        }), this.getList());
    },
    getList: function() {
        var c = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t, r, a, n, i, o, s, u;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    return r = (t = c).data, a = r.refresh, n = r.param, i = r.list, e.next = 4, _index.pluginModel.getMyArticle(n);

                  case 4:
                    o = e.sent, s = o.data, _xx_util2.default.hideAll(), u = i, a || (s.data = [].concat(_toConsumableArray(u.data), _toConsumableArray(s.data))), 
                    t.setData({
                        list: s,
                        loading: !1,
                        refresh: !1
                    });

                  case 10:
                  case "end":
                    return e.stop();
                }
            }, e, c);
        }))();
    },
    toDel: function(e) {
        var t = this, r = _xx_util2.default.getData(e).index;
        wx.showModal({
            title: "",
            content: "是否确认删除此数据？",
            success: function(e) {
                e.confirm && t.toDelMyArticle(r);
            }
        });
    },
    toDelMyArticle: function(i) {
        var o = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t, r, a, n;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    return r = (t = o).data.list, a = r.data[i].id, e.next = 5, _index.pluginModel.toDelMyArticle({
                        id: a
                    });

                  case 5:
                    if (n = e.sent, 0 == n.errno) {
                        e.next = 9;
                        break;
                    }
                    return e.abrupt("return");

                  case 9:
                    r.data.splice(i, 1), t.setData({
                        list: r
                    });

                  case 11:
                  case "end":
                    return e.stop();
                }
            }, e, o);
        }))();
    }
});