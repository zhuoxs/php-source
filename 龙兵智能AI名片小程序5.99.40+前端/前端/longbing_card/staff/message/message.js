var _slicedToArray = function(e, t) {
    if (Array.isArray(e)) return e;
    if (Symbol.iterator in Object(e)) return function(e, t) {
        var r = [], a = !0, n = !1, s = void 0;
        try {
            for (var o, i = e[Symbol.iterator](); !(a = (o = i.next()).done) && (r.push(o.value), 
            !t || r.length !== t); a = !0) ;
        } catch (e) {
            n = !0, s = e;
        } finally {
            try {
                !a && i.return && i.return();
            } finally {
                if (n) throw s;
            }
        }
        return r;
    }(e, t);
    throw new TypeError("Invalid attempt to destructure non-iterable instance");
}, _xx_util = require("../../resource/js/xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util), _index = require("../../resource/apis/index.js");

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
        var i = e.apply(this, arguments);
        return new Promise(function(s, o) {
            return function t(e, r) {
                try {
                    var a = i[e](r), n = a.value;
                } catch (e) {
                    return void o(e);
                }
                if (!a.done) return Promise.resolve(n).then(function(e) {
                    t("next", e);
                }, function(e) {
                    t("throw", e);
                });
                s(n);
            }("next");
        });
    };
}

var app = getApp(), regeneratorRuntime = _xx_util2.default.regeneratorRuntime;

Page({
    data: {
        messageTime: "",
        staffInfo: [],
        dataList: {
            list: [],
            page: 0,
            total_page: 0
        },
        param: {
            page: 1
        },
        refresh: !1,
        loading: !0
    },
    onLoad: function(e) {
        var t = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                  case "end":
                    return e.stop();
                }
            }, e, t);
        }))();
    },
    subscribe: function() {
        var r = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    t = wx.getStorageSync("userid"), getApp().websocket.sendMessage({
                        unread: !0,
                        user_id: t,
                        to_uid: t
                    }), getApp().websocket.subscribe("unread", r.getUserUnreadNum), getApp().websocket.subscribe("getMsg", r.getMsgUnreadNum);

                  case 4:
                  case "end":
                    return e.stop();
                }
            }, e, r);
        }))();
    },
    getUserUnreadNum: function(e) {
        var t = e.data, r = {
            user_count: t.user_count,
            staff_count: t.staff_count
        };
        getApp().getUnReadNum(r);
    },
    getMsgUnreadNum: function(e) {
        var t = {
            user_count: e.user_count,
            staff_count: e.staff_count
        };
        getApp().getUnReadNum(t);
    },
    onHide: function() {
        getApp().websocket.unSubscribe("unread"), getApp().websocket.unSubscribe("getMsg");
    },
    onUnload: function() {
        getApp().websocket.unSubscribe("unread"), getApp().websocket.unSubscribe("getMsg");
    },
    onShow: function() {
        var u = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t, r, a, n, s, o, i;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    return e.next = 2, getApp().getConfigInfo(!0);

                  case 2:
                    return t = getApp().globalData, r = t.isIphoneX, a = t.userDefault, n = t.configInfo, 
                    s = n.config.btn_sale, o = wx.getStorageSync("userid"), i = (new Date().getTime() / 1e3).toFixed(0), 
                    u.setData({
                        isIphoneX: r,
                        userDefault: a,
                        btn_sale: s,
                        curr_user_id: o,
                        messageTime: i
                    }), u.subscribe(), e.next = 10, u.onPullDownRefresh();

                  case 10:
                  case "end":
                    return e.stop();
                }
            }, e, u);
        }))();
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
                        wx.showNavigationBarLoading(), wx.stopPullDownRefresh(), t.getList(), _xx_util2.default.hideAll();
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
        (a *= 1) == r.total_page || t || (this.setData({
            "param.page": a + 1,
            loading: !0
        }), this.getList());
    },
    getList: function() {
        var d = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t, r, a, n, s, o, i, u, c, f, l, g;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    return r = (t = d).data, a = r.refresh, n = r.param, s = r.dataList, e.next = 4, 
                    Promise.all([ _index.staffModel.getStaffInfo(), _index.staffModel.getMessageList(n) ]);

                  case 4:
                    for (g in o = e.sent, i = _slicedToArray(o, 2), u = i[0], c = i[1], _xx_util2.default.hideAll(), 
                    console.log("getMessageList ==>", c.data), f = s, l = c.data, a || (l.list = [].concat(_toConsumableArray(f.list), _toConsumableArray(l.list))), 
                    l.list) l.list[g].last_time2 = _xx_util2.default.ctDate(1 * l.list[g].last_time);
                    l.last.last_time2 = _xx_util2.default.ctDate(1 * l.last.create_time), l.page = 1 * l.page, 
                    t.setData({
                        staffInfo: u.data,
                        dataList: l,
                        refresh: !1,
                        loading: !1
                    });

                  case 17:
                  case "end":
                    return e.stop();
                }
            }, e, d);
        }))();
    },
    toChat: function(e) {
        var t = _xx_util2.default.getData(e).index, r = this.data, a = r.curr_user_id, n = r.userDefault, s = r.staffInfo, o = r.dataList.list, i = a == o[t].user_id ? o[t].target_id : o[t].user_id, u = o[t].user.nickName || "新客户", c = o[t].user.avatarUrl || n, f = o[t].phone, l = s.avatarUrl;
        wx.navigateTo({
            url: "/longbing_card/chat/staffChat/staffChat?chat_to_uid=" + i + "&contactUserName=" + u + "&chatid=" + o[t].id + "&chatAvatarUrl=" + l + "&toChatAvatarUrl=" + c + "&clientPhone=" + f
        });
    }
});