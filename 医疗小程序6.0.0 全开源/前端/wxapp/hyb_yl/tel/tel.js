var app = getApp();

Page({
    data: {
        send: !1,
        alreadySend: !1,
        second: 60,
        disabled: !0,
        buttonType: "default",
        phoneNum: "",
        code: "",
        smscode: "",
        otherInfo: ""
    },
    onLoad: function() {
        var t = wx.getStorageSync("color");
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: t
        });
        var e = this, o = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/Myphone",
            data: {
                openid: o
            },
            success: function(t) {
                console.log(t), e.setData({
                    myphone: t.data.data
                });
            },
            fail: function(t) {
                console.log(t);
            }
        });
    },
    inputPhoneNum: function(t) {
        var e = t.detail.value;
        11 === e.length ? this.checkPhoneNum(e) && (this.setData({
            phoneNum: e
        }), console.log("phoneNum" + this.data.phoneNum), this.showSendMsg(), this.activeButton()) : (this.setData({
            phoneNum: ""
        }), this.hideSendMsg());
    },
    checkPhoneNum: function(t) {
        return !!/^1\d{10}$/.test(t) || (wx.showToast({
            title: "手机号不正确",
            image: "../images/error.png"
        }), !1);
    },
    showSendMsg: function() {
        this.data.alreadySend || this.setData({
            send: !0
        });
    },
    hideSendMsg: function() {
        this.setData({
            send: !1,
            disabled: !0,
            buttonType: "default"
        });
    },
    sendMsg: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/SendSms",
            data: {
                phoneNum: this.data.phoneNum
            },
            header: {
                "content-type": "application/json"
            },
            success: function(t) {
                console.log(t), e.setData({
                    smscode: t.data.data
                });
            }
        }), this.setData({
            alreadySend: !0,
            send: !1
        }), this.timer();
    },
    timer: function() {
        var n = this;
        new Promise(function(t, e) {
            var o = setInterval(function() {
                n.setData({
                    second: n.data.second - 1
                }), n.data.second <= 0 && (n.setData({
                    second: 60,
                    alreadySend: !1,
                    send: !0
                }), t(o));
            }, 1e3);
        }).then(function(t) {
            clearInterval(t);
        });
    },
    addOtherInfo: function(t) {
        console.log(t), this.setData({
            otherInfo: t.detail.value
        }), this.activeButton(), console.log("otherInfo: " + this.data.otherInfo);
    },
    addCode: function(t) {
        console.log(t), this.setData({
            code: t.detail.value
        }), this.activeButton(), console.log("code" + this.data.code);
    },
    activeButton: function() {
        var t = this.data, e = t.phoneNum, o = t.code, n = t.otherInfo;
        console.log(n), e && o && n ? this.setData({
            disabled: !1,
            buttonType: "primary"
        }) : this.setData({
            disabled: !0,
            buttonType: "default"
        });
    },
    onSubmit: function(t) {
        var e = wx.getStorageSync("openid"), o = this.data.phoneNum, n = parseInt(this.data.code), a = this.data.smscode;
        console.log(a), "" == a || n != a ? wx.showToast({
            title: "验证失败",
            icon: "error"
        }) : app.util.request({
            url: "entry/wxapp/Savemyphone",
            data: {
                u_phone: o,
                openid: e
            },
            header: {
                "content-type": "application/json"
            },
            success: function(t) {
                console.log(t), wx.showToast({
                    title: "保存成功",
                    icon: "success",
                    success: function(t) {
                        wx.redirectTo({
                            url: "/hyb_yl/my/my"
                        });
                    }
                });
            },
            fail: function(t) {
                console.log(t);
            }
        });
    }
});