var app = getApp(), innerAudioContext = wx.createInnerAudioContext();

Page({
    data: {
        funcAll: [],
        data: [],
        fid: 0,
        releaseAll: [],
        isview: 0,
        rid: 0,
        pageType: 0,
        page: 1,
        duration: 0,
        searchKeys: ""
    },
    onShow: function() {
        var s = this;
        innerAudioContext.onPlay(function(a) {
            innerAudioContext.duration, setTimeout(function() {
                innerAudioContext.duration;
            }, 1e3), innerAudioContext.onTimeUpdate(function(a) {
                var e = innerAudioContext.duration, t = parseInt(e / 60);
                t < 10 && (t = "0" + t);
                var n = parseInt(e - 60 * t);
                n < 10 && (n = "0" + n);
                var i = innerAudioContext.currentTime, o = parseInt(i / 60);
                o < 10 && (o = "0" + o);
                var r = parseInt(i - 60 * o);
                r < 10 && (r = "0" + r), s.setData({
                    duration: 100 * innerAudioContext.duration.toFixed(2),
                    curTimeVal: 100 * innerAudioContext.currentTime.toFixed(2),
                    durationDay: t + ":" + n,
                    curTimeValDay: o + ":" + r
                });
            }), innerAudioContext.onEnded(function() {
                for (var a = s.data.releaseAll, e = 0; e < a.length; e++) if (0 < a[e].voice.length) for (var t = 0; t < a[e].voice.length; t++) if (1 == a[e].voice[t].play) {
                    a[e].voice[t].play = 0;
                    break;
                }
                s.setData({
                    releaseAll: a
                });
            });
        }), s.setData({
            page: 1
        }), s.getlist();
    },
    onPullDownRefresh: function() {
        this.setData({
            page: 1
        }), this.getlist(), wx.stopPullDownRefresh();
    },
    onLoad: function(a) {
        var e = this;
        e.setData({
            isIphoneX: app.globalData.isIphoneX
        }), wx.setNavigationBarTitle({
            title: "发布列表页"
        });
        var t = a.fid;
        0 < a.fid && e.setData({
            fid: t
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
                e.setData({
                    baseinfo: a.data.data
                }), wx.setNavigationBarColor({
                    frontColor: e.data.baseinfo.base_tcolor,
                    backgroundColor: e.data.baseinfo.base_color
                });
            },
            fail: function(a) {}
        }), app.util.getUserInfo(this.getinfos);
    },
    searchinput: function(a) {
        this.setData({
            searchKeys: a.detail.value,
            page: 1
        }), this.getlist();
    },
    redirectto: function(a) {
        var e = a.currentTarget.dataset.link, t = a.currentTarget.dataset.linktype;
        app.util.redirectto(e, t);
    },
    getinfos: function() {
        var n = this;
        wx.getStorage({
            key: "openid",
            success: function(a) {
                var e = app.util.url("entry/wxapp/globaluserinfo", {
                    m: "sudu8_page"
                });
                wx.request({
                    url: e,
                    data: {
                        openid: a.data
                    },
                    success: function(a) {
                        var e = a.data.data;
                        e.nickname && e.avatar || n.setData({
                            isview: 1
                        }), n.setData({
                            globaluser: a.data.data
                        });
                    }
                });
                var t = a.data;
                n.setData({
                    openid: t
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
                var e = a.userInfo, t = e.nickName, n = e.avatarUrl, i = e.gender, o = e.province, r = e.city, s = e.country, l = app.util.url("entry/wxapp/Useupdate", {
                    m: "sudu8_page"
                });
                wx.request({
                    url: l,
                    data: {
                        openid: d,
                        nickname: t,
                        avatarUrl: n,
                        gender: i,
                        province: o,
                        city: r,
                        country: s
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
        var t = this, n = a.currentTarget.dataset.index, e = a.currentTarget.dataset.rid;
        app.util.request({
            url: "entry/wxapp/ForumLikes",
            data: {
                openid: wx.getStorageSync("openid"),
                rid: e
            },
            success: function(a) {
                var e = t.data.releaseAll;
                wx.getStorageSync("golobeuser").nickname;
                1 == a.data.data.is_like ? (wx.showToast({
                    title: "点赞成功"
                }), e[n].is_like = 1) : 2 == a.data.data.is_like && (wx.showToast({
                    title: "取赞成功"
                }), e[n].is_like = 2), e[n].likes = a.data.data.num, e[n].likesAll = a.data.data.likesAll, 
                t.setData({
                    releaseAll: e
                });
            },
            fail: function(a) {}
        });
    },
    changeCollection: function(a) {
        var t = this, n = a.currentTarget.dataset.index, e = a.currentTarget.dataset.rid;
        app.util.request({
            url: "entry/wxapp/ForumCollection",
            data: {
                openid: wx.getStorageSync("openid"),
                rid: e
            },
            success: function(a) {
                var e = t.data.releaseAll;
                1 == a.data.data.is_collect ? (wx.showToast({
                    title: "收藏成功"
                }), e[n].is_collect = 1) : 2 == a.data.data.is_collect && (wx.showToast({
                    title: "取收成功"
                }), e[n].is_collect = 2), e[n].collection = a.data.data.num, t.setData({
                    releaseAll: e
                });
            },
            fail: function(a) {}
        });
    },
    onReady: function() {},
    getlist: function(a) {
        var e = this;
        if (null == a) var t = e.data.fid; else {
            t = a.currentTarget.dataset.id;
            e.setData({
                fid: t,
                page: 1
            });
        }
        app.util.request({
            url: "entry/wxapp/ReleaseAll",
            data: {
                fid: t,
                searchKeys: e.data.searchKeys,
                page: e.data.page,
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
                }) : e.setData({
                    releaseAll: a.data.data.releaseAll,
                    funcAll: a.data.data.funcAll,
                    pageType: a.data.data.pageType
                }));
            }
        });
    },
    onReachBottom: function() {
        var e = this, t = e.data.page + 1, a = e.data.fid;
        app.util.request({
            url: "entry/wxapp/ReleaseAll",
            data: {
                fid: a,
                searchKeys: e.data.searchKeys,
                page: t,
                openid: e.data.openid
            },
            success: function(a) {
                e.setData({
                    releaseAll: e.data.releaseAll.concat(a.data.data.releaseAll),
                    page: t
                });
            }
        });
    },
    goRelease: function() {
        wx.navigateTo({
            url: "/sudu8_page_plugin_mapforum/release/release?fid=" + this.data.fid
        });
    },
    goCollect: function() {
        wx.navigateTo({
            url: "/sudu8_page_plugin_mapforum/collect/collect"
        });
    },
    goContent: function(a) {
        var e = a.currentTarget.dataset.rid;
        wx.navigateTo({
            url: "/sudu8_page_plugin_mapforum/forum_page/forum_page?rid=" + e
        });
    },
    makephone: function(a) {
        var e = a.currentTarget.dataset.tel;
        wx.makePhoneCall({
            phoneNumber: e
        });
    },
    videoplay: function() {},
    voiceplay: function() {},
    playvoice: function(a) {
        for (var e = this.data.releaseAll, t = a.currentTarget.dataset.index, n = a.currentTarget.dataset.idx, i = 0; i < e[n].voice.length; i++) e[n].voice[i].play = t == i ? 1 : 0, 
        this.setData({
            releaseAll: e
        });
        var o = a.currentTarget.dataset.voice;
        innerAudioContext.src = o, innerAudioContext.play();
    },
    stopvoice: function(a) {
        var e = this.data.releaseAll, t = a.currentTarget.dataset.index;
        e[a.currentTarget.dataset.idx].voice[t].play = 0, this.setData({
            releaseAll: e
        }), innerAudioContext.stop(function() {});
    },
    onHide: function() {},
    onUnload: function() {},
    onShareAppMessage: function() {}
});