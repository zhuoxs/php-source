var e = require("../../../../utils/base.js"), t = require("../../../../../api.js"), a = require("../../../../../siteinfo.js"), r = new e.Base(), n = getApp();

Page({
    data: {
        orderIndex: 0,
        kind: "all",
        page: 1,
        size: 10,
        loadmore: !0,
        orderList: [],
        refundOrder: [],
        selectedFlag: [ !1, !1, !1 ],
        infoAuth: !0,
        sceneData: ""
    },
    onLoad: function(e) {
        var t = this;
        e.scene && (this.data.sceneData = e.scene), this.setData({
            orderIndex: e.sindex || 0,
            kind: e.kind || "all"
        }), this.getOrder(e.kind), n.getTabBar(), n.getInformation(function(e) {
            t.setData({
                platform: e
            });
        });
    },
    onShow: function() {
        var e = this;
        n.userInfoAuth(function(t) {
            e.setData({
                infoAuth: t
            });
        });
    },
    onReachBottom: function() {
        this.setData({
            page: this.data.page + 1
        }), this.data.loadmore && this.getOrder(this.data.kind);
    },
    getUserInfo: function(e) {
        var a = this;
        wx.getSetting({
            success: function(e) {
                e.authSetting["scope.userInfo"] && wx.getUserInfo({
                    success: function(e) {
                        n.userInfoAuth(function(e) {
                            a.setData({
                                infoAuth: e
                            });
                        }), wx.setStorageSync("userInfo", e.userInfo), n.updateToken(function(n) {
                            if ("undefined" != n) {
                                var d = {
                                    url: t.default.user_update,
                                    data: {
                                        nickname: e.userInfo.nickName,
                                        avatar: e.userInfo.avatarUrl
                                    }
                                };
                                r.getData(d, function(e) {}), a.getOrder(a.data.kind);
                            }
                        });
                    }
                });
            }
        });
    },
    switch: function(e) {
        var t = e.currentTarget.dataset.index, a = e.currentTarget.dataset.kind;
        this.setData({
            orderIndex: t,
            kind: a,
            page: 1,
            size: 10,
            orderList: [],
            refundOrder: []
        }), this.getOrder(a);
    },
    getOrder: function(e) {
        var a = this;
        wx.showLoading({
            title: "请稍后"
        });
        var n = {
            url: t.default.order_by_user,
            data: {
                kind: e || this.data.kind,
                page: this.data.page,
                size: this.data.size
            }
        };
        r.getData(n, function(t) {
            var r = a;
            a.data.orderList, a.data.refundOrder;
            if ("after" == e && t.data.length > 0) {
                var n = [];
                n = [ t.data[0].snap_info ], t.data[0].snap_info = n, r.data.refundOrder.push.apply(r.data.refundOrder, t.data), 
                r.setData({
                    refundOrder: r.data.refundOrder,
                    loadmore: !0
                }), t.data.length < r.data.size && r.setData({
                    loadmore: !1
                });
            } else r.data.orderList.push.apply(r.data.orderList, t.data), r.setData({
                orderList: r.data.orderList,
                loadmore: !0
            }), t.data.length < r.data.size && r.setData({
                loadmore: !1
            });
            wx.hideLoading(), console.log(t);
        });
    },
    search: function(e) {
        var t = e.detail.value;
        "" == t ? wx.showToast({
            title: "请输入搜索内容",
            icon: "none"
        }) : wx.navigateTo({
            url: "../order_search/order_search?keyword=" + t
        });
    },
    cancelOrder: function(e) {
        var a = this, n = e.currentTarget.dataset.id;
        wx.showModal({
            title: "是否取消该订单？",
            success: function(e) {
                if (e.confirm) {
                    var d = {
                        url: t.default.order_cancel,
                        data: {
                            orderId: n
                        }
                    };
                    console.log("取消订单参数", d), r.getData(d, function(e) {
                        console.log("取消订单", e), 0 == e.errorCode ? wx.showToast({
                            title: "取消失败",
                            icon: "none",
                            duration: 2e3
                        }) : (a.setData({
                            page: 1,
                            size: 10,
                            orderList: []
                        }), a.getOrder(a.data.kind));
                    });
                }
            }
        });
    },
    confirmOrder: function(e) {
        var a = this, n = e.currentTarget.dataset.id;
        wx.showModal({
            title: "是否确认收货",
            success: function(e) {
                if (e.confirm) {
                    var d = {
                        url: t.default.order_confirm,
                        data: {
                            orderId: n
                        }
                    };
                    r.getData(d, function(e) {
                        a.setData({
                            orderIndex: 4,
                            page: 1,
                            size: 10,
                            orderList: []
                        }), a.getOrder("completed");
                    });
                }
            }
        });
    },
    topay: function(e) {
        wx.showLoading({
            title: "提交中"
        }), setTimeout(function() {
            wx.hideLoading();
        }, 200);
        var r = e.currentTarget.dataset.id, d = this, i = wx.getStorageSync("token") || "";
        i && wx.request({
            url: n.globalData.api_root + t.default.pay_pre_order,
            method: "POST",
            header: {
                token: i,
                uniacid: a.uniacid
            },
            data: {
                id: r
            },
            success: function(e) {
                if (console.log(e), 0 == e.data.errorCode) wx.showModal({
                    title: "提示",
                    content: e.data.msg,
                    showCancel: !1,
                    complete: function(e) {
                        wx.redirectTo({
                            url: "../order/order?sindex=1&kind=wait"
                        }), d.setData({
                            page: 1,
                            size: 10,
                            orderList: []
                        }), d.getOrder("wait");
                    }
                }); else {
                    var t = e.data;
                    wx.requestPayment({
                        timeStamp: t.timeStamp.toString(),
                        nonceStr: t.nonceStr,
                        package: t.package,
                        signType: t.signType,
                        paySign: t.paySign,
                        success: function(e) {
                            wx.redirectTo({
                                url: "../order/order?sindex=2&kind=send"
                            });
                        },
                        fail: function(e) {
                            wx.showToast({
                                title: "支付失败"
                            }), wx.redirectTo({
                                url: "../order/order?sindex=1&kind=wait"
                            });
                        }
                    });
                }
            }
        });
    },
    moreUp: function(e) {
        var t = e.currentTarget.dataset.index;
        this.data.selectedFlag[t] ? this.data.selectedFlag[t] = !1 : this.data.selectedFlag[t] = !0, 
        this.setData({
            selectedFlag: this.data.selectedFlag
        });
    },
    navigatorLink: function(e) {
        console.log(e), n.navClick(e, this);
    }
});