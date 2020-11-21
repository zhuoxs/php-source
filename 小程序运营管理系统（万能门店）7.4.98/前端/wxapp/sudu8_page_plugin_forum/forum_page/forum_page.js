var app = getApp();

Page({
    data: {
        baseurl: app.globalData.baseurl,
        uniacid: app.globalData.uniacid,
        data: [ {
            id: 1,
            tx: "/images/tsfw1.jpg",
            name: "某某某",
            time: "2018-06-03 15:00",
            content: "去年12月，红米5系列手机面世，主打18：9千元全面屏，将高大上的全面屏设计的正式拉入千元机战场。"
        }, {
            id: 2,
            tx: "/images/tsfw1.jpg",
            name: "某某某",
            time: "2018-06-03 15:00",
            content: "去年12月，红米5系列手机面世，主打18：9千元全面屏，将高大上的全面屏设计的正式拉入千元机战场。"
        }, {
            id: 3,
            tx: "/images/tsfw1.jpg",
            name: "某某某",
            time: "2018-06-03 15:00",
            content: "去年12月，红米5系列手机面世，主打18：9千元全面屏，将高大上的全面屏设计的正式拉入千元机战场。"
        }, {
            id: 4,
            tx: "/images/tsfw1.jpg",
            name: "某某某",
            time: "2018-06-03 15:00",
            content: "去年12月，红米5系列手机面世，主打18：9千元全面屏，将高大上的全面屏设计的正式拉入千元机战场。"
        } ],
        article_con: "",
        page: 1,
        commentList: [],
        moreComment: !1,
        commentCon: "",
        nickname: "",
        uid: 0,
        alert_del: 0,
        isview: 0,
        settop: 1,
        conType: ""
    },
    onShow: function() {
        var t = this;
        t.setData({
            page: 1
        }), t.getcontent(), t.getcomment(), wx.stopPullDownRefresh();
    },
    onPullDownRefresh: function() {
        var t = this;
        t.setData({
            page: 1
        }), t.getcontent(), t.getcomment(), wx.stopPullDownRefresh();
    },
    onLoad: function(t) {
        var a = this, e = t.rid;
        0 < t.rid && a.setData({
            rid: e
        });
        var n = t.type;
        null != n && a.setData({
            conType: n
        });
        var o = app.util.url("entry/wxapp/BaseMin", {
            m: "sudu8_page"
        });
        wx.request({
            url: o,
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
        }), app.util.getUserInfo(this.getinfos), a.getcomment();
    },
    onReady: function() {},
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
        var c = this, r = wx.getStorageSync("openid");
        wx.getUserInfo({
            success: function(t) {
                var a = userInfo.nickName, e = userInfo.avatarUrl, n = userInfo.gender, o = userInfo.province, i = userInfo.city, s = userInfo.country;
                app.util.request({
                    url: "entry/wxapp/Useupdate",
                    data: {
                        openid: r,
                        nickname: a,
                        avatarUrl: e,
                        gender: n,
                        province: o,
                        city: i,
                        country: s
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
    getcontent: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/GetForumCon",
            data: {
                rid: a.data.rid,
                openid: wx.getStorageSync("openid"),
                conType: a.data.conType
            },
            success: function(t) {
                wx.setNavigationBarTitle({
                    title: t.data.data.content.substring(0, 10)
                }), a.setData({
                    article_con: t.data.data,
                    fid: t.data.data.fid,
                    settop: t.data.data.settop
                });
            },
            fail: function(t) {}
        });
    },
    setChange: function() {
        wx.navigateTo({
            url: "/sudu8_page_plugin_forum/release/release?rid=" + this.data.rid + "&fid=" + this.data.fid
        });
    },
    pagedel: function(a) {
        var e = this, n = e.data.fid, o = a.currentTarget.dataset.types;
        wx.showModal({
            title: "提示",
            content: "谨慎操作，删除后数据无法恢复!",
            cancelText: "取消删除",
            confirmText: "确认删除",
            success: function(t) {
                if (t.cancel) return !1;
                app.util.request({
                    url: "entry/wxapp/ForumPageDel",
                    data: {
                        id: a.currentTarget.dataset.id,
                        types: o
                    },
                    success: function(t) {
                        1 == t.data.data ? wx.showToast({
                            title: "删除成功",
                            success: function() {
                                setTimeout(function() {
                                    1 == o ? wx.redirectTo({
                                        url: "/sudu8_page_plugin_forum/forum/forum?fid=" + n
                                    }) : 2 != o && 3 != o || wx.redirectTo({
                                        url: "/sudu8_page_plugin_forum/forum_page/forum_page?rid=" + e.data.rid
                                    });
                                }, 2e3);
                            }
                        }) : wx.showToast({
                            title: "删除失败"
                        });
                    },
                    fail: function(t) {}
                });
            }
        });
    },
    setStick: function() {
        wx.navigateTo({
            url: "/sudu8_page_plugin_forum/set_top/set_top?fid=" + this.data.fid + "&rid=" + this.data.rid + "&returnpage=1"
        });
    },
    getcomment: function() {
        var a = this, t = a.data.page, e = a.data.rid;
        app.util.request({
            url: "entry/wxapp/GetForumComment",
            data: {
                rid: e,
                page: t,
                openid: wx.getStorageSync("openid")
            },
            success: function(t) {
                "" != t.data.data.list ? (10 < t.data.data.count.length ? a.setData({
                    moreComment: !0
                }) : a.setData({
                    moreComment: !1
                }), a.setData({
                    count: t.data.data.count,
                    commentList: t.data.data.list
                })) : a.setData({
                    count: t.data.data.count,
                    moreComment: !1
                });
            }
        });
    },
    onReachBottom: function() {
        var a = this, e = a.data.page + 1, t = a.data.rid;
        app.util.request({
            url: "entry/wxapp/GetForumComment",
            data: {
                rid: t,
                page: e,
                openid: wx.getStorageSync("openid")
            },
            success: function(t) {
                "" != t.data.data ? a.setData({
                    count: t.data.data.count,
                    commentList: a.data.commentList.concat(t.data.data.list),
                    page: e
                }) : a.setData({
                    moreComment: !1
                });
            }
        });
    },
    getInputCon: function(t) {
        var a = t.detail.value;
        100 < a.length ? wx.showModal({
            title: "提醒",
            content: "字数不能大于100",
            showCancel: !1
        }) : this.setData({
            commentCon: a
        });
    },
    commentSub: function(t) {
        var a = this, e = a.data.commentCon;
        if ("" == e) return wx.showModal({
            title: "提示",
            content: "评论不能为空",
            showCancel: !1
        }), !1;
        if (100 < e.length) return wx.showModal({
            title: "提示",
            content: "评论内容超出允许范围!",
            showCancel: !1
        }), !1;
        var n = a.data.openid, o = a.data.rid;
        app.util.request({
            url: "entry/wxapp/ForumCommentSub",
            data: {
                rid: o,
                openid: n,
                content: e,
                uid: a.data.uid,
                commentId: a.data.commentId
            },
            success: function(t) {
                1 == t.data.data ? wx.showModal({
                    title: "提示",
                    content: "发布成功",
                    showCancel: !1,
                    success: function(t) {
                        wx.redirectTo({
                            url: "/sudu8_page_plugin_forum/forum_page/forum_page?rid=" + o
                        });
                    }
                }) : wx.showModal({
                    title: "提示",
                    content: "发布失败，请重新发布",
                    showCancel: !1
                });
            },
            fail: function(t) {}
        });
    },
    toReply: function(t) {
        this.setData({
            nickname: t.currentTarget.dataset.nickname,
            uid: t.currentTarget.dataset.uid,
            commentId: t.currentTarget.dataset.commentid
        });
    },
    commentAddLikes: function(t) {
        var e = this, a = t.currentTarget.dataset.type, n = t.currentTarget.dataset.commentid, o = t.currentTarget.dataset.index;
        if (2 == a) var i = t.currentTarget.dataset.topindex;
        app.util.request({
            url: "entry/wxapp/CommentChangeLikes",
            data: {
                commentType: a,
                commentid: n,
                openid: e.data.openid
            },
            success: function(a) {
                var t = a.data.data.is_like;
                1 == t ? wx.showToast({
                    title: "点赞成功",
                    success: function() {
                        var t = e.data.commentList;
                        t[o].likesNum = a.data.data.num, t[o].is_like = 1, e.setData({
                            commentList: t
                        });
                    }
                }) : 2 == t ? wx.showToast({
                    title: "取赞成功",
                    success: function() {
                        var t = e.data.commentList;
                        t[o].likesNum = a.data.data.num, t[o].is_like = 2, e.setData({
                            commentList: t
                        });
                    }
                }) : 3 == t ? wx.showToast({
                    title: "点赞成功",
                    success: function() {
                        var t = e.data.commentList;
                        t[i].reply[o].likesNum = a.data.data.num, t[i].reply[o].is_like = 1, e.setData({
                            commentList: t
                        });
                    }
                }) : 4 == t && wx.showToast({
                    title: "取赞成功",
                    success: function() {
                        var t = e.data.commentList;
                        t[i].reply[o].likesNum = a.data.data.num, t[i].reply[o].is_like = 2, e.setData({
                            commentList: t
                        });
                    }
                });
            },
            fail: function(t) {}
        });
    },
    changeLikes: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/ForumLikes",
            data: {
                openid: e.data.openid,
                rid: e.data.rid
            },
            success: function(t) {
                var a = e.data.article_con;
                1 == t.data.data.is_like ? (wx.showToast({
                    title: "点赞成功"
                }), a.is_like = 1) : 2 == t.data.data.is_like && (wx.showToast({
                    title: "取赞成功"
                }), a.is_like = 2), a.likes = t.data.data.num, e.setData({
                    article_con: a
                });
            },
            fail: function(t) {}
        });
    },
    changeCollection: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/ForumCollection",
            data: {
                openid: e.data.openid,
                rid: e.data.rid
            },
            success: function(t) {
                var a = e.data.article_con;
                1 == t.data.data.is_collect ? (wx.showToast({
                    title: "收藏成功"
                }), a.is_collect = 1) : 2 == t.data.data.is_collect && (wx.showToast({
                    title: "取收成功"
                }), a.is_collect = 2), a.collection = t.data.data.num, e.setData({
                    article_con: a
                });
            },
            fail: function(t) {}
        });
    },
    makephone: function(t) {
        var a = t.currentTarget.dataset.tel;
        wx.makePhoneCall({
            phoneNumber: a
        });
    },
    alert_del: function(t) {
        this.setData({
            alert_del: 1,
            types: t.currentTarget.dataset.types,
            delid: t.currentTarget.dataset.id
        });
    },
    hide_alert_del: function() {
        this.setData({
            alert_del: 0
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onShareAppMessage: function() {}
});