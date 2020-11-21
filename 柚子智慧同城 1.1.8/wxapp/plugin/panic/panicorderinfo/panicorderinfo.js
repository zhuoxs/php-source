/*www.lanrenzhijia.com   time:2019-06-01 22:11:49*/
function a(a, t, e) {
    return t in a ? Object.defineProperty(a, t, {
        value: e,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : a[t] = e, a
}
var t = require("../../../zhy/resource/js/index.js"),
    e = getApp();
e.Base({
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
        this.data.reload && (this.checkLogin(function(t) {
            a.setData({
                user: t
            }), a.onLoadData()
        }, "/plugin/panic/panicorderinfo/panicorderinfo"), this.data.reload = !1)
    },
    onUnload: function() {
        clearInterval(this.timer)
    },
    onLoadData: function() {
        var a = this;
        if (this.data.oid > 0) {
            var i = {};
            0 == this.data.pageType ? i.oid = this.data.oid : 1 == this.data.pageType && (i.order_no = this.data.oid), e.api.apiPanicOrderInfo(i).then(function(i) {
                if ("订单不存在" != i.msg) {
                    switch (i.data.order_status - 0) {
                        case 5:
                            i.data.flag = 1, i.data.flagName = "订单已取消";
                            break;
                        case 10:
                            (new Date).getTime() / 1e3 > i.data.expire_time ? (i.data.flag = 6, i.data.flagName = "订单已过期") : (i.data.flag = 2, i.data.flagName = "待支付");
                            break;
                        case 20:
                            0 == i.data.after_sale ? 4 == i.data.refund_status ? 1 == i.data.sincetype ? (i.data.flag = 38, i.data.flagName = "待核销(已拒绝退款)") : 2 == i.data.sincetype ? (i.data.flag = 39, i.data.flagName = "待发货(已拒绝退款)") : 3 == i.data.sincetype && (i.data.flag = 38, i.data.flagName = "待送货(已拒绝退款)") : 1 == i.data.sincetype ? (i.data.flag = 31, i.data.flagName = "待核销") : 2 == i.data.sincetype ? (i.data.flag = 32, i.data.flagName = "待发货") : 3 == i.data.sincetype && (i.data.flag = 33, i.data.flagName = "待送货") : 1 == i.data.after_sale ? (i.data.flag = 34, i.data.flagName = "申请退款中") : 2 == i.data.after_sale && (1 == i.data.refund_status ? (i.data.flag = 35, i.data.flagName = "退款中") : 2 == i.data.refund_status ? (i.data.flag = 36, i.data.flagName = "退款成功") : 3 == i.data.refund_status ? (i.data.flag = 37, i.data.flagName = "退款失败") : 4 == i.data.refund_status && (i.data.flag = 38, i.data.flagName = "拒绝退款"));
                            break;
                        case 30:
                            i.data.flag = 7, i.data.flagName = "确认收货";
                            break;
                        case 40:
                            i.data.flag = 4, i.data.flagName = "待评价";
                            break;
                        case 60:
                            i.data.flag = 5, i.data.flagName = "已完成";
                            break;
                        default:
                            i.data.flag = -1, i.data.flagName = "未知"
                    }
                    if (a.setData({
                        imgRoot: i.other.img_root,
                        info: i.data,
                        show: !0
                    }), 1 == a.data.pageType) {
                        var n = i.data.num - i.data.write_off_num,
                            o = 1;
                        n <= 0 && (o = 0), a.setData({
                            max: n,
                            min: o,
                            checkNum: o
                        })
                    } else t.qrcode("qrcode", "panic-" + i.data.order_no, 360, 360);
                    10 == a.data.info.order_status && a.delTimeOut()
                } else e.alert("订单不存在！", function() {
                    a.reloadPrevious(), wx.navigateBack({
                        delta: 1
                    })
                }, 0)
            }).
            catch (function(a) {
                e.tips(a.msg)
            })
        }
    },
    delTimeOut: function() {
        var a = this;
        clearInterval(this.timer);
        var t = parseInt((new Date).getTime() / 1e3),
            i = this.data.info.expire_time - 3 - t;
        this.setData({
            downTime: i
        }), this.timer = setInterval(function() {
            a.setData({
                downTime: i
            }), --i <= 0 && (a.setData({
                downTime: i
            }), clearInterval(a.timer), a.reloadPrevious(), e.api.apiPanicCancelOrder({
                oid: a.data.oid,
                user_id: a.data.user.id
            }).then(function(a) {}).
            catch (function(a) {
                e.tips(a.msg)
            }), e.alert("订单已过期！", function() {
                wx.navigateBack({
                    delta: 1
                })
            }, 0))
        }, 1e3)
    },
    onCancelTap: function() {
        var a = this;
        e.alert("确定取消该订单？", function() {
            e.api.apiPanicCancelOrder({
                oid: a.data.oid,
                user_id: a.data.user.id
            }).then(function(t) {
                e.tips("取消订单成功！"), a.reloadPrevious(), setTimeout(function() {
                    wx.navigateBack({
                        delta: 1
                    })
                }, 1e3)
            }).
            catch (function(a) {
                e.tips(a.msg)
            })
        })
    },
    onTelTap: function(a) {
        e.phone(this.data.info.store.tel)
    },
    onAddressTap: function() {
        e.map(this.data.info.store.lat, this.data.info.store.lng)
    },
    getNum: function(a) {
        this.setData({
            checkNum: a.detail
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
    onContinuePayTap: function() {
        var t = this,
            i = this.data.pay_type;
        console.log(i);
        var n = {
            oid: this.data.info.id
        };
        if (this.data.payStamp && 1 == i) return console.log("999"), void this.wxpayAjax();
        n.pay_type = 1 == i ? 1 : 2, e.api.apiPanicPayAgain(n).then(function(n) {
            "余额支付成功" == n.msg && setTimeout(function() {
                var i = 1;
                setTimeout(function() {
                    i = 0
                }, 4e3), e.alert("购买成功！", function() {
                    if (0 == i) {
                        var n;
                        t.setData((n = {
                            payType: !1
                        }, a(n, "info.flag", 31), a(n, "info.flagName", "待核销"), n))
                    } else e.tips("页面跳转中..."), setTimeout(function() {
                        var e;
                        t.setData((e = {
                            payType: !1
                        }, a(e, "info.flag", 31), a(e, "info.flagName", "待核销"), e))
                    }, 2e3)
                }, function() {
                    _this.onHomeTab()
                }, "提示", "返回首页", "订单详情")
            }, 1e3), 1 == i && (t.setData({
                payType: !1,
                payStamp: n.data
            }), t.wxpayAjax())
        }).
        catch (function(a) {
            e.tips(a.msg)
        })
    },
    wxpayAjax: function() {
        console.log("000");
        var t = this.data.payStamp,
            i = this;
        wx.requestPayment({
            timeStamp: t.timeStamp,
            nonceStr: t.nonceStr,
            package: t.package,
            signType: t.signType,
            paySign: t.paySign,
            success: function(t) {
                var n = this;
                setTimeout(function() {
                    var t = 1;
                    setTimeout(function() {
                        t = 0
                    }, 4e3), e.alert("购买成功！", function() {
                        if (0 == t) {
                            var i;
                            n.setData((i = {
                                payType: !1
                            }, a(i, "info.flag", 31), a(i, "info.flagName", "待核销"), i))
                        } else e.tips("页面跳转中..."), setTimeout(function() {
                            var t;
                            n.setData((t = {
                                payType: !1
                            }, a(t, "info.flag", 31), a(t, "info.flagName", "待核销"), t))
                        }, 2e3)
                    }, function() {
                        i.onHomeTab()
                    }, "提示", "返回首页", "订单详情")
                }, 1e3)
            },
            fail: function(a) {
                i.data.ajax = !1, e.tips("您已取消支付，请重新支付！")
            }
        })
    },
    onCheckTap: function() {
        var a = this,
            t = {
                type: 2,
                order_no: this.data.info.order_no,
                num: this.data.checkNum,
                user_id: this.data.user.id
            }, i = "确定核销" + this.data.checkNum + "份商品？",
            n = "核销" + this.data.checkNum + "份商品成功！";
        e.alert(i, function() {
            e.api.apiStoreConfirmAllOrder(t).then(function(t) {
                e.tips(n), a.reloadPrevious(), setTimeout(function() {
                    wx.navigateBack({
                        delta: 1
                    })
                }, 1e3)
            }).
            catch (function(a) {
                e.tips(a.msg)
            })
        })
    },
    onAfterSaleTap: function() {
        var t = this;
        e.alert("确定申请退款？", function() {
            var i = {
                user_id: t.data.user.id,
                oid: t.data.info.id
            };
            e.api.apiPanicAfterSale(i).then(function(i) {
                var n;
                t.setData((n = {}, a(n, "info.flag", 34), a(n, "info.flagName", "申请退款中"), n)), t.reloadPrevious(), e.alert("申请退款成功，请耐心等待审核！", function() {
                    return !1
                }, 0)
            }).
            catch (function(a) {
                e.tips(a.msg)
            })
        }, 0)
    },
    onCancleAfterSaleTap: function() {
        var t = this;
        e.alert("确定取消申请退款？", function() {
            var i = {
                user_id: t.data.user.id,
                oid: t.data.info.id
            };
            e.api.apiPanicCancelAfterSale(i).then(function(i) {
                if (t.reloadPrevious(), 1 == t.data.info.sincetype) {
                    var n;
                    t.setData((n = {}, a(n, "info.flag", 31), a(n, "info.flagName", "待核销"), n))
                } else if (2 == t.data.info.sincetype) {
                    var o;
                    t.setData((o = {}, a(o, "info.flag", 32), a(o, "info.flagName", "待发货"), o))
                } else if (3 == t.data.info.sincetype) {
                    var s;
                    t.setData((s = {}, a(s, "info.flag", 33), a(s, "info.flagName", "待送货"), s))
                }
                e.alert("取消申请退款成功！", function() {
                    return !1
                }, 0)
            }).
            catch (function(a) {
                e.tips(a.msg)
            })
        }, 0)
    },
    onCommentTap: function(a) {
        e.navTo("/base/comment/comment?page=0&id=" + this.data.info.id)
    },
    onReceiveTap: function() {
        var t = this;
        e.alert("确定已收到快递？", function() {
            var i = {
                user_id: t.data.user.id,
                oid: t.data.info.id
            };
            e.api.apiPanicConfirmOrd(i).then(function(e) {
                var i;
                t.reloadPrevious(), t.setData((i = {}, a(i, "info.flag", 4), a(i, "info.flagName", "待评价"), i))
            }).
            catch (function(a) {
                e.tips(a.msg)
            })
        }, 0)
    }
});