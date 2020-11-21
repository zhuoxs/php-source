var app = getApp(), tool = require("../../resource/js/tools.js");

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
        multiIndex: [ 0, 0 ]
    },
    onLoad: function(t) {
        var a = wx.getStorageSync("userInfo");
        if (a) {
            var e = a.id, s = t.gid || "", i = t.attrid || "", o = t.num || "", n = t.cartsid || "";
            n = n.substring(0, n.length - 1), this.setData({
                type: t.type,
                user_id: e,
                gid: s,
                attr_id: i,
                num: o,
                cart_ids: n
            }), this.loadDate();
            var r = tool.formatTime(new Date());
            this.setData({
                multiArray: r
            });
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
        var r = this;
        app.ajax({
            url: "Cbook|getBookPlaceOrder",
            data: {
                type: r.data.type,
                user_id: r.data.user_id,
                gid: r.data.gid,
                attr_ids: r.data.attr_id,
                num: r.data.num,
                province: "",
                city: ""
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
                }), r.setData({
                    goods: a,
                    imgroot: t.other.img_root,
                    show: !0,
                    totalPrice: 0 < a.discoun_price ? a.discoun_price : a.total_goods_price,
                    total_shop: n,
                    expressPrice: a.express_price,
                    cart_ids_list: e,
                    mch_list: s
                }), r.getTotalPrice();
            }
        });
    },
    onShow: function() {},
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
        }), t = parseFloat(e) + parseFloat(i) - parseFloat(s) + this.data.total_shop, this.setData({
            actualPrice: t.toFixed(2)
        });
    },
    subOrder: function(e) {
        var t = this, a = t.data.curPay, s = (t.data.type, t.data.cart_ids, e.detail.formId), i = t.data.mch_list, o = t.data.goods, n = e.detail.value.platmsg || e.detail.value.shopmsg0, r = t.data.sincetype, d = 0, c = t.data.platShop, l = null != c ? o.shop_list[c].id : "", u = e.detail.value.uname, p = e.detail.value.phone, h = e.detail.value.time;
        i.length && i.forEach(function(t, a) {
            t.remark = e.detail.value["shopmsg" + a] || "", t.sincetype = r, t.shop_id = 0;
        });
        for (var g = 0; g < o.mch_list.length; g++) {
            if (null == o.mch_list[g].store) {
                d++;
                break;
            }
            i[g].shop_id = o.mch_list[g].shopid, l = i[g].shop_id;
        }
        if ("" == u) app.tips("请输入您的姓名"); else if (/^1(3|4|5|7|8)\d{9}$/.test(p)) if (t.data.showtime) if (null == c && null != o.list) app.tips("请选择平台门店"); else if (0 != d && 0 < o.mch_list.length) app.tips("请选择商家门店"); else {
            if (t.setData({
                isRequest: ++t.data.isRequest
            }), 1 != t.data.isRequest) return void wx.showToast({
                title: "正在请求中...",
                icon: "none"
            });
            app.ajax({
                url: "Cbook|setBookOrder",
                data: {
                    user_id: t.data.user_id,
                    gid: t.data.gid,
                    attr_ids: t.data.attr_id,
                    num: t.data.num,
                    pay_type: a,
                    book_name: u,
                    book_phone: p,
                    book_time: h,
                    user_coupon_id: t.data.couponid || "",
                    remark: n || "",
                    formId: s,
                    shop_id: l || ""
                },
                success: function(t) {
                    0 == t.code ? 1 == a ? app.ajax({
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
                                            t.confirm ? app.reTo("/sqtg_sun/pages/plugin/order/orderlist/orderlist?id=0") : app.lunchTo("/sqtg_sun/pages/home/index/index");
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
                                            t.confirm ? app.reTo("/sqtg_sun/pages/plugin/order/orderlist/orderlist?id=0") : app.lunchTo("/sqtg_sun/pages/home/index/index");
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
                            t.confirm ? app.reTo("/sqtg_sun/pages/plugin/order/orderlist/orderlist?id=0") : app.lunchTo("/sqtg_sun/pages/home/index/index");
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
        } else app.tips("请选择预约时间"); else app.tips("请输入您的联系电话");
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
        e.mch_list[t].shopid = e.mch_list[t].mch_shop_list[a].id, console.log(e), this.setData({
            goods: e
        });
    },
    bindMultiPickerColumnChange: function(t) {
        var a = {
            multiArray: this.data.multiArray,
            multiIndex: this.data.multiIndex
        };
        a.multiIndex[t.detail.column] = t.detail.value, this.setData({
            showtime: !0
        }), this.setData(a);
    }
});