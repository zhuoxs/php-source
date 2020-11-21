var app = getApp();

Page({
    data: {},
    onLoad: function(a) {
        var t = (t = app.siteInfo.siteroot).substring(0, t.length - 13), e = this, n = a.id;
        e.setData({
            host: t,
            id: n
        });
        var o = 0;
        a.fxsid && (o = a.fxsid, e.setData({
            fxsid: a.fxsid
        }));
        var i = app.util.url("entry/wxapp/BaseMin", {
            m: "sudu8_page"
        });
        wx.request({
            url: i,
            data: {
                vs1: 1
            },
            cachetime: "30",
            success: function(a) {
                a.data.data;
                e.setData({
                    baseinfo: a.data.data
                }), wx.setNavigationBarColor({
                    frontColor: e.data.baseinfo.base_tcolor,
                    backgroundColor: e.data.baseinfo.base_color
                });
            }
        }), app.util.getUserInfo(e.getinfos, o), e.dataindex();
    },
    dataindex: function() {
        var t = this, a = app.util.url("entry/wxapp/Dataindex", {
            m: "sudu8_page_plugin_shop"
        });
        wx.request({
            url: a,
            data: {
                id: wx.getStorageSync("mlogin"),
                openid: wx.getStorageSync("openid")
            },
            cachetime: "30",
            success: function(a) {
                t.setData({
                    dataindex: a.data.data
                });
            }
        });
    },
    redirectto: function(a) {
        var t = a.currentTarget.dataset.link, e = a.currentTarget.dataset.linktype;
        app.util.redirectto(t, e);
    },
    goProList: function() {
        wx.redirectTo({
            url: "sudu8_page_plugin_shop/manage_prolist/manage_prolist"
        });
    },
    goOrderList: function() {
        wx.redirectTo({
            url: "sudu8_page_plugin_shop/manage_order/manage_order"
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        this.dataindex(), wx.stopPullDownRefresh();
    },
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});