var _xx_util = require("../../resource/js/xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util), _index = require("../../resource/apis/index.js");

function _interopRequireDefault(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}

function _defineProperty(t, e, a) {
    return e in t ? Object.defineProperty(t, e, {
        value: a,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[e] = a, t;
}

function _toConsumableArray(t) {
    if (Array.isArray(t)) {
        for (var e = 0, a = Array(t.length); e < t.length; e++) a[e] = t[e];
        return a;
    }
    return Array.from(t);
}

function _asyncToGenerator(t) {
    return function() {
        var u = t.apply(this, arguments);
        return new Promise(function(o, i) {
            return function e(t, a) {
                try {
                    var n = u[t](a), r = n.value;
                } catch (t) {
                    return void i(t);
                }
                if (!n.done) return Promise.resolve(r).then(function(t) {
                    e("next", t);
                }, function(t) {
                    e("throw", t);
                });
                o(r);
            }("next");
        });
    };
}

var regeneratorRuntime = _xx_util2.default.regeneratorRuntime, app = getApp();

Page({
    data: {
        openType: "getUserInfo",
        classify_list: [],
        tabActiveIndex: 0,
        scrollNav: "scrollNav0",
        showMoreStatus: "",
        ranks: [ "最新", "附近" ],
        rankInd: 0,
        dataList: {
            list: [],
            page: 1,
            total_page: 20
        },
        param: {
            page: 1
        },
        refresh: !1,
        loading: !0
    },
    onLoad: function(D) {
        var P = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function t() {
            var e, a, n, r, o, i, u, s, c, l, d, g, f, p, h, _, x, m, v, b, w, y, A, S;
            return regeneratorRuntime.wrap(function(t) {
                for (;;) switch (t.prev = t.next) {
                  case 0:
                    return e = P, wx.showShareMenu({
                        withShareTicket: !0
                    }), a = D.uid, n = D.fid, r = {
                        to_uid: a,
                        from_id: n
                    }, o = {
                        page: 1,
                        to_uid: a
                    }, t.next = 7, getApp().getConfigInfo();

                  case 7:
                    getApp().globalData.to_uid = a, i = _xx_util2.default.getTabTextInd(getApp().globalData.tabBar, "toEnroll"), 
                    wx.setNavigationBarTitle({
                        title: i[0]
                    }), u = getApp().globalData.configInfo.config, s = u.appoint_name, c = u.appoint_pic, 
                    s || (s = i[0] || "活动"), l = getApp().globalData, d = l.auth, g = l.tabBar, f = l.logoImg, 
                    p = l.userDefault, h = l.productDefault, l.isStaff, x = l.configInfo, l.hasClientPhone, 
                    v = wx.getStorageSync("user"), b = v.id, w = v.phone, _ = a == b, m = !!w, y = d.authStatus, 
                    A = d.authPhoneStatus, S = x.config.btn_consult, e.setData({
                        optionsParam: r,
                        param: o,
                        title_text: i,
                        nowPageIndex: i[1],
                        tabBar: g,
                        appoint_name: s,
                        appoint_pic: c,
                        logoImg: f,
                        productDefault: h,
                        isStaff: _,
                        hasClientPhone: m,
                        btn_consult: S,
                        userDefault: p,
                        authPhoneStatus: A,
                        authStatus: y,
                        copyright: x.config
                    }, function() {
                        e.getAuthInfoSuc(), e.getCate(), _xx_util2.default.hideAll();
                    }), e.subscribe();

                  case 20:
                  case "end":
                    return t.stop();
                }
            }, t, P);
        }))();
    },
    subscribe: function() {
        var n = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function t() {
            var e, a;
            return regeneratorRuntime.wrap(function(t) {
                for (;;) switch (t.prev = t.next) {
                  case 0:
                    e = wx.getStorageSync("userid"), a = getApp().globalData.to_uid, getApp().websocket.sendMessage({
                        unread: !0,
                        user_id: e,
                        to_uid: a
                    }), getApp().websocket.subscribe("unread", n.getUserUnreadNum), getApp().websocket.subscribe("getMsg", n.getMsgUnreadNum);

                  case 5:
                  case "end":
                    return t.stop();
                }
            }, t, n);
        }))();
    },
    getUserUnreadNum: function(t) {
        var e = t.data, a = e.user_count, n = {
            user_count: a,
            staff_count: e.staff_count
        };
        getApp().getUnReadNum(n), this.toMsgAnimatoins(a);
    },
    getMsgUnreadNum: function(t) {
        var e = t.user_count, a = t.staff_count;
        if (t.data2.user_id == getApp().globalData.to_uid) {
            var n = {
                user_count: e,
                staff_count: a
            };
            getApp().getUnReadNum(n), this.toMsgAnimatoins(e);
        }
    },
    toMsgAnimatoins: function(t) {
        var e = this;
        e.setData({
            clientUnread: t
        }), t <= 0 || (e.setData({
            clientUnreadImg: !0
        }), setTimeout(function() {
            e.setData({
                clientUnreadImg: !1
            });
        }, 5e3));
    },
    onPageScroll: function(t) {
        this.setData({
            scrollTop: t.scrollTop
        });
    },
    onHide: function() {
        getApp().websocket.unSubscribe("unread"), getApp().websocket.unSubscribe("getMsg");
    },
    onUnload: function() {
        getApp().websocket.unSubscribe("unread"), getApp().websocket.unSubscribe("getMsg");
    },
    onShareAppMessage: function(t) {
        var e = this.data.optionsParam.to_uid, a = wx.getStorageSync("userid"), n = this.data.appoint_name;
        return console.log("/longbing_card/reserve/pages/index/index?uid=" + e + "&fid=" + a), 
        {
            title: n,
            path: "/longbing_card/reserve/pages/index/index?uid=" + e + "&fid=" + a,
            imageUrl: ""
        };
    },
    onPullDownRefresh: function() {
        var e = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function t() {
            var n;
            return regeneratorRuntime.wrap(function(t) {
                for (;;) switch (t.prev = t.next) {
                  case 0:
                    (n = e).setData({
                        refresh: !0,
                        "param.page": 1
                    }, function() {
                        wx.showNavigationBarLoading();
                        var t = n.data, e = t.tabActiveIndex, a = t.rankInd;
                        1 == a || 0 == a && 0 < 1 * e ? n.getList() : n.getCate();
                    });

                  case 2:
                  case "end":
                    return t.stop();
                }
            }, t, e);
        }))();
    },
    onReachBottom: function() {
        var t = this.data, e = t.loading, a = t.dataList, n = a.page;
        n == a.total_page || e || (this.setData({
            "param.page": n + 1,
            loading: !0
        }), this.getList());
    },
    getAuthInfoSuc: function(t) {
        console.log(t, "getAuthInfoSuc");
        var e = this.data.openType, a = this.data.optionsParam.to_uid, n = getApp().getCurUserInfo(a, e);
        this.setData(n);
    },
    getCate: function() {
        var g = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function t() {
            var e, a, n, r, o, i, u, s, c, l, d;
            return regeneratorRuntime.wrap(function(t) {
                for (;;) switch (t.prev = t.next) {
                  case 0:
                    return a = (e = g).data, n = a.tabActiveIndex, r = a.optionsParam, o = a.dataList, 
                    i = r.to_uid, t.next = 5, _index.pluginModel.getEnrollCate({
                        to_uid: i
                    });

                  case 5:
                    u = t.sent, s = u.data, c = s.classify_list, l = s.activity_list, d = s.total_page, 
                    _xx_util2.default.hideAll(), 0 == n && (o.list = l, o.total_page = d), e.setData({
                        classify_list: c,
                        dataList: o,
                        refresh: !1,
                        loading: !1
                    });

                  case 10:
                  case "end":
                    return t.stop();
                }
            }, t, g);
        }))();
    },
    getList: function() {
        var d = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function t() {
            var e, a, n, r, o, i, u, s, c, l;
            return regeneratorRuntime.wrap(function(t) {
                for (;;) switch (t.prev = t.next) {
                  case 0:
                    return a = (e = d).data, n = a.refresh, r = a.param, o = a.dataList, i = a.tabActiveIndex, 
                    u = a.classify_list, r.classify_id = 0 < i ? u[1 * i - 1].id : 0, t.next = 5, _index.pluginModel.getEnrollList(r);

                  case 5:
                    s = t.sent, c = s.data, _xx_util2.default.hideAll(), l = o, n || (c.list = [].concat(_toConsumableArray(l.list), _toConsumableArray(c.list))), 
                    c.page = 1 * c.page, e.setData({
                        dataList: c,
                        loading: !1,
                        refresh: !1
                    });

                  case 12:
                  case "end":
                    return t.stop();
                }
            }, t, d);
        }))();
    },
    toSetVal: function(u) {
        var s = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function t() {
            var e, a, n, r, o, i;
            return regeneratorRuntime.wrap(function(t) {
                for (;;) switch (t.prev = t.next) {
                  case 0:
                    if (e = s, a = _xx_util2.default.getData(u), n = a.index, r = a.type, o = "" + r, 
                    i = {
                        longitude: 0,
                        latitude: 0
                    }, 1 != n) {
                        t.next = 15;
                        break;
                    }
                    return t.prev = 5, t.next = 8, _xx_util2.default.getLocation();

                  case 8:
                    i = t.sent, t.next = 15;
                    break;

                  case 11:
                    t.prev = 11, t.t0 = t.catch(5), n = 0, e.setData({
                        isSetting: t.t0.errMsg.includes("auth"),
                        settingText: [ "地理位置", "你的地理位置将用于查询附近的活动" ]
                    });

                  case 15:
                    return e.setData(_defineProperty({
                        "param.latitude": i.latitude,
                        "param.longitude": i.longitude
                    }, o, n)), t.next = 18, s.onPullDownRefresh();

                  case 18:
                  case "end":
                    return t.stop();
                }
            }, t, s, [ [ 5, 11 ] ]);
        }))();
    },
    toShowMore: function(t) {
        var e = _xx_util2.default.getData(t).type;
        this.setData({
            showMoreStatus: 0 == e ? 1 : 0
        });
    },
    toTabClick: function(r) {
        var o = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function t() {
            var e, a, n;
            return regeneratorRuntime.wrap(function(t) {
                for (;;) switch (t.prev = t.next) {
                  case 0:
                    return e = o, a = _xx_util2.default.getData(r), n = a.index, e.setData({
                        tabActiveIndex: n,
                        showMoreStatus: 0,
                        scrollNav: "scrollNav" + n
                    }), t.next = 5, o.onPullDownRefresh();

                  case 5:
                  case "end":
                    return t.stop();
                }
            }, t, o);
        }))();
    },
    tabJump: function(t) {
        var e = t.detail, a = e.url, n = e.method, r = e.type, o = e.curr, i = e.index, u = e.text, s = e.formId;
        _index.baseModel.getFormId({
            formId: s
        });
        var c = this.data.optionsParam.to_uid, l = wx.getStorageSync("userid");
        if (a && (0 == a.indexOf("wx") || -1 < a.indexOf("http") || (a = a + "?uid=" + c + "&fid=" + l)), 
        !a) {
            var d = this.data.tabBar.list;
            d[i].pagePath2 ? (a = d[i].pagePath2 + "?uid=" + c + "&fid=" + l, wx[n]({
                url: a,
                fail: function(t) {
                    a = "/longbing_card/pages/index/index?currentTabBar=" + o + "&to_uid=" + c + "&from_id=" + l, 
                    console.log(t, a);
                }
            })) : a = "/longbing_card/pages/index/index?currentTabBar=" + o + "&to_uid=" + c + "&from_id=" + l;
        }
        t.currentTarget.dataset = {
            url: a,
            method: n,
            type: r,
            curr: o,
            index: i,
            text: u,
            formId: s
        }, _xx_util2.default.goUrl(t);
    },
    toConsult: function() {
        var n = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function t() {
            var e, a;
            return regeneratorRuntime.wrap(function(t) {
                for (;;) switch (t.prev = t.next) {
                  case 0:
                    e = n.data.optionsParam.to_uid, a = "/longbing_card/chat/userChat/userChat?chat_to_uid=" + e, 
                    console.log(a, "toConsult"), wx.navigateTo({
                        url: a
                    });

                  case 4:
                  case "end":
                    return t.stop();
                }
            }, t, n);
        }))();
    },
    getPhoneNumber: function(t) {
        var e = t.detail, a = e.encryptedData, n = e.iv;
        a && n && this.setPhoneInfo(a, n), this.toConsult();
    },
    setPhoneInfo: function(t, e) {
        var n = this, a = n.data.optionsParam.to_uid;
        _index.baseModel.getPhone({
            encryptedData: t,
            iv: e,
            to_uid: a
        }).then(function(a) {
            _xx_util2.default.hideAll(), getApp().globalData.hasClientPhone = !0, getApp().globalData.auth.authPhoneStatus = !0, 
            n.setData({
                hasClientPhone: !0,
                authPhoneStatus: !0
            }, function() {
                if (a.data.phone) {
                    var t = wx.getStorageSync("userid"), e = wx.getStorageSync("user");
                    e.phone = a.data.phone, wx.setStorageSync("userid", t), wx.setStorageSync("user", e);
                }
                n.getAuthInfoSuc();
            });
        });
    }
});