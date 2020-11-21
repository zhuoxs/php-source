var e = require("../../../utils/base.js"), t = require("../../../../api.js"), n = new e.Base();

getApp();

Page({
    data: {
        canIUse: wx.canIUse("button.open-type.getUserInfo")
    },
    onLoad: function(e) {
        var t = this;
        wx.getStorage({
            key: "store_info",
            success: function(e) {
                t.setData({
                    store_info: e.data
                });
            }
        });
    },
    onShow: function() {
        wx.getSetting({
            success: function(e) {
                e.authSetting["scope.userInfo"] && wx.getUserInfo({
                    success: function(e) {
                        wx.redirectTo({
                            url: "../index/index"
                        });
                    }
                });
            }
        });
    },
    getUserInfo: function(e) {
        wx.getSetting({
            success: function(e) {
                e.authSetting["scope.userInfo"] && wx.getUserInfo({
                    success: function(e) {
                        wx.setStorageSync("userInfo", e.userInfo);
                        var s = {
                            url: t.default.user_update,
                            data: {
                                nickname: e.userInfo.nickName,
                                avatar: e.userInfo.avatarUrl
                            }
                        };
                        n.getData(s, function(e) {
                            console.log(e), wx.redirectTo({
                                url: "../index/index"
                            });
                        });
                    }
                });
            }
        });
    }
});