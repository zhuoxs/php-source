var e = new getApp(), a = e.siteInfo.uniacid;

Page({
    data: {
        address: "",
        name: "",
        phone: "",
        seedData: [],
        farmSetData: [],
        selectBag: [],
        types: 0,
        recovery_method: 1
    },
    onLoad: function(t) {
        var n = this;
        e.util.setNavColor(a);
        var s = 0;
        t.types && (s = t.types);
        var r = wx.getStorageSync("kundian_farm_setData"), d = wx.getStorageSync("kundian_farm_uid"), o = 1;
        2 == r.recovery_method && (o = 2), n.setData({
            farmSetData: r,
            selectBag: JSON.parse(t.selectBag),
            types: s,
            recovery_method: o
        }), e.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "user",
                op: "getAddress",
                uniacid: a,
                uid: d
            },
            success: function(e) {
                var a = e.data.address, t = "";
                a && (t = a.region + " " + a.address), n.setData({
                    address: t,
                    userName: a.name,
                    phone: a.phone
                });
            }
        });
    },
    selAddress: function(e) {
        wx.navigateTo({
            url: "/kundian_farm/pages/user/address/index?is_select=true"
        });
    },
    radioChange: function(e) {
        this.setData({
            recovery_method: e.detail.value
        });
    },
    changeRecoveryMethod: function(e) {
        var a = e.currentTarget.dataset.state, t = this.data, n = t.totalPrice, s = t.send_price, r = t.copyTotalPrice;
        n = 2 == a ? parseFloat(n - s).toFixed(2) : r, this.setData({
            recovery_method: a,
            totalPrice: n
        });
    },
    nowPay: function(a) {
        var t = this, n = wx.getStorageSync("kundian_farm_uid"), s = e.siteInfo.uniacid, r = t.data, d = r.userName, o = r.address, i = r.phone, c = r.selectBag, l = r.recovery_method, u = a.detail.formId;
        if (1 == l && ("" == o || "" == d || "" == i)) return wx.showToast({
            title: "请选择收货地址",
            icon: "none"
        }), !1;
        if (2 != l || (d = a.detail.value.name, i = a.detail.value.phone, "" != d && "" != i)) {
            var p = {
                op: "addSeedSendOrder",
                address: o,
                name: d,
                phone: i,
                uniacid: s,
                uid: n,
                control: "land",
                selectBag: JSON.stringify(c),
                formid: u,
                recovery_method: l
            };
            e.util.request({
                url: "entry/wxapp/class",
                data: p,
                method: "POST",
                success: function(a) {
                    var n = a.data.order_id;
                    if (2 == l) return wx.redirectTo({
                        url: "/kundian_farm/pages/shop/orderList/index"
                    }), !1;
                    e.util.request({
                        url: "entry/wxapp/pay",
                        data: {
                            orderid: n,
                            uniacid: s,
                            control: "land",
                            op: "seedSendPay"
                        },
                        cachetime: "0",
                        success: function(a) {
                            if (a.data && a.data.data && !a.data.errno) {
                                var r = a.data.data.package;
                                wx.requestPayment({
                                    timeStamp: a.data.data.timeStamp,
                                    nonceStr: a.data.data.nonceStr,
                                    package: a.data.data.package,
                                    signType: "MD5",
                                    paySign: a.data.data.paySign,
                                    success: function(a) {
                                        wx.showLoading({
                                            title: "玩命加载中..."
                                        }), e.util.request({
                                            url: "entry/wxapp/class",
                                            data: {
                                                op: "notifySeedSend",
                                                control: "land",
                                                order_id: n,
                                                uniacid: s,
                                                prepay_id: r,
                                                selectBag: JSON.stringify(c)
                                            },
                                            method: "POST",
                                            success: function(e) {
                                                wx.hideLoading(), wx.showModal({
                                                    title: "提示",
                                                    content: "支付成功",
                                                    showCancel: !1,
                                                    success: function() {
                                                        1 == t.data.types ? wx.redirectTo({
                                                            url: "/kundian_game/pages/farm/index"
                                                        }) : wx.redirectTo({
                                                            url: "/kundian_farm/pages/shop/orderList/index"
                                                        });
                                                    }
                                                });
                                            }
                                        });
                                    },
                                    fail: function(e) {
                                        console.log("支付失败1");
                                    }
                                });
                            } else console.log("支付失败2");
                        },
                        fail: function(e) {
                            wx.showModal({
                                title: "系统提示",
                                content: e.data.message ? e.data.message : "错误",
                                showCancel: !1,
                                success: function(e) {
                                    e.confirm;
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
        var e = this.data.farmSetData;
        wx.openLocation({
            latitude: parseFloat(e.self_lifting_place.lat),
            longitude: parseFloat(e.self_lifting_place.lng),
            name: e.self_lifting_address
        });
    },
    onShow: function(e) {
        var a = wx.getStorageSync("kundian_farm_uid"), t = wx.getStorageSync("selectAdd_" + a);
        t && (this.setData({
            address: t.region + " " + t.address,
            userName: t.name,
            phone: t.phone
        }), wx.removeStorageSync("selectAdd_" + a));
    }
});