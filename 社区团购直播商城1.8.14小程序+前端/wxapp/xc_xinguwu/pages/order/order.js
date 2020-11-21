var _Page;

function _defineProperty(a, t, e) {
    return t in a ? Object.defineProperty(a, t, {
        value: e,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : a[t] = e, a;
}

var app = getApp();

function qrcode(a) {
    return require("../../../utils/wxqrcode.js").createQrCodeImg(a, {
        size: 300
    });
}

Page((_defineProperty(_Page = {
    data: {
        curIndex: 0,
        page: 1,
        pagesize: 10,
        loadend: !1,
        order: [],
        qrcode: !1
    },
    hideQrcode: function() {
        this.setData({
            qrcode: !1
        });
    },
    onLoad: function(a) {
        var t, e = this;
        app.look.istrue(a.status) ? (t = parseInt(a.status), this.setData({
            curIndex: t
        })) : t = this.data.curIndex, this.setData({
            "goHome.blackhomeimg": app.globalData.blackhomeimg,
            refund: app.globalData.webset.refund
        }), app.util.showLoading(), app.util.request({
            url: "entry/wxapp/my",
            method: "POST",
            data: {
                op: "getorder",
                page: e.data.page,
                pagesize: e.data.pagesize,
                status: t
            },
            success: function(a) {
                var t = a.data;
                t.data.list && e.setData({
                    order: t.data.list,
                    page: 2
                });
            },
            fail: function(a) {
                1 == a.data.errno && (app.look.no(a.data.message), e.setData({
                    loadend: !0,
                    order: null
                }));
            }
        });
    },
    onReady: function() {
        app.look.navbar(this);
    },
    cancelOrder: function(a) {
        var t = this, e = a.currentTarget.dataset.index, r = this.data.order, o = r[e].id;
        wx.showModal({
            title: "提示",
            content: "确定取消订单",
            success: function(a) {
                a.confirm ? (wx.showLoading({
                    title: "操作中"
                }), app.util.request({
                    url: "entry/wxapp/my",
                    data: {
                        op: "off_order",
                        id: o
                    },
                    success: function(a) {
                        wx.hideLoading(), app.look.ok(a.data.message), r.splice(e, 1), t.setData({
                            order: r
                        });
                    }
                })) : a.cancel && console.log("用户点击取消");
            }
        });
    },
    rebuy: function(a) {
        var t = this, e = a.currentTarget.dataset.index, r = this.data.order[e].list, d = wx.getStorageSync("cars") || [];
        d && r.forEach(function(a, t) {
            for (var e = !1, r = 0, o = d.length; r < o; r++) if (d[r].id == a.id && a.attr == d[r].attr) {
                e = !0;
                break;
            }
            e || d.push({
                id: a.id,
                num: a.num,
                price: a.price,
                attr: a.attr,
                cid: 1
            });
        }), wx.setStorage({
            key: "cars",
            data: d,
            success: function() {
                t.setData({
                    carnum: d.length
                }), wx.showToast({
                    title: "已加入购物车"
                });
            }
        }), wx.redirectTo({
            url: "/xc_xinguwu/pages/cart/cart"
        });
    },
    bindTap: function(a) {
        var e = this, t = parseInt(a.currentTarget.dataset.index);
        app.util.showLoading(), app.util.request({
            url: "entry/wxapp/my",
            method: "POST",
            data: {
                op: "getorder",
                page: 1,
                pagesize: e.data.pagesize,
                status: t
            },
            success: function(a) {
                var t = a.data;
                t.data.list && e.setData({
                    order: t.data.list,
                    page: 2,
                    loadend: !1
                });
            },
            fail: function(a) {
                1 == a.data.errno && (app.look.no(a.data.message), e.setData({
                    loadend: !0,
                    order: null,
                    page: 1
                }));
            }
        }), this.setData({
            curIndex: t
        });
    },
    topay: function(a) {
        var e = this, r = a.currentTarget.dataset.index, o = this.data.order, t = o[r].id;
        wx.showLoading({
            title: "加载中"
        }), app.util.request({
            url: "entry/wxapp/my",
            data: {
                op: "pay_order",
                id: t
            },
            success: function(a) {
                console.log(a), wx.hideLoading(), a.data && a.data.data && !a.data.errno && wx.requestPayment({
                    timeStamp: a.data.data.timeStamp,
                    nonceStr: a.data.data.nonceStr,
                    package: a.data.data.package,
                    signType: "MD5",
                    paySign: a.data.data.paySign,
                    success: function(a) {
                        var t = o[r].order;
                        setTimeout(function() {
                            !function a(t) {
                                app.util.request({
                                    url: "entry/wxapp/payquery",
                                    showLoading: !1,
                                    data: {
                                        tid: t
                                    },
                                    success: function(a) {
                                        app.globalData.userInfo = a.data.data, 0 == e.data.curIndex ? o[r].status = 2 : o.splice(r, 1), 
                                        e.setData({
                                            order: o
                                        });
                                    },
                                    fail: function() {
                                        console.log(123), setTimeout(function() {
                                            a(t);
                                        }, 1e3);
                                    }
                                });
                            }(t);
                        }, 500);
                    },
                    fail: function(a) {
                        a.errMsg;
                    }
                });
            }
        });
    },
    toOrderDetail: function(a) {
        var t = this.data.order[a.currentTarget.dataset.index].id;
        wx.navigateTo({
            url: "../orderDetail/orderDetail?id=" + t
        });
    },
    toRefund: function(a) {
        var t = this.data.order[a.currentTarget.dataset.index].id;
        wx.navigateTo({
            url: "../refund/refund?id=" + t
        });
    },
    toDelivery: function(a) {
        var t = a.currentTarget.dataset.index, e = this.data.order[t].id;
        wx.showLoading({
            title: "提交中"
        }), app.util.request({
            url: "entry/wxapp/my",
            data: {
                op: "remind_order",
                id: e
            },
            success: function(a) {
                wx.hideLoading(), app.util.message({
                    title: a.data.message
                });
            }
        });
    },
    confirmReceipt: function(a) {
        var t = this, e = a.currentTarget.dataset.index, r = this.data.order, o = r[e].id;
        wx.showModal({
            title: "提示",
            content: "确认收货?",
            success: function(a) {
                a.confirm && (wx.showLoading({
                    title: "加载中"
                }), app.util.request({
                    url: "entry/wxapp/my",
                    data: {
                        op: "sure_order",
                        id: o
                    },
                    success: function(a) {
                        app.look.ok(a.data.message), 0 == t.data.curIndex ? r[e].status = 5 : r.splice(e, 1), 
                        t.setData({
                            order: r
                        }), 1 == app.globalData.webset.comment && wx.showModal({
                            title: "发表评论",
                            content: "发表评论?",
                            success: function(a) {
                                a.confirm && wx.navigateTo({
                                    url: "/xc_xinguwu/pages/comment/comment?id=" + o
                                });
                            }
                        });
                    }
                }));
            }
        });
    },
    onPullDownRefresh: function() {
        var e = this, a = this.data.curIndex;
        app.util.showLoading(), app.util.request({
            url: "entry/wxapp/my",
            method: "POST",
            data: {
                op: "getorder",
                page: 1,
                pagesize: e.data.pagesize,
                status: a
            },
            success: function(a) {
                wx.stopPullDownRefresh();
                var t = a.data;
                t.data.list && e.setData({
                    order: t.data.list,
                    page: 2,
                    loadend: !1
                });
            },
            fail: function(a) {
                1 == a.data.errno && (app.look.no(a.data.message), e.setData({
                    loadend: !0,
                    order: null,
                    page: 1
                }));
            }
        });
    },
    onReachBottom: function() {
        var e = this, a = this.data.loadend, r = this.data.order;
        a || (app.util.showLoading(), app.util.request({
            url: "entry/wxapp/my",
            method: "POST",
            data: {
                op: "getorder",
                page: e.data.page,
                pagesize: e.data.pagesize,
                status: e.data.curIndex
            },
            success: function(a) {
                var t = a.data;
                t.data.list && e.setData({
                    order: r.concat(t.data.list),
                    page: e.data.page + 1
                });
            },
            fail: function(a) {
                1 == a.data.errno && (app.look.no(a.data.message), e.setData({
                    loadend: !0
                }));
            }
        }));
    },
    toRefundDetail: function(a) {
        wx.navigateTo({
            url: "../refundDetail2/refundDetail2?id=" + this.data.order[a.currentTarget.dataset.index].id
        });
    }
}, "onReady", function() {
    var a = {};
    a.nor_pos = app.module_url + "resource/wxapp/community/nor-pos.png", this.setData({
        images: a
    });
}), _defineProperty(_Page, "pickCode", function(a) {
    var e = this, r = a.currentTarget.dataset.index;
    console.log(r), "" != this.data.order[r].hex ? this.setData({
        hex: qrcode(this.data.order[r].hex + "#" + e.data.order[r].order),
        qrcode: !0
    }) : app.util.request({
        url: "entry/wxapp/community",
        showLoading: !0,
        method: "POST",
        data: {
            op: "pickCode",
            id: e.data.order[r].id
        },
        success: function(a) {
            var t;
            e.setData((_defineProperty(t = {
                hex: qrcode(a.data.data + "#" + e.data.order[r].order)
            }, "order[" + r + "].hex", a.data.data), _defineProperty(t, "qrcode", !0), t));
        },
        fail: function(a) {
            app.look.no(a.data.message);
        }
    });
}), _defineProperty(_Page, "toNav", function(a) {
    var t = a.currentTarget.dataset.index;
    app.util.request({
        url: "entry/wxapp/community",
        showLoading: !0,
        method: "POST",
        data: {
            op: "getClubLocation",
            id: this.data.order[t].club_id
        },
        success: function(a) {
            wx.openLocation({
                latitude: parseFloat(a.data.data.latitude),
                longitude: parseFloat(a.data.data.longitude),
                complete: function(a) {}
            });
        }
    });
}), _Page));