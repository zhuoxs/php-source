require("longbing_card/resource/js/wxPromise.min.js");

var _index = require("longbing_card/resource/js/mp-extend/index.js"), _index2 = _interopRequireDefault(_index), _index3 = require("longbing_card/resource/apis/index.js"), _websocket = require("longbing_card/resource/js/websocket.js"), _websocket2 = _interopRequireDefault(_websocket), _xx_util = require("longbing_card/resource/js/xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util);

function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

var timerRead, util = require("longbing_card/resource/js/util.js"), appUniacid = require("siteinfo.js"), regeneratorRuntime = _xx_util2.default.regeneratorRuntime;

Page = _index2.default.Page, App({
    onLaunch: function(e) {
        console.log(e);
        var a = wx.getStorageSync("userid") || "", t = wx.getStorageSync("user") || {}, o = wx.getStorageSync("token") || "", n = wx.getStorageSync("lb_token") || "";
        wx.clearStorageSync(), wx.setStorageSync("userid", a), wx.setStorageSync("user", t), 
        wx.setStorageSync("token", o), wx.setStorageSync("lb_token", n), this.websocket = _websocket2.default, 
        this.websocket.connect();
    },
    onShow: function(e) {
        var a = this, t = wx.getSystemInfoSync(), o = t.model, n = t.platform;
        a.globalData.platform = n, a.globalData.isIphoneX = o.includes("iPhone X"), console.log(n + " || " + o);
        var r = e.query.scene ? _xx_util2.default.getSceneParam(decodeURIComponent(e.query.scene)) : e.query, i = r.to_uid, c = r.uid, g = r.from_id, s = r.fid, l = r.id, u = r.is_qr, d = r.custom, m = r.type, _ = {
            scene: e.scene,
            is_qr: u || 0,
            is_group: 1044 == e.scene ? 1 : 0,
            type: d ? 1 : m || 0,
            target_id: d || (l || 0)
        };
        a.globalData.loginParam = _, a.globalData.to_uid = i || c || 0, a.globalData.from_id = g || s || 0;
        var h = a.globalData, p = h.to_uid, f = h.from_id;
        wx.setStorageSync("pid", f || p);
        var b = [ a.globalData.loginParam, {
            cur_to_uid: p,
            cur_from_id: f,
            pid: f || p
        } ];
        console.log("console_items =>", b), 1044 == e.scene && wx.getShareInfo({
            shareTicket: e.shareTicket,
            complete: function(e) {
                a.globalData.encryptedData = e.encryptedData, a.globalData.iv = e.iv;
            }
        }), a.getToLogin();
    },
    onHide: function() {},
    onError: function(e) {
        console.log(e);
    },
    _clearBadgeTimer: function() {
        var e = this;
        e.globalData._setTabBarBadgeTimer && (clearInterval(e.globalData._setTabBarBadgeTimer), 
        e.globalData._setTabBarBadgeTimer = null);
    },
    _createBadgeTimer: function() {
        var e = this;
        e.globalData._setTabBarBadgeTimer || (e.globalData._setTabBarBadgeTimer = setInterval(function() {
            e.setMsgBadge(e.globalData.badgeNum);
        }, 300));
    },
    setMsgBadge: function(e) {
        var a = this;
        0 != e ? wx.setTabBarBadge({
            index: 1,
            text: String(e),
            success: function() {
                a._clearBadgeTimer();
            },
            fail: function() {
                a._createBadgeTimer();
            }
        }) : wx.removeTabBarBadge({
            index: 1,
            success: function() {
                a._clearBadgeTimer();
            },
            fail: function() {
                a._createBadgeTimer();
            }
        });
    },
    getConfigInfo: function() {
        var t = 0 < arguments.length && void 0 !== arguments[0] && arguments[0], s = this, n = s.globalData.configInfo;
        return new Promise(function(o, e) {
            if (n && !t) {
                var a = Object.assign({}, n);
                o(a);
            } else _index3.baseModel.getInConfig().then(function(e) {
                console.log(e, "getInConfig");
                var a = e.data, t = Object.assign({}, a);
                o(t);
            }).catch(function() {
                _index3.baseModel.getConfig().then(function(e) {
                    console.log(e, "getConfig");
                    var a = e.data, t = Object.assign({}, a);
                    o(t);
                });
            });
        }).then(function(e) {
            var a = e.tabBar, t = e.config, o = e.lb_token, n = e.is_pay_shop;
            wx.setStorageSync("lb_token", o);
            var r = t.ios_pay, i = t.android_pay, c = wx.getSystemInfoSync().system.includes("iOS"), g = 0 != n && 1 == (c ? r : i);
            return s.globalData.price_switch = g, s.globalData.configInfo = e, s.globalData.tabBar = a, 
            console.log("is_pay_shop price_switch =>", n, g), e;
        });
    },
    getToLogin: function() {
        var d = this;
        wx.login({
            success: function(e) {
                var a = d.globalData.loginParam, t = a.scene, o = a.is_qr, n = a.is_group, r = a.type, i = a.target_id, c = d.globalData, g = c.encryptedData, s = c.iv, l = wx.getStorageSync("pid");
                console.log("pid =>", l), _index3.baseModel.getBind({
                    from_id: l
                });
                var u = {
                    code: e.code,
                    from_id: l,
                    scene: t,
                    is_qr: o,
                    is_group: n,
                    type: r || 0,
                    target_id: i || 0,
                    encryptedData: g || "",
                    iv: s || ""
                };
                wx.setStorageSync("loginParamObj", u), _index3.baseModel.getLogin(u).then(function(e) {
                    var a = e.data, t = a.user_id, o = a.user;
                    d.globalData.userid = t, wx.setStorageSync("userid", t), o && (d.globalData.openGId_2 = o.openGId_2 || "", 
                    o.phone && (d.globalData.hasClientPhone = !0), wx.setStorageSync("user", o));
                });
            }
        });
    },
    getCardAfter: function() {
        var e = this.globalData, a = e.to_uid, t = e.from_id, o = e.openGId_2, n = this.globalData.loginParam;
        t || (t = a);
        var r = {
            to_uid: a,
            is_qr: n.is_qr,
            is_group: n.is_group,
            type: n.type,
            target_id: n.target_id,
            from_id: t
        };
        o && (r.openGId = o), _index3.userModel.getCardAfter(r).then(function(e) {});
    },
    getUnReadNum: function(e) {
        var a = e.user_count, t = e.staff_count;
        this.globalData.badgeNum = t, this._createBadgeTimer(), this.globalData.clientUnread = a;
    },
    getCurUserInfo: function(e, a) {
        var t = wx.getStorageSync("user") || {}, o = t.nickName, n = t.avatarUrl, r = t.phone;
        this.globalData.hasClientPhone = !!r;
        var i = this.globalData.configInfo.config.force_phone, c = n && !r && 1 == i ? 1 : 0, g = {
            nickName: o,
            avatarUrl: n,
            phone: r,
            force_phone: c,
            to_uid: e
        };
        return console.log(i, c, "*************force_phone*2"), {
            userInfo: g,
            openType: a = 1 == c ? "getPhoneNumber" : a
        };
    },
    util: util,
    userInfo: {
        sessionid: null
    },
    siteInfo: require("siteinfo.js"),
    globalData: {
        isIphoneX: !1,
        platform: !1,
        isShowCard: "/",
        userid: "",
        openGId_2: "",
        to_uid: 0,
        from_id: 0,
        nickName: "",
        avatarUrl: "",
        encryptedData: !1,
        iv: !1,
        isStaff: -1,
        isBoss: !1,
        hasClientPhone: !1,
        configInfo: !1,
        checkvoucher: !1,
        voucherStatus: {
            tag: "big",
            status: "unreceive"
        },
        auth: {
            authStatus: "400",
            authPhoneStatus: "400"
        },
        chooseStaffInfo: {
            avatar: "",
            avatarImg: ""
        },
        loginParam: {
            scene: "",
            is_qr: "",
            is_group: "",
            type: "",
            target_id: ""
        },
        _setTabBarBadgeTimer: null,
        badgeNum: 0,
        clientUnread: 1,
        productDefault: "https://retail.xiaochengxucms.com/images/12/2018/11/t6MzXY2izRj1zZWi8pRdd1Zmx217r3.jpg",
        bannerDefault: "https://retail.xiaochengxucms.com/images/12/2018/11/RpbHpOzXlTHxPrE5XTm5hS3SB5EszX.jpg",
        chatImg: "https://retail.xiaochengxucms.com/images/12/2018/09/uEunvCzB16TY1gmTEtDDiEZ6YdU7Zu.png",
        logoImg: "https://retail.xiaochengxucms.com/images/12/2018/11/crDXyl3TyBRLUBch6ToqXL6e9D96hY.jpg",
        userDefault: "https://retail.xiaochengxucms.com/images/12/2018/11/fDK7kkrmkMReK50l4r1Le740Kmra85.jpg",
        noUserImg: "https://retail.xiaochengxucms.com/images/12/2018/09/jyJlH5ax28TztQAQ2Jh8tIkXLhBQyK.png",
        moreImgs: "https://retail.xiaochengxucms.com/images/12/2018/09/jeVh5RF0dfndncFeZzmhzeW511V4Rm.png",
        ingImg: "https://retail.xiaochengxucms.com/images/12/2018/09/hnqwnkQsV4lNx2vIyCA3lxF3LTfGqv.png",
        bossImg: "https://retail.xiaochengxucms.com/images/12/2018/09/KYdftdZuDYh2TF9pQnJ0uT9tgNt2q2.png",
        playVideoImg: "https://retail.xiaochengxucms.com/images/12/2018/10/T8A1maB3boAB3A8Sb8yTYBs1b0BmaA.png",
        companyVideoImg: "https://retail.xiaochengxucms.com/images/12/2018/10/vmKklLlnkMRCRBFuZDMEkEcfu4fEKr.png",
        cardVideoImg: "https://retail.xiaochengxucms.com/images/12/2018/10/Ik4kmm8i4a8Qb5383a699m6p3g3g6q.png",
        tabBar: {
            color: "#838591",
            selectedColor: "#e93636",
            backgroundColor: "#fff",
            borderStyle: "white",
            list: [ {
                pagePath: "",
                text: "名片",
                currentTabBar: "toCard",
                iconPath: "/longbing_card/resource/icon/icon-card.png",
                selectedIconPath: "/longbing_card/resource/icon/icon-card-cur.png",
                method: "reLaunch"
            }, {
                pagePath: "/longbing_card/reserve/pages/index/index",
                text: "预约",
                iconPath: "/longbing_card/resource/icon/icon-reserve.png",
                selectedIconPath: "/longbing_card/resource/icon/icon-reserve-cur.png",
                method: "redirectTo"
            }, {
                pagePath: "",
                text: "商城",
                currentTabBar: "toShop",
                iconPath: "/longbing_card/resource/icon/icon-shop.png",
                selectedIconPath: "/longbing_card/resource/icon/icon-shop-cur.png",
                method: "reLaunch"
            }, {
                pagePath: "",
                text: "动态",
                currentTabBar: "toNews",
                iconPath: "/longbing_card/resource/icon/icon-news.png",
                selectedIconPath: "/longbing_card/resource/icon/icon-news-cur.png",
                method: "reLaunch"
            }, {
                pagePath: "",
                text: "官网",
                currentTabBar: "toCompany",
                iconPath: "/longbing_card/resource/icon/icon-company.png",
                selectedIconPath: "/longbing_card/resource/icon/icon-company-cur.png",
                method: "reLaunch"
            } ]
        }
    }
});