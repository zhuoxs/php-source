var a = getApp(), e = a.requirejs("/core"), t = a.requirejs("/foxui");

a.requirejs("jquery");

Page({
    data: {
        radios: {
            balance: {
                checked: 0,
                name: "余额"
            },
            weixin: {
                checked: 0,
                name: "微信"
            },
            alipay: {
                checked: 0,
                name: "支付宝"
            },
            card: {
                checked: 0,
                name: "银行卡"
            }
        },
        args: {}
    },
    onLoad: function(a) {
        var t = this;
        e.get("dividend/apply", "", function(a) {
            t.setData({
                msg: a
            }), a.member;
        });
    },
    selected: function(a) {
        var e = this, t = e.data.radios, r = a.currentTarget.dataset.status;
        for (var i in t) r == i ? (t[i].checked = 1 != a.currentTarget.dataset.checked, 
        e.setData({
            radios: t,
            "args.type": a.currentTarget.dataset.type
        })) : (t[i].checked = !1, e.setData({
            radios: t
        }));
    },
    changeinput: function(a) {
        var e = this, t = a.detail.value, r = a.target.dataset.input, i = e.data.args;
        i[r] = t, e.setData({
            args: i
        });
    },
    bindpullldown: function(a) {
        console.error(a.detail.value);
        var e = this, t = a.detail.value, r = e.data.msg.banklist;
        e.data.args;
        for (var i in r) i == t && e.setData({
            "args.bankname": r[t].bankname,
            index: t
        });
    },
    submit: function() {
        var a = this, r = "", i = a.data.args;
        if (0 == i.type) r = "余额"; else if (1 == i.type) r = "微信钱包"; else if (2 == i.type) {
            if (r = "支付宝", !i.realname) return void t.toast(a, "请输入姓名");
            if (!i.alipay) return void t.toast(a, "请输入支付宝账号");
            if (!i.alipay1) return void t.toast(a, "请输入支付宝确认账号");
            if (i.alipay != i.alipay1) return void t.toast(a, "支付宝账号不一致");
        } else if (3 == i.type) {
            if (r = "银行卡", !i.realname1) return void t.toast(a, "请输入姓名");
            if (!i.bankname) return void t.toast(a, "请选择银行");
            if (!i.bankcard) return void t.toast(a, "请输入银行卡账号");
            if (!i.bankcard1) return void t.toast(a, "请输入银行卡确认账号");
            if (i.bankcard != i.bankcard1) return void t.toast(a, "银行卡账号不一致");
            i.realname = i.realname1;
        }
        wx.showModal({
            title: "提示",
            content: "确认提现到" + r + "吗？",
            success: function(a) {
                a.confirm && e.post("dividend/apply", i, function(a) {
                    wx.navigateBack({
                        detail: 1
                    });
                });
            }
        });
    }
});