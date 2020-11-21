var app = getApp();

Page({
    data: {
        list: [],
        page: 1,
        isview: 0,
        type: 1
    },
    onPullDownRefresh: function() {
        this.setData({
            page: 1
        }), this.getlist(), wx.stopPullDownRefresh();
    },
    onLoad: function() {
        var a = this;
        a.setData({
            isIphoneX: app.globalData.isIphoneX
        }), wx.setNavigationBarTitle({
            title: "收藏页"
        });
        var t = app.util.url("entry/wxapp/BaseMin", {
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
        }), app.util.getUserInfo(this.getinfos), a.getlist();
    },
    change: function(t) {
        var a = this, e = t.currentTarget.dataset.type;
        a.data.type != e && (a.setData({
            type: e,
            page: 1
        }), a.getlist());
    },
    redirectto: function(t) {
        var a = t.currentTarget.dataset.link, e = t.currentTarget.dataset.linktype;
        app.util.redirectto(a, e);
    },
    getlist: function() {
        var a = this, t = a.data.page;
        app.util.request({
            url: "entry/wxapp/GetForumCollect",
            data: {
                openid: wx.getStorageSync("openid"),
                page: t,
                type: a.data.type
            },
            success: function(t) {
                a.setData({
                    list: t.data.data
                });
            },
            fail: function(t) {}
        });
    },
    onReachBottom: function() {
        var a = this, e = a.data.page + 1;
        app.util.request({
            url: "entry/wxapp/GetForumCollect",
            data: {
                openid: wx.getStorageSync("openid"),
                page: e,
                type: a.data.type
            },
            success: function(t) {
                a.setData({
                    list: a.data.list.concat(t.data.data),
                    page: e
                });
            },
            fail: function(t) {}
        });
    },
    getinfos: function() {
        var e = this;
        wx.getStorage({
            key: "openid",
            success: function(t) {
                var a = t.data;
                e.setData({
                    openid: a
                });
            },
            fail: function(t) {
                e.setData({
                    isview: 1
                });
            }
        });
    },
    huoqusq: function() {
        var c = this, u = wx.getStorageSync("openid");
        wx.getUserInfo({
            success: function(t) {
                var a = t.userInfo, e = a.nickName, n = a.avatarUrl, o = a.gender, i = a.province, s = a.city, r = a.country;
                app.util.request({
                    url: "entry/wxapp/Useupdate",
                    data: {
                        openid: u,
                        nickname: e,
                        avatarUrl: n,
                        gender: o,
                        province: i,
                        city: s,
                        country: r
                    },
                    header: {
                        "content-type": "application/json"
                    },
                    success: function(t) {
                        wx.setStorageSync("golobeuid", t.data.data.id), wx.setStorageSync("golobeuser", t.data.data), 
                        c.setData({
                            isview: 0,
                            globaluser: t.data.data
                        });
                    }
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onShareAppMessage: function() {}
});