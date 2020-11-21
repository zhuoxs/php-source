var app = getApp();

Page({
    data: {
        hideRuzhu: !0
    },
    onLoad: function(t) {
        console.log(t);
        var a = t.userid, e = wx.getStorageSync("url"), o = wx.getStorageSync("auth_type");
        console.log(o), console.log(22), this.setData({
            userid: a,
            url: e,
            auth_type: o
        });
    },
    checkOrderNum: function(t) {
        console.log(t.detail.value), this.setData({
            orderNum: t.detail.value
        });
    },
    Putforward: function(t) {
        var a = wx.getStorageSync("system");
        console.log(a.tx_open), 1 == a.tx_open ? wx.navigateTo({
            url: "../withDrawal/withDrawal"
        }) : wx.showToast({
            title: "提现功能暂时关闭，给您造成的不便敬请谅解！",
            icon: "none"
        });
    },
    deterBtn: function(t) {
        var a = this, e = a.data.orderNum, o = a.data.userid;
        console.log(e + o), app.util.request({
            url: "entry/wxapp/checkOrderInfo",
            cachetime: "0",
            data: {
                orderNum: e
            },
            success: function(t) {
                console.log(t), t.data ? a.setData({
                    hideRuzhu: !1,
                    orderInfo: t.data
                }) : wx.showToast({
                    title: "该订单不存在，请确认后重新输入！",
                    icon: "none"
                });
            }
        });
    },
    applyFor: function(t) {
        console.log(t.currentTarget.dataset.id);
        var a = this, e = t.currentTarget.dataset.id, o = t.currentTarget.dataset.gtype, n = a.data.userid;
        console.log(n), app.util.request({
            url: "entry/wxapp/WriteOrder",
            cachetime: "30",
            data: {
                id: e,
                userid: n,
                gtype: o
            },
            success: function(t) {
                console.log(t), 1 == t.data.data && (wx.showToast({
                    title: "核销成功！"
                }), a.setData({
                    hideRuzhu: !0
                })), setTimeout(function() {
                    a.onShow();
                }, 1e3);
            }
        });
    },
    goFabuYHQ: function(t) {
        console.log(t), wx.navigateTo({
            url: "../../market-tool/yhq/yhq"
        });
    },
    saomaCode: function(t) {
        var o = this, n = wx.getStorageSync("openid"), u = o.data.userid;
        wx.scanCode({
            success: function(t) {
                console.log(t);
                var a = t.result, e = wx.getStorageSync("auth_type");
                app.util.request({
                    url: "entry/wxapp/checkOrderCode",
                    cachetime: "0",
                    data: {
                        code: a,
                        openid: n,
                        userid: u,
                        auth_type: e
                    },
                    success: function(t) {
                        console.log(t), o.setData({
                            hideRuzhu: !1,
                            orderInfo: t.data.data
                        });
                    }
                });
            }
        });
    },
    settingTap: function(t) {
        wx.navigateTo({
            url: "../audio/audio"
        });
    },
    goMyOrder: function(t) {
        console.log(t), wx.navigateTo({
            url: "../myOrder/myOrder?currentTab=" + t.currentTarget.dataset.currenttab
        });
    },
    goFabuKJ: function(t) {
        wx.navigateTo({
            url: "../../market-tool/kanjia/kanjia"
        });
    },
    goFabuPT: function(t) {
        wx.navigateTo({
            url: "../../market-tool/pintuan/pintuan"
        });
    },
    goFabuJK: function(t) {
        wx.navigateTo({
            url: "../../market-tool/jika/jika"
        });
    },
    goFabuSP: function(t) {
        wx.navigateTo({
            url: "../../market-tool/goods/goods"
        });
    },
    goActkj: function(t) {
        wx.navigateTo({
            url: "../../manager-act/kanjia/kanjia"
        });
    },
    goActpt: function(t) {
        wx.navigateTo({
            url: "../../manager-act/pintuan/pintuan"
        });
    },
    goActjk: function(t) {
        wx.navigateTo({
            url: "../../manager-act/jika/jika"
        });
    },
    goActsp: function(t) {
        wx.navigateTo({
            url: "../../manager-act/goods/goods"
        });
    },
    goActyhq: function(t) {
        wx.navigateTo({
            url: "../../manager-act/yhq/yhq"
        });
    },
    loginOut: function(t) {
        wx.navigateBack({});
    },
    backIndex: function() {
        wx.redirectTo({
            url: "../../first/index"
        });
    },
    onReady: function() {},
    onShow: function() {
        this.getUserInfo();
        var a = this, t = wx.getStorageSync("openid"), e = wx.getStorageSync("auth_type");
        app.util.request({
            url: "entry/wxapp/StoreIncome",
            cachetime: "0",
            data: {
                openid: t,
                auth_type: e
            },
            success: function(t) {
                console.log(t), a.setData({
                    newData: t.data.data
                });
            }
        });
    },
    getUserInfo: function() {
        var a = this;
        wx.login({
            success: function() {
                wx.getUserInfo({
                    success: function(t) {
                        console.log(t), a.setData({
                            userInfo: t.userInfo
                        });
                    }
                });
            }
        });
    },
    closePopupTap: function(t) {
        this.setData({
            hideRuzhu: !0
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    addMemberTap: function(t) {
        wx.navigateTo({
            url: "../addVerMember/addVerMember"
        });
    }
});