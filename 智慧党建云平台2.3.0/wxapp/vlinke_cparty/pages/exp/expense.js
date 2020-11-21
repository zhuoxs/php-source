var e = function(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}(require("../../util/request.js")), t = getApp();

Page({
    data: {
        paymoney: "0.00",
        paymoneydisabled: !1
    },
    formSubmit: function(t) {
        var n = this, a = parseFloat(t.detail.value.paymoney), o = t.detail.value.remark;
        if (!a || a <= 0) wx.showModal({
            title: "提示",
            content: "支付金额要大于0.00元！",
            showCancel: !1,
            success: function(e) {}
        }); else {
            var c = n.data.expense.id, i = n.data.user.id;
            e.default.get("expense", {
                op: "post",
                id: c,
                userid: i,
                paymoney: a,
                remark: o
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
    onLoad: function(t) {
        var n = this, a = wx.getStorageSync("param") || null, o = wx.getStorageSync("user") || null;
        n.setData({
            param: a,
            user: o
        }), null == o && wx.redirectTo({
            url: "../login/login"
        });
        var c = t.cateid, i = o.id, s = o.branchid;
        e.default.get("expense", {
            cateid: c,
            userid: i,
            branchid: s
        }).then(function(e) {
            n.setData({
                expcate: e.expcate,
                expense: e.expense,
                branch: e.branch,
                paymoney: parseFloat(e.expense.paymoney).toFixed(2)
            }), 2 != e.expcate.status && 3 != e.expcate.status || n.setData({
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
        t.util.footer(this);
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {
        var e = this;
        return {
            title: e.data.param.wxappsharetitle,
            path: "/vlinke_cparty/pages/home/home",
            imageUrl: e.data.param.wxappshareimageurl
        };
    }
});