var a = require("../../../../wxParse/wxParse.js"), e = new getApp(), t = e.siteInfo.uniacid, n = wx.getStorageSync("kundian_farm_uid");

Page({
    data: {
        specVal: [],
        sku_name: "",
        count: 0,
        aid: "",
        animalData: [],
        totalPrice: 0,
        copyTotalPrice: 0,
        couponCount: 0,
        userCoupon: [],
        userName: "",
        userTel: "",
        state: !1,
        rules: !0,
        farmSetData: [],
        order_id: 0,
        iscostShow: !0
    },
    onLoad: function(o) {
        var i = 0;
        e.globalData.sysData.model.indexOf("iPhone X") > -1 && (i = 68);
        var s = 0, r = wx.getStorageSync("kundian_farm_buy_animal"), u = o.aid, c = o.count;
        s = c * r.price, this.setData({
            count: c,
            aid: u,
            animalData: r,
            totalPrice: s,
            copyTotalPrice: s,
            bottom: i
        });
        var d = this;
        e.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "coupon",
                op: "getUseCouponCount",
                uid: n,
                uniacid: t,
                type: 3,
                totalprice: s
            },
            success: function(e) {
                var t = e.data, n = t.couponCount, o = t.user;
                d.setData({
                    couponCount: n,
                    userName: o.truename,
                    userTel: o.phone
                });
                var i = wx.getStorageSync("kundian_farm_setData");
                i && a.wxParse("article", "html", i.animal_rule, d, 5);
            }
        }), d.setData({
            farmSetData: wx.getStorageSync("kundian_farm_setData")
        }), wx.removeStorageSync("kundian_farm_buy_animal");
    },
    useCoupon: function(a) {
        var e = this.data.copyTotalPrice - this.data.send_price;
        wx.navigateTo({
            url: "../../user/coupon/useCoupon/index?type=3&totalPrice=" + e
        });
    },
    onShow: function() {
        var a = this.data.copyTotalPrice;
        if (wx.getStorageSync("user_coupon")) {
            var n = wx.getStorageSync("user_coupon");
            return wx.removeStorageSync("user_coupon"), void this.setData({
                userCoupon: n,
                totalPrice: parseFloat(a - n.coupon.coupon_price).toFixed(2)
            });
        }
        this.setData({
            userCoupon: [],
            totalPrice: a
        });
        var o = this, i = wx.getStorageSync("kundian_farm_uid");
        e.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "index",
                op: "getUserBindPhone",
                uid: i,
                uniacid: t
            },
            success: function(a) {
                o.setData({
                    userName: a.data.userInfo.truename,
                    userTel: a.data.userInfo.phone
                });
            }
        });
    },
    surePay: function(a) {
        var n = this, o = n.data, i = o.userName, s = o.userTel, r = o.rules, u = o.count, c = o.aid, d = o.specVal, l = o.totalPrice, p = o.userCoupon, m = o.order_id;
        if ("" != i && void 0 != i) if ("" != s && void 0 != s) {
            var f = 0, g = 0, w = wx.getStorageSync("kundian_farm_uid");
            if ("" != p && (console.log(p), f = p.coupon.id, g = p.coupon.coupon_price), !r) return wx.showModal({
                title: "提示",
                content: "请先阅读并同意农场协议",
                showCancel: !1
            }), !1;
            e.util.request({
                url: "entry/wxapp/class",
                data: {
                    control: "animal",
                    op: "sureAdoptAnimal",
                    uid: w,
                    uniacid: t,
                    count: u,
                    spec_id: d.id,
                    aid: c,
                    coupon_id: f,
                    coupon_price: g,
                    username: i,
                    phone: s,
                    totalPrice: l,
                    order_id: m
                },
                success: function(a) {
                    if (0 == a.data.code) {
                        var o = a.data.order_id;
                        n.setData({
                            order_id: o
                        }), e.util.request({
                            url: "entry/wxapp/pay",
                            data: {
                                op: "getAnimalPayOrder",
                                orderid: o,
                                uniacid: t,
                                file: "animal"
                            },
                            cachetime: "0",
                            success: function(a) {
                                if (a.data && a.data.data && !a.data.errno) {
                                    var n = a.data.data.package;
                                    wx.requestPayment({
                                        timeStamp: a.data.data.timeStamp,
                                        nonceStr: a.data.data.nonceStr,
                                        package: a.data.data.package,
                                        signType: "MD5",
                                        paySign: a.data.data.paySign,
                                        success: function(a) {
                                            wx.showLoading({
                                                title: "加载中"
                                            }), e.util.request({
                                                url: "entry/wxapp/class",
                                                data: {
                                                    control: "animal",
                                                    op: "sendMsg",
                                                    order_id: o,
                                                    uniacid: t,
                                                    prepay_id: n
                                                },
                                                success: function() {
                                                    wx.showModal({
                                                        title: "提示",
                                                        content: "支付成功",
                                                        showCancel: !1,
                                                        success: function() {
                                                            wx.redirectTo({
                                                                url: "../../user/Animal/index?current=2"
                                                            });
                                                        }
                                                    }), wx.hideLoading();
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
                                            }), wx.hideLoading();
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
                }
            });
        } else wx.showToast({
            title: "请填写联系电话"
        }); else wx.showToast({
            title: "请填写姓名！"
        });
    },
    inputUserName: function(a) {
        var e = a.detail.value;
        this.setData({
            userName: e
        });
    },
    changeRules: function() {
        var a = this.data.rules;
        this.setData({
            rules: !a
        });
    },
    animalRule: function(a) {
        wx.navigateTo({
            url: "/kundian_farm/pages/common/agreement/index?type=2"
        });
    },
    preventTouchMove: function() {},
    hideModal: function() {
        this.setData({
            state: !1
        });
    },
    changePhone: function(a) {
        wx.navigateTo({
            url: "/kundian_farm/pages/user/phone/index"
        });
    },
    costxq: function(a) {
        this.setData({
            iscostShow: !this.data.iscostShow
        });
    }
});