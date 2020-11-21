var t = require("../../../../utils/base.js"), a = require("../../../../../api.js"), e = require("../../../../../siteinfo.js"), i = new t.Base(), s = getApp();

Page({
    data: {
        goods_count: 0,
        ps_type: 0,
        store_type: 2,
        is_area: 0,
        ps_selsect: "hide",
        support: "hide",
        userCoupon: !1,
        pickAddress: [],
        daydata: {},
        deliveryTime: {},
        goodsTotalPrice: 0,
        totalPrice: 0,
        freight: 0,
        freightPrice: 0,
        openfreight: !0,
        subPrice: 0,
        Integral_money: 0,
        is_integral: 0,
        openintegral: !1,
        is_coupon: 0,
        poor: 0,
        not_area: 0,
        select_express: 0,
        select_delivery: 0,
        deliveryPrice: 0,
        openBuy: 1,
        openDelivery: 1,
        openExpress: 1,
        openFunciton: 1,
        flag: !0
    },
    onLoad: function(t) {
        var a = this, e = this.data.store_type, i = this.data.ps_type;
        if (s.getInformation(function(t) {
            1 == t.info.is_delivery && 0 == t.info.is_express ? (e = 2, i = 0) : 1 == t.info.is_express && 0 == t.info.is_delivery ? (e = 1, 
            i = 0) : 1 == t.info.is_delivery && 1 == t.info.is_express ? (e = 2, i = 0) : (e = 3, 
            i = 3), a.setData({
                is_delivery: t.info.is_delivery,
                is_express: t.info.is_express,
                is_pick: t.info.is_pick,
                minPrice: 1 == t.info.is_delivery ? t.deliver.min_price : 0,
                store_type: e,
                ps_type: i,
                is_timing: 1 == t.info.is_delivery ? t.deliver.is_timing : 0
            });
        }), "0" == t.buyType) if ("" != t.attr_id_list && "0" == t.buyType) {
            var r = JSON.stringify(t.attr_id_list).replace(/\"/g, ""), o = JSON.stringify(t.specValue).replace(/\"/g, "");
            this.setData({
                attr_id_list: r.split(","),
                specValue: o.split(",")
            });
        } else this.setData({
            attr_id_list: t.attr_id_list,
            specValue: t.specValue
        });
        this.setData({
            buyType: t.buyType
        }), "0" == t.buyType && this.setData({
            num: t.num,
            goodId: t.goodId
        });
    },
    onShow: function() {
        this.setData({
            not_area: 0,
            poor: 0,
            flag: !0
        }), this.getAddress(), this.getPickAddress();
    },
    onUnload: function() {
        wx.removeStorageSync("pickAddress");
    },
    getAddress: function(t) {
        var e = this, s = {
            url: a.default.DefaultAddress,
            method: "GET"
        };
        i.getData(s, function(t) {
            1 == t.errorCode ? (e.setData({
                addressInfo: t.data,
                addressId: t.data.id,
                openBuy: 1
            }), e.buy(), e.getDelivery(t.data.id)) : (e.setData({
                addressInfo: "",
                freight: 0,
                delivery_price: 0,
                addressId: "",
                openBuy: 1
            }), e.buy());
        });
    },
    peisong: function(t) {
        var a = t.currentTarget.dataset.ps_type, e = this.data.is_delivery, i = this.data.is_express, s = (this.data.is_pick, 
        this.data.store_type);
        this.setData({
            ps_type: a
        }), 0 == a ? (1 == e && 0 == i ? s = 2 : 1 == i && 0 == e ? s = 1 : 1 == e && 1 == i && (s = 2), 
        this.setData({
            store_type: s,
            openBuy: 1,
            deliveryTime: {},
            flag: !0
        }), this.getAddress()) : (this.setData({
            store_type: 3,
            openBuy: 1,
            daydata: {},
            poor: 0,
            is_area: 0,
            not_area: 0
        }), this.buy());
    },
    storePs: function(t) {
        var a = t.currentTarget.dataset.id;
        this.setData({
            store_type: a,
            openBuy: 1,
            openFunciton: 0,
            flag: !1
        }), this.buy(), this.cascadeToggle(t);
    },
    getDelivery: function(t) {
        var e = this, s = {
            url: a.default.delivery_area,
            data: {
                addressId: t
            }
        };
        i.getData(s, function(t) {
            console.log("配送范围=>", t), 1 == t.errorCode ? e.setData({
                delivery_price: t.data.delivery_price,
                is_area: t.data.is_area
            }) : e.setData({
                is_area: 0,
                delivery_price: 0
            });
        });
    },
    getAttr: function() {
        var t = this;
        wx.showLoading({
            title: "请稍后"
        });
        var e = [], s = (Number(this.data.store_type), 0), r = [], o = {};
        o = "" != this.data.attr_id_list ? {
            url: a.default.attr_info,
            data: {
                product_id: this.data.goodId,
                attr_id_list: this.data.attr_id_list
            }
        } : {
            url: a.default.product,
            data: {
                productId: this.data.goodId
            },
            method: "GET"
        }, i.getData(o, function(a) {
            setTimeout(function() {
                wx.hideLoading();
            }, 300), t.setData({
                attrInfo: a.data
            }), 1 == a.errorCode && ("" != t.data.attr_id_list && (a.data.vip_price = a.data.price), 
            e[0] = {
                product: a.data,
                product_id: a.data.id,
                num: t.data.num,
                attr_id_list: t.data.attr_id_list,
                specValue: t.data.specValue,
                price: "" != t.data.attr_id_list ? a.data.price : 0
            }, s = t.data.num);
            for (var i in e) {
                var o = {
                    productId: e[i].product.id,
                    attr_id_list: e[i].attr_id_list,
                    num: e[i].num
                };
                r.push(o);
            }
            var d = {
                addressId: t.data.addressId,
                order_type: t.data.store_type,
                product: r
            };
            t.checkBuy(d, e);
        });
    },
    getCart: function() {
        var t = this;
        wx.showLoading({
            title: "请稍后"
        });
        var e = [], s = (Number(this.data.store_type), {
            url: a.default.getCart,
            method: "GET"
        });
        i.getData(s, function(a) {
            var i = [];
            if (1 == a.errorCode) {
                var s = a.data.info;
                for (var r in s) 1 == s[r].is_checked && i.push(s[r]);
                for (var o in i) {
                    var d = {
                        productId: i[o].product.id,
                        attr_id_list: i[o].attr_id_list,
                        num: i[o].num
                    };
                    e.push(d);
                }
                var n = {
                    addressId: t.data.addressId,
                    order_type: t.data.store_type,
                    product: e
                };
                t.checkBuy(n, i);
            }
            setTimeout(function() {
                wx.hideLoading();
            }, 300);
        });
    },
    checkBuy: function(t, e) {
        var s = this, r = 0, o = [], d = [], n = [], u = this.data.select_express, p = this.data.select_delivery;
        for (var c in e) -1 != e[c].product.send_type.indexOf(1) && (u = 1), -1 != e[c].product.send_type.indexOf(2) && (p = 1, 
        d.push(e[c]));
        var l = 0;
        if (d.length > 0) for (var h in d) l += d[h].product.vip_price * d[h].num;
        var _ = {
            url: a.default.check_buy,
            data: t
        };
        i.getData(_, function(t) {
            var a = [], i = [];
            if (1 == t.errorCode) {
                for (var d in e) for (var c in t.data) {
                    if (e[d].product_id == t.data[c].productId && 1 == t.data[c].can_buy && s.specEqual(e[d].attr_id_list, t.data[c].attr_id_list)) {
                        a.push(e[d]);
                        break;
                    }
                    if (e[d].product_id == t.data[c].productId && 1 != t.data[c].can_buy && s.specEqual(e[d].attr_id_list, t.data[c].attr_id_list)) {
                        e[d].msg = t.data[c].msg, i.push(e[d]);
                        break;
                    }
                }
                if (s.goodsPrice(u, p, l, a), a.length > 0 && "" != s.data.addressId) {
                    for (var d in a) -1 != a[d].product.send_type.indexOf(1) && n.push(a[d]);
                    s.getFreight(n);
                } else s.setData({
                    freight: 0
                });
                for (var d in a) {
                    var h = {
                        productId: a[d].product.id,
                        attr_id_list: a[d].attr_id_list,
                        num: a[d].num
                    };
                    r += Number(a[d].num), o.push(h);
                }
                var _ = {
                    addressId: s.data.addressId,
                    order_type: s.data.store_type,
                    product: o
                };
                s.getIntegral(_), a.length > 0 && s.getCoupon(_), s.setData({
                    select_express: u,
                    select_delivery: p,
                    supportGoods: a,
                    notSupportGoods: i,
                    productData: _,
                    goods_count: r
                });
            }
        });
    },
    specEqual: function(t, a) {
        if (null == t && (t = ""), t instanceof Array && a instanceof Array) {
            if (t.length !== a.length) return !1;
            for (var e = 0; e < t.length; e++) if (Number(t[e]) !== Number(a[e])) return !1;
            return !0;
        }
        return Number(t) == Number(a);
    },
    buy: function(t) {
        1 == this.data.openBuy && (0 == this.data.buyType ? this.getAttr() : this.getCart());
    },
    kuaidi: function(t, a, e) {
        console.log("快递是否开启=>", this.data.is_express), console.log("minPrice=>", this.data.minPrice), 
        console.log("select_express=>", t), console.log("select_delivery=>", a), 0 == this.data.ps_type ? 1 == t && 1 == a ? 1 == this.data.is_area && e > this.data.minPrice && 1 == this.data.is_delivery ? (console.log("在配送范围内和起步价达到的情况下优先显示同城配送"), 
        this.setData({
            store_type: 2,
            openBuy: 1,
            msg: "",
            openDelivery: 1
        }), this.data.flag && this.buy(), this.setData({
            flag: !1
        })) : 1 == this.data.is_area && e < this.data.minPrice && 1 == this.data.is_express ? (console.log("在配送范围内和起步价达不到的情况下显示快递发货"), 
        this.setData({
            store_type: 1,
            openBuy: 1,
            msg: "未达到起送价",
            openDelivery: 0
        }), this.data.flag && this.buy(), this.setData({
            flag: !1
        })) : 0 == this.data.is_area && 1 == this.data.is_express && (console.log("不在配送范围内的情况下显示快递发货"), 
        this.setData({
            store_type: 1,
            openBuy: 1,
            msg: "不在配送范围",
            openDelivery: 0
        }), this.data.flag && this.buy(), this.setData({
            flag: !1
        })) : 1 != t && 1 == a && 1 == this.data.is_delivery && (console.log("支持同城"), 1 == this.data.is_area && e > this.data.minPrice ? (console.log("订单设置开启了快递，起步价到达"), 
        this.setData({
            store_type: 2,
            openBuy: 1,
            msg: "",
            openExpress: 0
        }), this.data.flag && this.buy(), this.setData({
            flag: !1
        })) : 1 == this.data.is_express && 1 == this.data.is_area ? (console.log("开启快递功能，在配送范围，没有商品支持快递"), 
        this.setData({
            store_type: 2,
            openBuy: 1,
            msg: "未达到起送价",
            openExpress: 0,
            poor: 1
        }), this.data.flag && this.buy(), this.setData({
            flag: !1
        })) : 0 == this.data.is_express && 1 != this.data.is_area ? (console.log("关闭了快递功能"), 
        this.setData({
            store_type: 2,
            openBuy: 1,
            not_area: 1
        }), this.data.flag && this.buy(), this.setData({
            flag: !1
        })) : 1 == this.data.is_express && 1 != this.data.is_area ? (console.log("不在配送范围内"), 
        this.setData({
            store_type: 2,
            openBuy: 1,
            msg: "该地址不在配送范围内",
            openExpress: 0,
            not_area: 1
        }), this.data.flag && this.buy(), this.setData({
            flag: !1
        })) : 1 == this.data.is_area && e < this.data.minPrice && (console.log("配送范围内起步价不够"), 
        this.setData({
            store_type: 2,
            openBuy: 1,
            msg: "未达到起步价",
            openExpress: 0,
            poor: 1
        }), this.data.flag && this.buy(), this.setData({
            flag: !1
        }))) : (console.log("没有进入"), this.setData({
            store_type: 3,
            openBuy: 0
        }), this.buy());
    },
    goodsPrice: function(t, a, e, i) {
        var s = 0;
        if ("" != this.data.attr_id_list && "0" == this.data.buyType) for (var r in i) s += Number(i[r].price) * Number(i[r].num); else for (var r in i) s += Number(i[r].product.vip_price) * Number(i[r].num);
        var o = 1 == this.data.is_delivery ? wx.getStorageSync("store_info").deliver.min_price : 0, d = 0;
        s < o && 2 == this.data.store_type && (d = o - s), this.setData({
            goodsTotalPrice: Number(s).toFixed(2),
            poor_price: d.toFixed(2)
        }), this.totalPrice(s, this.data.freightPrice, this.data.Integral_money, this.data.subPrice), 
        1 == this.data.openFunciton && this.kuaidi(t, a, e);
    },
    getIntegral: function(t) {
        var e = this, s = {
            url: a.default.product_integral,
            data: t
        };
        i.getData(s, function(t) {
            e.setData({
                integral: t.integral,
                money: t.money
            });
        });
    },
    openIntegral: function(t) {
        var a = this.data.Integral_money, e = this.data.is_integral;
        t.detail.value ? (a = this.data.money, e = 1) : (a = 0, e = 0), this.setData({
            Integral_money: a,
            is_integral: e
        }), this.totalPrice(this.data.goodsTotalPrice, this.data.freightPrice, a, this.data.subPrice);
    },
    getCoupon: function(t) {
        var e = this, s = {
            url: a.default.product_coupon,
            data: t
        };
        i.getData(s, function(t) {
            console.log("优惠券列表=>", t), 1 == t.errorCode ? e.setData({
                couponList: t.data
            }) : e.setData({
                couponList: []
            });
        });
    },
    getFreight: function(t) {
        var e = this;
        console.log("freightGoods=>", t);
        var s = [];
        for (var r in t) {
            var o = {
                productId: t[r].product.id,
                attr_id_list: t[r].attr_id_list,
                num: t[r].num
            };
            s.push(o);
        }
        var d = {
            addressId: this.data.addressId,
            product: s
        }, n = {
            url: a.default.product_freight,
            data: d
        }, u = 0;
        i.getData(n, function(t) {
            console.log("运费=>", t), 0 == t.error_code ? (e.setData({
                openfreight: !1
            }), u = 0) : u = Number(t).toFixed(2);
            var a = 0;
            a = 1 == e.data.store_type ? t : 2 == e.data.store_type ? e.data.delivery_price : 0, 
            e.totalPrice(e.data.goodsTotalPrice, a, e.data.Integral_money, e.data.subPrice), 
            e.setData({
                freight: u,
                freightPrice: Number(a).toFixed(2)
            });
        });
    },
    totalPrice: function(t, a, e, i) {
        var s = Number(t) + Number(a) - Number(i) - Number(e);
        this.setData({
            totalPrice: s <= 0 ? 0 : s.toFixed(2)
        });
    },
    selectCoupon: function(t) {
        var e = this;
        wx.showLoading({
            title: "请稍后"
        });
        var s = t.currentTarget.dataset.couponid, r = this.data.productData;
        r.is_integral = this.data.is_integral, r.order_type = this.data.store_type, r.delivery_time = this.data.deliveryTime.day || "", 
        r.is_coupon = 1, r.couponId = s, r.pick_info = {
            pickId: this.data.pickId,
            name: this.data.name,
            phone: this.data.phone,
            address: this.data.pickAddress.address,
            time: this.data.daydata.day
        };
        var o = {
            url: a.default.coupon_price,
            data: r
        };
        i.getData(o, function(t) {
            1 == t.errorCode ? (e.totalPrice(e.data.goodsTotalPrice, e.data.freightPrice, e.data.Integral_money, t.data), 
            e.setData({
                subPrice: t.data,
                userCoupon: !e.data.userCoupon,
                is_coupon: 1,
                couponId: s
            })) : (e.totalPrice(e.data.goodsTotalPrice, e.data.freightPrice, e.data.Integral_money, 0), 
            e.setData({
                subPrice: 0,
                userCoupon: !e.data.userCoupon,
                is_coupon: 0,
                couponId: s
            }));
        }), setTimeout(function() {
            wx.hideLoading();
        }, 300);
    },
    toPay: function(t) {
        wx.showLoading({
            title: "提交中"
        });
        var i = this.data.productData;
        i.is_integral = this.data.is_integral, i.order_type = this.data.store_type, i.delivery_time = this.data.deliveryTime.day || "", 
        i.is_coupon = this.data.is_coupon, i.couponId = this.data.couponId, i.pick_info = {
            pickId: this.data.pickId,
            name: this.data.name,
            phone: this.data.phone,
            address: this.data.pickAddress.address,
            time: this.data.daydata.day
        };
        var r = wx.getStorageSync("token") || "";
        r && wx.request({
            url: s.globalData.api_root + a.default.order_place,
            data: i,
            header: {
                "content-type": "application/json",
                token: r,
                uniacid: e.uniacid
            },
            method: "POST",
            success: function(t) {
                if (1 == t.data.errorCode) {
                    t.data;
                    wx.request({
                        url: s.globalData.api_root + a.default.pay_pre_order,
                        method: "POST",
                        header: {
                            token: r,
                            uniacid: e.uniacid
                        },
                        data: {
                            id: t.data.data
                        },
                        success: function(t) {
                            wx.hideLoading();
                            var a = t.data;
                            wx.requestPayment({
                                timeStamp: a.timeStamp.toString(),
                                nonceStr: a.nonceStr,
                                package: a.package,
                                signType: a.signType,
                                paySign: a.paySign,
                                success: function(t) {
                                    wx.redirectTo({
                                        url: "../order/order?status=1&sindex=2&kind=send"
                                    });
                                },
                                fail: function(t) {
                                    wx.hideLoading(), wx.showModal({
                                        title: "提示",
                                        showCancel: !1,
                                        content: "订单支付失败",
                                        success: function(t) {
                                            wx.redirectTo({
                                                url: "../order/order?status=0&sindex=1&kind=wait"
                                            });
                                        }
                                    });
                                }
                            });
                        }
                    });
                } else wx.showToast({
                    title: t.data.msg,
                    icon: "none",
                    duration: 2e3
                });
            },
            fail: function(t) {
                wx.hideLoading();
            }
        });
    },
    getPickAddress: function() {
        var t = wx.getStorageSync("pickAddress");
        t && this.setData({
            pickAddress: t,
            pickId: t.id,
            is_pickTime: t.is_pick
        });
    },
    selectTime: function(t) {
        var a = t.currentTarget.dataset.pickid;
        a ? wx.navigateTo({
            url: "../pickup_time/pickup_time?pickId=" + a + "&timeIndex=" + this.data.daydata.timeIndex + "&period=" + this.data.daydata.period + "&timeIdx=" + this.data.daydata.timeIdx + "&am=" + this.data.daydata.am + "&Ttype=0"
        }) : wx.showToast({
            title: "请选择提货地址",
            icon: "none",
            duration: 2e3
        });
    },
    selectDTime: function(t) {
        wx.navigateTo({
            url: "../pickup_time/pickup_time?&timeIndex=" + this.data.daydata.timeIndex + "&period=" + this.data.daydata.period + "&timeIdx=" + this.data.daydata.timeIdx + "&am=" + this.data.daydata.am + "&Ttype=1"
        });
    },
    inputPhone: function(t) {
        var a = this, e = t.detail.value;
        i.checkPhone(e, function(t) {
            t ? a.setData({
                phone: e
            }) : wx.showToast({
                title: "请输入正确手机号码",
                icon: "none",
                duration: 2e3
            });
        });
    },
    getName: function(t) {
        var a = t.detail.value;
        this.setData({
            name: a
        });
    },
    cascadeToggle: function(t) {
        var a = this, e = t.currentTarget.dataset.type;
        "show" == a.data.ps_selsect || "show" == a.data.support ? a.cascadeDismiss(e) : a.cascadePopup(e);
    },
    cascadePopup: function(t) {
        var a = wx.createAnimation({
            duration: 300,
            timingFunction: "ease-in-out"
        });
        this.animation = a, a.bottom(0).step(), "0" == t ? this.setData({
            animationData: this.animation.export(),
            ps_selsect: "show"
        }) : 1 == t && this.setData({
            animationData2: this.animation.export(),
            support: "show"
        });
    },
    cascadeDismiss: function(t) {
        this.animation.bottom(-500).step(), 0 == t ? this.setData({
            animationData: this.animation.export(),
            ps_selsect: "hide"
        }) : 1 == t && this.setData({
            animationData2: this.animation.export(),
            support: "hide"
        });
    },
    not_userCoupon: function(t) {
        this.setData({
            userCoupon: !this.data.userCoupon,
            subPrice: 0,
            is_coupon: 0
        }), this.totalPrice(this.data.goodsTotalPrice, this.data.freightPrice, this.data.Integral_money, 0);
    },
    userCoupon: function(t) {
        this.setData({
            userCoupon: !this.data.userCoupon
        });
    },
    gotToarea: function(t) {
        wx.navigateTo({
            url: "../../../Home/area/area"
        });
    }
});