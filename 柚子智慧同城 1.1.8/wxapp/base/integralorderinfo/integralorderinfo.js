/*www.lanrenzhijia.com   time:2019-06-01 22:11:54*/
require("../../zhy/template/wxParse/wxParse.js");
var a = getApp();
a.Base({
    data: {
        sending: !1,
        payType: [{
            name: "微信支付",
            pic: "../../zhy/resource/images/wx.png"
        }, {
            name: "余额支付",
            pic: "../../zhy/resource/images/local.png"
        }],
        curPay: 1,
        alert: !1
    },
    onLoad: function(a) {
        this.setData({
            oid: a.id
        })
    },
    onShow: function() {
        var a = this;
        this.checkLogin(function(t) {
            a.setData({
                user: t
            }), a.onLoadData()
        }, "/base/integralorderinfo/integralorderinfo?id=" + this.data.oid)
    },
    onLoadData: function() {
        var t = this;
        a.api.apiIntegralOrderDetails({
            oid: t.data.oid
        }).then(function(e) {
            e.data.goodsinfo.cover = e.other.img_root + e.data.goodsinfo.cover, 2 == e.data.sincetype && a.ajax({
                url: "Cshop|getShop",
                data: {
                    id: e.data.store_id
                },
                success: function(a) {
                    t.setData({
                        shopinfo: a.data
                    })
                }
            }), t.setData({
                goods: e.data,
                show: !0
            })
        }).
        catch (function(t) {
            a.tips(t.msg)
        });
        var e = getCurrentPages();
        e[e.length - 2].setData({
            reload: !0
        })
    },
    changePayType: function(a) {
        this.setData({
            curPay: a.currentTarget.dataset.index
        })
    },
    toggleMask: function() {
        this.setData({
            alert: !this.data.alert
        })
    },
    onCancelTab: function(t) {
        var e = this,
            n = (t.currentTarget.dataset.idx, {
                goods_id: e.data.goods.goodsinfo.id,
                user_id: e.data.user.id,
                oid: e.data.goods.id
            });
        wx.showModal({
            title: "提示",
            content: "确定取消该订单吗！",
            success: function(t) {
                t.confirm ? a.api.apiIntegralCancelOrder(n).then(function(t) {
                    a.tips(t.msg), wx.showModal({
                        title: "提示",
                        content: "订单已取消！",
                        showCancel: !1,
                        success: function(a) {
                            wx.navigateBack({
                                delta: 1
                            })
                        }
                    })
                }).
                catch (function(t) {
                    a.tips(t.msg)
                }) : t.cancel
            }
        })
    },
    onBuyMoneyTab: function() {
        1 == this.data.curPay ? this.rePay() : this.onBalancePay()
    },
    onBalancePay: function() {
        var t = this,
            e = {
                oid: t.data.oid,
                user_id: t.data.user.id,
                goods_id: t.data.goods.goodsinfo.id
            };
        a.api.apiIntegralBalancePay(e).then(function(e) {
            a.tips("兑换成功！"), setTimeout(function() {
                a.reTo("/base/integralorder/integralorder"), t.setData({
                    sending: !1
                })
            }, 1e3)
        }).
        catch (function(e) {
            t.setData({
                sending: !1
            }), a.tips(e.data.msg)
        })
    },
    rePay: function() {
        var t = this;
        if (!t.data.sending) {
            t.setData({
                sending: !0
            });
            var n = {
                oid: t.data.oid,
                user_id: t.data.user.id,
                goods_id: t.data.goods.goodsinfo.id
            };
            a.api.apiIntegralAgainPay(n).then(function(e) {
                wx.requestPayment({
                    timeStamp: e.data.timeStamp,
                    nonceStr: e.data.nonceStr,
                    package: e.data.package,
                    signType: e.data.signType,
                    paySign: e.data.paySign,
                    success: function(e) {
                        a.tips("兑换成功！"), setTimeout(function() {
                            a.reTo("/base/integralorder/integralorder"), t.setData({
                                sending: !1
                            })
                        }, 1e3)
                    },
                    fail: function(e) {
                        t.setData({
                            sending: !1
                        }), a.tips("您已取消支付，请重新支付！")
                    }
                })
            }).
            catch (function(n) {
                t.setData({
                    sending: !1
                }), a.tips(e.data.msg)
            })
        }
    },
    onCheckReceiveTab: function() {
        var t = this;
        wx.showModal({
            title: "提示",
            content: "确定已经收到快递！",
            success: function(n) {
                n.confirm ? a.api.apiIntegralCheckGet({
                    oid: t.data.oid
                }).then(function(t) {
                    a.tips("收货成功！"), setTimeout(function() {
                        a.reTo("/cysc_sun/pages/public/pages/integralorder/integralorder")
                    }, 1e3)
                }).
                catch (function(n) {
                    t.setData({
                        sending: !1
                    }), a.tips(e.data.msg)
                }) : n.cancel
            }
        })
    },
    onGPStab: function() {
        var a = this.data.shopinfo.latitude - 0,
            t = this.data.shopinfo.longitude - 0;
        wx.openLocation({
            latitude: a,
            longitude: t,
            scale: 28
        })
    },
    onDelectTab: function(t) {
        var e = this;
        wx.showModal({
            title: "提示",
            content: "确定删除该订单记录！",
            success: function(n) {
                n.confirm ? a.api.apiIntegralDelOrd({
                    oid: e.data.oid
                }).then(function(t) {
                    a.tips("删除成功！"), setTimeout(function() {
                        a.reTo("/cysc_sun/pages/public/pages/integralorder/integralorder")
                    }, 1e3)
                }).
                catch (function(e) {
                    a.tips(t.data.msg)
                }) : n.cancel
            }
        })
    }
});