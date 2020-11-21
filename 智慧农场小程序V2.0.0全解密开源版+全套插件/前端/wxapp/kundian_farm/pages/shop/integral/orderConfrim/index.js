var e = new getApp(), a = e.siteInfo.uniacid;

Page({
    data: {
        borderImg: "../../../../images/icon/address-line.png",
        address: "",
        phone: "",
        userName: "",
        goodsData: [],
        specItem: [],
        specVal: [],
        default: !1,
        count: "",
        totalPrice: [],
        cartData: [],
        is_buy_type: 1,
        goods_id: "",
        cart_id: "",
        spec_id: "",
        send_price: 0,
        farmSetData: []
    },
    onLoad: function(t) {
        var d = t.goodsid;
        if (t.spec_id) s = t.spec_id; else var s = 0;
        t.cart_id;
        var i = t.count, o = wx.getStorageSync("kundian_farm_uid"), r = this;
        e.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "integral",
                op: "getSureGoods",
                uniacid: a,
                goods_id: d,
                spec_id: s,
                count: i,
                uid: o
            },
            success: function(e) {
                var a = e.data, t = a.specVal, o = a.specItem, n = a.goodsData, c = a.totalPrice, u = a.send_price, l = a.address;
                t || (t = []);
                var p = "";
                l && (p = l.region + " " + l.address), r.setData({
                    specItem: o,
                    goodsData: n,
                    count: i,
                    specVal: t,
                    totalPrice: c,
                    goods_id: d,
                    spec_id: s,
                    send_price: u,
                    address: p,
                    userName: l.name || "",
                    phone: l.phone || ""
                });
            }
        }), e.util.setNavColor(a), r.setData({
            farmSetData: wx.getStorageSync("kundian_farm_setData")
        });
    },
    chooseAddress: function(e) {
        wx.navigateTo({
            url: "/kundian_farm/pages/user/address/index?is_select=true"
        });
    },
    onShow: function(e) {
        var a = wx.getStorageSync("kundian_farm_uid"), t = wx.getStorageSync("selectAdd_" + a);
        t && (this.setData({
            address: t.region + " " + t.address,
            userName: t.name,
            phone: t.phone
        }), wx.removeStorageSync("selectAdd_" + a));
    },
    formSubmit: function(t) {
        var d = this.data, s = d.userName, i = d.address, o = d.phone, r = (d.is_buy_type, 
        d.remark), n = d.goods_id, c = d.count, u = d.spec_id, l = d.send_price, p = wx.getStorageSync("kundian_farm_uid");
        if ("" != i && "" != o && "" != s) {
            var g = {
                control: "integral",
                op: "addOrder",
                address: i,
                name: s,
                phone: o,
                uniacid: a,
                goods_id: n,
                count: c,
                uid: p,
                remark: r,
                is_buy_type: 1,
                spec_id: u
            };
            e.util.request({
                url: "entry/wxapp/class",
                data: g,
                success: function(t) {
                    if (1 == t.data.code) {
                        var d = t.data.order_id;
                        "" == l || 0 == l ? (wx.showLoading({
                            title: "加载中..."
                        }), e.util.request({
                            url: "entry/wxapp/class",
                            data: {
                                control: "integral",
                                op: "sendMsg",
                                order_id: d,
                                uniacid: a,
                                uid: p
                            },
                            success: function(e) {
                                0 == e.data.code && wx.showModal({
                                    title: "提示",
                                    content: "兑换成功",
                                    showCancel: !1,
                                    success: function() {
                                        wx.redirectTo({
                                            url: "../orderList/index"
                                        });
                                    }
                                }), wx.hideLoading();
                            }
                        })) : e.util.request({
                            url: "entry/wxapp/pay",
                            data: {
                                op: "getIntegralPayOrder",
                                orderid: d,
                                uniacid: a,
                                file: "integral"
                            },
                            cachetime: "0",
                            success: function(t) {
                                if (t.data && t.data.data && !t.data.errno) {
                                    var s = t.data.data.package;
                                    wx.requestPayment({
                                        timeStamp: t.data.data.timeStamp,
                                        nonceStr: t.data.data.nonceStr,
                                        package: t.data.data.package,
                                        signType: "MD5",
                                        paySign: t.data.data.paySign,
                                        success: function(t) {
                                            wx.showLoading({
                                                title: "加载中"
                                            }), e.util.request({
                                                url: "entry/wxapp/class",
                                                data: {
                                                    control: "integral",
                                                    op: "sendMsg",
                                                    order_id: d,
                                                    uniacid: a,
                                                    prepay_id: s,
                                                    uid: p
                                                },
                                                success: function(e) {
                                                    wx.showModal({
                                                        title: "提示",
                                                        content: "支付成功",
                                                        showCancel: !1,
                                                        success: function() {
                                                            wx.redirectTo({
                                                                url: "../orderList/index"
                                                            });
                                                        }
                                                    }), wx.hideLoading();
                                                }
                                            });
                                        },
                                        fail: function(e) {
                                            wx.redirectTo({
                                                url: "../orderList/index"
                                            });
                                        }
                                    });
                                } else wx.redirectTo({
                                    url: "../orderList/index"
                                });
                            },
                            fail: function(e) {
                                wx.showModal({
                                    title: "系统提示",
                                    content: e.data.message ? e.data.message : "错误",
                                    showCancel: !1,
                                    success: function(e) {
                                        e.confirm && wx.redirectTo({
                                            url: "../orderList/index"
                                        });
                                    }
                                });
                            }
                        });
                    } else 2 == t.data.code ? wx.showToast({
                        title: "兑换失败"
                    }) : 3 == t.data.code ? wx.showToast({
                        title: "积分不足"
                    }) : 4 == t.data.code && wx.showToast({
                        title: "积分支付失败"
                    });
                }
            });
        } else wx.showToast({
            title: "请选择收货地址!"
        });
    }
});