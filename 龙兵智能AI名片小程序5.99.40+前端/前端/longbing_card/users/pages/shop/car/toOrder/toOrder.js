var _xx_util = require("../../../../../resource/js/xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util), _index = require("../../../../../resource/apis/index.js");

function _interopRequireDefault(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}

var app = getApp(), regeneratorRuntime = _xx_util2.default.regeneratorRuntime;

Page({
    data: {
        toWxPayStatus: 0
    },
    onLoad: function(t) {
        console.log(t, "options");
        var a, e = this, o = t.status, r = {
            status: o,
            sharestatus: t.sharestatus
        };
        if (o) {
            var i = getApp().globalData.to_uid, s = wx.getStorageSync("storageToOrder"), d = "toCollage" == o ? s.dataList[0].goods_id : "toJoinCollage" == o ? s.tmp_trolley_ids : "", l = "/longbing_card/users/pages/uCenter/order/orderList/orderList?currentTab=";
            r.tmpFailUrl = "toCollage" == o || "toJoinCollage" == o ? "/longbing_card/users/pages/uCenter/order/collageList/collageList?currentTab=0" : l + "1", 
            r.tmpSuccessUrl = "toCollage" == o || "toJoinCollage" == o ? "/longbing_card/users/pages/shop/releaseCollage/releaseCollage?status=toShare&to_uid=" + i + "&id=" + d + "&collage_id=" : l + "2";
            var n = "toCollage" == o ? "发布拼团" : "toJoinCollage" == o ? "参加拼团" : "去结算";
            wx.setNavigationBarTitle({
                title: n
            });
        }
        wx.getStorageSync("storageToOrder") && (r.orderData = wx.getStorageSync("storageToOrder"));
        var u = 0, c = r.orderData.dataList;
        for (var g in c) a || (a = c[0].goods_id), a == c[g].goods_id && (c[g].toCountFreightPrice = 1), 
        0 < g && (c[g].goods_id != c[g - 1].goods_id ? (a = c[g].goods_id, c[g].toCountFreightPrice = 1) : c[g].toCountFreightPrice = 0), 
        1 == c[g].toCountFreightPrice && (u += 1 * c[g].freight);
        r.orderData.freight_price = u, r.orderData.countPayMoney = (1 * r.orderData.count_price + 1 * u).toFixed(2), 
        r.orderData.countPayMoney2 = r.orderData.countPayMoney, getApp().getConfigInfo(!0).then(function() {
            e.setData({
                paramData: r,
                globalData: getApp().globalData
            }), e.getAddressList(), wx.hideLoading();
        });
    },
    onShow: function() {
        var t = this, a = getApp().globalData, e = {};
        a.checkAddress_cur && (e = a.checkAddress_cur, t.setData({
            checkAddress_cur: e
        }));
        var o = t.data.paramData;
        if (o && o.orderData) {
            var r = o.orderData.countPayMoney;
            a.checkvoucher && (r = (o.orderData.countPayMoney - a.checkvoucher.reduce).toFixed(2)), 
            o.orderData.countPayMoney2 = r;
        }
        t.setData({
            globalData: a,
            paramData: o
        });
    },
    onHide: function() {
        getApp().globalData.checkvoucher = !1, wx.removeStorageSync("storageToOrder");
    },
    onUnload: function() {
        getApp().globalData.checkvoucher = !1, wx.removeStorageSync("storageToOrder");
    },
    onPullDownRefresh: function() {
        wx.showNavigationBarLoading(), this.getAddressList();
    },
    getAddressList: function() {
        var o = this;
        _index.userModel.getAddressList().then(function(t) {
            var a = t.data;
            for (var e in a) 1 == a[e].is_default && (getApp().globalData.checkAddress = a[e]);
            getApp().globalData.checkAddress && o.setData({
                checkAddress_cur: getApp().globalData.checkAddress
            });
        });
    },
    getProductOrder: function(t) {
        var o = this;
        _index.userModel.getProductOrder(t).then(function(t) {
            if (_xx_util2.default.hideAll(), o.toOrderPay(t), 0 == t.errno) {
                var a = o.data.paramData.orderData.dataList;
                for (var e in a) o.toShopDelTrolley(a[e].id);
            }
        });
    },
    getOnlyOrder: function(t) {
        var a = this;
        _index.userModel.getOnlyOrder(t).then(function(t) {
            _xx_util2.default.hideAll(), a.toOrderPay(t);
        });
    },
    getCollageOrder: function(t) {
        var a = this;
        _index.userModel.getCollageOrder(t).then(function(t) {
            _xx_util2.default.hideAll(), a.toOrderPay(t);
        });
    },
    getJoinCollageOrder: function(t) {
        var a = this;
        _index.userModel.getJoinCollageOrder(t).then(function(t) {
            _xx_util2.default.hideAll(), a.toOrderPay(t);
        });
    },
    toOrderPay: function(t) {
        var a = this, e = this;
        0 == t.errno ? t.message ? wx.showToast({
            icon: "none",
            image: "/longbing_card/resource/images/alert.png",
            title: t.message,
            duration: 2e3,
            success: function() {
                setTimeout(function() {
                    var t = e.data.paramData.tmpSuccessUrl;
                    "toCollage" != e.data.paramData.status && "toJoinCollage" != e.data.paramData.status || (t += e.data.pay_collage_id), 
                    console.log(t, "tmpURL"), "fromshare" == e.data.paramData.sharestatus ? (t += "&sharestatus=fromshare", 
                    wx.reLaunch({
                        url: t
                    })) : wx.redirectTo({
                        url: t
                    }), e.data.toWxPayStatus = 0;
                }, 1500);
            }
        }) : this.getWxPay(t.data.order_id) : wx.showModal({
            title: "",
            content: t.message,
            showCancel: !1,
            confirmText: "知道啦",
            success: function(t) {
                t.confirm && a.setData({
                    toWxPayStatus: 0
                });
            }
        });
    },
    toShopDelTrolley: function(t) {
        _index.userModel.getShopDelTro({
            id: t
        }).then(function(t) {
            _xx_util2.default.hideAll();
        });
    },
    getWxPay: function(t) {
        var a = this;
        _xx_util2.default.showLoading(), _index.userModel.getWxPay({
            order_id: t
        }).then(function(t) {
            _xx_util2.default.hideAll(), 0 == t.errno ? (t.data.collage_id && a.setData({
                pay_collage_id: t.data.collage_id
            }), wx.requestPayment({
                timeStamp: t.data.timeStamp,
                nonceStr: t.data.nonceStr,
                package: t.data.package,
                signType: "MD5",
                paySign: t.data.paySign,
                success: function(t) {
                    wx.showToast({
                        icon: "none",
                        image: "/longbing_card/resource/images/alert.png",
                        title: "支付成功",
                        duration: 2e3,
                        success: function() {
                            setTimeout(function() {
                                var t = a.data.paramData.tmpSuccessUrl;
                                "toCollage" != a.data.paramData.status && "toJoinCollage" != a.data.paramData.status || (t += a.data.pay_collage_id), 
                                console.log(t, "tmpURL"), "fromshare" == a.data.paramData.sharestatus ? (t += "&sharestatus=fromshare", 
                                wx.reLaunch({
                                    url: t
                                })) : wx.redirectTo({
                                    url: t
                                }), a.data.toWxPayStatus = 0;
                            }, 1500);
                        }
                    });
                },
                fail: function(t) {
                    wx.showToast({
                        icon: "none",
                        image: "/longbing_card/resource/images/error.png",
                        title: "支付失败",
                        duration: 2e3,
                        success: function() {
                            setTimeout(function() {
                                wx.redirectTo({
                                    url: a.data.paramData.tmpFailUrl
                                }), a.data.toWxPayStatus = 0;
                            }, 1500);
                        }
                    });
                },
                complete: function(t) {}
            })) : wx.showModal({
                title: "系统提示",
                content: t.data.message || "支付失败，请重试",
                showCancel: !1,
                success: function(t) {
                    t.confirm && setTimeout(function() {
                        wx.redirectTo({
                            url: a.data.paramData.tmpFailUrl
                        });
                    }, 1e3);
                }
            });
        });
    },
    toJump: function(t) {
        var a = this, e = _xx_util2.default.getData(t).status;
        console.log(e, t);
        var o = a.data, r = o.checkAddress_cur, i = o.toWxPayStatus, s = o.paramData, d = o.globalData, l = s.orderData.tmp_is_self;
        if ("toCheckAddress" != e && 0 == l) {
            if (!r) return _xx_util2.default.showFail("请选择收货地址"), !1;
            var n = r.id;
            if (!n) return _xx_util2.default.showFail("请选择收货地址"), !1;
        }
        if ("toWxPay" == e) {
            console.log(e, i);
            var u = getApp().globalData.to_uid, c = d.checkvoucher, g = s.status, _ = s.orderData, h = _.dataList, p = _.tmp_trolley_ids, f = h[0], x = f.collage_id, m = f.number, D = f.goods_id, y = f.spe_price_id;
            0 == i && a.setData({
                toWxPayStatus: 1
            }, function() {
                var t = {
                    to_uid: u,
                    address_id: 0 == l ? n : -1
                };
                "toOrder" != g && "toCarOrder" != g || c.id && (t.record_id = c.id), "toOrder" == g && (t.number = m, 
                t.goods_id = D, t.spe_price_id = y, a.getOnlyOrder(t)), "toCarOrder" == g && (t.trolley_ids = p, 
                a.getProductOrder(t)), "toCollage" != g && "toJoinCollage" != g || (t.collage_id = x, 
                t.number = m, t.goods_id = "toCollage" == g ? D : p, "toCollage" == g && a.getCollageOrder(t), 
                "toJoinCollage" == g && a.getJoinCollageOrder(t));
            });
        }
    }
});