var _home = require("../../modules/home"), homeModule = new _home.home(), app = getApp();

Page({
    data: {
        logo: ""
    },
    onLoad: function(n) {
        var o = this, t = setInterval(function() {
            app.globalData.syStem && (clearInterval(t), o.setData({
                logo: app.globalData.syStem.logo
            }));
        }, 10);
        this.login();
    },
    onReady: function() {
        app.setNavigation();
    },
    onShow: function() {},
    login: function(n) {
        wx.getSetting({
            success: function(n) {
                n.authSetting["scope.userInfo"] ? app.util.getUserInfo(function(n) {
                    n ? homeModule.login().then(function(n) {
                        var o = setInterval(function() {
                            app.globalData.is_client && (clearInterval(o), app.bindUid());
                        }, 1e3);
                        wx.switchTab({
                            url: "../index/index"
                        });
                    }, function(n) {}) : app.hint("获取信息失败~");
                }) : app.hint("登录需要授权");
            },
            fail: function(n) {}
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {
        return app.userShare();
    }
});