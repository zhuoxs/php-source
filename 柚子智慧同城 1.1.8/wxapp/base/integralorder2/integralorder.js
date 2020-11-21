/*www.lanrenzhijia.com   time:2019-06-01 22:11:54*/
var a = require("../../zhy/template/wxParse/wxParse.js"),
    t = getApp();
t.Base({
    data: {
        oid: 0,
        payType: [{
            name: "微信支付",
            pic: "../../zhy/resource/images/wx.png"
        }, {
            name: "余额支付",
            pic: "../../zhy/resource/images/local.png"
        }],
        curPay: 1,
        expressType: [{
            name: "快递",
            value: 1,
            checked: "true"
        }],
        expressChoose: 1,
        expressInfo: !1,
        addressFalse: !0,
        shopChoose: 0,
        remark: "",
        sending: !1,
        alert: !1
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
        var e = this;
        this.checkLogin(function(t) {
            e.setData({
                user: t,
                param: JSON.parse(a.id)
            }), e.onLoadData()
        }, "/base/integralorder2/integralorder?id=" + a.id)
    },
    onLoadData: function() {
        var e = this,
            s = getCurrentPages();
        s[s.length - 2].setData({
            reload: !0
        });
        var n = wx.getStorageSync("expressInfo");
        n && (this.setData({
            expressInfo: n,
            uName: n.userName,
            uPhone: n.telNumber
        }), this.checkFee()), t.api.apiIntegralGoodsDetails({
            id: e.data.param.goods_id
        }).then(function(t) {
            for (var s in t.data.pics) t.data.pics[s] = t.other.img_root + t.data.pics[s];
            t.data.cover = t.other.img_root + t.data.cover, a.wxParse("content", "html", t.data.details, e, 0), e.setData({
                info: t.data,
                show: !0
            })
        }).
        catch (function(a) {
            t.tips(a.msg)
        })
    },
    checkFee: function() {
        var a = this,
            e = {
                goods_id: this.data.param.goods_id,
                num: this.data.param.num,
                province: this.data.expressInfo.provinceName,
                city: this.data.expressInfo.cityName,
                area: this.data.expressInfo.countyName
            };
        t.api.apiIntegralGetDistribution(e).then(function(e) {
            a.setData({
                fee: e.data.distribution
            })
        }).
        catch (function(a) {
            t.tips(a.msg)
        })
    },
    expressChange: function(a) {
        this.setData({
            expressChoose: a.detail.value
        })
    },
    bindPickerChange: function(a) {
        this.setData({
            shopChoose: a.detail.value
        })
    },
    getUName: function(a) {
        this.setData({
            uName: a.detail.value
        })
    },
    getUPhone: function(a) {
        this.setData({
            uPhone: a.detail.value
        })
    },
    getRemark: function(a) {
        this.setData({
            remark: a.detail.value
        })
    },
    toggleMask: function() {
        this.setData({
            alert: !this.data.alert
        })
    },
    changePayType: function(a) {
        this.setData({
            curPay: a.currentTarget.dataset.index
        })
    },
    onBuyTab: function(a) {
        var e = this,
            s = {
                prepay_id: a.detail.formId,
                user_id: e.data.user.id,
                goods_id: e.data.param.goods_id,
                total_num: e.data.param.num,
                store_id: "",
                order_amount: "",
                sincetype: e.data.expressChoose,
                distribution: "",
                name: "",
                phone: "",
                province: "",
                city: "",
                area: "",
                address: "",
                remark: e.data.remark
            };
        1 == e.data.expressChoose && (s.order_amount = e.data.fee, s.distribution = e.data.fee, s.name = e.data.expressInfo.userName, s.phone = e.data.expressInfo.telNumber, s.province = e.data.expressInfo.provinceName, s.city = e.data.expressInfo.cityName, s.area = e.data.expressInfo.countyName, s.address = e.data.expressInfo.detailInfo), !s.name || s.name.length < 1 ? t.tips("请输入正确的收货人姓名！") : s.phone.length < 11 ? t.tips("请输入正确的联系电话！") : (e.setData({
            params: s
        }), 1 == e.data.expressChoose && e.data.fee > 0 ? e.toggleMask() : e.ajaxPay())
    },
    onBuyMoneyTab: function() {
        this.data.params.pay_type = this.data.curPay, this.data.oid > 0 ? 1 == this.data.params.pay_type ? this.rePay() : this.onBalancePay() : this.ajaxPay()
    },
    ajaxPay: function() {
        var a = this;
        a.data.sending || (a.setData({
            sending: !0
        }), t.api.apiIntegralBuy(a.data.params).then(function(e) {
            a.setData({
                oid: e.other.oid
            }), 0 == e.data ? (t.tips("兑换成功！"), setTimeout(function() {
                t.reTo("/base/integralorder/integralorder"), a.setData({
                    sending: !1
                })
            }, 1e3)) : 1 == a.data.params.pay_type ? wx.requestPayment({
                timeStamp: e.data.timeStamp,
                nonceStr: e.data.nonceStr,
                package: e.data.package,
                signType: e.data.signType,
                paySign: e.data.paySign,
                success: function(e) {
                    setTimeout(function() {
                        t.reTo("/base/integralorder/integralorder"), a.setData({
                            sending: !1
                        })
                    }, 1e3), t.tips("兑换成功！")
                },
                fail: function(e) {
                    a.setData({
                        sending: !1
                    }), t.tips("您已取消支付，请重新支付！")
                }
            }) : a.onBalancePay()
        }).
        catch (function(s) {
            a.setData({
                sending: !1
            }), t.tips(e.data.msg)
        }))
    },
    onBalancePay: function() {
        var a = this,
            e = {
                oid: a.data.oid,
                user_id: a.data.user.id,
                goods_id: a.data.param.goods_id
            };
        t.api.apiIntegralBalancePay(e).then(function(e) {
            t.tips("兑换成功！"), setTimeout(function() {
                t.reTo("/base/integralorder/integralorder"), a.setData({
                    sending: !1
                })
            }, 1e3)
        }).
        catch (function(e) {
            a.setData({
                sending: !1
            }), e.data ? t.tips(e.data.msg) : t.tips("您已取消支付，请重新支付！")
        })
    },
    rePay: function() {
        var a = this;
        if (!a.data.sending) {
            a.setData({
                sending: !0
            });
            var s = {
                oid: a.data.oid,
                user_id: a.data.user.id,
                goods_id: a.data.param.goods_id
            };
            t.api.apiIntegralAgainPay(s).then(function(e) {
                wx.requestPayment({
                    timeStamp: e.data.timeStamp,
                    nonceStr: e.data.nonceStr,
                    package: e.data.package,
                    signType: e.data.signType,
                    paySign: e.data.paySign,
                    success: function(e) {
                        t.tips("兑换成功！"), setTimeout(function() {
                            t.reTo("/base/integralorder/integralorder"), a.setData({
                                sending: !1
                            })
                        }, 1e3)
                    },
                    fail: function(e) {
                        a.setData({
                            sending: !1
                        }), t.tips("您已取消支付，请重新支付！")
                    }
                })
            }).
            catch (function(s) {
                a.setData({
                    sending: !1
                }), t.tips(e.data.msg)
            })
        }
    }
});