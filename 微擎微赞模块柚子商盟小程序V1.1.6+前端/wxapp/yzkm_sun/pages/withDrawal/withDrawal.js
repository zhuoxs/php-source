var app = getApp();

function toDecimal2(t) {
    var e = parseFloat(t);
    if (isNaN(e)) return !1;
    var o = (e = Math.round(100 * t) / 100).toString(), n = o.indexOf(".");
    for (n < 0 && (n = o.length, o += "."); o.length <= n + 2; ) o += "0";
    return o;
}

Page({
    data: {
        noticeBox: !0,
        checked: !1,
        flag: !0,
        balance_sj: "",
        tx_sxf: "",
        commission_cost: ""
    },
    onLoad: function(t) {
        console.log(t);
        var e = this;
        e.setData({
            balance_sj: t.balance_sj
        }), app.util.request({
            url: "entry/wxapp/Sys_tixian",
            success: function(t) {
                console.log("查看系统表数据"), console.log(t), e.setData({
                    tx_sxf: t.data.tx_sxf,
                    tx_details: t.data.tx_details,
                    commission_cost: t.data.commission_cost
                });
            }
        });
        var o = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/User_id",
            data: {
                openid: o
            },
            success: function(t) {
                console.log("查看用户id"), console.log(t), wx.setStorageSync("user_id", t.data.id);
            }
        });
    },
    bindSubmit: function(t) {
        var e = this, o = e.data.checked, n = wx.getStorageSync("user_id"), a = e.data.balance_sj, s = toDecimal2(t.detail.value.putmoney), i = t.detail.value.username, c = t.detail.value.accountnumber, l = t.detail.value.comaccountnumber, u = wx.getStorageSync("openid"), r = e.data.txset.tx_money, d = s * (e.data.commission_cost / 100), f = (s - d) * (e.data.tx_sxf / 100), x = s - d - f;
        if (console.log(d), console.log(f), console.log(x), s < 1) wx.showToast({
            title: "请输入正确的提现金额！",
            icon: "none"
        }); else if (1 == o) {
            var p = e.data.flag;
            if (console.log(p), 1 == p) if (e.setData({
                flag: !1
            }), setTimeout(function() {
                e.setData({
                    flag: !0
                });
            }, 1e3), a - 0 < s - 0) wx.showToast({
                title: "提现金额不能大于可提现金额！",
                icon: "none"
            }); else if (s - 0 < r - 0) wx.showToast({
                title: "提现金额不能小于最低提现金额！",
                icon: "none"
            }); else {
                if (!s) return wx.showToast({
                    title: "请输入提现金额！",
                    icon: "none"
                }), !1;
                if (!i) return wx.showToast({
                    title: "请输入您的姓名！",
                    icon: "none"
                }), !1;
                if (!c) return wx.showToast({
                    title: "请输入微信号！",
                    icon: "none"
                }), !1;
                if (!l) return wx.showToast({
                    title: "请输入确认账号！",
                    icon: "none"
                }), !1;
                if (c != l) return wx.showToast({
                    title: "微信号和确认账号不一致！",
                    icon: "none"
                }), !1;
                app.util.request({
                    url: "entry/wxapp/InputStoreMoney",
                    cachetime: "0",
                    data: {
                        canbeInput: a,
                        accountnumber: c,
                        comaccountnumber: l,
                        putmoney: s,
                        username: i,
                        openid: u,
                        actual_money: x,
                        user_id: n
                    },
                    success: function(t) {
                        console.log(t), 1 == t.data && (wx.hideLoading(), wx.showToast({
                            title: "提交成功！"
                        }), setTimeout(function() {
                            wx.redirectTo({
                                url: "../mine/mine"
                            });
                        }, 2e3));
                    }
                });
            } else wx.showToast({
                title: "请勿重复提交请求...",
                icon: "none"
            });
        } else wx.showToast({
            title: "请阅读并同意《提现须知》",
            icon: "none"
        });
    },
    checkBoxTap: function(t) {
        console.log(t), this.data.checked ? this.setData({
            checked: !1
        }) : this.setData({
            checked: !0
        });
    },
    noticeBoxTap: function(t) {
        this.setData({
            noticeBox: !1
        });
    },
    closeTap: function(t) {
        this.setData({
            noticeBox: !0
        });
    },
    onReady: function() {},
    onShow: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/Putforward",
            cachetime: "0",
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(t) {
                console.log(t), e.setData({
                    putforword: t.data.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/system",
            cachetime: "0",
            success: function(t) {
                console.log(t), e.setData({
                    txset: t.data
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});