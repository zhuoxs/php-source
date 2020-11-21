var _slicedToArray = function(t, e) {
    if (Array.isArray(t)) return t;
    if (Symbol.iterator in Object(t)) return function(t, e) {
        var a = [], o = !0, r = !1, n = void 0;
        try {
            for (var i, s = t[Symbol.iterator](); !(o = (i = s.next()).done) && (a.push(i.value), 
            !e || a.length !== e); o = !0) ;
        } catch (t) {
            r = !0, n = t;
        } finally {
            try {
                !o && s.return && s.return();
            } finally {
                if (r) throw n;
            }
        }
        return a;
    }(t, e);
    throw new TypeError("Invalid attempt to destructure non-iterable instance");
}, _xx_util = require("../../../../../resource/js/xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util), _index = require("../../../../../resource/apis/index.js");

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
        var s = t.apply(this, arguments);
        return new Promise(function(n, i) {
            return function e(t, a) {
                try {
                    var o = s[t](a), r = o.value;
                } catch (t) {
                    return void i(t);
                }
                if (!o.done) return Promise.resolve(r).then(function(t) {
                    e("next", t);
                }, function(t) {
                    e("throw", t);
                });
                n(r);
            }("next");
        });
    };
}

var app = getApp(), regeneratorRuntime = _xx_util2.default.regeneratorRuntime;

Page({
    data: {
        tabList: [ {
            dotNum: "0",
            name: "全部拼团",
            status: "toCollage"
        }, {
            dotNum: "0",
            name: "拼团中",
            status: "toCollage"
        }, {
            dotNum: "0",
            name: "拼团成功",
            status: "toCollage"
        }, {
            dotNum: "0",
            name: "拼团失败",
            status: "toCollage"
        } ],
        currentIndex: 0,
        scrollNav: "scrollNav0",
        toShowWxPayStatus: !1,
        toWxPayStatus: 0,
        dataList: {
            list: [],
            page: 1,
            total_page: 1
        },
        param: {
            page: 1
        },
        refresh: !1,
        loading: !0
    },
    onLoad: function(t) {
        console.log(t, "options");
        var e = t.currentTab, a = getApp().globalData, o = a.isIphoneX, r = a.noUserImg;
        this.setData({
            isIphoneX: o,
            noUserImg: r,
            currentIndex: e || 0,
            toShowWxPayStatus: !1
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
                    (e = a).setData({
                        refresh: !0,
                        "param.page": 1
                    }, function() {
                        wx.showNavigationBarLoading(), e.getList();
                    });

                  case 2:
                  case "end":
                    return t.stop();
                }
            }, t, a);
        }))();
    },
    onReachBottom: function() {
        var t = this.data, e = t.loading, a = t.dataList, o = a.page;
        o == a.total_page || e || (this.setData({
            "param.page": o + 1,
            loading: !0
        }), this.getList());
    },
    getList: function() {
        var v = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function t() {
            var e, a, o, r, n, i, s, u, d, l, c, f, _, g, h, x, p, m, y, S;
            return regeneratorRuntime.wrap(function(t) {
                for (;;) switch (t.prev = t.next) {
                  case 0:
                    return a = (e = v).data, o = a.refresh, r = a.param, n = a.dataList, i = a.currentIndex, 
                    s = a.tabList, r.type = i, t.next = 5, Promise.all([ _index.userModel.getShopCollNum(), _index.userModel.getShopColl(r) ]);

                  case 5:
                    for (y in u = t.sent, d = _slicedToArray(u, 2), l = d[0], c = d[1], _xx_util2.default.hideAll(), 
                    f = l.data, _ = f.going, g = f.suc, h = f.fail, s[0].dotNum = 0, s[1].dotNum = _, 
                    s[2].dotNum = g, s[3].dotNum = h, x = n, p = c, o || (p.data = [].concat(_toConsumableArray(x.data), _toConsumableArray(p.data))), 
                    p.page = 1, p.total_page = 1, m = p.data) {
                        for (S in m[y].order_info) m[y].user_id == m[y].order_info[S].user_id && (m[y].order_info_2 = m[y].order_info[S]);
                        m[y].collage_info.number_2 = parseInt((m[y].order_info_2.total_price - m[y].order_info_2.freight) / m[y].collage_info.price);
                    }
                    e.setData({
                        tabList: s,
                        dataList: p,
                        loading: !1,
                        refresh: !1
                    });

                  case 23:
                  case "end":
                    return t.stop();
                }
            }, t, v);
        }))();
    },
    getShopcancelorder: function(t, e) {
        var a = this;
        console.log(t, "order_id");
        var o = a.data.dataList.data;
        _index.userModel.getShopCancelOrder({
            id: t
        }).then(function(t) {
            0 == t.errno && (0 == a.data.currentIndex && _xx_util2.default.showSuccess("已取消订单"), 
            o.splice(e, 1), a.setData({
                "dataList.data": o
            }));
        });
    },
    getShopdelorder: function(t, e) {
        var a = this, o = a.data.dataList.data;
        _index.userModel.getShopDelOrder({
            id: t
        }).then(function(t) {
            0 == t.errno && (_xx_util2.default.showSuccess("已删除拼团"), o.splice(e, 1), a.setData({
                "dataList.data": o
            }));
        });
    },
    getRefund: function(t, e) {
        var a = this, o = a.data.dataList.data;
        _index.userModel.getShopRefund({
            order_id: t
        }).then(function(t) {
            0 == t.errno && (_xx_util2.default.showSuccess("已申请退款"), o[e].order_info_2.pay_status = 2, 
            a.setData({
                "dataList.data": o
            }));
        });
    },
    getWxPay: function(t, a) {
        var o = this;
        _xx_util2.default.showLoading();
        var r = o.data.dataList.data;
        _index.userModel.getWxPay({
            order_id: t
        }).then(function(t) {
            if (_xx_util2.default.hideAll(), console.log("getWxPay ==>", t), 0 == t.errno) {
                var e = t.data.collage_id;
                wx.requestPayment({
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
                                    _xx_util2.default.hideAll(), wx.navigateTo({
                                        url: "/longbing_card/users/pages/shop/releaseCollage/releaseCollage?id=" + r[a].collage_info.goods_id + "&status=toShare&to_uid=" + r[a].order_info.to_uid + "&collage_id=" + e
                                    }), o.setData({
                                        toWxPayStatus: 0,
                                        toShowWxPayStatus: !1
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
                                    o.setData({
                                        toWxPayStatus: 0,
                                        toShowWxPayStatus: !0
                                    }), _xx_util2.default.hideAll();
                                }, 1500);
                            }
                        });
                    },
                    complete: function(t) {
                        o.setData({
                            toShowWxPayStatus: !0
                        });
                    }
                });
            } else wx.showModal({
                title: "系统提示",
                content: t.data.message || "支付失败，请重试",
                showCancel: !1,
                success: function(t) {
                    t.confirm && o.setData({
                        toWxPayStatus: 0,
                        toShowWxPayStatus: !0
                    });
                }
            });
        });
    },
    toJump: function(t) {
        var e = this, a = _xx_util2.default.getData(t), o = a.status, r = a.index, n = e.data, i = n.toWxPayStatus, s = n.dataList.data;
        "toCancel" == o ? e.getShopcancelorder(s[r].order_info_2.id, r) : "toWxPay" == o ? 0 == i && e.setData({
            toWxPayStatus: 1
        }, function() {
            e.getWxPay(s[r].order_info_2.id, r);
        }) : "toRefund" == o ? e.getRefund(s[r].order_info_2.id, r) : "toDelete" == o && e.getShopdelorder(s[r].order_info_2.id, r);
    },
    toTabClick: function(t) {
        var e = _xx_util2.default.getData(t).index;
        this.setData({
            currentIndex: e,
            scrollNav: "scrollNav" + e
        }), this.onPullDownRefresh();
    }
});