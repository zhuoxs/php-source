var app = getApp();

Page({
    data: {
        minHeight: 220,
        bg: "",
        userinfo: "",
        hasEmptyGrid: !1,
        showPicker: !1,
        paixu: ""
    },
    onPullDownRefresh: function() {
        this.data.id;
        this.getsign(), wx.stopPullDownRefresh();
    },
    onLoad: function(t) {
        var a = this;
        a.getsign(), wx.setNavigationBarTitle({
            title: "签到排行榜"
        });
        var e = 0;
        t.fxsid && (e = t.fxsid, a.setData({
            fxsid: t.fxsid
        }));
        var i = app.util.url("entry/wxapp/BaseMin", {
            m: "sudu8_page"
        });
        wx.request({
            url: i,
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
        }), app.util.getUserInfo(a.getinfos, e);
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
    getsign: function() {
        var e = this, t = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/paihb",
            data: {
                openid: t
            },
            success: function(t) {
                var a = t.data.data;
                e.setData({
                    paixu: a
                });
            }
        });
    },
    onShareAppMessage: function() {
        return {
            title: "签到排行榜"
        };
    }
});