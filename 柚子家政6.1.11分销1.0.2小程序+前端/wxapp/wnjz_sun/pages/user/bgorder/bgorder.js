var app = getApp();

Page({
    data: {
        curIndex: 0,
        nav: [ "全部", "待付款", "待服务", "已完成" ],
        arrLen: [ "0", "0", "0", "0", "0" ],
        all: [],
        dfk: [],
        dsh: [],
        tk: []
    },
    onLoad: function(t) {
        this.getUrl(), wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        var e = this, t = wx.getStorageSync("openid"), a = wx.getStorageSync("build_id");
        app.util.request({
            url: "entry/wxapp/kjOrrde",
            cachetime: "0",
            method: "GET",
            data: {
                userid: t,
                build_id: a
            },
            success: function(t) {
                console.log(t), e.setData({
                    all: t.data,
                    status: !0
                }), e.getdazhifu(), e.getdaquer(), e.getoverconme();
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
    getdazhifu: function() {
        var t = wx.getStorageSync("openid"), e = wx.getStorageSync("build_id"), a = this;
        app.util.request({
            url: "entry/wxapp/kjdazhifu",
            cachetime: "0",
            method: "GET",
            data: {
                userid: t,
                build_id: e
            },
            success: function(t) {
                a.setData({
                    dfk: t.data
                });
            }
        });
    },
    getdaquer: function() {
        var t = wx.getStorageSync("openid"), e = wx.getStorageSync("build_id"), a = this;
        app.util.request({
            url: "entry/wxapp/kjdaqueren",
            cachetime: "0",
            method: "GET",
            data: {
                userid: t,
                build_id: e
            },
            success: function(t) {
                console.log(t), a.setData({
                    dsh: t.data
                });
            }
        });
    },
    getoverconme: function() {
        var t = wx.getStorageSync("openid"), e = wx.getStorageSync("build_id"), a = this;
        app.util.request({
            url: "entry/wxapp/overcome",
            cachetime: "0",
            method: "GET",
            data: {
                userid: t,
                build_id: e
            },
            success: function(t) {
                console.log(t), a.setData({
                    overcome: t.data
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    bargainTap: function(t) {
        var e = parseInt(t.currentTarget.dataset.index);
        this.setData({
            curIndex: e
        });
    },
    toDelete: function(t) {
        var e = t.currentTarget.dataset.oid, a = this, n = t.currentTarget.dataset.index, o = a.data.all;
        wx.showModal({
            title: "提示",
            content: "确认取消订单吗",
            success: function(t) {
                t.confirm ? (app.util.request({
                    url: "entry/wxapp/kjOrderDelete",
                    method: "GET",
                    data: {
                        id: e
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
        app.util.request({
            url: "entry/wxapp/kjOrderqueren",
            method: "GET",
            data: {
                id: a
            },
            success: function(t) {
                o[n].status = "5", e.setData({
                    all: o
                });
            }
        });
    },
    toService: function(t) {
        var e = t.currentTarget.dataset.oid;
        app.util.request({
            url: "entry/wxapp/toService",
            cachetime: "0",
            data: {
                id: e
            },
            success: function(t) {
                console.log(t);
            }
        }), this.onShow();
    },
    tozhifu: function(t) {
        var e = wx.getStorageSync("openid"), a = t.currentTarget.dataset.oid, n = t.currentTarget.dataset.price;
        t.currentTarget.dataset.index;
        app.util.request({
            url: "entry/wxapp/Orderarr",
            data: {
                price: n,
                openid: e,
                order_id: a,
                type: 2
            },
            success: function(t) {
                wx.requestPayment({
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
                            url: "entry/wxapp/kjOrderqueren",
                            cachetime: "0",
                            data: {
                                id: a
                            },
                            success: function(t) {
                                console.log("ceshi-----------------------"), console.log(t), console.log("ceshi-----------------------");
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
                        ordertype: 2,
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
                        ordertype: 2,
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