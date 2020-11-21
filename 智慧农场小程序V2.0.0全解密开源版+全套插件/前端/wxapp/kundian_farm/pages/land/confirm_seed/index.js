var a = new getApp(), t = a.siteInfo.uniacid;

wx.getStorageSync("kundian_farm_uid");

Page({
    data: {
        seed: [],
        totalPrice: 0,
        copyTotalPrice: 0,
        couponCount: 0,
        userCoupon: [],
        lid: "",
        farmSetData: [],
        order_id: 0
    },
    onLoad: function(a) {
        var t = a.totalPrice, e = a.lid, o = a.seedList, i = JSON.parse(o);
        this.setData({
            seed: i,
            lid: e,
            totalPrice: t,
            copyTotalPrice: t,
            farmSetData: wx.getStorageSync("kundian_farm_setData")
        });
    },
    selectCoupon: function(a) {
        var t = this.data.copyTotalPrice;
        wx.navigateTo({
            url: "../../coupon/useCoupon/index?type=5&totalPrice=" + t
        });
    },
    onShow: function() {
        var a = this.data.copyTotalPrice;
        if (wx.getStorageSync("user_coupon")) {
            var t = wx.getStorageSync("user_coupon");
            wx.removeStorageSync("user_coupon"), this.setData({
                userCoupon: t,
                totalPrice: parseFloat(a - t.coupon.coupon_price).toFixed(2)
            });
        } else this.setData({
            userCoupon: [],
            totalPrice: a
        });
    },
    surePay: function(e) {
        var o = this, i = e.detail.formId, n = o.data.seed, d = o.data.totalPrice, c = o.data, r = c.lid, s = c.userCoupon, u = 0, l = 0;
        "" != s && (u = s.coupon.id, l = s.coupon.coupon_price);
        var p = wx.getStorageSync("kundian_farm_uid");
        if (0 != p) {
            var f = o.data.order_id;
            a.util.request({
                url: "entry/wxapp/class",
                data: {
                    op: "addSeedOrder",
                    control: "land",
                    uniacid: t,
                    uid: p,
                    total_price: d,
                    coupon_id: u,
                    coupon_price: l,
                    lid: r,
                    seedList: JSON.stringify(n),
                    formid: i,
                    order_id: f
                },
                method: "POST",
                success: function(e) {
                    f = e.data.order_id, a.util.request({
                        url: "entry/wxapp/pay",
                        data: {
                            op: "getSeedPayOrder",
                            control: "land",
                            orderid: f,
                            uniacid: t
                        },
                        cachetime: "0",
                        success: function(e) {
                            if (e.data && e.data.data && !e.data.errno) {
                                var o = e.data.data.package;
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
                                                op: "notifySeed",
                                                control: "land",
                                                order_id: f,
                                                uniacid: t,
                                                prepay_id: o,
                                                lid: r
                                            },
                                            success: function(a) {
                                                wx.hideLoading(), wx.showModal({
                                                    title: "提示",
                                                    content: "支付成功！请耐心等待管理员进行播种",
                                                    showCancel: !1,
                                                    success: function() {
                                                        wx.redirectTo({
                                                            url: "../mineLandDetail/index?lid=" + r
                                                        });
                                                    }
                                                });
                                            }
                                        });
                                    },
                                    fail: function(a) {
                                        wx.showModal({
                                            title: "系统提示",
                                            content: "您取消了支付",
                                            showCancel: !1,
                                            success: function(a) {}
                                        });
                                    }
                                });
                            }
                        },
                        fail: function(a) {
                            wx.showModal({
                                title: "系统提示",
                                content: a.data.message ? a.data.message : "错误",
                                showCancel: !1,
                                success: function(a) {}
                            });
                        }
                    });
                }
            });
        } else wx.navigateTo({
            url: "../../../login/index"
        });
    }
});