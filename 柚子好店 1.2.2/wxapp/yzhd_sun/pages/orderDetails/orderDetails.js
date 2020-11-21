var app = getApp();

Page({
    data: {
        yhqMoney: "0.00",
        wangwang: !0
    },
    onLoad: function(t) {
        var n = this;
        console.log("参数数据传值"), console.log(t);
        var a = wx.getStorageSync("openid");
        console.log(a);
        var o = wx.getStorageSync("shopcart");
        if (console.log(o), wx.getStorage({
            key: "url",
            success: function(a) {
                n.setData({
                    url: a.data,
                    buyType: t.buyType,
                    shopcart: o,
                    name: t.name,
                    tel: t.tel
                });
            }
        }), o) {
            var e = o.allprice - 0;
            n.setData({
                amountMoney: e,
                yfMoney: e
            });
        } else app.util.request({
            url: "entry/wxapp/IsVip",
            cachetime: "0",
            data: {
                openid: a
            },
            success: function(a) {
                console.log(a), n.setData({
                    isVip: a.data
                }), app.util.request({
                    url: "entry/wxapp/GetGoodsDetail",
                    cachetime: "0",
                    data: {
                        gid: t.gid,
                        buyType: t.buyType
                    },
                    success: function(a) {
                        if (console.log(a), n.setData({
                            goodsInfo: a.data.data,
                            num: t.num,
                            totalPrice: t.totalPrice
                        }), 2 == n.data.isVip) {
                            var o = n.data.goodsInfo.current_price * n.data.num;
                            n.setData({
                                amountMoney: o,
                                yfMoney: o
                            });
                        }
                        if (2 != n.data.isVip) {
                            o = n.data.goodsInfo.fans_price * n.data.num;
                            n.setData({
                                amountMoney: o,
                                yfMoney: o
                            });
                        }
                    }
                });
            }
        });
        n.diyWinColor();
    },
    goSelCoupons: function(a) {
        var o = this, t = o.data.shopcart;
        if (t) {
            var n = t.allprice - 0;
            o.setData({
                amountMoney: n,
                yfMoney: n
            }), wx.navigateTo({
                url: "../couponsList/couponsList?bid=" + t.info[0].bid + "&&gid=" + t.info[0].caipin_id + "&&price=" + o.data.amountMoney
            });
        } else {
            if (2 == o.data.isVip) {
                n = o.data.goodsInfo.current_price * o.data.num;
                o.setData({
                    amountMoney: n,
                    yfMoney: n
                });
            }
            if (2 != o.data.isVip) {
                n = o.data.goodsInfo.fans_price * o.data.num;
                o.setData({
                    amountMoney: n,
                    yfMoney: n
                });
            }
            wx.navigateTo({
                url: "../couponsList/couponsList?bid=" + o.data.goodsInfo.branch_id + "&&gid=" + o.data.goodsInfo.id + "&&price=" + o.data.yfMoney
            });
        }
    },
    payNowTap: function(a) {
        var e = this, i = wx.getStorageSync("openid"), o = e.data.wangwang;
        if (console.log(e.data.amountMoney), console.log(i), console.log(e.data.yhqid), 
        e.data.yhqid) var s = e.data.yhqid; else s = 0;
        var c = e.data.shopcart;
        if (console.log(c.info), c) {
            for (var d = "", r = "", l = "", u = "", t = "", n = 0; n < c.info.length; n++) d += c.info[n].caipin_id + ",", 
            r = c.info[n].bid, l += c.info[n].img + ",", u += c.info[n].gname + ",", t += c.info[n].number + ",";
            console.log(t);
            c = 1;
            var y = t, g = 4;
        } else g = e.data.buyType, d = e.data.goodsInfo.id, r = e.data.goodsInfo.branch_id, 
        c = 0, y = e.data.num;
        o ? (e.setData({
            wangwang: !1
        }), app.util.request({
            url: "entry/wxapp/orderarr",
            data: {
                openid: i,
                price: e.data.amountMoney
            },
            success: function(t) {
                console.log(t), console.log(s);
                var n = t.data.package;
                app.util.request({
                    url: "entry/wxapp/PayGoods",
                    cachetime: "0",
                    data: {
                        gname: u,
                        imgs: l,
                        shopcart: c,
                        openid: i,
                        gid: d,
                        name: e.data.name,
                        address: 1,
                        tel: e.data.tel,
                        goods_num: y,
                        money: e.data.amountMoney,
                        bid: r,
                        buyType: g,
                        yhqid: s
                    },
                    success: function(a) {
                        console.log(a);
                        var o = a.data;
                        wx.requestPayment({
                            timeStamp: t.data.timeStamp,
                            nonceStr: t.data.nonceStr,
                            package: t.data.package,
                            signType: "MD5",
                            paySign: t.data.paySign,
                            fail: function(a) {
                                e.setData({
                                    wangwang: !0
                                }), console.log("-----支付失败-----"), wx.showModal({
                                    title: "提示",
                                    content: "未支付，已为您加入到待支付订单中",
                                    showCancel: !1,
                                    success: function(a) {
                                        a.confirm && wx.navigateBack({});
                                    }
                                });
                            },
                            success: function(a) {
                                e.setData({
                                    wangwang: !0
                                }), console.log(a), console.log("-----支付成功-----"), app.util.request({
                                    url: "entry/wxapp/BuyMessage",
                                    cachetime: "0",
                                    data: {
                                        gname: u,
                                        prepay_id: n,
                                        openid: i,
                                        money: e.data.amountMoney,
                                        bid: r,
                                        gid: d,
                                        buyType: g
                                    },
                                    success: function(a) {
                                        console.log(a);
                                    }
                                }), app.util.request({
                                    url: "entry/wxapp/checkOrder",
                                    data: {
                                        order_id: o
                                    },
                                    success: function(a) {
                                        wx.showModal({
                                            title: "提示",
                                            content: "已支付成功，请去我的全部订单中查询~",
                                            showCancel: !1,
                                            success: function(a) {
                                                console.log(o), console.log(a), wx.redirectTo({
                                                    url: "../orderAfter/orderAfter?orderID=" + o + "&&store_id=" + r
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
        })) : wx.showToast({
            title: "请勿重复提交"
        });
    },
    onReady: function(a) {},
    onShow: function() {
        var a = this, o = wx.getStorageSync("yhqDetails");
        if ("1" == o[1]) {
            var t = (a.data.amountMoney - 0 - (o[2] - 0)).toFixed(2);
            a.setData({
                yhqMoney: o[2],
                amountMoney: t,
                yhqid: o[0]
            });
        }
        if ("2" == o[1]) {
            var n = (a.data.amountMoney - 0) * (o[3] - 0) * .01;
            console.log(n);
            t = (a.data.amountMoney - 0 - (n - 0)).toFixed(2);
            console.log(t), a.setData({
                yhqMoney: n,
                amountMoney: t,
                yhqid: o[0]
            });
        }
        wx.removeStorageSync("yhqDetails");
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    diyWinColor: function(a) {
        var o = wx.getStorageSync("system");
        wx.setNavigationBarColor({
            frontColor: o.color,
            backgroundColor: o.fontcolor,
            animation: {
                duration: 400,
                timingFunc: "easeIn"
            }
        }), wx.setNavigationBarTitle({
            title: "订单详情"
        });
    }
});