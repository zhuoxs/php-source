/*   time:2019-08-09 13:18:39*/
var app = getApp();
Page({
    data: {
        is_modal_Hidden: !0
    },
    onLoad: function(n) {
        app.wxauthSetting();
        var a = n.url;
        this.setData({
            path: a
        })
    },
    onShow: function() {
        app.func.islogin(app, this)
    },
    bindmessage: function(n) {
        console.log("回调"), console.log(n)
    },
    onShareAppMessage: function(n) {
        var a = this.data.path;
        return console.log(a), {
            path: "/mzhk_sun/plugin/shoppingMall/publicNumber/publicNumber?url=" + a
        }
    },
    ceshi: function(n) {
        console.log("cesshji")
    },
    updateUserInfo: function(n) {
        app.wxauthSetting()
    }
});