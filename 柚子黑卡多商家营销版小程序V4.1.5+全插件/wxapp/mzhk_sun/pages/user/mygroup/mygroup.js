var app = getApp();

Page({
    data: {
        navTile: "我的拼团",
        curIndex: 0,
        nav: [ "全部", "待付款", "拼团中", "已成团", "待收货", "完成/售后" ],
        orderlist: [],
        status: [ 0, 2, 3, 4, 6, 5 ],
        statusstr: [ "", "已取消订单", "待支付", "拼团中", "已成团", "已完成", "待收货" ],
        url: "",
        page: [ 1, 1, 1, 1, 1, 1 ],
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
        }), wx.setNavigationBarTitle({
            title: e.data.navTile
        });
        var o = app.getSiteUrl();
        o ? e.setData({
            url: o
        }) : app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            success: function(t) {
                wx.setStorageSync("url", t.data), o = t.data, e.setData({
                    url: o
                });
            }
        }), app.util.request({
            url: "entry/wxapp/System",
            cachetime: "30",
            showLoading: !1,
            success: function(t) {
                console.log(t.data);
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
        var t = wx.getStorageSync("openid"), r = a.tab;
        r = r || 0;
        var n = e.data.status[r];
        app.util.request({
            url: "entry/wxapp/getGroupOrder",
            data: {
                orderstatus: n,
                openid: t
            },
            success: function(t) {
                2 == t.data ? e.setData({
                    orderlist: [],
                    curIndex: r
                }) : e.setData({
                    orderlist: t.data,
                    curIndex: r
                });
            }
        }), app.util.request({
            url: "entry/wxapp/CheckGroup",
            success: function(t) {
                console.log("成功"), console.log(t.data);
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
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {
        var e = this, o = e.data.curIndex;
        o = null == o ? 0 : o;
        var t = e.data.status[o], a = wx.getStorageSync("openid"), r = e.data.orderlist, n = e.data.page, d = n[o];
        console.log(o + "---" + d), app.util.request({
            url: "entry/wxapp/getGroupOrder",
            cachetime: "10",
            data: {
                orderstatus: t,
                openid: a,
                page: d
            },
            success: function(t) {
                if (2 == t.data) wx.showToast({
                    title: "已经没有内容了哦！！！",
                    icon: "none"
                }); else {
                    var a = t.data;
                    r = r.concat(a), n[o] = d + 1, console.log(n), e.setData({
                        orderlist: r,
                        page: n
                    });
                }
            }
        });
    },
    bargainTap: function(t) {
        var a = this, e = parseInt(t.currentTarget.dataset.index), o = a.data.status[e], r = wx.getStorageSync("openid"), n = [ 1, 1, 1, 1, 1, 1 ];
        app.util.request({
            url: "entry/wxapp/getGroupOrder",
            data: {
                orderstatus: o,
                openid: r
            },
            success: function(t) {
                2 == t.data ? a.setData({
                    orderlist: [],
                    page: n
                }) : a.setData({
                    orderlist: t.data,
                    page: n
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
        var a = this, e = t.currentTarget.dataset.statu, o = t.currentTarget.dataset.g_order_id, r = (a.data.newtotalprice, 
        wx.getStorageSync("openid")), n = 0, d = 0, s = "", i = 0, c = 0;
        1 == e && (d = t.currentTarget.dataset.order_id, n = t.currentTarget.dataset.g_order_id, 
        s = t.currentTarget.dataset.f_index, i = t.currentTarget.dataset.price, c = t.currentTarget.dataset.is_lead), 
        1 == t.currentTarget.dataset.iscj && a.setData({
            gid: t.currentTarget.dataset.gid,
            cjid: t.currentTarget.dataset.cjid,
            iscj: t.currentTarget.dataset.iscj
        }), app.util.request({
            url: "entry/wxapp/Firstbuy2",
            cachetime: "0",
            showLoading: !1,
            data: {
                lid: 3,
                oid: o,
                openid: r
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
            order_id: d,
            g_order_id: n,
            g_f_index: s,
            totalprice: i,
            is_lead: c,
            payType: 1
        });
    },
    toPay: function(t) {
        var a = this, e = wx.getStorageSync("openid"), o = a.data.g_order_id, r = a.data.order_id, n = a.data.g_f_index, d = a.data.payType, s = a.data.orderlist, i = a.data.is_lead;
        if (a.data.isclick) return wx.showToast({
            title: "请稍后",
            icon: "none",
            duration: 1e3
        }), !1;
        a.setData({
            isclick: !0
        });
        var c = {
            payType: d,
            resulttype: 3,
            orderarr: "",
            SendMessagePay: "",
            PayOrder: "",
            SendSms: "",
            PayOrderurl: "entry/wxapp/PayptOrder",
            PayredirectTourl: {
                status: 3,
                f_index: n,
                orderlist: s
            }
        };
        c.orderarr = {
            openid: e,
            order_id: r,
            g_order_id: o,
            ordertype: 1,
            price: a.data.totalprice,
            is_lead: i
        }, c.PayOrder = {
            order_id: r,
            g_order_id: o,
            openid: e
        }, app.func.orderarr(app, a, c);
    },
    toRefundcannel: function(t) {
        var e = this, a = t.currentTarget.dataset.order_id, o = t.currentTarget.dataset.g_order_id, r = t.currentTarget.dataset.f_index, n = e.data.orderlist;
        wx.showModal({
            title: "提示",
            content: "确认取消退款吗",
            showCancel: !0,
            success: function(t) {
                t.confirm && app.util.request({
                    url: "entry/wxapp/SetOrderStatus",
                    data: {
                        order_id: a,
                        g_order_id: o,
                        ordertype: 1,
                        status: 1,
                        refund: 4
                    },
                    success: function(t) {
                        console.log(123456), console.log(t.data), console.log(789456), 2 == t.data ? wx.showToast({
                            title: "申请失败！",
                            icon: "none",
                            duration: 2e3
                        }) : (wx.showToast({
                            title: "申请成功！",
                            icon: "success",
                            duration: 500
                        }), n[r].isrefund = 0, console.log(n), e.setData({
                            orderlist: n
                        }));
                    },
                    fail: function(a) {
                        console.log(a.data), wx.showModal({
                            title: "提示信息",
                            content: a.data.message,
                            showCancel: !1,
                            success: function(t) {
                                n[r].status = a.data.data.status, console.log(n), e.setData({
                                    orderlist: n
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
        var e = this, a = t.currentTarget.dataset.order_id, o = t.currentTarget.dataset.g_order_id, r = t.currentTarget.dataset.f_index, n = e.data.orderlist;
        wx.showModal({
            title: "提示",
            content: "确认申请退款吗",
            showCancel: !0,
            success: function(t) {
                t.confirm && app.util.request({
                    url: "entry/wxapp/SetOrderStatus",
                    data: {
                        order_id: a,
                        g_order_id: o,
                        ordertype: 1,
                        refund: 1
                    },
                    success: function(t) {
                        console.log(123456), console.log(t.data), console.log(789456), 2 == t.data ? wx.showToast({
                            title: "申请失败！",
                            icon: "none",
                            duration: 2e3
                        }) : (wx.showToast({
                            title: "申请成功！",
                            icon: "success",
                            duration: 500
                        }), n[r].isrefund = 1, console.log(n), e.setData({
                            orderlist: n
                        }));
                    },
                    fail: function(a) {
                        console.log(a.data), wx.showModal({
                            title: "提示信息",
                            content: a.data.message,
                            showCancel: !1,
                            success: function(t) {
                                n[r].status = a.data.data.status, console.log(n), e.setData({
                                    orderlist: n
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
        var a = this, e = t.currentTarget.dataset.order_id, o = t.currentTarget.dataset.g_order_id, r = t.currentTarget.dataset.f_index, n = a.data.orderlist, d = wx.getStorageSync("openid");
        wx.showModal({
            title: "提示",
            content: "确定要确认收货吗？",
            showCancel: !0,
            success: function(t) {
                t.confirm && app.util.request({
                    url: "entry/wxapp/SetOrderFinish",
                    data: {
                        order_id: e,
                        g_order_id: o,
                        openid: d,
                        ordertype: 1
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
                        }), n[r].status = 5, console.log(n), a.setData({
                            orderlist: n
                        }));
                    }
                });
            },
            fail: function(t) {},
            complete: function(t) {}
        });
    },
    toCancel: function(t) {
        var a = this, e = t.currentTarget.dataset.order_id, o = t.currentTarget.dataset.g_order_id, r = t.currentTarget.dataset.f_index, n = a.data.orderlist;
        wx.showModal({
            title: "提示",
            content: "确认取消该订单吗",
            showCancel: !0,
            success: function(t) {
                t.confirm && app.util.request({
                    url: "entry/wxapp/SetOrderStatus",
                    data: {
                        order_id: e,
                        g_order_id: o,
                        ordertype: 1,
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
                        }), n[r].status = 1, console.log(n), a.setData({
                            orderlist: n
                        }));
                    }
                });
            },
            fail: function(t) {},
            complete: function(t) {}
        });
    },
    toShare: function(t) {
        var a = t.currentTarget.dataset.id, e = t.currentTarget.dataset.gid;
        wx.navigateTo({
            url: "../../index/goCantuan/goCantuan?id=" + a + "&gid=" + e
        });
    },
    toOrderder: function(t) {
        var a = t.currentTarget.dataset.order_id;
        wx.navigateTo({
            url: "../orderdet/orderdet?order_id=" + a + "&ordertype=1"
        });
    },
    onPackage: function() {
        this.setData({
            isPackage: !this.data.isPackage
        });
    },
    onShareAppMessage: function(t) {
        var a = this.data.gid, e = wx.getStorageSync("users"), o = this.data.rcontent, r = o.id, n = o.rname, d = this.data.orderlist[0].id;
        if (console.log(d), "button" === t.from && console.log(t.target), 0 == a) var s = "/mzhk_sun/pages/index/index"; else s = "/mzhk_sun/pages/index/groupdet/groupdet?id=" + a + "&rid=" + r + "&user_id=" + e.id + "&oid=" + d + "&is_redshare=1";
        return {
            title: n,
            path: s,
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
        var a = this, e = t.currentTarget.dataset.rid, o = t.currentTarget.dataset.bid, r = t.currentTarget.dataset.unid, n = t.currentTarget.dataset.index, d = a.data.gid, s = wx.getStorageSync("openid"), i = a.data.urcontent;
        app.util.request({
            url: "entry/wxapp/getUredpacket",
            showLoading: !1,
            data: {
                rid: e,
                bid: o,
                unid: r,
                gid: d,
                openid: s,
                m: app.globalData.Plugin_redpacket
            },
            success: function(t) {
                console.log(t.data), 2 != t.data && (i[n].isgive = 1, a.setData({
                    urcontent: i
                }));
            }
        });
    },
    getAll: function(t) {
        var e = this, a = e.data.gid, o = wx.getStorageSync("openid"), r = e.data.urcontent;
        app.util.request({
            url: "entry/wxapp/getAll",
            showLoading: !1,
            data: {
                gid: a,
                openid: o,
                m: app.globalData.Plugin_redpacket
            },
            success: function(t) {
                if (console.log(t.data), 2 != t.data) {
                    for (var a = 0; a < r.length; a++) r[a].isgive = 1;
                    e.setData({
                        urcontent: r
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
                type: 3
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