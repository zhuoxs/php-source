var app = getApp();

Page({
    data: {
        isShow: !0,
        distribution_set: [],
        payStyle: [],
        promoter_data: [],
        payStyle_data: [ {
            id: 1,
            name: "wx",
            icon: "../../../../style/images/wxlogo.png",
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
        var e = this;
        app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            showLoading: !1,
            success: function(t) {
                wx.setStorageSync("url", t.data);
                var a = t.data;
                e.setData({
                    url: a
                });
            }
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
        var u = this, t = wx.getStorageSync("openid"), a = wx.getStorageSync("users");
        app.util.request({
            url: "entry/wxapp/Plugin",
            data: {
                type: 1
            },
            showLoading: !1,
            success: function(t) {
                var a = t.data;
                if (2 != a) {
                    var e = a.withdrawtype.split(","), o = u.data.payStyle_data, i = [], n = 0;
                    for (var r in o) for (var s in e) o[r].id == e[s] && (i[n] = o[r], n++);
                    i.length <= 0 && (i[0] = o[0]), u.setData({
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
                u.setData({
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
        var a, e, o, i = !0, n = "", r = this.data.check, s = this.data.payName, u = t.detail.value.putForward;
        if (r ? u ? "wx" == s ? (a = t.detail.value.wx_uname, e = "", o = t.detail.value.wx_phone, 
        "" == a ? n = "请填写您的名字" : "" == o ? n = "请输入正确的手机号码" : i = !1) : "zfb" == s ? (a = t.detail.value.zfb_uname, 
        e = t.detail.value.zfb_account, o = t.detail.value.zfb_phone, "" == a ? n = "请填写支付宝账号认证的名字" : "" == e ? n = "请输入支付宝账号" : "" == o ? n = "请输入正确的手机号码" : i = !1) : "yhk" == s ? (a = t.detail.value.yhk_uname, 
        e = t.detail.value.yhk_account, o = t.detail.value.yhk_phone, "" == a ? n = "请填写持卡人名字" : "" == e ? n = "请输入银行卡号" : "" == o ? n = "请输入正确的手机号码" : i = !1) : "yue" == s ? (o = e = a = "", 
        i = !1) : n = "请选择提现方式" : n = "请输入提现金额" : n = "请阅读提现须知", 1 == i) wx.showToast({
            title: n,
            icon: "none"
        }); else {
            var l = wx.getStorageSync("users"), c = wx.getStorageSync("openid"), d = t.detail.formId;
            app.util.request({
                url: "entry/wxapp/SaveWithDraw",
                cachetime: "0",
                data: {
                    uid: l.id,
                    openid: c,
                    wd_type: {
                        wx: 1,
                        zfb: 2,
                        yhk: 3,
                        yue: 4
                    }[s],
                    money: u,
                    account: e,
                    uname: a,
                    phone: o,
                    formid: d,
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
                }
            });
        }
    }
});