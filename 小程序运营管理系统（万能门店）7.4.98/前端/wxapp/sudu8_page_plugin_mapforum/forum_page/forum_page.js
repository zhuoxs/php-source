var _data;

function _defineProperty(t, a, e) {
    return a in t ? Object.defineProperty(t, a, {
        value: e,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[a] = e, t;
}

var app = getApp(), innerAudioContext = wx.createInnerAudioContext();

Page({
    data: (_data = {
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
        settop: 1
    }, _defineProperty(_data, "article_con", {
        videourl: ""
    }), _defineProperty(_data, "duration", 0), _defineProperty(_data, "menu", 0), _defineProperty(_data, "forum_x", 0), 
    _defineProperty(_data, "conType", ""), _data),
    onShow: function() {
        var s = this;
        innerAudioContext.onPlay(function(t) {
            innerAudioContext.duration, setTimeout(function() {
                innerAudioContext.duration;
            }, 1e3), innerAudioContext.onTimeUpdate(function(t) {
                var a = innerAudioContext.duration, e = parseInt(a / 60);
                e < 10 && (e = "0" + e);
                var n = parseInt(a - 60 * e);
                n < 10 && (n = "0" + n);
                var i = innerAudioContext.currentTime, o = parseInt(i / 60);
                o < 10 && (o = "0" + o);
                var r = parseInt(i - 60 * o);
                r < 10 && (r = "0" + r), s.setData({
                    duration: 100 * innerAudioContext.duration.toFixed(2),
                    curTimeVal: 100 * innerAudioContext.currentTime.toFixed(2),
                    durationDay: e + ":" + n,
                    curTimeValDay: o + ":" + r
                });
            }), innerAudioContext.onEnded(function() {
                for (var t = s.data.voice, a = 0; a < t.length; a++) if (1 == t[a].play) {
                    t[a].play = 0;
                    break;
                }
                s.setData({
                    voice: t
                });
            });
        }), s.setData({
            page: 1
        }), s.getcontent(), s.getcomment(), wx.stopPullDownRefresh();
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
        var i = app.util.url("entry/wxapp/BaseMin", {
            m: "sudu8_page"
        });
        wx.request({
            url: i,
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
        var s = this, d = wx.getStorageSync("openid");
        wx.getUserInfo({
            success: function(t) {
                var a = userInfo.nickName, e = userInfo.avatarUrl, n = userInfo.gender, i = userInfo.province, o = userInfo.city, r = userInfo.country;
                app.util.request({
                    url: "entry/wxapp/Useupdate",
                    data: {
                        openid: d,
                        nickname: a,
                        avatarUrl: e,
                        gender: n,
                        province: i,
                        city: o,
                        country: r
                    },
                    header: {
                        "content-type": "application/json"
                    },
                    success: function(t) {
                        wx.setStorageSync("golobeuid", t.data.data.id), wx.setStorageSync("golobeuser", t.data.data), 
                        s.setData({
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
                    title: t.data.data.release_title
                }), a.setData({
                    article_con: t.data.data,
                    fid: t.data.data.fid,
                    settop: t.data.data.settop,
                    voice: t.data.data.voice
                });
            },
            fail: function(t) {}
        });
    },
    setChange: function() {
        wx.navigateTo({
            url: "/sudu8_page_plugin_mapforum/release/release?rid=" + this.data.rid + "&fid=" + this.data.fid
        });
    },
    pagedel: function(a) {
        var e = this, n = e.data.fid, i = a.currentTarget.dataset.types;
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
                        types: i
                    },
                    success: function(t) {
                        1 == t.data.data ? wx.showToast({
                            title: "删除成功",
                            success: function() {
                                setTimeout(function() {
                                    1 == i ? wx.redirectTo({
                                        url: "/sudu8_page_plugin_mapforum/forum/forum?fid=" + n
                                    }) : 2 != i && 3 != i || wx.redirectTo({
                                        url: "/sudu8_page_plugin_mapforum/forum_page/forum_page?rid=" + e.data.rid
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
            url: "/sudu8_page_plugin_mapforum/set_top/set_top?fid=" + this.data.fid + "&rid=" + this.data.rid + "&returnpage=1"
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
        var n = a.data.openid, i = a.data.rid;
        app.util.request({
            url: "entry/wxapp/ForumCommentSub",
            data: {
                rid: i,
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
                            url: "/sudu8_page_plugin_mapforum/forum_page/forum_page?rid=" + i
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
        var e = this, a = t.currentTarget.dataset.type, n = t.currentTarget.dataset.commentid, i = t.currentTarget.dataset.index;
        if (2 == a) var o = t.currentTarget.dataset.topindex;
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
                        t[i].likesNum = a.data.data.num, t[i].is_like = 1, e.setData({
                            commentList: t
                        });
                    }
                }) : 2 == t ? wx.showToast({
                    title: "取赞成功",
                    success: function() {
                        var t = e.data.commentList;
                        t[i].likesNum = a.data.data.num, t[i].is_like = 2, e.setData({
                            commentList: t
                        });
                    }
                }) : 3 == t ? wx.showToast({
                    title: "点赞成功",
                    success: function() {
                        var t = e.data.commentList;
                        t[o].reply[i].likesNum = a.data.data.num, t[o].reply[i].is_like = 1, e.setData({
                            commentList: t
                        });
                    }
                }) : 4 == t && wx.showToast({
                    title: "取赞成功",
                    success: function() {
                        var t = e.data.commentList;
                        t[o].reply[i].likesNum = a.data.data.num, t[o].reply[i].is_like = 2, e.setData({
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
    playvoice: function(t) {
        for (var a = this.data.voice, e = t.currentTarget.dataset.index, n = 0; n < a.length; n++) a[n].play = e == n ? 1 : 0, 
        this.setData({
            voice: a
        });
        var i = t.currentTarget.dataset.voice;
        innerAudioContext.src = i, innerAudioContext.play();
    },
    stopvoice: function(t) {
        var a = this.data.voice;
        a[t.currentTarget.dataset.index].play = 0, this.setData({
            voice: a
        }), innerAudioContext.stop(function() {});
    },
    torelease: function() {
        wx.navigateTo({
            url: "/sudu8_page_plugin_mapforum/release/release"
        });
    },
    tolist: function() {
        wx.navigateTo({
            url: "/sudu8_page_plugin_mapforum/forum/forum?fid=0"
        });
    },
    getmenu: function() {
        this.setData({
            menu: 1,
            forum_x: 1
        });
    },
    closemenu: function() {
        this.setData({
            menu: 0,
            forum_x: 0
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onShareAppMessage: function() {}
});