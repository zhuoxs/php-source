var app = getApp();

Page({
    data: {
        baseurl: app.globalData.baseurl,
        uniacid: app.globalData.uniacid,
        fid: 0,
        rid: 0,
        stick_money: 0,
        stick_days: 0,
        userMoney: 0,
        returnpage: 2,
        allmoney: 0
    },
    onPullDownRefresh: function() {
        this.getForumSet(), this.getUserMoney(), wx.stopPullDownRefresh();
    },
    onLoad: function(t) {
        var a = this, e = t.fid, n = t.rid, s = t.returnpage;
        a.setData({
            fid: e,
            rid: n,
            returnpage: s
        });
        var o = app.util.url("entry/wxapp/BaseMin", {
            m: "sudu8_page"
        });
        wx.request({
            url: o,
            cachetime: "30",
            data: {
                vs1: 1
            },
            success: function(t) {
                a.setData({
                    baseinfo: t.data.data
                }), wx.setNavigationBarTitle({
                    title: "置顶"
                }), wx.setNavigationBarColor({
                    frontColor: a.data.baseinfo.base_tcolor,
                    backgroundColor: a.data.baseinfo.base_color
                });
            },
            fail: function(t) {}
        }), a.getForumSet(), a.getUserMoney();
    },
    onReady: function() {},
    getForumSet: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/ForumSet",
            success: function(t) {
                a.setData({
                    stick_money: t.data.data.stick_money
                });
            },
            fail: function(t) {}
        });
    },
    getStickDays: function(t) {
        var a = t.detail.value, e = this.data.stick_money * a;
        e = e.toFixed(2), this.setData({
            stick_days: a,
            allmoney: e
        });
    },
    getUserMoney: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/GetUserMoney",
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(t) {
                a.setData({
                    userMoney: t.data.data
                });
            },
            fail: function(t) {}
        });
    },
    formSubmit: function(t) {
        var a = this, e = a.data.stick_days;
        if (0 == e) return wx.showModal({
            title: "提示",
            content: "请输入置顶天数",
            showCancel: !1
        }), !1;
        var n = a.data.stick_money, s = t.detail.formId;
        0 < n ? app.util.request({
            url: "entry/wxapp/ForumOrder",
            data: {
                release_money: 0,
                stick_days: e,
                stick_money: n,
                openid: wx.getStorageSync("openid"),
                formId: s
            },
            success: function(t) {
                if (1 == t.data.data.type) wx.showModal({
                    title: "请注意",
                    content: "您将使用余额支付" + e * n + "元",
                    success: function(t) {
                        t.confirm && a.setStick();
                    }
                }); else {
                    if ("success" == t.data.data.message) {
                        t.data.data.order_id;
                        a.setData({
                            prepay_id: t.data.data.package
                        }), wx.requestPayment({
                            timeStamp: t.data.data.timeStamp,
                            nonceStr: t.data.data.nonceStr,
                            package: t.data.data.package,
                            signType: "MD5",
                            paySign: t.data.data.paySign,
                            success: function(t) {
                                0 < a.data.userMoney ? app.util.request({
                                    url: "entry/wxapp/UpdateUserMoney",
                                    data: {
                                        openid: wx.getStorageSync("openid")
                                    },
                                    success: function(t) {
                                        1 == t.data.data && wx.showToast({
                                            title: "支付成功",
                                            icon: "success",
                                            duration: 3e3,
                                            success: function(t) {
                                                a.setStick();
                                            }
                                        });
                                    }
                                }) : wx.showToast({
                                    title: "支付成功",
                                    icon: "success",
                                    duration: 3e3,
                                    success: function(t) {
                                        a.setStick();
                                    }
                                });
                            },
                            fail: function(t) {},
                            complete: function(t) {}
                        });
                    }
                    "error" == t.data.data.message && wx.showModal({
                        title: "提醒",
                        content: t.data.data.message,
                        showCancel: !1
                    });
                }
            },
            fail: function(t) {}
        }) : a.setStick();
    },
    setStick: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/SetStick",
            data: {
                rid: a.data.rid,
                stick_money: a.data.stick_money,
                stick_days: a.data.stick_days
            },
            success: function(t) {
                1 == t.data.data ? wx.showModal({
                    title: "提示",
                    content: "置顶成功",
                    showCancel: !1,
                    success: function(t) {
                        wx.navigateBack({
                            delta: a.data.returnpage
                        });
                    }
                }) : wx.showModal({
                    title: "提示",
                    content: "置顶失败",
                    showCancel: !1
                });
            },
            fail: function(t) {}
        });
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});