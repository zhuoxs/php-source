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
    }, _defineProperty(_data, "address", []), _defineProperty(_data, "isOpenPay", !1), 
    _data),
    onLoad: function(t) {
        var n = this;
        wx.setNavigationBarTitle({
            title: n.data.navTile
        }), wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
        var a = wx.getStorageSync("settings");
        this.setData({
            settings: a
        });
        var e = t.order_id, i = wx.getStorageSync("openid");
        wx.getStorage({
            key: "order-groupjoin",
            success: function(t) {
                var o = t.data.num;
                n.setData({
                    spec: t.data.spec,
                    spect: t.data.spect,
                    num: o
                }), app.util.request({
                    url: "entry/wxapp/getMch_idByOrder_id",
                    cachetime: "0",
                    data: {
                        order_id: e
                    },
                    success: function(t) {
                        n.setData({
                            mch_id: t.data,
                            order_id: e
                        });
                    }
                }), app.util.request({
                    url: "entry/wxapp/GoodsDetails",
                    cachetime: "0",
                    data: {
                        order_id: e,
                        openid: i
                    },
                    success: function(t) {
                        var a = t.data.data, e = a.pintuan_price * o, i = parseFloat(e) + parseFloat(n.data.settings.distribution);
                        n.setData({
                            goodsDetails: a,
                            first_price: e,
                            price: e,
                            last_price: i,
                            distribution: parseFloat(n.data.settings.distribution),
                            num: o
                        });
                    }
                });
            }
        }), n.urls();
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
    onShow: function() {},
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
        var a = (n = this).data.price, e = n.data.cardprice, i = n.data.distribution, o = t.currentTarget.dataset.type, n = this;
        "1" == o ? (i = 0, n.setData({
            distribution: 0
        })) : (i = n.data.settings.distribution, n.setData({
            distribution: n.data.settings.distribution
        }));
        i = 0;
        0 == o ? i = n.data.settings.distribution : 1 == o && (i = 0);
        var s = (parseFloat(a) - parseFloat(e) + parseFloat(i)).toFixed(2);
        n.setData({
            sincetype: o,
            last_price: s
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
        var a = this, e = a.data.sincetype, i = t.currentTarget.dataset.price, o = t.currentTarget.dataset.gid, n = a.data.price, s = 0;
        0 == e ? s = a.data.settings.distribution : 1 == e && (s = 0);
        var r = (parseFloat(n) - parseFloat(i) + parseFloat(s)).toFixed(2);
        r < 0 && (r = 0), a.setData({
            coupon_id: o,
            cardprice: i,
            curprice: r,
            last_price: r
        }), a.util("close");
    },
    toPay: function(e) {
        var i = this, t = (i.data.cid, i.data.sincetype), o = i.data.address, n = e.currentTarget.dataset.gid, s = i.data.payType;
        if (null != s) {
            if (i.data.msg) r = i.data.msg.value; else var r = "";
            if (i.data.ziti_phone) c = i.data.ziti_phone.value; else var c = "";
            if (0 == t) {
                if (!o.provinceName) return void wx.showModal({
                    title: "温馨提示",
                    content: "请选择收货地址",
                    showCancel: !1
                });
            } else if (1 == t && "" == c) return void wx.showModal({
                title: "温馨提示",
                content: "请选择填写自提电话",
                showCancel: !1
            });
            1 == flag && console.log("---订单提交中---");
            var d = i.data.last_price;
            wx.getStorage({
                key: "openid",
                success: function(t) {
                    var a = t.data;
                    app.util.request({
                        url: "entry/wxapp/Expire",
                        cachetime: "0",
                        data: {
                            id: n,
                            openid: a
                        },
                        success: function(t) {
                            0 == t.data.data ? wx.showToast({
                                title: "活动已结束",
                                icon: "none"
                            }) : (console.log("拼客参与拼团下订单"), app.util.request({
                                url: "entry/wxapp/setGroupOrder",
                                cachetime: "0",
                                data: {
                                    uid: a,
                                    order_amount: d,
                                    cid: 0,
                                    pin_mch_id: i.data.mch_id,
                                    order_id: i.data.order_id,
                                    gid: e.currentTarget.dataset.gid,
                                    pic: e.currentTarget.dataset.pic,
                                    good_total_price: i.data.price,
                                    good_total_num: i.data.num,
                                    sincetype: i.data.sincetype,
                                    distribution: i.data.distribution,
                                    coupon_id: i.data.coupon_id,
                                    coupon_price: i.data.cardprice,
                                    spec_value: i.data.spec,
                                    spec_value1: i.data.spect,
                                    name: o.userName,
                                    phone: o.telNumber,
                                    province: o.provinceName,
                                    city: o.cityName,
                                    zip: o.countyName,
                                    address: o.detailInfo,
                                    postalcode: o.postalCode,
                                    ziti_phone: c,
                                    remark: r,
                                    pay_type: s,
                                    formId: i.data.formId
                                },
                                success: function(t) {
                                    var a = t.data.order_id;
                                    2 != t.data.pay_type ? (console.log("获取支付参数"), app.util.request({
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
                                                                url: "../../user/groupdet/groupdet?order_id=" + a
                                                            });
                                                        }
                                                    });
                                                },
                                                fail: function(t) {
                                                    wx.redirectTo({
                                                        url: "../../index/groupjoin/groupjoin?order_id=" + i.data.order_id
                                                    });
                                                }
                                            });
                                        }
                                    })) : wx.showToast({
                                        title: "支付成功",
                                        icon: "success",
                                        duration: 2e3,
                                        success: function() {},
                                        complete: function() {
                                            wx.redirectTo({
                                                url: "/yzmdwsc_sun/pages/user/groupdet/groupdet?order_id=" + a
                                            });
                                        }
                                    });
                                }
                            }));
                        }
                    });
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