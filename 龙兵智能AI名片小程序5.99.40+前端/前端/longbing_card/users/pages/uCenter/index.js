var _xx_util = require("../../../resource/js/xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util), _index = require("../../../resource/apis/index.js");

function _interopRequireDefault(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}

var app = getApp(), regeneratorRuntime = _xx_util2.default.regeneratorRuntime;

Page({
    data: {
        showCheck: -1,
        canIUse: wx.canIUse("button.open-type.getUserInfo")
    },
    onLoad: function(t) {
        var s = this;
        _xx_util2.default.showLoading(), getApp().getConfigInfo().then(function() {
            var t = getApp().globalData, e = t.price_switch, a = t.userDefault, o = t.isIphoneX;
            s.setData({
                price_switch: e,
                userDefault: a,
                isIphoneX: o
            }, function() {
                s.getUser();
            });
        }), _xx_util2.default.hideAll();
    },
    onPullDownRefresh: function() {
        wx.showNavigationBarLoading(), this.getUser();
    },
    getUser: function() {
        var a = this;
        _index.baseModel.getUserInfo().then(function(t) {
            var e = t.data;
            a.setData({
                userData: e
            });
        });
    },
    toUpdate: function() {
        var e = this;
        wx.getSetting({
            success: function(t) {
                t.authSetting["scope.userInfo"] ? (console.log("有res.authSetting['scope.userInfo']"), 
                wx.getUserInfo({
                    lang: "zh_CN",
                    success: function(t) {
                        e.toChangeUserInfo(t.userInfo);
                    }
                })) : (console.log("没有res.authSetting['scope.userInfo']"), getApp().globalData.auth.authStatus = !1, 
                e.setData({
                    auth_user_status: !1
                }));
            },
            fail: function(t) {
                console.log("wx.getSetting ==>> fail");
            }
        });
    },
    getUserInfo: function(t) {
        t.detail.userInfo && this.toChangeUserInfo(t.detail.userInfo);
    },
    toChangeUserInfo: function(n) {
        var i = this;
        _xx_util2.default.showLoading({
            title: "更新中.."
        }), _index.baseModel.getUpdateUserInfo(n).then(function(t) {
            _xx_util2.default.hideAll();
            var e = n.nickName, a = n.avatarUrl, o = i.data.userData;
            o.nickName = e, o.avatarUrl = a;
            var s = wx.getStorageSync("user");
            s.nickName = e, s.avatarUrl = a, wx.setStorageSync("user", s), getApp().globalData.auth.authStatus = !0, 
            i.setData({
                userData: o,
                auth_user_status: !0
            });
        });
    },
    toJump: function(t) {
        var e = _xx_util2.default.getData(t).status;
        "toJumpUrl" == e && _xx_util2.default.goUrl(t), "toCancel" == e && this.setData({
            order_id: !1,
            showCheck: !1
        });
    },
    formSubmitCheck: function(t) {
        var a = this, e = t.detail.formId;
        _index.baseModel.getFormId({
            formId: e
        });
        var o = t.detail.value.pwd, s = a.data.order_id;
        if (!o) return _xx_util2.default.showFail("请输入核销密码！"), !1;
        wx.showModal({
            title: "",
            content: "请确认是否要核销此订单",
            success: function(t) {
                t.confirm && (_xx_util2.default.showLoading(), _index.staffModel.toCheckPassword({
                    pwd: o,
                    id: s
                }).then(function(t) {
                    if (_xx_util2.default.hideAll(), 0 == t.errno) _xx_util2.default.showSuccess("核销成功"), 
                    setTimeout(function() {
                        a.setData({
                            showCheck: !1
                        });
                    }, 2e3); else if (-1 == t.errno) {
                        var e = t.message;
                        "pwd error" == e && (e = "密码输入错误！"), "can not write off this order" == e && (e = "此单已核销！"), 
                        _xx_util2.default.showFail(e);
                    } else _xx_util2.default.showToast("fail", "核销失败");
                }));
            }
        });
    },
    formSubmit: function(t) {
        var a = this, e = t.detail.formId;
        _index.baseModel.getFormId({
            formId: e
        });
        var o = _xx_util2.default.getFormData(t), s = o.status;
        o.index;
        "toJumpUrl" == s && _xx_util2.default.goUrl(t, !0), "toShowCheck" == s && wx.scanCode({
            success: function(t) {
                var e = JSON.parse(t.result).order_id;
                a.setData({
                    order_id: e,
                    showCheck: !0
                });
            }
        });
    }
});