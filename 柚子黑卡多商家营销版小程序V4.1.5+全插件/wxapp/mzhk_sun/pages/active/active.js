var app = getApp(), Page = require("../../sdk/qitui/oddpush.js").oddPush(Page).Page;

Page({
    data: {
        navTile: "活动推荐",
        nav: [ "正在进行", "往期活动" ],
        activeList: [],
        activeType: [ "砍价活动", "拼团活动", "集卡活动", "抢购活动", "免单活动" ],
        url: [],
        viptype: [],
        hklogo: "../../../style/images/hklogo.png",
        hkname: "柚子黑卡",
        oldActiveList: [],
        ActivePage: 1,
        oldActivePage: 1,
        is_modal_Hidden: !0,
        tabBar: app.globalData.tabBar,
        whichone: 1,
        iscateselect: 0,
        whichonetwo: 16,
        flag: 1
    },
    onLoad: function(a) {
        var e = this;
        a = app.func.decodeScene(a), e.setData({
            options: a
        }), wx.setNavigationBarTitle({
            title: e.data.navTile
        });
        var t = app.getSiteUrl();
        t ? (e.setData({
            url: t
        }), app.editTabBar(t)) : app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            showLoading: !1,
            success: function(a) {
                wx.setStorageSync("url", a.data), t = a.data, app.editTabBar(t), e.setData({
                    url: t
                });
            }
        }), app.wxauthSetting(), app.util.request({
            url: "entry/wxapp/System",
            cachetime: "60",
            success: function(a) {
                var t = a.data.attachurl;
                wx.setStorageSync("url", t), wx.setNavigationBarColor({
                    frontColor: a.data.fontcolor ? a.data.fontcolor : "#000000",
                    backgroundColor: a.data.color ? a.data.color : "#ffffff",
                    animation: {
                        duration: 0,
                        timingFunc: "easeIn"
                    }
                }), e.setData({
                    openblackcard: a.data.openblackcard,
                    logo: a.data.hk_logo ? t + a.data.hk_logo : "",
                    pt_name: a.data.hk_tubiao ? a.data.hk_tubiao : "",
                    hk_bgimg: a.data.hk_bgimg ? t + a.data.hk_bgimg : "",
                    hk_namecolor: a.data.hk_namecolor ? a.data.hk_namecolor : "#f5ac32"
                });
            }
        });
    },
    onReady: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/Actives",
            cachetime: "30",
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(a) {
                console.log(a), 2 == a.data ? e.setData({
                    activeList: []
                }) : e.setData({
                    activeList: a.data
                }), e.GetVip();
            }
        }), app.util.request({
            url: "entry/wxapp/GetadData",
            showLoading: !1,
            data: {
                position: 15
            },
            success: function(a) {
                var t = a.data;
                e.setData({
                    adbackcardimg: t || []
                });
            }
        });
    },
    onShow: function() {
        app.func.islogin(app, this);
        var a = this.data.options;
        a.d_user_id && app.distribution.distribution_parsent(app, a.d_user_id);
    },
    gotoadinfo: function(a) {
        var t = a.currentTarget.dataset.tid, e = a.currentTarget.dataset.id;
        app.func.gotourl(app, t, e);
    },
    GetVip: function() {
        var t = this, a = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/ISVIP",
            showLoading: !1,
            data: {
                openid: a
            },
            success: function(a) {
                console.log("获取vip数据"), console.log(a), t.setData({
                    viptype: a.data
                });
            }
        });
    },
    getUrl: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/url",
            showLoading: !1,
            cachetime: "30",
            success: function(a) {
                wx.setStorageSync("url", a.data), t.setData({
                    url: a.data
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {
        var e = this;
        if (2 == e.data.flag) {
            var i = e.data.oldActiveList, o = e.data.oldActivePage;
            app.util.request({
                url: "entry/wxapp/OldActives",
                cachetime: "30",
                data: {
                    page: o,
                    openid: wx.getStorageSync("openid")
                },
                success: function(a) {
                    if (console.log(a), 2 == a.data) wx.showToast({
                        title: "已经没有内容了哦！！！",
                        icon: "none"
                    }); else {
                        var t = a.data;
                        i = i.concat(t), e.setData({
                            oldActiveList: i,
                            oldActivePage: o + 1
                        });
                    }
                }
            });
        } else {
            var n = e.data.activeList, c = e.data.ActivePage;
            console.log(123456789), console.log(c);
            var a = e.data.iscateselect;
            if (0 != a) var t = {
                page: c,
                openid: wx.getStorageSync("openid"),
                lid: a
            }; else t = {
                page: c,
                openid: wx.getStorageSync("openid")
            };
            console.log(t), app.util.request({
                url: "entry/wxapp/Actives",
                cachetime: "30",
                data: t,
                success: function(a) {
                    if (console.log(a), 2 == a.data) wx.showToast({
                        title: "已经没有内容了哦！！！",
                        icon: "none"
                    }); else {
                        var t = a.data;
                        n = n.concat(t), e.setData({
                            activeList: n,
                            ActivePage: c + 1
                        });
                    }
                }
            });
        }
    },
    onShareAppMessage: function() {
        return {
            path: "/mzhk_sun/pages/active/active?d_user_id=" + wx.getStorageSync("users").id
        };
    },
    navTap: function(a) {
        var t = parseInt(a.currentTarget.dataset.index);
        if (1 == t) {
            var e = this;
            app.util.request({
                url: "entry/wxapp/OldActives",
                cachetime: "30",
                showLoading: !1,
                data: {
                    openid: wx.getStorageSync("openid")
                },
                success: function(a) {
                    e.setData({
                        oldActiveList: a.data
                    }), e.getUrl();
                }
            });
        }
        this.setData({
            curIndex: t
        });
    },
    ptbon: function(a) {
        var t = a.currentTarget.dataset.id;
        wx.navigateTo({
            url: "../index/groupdet/groupdet?id=" + t
        });
    },
    kjbon: function(a) {
        var t = a.currentTarget.dataset.id;
        wx.navigateTo({
            url: "../index/bardet/bardet?id=" + t
        });
    },
    qgbon: function(a) {
        var t = a.currentTarget.dataset.id;
        wx.navigateTo({
            url: "../index/package/package?id=" + t
        });
    },
    mdbon: function(a) {
        var t = a.currentTarget.dataset.id;
        wx.navigateTo({
            url: "../index/freedet/freedet?id=" + t
        });
    },
    jkbon: function(a) {
        var t = a.currentTarget.dataset.id;
        wx.navigateTo({
            url: "../index/cardsdet/cardsdet?gid=" + t
        });
    },
    hybon: function(a) {
        var t = a.currentTarget.dataset.id;
        console.log(t), wx.navigateTo({
            url: "../index/welfare/welfare?id=" + t
        });
    },
    togroupdet: function(a) {
        wx.navigateTo({
            url: "../index/groupdet/groupdet"
        });
    },
    tocardsdet: function(a) {
        wx.navigateTo({
            url: "../index/cardsdet/cardsdet"
        });
    },
    topackage: function(a) {
        wx.navigateTo({
            url: "../index/package/package"
        });
    },
    tobardet: function(a) {
        wx.navigateTo({
            url: "../index/bardet/bardet"
        });
    },
    toMember: function(a) {
        wx.navigateTo({
            url: "../member/member"
        });
    },
    updateUserInfo: function(a) {
        console.log("授权操作更新");
        app.wxauthSetting();
    },
    onNavTap: function(a) {
        var t = this, e = parseInt(a.currentTarget.dataset.idx);
        2 == e ? app.util.request({
            url: "entry/wxapp/OldActives",
            cachetime: "30",
            showLoading: !1,
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(a) {
                t.setData({
                    oldActiveList: a.data
                }), t.getUrl();
            }
        }) : app.util.request({
            url: "entry/wxapp/Actives",
            cachetime: "30",
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(a) {
                console.log(a), 2 == a.data ? t.setData({
                    activeList: []
                }) : t.setData({
                    activeList: a.data
                }), t.GetVip();
            }
        }), this.setData({
            flag: e,
            iscateselect: 0
        });
    },
    onTaggleTap: function() {
        this.setData({
            mask: !this.data.mask
        });
    },
    onClassifyTap: function(a) {
        var t = this, e = a.currentTarget.dataset.tdx, i = e + 2;
        app.util.request({
            url: "entry/wxapp/Actives",
            cachetime: "0",
            data: {
                openid: wx.getStorageSync("openid"),
                lid: i
            },
            success: function(a) {
                console.log(a), 2 == a.data ? t.setData({
                    activeList: []
                }) : t.setData({
                    activeList: a.data,
                    flag: 1,
                    choose: e,
                    mask: !1,
                    iscateselect: i,
                    ActivePage: 1
                }), t.GetVip();
            }
        });
    }
});