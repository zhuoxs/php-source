var _slicedToArray = function(e, t) {
    if (Array.isArray(e)) return e;
    if (Symbol.iterator in Object(e)) return function(e, t) {
        var r = [], n = !0, a = !1, o = void 0;
        try {
            for (var u, i = e[Symbol.iterator](); !(n = (u = i.next()).done) && (r.push(u.value), 
            !t || r.length !== t); n = !0) ;
        } catch (e) {
            a = !0, o = e;
        } finally {
            try {
                !n && i.return && i.return();
            } finally {
                if (a) throw o;
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

function _asyncToGenerator(e) {
    return function() {
        var i = e.apply(this, arguments);
        return new Promise(function(o, u) {
            return function t(e, r) {
                try {
                    var n = i[e](r), a = n.value;
                } catch (e) {
                    return void u(e);
                }
                if (!n.done) return Promise.resolve(a).then(function(e) {
                    t("next", e);
                }, function(e) {
                    t("throw", e);
                });
                o(a);
            }("next");
        });
    };
}

var app = getApp(), regeneratorRuntime = _xx_util2.default.regeneratorRuntime;

Page({
    data: {
        cardIndexData: {},
        notRead: "",
        noticeNum: "",
        qrImg: ""
    },
    onLoad: function(e) {
        var t = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    t;

                  case 1:
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
        this.subscribe(), this.firstLoad();
    },
    onPullDownRefresh: function() {
        var t = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    t.firstLoad();

                  case 2:
                  case "end":
                    return e.stop();
                }
            }, e, t);
        }))();
    },
    onShareAppMessage: function(e) {
        var t = this.data, r = t.to_uid, n = t.cardIndexData, a = n.share_img, o = n.info, u = o.card_type, i = o.avatar_2, s = o.share_text;
        a && "cardType1" != u && "cardType4" != u || (a = i);
        var c = "/longbing_card/pages/index/index?to_uid=" + r + "&from_id=" + r + "&currentTabBar=toCard";
        return console.log(c, "tmp_path"), {
            title: s,
            path: c,
            imageUrl: a
        };
    },
    firstLoad: function() {
        var h = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t, r, n, a, o, u, i, s, c, d, f, g, p, l, _, m;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    return t = wx.getStorageSync("userid"), e.next = 3, Promise.all([ getApp().getConfigInfo(!0), _index.userModel.getCardShow({
                        to_uid: t
                    }), _index.staffModel.getFormIds(), _index.staffModel.getUnread() ]);

                  case 3:
                    r = e.sent, n = _slicedToArray(r, 4), n[0], a = n[1], o = n[2], u = n[3], i = getApp().globalData, 
                    s = i.isIphoneX, c = i.userDefault, d = i.configInfo, f = d.checkArticle, g = d.checkActivity, 
                    p = d.config, l = p.plugin, _ = o.data.count, m = u.data.count, h.setData({
                        plugin: l,
                        isIphoneX: s,
                        userDefault: c,
                        checkArticle: f,
                        checkActivity: g,
                        to_uid: t,
                        cardIndexData: a.data,
                        noticeNum: _,
                        notRead: m
                    });

                  case 15:
                  case "end":
                    return e.stop();
                }
            }, e, h);
        }))();
    },
    getFormIds: function() {
        var a = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t, r, n;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    return e.next = 2, _index.staffModel.getFormIds();

                  case 2:
                    t = e.sent, r = t.data, n = r.count, a.setData({
                        noticeNum: n
                    });

                  case 6:
                  case "end":
                    return e.stop();
                }
            }, e, a);
        }))();
    }
});