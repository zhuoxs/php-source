var e = getApp(), t = require("./../../../utils/core.js");

Page({
    data: {
        close: 0,
        text: "",
        imgUrl: ""
    },
    onLoad: function(t) {
        this.setData({
            close: t.close,
            text: t.text,
            imgUrl: e.globalData.approot
        });
    },
    onShow: function() {
        var t = e.getCache("sysset").shopname;
        wx.setNavigationBarTitle({
            title: t || "提示"
        });
    },
    bind: function() {
        var e = this, t = setInterval(function() {
            wx.getSetting({
                success: function(n) {
                    var a = n.authSetting["scope.userInfo"];
                    a && (wx.reLaunch({
                        url: "/pages/index/index"
                    }), clearInterval(t), e.setData({
                        userInfo: a
                    }));
                }
            });
        }, 1e3);
    },
    bindGetUserInfo: function(n) {
        var a = e.getCache("routeData"), i = a.url, s = a.params, o = "";
        Object.keys(s).forEach(function(e) {
            o += e + "=" + s[e] + "&";
        });
        var c = "/" + i + "?" + (s = o.substring(0, o.length - 1));
        wx.login({
            success: function(a) {
                t.post("wxapp/login", {
                    code: a.code
                }, function(a) {
                    a.error ? t.alert("获取用户登录态失败:" + a.message) : t.get("wxapp/auth", {
                        data: n.detail.encryptedData,
                        iv: n.detail.iv,
                        sessionKey: a.session_key
                    }, function(t) {
                        1 == t.isblack && wx.showModal({
                            title: "无法访问",
                            content: "您在商城的黑名单中，无权访问！",
                            success: function(t) {
                                t.confirm && e.close(), t.cancel && e.close();
                            }
                        }), n.detail.userInfo.openid = t.openId, n.detail.userInfo.id = t.id, n.detail.userInfo.uniacid = t.uniacid, 
                        e.setCache("userinfo", n.detail.userInfo), e.setCache("userinfo_openid", n.detail.userInfo.openid), 
                        e.setCache("userinfo_id", t.id), e.getSet(), wx.reLaunch({
                            url: c
                        });
                    });
                });
            },
            fail: function() {
                t.alert("获取用户信息失败!");
            }
        });
    }
});