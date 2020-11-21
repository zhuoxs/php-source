var app = getApp();

Page({
    data: {
        checked: !1
    },
    onLoad: function(o) {
        var t = o.docmoney, e = wx.getStorageSync("color");
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: e
        }), this.setData({
            docmoney: t
        });
    },
    mingClick: function() {
        var o = wx.getStorageSync("openid");
        wx.navigateTo({
            url: "/hyb_yl/usermx/usermx?openid=" + o
        });
    },
    xuzhi: function() {
        wx.navigateTo({
            url: "/hyb_yl/xuzhi/xuzhi"
        });
    },
    money: function(o) {
        var t = this.data.money;
        if (console.log(o), o.detail.value >= t) {
            var e = t;
            this.setData({
                value: e
            });
        }
    },
    subClick: function(a) {
        var o = this.data.base, t = parseInt(o.zdtx), e = o.txsx, n = a.detail.value;
        n.openid = wx.getStorageSync("openid");
        var c = n.tx_cost, l = n.sj_cost, s = l - l * e, i = l * e;
        this.data.countmoney;
        0 == a.detail.value.sj_cost.length ? wx.showModal({
            content: "您的账户暂无金额"
        }) : 0 == a.detail.value.tx_cost.length ? wx.showModal({
            content: "请输提现金额"
        }) : "" == a.detail.value.tx_type || null == a.detail.value.tx_type ? wx.showModal({
            content: "请选择提现方式"
        }) : l < c ? wx.showModal({
            content: "超出实际金额"
        }) : c < t ? wx.showModal({
            content: "提现金额必须大于等于" + t
        }) : wx.showModal({
            content: " 实际到帐" + s + "扣除" + i + "手续费",
            success: function(o) {
                if (o.confirm) {
                    console.log(o.confirm), console.log("用户点击确定");
                    var t = a.detail.value.tx_cost, e = a.detail.value.tx_type, n = wx.getStorageSync("openid");
                    app.util.request({
                        url: "entry/wxapp/SaveTx",
                        data: {
                            sj_cost: s,
                            tx_cost: t,
                            tx_type: e,
                            openid: n
                        },
                        header: {
                            "Content-Type": "application/json"
                        },
                        success: function(o) {
                            console.log(o), 1 == o.data.code ? wx.showToast({
                                title: "提交失败"
                            }) : (wx.showToast({
                                title: "提交成功"
                            }), wx.redirectTo({
                                url: "../my/my"
                            }));
                        },
                        fail: function(o) {
                            console.log(o);
                        }
                    });
                } else o.cancel && console.log("用户点击取消");
            }
        });
    },
    onReady: function() {
        this.getBase();
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    getBase: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/Base",
            success: function(o) {
                console.log(o), t.setData({
                    base: o.data.data
                });
            },
            fail: function(o) {}
        });
    }
});