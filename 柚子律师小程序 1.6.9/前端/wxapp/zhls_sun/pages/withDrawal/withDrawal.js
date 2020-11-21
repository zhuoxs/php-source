var app = getApp();

function toDecimal2(t) {
    var e = parseFloat(t);
    if (isNaN(e)) return !1;
    var n = (e = Math.round(100 * t) / 100).toString(), o = n.indexOf(".");
    for (o < 0 && (o = n.length, n += "."); n.length <= o + 2; ) n += "0";
    return n;
}

Page({
    data: {
        noticeBox: !0,
        checked: !1,
        flag: !0
    },
    passWdInput: function(t) {
        var e = t.detail.value, n = .01 * this.data.txset.tx_sxf;
        this.setData({
            proce: e * n,
            toaccount: e - e * n
        });
    },
    bindSubmit: function(t) {
        var e = this, n = e.data.checked, o = e.data.Putforward, a = e.data.txset.tx_money, i = t.detail.value.accountnumber, s = t.detail.value.comaccountnumber, c = toDecimal2(t.detail.value.putmoney), u = t.detail.value.username, l = wx.getStorageSync("openid"), r = wx.getStorageSync("ls_id");
        if (c < 1) wx.showToast({
            title: "请输入正确的提现金额！",
            icon: "none"
        }); else if (1 == n) {
            var d = e.data.flag;
            if (console.log(d), 1 == d) if (e.setData({
                flag: !1
            }), setTimeout(function() {
                e.setData({
                    flag: !0
                });
            }, 1e3), o - 0 < c - 0) wx.showToast({
                title: "提现金额不能大于可提现金额！",
                icon: "none"
            }); else if (c - 0 < a - 0) wx.showToast({
                title: "提现金额不能小于最低提现金额！",
                icon: "none"
            }); else {
                if (!c) return wx.showToast({
                    title: "请输入提现金额！",
                    icon: "none"
                }), !1;
                if (!u) return wx.showToast({
                    title: "请输入您的姓名！",
                    icon: "none"
                }), !1;
                if (!i) return wx.showToast({
                    title: "请输入微信号！",
                    icon: "none"
                }), !1;
                if (!s) return wx.showToast({
                    title: "请输入确认账号！",
                    icon: "none"
                }), !1;
                if (i != s) return wx.showToast({
                    title: "微信号和确认账号不一致！",
                    icon: "none"
                }), !1;
                app.util.request({
                    url: "entry/wxapp/InputStoreMoney",
                    cachetime: "0",
                    data: {
                        canbeInput: o,
                        accountnumber: i,
                        comaccountnumber: s,
                        putmoney: c,
                        username: u,
                        openid: l,
                        ls_id: r
                    },
                    success: function(t) {
                        console.log(t), 1 == t.data.data && (wx.showLoading({
                            title: "提现信息提交中...",
                            mask: !0
                        }), setTimeout(function() {
                            wx.hideLoading(), wx.showToast({
                                title: "提交成功！请等待审核！"
                            }), wx.redirectTo({
                                url: "/zhls_sun/pages/manager/center/center?id=" + r
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
    onLoad: function(t) {},
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
        var e = this, t = wx.getStorageSync("ls_id");
        app.util.request({
            url: "entry/wxapp/CanPresented",
            cachetime: "0",
            data: {
                ls_id: t
            },
            success: function(t) {
                console.log(t), e.setData({
                    Putforward: t.data
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