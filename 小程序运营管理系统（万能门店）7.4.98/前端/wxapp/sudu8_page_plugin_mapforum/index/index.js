var app = getApp();

Page({
    data: {
        data: [],
        page_signs: "/sudu8_page_plugin_mapforum/index/index"
    },
    onPullDownRefresh: function() {
        this.getbaseinfo(), this.getfunc(), wx.stopPullDownRefresh();
    },
    onShow: function() {
        this.getfunc();
    },
    onLoad: function() {
        this.setData({
            isIphoneX: app.globalData.isIphoneX
        }), wx.setNavigationBarTitle({
            title: "地图论坛首页"
        }), this.getbaseinfo();
    },
    getbaseinfo: function() {
        var a = this, t = app.util.url("entry/wxapp/BaseMin", {
            m: "sudu8_page"
        });
        wx.request({
            url: t,
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
    redirectto: function(t) {
        var a = t.currentTarget.dataset.link, n = t.currentTarget.dataset.linktype;
        app.util.redirectto(a, n);
    },
    getfunc: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/Forumfunc",
            success: function(t) {
                a.setData({
                    data: t.data.data
                });
            },
            fail: function(t) {}
        });
    },
    onReady: function() {},
    onHide: function() {},
    onUnload: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});