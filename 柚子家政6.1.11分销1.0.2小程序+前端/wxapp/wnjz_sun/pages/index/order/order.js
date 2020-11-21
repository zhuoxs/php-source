var app = getApp(), tool = require("../../../../style/utils/tools.js");

Page({
    data: {
        price: "",
        pronum: "",
        totalprice: "",
        index: "1",
        multiArray: [],
        ispay: !0,
        url: [],
        order: [],
        hasAddress: !1,
        address: [],
        multiIndex: [ 0, 0 ],
        showtime: "false",
        showModalStatus: !1,
        cardstu: !1,
        cardsprice: "",
        flag: "true",
        cards: [],
        id: "",
        shopprice: "",
        choose: [ {
            name: "微信",
            value: "微信支付",
            icon: "../../../../style/images/wx.png"
        }, {
            name: "余额",
            value: "余额支付",
            icon: "../../../../style/images/local.png"
        } ],
        payStatus: !1,
        isIpx: app.globalData.isIpx
    },
    onLoad: function(u) {
        var p = this;
        console.log(u), wx.setStorageSync("orderid", u.id), p.getTotalPrice(), p.getUrl(), 
        app.util.request({
            url: "entry/wxapp/system",
            cachetime: "0",
            success: function(t) {
                var a = parseInt(t.data.valb), e = parseInt(t.data.valc), i = tool.formatTime(new Date());
                console.log("2222222222222222222222"), console.log(i);
                for (var o = [], n = a; n <= e; n++) o.push(n + ":00"), o.push(n + ":30");
                i[1] = o;
                var r = new Date(), s = r.getHours(), c = r.getMinutes(), d = 0;
                if (10 <= s && s <= 22) for (var n in i[1]) {
                    if (i[1][n].split(":")[0] == s) {
                        d = 30 < c ? parseInt(n) + 2 : parseInt(n) + 1;
                        break;
                    }
                }
                var l = [ 0, d ];
                p.setData({
                    multiArray: i,
                    orderid: u.id,
                    multiIndex: l
                });
            }
        }), wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
        var t = u.id;
        p = this;
        app.util.request({
            url: "entry/wxapp/Ordercheck",
            method: "GET",
            data: {
                id: t
            },
            success: function(t) {
                var a = t.data.goods.shopprice, e = a, i = t.data.goods, o = void 0, n = p.data.index;
                o = 0 < parseInt(i.startbuy) ? 1 < n ? n : parseInt(i.startbuy) : n, p.setData({
                    order: i,
                    totalprice: a,
                    currprice: e,
                    shopprice: t.data.goods.shopprice,
                    index: o
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        this.conutt();
    },
    getUrl: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/url",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url", t.data), a.setData({
                    url: t.data
                });
            }
        });
    },
    conutt: function() {
        var t = wx.getStorageSync("openid"), a = wx.getStorageSync("build_id"), e = this;
        app.util.request({
            url: "entry/wxapp/CounpPay",
            cachetime: "20",
            method: "GET",
            data: {
                userid: t,
                build_id: a
            },
            success: function(t) {
                console.log(t.data), e.setData({
                    cards: t.data
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    addNum: function(t) {
        var a = this, e = t.currentTarget.dataset.index, i = parseInt(e) + 1, o = a.data.shopprice, n = a.data.order, r = parseInt(n.endbuy);
        if (0 < r && r < i) return wx.showToast({
            title: "该商品限购" + r + "份",
            icon: "none"
        }), !1;
        if (console.log(o), null != a.data.counp_index) var s = a.data.cards[a.data.counp_index].val; else s = 0;
        if (100 < i && (i = 99), s) var c = o * i - s; else c = o * i;
        var d = (o * i).toFixed(2);
        this.setData({
            index: i,
            totalprice: d,
            currprice: c
        });
    },
    reduceNum: function(t) {
        var a = this, e = t.currentTarget.dataset.index, i = parseInt(e) - 1, o = a.data.order, n = parseInt(o.startbuy);
        if (0 < n && i < n) return wx.showToast({
            title: "该商品" + n + "份起购",
            icon: "none"
        }), !1;
        var r = a.data.shopprice;
        if (null != a.data.counp_index) var s = a.data.cards[a.data.counp_index].val; else s = 0;
        i < 1 && (i = 1);
        var c = (r * i).toFixed(2);
        if (0 < s) if (a.data.cards[a.data.counp_index].vab > c) {
            this.setData({
                cardsprice: "",
                cardstu: !1,
                cid: 0,
                counp_index: void 0
            });
            var d = c;
        } else d = r * i - s; else d = r * i;
        this.setData({
            index: i,
            totalprice: c,
            currprice: d
        });
    },
    getTotalPrice: function() {
        var t = parseInt(this.data.index), a = this.data.shopprice, e = parseInt(a) * t;
        this.setData({
            totalprice: e
        });
    },
    bindMultiPickerColumnChange: function(t) {
        var a = this.data.multiIndex, e = t.detail.value;
        if (0 == a[0] && 1 == t.detail.column || 0 == t.detail.column && 0 == t.detail.value) {
            var i = new Date(), o = i.getHours(), n = i.getMinutes(), r = this.data.multiArray, s = 0;
            if (10 <= o && o <= 22) for (var c in r[1]) {
                if (r[1][c].split(":")[0] == o) {
                    e = (s = 30 < n ? parseInt(c) + 2 : parseInt(c) + 1) < e ? e : s;
                    break;
                }
            }
            if (0 == t.detail.column && 0 == t.detail.value) {
                var d = {
                    multiIndex: [ 0, e ]
                };
                return this.setData(d), !1;
            }
        }
        (d = {
            multiIndex: this.data.multiIndex
        }).multiIndex[t.detail.column] = e, this.setData(d);
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
            a.opacity(1).height(300).step(), this.setData({
                animationData: a
            }), "close" == t && this.setData({
                showModalStatus: !1
            });
        }.bind(this), 200), "open" == t && this.setData({
            showModalStatus: !0
        });
    },
    coupon: function(t) {
        var a = parseFloat(t.currentTarget.dataset.curprice), e = parseFloat(t.currentTarget.dataset.price), i = t.currentTarget.dataset.cid, o = t.currentTarget.dataset.index, n = this.data.totalprice;
        if (console.log(n), console.log(e), n < e) return wx.showToast({
            title: "购买商品需满" + e + "元才能使用该优惠券",
            icon: "none"
        }), !1;
        n = (n - a).toFixed(2), this.setData({
            cardsprice: a,
            cardstu: !0,
            currprice: n,
            cid: i,
            counp_index: o
        }), this.util("close");
    },
    formSubmit: function(t) {
        console.log(t);
        var a = "", e = "", i = !0, o = this, n = wx.getStorageSync("build_id");
        console.log(n);
        var r = o.data.payType, s = o.data.cid, c = o.data.shopprice * o.data.index;
        if (s ? c -= o.data.cards[o.data.counp_index].val : c = c, 0 == o.data.ispay) return !1;
        o.setData({
            ispay: !1
        });
        var d = t.detail.value.gid, l = t.detail.value.num, u = t.detail.value.time, p = t.detail.value.name, h = t.detail.value.tel, g = t.detail.value.count, f = t.detail.value.city, x = t.detail.value.detai, y = t.detail.value.province, m = t.detail.value.remark, w = wx.getStorageSync("openid");
        if (100 < t.detail.value.num) a = "数量不得超过100"; else if (" " == t.detail.value.time || 0 == o.data.showtime) a = "请选择服务时间"; else if ("" == t.detail.value.name) a = "请填写地址", 
        o.setData({
            ispay: !0
        }); else if (null == this.data.payType || "" == this.data.payType) a = "请选择支付方式"; else {
            if (i = "false", console.log(l + "----" + o.data.order.startbuy), parseInt(l) < parseInt(o.data.order.startbuy) && (console.log(11111111111), 
            null != o.data.order.startbuy && "" != o.data.order.startbuy && 0 != o.data.order.startbuy)) return console.log(222222222), 
            void wx.showModal({
                title: "提示",
                content: "该商品起购为" + o.data.order.startbuy + "个!",
                showCancel: !1
            });
            if (parseInt(l) > parseInt(o.data.order.endbuy) && null != o.data.order.endbuy && "" != o.data.order.endbuy && 0 != o.data.order.endbuy) return void wx.showModal({
                title: "提示",
                content: "该商品限购" + o.data.order.endbuy + "个!",
                showCancel: !1
            });
            app.util.request({
                url: "entry/wxapp/Addorders",
                data: {
                    cid: s,
                    totalprice: c,
                    gid: d,
                    num: l,
                    time: u,
                    cityName: f,
                    detailInfo: x,
                    telNumber: h,
                    countyName: g,
                    name: p,
                    oprnid: w,
                    provinceName: y,
                    remark: m,
                    build_id: n
                },
                success: function(t) {
                    e = t.data, console.log(e), "微信" == r ? app.util.request({
                        url: "entry/wxapp/Orderarr",
                        data: {
                            price: c,
                            openid: w,
                            order_id: e,
                            type: 1
                        },
                        success: function(t) {
                            console.log(t), console.log(e);
                            var a = t.data.package;
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
                                        duration: 2e3
                                    }), app.util.request({
                                        url: "entry/wxapp/PayOrder",
                                        cachetime: "0",
                                        data: {
                                            order_id: e,
                                            build_id: n
                                        },
                                        success: function(t) {
                                            console.log(t.data), app.util.request({
                                                url: "entry/wxapp/Paysuccess",
                                                cachetime: "0",
                                                data: {
                                                    prepay_id: a,
                                                    openid: w,
                                                    order_id: e
                                                },
                                                success: function(t) {
                                                    console.log(t.data), wx.showModal({
                                                        title: "提示",
                                                        content: "订单已支付成功",
                                                        cancelText: "去首页",
                                                        confirmText: "查看订单",
                                                        confirmColor: "#41c2fc",
                                                        success: function(t) {
                                                            t.cancel ? wx.reLaunch({
                                                                url: "../index"
                                                            }) : t.confirm && wx.redirectTo({
                                                                url: "../../user/service/service"
                                                            }), o.setData({
                                                                ispay: !0
                                                            });
                                                        }
                                                    });
                                                }
                                            });
                                        }
                                    });
                                },
                                fail: function(t) {
                                    o.conutt(), o.setData({
                                        ispay: !0
                                    });
                                }
                            });
                        }
                    }) : app.util.request({
                        url: "entry/wxapp/balancePay",
                        cachetime: "0",
                        data: {
                            openid: w,
                            order_id: e,
                            build_id: n
                        },
                        success: function(t) {
                            console.log(t.data), o.setData({
                                ispay: !0
                            }), 1 == t.data.as ? wx.showModal({
                                title: "提示",
                                content: "订单已支付成功",
                                cancelText: "去首页",
                                confirmText: "查看订单",
                                confirmColor: "#41c2fc",
                                success: function(t) {
                                    t.cancel ? wx.reLaunch({
                                        url: "/wnjz_sun/pages/index/index"
                                    }) : t.confirm && wx.redirectTo({
                                        url: "../../user/service/service"
                                    });
                                }
                            }) : 3 == t.data.as && (wx.showToast({
                                title: "余额不足！",
                                icon: "none",
                                duration: 6e3
                            }), o.conutt());
                        }
                    });
                },
                fail: function(t) {
                    wx.showModal({
                        title: "提示",
                        content: t.data.message,
                        showCancel: !1
                    }), o.setData({
                        ispay: !0
                    });
                }
            });
        }
        1 == i && wx.showModal({
            title: "提示",
            content: a,
            showCancel: !1
        });
    },
    toAddress: function() {
        var a = this;
        console.log(a.data.totalprice), wx.chooseAddress({
            success: function(t) {
                console.log("获取地址成功"), a.getTotalPrice(), a.setData({
                    address: t,
                    hasAddress: !0,
                    totalprice: a.data.totalprice
                });
            },
            fail: function(t) {
                console.log("获取地址失败"), wx.getSetting({
                    success: function(t) {
                        t.authSetting["scope.address"] || (console.log("进入信息授权开关页面"), wx.openSetting({
                            success: function(t) {
                                console.log("openSetting success", t.authSetting);
                            }
                        }));
                    }
                });
            }
        });
    },
    radioChange: function(t) {
        var a = t.detail.value;
        console.log(a), this.setData({
            payType: a
        });
    },
    showPay: function(t) {
        var a = new Date(), e = a.getMonth() + 1 + "-" + a.getDate() + " " + a.getHours() + ":" + a.getMinutes(), i = Date.parse(new Date(e)) / 1e3;
        console.log(i);
        var o = this.data.multiIndex, n = this.data.multiArray, r = n[0][o[0]].substring(n[0][o[0]].length - 5) + " " + n[1][o[1]], s = Date.parse(new Date(r)) / 1e3;
        if (console.log(s), s < i) return wx.showModal({
            title: "提示",
            content: "时间选择错误，请重新选择",
            showCancel: !1
        }), !1;
        this.setData({
            payStatus: !this.data.payStatus
        });
    }
});