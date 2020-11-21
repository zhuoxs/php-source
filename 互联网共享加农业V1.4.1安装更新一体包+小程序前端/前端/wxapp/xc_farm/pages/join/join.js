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
        seccount: 60,
        bind: !0
    },
    input: function(e) {
        this.setData({
            mobile: e.detail.value
        });
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
        this.data.bind ? t.bind = 1 : t.bind = -1, t.op = "join", app.util.request({
            url: "entry/wxapp/user",
            method: "POST",
            data: t,
            success: function(e) {
                if ("" != e.data.data) {
                    wx.showToast({
                        title: "注册成功",
                        icon: "success",
                        duration: 2e3
                    });
                    var a = app.userinfo;
                    a.bind = 1, a.name = t.name, a.mobile = t.phone, app.userinfo = a, setTimeout(function() {
                        wx.navigateBack({
                            delta: 2
                        });
                    }, 2e3);
                }
            }
        });
    },
    sendFunc: function() {
        var t = this, e = t.data.mobile;
        if ("" != e && null != e && /^1[34578]\d{9}$/.test(e)) {
            var n = "";
            t.data.sending || app.util.request({
                url: "entry/wxapp/sendcode",
                method: "POST",
                data: {
                    op: "mobile",
                    mobile: e
                },
                success: function(e) {
                    var a = e.data;
                    "" != a.data && 1 == a.data.status && (t.setData({
                        sending: !0
                    }), n = setInterval(function() {
                        var e = t.data.seccount;
                        0 == --e ? (clearInterval(n), t.setData({
                            sending: !1
                        })) : t.setData({
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
                var a = e.data;
                "" != a.data && n.setData({
                    sms: a.data
                });
            },
            complete: function(e) {
                var a = {
                    name: {
                        required: !0
                    },
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
                }, t = {
                    name: {
                        required: "请输入姓名"
                    },
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
                1 == n.data.sms.status && (a.code = {
                    required: !0
                }, t.code = {
                    required: "请输入验证码"
                }), Validate = new _WxValidate2.default(a, t);
            }
        });
    }
});