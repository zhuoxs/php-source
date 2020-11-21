var t = getApp();

Page({
    data: {
        logintag: "",
        info: "",
        truename: "",
        gender: "",
        mobile: "",
        wx: "",
        province: "",
        city: "",
        country: "",
        getmsg: "获取验证码",
        sendmsg: "sendmsg",
        veri_code: ""
    },
    onLoad: function(t) {
        var e = this;
        try {
            var o = wx.getStorageSync("session");
            o && (console.log("logintag:", o), e.setData({
                logintag: o
            }));
        } catch (t) {}
        e.show();
    },
    show: function(e) {
        var o = this, n = o.data.logintag;
        wx.request({
            url: t.data.url + "showpersoninfo",
            data: {
                logintag: n
            },
            header: {
                "content-type": "application/x-www-form-urlencoded"
            },
            success: function(t) {
                if (console.log("showpersoninfo => 获取用户的基本信息"), console.log(t), "0000" == t.data.retCode) {
                    var e = t.data.info;
                    o.setData({
                        info: e,
                        province: e.province,
                        city: e.city,
                        country: e.country,
                        truename: e.truename,
                        gender: e.gender,
                        mobile: e.mobile,
                        wx: e.wx
                    });
                } else wx.showToast({
                    title: "获取数据失败",
                    icon: "none",
                    duration: 800
                });
            }
        });
    },
    truename: function(t) {
        this.setData({
            truename: t.detail.value
        });
    },
    gender: function(t) {
        var e = this;
        console.log(t), e.setData({
            gender: t.detail.value
        });
    },
    mobile: function(t) {
        var e = this;
        console.log(t), e.setData({
            mobile: t.detail.value
        });
    },
    veri_code: function(t) {
        var e = this;
        console.log(t), e.setData({
            veri_code: t.detail.value
        });
    },
    wx: function(t) {
        var e = this;
        console.log(t), e.setData({
            wx: t.detail.value
        });
    },
    bindRegionChange: function(t) {
        this.setData({
            province: t.detail.value[0],
            city: t.detail.value[1],
            country: t.detail.value[2]
        });
    },
    preserve: function(e) {
        console.log(e);
        var o = this, n = o.data.logintag, a = o.data.mobile, i = o.data.province, s = o.data.city, r = o.data.country, c = o.data.gender, l = o.data.wx, d = o.data.truename, u = o.data.veri_code;
        "" != d ? "0" != c ? "" != a ? "" != l ? "" != i ? "" != u ? wx.request({
            url: t.data.url + "modipersoninfo",
            data: {
                logintag: n,
                mobile: a,
                province: i,
                city: s,
                country: r,
                gender: c,
                wx: l,
                truename: d,
                smscode: u
            },
            header: {
                "content-type": "application/x-www-form-urlencoded"
            },
            success: function(t) {
                console.log("modipersoninfo => 提交用户的基本信息"), console.log(t), "0000" == t.data.retCode ? (wx.showToast({
                    title: t.data.retDesc,
                    icon: "none",
                    duration: 1e3
                }), setTimeout(function() {
                    console.log("延迟调用 => 返回上一页"), wx.navigateBack({
                        delta: 1,
                        success: function(t) {
                            var e = getCurrentPages().pop();
                            void 0 != e && null != e && e.onLoad();
                        }
                    });
                }, 1e3)) : wx.showToast({
                    title: t.data.retDesc,
                    icon: "none",
                    duration: 1500
                });
            }
        }) : wx.showToast({
            title: "验证码未填写",
            icon: "none",
            duration: 1e3
        }) : wx.showToast({
            title: "省份城市未选择",
            icon: "none",
            duration: 1e3
        }) : wx.showToast({
            title: "微信号未填写",
            icon: "none",
            duration: 1e3
        }) : wx.showToast({
            title: "手机号码未填写",
            icon: "none",
            duration: 1e3
        }) : wx.showToast({
            title: "性别未勾选",
            icon: "none",
            duration: 1e3
        }) : wx.showToast({
            title: "姓名未填写",
            icon: "none",
            duration: 1e3
        });
    },
    sendmessg: function(t) {
        var e = this, o = e.data.mobile;
        if (o) {
            if (!/^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1})|(17[0-9]{1}))+\d{8})$/.test(o)) return wx.showToast({
                title: "手机号有误！",
                icon: "none",
                duration: 1e3
            }), !1;
            var n = 1;
            if (1 == n) {
                n = 0;
                var a = 60;
                (e = this).setData({
                    sendmsg: "sendmsgafter"
                });
                var i = setInterval(function() {
                    e.setData({
                        getmsg: a + "s后重新发送"
                    }), --a < 0 && (n = 1, clearInterval(i), e.setData({
                        sendmsg: "sendmsg",
                        getmsg: "获取验证码"
                    }));
                }, 1e3);
            }
            e.bindright(t);
        } else wx.showToast({
            title: "手机号码不能为空",
            icon: "none",
            duration: 1e3
        });
    },
    bindright: function(e) {
        var o = this, n = o.data.logintag, a = o.data.mobile, i = Math.random().toString(36).substr(2, 15);
        wx.request({
            url: t.data.url + "getsms",
            data: {
                mobile: a,
                data: i,
                logintag: n
            },
            header: {
                "content-type": "application/x-www-form-urlencoded"
            },
            method: "GET",
            success: function(t) {
                console.log("getsms => 发送短信息给用户"), console.log(t), t.data.retCode, wx.showToast({
                    title: t.data.retDesc,
                    icon: "none",
                    duration: 800
                });
            }
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