var _request = require("../../util/request.js"), _request2 = _interopRequireDefault(_request);

function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

var funtime, app = getApp(), codetime = 60, codecan = !0;

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
        var e = this;
        funtime = setInterval(function() {
            codetime--, e.setData({
                getcodetip: codetime + "s后重新获取"
            }), codetime <= 0 && (clearInterval(funtime), codetime = 60, codecan = !0, e.setData({
                getcodetip: "获取验证码"
            }));
        }, 1e3);
    },
    getCode: function(e) {
        var t = this, n = t.data.mobile;
        if (/^1[34578]\d{9}$/.test(n)) {
            if (codecan) {
                codecan = !1;
                _request2.default.get("login", {
                    op: "getcode",
                    mobile: n
                }).then(function(e) {
                    t.setData({
                        getcodetip: "60s后重新获取"
                    }), t.funTime();
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
        var l = this;
        app.util.getUserInfo(function(e) {
            var t = l.data.realname;
            if (0 != t.length) {
                var n = l.data.param, o = "";
                if (1 != n.loginmobile && 2 != n.loginmobile || 0 != (o = l.data.mobile).length) {
                    var a = "";
                    if (2 != n.loginmobile || 0 != (a = l.data.code).length) {
                        var i = "";
                        if (1 != n.loginidnumber || 0 != (i = l.data.idnumber).length) {
                            var s = e.wxInfo.nickName, c = e.wxInfo.avatarUrl;
                            _request2.default.post("login", {
                                op: "post",
                                realname: t,
                                mobile: o,
                                code: a,
                                idnumber: i,
                                nickname: s,
                                headimgurl: c
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
        var t = this;
        null != (wx.getStorageSync("user") || null) && wx.redirectTo({
            url: "../home/home"
        }), _request2.default.get("login").then(function(e) {
            t.setData({
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
        app.util.footer(this);
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
        return {
            title: this.data.param.wxappsharetitle,
            path: "/vlinke_cparty/pages/home/home",
            imageUrl: this.data.param.wxappshareimageurl
        };
    }
});