var app = getApp();

Page({
    data: {
        money: "",
        flag: !1
    },
    onLoad: function(a) {
        this.onLoadData();
    },
    onLoadData: function() {
        var t = this, a = wx.getStorageSync("userInfo");
        a ? app.ajax({
            url: "Crecharge|recharge",
            data: {
                user_id: a.id
            },
            success: function(a) {
                t.setData({
                    info: a.data,
                    show: !0
                });
            }
        }) : wx.showModal({
            title: "提示",
            content: "您未登陆，请先登陆！",
            success: function(a) {
                if (a.confirm) {
                    var t = encodeURIComponent("/sqtg_sun/pages/public/pages/mybalance/mybalance");
                    app.reTo("/sqtg_sun/pages/home/login/login?id=" + t);
                } else a.cancel && app.lunchTo("/sqtg_sun/pages/home/index/index");
            }
        });
    },
    blurMoney: function(a) {
        var t = (a.detail.value.trim() - 0).toFixed(2);
        isNaN(t) ? (this.setData({
            money: this.data.money
        }), this.tips("请输入正确的洗车券单价！")) : this.setData({
            money: t
        });
    },
    inputMoney: function(a) {
        var t = a.detail.value;
        isNaN(t) && (t = this.data.money), this.setData({
            money: t
        });
    },
    onPayTab: function() {
        this.data.money >= this.data.info.recharge.recharge_lowest ? (this.setData({
            smoney: 0
        }), this.pay()) : app.tips("最低充值额度为" + this.data.info.recharge.recharge_lowest + "元");
    },
    onCardTab: function(a) {
        var t = a.currentTarget.dataset.idx;
        this.setData({
            money: this.data.info.recharge.details[t].money,
            smoney: this.data.info.recharge.details[t].send_money
        }), this.pay();
    },
    pay: function() {
        var s = this;
        if (!s.data.flag) {
            s.setData({
                flag: !0
            });
            var a = {
                user_id: wx.getStorageSync("userInfo").id,
                recmoney: this.data.money,
                send_money: this.data.smoney
            };
            if (this.data.money <= 0) return s.setData({
                flag: !1
            }), void app.tips("请输入金额！");
            app.ajax({
                url: "Crecharge|pay",
                data: a,
                success: function(a) {
                    wx.requestPayment({
                        timeStamp: a.data.timeStamp,
                        nonceStr: a.data.nonceStr,
                        package: a.data.package,
                        signType: a.data.signType,
                        paySign: a.data.paySign,
                        success: function(a) {
                            s.setData({
                                flag: !1
                            }), s.onLoadData();
                            var t = getCurrentPages(), e = t[t.length - 2], n = t[t.length - 3];
                            e.setData({
                                reload: !0
                            }), n.setData({
                                reload: !0
                            }), app.tips("充值成功！");
                        },
                        fail: function(a) {
                            s.setData({
                                flag: !1
                            }), app.tips("您已取消充值，请重新充值！");
                        }
                    });
                },
                fail: function(a) {
                    s.setData({
                        flag: !1
                    });
                }
            });
        }
    }
});