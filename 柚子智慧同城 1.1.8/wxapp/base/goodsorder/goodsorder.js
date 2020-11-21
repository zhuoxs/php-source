/*www.lanrenzhijia.com   time:2019-06-01 22:11:54*/
var a = getApp();
a.Base({
    data: {
        attrName: "",
        cur: 1,
        pay_type: 1,
        payType: !1
    },
    onLoad: function(a) {
        this.setData({
            gid: a.gid,
            attr_ids: a.attr_ids ? a.attr_ids : 0,
            num: a.num,
            reload: !0
        })
    },
    onShow: function() {
        var a = this;
        this.data.reload && (this.setData({
            reload: !1
        }), this.checkLogin(function(t) {
            a.setData({
                user: t,
                user_id: t.id
            }), a.onLoadData()
        }, "/pages/goodsorder/goodsorder"))
    },
    onLoadData: function() {
        var t = this,
            e = this,
            d = e.data.attrName,
            r = {
                user_id: e.data.user_id,
                gid: e.data.gid,
                attr_ids: e.data.attr_ids,
                num: e.data.num
            };
        a.api.apiOrderGetPlaceOrder(r).then(function(a) {
            d = a.data.goodsattrsetting ? a.data.goodsattrsetting.key.replace(/^,+|,+$/g, "") : 0, t.setData({
                order: a.data,
                attrName: d,
                img_root: a.other.img_root,
                show: !0
            })
        }).
        catch (function(t) {
            t.code, a.tips(t.msg)
        })
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
    subOrder: function(t) {
        var e = this,
            d = this,
            r = this.data.pay_type,
            s = d.data.tel || t.detail.value.tel.replace(/\s+/g, ""),
            i = t.detail.formId;
        if (/^1(3|4|5|7|8|9)\d{9}$/.test(s)) {
            if (!d.data.ajax) if (d.setData({
                ajax: !0
            }), d.data.order_id && 2 != r) {
                var o = {
                    order_id: d.data.order_id
                };
                a.api.apiOrderGetWxParamByOrderId(o).then(function(t) {
                    t.data && wx.requestPayment({
                        appId: t.data.appId,
                        nonceStr: t.data.nonceStr,
                        package: t.data.package,
                        paySign: t.data.paySign,
                        prepay_id: t.data.prepay_id,
                        signType: t.data.signType,
                        timeStamp: t.data.timeStamp,
                        success: function(t) {
                            d.setData({
                                payType: !1,
                                ajax: !1
                            }), a.tips("支付成功去使用！"), a.reTo("/base/ordersuccess/ordersuccess")
                        },
                        fail: function() {
                            d.setData({
                                buttonName: "继续支付",
                                ajax: !1
                            })
                        }
                    })
                }).
                catch (function(t) {
                    d.setData({
                        ajax: !1
                    }), a.tips(t.msg)
                })
            } else if (!d.data.order_id || 2 == r) {
                var n = {
                    user_id: d.data.user_id,
                    gid: d.data.gid,
                    attr_ids: d.data.attr_ids,
                    num: d.data.num,
                    phone: s,
                    remark: t.detail.value.note,
                    formId: i,
                    pay_type: r
                }, p = wx.getStorageSync("s_id");
                p && p > 0 && (n.share_user_id = p), a.api.apiOrderSetOrder(n).then(function(t) {
                    return d.setData({
                        order_id: t.data.order_id || 0
                    }), "0.00" == d.data.order.order.order_amount ? (a.reTo("/base/ordersuccess/ordersuccess"), void d.setData({
                        payType: !1,
                        ajax: !1
                    })) : 2 == r ? (a.tips("余额支付成功"), setTimeout(function() {
                        a.reTo("/base/ordersuccess/ordersuccess")
                    }, 1500), void d.setData({
                        payType: !1,
                        ajax: !1
                    })) : void(t.data && wx.requestPayment({
                        appId: t.data.appId,
                        nonceStr: t.data.nonceStr,
                        package: t.data.package,
                        paySign: t.data.paySign,
                        prepay_id: t.data.prepay_id,
                        signType: t.data.signType,
                        timeStamp: t.data.timeStamp,
                        success: function(t) {
                            a.tips("支付成功去使用！"), d.setData({
                                payType: !1,
                                ajax: !1
                            }), a.reTo("/base/ordersuccess/ordersuccess")
                        },
                        fail: function() {
                            d.setData({
                                buttonName: "继续支付",
                                ajax: !1
                            })
                        }
                    }))
                }).
                catch (function(t) {
                    a.tips(t.msg), e.setData({
                        ajax: !1
                    })
                })
            }
        } else a.tips("请输入正确的手机号码")
    },
    onTabTap: function(a) {
        var t = this,
            e = a.currentTarget.dataset.index;
        t.setData({
            cur: e
        })
    },
    onAddressTap: function() {
        a.map(this.data.order.store.lat, this.data.order.store.lng)
    }
});