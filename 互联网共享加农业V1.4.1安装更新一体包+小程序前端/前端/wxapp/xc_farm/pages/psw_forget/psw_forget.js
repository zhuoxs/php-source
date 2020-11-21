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
        sending: !1,
        seccount: 60
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
        t.op = "info_edit", app.util.request({
            url: "entry/wxapp/user",
            method: "POST",
            data: t,
            success: function(e) {
                "" != e.data.data && (wx.showToast({
                    title: "修改成功",
                    icon: "success",
                    duration: 2e3
                }), setTimeout(function() {
                    wx.navigateBack({
                        delta: 1
                    });
                }, 2e3));
            }
        });
    },
    sendFunc: function() {
        var a = this, e = a.data.mobile;
        if ("" != e && null != e && /^1[34578]\d{9}$/.test(e)) {
            var n = "";
            a.data.sending || app.util.request({
                url: "entry/wxapp/sendcode",
                method: "POST",
                data: {
                    op: "mobile",
                    mobile: e
                },
                success: function(e) {
                    var t = e.data;
                    "" != t.data && 1 == t.data.status && (a.setData({
                        sending: !0
                    }), n = setInterval(function() {
                        var e = a.data.seccount;
                        0 == --e ? (clearInterval(n), a.setData({
                            sending: !1
                        })) : a.setData({
                            seccount: e
                        });
                    }, 1e3));
                }
            });
        } else wx.showModal({
            title: "错误",
            content: "请输入正确的手机号"
        });
    },
    onLoad: function(e) {
        var n = this;
        common.config(n), app.util.request({
            url: "entry/wxapp/user",
            method: "POST",
            data: {
                op: "sms"
            },
            success: function(e) {
                var t = e.data;
                "" != t.data && n.setData({
                    sms: t.data,
                    mobile: app.userinfo.mobile
                });
            },
            complete: function(e) {
                var t = {
                    phone: {
                        required: !0,
                        tel: !0
                    },
                    password: {
                        required: !0,
                        minlength: 6
                    },
                    password2: {
                        required: !0,
                        equalTo: "password",
                        minlength: 6
                    }
                }, a = {
                    phone: {
                        required: "请输入手机号码",
                        tel: "请输入正确的手机号码"
                    },
                    password: {
                        required: "请输入密码",
                        minlength: "密码至少六位"
                    },
                    password2: {
                        required: "请再次输入密码",
                        equalTo: "两次输入的密码不一致",
                        minlength: "密码至少六位"
                    }
                };
                1 == n.data.sms.status && (t.code = {
                    required: !0
                }, a.code = {
                    required: "请输入验证码"
                }), Validate = new _WxValidate2.default(t, a);
            }
        });
    }
});