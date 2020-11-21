/*www.lanrenzhijia.com   time:2019-06-01 22:11:50*/
function a(a, e, t) {
    return e in a ? Object.defineProperty(a, e, {
        value: t,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : a[e] = t, a
}
var e = getApp();
e.Base({
    data: {
        showTypeA: !1,
        showTypeB: !1,
        addressFalse: !0
    },
    getAddress: function(a) {
        var e = this;
        this.data.addressFalse && wx.chooseAddress({
            success: function(a) {
                e.setData({
                    expressInfo: a
                }), wx.setStorageSync("expressInfo", a)
            },
            fail: function(a) {
                e.setData({
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
        var e = this,
            t = JSON.parse(a.id);
        if (t.all_sendtype) {
            var s = t.all_sendtype.split(",");
            for (var i in s) 1 == s[i] ? this.setData({
                showTypeA: !0
            }) : 2 == s[i] && (this.setData({
                showTypeB: !0
            }), t.sincetype = 2);
            1 == s[0] && (t.sincetype = 1)
        } else this.setData({
            showTypeA: !0
        }), t.sincetype = 1;
        this.checkLogin(function(a) {
            t.phone = a.tel, t.remark = "", t.is_head = t.heads_id > 0 ? 0 : 1 == t.ordertype ? 1 : 0, t.name = a.nickname, e.setData({
                param: t,
                user: a
            }), e.onLoadData(a)
        }, "/plugin/spell/order/order?id=" + a.id)
    },
    onLoadData: function() {
        var e;
        this.reloadPrevious();
        var t = 0;
        2 == this.data.param.ordertype ? t = (this.data.param.money * this.data.param.num).toFixed(2) : 1 != this.data.param.ordertype && 0 != this.data.param.ordertype || (t = this.data.param.heads_id > 0 ? (this.data.param.money * this.data.param.num).toFixed(2) : (this.data.param.money * this.data.param.num - this.data.param.coupon_money).toFixed(2));
        var s = (t - 0 + (this.data.param.distribution - 0)).toFixed(2),
            i = t;
        this.setData((e = {}, a(e, "param.order_amount", t), a(e, "param.mail_money", s), a(e, "param.store_money", i), a(e, "show", !0), e))
    },
    onTypeTap: function(e) {
        var t = e.currentTarget.dataset.idx;
        this.setData(a({}, "param.sincetype", t))
    },
    onAddressTap: function() {
        e.map(this.data.param.store_lat, this.data.param.store_lng)
    },
    onTelTap: function() {
        e.phone(this.data.param.store_tel)
    },
    getTel: function(e) {
        var t = e.detail.value.trim();
        this.setData(a({}, "param.phone", t))
    },
    getRemark: function(e) {
        var t = e.detail.value.trim();
        this.setData(a({}, "param.remark", t))
    },
    onCheckTap: function(a) {
        var t = this,
            s = this.data.param;
        if (2 == s.sincetype) {
            if (s.order_amount = s.mail_money, !this.data.expressInfo) return void e.tips("请选择收货地址");
            if (s.name = this.data.expressInfo.userName, s.phone = this.data.expressInfo.telNumber, s.address = this.data.expressInfo.provinceName + this.data.expressInfo.cityName + this.data.expressInfo.countyName + this.data.expressInfo.detailInfo, s.name.length < 1 || s.phone.length < 8 || s.phone.address < 1) return void e.tips("请选择收货地址")
        } else if (s.order_amount = s.store_money, s.phone.length < 11) return void e.tips("请输入正确的预留电话！");
        var i = wx.getStorageSync("s_id");
        i && i > 0 && (s.share_user_id = i), this.data.ajax || (this.setData({
            ajax: !0
        }), e.api.apiPinGetBuy(s).then(function(a) {
            t.reloadPrevious(), e.reTo("/plugin/spell/orderinfo/orderinfo?page=0&oid=" + a.data.oid)
        }).
        catch (function(a) {
            setTimeout(function() {
                t.setData({
                    ajax: !1
                }), e.tips(a.msg)
            }, 1e3)
        }))
    },
    wxpayAjax: function() {
        var a = this.data.payStamp,
            t = this;
        wx.requestPayment({
            timeStamp: a.timeStamp,
            nonceStr: a.nonceStr,
            package: a.package,
            signType: a.signType,
            paySign: a.paySign,
            success: function(a) {
                setTimeout(function() {
                    var a = 1;
                    setTimeout(function() {
                        a = 0
                    }, 4e3), e.alert("购买成功！", function() {
                        0 == a ? e.navTo("/plugin/spell/orderinfo/orderinfo?page=0&oid=" + t.data.oid) : (e.tips("页面跳转中..."), setTimeout(function() {
                            e.navTo("/plugin/spell/orderinfo/orderinfo?page=0&oid=" + t.data.oid)
                        }, 2e3))
                    }, function() {
                        t.onHomeTab()
                    }, "提示", "返回首页", "订单详情")
                }, 1e3)
            },
            fail: function(a) {
                t.data.ajax = !1, e.tips("您已取消支付，请重新支付！")
            }
        })
    }
});