var _home = require("../../modules/home"), _address = require("../../modules/address"), addressModule = new _address.address(), homeModule = new _home.home(), app = getApp();

Page({
    data: {
        top_swiper: [],
        swiper_tap: 0,
        list: [],
        swiper_idx: 0,
        price: 0,
        fahuo: "",
        shouhuo: "",
        is_address: 0,
        distance: 0,
        car_id: 0,
        name: "",
        volume: "",
        red_bag: !0,
        new_person: {},
        is_price: 0
    },
    onLoad: function(t) {
        this.topSwiper(), this.carType(), this.getIsNewCoupons(), this.getUpdate(), wx.removeStorageSync("coupon");
    },
    onReady: function() {
        app.setNavigation();
        var t = setInterval(function() {
            app.globalData.syStem && (clearInterval(t), wx.setNavigationBarTitle({
                title: app.globalData.syStem.program_title
            }));
        }, 10);
    },
    onShow: function() {
        0 == app.globalData.user_id && homeModule.getUserId().then(function(t) {
            app.globalData.user_id = t.user_id;
            var a = {
                type: "bindUid",
                uid: app.globalData.user_id
            };
            app.linkWebsocket(a);
        }, function(t) {
            console.log("未获取用户id");
        }), this.checkAddress();
    },
    confirm: function(t) {
        var a = this;
        app.saveFromId(t.detail.formId);
        var e = this.data.swiper_tap, i = this.data.name, s = this.data.volume, n = this.data.list[this.data.swiper_idx], o = this.data.distance;
        if (1 != this.data.is_address) return app.hint("请选择先地址~");
        if (console.log(this.data.fahuo.ad_info.city), console.log(this.data.shouhuo.ad_info.city), 
        this.data.fahuo.ad_info.city == this.data.shouhuo.ad_info.city || 0 != e) {
            if (!(1 != e || i && s)) {
                if (!i) return app.hint("请填写物品名称~");
                if (!s) return app.hint("请填写物品的长宽高~");
            }
            wx.setStorageSync("goods", n), wx.navigateTo({
                url: "../order/order?swiper_tap=" + e + "&distance=" + o + "&price=" + this.data.price + "&volume=" + this.data.volume + "&name=" + this.data.name
            });
        } else wx.showModal({
            title: "温馨提示",
            content: "当前发货地址和收货地址不在同一城市~",
            showCancel: !1,
            success: function(t) {
                if (t.confirm) {
                    if (a.setData({
                        swiper_tap: 1
                    }), !i) return app.hint("请填写物品名称~");
                    if (!s) return app.hint("请填写物品的长宽高~");
                    wx.setStorageSync("goods", n), wx.navigateTo({
                        url: "../order/order?swiper_tap=1&distance=" + o + "&price=" + a.data.price + "&volume=" + a.data.volume + "&name=" + a.data.name
                    });
                }
            }
        });
    },
    closeIndexImg: function() {
        this.setData({
            red_bag: !0
        });
    },
    getIsNewCoupons: function() {
        var a = this;
        homeModule.newCoupon().then(function(t) {
            t.id && (console.log(t), a.setData({
                red_bag: !1,
                new_person: t
            }));
        }, function(t) {});
    },
    name: function(t) {
        this.setData({
            name: t.detail.value
        });
    },
    volume: function(t) {
        this.setData({
            volume: t.detail.value
        });
    },
    checkAddress: function() {
        var t = this, a = wx.getStorageSync("fahuo"), e = wx.getStorageSync("shouhuo");
        if (a && this.setData({
            fahuo: a
        }), e && this.setData({
            shouhuo: e
        }), a.title && e.title) {
            if (this.setData({
                is_price: 0
            }), app.globalData.syStem) return void this.predict(a, e, app.globalData.syStem.amap);
            var i = setInterval(function() {
                app.globalData.syStem && (clearInterval(i), t.predict(a, e, app.globalData.syStem.amap));
            }, 10);
        } else this.setData({
            is_address: 0
        });
    },
    acrossCity: function() {},
    predict: function(t, a, e) {
        var i = this, s = this.data.swiper_idx, n = setInterval(function() {
            i.data.list && 0 < i.data.list.length && (clearInterval(n), addressModule.getDistance(t, a, 0, e).then(function(a) {
                homeModule.predictPrice({
                    distance: a.distance,
                    car_id: i.data.list[s].id
                }).then(function(t) {
                    i.setData({
                        price: t.price,
                        is_address: 1,
                        distance: a.distance,
                        is_price: 1
                    });
                }, function(t) {});
            }, function(t) {
                console.log(t);
            }));
        }, 10);
    },
    preImg: function(t) {
        var a = t.currentTarget.dataset.idx, e = this.data.list, i = [];
        e.forEach(function(t) {
            i.push(t.image);
        }), wx.previewImage({
            current: i[a],
            urls: i
        });
    },
    swiperCar: function(t) {
        var a = t.currentTarget.dataset.id;
        this.setData({
            swiper_idx: a
        }), this.checkAddress();
    },
    bindArrows: function(t) {
        var a = this.data.swiper_idx;
        1 == t.currentTarget.dataset.id ? a++ : a--, this.setData({
            swiper_idx: a
        }), this.checkAddress();
    },
    swiperTap: function(t) {
        var a = t.detail.current;
        this.setData({
            swiper_idx: a
        }), this.checkAddress();
    },
    carType: function() {
        var a = this;
        homeModule.carType().then(function(t) {
            a.setData({
                list: t
            });
        }, function(t) {});
    },
    tapCity: function(t) {
        var a = t.currentTarget.dataset.id;
        this.setData({
            swiper_tap: a
        });
    },
    topSwiper: function() {
        var a = this;
        homeModule.topSwiper().then(function(t) {
            a.setData({
                top_swiper: t
            });
        }, function(t) {});
    },
    getUpdate: function() {
        var a = wx.getUpdateManager();
        a.onCheckForUpdate(function(t) {
            console.log(t.hasUpdate);
        }), a.onUpdateReady(function() {
            wx.showModal({
                title: "更新提示",
                content: "新版本上线，需要重启应用哟~",
                showCancel: !1,
                success: function(t) {
                    t.confirm && a.applyUpdate();
                }
            });
        }), a.onUpdateFailed(function() {});
    },
    jump: function(t) {
        var a = t.currentTarget.dataset.url, e = t.currentTarget.dataset.type, i = t.currentTarget.dataset.app_url, s = t.currentTarget.dataset.appid;
        if (2 != parseInt(e)) switch (a) {
          case "no":
            break;

          default:
            wx.navigateTo({
                url: "../" + a
            });
        } else wx.navigateToMiniProgram({
            appId: s,
            path: i
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {
        return app.userShare();
    }
});