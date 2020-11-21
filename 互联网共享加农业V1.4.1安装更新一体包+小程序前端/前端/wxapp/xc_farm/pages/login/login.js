var _WxValidate = require("../../../utils/WxValidate.js"), _WxValidate2 = _interopRequireDefault(_WxValidate);

function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

var common = require("../common/common.js"), app = getApp(), Validate = "";

Page({
    data: {
        navHref: "",
        bind: !0
    },
    bind_change: function() {
        this.setData({
            bind: !this.data.bind
        });
    },
    formSubmit: function(e) {
        var t = e.detail.value;
        if (!Validate.checkForm(e)) {
            var a = Validate.errorList[0];
            return wx.showModal({
                title: "内容不符合要求",
                content: a.msg,
                showCancel: !1
            }), !1;
        }
        this.data.bind ? t.bind = 1 : t.bind = -1, t.op = "login", app.util.request({
            url: "entry/wxapp/user",
            method: "POST",
            data: t,
            success: function(e) {
                if ("" != e.data.data) {
                    wx.showToast({
                        title: "登录成功",
                        icon: "success",
                        duration: 2e3
                    });
                    var t = app.userinfo;
                    t.bind = 1, app.userinfo = t, setTimeout(function() {
                        wx.navigateBack({
                            delta: 1
                        });
                    }, 2e3);
                }
            }
        });
    },
    onLoad: function(e) {
        common.config(this);
        Validate = new _WxValidate2.default({
            phone: {
                required: !0,
                tel: !0
            },
            password: {
                required: !0,
                minlength: 6
            }
        }, {
            phone: {
                required: "请输入手机号码",
                tel: "请输入正确的手机号码"
            },
            password: {
                required: "请输入密码",
                minlength: "密码至少六位"
            }
        });
    },
    onPullDownRefresh: function() {
        wx.stopPullDownRefresh();
    }
});