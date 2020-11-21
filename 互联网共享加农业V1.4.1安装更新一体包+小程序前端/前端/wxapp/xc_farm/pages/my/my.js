var common = require("../common/common.js"), app = getApp();

function sign(t) {
    var a = t.data.name, e = t.data.mobile, n = (t.data.code, "");
    "" != e && null != e || (n = "请输入手机号"), "" != a && null != a || (n = "请输入姓名"), "" == n ? t.setData({
        submit: !0
    }) : wx.showModal({
        title: "错误",
        content: n,
        showCancel: !1
    });
}

Page({
    data: {
        navHref: "../my/my",
        sending: !1,
        seccount: 60,
        submit: !1
    },
    set: function() {
        wx.navigateTo({
            url: "../psw_forget/psw_forget"
        });
    },
    input: function(t) {
        var a = this, e = t.currentTarget.dataset.name, n = t.detail.value;
        switch (e) {
          case "name":
            a.setData({
                name: n
            });
            break;

          case "mobile":
            a.setData({
                mobile: n
            });
            break;

          case "code":
            a.setData({
                code: n
            });
        }
    },
    sendFunc: function() {
        var e = this, t = e.data.mobile;
        if ("" != t && null != t && /^1[34578]\d{9}$/.test(t)) {
            var n = "";
            e.data.sending || app.util.request({
                url: "entry/wxapp/sendcode",
                method: "POST",
                data: {
                    op: "mobile",
                    mobile: t
                },
                success: function(t) {
                    var a = t.data;
                    "" != a.data && 1 == a.data.status && (e.setData({
                        sending: !0
                    }), n = setInterval(function() {
                        var t = e.data.seccount;
                        0 == --t ? (clearInterval(n), e.setData({
                            sending: !1
                        })) : e.setData({
                            seccount: t
                        });
                    }, 1e3));
                }
            });
        } else wx.showModal({
            title: "错误",
            content: "请输入正确的手机号"
        });
    },
    yin_on: function() {
        this.setData({
            yin: !0
        });
    },
    yin_close: function() {
        this.setData({
            yin: !1
        });
    },
    submit: function() {
        var e = this;
        sign(e), e.data.submit && app.util.request({
            url: "entry/wxapp/user",
            method: "POST",
            data: {
                op: "join",
                name: e.data.name,
                mobile: e.data.mobile,
                bind: 1
            },
            success: function(t) {
                "" != t.data.data && (wx.showToast({
                    title: "提交成功",
                    icon: "success",
                    duration: 2e3
                }), e.setData({
                    yin: !1
                }), app.util.request({
                    url: "entry/wxapp/user",
                    method: "POST",
                    data: {
                        op: "user"
                    },
                    success: function(t) {
                        var a = t.data;
                        "" != a.data && e.setData({
                            xc: a.data
                        });
                    }
                }));
            }
        });
    },
    getPhoneNumber: function(t) {
        var e = this;
        app.util.request({
            url: "entry/wxapp/user",
            method: "POST",
            data: {
                op: "getphone",
                encryptedData: t.detail.encryptedData,
                iv: t.detail.iv
            },
            success: function(t) {
                var a = t.data;
                "" != a.data && e.setData({
                    mobile: a.data.purePhoneNumber
                });
            }
        });
    },
    onLoad: function() {
        var e = this;
        common.config(e), common.is_bind(), app.util.request({
            url: "entry/wxapp/user",
            method: "POST",
            data: {
                op: "user"
            },
            success: function(t) {
                var a = t.data;
                "" != a.data && e.setData({
                    xc: a.data
                });
            }
        });
    },
    onPullDownRefresh: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/user",
            method: "POST",
            data: {
                op: "user"
            },
            success: function(t) {
                wx.stopPullDownRefresh();
                var a = t.data;
                "" != a.data && e.setData({
                    xc: a.data
                });
            }
        });
    }
});