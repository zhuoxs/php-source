var app = getApp(), wxbarcode = require("../../../../../zhy/resource/js/index.js");

function getTimeStr(e) {
    return e = (e = e.replace(/-/g, ":").replace(" ", ":")).split(":"), new Date(e[0], e[1] - 1, e[2], e[3], e[4], e[5]).getTime() / 1e3;
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
        curPay: 1
    },
    onLoad: function(e) {
        this.setData({
            oid: e.id
        }), this.onLoadData();
    },
    onUnload: function() {
        clearInterval(this.timer);
    },
    onLoadData: function() {
        var r = this;
        app.api.getCpinOrderDetails({
            oid: this.data.oid
        }).then(function(e) {
            wxbarcode.qrcode("qrcode", "hx-spell-" + e.data.info.order_num, 360, 360), clearInterval(r.timer);
            var t = new Date().getTime() / 1e3, a = getTimeStr(e.data.info.create_time), i = 60 * (e.data.goodsinfo.pay_time - 0), o = t - a, n = 0;
            0 < i - o - 10 && (n = i - o - 10), r.setData({
                downTime: n
            }), 0 == e.data.info.order_status && (r.timer = setInterval(function() {
                r.setData({
                    downTime: n
                }), --n <= 0 && (clearInterval(r.timer), wx.showModal({
                    title: "提示",
                    content: "订单已过期！",
                    showCancel: !1,
                    success: function(e) {
                        wx.navigateBack({
                            delta: 1
                        });
                    }
                }));
            }, 1e3)), r.setData({
                imgRoot: e.other.img_root,
                info: e.data,
                show: !0
            });
        }).catch(function(e) {
            -1 == e.code ? app.tips(e.msg) : "订单失效" == e.msg ? wx.showModal({
                title: "提示",
                content: e.msg,
                showCancel: !1,
                success: function(e) {
                    wx.navigateBack({
                        delta: 1
                    });
                }
            }) : app.tips(e.msg);
        });
    }
});