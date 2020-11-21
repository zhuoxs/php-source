var app = getApp(), WxParse = require("../../../wxParse/wxParse.js");

function config(o, n) {
    o.updateUserInfo = updateUserInfo, is_user(o), o.user_close = user_close, sign(function() {
        if ("" != app.closed && null != app.closed && "xc_farm/pages/closed/closed" != o.route) return wx.redirectTo({
            url: "../closed/closed"
        }), !1;
        if ("admin" == n) var e = app.admin; else if ("admin2" == n) e = app.admin2; else if ("admin3" == n) e = app.admin3; else e = app.footer;
        for (var a = -1, t = 0; t < e.length; t++) o.data.navHref == e[t].pagePath && 1 == e[t].status && (a = t);
        "" != app.config && null != app.config && wx.setNavigationBarTitle({
            title: app.config.webname
        }), o.setData({
            footer: e,
            footerCurr: a,
            theme: app.theme,
            config: app.config
        }), "" != app.review && null != app.review && ("" != app.review.content && null != app.review.content && WxParse.wxParse("article", "html", app.review.content, o, 0), 
        o.setData({
            review: app.review
        })), app.app_add_status && (o.setData({
            app_step1: !0
        }), o.app_step_next = app_step_next, o.app_step_end = app_step_end);
    });
}

function sign(e) {
    1 == app.globalData.login ? "function" == typeof e && e() : (app.util.request({
        url: "entry/wxapp/index",
        method: "POST",
        showLoading: !1,
        data: {
            op: "base"
        },
        success: function(e) {
            var a = e.data;
            if ("" != a.data) {
                if ("" != a.data.config && null != a.data.config) {
                    var t = a.data.config;
                    if ("" != t.footer && null != t.footer) for (var o = 0; o < t.footer.length; o++) "" != t.footer[o].text && null != t.footer[o].text && (app.footer[o].text = t.footer[o].text), 
                    "" != t.footer[o].icon && null != t.footer[o].icon && (app.footer[o].iconPath = t.footer[o].icon), 
                    "" != t.footer[o].select && null != t.footer[o].select && (app.footer[o].selectedIconPath = t.footer[o].select), 
                    "" != t.footer[o].link && null != t.footer[o].link && (app.footer[o].pagePath = t.footer[o].link), 
                    "" != t.footer[o].status && null != t.footer[o].status && (app.footer[o].status = t.footer[o].status);
                    app.config = a.data.config;
                }
                if ("" != a.data.theme && null != a.data.theme) {
                    var n = app.theme;
                    if (2 == a.data.theme.type && (n.name = 2, "" != a.data.theme.color && null != a.data.theme.color && (n.color = a.data.theme.color), 
                    "" != a.data.theme.icon && null != a.data.theme.icon)) for (o = 0; o < a.data.theme.icon.length; o++) "" != a.data.theme.icon[o] && null != a.data.theme.icon[o] && (n.icon[o] = a.data.theme.icon[o]);
                    app.theme = n;
                }
                "" != a.data.review && null != a.data.review && (app.review = a.data.review), "" != a.data.closed && null != a.data.closed && (app.closed = a.data.closed), 
                app.app_add_status = a.data.app_add_status;
            }
            app.globalData.login = 1;
        },
        complete: function() {
            "function" == typeof e && e();
        }
    }), app.util.request({
        url: "entry/wxapp/grouprefund",
        method: "POST",
        showLoading: !1
    }));
}

function updateUserInfo(e) {
    var t = this;
    t.setData({
        shadow: !1,
        get_userinfo: !1
    }), "" != e.detail.userInfo && null != e.detail.userInfo && app.util.getUserInfo(function(e) {
        var a = {};
        "" != e.wxInfo && null != e.wxInfo ? (a = e.wxInfo).op = "userinfo" : a.op = "userinfo", 
        "" != t.data.fen_openid && null != t.data.fen_openid && (a.fen_openid = t.data.fen_openid), 
        app.util.request({
            url: "entry/wxapp/index",
            showLoading: !1,
            data: a,
            success: function(e) {
                var a = e.data;
                "" != a.data && (app.userinfo = a.data);
            }
        });
    }, e.detail);
}

function is_user(t) {
    1 != app.globalData.login && app.util.getUserInfo(function(e) {
        var a = {};
        "" == e.wxInfo || null == e.wxInfo ? t.setData({
            shadow: !0,
            get_userinfo: !0
        }) : a = e.wxInfo, a.op = "userinfo", "" != t.data.fen_openid && null != t.data.fen_openid && (a.fen_openid = t.data.fen_openid), 
        app.util.request({
            url: "entry/wxapp/index",
            method: "POST",
            showLoading: !1,
            data: a,
            success: function(e) {
                var a = e.data;
                "" != a.data && (app.userinfo = a.data, t.setData({
                    userinfo: a.data
                }));
            }
        });
    });
}

function user_close() {
    this.setData({
        shadow: !1,
        get_userinfo: !1
    });
}

function is_bind(e) {
    "function" == typeof e && e();
}

function app_step_next() {
    this.setData({
        app_step1: !1,
        app_step2: !0
    });
}

function app_step_end() {
    var a = this;
    app.util.request({
        url: "entry/wxapp/index",
        method: "POST",
        showLoading: !1,
        data: {
            op: "app_add_log"
        },
        success: function(e) {
            "" != e.data.data && (a.setData({
                app_step2: !1
            }), app.app_add_status = !1);
        }
    });
}

module.exports = {
    config: config,
    is_bind: is_bind
};