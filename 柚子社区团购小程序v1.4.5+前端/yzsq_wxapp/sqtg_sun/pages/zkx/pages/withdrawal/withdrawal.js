var app = getApp();

Page({
    data: {
        spindex: 0,
        ostyle: [ {
            img: "../../../../../zhy/resource/images/wx.png",
            name: "微信"
        }, {
            img: "../../../../../zhy/resource/images/alipay.png",
            name: "支付宝"
        }, {
            img: "../../../../../zhy/resource/images/bankCard.png",
            name: "银行卡"
        } ],
        cms_money: 0,
        plat_money: 0,
        ali_money: 0,
        bank_money: 0,
        actual_money: 0
    },
    onLoad: function(a) {
        var e = wx.getStorageSync("userInfo");
        this.setData({
            user_id: e.id
        }), this.loadData();
    },
    loadData: function() {
        var t = this, a = t.data.user_id;
        app.ajax({
            url: "Cleader|getWithdrawInfo",
            data: {
                user_id: a
            },
            success: function(a) {
                console.log(a);
                var e = a.data.withdraw_type[0] - 1;
                t.setData({
                    spindex: e,
                    store: a.data
                });
            }
        });
    },
    onShow: function() {},
    spTap: function(a) {
        var e = this.data.m;
        0 != e && "" != e && null != e ? (this.setData({
            typeindex: a.currentTarget.dataset.index,
            spindex: this.data.store.withdraw_type[a.currentTarget.dataset.index] - 1
        }), this.getMoney()) : app.tips("请先输入提现金额");
    },
    getMoney: function(a) {
        var e = this;
        if (a) {
            var t = parseFloat(a.detail.value) || 0;
            e.setData({
                m: t
            });
        } else t = e.data.m;
        var n = e.data.store, i = e.data.spindex;
        if (t > parseFloat(n.money) && app.tips("提现金额不得超过" + n.money), 0 == i) var o = (t - n.withdraw_platformrate / 100 * t - n.withdraw_wechatrate / 100 * t).toFixed(2); else if (1 == i) o = (t - n.withdraw_platformrate / 100 * t - n.withdraw_alipayrate / 100 * t).toFixed(2); else if (2 == i) o = (t - n.withdraw_platformrate / 100 * t - n.withdraw_bankrate / 100 * t).toFixed(2);
        e.setData({
            cms_money: (n.withdraw_platformrate / 100 * t).toFixed(2),
            plat_money: (n.withdraw_wechatrate / 100 * t).toFixed(2),
            ali_money: (n.withdraw_alipayrate / 100 * t).toFixed(2),
            bank_money: (n.withdraw_bankrate / 100 * t).toFixed(2),
            actual_money: o,
            money: parseFloat(t)
        });
    },
    formSubmit: function(a) {
        var e = this, t = a.detail.value.tel, n = a.detail.value.uname, i = a.detail.value.bank, o = "提取失败", s = !1, d = e.data.money || 0, r = e.data.store, l = e.data.spindex;
        if (d > parseFloat(r.money) || d < parseFloat(r.withdraw_min)) o = "金额不得大于" + r.money + "元或小于" + r.withdraw_min + "元"; else if ("" == n || null == n) o = "请输入您的姓名"; else if (1 != e.data.spindex || "" != i && null != i) if (2 != e.data.spindex || "" != i && null != i) if (/^1(3|4|5|7|8|9)\d{9}$/.test(t)) {
            if (s = !0, 0 == l) var m = e.data.plat_money; else if (1 == l) m = e.data.ali_money; else if (2 == l) m = e.data.bank_money;
            e.setData({
                sending: !0
            }), setTimeout(function() {
                e.setData({
                    sending: !1
                });
            }, 1e3), app.ajax({
                url: "Cleader|addWithdraw",
                data: {
                    user_id: e.data.user_id,
                    amount: d,
                    wd_type: e.data.spindex + 1,
                    wd_name: n,
                    wd_phone: t,
                    money: e.data.actual_money,
                    paycommission: e.data.cms_money,
                    ratesmoney: m,
                    wd_account: i
                },
                success: function(a) {
                    wx.showModal({
                        content: "申请成功",
                        showCancel: !1,
                        success: function(a) {
                            e.loadData(), e.setData({
                                money: "",
                                cms_money: 0,
                                plat_money: 0,
                                ali_money: 0,
                                bank_money: 0,
                                actual_money: 0
                            }), wx.navigateBack({});
                        }
                    });
                }
            });
        } else o = "请输入正确的手机号码"; else o = "请输入银行卡号"; else o = "请输入支付宝账号";
        s || app.tips(o);
    }
});