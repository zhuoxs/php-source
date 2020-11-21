var _request = require("../../util/request.js"), _request2 = _interopRequireDefault(_request), _cart = require("../../util/cart.js"), _cart2 = _interopRequireDefault(_cart);

function _interopRequireDefault(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}

var app = getApp();

Page({
    data: {
        animationData: {},
        navTile: "",
        nav: [ {
            title: "扫一扫",
            src: "../../../style/images/nav2.png",
            bind: "scanCode"
        }, {
            title: "每日秒杀",
            src: "../../../style/images/nav1.png",
            bind: "index/seckill/seckill"
        }, {
            title: "领券中心",
            src: "../../../style/images/nav3.png",
            bind: "index/cards/cards"
        }, {
            title: "更多分店",
            src: "../../../style/images/nav4.png",
            bind: "index/branch/branch"
        } ],
        tech: {
            tech_title: "",
            tech_is_show: !1,
            tech_phone: "",
            tech_img: ""
        },
        skIndex: "0",
        isLogin: !1,
        indicatorDots: !1,
        autoplay: !1,
        interval: 3e3,
        duration: 800,
        notName: "店铺公告",
        secKillActivityId: 0,
        isIpx: app.globalData.isIpx,
        cartCount: 0
    },
    onLoad: function() {
        this.setTitle(), this.userAuth(), this.login(), this.updateCart();
    },
    updateCart: function() {
        this.setData({
            cartCount: _cart2.default.getAllNum()
        });
    },
    setTitle: function() {
        var t = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : null;
        null != t && this.setData({
            navTile: t
        }), wx.setNavigationBarTitle({
            title: this.data.navTile
        });
    },
    login: function() {
        var e = this;
        wx.getStorageSync("openid") ? e.handleLngLat() : wx.login({
            success: function(t) {
                t.code ? (console.log("code:" + t.code), _request2.default.get("getOpenid", {
                    code: t.code
                }).then(function(t) {
                    console.log(t), wx.setStorageSync("openid", t.openid), e.handleLngLat();
                })) : console.log("登录失败！" + t.errMsg);
            }
        });
    },
    handleLngLat: function() {
        var i = this, t = wx.getStorageSync("lnglat") || null, s = parseInt(Date.parse(new Date()) / 1e3);
        null != t && parseInt(t.expried) < s && (t = null), null == t ? wx.getLocation({
            type: "wgs84",
            success: function(t) {
                var e = t.latitude, a = t.longitude;
                console.log(t);
                var n = {};
                n.latitude = e, n.longitude = a, n.expried = s + 600, wx.setStorageSync("lnglat", n), 
                i.saveUserInfo(e, a);
            },
            fail: function(t) {
                console.log(t);
            }
        }) : i.saveUserInfo(t.latitude, t.longitude);
    },
    saveUserInfo: function(t, e) {
        var a = this, n = this, i = wx.getStorageSync("userInfo"), s = wx.getStorageSync("storeId") || 0;
        _request2.default.post("saveUserInfo", {
            latitude: t,
            longitude: e,
            avatarUrl: i.avatarUrl,
            nickName: i.nickName,
            store_id: s
        }).then(function(t) {
            wx.setStorageSync("storeId", t.store.id), wx.setStorageSync("storeName", t.store.name), 
            0 == t.nav.length && (t.nav = a.data.nav), n.setData({
                banner: t.banner,
                notice: t.notice,
                operation: t.nav,
                newRecom: t.new_goods,
                seckill: t.second_kill_activity,
                limitTime: t.limit_time_activity,
                tech: t.tech,
                secKillActivityId: t.sec_kill_activity_id,
                skIndex: t.sec_kill_activity_index
            }), n.setTitle(t.store.name);
        });
    },
    handleUserInfo: function(t, e) {
        this.setData({
            isLogin: !1
        }), console.log(t), wx.setStorageSync("userInfo", {
            avatarUrl: t.avatarUrl,
            nickName: t.nickName
        }), e && _request2.default.post("saveBaseUserInfo", {
            avatarUrl: t.avatarUrl,
            nickName: t.nickName
        }).then(function(t) {});
    },
    userAuth: function() {
        var e = this;
        wx.getSetting({
            success: function(t) {
                t.authSetting["scope.userInfo"] ? wx.getUserInfo({
                    success: function(t) {
                        e.handleUserInfo(t.userInfo, !1);
                    }
                }) : e.setData({
                    isLogin: !0
                });
            }
        });
    },
    bindGetUserInfo: function(t) {
        this.handleUserInfo(t.detail.userInfo, !0);
    },
    seckill: function(t) {
        var e = t.currentTarget.dataset.index;
        this.setData({
            skIndex: e
        });
    },
    seckillAddCart: function(t) {
        var e = {};
        e.src = t.src, e.name = t.name, e.goods_type = 2, e.id = t.id, e.activity_goods_id = t.activity_goods_id, 
        e.price = t.price, _cart2.default.add(e) ? (_cart2.default.showSuccess(), this.updateCart()) : _cart2.default.showFail();
    },
    seckillAdd: function(t) {
        var e = this, a = t.currentTarget.dataset.index, n = (t.currentTarget.dataset.id, 
        this.data.skIndex), i = this.data.seckill[n].goods[a], s = {};
        s.store_id = _cart2.default.getStoreId(), s.goods_id = i.id, s.activity_id = this.data.secKillActivityId, 
        s.activity_type = 2, s.activity_goods_id = i.activity_goods_id;
        var o = {};
        o.id = i.id, o.goods_type = 2, s.cartCount = _cart2.default.getNum(o), console.log(s), 
        _request2.default.get("isValidCart", s).then(function(t) {
            console.log(t), t.is_enable ? e.seckillAddCart(i) : wx.showToast({
                title: t.msg,
                icon: "none",
                duration: 2e3
            });
        });
    },
    add: function(t) {
        var e = t.currentTarget.dataset.index, a = this.data.newRecom[e];
        _cart2.default.add(a) ? (_cart2.default.showSuccess(), this.updateCart()) : _cart2.default.showFail();
    },
    toSeckill: function(t) {
        wx.navigateTo({
            url: "seckill/seckill"
        });
    },
    toCards: function(t) {
        wx.navigateTo({
            url: "cards/cards"
        });
    },
    toBranch: function(t) {
        wx.navigateTo({
            url: "branch/branch"
        });
    },
    toRedirect: function(t) {
        var e = t.currentTarget.dataset.action;
        if (-1 == e.indexOf("/")) switch (e) {
          case "scanCode":
            this.scanCode();
        } else wx.navigateTo({
            url: "/yzbld_sun/pages/" + e
        });
    },
    toTimebuy: function(t) {
        wx.navigateTo({
            url: "timebuy/timebuy"
        });
    },
    toGoods: function(t) {
        wx.navigateTo({
            url: "goods/goods?id=" + t.currentTarget.dataset.id
        });
    },
    toClassify: function(t) {
        wx.navigateTo({
            url: "../classify/classify"
        });
    },
    scanCode: function(t) {
        wx.scanCode({
            scanType: "barCode",
            success: function(t) {
                console.log(t), _request2.default.get("getGoodsIdFromBarCode", {
                    barcode: t.result
                }).then(function(t) {
                    console.log(t);
                    var e = "goods/goods?id=" + t.id;
                    wx.navigateTo({
                        url: e
                    });
                });
            }
        });
    },
    callphone: function(t) {
        var e = t.currentTarget.dataset.phone;
        wx.makePhoneCall({
            phoneNumber: e
        });
    },
    onShareAppMessage: function(t) {}
});