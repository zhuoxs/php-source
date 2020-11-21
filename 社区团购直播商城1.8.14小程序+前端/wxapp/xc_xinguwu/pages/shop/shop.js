var app = getApp();

Page({
    data: {
        user: null,
        hot: null,
        recommend: null,
        list: null,
        address: null,
        show: !1,
        express: null,
        paytype: 1,
        formid: []
    },
    onLoad: function() {
        var e = this;
        this.setData({
            user: app.globalData.userInfo,
            webset: app.globalData.webset
        }), app.util.request({
            url: "entry/wxapp/shop",
            cachetime: "30",
            showLoading: !0,
            data: {
                op: "shop"
            },
            success: function(a) {
                var t = a.data;
                t.data.ppt && e.setData({
                    ppt: t.data.ppt
                }), t.data.hot && e.setData({
                    hot: t.data.hot
                }), t.data.recommend && e.setData({
                    recommend: t.data.recommend
                });
            }
        });
    },
    close: function() {
        this.setData({
            show: !1
        });
    },
    change: function(a) {
        var n = this;
        wx.showLoading({
            title: "获取中"
        });
        var t = a.currentTarget.dataset.index, e = a.currentTarget.dataset.na, p = this.data[e][t];
        p.num = 1;
        var l = this.data.address, c = app.globalData.express, f = 0;
        -1 == p.bag ? function() {
            if (null != l && null != c) {
                var d = l.region;
                d = d.split(" ");
                var u = !0;
                if ("" != c.notarea && u) {
                    var a = c.notarea;
                    for (var t in a) {
                        if (!u) return;
                        d[0] == t && a[t].forEach(function(a, t) {
                            if (a === d[1]) return n.setData({
                                isexpress: !1
                            }), void (u = !1);
                        });
                    }
                }
                if (u && c.setting && c.setting.forEach(function(n, a) {
                    if (u && "" != n.citys) {
                        var t = n.citys;
                        for (var e in t) {
                            if (!u) return;
                            e === d[0] && t[e].forEach(function(a, t) {
                                if (a !== d[1]) ; else {
                                    var e = c.calculatetype, s = n.value;
                                    if ("weight" == e) {
                                        for (var r = 0, i = 0; i < p.length; i++) r += p[i].num * p[i].weight;
                                        r <= s.firstweight && (f = s.firstprice), r > s.firstweight && (f = parseFloat(s.firstprice) + Math.ceil((r - s.firstweight) / s.secondweight) * s.secondprice);
                                    }
                                    if ("number" == e) {
                                        var o = 0;
                                        for (i = 0; i < p.length; i++) o += p[i].num;
                                        o <= s.firstnum && (f = s.firstnumprice), r > s.firstnum && (f = parseFloat(s.firstnumprice) + Math.ceil((o - s.firstnum) / s.secondnum) * s.secondnumprice);
                                    }
                                    u = !1;
                                }
                            });
                        }
                    }
                }), u && c.default) {
                    var e = c.default, s = c.calculatetype;
                    if ("weight" == s) {
                        for (var r = 0, i = 0; i < p.length; i++) r += p[i].num * p[i].weight;
                        r <= e.default_firstweight && (f = parseFolat(e.default_firstprice)), r > e.default_firstweight && (f = parseFloat(e.default_firstprice) + Math.ceil((r - e.default_firstweight) / e.default_secondweight) * e.default_secondprice);
                    }
                    if ("number" == s) {
                        var o = 0;
                        for (i = 0; i < p.length; i++) o += p[i].num;
                        o <= e.default_firstnum && (f = e.default_firstnumprice), o > e.default_firstnum && (f = parseFloat(e.default_firstnumprice) + (o - e.default_firstnum) / e.default_secondnum * e.default_secondnumprice);
                    }
                }
            }
            p.express = f, console.log(p), n.setData({
                list: p,
                show: !0
            });
        }() : this.setData({
            list: p,
            show: !0
        }), parseFloat(p.price) + parseFloat(p.express) > app.globalData.userInfo.amount && n.setData({
            paytype: 2
        }), wx.hideLoading();
    },
    exchange: function(a) {
        var t = this.data.formid;
        if (1 != a.detail.target.dataset.sumit) return t.push(a.detail.formId), void this.setData({
            formid: t
        });
        t.push(a.detail.formId);
        var s = this.data.list, e = this.data.address, r = a.detail.value.paytype;
        1 == r && parseFloat(s.express) + parseFloat(s.price) > app.globalData.userInfo.amount && (r = 3), 
        wx.showLoading({
            title: "提交中"
        }), app.util.request({
            url: "entry/wxapp/shop",
            showLoading: !1,
            data: {
                op: "order",
                list: s.id,
                address: e.id,
                paytype: r,
                formid: t
            },
            success: function(a) {
                var t = a.data;
                if (console.log(a), 0 < s.express || 0 < s.price) {
                    if (2 == r || 3 == r) {
                        var e = t.data.tid;
                        t && t.data && !a.data.errno && wx.requestPayment({
                            timeStamp: a.data.data.timeStamp,
                            nonceStr: a.data.data.nonceStr,
                            package: a.data.data.package,
                            signType: "MD5",
                            paySign: a.data.data.paySign,
                            success: function(a) {
                                wx.hideLoading();
                                setTimeout(function() {
                                    !function a(t) {
                                        app.util.request({
                                            url: "entry/wxapp/payquery",
                                            showLoading: !1,
                                            data: {
                                                tid: t
                                            },
                                            success: function(a) {
                                                app.globalData.userInfo = a.data.data, app.util.message({
                                                    title: "支付成功",
                                                    redirect: "redirect:../order/order?status=2"
                                                });
                                            },
                                            fail: function() {
                                                setTimeout(function() {
                                                    a(t);
                                                }, 1e3);
                                            }
                                        });
                                    }(e);
                                }, 500);
                            },
                            fail: function(a) {
                                console.log(a), "requestPayment:fail cancel" === a.errMsg && app.util.message({
                                    title: "你有订单未支付",
                                    redirect: "redirect:../order/order?status=1"
                                });
                            }
                        });
                    }
                    1 != r && 4 != r || (a.data.data && (app.globalData.userInfo = a.data.data), app.util.message({
                        title: a.data.message,
                        redirect: "redirect:../order/order?status=2"
                    }));
                } else a.data.data && (app.globalData.userInfo = a.data.data), app.util.message({
                    title: a.data.message,
                    redirect: "redirect:../order/order?status=2"
                });
            }
        });
    },
    onReady: function() {
        app.look.footer(this), app.look.navbar(this);
    },
    onShow: function() {
        var t = this;
        null != app.address ? this.setData({
            address: app.address
        }) : app.util.request({
            url: "entry/wxapp/goods",
            cachetime: "30",
            showLoading: !1,
            data: {
                op: "get_default_address"
            },
            success: function(a) {
                a.data.data.address && t.setData({
                    address: a.data.data.address
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/shop",
            cachetime: "30",
            showLoading: !0,
            data: {
                op: "shop"
            },
            success: function(a) {
                wx.stopPullDownRefresh();
                var t = a.data;
                t.data.user && e.setData({
                    user: t.data.user
                }), t.data.ppt && e.setData({
                    ppt: t.data.ppt
                }), t.data.hot && e.setData({
                    hot: t.data.hot
                }), t.data.recommend && e.setData({
                    recommend: t.data.recommend
                });
            }
        });
    },
    onReachBottom: function() {},
    onGotUserInfo: function(a) {
        app.look.getuserinfo(a, this);
    }
});