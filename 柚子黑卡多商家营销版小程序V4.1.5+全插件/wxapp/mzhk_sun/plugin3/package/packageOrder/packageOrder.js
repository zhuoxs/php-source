/*   time:2019-08-09 13:18:47*/
var app = getApp();

function sendMessage(t) {
    app.util.request({
        url: "entry/wxapp/SendMessagePay",
        data: t,
        success: function(a) {
            console.log(a), console.log(t), console.log("发送成功")
        }
    })
}
Page({
    data: {
        curIndex: 0,
        nav: ["全部", "待支付", "已支付", "已完成"],
        statusstr: ["", "已取消订单", "待支付", "待使用", "待收货", "已完成"],
        orderlist: [],
        isclick: !1,
        choose: [{
            name: "微信支付",
            value: "1",
            icon: "/style/images/wx.png",
            checked: "checked"
        }],
        payStatus: 0,
        payType: "1",
        g_order_id: 0,
        g_f_index: "",
        isPackage: !1,
        rcontent: [],
        rid: 0,
        gid: 0,
        newtotalprice: 0,
        unionredpacket: !1,
        load: !0,
        page: 1
    },
    onLoad: function(a) {
        var e = this,
            t = app.getSiteUrl();
        t ? e.setData({
            url: t
        }) : app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            success: function(a) {
                wx.setStorageSync("url", a.data), t = a.data, e.setData({
                    url: t
                })
            }
        }), app.util.request({
            url: "entry/wxapp/System",
            cachetime: "30",
            showLoading: !1,
            success: function(a) {
                console.log(a.data);
                var t = e.data.choose;
                if (1 == a.data.isopen_recharge) {
                    t = t.concat([{
                        name: "余额支付",
                        value: "2",
                        icon: "/style/images/yuelogo.png",
                        checked: ""
                    }])
                }
                e.setData({
                    choose: t,
                    hk_userrules: a.data.hk_userrules
                }), wx.setNavigationBarColor({
                    frontColor: a.data.fontcolor ? a.data.fontcolor : "",
                    backgroundColor: a.data.color ? a.data.color : "",
                    animation: {
                        duration: 0,
                        timingFunc: "easeIn"
                    }
                })
            }
        })
    },
    bargainTap: function(a) {
        var t = this,
            e = parseInt(a.currentTarget.dataset.index),
            o = wx.getStorageSync("users").id;
        app.util.request({
            url: "entry/wxapp/orderlist",
            data: {
                status: e,
                uid: o,
                page: 1,
                m: app.globalData.Plugin_package
            },
            success: function(a) {
                console.log(a.data), 2 == a.data ? t.setData({
                    orderlist: [],
                    page: 1,
                    load: !0
                }) : t.setData({
                    orderlist: a.data,
                    page: 1,
                    load: !0
                })
            }
        }), this.setData({
            curIndex: e,
            page: 1,
            load: !0
        })
    },
    radioChange: function(a) {
        var t = a.detail.value;
        console.log(t), this.setData({
            payType: t
        })
    },
    formSubmit: function(a) {
        var t = a.detail.formId;
        this.setData({
            form_id: t
        })
    },
    showPay: function(a) {
        console.log(a);
        var t = a.currentTarget.dataset.statu,
            e = (a.currentTarget.dataset.order_id, wx.getStorageSync("openid"), 0),
            o = "",
            s = 0,
            n = a.currentTarget.dataset.pid;
        1 == t && (e = a.currentTarget.dataset.order_id, o = a.currentTarget.dataset.f_index, s = a.currentTarget.dataset.price), this.setData({
            payStatus: t,
            g_order_id: e,
            g_f_index: o,
            totalprice: s,
            payType: 1,
            pid: n
        })
    },
    toPay: function(a) {
        var t = this,
            e = wx.getStorageSync("users").id,
            o = t.data.g_order_id,
            s = (t.data.g_f_index, t.data.payType),
            n = (t.data.orderlist, t.data.isclick),
            i = wx.getStorageSync("openid");
        if (n) return wx.showToast({
            title: "请稍后",
            icon: "none",
            duration: 1e3
        }), !1;
        t.setData({
            isclick: !0
        });
        var r = {
            orderarr: {
                order_id: o,
                openid: i,
                m: app.globalData.Plugin_package
            },
            SendMessagePay: {
                order_id: o,
                openid: i,
                form_id: t.data.form_id,
                m: app.globalData.Plugin_package
            },
            payType: s,
            url: 1
        };
        app.util.request({
            url: "entry/wxapp/ispay",
            data: {
                uid: e,
                pid: t.data.pid,
                m: app.globalData.Plugin_package
            },
            success: function(a) {
                1 == a.data ? t.pays(r) : wx.showToast({
                    title: "库存不足,无法下单"
                })
            }
        })
    },
    toRefundcannel: function(a) {
        var e = this,
            t = a.currentTarget.dataset.order_id,
            o = a.currentTarget.dataset.f_index,
            s = e.data.orderlist;
        wx.showModal({
            title: "提示",
            content: "确认取消退款吗",
            showCancel: !0,
            success: function(a) {
                a.confirm && app.util.request({
                    url: "entry/wxapp/SetOrderStatus",
                    data: {
                        order_id: t,
                        m: app.globalData.Plugin_package,
                        refund: 4
                    },
                    success: function(a) {
                        0 == a.data ? wx.showToast({
                            title: "申请失败！",
                            icon: "none",
                            duration: 2e3
                        }) : (wx.showToast({
                            title: "申请成功！",
                            icon: "success",
                            duration: 500
                        }), s[o].isrefund, e.setData({
                            orderlist: s
                        }))
                    },
                    fail: function(t) {
                        console.log(t.data), wx.showModal({
                            title: "提示信息",
                            content: t.data.message,
                            showCancel: !1,
                            success: function(a) {
                                s[o].status = t.data.data.status, console.log(s), e.setData({
                                    orderlist: s
                                })
                            }
                        })
                    }
                })
            },
            fail: function(a) {},
            complete: function(a) {}
        })
    },
    toRefund: function(a) {
        var e = this,
            t = a.currentTarget.dataset.order_id,
            o = a.currentTarget.dataset.f_index,
            s = e.data.orderlist;
        wx.showModal({
            title: "提示",
            content: "确认申请退款吗",
            showCancel: !0,
            success: function(a) {
                a.confirm && app.util.request({
                    url: "entry/wxapp/packagerefund",
                    data: {
                        oid: t,
                        m: app.globalData.Plugin_package
                    },
                    success: function(a) {
                        0 == a.data ? wx.showToast({
                            title: "申请失败！",
                            icon: "none",
                            duration: 2e3
                        }) : (wx.showToast({
                            title: "申请成功！",
                            icon: "success",
                            duration: 500
                        }), s[o].isrefund = 1, e.setData({
                            orderlist: s
                        }))
                    },
                    fail: function(t) {
                        console.log(t.data), wx.showModal({
                            title: "提示信息",
                            content: t.data.message,
                            showCancel: !1,
                            success: function(a) {
                                s[o].status = t.data.data.status, console.log(s), e.setData({
                                    orderlist: s
                                })
                            }
                        })
                    }
                })
            },
            fail: function(a) {},
            complete: function(a) {}
        })
    },
    toCancel: function(a) {
        var t = this,
            e = a.currentTarget.dataset.order_id,
            o = a.currentTarget.dataset.f_index,
            s = t.data.orderlist;
        wx.showModal({
            title: "提示",
            content: "确认取消该订单吗",
            showCancel: !0,
            success: function(a) {
                a.confirm && app.util.request({
                    url: "entry/wxapp/packagecancel",
                    data: {
                        oid: e,
                        m: app.globalData.Plugin_package
                    },
                    success: function(a) {
                        0 == a.data ? wx.showToast({
                            title: "取消订单失败！",
                            icon: "none",
                            duration: 2e3
                        }) : (wx.showToast({
                            title: "取消订单成功！",
                            icon: "success",
                            duration: 500
                        }), s[o].status = 6, console.log(s), t.setData({
                            orderlist: s
                        }))
                    }
                })
            },
            fail: function(a) {},
            complete: function(a) {}
        })
    },
    onReady: function() {},
    onShow: function() {
        var t = this,
            a = wx.getStorageSync("users").id;
        app.util.request({
            url: "entry/wxapp/orderlist",
            data: {
                uid: a,
                status: 0,
                page: 1,
                m: app.globalData.Plugin_package
            },
            success: function(a) {
                t.setData({
                    orderlist: a.data,
                    isclick: !1,
                    payStatus: 0
                })
            }
        })
    },
    onReachBottom: function() {
        var e = this,
            a = e.data.curIndex,
            t = wx.getStorageSync("users").id,
            o = (wx.getStorageSync("brand_info"), e.data.orderlist),
            s = ++e.data.page;
        app.util.request({
            url: "entry/wxapp/orderlist",
            data: {
                status: a,
                uid: t,
                page: s,
                m: app.globalData.Plugin_package
            },
            success: function(a) {
                if (0 == a.data) wx.showToast({
                    title: "已经没有内容了哦！！！",
                    icon: "none"
                });
                else {
                    var t = a.data;
                    o = o.concat(t), console.log(s), e.setData({
                        orderlist: o,
                        page: s
                    })
                }
            }
        })
    },
    onShareAppMessage: function(a) {
        var t = this.data.gid,
            e = wx.getStorageSync("users"),
            o = this.data.rcontent,
            s = o.id,
            n = o.rname,
            i = this.data.orderlist[0].oid;
        if (console.log(i), "button" === a.from && console.log(a.target), 0 == t) var r = "/mzhk_sun/pages/index/index";
        else r = "/mzhk_sun/plugin3/secondary/detail/detail?id=" + t + "&rid=" + s + "&user_id=" + e.id + "&oid=" + i + "&is_redshare=1";
        return {
            title: n,
            path: r,
            success: function(a) {
                console.log("转发成功")
            },
            fail: function(a) {
                console.log("转发失败")
            }
        }
    },
    toOrderder: function(a) {
        var t = a.currentTarget.dataset.order_id;
        wx.navigateTo({
            url: "../packageOrderInfo/packageOrderInfo?order_id=" + t + "&ordertypes=12"
        })
    },
    pays: function(a) {
        var t = this,
            e = a.orderarr,
            o = a.payType,
            s = a.message;
        1 == o ? app.util.request({
            url: "entry/wxapp/Orderarr",
            data: e,
            success: function(a) {
                console.log(a.data), wx.requestPayment({
                    timeStamp: a.data.timeStamp,
                    nonceStr: a.data.nonceStr,
                    package: a.data.package,
                    signType: a.data.signType,
                    paySign: a.data.paySign,
                    success: function(a) {
                        wx.showToast({
                            title: "支付成功",
                            icon: "success",
                            duration: 2e3
                        }), sendMessage(s), t.onShow()
                    },
                    fail: function(a) {
                        wx.showToast({
                            title: "支付失败",
                            icon: "none",
                            duration: 2e3
                        }), console.log("失败00003"), t.setData({
                            continuesubmit: !0,
                            isclickpay: !1,
                            isclick: !1
                        })
                    }
                })
            },
            fail: function(a) {
                console.log("失败00002"), t.setData({
                    continuesubmit: !0,
                    isclickpay: !1,
                    isclick: !1
                }), wx.showModal({
                    title: "提示信息",
                    content: a.data.message,
                    showCancel: !1
                })
            }
        }) : 2 == o && (console.log("余额"), console.log(e), app.util.request({
            url: "entry/wxapp/OrderarrYue",
            data: e,
            success: function(a) {
                wx.showToast({
                    title: "支付成功",
                    icon: "success",
                    duration: 2e3
                }), sendMessage(s), t.onShow()
            },
            fail: function(a) {
                console.log("失败00004"), t.setData({
                    continuesubmit: !0,
                    isclickpay: !1,
                    isclick: !1
                }), wx.showModal({
                    title: "提示信息",
                    content: a.data.message,
                    showCancel: !1
                })
            }
        }))
    }
});