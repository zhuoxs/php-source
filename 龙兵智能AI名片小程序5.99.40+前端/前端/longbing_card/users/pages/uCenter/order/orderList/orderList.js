var _xx_util = require("../../../../../resource/js/xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util), _index = require("../../../../../resource/apis/index.js");

function _interopRequireDefault(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}

function _toConsumableArray(t) {
    if (Array.isArray(t)) {
        for (var e = 0, a = Array(t.length); e < t.length; e++) a[e] = t[e];
        return a;
    }
    return Array.from(t);
}

function _asyncToGenerator(t) {
    return function() {
        var i = t.apply(this, arguments);
        return new Promise(function(o, s) {
            return function e(t, a) {
                try {
                    var n = i[t](a), r = n.value;
                } catch (t) {
                    return void s(t);
                }
                if (!n.done) return Promise.resolve(r).then(function(t) {
                    e("next", t);
                }, function(t) {
                    e("throw", t);
                });
                o(r);
            }("next");
        });
    };
}

var app = getApp(), regeneratorRuntime = _xx_util2.default.regeneratorRuntime;

Page({
    data: {
        tabList: [ {
            name: "全部",
            status: "toOrder"
        }, {
            name: "待付款",
            status: "toOrder"
        }, {
            name: "待发货",
            status: "toOrder"
        }, {
            name: "待收货",
            status: "toOrder"
        }, {
            name: "已完成",
            status: "toOrder"
        }, {
            name: "已退款",
            status: "toOrder"
        } ],
        currentIndex: 0,
        scrollNav: "scrollNav0",
        globalData: {},
        toShowWxPayStatus: !1,
        toWxPayStatus: 0,
        checkInd: -1,
        dataList: {
            list: [],
            page: 1,
            total_page: 20
        },
        param: {
            page: 1
        },
        refresh: !1,
        loading: !0
    },
    onLoad: function(t) {
        console.log(t, "options");
        var e = t.currentTab;
        this.setData({
            currentIndex: e || 0,
            toShowWxPayStatus: !1,
            globalData: app.globalData
        });
    },
    onShow: function() {
        0 == this.data.toShowWxPayStatus && this.onPullDownRefresh();
    },
    onPullDownRefresh: function() {
        var a = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function t() {
            var e;
            return regeneratorRuntime.wrap(function(t) {
                for (;;) switch (t.prev = t.next) {
                  case 0:
                    return e = a, t.next = 3, getApp().getConfigInfo(!0);

                  case 3:
                    e.setData({
                        refresh: !0,
                        "param.page": 1
                    }, function() {
                        wx.showNavigationBarLoading(), e.getList();
                    });

                  case 4:
                  case "end":
                    return t.stop();
                }
            }, t, a);
        }))();
    },
    onReachBottom: function() {
        var t = this.data, e = t.loading, a = t.dataList, n = a.page;
        n == a.total_page || e || (this.setData({
            "param.page": n + 1,
            loading: !0
        }), this.getList());
    },
    getList: function() {
        var _ = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function t() {
            var e, a, n, r, o, s, i, u, d, c, l, f;
            return regeneratorRuntime.wrap(function(t) {
                for (;;) switch (t.prev = t.next) {
                  case 0:
                    return a = (e = _).data, n = a.refresh, r = a.param, o = a.dataList, s = a.currentIndex, 
                    r.type = s, t.next = 5, _index.userModel.getShopMyOrder(r);

                  case 5:
                    for (l in i = t.sent, u = i.data, _xx_util2.default.hideAll(), d = o, n || (u.list = [].concat(_toConsumableArray(d.list), _toConsumableArray(u.list))), 
                    u.page = 1 * u.page, c = u.list) if (c[l].left_time = _xx_util2.default.formatTime(1e3 * c[l].left_time, "h小时m分"), 
                    c[l].tmp_is_self = !1, c[l].refund_text = 0 == c[l].refund_status ? "申请退款" : 1 == c[l].refund_status ? "取消退款" : 2 == c[l].refund_status ? "已同意退款" : "已拒绝退款", 
                    c[l].goods_info) for (f in c[l].total_count_number = 0, c[l].goods_info) c[l].total_count_number += parseInt(c[l].goods_info[f].number), 
                    c[l].goods_info[f].unit_price = _xx_util2.default.getNormalPrice((c[l].goods_info[f].price / c[l].goods_info[f].number).toFixed(4)), 
                    1 == c[l].goods_info[f].is_self && (c[l].tmp_is_self = !0);
                    e.setData({
                        dataList: u,
                        loading: !1,
                        refresh: !1
                    });

                  case 14:
                  case "end":
                    return t.stop();
                }
            }, t, _);
        }))();
    },
    getShopcancelorder: function(t, e) {
        var a = this, n = a.data.dataList.list, r = a.data.currentIndex;
        _index.userModel.getShopCancelOrder({
            id: t
        }).then(function(t) {
            0 == t.errno && (_xx_util2.default.showSuccess("已取消订单"), 0 == r && (n[e].order_status = 1), 
            1 == r && n.splice(e, 1), a.setData({
                "dataList.list": n
            }));
        });
    },
    getShopendorder: function(t, e) {
        var a = this, n = a.data.dataList.list, r = a.data.currentIndex;
        _index.userModel.getShopEndOrder({
            id: t
        }).then(function(t) {
            0 == t.errno && (_xx_util2.default.showSuccess("已确认收货"), 0 == r && (n[e].order_status = 3), 
            0 != r && n.splice(e, 1), a.setData({
                "dataList.list": n
            }));
        });
    },
    getRefund: function(t, e) {
        var a = this, n = a.data.dataList.list;
        _index.userModel.getShopRefund({
            order_id: t
        }).then(function(t) {
            0 == t.errno && (_xx_util2.default.showSuccess("已申请退款"), n[e].pay_status = 2, a.setData({
                "dataList.list": n
            }));
        });
    },
    getWxPay: function(t, e) {
        var a = this;
        _xx_util2.default.showLoading(), _index.userModel.getWxPay({
            order_id: t
        }).then(function(t) {
            _xx_util2.default.hideAll(), console.log("getWxPay ==>", t), 0 == t.errno ? wx.requestPayment({
                timeStamp: t.data.timeStamp,
                nonceStr: t.data.nonceStr,
                package: t.data.package,
                signType: "MD5",
                paySign: t.data.paySign,
                success: function(t) {
                    wx.showToast({
                        icon: "success",
                        image: "/longbing_card/resource/images/alert.png",
                        title: "支付成功",
                        duration: 2e3,
                        success: function() {
                            setTimeout(function() {
                                _xx_util2.default.hideAll(), a.setData({
                                    currentIndex: 2,
                                    toWxPayStatus: 0
                                }, function() {
                                    this.onPullDownRefresh();
                                });
                            }, 1e3);
                        }
                    });
                },
                fail: function(t) {
                    wx.showToast({
                        icon: "fail",
                        image: "/longbing_card/resource/images/error.png",
                        title: "支付失败",
                        duration: 2e3,
                        success: function() {
                            setTimeout(function() {
                                a.setData({
                                    toWxPayStatus: 0,
                                    toShowWxPayStatus: !0
                                }), _xx_util2.default.hideAll();
                            }, 1500);
                        }
                    });
                },
                complete: function(t) {}
            }) : wx.showModal({
                title: "系统提示",
                content: t.data.message || "支付失败，请重试",
                showCancel: !1,
                success: function(t) {
                    t.confirm && a.setData({
                        toWxPayStatus: 0,
                        toShowWxPayStatus: !0
                    });
                }
            });
        });
    },
    checktoConsult: function(t) {
        if (console.log(t, "toConsult to_uid"), 0 != t) if (t == wx.getStorageSync("userid")) wx.showModal({
            title: "",
            content: "不能和自己进行对话哦！",
            confirmText: "知道啦",
            showCancel: !1,
            success: function(t) {
                t.confirm;
            }
        }); else {
            var e = "/longbing_card/chat/userChat/userChat?chat_to_uid=" + t + "&contactUserName=";
            console.log(e, "tmp_path"), wx.navigateTo({
                url: e
            });
        }
    },
    toOrderCancelRefund: function(o) {
        var s = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function t() {
            var e, a, n, r;
            return regeneratorRuntime.wrap(function(t) {
                for (;;) switch (t.prev = t.next) {
                  case 0:
                    e = _xx_util2.default.getData(o), a = e.index, n = s.data.dataList.list, r = n[a].id, 
                    _index.userModel.getOrderCancelRefund({
                        id: r
                    }).then(function(t) {
                        0 != t.errno ? _xx_util2.default.showModal({
                            title: "",
                            content: t.message
                        }) : (_xx_util2.default.showSuccess(t.message), n[a].refund_status = 0, n[a].refund_text = "申请退款", 
                        s.setData({
                            "dataList.list": n
                        }));
                    });

                  case 4:
                  case "end":
                    return t.stop();
                }
            }, t, s);
        }))();
    },
    toOrderRefund: function(o) {
        var s = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function t() {
            var e, a, n, r;
            return regeneratorRuntime.wrap(function(t) {
                for (;;) switch (t.prev = t.next) {
                  case 0:
                    e = _xx_util2.default.getData(o), a = e.index, n = s.data.dataList.list, r = n[a].id, 
                    _index.userModel.getOrderRefund({
                        id: r
                    }).then(function(t) {
                        _xx_util2.default.showModal({
                            title: "",
                            content: t.message
                        }), 0 == t.errno && (n[a].refund_status = 1, n[a].refund_text = "取消退款", s.setData({
                            "dataList.list": n
                        }));
                    });

                  case 4:
                  case "end":
                    return t.stop();
                }
            }, t, s);
        }))();
    },
    toJump: function(t) {
        var a = this, e = _xx_util2.default.getData(t), n = e.status, r = e.index, o = a.data, s = o.toWxPayStatus, i = o.dataList.list;
        "toConsult" == n ? a.checktoConsult(i[r].to_uid) : "toCancel" == n ? a.getShopcancelorder(i[r].id, r) : "toRefund" == n ? a.getRefund(i[r].id, r) : "toWxPay" == n ? 0 == s && a.setData({
            toWxPayStatus: 1
        }, function() {
            a.getWxPay(i[r].id, r);
        }) : "toConfirm" == n ? a.getShopendorder(i[r].id, r) : "toCheckPassword" == n && _index.staffModel.toGetOrderQr({
            id: i[r].id
        }).then(function(t) {
            _xx_util2.default.hideAll(), console.log("toGetOrderQr ==>", t.data);
            var e = t.data.path;
            a.setData({
                qr: e,
                checkInd: r
            });
        });
    },
    toTabClick: function(t) {
        var e = _xx_util2.default.getData(t).index;
        this.setData({
            currentIndex: e,
            scrollNav: "scrollNav" + e
        }), this.onPullDownRefresh();
    }
});