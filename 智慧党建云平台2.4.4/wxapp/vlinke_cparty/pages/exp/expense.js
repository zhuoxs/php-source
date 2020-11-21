var _request = require("../../util/request.js"), _request2 = _interopRequireDefault(_request);

function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

var app = getApp();

Page({
    data: {
        paymoney: "0.00",
        paymoneydisabled: !1
    },
    formSubmit: function(e) {
        var t = parseFloat(e.detail.value.paymoney), n = e.detail.value.remark;
        if (!t || t <= 0) wx.showModal({
            title: "提示",
            content: "支付金额要大于0.00元！",
            showCancel: !1,
            success: function(e) {}
        }); else {
            var a = this.data.expense.id, o = this.data.user.id;
            _request2.default.get("expense", {
                op: "post",
                id: a,
                userid: o,
                paymoney: t,
                remark: n
            }).then(function(e) {
                wx.requestPayment({
                    timeStamp: e.timeStamp,
                    nonceStr: e.nonceStr,
                    package: e.package,
                    signType: "MD5",
                    paySign: e.paySign,
                    success: function(e) {
                        wx.showModal({
                            title: "提示",
                            content: "支付成功！",
                            showCancel: !1,
                            success: function(e) {
                                e.confirm && wx.redirectTo({
                                    url: "../exp/explog"
                                });
                            }
                        });
                    },
                    fail: function(e) {
                        wx.showModal({
                            title: "提示",
                            content: "支付失败，请重试！",
                            showCancel: !1,
                            success: function(e) {
                                e.confirm && wx.redirectTo({
                                    url: "../exp/expcate"
                                });
                            }
                        });
                    }
                });
            }, function(e) {
                wx.showModal({
                    title: "提示",
                    content: e,
                    showCancel: !1,
                    success: function(e) {
                        e.confirm && wx.redirectTo({
                            url: "../exp/expcate"
                        });
                    }
                }), console.log(e);
            });
        }
    },
    paymoneyTip: function() {
        wx.showModal({
            title: "提示",
            content: "支付固定金额，不可修改。",
            showCancel: !1,
            success: function(e) {}
        });
    },
    onLoad: function(e) {
        var t = this, n = wx.getStorageSync("param") || null, a = wx.getStorageSync("user") || null;
        t.setData({
            param: n,
            user: a
        }), null == a && wx.redirectTo({
            url: "../login/login"
        });
        var o = e.cateid, i = a.id, s = a.branchid;
        _request2.default.get("expense", {
            cateid: o,
            userid: i,
            branchid: s
        }).then(function(e) {
            t.setData({
                expcate: e.expcate,
                expense: e.expense,
                branch: e.branch,
                paymoney: parseFloat(e.expense.paymoney).toFixed(2)
            }), 2 != e.expcate.status && 3 != e.expcate.status || t.setData({
                paymoneydisabled: !0
            });
        }, function(e) {
            wx.showModal({
                title: "提示",
                content: e,
                showCancel: !1,
                success: function(e) {
                    e.confirm && wx.redirectTo({
                        url: "../exp/expcate"
                    });
                }
            }), console.log(e);
        });
    },
    onReady: function() {
        app.util.footer(this);
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {
        return {
            title: this.data.param.wxappsharetitle,
            path: "/vlinke_cparty/pages/home/home",
            imageUrl: this.data.param.wxappshareimageurl
        };
    }
});