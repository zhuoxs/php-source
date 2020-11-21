var func = {
    decodeScene: function(t) {
        if (t.scene) for (var e = t, a = decodeURIComponent(t.scene).split("&"), s = 0; s < a.length; s++) {
            var n = a[s].split("=");
            e[n[0]] = n[1];
        } else e = t;
        return e;
    },
    islogin: function(e, a) {
        wx.getStorageSync("have_wxauth") || wx.getSetting({
            success: function(t) {
                t.authSetting["scope.userInfo"] ? (e.wxauthSetting(), wx.setStorageSync("have_wxauth", 1), 
                a.setData({
                    is_modal_Hidden: !0
                })) : a.setData({
                    is_modal_Hidden: !1
                });
            }
        });
    },
    gotoUrl: function(t, e, a, s, n) {
        1 == s ? (wx, wx.redirectTo({
            url: "/" + a
        })) : wx.navigateTo({
            url: "/" + a
        });
    },
    orderarr: function(t, e, a) {
        var s = a.orderarr, n = a.payType, i = (a.attrType, a.orderType, a.resulttype);
        1 == n ? t.util.request({
            url: "entry/wxapp/Orderarr",
            data: s,
            success: function(t) {
                console.log(t.data), wx.requestPayment({
                    timeStamp: t.data.timeStamp,
                    nonceStr: t.data.nonceStr,
                    package: t.data.package,
                    signType: t.data.signType,
                    paySign: t.data.paySign,
                    success: function(t) {
                        wx.showToast({
                            title: "支付成功",
                            icon: "success",
                            duration: 2e3
                        }), 0 == i && (e.setData(a.setdata), e.setData({
                            isclickpay: !1,
                            isclick: !1
                        }));
                    },
                    fail: function(t) {
                        wx.showToast({
                            title: "支付失败",
                            icon: "none",
                            duration: 2e3
                        }), console.log("失败00003"), e.setData({
                            continuesubmit: !0,
                            isclickpay: !1,
                            isclick: !1
                        });
                    }
                });
            },
            fail: function(t) {
                console.log("失败00002"), e.setData({
                    continuesubmit: !0,
                    isclickpay: !1,
                    isclick: !1
                }), wx.showModal({
                    title: "提示信息",
                    content: t.data.message,
                    showCancel: !1
                });
            }
        }) : 2 == n && t.util.request({
            url: "entry/wxapp/OrderarrYue",
            data: s,
            success: function(t) {
                wx.showToast({
                    title: "支付成功",
                    icon: "success",
                    duration: 2e3
                }), 0 == i && e.setData(a.setdata), e.setData({
                    continuesubmit: !0,
                    isclickpay: !1,
                    isclick: !1
                });
            },
            fail: function(t) {
                console.log("失败00004"), e.setData({
                    continuesubmit: !0,
                    isclickpay: !1,
                    isclick: !1
                }), wx.showModal({
                    title: "提示信息",
                    content: t.data.message,
                    showCancel: !1
                });
            }
        });
    }
};

module.exports = func;