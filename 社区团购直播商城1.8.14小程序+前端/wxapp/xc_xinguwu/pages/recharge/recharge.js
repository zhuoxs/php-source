var app = getApp();

Page({
    data: {
        monry: 0,
        idx: 0
    },
    choseTxtColor: function(a) {
        var t = a.currentTarget.dataset.idx;
        this.setData({
            idx: t
        });
    },
    myform: function(a) {
        var o = this, t = this.data.recharge, e = this.data.idx, n = t[e].fee;
        this.data.monry;
        "" != t[e].fee ? "" != a.detail.value.mode ? wx.showModal({
            title: "确认充值",
            content: "确认充值" + n + "元？",
            success: function(a) {
                a.confirm && (app.util.showLoading(), app.util.request({
                    url: "entry/wxapp/my",
                    data: {
                        op: "pay_recharge",
                        idx: e
                    },
                    success: function(a) {
                        console.log(a);
                        var t = a.data, e = t.data.tid;
                        t && t.data && !a.data.errno && wx.requestPayment({
                            timeStamp: a.data.data.timeStamp,
                            nonceStr: a.data.data.nonceStr,
                            package: a.data.data.package,
                            signType: "MD5",
                            paySign: a.data.data.paySign,
                            success: function(a) {
                                setTimeout(function() {
                                    !function a(t) {
                                        app.util.request({
                                            url: "entry/wxapp/payquery",
                                            showLoading: !1,
                                            data: {
                                                tid: t
                                            },
                                            success: function(a) {
                                                console.log(a.data.data), app.globalData.userInfo = a.data.data, wx.showToast({
                                                    title: "充值成功"
                                                }), o.setData({
                                                    monry: a.data.data.amount
                                                }), wx.redirectTo({
                                                    url: "../user/user"
                                                });
                                            },
                                            fail: function() {
                                                setTimeout(function() {
                                                    a(t);
                                                }, 1e3);
                                            }
                                        });
                                    }(e);
                                }, 500);
                            },
                            fail: function(a) {}
                        });
                    },
                    fail: function(a) {
                        wx.showModal({
                            title: "系统提示",
                            content: a.data.message ? a.data.message : "错误",
                            showCancel: !1,
                            success: function(a) {
                                a.confirm;
                            }
                        });
                    }
                }));
            }
        }) : wx.showToast({
            title: "请选择支付方式",
            icon: "none"
        }) : wx.showToast({
            title: "请选择充值面额",
            icon: "none"
        });
    },
    onLoad: function(a) {
        var e = this;
        e.setData({
            monry: app.globalData.userInfo.amount,
            webset: app.globalData.webset
        }), app.util.request({
            url: "entry/wxapp/my",
            showLoading: !1,
            data: {
                op: "recharge"
            },
            success: function(a) {
                var t = a.data;
                t.data.recharge && t.data.recharge.value && e.setData({
                    recharge: t.data.recharge.value
                });
            }
        });
    },
    onReady: function() {
        app.look.navbar(this);
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/my",
            showLoading: !1,
            data: {
                op: "recharge"
            },
            success: function(a) {
                wx.stopPullDownRefresh();
                var t = a.data;
                t.data.money && e.setData({
                    monry: t.data.money
                });
            }
        });
    },
    onReachBottom: function() {}
});