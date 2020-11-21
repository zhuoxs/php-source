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
                            var t = wx.getStorageSync("fcInfo");
                            t.wxInfo ? (t.login = !0, wx.setStorageSync("fcInfo", t), a.setData({
                                isLogin: !0
                            })) : (t.login = !1, wx.setStorageSync("fcInfo", t), a.setData({
                                isLogin: !1
                            }));
                        } else {
                            var n = wx.getStorageSync("fcInfo");
                            n.login = !1, wx.setStorageSync("fcInfo", n), a.setData({
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
                var n = wx.getStorageSync("fcInfo");
                n.wxInfo = e.detail.userInfo;
                var o = {
                    openid: n.openid,
                    headurl: e.detail.userInfo.avatarUrl,
                    username: e.detail.userInfo.nickName
                };
                (0, _api.SaveAvatarData)(o).then(function(e) {
                    n.wxInfo = e, n.login = !0, wx.setStorageSync("fcInfo", n), t.setData({
                        isLogin: !0
                    });
                });
            }
        }
    }
});