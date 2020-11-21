var _base = require("../../../we7/resource/js/base64"), app = getApp();

Page({
    data: {},
    onLoad: function(e) {
        var t = this;
        app.util.request({
            url: "entry/wxapp/pay",
            data: {
                orderid: e.orderid,
                m: e.module_name,
                title: e.title,
                pay_type: "wechat",
                order_type: e.type || "goods"
            },
            cachetime: "0",
            success: function(a) {
                a.data && a.data.data && !a.data.errno && wx.requestPayment({
                    timeStamp: a.data.data.timeStamp,
                    nonceStr: a.data.data.nonceStr,
                    package: a.data.data.package,
                    signType: "MD5",
                    paySign: a.data.data.paySign,
                    success: function(a) {
                        app.util.request({
                            url: "entry/wxapp/payResult",
                            data: {
                                orderid: e.orderid,
                                m: e.module_name,
                                pay_type: "wechat",
                                order_type: e.type || "goods"
                            },
                            cachetime: "0",
                            success: function(a) {
                                console.log(a), a.data.errno ? wx.showModal({
                                    title: "系统提示",
                                    content: a.data.message ? a.data.message : "错误",
                                    success: function(a) {
                                        console.log(a), a.confirm && t.backApp(a.data.data);
                                    }
                                }) : wx.showToast({
                                    title: "支付成功",
                                    success: function() {
                                        t.backApp(a.data.data);
                                    }
                                });
                            }
                        });
                    },
                    fail: function(a) {
                        t.backApp();
                    }
                });
            },
            fail: function(a) {
                wx.showModal({
                    title: "系统提示",
                    content: a.data.message ? a.data.message : "错误",
                    showCancel: !1,
                    success: function(a) {
                        a.confirm && t.backApp(a.data.data);
                    }
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    backApp: function(a) {
        if (a) try {
            wx.setStorageSync("we7_webview", a);
        } catch (a) {
            console.log(a);
        }
        var e = getCurrentPages();
        if (1 < e.length) for (var t in e) "wxapp_web/pages/view/index" === e[t].__route__ && wx.navigateBack({
            data: e.length - t + 1
        });
    },
    onShareAppMessage: function() {}
});