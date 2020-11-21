var a = getApp();

Page({
    data: {
        logintag: "",
        radioChange: "",
        recharge: ""
    },
    onLoad: function(a) {
        var n = this;
        try {
            var o = wx.getStorageSync("session");
            o && (console.log("logintag:", o), n.setData({
                logintag: o
            }));
        } catch (a) {}
    },
    radioChange: function(a) {
        console.log(a.detail.value);
        var n = this, o = a.detail.value;
        n.setData({
            radioChange: o
        });
    },
    recharge: function(a) {
        var n = this, o = a.detail.value;
        n.setData({
            recharge: o
        });
    },
    information: function(n) {
        var o = this, e = o.data.radioChange, t = o.data.recharge, i = o.data.logintag, c = n.detail.formId;
        "" != e ? "" != t ? wx.request({
            url: a.data.url + "carowner_recharge_log",
            data: {
                logintag: i,
                ntype: e,
                deposit: t,
                form_id: c
            },
            header: {
                "content-type": "application/x-www-form-urlencoded"
            },
            success: function(a) {
                console.log("carowner_recharge_log => 提交发布行程"), console.log(a), wx.requestPayment({
                    timeStamp: a.data.timeStamp,
                    nonceStr: a.data.nonceStr,
                    package: a.data.package,
                    signType: "MD5",
                    paySign: a.data.paySign,
                    success: function(a) {
                        console.log(a), wx.navigateBack({
                            delta: 1,
                            success: function(a) {
                                var n = getCurrentPages().pop();
                                void 0 != n && null != n && n.onLoad();
                            }
                        });
                    },
                    fail: function(a) {}
                });
            }
        }) : wx.showToast({
            title: "请输入充值金额",
            icon: "none",
            duration: 1e3
        }) : wx.showToast({
            title: "请选择充值类目",
            icon: "none",
            duration: 1e3
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