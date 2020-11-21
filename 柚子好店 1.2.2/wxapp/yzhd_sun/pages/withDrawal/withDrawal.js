var app = getApp();

Page({
    data: {
        noticeBox: !0
    },
    onLoad: function(t) {
        this.diyWinColor();
    },
    bindinputTap: function(t) {
        console.log(t), this.setData({
            inputMoney: t.detail.value
        });
    },
    bindSubmit: function(t) {
        console.log(t);
        var o = this;
        console.log(o.data.canPutMoney.canbeput);
        var n = wx.getStorageSync("openid"), e = o.data.canPutMoney.canbeput - 0, a = o.data.inputMoney - 0;
        a <= e && a >= o.data.system.tx_money ? (console.log("可提现"), 1 == o.data.checked && app.util.request({
            url: "entry/wxapp/InputStoreMoney",
            cachetime: "0",
            data: {
                putmoney: t.detail.value.money,
                canbeInput: o.data.canPutMoney.canbeput,
                username: t.detail.value.name,
                accountnumber: t.detail.value.account,
                comaccountnumber: t.detail.value.deteraccount,
                openid: n
            },
            success: function(t) {
                console.log(t), wx.showToast({
                    title: "提现成功"
                }), wx.navigateBack({});
            }
        })) : (console.log("不可提现"), wx.showToast({
            title: "提现失败",
            icon: "none"
        }));
    },
    checkBoxTap: function(t) {
        console.log(t), this.data.checked ? this.setData({
            checked: !1
        }) : this.setData({
            checked: !0
        });
    },
    noticeBoxTap: function(t) {
        this.setData({
            noticeBox: !1
        });
    },
    closeTap: function(t) {
        this.setData({
            noticeBox: !0
        });
    },
    onReady: function() {},
    onShow: function() {
        var o = this, t = wx.getStorageSync("openid"), n = wx.getStorageSync("system");
        console.log(n), o.setData({
            system: n
        }), app.util.request({
            url: "entry/wxapp/PutForward",
            cachetime: "0",
            data: {
                openid: t
            },
            success: function(t) {
                console.log(t), o.setData({
                    canPutMoney: t.data.data
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    diyWinColor: function(t) {
        var o = wx.getStorageSync("system");
        wx.setNavigationBarColor({
            frontColor: o.color,
            backgroundColor: o.fontcolor,
            animation: {
                duration: 400,
                timingFunc: "easeIn"
            }
        }), wx.setNavigationBarTitle({
            title: "提现"
        });
    }
});