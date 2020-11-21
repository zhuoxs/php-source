var app = getApp();

Page({
    data: {
        curIndex: 0,
        navArr: [ "全部", "待付款", "待确认", "已完成" ],
        arrLen: [ 0, 0, 0, 0 ],
        all: [],
        dfk: [],
        dsh: [],
        tk: [],
        showpaybox: !1,
        paychoose: [ {
            name: "微信支付",
            value: "1",
            icon: "/style/images/wx.png"
        }, {
            name: "余额支付",
            value: "2",
            icon: "/style/images/local.png"
        } ],
        isclickpay: !1
    },
    onLoad: function(t) {
        var a = this, e = wx.getStorageSync("url");
        console.log(e), a.setData({
            url: e
        }), wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
        var o = a.data.arrLen;
        console.log(o), 0 < a.data.all.length && (o[0] = "1"), 0 < a.data.dfk.length && (o[1] = "1"), 
        0 < a.data.dsh.length && (o[2] = "1"), 0 < a.data.tk.length && (o[3] = "1"), a.setData({
            arrLen: o
        });
    },
    onReady: function() {},
    onShow: function() {
        console.log("-----------------刷新页面-------------");
        var a = this, t = wx.getStorageSync("openid"), e = a.data.curIndex, o = wx.getStorageSync("build_id");
        console.log(e), app.util.request({
            url: "entry/wxapp/GetOrder",
            cachetime: "0",
            data: {
                openid: t,
                tabCheck: e,
                build_id: o
            },
            success: function(t) {
                console.log(t), 0 == e ? a.setData({
                    allOrder: t.data
                }) : 1 == e ? a.setData({
                    unpaidOrder: t.data
                }) : 2 == e ? a.setData({
                    waitOrder: t.data
                }) : 3 == e && a.setData({
                    overOrder: t.data
                });
            }
        });
    },
    toquere: function(t) {
        var a = t.currentTarget.dataset.oid, e = wx.getStorageSync("openid"), o = this;
        app.util.request({
            url: "entry/wxapp/ConfirmOrder",
            cachetime: "0",
            data: {
                openid: e,
                order_id: a
            },
            success: function(t) {
                console.log(t), 1 == t.data ? wx.showToast({
                    title: "确认成功！"
                }) : wx.showToast({
                    title: "确认失败！",
                    icon: "none"
                }), o.onShow();
            }
        });
    },
    toDelete: function(t) {
        var a = t.currentTarget.dataset.oid, e = this;
        app.util.request({
            url: "entry/wxapp/deleteOrder",
            cachetime: "0",
            data: {
                order_id: a
            },
            success: function(t) {
                1 == t.data ? wx.showToast({
                    title: "删除成功！"
                }) : wx.showToast({
                    title: "删除失败！",
                    icon: "none"
                }), e.onShow();
            }
        });
    },
    showpay: function(t) {
        var a = t.currentTarget.dataset.payprice, e = t.currentTarget.dataset.id, o = t.currentTarget.dataset.index;
        this.setData({
            payprice: a,
            the_id: e,
            showpaybox: !0,
            whichone: o
        });
    },
    ClosePaybox: function() {
        this.setData({
            showpaybox: !1
        });
    },
    radioChange: function(t) {
        var a = t.detail.value;
        console.log(a), this.setData({
            rstatus: a
        });
    },
    submittopay: function() {
        var t = this, a = t.data.payprice, e = t.data.rstatus, o = t.data.the_id, n = t.data.allOrder, r = t.data.whichone, i = wx.getStorageSync("openid");
        if (n[r].status = 3, "" == e) return wx.showModal({
            title: "提示",
            content: "请选择支付方式",
            showCancel: !1
        }), !1;
        if (t.data.isclickpay) return console.log("重复点击"), !0;
        t.setData({
            isclickpay: !0
        });
        var s = {
            orderarr: {
                price: a,
                order_id: o,
                openid: i,
                ordertype: 2
            },
            payType: e,
            attrType: 1,
            orderType: 2,
            resulttype: 0,
            setdata: {
                allOrder: n,
                showpaybox: !1
            },
            PayredirectTourl: ""
        };
        app.func.orderarr(app, t, s);
    },
    tozhifu: function(t) {
        var a = this;
        console.log(t);
        var e = t.currentTarget.dataset.oid, o = t.currentTarget.dataset.price, n = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/orderarr",
            cachetime: "0",
            data: {
                openid: n,
                price: o
            },
            success: function(t) {
                console.log(t), wx.requestPayment({
                    timeStamp: t.data.timeStamp,
                    nonceStr: t.data.nonceStr,
                    package: t.data.package,
                    signType: "MD5",
                    paySign: t.data.paySign,
                    success: function(t) {
                        console.log(t), app.util.request({
                            url: "entry/wxapp/PaykjOrder",
                            cachetime: "0",
                            data: {
                                order_id: e
                            },
                            success: function(t) {
                                wx.showToast({
                                    title: "付款成功！"
                                }), a.onShow();
                            }
                        });
                    },
                    fail: function(t) {
                        console.log(t);
                    }
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    bargainTap: function(t) {
        var a = parseInt(t.currentTarget.dataset.index);
        console.log(a), this.setData({
            curIndex: a
        }), this.onShow();
    }
});