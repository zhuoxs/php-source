var _xx_util = require("../../resource/js/xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util), _index = require("../../resource/apis/index.js");

function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

function _asyncToGenerator(e) {
    return function() {
        var i = e.apply(this, arguments);
        return new Promise(function(a, u) {
            return function t(e, n) {
                try {
                    var o = i[e](n), r = o.value;
                } catch (e) {
                    return void u(e);
                }
                if (!o.done) return Promise.resolve(r).then(function(e) {
                    t("next", e);
                }, function(e) {
                    t("throw", e);
                });
                a(r);
            }("next");
        });
    };
}

var regeneratorRuntime = _xx_util2.default.regeneratorRuntime;

Component({
    properties: {
        openType: {
            type: String,
            value: "getUserInfo"
        },
        authName: {
            type: String,
            value: "userInfo"
        },
        content: {
            type: String,
            value: ""
        },
        btnText: {
            type: String,
            value: ""
        },
        logo: {
            type: String
        },
        show: {
            type: Boolean,
            value: !0
        },
        userInfo: {
            type: Object
        },
        forceAuth: {
            type: Boolean,
            value: !1
        }
    },
    data: {
        contentList: {
            getUserInfo: [ "你好！初次使用，请先登录", "微信登录" ],
            getPhoneNumber: [ "你好！请授权手机号码", "授权手机号码" ],
            openSetting: [ "为了功能正常使用，你需要打开设置并开启获取相应权限", "打开设置" ]
        },
        logoImg: getApp().globalData.logoImg
    },
    methods: {
        getUserInfo: function(e) {
            var t = this, n = e.detail.userInfo, o = t.data, r = o.show, a = o.forceAuth, u = o.userInfo, i = o.openType;
            if (n) {
                _index.baseModel.getUpdateUserInfo(n), getApp().globalData.auth.authStatus = !0;
                var s = wx.getStorageSync("user"), c = n.nickName, g = n.avatarUrl;
                s.nickName = c, s.avatarUrl = g, wx.setStorageSync("user", s), r = !1, u.phone || (r = !0, 
                i = "getPhoneNumber", 1 == u.force_phone && (a = !0)), console.log(r, i, a, "***************show,openType,forceAuth"), 
                t.setData({
                    show: r,
                    openType: i,
                    forceAuth: a
                }), t.triggerEvent("getAuthInfoSuc", n);
            } else r = !!a, t.setData({
                show: r
            });
        },
        getPhoneNumber: function(f) {
            var d = this;
            return _asyncToGenerator(regeneratorRuntime.mark(function e() {
                var t, n, o, r, a, u, i, s, c, g, l, p, h;
                return regeneratorRuntime.wrap(function(e) {
                    for (;;) switch (e.prev = e.next) {
                      case 0:
                        if (n = (t = d).data, o = n.show, r = n.userInfo, a = r.force_phone, u = r.to_uid, 
                        i = f.detail, s = i.encryptedData, c = i.iv, !s || !c) {
                            e.next = 17;
                            break;
                        }
                        return console.log("同意授权获取电话号码"), e.next = 8, _index.baseModel.getPhone({
                            encryptedData: s,
                            iv: c,
                            to_uid: u
                        });

                      case 8:
                        g = e.sent, l = g.data, (p = l.phone) && ((h = wx.getStorageSync("user")).phone = p, 
                        wx.setStorageSync("user", h)), getApp().globalData.hasClientPhone = !0, getApp().globalData.auth.authPhoneStatus = !0, 
                        t.triggerEvent("getAuthInfoSuc", l), e.next = 20;
                        break;

                      case 17:
                        console.log("拒绝授权获取电话号码"), o = 1 == a, t.setData({
                            show: o
                        });

                      case 20:
                      case "end":
                        return e.stop();
                    }
                }, e, d);
            }))();
        },
        openSetting: function(e) {
            var t = this, n = t.data.show;
            e.detail.authSetting["scope." + this.properties.authName] ? t.triggerEvent("auth", e) : wx.showToast({
                title: "授权失败，请重试！",
                icon: "none"
            }), n = !0, t.setData({
                show: n
            });
        },
        close: function(e) {
            this.triggerEvent("close", e);
        }
    },
    ready: function() {}
});