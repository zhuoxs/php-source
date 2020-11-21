var app = getApp();

Page({
    data: {
        funcAll: [],
        data: [],
        fid: 0,
        releaseAll: [],
        isview: 0,
        rid: 0,
        pageType: 0,
        page: 1
    },
    onShow: function() {
        this.setData({
            page: 1
        }), this.getlist();
    },
    onPullDownRefresh: function() {
        this.setData({
            page: 1
        }), this.getlist(), wx.stopPullDownRefresh();
    },
    onLoad: function(a) {
        var t = this;
        t.setData({
            isIphoneX: app.globalData.isIphoneX
        }), wx.setNavigationBarTitle({
            title: "发布列表页"
        });
        var e = a.fid;
        0 < a.fid && t.setData({
            fid: e
        });
        var n = app.util.url("entry/wxapp/BaseMin", {
            m: "sudu8_page"
        });
        wx.request({
            url: n,
            cachetime: "30",
            data: {
                vs1: 1
            },
            success: function(a) {
                t.setData({
                    baseinfo: a.data.data
                }), wx.setNavigationBarColor({
                    frontColor: t.data.baseinfo.base_tcolor,
                    backgroundColor: t.data.baseinfo.base_color
                });
            },
            fail: function(a) {}
        }), app.util.getUserInfo(this.getinfos);
    },
    redirectto: function(a) {
        var t = a.currentTarget.dataset.link, e = a.currentTarget.dataset.linktype;
        app.util.redirectto(t, e);
    },
    getinfos: function() {
        var n = this;
        wx.getStorage({
            key: "openid",
            success: function(a) {
                var t = app.util.url("entry/wxapp/globaluserinfo", {
                    m: "sudu8_page"
                });
                wx.request({
                    url: t,
                    data: {
                        openid: a.data
                    },
                    success: function(a) {
                        var t = a.data.data;
                        t.nickname && t.avatar || n.setData({
                            isview: 1
                        }), n.setData({
                            globaluser: a.data.data
                        });
                    }
                });
                var e = a.data;
                n.setData({
                    openid: e
                });
            },
            fail: function(a) {
                n.setData({
                    isview: 1
                });
            }
        });
    },
    huoqusq: function() {
        var u = this, d = wx.getStorageSync("openid");
        wx.getUserInfo({
            success: function(a) {
                var t = a.userInfo, e = t.nickName, n = t.avatarUrl, i = t.gender, s = t.province, o = t.city, l = t.country, r = app.util.url("entry/wxapp/Useupdate", {
                    m: "sudu8_page"
                });
                wx.request({
                    url: r,
                    data: {
                        openid: d,
                        nickname: e,
                        avatarUrl: n,
                        gender: i,
                        province: s,
                        city: o,
                        country: l
                    },
                    header: {
                        "content-type": "application/json"
                    },
                    success: function(a) {
                        wx.setStorageSync("golobeuid", a.data.data.id), wx.setStorageSync("golobeuser", a.data.data), 
                        u.setData({
                            isview: 0,
                            globaluser: a.data.data
                        });
                    }
                });
            }
        });
    },
    changeLikes: function(a) {
        var e = this, n = a.currentTarget.dataset.index, t = a.currentTarget.dataset.rid;
        app.util.request({
            url: "entry/wxapp/ForumLikes",
            data: {
                openid: wx.getStorageSync("openid"),
                rid: t
            },
            success: function(a) {
                var t = e.data.releaseAll;
                wx.getStorageSync("golobeuser").nickname;
                1 == a.data.data.is_like ? (wx.showToast({
                    title: "点赞成功"
                }), t[n].is_like = 1) : 2 == a.data.data.is_like && (wx.showToast({
                    title: "取赞成功"
                }), t[n].is_like = 2), t[n].likes = a.data.data.num, t[n].likesAll = a.data.data.likesAll, 
                e.setData({
                    releaseAll: t
                });
            },
            fail: function(a) {}
        });
    },
    changeCollection: function(a) {
        var e = this, n = a.currentTarget.dataset.index, t = a.currentTarget.dataset.rid;
        app.util.request({
            url: "entry/wxapp/ForumCollection",
            data: {
                openid: wx.getStorageSync("openid"),
                rid: t
            },
            success: function(a) {
                var t = e.data.releaseAll;
                1 == a.data.data.is_collect ? (wx.showToast({
                    title: "收藏成功"
                }), t[n].is_collect = 1) : 2 == a.data.data.is_collect && (wx.showToast({
                    title: "取收成功"
                }), t[n].is_collect = 2), t[n].collection = a.data.data.num, e.setData({
                    releaseAll: t
                });
            },
            fail: function(a) {}
        });
    },
    onReady: function() {},
    getlist: function(a) {
        var t = this;
        if (null == a) var e = t.data.fid; else {
            e = a.currentTarget.dataset.id;
            t.setData({
                fid: e,
                page: 1
            });
        }
        app.util.request({
            url: "entry/wxapp/ReleaseAll",
            data: {
                fid: e,
                page: t.data.page,
                openid: wx.getStorageSync("openid")
            },
            success: function(a) {
                "" != a.data && (2 == a.data.data.is ? wx.showModal({
                    title: "提示",
                    content: "该分类不存在或不启用",
                    showCancel: !1,
                    success: function(a) {
                        wx.navigateBack({
                            delta: 1
                        });
                    }
                }) : t.setData({
                    releaseAll: a.data.data.releaseAll,
                    funcAll: a.data.data.funcAll,
                    pageType: a.data.data.pageType
                }));
            }
        });
    },
    onReachBottom: function() {
        var t = this, e = t.data.page + 1, a = t.data.fid;
        app.util.request({
            url: "entry/wxapp/ReleaseAll",
            data: {
                fid: a,
                page: e,
                openid: t.data.openid
            },
            success: function(a) {
                t.setData({
                    releaseAll: t.data.releaseAll.concat(a.data.data.releaseAll),
                    page: e
                });
            }
        });
    },
    goRelease: function() {
        wx.navigateTo({
            url: "/sudu8_page_plugin_forum/release/release?fid=" + this.data.fid
        });
    },
    goCollect: function() {
        wx.navigateTo({
            url: "/sudu8_page_plugin_forum/collect/collect"
        });
    },
    goContent: function(a) {
        var t = a.currentTarget.dataset.rid;
        wx.navigateTo({
            url: "/sudu8_page_plugin_forum/forum_page/forum_page?rid=" + t
        });
    },
    makephone: function(a) {
        var t = a.currentTarget.dataset.tel;
        wx.makePhoneCall({
            phoneNumber: t
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onShareAppMessage: function() {}
});