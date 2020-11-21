var e = require("../../../utils/base.js"), t = require("../../../../api.js"), n = new e.Base(), o = getApp();

Page({
    data: {},
    onLoad: function(e) {
        console.log("参数转码过的scene=>", decodeURIComponent(e.scene));
        var t = [], n = decodeURIComponent(e.scene).split("&");
        for (var o in n) {
            var a = n[o].split("=");
            t.push(a);
        }
        var r = {};
        for (var s in t) r = {
            parentId: t[0][1],
            id: t[1][1],
            type: t[2][1]
        };
        this.getClerkDetail(r.id);
    },
    onShow: function() {
        var e = this;
        o.userInfoAuth(function(t) {
            e.setData({
                infoAuth: t
            });
        });
    },
    getUserInfo: function(e) {
        var a = this;
        wx.getSetting({
            success: function(e) {
                e.authSetting["scope.userInfo"] && wx.getUserInfo({
                    success: function(e) {
                        wx.setStorageSync("userInfo", e.userInfo);
                        var r = {
                            url: t.default.user_update,
                            data: {
                                nickname: e.userInfo.nickName,
                                avatar: e.userInfo.avatarUrl
                            }
                        };
                        n.getData(r, function(e) {
                            console.log("用户=>", e);
                        }), o.userInfoAuth(function(e) {
                            a.setData({
                                infoAuth: e
                            });
                        });
                    }
                });
            }
        });
    },
    getClerkDetail: function(e) {
        var o = this, a = {
            url: t.default.clerk_detail,
            data: {
                orderId: e
            }
        };
        console.log(a), n.getData(a, function(e) {
            0 == e.errorCode ? wx.showModal({
                title: "提示",
                content: e.msg,
                showCancel: !1,
                success: function(e) {
                    wx.redirectTo({
                        url: "../../Tab/index/index"
                    });
                }
            }) : o.setData({
                clerkOrderInfo: e.data
            }), console.log("核销页详情=>", e);
        });
    },
    orderClerk: function(e) {
        var o = e.currentTarget.dataset.id, a = {
            url: t.default.order_clerk,
            data: {
                orderId: o
            }
        };
        n.getData(a, function(e) {
            console.log("点击核销=>", e), wx.showModal({
                title: "提示",
                content: e.msg,
                showCancel: !1,
                success: function(t) {
                    1 == e.errorCode && wx.reLaunch({
                        url: "../../Tab/index/index"
                    });
                }
            });
        });
    }
});