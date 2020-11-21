var a = getApp();

Page({
    data: {
        info: "",
        account_amount: "",
        deposit: "",
        radioChange: "",
        val: ""
    },
    onLoad: function(o) {
        var t = this;
        try {
            var e = wx.getStorageSync("session");
            e && (console.log("logintag:", e), t.setData({
                logintag: e
            }));
        } catch (a) {}
        var n = t.data.logintag;
        wx.request({
            url: a.data.url + "carowner_withdraw_deposit",
            data: {
                logintag: n
            },
            header: {
                "content-type": "application/x-www-form-urlencoded"
            },
            success: function(a) {
                if (console.log("carowner_withdraw_deposit => 获我的钱包数据信息"), console.log(a), "0000" == a.data.retCode) {
                    var o = a.data.info;
                    t.setData({
                        info: o,
                        account_amount: a.data.info.account_amount,
                        deposit: a.data.info.deposit,
                        redpacked: a.data.info.redpacked
                    });
                } else wx.showToast({
                    title: a.data.retDesc,
                    icon: "none",
                    duration: 1e3
                });
            }
        });
    },
    radioChange: function(a) {
        console.log(a.detail.value);
        var o = this, t = a.detail.value;
        o.setData({
            radioChange: t
        });
    },
    val: function(a) {
        console.log(a.detail.value);
        var o = this, t = a.detail.value;
        o.setData({
            val: t
        });
    },
    information: function(o) {
        var t = this, e = t.data.logintag, n = t.data.val, i = t.data.radioChange;
        if ("" != n) {
            if (2 == i) d = "carowner_withdraw_deposit_log"; else if (3 == i) d = "member_withdraw_redpacked_log"; else var d = "carowner_withdraw_account_log";
            console.log(d), console.log(n), wx.request({
                url: a.data.url + d,
                data: {
                    logintag: e,
                    deposit: n
                },
                header: {
                    "content-type": "application/x-www-form-urlencoded"
                },
                success: function(a) {
                    console.log(d + " =>  提现返回数据"), console.log(a), "0000" == a.data.retCode ? (wx.showToast({
                        title: a.data.retDesc,
                        icon: "none",
                        duration: 1e3
                    }), wx.navigateBack({
                        delta: 1,
                        success: function(a) {
                            var o = getCurrentPages().pop();
                            void 0 != o && null != o && o.onLoad();
                        }
                    })) : wx.showToast({
                        title: a.data.retDesc,
                        icon: "none",
                        duration: 1e3
                    });
                }
            });
        } else wx.showToast({
            title: "请输入充值金额",
            icon: "none",
            duration: 1e3
        });
    },
    tixina: function(a) {
        var o = this, t = o.data.radioChange, e = o.data.account_amount, n = o.data.deposit, i = o.data.redpacked;
        if (2 == t) d = n; else if (3 == t) d = i; else var d = e;
        o.setData({
            top: d,
            val: d
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});