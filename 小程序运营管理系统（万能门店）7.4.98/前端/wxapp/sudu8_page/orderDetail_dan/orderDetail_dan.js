var app = getApp();

Page({
    data: {
        state: 1,
        orderFormDisable: !0,
        isChange: "",
        formchangeBtn: 2
    },
    ContactMerchant: function() {
        var e = this;
        wx.showModal({
            title: "提示",
            content: "请联系商家咨询具体信息！",
            confirmText: "联系商家",
            success: function(a) {
                if (a.confirm) {
                    var t = e.data.baseinfo.tel;
                    wx.makePhoneCall({
                        phoneNumber: t
                    });
                }
            }
        });
    },
    makePhoneCall: function(a) {
        var t = a.currentTarget.dataset.tel;
        wx.makePhoneCall({
            phoneNumber: t
        });
    },
    bindDateChange2: function(a) {
        this.setData({
            chuydate: a.detail.value
        });
    },
    onLoad: function(a) {
        var t = this;
        a.orderid && t.setData({
            orderid: a.orderid
        });
        var e = 0;
        a.fxsid && (e = a.fxsid, t.setData({
            fxsid: a.fxsid
        })), t.getBase(), app.util.getUserInfo(t.getinfos, e);
    },
    getBase: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/BaseMin",
            cachetime: "30",
            data: {
                vs1: 1
            },
            success: function(a) {
                t.setData({
                    baseinfo: a.data.data
                }), wx.setNavigationBarColor({
                    frontColor: t.data.baseinfo.base_tcolor,
                    backgroundColor: t.data.baseinfo.base_color
                });
            },
            fail: function(a) {}
        });
    },
    getinfos: function() {
        var t = this;
        wx.getStorage({
            key: "openid",
            success: function(a) {
                t.setData({
                    openid: a.data
                }), t.getOrder();
            }
        });
    },
    getOrder: function() {
        var t = this, a = t.data.orderid;
        app.util.request({
            url: "entry/wxapp/getOrderDetail",
            data: {
                order_id: a
            },
            success: function(a) {
                t.setData({
                    datas: a.data.data
                });
            }
        });
    },
    copy: function(a) {
        wx.setClipboardData({
            data: a.currentTarget.dataset.ddh,
            success: function(a) {
                wx.showToast({
                    title: "复制成功"
                });
            }
        });
    },
    makephonecall: function() {
        this.data.datas.seller_tel && wx.makePhoneCall({
            phoneNumber: this.data.datas.seller_tel
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        wx.stopPullDownRefresh();
    },
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    tuikuan: function(a) {
        var t = a.detail.formId, e = a.currentTarget.dataset.order;
        wx.showModal({
            title: "提醒",
            content: "确定要退款吗？",
            success: function(a) {
                a.confirm && app.util.request({
                    url: "entry/wxapp/miaoshatk",
                    data: {
                        formId: t,
                        order_id: e
                    },
                    success: function(t) {
                        0 == t.data.data.flag ? wx.showModal({
                            title: "提示",
                            content: t.data.data.message,
                            showCancel: !1,
                            success: function(a) {
                                wx.redirectTo({
                                    url: "/sudu8_page/orderDetail_dan/orderDetail_dan?orderid=" + e
                                });
                            }
                        }) : wx.showModal({
                            title: "很抱歉",
                            content: t.data.data.message,
                            confirmText: "联系客服",
                            success: function(a) {
                                a.confirm && wx.makePhoneCall({
                                    phoneNumber: t.data.data.mobile
                                });
                            }
                        });
                    }
                });
            }
        });
    },
    qrshouh: function(a) {
        var t = a.target.dataset.order, e = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/danshouhuo",
            data: {
                openid: e,
                orderid: t
            },
            success: function(a) {
                wx.redirectTo({
                    url: "/sudu8_page/orderDetail_dan/orderDetail_dan?orderid=" + t
                });
            }
        });
    }
});