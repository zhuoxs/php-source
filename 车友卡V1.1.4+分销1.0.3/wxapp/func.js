var func = {};

function payresult(e, a, s) {
    var t = s.SendMessagePay, n = s.PayOrder, i = s.PayOrderurl, r = s.PayredirectTourl;
    e.util.request({
        url: "entry/wxapp/SendMessagePay",
        cachetime: "0",
        data: t,
        success: function(e) {
            console.log("发送成功"), console.log(e.data);
        }
    }), e.util.request({
        url: i,
        cachetime: "0",
        data: n,
        success: function(e) {
            console.log("跳转"), wx.redirectTo({
                url: r
            });
        }
    });
}

function paymemresult(e, a, s) {
    var t = s.PayOrder;
    e.util.request({
        url: "entry/wxapp/PayVIP",
        cachetime: "0",
        data: t,
        success: function(e) {
            a.setData({
                isclick: !1
            }), wx.showModal({
                content: "恭喜你，成为会员啦~",
                showCancel: !0,
                success: function(e) {
                    wx.navigateBack();
                }
            });
        },
        fail: function(e) {
            a.setData({
                isclick: !1
            });
        }
    });
}

function payorderresult(e, a, s) {
    s.SendMessagePay;
    var t = s.PayOrder, n = s.PayOrderurl, i = s.PayredirectTourl, r = i.orderlist;
    e.util.request({
        url: n,
        cachetime: "0",
        data: t,
        success: function(e) {
            console.log(i.f_index), r[i.f_index].status = i.status, a.setData({
                orderlist: r,
                isclick: !1,
                payStatus: 0
            });
        }
    });
}

func.gotourl = function(e, a, s) {
    var t = 3 < arguments.length && void 0 !== arguments[3] ? arguments[3] : "", n = a, i = "", r = !1;
    if (2 == n) i = "/yzqzk_sun/pages/index/bargain/bargain"; else if (3 == n) i = "/yzqzk_sun/pages/index/cards/cards"; else if (4 == n) i = "/yzqzk_sun/pages/index/timebuy/timebuy"; else if (5 == n) i = "/yzqzk_sun/pages/index/group/group"; else if (6 == n) i = "/yzqzk_sun/pages/index/shop/shop?id=" + s; else if (7 == n) i = "/yzqzk_sun/pages/index/bardet/bardet?id=" + s; else if (8 == n) i = "/yzqzk_sun/pages/index/cardsdet/cardsdet?gid=" + s; else if (9 == n) i = "/yzqzk_sun/pages/index/package/package?id=" + s; else if (10 == n) i = "/yzqzk_sun/pages/index/groupdet/groupdet?id=" + s; else if (11 == n) i = "/yzqzk_sun/pages/index/welfare/welfare?id=" + s; else if (13 == n) i = "/yzqzk_sun/pages/index/freedet/freedet?id=" + s; else if (14 == n) i = "/yzqzk_sun/pages/index/free/free"; else if (15 == n) i = "/yzqzk_sun/pages/index/index", 
    r = !0; else if (16 == n) i = "/yzqzk_sun/pages/active/active", r = !0; else if (17 == n) i = "/yzqzk_sun/pages/goods/goods", 
    r = !0; else if (18 == n) i = "/yzqzk_sun/pages/user/user", r = !0; else if (19 == n) i = "/yzqzk_sun/pages/index/news/news"; else if (20 == n) i = "/yzqzk_sun/pages/index/article/article?id=" + s; else if (21 == n) i = "/yzqzk_sun/pages/dynamic/dynamic", 
    r = !0; else if (24 == n) i = "/yzqzk_sun/pages/member/member"; else if (25 == n) i = "/yzqzk_sun/pages/user/recharge/recharge"; else {
        if (26 == n) {
            var u = wx.getStorageSync("openid");
            return e.util.request({
                url: "entry/wxapp/IsPromoter",
                data: {
                    openid: u,
                    m: e.globalData.Plugin_distribution
                },
                showLoading: !1,
                success: function(e) {
                    if (e) {
                        var a = e.data;
                        9 != a ? (i = 1 == a.status ? "/yzqzk_sun/plugin/distribution/fxCenter/fxCenter" : "/yzqzk_sun/plugin/distribution/fxAddShare/fxAddShare", 
                        wx.navigateTo({
                            url: i
                        })) : wx.showModal({
                            title: "提示信息",
                            content: "你还不是分销商，请到“我的”--“分销中心”进入申请成为分销商",
                            showCancel: !1,
                            success: function(e) {
                                i = "/yzqzk_sun/pages/user/user", wx.navigateTo({
                                    url: i
                                });
                            }
                        });
                    }
                }
            }), !1;
        }
        if (27 == n) return t.setData({
            showPublic: 1
        }), !1;
        if (22 == n) return wx.scanCode({
            success: function(e) {
                console.log("扫描获取数据-成功"), console.log(e);
                var a = "/yzqzk_sun/pages/user/pay/pay?bid=" + JSON.parse(e.result).bid;
                wx.navigateTo({
                    url: a
                });
            }
        }), !1;
        if (23 == n) return !1;
        12 == n && e.util.request({
            url: "entry/wxapp/GetOtherApplets",
            data: {
                id: s
            },
            success: function(e) {
                wx.navigateToMiniProgram({
                    appId: e.data.wxappjump.appid,
                    path: e.data.wxappjump.path,
                    extarData: {
                        open: "auth"
                    },
                    envVersion: "develop",
                    success: function(e) {
                        console.log("跳转成功");
                    },
                    fail: function(e) {
                        console.log("跳转失败");
                    }
                });
            },
            fail: function(e) {
                console.log("获取其他小程序数据失败");
            }
        });
    }
    "" != i && (r ? wx.redirectTo({
        url: i
    }) : wx.navigateTo({
        url: i
    }));
}, func.islogin = function(a, s) {
    wx.getStorageSync("have_wxauth") || wx.getSetting({
        success: function(e) {
            e.authSetting["scope.userInfo"] ? (a.wxauthSetting(), wx.setStorageSync("have_wxauth", 1), 
            s.setData({
                is_modal_Hidden: !0
            })) : s.setData({
                is_modal_Hidden: !1
            });
        }
    });
}, func.orderarr = function(a, s, t) {
    var n = this, e = t.orderarr, i = t.payType, r = t.resulttype;
    1 == i ? a.util.request({
        url: "entry/wxapp/Orderarr",
        data: e,
        success: function(e) {
            wx.requestPayment({
                timeStamp: e.data.timeStamp,
                nonceStr: e.data.nonceStr,
                package: e.data.package,
                signType: e.data.signType,
                paySign: e.data.paySign,
                success: function(e) {
                    wx.showToast({
                        title: "支付成功",
                        icon: "success",
                        duration: 2e3
                    }), 1 == r ? n.payresultsms(a, s, t) : 2 == r ? paymemresult(a, s, t) : 3 == r ? payorderresult(a, s, t) : payresult(a, s, t);
                },
                fail: function(e) {
                    wx.showToast({
                        title: "支付失败",
                        icon: "none",
                        duration: 2e3
                    }), console.log("失败00003"), s.setData({
                        continuesubmit: !0,
                        isclickpay: !1,
                        isclick: !1
                    });
                }
            });
        },
        fail: function() {
            console.log("失败00002"), s.setData({
                continuesubmit: !0,
                isclickpay: !1,
                isclick: !1
            }), wx.showModal({
                title: "提示信息",
                content: res.data.message,
                showCancel: !1
            });
        }
    }) : 2 == i && a.util.request({
        url: "entry/wxapp/OrderarrYue",
        data: e,
        success: function(e) {
            wx.showToast({
                title: "支付成功",
                icon: "success",
                duration: 2e3
            }), 1 == r ? n.payresultsms(a, s, t) : 2 == r ? paymemresult(a, s, t) : 3 == r ? payorderresult(a, s, t) : payresult(a, s, t);
        },
        fail: function(e) {
            console.log("失败00004"), s.setData({
                continuesubmit: !0,
                isclickpay: !1,
                isclick: !1
            }), wx.showModal({
                title: "提示信息",
                content: e.data.message,
                showCancel: !1
            });
        }
    });
}, func.payresultsms = function(e, a, s) {
    var t = s.SendMessagePay, n = (s.PayOrder, s.PayOrderurl, s.PayredirectTourl, s.SendSms);
    e.util.request({
        url: "entry/wxapp/SendMessagePay",
        cachetime: "0",
        data: t,
        success: function(e) {
            console.log("发送成功"), console.log(e.data);
        }
    }), n ? e.util.request({
        url: "entry/wxapp/SendSms",
        cachetime: "0",
        data: n,
        success: function(e) {
            wx.showModal({
                title: "提示",
                content: "提交成功，将返回上一页",
                showCancel: !1,
                success: function(e) {
                    wx.navigateBack();
                }
            });
        }
    }) : wx.showModal({
        title: "提示",
        content: "提交成功，将返回上一页",
        showCancel: !1,
        success: function(e) {
            wx.navigateBack();
        }
    });
}, func.decodeScene = function(e) {
    if (e.scene) for (var a = e, s = decodeURIComponent(e.scene).split("&"), t = 0; t < s.length; t++) {
        var n = s[t].split("=");
        a[n[0]] = n[1];
    } else a = e;
    return a;
}, func.show = function(e, a, s, t) {
    var n = wx.createAnimation({
        duration: a,
        timingFunction: "ease"
    });
    n.opacity(t).step();
    var i = '{"' + s + '":""}';
    (i = JSON.parse(i))[s] = n.export(), e.setData(i);
}, func.slideupshow = function(e, a, s, t, n) {
    var i = wx.createAnimation({
        duration: a,
        timingFunction: "ease"
    });
    i.translateY(t).opacity(n).step();
    var r = '{"' + s + '":""}';
    (r = JSON.parse(r))[s] = i.export(), e.setData(r);
}, func.sliderightshow = function(e, a, s, t, n) {
    var i = wx.createAnimation({
        duration: a,
        timingFunction: "ease"
    });
    i.translateX(t).opacity(n).step();
    var r = '{"' + s + '":""}';
    (r = JSON.parse(r))[s] = i.export(), e.setData(r);
}, module.exports = func;