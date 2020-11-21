var _api = require("../../../resource/js/api.js"), app = getApp();

Component({
    properties: {
        isLogin: {
            type: Boolean,
            value: !0,
            observer: function(e, t) {
                var n = {
                    login: e
                };
                this.triggerEvent("watch", n);
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
                            var t = wx.getStorageSync("userInfo");
                            t.wxInfo ? (t.login = !0, wx.setStorageSync("userInfo", t), a.setData({
                                isLogin: !0
                            })) : (t.login = !1, wx.setStorageSync("userInfo", t), a.setData({
                                isLogin: !1
                            }));
                        } else {
                            var n = wx.getStorageSync("userInfo");
                            n.login = !1, wx.setStorageSync("userInfo", n), a.setData({
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
            var t = this;
            if ("getUserInfo:fail auth deny" !== e.detail.errMsg) {
                var n = wx.getStorageSync("userInfo");
                n.wxInfo = e.detail.userInfo;
                var o = {
                    openid: n.openid,
                    headimg: e.detail.userInfo.avatarUrl,
                    user_name: e.detail.userInfo.nickName
                };
                (0, _api.SaveAvatarData)(o).then(function(e) {
                    n.wxInfo = e, n.login = !0, wx.setStorageSync("userInfo", n), t.setData({
                        isLogin: !0
                    });
                });
            }
        }
    }
});