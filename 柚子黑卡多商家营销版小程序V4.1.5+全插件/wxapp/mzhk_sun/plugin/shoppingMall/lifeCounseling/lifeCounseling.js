/*   time:2019-08-09 13:18:39*/
var _Page;

function _defineProperty(t, e, a) {
    return e in t ? Object.defineProperty(t, e, {
        value: a,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[e] = a, t
}
var app = getApp();
Page((_defineProperty(_Page = {
    data: {
        showModel: !1,
        value: "",
        is_modal_Hidden: !0,
        page: 1,
        list: []
    },
    onLoad: function(t) {
        app.wxauthSetting();
        var e = t.value;
        console.log(e), e ? this.setData({
            value: e
        }) : this.setData({
            value: ""
        }), this.getList()
    },
    onShow: function() {
        app.func.islogin(app, this);
        var t = wx.getStorageSync("article_id"),
            e = wx.getStorageSync("users").openid;
        if (1 == wx.getStorageSync("share_type")) {
            var a = wx.getStorageSync("d_user"),
                o = wx.getStorageSync("article_id_1");
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
                            icon: "success",
                            duration: 1200
                        })
                    } else 1 == t.code && wx.showToast({
                        title: t.msg,
                        icon: "none",
                        duration: 1200
                    })
                }
            }), wx.setStorageSync("share_type", 0), wx.setStorageSync("d_user", 0), wx.setStorageSync("article_id_1", 0)
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
                if (console.log(t.data.msg), 0 == (t = t.data).code) {
                    var e = "恭喜您获得" + t.data + "积分";
                    wx.showToast({
                        title: e,
                        icon: "success",
                        duration: 1200
                    })
                } else 1 == t.code && wx.showToast({
                    title: t.msg,
                    icon: "none",
                    duration: 1200
                })
            }
        }), wx.setStorageSync("article_id", 0)
    },
    publicLink: function(t) {
        var e = t.currentTarget.dataset.url,
            a = t.currentTarget.dataset.id;
        wx.setStorageSync("article_id", a), wx.navigateTo({
            url: "../publicNumber/publicNumber?url=" + e
        })
    },
    submit: function() {
        this.setData({
            showModel: !0
        })
    },
    preventTouchMove: function() {},
    go: function() {
        this.setData({
            showModel: !1
        })
    },
    making: function(t) {
        var e = this,
            a = t.currentTarget.dataset.id,
            o = wx.getStorageSync("users").openid,
            s = e.data.list,
            i = t.currentTarget.dataset.index,
            n = t.currentTarget.dataset.is_mark;
        0 == n ? app.util.request({
            url: "entry/wxapp/setMark",
            data: {
                m: app.globalData.Plugin_scoretask,
                openid: o,
                article_id: a
            },
            showLoading: !1,
            success: function(t) {
                console.log(t);
                t = t.data;
                s[i].is_mark = 1, e.setData({
                    list: s
                }), 0 == t.code ? wx.showToast({
                    title: "收藏成功",
                    icon: "success",
                    duration: 1200
                }) : wx.showToast({
                    title: t.msg,
                    icon: "none",
                    duration: 1200
                })
            }
        }) : 1 == n && app.util.request({
            url: "entry/wxapp/cancelMark",
            data: {
                m: app.globalData.Plugin_scoretask,
                openid: o,
                article_id: a
            },
            showLoading: !1,
            success: function(t) {
                0 == (t = t.data).code ? (s[i].is_mark = 0, e.setData({
                    list: s
                }), wx.showToast({
                    title: "取消成功",
                    icon: "success",
                    duration: 1200
                })) : wx.showToast({
                    title: t.msg,
                    icon: "none",
                    duration: 1200
                })
            }
        })
    },
    searchBtn: function(t) {
        var e = t.detail.value;
        this.setData({
            value: e
        }), this.getList()
    },
    getList: function() {
        var a = this,
            t = this.data.value,
            o = a.data.page,
            s = a.data.list,
            e = wx.getStorageSync("users").openid;
        console.log("还在吗"), console.log(t), console.log(wx.getStorageSync("users")), app.util.request({
            url: "entry/wxapp/getArticleList",
            data: {
                m: app.globalData.Plugin_scoretask,
                keyword: t,
                openid: e
            },
            showLoading: !1,
            success: function(t) {
                console.log(t.data);
                t.data.data.length, a.data.pagesize;
                if (1 == o) s = t.data.data;
                else for (var e in t.data.data) s.push(t.data.data[e]);
                o += 1, a.setData({
                    list: s,
                    ImgRoot: t.data.other.img_root
                })
            }
        })
    },
    lower: function() {
        this.data.hasMore ? this.getList() : wx.showToast({
            title: "没有更多活动了~",
            icon: "none"
        })
    },
    onReachBottom: function() {}
}, "submit", function(t) {
    var e = t.currentTarget.dataset.id;
    console.log("你的id是多少"), console.log(e);
    var a = wx.getStorageSync("users").openid,
        o = t.currentTarget.dataset.title,
        s = t.currentTarget.dataset.icon;
    console.log("你的icon"), console.log(s), this.setData({
        showModel: !0,
        type: 1,
        article_id: e,
        openid: a,
        title: o,
        icon: s
    })
}), _defineProperty(_Page, "onShareAppMessage", function(t) {
    var e = 1;
    if ("button" === t.from) {
        e = t.target.dataset.type;
        console.log(e);
        var a = t.target.dataset.article_id,
            o = t.target.dataset.openid,
            s = t.target.dataset.title,
            i = t.target.dataset.icon;
        if (1 == e) return {
            title: s,
            imageUrl: i,
            path: "/mzhk_sun/plugin/shoppingMall/home/home?share_type=" + e + "&d_user=" + o + "&article_id=" + a,
            success: function(t) {
                console.log("转发成功")
            },
            fail: function(t) {
                console.log("转发失败")
            }
        };
        if (2 == e) return console.log("邀请好友"), {
            title: "看好文，获积分，...",
            imageUrl: i,
            path: "/mzhk_sun/plugin/shoppingMall/home/home?share_type=" + e + "&d_user=" + (o = wx.getStorageSync("users").openid),
            success: function(t) {
                console.log("转发成功")
            },
            fail: function(t) {
                console.log("转发失败")
            }
        }
    }
}), _defineProperty(_Page, "updateUserInfo", function(t) {
    app.wxauthSetting()
}), _Page));