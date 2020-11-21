var app = getApp();

Page({
    data: {
        isShow: !0,
        distribution_set: [],
        promoter_data: [],
        payStyle: [],
        isclickpay: !1,
        payStyle_data: [ {
            id: 1,
            name: "wx",
            icon: "../../../../style/images/wx.png",
            title: "微信"
        }, {
            id: 2,
            name: "zfb",
            icon: "../../../../style/images/zfblogo.png",
            title: "支付宝"
        }, {
            id: 3,
            name: "yhk",
            icon: "../../../../style/images/yhlogo.png",
            title: "银行卡"
        }, {
            id: 4,
            name: "yue",
            icon: "../../../../style/images/yuelogo.png",
            title: "余额"
        } ]
    },
    onLoad: function(t) {
        this.setData({
            url: wx.getStorageInfoSync("root")
        });
        var a = wx.getStorageSync("System");
        wx.setNavigationBarColor({
            frontColor: a.fontcolor ? a.fontcolor : "#000000",
            backgroundColor: a.color ? a.color : "#ffffff",
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
    },
    onReady: function() {
        var l = this, t = wx.getStorageSync("openid"), a = wx.getStorageSync("users");
        app.util.request({
            url: "entry/wxapp/Plugin",
            data: {
                type: 1
            },
            showLoading: !1,
            success: function(t) {
                var a = t.data;
                if (2 != a) {
                    var e = a.withdrawtype.split(","), o = l.data.payStyle_data, i = [], n = 0;
                    for (var s in o) for (var c in e) o[s].id == e[c] && (i[n] = o[s], n++);
                    i.length <= 0 && (i[0] = o[0]), l.setData({
                        distribution_set: a,
                        payStyle: i
                    });
                }
            }
        }), app.util.request({
            url: "entry/wxapp/IsPromoter",
            data: {
                openid: t,
                uid: a.id,
                m: app.globalData.Plugin_distribution
            },
            showLoading: !1,
            success: function(t) {
                var a = t.data;
                l.setData({
                    promoter_data: a
                });
            }
        });
    },
    onShow: function() {},
    onReachBottom: function() {},
    checkboxChange: function(t) {
        this.setData({
            check: !this.data.check
        });
    },
    toggleRule: function(t) {
        this.setData({
            isShow: !this.data.isShow
        });
    },
    choosePay: function(t) {
        var a = t.currentTarget.dataset.index, e = t.currentTarget.dataset.name;
        this.setData({
            curIndex: a,
            payName: e
        });
    },
    formSubmit: function(t) {
        var a, e, o, i = this, n = !0, s = "", c = i.data.check, l = i.data.payName, u = t.detail.value.putForward, r = t.detail.formId;
        if (i.data.isclickpay) return console.log("多次点击pay"), wx.showToast({
            title: "请稍后...",
            icon: "none",
            duration: 2e3
        }), !1;
        if (i.setData({
            isclickpay: !0
        }), c ? u ? "wx" == l ? (a = t.detail.value.wx_uname, e = "", o = t.detail.value.wx_phone, 
        "" == a ? s = "请填写您的名字" : "" == o ? s = "请输入正确的手机号码" : n = !1) : "zfb" == l ? (a = t.detail.value.zfb_uname, 
        e = t.detail.value.zfb_account, o = t.detail.value.zfb_phone, "" == a ? s = "请填写支付宝账号认证的名字" : "" == e ? s = "请输入支付宝账号" : "" == o ? s = "请输入正确的手机号码" : n = !1) : "yhk" == l ? (a = t.detail.value.yhk_uname, 
        e = t.detail.value.yhk_account, o = t.detail.value.yhk_phone, "" == a ? s = "请填写持卡人名字" : "" == e ? s = "请输入银行卡号" : "" == o ? s = "请输入正确的手机号码" : n = !1) : "yue" == l ? (o = e = a = "", 
        n = !1) : s = "请选择提现方式" : s = "请输入提现金额" : s = "请阅读提现须知", 1 == n) wx.showToast({
            title: s,
            icon: "none"
        }), i.setData({
            isclickpay: !1
        }); else {
            var d = wx.getStorageSync("users"), p = wx.getStorageSync("openid");
            app.util.request({
                url: "entry/wxapp/SaveWithDraw",
                cachetime: "0",
                data: {
                    uid: d.id,
                    openid: p,
                    wd_type: {
                        wx: 1,
                        zfb: 2,
                        yhk: 3,
                        yue: 4
                    }[l],
                    money: u,
                    account: e,
                    uname: a,
                    phone: o,
                    formid: r,
                    m: app.globalData.Plugin_distribution
                },
                success: function(t) {
                    wx.showModal({
                        title: "提示",
                        content: "提现提交成功",
                        showCancel: !1,
                        success: function(t) {
                            wx.navigateBack({
                                delta: 1
                            });
                        }
                    });
                },
                fail: function(t) {
                    i.setData({
                        isclickpay: !1
                    }), wx.showModal({
                        title: "提示",
                        content: t.data.message,
                        showCancel: !1,
                        success: function(t) {}
                    });
                }
            });
        }
    }
});