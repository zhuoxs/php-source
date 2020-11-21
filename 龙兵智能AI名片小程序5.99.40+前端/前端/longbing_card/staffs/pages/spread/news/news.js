var _slicedToArray = function(e, t) {
    if (Array.isArray(e)) return e;
    if (Symbol.iterator in Object(e)) return function(e, t) {
        var r = [], a = !0, n = !1, i = void 0;
        try {
            for (var o, s = e[Symbol.iterator](); !(a = (o = s.next()).done) && (r.push(o.value), 
            !t || r.length !== t); a = !0) ;
        } catch (e) {
            n = !0, i = e;
        } finally {
            try {
                !a && s.return && s.return();
            } finally {
                if (n) throw i;
            }
        }
        return r;
    }(e, t);
    throw new TypeError("Invalid attempt to destructure non-iterable instance");
}, _xx_util = require("../../../../resource/js/xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util), _index = require("../../../../resource/apis/index.js");

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
    onLoad: function(o) {
        var s = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t, r, a, n, i;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    return t = s, _xx_util2.default.showLoading(), console.log(o, "options"), r = o.status, 
                    e.next = 6, getApp().getConfigInfo();

                  case 6:
                    a = getApp().globalData.isIphoneX, wx.hideShareMenu(), wx.setNavigationBarTitle({
                        title: "news" == r ? "动态推广" : "自定义码推广"
                    }), "news" == r && wx.showShareMenu({
                        withShareTicket: !0
                    }), n = "news" == r ? "getDelTimeLine" : "getDelQr", i = "news" == r ? "getTimeLine" : "getReleaseQrList", 
                    t.setData({
                        status: r,
                        isIphoneX: a,
                        modelMethod_del: n,
                        modelMethod_list: i
                    }), _xx_util2.default.hideAll();

                  case 14:
                  case "end":
                    return e.stop();
                }
            }, e, s);
        }))();
    },
    onShow: function() {
        this.onPullDownRefresh();
    },
    onPullDownRefresh: function() {
        var r = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    (t = r).setData({
                        refresh: !0,
                        "param.page": 1
                    }, function() {
                        wx.showNavigationBarLoading(), t.getList();
                    });

                  case 2:
                  case "end":
                    return e.stop();
                }
            }, e, r);
        }))();
    },
    onReachBottom: function() {
        var e = this.data, t = e.loading, r = e.dataList, a = r.page;
        a == r.total_page || t || (this.setData({
            "param.page": a + 1,
            loading: !0
        }), this.getList());
    },
    onShareAppMessage: function(e) {
        if ("button" === e.from) {
            var t = e.target.dataset, r = t.index, a = t.id, n = t.type, i = this.data, o = i.to_uid, s = i.dataList.list[r], u = s.title, l = s.cover, d = s.article_id, c = "/longbing_card/users/pages/news/detail/detail?to_uid=" + o + "&from_id=" + o + "&id=" + a + "&type=3";
            return 3 == n && (c = "/longbing_card/staffs/pages/article/detail/detail?id=" + d + "&uid=" + o + "&fid=" + o), 
            console.log(c, "tmp_path"), {
                title: u,
                path: c,
                imageUrl: l[0]
            };
        }
    },
    getList: function() {
        var x = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t, r, a, n, i, o, s, u, l, d, c, f, g, _, p, h;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    return r = (t = x).data, a = r.refresh, n = r.param, i = r.dataList, o = r.modelMethod_list, 
                    s = r.status, u = wx.getStorageSync("userid"), e.next = 5, Promise.all([ _index.staffModel[o](n), _index.userModel.getCardShow({
                        to_uid: u
                    }) ]);

                  case 5:
                    for (p in l = e.sent, d = _slicedToArray(l, 2), c = d[0], f = d[1], g = c.data, 
                    _xx_util2.default.hideAll(), _ = i, a || (g.list = [].concat(_toConsumableArray(_.list), _toConsumableArray(g.list))), 
                    g.list) if (g.list[p].create_time1 = _xx_util2.default.formatTime(1e3 * g.list[p].create_time, "YY/M/D"), 
                    "news" == s) for (h in g.list[p].cover) g.list[p].cover[h] || g.list[p].cover.splice(h, 1);
                    g.page = 1 * g.page, t.setData({
                        dataList: g,
                        loading: !1,
                        refresh: !1,
                        cardIndexData: f.data,
                        to_uid: u
                    });

                  case 16:
                  case "end":
                    return e.stop();
                }
            }, e, x);
        }))();
    },
    toDelete: function(e) {
        var t = this, r = _xx_util2.default.getData(e).index;
        wx.showModal({
            title: "",
            content: "是否确认删除此数据？",
            success: function(e) {
                e.confirm && t.toDel(r);
            }
        });
    },
    toDel: function(s) {
        var u = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t, r, a, n, i, o;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    return t = u.data, r = t.modelMethod_del, a = t.dataList, n = a.list, i = n[s].id, 
                    e.next = 5, _index.staffModel[r]({
                        id: i
                    });

                  case 5:
                    if (o = e.sent, 0 == o.errno) {
                        e.next = 9;
                        break;
                    }
                    return e.abrupt("return", !1);

                  case 9:
                    _xx_util2.default.showSuccess("删除成功"), n.splice(s, 1), _xx_util2.default.hideAll(), 
                    u.setData({
                        "dataList.list": n
                    });

                  case 13:
                  case "end":
                    return e.stop();
                }
            }, e, u);
        }))();
    },
    toJump: function(e) {
        var t = _xx_util2.default.getData(e), r = t.id, a = t.index, n = t.type, i = this.data, o = i.status, s = i.to_uid, u = "/longbing_card/staffs/pages/spread/code/code?id=" + r, l = i.dataList.list;
        "news" == o && (u = "/longbing_card/users/pages/news/detail/detail?id=" + r + "&to_uid=" + s + "&from_id=" + s, 
        3 == n && (u = "/longbing_card/staffs/pages/article/detail/detail?id=" + l[a].article_id + "&uid=" + s));
        console.log(u, "tmp_url"), wx.navigateTo({
            url: u
        });
    }
});