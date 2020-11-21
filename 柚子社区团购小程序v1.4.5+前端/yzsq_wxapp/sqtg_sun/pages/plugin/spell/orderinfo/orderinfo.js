var app = getApp(), wxbarcode = require("../../../../../zhy/resource/js/index.js");

function getTimeStr(a) {
    return a = (a = a.replace(/-/g, ":").replace(" ", ":")).split(":"), new Date(a[0], a[1] - 1, a[2], a[3], a[4], a[5]).getTime() / 1e3;
}

Page({
    data: {
        downTime: 0,
        payType: [ {
            name: "微信支付",
            pic: "../../../../../zhy/resource/images/wx.png"
        }, {
            name: "余额支付",
            pic: "../../../../../zhy/resource/images/local.png"
        } ],
        curPay: 1,
        alert: !1,
        ajax: !1
    },
    onLoad: function(a) {
        this.setData({
            oid: a.id
        }), this.onLoadData();
    },
    onUnload: function() {
        clearInterval(this.timer);
    },
    onLoadData: function() {
        var s = this;
        app.api.getCpinOrderDetails({
            oid: this.data.oid
        }).then(function(a) {
            wxbarcode.qrcode("qrcode", "hx-spell-" + a.data.info.order_num, 360, 360), clearInterval(s.timer);
            var t = new Date().getTime() / 1e3, i = getTimeStr(a.data.info.create_time), e = 60 * (a.data.goodsinfo.pay_time - 0), n = t - i, o = 0;
            0 < e - n - 10 && (o = e - n - 10), s.setData({
                downTime: o
            }), 0 == a.data.info.order_status && (s.timer = setInterval(function() {
                s.setData({
                    downTime: o
                }), --o <= 0 && (clearInterval(s.timer), wx.showModal({
                    title: "提示",
                    content: "订单已过期！",
                    showCancel: !1,
                    success: function(a) {
                        wx.navigateBack({
                            delta: 1
                        });
                    }
                }));
            }, 1e3)), console.log(a.data), s.setData({
                imgRoot: a.other.img_root,
                info: a.data,
                show: !0
            });
        }).catch(function(a) {
            -1 == a.code ? app.tips(a.msg) : "订单失效" == a.msg ? wx.showModal({
                title: "提示",
                content: a.msg,
                showCancel: !1,
                success: function(a) {
                    wx.navigateBack({
                        delta: 1
                    });
                }
            }) : app.tips(a.msg);
        });
    },
    toggleMask: function() {
        this.setData({
            alert: !this.data.alert
        });
    },
    changePayType: function(a) {
        this.setData({
            curPay: a.currentTarget.dataset.index
        });
    },
    onBuyMoneyTab: function() {
        1 == this.data.curPay ? this.rePayWX() : this.rePayTips();
    },
    rePayWX: function() {
        var t = this, n = this, a = wx.getStorageSync("linkaddress");
        if (!this.data.ajax) {
            this.setData({
                ajax: !0
            });
            var i = {
                oid: this.data.oid,
                leader_id: a.id
            };
            0 == this.data.info.info.heads_id ? i.buytype = 1 : 1 == this.data.info.info.is_head ? i.buytype = 2 : i.buytype = 3, 
            app.api.getCpinAgainPay(i).then(function(a) {
                wx.requestPayment({
                    timeStamp: a.data.timeStamp,
                    nonceStr: a.data.nonceStr,
                    package: a.data.package,
                    signType: a.data.signType,
                    paySign: a.data.paySign,
                    success: function(a) {
                        if (0 < n.data.info.info.heads_id) {
                            app.tips("参团成功！");
                            var t = wx.getStorageSync("userInfo"), i = wx.getStorageSync("linkaddress"), e = n.data.info.info.heads_id + "-" + n.data.info.goodsinfo.id + "-" + t.id + "-" + i.id;
                            setTimeout(function() {
                                n.setData({
                                    ajax: !1,
                                    alert: !1
                                }), app.lunchTo("/sqtg_sun/pages/plugin/spell/join/join?id=" + e);
                            }, 1e3);
                        } else app.tips("购买成功！"), n.setData({
                            ajax: !1,
                            alert: !1
                        }), n.onLoadData();
                    },
                    fail: function(a) {
                        n.setData({
                            ajax: !1
                        }), app.tips("您已取消支付，请重新支付！");
                    }
                });
            }).catch(function(a) {
                t.setData({
                    ajax: !1
                }), a.code, app.tips(a.msg);
            });
        }
    },
    rePayTips: function() {
        var i = this, e = this;
        if (!this.data.ajax) {
            this.setData({
                ajax: !0
            });
            var a = {
                oid: this.data.oid
            };
            0 == this.data.info.info.heads_id ? a.buytype = 1 : 1 == this.data.info.info.is_head ? a.buytype = 2 : a.buytype = 3, 
            app.api.getCpinBalancePay(a).then(function(a) {
                if (0 < e.data.info.info.heads_id) {
                    app.tips("参团成功！");
                    var t = e.data.info.info.heads_id + "-" + e.data.info.goodsinfo.id;
                    setTimeout(function() {
                        e.setData({
                            ajax: !1,
                            alert: !1
                        }), app.reTo("/sqtg_sun/pages/plugin/spell/join/join?id=" + t);
                    }, 1e3);
                } else app.tips("购买成功！"), i.setData({
                    ajax: !1,
                    alert: !1
                }), e.onLoadData();
            }).catch(function(a) {
                i.setData({
                    ajax: !1
                }), a.code, app.tips(a.msg);
            });
        }
    },
    onCancleOrderTab: function() {
        var t = this, i = wx.getStorageSync("userInfo");
        wx.showModal({
            title: "提示",
            content: "确定取消该订单？",
            success: function(a) {
                a.confirm && app.api.getCpinCancleOrd({
                    oid: t.data.oid,
                    user_id: i.id
                }).then(function(a) {
                    app.tips("订单已取消！"), setTimeout(function() {
                        wx.navigateBack({
                            delta: 1
                        });
                    }, 1e3);
                }).catch(function(a) {
                    a.code, app.tips(a.msg);
                });
            }
        });
    },
    onBtnTab: function() {
        var t = this;
        if (1 == this.data.info.info.order_status) {
            console.log(this.data.info.info);
            var a = wx.getStorageSync("userInfo"), i = this.data.info.info.heads_id + "-" + this.data.info.goodsinfo.id + "-" + a.id + "-" + this.data.info.leader.id;
            app.reTo("/sqtg_sun/pages/plugin/spell/join/join?id=" + i);
        } else if (3 == this.data.info.info.order_status && 1 == this.data.info.info.sincetype || 4 == this.data.info.info.order_status && 2 == this.data.info.info.sincetype) {
            var e = wx.getStorageSync("userInfo");
            app.api.getCpinConfirmOrd({
                oid: this.data.oid,
                user_id: e.id
            }).then(function(a) {
                app.tips("收货成功！"), t.setData({
                    ajax: !1,
                    alert: !1
                }), t.onLoadData();
            }).catch(function(a) {
                a.code, app.tips(a.msg);
            });
        } else 8 == this.data.info.info.order_status && app.navTo("/sqtg_sun/pages/plugin/spell/comment/comment?id=" + this.data.oid);
    },
    onCallLeader: function(a) {
        wx.makePhoneCall({
            phoneNumber: a.currentTarget.dataset.tel + ""
        });
    }
});