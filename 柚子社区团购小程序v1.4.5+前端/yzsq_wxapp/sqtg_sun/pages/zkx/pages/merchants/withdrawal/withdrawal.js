var app = getApp();

Page({
    data: {
        spindex: 0,
        ostyle: [ {
            img: "../../../../../../zhy/resource/images/wx.png",
            name: "微信"
        } ],
        cms_money: 0,
        plat_money: 0,
        actual_money: 0
    },
    onLoad: function(a) {
        wx.getStorageSync("userInfo");
        var t = wx.getStorageSync("userInfo");
        if (t) this.setData({
            user_id: t.id
        }); else {
            var e = encodeURIComponent("/sqtg_sun/pages/zkx/pages/merchants/withdrawal/withdrawal?id=" + a.id);
            app.reTo("/sqtg_sun/pages/home/login/login?id=" + e);
        }
        this.setData({
            id: a.id
        });
    },
    loadData: function() {
        var t = this;
        app.ajax({
            url: "Cwithdraw|getWithDrawSet",
            data: {
                store_id: t.data.id
            },
            success: function(a) {
                t.setData({
                    plat: a.data
                });
            }
        }), app.ajax({
            url: "Cstore|getStore",
            data: {
                id: t.data.id
            },
            success: function(a) {
                t.setData({
                    store: a.data
                });
            }
        });
    },
    onShow: function() {
        this.loadData();
    },
    spTap: function(a) {
        this.setData({
            spindex: a.currentTarget.dataset.index
        });
    },
    getMoney: function(a) {
        var t = this.data.store, e = this.data.plat, s = parseFloat(a.detail.value) || 0;
        s > parseFloat(t.money) && app.tips("提现金额不得超过" + t.money);
        var n = (s - e.cms_rates / 100 * s - e.wd_wxrates / 100 * s).toFixed(2);
        this.setData({
            cms_money: (e.cms_rates / 100 * s).toFixed(2),
            plat_money: (e.wd_wxrates / 100 * s).toFixed(2),
            actual_money: n,
            money: parseFloat(s)
        });
    },
    formSubmit: function(a) {
        var t = this, e = a.detail.value.tel, s = a.detail.value.uname, n = "", o = !1, i = t.data.money || 0, d = t.data.plat, r = t.data.store;
        i > parseFloat(r.money) || i < parseFloat(d.min_money) ? n = "金额不得大于" + r.money + "元或小于" + d.min_money + "元" : "" == s || null == s ? n = "请输入您的姓名" : /^1(3|4|5|7|8|9)\d{9}$/.test(e) ? (o = !0, 
        t.setData({
            sending: !0
        }), setTimeout(function() {
            t.setData({
                sending: !1
            });
        }, 1e3), app.ajax({
            url: "Cwithdraw|setWithDraw",
            data: {
                user_id: t.data.user_id,
                money: i,
                store_id: t.data.id,
                wd_name: s,
                wd_phone: e
            },
            success: function(a) {
                wx.showModal({
                    content: "申请成功",
                    showCancel: !1,
                    success: function(a) {
                        t.loadData(), t.setData({
                            money: "",
                            cms_money: 0,
                            plat_money: 0,
                            actual_money: 0
                        }), wx.navigateBack({});
                    }
                });
            }
        })) : n = "请输入正确的手机号码", o || app.tips(n);
    }
});