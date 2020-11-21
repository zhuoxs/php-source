var _xx_util = require("../../../../resource/js/xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util), _index = require("../../../../resource/apis/index.js");

function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

function _asyncToGenerator(e) {
    return function() {
        var s = e.apply(this, arguments);
        return new Promise(function(o, i) {
            return function t(e, a) {
                try {
                    var r = s[e](a), n = r.value;
                } catch (e) {
                    return void i(e);
                }
                if (!r.done) return Promise.resolve(n).then(function(e) {
                    t("next", e);
                }, function(e) {
                    t("throw", e);
                });
                o(n);
            }("next");
        });
    };
}

var app = getApp(), regeneratorRuntime = _xx_util2.default.regeneratorRuntime;

Page({
    data: {
        refresh: !1
    },
    onLoad: function(_) {
        var x = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t, a, r, n, o, i, s, u, d, l, c, g, f, m, p;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    return console.log(_, "options"), t = x, a = _.id, r = _.type, n = _.name, o = _.status, 
                    i = _.fromshare, s = _.src, u = _.shareimg, d = _.table_name, l = _.to_uid, c = _.from_id, 
                    g = {
                        id: a,
                        type: r,
                        name: n,
                        status: o,
                        fromshare: i,
                        src: s,
                        shareimg: u,
                        table_name: d,
                        to_uid: l,
                        from_id: c
                    }, n && wx.setNavigationBarTitle({
                        title: n
                    }), u && (g.cover = decodeURIComponent(_.shareimg)), l && (getApp().globalData.to_uid = l), 
                    console.log(g, "paramData"), t.setData({
                        paramData: g
                    }), e.next = 11, x.firstLoad(1);

                  case 11:
                    f = getApp().globalData, m = f.isIphoneX, p = f.configInfo, t.setData({
                        isIphoneX: m,
                        copyright: p.config
                    });

                  case 13:
                  case "end":
                    return e.stop();
                }
            }, e, x);
        }))();
    },
    onPullDownRefresh: function() {
        var t = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    return t.setData({
                        refresh: !0
                    }), wx.showNavigationBarLoading(), e.next = 5, t.firstLoad();

                  case 5:
                  case "end":
                    return e.stop();
                }
            }, e, t);
        }))();
    },
    onShareAppMessage: function(e) {
        var t = this, a = t.data.paramData, r = a.status, n = a.to_uid, o = a.name, i = a.src, s = a.shareimg, u = a.id, d = a.type, l = a.table_name, c = o;
        t.data.detailData && (c = t.data.detailData.title), n || (n = getApp().globalData.to_uid);
        var g = wx.getStorageSync("userid");
        if ("toPlayVideo" == r) {
            var f = void 0;
            if (l) {
                var m = t.data.detailData, p = m.cover, _ = m.video;
                s = encodeURIComponent(p), i = encodeURIComponent(_), f = "/longbing_card/users/pages/company/detail/detail?to_uid=" + n + "&from_id=" + g + "&id=" + u + "&table_name=" + l + "&status=toPlayVideo&name=" + o + "&fromshare=true";
            } else f = "/longbing_card/users/pages/company/detail/detail?to_uid=" + n + "&from_id=" + g + "&status=toPlayVideo&name=" + o + "&fromshare=true&src=" + i + "&shareimg=" + s;
            return console.log(f, "tmp_path"), {
                title: c,
                path: f,
                imageUrl: decodeURIComponent(s)
            };
        }
        var x = "/longbing_card/users/pages/company/detail/detail?to_uid=" + n + "&from_id=" + g + "&id=" + u + "&table_name=" + l + "&type=" + d + "&name=" + o + "&fromshare=true";
        return console.log(x, "tmp_path"), {
            title: c,
            path: x,
            imageUrl: ""
        };
    },
    firstLoad: function(f) {
        var m = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t, a, r, n, o, i, s, u, d, l, c, g;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    if (a = (t = m).data.paramData, r = a.status, n = a.id, o = a.table_name, i = a.to_uid, 
                    s = a.from_id, u = a.fromshare, i || (i = getApp().globalData.to_uid), d = wx.getStorageSync("userid"), 
                    l = void 0, t.data.refresh || _xx_util2.default.showLoading(), "toPlayVideo" != r || o) {
                        e.next = 20;
                        break;
                    }
                    if (1 != f || i == d) {
                        e.next = 14;
                        break;
                    }
                    return e.next = 11, Promise.all([ getApp().getConfigInfo(!0), getApp().getCardAfter() ]);

                  case 11:
                    l = e.sent, e.next = 17;
                    break;

                  case 14:
                    return e.next = 16, Promise.all([ getApp().getConfigInfo(!0) ]);

                  case 16:
                    l = e.sent;

                  case 17:
                    _xx_util2.default.hideAll(), e.next = 34;
                    break;

                  case 20:
                    if (1 != f || i == d) {
                        e.next = 26;
                        break;
                    }
                    return e.next = 23, Promise.all([ getApp().getConfigInfo(!0), _index.userModel.getModularInfo({
                        id: n,
                        table_name: o,
                        to_uid: i
                    }), getApp().getCardAfter() ]);

                  case 23:
                    l = e.sent, e.next = 29;
                    break;

                  case 26:
                    return e.next = 28, Promise.all([ getApp().getConfigInfo(!0), _index.userModel.getModularInfo({
                        id: n,
                        table_name: o,
                        to_uid: i
                    }) ]);

                  case 28:
                    l = e.sent;

                  case 29:
                    _xx_util2.default.hideAll(), (c = l[1].data).create_time1 = _xx_util2.default.formatTime(1e3 * c.create_time, "M月D日"), 
                    t.setData({
                        detailData: c
                    }), -2 == l[1].errno && (s || (s = wx.getStorageSync("userid")), g = "确定", "true" == u && (g = "返回首页"), 
                    wx.showModal({
                        title: "提示",
                        content: l[1].message,
                        confirmText: g,
                        showCancel: !1,
                        success: function(e) {
                            e.confirm && "true" == u && wx.reLaunch({
                                url: "/longbing_card/pages/index/index?to_uid=" + i + "&from_id=" + s + "&currentTabBar=toCompany"
                            });
                        }
                    }));

                  case 34:
                    console.log(l);

                  case 35:
                  case "end":
                    return e.stop();
                }
            }, e, m);
        }))();
    },
    bindwaiting: function(e) {
        console.log(e, "bindwaiting");
    },
    binderror: function(e) {
        console.log(e, "binderror");
    },
    toJump: function(e) {
        var t = _xx_util2.default.getData(e), a = t.status, r = t.content;
        if ("toCopyright" == a && _xx_util2.default.goUrl(e), "toCall" == a) {
            if (console.log("联系HR"), !r) return !1;
            wx.makePhoneCall({
                phoneNumber: r
            });
        }
    },
    formSubmit: function(e) {
        var t = e.detail.formId, a = _xx_util2.default.getFormData(e), r = (a.index, a.status), n = getApp().globalData, o = n.to_uid, i = n.from_id;
        _index.baseModel.getFormId({
            formId: t
        }), "toHome" == r && wx.reLaunch({
            url: "/longbing_card/pages/index/index?to_uid=" + o + "&from_id=" + i + "&currentTabBar=toCard"
        });
    }
});