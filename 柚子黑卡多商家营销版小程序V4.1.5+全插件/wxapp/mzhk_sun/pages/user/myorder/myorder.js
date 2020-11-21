var app = getApp();

Page({
    data: {
        navTile: "抢购订单",
        curIndex: 0,
        nav: [ "全部", "待支付", "待使用", "待收货", "完成/售后" ],
        status: [ 0, 2, 3, 4, 5 ],
        statusstr: [ "", "已取消订单", "待支付", "待使用", "待收货", "已完成" ],
        orderlist: [],
        url: "",
        page: [ 1, 1, 1, 1, 1 ],
        isclick: !1,
        choose: [ {
            name: "微信支付",
            value: "1",
            icon: "/style/images/wx.png",
            checked: "checked"
        } ],
        payStatus: 0,
        payType: "1",
        g_order_id: 0,
        g_f_index: "",
        isPackage: !1,
        rcontent: [],
        rid: 0,
        gid: 0,
        newtotalprice: 0,
        brands: [],
        unionredpacket: !1,
        open_lottery: 0
    },
    onLoad: function(a) {
        var e = this;
        a.id && app.util.request({
            url: "entry/wxapp/Plugin",
            data: {
                type: 5
            },
            showLoading: !1,
            success: function(t) {
                2 != t.data && (app.util.request({
                    url: "entry/wxapp/Getredpacket3",
                    showLoading: !1,
                    data: {
                        gid: a.id,
                        m: app.globalData.Plugin_redpacket
                    },
                    success: function(t) {
                        console.log(t.data), 2 != t.data ? e.setData({
                            rcontent: t.data,
                            isPackage: !0,
                            rid: t.data.id,
                            gid: a.id
                        }) : e.setData({
                            rcontent: [],
                            isPackage: !1,
                            rid: 0
                        });
                    }
                }), app.util.request({
                    url: "entry/wxapp/Getredpacket4",
                    showLoading: !1,
                    data: {
                        gid: a.id,
                        openid: wx.getStorageSync("openid"),
                        m: app.globalData.Plugin_redpacket
                    },
                    success: function(t) {
                        console.log(t.data), 2 != t.data ? e.setData({
                            urcontent: t.data,
                            unionredpacket: !0,
                            gid: a.id,
                            isPackage: !1
                        }) : e.setData({
                            urcontent: [],
                            unionredpacket: !1
                        });
                    }
                }));
            }
        }), app.util.request({
            url: "entry/wxapp/Plugin",
            data: {
                type: 9
            },
            showLoading: !1,
            success: function(t) {
                console.log(t), 2 != t.data && e.setData({
                    open_lottery: 1
                });
            }
        }), wx.setNavigationBarTitle({
            title: e.data.navTile
        });
        var t = app.getSiteUrl();
        e.setData({
            url: t
        }), app.util.request({
            url: "entry/wxapp/System",
            cachetime: "30",
            showLoading: !1,
            success: function(t) {
                var a = e.data.choose;
                if (1 == t.data.isopen_recharge) {
                    a = a.concat([ {
                        name: "余额支付",
                        value: "2",
                        icon: "/style/images/yuelogo.png",
                        checked: ""
                    } ]);
                }
                e.setData({
                    choose: a,
                    hk_userrules: t.data.hk_userrules
                }), wx.setNavigationBarColor({
                    frontColor: t.data.fontcolor ? t.data.fontcolor : "",
                    backgroundColor: t.data.color ? t.data.color : "",
                    animation: {
                        duration: 0,
                        timingFunc: "easeIn"
                    }
                });
            }
        });
        var n = a.tab ? a.tab : 0, o = e.data.status[n], r = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/getOrder",
            data: {
                orderstatus: o,
                openid: r
            },
            success: function(t) {
                2 == t.data ? e.setData({
                    orderlist: [],
                    curIndex: n
                }) : e.setData({
                    orderlist: t.data,
                    curIndex: n
                });
            }
        });
    },
    bargainTap: function(t) {
        var a = this, e = parseInt(t.currentTarget.dataset.index), n = a.data.status[e], o = wx.getStorageSync("openid"), r = [ 1, 1, 1, 1, 1 ];
        app.util.request({
            url: "entry/wxapp/getOrder",
            data: {
                orderstatus: n,
                openid: o
            },
            success: function(t) {
                2 == t.data ? a.setData({
                    orderlist: [],
                    page: r
                }) : a.setData({
                    orderlist: t.data,
                    page: r
                });
            }
        }), this.setData({
            curIndex: e
        });
    },
    radioChange: function(t) {
        var a = t.detail.value;
        console.log(a), this.setData({
            payType: a
        });
    },
    showPay: function(t) {
        var a = this, e = t.currentTarget.dataset.statu, n = t.currentTarget.dataset.order_id, o = (a.data.newtotalprice, 
        wx.getStorageSync("openid")), r = 0, s = "", i = 0;
        1 == e && (r = t.currentTarget.dataset.order_id, s = t.currentTarget.dataset.f_index, 
        i = t.currentTarget.dataset.price), 1 == t.currentTarget.dataset.iscj && a.setData({
            gid: t.currentTarget.dataset.gid,
            cjid: t.currentTarget.dataset.cjid,
            iscj: t.currentTarget.dataset.iscj
        }), app.util.request({
            url: "entry/wxapp/Firstbuy2",
            cachetime: "0",
            showLoading: !1,
            data: {
                lid: 5,
                oid: n,
                openid: o
            },
            success: function(t) {
                console.log(t.data), t.data;
            },
            fail: function(t) {
                return wx.showModal({
                    title: "提示信息",
                    content: t.data.message,
                    showCancel: !1,
                    success: function(t) {
                        a.setData({
                            payStatus: 0
                        });
                    }
                }), !1;
            }
        }), a.setData({
            payStatus: e,
            g_order_id: r,
            g_f_index: s,
            totalprice: i,
            payType: 1
        });
    },
    toPay: function(t) {
        var a = this, e = wx.getStorageSync("openid"), n = a.data.g_order_id, o = a.data.g_f_index, r = a.data.payType, s = a.data.orderlist;
        if (a.data.isclick) return wx.showToast({
            title: "请稍后",
            icon: "none",
            duration: 1e3
        }), !1;
        a.setData({
            isclick: !0
        });
        var i = {
            payType: r,
            resulttype: 3,
            orderarr: "",
            SendMessagePay: "",
            PayOrder: "",
            SendSms: "",
            PayOrderurl: "entry/wxapp/PayqgOrder",
            PayredirectTourl: {
                status: 3,
                f_index: o,
                orderlist: s
            }
        };
        i.orderarr = {
            openid: e,
            order_id: n,
            price: a.data.totalprice
        }, i.PayOrder = {
            order_id: n
        }, app.func.orderarr(app, a, i);
    },
    toRefundcannel: function(t) {
        var e = this, a = t.currentTarget.dataset.order_id, n = t.currentTarget.dataset.f_index, o = e.data.orderlist;
        wx.showModal({
            title: "提示",
            content: "确认取消退款吗",
            showCancel: !0,
            success: function(t) {
                t.confirm && app.util.request({
                    url: "entry/wxapp/SetOrderStatus",
                    data: {
                        order_id: a,
                        ordertype: 0,
                        status: 1,
                        refund: 4
                    },
                    success: function(t) {
                        2 == t.data ? wx.showToast({
                            title: "申请失败！",
                            icon: "none",
                            duration: 2e3
                        }) : (wx.showToast({
                            title: "申请成功！",
                            icon: "success",
                            duration: 500
                        }), o[n].isrefund = 0, e.setData({
                            orderlist: o
                        }));
                    },
                    fail: function(a) {
                        console.log(a.data), wx.showModal({
                            title: "提示信息",
                            content: a.data.message,
                            showCancel: !1,
                            success: function(t) {
                                o[n].status = a.data.data.status, console.log(o), e.setData({
                                    orderlist: o
                                });
                            }
                        });
                    }
                });
            },
            fail: function(t) {},
            complete: function(t) {}
        });
    },
    toRefund: function(t) {
        var e = this, a = t.currentTarget.dataset.order_id, n = t.currentTarget.dataset.f_index, o = e.data.orderlist;
        wx.showModal({
            title: "提示",
            content: "确认申请退款吗",
            showCancel: !0,
            success: function(t) {
                t.confirm && app.util.request({
                    url: "entry/wxapp/SetOrderStatus",
                    data: {
                        order_id: a,
                        ordertype: 0,
                        refund: 1
                    },
                    success: function(t) {
                        2 == t.data ? wx.showToast({
                            title: "申请失败！",
                            icon: "none",
                            duration: 2e3
                        }) : (wx.showToast({
                            title: "申请成功！",
                            icon: "success",
                            duration: 500
                        }), o[n].isrefund = 1, console.log(o), e.setData({
                            orderlist: o
                        }));
                    },
                    fail: function(a) {
                        console.log(a.data), wx.showModal({
                            title: "提示信息",
                            content: a.data.message,
                            showCancel: !1,
                            success: function(t) {
                                o[n].status = a.data.data.status, console.log(o), e.setData({
                                    orderlist: o
                                });
                            }
                        });
                    }
                });
            },
            fail: function(t) {},
            complete: function(t) {}
        });
    },
    toReceipt: function(t) {
        var a = this, e = t.currentTarget.dataset.order_id, n = t.currentTarget.dataset.f_index, o = a.data.orderlist, r = wx.getStorageSync("openid");
        wx.showModal({
            title: "提示",
            content: "确定要确认收货吗？",
            showCancel: !0,
            success: function(t) {
                t.confirm && app.util.request({
                    url: "entry/wxapp/SetOrderFinish",
                    data: {
                        order_id: e,
                        openid: r,
                        ordertype: 0
                    },
                    success: function(t) {
                        console.log(123456), console.log(t.data), console.log(789456), 2 == t.data ? wx.showToast({
                            title: "收货失败！",
                            icon: "none",
                            duration: 2e3
                        }) : (wx.showToast({
                            title: "收货成功！",
                            icon: "success",
                            duration: 500
                        }), o[n].status = 5, console.log(o), a.setData({
                            orderlist: o
                        }));
                    }
                });
            },
            fail: function(t) {},
            complete: function(t) {}
        });
    },
    toCancel: function(t) {
        var a = this, e = t.currentTarget.dataset.order_id, n = t.currentTarget.dataset.f_index, o = a.data.orderlist;
        wx.showModal({
            title: "提示",
            content: "确认取消该订单吗",
            showCancel: !0,
            success: function(t) {
                t.confirm && app.util.request({
                    url: "entry/wxapp/SetOrderStatus",
                    data: {
                        order_id: e,
                        status: 1
                    },
                    success: function(t) {
                        console.log(123456), console.log(t.data), console.log(789456), 2 == t.data ? wx.showToast({
                            title: "取消订单失败！",
                            icon: "none",
                            duration: 2e3
                        }) : (wx.showToast({
                            title: "取消订单成功！",
                            icon: "success",
                            duration: 500
                        }), o[n].status = 1, console.log(o), a.setData({
                            orderlist: o
                        }));
                    }
                });
            },
            fail: function(t) {},
            complete: function(t) {}
        });
    },
    toOrderder: function(t) {
        var a = t.currentTarget.dataset.order_id;
        wx.navigateTo({
            url: "../orderdet/orderdet?order_id=" + a
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {
        var e = this, n = e.data.curIndex, t = e.data.status[n], a = wx.getStorageSync("openid"), o = e.data.orderlist, r = e.data.page, s = r[n];
        app.util.request({
            url: "entry/wxapp/getOrder",
            cachetime: "10",
            data: {
                orderstatus: t,
                openid: a,
                page: s
            },
            success: function(t) {
                if (2 == t.data) wx.showToast({
                    title: "已经没有内容了哦！！！",
                    icon: "none"
                }); else {
                    var a = t.data;
                    o = o.concat(a), r[n] = s + 1, console.log(r), e.setData({
                        orderlist: o,
                        page: r
                    });
                }
            }
        });
    },
    onPackage: function() {
        this.setData({
            isPackage: !this.data.isPackage
        });
    },
    onShareAppMessage: function(t) {
        var a = this.data.gid, e = wx.getStorageSync("users"), n = this.data.rcontent, o = n.id, r = n.rname, s = this.data.orderlist[0].oid;
        if (console.log(s), "button" === t.from && console.log(t.target), 0 == a) var i = "/mzhk_sun/pages/index/index"; else i = "/mzhk_sun/pages/index/package/package?id=" + a + "&rid=" + o + "&user_id=" + e.id + "&oid=" + s + "&is_redshare=1";
        return {
            title: r,
            path: i,
            success: function(t) {
                console.log("转发成功");
            },
            fail: function(t) {
                console.log("转发失败");
            }
        };
    },
    showredpacket: function(t) {
        var a = this, e = t.currentTarget.dataset.gid;
        app.util.request({
            url: "entry/wxapp/Getredpacket3",
            showLoading: !1,
            data: {
                gid: e,
                m: app.globalData.Plugin_redpacket
            },
            success: function(t) {
                console.log(t.data), 2 != t.data ? a.setData({
                    rcontent: t.data,
                    isPackage: !0,
                    rid: t.data.id,
                    gid: e,
                    unionredpacket: !1
                }) : a.setData({
                    rcontent: [],
                    isPackage: !1,
                    rid: 0,
                    gid: 0
                });
            }
        });
    },
    getUredpacket: function(t) {
        var a = this, e = t.currentTarget.dataset.rid, n = t.currentTarget.dataset.bid, o = t.currentTarget.dataset.unid, r = t.currentTarget.dataset.index, s = a.data.gid, i = wx.getStorageSync("openid"), d = a.data.urcontent;
        app.util.request({
            url: "entry/wxapp/getUredpacket",
            showLoading: !1,
            data: {
                rid: e,
                bid: n,
                unid: o,
                gid: s,
                openid: i,
                m: app.globalData.Plugin_redpacket
            },
            success: function(t) {
                console.log(t.data), 2 != t.data && (d[r].isgive = 1, a.setData({
                    urcontent: d
                }));
            }
        });
    },
    getAll: function(t) {
        var e = this, a = e.data.gid, n = wx.getStorageSync("openid"), o = e.data.urcontent;
        app.util.request({
            url: "entry/wxapp/getAll",
            showLoading: !1,
            data: {
                gid: a,
                openid: n,
                m: app.globalData.Plugin_redpacket
            },
            success: function(t) {
                if (console.log(t.data), 2 != t.data) {
                    for (var a = 0; a < o.length; a++) o[a].isgive = 1;
                    e.setData({
                        urcontent: o
                    });
                }
            }
        });
    },
    onPackage2: function() {
        this.setData({
            unionredpacket: !this.data.unionredpacket
        });
    },
    showredpacket2: function(t) {
        var a = this, e = t.currentTarget.dataset.gid;
        app.util.request({
            url: "entry/wxapp/Getredpacket4",
            showLoading: !1,
            data: {
                gid: e,
                openid: wx.getStorageSync("openid"),
                m: app.globalData.Plugin_redpacket
            },
            success: function(t) {
                if (console.log(t.data), t.data.length <= 0) return wx.showModal({
                    title: "提示信息",
                    content: "已全部领取",
                    showCancel: !1
                }), !1;
                2 != t.data ? a.setData({
                    urcontent: t.data,
                    unionredpacket: !0,
                    gid: e,
                    isPackage: !1
                }) : a.setData({
                    urcontent: [],
                    brands: [],
                    unionredpacket: !1,
                    gid: 0
                });
            }
        });
    },
    toComment: function(t) {
        var a = t.currentTarget.dataset.order_id, e = t.currentTarget.dataset.gid;
        app.util.request({
            url: "entry/wxapp/IsComment",
            showLoading: !1,
            data: {
                oid: a,
                gid: e,
                type: 1
            },
            success: function(t) {
                if (console.log(t.data), 2 == t.data) return wx.showModal({
                    title: "提示信息",
                    content: "已评论",
                    showCancel: !1
                }), !1;
                wx.navigateTo({
                    url: "/mzhk_sun/pages/dynamic/dynamicedit/dynamicedit?oid=" + a + "&gid=" + e
                });
            }
        });
    },
    toLottery: function(t) {
        var a = t.currentTarget.dataset.gid;
        wx.navigateTo({
            url: "/mzhk_sun/plugin4/ticket/ticketmiandetail/ticketmiandetail?gid=" + a
        });
    }
});