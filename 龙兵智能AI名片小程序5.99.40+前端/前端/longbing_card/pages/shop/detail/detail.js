var _xx_util = require("../../../resource/js/xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util), _index = require("../../../resource/apis/index.js");

function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

function _asyncToGenerator(e) {
    return function() {
        var n = e.apply(this, arguments);
        return new Promise(function(i, d) {
            return function t(e, a) {
                try {
                    var o = n[e](a), r = o.value;
                } catch (e) {
                    return void d(e);
                }
                if (!o.done) return Promise.resolve(r).then(function(e) {
                    t("next", e);
                }, function(e) {
                    t("throw", e);
                });
                i(r);
            }("next");
        });
    };
}

var timer, app = getApp(), regeneratorRuntime = _xx_util2.default.regeneratorRuntime;

Page({
    data: {
        openType: "getUserInfo",
        swiperIndexCur: 1,
        swiperStatus: {
            indicatorDots: !1,
            autoplay: !0
        },
        isStaff: "",
        detailData: {},
        globalData: {},
        bgStatus: !1,
        chooseStatus: !1,
        chooseNumStatus: !1,
        addNumber: 1,
        addPrice: 0,
        countPrice: 0,
        rulesIndex: 0,
        checkSpeList: [],
        collageList: [],
        tmpTimes: [],
        refresh: !1
    },
    onLoad: function(y) {
        var k = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t, a, o, r, i, d, n, s, l, c, u, p, g, h, _, f, m, x, D, S, C, w, v, P, b, I, A;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    return console.log(y, "options"), t = k, _xx_util2.default.showLoading(), wx.showShareMenu({
                        withShareTicket: !0
                    }), a = y.scene ? _xx_util2.default.getSceneParam(decodeURIComponent(y.scene)) : y, 
                    o = a.id, r = a.to_uid, i = a.uid, d = a.from_id, n = a.fid, s = a.type, l = {
                        detailID: o,
                        to_uid: r || i,
                        from_id: d || n
                    }, c = getApp().globalData, u = c.to_uid, c.from_id, getApp().globalData.to_uid = r || i || u, 
                    t.setData({
                        paramData: l
                    }), e.next = 11, k.firstLoad(1);

                  case 11:
                    _xx_util2.default.hideAll(), p = getApp().globalData, g = p.auth, h = p.isIphoneX, 
                    p.hasClientPhone, f = p.productDefault, m = p.userDefault, x = p.logoImg, D = p.configInfo, 
                    S = p.price_switch, C = g.authStatus, w = g.authPhoneStatus, v = D.config.btn_talk, 
                    P = wx.getStorageSync("user"), b = P.phone, _ = !!b, I = _xx_util2.default.getTabTextInd(getApp().globalData.tabBar, "toShop")[0] || "商城", 
                    wx.setNavigationBarTitle({
                        title: I
                    }), A = wx.getStorageSync("userid"), t.setData({
                        price_switch: S,
                        authStatus: C,
                        authPhoneStatus: w,
                        isIphoneX: h,
                        hasClientPhone: _,
                        productDefault: f,
                        userDefault: m,
                        logoImg: x,
                        btn_talk: v,
                        copyright: D.config,
                        tmp_title: I,
                        curr_user_id: A
                    }), t.getAuthInfoSuc(), l.from_id && 2 == s && l.to_uid != A && 1044 == getApp().globalData.loginParam.scene && (timer = setInterval(function() {
                        getApp().globalData.encryptedData && t.toGetShareInfo();
                    }, 1e3));

                  case 23:
                  case "end":
                    return e.stop();
                }
            }, e, k);
        }))();
    },
    onHide: function() {
        clearInterval(timer);
    },
    onUnload: function() {
        clearInterval(timer);
    },
    onPullDownRefresh: function() {
        var o = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t, a;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    return t = o, wx.showNavigationBarLoading(), e.next = 4, o.firstLoad();

                  case 4:
                    a = getApp().globalData.price_switch, t.setData({
                        price_switch: a,
                        checkSpeList: [],
                        refresh: !0
                    }), t.getAuthInfoSuc();

                  case 7:
                  case "end":
                    return e.stop();
                }
            }, e, o);
        }))();
    },
    onShareAppMessage: function(e) {
        var t = this.data, a = t.curr_user_id, o = t.detailData, r = t.paramData, i = o.name, d = o.cover_true, n = r.detailID, s = r.to_uid;
        s != a && this.toForwardRecord();
        var l = "/longbing_card/pages/shop/detail/detail?to_uid=" + s + "&from_id=" + a + "&id=" + n + "&type=2";
        return console.log(l, "tmp_path"), {
            title: i,
            path: l,
            imageUrl: d
        };
    },
    firstLoad: function(R) {
        var F = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t, a, o, r, i, d, n, s, l, c, u, p, g, h, _, f, m, x, D, S, C, w, v, P, b, I, A, y, k, T, N, L, O, M;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    if ((t = F).data.refresh || _xx_util2.default.showLoading(), a = t.data.paramData, 
                    o = a.detailID, r = a.to_uid, i = wx.getStorageSync("userid"), d = void 0, 1 != R || r == i) {
                        e.next = 12;
                        break;
                    }
                    return e.next = 9, Promise.all([ getApp().getConfigInfo(!0), _index.userModel.getShopGoodsDetail({
                        goods_id: o,
                        to_uid: r
                    }), _index.userModel.getShopCollageList({
                        goods_id: o
                    }), _index.userModel.getCardShow({
                        to_uid: r
                    }), getApp().getCardAfter() ]);

                  case 9:
                    d = e.sent, e.next = 15;
                    break;

                  case 12:
                    return e.next = 14, Promise.all([ getApp().getConfigInfo(!0), _index.userModel.getShopGoodsDetail({
                        goods_id: o,
                        to_uid: r
                    }), _index.userModel.getShopCollageList({
                        goods_id: o
                    }), _index.userModel.getCardShow({
                        to_uid: r
                    }) ]);

                  case 14:
                    d = e.sent;

                  case 15:
                    if (_xx_util2.default.hideAll(), console.log(d), s = (n = d)[1], l = n[2], c = n[3], 
                    0 == s.errno) {
                        for (_ in console.log("getShopGoodsDetail"), u = s.data, p = u.content, _xx_util2.default.getHtml2WxmlVid(p), 
                        g = t.data.checkSpeList, h = [], u.spe_list) 1 < u.spe_list.length && "默认" == u.spe_list[_].title && 1 == u.spe_list[_].sec.length && "默认" == u.spe_list[_].sec[0].title && u.spe_list.splice(_, 1), 
                        g.push(0), 0 < u.spe_list.length && h.push(u.spe_list[_].sec[0].id);
                        if (0 < u.collage.length) {
                            for (f in u.collage) u.collage[f].shop_price = _xx_util2.default.getNormalPrice((u.collage[f].price / 1e4).toFixed(4)), 
                            u.collage[f].shop_spe_price = _xx_util2.default.getNormalPrice((u.collage[f].spe_price_price / 1e4).toFixed(4));
                            t.setData({
                                tmpShowCheckCollageID: u.collage[0].id,
                                tmpShowCheckNumber: u.collage[0].number
                            });
                        }
                        m = u.name, x = u.price, D = u.sale_count, S = u.cover_true, C = u.qr, w = u.unit, 
                        v = {
                            name: m,
                            price: x,
                            sale_count: D,
                            cover_true: S,
                            qr: C,
                            unit: w
                        }, u.shop_price = _xx_util2.default.getNormalPrice((x / 1e4).toFixed(4)), t.setData({
                            shareParamObj: v,
                            detailData: u,
                            addPrice: u.price,
                            shop_collageAddPrice: _xx_util2.default.getNormalPrice((u.price / 1e4).toFixed(2)),
                            checkSpeList: g,
                            checkIDs: h,
                            refresh: !1
                        }, function() {
                            t.getCurrentCheckIdAndPrice();
                        });
                    }
                    if (0 == l.errno) {
                        for (I in console.log("getShopCollageList"), P = l.data, b = t.data.tmpTimes, b = [], 
                        u = [], P) 0 < P[I].left_number && u.push(P[I]);
                        for (A in u) y = u[A].left_time, k = 0 < (k = parseInt(y / 24 / 60 / 60)) ? k + "天 " : "", 
                        b[A] = k + _xx_util2.default.formatTime(1e3 * y, "h小时m分钟"), 0 == y && (u.splice(A, 1), 
                        b.splice(A, 1)), t.setData({
                            tmpTimes: b
                        });
                        t.setData({
                            collageList: u
                        });
                    }
                    0 == c.errno && (console.log("getCardShow"), T = c.data, N = T.to_uid, T.from_id, 
                    L = T.info, O = L.avatar, M = L.job_name, getApp().globalData.to_uid = N, getApp().globalData.avatarUrl = O, 
                    getApp().globalData.job_name = M, t.setData({
                        cardIndexData: T
                    }));

                  case 21:
                  case "end":
                    return e.stop();
                }
            }, e, F);
        }))();
    },
    getShopAddTrolley: function(t) {
        var a = this, e = {
            goods_id: a.data.paramData.detailID,
            spe_price_id: a.data.spe_price_id,
            number: a.data.addNumber
        };
        _index.userModel.getShopAddTro(e).then(function(e) {
            _xx_util2.default.hideAll(), 0 == e.errno && (1 == t && wx.showModal({
                title: "",
                content: "已成功加入购物车，快去看看吧",
                cancelText: "继续选购",
                confirmText: "查看已选",
                success: function(e) {
                    e.confirm ? (a.toHideChoose(), wx.navigateTo({
                        url: "/longbing_card/users/pages/shop/car/carIndex/carIndex"
                    })) : e.cancel;
                }
            }), 2 == t && (a.setData({
                trolley_ids: e.data.id
            }), a.getToJumpUrl()));
        });
    },
    swiperChange: function(e) {
        var t = e.detail.current;
        this.setData({
            swiperIndexCur: 1 * t + 1
        });
    },
    toForwardRecord: function() {
        var e = {
            type: 2,
            to_uid: getApp().globalData.to_uid,
            target_id: this.data.paramData.detailID
        };
        _index.userModel.getForwardRecord(e).then(function(e) {
            _xx_util2.default.hideAll();
        });
    },
    toCopyRecord: function(e) {
        var t = {
            type: e,
            to_uid: getApp().globalData.to_uid
        };
        _index.userModel.getCopyRecord(t).then(function(e) {
            _xx_util2.default.hideAll();
        });
    },
    toGetShareInfo: function() {
        var s = this;
        wx.login({
            success: function(e) {
                var t = getApp().globalData, a = t.encryptedData, o = t.iv, r = e.code, i = s.data.paramData, d = i.to_uid, n = i.detailID;
                _index.userModel.getShareInfo({
                    encryptedData: a,
                    iv: o,
                    code: r,
                    to_uid: d,
                    target_id: n,
                    type: 3
                }).then(function(e) {
                    _xx_util2.default.hideAll(), 0 == e.errno && clearInterval(timer);
                });
            },
            fail: function(e) {}
        });
    },
    getPhoneNumber: function(e) {
        var t = e.detail, a = t.encryptedData, o = t.iv;
        a && o && this.setPhoneInfo(a, o), this.checktoConsult();
    },
    setPhoneInfo: function(e, t) {
        var a = this, o = getApp().globalData.to_uid;
        _index.baseModel.getPhone({
            encryptedData: e,
            iv: t,
            to_uid: o
        }).then(function(t) {
            _xx_util2.default.hideAll(), getApp().globalData.hasClientPhone = !0, getApp().globalData.auth.authPhoneStatus = !0, 
            a.setData({
                hasClientPhone: !0,
                authPhoneStatus: !0
            }, function() {
                if (t.data.phone) {
                    var e = wx.getStorageSync("user");
                    e.phone = t.data.phone, wx.setStorageSync("user", e);
                }
                a.getAuthInfoSuc();
            });
        });
    },
    getAuthInfoSuc: function(e) {
        console.log(e, "getAuthInfoSuc");
        var t = this.data.openType, a = this.data.paramData.to_uid, o = getApp().getCurUserInfo(a, t);
        this.setData(o);
    },
    checktoConsult: function() {
        var e = this.data.paramData, t = e.detailID, a = e.to_uid;
        if (0 == a) return console.log(a, "toConsult to_uid"), !1;
        if (a == wx.getStorageSync("userid")) wx.showModal({
            title: "",
            content: "不能和自己进行对话哦！",
            confirmText: "知道啦",
            showCancel: !1,
            success: function(e) {
                e.confirm;
            }
        }); else {
            var o = "/longbing_card/chat/userChat/userChat?chat_to_uid=" + a + "&goods_id=" + t;
            console.log(o, "toConsult"), wx.navigateTo({
                url: o
            });
        }
    },
    toShowChoose: function() {
        this.setData({
            bgStatus: !0,
            chooseNumStatus: !0
        });
    },
    toHideChoose: function() {
        this.setData({
            bgStatus: !1,
            chooseStatus: !1,
            chooseNumStatus: !1
        });
    },
    RemoveAddNum: function(e) {
        var t, a = this, o = e.currentTarget.dataset.status, r = a.data.addNumber, i = a.data.detailData.stock;
        if ("toCollagePay" == a.data.toOrderStatus && (t = a.data.tmpShowCheckNumber), "remove" == o) if ("toCollagePay" == a.data.toOrderStatus) {
            if (r < 1 * t + 1) return wx.showModal({
                title: "",
                content: "选择数量不能少于该拼团组合数量",
                confirmText: "知道啦",
                showCancel: !1,
                success: function(e) {
                    e.confirm;
                }
            }), !1;
            r < 1 * i + 1 && (r = 1 * r - 1);
        } else {
            if (1 == r) return wx.showModal({
                title: "",
                content: "不能再少了",
                confirmText: "知道啦",
                showCancel: !1,
                success: function(e) {
                    e.confirm;
                }
            }), !1;
            r < 1 * i + 1 && (r = 1 * r - 1);
        }
        if ("add" == o && 1 * i < (r = 1 * r + 1)) return wx.showModal({
            title: "",
            content: "库存不足，不能再添加了",
            confirmText: "知道啦",
            showCancel: !1,
            success: function(e) {
                e.confirm;
            }
        }), !1;
        a.setData({
            addNumber: r
        }), a.toCountAddPrice();
    },
    toCountAddPrice: function() {
        var e = this, t = e.data.addPrice;
        e.data.addNumber > parseInt(e.data.detailData.stock) && e.setData({
            addNumber: parseInt(e.data.detailData.stock)
        }), "toCollagePay" == e.data.toOrderStatus && (t = e.data.collageAddPrice), e.setData({
            countPrice: (1 * e.data.addNumber * (1 * t)).toFixed(2)
        });
    },
    getCurrentCheckIdAndPrice: function() {
        var e = this, t = e.data.checkIDs, a = "";
        for (var o in t) a += t[o] + "-";
        a = a.slice(0, -1);
        var r = e.data.checkSpeList, i = e.data.detailData.spe_list, d = "";
        if (0 < i.length) {
            for (var n in r) d += i[n].sec[r[n]].title + "-";
            d = d.slice(0, -1);
        }
        var s, l, c, u, p = e.data.detailData.spe_price;
        if ("toCollagePay" == e.data.toOrderStatus) {
            var g = e.data.detailData.collage, h = e.data.rulesIndex;
            u = 1, c = g[h].price, l = g[h].spe_price_stock, console.log(l, "stock *************"), 
            e.setData({
                collageAddPrice: c,
                shop_collageAddPrice: _xx_util2.default.getNormalPrice((c / 1e4).toFixed(4)),
                addNumber: e.data.tmpShowCheckNumber
            });
        } else {
            for (var _ in u = 0, p) a == p[_].spe_id_1 && (s = p[_].id, c = p[_].price, l = p[_].stock);
            e.setData({
                addPrice: c,
                shop_addPrice: _xx_util2.default.getNormalPrice((c / 1e4).toFixed(4))
            });
        }
        e.setData({
            tmpCheckIds: a,
            "detailData.stock": l,
            spe_price_id: s,
            tmpShowCheckID: u,
            spe_text: d
        }), e.toCountAddPrice();
    },
    getToJumpUrl: function() {
        var e = this, t = e.data.toOrderStatus, a = "toOrder", o = e.data.detailData, r = !1;
        1 == o.is_self && (r = !0);
        var i = {
            count_price: e.data.countPrice,
            tmp_trolley_ids: e.data.trolley_ids,
            tmp_is_self: r,
            dataList: [ {
                name: o.name,
                number: e.data.addNumber,
                goods_id: o.id,
                cover_true: o.cover_true,
                freight: o.freight,
                spe: e.data.spe_text,
                price2: e.data.addPrice,
                stock: o.stock,
                is_self: o.is_self
            } ]
        };
        "toCollagePay" == t && (a = "toCollage", i.dataList[0].collage_id = e.data.tmpShowCheckCollageID, 
        i.dataList[0].price2 = e.data.collageAddPrice), wx.setStorageSync("storageToOrder", i), 
        e.toHideChoose(), wx.navigateTo({
            url: "/longbing_card/users/pages/shop/car/toOrder/toOrder?status=" + a
        });
    },
    toJump: function(e) {
        var t = this, a = e.currentTarget.dataset.status, o = e.currentTarget.dataset.id, r = e.currentTarget.dataset.index, i = e.currentTarget.dataset.index1, d = e.currentTarget.dataset.paystatus;
        if ("toDetailJumpUrl" == a) _xx_util2.default.goUrl(e); else if ("toCopyright" == a || "moreCollage" == a || "toReleaseCollage" == a) {
            if ("moreCollage" == a) {
                var n = {
                    name: (_ = t.data.detailData).name,
                    unit: _.unit,
                    cover_true: _.cover_true,
                    collage_count: _.collage_count,
                    people: _.collage[t.data.rulesIndex].people,
                    number: _.collage[t.data.rulesIndex].number,
                    price: _.collage[t.data.rulesIndex].price,
                    oldPrice: _.price
                };
                wx.setStorageSync("moreCollageData", n);
            }
            _xx_util2.default.goUrl(e);
        } else if ("toConsult" == a) getApp().globalData.to_uid != wx.getStorageSync("userid") && t.toCopyRecord(8), 
        1 == t.data.hasClientPhone && t.checktoConsult(); else if ("toAddCar" == a || "toProductPay" == a || "toCollagePay" == a || "toOnlyPay" == a) t.setData({
            toOrderStatus: a
        }), t.toShowChoose(), t.getCurrentCheckIdAndPrice(); else if ("toPay" == a) {
            var s = t.data.toOrderStatus, l = "toOrder", c = t.data, u = c.addNumber, p = c.addPrice;
            if (u < 1) return wx.showModal({
                title: "",
                content: "请选择商品购买数量！",
                confirmText: "知道啦",
                showCancel: !1,
                success: function(e) {}
            }), !1;
            if (0 == p) return wx.showModal({
                title: "",
                content: "当前商品不支持购买！",
                confirmText: "知道啦",
                showCancel: !1,
                success: function(e) {}
            }), !1;
            if ("toAddCar" == s || "toAddCar" == d) t.getShopAddTrolley(1); else {
                s = t.data.toOrderStatus, l = "toOrder";
                var g = !1;
                1 == (_ = t.data.detailData).is_self && (g = !0);
                var h = {
                    count_price: t.data.countPrice,
                    tmp_trolley_ids: t.data.trolley_ids,
                    tmp_is_self: g,
                    dataList: [ {
                        name: _.name,
                        number: t.data.addNumber,
                        goods_id: _.id,
                        cover_true: _.cover_true,
                        freight: _.freight,
                        spe: t.data.spe_text,
                        price2: t.data.addPrice,
                        stock: _.stock,
                        is_self: _.is_self
                    } ]
                };
                "toProductPay" != s && "toOnlyPay" != d || (h.dataList[0].spe_price_id = t.data.spe_price_id), 
                "toCollagePay" == s && (l = "toCollage", h.dataList[0].collage_id = t.data.tmpShowCheckCollageID, 
                h.dataList[0].price2 = t.data.collageAddPrice), wx.setStorageSync("storageToOrder", h), 
                t.toHideChoose(), wx.navigateTo({
                    url: "/longbing_card/users/pages/shop/car/toOrder/toOrder?status=" + l
                });
            }
        } else if ("chooseCollage" == a) t.setData({
            bgStatus: !0,
            chooseStatus: !0
        }); else if ("setrules" == a) {
            var _, f = (_ = t.data.detailData.collage)[r].spe_id_1, m = f.split("-"), x = [];
            for (var D in m) x.push(m[D]);
            var S = t.data.detailData.spe_list, C = [];
            for (var w in S) for (var v in S[w].sec) x[w] == S[w].sec[v].id && C.push(v);
            t.setData({
                rulesIndex: r,
                toOrderStatus: "toCollagePay",
                tmpShowCheckID: 1,
                collageAddPrice: _[r].price,
                shop_collageAddPrice: _xx_util2.default.getNormalPrice((_[r].price / 1e4).toFixed(4)),
                "detailData.stock": _[r].spe_price_stock,
                addNumber: _[r].number,
                tmpShowCheckCollageID: _[r].id,
                tmpShowCheckNumber: _[r].number,
                checkIDs: x,
                checkSpeList: C,
                tmpCheckIds: f
            }), t.toCountAddPrice();
        } else if ("toCheckCur" == a) {
            S = t.data.checkSpeList;
            if (t.data.checkIDs[r] = o, S[r] = i, t.getCurrentCheckIdAndPrice(), t.setData({
                checkSpeList: S
            }), "toCollagePay" == t.data.toOrderStatus && (1 == t.data.tmpShowCheckID && t.setData({
                addNumber: t.data.tmpShowCheckNumber
            }), 0 == t.data.tmpShowCheckID)) return wx.showToast({
                icon: "none",
                title: "该组合没有参加拼团，请另选其他组合！",
                duration: 2e3
            }), !1;
        }
    },
    toSharePanel: function() {
        this.setData({
            sharePanel: !0
        });
    }
});