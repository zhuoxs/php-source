var tool = require("../../../../style/utils/tools.js"), app = getApp();

Page({
    data: {
        navTile: "提交订单",
        times: "24小时内",
        takeaddress: "厦门市集美区杏林湾路",
        contact: "13000000",
        startSince: "09:01",
        endSince: "21:01",
        distribution: "0.00",
        distributFee: "0.00",
        totalprice: "0",
        cardprice: "0",
        curprice: "0",
        showModalStatus: !1,
        goodsnum: 1,
        shop_price: 0,
        showRemark: 0,
        choose: [ {
            name: "微信",
            value: "微信支付",
            icon: "../../../../style/images/wx.png"
        }, {
            name: "余额",
            value: "余额支付",
            icon: "../../../../style/images/local.png"
        } ],
        payStatus: 0,
        payType: "",
        uremark: "",
        curremark: "",
        hasAddress: !1,
        multiArray: [],
        multiIndex: [ 0, 0 ],
        oldMultiIndex: [ 0, 0 ],
        address: {},
        isPay: 0,
        discount: 10,
        isIpx: app.globalData.isIpx,
        coupon_price: "0"
    },
    onLoad: function(t) {
        var o = this, s = t.id;
        wx.setNavigationBarTitle({
            title: o.data.navTile
        });
        var a = tool.formatTime(new Date());
        this.setData({
            multiArray: a,
            time: a[0][0] + " " + a[1][0]
        }), app.get_imgroot().then(function(i) {
            app.get_store_info().then(function(e) {
                app.get_user_info().then(function(a) {
                    app.util.request({
                        url: "entry/wxapp/CheckStock1",
                        cachetime: "0",
                        method: "post",
                        data: {
                            store_id: e.id,
                            id: s
                        },
                        success: function(t) {
                            o.setData({
                                imgroot: i,
                                store: e,
                                tel: a.tel,
                                goods: t.data,
                                takeaddress: e.address,
                                shop_price: t.data.shop_price
                            }), o.totalPrice();
                        }
                    });
                });
            });
        }), app.get_card_info().then(function(t) {
            o.setData({
                discount: t && t.discount ? t.discount : 10
            });
        }), app.get_setting().then(function(t) {
            o.setData({
                setting: t
            });
        }), app.get_user_info().then(function(t) {
            o.setData({
                user: t
            });
        });
    },
    onReady: function() {},
    onShow: function() {
        var o = this;
        app.get_user_coupons().then(function(t) {
            console.log(t);
            var a = t, e = [];
            for (var i in a) parseFloat(a[i].use_amount) <= parseFloat(o.data.shop_price) && e.push(a[i]);
            o.setData({
                cards: e
            });
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    getAddress: function(t) {
        var a = this;
        wx.chooseAddress({
            success: function(t) {
                app.util.request({
                    url: "entry/wxapp/GetDistributionFee",
                    cachetime: "0",
                    data: {
                        store_id: a.data.store.id,
                        province: t.provinceName,
                        city: t.cityName,
                        county: t.countyName
                    },
                    success: function(t) {
                        a.setData({
                            distribution: t.data,
                            distributFee: t.data
                        }), a.totalPrice();
                    }
                }), a.setData({
                    address: t,
                    hasAddress: !0
                });
            },
            fail: function(t) {}
        });
    },
    bindMultiPickerColumnChange: function(t) {
        var a = {
            multiArray: this.data.multiArray,
            multiIndex: this.data.multiIndex
        };
        a.multiIndex[t.detail.column] = t.detail.value, a.time = this.data.multiArray[0][this.data.multiIndex[0]] + " " + this.data.multiArray[1][this.data.multiIndex[1]], 
        this.setData(a);
    },
    dataChange: function(t) {
        var a = this.data.multiIndex;
        this.setData({
            oldMultiIndex: a
        });
    },
    dataCancel: function(t) {
        this.setData({
            multiIndex: this.data.oldMultiIndex
        });
    },
    powerDrawer: function(t) {
        var a = t.currentTarget.dataset.statu;
        1 == this.data.discountType && this.util(a);
    },
    util: function(t) {
        var a = wx.createAnimation({
            duration: 200,
            timingFunction: "linear",
            delay: 0
        });
        (this.animation = a).opacity(0).height(0).step(), this.setData({
            animationData: a.export()
        }), setTimeout(function() {
            a.opacity(1).height("550rpx").step(), this.setData({
                animationData: a
            }), "close" == t && this.setData({
                showModalStatus: !1
            });
        }.bind(this), 200), "open" == t && this.setData({
            showModalStatus: !0
        });
    },
    coupon: function(t) {
        var a = this, e = t.currentTarget.dataset.price, i = t.currentTarget.dataset.index, o = a.data.curprice;
        o < 0 && (o = 0), a.setData({
            cardprice: e,
            coupon_id: a.data.cards[i].id,
            coupon_price: e
        }), a.totalPrice(), a.util("close");
    },
    showModel: function(t) {
        var a = t.currentTarget.dataset.statu, e = t.currentTarget.dataset.confirm, i = this, o = i.data.uremark, s = i.data.curremark;
        "true" == e ? i.setData({
            uremark: o,
            curremark: o
        }) : i.setData({
            uremark: s
        }), i.setData({
            showRemark: a
        });
    },
    showPay: function(t) {
        (a = this).data.distributFee, a.data.payType, a.data.time, a.data.address, a.data.tel, 
        a.data.uremark;
        var a, e = t.currentTarget.dataset.statu;
        (a = this).setData({
            payStatus: e
        });
    },
    remark: function(t) {
        var a = t.detail.value;
        if (20 < a.length) return a = a.substr(0, 20), void wx.showModal({
            title: "提示",
            content: "不得超过20字",
            showCancel: !0
        });
        this.setData({
            uremark: a
        });
    },
    tel: function(t) {
        var a = t.detail.value;
        this.setData({
            tel: a
        });
    },
    payChange: function(t) {
        var a = t.detail.value;
        console.log(a), this.setData({
            payType: a
        });
    },
    radioChange: function(t) {
        var a = t.detail.value;
        this.setData({
            discountType: a
        }), this.totalPrice();
    },
    formSubmit: function(t) {
        console.log(t.detail);
        var a = !0, e = "", i = this, o = i.data.distributFee, s = i.data.time, n = i.data.tel, r = i.data.uremark, d = i.data.curprice, c = i.data.takeaddress, u = t.detail.formId, p = i.data.payType, l = i.data.goods.goods_id, h = i.data.goods.shop_price, m = i.data.goods.name, g = i.data.goodsnum, f = i.data.goods.pic;
        "the formId is a mock one" != u && app.getFormid(u), "" == p ? e = "请选择支付方式" : a = !1, 
        1 != a ? app.get_user_info().then(function(t) {
            if (console.log(1111), i.setData({
                isPay: ++i.data.isPay
            }), 1 != i.data.isPay) return console.log(2222), void wx.showToast({
                title: "正在支付中...",
                icon: "none"
            });
            i.setData({
                isPay: !0
            }), app.util.request({
                url: "entry/wxapp/AddOrderapp",
                cachetime: "0",
                method: "post",
                data: {
                    user_id: t.id,
                    store_id: i.data.store.id,
                    amount: i.data.shop_price,
                    pay_amount: d,
                    pay_type: p,
                    distribution_fee: o,
                    take_time: s,
                    take_tel: n,
                    goods_id: l,
                    goods_price: h,
                    goods_img: f,
                    num: g,
                    goods_name: m,
                    memo: r,
                    take_address: c,
                    coupon_id: i.data.coupon_id
                },
                success: function(t) {
                    if (0 == t.data.code) {
                        t.data.id;
                        var a = function() {
                            console.log("pay success"), wx.showModal({
                                title: "提示",
                                content: "支付成功",
                                cancelText: "回首页",
                                confirmText: "查看订单",
                                confirmColor: "#ff640f",
                                success: function(t) {
                                    t.confirm ? wx.redirectTo({
                                        url: "/yzhyk_sun/pages/user/apporder/apporder?cur=1"
                                    }) : wx.reLaunch({
                                        url: "/yzhyk_sun/pages/index/index"
                                    });
                                }
                            }), app.get_user_info(!1), app.get_user_coupons(!1);
                        };
                        if ("微信" == p) {
                            console.log(333);
                            var e = t.data.paydata.integralid;
                            app.wx_requestPayment(t.data.paydata).then(function(t) {
                                console.log(t), "requestPayment:ok" == t.errMsg && app.util.request({
                                    url: "entry/wxapp/addint",
                                    cachetime: "0",
                                    method: "post",
                                    data: {
                                        iid: e
                                    },
                                    success: function() {
                                        a();
                                    }
                                });
                            });
                        } else a();
                    } else wx.showModal({
                        title: "提示",
                        content: t.data.msg,
                        showCancel: !1,
                        success: function(t) {
                            wx.navigateBack({});
                        }
                    });
                    i.setData({
                        isPay: !1
                    });
                }
            });
        }) : wx.showModal({
            title: "提示",
            content: e,
            showCancel: !1
        });
    },
    add: function(t) {
        t.currentTarget.dataset.price;
        var a = this.data.goods, e = this.data.goodsnum;
        e < a.stock ? e += 1 : wx.showModal({
            title: "提示",
            content: "当前商品库存不足",
            showCancel: !1,
            success: function(t) {}
        }), this.setData({
            goodsnum: e,
            shop_price: e * a.shop_price
        }), this.totalPrice();
    },
    reduce: function(t) {
        t.currentTarget.dataset.price;
        var a = this.data.goods, e = this.data.goodsnum;
        1 < e && (e -= 1), this.setData({
            goodsnum: e,
            shop_price: e * a.shop_price
        }), this.totalPrice();
    },
    totalPrice: function(t) {
        var a = this, e = a.data.cardprice, i = a.data.distributFee, o = a.data.discount, s = a.data.discountType || 0, n = parseFloat(a.data.shop_price), r = n;
        if (console.log(s), 1 == s) r = n - parseFloat(e) + parseFloat(i); else if (2 == s) {
            r = n * parseFloat(o) / 10 + parseFloat(i);
            var d = parseFloat(n - r);
            a.setData({
                coupon_price: d
            });
        } else r = n + parseFloat(i);
        (r = r.toFixed(2)) <= 0 && (r = 0), a.setData({
            curprice: r
        });
    },
    toMember: function(t) {
        wx.redirectTo({
            url: "/yzhyk_sun/pages/index/member/member"
        });
    }
});