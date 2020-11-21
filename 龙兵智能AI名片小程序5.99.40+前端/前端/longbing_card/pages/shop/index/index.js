var _xx_util = require("../../../resource/js/xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util), _index = require("../../../resource/apis/index.js");

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
        var u = t.apply(this, arguments);
        return new Promise(function(o, i) {
            return function e(t, a) {
                try {
                    var r = u[t](a), n = r.value;
                } catch (t) {
                    return void i(t);
                }
                if (!r.done) return Promise.resolve(n).then(function(t) {
                    e("next", t);
                }, function(t) {
                    e("throw", t);
                });
                o(n);
            }("next");
        });
    };
}

var regeneratorRuntime = _xx_util2.default.regeneratorRuntime, voucher = require("../../../templates/voucher/voucher.js");

Page({
    data: {
        voucherStatus: {
            show: !1,
            status: "unreceive"
        },
        openType: "getUserInfo",
        swiperStatus: {
            indicatorDots: !1,
            autoplay: !0
        },
        swiperIndexCur: 0,
        activeIndex: 100000101,
        paramShop: {
            page: 1,
            type_id: 0
        },
        refreshShop: !1,
        loadingShop: !1,
        shop_all: {
            page: 1,
            total_page: "",
            list: []
        },
        categoryid: 0,
        scrollNav: "scrollNavAll"
    },
    onLoad: function(c) {
        var l = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function t() {
            var e, a, r, n, o, i, u, s;
            return regeneratorRuntime.wrap(function(t) {
                for (;;) switch (t.prev = t.next) {
                  case 0:
                    return e = l, wx.showShareMenu({
                        withShareTicket: !0
                    }), a = c.uid, r = c.fid, n = {
                        to_uid: a,
                        from_id: r
                    }, getApp().globalData.to_uid = a, o = getApp().globalData.isStaff, i = wx.getStorageSync("userid"), 
                    a != i && (o = !1), t.next = 10, _index.userModel.getCouponAll({
                        to_uid: a
                    });

                  case 10:
                    return u = t.sent, s = u.data, e.setData({
                        optionsParam: n,
                        isStaff: o,
                        coupon_all: s.list
                    }), t.next = 15, l.onPullDownRefresh();

                  case 15:
                    e.getAuthInfoSuc(), e.subscribe();

                  case 17:
                  case "end":
                    return t.stop();
                }
            }, t, l);
        }))();
    },
    subscribe: function() {
        var r = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function t() {
            var e, a;
            return regeneratorRuntime.wrap(function(t) {
                for (;;) switch (t.prev = t.next) {
                  case 0:
                    e = wx.getStorageSync("userid"), a = getApp().globalData.to_uid, getApp().websocket.sendMessage({
                        unread: !0,
                        user_id: e,
                        to_uid: a
                    }), getApp().websocket.subscribe("unread", r.getUserUnreadNum), getApp().websocket.subscribe("getMsg", r.getMsgUnreadNum);

                  case 5:
                  case "end":
                    return t.stop();
                }
            }, t, r);
        }))();
    },
    getUserUnreadNum: function(t) {
        var e = t.data, a = e.user_count, r = {
            user_count: a,
            staff_count: e.staff_count
        };
        getApp().getUnReadNum(r), this.toMsgAnimatoins(a);
    },
    getMsgUnreadNum: function(t) {
        var e = t.user_count, a = t.staff_count;
        if (t.data2.user_id == getApp().globalData.to_uid) {
            var r = {
                user_count: e,
                staff_count: a
            };
            getApp().getUnReadNum(r), this.toMsgAnimatoins(e);
        }
    },
    toMsgAnimatoins: function(t) {
        var e = this;
        e.setData({
            clientUnread: t
        }), t <= 0 || (e.setData({
            clientUnreadImg: !0
        }), setTimeout(function() {
            e.setData({
                clientUnreadImg: !1
            });
        }, 5e3));
    },
    onPageScroll: function(t) {
        this.setData({
            scrollTop: t.scrollTop
        });
    },
    onHide: function() {
        getApp().websocket.unSubscribe("unread"), getApp().websocket.unSubscribe("getMsg");
    },
    onUnload: function() {
        getApp().websocket.unSubscribe("unread"), getApp().websocket.unSubscribe("getMsg");
    },
    onShareAppMessage: function(t) {
        var e = this.data.optionsParam.to_uid, a = wx.getStorageSync("userid");
        return console.log("/longbing_card/pages/shop/index/index?uid=" + e + "&fid=" + a), 
        {
            title: "",
            path: "/longbing_card/pages/shop/index/index?uid=" + e + "&fid=" + a,
            imageUrl: ""
        };
    },
    onPullDownRefresh: function() {
        var v = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function t() {
            var e, a, r, n, o, i, u, s, c, l, p, d, g, h, f, _, x, m;
            return regeneratorRuntime.wrap(function(t) {
                for (;;) switch (t.prev = t.next) {
                  case 0:
                    return e = v, t.next = 3, getApp().getConfigInfo(!0);

                  case 3:
                    a = _xx_util2.default.getTabTextInd(getApp().globalData.tabBar, "toShop"), wx.setNavigationBarTitle({
                        title: a[0]
                    }), r = getApp().globalData, n = r.logoImg, o = r.userDefault, i = r.productDefault, 
                    u = r.configInfo, s = r.hasClientPhone, c = r.price_switch, l = r.auth, p = u.config, 
                    d = p.shop_version, g = p.shop_carousel_more, h = p.btn_consult, f = p.btn_talk, 
                    _ = l.authPhoneStatus, x = l.authStatus, m = e.data.categoryid, e.setData({
                        title_text: a,
                        nowPageIndex: a[1],
                        tabBar: getApp().globalData.tabBar,
                        shop_version: d,
                        shop_carousel_more: g,
                        logoImg: n,
                        productDefault: i,
                        hasClientPhone: s,
                        btn_consult: h,
                        btn_talk: f,
                        price_switch: c,
                        userDefault: o,
                        authPhoneStatus: _,
                        authStatus: x,
                        copyright: u.config,
                        refreshShop: !0,
                        "paramShop.page": 1,
                        "paramShop.type_id": m
                    }, function() {
                        wx.showNavigationBarLoading(), e.getShopTypes(), 0 < 1 * m && e.getShopList(), _xx_util2.default.hideAll();
                    });

                  case 10:
                  case "end":
                    return t.stop();
                }
            }, t, v);
        }))();
    },
    onReachBottom: function() {
        var t = this.data.loadingShop, e = this.data.shop_all, a = e.page, r = e.total_page;
        if (r <= a) return !1;
        a == r || t || (this.setData({
            "paramShop.page": parseInt(a) + 1,
            refreshShop: !1,
            loadingShop: !0
        }), this.getShopList());
    },
    getAuthInfoSuc: function(t) {
        console.log(t, "getAuthInfoSuc");
        var e = this.data.openType, a = this.data.optionsParam.to_uid, r = getApp().getCurUserInfo(a, e);
        this.setData(r);
    },
    getShopTypes: function() {
        var h = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function t() {
            var e, a, r, n, o, i, u, s, c, l, p, d, g;
            return regeneratorRuntime.wrap(function(t) {
                for (;;) switch (t.prev = t.next) {
                  case 0:
                    return a = (e = h).data, r = a.refreshShop, n = a.categoryid, r || _xx_util2.default.showLoading(), 
                    o = e.data.optionsParam.to_uid, t.next = 6, _index.userModel.getShopTypes({
                        to_uid: o
                    });

                  case 6:
                    for (g in i = t.sent, _xx_util2.default.hideAll(), u = i.data, s = u.carousel, c = u.shop_all, 
                    l = u.shop_type, p = u.shop_company, d = c.list) d[g].shop_price = _xx_util2.default.getNormalPrice((d[g].price / 1e4).toFixed(4));
                    0 == n && e.setData({
                        shop_all: c
                    }), e.setData({
                        carousel: s,
                        shop_type: l,
                        shop_company: p,
                        showTabBar: !0
                    });

                  case 13:
                  case "end":
                    return t.stop();
                }
            }, t, h);
        }))();
    },
    getShopList: function() {
        var p = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function t() {
            var e, a, r, n, o, i, u, s, c, l;
            return regeneratorRuntime.wrap(function(t) {
                for (;;) switch (t.prev = t.next) {
                  case 0:
                    return a = (e = p).data, r = a.refreshShop, n = a.paramShop, o = a.shop_all, n.to_uid = e.data.optionsParam.to_uid, 
                    r || _xx_util2.default.showLoading(), t.next = 6, _index.userModel.getShopList(n);

                  case 6:
                    for (l in i = t.sent, _xx_util2.default.hideAll(), u = o, s = i.data, r || (s.list = [].concat(_toConsumableArray(u.list), _toConsumableArray(s.list))), 
                    c = s.list) c[l].shop_price = _xx_util2.default.getNormalPrice((c[l].price / 1e4).toFixed(4));
                    s.page = 1 * s.page, e.setData({
                        shop_all: s,
                        loadingShop: !1,
                        refreshShop: !1,
                        showTabBar: !0
                    });

                  case 15:
                  case "end":
                    return t.stop();
                }
            }, t, p);
        }))();
    },
    swiperChange: function(t) {
        var e = t.detail.current;
        this.setData({
            swiperIndexCur: e
        });
    },
    toJump: function(t) {
        var e = _xx_util2.default.getData(t), a = e.categoryid, r = e.index, n = e.status;
        if ("toTabClickMore" == n || "toTabClick" == n) {
            var o = r, i = a;
            "toTabClickMore" == n && (o = "100000101", i = "All"), this.setData({
                activeIndex: o,
                categoryid: a,
                scrollNav: "scrollNav" + i,
                "paramShop.list": [],
                "paramShop.page": 1,
                "paramShop.type_id": a,
                refreshShop: !0
            }), this.getShopList();
        }
        if ("toShopDetail" == n) {
            var u = this.data.shop_all.list, s = getApp().globalData.to_uid, c = wx.getStorageSync("userid");
            wx.navigateTo({
                url: "/longbing_card/pages/shop/detail/detail?id=" + u[r].id + "&to_uid=" + s + "&from_id=" + c
            });
        }
    },
    tabJump: function(t) {
        var e = t.detail, a = e.url, r = e.method, n = e.type, o = e.curr, i = e.index, u = e.text, s = e.formId;
        _index.baseModel.getFormId({
            formId: s
        });
        var c = this.data.optionsParam.to_uid, l = wx.getStorageSync("userid");
        if (a && (0 == a.indexOf("wx") || -1 < a.indexOf("http") || (a = a + "?uid=" + c + "&fid=" + l)), 
        !a) {
            var p = this.data.tabBar.list;
            p[i].pagePath2 ? (a = p[i].pagePath2 + "?uid=" + c + "&fid=" + l, wx[r]({
                url: a,
                fail: function(t) {
                    a = "/longbing_card/pages/index/index?currentTabBar=" + o + "&to_uid=" + c + "&from_id=" + l, 
                    console.log(t, a);
                }
            })) : a = "/longbing_card/pages/index/index?currentTabBar=" + o + "&to_uid=" + c + "&from_id=" + l;
        }
        t.currentTarget.dataset = {
            url: a,
            method: r,
            type: n,
            curr: o,
            index: i,
            text: u,
            formId: s
        }, _xx_util2.default.goUrl(t);
    },
    toConsult: function() {
        var r = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function t() {
            var e, a;
            return regeneratorRuntime.wrap(function(t) {
                for (;;) switch (t.prev = t.next) {
                  case 0:
                    e = getApp().globalData.to_uid, a = "/longbing_card/chat/userChat/userChat?chat_to_uid=" + e, 
                    console.log(a, "toConsult"), wx.navigateTo({
                        url: a
                    });

                  case 4:
                  case "end":
                    return t.stop();
                }
            }, t, r);
        }))();
    },
    toUseCoupon: function(l) {
        var p = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function t() {
            var e, a, r, n, o, i, u, s, c;
            return regeneratorRuntime.wrap(function(t) {
                for (;;) switch (t.prev = t.next) {
                  case 0:
                    return e = p, console.log(l, "***********e"), a = _xx_util2.default.getData(l), 
                    r = a.index, n = e.data.coupon_all[r], o = n.record_id, t.next = 7, _index.userModel.getCouponQr({
                        record_id: o
                    });

                  case 7:
                    if (i = t.sent, u = i.errno, s = i.data, _xx_util2.default.hideAll(), 0 == u) {
                        t.next = 13;
                        break;
                    }
                    return t.abrupt("return");

                  case 13:
                    c = s.path, e.setData({
                        tmp_qr: c,
                        currentVoucher: n,
                        "voucherStatus.show": !0,
                        "voucherStatus.status": "unreceive"
                    });

                  case 15:
                  case "end":
                    return t.stop();
                }
            }, t, p);
        }))();
    },
    toCloseVoucher: function() {
        voucher.toCloseVoucher(this);
    },
    toGetCoupon: function(r) {
        var n = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function t() {
            var e, a;
            return regeneratorRuntime.wrap(function(t) {
                for (;;) switch (t.prev = t.next) {
                  case 0:
                    e = _xx_util2.default.getData(r), a = e.index, n.getCoupon(a);

                  case 2:
                  case "end":
                    return t.stop();
                }
            }, t, n);
        }))();
    },
    getCoupon: function(u) {
        var s = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function t() {
            var e, a, r, n, o, i;
            return regeneratorRuntime.wrap(function(t) {
                for (;;) switch (t.prev = t.next) {
                  case 0:
                    return a = (e = s).data.optionsParam.to_uid, r = e.data.coupon_all, n = r[u].id, 
                    _xx_util2.default.showLoading(), t.next = 7, _index.userModel.getCoupon({
                        to_uid: a,
                        coupon_id: n
                    });

                  case 7:
                    if (o = t.sent, i = o.errno, _xx_util2.default.hideAll(), 0 == i) {
                        t.next = 12;
                        break;
                    }
                    return t.abrupt("return");

                  case 12:
                    r[u].record_status = 1, e.setData({
                        coupon_all: r
                    });

                  case 14:
                  case "end":
                    return t.stop();
                }
            }, t, s);
        }))();
    },
    toSetInd: function(t) {
        var e = _xx_util2.default.getData(t).index;
        this.setData({
            coup_index: e
        });
    },
    getCouponPhone: function(i) {
        var u = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function t() {
            var e, a, r, n, o;
            return regeneratorRuntime.wrap(function(t) {
                for (;;) switch (t.prev = t.next) {
                  case 0:
                    if (e = u, a = i.detail, r = a.encryptedData, n = a.iv, o = e.data.coup_index, !r || !n) {
                        t.next = 8;
                        break;
                    }
                    return t.next = 6, Promise.all([ e.setPhoneInfo(r, n), e.getCoupon(o) ]);

                  case 6:
                    t.next = 8;
                    break;

                  case 8:
                  case "end":
                    return t.stop();
                }
            }, t, u);
        }))();
    },
    getPhoneNumber: function(t) {
        var e = t.detail, a = e.encryptedData, r = e.iv;
        a && r && this.setPhoneInfo(a, r), this.toConsult();
    },
    setPhoneInfo: function(t, e) {
        var a = this, r = getApp().globalData.to_uid;
        _index.baseModel.getPhone({
            encryptedData: t,
            iv: e,
            to_uid: r
        }).then(function(e) {
            _xx_util2.default.hideAll(), getApp().globalData.hasClientPhone = !0, getApp().globalData.auth.authPhoneStatus = !0, 
            a.setData({
                hasClientPhone: !0,
                authPhoneStatus: !0
            }, function() {
                if (e.data.phone) {
                    var t = wx.getStorageSync("user");
                    t.phone = e.data.phone, wx.setStorageSync("user", t);
                }
                a.getAuthInfoSuc();
            });
        });
    },
    goUrl: function(t) {
        var e = _xx_util2.default.getData(t), a = e.status, r = e.index;
        if ("toNav" == a) {
            var n = this.data.shop_type[r];
            wx.setStorageSync("navTypes", n);
        }
        _xx_util2.default.goUrl(t);
    }
});