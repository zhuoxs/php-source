var app = getApp();

Page({
    data: {
        show: !1,
        hasAddress: !1,
        showModalStatus: !1,
        payType: [ {
            name: "微信支付",
            pic: "../../resource/images/wx.png"
        }, {
            name: "余额支付",
            pic: "../../resource/images/local.png"
        } ],
        curPay: 1,
        showCoupon: !1,
        isRequest: 0,
        distribute_type: [ {
            name: "1",
            title: "快递配送",
            checked: !0
        }, {
            name: "2",
            title: "到店自提",
            checked: !1
        } ],
        sincetype: 1
    },
    onLoad: function(t) {
        var a = this, e = wx.getStorageSync("userInfo");
        if (e) {
            var s = e.id, i = t.gid || "", o = t.attrid || "", n = t.num || "", d = t.cartsid || "";
            d = d.substring(0, d.length - 1), a.setData({
                type: t.type,
                user_id: s,
                gid: i,
                attr_id: o,
                num: n,
                cart_ids: d
            });
            var r = wx.getStorageSync("expressInfo");
            r && a.setData({
                address: r
            }), a.loadDate();
        } else wx.showModal({
            title: "提示",
            content: "您未登陆，请先登陆！",
            success: function(t) {
                if (t.confirm) {
                    var a = encodeURIComponent("/sqtg_sun/pages/home/my/my?id=123");
                    app.reTo("/sqtg_sun/pages/home/login/login?id=" + a);
                } else t.cancel && app.lunchTo("/sqtg_sun/pages/home/index/index");
            }
        });
    },
    loadDate: function() {
        var d = this, t = d.data.address || {};
        app.ajax({
            url: "Corder|getPlaceOrder",
            data: {
                type: d.data.type,
                user_id: d.data.user_id,
                gid: d.data.gid,
                attr_ids: d.data.attr_id,
                num: d.data.num,
                cart_ids: d.data.cart_ids,
                province: t.provinceName || "",
                city: t.cityName || "",
                sincetype: d.data.sincetype
            },
            success: function(t) {
                var a = t.data, e = "", s = [], i = a.list || [], o = a.mch_list || [], n = 0;
                i.forEach(function(t, a) {
                    e += t.cart_id + ",";
                }), e = e.substring(0, e.length - 1), o.forEach(function(t, a) {
                    var e = {};
                    e.store_id = t.id, e.cart_id_list = [], e.user_coupon_id = "", t.list.forEach(function(t) {
                        e.cart_id_list.push(t.cart_id), n += t.price;
                    }), s.push(e);
                }), d.setData({
                    goods: a,
                    imgroot: t.other.img_root,
                    show: !0,
                    totalPrice: 0 < a.discoun_price ? a.discoun_price : a.total_goods_price,
                    total_shop: n,
                    expressPrice: a.express_price,
                    cart_ids_list: e,
                    mch_list: s
                }), d.getTotalPrice();
            }
        });
    },
    onShow: function() {},
    checkFee: function() {
        var t = wx.getStorageSync("expressInfo");
        t && this.setData({
            address: t
        }), this.loadDate();
    },
    toSgjoin: function(t) {
        this.setData({
            showModalStatus: !this.data.showModalStatus
        });
    },
    changePayType: function(t) {
        this.setData({
            curPay: t.currentTarget.dataset.index
        });
    },
    toggleCoupon: function() {
        this.setData({
            showCoupon: !this.data.showCoupon
        });
    },
    getCoupon: function(t) {
        var a = this;
        a.data.goods.list ? app.ajax({
            url: "Ccoupon|getUserCoupon",
            data: {
                user_id: a.data.user_id,
                m_price: a.data.totalPrice,
                store_id: 0
            },
            success: function(t) {
                0 < t.data.length ? (a.setData({
                    coupon: t.data
                }), a.toggleCoupon()) : app.tips("暂无可用优惠券");
            }
        }) : app.tips("暂无可用优惠券");
    },
    chooseCoupon: function(t) {
        var a = this, e = t.currentTarget.dataset.id, s = t.currentTarget.dataset.price;
        a.setData({
            couponid: e,
            couponPrice: s
        }), a.getTotalPrice(), a.toggleCoupon();
    },
    getTotalPrice: function() {
        var t = 0, a = this.data.goods, e = this.data.totalPrice, s = this.data.couponPrice || 0, i = this.data.expressPrice || 0;
        a.mch_list.length && a.mch_list.forEach(function(t, a) {
            i += t.express_price;
        }), i = 1 == this.data.sincetype ? i : 0, t = parseFloat(e) + parseFloat(i) - parseFloat(s) + this.data.total_shop, 
        this.setData({
            actualPrice: t.toFixed(2)
        });
    },
    subOrder: function(e) {
        var t = this, a = t.data.address || {}, s = t.data.curPay, i = t.data.type, o = (t.data.cart_ids, 
        e.detail.formId), n = t.data.mch_list, d = t.data.goods, r = e.detail.value.platmsg || e.detail.value.shopmsg0, c = t.data.sincetype, p = 0, u = t.data.platShop, l = 2 == c && null != u ? d.shop_list[u].id : "";
        if (n.length && n.forEach(function(t, a) {
            t.remark = e.detail.value["shopmsg" + a] || "", t.sincetype = c, t.shop_id = 0;
        }), 2 == c) for (var h = 0; h < d.mch_list.length; h++) {
            if (null == d.mch_list[h].store) {
                p++;
                break;
            }
            n[h].shop_id = d.mch_list[h].shopid;
        }
        if (null == a.userName && 1 == c) app.tips("请选择收货地址"); else if (null == a.userName && 2 == c) app.tips("请选择自提信息"); else if (2 == c && null == u && null != d.list) app.tips("请选择平台门店"); else if (2 == c && 0 != p && 0 < d.mch_list.length) app.tips("请选择商家门店"); else {
            if (t.setData({
                isRequest: ++t.data.isRequest
            }), 1 != t.data.isRequest) return void wx.showToast({
                title: "正在请求中...",
                icon: "none"
            });
            app.ajax({
                url: "Corder|setOrder",
                data: {
                    type: i,
                    user_id: t.data.user_id,
                    gid: t.data.gid,
                    attr_ids: t.data.attr_id,
                    num: t.data.num,
                    pay_type: s,
                    name: a.userName || "",
                    phone: a.telNumber || "",
                    province: a.provinceName || "",
                    city: a.cityName || "",
                    zip: a.countyName || "",
                    address: a.detailInfo || "",
                    postalcode: a.postalCode || "",
                    user_coupon_id: t.data.couponid || "",
                    cart_id_list: t.data.cart_ids_list,
                    mch_list: JSON.stringify(n),
                    remark: r || "",
                    formId: o,
                    sincetype: c,
                    shop_id: l || ""
                },
                success: function(t) {
                    0 == t.code ? 1 == s ? app.ajax({
                        url: "Corder|getPayParam",
                        data: {
                            order_id: t.data.order_id
                        },
                        success: function(t) {
                            wx.requestPayment({
                                timeStamp: t.data.timeStamp,
                                nonceStr: t.data.nonceStr,
                                package: t.data.package,
                                signType: "MD5",
                                paySign: t.data.paySign,
                                success: function(t) {
                                    wx.showModal({
                                        title: "提示",
                                        content: "支付成功",
                                        cancelText: "去首页",
                                        confirmText: "去订单页",
                                        confirmColor: "#f87d6d",
                                        success: function(t) {
                                            t.confirm ? app.reTo("/sqtg_sun/pages/public/pages/myorder/myorder?id=0") : app.lunchTo("/sqtg_sun/pages/home/index/index");
                                        }
                                    });
                                },
                                fail: function(t) {
                                    wx.showModal({
                                        title: "提示",
                                        content: "支付失败",
                                        cancelText: "去首页",
                                        confirmText: "去订单页",
                                        confirmColor: "#f87d6d",
                                        success: function(t) {
                                            t.confirm ? app.reTo("/sqtg_sun/pages/public/pages/myorder/myorder?id=0") : app.lunchTo("/sqtg_sun/pages/home/index/index");
                                        }
                                    });
                                }
                            });
                        }
                    }) : wx.showModal({
                        title: "提示",
                        content: "支付成功",
                        cancelText: "去首页",
                        confirmText: "去订单页",
                        confirmColor: "#f87d6d",
                        success: function(t) {
                            t.confirm ? app.reTo("/sqtg_sun/pages/public/pages/myorder/myorder?id=0") : app.lunchTo("/sqtg_sun/pages/home/index/index");
                        }
                    }) : wx.showToast({
                        title: t.data.msg,
                        icon: "none"
                    });
                },
                complete: function() {
                    t.setData({
                        isRequest: 0
                    });
                }
            });
        }
    },
    radioChange: function(t) {
        this.data.goods;
        this.setData({
            sincetype: t.detail.value
        }), this.getTotalPrice();
    },
    platShopChange: function(t) {
        this.setData({
            platShop: t.detail.value
        });
    },
    storeChange: function(t) {
        var a = t.currentTarget.dataset.index;
        this.getStoreAddr(a, t.detail.value);
    },
    getStoreAddr: function(t, a) {
        var e = this.data.goods;
        e.mch_list[t].store = e.mch_list[t].mch_shop_list[a].name + "-" + e.mch_list[t].mch_shop_list[a].address, 
        e.mch_list[t].shopid = e.mch_list[t].mch_shop_list[a].id, this.setData({
            goods: e
        });
    }
});