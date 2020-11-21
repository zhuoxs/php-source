var a = require("../../../../utils/base.js"), e = require("../../../../../api.js"), t = new a.Base();

Page({
    data: {
        payType: 1
    },
    onLoad: function(a) {
        console.log(a), this.setData({
            share_money: a.share_money,
            min_withdraw: a.min_withdraw
        });
        var e = wx.getStorageSync("userData").share;
        e && this.setData({
            share_info: e,
            payType: e.withdraw_type[0]
        });
    },
    typeSelect: function(a) {
        var e = a.currentTarget.dataset.index;
        this.setData({
            payType: e
        });
    },
    getPrice: function(a) {
        var e = a.detail.value, i = t.clearPrice(e);
        this.setData({
            price: i
        });
    },
    withdraw: function(a) {
        var i = {
            url: e.default.withdraw_submit,
            data: {
                type: this.data.payType,
                money: this.data.price,
                name: a.detail.value.Alipay_name || "",
                account: a.detail.value.Alipay_number || "",
                bank_name: a.detail.value.card_name || "",
                bank: a.detail.value.card_bank || "",
                bank_account: a.detail.value.card_number || "",
                formId: a.detail.formId
            }
        };
        console.log(i), t.getData(i, function(a) {
            console.log(a), 1 == a.errorCode ? wx.showModal({
                title: "提示",
                content: "已提交申请",
                showCancel: !1,
                success: function(a) {
                    wx.redirectTo({
                        url: "../detail/detail?swith=0"
                    });
                }
            }) : wx.showToast({
                title: a.msg,
                icon: "none",
                duration: 2e3
            });
        });
    }
});