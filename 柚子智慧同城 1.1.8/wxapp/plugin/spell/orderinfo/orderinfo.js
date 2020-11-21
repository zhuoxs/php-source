/*www.lanrenzhijia.com   time:2019-06-01 22:11:50*/
function a(a, t, i) {
    return t in a ? Object.defineProperty(a, t, {
        value: i,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : a[t] = i, a
}
var t = require("../../../zhy/resource/js/index.js"),
    i = getApp();
i.Base({
    data: {
        pageType: 0,
        downTime: 0,
        max: 0,
        min: 0,
        checkNum: 0,
        pay_type: 1
    },
    onLoad: function(a) {
        this.setData({
            pageType: a.page,
            oid: a.oid,
            reload: !0
        })
    },
    onShow: function() {
        var a = this;
        if (this.data.reload) {
            var t = "page=" + this.data.pageType + "&oid=" + this.data.oid;
            this.checkLogin(function(t) {
                a.setData({
                    user: t
                }), a.onLoadData()
            }, "/plugin/spell/orderinfo/orderinfo?" + t), this.data.reload = !1
        }
    },
    onUnload: function() {
        clearInterval(this.timer)
    },
    onLoadData: function() {
        var a = this;
        if (this.data.oid > 0) {
            var n = {};
            0 == this.data.pageType ? n.oid = this.data.oid : 1 == this.data.pageType && (n.order_no = this.data.oid), i.api.apiPinOrderDetails(n).then(function(n) {
                if ("订单不存在" != n.msg) {
                    var e = (new Date).getTime() / 1e3;
                    switch (n.data.info.order_status - 0) {
                        case 10:
                            e > n.data.info.expire_time ? (n.data.info.flag = 1, n.data.info.flagName = "订单已过期") : (n.data.info.flag = 2, n.data.info.flagName = "待支付");
                            break;
                        case 20:
                            e >= n.data.headsinfo.expire_time ? (n.data.info.flag = 31, n.data.info.flagName = "规定时间内未成团，已过期") : (n.data.info.flag = 32, n.data.info.flagName = "待成团");
                            break;
                        case 25:
                            0 == n.data.info.after_sale ? 4 == n.data.info.refund_status ? 1 == n.data.info.sincetype ? (n.data.info.flag = 48, n.data.info.flagName = "待核销(已拒绝退款)") : 2 == n.data.info.sincetype ? (n.data.info.flag = 48, n.data.info.flagName = "待发货(已拒绝退款)") : 3 == n.data.info.sincetype && (n.data.info.flag = 48, n.data.info.flagName = "待送货(已拒绝退款)") : 1 == n.data.info.sincetype ? (n.data.info.flag = 41, n.data.info.flagName = "待核销") : 2 == n.data.info.sincetype ? (n.data.info.flag = 42, n.data.info.flagName = "待发货") : 3 == n.data.info.sincetype && (n.data.info.flag = 43, n.data.info.flagName = "待送货") : 1 == n.data.info.after_sale ? (n.data.info.flag = 44, n.data.info.flagName = "申请退款中") : 2 == n.data.info.after_sale && (1 == n.data.info.refund_status ? (n.data.info.flag = 45, n.data.info.flagName = "退款中") : 2 == n.data.info.refund_status ? (n.data.info.flag = 46, n.data.info.flagName = "退款成功") : 3 == n.data.info.refund_status ? (n.data.info.flag = 47, n.data.info.flagName = "退款失败") : 4 == n.data.info.refund_status && (n.data.info.flag = 48, n.data.info.flagName = "拒绝退款"));
                            break;
                        case 30:
                            n.data.info.flag = 7, n.data.info.flagName = "待收货";
                            break;
                        case 40:
                            n.data.info.flag = 5, n.data.info.flagName = "待评价";
                            break;
                        case 60:
                            n.data.info.flag = 6, n.data.info.flagName = "已完成";
                            break;
                        default:
                            n.data.info.flag = -1, n.data.info.flagName = "未知"
                    }
                    if (a.setData({
                        imgRoot: n.other.img_root,
                        info: n.data,
                        show: !0
                    }), 1 == a.data.pageType) {
                        var o = n.data.info.num - n.data.info.write_off_num,
                            f = 1;
                        o <= 0 && (f = 0), a.setData({
                            max: o,
                            min: f,
                            checkNum: f
                        })
                    } else t.qrcode("qrcode", "spell-" + n.data.info.order_no, 360, 360);
                    10 == a.data.info.info.order_status && a.delTimeOut()
                } else i.alert("订单不存在！", function() {
                    a.reloadPrevious(), wx.navigateBack({
                        delta: 1
                    })
                }, 0)
            }).
            catch (function(a) {
                i.tips(a.msg)
            })
        } else i.tips("订单不存在")
    },
    delTimeOut: function() {
        var a = this;
        clearInterval(this.timer);
        var t = parseInt((new Date).getTime() / 1e3),
            n = this.data.info.info.expire_time - 7 - t;
        this.setData({
            downTime: n
        }), this.timer = setInterval(function() {
            a.setData({
                downTime: n
            }), --n <= 0 && (a.setData({
                downTime: n
            }), clearInterval(a.timer), a.reloadPrevious(), i.api.apiPinCancleOrd({
                oid: a.data.oid,
                user_id: a.data.user.id
            }).then(function(a) {}).
            catch (function(a) {
                i.tips(a.msg)
            }), i.alert("订单已过期！", function() {
                wx.navigateBack({
                    delta: 1
                })
            }, 0))
        }, 1e3)
    },
    onCancelTap: function() {
        var a = this;
        i.alert("确定取消该订单？", function() {
            i.api.apiPinCancleOrd({
                oid: a.data.oid,
                user_id: a.data.user.id
            }).then(function(t) {
                i.tips("取消订单成功！"), a.reloadPrevious(), setTimeout(function() {
                    wx.navigateBack({
                        delta: 1
                    })
                }, 1e3)
            }).
            catch (function(a) {
                i.tips(a.msg)
            })
        })
    },
    onTelTap: function(a) {
        i.phone(this.data.info.storeinfo.tel)
    },
    onAddressTap: function() {
        i.map(this.data.info.storeinfo.lat, this.data.info.storeinfo.lng)
    },
    getNum: function(a) {
        this.setData({
            checkNum: a.detail
        })
    },
    onContinuePayTap: function(a) {
        var t = this,
            n = a.detail.formId,
            e = this.data.pay_type;
        if (this.data.payStamp && 1 == e) this.wxpayAjax();
        else {
            var o = 0 == this.data.info.info.heads_id && 0 == this.data.info.info.is_head ? 1 : 1 == this.data.info.info.is_head ? 2 : 3;
            i.api.apiPinAgainPay({
                oid: this.data.info.info.id,
                buytype: o,
                prepay_id: n,
                pay_type: e
            }).then(function(a) {
                "余额支付成功" == a.msg ? (t.setData({
                    payType: !1
                }), wx.showLoading({
                    title: "余额支付成功！"
                }), i.timePass(3e3).then(function() {
                    t.onLoadData(), wx.hideLoading()
                })) : 1 == e && (t.setData({
                    payStamp: a.data
                }), t.wxpayAjax())
            }).
            catch (function(a) {
                i.tips(a.msg)
            })
        }
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
                t.setData({
                    payType: !1
                }), wx.showLoading({
                    title: "支付成功！"
                }), i.timePass(3e3).then(function() {
                    t.onLoadData(), wx.hideLoading()
                })
            },
            fail: function(a) {
                t.data.ajax = !1, i.tips("您已取消支付，请重新支付！")
            }
        })
    },
    onCheckTap: function() {
        var a = this;
        if (this.data.info.info.after_sale > 0) i.tips("已申请售后，无法进行核销！");
        else {
            var t = {
                type: 4,
                order_no: this.data.info.info.order_no,
                num: this.data.checkNum,
                user_id: this.data.user.id
            }, n = "确定核销" + this.data.checkNum + "份商品？",
                e = "核销" + this.data.checkNum + "份商品成功！";
            i.alert(n, function() {
                i.api.apiStoreConfirmAllOrder(t).then(function(t) {
                    i.tips(e), a.reloadPrevious(), setTimeout(function() {
                        wx.navigateBack({
                            delta: 1
                        })
                    }, 1e3)
                }).
                catch (function(a) {
                    i.tips(a.msg)
                })
            })
        }
    },
    onAfterSaleTap: function() {
        var t = this;
        i.alert("确定申请退款？", function() {
            var n = {
                user_id: t.data.user.id,
                oid: t.data.info.info.id
            };
            i.api.apiPinAfterSale(n).then(function(n) {
                var e;
                t.setData((e = {}, a(e, "info.info.flag", 44), a(e, "info.info.flagName", "申请退款中"), e)), t.reloadPrevious(), i.alert("申请退款成功，请耐心等待审核！", function() {
                    t.onLoadData()
                }, 0)
            }).
            catch (function(a) {
                i.tips(a.msg)
            })
        }, function() {})
    },
    onCancleAfterSaleTap: function() {
        var t = this;
        i.alert("确定取消申请退款？", function() {
            var n = {
                user_id: t.data.user.id,
                oid: t.data.info.info.id
            };
            i.api.apiPinCancelAfterSale(n).then(function(n) {
                if (t.reloadPrevious(), 1 == t.data.info.sincetype) {
                    var e;
                    t.setData((e = {}, a(e, "info.info.flag", 41), a(e, "info.info.flagName", "待核销"), e))
                } else if (2 == t.data.info.sincetype) {
                    var o;
                    t.setData((o = {}, a(o, "info.info.flag", 42), a(o, "info.info.flagName", "待发货"), o))
                } else if (3 == t.data.info.sincetype) {
                    var f;
                    t.setData((f = {}, a(f, "info.info.flag", 43), a(f, "info.info.flagName", "待送货"), f))
                }
                i.alert("取消申请退款成功！", function() {
                    t.onLoadData()
                }, 0)
            }).
            catch (function(a) {
                i.tips(a.msg)
            })
        }, function() {})
    },
    onCommentTap: function(a) {
        i.navTo("/base/comment/comment?page=1&id=" + this.data.info.info.id)
    },
    onJoinTap: function(a) {
        var t = this.data.info.headsinfo.id + "-" + this.data.info.goodsinfo.id;
        i.navTo("/plugin/spell/join/join?id=" + t)
    },
    onReceiveTap: function() {
        var t = this;
        i.alert("确定已收到快递？", function() {
            var n = {
                user_id: t.data.user.id,
                oid: t.data.info.info.id
            };
            i.api.apiPinConfirmOrd(n).then(function(i) {
                var n;
                t.reloadPrevious(), t.setData((n = {}, a(n, "info.info.flag", 5), a(n, "info.info.flagName", "待评价"), n)), t.onLoadData()
            }).
            catch (function(a) {
                i.tips(a.msg)
            })
        }, 0)
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
    }
});