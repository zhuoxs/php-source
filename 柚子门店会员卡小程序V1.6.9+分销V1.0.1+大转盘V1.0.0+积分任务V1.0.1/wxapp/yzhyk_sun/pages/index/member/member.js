var app = getApp();

Page({
    data: {
        navTile: "开通会员",
        bghead: "../../../../style/images/bgHead.png",
        bgCards: "../../../../style/images/bgCards.png",
        bgLogo: "../../../../style/images/icon6.png",
        curIndex: 0,
        nav: [ "开通会员", "会员码激活" ],
        cards: [],
        choose: [ {
            name: "微信",
            value: "微信支付",
            icon: "../../../../style/images/wx.png"
        }, {
            name: "余额",
            value: "余额支付",
            icon: "../../../../style/images/local.png"
        } ],
        payStatus: !1,
        isPay: 0
    },
    onLoad: function(t) {
        var e = this;
        wx.setNavigationBarTitle({
            title: e.data.navTile
        }), app.get_user_info().then(function(t) {
            console.log(t), e.setData({
                user: t
            });
        }), app.get_imgroot().then(function(a) {
            app.get_setting().then(function(t) {
                e.setData({
                    imgroot: a,
                    setting: t
                });
            });
        }), app.util.request({
            url: "entry/wxapp/GetMemberCards",
            cachetime: "0",
            success: function(t) {
                e.setData({
                    cards: t.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/GetMemberCardRecords",
            cachetime: "0",
            success: function(t) {
                e.setData({
                    member: t.data
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    navTap: function(t) {
        var a = parseInt(t.currentTarget.dataset.index);
        this.setData({
            curIndex: a
        });
    },
    phoneNum: function(t) {
        this.setData({
            phone: t.detail.value
        });
    },
    codeNum: function(t) {
        this.setData({
            codenum: t.detail.value
        });
    },
    toBuy: function(t) {
        console.log(t.currentTarget.dataset.index);
        this.data.phone;
    },
    toActive: function(t) {
        var a = this, e = a.data.codenum;
        null == e ? wx.showToast({
            title: "请输入激活码",
            icon: "none"
        }) : app.get_user_info().then(function(t) {
            app.util.request({
                url: "entry/wxapp/RechargeCard",
                cachetime: "0",
                data: {
                    user_id: t.id,
                    code: e
                },
                success: function(t) {
                    0 == t.data.code ? wx.showModal({
                        title: "提示",
                        content: "激活成功"
                    }) : wx.showModal({
                        title: "提示",
                        content: t.data.msg,
                        success: function(t) {
                            a.setData({
                                codenum: ""
                            });
                        }
                    });
                },
                fail: function() {
                    console.log("激活失败");
                }
            });
        });
    },
    powerDrawer: function(t) {
        this.setData({
            payStatus: !this.data.payStatus
        });
    },
    powerDrawers: function(t) {
        var a = t.currentTarget.dataset.index;
        this.setData({
            payStatus: !this.data.payStatus,
            chooseIndex: a,
            now_price: t.currentTarget.dataset.price
        });
    },
    radioChange: function(t) {
        var a = t.detail.value;
        this.setData({
            payType: a
        });
    },
    formSubmit: function(t) {
        console.log(t);
        var e = this, n = t.detail.formId, a = e.data.chooseIndex, o = e.data.cards, s = e.data.payType, i = o[a].amount, c = o[a].id, u = o[a].days, r = e.data.now_price;
        e.data.user.balance;
        app.get_user_info().then(function(a) {
            if (null == s) wx.showToast({
                title: "请选择支付方式",
                icon: "none"
            }); else {
                if (e.setData({
                    isPay: ++e.data.isPay
                }), 1 != e.data.isPay) return void wx.showToast({
                    title: "正在支付中...",
                    icon: "none"
                });
                0 < r ? app.pay(i, s).then(function(t) {
                    console.log(t), e.setData({
                        isPay: t
                    }), "the formId is a mock one" != n && app.getFormid(n), 1 == t && app.util.request({
                        url: "entry/wxapp/BuyCard",
                        cachetime: "0",
                        data: {
                            user_id: a.id,
                            card_id: c,
                            days: u,
                            amount: i,
                            pay_type: s
                        },
                        success: function(t) {
                            app.get_user_info(!1), app.get_user_coupons(!1), wx.redirectTo({
                                url: "../paysuc/paysuc"
                            });
                        }
                    });
                }) : app.util.request({
                    url: "entry/wxapp/BuyCard",
                    cachetime: "0",
                    data: {
                        user_id: a.id,
                        card_id: c,
                        days: u,
                        amount: i,
                        pay_type: s
                    },
                    success: function(t) {
                        app.get_user_info(!1), app.get_user_coupons(!1), wx.redirectTo({
                            url: "../paysuc/paysuc"
                        });
                    }
                });
            }
        });
    }
});