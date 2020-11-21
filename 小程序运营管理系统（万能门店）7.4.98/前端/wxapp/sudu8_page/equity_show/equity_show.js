var app = getApp();

Page({
    data: {
        shows: []
    },
    onLoad: function(t) {
        var a = this;
        wx.setNavigationBarTitle({
            title: "开通权益"
        });
        var e = 0;
        t.fxsid && (e = t.fxsid, a.setData({
            fxsid: t.fxsid
        })), a.getBase(), app.util.getUserInfo(a.getinfos, e);
    },
    getinfos: function() {
        var a = this;
        wx.getStorage({
            key: "openid",
            success: function(t) {
                a.setData({
                    openid: t.data
                }), a.getequity();
            }
        });
    },
    getequity: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/getequity",
            success: function(t) {
                a.setData({
                    shows: t.data.data.equity,
                    bg_img: t.data.data.bg_img
                });
            },
            fail: function(t) {}
        });
    },
    getBase: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/BaseMin",
            cachetime: "30",
            data: {
                vs1: 1
            },
            success: function(t) {
                a.setData({
                    baseinfo: t.data.data
                }), wx.setNavigationBarColor({
                    frontColor: a.data.baseinfo.base_tcolor,
                    backgroundColor: a.data.baseinfo.base_color
                });
            },
            fail: function(t) {}
        });
    },
    toregister: function() {
        wx.redirectTo({
            url: "/sudu8_page/register/register"
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});