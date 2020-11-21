var t = require("../../../utils/base.js"), a = require("../../../../api.js"), e = new t.Base(), s = getApp();

Page({
    data: {
        infoAuth: !0
    },
    onLoad: function(t) {
        var a = this;
        s.getTabBar(), this.guessYouLike();
        var e = wx.getStorageSync("userData");
        e.user_info && this.setData({
            userData: e,
            is_vip: e.user_info.is_vip
        }), s.getInformation(function(t) {
            a.setData({
                platform: t
            });
        });
    },
    onShow: function() {
        var t = this;
        this.getUserData(), s.userInfoAuth(function(a) {
            t.setData({
                infoAuth: a
            });
        });
    },
    getUserInfo: function(t) {
        var n = this;
        wx.getSetting({
            success: function(t) {
                t.authSetting["scope.userInfo"] && wx.getUserInfo({
                    success: function(t) {
                        console.log("用户授权信息=>", t), s.userInfoAuth(function(t) {
                            n.setData({
                                infoAuth: t
                            });
                        }), wx.setStorageSync("userInfo", t.userInfo), s.updateToken(function(s) {
                            if ("undefined" != s) {
                                var o = {
                                    url: a.default.user_update,
                                    data: {
                                        nickname: t.userInfo.nickName,
                                        avatar: t.userInfo.avatarUrl
                                    }
                                };
                                console.log("param", o), e.getData(o, function(t) {
                                    console.log(t);
                                }), n.getUserData();
                            }
                        });
                    }
                });
            }
        });
    },
    getUserData: function() {
        var t = this, s = {
            url: a.default.user
        };
        e.getData(s, function(a) {
            console.log("用户信息=>", a);
            var e = 0;
            1 == a.errorCode && (wx.setStorageSync("userData", a), e = a.user_info.is_vip, t.setData({
                userData: a,
                is_vip: e
            }));
        });
    },
    guessYouLike: function() {
        var t = this, s = {
            url: a.default.guess
        };
        e.getData(s, function(a) {
            if (1 == a.errorCode) {
                for (var e in a.data) a.data[e].price = parseFloat(a.data[e].price), a.data[e].o_price = parseFloat(a.data[e].o_price), 
                a.data[e].vip_price = parseFloat(a.data[e].vip_price);
                t.setData({
                    guessGood: a.data
                });
            }
        });
    },
    navigatorLink: function(t) {
        s.navClick(t, this);
    }
});