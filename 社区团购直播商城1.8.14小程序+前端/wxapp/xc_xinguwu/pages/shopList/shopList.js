var app = getApp();

Page({
    data: {
        page: 1,
        pagesize: 20,
        loadend: !1,
        user: null,
        list: null,
        shop: null,
        address: null,
        paytype: 1,
        disabled: !1
    },
    close: function() {
        this.setData({
            show: !1
        });
    },
    changePaytype: function(a) {
        console.log(a), this.setData({
            paytype: a.currentTarget.dataset.val
        });
    },
    change: function(a) {
        var t = a.currentTarget.dataset.index, l = this.data.shop[t], d = this.data.address, c = this.data.express, f = this;
        Number(l.integral) > Number(this.data.user.integral) ? f.setData({
            disabled: !0
        }) : f.setData({
            disabled: !1
        });
        f = this;
        this.setData({
            list: l,
            show: !0
        });
        -1 == l.bag && (null != c ? function() {
            if (null != d) {
                var o = d.region;
                o = o.split(" ");
                var p = !0;
                if ("" != c.notarea && p) {
                    var a = c.notarea;
                    for (var t in a) {
                        if (!p) return;
                        o[0] == t && a[t].forEach(function(a, t) {
                            if (a === o[1]) return f.setData({
                                isexpress: !1
                            }), void (p = !1);
                        });
                    }
                }
                if (p && c.setting && c.setting.forEach(function(d, a) {
                    if (p && "" != d.citys) {
                        var t = d.citys;
                        for (var e in t) {
                            if (!p) return;
                            e === o[0] && t[e].forEach(function(a, t) {
                                if (a !== o[1]) ; else {
                                    var e = c.calculatetype, s = d.value;
                                    if ("weight" == e) {
                                        for (var i = 0, r = 0; r < l.length; r++) i += l[r].num * l[r].weight;
                                        i <= s.firstweight && (u = s.firstprice), i > s.firstweight && (u = parseFloat(s.firstprice) + Math.ceil((i - s.firstweight) / s.secondweight) * s.secondprice);
                                    }
                                    if ("number" == e) {
                                        var n = 0;
                                        for (r = 0; r < l.length; r++) n += l[r].num;
                                        n <= s.firstnum && (u = s.firstnumprice), i > s.firstnum && (u = parseFloat(s.firstnumprice) + Math.ceil((n - s.firstnum) / s.secondnum) * s.secondnumprice);
                                    }
                                    p = !1;
                                }
                            });
                        }
                    }
                }), p && c.default) {
                    var e = c.default, s = c.calculatetype;
                    if ("weight" == s) {
                        for (var i = 0, r = 0; r < l.length; r++) i += l[r].num * l[r].weight;
                        var u = 0;
                        i <= e.default_firstweight && (u = parseFolat(e.default_firstprice)), i > e.default_firstweight && (u = parseFloat(e.default_firstprice) + Math.ceil((i - e.default_firstweight) / e.default_secondweight) * e.default_secondprice);
                    }
                    if ("number" == s) {
                        var n = 0;
                        for (r = 0; r < l.length; r++) n += l[r].num;
                        n <= e.default_firstnum && (u = e.default_firstnumprice), n > e.default_firstnum && (u = parseFloat(e.default_firstnumprice) + (n - e.default_firstnum) / e.default_secondnum * e.default_secondnumprice);
                    }
                }
            }
            l.postage = u, f.setData({
                list: l
            });
        }() : (l.postage = 0, f.setData({
            list: l
        }))), wx.hideLoading();
    },
    exchange: function(a) {
        var t = this.data.list, e = this.data.address, s = this.data.paytype, i = a.detail.formId;
        wx.showLoading({
            title: "提交中"
        }), app.util.request({
            url: "entry/wxapp/shop",
            showLoading: !1,
            data: {
                op: "order",
                list: t.id,
                address: e.id,
                paytype: s,
                formid: i
            },
            success: function(a) {
                wx.hideLoading();
                var t = a.data;
                t.errno || (2 != s && 3 != s || t && t.data && !a.data.errno && wx.requestPayment({
                    timeStamp: a.data.data.timeStamp,
                    nonceStr: a.data.data.nonceStr,
                    package: a.data.data.package,
                    signType: "MD5",
                    paySign: a.data.data.paySign,
                    success: function(a) {
                        app.util.message({
                            title: "支付成功",
                            redirect: "redirect:../order/order?status=2"
                        });
                    },
                    fail: function(a) {
                        console.log(a), "requestPayment:fail cancel" === a.errMsg && app.util.message({
                            title: "你有订单未支付",
                            redirect: "redirect:../order/order?status=1"
                        });
                    }
                }), 1 === s && app.util.message({
                    title: a.data.message,
                    redirect: "redirect:../order/order?status=2"
                }));
            }
        });
    },
    onLoad: function(a) {
        var e = this;
        app.util.request({
            url: "entry/wxapp/shop",
            cachetime: "30",
            showLoading: !0,
            method: "POST",
            data: {
                op: "shoplist_other"
            },
            success: function(a) {
                var t = a.data;
                t.data.user && e.setData({
                    user: t.data.user
                }), t.data.address && e.setData({
                    address: t.data.address
                }), t.data.express && e.setData({
                    express: t.data.express
                });
            }
        }), app.util.request({
            url: "entry/wxapp/shop",
            cachetime: "30",
            showLoading: !0,
            method: "POST",
            data: {
                op: "shoplist",
                page: e.data.page,
                pagesize: e.data.pagesize
            },
            success: function(a) {
                var t = a.data;
                t.data.shop && e.setData({
                    shop: t.data.shop
                }), e.setData({
                    page: e.data.page + 1
                });
            },
            fail: function() {
                e.setData({
                    loadend: !0
                });
            }
        });
    },
    onReady: function() {
        app.look.navbar(this);
    },
    onShow: function() {
        var a = app.address;
        null != a && this.setData({
            address: a
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/shop",
            showLoading: !0,
            method: "POST",
            data: {
                op: "shoplist",
                page: 1,
                pagesize: e.data.pagesize
            },
            success: function(a) {
                wx.stopPullDownRefresh();
                var t = a.data;
                t.data.shop && e.setData({
                    shop: t.data.shop
                }), e.setData({
                    page: 2
                });
            },
            fail: function() {
                e.setData({
                    loadend: !0
                });
            }
        });
    },
    onReachBottom: function() {
        if (console.log(this.data.loadend), !this.data.loadend) {
            var e = this;
            app.util.request({
                url: "entry/wxapp/shop",
                cachetime: "30",
                showLoading: !0,
                method: "POST",
                data: {
                    op: "shoplist",
                    page: e.data.page,
                    pagesize: e.data.pagesize
                },
                success: function(a) {
                    wx.stopPullDownRefresh();
                    var t = a.data;
                    t.data.shop && e.setData({
                        shop: e.data.shop.concat(t.data.shop)
                    }), e.setData({
                        page: e.data.page + 1
                    });
                },
                fail: function() {
                    e.setData({
                        loadend: !0
                    });
                }
            });
        }
    }
});