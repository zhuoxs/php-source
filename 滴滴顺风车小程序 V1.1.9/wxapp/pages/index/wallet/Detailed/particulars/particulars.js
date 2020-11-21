var t = getApp();

Page({
    data: {
        nclass: "",
        info: []
    },
    onLoad: function(t) {
        var a = this;
        console.log(t);
        var e = t.nid, o = t.pid, n = t.nclass;
        a.setData({
            nclass: n,
            nid: o,
            pid: e
        });
        try {
            var d = wx.getStorageSync("session");
            d && (console.log("logintag:", d), a.setData({
                logintag: d
            }));
        } catch (t) {}
        1 != n ? 4 != n ? 5 != n && 6 != n ? 2 != n ? 3 != n ? 8 != n ? 7 != n ? 9 != n || a.recharge() : a.income() : a.withdraw() : a.small() : a.deduct() : a.deposit() : a.up() : a.stall();
    },
    recharge: function(a) {
        var e = this, o = e.data.logintag, n = e.data.nid, d = e.data.pid;
        wx.request({
            url: t.data.url + "member_account_amount_order_detail",
            data: {
                logintag: o,
                nid: n,
                pid: d
            },
            header: {
                "content-type": "application/x-www-form-urlencoded"
            },
            success: function(t) {
                console.log("账户充值订单详情"), console.log(t), "0000" == t.data.retCode ? e.setData({
                    info: t.data.info
                }) : wx.showToast({
                    title: t.data.retDesc,
                    icon: "none",
                    duration: 1e3
                });
            }
        });
    },
    stall: function(a) {
        var e = this, o = e.data.logintag, n = e.data.nid, d = e.data.pid;
        wx.request({
            url: t.data.url + "passenger_parking_lot_detail",
            data: {
                logintag: o,
                nid: n,
                pid: d
            },
            header: {
                "content-type": "application/x-www-form-urlencoded"
            },
            success: function(t) {
                console.log("乘车购买车位费订单详情"), console.log(t), "0000" == t.data.retCode ? e.setData({
                    info: t.data.info
                }) : wx.showToast({
                    title: t.data.retDesc,
                    icon: "none",
                    duration: 1e3
                });
            }
        });
    },
    income: function(a) {
        var e = this, o = e.data.logintag, n = e.data.nid, d = e.data.pid;
        console.log("nid:", n), console.log("pid:", d), wx.request({
            url: t.data.url + "income_detail",
            data: {
                logintag: o,
                nid: n,
                pid: d
            },
            header: {
                "content-type": "application/x-www-form-urlencoded"
            },
            success: function(t) {
                console.log("收入订单详情"), console.log(t), "0000" == t.data.retCode ? e.setData({
                    info: t.data.info
                }) : wx.showToast({
                    title: t.data.retDesc,
                    icon: "none",
                    duration: 1e3
                });
            }
        });
    },
    withdraw: function(a) {
        var e = this, o = e.data.logintag, n = e.data.nid, d = e.data.pid;
        console.log("nid:", n), console.log("pid:", d), wx.request({
            url: t.data.url + "passenger_withdraw_detail",
            data: {
                logintag: o,
                nid: n,
                pid: d
            },
            header: {
                "content-type": "application/x-www-form-urlencoded"
            },
            success: function(t) {
                console.log("提现订单详情"), console.log(t), "0000" == t.data.retCode ? e.setData({
                    info: t.data.info
                }) : wx.showToast({
                    title: t.data.retDesc,
                    icon: "none",
                    duration: 1e3
                });
            }
        });
    },
    up: function(a) {
        var e = this, o = e.data.logintag, n = e.data.nid, d = e.data.pid;
        wx.request({
            url: t.data.url + "passenger_recharge_detail",
            data: {
                logintag: o,
                nid: n,
                pid: d
            },
            header: {
                "content-type": "application/x-www-form-urlencoded"
            },
            success: function(t) {
                console.log("车主押金充值订单详情"), console.log(t), "0000" == t.data.retCode ? e.setData({
                    info: t.data.info
                }) : wx.showToast({
                    title: t.data.retDesc,
                    icon: "none",
                    duration: 1e3
                });
            }
        });
    },
    deposit: function(a) {
        var e = this, o = e.data.logintag, n = e.data.nid, d = e.data.pid;
        wx.request({
            url: t.data.url + "passenger_withdraw_detail",
            data: {
                logintag: o,
                nid: n,
                pid: d
            },
            header: {
                "content-type": "application/x-www-form-urlencoded"
            },
            success: function(t) {
                console.log("提现订单详情"), console.log(t), "0000" == t.data.retCode ? e.setData({
                    info: t.data.info
                }) : wx.showToast({
                    title: t.data.retDesc,
                    icon: "none",
                    duration: 1e3
                });
            }
        });
    },
    deduct: function(a) {
        var e = this, o = e.data.logintag, n = e.data.nid, d = e.data.pid;
        wx.request({
            url: t.data.url + "deduction_deposit_detail",
            data: {
                logintag: o,
                nid: n,
                pid: d
            },
            header: {
                "content-type": "application/x-www-form-urlencoded"
            },
            success: function(t) {
                console.log("扣除押金订单详情"), console.log(t), "0000" == t.data.retCode ? e.setData({
                    info: t.data.info
                }) : wx.showToast({
                    title: t.data.retDesc,
                    icon: "none",
                    duration: 1e3
                });
            }
        });
    },
    small: function(a) {
        var e = this, o = e.data.logintag, n = e.data.nid, d = e.data.pid;
        wx.request({
            url: t.data.url + "deduction_carfare_detail",
            data: {
                logintag: o,
                nid: n,
                pid: d
            },
            header: {
                "content-type": "application/x-www-form-urlencoded"
            },
            success: function(t) {
                console.log("扣除车资订单详情"), console.log(t), "0000" == t.data.retCode ? e.setData({
                    info: t.data.info
                }) : wx.showToast({
                    title: t.data.retDesc,
                    icon: "none",
                    duration: 1e3
                });
            }
        });
    },
    del: function(t) {
        var a = this, e = a.data.nclass;
        1 != e ? 4 != e ? 5 != e && 6 != e ? 2 != e ? 3 != e ? 8 != e ? 7 != e ? 9 != e || a.rechargedel() : a.seven() : a.send() : a.smalldel() : a.deductdel() : a.depositdel() : a.updel() : a.stalldel();
    },
    rechargedel: function(a) {
        var e = this, o = e.data.logintag, n = e.data.nid, d = e.data.pid;
        wx.request({
            url: t.data.url + "member_account_amount_order_detail_del",
            data: {
                logintag: o,
                nid: n,
                pid: d
            },
            header: {
                "content-type": "application/x-www-form-urlencoded"
            },
            success: function(t) {
                console.log("删除账户充值"), console.log(t), "0000" == t.data.retCode ? (wx.navigateBack({
                    delta: 1,
                    success: function(t) {
                        var a = getCurrentPages().pop();
                        void 0 != a && null != a && a.onLoad();
                    }
                }), wx.showToast({
                    title: t.data.retDesc,
                    icon: "none",
                    duration: 1e3
                })) : wx.showToast({
                    title: t.data.retDesc,
                    icon: "none",
                    duration: 1e3
                });
            }
        });
    },
    send: function(a) {
        var e = this, o = e.data.logintag, n = e.data.nid, d = e.data.pid;
        wx.request({
            url: t.data.url + "deduction_carfare_detail_del",
            data: {
                logintag: o,
                nid: n,
                pid: d
            },
            header: {
                "content-type": "application/x-www-form-urlencoded"
            },
            success: function(t) {
                console.log("删除收入明细表扣除车资记录"), console.log(t), "0000" == t.data.retCode ? (wx.navigateBack({
                    delta: 1,
                    success: function(t) {
                        var a = getCurrentPages().pop();
                        void 0 != a && null != a && a.onLoad();
                    }
                }), wx.showToast({
                    title: t.data.retDesc,
                    icon: "none",
                    duration: 1e3
                })) : wx.showToast({
                    title: t.data.retDesc,
                    icon: "none",
                    duration: 1e3
                });
            }
        });
    },
    seven: function(a) {
        var e = this, o = e.data.logintag, n = e.data.nid, d = e.data.pid;
        wx.request({
            url: t.data.url + "income_detail_del",
            data: {
                logintag: o,
                nid: n,
                pid: d
            },
            header: {
                "content-type": "application/x-www-form-urlencoded"
            },
            success: function(t) {
                console.log("删除收入明细记录"), console.log(t), "0000" == t.data.retCode ? (wx.navigateBack({
                    delta: 1,
                    success: function(t) {
                        var a = getCurrentPages().pop();
                        void 0 != a && null != a && a.onLoad();
                    }
                }), wx.showToast({
                    title: t.data.retDesc,
                    icon: "none",
                    duration: 1e3
                })) : wx.showToast({
                    title: t.data.retDesc,
                    icon: "none",
                    duration: 1e3
                });
            }
        });
    },
    stalldel: function(a) {
        var e = this, o = e.data.logintag, n = e.data.nid, d = e.data.pid;
        wx.request({
            url: t.data.url + "passenger_parking_lot_detail_del",
            data: {
                logintag: o,
                nid: n,
                pid: d
            },
            header: {
                "content-type": "application/x-www-form-urlencoded"
            },
            success: function(t) {
                console.log("删除收入明细表乘客购买车主车位记录"), console.log(t), "0000" == t.data.retCode ? (wx.navigateBack({
                    delta: 1,
                    success: function(t) {
                        var a = getCurrentPages().pop();
                        void 0 != a && null != a && a.onLoad();
                    }
                }), wx.showToast({
                    title: t.data.retDesc,
                    icon: "none",
                    duration: 1e3
                })) : wx.showToast({
                    title: t.data.retDesc,
                    icon: "none",
                    duration: 1e3
                });
            }
        });
    },
    updel: function(a) {
        var e = this, o = e.data.logintag, n = e.data.nid, d = e.data.pid;
        wx.request({
            url: t.data.url + "passenger_recharge_detail_del",
            data: {
                logintag: o,
                nid: n,
                pid: d
            },
            header: {
                "content-type": "application/x-www-form-urlencoded"
            },
            success: function(t) {
                console.log("删除收入明细表充值押金记录"), console.log(t), "0000" == t.data.retCode ? (wx.navigateBack({
                    delta: 1,
                    success: function(t) {
                        var a = getCurrentPages().pop();
                        void 0 != a && null != a && a.onLoad();
                    }
                }), wx.showToast({
                    title: t.data.retDesc,
                    icon: "none",
                    duration: 1e3
                })) : wx.showToast({
                    title: t.data.retDesc,
                    icon: "none",
                    duration: 1e3
                });
            }
        });
    },
    depositdel: function(a) {
        var e = this, o = e.data.logintag, n = e.data.nid, d = e.data.pid;
        wx.request({
            url: t.data.url + "passenger_withdraw_detail_del",
            data: {
                logintag: o,
                nid: n,
                pid: d
            },
            header: {
                "content-type": "application/x-www-form-urlencoded"
            },
            success: function(t) {
                console.log("删除收入明细表提现记录"), console.log(t), "0000" == t.data.retCode ? (wx.navigateBack({
                    delta: 1,
                    success: function(t) {
                        var a = getCurrentPages().pop();
                        void 0 != a && null != a && a.onLoad();
                    }
                }), wx.showToast({
                    title: t.data.retDesc,
                    icon: "none",
                    duration: 1e3
                })) : wx.showToast({
                    title: t.data.retDesc,
                    icon: "none",
                    duration: 1e3
                });
            }
        });
    },
    deductdel: function(a) {
        var e = this, o = e.data.logintag, n = e.data.nid, d = e.data.pid;
        wx.request({
            url: t.data.url + "deduction_deposit_detail_del",
            data: {
                logintag: o,
                nid: n,
                pid: d
            },
            header: {
                "content-type": "application/x-www-form-urlencoded"
            },
            success: function(t) {
                console.log("删除收入明细表扣除押金记录"), console.log(t), "0000" == t.data.retCode ? (wx.navigateBack({
                    delta: 1,
                    success: function(t) {
                        var a = getCurrentPages().pop();
                        void 0 != a && null != a && a.onLoad();
                    }
                }), wx.showToast({
                    title: t.data.retDesc,
                    icon: "none",
                    duration: 1e3
                })) : wx.showToast({
                    title: t.data.retDesc,
                    icon: "none",
                    duration: 1e3
                });
            }
        });
    },
    smalldel: function(a) {
        var e = this, o = e.data.logintag, n = e.data.nid, d = e.data.pid;
        wx.request({
            url: t.data.url + "deduction_carfare_detail_del",
            data: {
                logintag: o,
                nid: n,
                pid: d
            },
            header: {
                "content-type": "application/x-www-form-urlencoded"
            },
            success: function(t) {
                console.log("删除收入明细表扣除车资记录"), console.log(t), "0000" == t.data.retCode ? (wx.navigateBack({
                    delta: 1,
                    success: function(t) {
                        var a = getCurrentPages().pop();
                        void 0 != a && null != a && a.onLoad();
                    }
                }), wx.showToast({
                    title: t.data.retDesc,
                    icon: "none",
                    duration: 1e3
                })) : wx.showToast({
                    title: t.data.retDesc,
                    icon: "none",
                    duration: 1e3
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {
        var t = this.data.id;
        return console.log("分享：", t), {
            title: "拼车",
            desc: "拼车!",
            path: "/pages/index/index?id=" + t
        };
    }
});