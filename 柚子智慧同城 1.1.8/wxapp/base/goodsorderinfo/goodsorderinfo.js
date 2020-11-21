/*www.lanrenzhijia.com   time:2019-06-01 22:11:54*/
var a = getApp(),
    t = require("../../zhy/resource/js/index.js");
a.Base({
    data: {
        pay_type: 1
    },
    onLoad: function(a) {
        var t = this;
        this.checkLogin(function(e) {
            t.setData({
                user_id: e.id,
                order_id: a.id
            }), t.onLoadData()
        }, "/base/goodsorderinfo/goodsorderinfo")
    },
    onLoadData: function() {
        var e = this,
            i = {
                order_id: this.data.order_id
            };
        a.api.apiOrderGetOrderDetail(i).then(function(a) {
            new Date(a.data.goods.end_time.replace(/-/g, "/")).getTime() < (new Date).getTime() && e.setData({
                goods_overdue: !0
            });
            var i = a.data,
                d = 0;
            t.qrcode("qrcode", "goods-" + a.data.order_no, 276, 276), i.detail.forEach(function(a, t) {
                d += a.total_price - 0
            }), e.setData({
                order: a.data,
                img_root: a.other.img_root,
                countPrice: d.toFixed(2),
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
    payNow: function(t) {
        var e = this,
            i = this,
            d = this.data.pay_type,
            o = i.data.ajax;
        this.data.order_id;
        if (i.data.order.goods.stock <= 0) a.tips("库存不足！");
        else if (!o) if (i.setData({
            ajax: !0
        }), i.data.order_id && 2 != d) {
            var n = {
                order_id: i.data.order_id
            };
            a.api.apiOrderGetWxParamByOrderId(n).then(function(t) {
                t.data && wx.requestPayment({
                    appId: t.data.appId,
                    nonceStr: t.data.nonceStr,
                    package: t.data.package,
                    paySign: t.data.paySign,
                    prepay_id: t.data.prepay_id,
                    signType: t.data.signType,
                    timeStamp: t.data.timeStamp,
                    success: function(t) {
                        i.setData({
                            payType: !1,
                            ajax: !1
                        }), a.tips("支付成功，去使用"), setTimeout(function() {
                            i.onLoadData()
                        }, 1500)
                    },
                    fail: function() {
                        i.setData({
                            buttonName: "继续支付",
                            ajax: !1
                        })
                    }
                })
            }).
            catch (function(t) {
                i.setData({
                    ajax: !1
                }), a.tips(t.msg)
            })
        } else if (!i.data.order_id || 2 == d) {
            var r = {
                order_id: this.data.order_id,
                pay_type: 2
            }, s = wx.getStorageSync("s_id");
            s && s > 0 && (r.share_user_id = s), a.api.apiOrderGetWxParamByOrderId(r).then(function(t) {
                return t.data.order_id && i.setData({
                    order_id: t.data.order_id || 0
                }), "余额支付成功" == t.data ? (a.tips("余额支付成功，去使用!"), setTimeout(function() {
                    i.onLoadData()
                }, 1500), void i.setData({
                    payType: !1,
                    ajax: !1
                })) : "0.00" == i.data.order.order.order_amount && 2 != d ? (a.tips("支付成功！"), setTimeout(function() {
                    i.onLoadData()
                }, 1500), void i.setData({
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
                        i.setData({
                            payType: !1,
                            ajax: !1
                        }), a.tips("支付成功！"), setTimeout(function() {
                            i.onLoadData()
                        }, 1500)
                    },
                    fail: function() {
                        i.setData({
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
    },
    onCancelOrderTap: function() {
        var t = this,
            e = t.data.ajax,
            i = {
                order_id: this.data.order_id
            };
        e || (t.setData({
            ajax: !0
        }), a.api.apiOrderCancelOrder(i).then(function(e) {
            a.tips("取消订单成功！"), setTimeout(function() {
                wx.navigateBack({})
            }, 1500), t.setData({
                ajax: !1
            })
        }).
        catch (function(e) {
            t.setData({
                ajax: !1
            }), a.tips(e.msg)
        }))
    },
    onRefundTap: function() {
        var t = this;
        t.data.ajax || (t.setData({
            ajax: !0
        }), wx.showModal({
            title: "提示",
            content: "确定申请退款？",
            success: function(e) {
                if (e.confirm) {
                    var i = {
                        order_id: t.data.order_id,
                        user_id: t.data.user_id
                    };
                    a.api.apiOrderSetOrderRefund(i).then(function(e) {
                        a.alert("已提交,等待后台通过退款申请", function() {
                            wx.navigateBack({
                                delta: 1
                            })
                        }, 0), t.setData({
                            ajax: !1
                        })
                    }).
                    catch (function(e) {
                        t.setData({
                            ajax: !1
                        }), a.tips(e.msg)
                    })
                } else t.setData({
                    ajax: !1
                })
            }
        }))
    },
    onDeleteTap: function() {
        var t = this,
            e = t.data.ajax,
            i = {
                order_id: this.data.order_id
            };
        e || (t.setData({
            ajax: !0
        }), a.api.apiOrderDelOrder(i).then(function(e) {
            a.tips("删除订单成功！"), setTimeout(function() {
                wx.navigateBack({})
            }, 1500), t.setData({
                ajax: !1
            })
        }).
        catch (function(e) {
            t.setData({
                ajax: !1
            }), a.tips(e.msg)
        }))
    },
    onCancelRefundTap: function() {
        var t = this;
        t.data.ajax || (t.setData({
            ajax: !0
        }), wx.showModal({
            title: "提示",
            content: "确定取消退款？",
            success: function(e) {
                if (e.confirm) {
                    var i = {
                        order_id: t.data.order_id,
                        user_id: t.data.user_id
                    };
                    a.api.apiOrderCancelOrderRefund(i).then(function(e) {
                        a.tips("已取消退款申请,订单回到待使用"), setTimeout(function() {
                            wx.navigateBack({
                                delta: 1
                            })
                        }, 1500), t.setData({
                            ajax: !1
                        })
                    }).
                    catch (function(e) {
                        t.setData({
                            ajax: !1
                        }), e.code, a.tips(e.msg)
                    })
                } else a.tips(e.msg), t.setData({
                    ajax: !1
                })
            }
        }))
    },
    onTelTap: function() {
        var t = this.data.order.store.tel;
        a.phone(t)
    },
    onEvaluationTap: function() {
        a.navTo("/base/goodscomment/goodscomment?page=0&id=" + this.data.order_id)
    }
});