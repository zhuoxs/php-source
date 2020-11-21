var app = getApp();

Page({
    data: {
        postData: [ "快递", "到店取货" ],
        addressData: [],
        addNew: [],
        cid: "",
        payData: ""
    },
    onLoad: function(s) {
        console.log("-------------清楚缓存------------------"), wx.removeStorageSync("coupon_id"), 
        wx.removeStorageSync("down_price"), wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), console.log(s);
        var o = s.gid, c = this;
        s.cid ? wx.getStorage({
            key: "crid",
            success: function(e) {
                var r = e.data.crid;
                app.util.request({
                    url: "entry/wxapp/PayCart",
                    cachetime: "0",
                    data: {
                        id: r
                    },
                    success: function(e) {
                        console.log(e), console.log(e.data.data[0].gid), app.util.request({
                            url: "entry/wxapp/getStoreName",
                            data: {
                                gid: e.data.data[0].gid
                            },
                            success: function(e) {
                                console.log(e), c.setData({
                                    goodsDetails: e.data.data
                                });
                            }
                        });
                        for (var n = 0, a = 0, t = "", o = 0; o < e.data.data.length; o++) console.log(e.data.data[o].price), 
                        n += e.data.data[o].price - 0, a += parseInt(e.data.data[o].num), t = t + e.data.data[o].gname + ",";
                        console.log(n), c.setData({
                            payData: e.data.data,
                            price: n,
                            num: a,
                            gname: t,
                            crid: r,
                            cid: s.cid
                        }), .01 < n ? wx.getStorage({
                            key: "openid",
                            success: function(e) {
                                app.util.request({
                                    url: "entry/wxapp/PersonVip",
                                    cachetime: "0",
                                    data: {
                                        uid: e.data
                                    },
                                    success: function(e) {
                                        if (console.log(e), 0 == e.data.data) var a = 1; else a = e.data.data.discount;
                                        var t = n * a, o = n - t;
                                        o = o.toFixed(2), t = t.toFixed(2), console.log(t), wx.setStorageSync("last_price", t), 
                                        c.setData({
                                            youhui: o,
                                            last_price: t
                                        });
                                    }
                                });
                            }
                        }) : (console.log(n), c.setData({
                            youhui: 0,
                            last_price: n
                        }));
                    }
                });
            }
        }) : wx.getStorage({
            key: "order",
            success: function(e) {
                var t = e.data.num;
                c.setData({
                    spec: e.data.spec,
                    spect: e.data.spect,
                    num: t
                }), app.util.request({
                    url: "entry/wxapp/GoodsDetails",
                    cachetime: "0",
                    data: {
                        id: o
                    },
                    success: function(e) {
                        console.log(e);
                        var a = e.data.data, n = a.goods_price * t;
                        c.setData({
                            goodsDetails: a,
                            first_price: n
                        }), .01 < n ? wx.getStorage({
                            key: "openid",
                            success: function(e) {
                                app.util.request({
                                    url: "entry/wxapp/PersonVip",
                                    cachetime: "0",
                                    data: {
                                        uid: e.data,
                                        gid: o
                                    },
                                    success: function(e) {
                                        if (console.log(e), 0 == e.data.data) var a = 1; else a = e.data.data.discount;
                                        var t = n * a, o = n - t;
                                        o = o.toFixed(2), t = t.toFixed(2), wx.setStorageSync("last_price", t), console.log(t), 
                                        c.setData({
                                            youhui: o,
                                            last_price: t
                                        });
                                    }
                                });
                            }
                        }) : c.setData({
                            youhui: 0,
                            last_price: n
                        });
                    }
                });
            }
        }), c.urls();
    },
    urls: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "0",
            success: function(e) {
                wx.setStorageSync("url", e.data), a.setData({
                    url: e.data
                });
            }
        });
    },
    goHadYhq: function(e) {
        wx.navigateTo({
            url: "../selectCoupon/hadYhq?price=" + e.currentTarget.dataset.vipcard + "&sid=" + e.currentTarget.dataset.store_id
        });
    },
    selectPost: function(e) {
        var d = this;
        if (this.setData({
            currentSelect: e.currentTarget.dataset.index
        }), 0 == e.currentTarget.dataset.index) wx.chooseAddress({
            success: function(e) {
                var a = e.userName, t = e.postalCode, o = e.cityName, n = e.provinceName, r = e.countyName, s = e.detailInfo, c = e.nationalCode, i = e.telNumber;
                d.setData({
                    userName: a,
                    postalCode: t,
                    provinceName: n,
                    cityName: o,
                    countyName: r,
                    detailInfo: s,
                    nationalCode: c,
                    telNumber: i,
                    showBox: "",
                    nickName: "",
                    mobile: ""
                });
            }
        }); else if (1 == e.currentTarget.dataset.index) {
            d.setData({
                showBox: 1,
                userName: ""
            });
        }
    },
    myName: function(e) {
        var a = e.detail.value;
        this.setData({
            nickName: a
        });
    },
    mobile: function(e) {
        console.log(e);
        var a = e.detail.value;
        this.setData({
            mobile: a
        });
    },
    message: function(e) {
        var a = e.detail;
        this.setData({
            msg: a
        });
    },
    onReady: function() {},
    toPay: function(t) {
        var s = this.data.cid, o = this, e = o.data.payData;
        console.log(e);
        var c = [], i = [], d = [], u = [], p = [], l = [], g = t.currentTarget.dataset.nickname, m = t.currentTarget.dataset.mobile, y = t.currentTarget.dataset.store_id;
        console.log(m);
        var _ = wx.getStorageSync("coupon_id");
        if (console.log(_), o.data.last_prices) var n = o.data.last_prices; else n = o.data.last_price;
        if (console.log(c), s) for (var a = 0; a < e.length; a++) c += e[a].gid + ",", i += e[a].gname + ",", 
        d += e[a].pic + ",", u += e[a].price + ",", p += e[a].combine + ",", l += e[a].num + ","; else c = t.currentTarget.dataset.gid, 
        l = t.currentTarget.dataset.num;
        console.log("houmian ----------------"), console.log(c), app.util.request({
            url: "entry/wxapp/ShopCartNum",
            cachetime: "30",
            data: {
                good_id: c,
                openid: wx.getStorageSync("openid"),
                good_num: l
            },
            success: function(e) {
                if (console.log(e), 0 == o.data.currentSelect) if (t.currentTarget.dataset.user_name) {
                    if (t.currentTarget.dataset.msg) a = t.currentTarget.dataset.msg.value; else var a = "";
                    console.log(g), wx.getStorage({
                        key: "openid",
                        success: function(e) {
                            var r = e.data;
                            app.util.request({
                                url: "entry/wxapp/Orderarr",
                                cachetime: "30",
                                data: {
                                    price: n,
                                    openid: r
                                },
                                success: function(n) {
                                    var o = this;
                                    if (console.log(n), 1 != s) console.log("-----直接购买=------"), app.util.request({
                                        url: "entry/wxapp/AddOrder",
                                        cachetime: "0",
                                        data: {
                                            user_id: r,
                                            money: t.currentTarget.dataset.price,
                                            user_name: t.currentTarget.dataset.user_name,
                                            address: t.currentTarget.dataset.address,
                                            tel: t.currentTarget.dataset.phone,
                                            good_id: t.currentTarget.dataset.gid,
                                            good_name: t.currentTarget.dataset.gname,
                                            good_img: t.currentTarget.dataset.img,
                                            good_money: t.currentTarget.dataset.good_price,
                                            good_spec: t.currentTarget.dataset.spec,
                                            good_num: t.currentTarget.dataset.num,
                                            note: a,
                                            mobile: m,
                                            nickName: g,
                                            store_id: y
                                        },
                                        success: function(e) {
                                            var t = e.data;
                                            console.log("获取支付数据"), console.log(n.data);
                                            var o = n.data.package;
                                            wx.requestPayment({
                                                timeStamp: n.data.timeStamp,
                                                nonceStr: n.data.nonceStr,
                                                package: n.data.package,
                                                signType: "MD5",
                                                paySign: n.data.paySign,
                                                success: function(e) {
                                                    console.log(e), wx.showToast({
                                                        title: "支付成功",
                                                        icon: "success",
                                                        duration: 2e3
                                                    }), app.util.request({
                                                        url: "entry/wxapp/PayOrder",
                                                        cachetime: "0",
                                                        data: {
                                                            order_id: t
                                                        },
                                                        success: function(e) {
                                                            console.log(t), console.log(o), app.util.request({
                                                                url: "entry/wxapp/BuyMessage",
                                                                cachetime: "0",
                                                                data: {
                                                                    order_id: t,
                                                                    new_package: o,
                                                                    openid: r
                                                                },
                                                                success: function(e) {
                                                                    console.log("-------------模板消息发送----------------"), console.log(e);
                                                                }
                                                            });
                                                        }
                                                    });
                                                    var a = this;
                                                    app.util.request({
                                                        url: "entry/wxapp/DieCoupon",
                                                        data: {
                                                            coupon_id: _,
                                                            openid: r
                                                        },
                                                        success: function(e) {
                                                            console.log(e), a.setData({
                                                                down_price: ""
                                                            }), wx.removeStorageSync("coupon_id");
                                                        }
                                                    }), wx.navigateTo({
                                                        url: "../myOrder-list/index"
                                                    });
                                                },
                                                fail: function(e) {}
                                            });
                                        }
                                    }); else {
                                        o = this;
                                        app.util.request({
                                            url: "entry/wxapp/AddOrder",
                                            cachetime: "0",
                                            data: {
                                                user_id: r,
                                                money: t.currentTarget.dataset.price,
                                                user_name: t.currentTarget.dataset.user_name,
                                                address: t.currentTarget.dataset.address,
                                                tel: t.currentTarget.dataset.phone,
                                                good_id: c,
                                                good_name: i,
                                                good_img: d,
                                                good_money: u,
                                                good_spec: p,
                                                good_num: l,
                                                note: a,
                                                mobile: m,
                                                nickName: g,
                                                store_id: y
                                            },
                                            success: function(e) {
                                                var a = e.data, t = n.data.package;
                                                wx.requestPayment({
                                                    timeStamp: n.data.timeStamp,
                                                    nonceStr: n.data.nonceStr,
                                                    package: n.data.package,
                                                    signType: "MD5",
                                                    paySign: n.data.paySign,
                                                    success: function(e) {
                                                        wx.showToast({
                                                            title: "支付成功",
                                                            icon: "success",
                                                            duration: 2e3
                                                        }), app.util.request({
                                                            url: "entry/wxapp/PayOrder",
                                                            cachetime: "0",
                                                            data: {
                                                                order_id: a
                                                            },
                                                            success: function(e) {
                                                                app.util.request({
                                                                    url: "entry/wxapp/BuyMessage",
                                                                    cachetime: "0",
                                                                    data: {
                                                                        order_id: a,
                                                                        new_package: t,
                                                                        openid: r
                                                                    },
                                                                    success: function(e) {
                                                                        console.log("-------------模板消息发送----------------"), console.log(e);
                                                                    }
                                                                });
                                                            }
                                                        }), app.util.request({
                                                            url: "entry/wxapp/DieCoupon",
                                                            data: {
                                                                coupon_id: _,
                                                                openid: r
                                                            },
                                                            success: function(e) {
                                                                console.log(e), o.setData({
                                                                    down_price: ""
                                                                }), wx.removeStorageSync("coupon_id");
                                                            }
                                                        }), wx.navigateTo({
                                                            url: "../myOrder-list/index"
                                                        });
                                                    },
                                                    fail: function(e) {}
                                                });
                                            }
                                        });
                                    }
                                }
                            });
                        }
                    });
                } else wx.showToast({
                    title: "请选择收货地址！",
                    icon: "none",
                    duration: 2e3
                }); else {
                    if (console.log(g), !m) return void wx.showToast({
                        title: "请输入手机号码或收货人！",
                        icon: "none"
                    });
                    if (console.log(m.toString().length), m.toString().length < 11) wx.showToast({
                        title: "请输入正确的手机号码！",
                        icon: "none"
                    }); else {
                        if (t.currentTarget.dataset.msg) a = t.currentTarget.dataset.msg.value; else var a = "";
                        wx.getStorage({
                            key: "openid",
                            success: function(e) {
                                var r = e.data;
                                app.util.request({
                                    url: "entry/wxapp/Orderarr",
                                    cachetime: "30",
                                    data: {
                                        price: n,
                                        openid: r
                                    },
                                    success: function(n) {
                                        var o = this;
                                        if (1 != s) console.log("-----直接购买=------"), app.util.request({
                                            url: "entry/wxapp/AddOrder",
                                            cachetime: "0",
                                            data: {
                                                user_id: r,
                                                money: t.currentTarget.dataset.price,
                                                user_name: t.currentTarget.dataset.user_name,
                                                address: t.currentTarget.dataset.address,
                                                tel: t.currentTarget.dataset.phone,
                                                good_id: t.currentTarget.dataset.gid,
                                                good_name: t.currentTarget.dataset.gname,
                                                good_img: t.currentTarget.dataset.img,
                                                good_money: t.currentTarget.dataset.good_price,
                                                good_spec: t.currentTarget.dataset.spec,
                                                good_num: t.currentTarget.dataset.num,
                                                note: a,
                                                mobile: m,
                                                nickName: g,
                                                store_id: y
                                            },
                                            success: function(e) {
                                                var t = e.data, o = n.data.package;
                                                wx.requestPayment({
                                                    timeStamp: n.data.timeStamp,
                                                    nonceStr: n.data.nonceStr,
                                                    package: n.data.package,
                                                    signType: "MD5",
                                                    paySign: n.data.paySign,
                                                    success: function(e) {
                                                        wx.showToast({
                                                            title: "支付成功",
                                                            icon: "success",
                                                            duration: 2e3
                                                        }), app.util.request({
                                                            url: "entry/wxapp/PayOrder",
                                                            cachetime: "0",
                                                            data: {
                                                                order_id: t
                                                            },
                                                            success: function(e) {
                                                                app.util.request({
                                                                    url: "entry/wxapp/BuyMessage",
                                                                    cachetime: "0",
                                                                    data: {
                                                                        order_id: t,
                                                                        new_package: o,
                                                                        openid: r
                                                                    },
                                                                    success: function(e) {
                                                                        console.log("-------------模板消息发送----------------"), console.log(e);
                                                                    }
                                                                });
                                                                var a = this;
                                                                app.util.request({
                                                                    url: "entry/wxapp/DieCoupon",
                                                                    data: {
                                                                        coupon_id: _,
                                                                        openid: r
                                                                    },
                                                                    success: function(e) {
                                                                        console.log(e), a.setData({
                                                                            down_price: ""
                                                                        }), wx.removeStorageSync("coupon_id");
                                                                    }
                                                                }), wx.navigateTo({
                                                                    url: "../myOrder-list/index"
                                                                });
                                                            }
                                                        });
                                                    },
                                                    fail: function(e) {}
                                                });
                                            }
                                        }); else {
                                            o = this;
                                            app.util.request({
                                                url: "entry/wxapp/AddOrder",
                                                cachetime: "0",
                                                data: {
                                                    user_id: r,
                                                    money: t.currentTarget.dataset.price,
                                                    user_name: t.currentTarget.dataset.user_name,
                                                    address: t.currentTarget.dataset.address,
                                                    tel: t.currentTarget.dataset.phone,
                                                    good_id: c,
                                                    good_name: i,
                                                    good_img: d,
                                                    good_money: u,
                                                    good_spec: p,
                                                    good_num: l,
                                                    note: a,
                                                    mobile: m,
                                                    nickName: g,
                                                    store_id: y
                                                },
                                                success: function(e) {
                                                    var a = e.data, t = n.data.package;
                                                    wx.requestPayment({
                                                        timeStamp: n.data.timeStamp,
                                                        nonceStr: n.data.nonceStr,
                                                        package: n.data.package,
                                                        signType: "MD5",
                                                        paySign: n.data.paySign,
                                                        success: function(e) {
                                                            wx.showToast({
                                                                title: "支付成功",
                                                                icon: "success",
                                                                duration: 2e3
                                                            }), app.util.request({
                                                                url: "entry/wxapp/PayOrder",
                                                                cachetime: "0",
                                                                data: {
                                                                    order_id: a
                                                                },
                                                                success: function(e) {
                                                                    app.util.request({
                                                                        url: "entry/wxapp/BuyMessage",
                                                                        cachetime: "0",
                                                                        data: {
                                                                            order_id: a,
                                                                            new_package: t,
                                                                            openid: r
                                                                        },
                                                                        success: function(e) {
                                                                            console.log("-------------模板消息发送----------------"), console.log(e);
                                                                        }
                                                                    }), app.util.request({
                                                                        url: "entry/wxapp/DieCoupon",
                                                                        data: {
                                                                            coupon_id: _,
                                                                            openid: r
                                                                        },
                                                                        success: function(e) {
                                                                            console.log(e), o.setData({
                                                                                down_price: ""
                                                                            }), wx.removeStorageSync("coupon_id");
                                                                        }
                                                                    }), wx.navigateTo({
                                                                        url: "../myOrder-list/index"
                                                                    });
                                                                }
                                                            });
                                                        },
                                                        fail: function(e) {}
                                                    });
                                                }
                                            });
                                        }
                                    }
                                });
                            }
                        });
                    }
                }
            }
        });
    },
    goToAddress: function() {},
    onShow: function() {
        wx.getStorageSync("openid");
        var e = wx.getStorageSync("coupon_id"), a = wx.getStorageSync("down_price");
        if (console.log(a), e) {
            var t = this.data.last_price;
            console.log(t);
            var o = t - a;
            this.setData({
                last_prices: o,
                coupon_id: e,
                down_price: a
            });
        } else this.setData({
            coupon_id: "",
            down_price: 0
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});