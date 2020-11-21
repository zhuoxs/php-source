var app = getApp();

Page({
    data: {
        tab: [ "提现", "充值" ],
        array: [ "微信余额" ],
        current: 0,
        oppenId: 0
    },
    tab: function(t) {
        this.setData({
            current: t.currentTarget.dataset.index
        });
    },
    onLoad: function(t) {
        var o = wx.getStorageSync("color");
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: o
        });
        var e = this, a = app.siteInfo.uniacid;
        this.setData({
            uniacid: a
        });
        var n = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/Doctormoneytx",
            data: {
                openid: n
            },
            success: function(t) {
                console.log(t.data.data), e.setData({
                    zhuanmoney: t.data.data.money
                });
            },
            fail: function(t) {
                console.log(t);
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    formSubmit: function(i) {
        var t = i.detail.value;
        t.openid = wx.getStorageSync("openid");
        var o = t.tx_cost, e = t.sj_cost;
        console.log(o, e);
        this.data.countmoney;
        0 == i.detail.value.sj_cost.length ? wx.showModal({
            content: "您的账户暂无金额"
        }) : 0 == i.detail.value.tx_cost.length ? wx.showModal({
            content: "请输提现金额"
        }) : "" == i.detail.value.tx_type || null == i.detail.value.tx_type ? wx.showModal({
            content: "请选择提现方式"
        }) : e < o ? wx.showModal({
            content: "超出实际金额"
        }) : o < 1 ? wx.showModal({
            content: "提现金额必须大于1"
        }) : wx.showModal({
            title: "提示",
            content: " 确认提交么？ ",
            success: function(t) {
                if (t.confirm) {
                    console.log(t.confirm), console.log("用户点击确定");
                    var o = i.detail.value.sj_cost, e = i.detail.value.tx_cost, a = i.detail.value.tx_type, n = wx.getStorageSync("openid");
                    app.util.request({
                        url: "entry/wxapp/SaveTx",
                        data: {
                            sj_cost: o,
                            tx_cost: e,
                            tx_type: a,
                            openid: n
                        },
                        header: {
                            "Content-Type": "application/json"
                        },
                        success: function(t) {
                            console.log(t), 1 == t.data.code ? wx.showToast({
                                title: "提交失败"
                            }) : (wx.showToast({
                                title: "提交成功"
                            }), wx.redirectTo({
                                url: "../my/my"
                            }));
                        },
                        fail: function(t) {
                            console.log(t);
                        }
                    });
                } else t.cancel && console.log("用户点击取消");
            }
        });
    },
    czformSubmit: function(t) {
        t.detail.value.openid = wx.getStorageSync("openid");
    },
    onformSubmit: function(i) {
        var t = i.detail.value;
        t.openid = wx.getStorageSync("openid");
        var o = parseFloat(t.tx_cost), e = parseFloat(t.sj_cost);
        console.log(o);
        this.data.countmoney;
        0 == i.detail.value.sj_cost.length ? wx.showModal({
            content: "您的账户暂无金额"
        }) : 0 == i.detail.value.tx_cost.length ? wx.showModal({
            content: "请输提现金额"
        }) : "" == i.detail.value.tx_type || null == i.detail.value.tx_type ? wx.showModal({
            content: "请选择提现方式"
        }) : e < o ? wx.showModal({
            content: "超出实际金额"
        }) : o < 1 ? wx.showModal({
            content: "提现金额必须大于1"
        }) : wx.showModal({
            title: "提示",
            content: " 确认提交么？ ",
            success: function(t) {
                if (t.confirm) {
                    console.log(t.confirm), console.log("用户点击确定");
                    var o = i.detail.value.sj_cost, e = i.detail.value.tx_cost, a = i.detail.value.tx_type, n = wx.getStorageSync("openid");
                    app.util.request({
                        url: "entry/wxapp/SaveTx",
                        data: {
                            sj_cost: o,
                            tx_cost: e,
                            tx_type: a,
                            openid: n
                        },
                        header: {
                            "Content-Type": "application/json"
                        },
                        success: function(t) {
                            console.log(t), 1 == t.data.code ? wx.showToast({
                                title: "提交失败"
                            }) : (wx.showToast({
                                title: "提交成功"
                            }), wx.redirectTo({
                                url: "../my/my"
                            }));
                        },
                        fail: function(t) {
                            console.log(t);
                        }
                    });
                } else t.cancel && console.log("用户点击取消");
            }
        });
    },
    bindPickerChange: function(t) {
        console.log("picker发送选择改变，携带值为", t.detail.value), this.setData({
            index: t.detail.value
        });
    },
    showModal: function() {
        var t = wx.createAnimation({
            duration: 200,
            timingFunction: "linear",
            delay: 0
        });
        (this.animation = t).translateY(300).step(), this.setData({
            animationData: t.export(),
            showModalStatus: !0
        }), setTimeout(function() {
            t.translateY(0).step(), this.setData({
                animationData: t.export()
            });
        }.bind(this), 200);
    },
    hideModal: function() {
        var t = wx.createAnimation({
            duration: 200,
            timingFunction: "linear",
            delay: 0
        });
        (this.animation = t).translateY(300).step(), this.setData({
            animationData: t.export()
        }), setTimeout(function() {
            t.translateY(0).step(), this.setData({
                animationData: t.export(),
                showModalStatus: !1
            });
        }.bind(this), 200);
    }
});