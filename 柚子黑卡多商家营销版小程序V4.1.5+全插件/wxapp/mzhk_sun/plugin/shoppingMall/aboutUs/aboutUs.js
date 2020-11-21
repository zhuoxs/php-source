/*   time:2019-08-09 13:18:39*/
var app = getApp();
Page({
    data: {
        is_modal_Hidden: !0
    },
    onLoad: function(a) {
        var t = this;
        app.wxauthSetting(), app.util.request({
            url: "entry/wxapp/System",
            data: {
                m: app.globalData.Plugin_scoretask
            },
            success: function(a) {
                console.log("关于我们的"), console.log(a.data), t.setData({
                    aboutUs: a.data
                })
            }
        })
    },
    onReady: function() {},
    onShow: function() {
        app.func.islogin(app, this)
    },
    onHide: function() {},
    onUnload: function() {},
    updateUserInfo: function(a) {
        app.wxauthSetting()
    }
});