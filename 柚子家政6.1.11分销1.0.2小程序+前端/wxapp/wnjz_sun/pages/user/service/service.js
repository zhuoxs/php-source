var app = getApp();

Page({
    data: {
        service: [ "全部", "待支付", "待服务", "已服务" ],
        curIdenx: "0",
        all: [],
        waitSer: [],
        dzf: [],
        dpj: [],
        sh: [],
        url: [],
        status: []
    },
    onLoad: function(t) {
        this.getUrl();
    },
    onReady: function() {},
    onShow: function() {
        var e = this, t = wx.getStorageSync("build_id"), a = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/Orrde",
            cachetime: "0",
            method: "GET",
            data: {
                userid: a,
                build_id: t
            },
            success: function(t) {
                e.setData({
                    allorder: t.data.data,
                    status: !0
                }), e.getdafuwu(), e.getdazhifu(), e.getdaquer(), e.getservices();
            }
        });
    },
    getUrl: function() {
        var e = this;
        wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/url",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url", t.data), e.setData({
                    url: t.data
                });
            }
        });
    },
    getdafuwu: function() {
        var t = wx.getStorageSync("openid"), e = wx.getStorageSync("build_id"), a = this;
        app.util.request({
            url: "entry/wxapp/dafuwu",
            cachetime: "0",
            method: "GET",
            data: {
                userid: t,
                build_id: e
            },
            success: function(t) {
                a.setData({
                    waitSer: t.data
                });
            }
        });
    },
    getdazhifu: function() {
        var t = wx.getStorageSync("openid"), e = wx.getStorageSync("build_id"), a = this;
        app.util.request({
            url: "entry/wxapp/dazhifu",
            cachetime: "0",
            method: "GET",
            data: {
                userid: t,
                build_id: e
            },
            success: function(t) {
                a.setData({
                    dzf: t.data
                });
            }
        });
    },
    getdaquer: function() {
        var t = wx.getStorageSync("openid"), e = wx.getStorageSync("build_id"), a = this;
        app.util.request({
            url: "entry/wxapp/daqueren",
            cachetime: "0",
            method: "GET",
            data: {
                userid: t,
                build_id: e
            },
            success: function(t) {
                a.setData({
                    sh: t.data
                });
            }
        });
    },
    getservices: function() {
        var t = wx.getStorageSync("openid"), e = wx.getStorageSync("build_id"), a = this;
        app.util.request({
            url: "entry/wxapp/services",
            cachetime: "0",
            method: "GET",
            data: {
                openid: t,
                build_id: e
            },
            success: function(t) {
                a.setData({
                    overservices: t.data
                });
            }
        });
    },
    goDetails: function(t) {
        wx.navigateTo({
            url: "/wnjz_sun/pages/user/orderdet/orderdet?oid=" + t.currentTarget.dataset.id
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    navTab: function(t) {
        var e = t.currentTarget.dataset.index;
        this.setData({
            curIdenx: e
        });
    },
    toComment: function(t) {
        wx.navigateTo({
            url: "../comment/comment?oid=" + t.currentTarget.dataset.oid
        });
    },
    toDelete: function(t) {
        var e = t.currentTarget.dataset.oid;
        console.log(e);
        var a = this, n = t.currentTarget.dataset.index, o = a.data.all;
        wx.showModal({
            title: "提示",
            content: "确认取消订单吗",
            success: function(t) {
                t.confirm ? (app.util.request({
                    url: "entry/wxapp/OrderDelete",
                    cachetime: "0",
                    method: "GET",
                    data: {
                        oid: e
                    },
                    success: function(t) {
                        o.splice(n, 1), a.setData({
                            all: o
                        });
                    }
                }), a.onShow()) : t.cancel && console.log("用户点击取消");
            },
            fail: function(t) {}
        });
    },
    toqueren: function(t) {
        var e = this, a = t.currentTarget.dataset.oid, n = t.currentTarget.dataset.index, o = e.data.all;
        e.data.sh;
        console.log(a), app.util.request({
            url: "entry/wxapp/Orderqueren",
            cachetime: "0",
            method: "GET",
            data: {
                oid: a
            },
            success: function(t) {
                console.log(t), o[n].status = "5", e.setData({
                    all: o
                });
            }
        });
    },
    toquere: function(t) {
        var e = this, a = t.currentTarget.dataset.oid, n = t.currentTarget.dataset.index, o = e.data.sh;
        app.util.request({
            url: "entry/wxapp/Orderqueren",
            cachetime: "0",
            data: {
                oid: a
            },
            success: function(t) {
                console.log(t), o.splice(n, 1), e.setData({
                    sh: o
                }), wx.showToast({
                    title: "确认成功！"
                }), e.onShow();
            }
        });
    },
    tozhifu: function(t) {
        console.log(t);
        var e = wx.getStorageSync("openid"), a = t.currentTarget.dataset.oid;
        console.log(a);
        var n = t.currentTarget.dataset.price;
        t.currentTarget.dataset.index;
        console.log(n);
        var o = this;
        app.util.request({
            url: "entry/wxapp/Orderarr",
            data: {
                price: n,
                openid: e,
                order_id: a,
                type: 1
            },
            success: function(t) {
                console.log(t.data), wx.requestPayment({
                    timeStamp: t.data.timeStamp,
                    nonceStr: t.data.nonceStr,
                    package: t.data.package,
                    signType: "MD5",
                    paySign: t.data.paySign,
                    success: function(t) {
                        wx.showToast({
                            title: "支付成功",
                            icon: "success",
                            duration: 2e3
                        }), app.util.request({
                            url: "entry/wxapp/PayOrder",
                            cachetime: "0",
                            data: {
                                order_id: a
                            },
                            success: function(t) {
                                o.onShow();
                            }
                        });
                    },
                    fail: function(t) {}
                });
            }
        });
    },
    toRefund: function(t) {
        var e = t.currentTarget.dataset.oid;
        t.currentTarget.dataset.index;
        wx.showModal({
            title: "提示",
            content: "确认申请退款吗",
            showCancel: !0,
            success: function(t) {
                t.confirm && app.util.request({
                    url: "entry/wxapp/SetOrderStatus",
                    data: {
                        oid: e,
                        ordertype: 1,
                        refund: 1
                    },
                    success: function(t) {
                        console.log(t.data), 2 == t.data ? wx.showToast({
                            title: "申请失败！",
                            icon: "none",
                            duration: 2e3
                        }) : wx.showToast({
                            title: "申请成功！",
                            icon: "success",
                            duration: 500
                        });
                    },
                    fail: function(t) {
                        console.log(t.data), wx.showModal({
                            title: "提示信息",
                            content: t.data.message,
                            showCancel: !1,
                            success: function(t) {}
                        });
                    }
                });
            },
            fail: function(t) {},
            complete: function(t) {}
        });
    },
    toRefundcannel: function(t) {
        var e = t.currentTarget.dataset.oid;
        t.currentTarget.dataset.index;
        wx.showModal({
            title: "提示",
            content: "确认取消退款吗",
            showCancel: !0,
            success: function(t) {
                t.confirm && app.util.request({
                    url: "entry/wxapp/SetOrderStatus",
                    data: {
                        oid: e,
                        ordertype: 1,
                        status: 1,
                        refund: 4
                    },
                    success: function(t) {
                        2 == t.data ? wx.showToast({
                            title: "申请失败！",
                            icon: "none",
                            duration: 2e3
                        }) : wx.showToast({
                            title: "申请成功！",
                            icon: "success",
                            duration: 500
                        });
                    },
                    fail: function(t) {
                        console.log(t.data), wx.showModal({
                            title: "提示信息",
                            content: t.data.message,
                            showCancel: !1,
                            success: function(t) {}
                        });
                    }
                });
            },
            fail: function(t) {},
            complete: function(t) {}
        });
    }
});