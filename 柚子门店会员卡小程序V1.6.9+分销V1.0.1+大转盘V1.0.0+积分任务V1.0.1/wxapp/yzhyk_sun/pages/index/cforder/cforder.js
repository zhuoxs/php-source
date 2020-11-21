var tool = require("../../../../style/utils/tools.js"), app = getApp();

Page({
    data: {
        navTile: "提交订单",
        times: "24小时内",
        takeaddress: "厦门市集美区杏林湾路",
        contact: "13000000",
        startSince: "09:01",
        endSince: "21:01",
        sincetype: "0",
        distribution: "0.00",
        distributFee: "0.00",
        totalprice: "0",
        cardprice: "0",
        curprice: "0",
        showModalStatus: !1,
        cards: [ {
            price: "30",
            minprice: "398",
            time: "2018.01.12-2018.02.12"
        }, {
            price: "10",
            minprice: "398",
            time: "2018.01.12-2018.02.12"
        } ],
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
        var s = this;
        wx.setNavigationBarTitle({
            title: s.data.navTile
        });
        var a = tool.formatTime(new Date());
        this.setData({
            multiArray: a,
            time: a[0][0] + " " + a[1][0]
        }), app.get_imgroot().then(function(i) {
            app.get_store_info().then(function(e) {
                app.get_user_info().then(function(t) {
                    var a = app.cart_get();
                    s.setData({
                        imgroot: i,
                        store: e,
                        tel: t.tel,
                        cart: a,
                        takeaddress: e.address
                    }), s.totalPrice();
                });
            });
        }), app.get_card_info().then(function(t) {
            s.setData({
                discount: t && t.discount ? t.discount : 10
            });
        }), app.get_setting().then(function(t) {
            s.setData({
                setting: t
            });
        }), app.get_user_info().then(function(t) {
            s.setData({
                user: t
            });
        });
    },
    onReady: function() {},
    onShow: function() {
        var s = app.cart_get(), o = this;
        app.get_user_coupons().then(function(t) {
            var a = t, e = [];
            for (var i in a) parseFloat(a[i].use_amount) <= parseFloat(s.amount) && e.push(a[i]);
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
    chooseType: function(t) {
        var a = t.currentTarget.dataset.type, e = this, i = e.data.distribution;
        "1" == a ? e.setData({
            distributFee: 0
        }) : e.setData({
            distributFee: i
        }), e.totalPrice(), e.setData({
            sincetype: a
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
        var a = this, e = t.currentTarget.dataset.price, i = t.currentTarget.dataset.index, s = a.data.curprice;
        s < 0 && (s = 0), a.setData({
            cardprice: e,
            coupon_id: a.data.cards[i].id,
            coupon_price: e
        }), a.totalPrice(), a.util("close");
    },
    showModel: function(t) {
        var a = t.currentTarget.dataset.statu, e = t.currentTarget.dataset.confirm, i = this, s = i.data.uremark, o = i.data.curremark;
        "true" == e ? i.setData({
            uremark: s,
            curremark: s
        }) : i.setData({
            uremark: o
        }), i.setData({
            showRemark: a
        });
    },
    showPay: function(t) {
        var a = !0, e = "", i = (n = this).data.sincetype, s = (n.data.distributFee, n.data.payType, 
        n.data.time, n.data.address), o = n.data.tel;
        n.data.uremark;
        if ("1" == i ? /^\d{9,}$/.test(o) ? a = "false" : e = "请输入自提电话" : null == s.userName ? e = "请选择收货地址" : a = "false", 
        1 != a) {
            var n, r = t.currentTarget.dataset.statu;
            (n = this).setData({
                payStatus: r
            });
        } else wx.showModal({
            title: "提示",
            content: e,
            showCancel: !1
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
        var a = !0, e = "", i = this, s = i.data.sincetype, o = i.data.distributFee, n = i.data.payType, r = i.data.time, d = i.data.tel, c = i.data.cart, u = i.data.uremark, l = i.data.curprice, p = i.data.address, m = i.data.takeaddress, h = t.detail.formId;
        console.log(h), "the formId is a mock one" != h && app.getFormid(h), "" == n ? e = "请选择支付方式" : a = !1, 
        1 != a ? app.get_user_info().then(function(t) {
            i.setData({
                isPay: ++i.data.isPay
            }), 1 == i.data.isPay ? (i.setData({
                isPay: !0
            }), app.util.request({
                url: "entry/wxapp/AddOrder",
                cachetime: "0",
                method: "post",
                data: {
                    user_id: t.id,
                    store_id: i.data.store.id,
                    amount: c.amount,
                    pay_amount: l,
                    pay_type: n,
                    goodses: c.goodses,
                    distribution_type: s,
                    province: p.provinceName,
                    city: p.cityName,
                    county: p.countyName,
                    address: p.detailInfo,
                    distribution_fee: o,
                    take_time: r,
                    take_tel: d,
                    memo: u,
                    take_address: m,
                    coupon_id: i.data.coupon_id
                },
                success: function(t) {
                    if (1 == t.data.code) return wx.showToast({
                        title: "余额不足",
                        duration: 2e3,
                        icon: "none"
                    }), i.setData({
                        isPay: 0
                    }), !1;
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
                                        url: "/yzhyk_sun/pages/user/myorder/myorder"
                                    }) : wx.reLaunch({
                                        url: "/yzhyk_sun/pages/index/index"
                                    });
                                }
                            }), app.get_user_info(!1), app.get_user_coupons(!1), app.cart_clear();
                        };
                        if ("微信" == n) {
                            t.data.paydata.integralid;
                            app.wx_requestPayment(t.data.paydata).then(function(t) {
                                console.log(t), "requestPayment:ok" == t.errMsg && a();
                            }).catch(function(t) {
                                console.log(1111);
                            });
                        } else a();
                    } else console.log(22222), wx.showModal({
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
            })) : wx.showToast({
                title: "正在支付中...",
                icon: "none"
            });
        }) : wx.showModal({
            title: "提示",
            content: e,
            showCancel: !1
        });
    },
    totalPrice: function(t) {
        var a = this, e = a.data.cardprice, i = a.data.distributFee, s = a.data.discount, o = a.data.discountType || 0, n = parseFloat(a.data.cart.amount), r = n;
        if (1 == o) r = n - parseFloat(e) + parseFloat(i); else if (2 == o) {
            r = n * parseFloat(s) / 10 + parseFloat(i);
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