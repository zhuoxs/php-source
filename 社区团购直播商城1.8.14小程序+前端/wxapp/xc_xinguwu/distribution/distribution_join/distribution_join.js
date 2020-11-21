var app = getApp(), WxParse = require("../../../wxParse/wxParse.js");

Page({
    data: {
        phone: "",
        again: !0,
        agree: !1,
        show: !1,
        getmsg: "获取验证码"
    },
    phone: function(t) {
        var e = t.detail.value;
        this.setData({
            phone: e
        });
    },
    toAgree: function() {
        this.setData({
            agree: !this.data.agree
        });
    },
    accept: function() {
        this.setData({
            agree: !0,
            show: !1
        });
    },
    close_show: function() {
        this.setData({
            show: !1
        });
    },
    sendmessg: function(t) {
        var e = this, a = 1;
        if (1 == a) {
            if ("" == this.data.phone) return void wx.showModal({
                title: "",
                content: "手机号不能为空",
                showCancel: !1
            });
            if (!/^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1})|(17[0-9]{1}))+\d{8})$/.test(this.data.phone)) return void wx.showModal({
                title: "",
                content: "手机号格式不正确",
                showCancel: !1
            });
            app.util.request({
                url: "entry/wxapp/distribution",
                showLoading: !1,
                data: {
                    op: "send_code",
                    phone: e.data.phone
                },
                success: function(t) {}
            }), a = 0;
            e = this;
            var o = 60, n = setInterval(function() {
                e.setData({
                    getmsg: o + "s后重试",
                    again: !1
                }), --o < 0 && (a = 1, clearInterval(n), e.setData({
                    getmsg: "获取验证码",
                    again: !0
                }));
            }, 1e3);
        }
    },
    getPhoneNumber: function(t) {
        var e = this;
        "getPhoneNumber:ok" == t.detail.errMsg && app.util.request({
            url: "entry/wxapp/supplier",
            showLoading: !0,
            method: "POST",
            data: {
                op: "getphone",
                iv: t.detail.iv,
                encryptedData: t.detail.encryptedData
            },
            success: function(t) {
                e.setData({
                    phone: t.data.data.phoneNumber
                });
            },
            fail: function(t) {
                wx.showModal({
                    title: "获取手机号码失败",
                    content: "获取手机号码失败",
                    showCancel: !1,
                    cancelText: "关闭"
                });
            }
        });
    },
    myfrom: function(t) {
        var e = this, a = t.detail.value, o = t.detail.formId;
        if (e.data.agree) {
            if ("" != a.name) {
                if ("" == a.wechat) wx.showModal({
                    title: "",
                    content: "请输入微信号",
                    showCancel: !1
                }); else {
                    if ("" == a.phone) return void wx.showModal({
                        title: "",
                        content: "手机号不能为空",
                        showCancel: !1
                    });
                    if (!/^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1})|(17[0-9]{1}))+\d{8})$/.test(a.phone)) return void wx.showModal({
                        title: "",
                        content: "手机号格式不正确",
                        showCancel: !1
                    });
                    if ("" == a.code && 1 == app.globalData.webset.distribution_sms_code) return void wx.showModal({
                        title: "",
                        content: "请输入验证码",
                        showCancel: !1
                    });
                }
                a.formid = o, app.util.request({
                    url: "entry/wxapp/distribution",
                    showLoading: !1,
                    data: {
                        op: "join",
                        value: a
                    },
                    success: function(t) {
                        1 == app.globalData.webset.distribution_audit ? wx.showModal({
                            title: "系统提示",
                            content: "你的申请已提交,请耐心等待管理员审核!",
                            showCancel: !1,
                            success: function() {
                                wx.reLaunch({
                                    url: "/xc_xinguwu/pages/user/user"
                                });
                            }
                        }) : e.setData({
                            hint: !0
                        });
                    }
                });
            } else wx.showModal({
                title: "",
                content: "请输入姓名",
                showCancel: !1
            });
        } else app.look.alert("请先仔细阅读协议内容");
    },
    sure: function() {
        wx.redirectTo({
            url: "../distribution/distribution"
        });
    },
    imageLoad: function(t) {
        var e = t.detail.width, a = 100 * t.detail.height / e;
        this.setData({
            bannerHeight: a
        });
    },
    show: function() {
        this.setData({
            show: !0
        });
    },
    onLoad: function(t) {
        var a = this;
        a.setData({
            distribution_sms_code: app.globalData.webset.distribution_sms_code,
            "goHome.blackhomeimg": app.globalData.blackhomeimg
        }), app.util.request({
            url: "entry/wxapp/distribution",
            showLoading: !1,
            data: {
                op: "distribution_join",
                userid: t.userid
            },
            success: function(t) {
                var e = t.data;
                e.data.ppt && a.setData({
                    ppt: e.data.ppt
                }), e.data.pageset && (app.look.istrue(e.data.pageset.page_title) && wx.setNavigationBarTitle({
                    title: e.data.pageset.page_title
                }), WxParse.wxParse("article", "html", e.data.pageset.contents, a, 20), WxParse.wxParse("article1", "html", e.data.pageset.deal_con, a, 0), 
                a.setData({
                    pageset: e.data.pageset
                }));
            }
        });
    },
    onReady: function() {
        app.look.navbar(this);
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});