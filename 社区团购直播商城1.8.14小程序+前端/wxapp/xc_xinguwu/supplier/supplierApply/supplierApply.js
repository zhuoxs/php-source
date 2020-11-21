var app = getApp(), WxParse = require("../../../wxParse/wxParse.js");

Page({
    data: {
        phoneNum: "",
        codeNum: "",
        getmsg: "获取验证码",
        scene: -1,
        resubmit: !1,
        supcencer: !1,
        message: ""
    },
    phoneNum: function(e) {
        this.setData({
            phoneNum: e.detail.value
        });
    },
    getPhoneNumber: function(e) {
        var a = this;
        "getPhoneNumber:ok" == e.detail.errMsg && app.util.request({
            url: "entry/wxapp/supplier",
            showLoading: !0,
            method: "POST",
            data: {
                op: "getphone",
                iv: e.detail.iv,
                encryptedData: e.detail.encryptedData
            },
            success: function(e) {
                a.setData({
                    "suppliermodel.phone": e.data.data.phoneNumber
                });
            },
            fail: function(e) {
                wx.showModal({
                    title: "获取手机号码失败",
                    content: "获取手机号码失败",
                    showCancel: !1,
                    cancelText: "关闭"
                });
            }
        });
    },
    sendmessg: function(e) {
        var a = 1;
        if (1 == a) {
            if ("" == this.data.phoneNum) return void app.look.alert("手机号码不能为空");
            if (!/^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1})|(17[0-9]{1}))+\d{8})$/.test(this.data.phoneNum)) return void app.look.alert("手机号码格式不正确");
            var t = this;
            app.util.request({
                url: "entry/wxapp/supplier",
                showLoading: !1,
                data: {
                    op: "sendCode",
                    phone: t.data.phoneNum
                },
                success: function() {
                    console.log("发送成功");
                },
                fail: function() {
                    console.log("发送失败");
                }
            }), a = 0;
            var o = 60, n = setInterval(function() {
                t.setData({
                    getmsg: o + "s后重试",
                    sending: !0
                }), --o < 0 && (a = 1, clearInterval(n), t.setData({
                    getmsg: "获取验证码",
                    sending: !1
                }));
            }, 1e3);
        }
    },
    agreeMent: function() {
        this.setData({
            agree: !this.data.agree
        });
    },
    myAgree: function() {
        this.setData({
            agree: !0,
            agreement: !1
        });
    },
    showRule: function() {
        this.setData({
            agreement: !0
        });
    },
    wantThink: function() {
        this.setData({
            agreement: !1,
            agree: !1
        });
    },
    resubmit: function() {
        "3" == this.data.apply && this.setData({
            scene: 1
        });
    },
    myfrom: function(e) {
        var a = e.detail.value, t = [];
        if (t.push(e.detail.formId), "" != a.name) if ("" != a.wechat) if ("" != a.phone) if ("" != a.code) if (this.data.agree) {
            var o = this;
            app.util.request({
                url: "entry/wxapp/supplier",
                showLoading: !0,
                method: "POST",
                data: {
                    op: "applicationIn",
                    name: a.name,
                    wechat: a.wechat,
                    phone: a.phone,
                    formid: t.join(","),
                    code: a.code
                },
                success: function(e) {
                    o.setData({
                        meesage: "",
                        scene: 2,
                        apply: "2"
                    }), console.log("cccccccccc"), app.look.ok("等待管理员审核", function() {});
                }
            });
        } else app.util.message({
            title: "请先阅读入驻协议",
            type: "error"
        }); else app.look.alert("请输入验证码"); else app.look.alert("请输入你的手机号码"); else app.look.alert("请输入你的微信号"); else app.look.alert("请输入你的姓名");
    },
    onLoad: function(e) {
        var o = this;
        app.util.request({
            url: "entry/wxapp/supplier",
            showLoading: !1,
            method: "POST",
            data: {
                op: "supplierSet"
            },
            success: function(e) {
                console.log(e.data.data), WxParse.wxParse("article", "html", e.data.data.list.contents, o, 0);
                var a = e.data.data.suppliermodel, t = {
                    pageset: e.data.data.list,
                    suppliermodel: a
                };
                if (a) switch (t.scene = 2, t.apply = a.apply, console.log(a.apply), a.apply) {
                  case "1":
                    t.meesage = "恭喜您，您提交的审核管理员已通过";
                    break;

                  case "2":
                    t.meesage = "";
                    break;

                  case "3":
                  case "4":
                    t.meesage = a.remark;
                } else t.scene = 1;
                o.setData(t);
            }
        });
    },
    onReady: function() {
        app.look.goHome(this);
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});