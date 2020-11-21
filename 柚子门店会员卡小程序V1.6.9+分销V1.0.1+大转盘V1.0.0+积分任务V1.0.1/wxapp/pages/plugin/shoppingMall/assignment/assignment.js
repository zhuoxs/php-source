var app = getApp();

Page({
    data: {
        variable: !0,
        moreMissions: !0,
        showModel1: !1,
        showModel2: !1,
        showModel3: !1,
        showModel4: !1,
        value: !1,
        contain: !1,
        id: "",
        sign: [],
        status: !1
    },
    onLoad: function(t) {
        var e = this;
        wx.getStorageSync("user");
        app.get_openid().then(function(t) {
            console.log(t), e.setData({
                openid: t
            });
            var a = t;
            app.util.request({
                url: "entry/wxapp/getTask",
                data: {
                    m: app.globalData.Plugin_scoretask,
                    openid: a
                },
                showLoading: !1,
                success: function(t) {
                    console.log(t), e.setData({
                        list: t.data.data,
                        imgroot: t.data.other.img_root
                    });
                }
            }), app.util.request({
                url: "entry/wxapp/getTotalTaskNumAndWcTaskNum",
                data: {
                    m: app.globalData.Plugin_scoretask,
                    openid: a
                },
                showLoading: !1,
                success: function(t) {
                    console.log(t), e.setData({
                        total_num: t.data.data.total_num,
                        wc_num: t.data.data.wc_num
                    });
                }
            }), app.util.request({
                url: "entry/wxapp/getSingleScore",
                data: {
                    m: app.globalData.Plugin_scoretask,
                    openid: a
                },
                showLoading: !1,
                success: function(t) {
                    console.log("单个点劵"), console.log(t.data);
                    t = t.data.data;
                    e.setData({
                        yqhy: t.yqhy,
                        jfcj: t.jfcj,
                        sc: t.sc
                    });
                }
            }), e.getTask(), app.util.request({
                url: "entry/wxapp/getSignTask",
                data: {
                    m: app.globalData.Plugin_scoretask,
                    openid: a
                },
                showLoading: !1,
                success: function(t) {
                    var a = t.data.data.jr_status;
                    e.setData({
                        sign: t.data.data,
                        imgroot1: t.data.other.img_root,
                        status: a
                    });
                }
            }), app.util.request({
                url: "entry/wxapp/getArticleList",
                data: {
                    m: app.globalData.Plugin_scoretask,
                    show_task: 1,
                    openid: a
                },
                showLoading: !1,
                success: function(t) {
                    console.log(t.data), e.setData({
                        readArray: t.data,
                        picture: t.data.other.img_root
                    });
                }
            });
        });
    },
    sign: function() {
        var e = this, a = (wx.getStorageSync("user"), e.data.openid);
        app.util.request({
            url: "entry/wxapp/setSign",
            data: {
                m: app.globalData.Plugin_scoretask,
                openid: a
            },
            showLoading: !1,
            success: function(t) {
                app.util.request({
                    url: "entry/wxapp/getSignTask",
                    data: {
                        m: app.globalData.Plugin_scoretask,
                        openid: a
                    },
                    showLoading: !1,
                    success: function(t) {
                        var a = t.data.data.jr_status;
                        e.setData({
                            sign: t.data.data,
                            imgroot1: t.data.other.img_root,
                            status: a
                        });
                    }
                });
            }
        });
    },
    getTask: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/getInviteFriendTask",
            data: {
                m: app.globalData.Plugin_scoretask,
                openid: a.data.openid
            },
            showLoading: !1,
            success: function(t) {
                console.log(t), a.setData({
                    list2: t.data.data,
                    imgroot: t.data.other.img_root
                });
            }
        });
    },
    totask: function(t) {
        var a = t.currentTarget.dataset.type;
        1 == a && this.setData({
            showModel1: !0
        }), 2 == a && this.setData({
            showModel2: !0
        }), 3 == a && this.setData({
            showModel3: !0
        }), 4 == a && this.setData({
            showModel4: !0
        }), 5 == a && this.setData({
            showModel5: !0
        }), 6 == a && this.setData({
            showModel6: !0
        });
    },
    publicLink: function(t) {
        var a = t.currentTarget.dataset.url, e = t.currentTarget.dataset.id;
        wx.setStorageSync("article_id", e), wx.navigateTo({
            url: "../publicNumber/publicNumber?url=" + a
        });
    },
    click: function() {
        this.setData({
            value: !0,
            moreMissions: !1
        });
    },
    cancel: function() {
        this.setData({
            showModel1: !1
        });
    },
    leave: function() {
        this.setData({
            showModel2: !1
        });
    },
    noInvitations: function() {
        this.setData({
            showModel3: !1
        });
    },
    eradicate: function() {
        this.setData({
            showModel4: !1
        });
    },
    pointsDraw: function() {
        this.setData({
            showModel5: !1
        });
    },
    mark: function() {
        this.setData({
            showModel6: !1
        });
    },
    onShareAppMessage: function(t) {
        var a = this, e = 1;
        if ("button" === t.from) {
            e = t.target.dataset.type;
            console.log(e);
            var o = t.target.dataset.article_id, s = t.target.dataset.openid, n = t.target.dataset.title, i = t.target.dataset.icon;
            if (1 == e) return {
                title: n,
                imageUrl: a.data.imgroot + i,
                path: "/pages/plugin/shoppingMall/home/home?share_type=" + e + "&d_user=" + s + "&article_id=" + o,
                success: function(t) {
                    console.log("转发成功");
                },
                fail: function(t) {
                    console.log("转发失败");
                }
            };
            if (2 == e) {
                console.log("邀请好友");
                s = a.data.openid;
                return console.log(s), console.log(e), {
                    title: "看好文，获点劵，...",
                    imageUrl: a.data.imgroot + i,
                    path: "/pages/plugin/shoppingMall/home/home?share_type=" + e + "&d_user=" + s,
                    success: function(t) {
                        console.log("转发成功");
                    },
                    fail: function(t) {
                        console.log("转发失败");
                    }
                };
            }
        }
    },
    invite: function(t) {
        var a = t.currentTarget.dataset.id, e = (wx.getStorageSync("user"), t.currentTarget.dataset.url1);
        console.log(e);
        var o = this.data.openid, s = t.currentTarget.dataset.title, n = t.currentTarget.dataset.icon;
        e ? this.setData({
            showModel: !0,
            type: 1,
            article_id: a,
            openid: o,
            title: s,
            icon: n
        }) : wx.showModal({
            title: "提示",
            content: "该文章没有具体内容，无法分享"
        });
    },
    preventTouchMove: function() {},
    go: function() {
        this.setData({
            showModel: !1
        });
    },
    takeStroll: function() {
        wx.redirectTo({
            url: "../integrationMall/integrationMall"
        });
    },
    toWelfare: function() {
        wx.redirectTo({
            url: "../integrationMall/integrationMall"
        });
    },
    GoRaffle: function() {
        wx.navigateTo({
            url: "../pointsDraw/pointsDraw"
        }), this.setData({
            showModel5: !1
        });
    },
    goMark: function() {
        wx.redirectTo({
            url: "../home/home"
        });
    },
    home: function() {
        wx.redirectTo({
            url: "../home/home"
        });
    },
    integrationMall: function() {
        wx.redirectTo({
            url: "../integrationMall/integrationMall"
        });
    },
    me: function() {
        wx.redirectTo({
            url: "../me/me"
        });
    },
    onShow: function() {
        var t = wx.getStorageSync("article_id"), a = (wx.getStorageSync("user"), this.data.openid);
        0 < t && app.util.request({
            url: "entry/wxapp/setRead",
            data: {
                m: app.globalData.Plugin_scoretask,
                openid: a,
                article_id: t
            },
            showLoading: !1,
            success: function(t) {
                if (console.log(t.data.msg), 0 == (t = t.data).code) {
                    var a = "恭喜您获得" + t.data + "点劵";
                    wx.showToast({
                        title: a,
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
    }
});