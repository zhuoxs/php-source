var e = getApp(), t = e.requirejs("core"), i = e.requirejs("foxui"), a = e.requirejs("jquery");

Page({
    data: {
        member: {},
        binded: !1,
        endtime: 0,
        postData: {},
        submit: !1,
        subtext: "立即绑定",
        smsimgcode: "",
        verifycode_img: ""
    },
    onLoad: function(i) {
        e.url(i), t.loading(), this.getInfo();
    },
    getInfo: function() {
        var e, i = this;
        t.get("member/bind", {}, function(t) {
            if (t.error) wx.redirectTo({
                url: "/pages/member/index/index"
            }); else {
                var a = {
                    member: t.member,
                    binded: t.binded,
                    endtime: t.endtime,
                    show: !0,
                    smsimgcode: t.smsimgcode,
                    verifycode_img: t.verifycode_img
                };
                a.postData = {
                    mobile: t.member.mobile,
                    code: "",
                    password: "",
                    password1: ""
                }, i.setData(a), t.endtime > 0 && i.endTime(), e = t.binded ? "更换绑定手机号" : "绑定手机号", 
                wx.setNavigationBarTitle({
                    title: e
                });
            }
        }, !0, !0, !0);
    },
    endTime: function() {
        var e = this, t = e.data.endtime;
        if (t > 0) {
            e.setData({
                endtime: t - 1
            });
            setTimeout(function() {
                e.endTime();
            }, 1e3);
        }
    },
    inputChange: function(e) {
        var i = this.data.postData, s = t.pdata(e).type, o = e.detail.value;
        i[s] = a.trim(o), this.setData({
            postData: i
        });
    },
    getCode: function(e) {
        var s = this;
        if (!(s.data.endtime > 0)) {
            var o = s.data.postData.mobile;
            if (a.isMobile(o)) {
                if (1 == s.data.smsimgcode) {
                    var m = s.data.postData.verifyImg;
                    if (void 0 == m) return void i.toast(s, "请填写图形验证码");
                }
                t.get("sms/changemobile", {
                    mobile: o,
                    verifyImgCode: m,
                    smsimgcode: s.data.smsimgcode
                }, function(e) {
                    0 == e.error ? (i.toast(s, "短信发送成功"), s.setData({
                        endtime: 60
                    }), s.endTime()) : i.toast(s, e.message);
                }, !0, !0, !0);
            } else i.toast(s, "请填写正确的手机号");
        }
    },
    submit: function(e) {
        if (!this.data.submit) {
            var s = this, o = this.data.postData;
            a.isMobile(o.mobile) ? 5 == o.code.length ? o.password && "" != o.password ? o.password1 && "" != o.password1 ? o.password == o.password1 ? (this.setData({
                submit: !0,
                subtext: "正在绑定..."
            }), t.post("member/bind/submit", o, function(e) {
                if (92001 != e.error && 92002 != e.error) return 0 != e.error ? (i.toast(s, e.message), 
                void s.setData({
                    submit: !1,
                    subtext: "立即绑定"
                })) : void wx.navigateBack();
                t.confirm(e.message, function() {
                    o.confirm = 1, t.post("member/bind/submit", o, function(e) {
                        e.error > 0 ? i.toast(s, e.message) : wx.navigateBack(), s.setData({
                            submit: !1,
                            subtext: "立即绑定",
                            "postData.confirm": 0
                        });
                    }, !0, !0, !0);
                });
            }, !0, !0, !0)) : i.toast(this, "两次输入的密码不一致") : i.toast(this, "请确认登录密码") : i.toast(this, "请填写登录密码") : i.toast(this, "请填写5位短信验证码") : i.toast(this, "请填写正确的手机号");
        }
    },
    imageChange: function() {
        var e = this;
        t.get("member/bind/imageChange", {}, function(t) {
            e.setData({
                verifycode_img: t.verifycode_img
            });
        });
    }
});