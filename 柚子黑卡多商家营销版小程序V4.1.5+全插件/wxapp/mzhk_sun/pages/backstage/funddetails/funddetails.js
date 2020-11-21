var app = getApp();

Page({
    data: {
        curIndex: 0,
        nav: [ "待付款", "未使用", "待发货", "待收货", "退款", "已完成" ],
        status: [ 2, 3, 33, 4, 31, 5 ],
        status_ground: [ 2, 4, 43, 6, 41, 5 ],
        nav_card: [ "未使用", "待发货", "待收货", "已完成" ],
        status_card: [ 1, 13, 11, 2 ],
        statusstr: [ "", "已取消订单", "待支付", "未使用", "待收货", "已完成" ],
        statusstr_ground: [ "", "已取消订单", "待支付", "拼团中", "未使用", "已完成", "待收货" ],
        statusstr_card: [ "未使用", "待收货", "已完成" ],
        nav_free: [ "未中奖", "中奖未使用", "中奖已使用" ],
        status_free: [ 2, 10, 12 ],
        orderlist: [],
        showModel: !1,
        code: "",
        page: [ 1, 1, 1, 1, 1, 1 ],
        titlearr: [ "抢购订单", "拼团订单", "砍价订单", "集卡订单", "普通订单", "", "免单订单" ],
        oid: 0
    },
    onLoad: function(t) {
        var e = this, a = app.getSiteUrl();
        a ? e.setData({
            url: a
        }) : app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            success: function(t) {
                wx.setStorageSync("url", t.data), a = t.data, e.setData({
                    url: a
                });
            }
        });
        var o = t.ordertype;
        e.setData({
            ordertype: o
        });
        var r = e.data.titlearr;
        wx.setNavigationBarTitle({
            title: r[o]
        }), wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("System").fontcolor,
            backgroundColor: wx.getStorageSync("System").color,
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
        wx.getStorageSync("openid");
        var n = t.tab;
        if (n = n || 0, 1 == o) var s = e.data.status_ground[n]; else if (3 == o) s = e.data.status_card[n]; else if (6 == o) s = e.data.status_free[n]; else s = e.data.status[n];
        var d = wx.getStorageSync("brand_info");
        app.util.request({
            url: "entry/wxapp/GetBrandOrder",
            data: {
                orderstatus: s,
                bid: d.bid,
                ordertype: o
            },
            success: function(t) {
                console.log("获取商户订单"), console.log(t.data), 2 == t.data ? e.setData({
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
        var e = this, a = parseInt(t.currentTarget.dataset.index), o = (wx.getStorageSync("openid"), 
        e.data.ordertype);
        if (1 == o) var r = e.data.status_ground[a]; else if (3 == o) r = e.data.status_card[a]; else if (6 == o) r = e.data.status_free[a]; else r = e.data.status[a];
        var n = wx.getStorageSync("brand_info"), s = [ 1, 1, 1, 1, 1, 1 ];
        app.util.request({
            url: "entry/wxapp/GetBrandOrder",
            data: {
                orderstatus: r,
                bid: n.bid,
                ordertype: o
            },
            success: function(t) {
                console.log("获取商户订单1111"), console.log(t.data), 2 == t.data ? e.setData({
                    orderlist: [],
                    curIndex: a,
                    page: s
                }) : e.setData({
                    orderlist: t.data,
                    curIndex: a,
                    page: s
                });
            }
        }), this.setData({
            curIndex: a
        });
    },
    toAgreeRefund: function(t) {
        var e = this, a = t.currentTarget.dataset.order_id, o = e.data.ordertype;
        if (1 == o) var r = t.currentTarget.dataset.g_order_id; else r = 0;
        var n = t.currentTarget.dataset.f_index, s = e.data.orderlist, d = wx.getStorageSync("brand_info");
        wx.showModal({
            title: "提示",
            content: "确认同意退款吗",
            showCancel: !0,
            success: function(t) {
                t.confirm && app.util.request({
                    url: "entry/wxapp/SetBrandOrderStatus",
                    data: {
                        order_id: a,
                        g_order_id: r,
                        bid: d.bid,
                        ordertype: o,
                        refund: 2
                    },
                    success: function(t) {
                        console.log(123456), console.log(t.data), console.log(789456), 2 == t.data ? wx.showToast({
                            title: "退款失败！",
                            icon: "none",
                            duration: 2e3
                        }) : (wx.showToast({
                            title: "退款成功！",
                            icon: "success",
                            duration: 500
                        }), s[n].isrefund = 2, console.log(s), e.setData({
                            orderlist: s
                        }));
                    }
                });
            }
        });
    },
    toRefuseRefund: function(t) {
        var e = this, a = t.currentTarget.dataset.order_id, o = e.data.ordertype;
        if (1 == o) var r = t.currentTarget.dataset.g_order_id; else r = 0;
        var n = t.currentTarget.dataset.f_index, s = e.data.orderlist, d = wx.getStorageSync("brand_info");
        wx.showModal({
            title: "提示",
            content: "确认拒绝退款吗",
            showCancel: !0,
            success: function(t) {
                t.confirm && app.util.request({
                    url: "entry/wxapp/SetBrandOrderStatus",
                    data: {
                        order_id: a,
                        g_order_id: r,
                        bid: d.bid,
                        ordertype: o,
                        refund: 3
                    },
                    success: function(t) {
                        console.log(123456), console.log(t.data), console.log(789456), 2 == t.data ? wx.showToast({
                            title: "拒绝退款失败！",
                            icon: "none",
                            duration: 2e3
                        }) : (wx.showToast({
                            title: "拒绝退款成功！",
                            icon: "success",
                            duration: 500
                        }), s[n].isrefund = 3, console.log(s), e.setData({
                            orderlist: s
                        }));
                    }
                });
            },
            fail: function(t) {},
            complete: function(t) {}
        });
    },
    toShip: function(t) {
        var e = this, a = t.currentTarget.dataset.order_id, o = t.currentTarget.dataset.sincetype, r = e.data.ordertype;
        if (1 == r) var n = t.currentTarget.dataset.g_order_id; else n = 0;
        var s = t.currentTarget.dataset.f_index, d = e.data.orderlist, i = wx.getStorageSync("brand_info");
        if ("快递" == o) {
            var c = 1 == r ? n : a;
            this.setData({
                showModel: !0,
                oid: c,
                shipindex: s
            });
        } else "送货上门" == o ? wx.showModal({
            title: "提示",
            content: "确认发货吗",
            showCancel: !0,
            success: function(t) {
                t.confirm && app.util.request({
                    url: "entry/wxapp/SetBrandOrderStatus",
                    data: {
                        order_id: a,
                        g_order_id: n,
                        bid: i.bid,
                        ordertype: r,
                        ship: 2
                    },
                    success: function(t) {
                        console.log(123456), console.log(t.data), console.log(789456), 2 == t.data ? wx.showToast({
                            title: "发货失败！",
                            icon: "none",
                            duration: 2e3
                        }) : (wx.showToast({
                            title: "发货成功！",
                            icon: "success",
                            duration: 500
                        }), d[s].status = 1 == r ? 6 : 3 == r ? 3 : 4, console.log(d), e.setData({
                            orderlist: d
                        }));
                    }
                });
            },
            fail: function(t) {},
            complete: function(t) {}
        }) : wx.showToast({
            title: "参数错误",
            icon: "none",
            duration: 2e3
        });
    },
    formSubmit: function(t) {
        var e = this, a = (wx.getStorageSync("openid"), t.detail.value.shipname), o = t.detail.value.shipnum, r = t.detail.value.oid, n = e.data.shipindex, s = e.data.orderlist, d = wx.getStorageSync("brand_info"), i = e.data.ordertype;
        return r <= 0 ? (wx.showToast({
            title: "参数错误",
            icon: "none",
            duration: 2e3
        }), !1) : "" == a || "" == o ? (wx.showToast({
            title: "快递名称或快递单号不能为空",
            icon: "none",
            duration: 2e3
        }), !1) : (console.log(r), void app.util.request({
            url: "entry/wxapp/SetBrandOrderStatus",
            data: {
                order_id: r,
                g_order_id: r,
                bid: d.bid,
                shipname: a,
                shipnum: o,
                ordertype: i,
                ship: 1
            },
            success: function(t) {
                console.log(123456), console.log(t.data), console.log(789456), 2 == t.data ? wx.showToast({
                    title: "发货失败！",
                    icon: "none",
                    duration: 2e3
                }) : (wx.showToast({
                    title: "发货成功！",
                    icon: "success",
                    duration: 500
                }), s[n].status = 1 == i ? 6 : 4, console.log(s), e.setData({
                    orderlist: s,
                    showModel: !1
                }));
            }
        }));
    },
    goMyorderdet: function(t) {
        var e = t.currentTarget.dataset.order_id, a = this.data.ordertype;
        wx.navigateTo({
            url: "../myorderdet/myorderdet?order_id=" + e + "&ordertype=" + a
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {
        var a = this, o = a.data.curIndex, t = (wx.getStorageSync("openid"), a.data.ordertype);
        if (1 == t) var e = a.data.status_ground[o]; else if (3 == t) e = a.data.status_card[o]; else e = a.data.status[o];
        var r = wx.getStorageSync("brand_info"), n = a.data.orderlist, s = a.data.page, d = s[o];
        app.util.request({
            url: "entry/wxapp/GetBrandOrder",
            data: {
                orderstatus: e,
                bid: r.bid,
                ordertype: t,
                page: d
            },
            success: function(t) {
                if (console.log("获取商户订单1111"), console.log(t.data), 2 == t.data) wx.showToast({
                    title: "已经没有内容了哦！！！",
                    icon: "none"
                }); else {
                    var e = t.data;
                    n = n.concat(e), s[o] = d + 1, console.log(s), a.setData({
                        orderlist: n,
                        page: s
                    });
                }
            }
        });
    },
    onShareAppMessage: function() {},
    enterOrderNum: function(t) {},
    showModel: function(t) {
        this.setData({
            showModel: !this.data.showModel
        });
    },
    getCode: function(t) {
        this.setData({
            code: t.detail.value
        });
    },
    toSubmit: function(t) {
        var e = this.data.code;
        console.log(e), "" == e && wx.showToast({
            title: "请输入快递单号号",
            icon: "none"
        });
    }
});