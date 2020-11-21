var app = getApp();

Page({
    data: {
        items: [ {
            name: "微信支付",
            value: "微信支付",
            checked: "true"
        }, {
            name: "余额支付",
            value: "余额支付"
        } ],
        playBtn: !1
    },
    onLoad: function(a) {
        var t = this;
        app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "0",
            success: function(a) {
                wx.setStorageSync("url", a.data), t.setData({
                    url: a.data
                });
            }
        }), wx.getUserInfo({
            success: function(a) {
                t.setData({
                    userInfo: a.userInfo
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        var t = this, a = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/VipkaData",
            cachetime: "0",
            data: {
                openid: a
            },
            success: function(a) {
                t.setData({
                    vipData: a.data.vipData,
                    welfare: a.data.wel,
                    isopen: a.data.isopen
                });
            }
        });
    },
    radioChange: function(a) {
        console.log("radio发生change事件，携带value值为：", a.detail.value), this.setData({
            radios: a.detail.value
        });
    },
    opendPlay: function(a) {
        var t = a.currentTarget.dataset.index, e = this.data.vipData;
        this.setData({
            playBtn: !0,
            total: e[t].vip_price,
            vip_id: e[t].id,
            radios: "微信支付"
        });
    },
    closePlay: function() {
        var t = this;
        "微信支付" == t.data.radios ? wx.showModal({
            title: "提示！",
            content: "是否开通会员！",
            success: function(a) {
                a.confirm && t.wxpay();
            }
        }) : wx.showModal({
            title: "提示！",
            content: "是否开通会员！",
            success: function(a) {
                a.confirm && t.balance();
            }
        }), t.setData({
            playBtn: !1
        });
    },
    closePlay1: function(a) {
        this.setData({
            playBtn: !1
        });
    },
    wxpay: function(a) {
        var t = this, e = wx.getStorageSync("openid"), n = t.data.total;
        app.util.request({
            url: "entry/wxapp/Orderarr",
            cachetime: "30",
            data: {
                openid: e,
                price: n
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
                        console.log(a), "requestPayment:ok" == a.errMsg && t.goOpen();
                    },
                    fail: function(a) {}
                });
            }
        });
    },
    balance: function(a) {
        var t = this, e = wx.getStorageSync("openid"), n = t.data.total;
        app.util.request({
            url: "entry/wxapp/BalancePay",
            cachetime: "0",
            data: {
                openid: e,
                total: n,
                name: "充值会员"
            },
            success: function(a) {
                console.log(a.data), 1 == a.data ? t.goOpen() : wx.showToast({
                    title: "余额不足！",
                    icon: "none",
                    duration: 2e3
                });
            }
        });
    },
    goOpen: function(a) {
        var t = this, e = t.data.vip_id, n = wx.getStorageSync("openid"), o = t.data.isopen.isopen;
        app.util.request({
            url: "entry/wxapp/OpenVip",
            cachetime: "0",
            data: {
                openid: n,
                id: e
            },
            success: function(a) {
                console.log(a.data), 1 == a.data && (1 == o ? wx.showToast({
                    title: "恭喜您续费成功！！",
                    icon: "success",
                    duration: 2e3
                }) : wx.showToast({
                    title: "恭喜您成为vip！！",
                    icon: "success",
                    duration: 2e3
                }), t.onShow());
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});