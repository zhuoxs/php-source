var app = getApp();

Page({
    data: {
        statusType: [ "全部", "待支付", "进行中", " 已完成" ],
        currentType: 0,
        tabClass: [ "", "", "", "", "" ],
        orderListStatus: [ "待支付", "进行中", "已完成" ],
        orderList: !0,
        yh_id: ""
    },
    onLoad: function(t) {
        var e = this;
        console.log("初始下标"), console.log(t), e.setData({
            currentType: t.currentTab
        }), app.util.request({
            url: "entry/wxapp/Url",
            success: function(t) {
                console.log("页面加载请求"), console.log(t), wx.getStorageSync("url", t.data), e.setData({
                    url: t.data
                });
            }
        }), e.diyWinColor();
    },
    statusTap: function(t) {
        console.log("订单页选项卡5"), console.log(t);
        var e = t.currentTarget.dataset.index;
        this.setData({
            currentType: e
        }), this.onShow();
    },
    goDetails: function(t) {
        wx.navigateTo({
            url: "../myOrder-list/details"
        });
    },
    calOrder: function(t) {
        var e = t.currentTarget.dataset.id, a = this;
        app.util.request({
            url: "entry/wxapp/calOrder",
            cachetime: "0",
            data: {
                id: e
            },
            success: function(t) {
                console.log(t), 1 == t.data && wx.showToast({
                    title: "取消成功！",
                    icon: "success"
                }), setTimeout(function() {
                    a.onShow();
                }, 1e3);
            }
        });
    },
    toPay: function(t) {
        var e = t.currentTarget.dataset.price, a = t.currentTarget.dataset.id, o = t.currentTarget.dataset.gid, n = t.currentTarget.dataset.buyNumber, r = wx.getStorageSync("openid"), c = this;
        app.util.request({
            url: "entry/wxapp/Orderarr",
            cachetime: "0",
            data: {
                price: e,
                openid: r
            },
            success: function(t) {
                console.log(t), wx.requestPayment({
                    timeStamp: t.data.timeStamp,
                    nonceStr: t.data.nonceStr,
                    package: t.data.package,
                    signType: "MD5",
                    paySign: t.data.paySign,
                    success: function(t) {
                        console.log("支付数据"), console.log(t), wx.showToast({
                            title: "支付成功",
                            icon: "success",
                            duration: 2e3
                        }), app.util.request({
                            url: "entry/wxapp/changeOrder",
                            cachetime: "0",
                            data: {
                                order_id: a,
                                buyNumber: n,
                                gid: o
                            },
                            success: function(t) {
                                c.setData({
                                    currentType: 2
                                }), c.onShow();
                            }
                        });
                    }
                });
            }
        });
    },
    comOrder: function(t) {
        console.log(t);
        var e = t.currentTarget.dataset.id, a = t.currentTarget.dataset.money, o = t.currentTarget.dataset.goodsid, n = this;
        app.util.request({
            url: "entry/wxapp/comfirmOrder",
            cachetime: "0",
            data: {
                id: e,
                money: a,
                goodsid: o
            },
            success: function(t) {
                console.log(t), 1 == t.data && (wx.showToast({
                    title: "确认成功！"
                }), setTimeout(function() {
                    n.setData({
                        currentType: 3
                    }), n.onShow();
                }, 1e3));
            }
        });
    },
    delOrder: function(t) {
        var e = t.currentTarget.dataset.id, a = this;
        wx.showModal({
            title: "提示",
            content: "确认删除该订单吗？",
            success: function(t) {
                t.confirm ? (console.log("用户点击确定"), app.util.request({
                    url: "entry/wxapp/DelOrder",
                    cachetime: "0",
                    data: {
                        id: e
                    },
                    success: function(t) {
                        console.log(t), 1 == t.data && (wx.showToast({
                            title: "确认成功！"
                        }), setTimeout(function() {
                            a.onShow();
                        }, 1e3));
                    }
                })) : t.cancel && console.log("用户点击取消");
            }
        });
    },
    onReady: function() {},
    checkOrder: function(t) {
        var e = t.currentTarget.dataset.id;
        wx.navigateTo({
            url: "../myOrderDetail/myOrderDetail?id=" + e
        });
    },
    onShow: function() {
        var e = this, t = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/Order_mine",
            data: {
                currentType: e.data.currentType,
                openid: t
            },
            success: function(t) {
                console.log("查看订单数据"), console.log(t.data), e.setData({
                    list: t.data
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    gohome: function() {
        wx.reLaunch({
            url: "../mine/mine"
        });
    },
    diyWinColor: function(t) {
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: "#ffb62b"
        }), wx.setNavigationBarTitle({
            title: "我的订单"
        });
    }
});