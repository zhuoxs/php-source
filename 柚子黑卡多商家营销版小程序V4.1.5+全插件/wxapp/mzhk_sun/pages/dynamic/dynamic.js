var app = getApp();

Page({
    data: {
        navTile: "看一看",
        whichone: 2,
        whichonetwo: 21,
        banner: "../../../style/images/icon200.jpg",
        dynamicList: [],
        comment: "",
        url: "",
        showcomment: !1,
        com_cid: 0,
        f_index: "",
        releaseFocus: !1,
        disabled: !1,
        comcontent: "",
        is_modal_Hidden: !0,
        page: 1,
        adflashimg: [],
        starnums: 5
    },
    onLoad: function(t) {
        var e = this, a = app.getSiteUrl();
        a ? (e.setData({
            url: a
        }), app.editTabBar(a)) : app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            showLoading: !1,
            success: function(t) {
                wx.setStorageSync("url", t.data), a = t.data, app.editTabBar(a), e.setData({
                    url: a
                });
            }
        }), app.wxauthSetting(), wx.setNavigationBarTitle({
            title: e.data.navTile
        }), wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("System").fontcolor ? wx.getStorageSync("System").fontcolor : "",
            backgroundColor: wx.getStorageSync("System").color ? wx.getStorageSync("System").color : "",
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
    },
    onReady: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/GetadData",
            cachetime: "30",
            showLoading: !1,
            data: {
                position: 12
            },
            success: function(t) {
                console.log("11111"), console.log(t.data);
                var e = t.data;
                a.setData({
                    adflashimg: e
                });
            }
        });
    },
    gotoadinfo: function(t) {
        var e = t.currentTarget.dataset.tid, a = t.currentTarget.dataset.id;
        app.func.gotourl(app, e, a);
    },
    comment: function(t) {
        this.setData({
            comcontent: t.detail.value
        });
    },
    onShow: function() {
        var e = this;
        if (app.func.islogin(app, e), e.data.page <= 1) {
            var t = wx.getStorageSync("openid");
            app.util.request({
                url: "entry/wxapp/GetCircle",
                data: {
                    openid: t
                },
                success: function(t) {
                    console.log(t.data), 2 == t.data ? e.setData({
                        dynamicList: []
                    }) : e.setData({
                        dynamicList: t.data
                    });
                }
            });
        }
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {
        var a = this, n = a.data.page, t = wx.getStorageSync("openid"), i = a.data.dynamicList;
        app.util.request({
            url: "entry/wxapp/GetCircle",
            data: {
                openid: t,
                page: n
            },
            success: function(t) {
                if (console.log(t), 2 == t.data) wx.showToast({
                    title: "已经没有内容了哦！！！",
                    icon: "none"
                }); else {
                    var e = t.data;
                    i = i.concat(e), a.setData({
                        dynamicList: i,
                        page: n + 1
                    });
                }
            }
        });
    },
    onShareAppMessage: function() {},
    showmorecom: function(t) {
        var i = this, o = t.currentTarget.dataset.index, s = i.data.dynamicList, e = s[o].id, a = s[o].compage, n = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/GetCircleComment",
            cachetime: "10",
            data: {
                openid: n,
                cid: e,
                page: a
            },
            success: function(t) {
                if (console.log(t), 2 == t.data) wx.showToast({
                    title: "已经没有内容了哦！！！",
                    icon: "none"
                }), s[o].showcommore = 0, i.setData({
                    dynamicList: s
                }); else {
                    var e = t.data;
                    s[o].compage = s[o].compage + 1;
                    for (var a = s[o].comment.length, n = 0; n < e.length; n++) s[o].comment[a + n] = e[n];
                    e.length < 5 && (s[o].showcommore = 0), i.setData({
                        dynamicList: s
                    });
                }
            }
        });
    },
    closecomment: function(t) {
        var e = this.data.showcomment;
        this.setData({
            showcomment: !e,
            releaseFocus: !1,
            com_cid: 0,
            f_index: ""
        });
    },
    gotocomment: function(t) {
        var e = t.currentTarget.dataset.f_index, a = t.currentTarget.dataset.cid;
        this.setData({
            showcomment: !0,
            releaseFocus: !0,
            com_cid: a,
            f_index: e,
            comcontent: ""
        });
    },
    cominput: function(t) {
        var e = t.detail.value, a = /[^\u0020-\u007E\u00A0-\u00BE\u2E80-\uA4CF\uF900-\uFAFF\uFE30-\uFE4F\uFF00-\uFFEF\u0080-\u009F\u2000-\u201f\u2026\u2022\u20ac\r\n]/g;
        e.match(a) && (e = e.replace(a, "")), this.setData({
            comcontent: e
        });
    },
    formSubmit: function(t) {
        var n = this, i = t.detail.value.content, e = t.detail.value.cid, o = t.detail.value.f_index, a = wx.getStorageSync("openid"), s = n.data.dynamicList, c = wx.getStorageSync("users").img, r = wx.getStorageSync("users").name;
        return e && o ? "" == i ? (wx.showToast({
            icon: "none",
            title: "评论内容不能为空！"
        }), !1) : (wx.showLoading({
            title: "提交中，请稍后..."
        }), n.setData({
            disabled: !0
        }), void app.util.request({
            url: "entry/wxapp/SaveCircleComment",
            cachetime: "0",
            data: {
                user_id: wx.getStorageSync("users").id,
                uimg: c,
                uname: r,
                content: i,
                cid: e,
                openid: a,
                form_id: t.detail.formId
            },
            success: function(t) {
                wx.showToast({
                    icon: "none",
                    title: "评论成功！",
                    duration: 2e3
                }), wx.hideLoading();
                var e = s[o].comment, a = {
                    uimg: c,
                    uname: r,
                    content: i
                };
                e.unshift(a), s[o].comment = e, s[o].commentnum = parseInt(s[o].commentnum) + 1, 
                n.setData({
                    dynamicList: s,
                    disabled: !1,
                    showcomment: !1,
                    releaseFocus: !1,
                    comcontent: ""
                });
            },
            fail: function(t) {
                wx.showModal({
                    title: "提示信息",
                    content: t.data.message,
                    showCancel: !1
                }), n.setData({
                    disabled: !1
                });
            }
        })) : (wx.showToast({
            icon: "none",
            title: "参数错误！"
        }), n.setData({
            showcomment: !1,
            releaseFocus: !1,
            com_cid: 0,
            f_index: ""
        }), !1);
    },
    clickGood: function(t) {
        var n = this, e = t.currentTarget.dataset.cid, i = n.data.dynamicList, a = t.currentTarget.dataset.statu, o = t.currentTarget.dataset.index, s = wx.getStorageSync("users").img, c = (wx.getStorageSync("users").name, 
        wx.getStorageSync("openid")), r = i[o].islike, d = parseInt(i[o].likenum);
        app.util.request({
            url: "entry/wxapp/SaveCircleLike",
            cachetime: "10",
            data: {
                user_id: wx.getStorageSync("users").id,
                openid: c,
                cid: e,
                uimg: s,
                islike: r
            },
            success: function(t) {
                console.log(t);
                var e = {
                    uimg: s,
                    openid: c
                };
                if (1 == r) {
                    i[o].islike = 0, i[o].likenum = 0 < d ? d - 1 : 0;
                    var a = [];
                    i[o].like.forEach(function(t) {
                        t.openid != c && a.push(t);
                    }), i[o].like = a;
                } else i[o].islike = 1, i[o].likenum = d + 1, i[o].like.unshift(e);
                n.setData({
                    dynamicList: i,
                    disabled: !1
                });
            }
        }), i[o].islike = 0 == a ? 1 : 0, n.setData({
            dynamicList: i
        });
    },
    previewImg: function(t) {
        for (var e = this.data.dynamicList, a = this.data.url, n = t.currentTarget.dataset.index, i = t.currentTarget.dataset.idx, o = a + e[n].img[i], s = e[n].img, c = [], r = 0; r < s.length; r++) c[r] = a + s[r];
        wx.previewImage({
            current: o,
            urls: c
        });
    },
    toDynamicdet: function(t) {
        wx.navigateTo({
            url: "dynamicdet/dynamicdet"
        });
    },
    toEdit: function(t) {
        wx.navigateTo({
            url: "dynamicedit/dynamicedit"
        });
    },
    updateUserInfo: function(t) {
        console.log("授权操作更新");
        app.wxauthSetting();
    },
    toGoods: function(t) {
        var e = t.currentTarget.dataset.gid, a = t.currentTarget.dataset.lid;
        if (console.log(e), 1 == a) var n = "/mzhk_sun/pages/index/goods/goods?gid=" + e; else if (2 == a) n = "/mzhk_sun/pages/index/bardet/bardet?id=" + e; else if (3 == a) n = "/mzhk_sun/pages/index/groupdet/groupdet?id=" + e; else n = "/mzhk_sun/pages/index/package/package?id=" + e;
        wx.navigateTo({
            url: n
        });
    }
});