var t = require("../../../../utils/base.js"), i = require("../../../../../api.js"), o = new t.Base();

Page({
    data: {},
    onLoad: function(t) {
        this.getUserInfo(), this.getShareData();
    },
    getShareData: function() {
        var t = this, e = {
            url: i.default.share_data,
            method: "GET"
        };
        o.getData(e, function(i) {
            console.log("推广信息=>", i), 1 == i.errorCode && t.setData({
                shareData: i.data
            });
        });
    },
    getUserInfo: function() {
        var t = this, e = {
            url: i.default.user
        };
        o.getData(e, function(i) {
            console.log("用户信息=》", i), "0" == i.condition ? wx.showModal({
                title: "提示",
                content: "推广功能未开启",
                showCancel: !1,
                success: function(t) {
                    wx.navigateBack({
                        delta: 1
                    });
                }
            }) : "1" == i.condition && "1" != i.user_info.is_distributor ? wx.redirectTo({
                url: "../audit/audit?condition=" + i.condition + "&is_distributor=" + i.user_info.is_distributor
            }) : "2" == i.condition && "1" != i.user_info.is_distributor ? wx.redirectTo({
                url: "../audit/audit?condition=" + i.condition + "&is_distributor=" + i.user_info.is_distributor
            }) : "3" == i.condition && "1" != i.user_info.is_distributor ? wx.showModal({
                title: "提示",
                content: "您还不是推广员",
                showCancel: !1,
                success: function(t) {
                    wx.navigateBack({
                        delta: 1
                    });
                }
            }) : "4" == i.condition && "1" != i.user_info.is_distributor && wx.showModal({
                title: "提示",
                content: "您还不是推广员",
                showCancel: !1,
                success: function(t) {
                    wx.navigateBack({
                        delta: 1
                    });
                }
            }), wx.setStorageSync("userData", i), t.setData({
                userInfo: i
            });
        });
    }
});