var app = getApp(), WxParse = require("../../wxParse/wxParse.js");

Page({
    data: {
        status: !1,
        product: [],
        total: 0
    },
    onLoad: function(t) {
        var a = this;
        a.getTotal(), app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            success: function(t) {
                wx.setStorageSync("url", t.data), a.setData({
                    url: t.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/GetMbmessage",
            cachetime: 0,
            success: function(t) {
                a.setData({
                    is_open: t.data.is_open,
                    mb3: t.data.mb3
                });
            }
        });
        var e = wx.getStorageSync("mealCar");
        a.setData({
            product: e
        });
    },
    getTotal: function() {
        for (var t = this.data.product, a = 0, e = 0; e < t.length; e++) {
            if (1 == t[e].status) a += Number(t[e].price);
        }
        this.setData({
            total: a
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    goYesOrder: function(t) {
        for (var i = this, a = i.data.product, u = t.detail.formId, d = [], l = wx.getStorageSync("mealCar"), e = 0; e < a.length; e++) 1 == a[e].status && d.push(a[e]);
        console.log(d), 0 == d.length ? wx.showToast({
            title: "请选择你想买的商品！！！",
            icon: "none",
            duration: 2e3
        }) : wx.getStorage({
            key: "openid",
            success: function(t) {
                var a = t.data, c = i.data.total;
                app.util.request({
                    url: "entry/wxapp/Orderarr",
                    cachetime: "30",
                    data: {
                        price: c,
                        openid: a
                    },
                    success: function(t) {
                        var r = wx.getStorageSync("users").id;
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
                                });
                                for (var a = 0; a < d.length; a++) {
                                    var e = d[a].Id - 1;
                                    app.util.request({
                                        url: "entry/wxapp/addMealCar",
                                        cachetime: "0",
                                        data: {
                                            uid: r,
                                            mid: d[a].mid
                                        },
                                        success: function(t) {
                                            l.splice(e, 1), wx.setStorageSync("mealCar", l), i.setData({
                                                product: l
                                            });
                                        }
                                    });
                                }
                                if (2 == i.data.is_open) {
                                    var s = wx.getStorageSync("access_token"), o = Date.parse(new Date());
                                    o /= 1e3, o = util.formatTimeTwo(o, "Y/M/D h:m:s");
                                    var n = {
                                        access_token: s,
                                        touser: wx.getStorageSync("users").openid,
                                        template_id: i.data.mb3,
                                        page: "byjs_sun/pages/product/index/index",
                                        form_id: u,
                                        value1: "购物车结算！",
                                        color1: "#4a4a4a",
                                        value2: o,
                                        color2: "#9b9b9b",
                                        value3: c,
                                        color3: "#9b9b9b"
                                    };
                                    app.util.request({
                                        url: "entry/wxapp/Send",
                                        data: n,
                                        method: "POST",
                                        success: function(t) {},
                                        fail: function(t) {
                                            console.log("push err"), console.log(t);
                                        }
                                    });
                                }
                                setTimeout;
                            },
                            fail: function(t) {
                                wx.showToast({
                                    title: "支付失败",
                                    icon: "success",
                                    duration: 2e3
                                });
                            }
                        }), console.log("-----直接购买=------");
                    }
                });
            }
        });
    },
    check: function(t) {
        var a = this, e = (a.data.total, t.currentTarget.dataset.index), s = JSON.parse(JSON.stringify(this.data.product));
        console.log(a.data.product), !0 === s[e].status ? s[e].status = !1 : s[e].status = !0, 
        this.setData({
            product: s
        }), this.getTotal(), console.log(a.data.product);
        for (var o = 0, n = s.length; o < n; ) {
            if (!0 !== s[o].status) return this.setData({
                status: !1
            }), !1;
            o++;
        }
        this.setData({
            status: !0
        });
    },
    allCheck: function() {
        var t = this.data.status, a = JSON.parse(JSON.stringify(this.data.product));
        if (!0 === t) {
            for (var e in a) a[e].status = !1;
            this.setData({
                product: a,
                status: !1
            }), this.getTotal();
        } else {
            for (var s in a) a[s].status = !0;
            this.setData({
                product: a,
                status: !0
            }), this.getTotal();
        }
    },
    gotobuy: function(t) {
        wx.switchTab({
            url: "/byjs_sun/pages/charge/chargeIndex/chargeIndex"
        });
    },
    clear: function(t) {
        for (var a, e = this, s = t.currentTarget.dataset.index, o = e.data.product, n = wx.getStorageSync("mealCar"), r = 0; r < n.length; r++) n[r].Id, 
        o[s].Id, a = r;
        wx.showModal({
            title: "提示",
            content: "是否删除?",
            success: function(t) {
                t.confirm && (o.splice(s, 1), n.splice(a, 1), wx.setStorageSync("mealCar", n), e.setData({
                    product: o
                }));
            }
        });
    }
});