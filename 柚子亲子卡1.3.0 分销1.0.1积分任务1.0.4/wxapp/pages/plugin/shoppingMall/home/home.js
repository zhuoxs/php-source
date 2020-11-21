var app = getApp();

Page({
    data: {
        showModel: !1,
        loadImgKey: !1,
        make: !1,
        variable: !0,
        isPlayingMusic: !1,
        curPage: 1,
        pagesize: 3,
        activeList: [],
        list: []
    },
    onLoad: function(t) {
        var e = this, a = (wx.getStorageSync("user").openid, t.share_type);
        if (1 == a) {
            var o = t.article_id, i = t.d_user;
            wx.setStorageSync("article_id_1", o), wx.setStorageSync("share_type", a), wx.setStorageSync("d_user", i), 
            app.util.request({
                url: "entry/wxapp/getArticleDetail",
                data: {
                    m: app.globalData.Plugin_scoretask,
                    id: o
                },
                success: function(t) {
                    wx.navigateTo({
                        url: "../publicNumber/publicNumber?url=" + t.data.data.url
                    });
                }
            });
        } else if (2 == a) {
            i = t.d_user;
            wx.setStorageSync("share_type", a), wx.setStorageSync("d_user", i);
        }
        app.util.request({
            url: "entry/wxapp/getCustomize",
            data: {
                m: app.globalData.Plugin_scoretask
            },
            showLoading: !1,
            success: function(t) {
                console.log("列表页面"), console.log(t), e.setData({
                    banner: t.data.data.banner,
                    imgroot: t.data.other.img_root,
                    icons: t.data.data.icons
                });
            }
        }), e.getArticleList();
    },
    onShow: function() {
        var t = wx.getStorageSync("article_id"), e = wx.getStorageSync("user").openid;
        if (1 == wx.getStorageSync("share_type")) {
            var a = wx.getStorageSync("d_user"), o = wx.getStorageSync("article_id_1");
            app.util.request({
                url: "entry/wxapp/setRead",
                data: {
                    m: app.globalData.Plugin_scoretask,
                    openid: e,
                    article_id: o,
                    invite_openid: a
                },
                showLoading: !1,
                success: function(t) {
                    if (0 == (t = t.data).code) {
                        var e = "恭喜您获得" + t.data + "积分";
                        wx.showToast({
                            title: e,
                            icon: "none",
                            duration: 1200
                        });
                    } else 1 == t.code && wx.showToast({
                        title: t.msg,
                        icon: "none",
                        duration: 1200
                    });
                }
            }), wx.setStorageSync("share_type", 0), wx.setStorageSync("d_user", 0), wx.setStorageSync("article_id_1", 0);
        }
        0 < t && app.util.request({
            url: "entry/wxapp/setRead",
            data: {
                m: app.globalData.Plugin_scoretask,
                openid: e,
                article_id: t
            },
            showLoading: !1,
            success: function(t) {
                if (0 == (t = t.data).code) {
                    var e = "恭喜您获得" + t.data + "积分";
                    wx.showToast({
                        title: e,
                        icon: "none",
                        duration: 1200
                    });
                } else 1 == t.code && wx.showToast({
                    title: t.msg,
                    icon: "none",
                    duration: 1200
                });
            }
        }), wx.setStorageSync("article_id", 0);
    },
    onShareAppMessage: function(t) {
        var e = 1;
        if ("button" === t.from) {
            e = t.target.dataset.type;
            var a = t.target.dataset.article_id, o = t.target.dataset.openid, i = t.target.dataset.title, n = t.target.dataset.icon;
            if (1 == e) return {
                title: i,
                imageUrl: this.data.imgroot + n,
                path: "/pages/plugin/shoppingMall/home/home?share_type=" + e + "&d_user=" + o + "&article_id=" + a,
                success: function(t) {
                    console.log("转发成功");
                },
                fail: function(t) {
                    console.log("转发失败");
                }
            };
        }
    },
    onReachBottom: function() {},
    getArticleList: function() {
        var o = this, i = o.data.curPage, n = o.data.list, t = wx.getStorageSync("user").openid;
        app.util.request({
            url: "entry/wxapp/getArticleList",
            data: {
                m: app.globalData.Plugin_scoretask,
                show_index: 1,
                openid: t,
                page: i,
                pagesize: o.data.pagesize
            },
            showLoading: !1,
            success: function(t) {
                console.log(t.data.other);
                var e = t.data.data.length == o.data.pagesize;
                if (1 == i) n = t.data.data; else for (var a in t.data.data) n.push(t.data.data[a]);
                console.log("页数"), i += 1, console.log(i), o.setData({
                    imgroot: t.data.other.img_root,
                    list: n,
                    curPage: i,
                    hasMore: e
                });
            }
        });
    },
    lower: function(t) {
        this.data.hasMore ? this.getArticleList() : wx.showToast({
            title: "没有更多活动了~",
            icon: "none"
        });
    },
    publicLink: function(t) {
        var e = t.currentTarget.dataset.url, a = t.currentTarget.dataset.id;
        wx.setStorageSync("article_id", a), wx.navigateTo({
            url: "../publicNumber/publicNumber?url=" + e
        });
    },
    onHide: function() {
        console.log("写作");
    },
    onUnload: function() {
        console.log("写作1");
    },
    searchBtn: function(t) {
        var e = t.detail.value;
        wx.navigateTo({
            url: "../lifeCounseling/lifeCounseling?value=" + e
        });
    },
    jumpLink: function(t) {
        console.log(t);
        var e = t.currentTarget.dataset.url;
        wx.navigateTo({
            url: e
        });
    },
    integrationMall: function() {
        wx.redirectTo({
            url: "../integrationMall/integrationMall"
        });
    },
    assignment: function() {
        wx.redirectTo({
            url: "../assignment/assignment"
        });
    },
    me: function() {
        wx.redirectTo({
            url: "../me/me"
        });
    },
    submit: function(t) {
        var e = t.currentTarget.dataset.id, a = wx.getStorageSync("user").openid, o = t.currentTarget.dataset.title, i = t.currentTarget.dataset.icon;
        this.setData({
            showModel: !0,
            type: 1,
            article_id: e,
            openid: a,
            title: o,
            icon: i
        });
    },
    preventTouchMove: function() {},
    go: function() {
        this.setData({
            showModel: !1
        });
    },
    making: function(t) {
        var e = this, a = t.currentTarget.dataset.id, o = wx.getStorageSync("user").openid, i = e.data.list, n = t.currentTarget.dataset.index, r = t.currentTarget.dataset.is_mark;
        0 == r ? app.util.request({
            url: "entry/wxapp/setMark",
            data: {
                m: app.globalData.Plugin_scoretask,
                openid: o,
                article_id: a
            },
            showLoading: !1,
            success: function(t) {
                t = t.data;
                i[n].is_mark = 1, e.setData({
                    list: i
                }), 0 == t.code ? wx.showToast({
                    title: "收藏成功",
                    icon: "success",
                    duration: 1200
                }) : wx.showToast({
                    title: t.msg,
                    icon: "none",
                    duration: 1200
                });
            }
        }) : 1 == r && app.util.request({
            url: "entry/wxapp/cancelMark",
            data: {
                m: app.globalData.Plugin_scoretask,
                openid: o,
                article_id: a
            },
            showLoading: !1,
            success: function(t) {
                0 == (t = t.data).code ? (i[n].is_mark = 0, e.setData({
                    list: i
                }), wx.showToast({
                    title: "取消成功",
                    icon: "success",
                    duration: 1200
                })) : wx.showToast({
                    title: t.msg,
                    icon: "none",
                    duration: 1200
                });
            }
        });
    },
    onPosterTab: function() {
        var a = this;
        if (wx.showLoading({
            title: "海报生成中..."
        }), a.data.posterUrl) wx.hideLoading(), wx.previewImage({
            current: a.data.posterUrl,
            urls: [ a.data.posterUrl ]
        }); else {
            var o = wx.getStorageSync("system"), i = app.siteInfo.siteroot.split("/app/")[0] + "/attachment/", t = wx.getStorageSync("user_info");
            console.log(t), console.log(i);
            app.util.request({
                url: "entry/wxapp/GetwxCode",
                data: {
                    page: "demo_sun/pages/index/index",
                    width: 120
                },
                success: function(t) {
                    console.log("获取小程序二维码"), console.log(t.data);
                    var e = t.data;
                    a.setData({
                        posterinfo: {
                            avatar: i + "" + o.poster_img,
                            banner: i + "" + o.poster_img,
                            qr: i + e,
                            wxcode_pic: e
                        },
                        loadImgKey: !0
                    }), console.log(a.data.posterinfo);
                }
            });
        }
    },
    createPoster: function(t) {
        var e = t.detail;
        this.setData({
            posterUrl: e.url
        }), wx.hideLoading(), wx.previewImage({
            current: "" + t.detail.url,
            urls: [ t.detail.url ]
        });
    },
    toIndex: function(t) {
        wx.reLaunch({
            url: "/yzqzk_sun/pages/index/index"
        });
    },
    winners: function(t) {
        var e = t.currentTarget.dataset.url;
        wx.navigateTo({
            url: e
        });
    }
});