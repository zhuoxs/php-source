function _defineProperty(t, a, e) {
    return a in t ? Object.defineProperty(t, a, {
        value: e,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[a] = e, t;
}

var app = getApp();

Page({
    data: {
        navTile: "购物车订单",
        curIndex: 0,
        nav: [ "全部", "待支付", "待配送", "配送中", "完成/售后" ],
        status: [ 0, 2, 3, 4, 5 ],
        statusstr: [ "", "已取消订单", "待支付", "待配送", "配送中", "已完成" ],
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
        open_lottery: 0,
        list: {
            load: !1,
            over: !1,
            page: 0,
            length: 10,
            none: !1,
            data: []
        }
    },
    onLoad: function(a) {
        var n = this, o = a.tab ? a.tab : 0, t = n.data.status[o], e = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/psorderlist",
            data: {
                status: t,
                openid: e,
                page: 0
            },
            success: function(t) {
                var a, e;
                (console.log(t), 2 == t.data) ? n.setData((_defineProperty(a = {}, "list.data", []), 
                _defineProperty(a, "curIndex", o), a)) : n.setData((_defineProperty(e = {}, "list.data", t.data), 
                _defineProperty(e, "curIndex", o), e));
            }
        }), a.id && app.util.request({
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
                        console.log(t.data), 2 != t.data ? n.setData({
                            rcontent: t.data,
                            isPackage: !0,
                            rid: t.data.id,
                            gid: a.id
                        }) : n.setData({
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
                        console.log(t.data), 2 != t.data ? n.setData({
                            urcontent: t.data,
                            unionredpacket: !0,
                            gid: a.id,
                            isPackage: !1
                        }) : n.setData({
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
                console.log(t), 2 != t.data && n.setData({
                    open_lottery: 1
                });
            }
        }), wx.setNavigationBarTitle({
            title: n.data.navTile
        });
        var r = app.getSiteUrl();
        n.setData({
            url: r
        }), app.util.request({
            url: "entry/wxapp/System",
            cachetime: "30",
            showLoading: !1,
            success: function(t) {
                var a = n.data.choose;
                if (1 == t.data.isopen_recharge) {
                    a = a.concat([ {
                        name: "余额支付",
                        value: "2",
                        icon: "/style/images/yuelogo.png",
                        checked: ""
                    } ]);
                }
                n.setData({
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
    },
    bargainTap: function(t) {
        var e = this, a = parseInt(t.currentTarget.dataset.index), n = e.data.status[a], o = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/psorderlist",
            data: {
                status: n,
                openid: o,
                page: 0
            },
            success: function(t) {
                var a;
                2 == t.data ? e.setData(_defineProperty({
                    orderlist: []
                }, "list.page", 0)) : e.setData((_defineProperty(a = {}, "list.data", t.data), _defineProperty(a, "list.page", 0), 
                _defineProperty(a, "list.over", !1), a));
            }
        }), this.setData({
            curIndex: a
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
        wx.getStorageSync("openid")), r = 0, i = "", s = 0;
        1 == e && (r = t.currentTarget.dataset.order_id, i = t.currentTarget.dataset.f_index, 
        s = t.currentTarget.dataset.price), 1 == t.currentTarget.dataset.iscj && a.setData({
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
            g_f_index: i,
            totalprice: s,
            payType: 1
        });
    },
    toPay: function(t) {
        var a = this, e = wx.getStorageSync("openid"), n = a.data.g_order_id, o = a.data.g_f_index, r = a.data.payType, i = a.data.list.data;
        if (a.data.isclick) return wx.showToast({
            title: "请稍后",
            icon: "none",
            duration: 1e3
        }), !1;
        a.setData({
            isclick: !0
        });
        var s = {
            payType: r,
            resulttype: 3,
            orderarr: "",
            SendMessagePay: "",
            PayOrder: "",
            SendSms: "",
            PayOrderurl: "entry/wxapp/PaypsOrder",
            PayredirectTourl: {
                status: 3,
                f_index: o,
                orderlist: i,
                deliveryOrder: 1
            }
        };
        s.orderarr = {
            openid: e,
            order_id: n,
            price: a.data.totalprice,
            ordertype: 14
        }, s.PayOrder = {
            oid: n
        }, app.util.request({
            url: "entry/wxapp/ispsOrder",
            data: {
                oid: n
            },
            success: function(t) {
                1 == t.data && app.func.orderarr(app, a, s);
            }
        });
    },
    toRefundcannel: function(t) {
        var e = this, a = t.currentTarget.dataset.order_id, n = t.currentTarget.dataset.f_index, o = e.data.list.data;
        wx.showModal({
            title: "提示",
            content: "确认取消退款吗",
            showCancel: !0,
            success: function(t) {
                t.confirm && app.util.request({
                    url: "entry/wxapp/SetOrderStatus",
                    data: {
                        order_id: a,
                        ordertype: 14,
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
                        }), o[n].isrefund = 0, e.setData(_defineProperty({}, "list.data", o)));
                    },
                    fail: function(a) {
                        console.log(a.data), wx.showModal({
                            title: "提示信息",
                            content: a.data.message,
                            showCancel: !1,
                            success: function(t) {
                                o[n].status = a.data.data.status, console.log(o), e.setData(_defineProperty({}, "list.data", o));
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
        var e = this, a = t.currentTarget.dataset.order_id, n = t.currentTarget.dataset.f_index, o = e.data.list.data;
        wx.showModal({
            title: "提示",
            content: "确认申请退款吗",
            showCancel: !0,
            success: function(t) {
                t.confirm && app.util.request({
                    url: "entry/wxapp/SetOrderStatus",
                    data: {
                        order_id: a,
                        ordertype: 14,
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
                        }), o[n].isrefund = 1, console.log(o), e.setData(_defineProperty({}, "list.data", o)));
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
        var a = this, e = t.currentTarget.dataset.order_id, n = t.currentTarget.dataset.f_index, o = a.data.list.data;
        wx.showModal({
            title: "提示",
            content: "确认取消该订单吗",
            showCancel: !0,
            success: function(t) {
                t.confirm && app.util.request({
                    url: "entry/wxapp/SetOrderStatus",
                    data: {
                        order_id: e,
                        ordertype: 14,
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
                        }), o[n].status = 1, console.log(o), a.setData(_defineProperty({}, "list.data", o)));
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
            url: "../psOrderDet/psOrderDet?oid=" + a
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {
        var n = this, t = n.data.curIndex, a = n.data.status[t], e = wx.getStorageSync("openid"), o = n.data.list.data, r = n.data.list.page;
        if (n.data.list.over) return wx.showToast({
            title: "已经没有内容了哦！！！",
            icon: "none"
        }), !1;
        app.util.request({
            url: "entry/wxapp/psorderlist",
            data: {
                status: a,
                openid: e,
                page: ++r
            },
            success: function(t) {
                if (t.data.length < 1) return wx.showToast({
                    title: "已经没有内容了哦！！！",
                    icon: "none"
                }), n.setData(_defineProperty({}, "list.over", !0)), !1;
                var a, e = t.data;
                o = o.concat(e), n.setData((_defineProperty(a = {}, "list.data", o), _defineProperty(a, "list.page", r), 
                a));
            }
        });
    },
    onPackage: function() {
        this.setData({
            isPackage: !this.data.isPackage
        });
    },
    onShareAppMessage: function(t) {
        var a = this.data.gid, e = wx.getStorageSync("users"), n = this.data.rcontent, o = n.id, r = n.rname, i = this.data.orderlist[0].oid;
        if (console.log(i), "button" === t.from && console.log(t.target), 0 == a) var s = "/mzhk_sun/pages/index/index"; else s = "/mzhk_sun/pages/index/package/package?id=" + a + "&rid=" + o + "&user_id=" + e.id + "&oid=" + i + "&is_redshare=1";
        return {
            title: r,
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
        var a = this, e = t.currentTarget.dataset.rid, n = t.currentTarget.dataset.bid, o = t.currentTarget.dataset.unid, r = t.currentTarget.dataset.index, i = a.data.gid, s = wx.getStorageSync("openid"), d = a.data.urcontent;
        app.util.request({
            url: "entry/wxapp/getUredpacket",
            showLoading: !1,
            data: {
                rid: e,
                bid: n,
                unid: o,
                gid: i,
                openid: s,
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