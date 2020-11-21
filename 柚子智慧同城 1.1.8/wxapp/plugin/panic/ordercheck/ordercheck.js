/*www.lanrenzhijia.com   time:2019-06-01 22:11:49*/
function a(a, t, e) {
    return t in a ? Object.defineProperty(a, t, {
        value: e,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : a[t] = e, a
}
var t = getApp();
t.Base({
    data: {
        showTypeA: !1,
        showTypeB: !1,
        addressFalse: !0,
        param: {
            sincetype: 1,
            remark: "",
            phone: "",
            pay_type: 1
        },
        pay_type: 1
    },
    getAddress: function(a) {
        var t = this;
        this.data.addressFalse && wx.chooseAddress({
            success: function(a) {
                t.setData({
                    expressInfo: a
                }), wx.setStorageSync("expressInfo", a)
            },
            fail: function(a) {
                t.setData({
                    addressFalse: !1
                })
            }
        })
    },
    openWXSetting: function(a) {
        a.detail.authSetting["scope.address"] && (this.setData({
            addressFalse: !0
        }), this.getAddress())
    },
    onLoad: function(a) {
        var t = this,
            e = JSON.parse(a.id);
        if (e.all_sendtype) {
            var n = e.all_sendtype.split(",");
            for (var i in n) 1 == n[i] ? this.setData({
                showTypeA: !0
            }) : 2 == n[i] && (this.setData({
                showTypeB: !0
            }), e.sincetype = 2);
            1 == n[0] && (e.sincetype = 1)
        } else this.setData({
            showTypeA: !0
        }), e.sincetype = 1;
        this.checkLogin(function(a) {
            e.phone = null == a.tel ? "" : a.tel, e.remark = "", e.mail_money = (e.order_amount - 0 + (e.distribution - 0)).toFixed(2), e.store_money = e.order_amount - 0, t.setData({
                param: e,
                user: a
            }), t.onLoadData(a)
        }, "/base/admin/admin")
    },
    onLoadData: function(a) {
        this.setData({
            show: !0
        })
    },
    onTypeTap: function(t) {
        var e = t.currentTarget.dataset.idx;
        this.setData(a({}, "param.sincetype", e))
    },
    onAddressTap: function() {
        t.map(this.data.param.store_lat, this.data.param.store_lng)
    },
    onTelTap: function() {
        t.phone(this.data.param.store_tel)
    },
    getTel: function(t) {
        var e = t.detail.value.trim();
        this.setData(a({}, "param.phone", e))
    },
    getRemark: function(t) {
        var e = t.detail.value.trim();
        this.setData(a({}, "param.remark", e))
    },
    onPayTap: function(a) {
        this.setData({
            payType: !0
        })
    },
    onPaycloseTap: function() {
        this.setData({
            payType: !1
        })
    },
    onChooseTap: function(a) {
        var t = a.currentTarget.dataset.pay - 0;
        this.setData({
            pay_type: t
        })
    },
    onCheckTap: function(a) {
        var e = this,
            n = this,
            i = this.data.param;
        if (2 == i.sincetype) {
            if (i.order_amount = i.mail_money, !this.data.expressInfo) return void t.tips("请选择收货地址");
            if (i.name = this.data.expressInfo.userName, i.phone = this.data.expressInfo.telNumber, i.address = this.data.expressInfo.provinceName + this.data.expressInfo.cityName + this.data.expressInfo.countyName + this.data.expressInfo.detailInfo, i.name.length < 1 || i.phone.length < 8 || i.phone.address < 1) return void t.tips("请选择收货地址")
        } else if (i.order_amount = i.store_money, i.phone.length < 11) return void t.tips("请输入正确的预留电话！");
        var s = wx.getStorageSync("s_id");
        s && s > 0 && (i.share_user_id = s);
        var o = this.data.pay_type;
        i.pay_type = 1 == o ? 1 : 2, this.data.ajax || (this.data.ajax = !0, t.api.apiPanicPanicBuy(i).then(function(a) {
            if ("余额支付成功" == a.msg) {
                var i = 1;
                e.setData({
                    payType: !1
                }), setTimeout(function() {
                    i = 0
                }, 5e3), t.alert("余额支付成功", function() {
                    wx.showLoading({
                        title: "余额支付成功"
                    }), t.timePass(3e3).then(function() {
                        t.reTo("/plugin/panic/panicorderinfo/panicorderinfo?page=0&oid=" + n.data.oid), wx.hideLoading()
                    })
                }, function() {
                    e.onHomeTab()
                }, "提示", "返回首页", "订单详情")
            }
            if (e.reloadPrevious(), e.setData({
                oid: a.other.oid
            }), "免单成功" == a.msg) {
                e.setData({
                    payType: !1
                });
                var s = 1;
                setTimeout(function() {
                    s = 0
                }, 5e3), t.alert("购买成功！", function() {
                    wx.showLoading({
                        title: "购买成功！"
                    }), t.timePass(3e3).then(function() {
                        t.reTo("/plugin/panic/panicorderinfo/panicorderinfo?page=0&oid=" + n.data.oid), wx.hideLoading()
                    })
                }, function() {
                    e.onHomeTab()
                }, "提示", "返回首页", "订单详情")
            } else "调支付" == a.msg && (e.setData({
                payStamp: a.data
            }), e.wxpayAjax());
            e.setData({
                orderInfo: a.data
            }), e.data.ajax = !1
        }).
        catch (function(a) {
            n.data.param.oldoid <= 0 ? t.alert("您有未支付订单，是否继续支付？", function() {
                wx.navigateBack({
                    delta: 1
                })
            }) : t.alert("您有未支付订单，是否继续支付？", function() {
                t.navTo("/plugin/panic/panicorderinfo/panicorderinfo?page=0&oid=" + e.data.param.oldoid)
            }), e.data.ajax = !1
        }))
    },
    wxpayAjax: function() {
        var a = this.data.payStamp,
            e = this;
        wx.requestPayment({
            timeStamp: a.timeStamp,
            nonceStr: a.nonceStr,
            package: a.package,
            signType: a.signType,
            paySign: a.paySign,
            success: function(a) {
                this.setData({
                    payType: !1
                }), setTimeout(function() {
                    var a = 1;
                    setTimeout(function() {
                        a = 0
                    }, 4e3), t.alert("购买成功！", function() {
                        t.timePass(3e3).then(function() {
                            t.reTo("/plugin/panic/panicorderinfo/panicorderinfo?page=0&oid=" + e.data.oid), wx.hideLoading()
                        })
                    }, function() {
                        e.onHomeTab()
                    }, "提示", "返回首页", "订单详情")
                }, 1e3)
            },
            fail: function(a) {
                e.data.ajax = !1, t.tips("您已取消支付，请重新支付！")
            }
        })
    }
});