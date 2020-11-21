var a = new getApp(), e = a.siteInfo.uniacid;

Page({
    data: {
        goodsData: [],
        specItem: [],
        aboutData: [],
        total_price: 0,
        copyTotalPrice: 0,
        count: 0,
        address: "",
        userName: "",
        phone: "",
        goods_id: "",
        spec_id: "",
        couponCount: 0,
        userCoupon: [],
        farmSetData: []
    },
    onLoad: function(t) {
        var o = this, n = t.goods_id;
        if (t.spec_id) var s = t.spec_id; else s = 0;
        var r = t.count, d = wx.getStorageSync("kundian_farm_uid");
        a.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "group",
                op: "getSureGoodsData",
                goods_id: n,
                spec_id: s,
                uniacid: e,
                count: r,
                uid: d
            },
            success: function(a) {
                var e = a.data, t = e.address, d = e.goodsData, i = e.aboutData, c = e.specItem, u = e.total_price, p = e.specVal, l = e.couponCount, g = "";
                t && (g = t.region + " " + t.address), o.setData({
                    goodsData: d,
                    specItem: c,
                    aboutData: i,
                    total_price: u,
                    copyTotalPrice: u,
                    count: r,
                    specVal: p,
                    goods_id: n,
                    spec_id: s,
                    couponCount: l,
                    address: g,
                    userName: t.name || "",
                    phone: t.phone || ""
                });
            }
        }), a.util.setNavColor(e), o.setData({
            farmSetData: wx.getStorageSync("kundian_farm_setData")
        });
    },
    chooseAddress: function(a) {
        wx.navigateTo({
            url: "/kundian_farm/pages/user/address/index?is_select=true"
        });
    },
    formSubmit: function(t) {
        var o = wx.getStorageSync("kundian_farm_uid"), n = t.detail.value.remark, s = this.data, r = s.address, d = s.userName, i = s.phone, c = s.goods_id, u = s.spec_id, p = s.count, l = s.userCoupon, g = 0, _ = 0;
        if ("" != l && (g = l.coupon.id, _ = l.coupon.coupon_price), "" == r || "" == d || "" == i) wx.showToast({
            title: "请选择地址"
        }); else {
            var f = {
                control: "group",
                op: "addGroupOrder",
                uid: o,
                uniacid: e,
                address: r,
                phone: i,
                name: d,
                goods_id: c,
                spec_id: u,
                count: p,
                remark: n,
                coupon_id: g,
                coupon_price: _
            };
            a.util.request({
                url: "entry/wxapp/class",
                data: f,
                success: function(t) {
                    var o = t.data.order_id;
                    a.util.request({
                        url: "entry/wxapp/pay",
                        data: {
                            op: "getGroupPayOrder",
                            orderid: o,
                            uniacid: e,
                            file: "group"
                        },
                        cachetime: "0",
                        success: function(t) {
                            if (t.data && t.data.data && !t.data.errno) {
                                var n = t.data.data.package;
                                wx.requestPayment({
                                    timeStamp: t.data.data.timeStamp,
                                    nonceStr: t.data.data.nonceStr,
                                    package: t.data.data.package,
                                    signType: "MD5",
                                    paySign: t.data.data.paySign,
                                    success: function(t) {
                                        wx.showLoading({
                                            title: "玩命加载中"
                                        }), a.util.request({
                                            url: "entry/wxapp/class",
                                            data: {
                                                control: "group",
                                                order_id: o,
                                                op: "sendMsg",
                                                uniacid: e,
                                                prepay_id: n
                                            },
                                            success: function() {
                                                wx.hideLoading(), wx.showModal({
                                                    title: "提示",
                                                    content: "支付成功",
                                                    showCancel: !1,
                                                    success: function() {
                                                        wx.redirectTo({
                                                            url: "../orderList/index"
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
                                                a.confirm;
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
        }
    },
    selectCoupon: function(a) {
        var e = this.data.copyTotalPrice - this.data.send_price;
        wx.navigateTo({
            url: "../../../user/coupon/useCoupon/index?type=2&totalPrice=" + e
        });
    },
    onShow: function(a) {
        var e = this.data.copyTotalPrice;
        if (wx.getStorageSync("user_coupon")) {
            wx.getStorageSync("user_coupon");
            wx.removeStorageSync("user_coupon");
        } else this.setData({
            userCoupon: [],
            total_price: e
        });
        var t = wx.getStorageSync("kundian_farm_uid"), o = wx.getStorageSync("selectAdd_" + t);
        o && (this.setData({
            address: o.region + " " + o.address,
            userName: o.name,
            phone: o.phone
        }), wx.removeStorageSync("selectAdd_" + t));
    }
});