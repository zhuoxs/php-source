var _api = require("../../../common/js/api.js"), app = getApp();

Component({
    properties: {
        isLogin: {
            type: Boolean,
            value: !0,
            observer: function(e, n) {
                var t = {
                    login: e
                };
                this.triggerEvent("watch", t);
            }
        }
    },
    attached: function() {
        this._onLogin();
    },
    methods: {
        _onLogin: function() {
            var a = this;
            (0, _api.getUserInfo)().catch(function(e) {
                wx.getSetting({
                    success: function(e) {
                        if (e.authSetting["scope.userInfo"]) {
                            var n = wx.getStorageSync("userInfo");
                            n.wxInfo ? (n.login = !0, wx.setStorageSync("userInfo", n), a.setData({
                                isLogin: !0
                            })) : (n.login = !1, wx.setStorageSync("userInfo", n), a.setData({
                                isLogin: !1
                            }));
                        } else {
                            var t = wx.getStorageSync("userInfo");
                            t.login = !1, wx.setStorageSync("userInfo", t), a.setData({
                                isLogin: !1
                            });
                        }
                        var o = {
                            login: a.data.isLogin
                        };
                        a.triggerEvent("watch", o);
                    }
                });
            });
        },
        _getUserInfo: function(e) {
            var n = this;
            if ("getUserInfo:fail auth deny" !== e.detail.errMsg) {
                var t = wx.getStorageSync("userInfo");
                t.wxInfo = e.detail.userInfo;
                var o = {
                    openid: t.openid,
                    headimg: e.detail.userInfo.avatarUrl,
                    user_name: e.detail.userInfo.nickName
                };
                (0, _api.SaveAvatarData)(o).then(function(e) {
                    t.wxInfo = e, t.login = !0, wx.setStorageSync("userInfo", t), n.setData({
                        isLogin: !0
                    });
                });
            }
        }
    }
});