var a = new getApp(), t = a.siteInfo.uniacid;

Page({
    data: {
        integralData: [],
        page: 1,
        isContent: !0
    },
    onLoad: function(e) {
        wx.getStorageSync("kundian_farm_uid");
        this.getIntegralOrder(!1), a.util.setNavColor(t);
    },
    getIntegralOrder: function(e) {
        var n = this, r = wx.getStorageSync("kundian_farm_uid"), i = n.data, d = i.page, o = i.integralData;
        e && (d = parseInt(d) + 1), a.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "integral",
                op: "getIntegralRecord",
                uid: r,
                uniacid: t,
                page: d
            },
            success: function(a) {
                var t = a.data.orderData;
                if (e) {
                    for (var r = 0; r < t.length; r++) o.push(t[r]);
                    n.setData({
                        integralData: o,
                        page: d
                    });
                } else a.data.orderData ? n.setData({
                    integralData: a.data.orderData
                }) : n.setData({
                    isContent: !1
                });
            }
        });
    },
    onReachBottom: function(a) {
        this.getIntegralOrder(!0);
    },
    pay: function(t) {
        var e = t.currentTarget.dataset.orderid, n = a.siteInfo.uniacid, r = wx.getStorageSync("kundian_farm_uid");
        a.util.request({
            url: "entry/wxapp/pay",
            data: {
                op: "getIntegralPayOrder",
                orderid: e,
                uniacid: n,
                file: "integral"
            },
            cachetime: "0",
            success: function(t) {
                if (t.data && t.data.data && !t.data.errno) {
                    var i = t.data.data.package;
                    wx.requestPayment({
                        timeStamp: t.data.data.timeStamp,
                        nonceStr: t.data.data.nonceStr,
                        package: t.data.data.package,
                        signType: "MD5",
                        paySign: t.data.data.paySign,
                        success: function(t) {
                            wx.showLoading({
                                title: "加载中"
                            }), a.util.request({
                                url: "entry/wxapp/class",
                                data: {
                                    control: "integral",
                                    op: "sendMsg",
                                    order_id: e,
                                    uniacid: n,
                                    prepay_id: i,
                                    uid: r
                                },
                                success: function(a) {
                                    wx.showModal({
                                        title: "提示",
                                        content: "支付成功",
                                        showCancel: !1,
                                        success: function() {
                                            wx.redirectTo({
                                                url: "../orderList/index"
                                            });
                                        }
                                    }), wx.hideLoading();
                                }
                            });
                        },
                        fail: function(a) {
                            wx.redirectTo({
                                url: "../orderList/index"
                            });
                        }
                    });
                } else wx.redirectTo({
                    url: "../orderList/index"
                });
            },
            fail: function(a) {
                wx.showModal({
                    title: "系统提示",
                    content: a.data.message ? a.data.message : "错误",
                    showCancel: !1,
                    success: function(a) {
                        a.confirm && wx.redirectTo({
                            url: "../orderList/index"
                        });
                    }
                });
            }
        });
    },
    onShareAppMessage: function() {}
});