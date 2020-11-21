/*www.lanrenzhijia.com   time:2019-06-01 22:11:54*/
var a = getApp();
a.Base({
    data: {
        money: "",
        flag: !1
    },
    onLoad: function(a) {
        var t = this;
        this.checkLogin(function(a) {
            t.setData({
                user: a
            }), t.onLoadData(a)
        }, "/base/recharge/recharge")
    },
    onLoadData: function(t) {
        var e = this;
        a.api.ApiRechargeRecharge({
            user_id: this.data.user.id
        }).then(function(a) {
            e.setData({
                info: a.data,
                show: !0
            })
        }).
        catch (function(t) {
            a.tips(t.msg)
        })
    },
    blurMoney: function(a) {
        var t = (a.detail.value.trim() - 0).toFixed(2);
        isNaN(t) ? (this.setData({
            money: this.data.money
        }), this.tips("请输入正确的金额！")) : this.setData({
            money: t
        })
    },
    inputMoney: function(a) {
        var t = a.detail.value;
        isNaN(t) && (t = this.data.money), this.setData({
            money: t
        })
    },
    onPayTab: function() {
        this.data.money >= this.data.info.recharge.recharge_lowest ? (this.setData({
            smoney: 0
        }), this.pay()) : a.tips("最低充值额度为" + this.data.info.recharge.recharge_lowest + "元")
    },
    onCardTab: function(a) {
        var t = a.currentTarget.dataset.idx;
        this.setData({
            money: this.data.info.recharge.details[t].money,
            smoney: this.data.info.recharge.details[t].send_money
        }), this.pay()
    },
    pay: function() {
        var t = this;
        if (!t.data.flag) {
            t.setData({
                flag: !0
            });
            var e = {
                user_id: this.data.user.id,
                recmoney: this.data.money,
                send_money: this.data.smoney
            };
            if (this.data.money <= 0) return t.setData({
                flag: !1
            }), void a.tips("请输入金额！");
            a.api.apiRechargePay(e).then(function(e) {
                wx.requestPayment({
                    timeStamp: e.data.timeStamp,
                    nonceStr: e.data.nonceStr,
                    package: e.data.package,
                    signType: e.data.signType,
                    paySign: e.data.paySign,
                    success: function(e) {
                        t.setData({
                            flag: !1
                        }), a.tips("充值成功！"), t.onLoadData()
                    },
                    fail: function(e) {
                        t.setData({
                            flag: !1
                        }), a.tips("您已取消充值，请重新充值！")
                    }
                })
            }).
            catch (function(t) {
                a.tips(t.msg)
            })
        }
    }
});