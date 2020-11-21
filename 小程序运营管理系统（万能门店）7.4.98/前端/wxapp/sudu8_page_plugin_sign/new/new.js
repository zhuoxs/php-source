var app = getApp();

Page({
    data: {
        page: 1,
        collectlist: "",
        baseinfo: [],
        arr: ""
    },
    onPullDownRefresh: function() {
        this.getCollect(), wx.stopPullDownRefresh();
    },
    onLoad: function(t) {
        var a = this;
        a.getCollect(), wx.setNavigationBarTitle({
            title: "最新签到"
        });
        var e = 0;
        t.fxsid && (e = t.fxsid, a.setData({
            fxsid: t.fxsid
        }));
        var o = app.util.url("entry/wxapp/BaseMin", {
            m: "sudu8_page"
        });
        wx.request({
            url: o,
            data: {
                vs1: 1
            },
            success: function(t) {
                t.data.data;
                a.setData({
                    baseinfo: t.data.data
                }), wx.setNavigationBarColor({
                    frontColor: a.data.baseinfo.base_tcolor,
                    backgroundColor: a.data.baseinfo.base_color
                });
            }
        }), app.util.getUserInfo(this.getinfos, e);
    },
    redirectto: function(t) {
        var a = t.currentTarget.dataset.link, e = t.currentTarget.dataset.linktype;
        app.util.redirectto(a, e);
    },
    getinfos: function() {
        var a = this;
        wx.getStorage({
            key: "openid",
            success: function(t) {
                a.setData({
                    openid: t.data
                });
            }
        });
    },
    getCollect: function() {
        var a = this, t = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/Zxqd",
            data: {
                openid: t
            },
            success: function(t) {
                a.setData({
                    arr: t.data.data
                });
            }
        });
    },
    onShareAppMessage: function() {
        return {
            title: "最新签到"
        };
    }
});