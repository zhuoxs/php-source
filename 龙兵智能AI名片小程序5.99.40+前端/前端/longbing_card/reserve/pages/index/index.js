var _xx_util = require("../../../resource/js/xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util), _index = require("../../../resource/apis/index.js");

function _interopRequireDefault(t) {
    return t && t.__esModule ? t : {
        default: t
    };
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
        var s = t.apply(this, arguments);
        return new Promise(function(o, i) {
            return function e(t, a) {
                try {
                    var n = s[t](a), r = n.value;
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
    onLoad: function(S) {
        var I = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function t() {
            var e, a, n, r, o, i, s, u, c, g, d, l, f, p, h, _, m, x, b, v, A, w, y, D;
            return regeneratorRuntime.wrap(function(t) {
                for (;;) switch (t.prev = t.next) {
                  case 0:
                    return e = I, wx.showShareMenu({
                        withShareTicket: !0
                    }), a = S.uid, n = S.fid, r = {
                        to_uid: a,
                        from_id: n
                    }, o = {
                        page: 1,
                        to_uid: a
                    }, t.next = 7, getApp().getConfigInfo();

                  case 7:
                    getApp().globalData.to_uid = a, i = _xx_util2.default.getTabTextInd(getApp().globalData.tabBar, "toReserve"), 
                    wx.setNavigationBarTitle({
                        title: i[0]
                    }), s = getApp().globalData.configInfo.config, u = s.appoint_name, c = s.appoint_pic, 
                    u || (u = i[0] || "预约"), g = getApp().globalData, d = g.auth, l = g.tabBar, f = g.logoImg, 
                    p = g.userDefault, h = g.productDefault, g.isStaff, m = g.configInfo, g.hasClientPhone, 
                    b = wx.getStorageSync("user"), v = b.id, A = b.phone, _ = a == v, x = !!A, w = d.authStatus, 
                    y = d.authPhoneStatus, D = m.config.btn_consult, e.setData({
                        optionsParam: r,
                        param: o,
                        title_text: i,
                        nowPageIndex: i[1],
                        tabBar: l,
                        appoint_name: u,
                        appoint_pic: c,
                        logoImg: f,
                        productDefault: h,
                        isStaff: _,
                        hasClientPhone: x,
                        btn_consult: D,
                        userDefault: p,
                        authPhoneStatus: y,
                        authStatus: w,
                        copyright: m.config
                    }, function() {
                        e.getAuthInfoSuc(), e.getCate(), _xx_util2.default.hideAll();
                    }), e.subscribe();

                  case 20:
                  case "end":
                    return t.stop();
                }
            }, t, I);
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
        var e = this.data.optionsParam.to_uid, a = wx.getStorageSync("userid"), n = this.data.appoint_name, r = "/longbing_card/reserve/pages/index/index?uid=" + e + "&fid=" + a;
        return console.log(r, "tmp_path"), {
            title: n,
            path: r,
            imageUrl: ""
        };
    },
    onPullDownRefresh: function() {
        var a = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function t() {
            var e;
            return regeneratorRuntime.wrap(function(t) {
                for (;;) switch (t.prev = t.next) {
                  case 0:
                    (e = a).setData({
                        refresh: !0,
                        "param.page": 1
                    }, function() {
                        wx.showNavigationBarLoading(), 0 < 1 * e.data.tabActiveIndex ? e.getList() : e.getCate();
                    });

                  case 2:
                  case "end":
                    return t.stop();
                }
            }, t, a);
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
        var p = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function t() {
            var e, a, n, r, o, i, s, u, c, g, d, l, f;
            return regeneratorRuntime.wrap(function(t) {
                for (;;) switch (t.prev = t.next) {
                  case 0:
                    return a = (e = p).data, n = a.tabActiveIndex, r = a.optionsParam, o = a.dataList, 
                    i = r.to_uid, t.next = 5, _index.pluginModel.getReserveCate({
                        to_uid: i
                    });

                  case 5:
                    s = t.sent, u = s.data, c = u.classify_list, g = u.list, d = u.staff_company_info, 
                    l = u.staff_info, f = u.total_page, _xx_util2.default.hideAll(), 0 == n && (o.list = g, 
                    o.total_page = f), e.setData({
                        classify_list: c,
                        staff_company_info: d,
                        staff_info: l,
                        dataList: o,
                        refresh: !1,
                        loading: !1
                    });

                  case 10:
                  case "end":
                    return t.stop();
                }
            }, t, p);
        }))();
    },
    getList: function() {
        var d = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function t() {
            var e, a, n, r, o, i, s, u, c, g;
            return regeneratorRuntime.wrap(function(t) {
                for (;;) switch (t.prev = t.next) {
                  case 0:
                    return a = (e = d).data, n = a.refresh, r = a.param, o = a.dataList, i = a.tabActiveIndex, 
                    s = a.classify_list, r.classify_id = 0 < i ? s[1 * i - 1].id : 0, t.next = 5, _index.pluginModel.getReserveList(r);

                  case 5:
                    u = t.sent, c = u.data, _xx_util2.default.hideAll(), g = o, n || (c.list = [].concat(_toConsumableArray(g.list), _toConsumableArray(c.list))), 
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
    tabChange: function(e) {
        var a = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function t() {
            return regeneratorRuntime.wrap(function(t) {
                for (;;) switch (t.prev = t.next) {
                  case 0:
                    return a.setData({
                        tabActiveIndex: e.detail.index
                    }), t.next = 4, a.onPullDownRefresh();

                  case 4:
                  case "end":
                    return t.stop();
                }
            }, t, a);
        }))();
    },
    tabJump: function(t) {
        var e = t.detail, a = e.url, n = e.method, r = e.type, o = e.curr, i = e.index, s = e.text, u = e.formId;
        _index.baseModel.getFormId({
            formId: u
        });
        var c = this.data.optionsParam.to_uid, g = wx.getStorageSync("userid");
        if (a && (0 == a.indexOf("wx") || -1 < a.indexOf("http") || (a = a + "?uid=" + c + "&fid=" + g)), 
        !a) {
            var d = this.data.tabBar.list;
            d[i].pagePath2 ? (a = d[i].pagePath2 + "?uid=" + c + "&fid=" + g, wx[n]({
                url: a,
                fail: function(t) {
                    a = "/longbing_card/pages/index/index?currentTabBar=" + o + "&to_uid=" + c + "&from_id=" + g, 
                    console.log(t, a);
                }
            })) : a = "/longbing_card/pages/index/index?currentTabBar=" + o + "&to_uid=" + c + "&from_id=" + g;
        }
        t.currentTarget.dataset = {
            url: a,
            method: n,
            type: r,
            curr: o,
            index: i,
            text: s,
            formId: u
        }, _xx_util2.default.goUrl(t);
    },
    toConsult: function() {
        var r = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function t() {
            var e, a, n;
            return regeneratorRuntime.wrap(function(t) {
                for (;;) switch (t.prev = t.next) {
                  case 0:
                    e = getApp().globalData.to_uid, a = r.data.staff_info.name, getApp().globalData.nickName = a, 
                    n = "/longbing_card/chat/userChat/userChat?chat_to_uid=" + e + "&contactUserName=" + a, 
                    console.log(n, "toConsult"), wx.navigateTo({
                        url: n
                    });

                  case 6:
                  case "end":
                    return t.stop();
                }
            }, t, r);
        }))();
    },
    getPhoneNumber: function(t) {
        var e = t.detail, a = e.encryptedData, n = e.iv;
        a && n && this.setPhoneInfo(a, n), this.toConsult();
    },
    setPhoneInfo: function(t, e) {
        var a = this, n = getApp().globalData.to_uid;
        _index.baseModel.getPhone({
            encryptedData: t,
            iv: e,
            to_uid: n
        }).then(function(e) {
            _xx_util2.default.hideAll(), app.globalData.hasClientPhone = !0, app.globalData.auth.authPhoneStatus = !0, 
            a.setData({
                hasClientPhone: !0,
                authPhoneStatus: !0
            }, function() {
                if (e.data.phone) {
                    var t = wx.getStorageSync("user");
                    t.phone = e.data.phone, wx.setStorageSync("user", t);
                }
                a.getAuthInfoSuc();
            });
        });
    }
});