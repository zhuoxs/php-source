var app = getApp();

Page({
    data: {
        navTile: "首页",
        bg: "../../../style/images/bg.png",
        cardsBg: app.globalData.cardsBg,
        weblogo: "../../../style/images/logo.png",
        cardsOpear: [],
        memberPrice: "",
        notice: [],
        imgUrls: [],
        operation: [],
        couponBg: "../../../style/images/couponbg.png",
        idMember: 0,
        story: [],
        list: [],
        isLogin: !1,
        vipType: 0,
        curPage: 1,
        pagesize: 3,
        sort: [ {
            order: 1,
            status: !0
        }, {
            order: 1,
            status: !0
        }, {
            order: 1,
            status: !0
        }, {
            order: 1,
            status: !0
        }, {
            order: 1,
            status: !0
        }, {
            order: 1,
            status: !0
        }, {
            order: 1,
            status: !0
        }, {
            order: 1,
            status: !0
        } ],
        showAd: !1,
        imgroot: wx.getStorageSync("imgroot"),
        animationData: {}
    },
    onLoad: function(t) {
        var o = this;
        wx.setNavigationBarTitle({
            title: o.data.navTile
        }), t = app.func.decodeScene(t), o.setData({
            options: t
        }), t.d_user_id && o.setData({
            d_user_id: t.d_user_id
        }), app.get_imgroot().then(function(e) {
            app.get_qz_cards(!0).then(function(t) {
                t.background = t.background ? e + t.background : t.background;
                var a = t.kkxf_background ? e + t.kkxf_background : t.kkxf_background;
                o.setData({
                    imgroot: e,
                    qzCards: t,
                    cardsBg: t.background || o.data.cardsBg,
                    couponBg: a || o.data.couponBg
                });
            });
        }), app.get_setting(!0).then(function(t) {
            if (1 == t.is_layout && o.setData({
                sort: t.index_layout
            }), "" == wx.getStorageSync("showAd") && 1 == t.is_adv) var a = 1; else a = 0;
            o.setData({
                setting: t,
                showAd: a
            }), app.globalData.showAd = t.is_adv, t.index_title && wx.setNavigationBarTitle({
                title: t.index_title
            }), null != t.fontcolor && "" != t.fontcolor && null != t.fontcolor || (t.fontcolor = "#000000"), 
            null != t.color && "" != t.color && null != t.color || (t.color = "#ffffff"), wx.setNavigationBarColor({
                frontColor: t.fontcolor,
                backgroundColor: t.color
            });
        }), o.getSomething();
    },
    onShow: function() {
        var a = this, t = a.data.options;
        t.d_user_id && app.distribution.distribution_parsent(app, t.d_user_id), app.get_user_vip().then(function(t) {
            a.setData({
                vipType: t
            });
        }), app.get_user_info(!0).then(function(t) {
            a.setData({
                user: t
            });
        }), null != app.globalData.showAd && a.setData({
            showAd: app.globalData.showAd
        }), a.get_story_list(), a.get_active_list();
    },
    onShareAppMessage: function() {
        return {
            path: "/yzcyk_sun/pages/index/index?d_user_id=" + this.data.user.id
        };
    },
    updateUserInfo: function(t) {
        var a = wx.getStorageSync("user") || [];
        this.setData({
            user: a
        });
    },
    get_story_list: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/getStoryStStory",
            cachetime: "0",
            data: {
                page: 1,
                pagesize: 3,
                show_index: 1
            },
            success: function(t) {
                a.setData({
                    story: t.data
                });
            }
        });
    },
    get_active_list: function() {
        var o = this, n = o.data.curPage, r = o.data.list;
        app.util.request({
            url: "entry/wxapp/getActivity",
            cachetime: "0",
            data: {
                show_index: 1,
                page: n,
                pagesize: o.data.pagesize
            },
            success: function(t) {
                var a = t.data.length == o.data.pagesize;
                if (1 == n) r = t.data; else for (var e in t.data) r.push(t.data[e]);
                n += 1, o.setData({
                    list: r,
                    curPage: n,
                    hasMore: a
                });
            }
        });
    },
    getSomething: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/getAnnouncement",
            cachetime: "10",
            success: function(t) {
                a.setData({
                    notice: t.data
                });
            }
        }), app.get_diy_msg().then(function(t) {
            a.setData({
                imgUrls: t.banner
            });
        }), console.log(111111), app.util.request({
            url: "entry/wxapp/getCustomize",
            cachetime: "10",
            success: function(t) {
                console.log(t.data), a.setData({
                    operation: t.data.icons
                });
            }
        });
    },
    toPrivilege: function(t) {
        wx.navigateTo({
            url: "/yzcyk_sun/pages/index/privilege/privilege"
        });
    },
    toParenting: function(t) {
        wx.navigateTo({
            url: "/yzcyk_sun/pages/index/parenting/parenting"
        });
    },
    toJoinMember: function(t) {
        wx.navigateTo({
            url: "../member/joinmember/joinmember"
        });
    },
    toParentingdet: function(t) {
        var a = t.currentTarget.dataset.id;
        wx.navigateTo({
            url: "parentingdet/parentingdet?id=" + a
        });
    },
    toInner: function(t) {
        var a = t.currentTarget.dataset.url;
        wx.navigateTo({
            url: a
        });
    },
    toStoryList: function(t) {
        wx.navigateTo({
            url: "storylist/storylist"
        });
    },
    toStory: function(t) {
        t.currentTarget.dataset.id;
        wx.navigateTo({
            url: "story/story"
        });
    },
    toStorydet: function(t) {
        wx.navigateTo({
            url: "storydet/storydet"
        });
    },
    onReachBottom: function() {
        this.data.hasMore ? this.get_active_list() : wx.showToast({
            title: "没有更多活动了~",
            icon: "none"
        });
    },
    isLogin: function(t) {
        this.setData({
            isLogin: !this.data.isLogin
        });
    },
    toVipStory: function(t) {
        var a = t.currentTarget.dataset.id, e = t.currentTarget.dataset.album, o = t.currentTarget.dataset.flink, n = o || this.data.imgroot + t.currentTarget.dataset.src, r = t.currentTarget.dataset.index, i = t.currentTarget.dataset.albumid;
        0 == e ? wx.navigateTo({
            url: "storydet/storydet?id=" + a + "&src=" + n + "&index" + r
        }) : wx.navigateTo({
            url: "story/story?id=" + i
        });
    },
    callphone: function(t) {
        var a = t.currentTarget.dataset.phone;
        wx.makePhoneCall({
            phoneNumber: a
        });
    },
    toMember: function() {
        wx.navigateTo({
            url: "/yzcyk_sun/pages/member/member"
        });
    },
    toSwiperAd: function(t) {
        var a = t.currentTarget.dataset.url;
        "" != a && wx.navigateTo({
            url: a
        });
    },
    toggleAd: function(t) {
        wx.setStorageSync("showAd", 1), this.setData({
            showAd: 0
        }), app.globalData.showAd = 0;
    }
});