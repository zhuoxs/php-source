var app = getApp(), template = require("../template/template.js");

Page({
    data: {
        currentTab: 0,
        hideRuzhu: !0
    },
    onLoad: function(t) {
        var e = this;
        app.util.request({
            url: "entry/wxapp/Url",
            success: function(t) {
                console.log("页面加载请求"), console.log(t), wx.setStorageSync("url", t.data), e.setData({
                    url: t.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/system",
            success: function(t) {
                console.log("****************************"), console.log(t), wx.setStorageSync("system", t.data), 
                wx.setNavigationBarColor({
                    frontColor: t.data.color,
                    backgroundColor: t.data.fontcolor,
                    animation: {
                        timingFunc: "easeIn"
                    }
                });
            }
        }), app.util.request({
            url: "entry/wxapp/Custom_photo",
            success: function(t) {
                console.log("自定义数据显示"), console.log(t.data);
                var o = wx.getStorageSync("url");
                0 == t.data.key ? template.tabbar("tabBar", 4, e, t, o) : template.tabbar("tabBar", 2, e, t, o);
            }
        });
        var o = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/User_id",
            data: {
                openid: o
            },
            success: function(t) {
                console.log("查看用户id"), console.log(t), e.setData({
                    comment_xqy: t.data
                }), wx.setStorageSync("user_id", t.data.id);
            }
        }), e.diyWinColor();
    },
    goToSeller: function() {
        var t = wx.getStorageSync("user_id");
        app.util.request({
            url: "entry/wxapp/Check_sj",
            data: {
                user_id: t
            },
            success: function(t) {
                console.log("显示数据"), console.log(t.data), wx.navigateTo({
                    url: "../manager/manager"
                });
            }
        });
    },
    goCollect: function(t) {
        wx.navigateTo({
            url: "./collect/collect"
        });
    },
    goPreferPay: function(t) {
        wx.navigateTo({
            url: "./prefer-pay/prefer-pay"
        });
    },
    goRuzhu: function(t) {
        var o = this, e = wx.getStorageSync("user_id");
        app.util.request({
            url: "entry/wxapp/Shen_qing",
            data: {
                user_id: e
            },
            success: function(t) {
                return console.log("判断入驻状态"), console.log(t), 1 == t.data.status ? (wx.showToast({
                    title: "正在审核中无需重复添加....",
                    icon: "none"
                }), !1) : 2 == t.data.status ? (wx.showToast({
                    title: "已通过审核无需重复申请....",
                    icon: "none"
                }), !1) : (app.util.request({
                    url: "entry/wxapp/Notice_rz",
                    success: function(t) {
                        console.log("入驻需知"), console.log(t.data), o.setData({
                            Notice: t.data.notice
                        });
                    }
                }), void o.setData({
                    hideRuzhu: !1
                }));
            }
        });
    },
    applyFor: function(t) {
        wx.navigateTo({
            url: "../sjrz-Page/sjrz-Page"
        });
    },
    closePopupTap: function(t) {
        this.setData({
            hideRuzhu: !0
        });
    },
    goMyOrder: function(t) {
        console.log(t), wx.navigateTo({
            url: "../myOrder/myOrder?currentTab=" + t.currentTarget.dataset.currenttab
        });
    },
    goMyFabu: function(t) {
        wx.navigateTo({
            url: "../myFabu/myFabu"
        });
    },
    goShipAddress: function(t) {
        wx.navigateTo({
            url: "../myAddress/myAddress"
        });
    },
    goAboutUs: function(t) {
        wx.navigateTo({
            url: "../company-show/company-show"
        });
    },
    bindChange: function(t) {
        this.setData({
            currentTab: t.detail.current
        });
    },
    swichNav: function(t) {
        if (this.data.currentTab === t.target.dataset.current) return !1;
        this.setData({
            currentTab: t.target.dataset.current
        });
    },
    onReady: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    diyWinColor: function(t) {
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: "#ffb62b"
        }), wx.setNavigationBarTitle({
            title: "我的"
        });
    },
    onShow: function() {
        this.getUserInfo();
    },
    getUserInfo: function() {
        var o = this;
        wx.login({
            success: function() {
                wx.getUserInfo({
                    success: function(t) {
                        console.log(t), o.setData({
                            userInfo: t.userInfo
                        });
                    }
                });
            }
        });
    }
});