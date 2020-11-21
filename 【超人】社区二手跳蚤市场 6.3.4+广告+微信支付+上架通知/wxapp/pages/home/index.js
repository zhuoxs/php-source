var app = getApp(), Toast = require("../../libs/zanui/toast/toast");

Page({
    data: {
        Custom: app.globalData.Custom,
        CustomBarRightOffset: app.globalData.CustomBarRightOffset,
        showLocationList: !1,
        noticeDots: !1,
        showCube: !1,
        autoplay: !0,
        interval: 3e3,
        duration: 500,
        vertical: !0,
        display: [ {
            id: "location",
            title: "附近"
        }, {
            id: "popular",
            title: "人气"
        }, {
            id: "new",
            title: "最新"
        } ],
        selectedId: "location",
        fixed: !0,
        height: 45,
        pages: 1,
        hide: !0,
        more: !0,
        refresh: !0,
        recycle: {
            open: !1,
            style: []
        },
        showCategoryPopup: !1,
        showOfficialAccount: !0
    },
    onLoad: function() {
        var t = this;
        t.setData({
            showOfficialAccount: !wx.getStorageSync("show_official_account"),
            iphoneX: app.globalData.iphoneX
        });
        var a = t.data.Custom.left - t.data.CustomBarRightOffset - 50;
        t.setData({
            locationWidth: a
        }), t.getBasicSetting(), app.viewCount();
    },
    changeLocation: function() {
        wx.navigateTo({
            url: "../city/index"
        });
    },
    setLocation: function(t, a, e) {
        app.globalData.lat = t, app.globalData.lng = a, app.globalData.location = e, this.setData({
            location: e
        }), this.getIndexData("", t, a);
    },
    goSearch: function() {
        wx.navigateTo({
            url: "../search/index"
        });
    },
    getBasicSetting: function() {
        var n = this;
        wx.getLocation({
            type: "gcj02",
            success: function(t) {
                var o = t.latitude, s = t.longitude;
                app.globalData.lat = o, app.globalData.lng = s, app.util.request({
                    url: "entry/wxapp/home",
                    cachetime: "0",
                    data: {
                        act: "get_base_info",
                        lat: o,
                        lng: s,
                        m: "superman_hand2"
                    },
                    success: function(t) {
                        var a = t.data.data;
                        "popular" == a.tab_display ? n.setData({
                            display: [ {
                                id: "popular",
                                title: "人气"
                            }, {
                                id: "location",
                                title: "附近"
                            }, {
                                id: "new",
                                title: "最新"
                            } ],
                            selectedId: "popular"
                        }) : "new" == a.tab_display && n.setData({
                            display: [ {
                                id: "new",
                                title: "最新"
                            }, {
                                id: "popular",
                                title: "人气"
                            }, {
                                id: "location",
                                title: "附近"
                            } ],
                            selectedId: "new"
                        }), n.setData({
                            loadingImg: a.loading_img ? a.loading_img : "../../libs/images/loading.gif",
                            soldImg: a.sold_img ? a.sold_img : "../../libs/images/yz.png",
                            post_time: a.post_time,
                            credit_title: a.credit_title ? a.credit_title.credit1.title : "积分",
                            location: a.location ? a.location.address : "",
                            district: a.location ? a.location.district : ""
                        }), wx.setStorageSync("loading_img", n.data.loadingImg), wx.setStorageSync("sold_img", n.data.soldImg), 
                        wx.setStorageSync("post_time", n.data.post_time), app.globalData.locationList = a.location ? a.location.pois : [], 
                        app.globalData.location = n.data.location, app.globalData.district = n.data.district, 
                        app.globalData.credit_title = n.data.credit_title, a.audit_switch && a.audit_version && a.audit_version == app.data.version ? n.setData({
                            audit: !0,
                            audit_item: a.audit_item
                        }) : n.setData({
                            audit: !1
                        });
                        var e = wx.getStorageSync("userInfo");
                        if (e && e.memberInfo) {
                            var i = e.memberInfo.uid;
                            n.getIndexData(i, o, s);
                        } else n.setData({
                            showLogin: !0
                        });
                    }
                });
            },
            fail: function() {
                wx.showModal({
                    title: "系统提示",
                    content: "系统需要获取您的定位以给您推荐附近的物品",
                    showCancel: !1,
                    success: function(t) {
                        t.confirm && wx.openSetting({
                            success: function() {
                                n.getBasicSetting();
                            }
                        });
                    }
                });
            }
        });
    },
    getUserInfo: function(t) {
        var e = this;
        "getUserInfo:ok" == t.detail.errMsg ? (e.setData({
            showLogin: !1
        }), app.util.getUserInfo(function(t) {
            var a = t.memberInfo.uid;
            e.getIndexData(a, app.globalData.lat, app.globalData.lng);
        }, t.detail)) : e.setData({
            showLogin: !0
        });
    },
    closeLogin: function() {
        this.setData({
            showLogin: !1
        });
    },
    closeOfficialAccount: function() {
        wx.setStorageSync("show_official_account", "1"), this.setData({
            showOfficialAccount: !1
        });
    },
    getIndexData: function() {
        var t = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : "", a = 1 < arguments.length && void 0 !== arguments[1] ? arguments[1] : "", e = 2 < arguments.length && void 0 !== arguments[2] ? arguments[2] : "", g = this;
        app.globalData.isOpenSocket || (app.initChat(), app.globalData.isOpenSocket = !0), 
        app.util.request({
            url: "entry/wxapp/home",
            cachetime: "0",
            data: {
                uid: t,
                lat: a,
                lng: e,
                op: g.data.selectedId,
                district: app.globalData.district,
                m: "superman_hand2"
            },
            success: function(t) {
                if (app.util.footer(g), t.data.errno) g.showIconToast(t.data.errmsg); else {
                    var a = t.data.data;
                    a.credit_setting && 1 == a.credit_setting.open && 0 == a.credit_setting.login_tip && g.setData({
                        firstLogin: !0,
                        credit_img: a.credit_setting.credit_img,
                        loginCredit: a.credit_setting.login_credit
                    }), a.credit_setting && 1 == a.credit_setting.open && 1 == a.credit_setting.day_login && !g.data.firstLogin && g.showIconToast("每日登录" + g.data.credit_title + "+" + a.credit_setting.day, "success"), 
                    a.credit_setting && 1 == a.credit_setting.day_login && app.util.request({
                        url: "entry/wxapp/stat",
                        cachetime: "0",
                        data: {
                            dau: "yes",
                            m: "superman_hand2"
                        },
                        success: function() {
                            console.log("dau +1");
                        }
                    }), a.title && g.setData({
                        topTitle: a.title
                    }), wx.setStorageSync("recycle_open", !(!a.recycle || !a.recycle.open)), wx.setStorageSync("recycle_style", a.recycle && a.recycle.style ? a.recycle.style : ""), 
                    a.cube && 1 == a.cube.open ? (g.setData({
                        showCube: !0,
                        cubeList: a.cube.data,
                        post_img: a.cube.post_img ? a.cube.post_img : "../../images/post.png"
                    }), wx.setStorageSync("cube_open", !0), wx.getStorageSync("category") || wx.setStorageSync("category", a.category)) : wx.setStorageSync("cube_open", !1), 
                    a.post_btn && 1 == a.post_btn.open ? (g.setData({
                        showPostBtn: !0,
                        post_appid: a.post_btn.data.appid,
                        post_url: a.post_btn.data.url,
                        post_img: a.post_btn.data.thumb ? a.post_btn.data.thumb : "../../images/post.png"
                    }), wx.setStorageSync("post_open", !0), wx.setStorageSync("post_btn_data", a.post_btn.data)) : wx.setStorageSync("post_open", !1), 
                    app.setTabBar(g), app.checkRedDot(g);
                    var e = [];
                    if (!g.data.audit && "location" != g.data.selectedId) {
                        var i = a.top_items, o = app.globalData.district, s = 1;
                        if ("popular" == g.data.selectedId && (s = 2), i && 0 < i.length) for (var n = 0; n < i.length; n++) for (var c = i[n].set_top_fields, l = 0; l < c.length; l++) if (c[l].district == o && (3 == c[l].position || c[l].position == s)) {
                            i[n].top_position = c[l].position, e.push(i[n]);
                            break;
                        }
                    }
                    var p = a.items ? a.items : [], d = e.concat(p);
                    g.setData({
                        slide: a.slide,
                        switch: a.cate_switch,
                        notice_type: a.notice_type,
                        category: a.category,
                        notice: a.notice,
                        list: g.data.audit ? [ g.data.audit_item ] : d,
                        total: a.items ? a.items.length : 0,
                        thumb_open: 1 == a.thumb,
                        completed: !0
                    }), a.plugin_notice && g.setData({
                        plugin_notice: 1 == a.plugin_notice.switch,
                        askId: a.plugin_notice.askid
                    });
                    var r = wx.getSystemInfoSync().version;
                    r = parseInt(r.split(".").join("")), !wx.getStorageSync("addMyWxapp") && 671 <= r && (g.setData({
                        addMyWxapp: !0
                    }), wx.setStorageSync("addMyWxapp", "1"));
                }
            },
            fail: function(t) {
                g.setData({
                    completed: !0
                }), g.showIconToast(t.data.errmsg);
            }
        });
    },
    giveCredit: function() {
        var a = this;
        a.setData({
            firstLogin: !1
        }), app.util.request({
            url: "entry/wxapp/home",
            cachetime: "0",
            data: {
                act: "get_credit",
                m: "superman_hand2"
            },
            success: function(t) {
                t.data.errno ? a.showIconToast(t.data.errmsg) : a.showIconToast(a.data.credit_title + "+" + a.data.loginCredit, "success");
            }
        });
    },
    goTop: function() {
        wx.pageScrollTo({
            scrollTop: 0,
            duration: 500
        });
    },
    closeModal: function() {
        this.setData({
            showAuth: !1
        });
    },
    closeMask: function() {
        this.setData({
            addMyWxapp: !1
        });
    },
    handleTabChange: function(t) {
        var a = t.currentTarget.dataset.id, e = app.globalData.lat || "", i = app.globalData.lng || "";
        this.setData({
            selectedId: a,
            pages: 1,
            more: !0,
            refresh: !0
        }), this.getIndexData("", e, i);
    },
    onReachBottom: function() {
        var i = this;
        if (i.data.refresh && !i.data.audit && 0 != i.data.total) {
            i.setData({
                hide: !1
            });
            var t = app.globalData.lat || "", a = app.globalData.lng || "", o = i.data.pages + 1;
            app.util.request({
                url: "entry/wxapp/home",
                cachetime: "0",
                data: {
                    page: o,
                    op: i.data.selectedId,
                    lat: t,
                    lng: a,
                    district: app.globalData.district,
                    m: "superman_hand2"
                },
                success: function(t) {
                    if (i.setData({
                        hide: !0
                    }), 0 == t.data.errno) {
                        var a = t.data.data.items;
                        if (0 < a.length) {
                            var e = i.data.list.concat(a);
                            i.setData({
                                total: a.length,
                                list: e,
                                pages: o
                            });
                        } else i.setData({
                            more: !1,
                            refresh: !1
                        });
                    } else i.showIconToast(t.errmsg);
                }
            });
        }
    },
    onPullDownRefresh: function() {
        this.getBasicSetting(), wx.stopPullDownRefresh();
    },
    onShareAppMessage: function() {
        return {
            title: this.data.topTitle ? this.data.topTitle : "首页",
            path: "/pages/home/index"
        };
    },
    toggleCategoryPopup: function() {
        this.setData({
            showCategoryPopup: !this.data.showCategoryPopup
        });
    },
    viewAdd: function(a) {
        var t = 1, e = this;
        if (0 != t) {
            t = 0;
            var i = a.currentTarget.dataset.id;
            app.util.request({
                url: "entry/wxapp/home",
                cachetime: "0",
                data: {
                    act: "page_view",
                    id: i,
                    m: "superman_hand2"
                },
                success: function(t) {
                    t.data.errno || (console.log("点击量+1"), e.jumpToPage(a));
                },
                complete: function() {
                    t = 1;
                }
            });
        }
    },
    jumpToPage: function(t) {
        var a = t.currentTarget.dataset.url;
        -1 != a.indexOf("http") ? wx.navigateTo({
            url: "../ad/index?path=" + encodeURIComponent(a)
        }) : wx.navigateTo({
            url: a
        });
    },
    showIconToast: function(t) {
        var a = 1 < arguments.length && void 0 !== arguments[1] ? arguments[1] : "fail";
        Toast({
            type: a,
            message: t,
            selector: "#zan-toast"
        });
    }
});