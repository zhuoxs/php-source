var app = getApp(), Page = require("../../../../zhy/sdk/qitui/oddpush.js").oddPush(Page).Page;

Page({
    data: {
        userName: "AWIN韩",
        msg: [ "用户在本活动期间完成充值，即可享受充300送100，充500送200，充1000送500多用多送的互动", "用户在本活动期间完成充值，即可享受充300送100，充500送200，充1000送500多用多送的互动" ]
    },
    submit: function() {
        var t = wx.getStorageSync("openid"), e = this.data.total || "";
        "" != e ? app.util.request({
            url: "entry/wxapp/Orderarr",
            cachetime: "30",
            data: {
                openid: t,
                price: e
            },
            success: function(a) {
                console.log(a.data);
                a.data.package;
                wx.requestPayment({
                    timeStamp: a.data.timeStamp,
                    nonceStr: a.data.nonceStr,
                    package: a.data.package,
                    signType: "MD5",
                    paySign: a.data.paySign,
                    success: function(a) {
                        app.util.request({
                            url: "entry/wxapp/Rechargeamount",
                            cachetime: "0",
                            data: {
                                openid: t,
                                total: e
                            },
                            success: function(a) {
                                1 == a.data ? (wx.showToast({
                                    title: "充值成功！",
                                    icon: "success",
                                    duration: 2e3
                                }), wx.navigateTo({
                                    url: "/ymktv_sun/pages/my/mybalance/mybalance"
                                })) : wx.showToast({
                                    title: "充值失败！",
                                    icon: "none",
                                    duration: 2e3
                                });
                            }
                        });
                    },
                    fail: function(a) {}
                });
            }
        }) : wx.showToast({
            title: "请输入金额",
            icon: "none",
            duration: 2e3
        });
    },
    bindKeyInput: function(a) {
        this.setData({
            total: a.detail.value
        });
    },
    onReady: function() {},
    onLoad: function(a) {
        this.setData({
            name: a.name,
            total: a.total
        });
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});