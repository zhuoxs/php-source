var e = getApp();

Page({
    data: {
        getmsg: "获取验证码",
        sendmsg: "sendmsg",
        iphone: "",
        logintag: "",
        code: ""
    },
    onLoad: function(e) {
        var o = this;
        try {
            var t = wx.getStorageSync("session");
            t && (console.log("logintag:", t), o.setData({
                logintag: t
            }));
        } catch (e) {}
    },
    iphone: function(e) {
        var o = this;
        console.log(e.detail.value), o.setData({
            iphone: e.detail.value
        });
    },
    code: function(e) {
        var o = this;
        console.log(e.detail.value), o.setData({
            code: e.detail.value
        });
    },
    sendmessg: function(e) {
        var o = this, t = o.data.iphone;
        if (t) {
            if (!/^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1})|(17[0-9]{1}))+\d{8})$/.test(t)) return wx.showToast({
                title: "手机号有误！",
                icon: "none",
                duration: 1e3
            }), !1;
            var n = 1;
            if (1 == n) {
                n = 0;
                var a = 60;
                (o = this).setData({
                    sendmsg: "sendmsgafter"
                });
                var i = setInterval(function() {
                    o.setData({
                        getmsg: a + "s后重新发送"
                    }), --a < 0 && (n = 1, clearInterval(i), o.setData({
                        sendmsg: "sendmsg",
                        getmsg: "获取验证码"
                    }));
                }, 1e3);
            }
            o.bindright(e);
        } else wx.showToast({
            title: "手机号码不能为空",
            icon: "none",
            duration: 1e3
        });
    },
    bindright: function(o) {
        var t = this, n = t.data.logintag, a = t.data.iphone;
        wx.request({
            url: e.data.url + "member_binding_mobile_send_sms",
            data: {
                mobile: a,
                logintag: n
            },
            header: {
                "content-type": "application/x-www-form-urlencoded"
            },
            method: "GET",
            success: function(e) {
                console.log("getsms => 发送短信息给用户"), console.log(e), e.data.retCode, wx.showToast({
                    title: e.data.retDesc,
                    icon: "none",
                    duration: 800
                });
            }
        });
    },
    login: function(o) {
        var t = this;
        console.log(o.detail.formId);
        var n = o.detail.formId, a = t.data.iphone, i = t.data.code, s = t.data.logintag;
        "" != a ? "" != i ? wx.request({
            url: e.data.url + "member_perfect_mobile",
            data: {
                mobile: a,
                smscode: i,
                logintag: s,
                form_id: n
            },
            header: {
                "content-type": "application/x-www-form-urlencoded"
            },
            success: function(e) {
                console.log("会员完善手机号"), console.log(e), "0000" == e.data.retCode ? (wx.showToast({
                    title: e.data.retDesc,
                    icon: "none",
                    duration: 1e3
                }), setTimeout(function() {
                    console.log("延迟调用 => home"), wx.navigateBack({
                        delta: 1,
                        success: function(e) {
                            var o = getCurrentPages().pop();
                            void 0 != o && null != o && o.onLoad();
                        }
                    });
                }, 1e3)) : wx.showToast({
                    title: e.data.retDesc,
                    icon: "none",
                    duration: 1e3
                });
            }
        }) : wx.showToast({
            title: "验证码未填写",
            icon: "none",
            duration: 1e3
        }) : wx.showToast({
            title: "手机号码未填写",
            icon: "none",
            duration: 1e3
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});