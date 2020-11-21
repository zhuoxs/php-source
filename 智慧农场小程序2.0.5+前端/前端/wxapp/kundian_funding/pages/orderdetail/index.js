var a = new getApp(), t = a.siteInfo.uniacid, e = a.util.url("entry/wxapp/funding") + "m=kundian_farm_plugin_funding";

Page({
    data: {
        orderData: []
    },
    onLoad: function(a) {
        var t = this, r = a.orderid;
        wx.request({
            url: e,
            data: {
                op: "orderDetail",
                control: "order",
                orderid: r
            },
            success: function(a) {
                var e = a.data.orderData, r = "";
                r = 1 == e.return_type ? "平台将以" + e.project.return_percent + "%的价格回收" : a.data.orderData.spec.spec_desc, 
                t.setData({
                    orderData: e,
                    return_desc: r
                });
            }
        });
    },
    payOrder: function(r) {
        var n = r.currentTarget.dataset.orderid, d = wx.getStorageSync("kundian_farm_uid");
        a.util.request({
            url: "entry/wxapp/fundingPay",
            data: {
                orderid: n,
                uniacid: t
            },
            cachetime: "0",
            success: function(a) {
                if (a.data && a.data.data && !a.data.errno) {
                    var t = a.data.data.package;
                    wx.requestPayment({
                        timeStamp: a.data.data.timeStamp,
                        nonceStr: a.data.data.nonceStr,
                        package: a.data.data.package,
                        signType: "MD5",
                        paySign: a.data.data.paySign,
                        success: function(a) {
                            wx.request({
                                url: e,
                                data: {
                                    op: "notify",
                                    control: "project",
                                    uid: d,
                                    orderid: n,
                                    prepay_id: t
                                },
                                success: function(a) {
                                    wx.showToast({
                                        title: "支付成功",
                                        success: function(a) {
                                            wx.redirectTo({
                                                url: "../orderList/index"
                                            });
                                        }
                                    });
                                }
                            });
                        },
                        fail: function(a) {}
                    });
                }
                "JSAPI支付必须传openid" == a.data.message && wx.navigateTo({
                    url: "../../login/index"
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
        });
    }
});