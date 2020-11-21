/*   time:2019-08-09 13:18:39*/
var app = getApp();
Page({
    data: {
        isShow: !0,
        distribution_set: [],
        promoter_data: [],
        payStyle: [],
        isclickpay: !1,
        payStyle_data: [{
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
        }]
    },
    onLoad: function(a) {
        var e = this;
        app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            showLoading: !1,
            success: function(a) {
                wx.setStorageSync("url", a.data);
                var t = a.data;
                e.setData({
                    url: t
                })
            }
        });
        var t = wx.getStorageSync("System");
        wx.setNavigationBarColor({
            frontColor: t.fontcolor ? t.fontcolor : "#000000",
            backgroundColor: t.color ? t.color : "#ffffff",
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        })
    },
    onReady: function() {
        var l = this,
            a = wx.getStorageSync("openid"),
            t = wx.getStorageSync("users");
        app.util.request({
            url: "entry/wxapp/Plugin",
            data: {
                type: 1
            },
            showLoading: !1,
            success: function(a) {
                var t = a.data;
                if (2 != t) {
                    var e = t.withdrawtype.split(","),
                        i = l.data.payStyle_data,
                        n = [],
                        o = 0;
                    for (var s in i) for (var c in e) i[s].id == e[c] && (n[o] = i[s], o++);
                    n.length <= 0 && (n[0] = i[0]), l.setData({
                        distribution_set: t,
                        payStyle: n
                    })
                }
            }
        }), app.util.request({
            url: "entry/wxapp/IsPromoter",
            data: {
                openid: a,
                uid: t.id,
                m: app.globalData.Plugin_distribution
            },
            showLoading: !1,
            success: function(a) {
                var t = a.data;
                l.setData({
                    promoter_data: t
                })
            }
        })
    },
    onShow: function() {},
    onReachBottom: function() {},
    checkboxChange: function(a) {
        this.setData({
            check: !this.data.check
        })
    },
    toggleRule: function(a) {
        this.setData({
            isShow: !this.data.isShow
        })
    },
    choosePay: function(a) {
        var t = a.currentTarget.dataset.index,
            e = a.currentTarget.dataset.name;
        this.setData({
            curIndex: t,
            payName: e
        })
    },
    formSubmit: function(a) {
        var t, e, i, n, o, s = this,
            c = !0,
            l = "",
            u = s.data.check,
            r = s.data.payName,
            d = a.detail.value.putForward,
            p = a.detail.formId;
        if (s.data.isclickpay) return console.log("多次点击pay"), wx.showToast({
            title: "请稍后...",
            icon: "none",
            duration: 2e3
        }), !1;
        if (s.setData({
            isclickpay: !0
        }), u ? d ? "wx" == r ? (e = t = "", i = a.detail.value.wx_uname, n = "", o = a.detail.value.wx_phone, "" == i ? l = "请填写您的名字" : "" == o ? l = "请输入正确的手机号码" : c = !1) : "zfb" == r ? (e = t = "", i = a.detail.value.zfb_uname, n = a.detail.value.zfb_account, o = a.detail.value.zfb_phone, "" == i ? l = "请填写支付宝账号认证的名字" : "" == n ? l = "请输入支付宝账号" : "" == o ? l = "请输入正确的手机号码" : c = !1) : "yhk" == r ? (t = a.detail.value.yhk_bname, e = a.detail.value.yhk_fbname, i = a.detail.value.yhk_uname, n = a.detail.value.yhk_account, o = a.detail.value.yhk_phone, "" == i ? l = "请填写持卡人名字" : "" == n ? l = "请输入银行卡号" : "" == o ? l = "请输入正确的手机号码" : "" == t ? l = "请输入银行名称" : "" == e ? l = "请输入支行名称" : c = !1) : "yue" == r ? (o = n = i = e = t = "", c = !1) : l = "请选择提现方式" : l = "请输入提现金额" : l = "请阅读提现须知", 1 == c) wx.showToast({
            title: l,
            icon: "none"
        }), s.setData({
            isclickpay: !1
        });
        else {
            var y = wx.getStorageSync("users"),
                h = wx.getStorageSync("openid");
            app.util.request({
                url: "entry/wxapp/SaveWithDraw",
                cachetime: "0",
                data: {
                    uid: y.id,
                    openid: h,
                    wd_type: {
                        wx: 1,
                        zfb: 2,
                        yhk: 3,
                        yue: 4
                    }[r],
                    money: d,
                    account: n,
                    uname: i,
                    phone: o,
                    bankname: t,
                    fbankname: e,
                    formid: p,
                    m: app.globalData.Plugin_distribution
                },
                success: function(a) {
                    wx.showModal({
                        title: "提示",
                        content: "提现提交成功",
                        showCancel: !1,
                        success: function(a) {
                            wx.navigateBack({
                                delta: 1
                            })
                        }
                    })
                },
                fail: function(a) {
                    s.setData({
                        isclickpay: !1
                    }), wx.showModal({
                        title: "提示",
                        content: a.data.message,
                        showCancel: !1,
                        success: function(a) {}
                    })
                }
            })
        }
    }
});