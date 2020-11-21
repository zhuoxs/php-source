var e, t = function(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}(require("../../util/request.js")), n = getApp(), o = 60, a = !0;

Page({
    data: {
        getcodetip: "获取验证码",
        realname: "",
        mobile: "",
        code: "",
        idnumber: ""
    },
    realnameConfirm: function(e) {
        this.setData({
            realname: e.detail.value
        });
    },
    mobileConfirm: function(e) {
        this.setData({
            mobile: e.detail.value
        });
    },
    codeConfirm: function(e) {
        this.setData({
            code: e.detail.value
        });
    },
    idnumberConfirm: function(e) {
        this.setData({
            idnumber: e.detail.value
        });
    },
    funTime: function() {
        var t = this;
        e = setInterval(function() {
            o--, t.setData({
                getcodetip: o + "s后重新获取"
            }), o <= 0 && (clearInterval(e), o = 60, a = !0, t.setData({
                getcodetip: "获取验证码"
            }));
        }, 1e3);
    },
    getCode: function(e) {
        var n = this, o = n.data.mobile;
        if (/^1[34578]\d{9}$/.test(o)) {
            if (a) {
                a = !1;
                t.default.get("login", {
                    op: "getcode",
                    mobile: o
                }).then(function(e) {
                    n.setData({
                        getcodetip: "60s后重新获取"
                    }), n.funTime();
                }, function(e) {
                    wx.showModal({
                        title: "提示",
                        content: e,
                        showCancel: !1,
                        success: function(e) {}
                    }), console.log(e);
                });
            }
        } else wx.showModal({
            title: "提示",
            content: "输入的手机号格式不正确！",
            showCancel: !1,
            success: function(e) {}
        });
    },
    updateUserInfo: function(e) {
        var o = this;
        n.util.getUserInfo(function(e) {
            var n = o.data.realname;
            if (0 != n.length) {
                var a = o.data.param, i = "";
                if (1 != a.loginmobile && 2 != a.loginmobile || 0 != (i = o.data.mobile).length) {
                    var l = "";
                    if (2 != a.loginmobile || 0 != (l = o.data.code).length) {
                        var s = "";
                        if (1 != a.loginidnumber || 0 != (s = o.data.idnumber).length) {
                            var c = e.wxInfo.nickName, u = e.wxInfo.avatarUrl;
                            t.default.post("login", {
                                op: "post",
                                realname: n,
                                mobile: i,
                                code: l,
                                idnumber: s,
                                nickname: c,
                                headimgurl: u
                            }).then(function(e) {
                                wx.reLaunch({
                                    url: "../home/home"
                                });
                            }, function(e) {
                                wx.showModal({
                                    title: "提示",
                                    content: e,
                                    showCancel: !1,
                                    success: function(e) {}
                                });
                            });
                        } else wx.showModal({
                            title: "提示",
                            content: "身份证号不能为空！",
                            showCancel: !1,
                            success: function(e) {}
                        });
                    } else wx.showModal({
                        title: "提示",
                        content: "验证码不能为空！",
                        showCancel: !1,
                        success: function(e) {}
                    });
                } else wx.showModal({
                    title: "提示",
                    content: "手机号不能为空！",
                    showCancel: !1,
                    success: function(e) {}
                });
            } else wx.showModal({
                title: "提示",
                content: "姓名不能为空！",
                showCancel: !1,
                success: function(e) {}
            });
        }, e.detail);
    },
    onLoad: function(e) {
        var n = this;
        null != (wx.getStorageSync("user") || null) && wx.redirectTo({
            url: "../home/home"
        }), t.default.get("login").then(function(e) {
            n.setData({
                param: e.param
            });
        }, function(e) {
            wx.showModal({
                title: "提示",
                content: e,
                showCancel: !1,
                success: function(e) {}
            }), console.log(e);
        });
    },
    onReady: function() {
        n.util.footer(this);
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        this.data.pindex = 1, this.getMore();
    },
    onReachBottom: function() {
        this.data.hasMore ? this.getMore() : wx.showToast({
            title: "没有更多数据"
        });
    },
    onShareAppMessage: function() {
        var e = this;
        return {
            title: e.data.param.wxappsharetitle,
            path: "/vlinke_cparty/pages/home/home",
            imageUrl: e.data.param.wxappshareimageurl
        };
    }
});