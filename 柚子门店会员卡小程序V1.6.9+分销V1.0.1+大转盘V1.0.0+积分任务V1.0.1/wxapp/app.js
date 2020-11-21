var _slicedToArray = function(t, e) {
    if (Array.isArray(t)) return t;
    if (Symbol.iterator in Object(t)) return function(t, e) {
        var o = [], n = !0, a = !1, s = void 0;
        try {
            for (var i, r = t[Symbol.iterator](); !(n = (i = r.next()).done) && (o.push(i.value), 
            !e || o.length !== e); n = !0) ;
        } catch (t) {
            a = !0, s = t;
        } finally {
            try {
                !n && r.return && r.return();
            } finally {
                if (a) throw s;
            }
        }
        return o;
    }(t, e);
    throw new TypeError("Invalid attempt to destructure non-iterable instance");
};

App({
    onLaunch: function() {},
    onShow: function() {
        var e = this;
        wx.getSystemInfo({
            success: function(t) {
                -1 != t.model.search("iPhone X") && (e.globalData.isIpx = !0);
            }
        });
    },
    globalData: {
        userInfo: {},
        store_info: null,
        Plugin_scoretask: "yzhyk_sun_plugin_scoretask",
        Plugin_eatvisit: "yzhyk_sun_plugin_eatvisit",
        Plugin_distribution: "yzhyk_sun_plugin_distribution",
        Plugin_yzhyk: "yzhyk_sun",
        tabBar: {
            color: "#9E9E9E",
            selectedColor: "#f00",
            backgroundColor: "#fff",
            borderStyle: "#ccc",
            list: [ {
                pagePath: "/yzhyk_sun/pages/index/index",
                text: "到店",
                iconPath: "/style/images/shop.png",
                selectedIconPath: "/style/images/shopSele.png",
                selectedColor: "#ff640f",
                active: !0
            }, {
                pagePath: "/yzhyk_sun/pages/goods/goods",
                text: "商品",
                iconPath: "/style/images/goods.png",
                selectedIconPath: "/style/images/goodsSele.png",
                selectedColor: "#ff640f",
                active: !1
            }, {
                pagePath: "/yzhyk_sun/pages/carts/carts",
                text: "购物车",
                iconPath: "/style/images/cart.png",
                selectedIconPath: "/style/images/cartsSele.png",
                selectedColor: "#ff640f",
                active: !1
            }, {
                pagePath: "/yzhyk_sun/pages/user/user",
                text: "会员中心",
                iconPath: "/style/images/user.png",
                selectedIconPath: "/style/images/userSele.png",
                selectedColor: "#ff640f",
                active: !1
            } ],
            position: "bottom"
        },
        showAd: !0,
        isIpx: !1
    },
    editTabBar: function() {
        var r = this;
        r.get_setting().then(function(t) {
            console.log(0x27797f26d671c8), console.log(t);
            var e = getCurrentPages(), a = e[e.length - 1], s = a.__route__;
            0 != s.indexOf("/") && (s = "/" + s);
            var i = r.globalData.tabBar;
            r.get_imgroot().then(function(n) {
                t.app_tbcolor && (i.backgroundColor = t.app_tbcolor), t.app_tfcolor && (i.color = t.app_tfcolor), 
                t.app_tsfcolor && (i.selectedColor = t.app_tsfcolor), console.log(i), r.get_tabs().then(function(o) {
                    console.log(2222222222222222e4), console.log(o), console.log(r.globalData.tabs), 
                    wx.removeStorageSync("tanBar"), 0 < o.length && (console.log(444444444), i.list = [], 
                    r.setFx().then(function(t) {
                        for (var e in console.log(5555555555), console.log(t), o) 0 != o[e].page.indexOf("/") && (o[e].page = t), 
                        i.list.push({
                            pagePath: o[e].page,
                            text: o[e].name,
                            iconPath: n + o[e].pic,
                            selectedIconPath: n + o[e].pic_s,
                            selectedColor: "#ff640f",
                            active: !1,
                            title: o[e].title,
                            id: o[e].id
                        });
                        return i;
                    }).then(function(t) {
                        console.log(t), console.log(333333333333333);
                        for (var e = 0; e < t.list.length; e++) t.list[e].active = !1, t.list[e].selectedColor = t.selectedColor, 
                        t.list[e].pagePath == s && (t.list[e].active = !0, t.list[e].title && wx.setNavigationBarTitle({
                            title: t.list[e].title
                        }));
                        t.isIpx = r.globalData.isIpx, wx.setStorageSync("tabBar", t), a.setData({
                            tabBar: t
                        });
                    }));
                });
            });
        });
    },
    pageInit: function() {
        this.get_setting().then(function(t) {
            if (t.app_bcolor) {
                var e = {};
                e.frontColor = "0" == t.app_fcolor || null == t.app_fcolor ? "#ffffff" : "#000000", 
                e.backgroundColor = t.app_bcolor, wx.setNavigationBarColor(e);
            }
        });
    },
    siteInfo: require("siteinfo.js"),
    util: require("common/util.js"),
    func: require("func.js"),
    zhy: require("common/zhy.js"),
    md5: require("we7/js/md5.js"),
    api: require("common/api.js"),
    distribution: require("/zhy/distribution/distribution.js"),
    promise_list: {},
    get_promise: function(t) {
        var e = 1 < arguments.length && void 0 !== arguments[1] && arguments[1], o = this, n = o.md5(t);
        if (!e && o.promise_list[n]) return o.promise_list[n];
        var a = new Promise(t);
        return o.promise_list[n] = a.then(function(t) {
            return delete o.promise_list[n], Promise.resolve(t);
        }).catch(function(t) {
            return delete o.promise_list[n], Promise.reject(t);
        }), o.promise_list[n];
    },
    offline_cart_add: function(t) {
        try {
            var e = t.id, o = this.offline_cart_get();
            return o.goodses[e] ? o.goodses[e].num++ : (t.num = 1, o.goodses[e] = t), o.goodses[e].num > o.goodses[e].limit && wx.showToast({
                title: "商品限购 " + o.goodses[e].limit + " 件",
                icon: "none",
                duration: 2e3
            }), o.num = parseFloat(o.num) + 1, o.amount = parseFloat(o.amount) + parseFloat(t.price), 
            o.amount = o.amount.toFixed(2), this.offline_cart_set(o), o;
        } catch (t) {
            wx.showToast({
                title: "添加商品失败",
                icon: "none",
                duration: 2e3
            });
        }
    },
    offline_cart_reduce: function(t) {
        var e = t, o = this.offline_cart_get();
        return o.goodses[e] && (o.goodses[e].num -= 1), o.num -= 1, o.amount -= o.goodses[e].price, 
        o.amount = o.amount.toFixed(2), 0 == o.goodses[e].num && delete o.goodses[e], this.offline_cart_set(o), 
        o;
    },
    offline_cart_delete: function(t) {
        var e = t, o = this.offline_cart_get();
        if (o.goodses[e]) {
            var n = o.goodses[e];
            delete o.goodses[e], o.num -= n.num, o.amount -= n.num * n.price, o.amount = o.amount.toFixed(2);
        }
        return this.offline_cart_set(o), o;
    },
    offline_cart_get: function() {
        return this.zhy.storage.get("offline_cart" + this.globalData.store_info.id) || {
            goodses: {},
            num: 0,
            amount: 0
        };
    },
    offline_cart_set: function(t) {
        this.zhy.storage.set("offline_cart" + this.globalData.store_info.id, t, 14400);
    },
    offline_cart_clear: function() {
        var t = {
            goodses: {},
            num: 0,
            amount: 0
        };
        return this.offline_cart_set(t), t;
    },
    cart_add: function(t) {
        try {
            var e = t.id, o = this.cart_get();
            return o.goodses[e] ? o.goodses[e].num++ : (t.num = 1, o.goodses[e] = t), o.goodses[e].num > o.goodses[e].limit && wx.showToast({
                title: "商品限购 " + o.goodses[e].limit + " 件",
                icon: "none",
                duration: 2e3
            }), o.num = parseFloat(o.num) + 1, o.amount = parseFloat(o.amount) + parseFloat(t.price), 
            o.amount = o.amount.toFixed(2), this.cart_set(o), o;
        } catch (t) {
            wx.showToast({
                title: "添加商品失败",
                icon: "none",
                duration: 2e3
            });
        }
    },
    cart_reduce: function(t) {
        var e = t, o = this.cart_get();
        return o.goodses[e] && (o.goodses[e].num -= 1), o.num -= 1, o.amount -= o.goodses[e].price, 
        o.amount = o.amount.toFixed(2), 0 == o.goodses[e].num && delete o.goodses[e], this.cart_set(o), 
        o;
    },
    cart_delete: function(t) {
        var e = t, o = this.cart_get();
        if (o.goodses[e]) {
            var n = o.goodses[e];
            delete o.goodses[e], o.num -= n.num, o.amount -= n.num * n.price, o.amount = o.amount.toFixed(2);
        }
        return this.cart_set(o), o;
    },
    cart_get: function() {
        return this.zhy.storage.get("cart" + this.globalData.store_info.id) || {
            goodses: {},
            num: 0,
            amount: 0
        };
    },
    cart_set: function(t) {
        this.zhy.storage.set("cart" + this.globalData.store_info.id, t);
    },
    cart_clear: function() {
        var t = {
            goodses: {},
            num: 0,
            amount: 0
        };
        return this.cart_set(t), t;
    },
    group_cart_add: function(t) {
        try {
            var e = t.id, o = this.group_cart_get();
            return o.goodses[e] ? o.goodses[e].num++ : (t.num = 1, o.goodses[e] = t), o.goodses[e].num > o.goodses[e].limit && wx.showToast({
                title: "商品限购 " + o.goodses[e].limit + " 件",
                icon: "none",
                duration: 2e3
            }), o.num = parseFloat(o.num) + 1, o.amount = parseFloat(o.amount) + parseFloat(t.price), 
            o.amount = o.amount.toFixed(2), this.group_cart_set(o), o;
        } catch (t) {
            console.log(t), wx.showToast({
                title: "添加商品失败",
                icon: "none",
                duration: 2e3
            });
        }
    },
    group_cart_reduce: function(t) {
        var e = t, o = this.group_cart_get();
        return o.goodses[e] && (o.goodses[e].num -= 1), o.num -= 1, o.amount -= o.goodses[e].price, 
        o.amount = o.amount.toFixed(2), 0 == o.goodses[e].num && delete o.goodses[e], this.group_cart_set(o), 
        o;
    },
    group_cart_delete: function(t) {
        var e = t, o = this.group_cart_get();
        if (o.goodses[e]) {
            var n = o.goodses[e];
            delete o.goodses[e], o.num -= n.num, o.amount -= n.num * n.price, o.amount = o.amount.toFixed(2);
        }
        return this.group_cart_set(o), o;
    },
    group_cart_get: function() {
        return this.zhy.storage.get("group_cart") || {
            goodses: {},
            num: 0,
            amount: 0
        };
    },
    group_cart_set: function(t) {
        this.zhy.storage.set("group_cart", t);
    },
    group_cart_clear: function() {
        var t = {
            goodses: {},
            num: 0,
            amount: 0
        };
        return this.group_cart_set(t), t;
    },
    get_store_info: function() {
        var n = !(0 < arguments.length && void 0 !== arguments[0]) || arguments[0], a = this;
        return a.get_promise(function(o, t) {
            var e = a.globalData.store_info;
            e && n ? o(e) : a.get_wxuser_location().then(function(t) {
                console.log(t), 1 == t ? o(t) : a.util.request({
                    url: "entry/wxapp/GetNearestStore",
                    data: {
                        latitude: t.latitude,
                        longitude: t.longitude
                    },
                    success: function(t) {
                        console.log(t.data);
                        var e = t.data;
                        a.globalData.store_info = e, o(e);
                    }
                });
            });
        });
    },
    set_store_info: function(t) {
        this.globalData.store_info = t, this.get_user_coupons(!1), this.get_coupons(!1);
    },
    get_wxuser_location: function() {
        var n = this;
        return new Promise(function(e, t) {
            var o = n.globalData.wxuser_location;
            o ? e(o) : wx.getSetting({
                success: function(t) {
                    t.authSetting["scope.userLocation"] ? (console.log(1), wx.getLocation({
                        success: function(t) {
                            n.globalData.wxuser_location = t, e(t);
                        }
                    })) : (console.log(2), wx.authorize({
                        scope: "scope.userLocation",
                        success: function(t) {
                            console.log(3), wx.getLocation({
                                success: function(t) {
                                    n.globalData.wxuser_location = t, e(t);
                                }
                            });
                        },
                        fail: function(t) {
                            console.log(4), e(1);
                        }
                    }));
                }
            });
        });
    },
    get_wxuser_info: function() {
        var n = this;
        return new Promise(function(e, t) {
            var o = n.globalData.wxuser_info;
            o ? e(o) : wx.getSetting({
                success: function(t) {
                    t.authSetting["scope.userInfo"] ? wx.getUserInfo({
                        success: function(t) {
                            n.globalData.wxuser_info = t.userInfo, e(t.userInfo);
                        }
                    }) : wx.authorize({
                        scope: "scope.userInfo",
                        success: function(t) {
                            wx.getUserInfo({
                                success: function(t) {
                                    n.globalData.wxuser_info = t.userInfo, e(t.userInfo);
                                }
                            });
                        }
                    });
                }
            });
        });
    },
    get_openid: function() {
        var n = !(0 < arguments.length && void 0 !== arguments[0]) || arguments[0], a = this;
        return new Promise(function(o, t) {
            var e = a.globalData.openid;
            e && n ? o(e) : wx.login({
                success: function(t) {
                    var e = t.code;
                    a.util.request({
                        url: "entry/wxapp/openid",
                        fromcache: n,
                        data: {
                            code: e,
                            m: "yzhyk_sun"
                        },
                        success: function(t) {
                            console.log(t), a.globalData.openid = t.data.openid, a.globalData.key = t.data.session_key, 
                            o(t.data.openid);
                        }
                    });
                }
            });
        });
    },
    get_key: function() {
        var n = !(0 < arguments.length && void 0 !== arguments[0]) || arguments[0], a = this;
        return new Promise(function(e, t) {
            var o = a.globalData.key;
            o && n ? e(o) : a.get_openid(n).then(function(t) {
                e(a.globalData.key);
            });
        });
    },
    get_user_info: function() {
        !(0 < arguments.length && void 0 !== arguments[0]) || arguments[0];
        var o = this;
        return o.get_promise(function(e, t) {
            o.get_openid().then(function(t) {
                o.util.request({
                    url: "entry/wxapp/Login",
                    data: {
                        openid: t,
                        m: "yzhyk_sun"
                    },
                    success: function(t) {
                        console.log(t), wx.setStorageSync("users", t.data), o.globalData.user_info = t.data, 
                        o.globalData.uniacid = t.data.uniacid, e(t.data);
                    }
                });
            });
        });
    },
    get_setting: function() {
        var n = !(0 < arguments.length && void 0 !== arguments[0]) || arguments[0], a = this;
        return a.get_promise(function(e, t) {
            var o = a.globalData.setting;
            console.log(o), o && n ? e(o) : a.util.request({
                url: "entry/wxapp/GetPlatformInfo",
                data: {
                    m: "yzhyk_sun"
                },
                success: function(t) {
                    console.log(t), a.globalData.setting = t.data, e(t.data);
                }
            });
        });
    },
    get_card_info: function() {
        !(0 < arguments.length && void 0 !== arguments[0]) || arguments[0];
        var o = this;
        return new Promise(function(e, t) {
            o.get_user_info().then(function(t) {
                o.util.request({
                    url: "entry/wxapp/GetCardLevel",
                    data: {
                        level_id: t.level_id
                    },
                    success: function(t) {
                        e(t.data);
                    }
                });
            });
        });
    },
    get_card_price: function() {
        !(0 < arguments.length && void 0 !== arguments[0]) || arguments[0];
        var o = this;
        return new Promise(function(e, t) {
            o.get_user_info().then(function(t) {
                o.util.request({
                    url: "entry/wxapp/GetCardPrice",
                    data: {
                        level_id: t.level_id
                    },
                    success: function(t) {
                        e(t.data);
                    }
                });
            });
        });
    },
    get_admin_store_info: function() {
        var n = !(0 < arguments.length && void 0 !== arguments[0]) || arguments[0], a = this;
        return new Promise(function(e, t) {
            var o = a.globalData.admin_store;
            o && n ? e(o) : a.get_admin_stores(n).then(function(t) {
                e(t[0]), a.globalData.admin_store = t[0];
            });
        });
    },
    get_admin_stores: function() {
        var n = !(0 < arguments.length && void 0 !== arguments[0]) || arguments[0], a = this;
        return new Promise(function(e, t) {
            var o = a.globalData.admin_stores;
            o && n ? e(o) : a.get_user_info().then(function(t) {
                a.util.request({
                    url: "entry/wxapp/GetAdminStores",
                    data: {
                        user_id: t.id
                    },
                    success: function(t) {
                        a.globalData.admin_stores = t.data, e(t.data);
                    }
                });
            });
        });
    },
    getFormid: function(e) {
        var o = this;
        "the formId is a mock one" != e && o.get_user_info().then(function(t) {
            o.util.request({
                url: "entry/wxapp/AddFormID",
                fromcache: !1,
                data: {
                    user_id: t.id,
                    form_id: e
                },
                success: function(t) {
                    console.log("成功");
                }
            });
        });
    },
    get_imgroot: function() {
        var n = !(0 < arguments.length && void 0 !== arguments[0]) || arguments[0], a = this;
        return a.get_promise(function(e, t) {
            var o = a.globalData.imgroot;
            o && n ? e(o) : a.util.request({
                url: "entry/wxapp/GetImgRoot",
                fromcache: n,
                cachetime: 259200,
                success: function(t) {
                    a.globalData.imgroot = t.data, e(t.data);
                }
            });
        });
    },
    get_tabs: function() {
        var n = !(0 < arguments.length && void 0 !== arguments[0]) || arguments[0], a = this;
        return new Promise(function(e, t) {
            var o = a.globalData.tabs;
            o && n ? (console.log(999999999999999), e(o)) : (console.log(888888888888888), a.util.request({
                url: "entry/wxapp/GetTabs",
                success: function(t) {
                    a.globalData.tabs = t.data, e(t.data);
                }
            }));
        });
    },
    get_user_coupons: function() {
        !(0 < arguments.length && void 0 !== arguments[0]) || arguments[0];
        var n = this;
        return new Promise(function(o, t) {
            n.get_user_info().then(function(e) {
                n.get_store_info().then(function(t) {
                    n.util.request({
                        url: "entry/wxapp/GetUserCoupons",
                        data: {
                            user_id: e.id,
                            store_id: t.id
                        },
                        success: function(t) {
                            o(t.data);
                        }
                    });
                });
            });
        });
    },
    get_coupons: function() {
        !(0 < arguments.length && void 0 !== arguments[0]) || arguments[0];
        var n = this;
        return new Promise(function(o, t) {
            n.get_user_info().then(function(e) {
                n.get_store_info().then(function(t) {
                    n.util.request({
                        url: "entry/wxapp/GetCoupons",
                        data: {
                            user_id: e.id,
                            store_id: t.id
                        },
                        success: function(t) {
                            o(t.data);
                        }
                    });
                });
            });
        });
    },
    check_balance: function() {
        var o = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : 0, n = this;
        return new Promise(function(e, t) {
            n.get_user_info().then(function(t) {
                n.util.request({
                    url: "entry/wxapp/CheckBalance",
                    fromcache: !1,
                    data: {
                        user_id: t.id,
                        pay_amount: o
                    },
                    success: function(t) {
                        console.log(t), 0 == t.data.code ? e(1) : (wx.showModal({
                            title: "提示",
                            content: t.data.msg,
                            showCancel: !1
                        }), e(0));
                    }
                });
            });
        });
    },
    wx_pay: function() {
        var o = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : 0, n = this;
        return new Promise(function(e, t) {
            n.get_openid().then(function(t) {
                n.util.request({
                    url: "entry/wxapp/Orderarr",
                    fromcache: !1,
                    data: {
                        openid: t,
                        price: o
                    },
                    success: function(t) {
                        wx.requestPayment({
                            timeStamp: t.data.timeStamp,
                            nonceStr: t.data.nonceStr,
                            package: t.data.package,
                            signType: t.data.signType,
                            paySign: t.data.paySign,
                            success: function(t) {
                                e(1);
                            },
                            fail: function(t) {
                                wx.showModal({
                                    title: "提示",
                                    content: "支付失败，请重新发起支付",
                                    showCancel: !1
                                }), e(0);
                            }
                        });
                    }
                });
            });
        });
    },
    pay: function() {
        var o = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : 0, n = arguments[1], a = this;
        return new Promise(function(e, t) {
            "微信" == n ? a.wx_pay(o).then(function(t) {
                console.log(t), e(t);
            }) : a.check_balance(o).then(function(t) {
                e(t);
            });
        });
    },
    wx_requestPayment: function(t) {
        return new Promise(function(e, o) {
            wx.requestPayment({
                timeStamp: t.timeStamp,
                nonceStr: t.nonceStr,
                package: t.package,
                signType: t.signType,
                paySign: t.paySign,
                success: function(t) {
                    console.log(t), e(t);
                },
                fail: function(t) {
                    wx.showModal({
                        title: "提示",
                        content: "支付失败，请重新发起支付",
                        showCancel: !1
                    }), o(t);
                }
            });
        });
    },
    full_setting: function() {
        var t = getApp(), e = getCurrentPages(), a = e[e.length - 1];
        Promise.all([ t.api.get_imgroot(), t.api.get_setting() ]).then(function(t) {
            var e = _slicedToArray(t, 2), o = e[0], n = e[1];
            a.setData({
                imgroot: o,
                setting: n
            });
        });
    },
    getSiteUrl: function() {
        var e = wx.getStorageSync("url");
        if (e) return e;
        wx.request({
            url: this.siteInfo.siteroot + "?i=" + this.siteInfo.uniacid + "&t=undefined&v=1.0.0&from=wxapp&c=entry&a=wxapp&do=GetImgRoot&m=yzhyk_sun",
            header: {
                "content-type": "application/json"
            },
            success: function(t) {
                return e = t.data, wx.setStorageSync("url", e), e;
            }
        });
    },
    wxauthSetting: function(t) {
        var s = this, e = getCurrentPages(), i = e[e.length - 1];
        wx.login({
            success: function(t) {
                var e = t.code;
                wx.setStorageSync("code", e), s.util.request({
                    url: "entry/wxapp/openid",
                    showLoading: !1,
                    cachetime: "3600",
                    data: {
                        code: e
                    },
                    success: function(t) {
                        console.log(t.data), wx.setStorageSync("key", t.data.session_key), wx.setStorageSync("openid", t.data.openid);
                        var a = t.data.openid, e = wx.getStorageSync("share_type"), o = wx.getStorageSync("d_user");
                        console.log("授权新形象1231"), console.log(e), console.log(o), 2 == e && a != o && "" != o && (console.log("邀请好友任务"), 
                        s.util.request({
                            url: "entry/wxapp/setInvitefriends",
                            data: {
                                m: "yzhyk_sun_plugin_scoretask",
                                openid: a,
                                invite_openid: o
                            },
                            showLoading: !1,
                            success: function(t) {}
                        })), wx.getSetting({
                            success: function(t) {
                                t.authSetting["scope.userInfo"] && wx.getUserInfo({
                                    success: function(t) {
                                        var e = t.userInfo.nickName, o = t.userInfo.avatarUrl, n = t.userInfo.gender;
                                        wx.setStorageSync("user_info", t.userInfo), s.util.request({
                                            url: "entry/wxapp/Login",
                                            showLoading: !1,
                                            cachetime: "3600",
                                            data: {
                                                openid: a,
                                                img: o,
                                                name: e,
                                                gender: n
                                            },
                                            success: function(t) {
                                                wx.setStorageSync("users", t.data), wx.getStorageSync("have_wxauth") || i.onShow(), 
                                                wx.setStorageSync("uniacid", t.data.uniacid), i.setData({
                                                    is_modal_Hidden: !0,
                                                    usersinfo: t.data
                                                });
                                            }
                                        });
                                    }
                                });
                            }
                        });
                    }
                });
            }
        });
    },
    setFx: function() {
        var a = this;
        return new Promise(function(e, t) {
            var o = wx.getStorageSync("users").openid, n = wx.getStorageSync("users");
            a.util.request({
                url: "entry/wxapp/Plugin",
                data: {
                    type: 3
                },
                success: function(t) {
                    2 != t.data && t.data;
                    o && a.util.request({
                        url: "entry/wxapp/IsPromoter",
                        data: {
                            openid: o,
                            form_id: 0,
                            uid: n.id,
                            status: 3,
                            m: "yzhyk_sun_plugin_distribution"
                        },
                        success: function(t) {
                            t && 9 != t.data ? 0 == t.data || 222 == t.data ? e("/yzhyk_sun/plugin/distribution/fxAddShare/fxAddShare") : 111 == t.data ? e("/yzhyk_sun/plugin/distribution/fxBuyShare/fxBuyShare") : 333 == t.data ? e("/yzhyk_sun/plugin/distribution/fxVipShare/fxVipShare") : 5 == t.data ? e("/yzhyk_sun/plugin/distribution/fxYqmShare/fxYqmShare") : e("/yzhyk_sun/plugin/distribution/fxCenter/fxCenter") : e("/yzhyk_sun/plugin/distribution/fxAddShare/fxAddShare");
                        }
                    });
                }
            });
        });
    }
});

var Page_temp = Page;

Page = function(t) {
    var e = getApp(), o = t.onLoad;
    t.onLoad = function(t) {
        e.pageInit(), o.call(this, t);
    }, Page_temp(t);
};