var _extends = Object.assign || function(t) {
    for (var a = 1; a < arguments.length; a++) {
        var o = arguments[a];
        for (var n in o) Object.prototype.hasOwnProperty.call(o, n) && (t[n] = o[n]);
    }
    return t;
}, _reload = require("../../common/js/reload.js"), _api = require("../../common/js/api.js"), app = getApp(), wxParse = require("../wxParse/wxParse.js");

Page(_extends({}, _reload.reload, {
    data: {
        imgLink: wx.getStorageSync("url"),
        mask: !0
    },
    onLoad: function(t) {
        this.setData({
            options: t
        });
    },
    onloadData: function(t) {
        var a = this;
        t.detail.login && (this.setData({
            show: !0
        }), this.checkUrl().then(function(t) {
            a.onloadDatas(a.data.options);
        }).catch(function(t) {
            -1 === t.code ? a.tips(t.msg) : a.tips("false");
        }));
    },
    onloadDatas: function(t) {
        var a = this;
        this.setData({
            table: t.table - 0,
            oid: t.oid
        }), (0, _api.OrderInfoData)({
            oid: t.oid
        }).then(function(t) {
            wxParse.wxParse("qcrule", "html", t.qcrule, a, 50), a.setData({
                msg: t
            });
        }, function(t) {
            wx.showToast({
                title: t.msg,
                icon: "none",
                duration: 1e3
            });
        });
    },
    goTakeCar: function(t) {
        this.navTo("../pickcar/pickcar");
    },
    onMaskTab: function() {
        this.setData({
            mask: !this.data.mask
        });
    },
    onPayTab: function(t) {
        var o = this, n = t.detail.formId;
        this.setData({
            formId: n
        });
        var a = {
            cid: this.data.msg.cid,
            carnum: this.data.msg.carnum,
            uid: wx.getStorageSync("userInfo").wxInfo.id,
            stime: this.data.msg.start_time,
            etime: this.data.msg.end_time
        };
        (0, _api.IsorderData)(a).then(function(t) {
            (0, _api.appPay)({
                openid: wx.getStorageSync("userInfo").openid,
                oid: o.data.oid
            }).then(function(t) {
                wx.showToast({
                    title: "支付成功",
                    icon: "none",
                    duration: 1e3
                });
                var a = {
                    formId: n,
                    package: t.package,
                    prepay_id: t.prepay_id,
                    oid: o.data.oid,
                    shopname: o.data.msg.shop.name
                };
                console.log(a), (0, _api.PaysuccessData)(a).then(function(t) {
                    setTimeout(function() {
                        wx.redirectTo({
                            url: "../pickcar/pickcar?oid=" + t.oid + "&sid=" + t.sid
                        });
                    }, 1e3);
                }, function(t) {
                    console.log("err");
                });
            }, function(t) {
                wx.showToast({
                    title: "失败",
                    icon: "none",
                    duration: 1e3
                });
            });
        }).catch(function(t) {
            console.log(t), wx.showToast({
                title: t.msg,
                duration: 2e3,
                icon: "none"
            });
        });
    },
    onCancelTab: function() {
        (0, _api.CancelData)({
            oid: this.data.oid
        }).then(function(t) {
            wx.showToast({
                title: "取消订单成功",
                icon: "none",
                duration: 1e3
            }), setTimeout(function() {
                wx.reLaunch({
                    url: "../home/home"
                });
            }, 1200);
        }, function(t) {
            wx.showToast({
                title: t.msg,
                icon: "none",
                duration: 1e3
            });
        });
    }
}));