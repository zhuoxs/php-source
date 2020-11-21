var Page = require("../../../sdk/qitui/oddpush.js").oddPush(Page).Page, app = getApp();

Page({
    data: {
        navTile: "福利详情",
        indicatorDots: !1,
        autoplay: !1,
        interval: 3e3,
        duration: 800,
        welfareList: [],
        url: [],
        viptype: "0",
        is_modal_Hidden: !0,
        choose: [ {
            name: "微信支付",
            value: "1",
            icon: "/style/images/wx.png",
            checked: "checked"
        } ],
        payStatus: 0,
        payType: "1",
        showModalStatus: 0
    },
    onLoad: function(e) {
        var t = this;
        wx.setNavigationBarTitle({
            title: t.data.navTile
        });
        e.id;
        t.setData({
            id: e.id
        });
        var a = app.getSiteUrl();
        a ? t.setData({
            url: a
        }) : app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            success: function(e) {
                wx.setStorageSync("url", e.data), a = e.data, t.setData({
                    url: a
                });
            }
        }), app.wxauthSetting(), app.util.request({
            url: "entry/wxapp/System",
            cachetime: "30",
            showLoading: !1,
            success: function(e) {
                console.log(e.data);
                var a = t.data.choose;
                if (1 == e.data.isopen_recharge) {
                    a = a.concat([ {
                        name: "余额支付",
                        value: "2",
                        icon: "/style/images/yuelogo.png",
                        checked: ""
                    } ]);
                }
                t.setData({
                    choose: a,
                    store_open: e.data.store_open ? e.data.store_open : 0
                }), wx.setNavigationBarColor({
                    frontColor: e.data.fontcolor ? e.data.fontcolor : "",
                    backgroundColor: e.data.color ? e.data.color : "",
                    animation: {
                        duration: 0,
                        timingFunc: "easeIn"
                    }
                });
            }
        });
    },
    onReady: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/welfare",
            method: "GET",
            data: {
                id: a.data.id
            },
            success: function(e) {
                console.log(122), console.log(e), a.setData({
                    welfareList: e.data
                });
            }
        });
    },
    toIndex: function(e) {
        wx.redirectTo({
            url: "/mzhk_sun/pages/index/index"
        });
    },
    onShow: function() {
        var a = this;
        app.func.islogin(app, a), a.getUrl();
        var e = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/isLingqu",
            cachetime: "30",
            data: {
                id: a.data.id,
                openid: e
            },
            header: {
                "content-type": "application/json"
            },
            success: function(e) {
                console.log(e), 0 < e.data.id ? a.setData({
                    receive: 1
                }) : a.setData({
                    receive: 0
                });
            }
        }), app.util.request({
            url: "entry/wxapp/ISVIP",
            cachetime: "0",
            data: {
                openid: e
            },
            header: {
                "content-type": "application/json"
            },
            success: function(e) {
                a.setData({
                    viptype: e.data.viptype
                });
            }
        });
    },
    getUrl: function() {
        var a = this, t = app.getSiteUrl();
        t ? a.setData({
            url: t
        }) : app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            success: function(e) {
                wx.setStorageSync("url", e.data), t = e.data, a.setData({
                    url: t
                });
            }
        });
    },
    showPay: function(e) {
        var a = this;
        app.util.request({
            url: "entry/wxapp/User",
            cachetime: "0",
            showLoading: !1,
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(e) {
                if (1 == e.data) return wx.showToast({
                    title: "禁止购买",
                    icon: "loading",
                    duration: 2e3
                }), tourl = "/mzhk_sun/pages/index/index", wx.redirectTo({
                    url: tourl
                }), !1;
            }
        });
        var t = e.currentTarget.dataset.statu, o = a.data.welfareList, n = parseFloat(o.currentprice);
        return 1 == a.data.receive ? (wx.showToast({
            title: "您已领取过啦",
            icon: "none",
            duration: 1e3
        }), !1) : n <= 0 ? (a.receive(), !1) : void app.util.request({
            url: "entry/wxapp/timeover",
            cachetime: "0",
            showLoading: !1,
            data: {
                id: a.data.id,
                type: 1
            },
            success: function(e) {
                console.log(e.data), a.setData({
                    payStatus: t
                });
            },
            fail: function(e) {
                return wx.showModal({
                    title: "提示信息",
                    content: e.data.message,
                    showCancel: !1
                }), !1;
            }
        });
    },
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    callphone: function(e) {
        var a = e.currentTarget.dataset.phone;
        wx.makePhoneCall({
            phoneNumber: a
        });
    },
    toMember: function(e) {
        wx.redirectTo({
            url: "../../member/member"
        });
    },
    radioChange: function(e) {
        var a = e.detail.value;
        console.log(a), this.setData({
            payType: a
        });
    },
    tobuy: function(e) {
        var t = this, a = t.data.welfareList, o = a.id, n = a.currentprice, i = wx.getStorageSync("openid"), r = t.data.payType;
        if (t.data.isclick) return console.log("重复点击"), !1;
        t.setData({
            isclick: !0
        });
        var s = {
            payType: r,
            resulttype: 4,
            orderarr: "",
            SendMessagePay: "",
            PayOrder: "",
            SendSms: "",
            PayOrderurl: "",
            PayredirectTourl: "/mzhk_sun/pages/user/welfare/welfare"
        };
        app.util.request({
            url: "entry/wxapp/Counpadd",
            data: {
                openid: i,
                id: o,
                ty: 1
            },
            success: function(e) {
                var a = e.data.order_id;
                console.log(a), s.orderarr = {
                    id: o,
                    cou_order_id: a,
                    price: n,
                    openid: i,
                    paytype: 3,
                    paytypes: 3
                }, s.PayOrder = {
                    id: o,
                    price: n,
                    openid: i,
                    payType: r
                }, app.func.orderarr(app, t, s);
            },
            fail: function(e) {
                wx.showModal({
                    title: "提示信息",
                    content: e.data.message,
                    showCancel: !1
                }), t.setData({
                    isclickpay: !1
                });
            }
        });
    },
    receive: function(e) {
        var a = this, t = a.data.welfareList.id, o = wx.getStorageSync("openid"), n = a.data.receive;
        0 == n ? app.util.request({
            url: "entry/wxapp/Counpadd",
            cachetime: "30",
            data: {
                openid: o,
                id: t
            },
            header: {
                "content-type": "application/json"
            },
            success: function(e) {
                a.setData({
                    receive: 1
                }), 2 == e.data.status ? wx.showToast({
                    title: "您已领取过啦",
                    icon: "none",
                    duration: 1e3
                }) : wx.showToast({
                    title: "领取成功",
                    icon: "success",
                    duration: 1e3
                });
            }
        }) : wx.showToast({
            title: "您已领取过啦~",
            icon: "none",
            duration: 1e3
        });
    },
    showmap: function(e) {
        var a = e.currentTarget.dataset.address, t = Number(e.currentTarget.dataset.longitude), o = Number(e.currentTarget.dataset.latitude);
        0 == t && 0 == o && wx.showToast({
            title: "该地址可能无法在地图上显示~",
            icon: "none",
            duration: 1e3
        }), wx.openLocation({
            name: a,
            latitude: o,
            longitude: t,
            scale: 18,
            address: a
        });
    },
    updateUserInfo: function(e) {
        console.log("授权操作更新");
        app.wxauthSetting();
    },
    toApply: function(e) {
        var a = this, t = e.currentTarget.dataset.statu, o = wx.getStorageSync("openid");
        console.log(t), console.log(o), app.util.request({
            url: "entry/wxapp/GetstoreNotice2",
            cachetime: "30",
            data: {
                openid: o
            },
            success: function(e) {
                console.log(e.data), 2 == e.data.data ? a.toBackstage() : a.setData({
                    storenotice: e.data.data.notice,
                    showModalStatus: t
                });
            }
        });
    },
    toBackstage: function(e) {
        var a = wx.getStorageSync("openid");
        console.log("商家管理入口"), app.util.request({
            url: "entry/wxapp/CheckBrandUser",
            cachetime: "0",
            data: {
                openid: a
            },
            success: function(e) {
                console.log("商家数据"), console.log(e.data), e.data ? (wx.setStorageSync("brand_info", e.data.data), 
                app.globalData.islogin = 1, wx.navigateTo({
                    url: "/mzhk_sun/pages/backstage/index2/index2"
                })) : wx.navigateTo({
                    url: "/mzhk_sun/pages/backstage/backstage"
                });
            },
            fail: function(e) {
                var a = wx.getStorageSync("loginname");
                console.log("非绑定登陆，获取登陆信息"), console.log(a), a ? wx.navigateTo({
                    url: "/mzhk_sun/pages/backstage/index2/index2"
                }) : wx.navigateTo({
                    url: "/mzhk_sun/pages/backstage/backstage"
                });
            }
        });
    }
});