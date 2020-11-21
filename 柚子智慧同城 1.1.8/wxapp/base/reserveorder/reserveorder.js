/*www.lanrenzhijia.com   time:2019-06-01 22:11:55*/
var a = getApp(),
    t = require("../../zhy/resource/js/tools.js");
a.Base({
    data: {
        attrName: "",
        cur: 1,
        pay_type: 1,
        payType: !1,
        multiIndex: [0, 0]
    },
    onLoad: function(a) {
        this.setData({
            gid: a.gid,
            attr_ids: a.attr_ids ? a.attr_ids : 0,
            num: a.num,
            reload: !0,
            goods_type: a.goods_type
        });
        var e = t.formatTime(new Date);
        this.setData({
            multiArray: e
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
        }, "/pages/reserveorder/reserveorder"))
    },
    onLoadData: function() {
        var t = this,
            e = this,
            s = e.data.attrName,
            r = {
                user_id: e.data.user_id,
                gid: e.data.gid,
                attr_ids: e.data.attr_ids,
                num: e.data.num,
                goods_type: e.data.goods_type
            };
        a.api.apiOrderGetPlaceOrder(r).then(function(a) {
            s = a.data.goodsattrsetting ? a.data.goodsattrsetting.key.replace(/^,+|,+$/g, "") : 0, t.setData({
                order: a.data,
                attrName: s,
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
            s = this,
            r = this.data.pay_type,
            i = s.data.book_phone || t.detail.value.book_phone.replace(/\s+/g, ""),
            d = t.detail.formId;
        if (/^1(3|4|5|7|8|9)\d{9}$/.test(i)) {
            var o = t.detail.value.book_name;
            if (o.length < 1) a.tips("请输入正确的预约人姓名");
            else {
                var n = t.detail.value.time;
                if (this.data.showtime) {
                    if (!s.data.ajax) if (s.setData({
                        ajax: !0
                    }), s.data.order_id && 2 != r) {
                        var p = {
                            order_id: s.data.order_id
                        };
                        a.api.apiOrderGetWxParamByOrderId(p).then(function(t) {
                            t.data && wx.requestPayment({
                                appId: t.data.appId,
                                nonceStr: t.data.nonceStr,
                                package: t.data.package,
                                paySign: t.data.paySign,
                                prepay_id: t.data.prepay_id,
                                signType: t.data.signType,
                                timeStamp: t.data.timeStamp,
                                success: function(t) {
                                    s.setData({
                                        payType: !1,
                                        ajax: !1
                                    }), a.reTo("/base/reservesuccess/reservesuccess")
                                },
                                fail: function() {
                                    s.setData({
                                        buttonName: "继续支付",
                                        ajax: !1
                                    })
                                }
                            })
                        }).
                        catch (function(t) {
                            s.setData({
                                ajax: !1
                            }), a.tips(t.msg)
                        })
                    } else if (!s.data.order_id || 2 == r) {
                        var u = {
                            user_id: s.data.user_id,
                            gid: s.data.gid,
                            attr_ids: s.data.attr_ids,
                            num: s.data.num,
                            book_phone: i,
                            remark: t.detail.value.note,
                            formId: d,
                            pay_type: r,
                            book_name: o,
                            book_time: n,
                            order_lid: 2
                        }, c = wx.getStorageSync("s_id");
                        c && c > 0 && (u.share_user_id = c), a.api.apiOrderSetOrder(u).then(function(t) {
                            return s.setData({
                                payType: !1,
                                order_id: t.data.order_id || 0
                            }), "0.00" == s.data.order.order.order_amount ? (a.reTo("/base/reservesuccess/reservesuccess"), void s.setData({
                                payType: !1,
                                ajax: !1
                            })) : 2 == r ? (a.tips("余额支付成功"), setTimeout(function() {
                                a.reTo("/base/reservesuccess/reservesuccess")
                            }, 1500), void s.setData({
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
                                    s.setData({
                                        payType: !1,
                                        ajax: !1
                                    }), a.reTo("/base/reservesuccess/reservesuccess")
                                },
                                fail: function() {
                                    s.setData({
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
                } else a.tips("请选择预约时间")
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
    },
    bindMultiPickerColumnChange: function(a) {
        var t = {
            multiArray: this.data.multiArray,
            multiIndex: this.data.multiIndex
        };
        t.multiIndex[a.detail.column] = a.detail.value, this.setData({
            showtime: !0
        }), this.setData(t)
    }
});