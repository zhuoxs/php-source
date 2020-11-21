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
        flag: !0
    },
    bindSubmit: function(t) {
        var e = this, o = e.data.checked, n = e.data.putforword.canbeput, a = e.data.txset.tx_money, i = t.detail.value.accountnumber, c = t.detail.value.comaccountnumber, s = toDecimal2(t.detail.value.putmoney), u = t.detail.value.username, r = wx.getStorageSync("openid");
        if (s < 1) wx.showToast({
            title: "请输入正确的提现金额！",
            icon: "none"
        }); else if (1 == o) {
            var l = e.data.flag;
            if (console.log(l), 1 == l) if (e.setData({
                flag: !1
            }), setTimeout(function() {
                e.setData({
                    flag: !0
                });
            }, 1e3), n - 0 < s - 0) wx.showToast({
                title: "提现金额不能大于可提现金额！",
                icon: "none"
            }); else if (s - 0 < a - 0) wx.showToast({
                title: "提现金额不能小于最低提现金额！",
                icon: "none"
            }); else {
                if (!s) return wx.showToast({
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
                if (!c) return wx.showToast({
                    title: "请输入确认账号！",
                    icon: "none"
                }), !1;
                if (i != c) return wx.showToast({
                    title: "微信号和确认账号不一致！",
                    icon: "none"
                }), !1;
                app.util.request({
                    url: "entry/wxapp/InputStoreMoney",
                    cachetime: "0",
                    data: {
                        canbeInput: n,
                        accountnumber: i,
                        comaccountnumber: c,
                        putmoney: s,
                        username: u,
                        openid: r
                    },
                    success: function(t) {
                        console.log(t), 1 == t.data.data && (wx.showLoading({
                            title: "提现信息提交中...",
                            mask: !0
                        }), setTimeout(function() {
                            wx.hideLoading(), wx.showToast({
                                title: "提交成功！请等待审核！"
                            }), wx.redirectTo({
                                url: "../center/center"
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