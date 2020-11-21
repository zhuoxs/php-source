/*   time:2019-08-09 13:18:39*/
var app = getApp();
Page({
    data: {
        variable: !0,
        is_modal_Hidden: !0
    },
    onLoad: function(a) {
        var t = this;
        app.wxauthSetting();
        var n = wx.getStorageSync("users").openid;
        app.util.request({
            url: "entry/wxapp/getUser2",
            data: {
                openid: n
            },
            success: function(a) {
                console.log("用户信息"), console.log(a.data), t.setData({
                    me: a.data
                })
            }
        })
    },
    onShow: function() {
        app.func.islogin(app, this)
    },
    myOrder: function() {
        wx.navigateTo({
            url: "../myOrder/myOrder"
        })
    },
    myMark: function() {
        wx.navigateTo({
            url: "../myMark/myMark"
        })
    },
    pointsDetails: function() {
        wx.navigateTo({
            url: "../pointsDetails/pointsDetails"
        })
    },
    addressManagement: function() {
        wx.navigateTo({
            url: "../addressManagement/addressManagement"
        })
    },
    aboutUs: function() {
        wx.navigateTo({
            url: "../aboutUs/aboutUs"
        })
    },
    home: function() {
        wx.redirectTo({
            url: "../home/home"
        })
    },
    integrationMall: function() {
        wx.redirectTo({
            url: "../integrationMall/integrationMall"
        })
    },
    assignment: function() {
        wx.redirectTo({
            url: "../assignment/assignment"
        })
    },
    updateUserInfo: function(a) {
        app.wxauthSetting()
    }
});