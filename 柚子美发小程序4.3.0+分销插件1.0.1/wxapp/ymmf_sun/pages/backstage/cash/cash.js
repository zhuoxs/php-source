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
    onLoad: function(t) {
        var a = this;
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("System").fontcolor,
            backgroundColor: wx.getStorageSync("System").color,
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
        var e = wx.getStorageSync("branch_id");
        app.util.request({
            url: "entry/wxapp/GetBrandMoney",
            cachetime: "0",
            data: {
                bid: e
            },
            success: function(t) {
                console.log("获取要提现的数据"), console.log(t.data), a.setData({
                    list: t.data,
                    mode: t.data.wd_type,
                    defaulttype: t.data.wd_type[0].id
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
    toggleRule: function(t) {
        this.setData({
            isShow: !this.data.isShow
        });
    },
    cashAll: function(t) {
        var a, e = this, o = e.data.list, n = e.data.list.canuseamount, i = e.data.index, d = e.data.mode, s = (n * o.commission / 100).toFixed(2), c = ((100 * n - 100 * s - 100 * (a = ((100 * n - n * o.commission) / 100 * d[i].wd_rates / 100).toFixed(2))) / 100).toFixed(2);
        e.setData({
            putForward: n,
            commissionMoney: s,
            ratesMoney: a,
            cangetMoney: c
        });
    },
    bindPickerChange: function(t) {
        var a, e, o = this, n = o.data.list, i = o.data.mode, d = o.data.putForward, s = t.detail.value, c = o.data.commissionMoney ? o.data.commissionMoney : 0;
        e = d ? ((100 * d - 100 * c - 100 * (a = ((100 * d - d * n.commission) / 100 * i[s].wd_rates / 100).toFixed(2))) / 100).toFixed(2) : a = "0.00", 
        this.setData({
            defaulttype: i[s].id,
            index: s,
            ratesMoney: a,
            cangetMoney: e
        });
    },
    enterMmoney: function(t) {
        var a, e, o = this, n = o.data.list, i = t.detail.value, d = o.data.index, s = o.data.mode, c = 0;
        i ? (c = ((i = parseInt(i)) * n.commission / 100).toFixed(2), a = ((100 * i - i * n.commission) / 100 * s[d].wd_rates / 100).toFixed(2), 
        console.log(i + "--" + n.commission + "--" + i * n.commission + "--" + s[d].wd_rates), 
        e = ((100 * i - 100 * c - 100 * a) / 100).toFixed(2)) : e = a = c = "0.00", o.setData({
            putForward: i,
            commissionMoney: c,
            ratesMoney: a,
            cangetMoney: e
        });
    },
    checkboxChange: function(t) {
        this.setData({
            check: !this.data.check
        });
    },
    formSubmit: function(t) {
        var a, e, o, n = this, i = !0, d = "", s = n.data.putForward, c = n.data.check, l = n.data.index, u = n.data.mode, r = wx.getStorageSync("branch_id");
        if (c ? s ? 2 == u[l].id ? (a = t.detail.value.zfb_uname, e = t.detail.value.zfb_account, 
        o = t.detail.value.zfb_phone, "" == a ? d = "请填写您的名字" : "" == e ? d = "请输入支付宝账号" : i = !1) : 3 == u[l].id ? (a = t.detail.value.yhk_uname, 
        e = t.detail.value.yhk_account, o = t.detail.value.yhk_phone, "" == a ? d = "请填写您的名字" : "" == e ? d = "请输入银行卡号" : i = !1) : (a = t.detail.value.wx_uname, 
        e = "", o = t.detail.value.wx_phone, "" == a ? d = "请填写您的名字" : i = !1) : d = "请输入提现金额" : d = "请阅读提现须知", 
        1 == i) wx.showModal({
            title: "提示",
            content: d,
            showCancel: !1
        }); else {
            var m = wx.getStorageSync("openid");
            app.util.request({
                url: "entry/wxapp/SaveWithDraw",
                cachetime: "0",
                data: {
                    bid: r,
                    openid: m,
                    wd_type: u[l].id,
                    money: s,
                    account: e,
                    uname: a,
                    phone: o
                },
                success: function(t) {
                    console.log("提交数据"), console.log(t.data), wx.showModal({
                        title: "提示",
                        content: "提现提交成功",
                        showCancel: !1,
                        success: function(t) {
                            wx.redirectTo({
                                url: "/ymmf_sun/pages/backstage/index3/index3"
                            });
                        }
                    });
                }
            });
        }
    },
    updateUserInfo: function(t) {
        console.log("授权操作更新");
        app.wxauthSetting();
    }
});