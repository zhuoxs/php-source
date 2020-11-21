var app = getApp();

Page({
    data: {
        currentIdx: 0,
        showRule: !0,
        region: []
    },
    onLoad: function(e) {
        var t = this;
        app.util.request({
            url: "entry/wxapp/VipType",
            cachetime: "0",
            success: function(e) {
                console.log(e), t.setData({
                    vipCardData: e.data,
                    currentId: e.data[0].id
                });
            }
        }), t.diyWinColor(), t.getHeaderImg();
    },
    buyCardType: function(e) {
        console.log(e);
        var t = e.currentTarget.dataset.index, a = e.currentTarget.dataset.id;
        this.setData({
            currentIdx: t,
            currentId: a
        });
    },
    seeVipPower: function(e) {
        this.setData({
            showRule: !1
        });
    },
    closePopupTap: function(e) {
        this.setData({
            showRule: !0
        });
    },
    inputName: function(e) {
        console.log(e), this.setData({
            name: e.detail.value
        });
    },
    inputTap: function(e) {
        console.log(e), this.setData({
            telLength: e.detail.cursor,
            phone: e.detail.value
        });
    },
    inputActCode: function(e) {
        console.log(e), this.setData({
            actcode: e.detail.value
        });
    },
    bindSubmit: function(e) {
        var t = this, a = wx.getStorageSync("openid");
        console.log(a), console.log(e);
        var o = e.detail.value.name, n = e.detail.value.phone;
        "" != o ? "" != n && 11 == t.data.telLength ? (console.log(o), console.log(n), console.log(a), 
        console.log(t.data.currentId), app.util.request({
            url: "entry/wxapp/BuyVipCard",
            cachetime: "0",
            data: {
                openid: a,
                id: t.data.currentId,
                username: o,
                tel: n
            },
            success: function(e) {
                console.log(e), "" != e.data.data ? wx.requestPayment({
                    timeStamp: e.data.timeStamp,
                    nonceStr: e.data.nonceStr,
                    package: e.data.package,
                    signType: "MD5",
                    paySign: e.data.paySign,
                    success: function(e) {
                        console.log(e), app.util.request({
                            url: "entry/wxapp/BuySuccess",
                            cachetime: "0",
                            data: {
                                id: t.data.currentId,
                                username: o,
                                tel: n,
                                openid: a
                            },
                            success: function(e) {
                                console.log(e), wx.showModal({
                                    title: "提示",
                                    content: "购买成功，您已是会员",
                                    showCancel: !1,
                                    success: function(e) {
                                        e.confirm && wx.redirectTo({
                                            url: "../fansCard/fansCard"
                                        });
                                    }
                                });
                            }
                        });
                    },
                    fail: function(e) {
                        console.log(e), console.log("购买失败");
                    }
                }) : wx.showModal({
                    title: "提示",
                    content: "支付失败",
                    showCancel: !1
                });
            }
        })) : wx.showModal({
            title: "提示",
            content: "请输入正确手机号码",
            showCancel: !1
        }) : wx.showModal({
            title: "提示",
            content: "请输入姓名",
            showCancel: !1
        });
    },
    deterActTap: function(e) {
        console.log(e);
        var t = this, a = wx.getStorageSync("openid"), o = t.data.name, n = t.data.phone, s = t.data.actcode;
        console.log(o), console.log(n), null != o ? null != n && 11 == t.data.telLength ? null != s ? (console.log(n), 
        app.util.request({
            url: "entry/wxapp/ActiveCode",
            cachetime: "0",
            data: {
                openid: a,
                code: s,
                username: o,
                tel: n
            },
            success: function(e) {
                console.log(e), wx.showModal({
                    title: "提示",
                    content: "激活成功，您已是会员",
                    showCancel: !1,
                    success: function(e) {
                        e.confirm && wx.redirectTo({
                            url: "../fansCard/fansCard"
                        });
                    }
                });
            }
        })) : wx.showModal({
            title: "提示",
            content: "请输入正确激活码",
            showCancel: !1
        }) : wx.showModal({
            title: "提示",
            content: "请输入正确手机号码",
            showCancel: !1
        }) : wx.showModal({
            title: "提示",
            content: "请输入姓名",
            showCancel: !1
        });
    },
    onReady: function() {},
    onShow: function() {
        var t = this, e = wx.getStorageSync("users");
        t.setData({
            users: e
        }), app.util.request({
            url: "entry/wxapp/GetFansCard",
            cachetime: "0",
            success: function(e) {
                console.log(e), t.setData({
                    fansCardInfo: e.data
                });
            }
        });
    },
    diyWinColor: function(e) {
        var t = wx.getStorageSync("system");
        wx.setNavigationBarColor({
            frontColor: t.color,
            backgroundColor: t.fontcolor,
            animation: {
                duration: 400,
                timingFunc: "easeIn"
            }
        }), wx.setNavigationBarTitle({
            title: "粉丝卡"
        });
    },
    getHeaderImg: function() {
        var t = this;
        app.globalData.userInfo ? this.setData({
            userInfo: app.globalData.userInfo,
            hasUserInfo: !0
        }) : this.data.canIUse ? app.userInfoReadyCallback = function(e) {
            t.setData({
                userInfo: e.userInfo,
                hasUserInfo: !0
            });
        } : wx.getUserInfo({
            success: function(e) {
                app.globalData.userInfo = e.userInfo, t.setData({
                    userInfo: e.userInfo,
                    hasUserInfo: !0
                });
            }
        });
    }
});