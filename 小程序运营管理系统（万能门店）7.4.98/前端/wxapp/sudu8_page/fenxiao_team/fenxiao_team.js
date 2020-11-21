var app = getApp();

Page({
    data: {
        nav: 1,
        page_signs: "/sudu8_page/fenxiao_team/fenxiao_team"
    },
    onPullDownRefresh: function() {
        this.getmor(), wx.stopPullDownRefresh();
    },
    onLoad: function(a) {
        var s = this;
        wx.setNavigationBarTitle({
            title: "我的团队"
        });
        var t = 0;
        a.fxsid && (t = a.fxsid, s.setData({
            fxsid: a.fxsid
        })), app.util.request({
            url: "entry/wxapp/BaseMin",
            data: {
                vs1: 1
            },
            success: function(a) {
                if (a.data.data.video) var t = "show";
                if (a.data.data.c_b_bg) var e = "bg";
                s.setData({
                    baseinfo: a.data.data,
                    show_v: t,
                    c_b_bg1: e
                }), wx.setNavigationBarColor({
                    frontColor: s.data.baseinfo.base_tcolor,
                    backgroundColor: s.data.baseinfo.base_color
                });
            }
        }), app.util.getUserInfo(s.getinfos, t);
    },
    redirectto: function(a) {
        var t = a.currentTarget.dataset.link, e = a.currentTarget.dataset.linktype;
        app.util.redirectto(t, e);
    },
    getinfos: function() {
        var e = this;
        wx.getStorage({
            key: "openid",
            success: function(a) {
                var t = a.data;
                e.setData({
                    openid: t
                }), e.getmor();
            }
        });
    },
    getmor: function() {
        var t = this, a = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/myteam",
            data: {
                openid: a
            },
            success: function(a) {
                t.setData({
                    myfans: a.data.data.user,
                    counts: a.data.data.user.length,
                    fxcj: a.data.data.cj
                });
            }
        });
    },
    nav: function(a) {
        var t = this, e = a.currentTarget.dataset.id;
        t.setData({
            nav: a.currentTarget.dataset.id
        });
        var s = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/myteam",
            data: {
                types: e,
                openid: s
            },
            success: function(a) {
                t.setData({
                    myfans: a.data.data.user,
                    counts: a.data.data.user.length,
                    fxcj: a.data.data.cj
                });
            }
        });
    }
});