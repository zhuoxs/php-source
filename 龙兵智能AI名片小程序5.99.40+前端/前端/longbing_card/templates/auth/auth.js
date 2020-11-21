var _that = void 0, _baseModel = void 0, _util = void 0;

function checkAuth(t, a, e) {
    _that = t, _baseModel = a, _util = e, wx.getSetting({
        success: function(t) {
            t.authSetting["scope.userInfo"] ? (console.log("有res.authSetting['scope.userInfo']"), 
            getApp().globalData.auth.authStatus = !0, _that.setData({
                authStatus: !0
            }, function() {
                var t = _that.data, a = t.exchange_switch, e = t.currentTabBar, o = t.cardIndexData;
                if (("cardList" == e || "toCard" == e) && 1 == a) {
                    var n = o.to_uid, s = wx.getStorageSync("isShowCard") || [], h = void 0;
                    -1 < s.indexOf(n) ? h = !1 : (h = !0, s.push(n), wx.setStorageSync("isShowCard", s)), 
                    _that.setData({
                        isToShowCard: h
                    });
                }
                toCheckAuthStatus();
            }), wx.getUserInfo({
                lang: "zh_CN",
                success: function(t) {
                    getChangeUserInfo(t.userInfo);
                }
            })) : (console.log("没有res.authSetting['scope.userInfo']"), getApp().globalData.auth.authStatus = !1, 
            _that.setData({
                authStatus: !1
            }));
        },
        fail: function(t) {
            console.log("wx.getSetting ==>> fail");
        }
    });
}

function toCheckAuthStatus() {
    var t = !0;
    getApp().globalData.configInfo.config && 1 == getApp().globalData.configInfo.config.force_phone && 0 == getApp().globalData.hasClientPhone && (t = !1), 
    getApp().globalData.auth.authStatus = !0, getApp().globalData.auth.authPhoneStatus = t, 
    _that.setData({
        authStatus: !0,
        authPhoneStatus: t
    }), console.log(_that.data.globalData.auth);
}

function getUserInfo(t) {
    if (t.detail.userInfo) {
        var a = t.detail.userInfo;
        console.log("获取微信用户信息 ==>>", a), getChangeUserInfo(a), getApp().globalData.auth.authStatus = !0, 
        _that.setData({
            authStatus: !0
        }, function() {
            var t = _that.data, a = t.exchange_switch, e = t.currentTabBar, o = t.cardIndexData;
            if ("toCard" == e && 1 == a) {
                var n = o.to_uid, s = wx.getStorageSync("isShowCard");
                s || (s = []);
                var h = void 0;
                -1 < s.indexOf(n) ? h = !1 : (h = !0, s.push(n), wx.setStorageSync("isShowCard", s)), 
                _that.setData({
                    isToShowCard: h
                });
            }
            toCheckAuthStatus();
        });
    } else console.log("拒绝授权"), _that.setData({
        authStatus: !1
    });
}

function getChangeUserInfo(e) {
    console.log("_baseModel.getUpdateUserInfo", e), _baseModel.getUpdateUserInfo(e).then(function(t) {
        _util.hideAll();
        var a = wx.getStorageSync("user");
        a.nickName = e.nickName, a.avatarUrl = e.avatarUrl, wx.setStorageSync("user", a);
    });
}

function getAuthPhoneNumber(t) {
    var a = t.detail, e = a.encryptedData, o = a.iv;
    e && o ? (console.log("同意授权获取电话号码"), setPhoneInfo(e, o)) : console.log("拒绝授权获取电话号码");
}

function setPhoneInfo(t, a) {
    var e = getApp().globalData.to_uid;
    _baseModel.getPhone({
        encryptedData: t,
        iv: a,
        to_uid: e
    }).then(function(t) {
        _util.hideAll();
        var a = t.data;
        if (a) {
            var e = wx.getStorageSync("user");
            e.phone = a.phone, wx.setStorageSync("user", e);
        }
        getApp().globalData.hasClientPhone = !0, getApp().globalData.auth.authPhoneStatus = !0, 
        _that.setData({
            hasClientPhone: !0,
            authPhoneStatus: !0
        });
    });
}

module.exports = {
    checkAuth: checkAuth,
    getUserInfo: getUserInfo,
    getAuthPhoneNumber: getAuthPhoneNumber
};