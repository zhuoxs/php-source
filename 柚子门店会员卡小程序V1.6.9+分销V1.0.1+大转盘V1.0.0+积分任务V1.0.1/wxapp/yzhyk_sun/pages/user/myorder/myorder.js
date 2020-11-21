var app = getApp();

Page({
    data: {
        navTile: "我的订单",
        curIndex: 0,
        pageIndex: 1,
        nav: [ {
            name: "全部",
            state: 0
        }, {
            name: "待付款",
            state: 10
        }, {
            name: "待发货",
            state: 20
        }, {
            name: "待收货",
            state: 30
        }, {
            name: "已完成",
            state: 40
        } ],
        goodsOrder: [],
        hasMore: !0,
        state: 0,
        choose: [ {
            name: "微信",
            value: "微信支付",
            icon: "../../../../style/images/wx.png"
        }, {
            name: "余额",
            value: "余额支付",
            icon: "../../../../style/images/local.png"
        } ],
        payStatus: !1,
        isPay: 0,
        isIpx: app.globalData.isIpx
    },
    onLoad: function(t) {
        var a = this;
        wx.setNavigationBarTitle({
            title: a.data.navTile
        }), app.get_imgroot().then(function(t) {
            a.setData({
                imgroot: t
            });
        }), app.get_user_info().then(function(t) {
            a.setData({
                userId: t.id,
                user: t
            });
        }), a.setData({
            curIndex: t.curindex,
            state: t.state
        });
    },
    onReady: function() {},
    onShow: function() {
        var t = this.data.state;
        this.getOrder(t);
    },
    getOrder: function(a) {
        var n = this, s = (n.data.curIndex, n.data.pageIndex);
        a = a || 0, s = s || 1, app.get_user_info().then(function(t) {
            app.util.request({
                url: "entry/wxapp/GetOrders",
                cachetime: "0",
                data: {
                    user_id: t.id,
                    state: a,
                    page: s
                },
                success: function(t) {
                    if (1 == s) n.setData({
                        goodsOrder: t.data
                    }); else {
                        for (var a = n.data.goodsOrder, e = 0; e < t.data.length; e++) a.push(t.data[e]);
                        n.setData({
                            goodsOrder: a
                        });
                    }
                    s += 1, n.setData({
                        pageIndex: s
                    }), t.data.length < 10 && n.setData({
                        hasMore: !1
                    });
                }
            });
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {
        var t = this.data.state;
        this.getOrder(t);
    },
    bargainTap: function(t) {
        var a = parseInt(t.currentTarget.dataset.index), e = t.currentTarget.dataset.state;
        this.setData({
            pageIndex: 1,
            curIndex: a,
            state: e
        }), this.getOrder(e);
    },
    toCancel: function(t) {
        var a = t.currentTarget.dataset.id, e = (t.currentTarget.dataset.index, this), n = e.data.state;
        wx.showModal({
            title: "提示",
            content: "确定取消该订单吗？",
            success: function(t) {
                t.confirm ? app.util.request({
                    url: "entry/wxapp/CancelOrder",
                    data: {
                        id: a
                    },
                    success: function(t) {
                        e.setData({
                            pageIndex: 1
                        }), e.getOrder(n);
                    }
                }) : t.cancel && console.log("用户点击取消");
            }
        });
    },
    confirmReceipt: function(t) {
        var a = t.currentTarget.dataset.id, e = (t.currentTarget.dataset.index, this), n = e.data.state;
        wx.showModal({
            title: "提示",
            content: "确定收到商品了吗？",
            success: function(t) {
                t.confirm ? app.util.request({
                    url: "entry/wxapp/ConfirmOrder",
                    data: {
                        id: a
                    },
                    success: function(t) {
                        e.setData({
                            pageIndex: 1
                        }), e.getOrder(n);
                    }
                }) : t.cancel && console.log("用户点击取消");
            }
        });
    },
    toDel: function(t) {
        var a = t.currentTarget.dataset.id, e = (t.currentTarget.dataset.index, this), n = e.data.state;
        wx.showModal({
            title: "提示",
            content: "订单删除后将不再显示",
            success: function(t) {
                t.confirm ? app.util.request({
                    url: "entry/wxapp/DeleteOrder",
                    data: {
                        id: a
                    },
                    success: function(t) {
                        e.setData({
                            pageIndex: 1
                        }), e.getOrder(n);
                    }
                }) : t.cancel && console.log("用户点击取消");
            }
        });
    },
    toConcat: function(t) {
        var a = t.currentTarget.dataset.phone;
        wx.makePhoneCall({
            phoneNumber: a + ""
        });
    },
    totui: function(t) {
        var a = this, e = t.currentTarget.dataset.id, n = a.data.state;
        wx.showModal({
            title: "提示",
            content: "是否申请退款？",
            success: function(t) {
                t.confirm ? app.util.request({
                    url: "entry/wxapp/tuiOrder",
                    data: {
                        id: e
                    },
                    success: function(t) {
                        a.setData({
                            pageIndex: 1
                        }), a.getOrder(n);
                    }
                }) : t.cancel && console.log("用户点击取消");
            }
        });
    },
    toMyorderdet: function(t) {
        var a = t.currentTarget.dataset.id;
        wx.navigateTo({
            url: "../myorderdet/myorderdet?id=" + a
        });
    },
    powerDrawer: function(t) {
        var a = t.currentTarget.dataset.index;
        this.setData({
            payStatus: !this.data.payStatus,
            orderIndex: a
        });
    },
    radioChange: function(t) {
        var a = t.detail.value;
        console.log(a), this.setData({
            payType: a
        });
    },
    formSubmit: function(t) {
        var e = this, a = e.data.orderIndex, n = e.data.goodsOrder[a], s = e.data.payType, r = (e.data.user, 
        n.id), o = n.pay_amount;
        null != s ? (e.setData({
            isPay: ++e.data.isPay
        }), 1 == e.data.isPay ? app.get_user_info().then(function(t) {
            app.util.request({
                url: "entry/wxapp/PayOrder",
                cachetime: "0",
                data: {
                    user_id: t.id,
                    id: r,
                    pay_type: s,
                    pay_amount: o
                },
                success: function(t) {
                    if (console.log(t.data.paydata), null != t.data.paydata) if (1 == t.data.paydata.paytype) wx.redirectTo({
                        url: "../../index/paysuc/paysuc"
                    }); else {
                        var a = t.data.paydata.integralid;
                        app.wx_requestPayment(t.data.paydata).then(function(t) {
                            "requestPayment:ok" == t.errMsg && app.util.request({
                                url: "entry/wxapp/addint",
                                cachetime: "0",
                                method: "post",
                                data: {
                                    iid: a
                                },
                                success: function() {
                                    wx.redirectTo({
                                        url: "../../index/paysuc/paysuc"
                                    });
                                }
                            });
                        });
                    } else wx.showModal({
                        title: "提示",
                        content: t.data.msg,
                        showCancel: !1,
                        success: function(t) {}
                    });
                    e.setData({
                        isPay: --e.data.isPay
                    });
                }
            });
        }) : wx.showToast({
            title: "正在支付中...",
            icon: "none"
        })) : wx.showToast({
            title: "请选择支付方式",
            icon: "none"
        });
    }
});