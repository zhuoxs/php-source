var wxp = require("../../sudu8_page/resource/wxParse/wxParse.js"), app = getApp();

Page({
    data: {
        imgUrls: [],
        indicatorDots: !0,
        autoplay: !0,
        interval: 5e3,
        duration: 1e3,
        a: 1,
        offer_record: [],
        my_offer: [],
        offer_price: 100,
        b: 1,
        remind: 1,
        frequency: 1,
        currentSwiper: 0
    },
    onLoad: function(e) {
        var a = app.util.url("entry/wxapp/BaseMin", {
            m: "sudu8_page"
        }), i = this;
        wx.request({
            url: a,
            data: {
                vs1: 1
            },
            cachetime: "30",
            success: function(a) {
                a.data.data;
                i.setData({
                    baseinfo: a.data.data
                }), wx.setNavigationBarColor({
                    frontColor: i.data.baseinfo.base_tcolor,
                    backgroundColor: i.data.baseinfo.base_color
                });
                var t = e.id;
                i.setData({
                    id: t
                }), app.util.getUserInfo(i.getinfos, 0);
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        this.getthispagedata(), wx.stopPullDownRefresh();
    },
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    changeTap: function(a) {
        var t = a.currentTarget.dataset.id;
        this.setData({
            a: t
        });
    },
    min: function(a) {
        var t = this.data.offer_price;
        t -= parseFloat(this.data.pdata.rules);
        var e = this.data.frequency - 1;
        0 < e && this.setData({
            offer_price: parseFloat(t.toPrecision(10)),
            frequency: e
        });
    },
    add: function(a) {
        var t = this.data.offer_price, e = parseFloat(this.data.pdata.rules), i = this.data.frequency + 1;
        t = 1 * t + 1 * e, this.setData({
            offer_price: parseFloat(t.toPrecision(10)),
            frequency: i
        });
    },
    pagetogoodslistpage: function(a) {
        clearInterval(this.data.timeapu), wx.redirectTo({
            url: "/sudu8_page/index/index"
        });
    },
    getthispagedata: function() {
        wx.stopPullDownRefresh();
        var r = this, a = this.data.id;
        r.data.openid;
        app.util.request({
            url: "entry/wxapp/auctionpage",
            data: {
                vs1: 1,
                id: a,
                openid: r.data.openid
            },
            success: function(a) {
                var t = a.data.data.pdata[0];
                wx.setStorageSync("max_money");
                var e = parseFloat(t.max_cost), i = parseFloat(t.rules), s = wx.getStorageSync("max_info");
                if (e == parseFloat(s[0]) || t.max_user == s[1]) t.username = s[2]; else {
                    var n = new Array();
                    n[0] = e, n[1] = t.max_user, n[2] = t.username, wx.setStorageSync("max_info", n);
                }
                var d = a.data.data.re;
                if (r.setData({
                    pdata: t,
                    offer_price: parseFloat((e + i * r.data.frequency).toPrecision(10)),
                    imgUrls: t.imglist,
                    remind: d
                }), wx.setNavigationBarTitle({
                    title: "详情页"
                }), 2 == r.data.b) {
                    var o = r.data.pdata;
                    o.time_end = o.time_begin, r.setData({
                        pdata: o
                    });
                }
                4 != r.data.b && r.timeapu(), wxp.wxParse("pagedata", "html", t.introduce, r, 0);
            },
            fail: function(a) {}
        });
    },
    offerprice: function(e) {
        this.data.offer_price;
        var i = this, a = i.data.openid, t = e.currentTarget.id, s = i.data.offer_price, n = i.data.pdata.bond;
        app.util.request({
            url: "entry/wxapp/auctionorderpay",
            data: {
                openid: a,
                price: s,
                deposit: n,
                types: "auction",
                goodsid: t,
                formId: e.detail.formId
            },
            header: {
                "content-type": "application/json"
            },
            success: function(a) {
                if (0 == a.data.errno) {
                    1 == a.data.data.errno && wx.showModal({
                        title: "提示",
                        content: a.data.message,
                        success: function(a) {
                            a.confirm ? i.todespay(e, "readytopay") : a.cancel && wx.showToast({
                                title: "已取消"
                            });
                        }
                    }), "nopay" == a.data.message && (wx.showToast({
                        title: "出价成功!",
                        duration: 1500
                    }), setTimeout(function() {
                        i.getthispagedata();
                    }, 1500)), "nonono" == a.data.message && (wx.showToast({
                        title: "出价低于最高值!",
                        duration: 1500
                    }), setTimeout(function() {
                        i.getthispagedata();
                    }, 1500)), "purse" == a.data.message && wx.showToast({
                        title: "从余额扣除保证金成功，点击出价继续"
                    });
                    -1 != [ 1, 2, 3, 4 ].indexOf(a.data.data.err) && wx.showModal({
                        title: "支付失败",
                        content: a.data.data.message,
                        showCancel: !1
                    });
                    var t = a.data.data.order_id;
                    0 == a.data.data.err && (app.util.request({
                        url: "entry/wxapp/savePrepayid",
                        data: {
                            types: "auction",
                            order_id: t,
                            prepayid: a.data.data.package
                        },
                        success: function(a) {}
                    }), wx.requestPayment({
                        timeStamp: a.data.data.timeStamp,
                        nonceStr: a.data.data.nonceStr,
                        package: a.data.data.package,
                        signType: "MD5",
                        paySign: a.data.data.paySign,
                        success: function(a) {
                            wx.showToast({
                                title: "支付成功",
                                icon: "success",
                                duration: 3e3,
                                success: function(a) {
                                    var t = this.data.id;
                                    app.util.request({
                                        url: "entry/wxapp/paydesok",
                                        data: {
                                            vs1: 1,
                                            goodsid: t
                                        },
                                        success: function(a) {
                                            wx.showToast({
                                                title: "支付成功！"
                                            });
                                        },
                                        fail: function(a) {}
                                    });
                                }
                            });
                        },
                        fail: function(a) {
                            wx.showToast({
                                title: "取消支付"
                            });
                        },
                        complete: function(a) {}
                    }));
                }
            }
        });
    },
    looklog: function(a) {
        var t = this, e = a.currentTarget.dataset.id;
        this.setData({
            a: e
        });
        var i = this.data.id;
        app.util.request({
            url: "entry/wxapp/auctionlog",
            data: {
                vs1: 1,
                goodsid: i
            },
            success: function(a) {
                a.data.data, t.setData({
                    offer_record: a.data.data
                });
            },
            fail: function(a) {}
        });
    },
    mylog: function(a) {
        var t = this, e = a.currentTarget.dataset.id, i = t.data.openid;
        this.setData({
            a: e
        });
        var s = this.data.id;
        app.util.request({
            url: "entry/wxapp/auctionlog",
            data: {
                vs1: 1,
                goodsid: s,
                openid: i
            },
            success: function(a) {
                a.data.data, t.setData({
                    my_offer: a.data.data
                });
            },
            fail: function(a) {}
        });
    },
    timeapu: function() {
        var a = this;
        clearInterval(this.data.timeapu), a.timeapu_fast();
        var t = setInterval(function() {
            a.timeapu_fast();
        }, 1e3);
        this.setData({
            timeapu: t
        });
    },
    timeapu_fast: function() {
        var a = this, t = this.data.pdata, e = a.data.pdata.time_end, i = e % 60, s = (e - i) % 3600 / 60, n = (e - i - 60 * s) % 86400 / 3600, d = (e - i - 60 * s - 3600 * n) / 86400;
        t.time_end -= 1, t.time_end < 1 && (clearInterval(a.data.timeapu), 1 == a.data.b ? a.itsfinish() : wx.navigateBack({
            delta: 1
        })), t.timetostr = d + "天" + n + ":" + s + ":" + i, t.end_day = d, 10 <= n ? (t.end_h1 = parseInt(n / 10), 
        t.end_h2 = n % 10) : (t.end_h1 = 0, t.end_h2 = n), 10 <= s ? (t.end_m1 = parseInt(s / 10), 
        t.end_m2 = s % 10) : (t.end_m1 = 0, t.end_m2 = s), 10 <= i ? (t.end_s1 = parseInt(i / 10), 
        t.end_s2 = i % 10) : (t.end_s1 = 0, t.end_s2 = i), a.setData({
            pdata: t
        });
    },
    itsfinish: function() {
        var t = this, a = this.data.id;
        app.util.request({
            url: "entry/wxapp/auctionthisok",
            data: {
                vs1: 1,
                goodsid: a
            },
            success: function(a) {
                t.pagetogoodslistpage();
            },
            fail: function(a) {}
        });
    },
    getformid: function(a) {
        var t = this, e = a.detail.formId, i = this.data.openid, s = this.data.pdata.id;
        app.util.request({
            url: "entry/wxapp/guagua",
            data: {
                cc: "set",
                gid: s,
                openid: i,
                formid: e
            },
            success: function(a) {
                "ok" == a.data.message && (t.setData({
                    remind: 1
                }), wx.showToast({
                    title: "设置成功"
                }));
            },
            fail: function(a) {}
        });
    },
    ungetformid: function() {
        var t = this, a = t.data.openid, e = t.data.pdata.id;
        app.util.request({
            url: "entry/wxapp/guagua",
            data: {
                cc: "del",
                gid: e,
                openid: a
            },
            success: function(a) {
                "ok" == a.data.message && (t.setData({
                    remind: 0
                }), wx.showToast({
                    title: "取消成功！"
                }));
            },
            fail: function(a) {}
        });
    },
    todespay: function(s, a) {
        this.data.offer_price;
        var n = this, t = n.data.openid, e = s.detail.formId, i = s.currentTarget.id, d = n.data.offer_price, o = n.data.pdata.bond;
        app.util.request({
            url: "entry/wxapp/auctionorderpay",
            data: {
                openid: t,
                price: d,
                deposit: o,
                types: "auction",
                goodsid: i,
                formId: e,
                cc: a
            },
            header: {
                "content-type": "application/json"
            },
            success: function(a) {
                "ok" == a.data.message && wx.showToast({
                    title: "完成，请尽情出价吧！"
                });
                -1 != [ 1, 2, 3, 4 ].indexOf(a.data.data.err) && wx.showModal({
                    title: "支付失败",
                    content: a.data.data.message,
                    showCancel: !1
                });
                var t = a.data.data.order_id;
                if (0 == a.data.data.err) {
                    var i = a.data.data.money_wx;
                    app.util.request({
                        url: "entry/wxapp/savePrepayid",
                        data: {
                            types: "auction",
                            order_id: t,
                            prepayid: a.data.data.package,
                            formid: s.detail.formid
                        },
                        success: function(a) {}
                    }), wx.requestPayment({
                        timeStamp: a.data.data.timeStamp,
                        nonceStr: a.data.data.nonceStr,
                        package: a.data.data.package,
                        signType: "MD5",
                        paySign: a.data.data.paySign,
                        success: function(a) {
                            wx.showToast({
                                title: "支付成功"
                            });
                            var t = n.data.openid, e = s.currentTarget.id;
                            app.util.request({
                                url: "entry/wxapp/paydesok",
                                data: {
                                    vs1: 1,
                                    gid: e,
                                    money: i,
                                    openid: t
                                },
                                success: function(a) {
                                    wx.showToast({
                                        title: "成功支付"
                                    });
                                },
                                fail: function(a) {}
                            });
                        },
                        fail: function(a) {
                            app.util.request({
                                url: "entry/wxapp/paydesbad",
                                data: {
                                    vs1: 1
                                },
                                success: function(a) {
                                    wx.showToast({
                                        title: "取消支付"
                                    });
                                },
                                fail: function(a) {}
                            });
                        },
                        complete: function(a) {}
                    });
                }
            }
        });
    },
    getinfos: function() {
        var t = this;
        wx.getStorage({
            key: "openid",
            success: function(a) {
                t.setData({
                    openid: a.data
                });
                t.data.id;
                t.getstatbygoodsid(t.data.id);
            }
        });
    },
    getstatbygoodsid: function(a) {
        var i = this;
        app.util.request({
            url: "entry/wxapp/getstatbyid",
            data: {
                vs1: 1,
                id: a
            },
            success: function(a) {
                var t = a.data.data.stat, e = 4;
                e = 1 == t ? 2 : 2 == t ? 1 : 4, i.setData({
                    b: e
                }), i.getthispagedata();
            },
            fail: function(a) {}
        });
    },
    swiperChange: function(a) {
        this.setData({
            currentSwiper: a.detail.current
        });
    }
});