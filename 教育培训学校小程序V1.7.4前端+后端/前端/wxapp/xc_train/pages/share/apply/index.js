var a = getApp(), e = require("../../common/common.js"), t = require("../../../../wxParse/wxParse.js");

Page({
    data: {
        agree: !0,
        isLoading: !1,
        mobile: "",
        sms_text: "获取"
    },
    pro_on: function() {
        this.setData({
            pro: !0
        });
    },
    pro_close: function() {
        this.setData({
            pro: !1
        });
    },
    agree_change: function() {
        var a = this;
        a.setData({
            agree: !a.data.agree
        });
    },
    input: function(a) {
        this.setData({
            mobile: a.detail.value
        });
    },
    sms_code: function() {
        var t = this, s = {
            mobile: t.data.mobile
        }, n = [ {
            name: "mobile",
            required: !0,
            required_msg: "请输入手机号",
            tel: !0,
            tel_msg: "请输入正确的手机号"
        } ];
        e.formCheck(s, n, t) && (t.data.isLoading || (t.setData({
            isLoading: !0
        }), s.op = "sms_code", a.util.request({
            url: "entry/wxapp/index",
            data: s,
            success: function(a) {
                wx.stopPullDownRefresh(), "" != a.data.data && (wx.showToast({
                    title: "发送成功"
                }), t.get_code());
            }
        })));
    },
    submit: function(t) {
        var s = this, n = t.detail.value, o = [ {
            name: "name",
            required: !0,
            required_msg: "请输入姓名"
        }, {
            name: "mobile",
            required: !0,
            required_msg: "请输入手机号",
            tel: !0,
            tel_msg: "请输入正确的手机号"
        }, {
            name: "code",
            required: !0,
            required_msg: "请输入验证码"
        } ], r = e.formCheck(n, o, s);
        r && (1 == s.data.agree ? (n.op = "share_apply", a.util.request({
            url: "entry/wxapp/index",
            data: n,
            success: function(a) {
                if ("" != a.data.data) {
                    wx.showToast({
                        title: "申请成功"
                    });
                    var e = s.data.share;
                    e.apply = {
                        status: -1
                    }, s.setData({
                        share: e
                    });
                }
            }
        })) : wx.showModal({
            title: "提示",
            content: "请同意",
            showCancel: !1
        }));
    },
    reload: function() {
        var e = this;
        a.util.request({
            url: "entry/wxapp/index",
            data: {
                op: "share_change"
            },
            success: function(a) {
                if (wx.stopPullDownRefresh(), "" != a.data.data) {
                    var t = e.data.share;
                    t.apply = "", e.setData({
                        share: t
                    });
                }
            }
        });
    },
    onLoad: function(a) {
        var t = this;
        e.config(t), e.theme(t), t.getData();
    },
    onReady: function() {},
    onShow: function() {
        e.audio_end(this);
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        this.getData();
    },
    onReachBottom: function() {},
    getData: function() {
        var e = this;
        a.util.request({
            url: "entry/wxapp/user",
            data: {
                op: "user"
            },
            success: function(a) {
                wx.stopPullDownRefresh();
                var s = a.data;
                if ("" != s.data && "" != s.data.share && null != s.data.share && (e.setData({
                    share: s.data.share
                }), "" != s.data.share.pro_content && null != s.data.share.pro_content)) t.wxParse("article", "html", s.data.share.pro_content, e, 0);
            }
        });
    },
    get_code: function() {
        var a = this, e = 60, t = setInterval(function() {
            (e -= 1) > 0 ? a.setData({
                sms_text: "(" + e + "s)"
            }) : (clearInterval(t), a.setData({
                isLoading: !0,
                sms_text: "获取"
            }));
        }, 1e3);
    }
});