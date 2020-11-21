var t = getApp();

Page(function(t, a, e) {
    return a in t ? Object.defineProperty(t, a, {
        value: e,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[a] = e, t;
}({
    data: {
        isShow: !1,
        TabCur: 0,
        scrollLeft: 0,
        list: [],
        page: 1,
        status: 0,
        is_last: !1
    },
    onLoad: function(a) {
        var e = this;
        t.util.getUserInfo(function(a) {
            a.memberInfo ? (t.util.request({
                url: "entry/wxapp/Api",
                data: {
                    m: "ox_reclaim",
                    r: "order.orderList",
                    uid: a.memberInfo.uid,
                    status: e.data.status,
                    page: e.data.page
                },
                success: function(t) {
                    e.setData({
                        list: t.data.data
                    });
                }
            }), wx.setStorageSync("uid", a.memberInfo.uid)) : e.hideDialog();
        });
    },
    hideDialog: function() {
        this.setData({
            isShow: !this.data.isShow
        });
    },
    updateUserInfo: function(a) {
        var e = this;
        e.hideDialog(), a.detail.userInfo && t.util.getUserInfo(function(a) {
            t.util.request({
                url: "entry/wxapp/Api",
                data: {
                    m: "ox_reclaim",
                    r: "order.orderList",
                    uid: a.memberInfo.uid,
                    status: e.data.status,
                    page: e.data.page
                },
                success: function(t) {
                    e.setData({
                        list: t.data.data
                    });
                }
            }), wx.setStorageSync("uid", a.memberInfo.uid);
        }, a.detail);
    },
    tabSelect: function(a) {
        var e = this;
        this.setData({
            page: 1,
            is_last: !1,
            TabCur: a.currentTarget.dataset.id,
            scrollLeft: 60 * (a.currentTarget.dataset.id - 1)
        }), t.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_reclaim",
                r: "order.orderList",
                uid: wx.getStorageSync("uid"),
                status: a.currentTarget.dataset.id,
                page: 1
            },
            success: function(t) {
                e.setData({
                    list: t.data.data,
                    TabCur: a.currentTarget.dataset.id,
                    scrollLeft: 60 * (a.currentTarget.dataset.id - 1),
                    status: a.currentTarget.dataset.id
                });
            }
        });
    },
    onPullDownRefresh: function() {
        var a = this;
        t.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_reclaim",
                r: "order.orderList",
                uid: wx.getStorageSync("uid"),
                status: a.data.status,
                page: 1
            },
            success: function(t) {
                a.setData({
                    list: t.data.data,
                    page: 1,
                    is_last: !1
                }), wx.stopPullDownRefresh();
            }
        });
    },
    onReachBottom: function() {
        var a = this;
        a.data.is_last || t.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_reclaim",
                r: "order.orderList",
                uid: wx.getStorageSync("uid"),
                page: a.data.page + 1,
                status: a.data.status
            },
            success: function(t) {
                t.data.data.length < 1 && (a.setData({
                    is_last: !0
                }), wx.showToast({
                    title: "没有更多数据了",
                    icon: "success",
                    duration: 2e3
                }));
                for (var e = a.data.list, r = 0; r < t.data.data.length; r++) e.push(t.data.data[r]);
                a.setData({
                    list: e,
                    page: a.data.page + 1
                });
            }
        });
    },
    cancel: function(a) {
        var e = this;
        t.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_reclaim",
                r: "order.cancel",
                uid: wx.getStorageSync("uid"),
                status: e.data.status,
                orderid: a.target.dataset.orderid,
                formid: a.detail.formId
            },
            success: function(a) {
                e.setData({
                    list: a.data.data,
                    page: 1,
                    is_last: !1
                }), t.util.message({
                    title: "预约取消成功"
                });
            }
        });
    },
    deleteOrder: function(a) {
        var e = this;
        t.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_reclaim",
                r: "order.deleteOrder",
                uid: wx.getStorageSync("uid"),
                status: e.data.status,
                orderid: a.target.dataset.orderid,
                formid: a.detail.formId
            },
            success: function(a) {
                e.setData({
                    list: a.data.data,
                    page: 1,
                    is_last: !1
                }), t.util.message({
                    title: "删除成功"
                });
            }
        });
    },
    confirm: function(a) {
        this.setData({
            querenid: a.target.dataset.orderid
        }), t.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_reclaim",
                r: "me.add_formid",
                uid: wx.getStorageSync("uid"),
                formid: a.detail.formId
            }
        });
    },
    quxiaoconfirm: function(t) {
        this.setData({
            querenid: 0
        });
    },
    confirmsub: function() {
        var a = this, e = a.data.querenid;
        this.setData({
            querenid: 0
        }), t.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_reclaim",
                r: "order.confirm",
                uid: wx.getStorageSync("uid"),
                status: a.data.status,
                orderid: e,
                formid: ""
            },
            success: function(e) {
                a.setData({
                    list: e.data.data,
                    page: 1,
                    is_last: !1
                }), t.util.message({
                    title: "确认成功"
                });
            }
        });
    },
    appraise: function(a) {
        t.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_reclaim",
                r: "me.add_formid",
                uid: wx.getStorageSync("uid"),
                formid: a.detail.formId
            }
        }), wx.navigateTo({
            url: "/pages/store/pages/appraise/index?orderid=" + a.target.dataset.orderid
        });
    },
    gofabu: function(a) {
        t.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_reclaim",
                r: "me.add_formid",
                uid: wx.getStorageSync("uid"),
                formid: a.detail.formId
            }
        }), wx.switchTab({
            url: "/pages/index/index"
        });
    },
    viewOrder: function(t) {
        wx.navigateTo({
            url: "/pages/order/detail/index?orderid=" + t.target.dataset.orderid
        });
    },
    selectReapir: function(a) {
        console.log(a.target.dataset.orderid);
        var e = this;
        t.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_reclaim",
                r: "bidding.selectReapir",
                uid: wx.getStorageSync("uid"),
                orderid: a.target.dataset.orderid,
                formid: a.detail.formId
            },
            success: function(t) {
                e.setData({
                    reapirlist: t.data.data
                });
            }
        }), this.setData({
            modalName: a.currentTarget.dataset.target
        });
    },
    selPay: function(t) {
        this.sureReapir(t);
    },
    hideModal: function(t) {
        this.setData({
            modalName: null
        });
    },
    sureReapir: function(a) {
        var e = this;
        t.util.request({
            url: "entry/wxapp/PaySel",
            data: {
                m: "ox_reclaim",
                r: "bidding.sureReapir",
                uid: wx.getStorageSync("uid"),
                rid: a.target.dataset.rid,
                orderid: a.target.dataset.orderid,
                price: a.target.dataset.price
            },
            success: function(t) {
                t.data && t.data.data && !t.data.errno && "1" != t.data.message && wx.requestPayment({
                    timeStamp: t.data.data.timeStamp,
                    nonceStr: t.data.data.nonceStr,
                    package: t.data.data.package,
                    signType: "MD5",
                    paySign: t.data.data.paySign,
                    success: function(t) {
                        var r = {
                            bid: a.target.dataset.bid,
                            rid: a.target.dataset.rid,
                            price: a.target.dataset.price,
                            orderid: a.target.dataset.orderid
                        };
                        e.upPayStaus(r), wx.showModal({
                            title: "选择师傅成功",
                            content: "师傅会第一时间联系您",
                            success: function(t) {
                                var a = {
                                    currentTarget: {
                                        dataset: {
                                            id: "1"
                                        }
                                    }
                                };
                                t.confirm && (e.tabSelect(a), e.hideModal());
                            }
                        });
                    },
                    fail: function(t) {
                        backApp();
                    }
                });
            },
            fail: function(t) {
                wx.showModal({
                    title: "系统提示",
                    content: t.data.message ? t.data.message : "错误",
                    showCancel: !1,
                    success: function(t) {
                        t.confirm && backApp();
                    }
                });
            }
        });
    },
    upPayStaus: function(a) {
        t.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_reclaim",
                r: "bidding.upOrder",
                uid: wx.getStorageSync("uid"),
                rid: a.rid,
                bid: a.bid,
                price: a.price,
                orderid: a.orderid
            },
            success: function(t) {},
            fail: function(t) {}
        });
    },
    flowShot: function(a) {
        var e = this;
        t.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_reclaim",
                r: "bidding.flowShot",
                uid: wx.getStorageSync("uid"),
                orderid: a.currentTarget.dataset.orderid,
                formid: a.detail.formId
            },
            success: function(a) {
                wx.showModal({
                    title: "系统提示",
                    content: a.data.message ? a.data.message : "错误",
                    showCancel: !1,
                    success: function(a) {
                        a.confirm && t.util.request({
                            url: "entry/wxapp/Api",
                            data: {
                                m: "ox_reclaim",
                                r: "order.orderList",
                                uid: wx.getStorageSync("uid"),
                                status: 0,
                                page: 1
                            },
                            success: function(t) {
                                e.setData({
                                    list: t.data.data
                                });
                            }
                        });
                    }
                });
            }
        });
    },
    call: function(t) {
        var a = t.target.dataset.rid;
        wx.navigateTo({
            url: "/pages/store/pages/masterDetail/index?uid=" + a
        });
    },
    refund: function(a) {
        var e = this;
        t.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_reclaim",
                r: "bidding.refund",
                uid: wx.getStorageSync("uid"),
                orderid: a.detail.value.orderid,
                reason: a.detail.value.reason
            },
            success: function(a) {
                t.util.message({
                    title: "申请成功"
                });
                var r = {
                    currentTarget: {
                        dataset: {
                            id: "2"
                        }
                    }
                };
                e.tabSelect(r), e.hideModal();
            },
            fail: function(a) {
                t.util.message({
                    title: "申请失败"
                }), e.hideModal();
            }
        });
    },
    refundInput: function(t) {
        this.setData({
            refundval: t.detail.value
        });
    },
    showModal: function(t) {
        this.setData({
            modalName: t.currentTarget.dataset.target,
            orderid: t.currentTarget.dataset.orderid
        });
    }
}, "hideModal", function(t) {
    this.setData({
        modalName: null,
        refundval: ""
    });
}));