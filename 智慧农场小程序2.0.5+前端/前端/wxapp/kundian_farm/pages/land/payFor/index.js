var a = require("../../../../wxParse/wxParse.js"), e = new getApp(), t = e.siteInfo.uniacid;

Page({
    data: {
        userName: "",
        userTel: "",
        state: !1,
        rules: !0,
        totalPrice: 0,
        copyTotalPrice: 0,
        lands: [],
        landLimit: [],
        landLimitArr: [],
        couponCount: 0,
        userCoupon: [],
        selectLand: [],
        landDetail: [],
        day: [],
        alias_day: [],
        currentIndex: 0,
        icon: [],
        order_id: 0,
        farmSetData: wx.getStorageSync("kundian_farm_setData"),
        is_load: !1,
        is_renew: 1,
        land_id: "",
        bottom: 0,
        iscostShow: !0
    },
    onLoad: function(n) {
        var o = this, i = 0;
        e.globalData.sysData.model.indexOf("iPhone X") > -1 && (i = 68);
        var r = wx.getStorageSync("kundian_farm_uid"), s = wx.getStorageSync("selectSpec"), d = wx.getStorageSync("kundian_farm_setData"), c = n.land_id, u = {};
        n.is_renew ? (u = {
            control: "land",
            op: "getPayLand",
            is_renew: n.is_renew,
            uniacid: t,
            uid: r,
            land_id: c
        }, o.setData({
            is_renew: n.is_renew,
            farmSetData: d,
            bottom: i
        })) : (u = {
            op: "getPayLand",
            control: "land",
            uniacid: t,
            lid: c,
            selectLand: JSON.stringify(s),
            uid: r
        }, o.setData({
            farmSetData: d,
            bottom: i
        })), e.util.request({
            url: "entry/wxapp/class",
            method: "POST",
            data: u,
            success: function(e) {
                if (-1 == e.data.code) return wx.showModal({
                    title: "提示",
                    content: e.data.msg,
                    showCancel: !1,
                    success: function() {
                        wx.navigateBack({
                            delta: 1
                        });
                    }
                }), !1;
                var t = e.data, n = t.landDetail, i = t.landLimit, r = t.day, d = t.alias_day, u = t.couponCount;
                t.icon;
                o.setData({
                    landDetail: n,
                    selectLand: s,
                    landLimit: i,
                    day: r,
                    alias_day: d,
                    totalPrice: e.data.total_price,
                    couponCount: u,
                    userName: e.data.user.truename || "",
                    userTel: e.data.user.phone || "",
                    icon: e.data.icon,
                    is_load: !0,
                    land_id: c
                }), "" != e.data.farmRule.value && a.wxParse("article", "html", e.data.farmRule.farm_rule, o, 5), 
                o.totalPrice();
            }
        }), e.util.setNavColor(t), wx.removeStorageSync("selectSpec");
    },
    totalPrice: function() {
        var a = 0, e = this.data, t = e.landLimit, n = e.selectLand, o = e.currentIndex;
        e.userCoupon;
        n.map(function(e) {
            a = parseFloat(a) + e.price * t[o].day;
        }), this.setData({
            totalPrice: parseFloat(a).toFixed(2),
            copyTotalPrice: parseFloat(a).toFixed(2)
        });
    },
    bindLimitChange: function(a) {
        var n = this;
        this.setData({
            currentIndex: a.detail.value
        }), this.totalPrice();
        var o = n.data.copyTotalPrice, i = wx.getStorageSync("kundian_farm_uid");
        e.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "coupon",
                op: "getLandCoupon",
                uniacid: t,
                uid: i,
                total_price: o
            },
            success: function(a) {
                n.setData({
                    couponCount: a.data.couponCount,
                    userCoupon: []
                });
            }
        });
    },
    newLandPay: function(a) {
        var n = this, o = n.data, i = o.userName, r = o.userTel, s = o.selectLand, d = o.landLimit, c = o.currentIndex, u = o.totalPrice, l = o.rules, p = o.userCoupon, w = o.order_id, g = o.is_renew, f = o.land_id;
        if ("" == i || void 0 == i) return wx.showToast({
            title: "请填写姓名！"
        }), !1;
        if ("" == r || void 0 == r) return wx.showToast({
            title: "请填写联系电话"
        }), !1;
        var m = wx.getStorageSync("kundian_farm_uid"), _ = 0, x = 0;
        if ("" != p && (_ = p.coupon.id, x = p.coupon.coupon_price), !l) return wx.showModal({
            title: "提示",
            content: "请先阅读并同意农场协议",
            showCancel: !1
        }), !1;
        if (0 == m || "" == m) return wx.navigateTo({
            url: "/kundian_farm/pages/login/index"
        }), !1;
        var h = "../../user/land/personLand/index";
        wx.getStorageSync("enter_is_play") && (h = "../../../../kundian_game/pages/farm/index"), 
        e.util.request({
            url: "entry/wxapp/class",
            method: "POST",
            dataType: "json",
            data: {
                op: "insertLandOrder",
                control: "land",
                uid: m,
                uniacid: t,
                total_price: u,
                username: i,
                phone: r,
                coupon_id: _,
                coupon_price: x,
                selectLand: JSON.stringify(s),
                lid: n.data.landDetail.id,
                limit_id: d[c].id,
                order_id: w,
                is_renew: g,
                land_id: f
            },
            success: function(a) {
                if (-1 == a.data.code) return wx.showModal({
                    title: "提示",
                    content: a.data.msg,
                    showCancel: !1
                }), !1;
                w = a.data.order_id, n.setData({
                    order_id: w
                });
                var o = {
                    op: "getLandPayOrder",
                    control: "land",
                    orderid: w,
                    uniacid: t
                };
                e.util.request({
                    url: "entry/wxapp/pay",
                    data: o,
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
                                            op: "sendMsg",
                                            control: "land",
                                            order_id: w,
                                            prepay_id: n,
                                            uniacid: t
                                        },
                                        success: function() {
                                            wx.showModal({
                                                title: "提示",
                                                content: "支付成功",
                                                showCancel: !1,
                                                success: function() {
                                                    wx.redirectTo({
                                                        url: "../" + h
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
                                        success: function(a) {}
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
        });
    },
    preventTouchMove: function() {},
    farmRule: function(a) {
        wx.navigateTo({
            url: "/kundian_farm/pages/common/agreement/index?type=1"
        });
    },
    inputUserName: function(a) {
        var e = a.detail.value;
        this.setData({
            userName: e
        });
    },
    inputUserTel: function(a) {
        var e = a.detail.value;
        this.setData({
            userTel: e
        });
    },
    changeRules: function() {
        var a = this.data.rules;
        this.setData({
            rules: !a
        });
    },
    selectCoupon: function(a) {
        var e = this.data.copyTotalPrice - this.data.send_price;
        wx.navigateTo({
            url: "../../coupon/useCoupon/index?type=4&totalPrice=" + e
        });
    },
    onShow: function(a) {
        var n = this.data.copyTotalPrice;
        if (wx.getStorageSync("user_coupon")) {
            var o = wx.getStorageSync("user_coupon");
            wx.removeStorageSync("user_coupon"), this.setData({
                userCoupon: o,
                totalPrice: parseFloat(n - o.coupon.coupon_price).toFixed(2)
            });
        } else this.setData({
            userCoupon: [],
            totalPrice: n
        });
        var i = this, r = wx.getStorageSync("kundian_farm_uid");
        e.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "index",
                op: "getUserBindPhone",
                uid: r,
                uniacid: t
            },
            success: function(a) {
                var e = a.data.userInfo;
                i.setData({
                    userName: e.truename,
                    userTel: e.phone
                });
            }
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