var e = new getApp(), a = e.siteInfo.uniacid;

Page({
    data: {
        address: "",
        phone: "",
        userName: "",
        goodsData: [],
        count: "",
        totalPrice: [],
        copyTotalPrice: 0,
        cartData: [],
        is_buy_type: 1,
        goods_id: "",
        cart_id: "",
        spec_id: "",
        send_price: 0,
        couponCount: 0,
        userCoupon: [],
        s: [],
        order_id: 0,
        isIphoneX: e.globalData.isIphoneX,
        recovery_method: []
    },
    onLoad: function(t) {
        var o = this, s = t.goodsid, r = t.spec_id, i = t.cart_id, d = t.count, n = wx.getStorageSync("kundian_farm_uid"), c = wx.getStorageSync("kundian_farm_setData"), u = 1;
        2 == c.recovery_method && (u = 2), o.setData({
            s: c,
            recovery_method: u
        }), s && (e.util.request({
            url: "entry/wxapp/class",
            data: {
                op: "getSureGoods",
                control: "shop",
                uniacid: a,
                goods_id: s,
                spec_id: r,
                count: d,
                uid: n
            },
            success: function(e) {
                var a = e.data, t = a.goodsData, i = a.totalPrice, n = a.send_price, c = a.couponCount, p = a.address;
                2 == u && (i = parseFloat(i - e.data.send_price).toFixed(2));
                var l = "";
                p && (l = p.region + " " + p.address), o.setData({
                    count: d,
                    totalPrice: i,
                    goods_id: s,
                    goodsData: t,
                    copyTotalPrice: e.data.totalPrice,
                    spec_id: r || "",
                    send_price: n,
                    couponCount: c,
                    address: l,
                    phone: p.phone || "",
                    userName: p.name || ""
                });
            }
        }), e.util.setNavColor(a)), i && e.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "cart",
                op: "getBuyCartData",
                uniacid: a,
                uid: n,
                cart_id: i
            },
            success: function(e) {
                var a = e.data, t = a.address, s = a.cartData, r = a.totalPrice, d = a.send_price, n = a.couponCount, c = "";
                t && (c = t.region + " " + t.address), o.setData({
                    cartData: s,
                    is_buy_type: 2,
                    totalPrice: r,
                    copyTotalPrice: r,
                    cart_id: i,
                    send_price: d,
                    couponCount: n,
                    address: c,
                    phone: t.phone || "",
                    userName: t.name || ""
                });
            }
        });
    },
    chooseAddress: function(e) {
        wx.navigateTo({
            url: "/kundian_farm/pages/user/address/index?is_select=true"
        });
    },
    changeRecoveryMethod: function(e) {
        var a = e.currentTarget.dataset.state, t = this.data, o = t.totalPrice, s = t.send_price, r = t.copyTotalPrice;
        o = 2 == a ? parseFloat(o - s).toFixed(2) : r, this.setData({
            recovery_method: a,
            totalPrice: o
        });
    },
    addCount: function(e) {
        var a = this.data.goodsData, t = parseInt(this.data.count) + 1;
        if (1 == a.is_open_sku) o = parseFloat(this.data.goodsData.specVal.price * t) + parseFloat(this.data.send_price); else var o = parseFloat(a.price * t) + parseFloat(this.data.send_price);
        this.setData({
            count: t,
            totalPrice: o,
            copyTotalPrice: o
        });
    },
    reduceCount: function(e) {
        if (this.data.count > 1) {
            var a = this.data.goodsData, t = parseInt(this.data.count) - 1;
            if (1 == a.is_open_sku) o = parseFloat(this.data.goodsData.specVal.price * t) + parseFloat(this.data.send_price); else var o = parseFloat(a.price * t) + parseFloat(this.data.send_price);
            this.setData({
                count: t,
                totalPrice: o,
                copyTotalPrice: o
            });
        }
    },
    selectCoupon: function(e) {
        var a = this.data.copyTotalPrice - this.data.send_price;
        wx.navigateTo({
            url: "../../user/coupon/useCoupon/index?type=1&totalPrice=" + a
        });
    },
    onShow: function(e) {
        var a = this.data.copyTotalPrice;
        if (wx.getStorageSync("user_coupon")) {
            var t = wx.getStorageSync("user_coupon");
            wx.removeStorageSync("user_coupon"), this.setData({
                userCoupon: t,
                totalPrice: parseFloat(a - t.coupon.coupon_price).toFixed(2)
            });
        } else this.setData({
            userCoupon: [],
            totalPrice: a
        });
        var o = wx.getStorageSync("kundian_farm_uid"), s = wx.getStorageSync("selectAdd_" + o);
        s && (this.setData({
            userName: s.name,
            phone: s.phone,
            address: s.region + " " + s.address
        }), wx.removeStorageSync("selectAdd_" + o));
    },
    subOrder: function(t) {
        var o = this, s = wx.getStorageSync("kundian_farm_uid"), r = t.detail.value.remark, i = o.data, d = (i.order_id, 
        i.userName), n = i.address, c = i.phone, u = i.userCoupon, p = i.send_price, l = i.totalPrice, _ = i.recovery_method, h = i.is_buy_type, g = 0, f = 0;
        if ("" != u && (g = u.coupon.id, f = u.coupon.coupon_price), 1 == _ && ("" == d || "" == n || "" == c)) return wx.showToast({
            title: "请选择收获地址",
            icon: "none"
        }), !1;
        if (2 != _ || (d = t.detail.value.userName, c = t.detail.value.phone, "" != d && "" != c)) {
            if (1 == h) var y = o.data, m = y.goods_id, w = y.count, x = y.spec_id, v = {
                control: "shop",
                op: "addOrder",
                address: n,
                name: d,
                phone: c,
                uniacid: a,
                goods_id: m,
                count: w,
                uid: s,
                remark: r,
                is_buy_type: 1,
                spec_id: x,
                coupon_id: g,
                coupon_price: f,
                send_price: p,
                totalPrice: l,
                recovery_method: _,
                formId: t.detail.formId
            }; else var P = o.data.cart_id, v = {
                control: "shop",
                op: "addOrder",
                address: n,
                name: d,
                phone: c,
                uniacid: a,
                cart_id: P,
                uid: s,
                remark: r,
                is_buy_type: 2,
                coupon_id: g,
                coupon_price: f,
                send_price: p,
                totalPrice: l,
                recovery_method: _,
                formId: t.detail.formId
            };
            e.util.request({
                url: "entry/wxapp/class",
                data: v,
                success: function(t) {
                    if (1 == t.data.code) {
                        var s = t.data.order_id;
                        o.setData({
                            order_id: s
                        }), e.util.request({
                            url: "entry/wxapp/pay",
                            data: {
                                op: "getShopPayOrder",
                                orderid: s,
                                uniacid: a,
                                file: "shop"
                            },
                            cachetime: "0",
                            success: function(t) {
                                if (t.data && t.data.data && !t.data.errno) {
                                    var o = t.data.data.package;
                                    wx.requestPayment({
                                        timeStamp: t.data.data.timeStamp,
                                        nonceStr: t.data.data.nonceStr,
                                        package: t.data.data.package,
                                        signType: "MD5",
                                        paySign: t.data.data.paySign,
                                        success: function(t) {
                                            wx.showLoading({
                                                title: "加载中"
                                            }), e.util.request({
                                                url: "entry/wxapp/class",
                                                data: {
                                                    control: "shop",
                                                    order_id: s,
                                                    op: "sendMsg",
                                                    uniacid: a,
                                                    prepay_id: o
                                                },
                                                success: function() {
                                                    wx.showModal({
                                                        title: "提示",
                                                        content: "支付成功",
                                                        showCancel: !1,
                                                        success: function() {
                                                            wx.redirectTo({
                                                                url: "../orderList/index"
                                                            });
                                                        }
                                                    }), wx.hideLoading();
                                                }
                                            });
                                        },
                                        fail: function(e) {
                                            wx.showModal({
                                                title: "系统提示",
                                                content: "您取消了支付!",
                                                showCancel: !1,
                                                success: function(e) {
                                                    e.confirm && wx.redirectTo({
                                                        url: "../orderList/index"
                                                    });
                                                }
                                            }), wx.hideLoading();
                                        }
                                    });
                                } else console.log("fail1");
                            },
                            fail: function(e) {
                                "JSAPI支付必须传openid" == e.data.message ? wx.navigateTo({
                                    url: "/kundian_farm/pages/login/index"
                                }) : wx.showModal({
                                    title: "系统提示",
                                    content: e.data.message ? e.data.message : "错误",
                                    showCancel: !1,
                                    success: function(e) {
                                        e.confirm;
                                    }
                                });
                            }
                        });
                    } else wx.showModal({
                        title: "提示",
                        content: "订单生成失败！",
                        showCancel: !1
                    });
                }
            });
        } else wx.showToast({
            title: "请填写取货信息",
            icon: "none"
        });
    },
    gotoMerchant: function() {
        var e = this.data.s;
        wx.openLocation({
            latitude: parseFloat(e.self_lifting_place.lat),
            longitude: parseFloat(e.self_lifting_place.lng),
            name: e.self_lifting_address
        });
    }
});