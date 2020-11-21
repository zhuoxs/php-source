var app = getApp();

Page({
    data: {
        navTile: "我的订单",
        curIndex: 0,
        nav: [ "全部", "待付款", "待使用", "已完成" ],
        list: [],
        curPage: 1,
        pagesize: 6
    },
    onLoad: function(e) {
        var a = this;
        wx.setNavigationBarTitle({
            title: a.data.navTile
        });
        var t = wx.getStorageSync("setting");
        t ? wx.setNavigationBarColor({
            frontColor: t.fontcolor,
            backgroundColor: t.color
        }) : app.get_setting(!0).then(function(t) {
            wx.setNavigationBarColor({
                frontColor: t.fontcolor,
                backgroundColor: t.color
            });
        }), app.get_imgroot().then(function(t) {
            a.setData({
                order_sign: e.sign,
                curIndex: e.sign,
                imgroot: t
            });
        });
    },
    onReady: function() {},
    onShow: function() {
        this.get_order_list();
    },
    get_order_list: function() {
        var n = this, o = n.data.curPage, i = n.data.list;
        app.get_openid().then(function(t) {
            app.util.request({
                url: "entry/wxapp/getMyOrder",
                cachetime: "0",
                data: {
                    openid: t,
                    order_sign: n.data.order_sign,
                    page: o,
                    pagesize: n.data.pagesize
                },
                success: function(t) {
                    console.log("页数"), console.log(o);
                    var e = t.data.length == n.data.pagesize;
                    if (1 == o) i = t.data; else for (var a in t.data) i.push(t.data[a]);
                    o += 1, console.log(t.data), n.setData({
                        list: i,
                        curPage: o,
                        hasMore: e
                    });
                }
            });
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {
        this.data.hasMore ? this.get_order_list() : wx.showToast({
            title: "没有更多订单啦~",
            icon: "none"
        });
    },
    bargainTap: function(t) {
        var e = parseInt(t.currentTarget.dataset.index);
        this.setData({
            curIndex: e,
            curPage: 1,
            order_sign: e
        }), this.get_order_list();
    },
    toCancel: function(t) {
        var e = this, a = t.currentTarget.dataset.id, n = t.currentTarget.dataset.index, o = e.data.list;
        wx.showModal({
            title: "提示",
            content: "确定取消该订单吗？",
            success: function(t) {
                t.confirm ? app.get_openid().then(function(t) {
                    app.util.request({
                        url: "entry/wxapp/cancelOrder",
                        cachetime: "0",
                        data: {
                            openid: t,
                            order_id: a
                        },
                        success: function(t) {
                            wx.showToast({
                                title: "取消订单成功"
                            }), o.splice(n, 1), e.setData({
                                list: o
                            });
                        },
                        fail: function() {
                            wx.showToast({
                                title: "取消订单失败",
                                icon: "none",
                                duration: 3e3
                            });
                        }
                    });
                }) : t.cancel && console.log("用户点击取消");
            }
        });
    },
    toOrderdet: function(t) {
        var e = t.currentTarget.dataset.id;
        wx.navigateTo({
            url: "../orderdet/orderdet?id=" + e
        });
    },
    toDel: function(t) {
        var e = this, a = t.currentTarget.dataset.id, n = t.currentTarget.dataset.index, o = e.data.list;
        wx.showModal({
            title: "提示",
            content: "订单删除后将不再显示",
            success: function(t) {
                t.confirm ? app.get_openid().then(function(t) {
                    app.util.request({
                        url: "entry/wxapp/delOrder",
                        cachetime: "0",
                        data: {
                            openid: t,
                            order_id: a
                        },
                        success: function(t) {
                            wx.showToast({
                                title: "删除成功"
                            }), o.splice(n, 1), e.setData({
                                list: o
                            });
                        },
                        fail: function() {
                            wx.showToast({
                                title: "删除失败",
                                icon: "none",
                                duration: 3e3
                            });
                        }
                    });
                }) : t.cancel && console.log("用户点击取消");
            }
        });
    },
    toPay: function(n) {
        var o = this;
        wx.showModal({
            title: "提示",
            content: "确定支付",
            success: function(t) {
                if (t.confirm) {
                    wx.getStorageSync("openid");
                    var e = n.currentTarget.dataset.id, a = n.currentTarget.dataset.index;
                    console.log(e), app.util.request({
                        url: "entry/wxapp/getPayParam",
                        cachetime: "0",
                        data: {
                            order_id: e
                        },
                        success: function(t) {
                            wx.requestPayment({
                                timeStamp: t.data.timeStamp,
                                nonceStr: t.data.nonceStr,
                                package: t.data.package,
                                signType: "MD5",
                                paySign: t.data.paySign,
                                success: function(t) {
                                    var e = o.data.list;
                                    console.log(t), wx.showToast({
                                        title: "支付成功",
                                        duration: 2e3
                                    }), 1 == o.data.curIndex ? e.splice(a, 1) : e[a].order_status = 1, o.setData({
                                        list: e
                                    });
                                },
                                fail: function(t) {
                                    wx.showModal({
                                        title: "提示",
                                        content: "支付失败，请重新支付",
                                        showCancel: !1,
                                        success: function(t) {}
                                    });
                                }
                            });
                        }
                    });
                } else t.cancel && console.log("用户点击取消");
            }
        });
    }
});