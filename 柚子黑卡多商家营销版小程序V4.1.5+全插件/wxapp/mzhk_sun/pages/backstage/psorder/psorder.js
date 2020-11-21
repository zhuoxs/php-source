var app = getApp();

Page({
    data: {
        curIndex: 0,
        nav: [ "待付款", "待配送", "配送中", "已完成" ],
        status_card: [ 2, 3, 4, 5 ],
        orderlist: [],
        showModel: !1,
        code: "",
        page: 0,
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
        }), wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("System").fontcolor,
            backgroundColor: wx.getStorageSync("System").color,
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
    },
    bargainTap: function(t) {
        var e = this, a = parseInt(t.currentTarget.dataset.index), o = (wx.getStorageSync("openid"), 
        e.data.status_card[a]), n = wx.getStorageSync("brand_info");
        app.util.request({
            url: "entry/wxapp/GetBrandPsOrder",
            data: {
                orderstatus: o,
                bid: n.bid,
                page: 0
            },
            success: function(t) {
                2 == t.data ? e.setData({
                    orderlist: [],
                    curIndex: a,
                    page: 0
                }) : e.setData({
                    orderlist: t.data,
                    curIndex: a,
                    page: 0
                });
            }
        }), this.setData({
            curIndex: a
        });
    },
    toAgreeRefund: function(t) {
        var e = this, a = t.currentTarget.dataset.order_id, o = e.data.ordertype;
        if (1 == o) var n = t.currentTarget.dataset.g_order_id; else n = 0;
        var r = t.currentTarget.dataset.f_index, s = e.data.orderlist, d = wx.getStorageSync("brand_info");
        wx.showModal({
            title: "提示",
            content: "确认同意退款吗",
            showCancel: !0,
            success: function(t) {
                t.confirm && app.util.request({
                    url: "entry/wxapp/SetBrandOrderStatus",
                    data: {
                        order_id: a,
                        g_order_id: n,
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
                        }), s[r].isrefund = 2, console.log(s), e.setData({
                            orderlist: s
                        }));
                    }
                });
            }
        });
    },
    toRefuseRefund: function(t) {
        var e = this, a = t.currentTarget.dataset.order_id, o = e.data.ordertype;
        if (1 == o) var n = t.currentTarget.dataset.g_order_id; else n = 0;
        var r = t.currentTarget.dataset.f_index, s = e.data.orderlist, d = wx.getStorageSync("brand_info");
        wx.showModal({
            title: "提示",
            content: "确认拒绝退款吗",
            showCancel: !0,
            success: function(t) {
                t.confirm && app.util.request({
                    url: "entry/wxapp/SetBrandOrderStatus",
                    data: {
                        order_id: a,
                        g_order_id: n,
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
                        }), s[r].isrefund = 3, console.log(s), e.setData({
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
        var o = this, e = t.currentTarget.dataset.order_id;
        wx.getStorageSync("brand_info");
        wx.showModal({
            title: "提示",
            content: "开始配送",
            showCancel: !0,
            success: function(t) {
                t.confirm && app.util.request({
                    url: "entry/wxapp/psorderps",
                    data: {
                        oid: e
                    },
                    success: function(t) {
                        if (0 == t.data) wx.showToast({
                            title: "配送失败！",
                            icon: "none",
                            duration: 2e3
                        }); else {
                            wx.showToast({
                                title: "配送成功！",
                                icon: "success",
                                duration: 500
                            });
                            var e = o.data.curIndex, a = o.data.status_card[e];
                            o.onShow(e, a);
                        }
                    }
                });
            },
            fail: function(t) {},
            complete: function(t) {}
        });
    },
    toSuccess: function(t) {
        var o = this, e = t.currentTarget.dataset.order_id;
        wx.getStorageSync("brand_info");
        wx.showModal({
            title: "提示",
            content: "完成配送",
            showCancel: !0,
            success: function(t) {
                t.confirm && app.util.request({
                    url: "entry/wxapp/pscom",
                    data: {
                        oid: e
                    },
                    success: function(t) {
                        if (0 == t.data) wx.showToast({
                            title: "完成配送失败！",
                            icon: "none",
                            duration: 2e3
                        }); else {
                            wx.showToast({
                                title: "配送完成！",
                                icon: "success",
                                duration: 500
                            });
                            var e = o.data.curIndex, a = o.data.status_card[e];
                            o.onShow(e, a);
                        }
                    }
                });
            },
            fail: function(t) {},
            complete: function(t) {}
        });
    },
    goMyorderdet: function(t) {
        var e = t.currentTarget.dataset.order_id;
        wx.navigateTo({
            url: "/mzhk_sun/pages/user/psOrderDet/psOrderDet?oid=" + e + "&users=1"
        });
    },
    onReady: function() {},
    onShow: function(e, t) {
        var a = this, o = (wx.getStorageSync("openid"), wx.getStorageSync("brand_info"));
        app.util.request({
            url: "entry/wxapp/GetBrandPsOrder",
            data: {
                orderstatus: t || 2,
                bid: o.bid,
                page: 0
            },
            success: function(t) {
                console.log("获取商户订单"), console.log(t.data), 2 == t.data ? a.setData({
                    orderlist: [],
                    curIndex: e || 0
                }) : a.setData({
                    orderlist: t.data,
                    curIndex: e || 0
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {
        var a = this, t = a.data.curIndex, e = (wx.getStorageSync("openid"), a.data.status_card[t]), o = wx.getStorageSync("brand_info"), n = a.data.orderlist, r = a.data.page;
        app.util.request({
            url: "entry/wxapp/GetBrandPsOrder",
            data: {
                orderstatus: e,
                bid: o.bid,
                page: ++r
            },
            success: function(t) {
                if (console.log("获取商户订单1111"), console.log(t.data), 2 == t.data) return --r, wx.showToast({
                    title: "已经没有内容了哦！！！",
                    icon: "none"
                }), !1;
                var e = t.data;
                n = n.concat(e), a.setData({
                    orderlist: n,
                    page: r
                });
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