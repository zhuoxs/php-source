var app = getApp();

Page({
    data: {
        ratesMoney: "0.00",
        putForward: "",
        minPut: "100",
        mode: [],
        list: [],
        check: !1,
        commissionMoney: "0.00",
        isShow: !0,
        is_modal_Hidden: !0,
        defaulttype: 0,
        index: 0,
        cangetMoney: "0.00"
    },
    onLoad: function(a) {
        var t = this;
        app.wxauthSetting(), wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("System").fontcolor,
            backgroundColor: wx.getStorageSync("System").color,
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
        var e = wx.getStorageSync("brand_info");
        app.util.request({
            url: "entry/wxapp/GetBrandMoney",
            cachetime: "0",
            data: {
                bid: e.bid
            },
            success: function(a) {
                console.log("获取要提现的数据"), console.log(a.data), t.setData({
                    list: a.data,
                    mode: a.data.wd_type,
                    defaulttype: a.data.wd_type[0].id
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        app.func.islogin(app, this);
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    toggleRule: function(a) {
        this.setData({
            isShow: !this.data.isShow
        });
    },
    cashAll: function(a) {
        var t, e = this, o = e.data.list, n = e.data.list.canuseamount, i = e.data.index, d = e.data.mode, s = (n * o.commission / 100).toFixed(2), c = ((100 * n - 100 * s - 100 * (t = ((100 * n - n * o.commission) / 100 * d[i].wd_rates / 100).toFixed(2))) / 100).toFixed(2);
        e.setData({
            putForward: n,
            commissionMoney: s,
            ratesMoney: t,
            cangetMoney: c
        });
    },
    bindPickerChange: function(a) {
        var t, e, o = this, n = o.data.list, i = o.data.mode, d = o.data.putForward, s = a.detail.value, c = o.data.commissionMoney ? o.data.commissionMoney : 0;
        e = d ? ((100 * d - 100 * c - 100 * (t = ((100 * d - d * n.commission) / 100 * i[s].wd_rates / 100).toFixed(2))) / 100).toFixed(2) : t = "0.00", 
        this.setData({
            defaulttype: i[s].id,
            index: s,
            ratesMoney: t,
            cangetMoney: e
        });
    },
    enterMmoney: function(a) {
        var t, e, o = this, n = o.data.list, i = a.detail.value, d = o.data.index, s = o.data.mode, c = 0;
        e = i ? ((100 * (i = parseInt(i)) - 100 * (c = (i * n.commission / 100).toFixed(2)) - 100 * (t = ((100 * i - i * n.commission) / 100 * s[d].wd_rates / 100).toFixed(2))) / 100).toFixed(2) : t = c = "0.00", 
        o.setData({
            putForward: i,
            commissionMoney: c,
            ratesMoney: t,
            cangetMoney: e
        });
    },
    checkboxChange: function(a) {
        this.setData({
            check: !this.data.check
        });
    },
    formSubmit: function(a) {
        var t, e, o, n, i, d = this, s = !0, c = "", l = d.data.putForward, u = d.data.check, r = d.data.index, m = d.data.mode, h = wx.getStorageSync("brand_info");
        if (u ? l ? 2 == m[r].id ? (e = t = "", o = a.detail.value.zfb_uname, n = a.detail.value.zfb_account, 
        i = a.detail.value.zfb_phone, "" == o ? c = "请填写您的名字" : "" == n ? c = "请输入支付宝账号" : s = !1) : 3 == m[r].id ? (console.log(a), 
        t = a.detail.value.yhk_bname, e = a.detail.value.yhk_fbname, o = a.detail.value.yhk_uname, 
        n = a.detail.value.yhk_account, i = a.detail.value.yhk_phone, "" == o ? c = "请填写您的名字" : "" == n ? c = "请输入银行卡号" : "" == t ? c = "请输入银行名称" : "" == e ? c = "请输入支行名称" : s = !1) : (e = t = "", 
        o = a.detail.value.wx_uname, n = "", i = a.detail.value.wx_phone, "" == o ? c = "请填写您的名字" : s = !1) : c = "请输入提现金额" : c = "请阅读提现须知", 
        1 == s) wx.showModal({
            title: "提示",
            content: c,
            showCancel: !1
        }); else {
            var p = wx.getStorageSync("openid");
            app.util.request({
                url: "entry/wxapp/SaveWithDraw",
                cachetime: "0",
                data: {
                    bid: h.bid,
                    openid: p,
                    wd_type: m[r].id,
                    money: l,
                    account: n,
                    uname: o,
                    phone: i,
                    bankname: t,
                    fbankname: e
                },
                success: function(a) {
                    console.log("提交数据"), console.log(a.data), wx.showModal({
                        title: "提示",
                        content: "提现提交成功",
                        showCancel: !1,
                        success: function(a) {
                            wx.redirectTo({
                                url: "/mzhk_sun/pages/backstage/index2/index2"
                            });
                        }
                    });
                }
            });
        }
    },
    updateUserInfo: function(a) {
        console.log("授权操作更新");
        app.wxauthSetting();
    }
});