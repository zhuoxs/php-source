var a = new getApp();

Page({
    data: {
        borderImg: "../../../images/icon/address-line.png",
        buyList: [],
        adoptData: [],
        specItem: [],
        address: "",
        phone: "",
        userName: "",
        adopt_id: "",
        farmSetData: [],
        order_id: 0,
        recovery_method: 1,
        remark: ""
    },
    onLoad: function(e) {
        var t = this, n = e.adopt_id, i = a.siteInfo.uniacid, d = wx.getStorageSync("kundian_farm_setData"), o = wx.getStorageSync("kundian_farm_uid"), r = 1;
        2 == d.recovery_method && (r = 2), t.setData({
            farmSetData: d,
            recovery_method: r
        }), a.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "animal",
                op: "getSureOrder",
                uniacid: i,
                adopt_id: n,
                uid: o
            },
            success: function(a) {
                var e = a.data, i = e.address, d = e.adoptData, o = "";
                i && (o = i.region + " " + i.address), t.setData({
                    adoptData: d,
                    adopt_id: n,
                    userName: i.name,
                    phone: i.phone,
                    address: o
                });
            }
        }), a.util.setNavColor(i);
    },
    selAddress: function(a) {
        wx.navigateTo({
            url: "/kundian_farm/pages/user/address/index?is_select=true"
        });
    },
    changeRecoveryMethod: function(a) {
        var e = a.currentTarget.dataset.state, t = this.data, n = t.totalPrice, i = t.send_price, d = t.copyTotalPrice;
        n = 2 == e ? parseFloat(n - i).toFixed(2) : d, this.setData({
            recovery_method: e,
            totalPrice: n
        });
    },
    getRemark: function(a) {
        this.setData({
            remark: a.detail.value
        });
    },
    nowPay: function(e) {
        var t = this, n = wx.getStorageSync("kundian_farm_uid"), i = a.siteInfo.uniacid, d = t.data, o = d.userName, r = d.address, s = d.phone, c = d.adopt_id, l = d.recovery_method, u = d.remark, p = d.farmSetData;
        if (1 == l && ("" == r || "" == o || "" == s)) return wx.showToast({
            title: "请选择收货地址",
            icon: "none"
        }), !1;
        if (2 != l || (o = e.detail.value.name, s = e.detail.value.phone, "" != o && "" != s)) {
            var m = {
                control: "animal",
                op: "addOrder",
                address: r,
                name: o,
                phone: s,
                uniacid: i,
                adopt_id: c,
                uid: n,
                recovery_method: l,
                remark: u,
                total_price: t.data.farmSetData.animal_send_price,
                self_address: p.self_lifting_address
            }, f = t.data.order_id;
            f ? 2 == l ? wx.redirectTo({
                url: "../../shop/orderList/index"
            }) : a.util.request({
                url: "entry/wxapp/pay",
                data: {
                    file: "animal",
                    orderid: f,
                    uniacid: i,
                    op: "getAnimalSendOrder"
                },
                cachetime: "0",
                success: function(e) {
                    if (e.data && e.data.data && !e.data.errno) {
                        var t = e.data.data.package;
                        wx.requestPayment({
                            timeStamp: e.data.data.timeStamp,
                            nonceStr: e.data.data.nonceStr,
                            package: e.data.data.package,
                            signType: "MD5",
                            paySign: e.data.data.paySign,
                            success: function(e) {
                                wx.showLoading({
                                    title: "玩命加载中..."
                                }), a.util.request({
                                    url: "entry/wxapp/class",
                                    data: {
                                        control: "animal",
                                        op: "notify_send",
                                        order_id: f,
                                        uniacid: i,
                                        prepay_id: t
                                    },
                                    success: function(a) {
                                        wx.hideLoading(), wx.showModal({
                                            title: "提示",
                                            content: "支付成功",
                                            showCancel: !1,
                                            success: function() {
                                                wx.redirectTo({
                                                    url: "../../shop/orderList/index"
                                                });
                                            }
                                        });
                                    }
                                });
                            },
                            fail: function(a) {
                                wx.showModal({
                                    title: "系统提示",
                                    content: "您取消了支付!",
                                    showCancel: !1,
                                    success: function(a) {
                                        a.confirm && is_jump && wx.redirectTo({
                                            url: "../../shop/orderList/index"
                                        });
                                    }
                                });
                            }
                        });
                    } else console.log("fail1");
                },
                fail: function(a) {
                    "JSAPI支付必须传openid" == a.data.message ? wx.navigateTo({
                        url: "/kundian_farm/pages/login/index"
                    }) : wx.showModal({
                        title: "系统提示",
                        content: a.data.message ? a.data.message : "错误",
                        showCancel: !1,
                        success: function(a) {
                            a.confirm;
                        }
                    });
                }
            }) : a.util.request({
                url: "entry/wxapp/class",
                data: m,
                success: function(e) {
                    var n = e.data.order_id;
                    t.setData({
                        order_id: n
                    }), 2 == l ? wx.redirectTo({
                        url: "../../shop/orderList/index"
                    }) : a.util.request({
                        url: "entry/wxapp/pay",
                        data: {
                            file: "animal",
                            orderid: n,
                            uniacid: i,
                            op: "getAnimalSendOrder"
                        },
                        cachetime: "0",
                        success: function(e) {
                            if (e.data && e.data.data && !e.data.errno) {
                                var t = e.data.data.package;
                                wx.requestPayment({
                                    timeStamp: e.data.data.timeStamp,
                                    nonceStr: e.data.data.nonceStr,
                                    package: e.data.data.package,
                                    signType: "MD5",
                                    paySign: e.data.data.paySign,
                                    success: function(e) {
                                        wx.showLoading({
                                            title: "玩命加载中..."
                                        }), a.util.request({
                                            url: "entry/wxapp/class",
                                            data: {
                                                control: "animal",
                                                op: "notify_send",
                                                order_id: n,
                                                uniacid: i,
                                                prepay_id: t
                                            },
                                            success: function(a) {
                                                wx.hideLoading(), wx.showModal({
                                                    title: "提示",
                                                    content: "支付成功",
                                                    showCancel: !1,
                                                    success: function() {
                                                        wx.redirectTo({
                                                            url: "../../shop/orderList/index"
                                                        });
                                                    }
                                                });
                                            }
                                        });
                                    },
                                    fail: function(a) {
                                        wx.showModal({
                                            title: "系统提示",
                                            content: "您取消了支付!",
                                            showCancel: !1,
                                            success: function(a) {
                                                a.confirm && is_jump && wx.redirectTo({
                                                    url: "../../shop/orderList/index"
                                                });
                                            }
                                        });
                                    }
                                });
                            } else console.log("fail1");
                        },
                        fail: function(a) {
                            "JSAPI支付必须传openid" == a.data.message ? wx.navigateTo({
                                url: "/kundian_farm/pages/login/index"
                            }) : wx.showModal({
                                title: "系统提示",
                                content: a.data.message ? a.data.message : "错误",
                                showCancel: !1,
                                success: function(a) {
                                    a.confirm;
                                }
                            });
                        }
                    });
                }
            });
        } else wx.showToast({
            title: "请填写收获信息",
            icon: "none"
        });
    },
    gotoMerchant: function() {
        var a = this.data.farmSetData;
        wx.openLocation({
            latitude: parseFloat(a.self_lifting_place.lat),
            longitude: parseFloat(a.self_lifting_place.lng),
            name: a.self_lifting_address
        });
    },
    onShow: function(a) {
        var e = wx.getStorageSync("kundian_farm_uid"), t = wx.getStorageSync("selectAdd_" + e);
        t && (this.setData({
            userName: t.name,
            phone: t.phone,
            address: t.region + " " + t.address
        }), wx.removeStorageSync("selectAdd_" + e));
    }
});