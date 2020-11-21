var app = getApp();

Page({
    data: {
        page_signs: "/sudu8_page/scorelist/scorelist",
        baseinfo: [],
        userInfo: "",
        searchtitle: "",
        scopes: !1,
        money: 0,
        score: 0,
        isview: 0,
        page: 1,
        xz: 1
    },
    onPullDownRefresh: function() {
        this.getinfos(), wx.stopPullDownRefresh();
    },
    onLoad: function(t) {
        var a = this;
        wx.setNavigationBarTitle({
            title: "积分明细"
        });
        var e = 0;
        t.fxsid && (e = t.fxsid, a.setData({
            fxsid: t.fxsid
        }));
        var s = t.type;
        null != s && a.setData({
            xz: s
        }), a.getBase(), app.util.getUserInfo(a.getinfos, e);
    },
    getinfos: function() {
        var e = this;
        wx.getStorage({
            key: "openid",
            success: function(t) {
                e.setData({
                    openid: t.data
                }), e.getinfo();
                var a = e.data.xz;
                1 == a && e.getscore(), 2 == a && e.getmoney();
            }
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
    redirectto: function(t) {
        var a = t.currentTarget.dataset.link, e = t.currentTarget.dataset.linktype;
        app.util.redirectto(a, e);
    },
    getinfo: function() {
        var a = this;
        wx.getStorage({
            key: "openid",
            success: function(t) {
                app.util.request({
                    url: "entry/wxapp/globaluserinfo",
                    data: {
                        openid: t.data
                    },
                    success: function(t) {
                        a.setData({
                            globaluser: t.data.data
                        });
                    }
                });
            }
        });
    },
    getscore: function() {
        var a = this;
        wx.getStorage({
            key: "openid",
            success: function(t) {
                app.util.request({
                    url: "entry/wxapp/getmyscorelist",
                    data: {
                        openid: t.data,
                        page: a.data.page
                    },
                    success: function(t) {
                        a.setData({
                            scorelists: t.data.data.lists
                        });
                    }
                });
            }
        });
    },
    getmoney: function() {
        var a = this;
        wx.getStorage({
            key: "openid",
            success: function(t) {
                app.util.request({
                    url: "entry/wxapp/getmymoneylist",
                    data: {
                        openid: t.data,
                        page: a.data.page
                    },
                    success: function(t) {
                        a.setData({
                            scorelists: t.data.data.lists
                        });
                    }
                });
            }
        });
    },
    onReachBottom: function() {
        var a = this, e = a.data.page + 1, t = wx.getStorageSync("openid");
        1 == a.data.xz ? app.util.request({
            url: "entry/wxapp/getmyscorelist",
            data: {
                openid: t,
                page: e
            },
            success: function(t) {
                1 == t.data.data.isover && a.setData({
                    scorelists: a.data.scorelists.concat(t.data.data.lists),
                    page: e
                });
            }
        }) : app.util.request({
            url: "entry/wxapp/getmymoneylist",
            data: {
                openid: t,
                page: e
            },
            success: function(t) {
                1 == t.data.data.isover && a.setData({
                    scorelists: a.data.scorelists.concat(t.data.data.lists),
                    page: e
                });
            }
        });
    },
    qieh: function(t) {
        var a = this, e = t.target.dataset.id;
        a.data.xz != e && (a.setData({
            xz: e,
            page: 1
        }), 1 == e ? (a.getscore(), wx.setNavigationBarTitle({
            title: "积分明细"
        })) : (a.getmoney(), wx.setNavigationBarTitle({
            title: "消费流水"
        })));
    }
});