function t(t, a) {
    var e = new RegExp("(^|&)" + a + "=([^&]*)(&|$)"), r = t.split("?")[1].match(e);
    return null != r ? unescape(r[2]) : null;
}

var a = getApp(), e = require("../../common/common.js"), r = require("../../../../wxParse/wxParse.js");

Page({
    data: {
        type: 1,
        withdraw_start: .01,
        isLoading: !1
    },
    tab: function(t) {
        var a = this, e = t.currentTarget.dataset.index;
        e != a.data.type && a.setData({
            type: e
        });
    },
    upload: function() {
        var e = this, r = "entry/wxapp/shareUpload";
        -1 == r.indexOf("http://") && -1 == r.indexOf("https://") && (r = a.util.url(r));
        var n = wx.getStorageSync("userInfo").sessionid;
        !t(r, "state") && n && (r = r + "&state=we7sid-" + n), r = r + "&state=we7sid-" + n;
        var s = getCurrentPages();
        s.length && (s = s[getCurrentPages().length - 1]) && s.__route__ && (r = r + "&m=" + s.__route__.split("/")[0]), 
        wx.chooseImage({
            count: 1,
            success: function(t) {
                var a = t.tempFilePaths;
                wx.uploadFile({
                    url: r,
                    filePath: a[0],
                    name: "file",
                    formData: {
                        user: "test"
                    },
                    success: function(t) {
                        var a = JSON.parse(t.data);
                        e.setData({
                            code: a.data.code,
                            share_code: a.data.share_code
                        });
                    }
                });
            }
        });
    },
    step_on: function() {
        var t = this;
        1 == t.data.type ? t.setData({
            step2: !0
        }) : 2 == t.data.type && t.setData({
            step1: !0
        });
    },
    step_close: function() {
        this.setData({
            step1: !1,
            step2: !1
        });
    },
    submit: function(t) {
        var r = this, n = t.detail.value, s = [];
        s = [ {
            name: "xc[type]",
            required: !0,
            required_msg: "请选择账户类型"
        }, {
            name: "xc[username]",
            required: !0,
            required_msg: "请输入账号"
        }, {
            name: "xc[name]",
            required: !0,
            required_msg: "请输入姓名"
        }, {
            name: "xc[mobile]",
            required: !0,
            required_msg: "请输入手机号码",
            tel: !0,
            tel_msg: "请输入正确的手机号码"
        }, {
            name: "xc[amount]",
            required: !0,
            required_msg: "请输入提现金额",
            gt: r.data.withdraw_start,
            gt_msg: "提现金额不能少于" + r.data.withdraw_start,
            lt: r.data.share.user.share_fee,
            lt_msg: "余额不足"
        }, {
            name: "xc[code]",
            required: !0,
            required_msg: "请上传收款码"
        } ];
        var i = e.formCheck(n, s, r);
        i && !r.data.isLoading && (r.setData({
            isLoading: !0
        }), n.op = "share_withdraw", "" != r.data.area_list && null != r.data.area_list && (n.area_code = r.data.area_code[r.data.index].id), 
        a.util.request({
            url: "entry/wxapp/index",
            method: "POST",
            data: n,
            success: function(t) {
                "" != t.data.data && (wx.showToast({
                    title: "提交成功"
                }), setTimeout(function() {
                    wx.navigateBack({
                        delta: 1
                    });
                }, 2e3));
            },
            complete: function() {
                r.setData({
                    isLoading: !1
                });
            }
        }));
    },
    onLoad: function(t) {
        var a = this;
        e.config(a), e.theme(a), a.getData();
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
        var t = this;
        a.util.request({
            url: "entry/wxapp/index",
            data: {
                op: "share_config"
            },
            success: function(a) {
                wx.stopPullDownRefresh();
                var e = a.data;
                "" != e.data && (t.setData({
                    share: e.data
                }), "" != e.data.withdraw_content && null != e.data.withdraw_content && r.wxParse("article", "html", e.data.withdraw_content, t, 5), 
                "" != e.data.withdraw_limit && null != e.data.withdraw_limit && t.setData({
                    withdraw_start: e.data.withdraw_limit
                }));
            }
        });
    }
});