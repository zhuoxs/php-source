var _data;

function _defineProperty(t, a, e) {
    return a in t ? Object.defineProperty(t, a, {
        value: e,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[a] = e, t;
}

var flag = !0, app = getApp();

Page({
    data: (_data = {
        navTile: "提交订单",
        goods: [],
        usercoupon: [],
        times: "24小时内",
        address: "厦门市集美区杏林湾路",
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
        price: 0,
        coupon_id: 0,
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
            pay_type: 1,
            icon: "../../../../style/images/wx.png"
        }, {
            name: "余额",
            value: "余额支付",
            pay_type: 2,
            icon: "../../../../style/images/local.png"
        } ],
        uremark: "",
        hasAddress: !1
    }, _defineProperty(_data, "address", []), _defineProperty(_data, "shareCheck", !1), 
    _defineProperty(_data, "shareMoney", "0"), _defineProperty(_data, "actual_shareMoney", "0"), 
    _defineProperty(_data, "isOpenPay", !1), _defineProperty(_data, "isIpx", app.globalData.isIpx), 
    _data),
    onLoad: function(d) {
        var u = this;
        wx.setNavigationBarTitle({
            title: u.data.navTile
        }), wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
        var t = wx.getStorageSync("settings");
        this.setData({
            settings: t
        });
        var a = d.gid, e = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/getDiscount",
            cachetime: "0",
            data: {
                openid: e
            },
            success: function(t) {
                var c = t.data;
                console.log(c), u.setData({
                    discount: c
                }), d.cid ? wx.getStorage({
                    key: "crid",
                    success: function(t) {
                        var n = t.data.crid;
                        app.util.request({
                            url: "entry/wxapp/PayCart",
                            cachetime: "0",
                            data: {
                                id: n
                            },
                            success: function(t) {
                                for (var a = 0, e = 0, o = "", i = 0; i < t.data.data.length; i++) a += parseFloat(t.data.data[i].price), 
                                e += parseInt(t.data.data[i].num), o = o + t.data.data[i].gname + ",";
                                var s = 0;
                                if (0 < parseFloat(c)) {
                                    (s = parseFloat(a * c / 10)) < .01 && (s = parseFloat(a));
                                    var r = parseFloat(s) + parseFloat(u.data.settings.distribution);
                                } else r = parseFloat(a) + parseFloat(u.data.settings.distribution);
                                r = parseFloat(r).toFixed(2), console.log("总金额"), console.log(r), u.setData({
                                    distribution: parseFloat(u.data.settings.distribution),
                                    payData: t.data.data,
                                    price: a,
                                    num: e,
                                    gname: o,
                                    crid: n,
                                    cid: d.cid,
                                    last_price: r,
                                    good_total_discount_price: s
                                }), wx.getStorage({
                                    key: "openid",
                                    success: function(t) {
                                        app.util.request({
                                            url: "entry/wxapp/getUserCoupon",
                                            cachetime: "0",
                                            data: {
                                                uid: t.data,
                                                m_price: a
                                            },
                                            success: function(t) {
                                                u.setData({
                                                    usercoupon: t.data.data
                                                });
                                            }
                                        });
                                    }
                                });
                            }
                        });
                    }
                }) : wx.getStorage({
                    key: "order",
                    success: function(t) {
                        var s = t.data.num;
                        u.setData({
                            spec: t.data.spec,
                            spect: t.data.spect,
                            num: s
                        }), app.util.request({
                            url: "entry/wxapp/GoodsDetails",
                            cachetime: "0",
                            data: {
                                id: a
                            },
                            success: function(t) {
                                console.log(t);
                                var a = t.data.data, e = a.goods_price * s, o = 0;
                                if (0 < parseFloat(c)) {
                                    (o = parseFloat(e * c / 10)) < .01 && (o = parseFloat(e));
                                    var i = parseFloat(o) + parseFloat(u.data.settings.distribution);
                                } else i = parseFloat(e) + parseFloat(u.data.settings.distribution);
                                i = i.toFixed(2), u.setData({
                                    goodsDetails: a,
                                    first_price: e,
                                    price: e,
                                    last_price: i,
                                    distribution: parseFloat(u.data.settings.distribution),
                                    good_total_discount_price: o
                                }), wx.getStorage({
                                    key: "openid",
                                    success: function(t) {
                                        app.util.request({
                                            url: "entry/wxapp/getUserCoupon",
                                            cachetime: "0",
                                            data: {
                                                uid: t.data,
                                                m_price: e
                                            },
                                            success: function(t) {
                                                u.setData({
                                                    usercoupon: t.data.data
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
        }), u.urls();
    },
    urls: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/Url2",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url2", t.data);
            }
        }), app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url", t.data), a.setData({
                    url: t.data
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        var a = this, t = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/getUser",
            cachetime: "0",
            data: {
                openid: t
            },
            success: function(t) {
                a.setData({
                    shareMoney: t.data.money,
                    memberconf: t.data.memberconf
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    bindTimeChange: function(t) {
        this.setData({
            time: t.detail.value
        });
    },
    chooseType: function(t) {
        var a = this;
        if (0 < a.data.discount) var e = a.data.good_total_discount_price; else e = a.data.price;
        var o = a.data.cardprice, i = a.data.distribution, s = a.data.shareMoney;
        a.data.shareCheck || (s = 0);
        var r = t.currentTarget.dataset.type;
        "1" == r ? (i = 0, a.setData({
            distribution: 0
        })) : (i = a.data.settings.distribution, a.setData({
            distribution: a.data.settings.distribution
        }));
        i = 0;
        0 == r ? i = a.data.settings.distribution : 1 == r && (i = 0);
        var n = (parseFloat(e) - parseFloat(o) + parseFloat(i)).toFixed(2), c = 0;
        c = n >= parseFloat(s) ? parseFloat(s) : n, (n = (n - parseFloat(s)).toFixed(2)) <= 0 && (n = 0), 
        a.setData({
            sincetype: r,
            last_price: n,
            actual_shareMoney: c
        });
    },
    powerDrawer: function(t) {
        var a = t.currentTarget.dataset.statu;
        this.util(a);
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
        var a = this, e = a.data.sincetype, o = t.currentTarget.dataset.price, i = t.currentTarget.dataset.gid;
        if (0 < a.data.discount) var s = a.data.good_total_discount_price; else s = a.data.price;
        var r = a.data.shareMoney;
        a.data.shareCheck || (r = 0);
        var n = 0;
        0 == e ? n = a.data.settings.distribution : 1 == e && (n = 0);
        var c = (parseFloat(s) - parseFloat(o) + parseFloat(n)).toFixed(2), d = 0;
        d = c >= parseFloat(r) ? parseFloat(r) : c, (c = (c - parseFloat(r)).toFixed(2)) < 0 && (c = 0), 
        a.setData({
            coupon_id: i,
            cardprice: o,
            curprice: c,
            last_price: c,
            actual_shareMoney: d
        }), a.util("close");
    },
    toPay: function(a) {
        var o = this, i = o.data.cid, t = o.data.sincetype, s = o.data.address, r = o.data.actual_shareMoney, n = o.data.payType;
        if (null != n) {
            if (o.data.msg) c = o.data.msg.value; else var c = "";
            if (o.data.ziti_phone) d = o.data.ziti_phone.value; else var d = "";
            if (0 == t) {
                if (!s.provinceName) return void wx.showModal({
                    title: "温馨提示",
                    content: "请选择收货地址",
                    showCancel: !1
                });
            } else if (1 == t && "" == d) return void wx.showModal({
                title: "温馨提示",
                content: "请选择填写自提电话",
                showCancel: !1
            });
            var u = o.data.last_price;
            wx.getStorage({
                key: "openid",
                success: function(t) {
                    var e = t.data;
                    1 != i ? (console.log("---直接购买---"), app.util.request({
                        url: "entry/wxapp/AddOrder",
                        cachetime: "0",
                        data: {
                            uid: e,
                            order_amount: u,
                            cid: 0,
                            gid: a.currentTarget.dataset.gid,
                            pic: a.currentTarget.dataset.pic,
                            good_total_price: o.data.price,
                            good_total_num: o.data.num,
                            sincetype: o.data.sincetype,
                            distribution: o.data.distribution,
                            coupon_id: o.data.coupon_id,
                            coupon_price: o.data.cardprice,
                            spec_value: o.data.spec,
                            spec_value1: o.data.spect,
                            name: s.userName,
                            phone: s.telNumber,
                            province: s.provinceName,
                            city: s.cityName,
                            zip: s.countyName,
                            address: s.detailInfo,
                            postalcode: s.postalCode,
                            ziti_phone: d,
                            remark: c,
                            share_deduction: r,
                            pay_type: n,
                            formId: o.data.formId,
                            discount: o.data.discount,
                            good_total_discount_price: o.data.good_total_discount_price
                        },
                        success: function(t) {
                            var a = t.data;
                            0 != a ? app.util.request({
                                url: "entry/wxapp/getPayParam",
                                cachetime: "0",
                                data: {
                                    order_id: a
                                },
                                success: function(t) {
                                    console.log(t), wx.requestPayment({
                                        timeStamp: t.data.timeStamp,
                                        nonceStr: t.data.nonceStr,
                                        package: t.data.package,
                                        signType: "MD5",
                                        paySign: t.data.paySign,
                                        success: function(t) {
                                            wx.showToast({
                                                title: "支付成功",
                                                icon: "success",
                                                duration: 2e3,
                                                success: function() {},
                                                complete: function() {
                                                    wx.redirectTo({
                                                        url: "/yzmdwsc_sun/pages/user/myorder/myorder"
                                                    });
                                                }
                                            });
                                        },
                                        fail: function(t) {
                                            wx.redirectTo({
                                                url: "/yzmdwsc_sun/pages/user/myorder/myorder"
                                            });
                                        }
                                    });
                                }
                            }) : wx.showToast({
                                title: "支付成功",
                                icon: "success",
                                duration: 2e3,
                                success: function() {},
                                complete: function() {
                                    wx.redirectTo({
                                        url: "/yzmdwsc_sun/pages/user/myorder/myorder"
                                    });
                                }
                            });
                        }
                    })) : (console.log("---购物车---"), wx.getStorage({
                        key: "crid",
                        success: function(t) {
                            var a = t.data.crid;
                            app.util.request({
                                url: "entry/wxapp/AddOrder",
                                cachetime: "0",
                                data: {
                                    uid: e,
                                    order_amount: u,
                                    cid: 1,
                                    crid: a,
                                    good_total_price: o.data.price,
                                    good_total_num: o.data.num,
                                    sincetype: o.data.sincetype,
                                    distribution: o.data.distribution,
                                    coupon_id: o.data.coupon_id,
                                    coupon_price: o.data.cardprice,
                                    name: s.userName,
                                    phone: s.telNumber,
                                    province: s.provinceName,
                                    city: s.cityName,
                                    zip: s.countyName,
                                    address: s.detailInfo,
                                    postalcode: s.postalCode,
                                    ziti_phone: d,
                                    remark: c,
                                    share_deduction: r,
                                    pay_type: n,
                                    formId: o.data.formId,
                                    discount: o.data.discount,
                                    good_total_discount_price: o.data.good_total_discount_price
                                },
                                success: function(t) {
                                    var a = t.data;
                                    0 != a ? app.util.request({
                                        url: "entry/wxapp/getPayParam",
                                        cachetime: "0",
                                        data: {
                                            order_id: a
                                        },
                                        success: function(t) {
                                            wx.requestPayment({
                                                timeStamp: t.data.timeStamp,
                                                nonceStr: t.data.nonceStr,
                                                package: t.data.package,
                                                signType: "MD5",
                                                paySign: t.data.paySign,
                                                success: function(t) {
                                                    wx.showToast({
                                                        title: "支付成功",
                                                        icon: "success",
                                                        duration: 2e3,
                                                        success: function() {},
                                                        complete: function() {
                                                            wx.redirectTo({
                                                                url: "/yzmdwsc_sun/pages/user/myorder/myorder"
                                                            });
                                                        }
                                                    });
                                                },
                                                fail: function(t) {
                                                    wx.redirectTo({
                                                        url: "/yzmdwsc_sun/pages/user/myorder/myorder"
                                                    });
                                                }
                                            });
                                        }
                                    }) : wx.showToast({
                                        title: "支付成功",
                                        icon: "success",
                                        duration: 2e3,
                                        success: function() {},
                                        complete: function() {
                                            wx.redirectTo({
                                                url: "/yzmdwsc_sun/pages/user/myorder/myorder"
                                            });
                                        }
                                    });
                                }
                            });
                        }
                    }));
                }
            });
        } else wx.showModal({
            title: "温馨提示",
            content: "请选择支付方式",
            showCancel: !1
        });
    },
    message: function(t) {
        var a = t.detail;
        console.log(a), this.setData({
            msg: a
        });
    },
    ziti_phone: function(t) {
        var a = t.detail;
        console.log(a), this.setData({
            ziti_phone: a
        });
    },
    formSubmit: function(t) {
        this.setData({
            isOpenPay: !this.data.isOpenPay,
            formId: t.detail.formId
        });
    },
    toAddress: function() {
        var a = this;
        wx.chooseAddress({
            success: function(t) {
                console.log(t), console.log("获取地址成功"), a.setData({
                    address: t,
                    hasAddress: !0
                });
            },
            fail: function(t) {
                console.log("获取地址失败");
            }
        });
    },
    checkChange: function(t) {
        var a = (r = this).data.shareMoney;
        if (r.setData({
            shareCheck: !r.data.shareCheck
        }), r.data.shareCheck || (a = 0), 0 < r.data.discount) var e = r.data.good_total_discount_price; else e = r.data.price;
        var o = r.data.cardprice, i = r.data.distribution, s = r.data.sincetype, r = this;
        i = 0;
        0 == s ? i = r.data.settings.distribution : 1 == s && (i = 0);
        var n = (parseFloat(e) - parseFloat(o) + parseFloat(i)).toFixed(2), c = 0;
        c = n >= parseFloat(a) ? parseFloat(a) : n, (n = (n - parseFloat(a)).toFixed(2)) <= 0 && (n = 0), 
        r.setData({
            last_price: n,
            actual_shareMoney: c
        });
    },
    toMap: function(t) {
        var a = parseFloat(t.currentTarget.dataset.latitude), e = parseFloat(t.currentTarget.dataset.longitude);
        wx.openLocation({
            latitude: a,
            longitude: e,
            scale: 28
        });
    },
    toSubmit: function(t) {
        this.setData({
            isOpenPay: !this.data.isOpenPay
        });
    },
    radioChange: function(t) {
        var a = t.detail.value;
        console.log(a), this.setData({
            payType: a
        });
    }
});