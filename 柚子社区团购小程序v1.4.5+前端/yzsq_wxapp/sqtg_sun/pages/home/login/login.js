var app = getApp(), Page = require("../../../../zhy/sdk/qitui/oddpush.js").oddPush(Page).Page;

Page({
    data: {},
    onLoad: function(t) {
        var e = decodeURIComponent(t.id);
        e ? this.setData({
            backurl: e
        }) : this.setData({
            backurl: "../index/index"
        }), this.getsetting();
    },
    getsetting: function() {
        var e = this, a = wx.getStorageSync("appConfig");
        a ? e.setData({
            setting: a
        }) : app.ajax({
            url: "Csystem|getSetting",
            success: function(t) {
                wx.setStorageSync("appConfig", t.data), e.setData({
                    setting: a,
                    imgroot: t.other.img_root
                });
            }
        });
    },
    onLoginTab: function(t) {
        "getUserInfo:fail auth deny" !== t.detail.errMsg && (this.setData({
            info: t.detail.userInfo
        }), this.wxLogin());
    },
    wxLogin: function() {
        var e = this;
        wx.login({
            success: function(t) {
                t.code ? app.ajax({
                    url: "Cwx|getOpenid",
                    data: {
                        code: t.code
                    },
                    method: "GET",
                    success: function(t) {
                        t.code ? app.tips(t.msg) : (wx.setStorageSync("session_key", t.data.session_key), 
                        wx.setStorageSync("open_id", t.data.openid), e.setData({
                            openid: t.data.openid
                        }), e.getUserInfo(t.data.openid));
                    }
                }) : app.tips("登录失败！" + t.errMsg);
            }
        });
    },
    getUserInfo: function(t) {
        var e = wx.getStorageSync("share_user_id"), a = this, s = {
            openid: t,
            name: this.data.info.nickName,
            img: this.data.info.avatarUrl,
            gender: this.data.info.gender,
            share_user_id: e,
            email: ""
        };
        app.ajax({
            url: "Cuser|login",
            data: s,
            method: "GET",
            success: function(t) {
                t.code ? app.tips(t.msg) : (wx.setStorageSync("userInfo", t.data), app.reTo(a.data.backurl));
            }
        });
    }
});