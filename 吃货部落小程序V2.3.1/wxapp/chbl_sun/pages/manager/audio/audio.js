var app = getApp();

Page({
    data: {
        hideShopPopup: !0,
        array: [ {
            dura: "1周",
            mon: "0.1"
        }, {
            dura: "2周",
            mon: "0.2"
        }, {
            dura: "3周",
            mon: "0.3"
        } ]
    },
    onLoad: function(t) {
        console.log(this.data.array.length);
        for (var a = [], e = 0; e < this.data.array.length; e++) {
            var n = this.data.array[e].dura + "/" + this.data.array[e].mon;
            a.push(n);
        }
        this.setData({
            dealData: a
        }), console.log(this.data.dealData);
    },
    bindPickerChange: function(t) {
        console.log(t), this.setData({
            index: t.detail.value,
            change: !0
        });
    },
    renew: function(t) {
        if (console.log(t), t.currentTarget.dataset.ctype) {
            var a, e = t.currentTarget.dataset.ctype;
            a = e.split("￥"), console.log(a[1]);
            var n = a[1], o = e.split("/")[0];
        }
        console.log(o);
        var c = wx.getStorageSync("openid"), i = wx.getStorageSync("auth_type");
        app.util.request({
            url: "entry/wxapp/orderarr",
            cachetime: "0",
            data: {
                price: n,
                openid: c,
                auth_type: i
            },
            success: function(t) {
                console.log(t), wx.requestPayment({
                    timeStamp: t.data.timeStamp,
                    nonceStr: t.data.nonceStr,
                    package: t.data.package,
                    signType: "MD5",
                    paySign: t.data.paySign,
                    success: function(t) {
                        app.util.request({
                            url: "entry/wxapp/renew",
                            cachetime: "0",
                            data: {
                                openid: c,
                                etype: o,
                                price: n,
                                auth_type: i
                            },
                            success: function(t) {
                                console.log(t), 1 == t.data && wx.showToast({
                                    title: "续费成功！"
                                }), setTimeout(function() {
                                    wx.navigateBack({});
                                }, 1e3);
                            }
                        });
                    },
                    fail: function(t) {}
                });
            }
        });
    },
    wantRenewTap: function(t) {
        this.setData({
            hideShopPopup: !1
        });
    },
    closeTap: function(t) {
        this.setData({
            hideShopPopup: !0
        });
    },
    deterTap: function() {},
    onReady: function() {},
    onShow: function() {
        var a = this, t = wx.getStorageSync("openid"), e = wx.getStorageSync("auth_type");
        app.util.request({
            url: "entry/wxapp/MyStoreInfoDate",
            cachetime: "0",
            data: {
                openid: t,
                auth_type: e
            },
            success: function(t) {
                console.log(t), a.setData({
                    datetime: t.data.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/StoreIn",
            cachetime: "0",
            success: function(t) {
                console.log(t), a.setData({
                    storein: t.data.data
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});