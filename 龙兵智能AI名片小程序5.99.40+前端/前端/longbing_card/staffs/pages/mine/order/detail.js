var _xx_util = require("../../../../resource/js/xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util), _index = require("../../../../resource/apis/index.js");

function _interopRequireDefault(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}

function _asyncToGenerator(t) {
    return function() {
        var s = t.apply(this, arguments);
        return new Promise(function(r, o) {
            return function e(t, a) {
                try {
                    var n = s[t](a), i = n.value;
                } catch (t) {
                    return void o(t);
                }
                if (!n.done) return Promise.resolve(i).then(function(t) {
                    e("next", t);
                }, function(t) {
                    e("throw", t);
                });
                r(i);
            }("next");
        });
    };
}

var timerOverTime, app = getApp(), regeneratorRuntime = _xx_util2.default.regeneratorRuntime;

Page({
    data: {
        toWxPayStatus: 0,
        checkInd: -1
    },
    onLoad: function(t) {
        console.log(t, "options");
        var e = this;
        _xx_util2.default.showLoading();
        var a = {
            id: t.id,
            status: t.status
        };
        getApp().getConfigInfo().then(function() {
            e.setData({
                paramData: a,
                globalData: app.globalData
            }), e.getDetailData(), _xx_util2.default.hideAll();
        });
    },
    onHide: function() {
        clearInterval(timerOverTime), wx.hideLoading();
    },
    onUnload: function() {
        clearInterval(timerOverTime), wx.hideLoading();
    },
    onPullDownRefresh: function() {
        wx.showNavigationBarLoading(), this.getDetailData();
    },
    getDetailData: function() {
        var i = this, t = i.data.paramData.id;
        _index.userModel.getShopOrderDetail({
            id: t
        }).then(function(t) {
            _xx_util2.default.hideAll();
            var e = t.data;
            if (e.create_time2 = _xx_util2.default.formatTime(1e3 * e.create_time, "YY-M-D h:m:s"), 
            e.left_time) {
                var a = e.left_time;
                timerOverTime = setInterval(function() {
                    e.left_time = e.left_time - 1;
                    var t = parseInt(e.left_time / 24 / 60 / 60);
                    a = (t = 0 < t ? t + "天" : "") + _xx_util2.default.formatTime(1e3 * e.left_time, "h小时m分s秒"), 
                    i.setData({
                        tmpOverTimes: a
                    });
                }, 1e3);
            }
            for (var n in e.tmp_is_self = !1, e.goods_info) e.goods_info[n].unit_price = (e.goods_info[n].price / e.goods_info[n].number).toFixed(2), 
            1 == e.goods_info[n].is_self && (e.tmp_is_self = !0);
            i.setData({
                detailData: e
            });
        });
    },
    checktoConsult: function() {
        var t = this.data.detailData.to_uid, e = "", a = this.data.detailData, n = [];
        if (0 == a.type) a.user_info && (e = a.user_info.name); else for (var i in a.own && n.push(a.own), 
        a.users && n.push(a.users), n) t == n[i].id && (e = n[i].nickName);
        if (0 == t) return console.log(t, "toConsult to_uid"), !1;
        t == wx.getStorageSync("userid") ? wx.showModal({
            title: "",
            content: "不能和自己进行对话哦！",
            confirmText: "知道啦",
            showCancel: !1,
            success: function(t) {
                t.confirm;
            }
        }) : (console.log("/longbing_card/chat/userChat/userChat?chat_to_uid=" + t + "&contactUserName=" + e), 
        wx.navigateTo({
            url: "/longbing_card/chat/userChat/userChat?chat_to_uid=" + t + "&contactUserName=" + e
        }));
    },
    getShopcancelorder: function() {
        var t = this.data.paramData.id;
        _index.userModel.getShopCancelOrder({
            id: t
        }).then(function(t) {
            if (_xx_util2.default.hideAll(), 0 != t.errno) return !1;
            wx.showToast({
                icon: "success",
                title: "已取消订单",
                duration: 2e3,
                success: function() {
                    setTimeout(function() {
                        wx.navigateBack();
                    }, 1e3);
                }
            });
        });
    },
    getShopdelorder: function() {
        var a = this, t = a.data.paramData.id;
        _index.userModel.getShopDelOrder({
            id: t
        }).then(function(t) {
            if (_xx_util2.default.hideAll(), 0 == t.errno) {
                var e = 1 == a.data.detailData.type ? "已删除拼团" : "已删除订单";
                _xx_util2.default.showSuccess(e), setTimeout(function() {
                    wx.navigateBack();
                }, 1e3);
            }
        });
    },
    getShopendorder: function() {
        var e = this, t = e.data.paramData.id;
        _index.userModel.getShopEndOrder({
            id: t
        }).then(function(t) {
            if (_xx_util2.default.hideAll(), 0 != t.errno) return !1;
            wx.showToast({
                icon: "success",
                title: "已确认收货",
                duration: 2e3,
                success: function() {
                    setTimeout(function() {
                        e.setData({
                            "detailData.order_status": 3
                        });
                    }, 1e3);
                }
            });
        });
    },
    getWxPay: function() {
        var e = this;
        _xx_util2.default.showLoading();
        var t = e.data.paramData.id, a = e.data.detailData;
        _index.userModel.getWxPay({
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
                            a.pay_status = 1, e.setData({
                                detailData: a
                            }), setTimeout(function() {
                                e.data.toWxPayStatus = 0, wx.hideLoading();
                            }, 1500);
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
                                e.data.toWxPayStatus = 0, wx.hideLoading();
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
                    t.confirm && e.setData({
                        toWxPayStatus: 0
                    });
                }
            });
        });
    },
    toOrderCancelRefund: function(t) {
        var n = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function t() {
            var e, a;
            return regeneratorRuntime.wrap(function(t) {
                for (;;) switch (t.prev = t.next) {
                  case 0:
                    e = n.data.detailData, a = e.id, _index.userModel.getOrderCancelRefund({
                        id: a
                    }).then(function(t) {
                        0 != t.errno ? _xx_util2.default.showModal({
                            title: "",
                            content: t.message
                        }) : (_xx_util2.default.showSuccess(t.message), e.refund_status = 0, e.refund_text = "申请退款", 
                        n.setData({
                            detailData: e
                        }));
                    });

                  case 3:
                  case "end":
                    return t.stop();
                }
            }, t, n);
        }))();
    },
    toOrderRefund: function(t) {
        var n = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function t() {
            var e, a;
            return regeneratorRuntime.wrap(function(t) {
                for (;;) switch (t.prev = t.next) {
                  case 0:
                    e = n.data.detailData, a = e.id, _index.userModel.getOrderRefund({
                        id: a
                    }).then(function(t) {
                        _xx_util2.default.showModal({
                            title: "",
                            content: t.message
                        }), 0 == t.errno && (e.refund_status = 1, e.refund_text = "取消退款", n.setData({
                            detailData: e
                        }));
                    });

                  case 3:
                  case "end":
                    return t.stop();
                }
            }, t, n);
        }))();
    },
    toJump: function(o) {
        var s = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function t() {
            var a, e, n, i, r;
            return regeneratorRuntime.wrap(function(t) {
                for (;;) switch (t.prev = t.next) {
                  case 0:
                    if (a = s, e = _xx_util2.default.getData(o), n = e.status, e.id, i = a.data.detailData, 
                    "toConsult" != n) {
                        t.next = 7;
                        break;
                    }
                    a.checktoConsult(), t.next = 31;
                    break;

                  case 7:
                    if ("toCancel" != n) {
                        t.next = 11;
                        break;
                    }
                    a.getShopcancelorder(), t.next = 31;
                    break;

                  case 11:
                    if ("toWxPay" != n) {
                        t.next = 16;
                        break;
                    }
                    0 == a.data.toWxPayStatus && a.setData({
                        toWxPayStatus: 1
                    }, function() {
                        a.getWxPay();
                    }), t.next = 31;
                    break;

                  case 16:
                    if ("toConfirm" != n) {
                        t.next = 20;
                        break;
                    }
                    a.getShopendorder(), t.next = 31;
                    break;

                  case 20:
                    if ("toDelete" != n) {
                        t.next = 30;
                        break;
                    }
                    return t.next = 23, wx.pro.showModal({
                        title: "提示",
                        content: "请确认是否要删除此数据"
                    });

                  case 23:
                    if (r = t.sent, r.confirm) {
                        t.next = 27;
                        break;
                    }
                    return t.abrupt("return");

                  case 27:
                    a.getShopdelorder(), t.next = 31;
                    break;

                  case 30:
                    "toCheckPassword" == n && _index.staffModel.toGetOrderQr({
                        id: i.id
                    }).then(function(t) {
                        _xx_util2.default.hideAll(), console.log("toGetOrderQr ==>", t.data);
                        var e = t.data.path;
                        a.setData({
                            qr: e,
                            checkInd: 0
                        });
                    });

                  case 31:
                  case "end":
                    return t.stop();
                }
            }, t, s);
        }))();
    }
});