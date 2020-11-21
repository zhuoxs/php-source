var _Page, _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function(t) {
    return typeof t;
} : function(t) {
    return t && "function" == typeof Symbol && t.constructor === Symbol && t !== Symbol.prototype ? "symbol" : typeof t;
};

function _defineProperty(t, a, e) {
    return a in t ? Object.defineProperty(t, a, {
        value: e,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[a] = e, t;
}

var app = getApp(), wxParse = require("../resource/wxParse/wxParse.js"), BackgroundAudioManager = wx.getBackgroundAudioManager();

BackgroundAudioManager.title = "", Page((_defineProperty(_Page = {
    data: {
        page_sign: "index",
        miniad: {},
        baseinfo: {
            i_b_x_ts: 9,
            copT: 9,
            show_v: 0
        },
        footer: {
            i_tel: app.globalData.i_tel,
            i_add: app.globalData.i_add,
            i_time: app.globalData.i_time,
            i_view: app.globalData.i_view,
            close: app.globalData.close,
            v_ico: app.globalData.v_ico
        },
        showAd: 1,
        showFad: 1,
        searchtitle: "",
        date_c: "",
        time_c: "",
        currentId: 1,
        minHeight: 220,
        heighthave: 0,
        content: [],
        menuContent: [ {
            title: "全部分类",
            content: [ "全部分类" ]
        }, {
            title: "综合排序",
            content: [ "综合排序", "距离最近" ]
        }, {
            title: "所有商家",
            content: [ "所有商家", "优选商家" ]
        } ],
        showMenu: !0,
        lastIndex: null,
        times: 1,
        longitude: "",
        latitude: "",
        yuyin: 1,
        tabArr2: {
            curHdIndex: 0
        },
        formimg: [],
        zhixin: !1,
        show_page_tcgg: 1,
        forminfo: [],
        footmenu: 0,
        footmenuh: 0,
        foottext: 0,
        page_is: 1,
        homepageid: 0,
        store: {},
        currentSwiper: 0,
        status: 0,
        id: "0",
        mapforum_pop: !1,
        map_scale: 14,
        mapsearchtitle: "",
        dtsearchkey: ""
    },
    onPullDownRefresh: function() {
        var t = this;
        t.refreshSessionkey();
        var a = app.siteInfo.siteroot.split("/app");
        t.setData({
            siteroot: a[0]
        }), "" != wx.getStorageSync("dtsearchkey") && (wx.removeStorageSync("dtsearchkey"), 
        t.setData({
            dtsearchkey: ""
        }));
        var e = t.data.pageid;
        null != e && "undefined" != e ? (t.data.homepageid == e ? t.setData({
            foot_is: t.data.foot_is
        }) : t.setData({
            foot_is: 1
        }), t.getPage(e), t.setData({
            homepage: 2,
            page_is: 2
        }), t.getfoot(1)) : this.homepage();
        wx.stopPullDownRefresh();
    },
    onReady: function(t) {
        this.audioCtx = wx.createAudioContext("myAudio");
    },
    onLoad: function(t) {
        (o = this).setData({
            isIphoneX: app.globalData.isIphoneX
        });
        var a = wx.getStorageSync("dtsearchkey");
        "" != a && (o.data.dtsearchkey = a), o.refreshSessionkey();
        var e = app.siteInfo.siteroot.split("/app");
        o.setData({
            siteroot: e[0]
        });
        var o = this;
        t.fxsid && (t.fxsid, o.setData({
            fxsid: t.fxsid
        })), wx.getSystemInfo({
            success: function(t) {
                o.setData({
                    width: t.windowWidth,
                    height: t.windowHeight,
                    left: (t.windowWidth - 76) / 2
                });
            }
        });
        var n = t.pageid;
        null != n && "undefined" != n ? (o.data.homepageid == n ? o.setData({
            foot_is: o.data.foot_is
        }) : o.setData({
            foot_is: 1
        }), o.getPage(n), o.setData({
            homepage: 2,
            page_is: 2,
            pageid: n,
            page_signs: "/sudu8_page/index/index?pageid=" + n
        }), o.getfoot(1)) : o.homepage();
    },
    homepage: function() {
        var o = this;
        app.util.request({
            url: "entry/wxapp/homepage",
            cachetime: "30",
            success: function(t) {
                var a = t.data.data.homepage, e = t.data.data.pageid;
                1 == a ? (o.setData({
                    homepage: 1,
                    foot_is: t.data.data.foot_is
                }), o.getIndex(), app.util.getUserInfo(o.getinfos, o.data.fxsid), 2 == t.data.data.foot_is ? o.setData({
                    page_signs: "/sudu8_page/index/index?pageid=" + e
                }) : o.setData({
                    page_signs: "/sudu8_page/index/index"
                })) : 2 == a && (0 == (o.data.pageid = e) ? wx.showModal({
                    title: "提醒",
                    content: "diy布局没有设置首页，无法进入",
                    showCancel: !1,
                    success: function(t) {
                        return !1;
                    }
                }) : (o.getPage(e), app.util.getUserInfo(o.getinfos, o.data.fxsid), o.setData({
                    page_signs: "/sudu8_page/index/index?pageid=" + e
                })), 1 == t.data.data.foot_is ? (o.setData({
                    page_signs: "/sudu8_page/index/index"
                }), o.getfoot(1)) : o.setData({
                    page_signs: "/sudu8_page/index/index?pageid=" + e
                }), o.setData({
                    homepage: 2,
                    homepageid: e,
                    foot_is: t.data.data.foot_is
                }));
            },
            fail: function(t) {}
        });
    },
    getfoot: function(t) {
        var a = this;
        app.util.request({
            url: "entry/wxapp/getfoot",
            cachetime: "30",
            data: {
                foot: t
            },
            success: function(t) {
                a.setData({
                    baseinfo: t.data.data
                });
            }
        });
    },
    tapMainMenu: function(t) {
        var a = this, e = t.currentTarget.dataset.index;
        a.data.lastIndex == e ? (a.data.times++, 2 == a.data.times ? a.setData({
            showMenu: !1
        }) : a.setData({
            showMenu: !0,
            content: a.data.menuContent[e].content,
            times: 1
        })) : a.setData({
            showMenu: !0,
            content: a.data.menuContent[e].content,
            times: 1
        }), a.data.lastIndex = e;
    },
    allShopList: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/selectShopList",
            cachetime: "30",
            data: {
                option1: e.data.menuContent[0].title,
                option2: e.data.menuContent[1].title,
                option3: e.data.menuContent[2].title,
                longitude: e.data.longitude,
                latitude: e.data.latitude
            },
            success: function(t) {
                var a = e.data.store;
                a.storeList = t.data.data, e.setData({
                    store: a
                });
            }
        });
    },
    tapSubMenu: function(t) {
        var a = this, e = a.data.menuContent, o = t.currentTarget.dataset.index;
        e[a.data.lastIndex].title = a.data.content[o], a.setData({
            menuContent: e,
            showMenu: !1,
            times: 2
        }), a.allShopList();
    },
    storelist: function() {
        var o = this;
        app.util.request({
            url: "entry/wxapp/storelist",
            cachetime: "30",
            success: function(t) {
                if (t.data.data.catelist) for (var a = o.data.menuContent, e = 0; e < t.data.data.catelist.length; e++) a[0].content.push(t.data.data.catelist[e].name);
                o.setData({
                    store: t.data.data,
                    menuContent: a
                });
            }
        });
    },
    getinfos: function() {
        var a = this;
        wx.getStorage({
            key: "openid",
            success: function(t) {
                a.setData({
                    openid: t.data
                });
            }
        });
    },
    getIndex: function() {
        var o = this;
        app.util.request({
            url: "entry/wxapp/base",
            cachetime: "30",
            data: {
                vs1: 1
            },
            success: function(t) {
                if (t.data.data.video) var a = "show"; else a = "hide";
                if (t.data.data.c_b_bg) var e = "bg"; else e = "";
                wx.setNavigationBarTitle({
                    title: t.data.data.name
                }), wx.setNavigationBarColor({
                    frontColor: t.data.data.base_tcolor,
                    backgroundColor: t.data.data.base_color
                }), o.setData({
                    baseinfo: t.data.data,
                    second: t.data.data.bigadCTC,
                    show_v: a,
                    c_b_bg1: e
                }), 1 == t.data.data.duomerchants ? (o.setData({
                    duomerchants: 1
                }), o.storelist(), wx.getLocation({
                    type: "wgs84",
                    success: function(t) {
                        o.data.latitude = t.latitude, o.data.longitude = t.longitude, o.allShopList();
                    },
                    fail: function(t) {
                        o.getlocation();
                    }
                })) : o.setData({
                    duomerchants: 0
                }), "1" == t.data.data.bigadC && o.countdown1(), o.index_nav(), "9" != t.data.data.copT && o.index_cop(), 
                1 == t.data.data.form_index && o.indexForm();
            },
            fail: function(t) {}
        });
    },
    getlocation: function() {
        wx.getSetting({
            success: function(t) {
                t.authSetting["scope.userLocation"] || wx.showModal({
                    title: "请授权获取当前位置",
                    content: "附近店铺需要授权此功能",
                    showCancel: !1,
                    success: function(t) {
                        t.confirm && wx.openSetting({
                            success: function(t) {
                                !0 === t.authSetting["scope.userLocation"] ? wx.showToast({
                                    title: "授权成功",
                                    icon: "success",
                                    duration: 1e3
                                }) : wx.showToast({
                                    title: "授权失败",
                                    icon: "success",
                                    duration: 1e3,
                                    success: function() {
                                        wx.reLaunch({
                                            url: "/sudu8_page/index/index"
                                        });
                                    }
                                });
                            }
                        });
                    }
                });
            },
            fail: function(t) {
                wx.showToast({
                    title: "调用授权窗口失败",
                    icon: "success",
                    duration: 1e3
                });
            }
        });
    },
    index_nav: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/nav",
            cachetime: "30",
            data: {
                type: "index"
            },
            success: function(t) {
                a.setData({
                    nav_index: t.data.data
                }), a.index_hot();
            },
            fail: function(t) {}
        });
    },
    index_cop: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/indexCop",
            cachetime: "30",
            data: {},
            success: function(t) {
                1 == t.data.data ? a.setData({
                    indexCop_is: 0
                }) : a.setData({
                    indexCop: t.data.data,
                    indexCop_is: 1
                });
            },
            fail: function(t) {}
        });
    },
    index_hot: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/Index_hot",
            cachetime: "30",
            success: function(t) {
                a.setData({
                    index_hot: t.data.data
                }), a.index_cate();
            },
            fail: function(t) {}
        });
    },
    index_cate: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/Index_cate",
            cachetime: "30",
            success: function(t) {
                a.setData({
                    index_cate: t.data.data
                }), wx.setStorageSync("isShowLoading", !1), wx.hideNavigationBarLoading(), wx.stopPullDownRefresh();
            },
            fail: function(t) {}
        });
    },
    countdown1: function() {
        var t = this, a = t.data.second;
        if (0 != a) setTimeout(function() {
            t.setData({
                second: a - 1
            }), t.countdown1();
        }, 1e3); else t.setData({
            showFad: 0
        });
    },
    serachInput: function(t) {
        this.setData({
            searchtitle: t.detail.value
        });
    },
    search: function() {
        var t = this.data.searchtitle;
        t ? wx.navigateTo({
            url: "/sudu8_page/search/search?title=" + t
        }) : wx.showModal({
            title: "提示",
            content: "请输入搜索内容！",
            showCancel: !1
        });
    },
    mapSerachInput: function(t) {
        this.setData({
            mapsearchtitle: t.detail.value
        });
    },
    mapSearch: function() {
        var t = this, a = t.data.mapsearchtitle;
        "" != a ? (wx.setStorageSync("dtsearchkey", a), t.setData({
            dtsearchkey: a
        }), t.getPage(t.data.pageid)) : "" != wx.getStorageSync("dtsearchkey") ? (wx.removeStorageSync("dtsearchkey"), 
        t.setData({
            dtsearchkey: ""
        }), t.getPage(t.data.pageid)) : wx.showModal({
            title: "提示",
            content: "请输入搜索内容！",
            showCancel: !1
        });
    },
    bindDateChange: function(t) {
        this.setData({
            date_c: t.detail.value
        });
    },
    bindTimeChange: function(t) {
        this.setData({
            time_c: t.detail.value
        });
    },
    swiperLoad: function(o) {
        var n = this;
        wx.getSystemInfo({
            success: function(t) {
                var a = o.detail.width / o.detail.height, e = t.windowWidth / a;
                n.data.heighthave || n.setData({
                    minHeight: e,
                    heighthave: 1
                });
            }
        });
    },
    redirectto: function(t) {
        var a = t.currentTarget.dataset.link, e = t.currentTarget.dataset.linktype;
        app.util.redirectto(a, e);
    },
    showvideo: function() {
        this.setData({
            showvideo: 1
        });
    },
    cvideo: function() {
        this.setData({
            showvideo: 0
        });
    },
    showvideo_diy: function(t) {
        this.setData({
            showvideo_diy: 1,
            videourl: t.currentTarget.dataset.video
        });
    },
    cvideo_idy: function() {
        this.setData({
            showvideo_diy: 0
        });
    },
    closeAd: function() {
        this.setData({
            showAd: 0
        });
    },
    closeFAd: function() {
        var t = this.data.pageset;
        null == t && (t = new Array()), t.kp_is = 2, this.setData({
            showFad: 0,
            pageset: t
        });
    },
    makePhoneCall: function(t) {
        var a = this.data.baseinfo.tel;
        wx.makePhoneCall({
            phoneNumber: a
        });
    },
    makePhoneCallB: function(t) {
        var a = this.data.baseinfo.tel_b;
        wx.makePhoneCall({
            phoneNumber: a
        });
    },
    makePhoneCallC: function(t) {
        var a = t.currentTarget.dataset.tel;
        wx.makePhoneCall({
            phoneNumber: a
        });
    },
    openMap: function(t) {
        wx.openLocation({
            latitude: parseFloat(this.data.baseinfo.latitude),
            longitude: parseFloat(this.data.baseinfo.longitude),
            name: this.data.baseinfo.name,
            address: this.data.baseinfo.address,
            scale: 22
        });
    },
    onShareAppMessage: function() {
        if (2 == this.data.homepage) return {
            title: this.data.pagetitle
        };
        this.data.baseinfo.name;
    },
    indexForm: function() {
        var u = this;
        app.util.request({
            url: "entry/wxapp/FormsConfig",
            cachetime: "30",
            success: function(t) {
                var a = t.data.data, e = t.data.data.single_v, o = t.data.data.checkbox_v, n = t.data.data.s2.s2v, i = t.data.data.c2.c2v, s = new Array(), d = new Array(), r = new Array(), c = new Array();
                s = e ? e.split(",") : "无", d = n ? n.split(",") : "无", r = o ? o.split(",") : "无", 
                c = i ? i.split(",") : "无", u.setData({
                    formsConfig: a,
                    single_v: s,
                    checkbox_v: r,
                    single_v2: d,
                    checkbox_v2: c
                }), wx.setStorageSync("isShowLoading", !1), wx.hideNavigationBarLoading(), wx.stopPullDownRefresh();
            }
        });
    },
    formSubmit: function(t) {
        var a = this;
        if (0 == t.detail.value.name.length && 1 == a.data.formsConfig.name_must) return wx.showModal({
            title: "提示",
            content: "请输入" + a.data.formsConfig.name,
            showCancel: !1
        }), !1;
        if (1 == a.data.formsConfig.tel_use && 1 == a.data.formsConfig.tel_i && 0 == t.detail.value.tel.length && 1 == a.data.formsConfig.tel_must) return wx.showModal({
            title: "提示",
            content: "请输入" + a.data.formsConfig.tel,
            showCancel: !1
        }), !1;
        if (1 == a.data.formsConfig.wechat_use && 1 == a.data.formsConfig.wechat_i && 0 == t.detail.value.wechat.length && 1 == a.data.formsConfig.wechat_must) return wx.showModal({
            title: "提示",
            content: "请输入" + a.data.formsConfig.wechat,
            showCancel: !1
        }), !1;
        if (1 == a.data.formsConfig.address_use && 1 == a.data.formsConfig.address_i && 0 == t.detail.value.address.length && 1 == a.data.formsConfig.address_must) return wx.showModal({
            title: "提示",
            content: "请输入" + a.data.formsConfig.address,
            showCancel: !1
        }), !1;
        if (1 == a.data.formsConfig.t5.t5u && 1 == a.data.formsConfig.t5.t5i && 0 == t.detail.value.t5.length && 1 == a.data.formsConfig.t5.t5m) return wx.showModal({
            title: "提示",
            content: "请输入" + a.data.formsConfig.t5.t5n,
            showCancel: !1
        }), !1;
        if (1 == a.data.formsConfig.t6.t6u && 1 == a.data.formsConfig.t6.t6i && 0 == t.detail.value.t6.length && 1 == a.data.formsConfig.t6.t6m) return wx.showModal({
            title: "提示",
            content: "请输入" + a.data.formsConfig.t6.t6n,
            showCancel: !1
        }), !1;
        if (1 == a.data.formsConfig.date_use && 1 == a.data.formsConfig.date_i && "" == t.detail.value.date && 1 == a.data.formsConfig.date_must) return wx.showModal({
            title: "提示",
            content: "请选择" + a.data.formsConfig.date,
            showCancel: !1
        }), !1;
        if (1 == a.data.formsConfig.time_use && 1 == a.data.formsConfig.time_i && "" == t.detail.value.time && 1 == a.data.formsConfig.time_must) return wx.showModal({
            title: "提示",
            content: "请选择" + a.data.formsConfig.time,
            showCancel: !1
        }), !1;
        if (1 == a.data.formsConfig.single_use && 1 == a.data.formsConfig.single_i && "" == t.detail.value.single && 1 == a.data.formsConfig.single_must) return wx.showModal({
            title: "提示",
            content: "请选择" + a.data.formsConfig.single_n,
            showCancel: !1
        }), !1;
        if (1 == a.data.formsConfig.s2.s2u && 1 == a.data.formsConfig.s2.s2i && "" == t.detail.value.s2 && 1 == a.data.formsConfig.s2.s2m) return wx.showModal({
            title: "提示",
            content: "请选择" + a.data.formsConfig.s2.s2n,
            showCancel: !1
        }), !1;
        if (1 == a.data.formsConfig.checkbox_use && 1 == a.data.formsConfig.checkbox_i) {
            if ("" == t.detail.value.checkbox && 1 == a.data.formsConfig.checkbox_must) return wx.showModal({
                title: "提示",
                content: "请选择" + a.data.formsConfig.checkbox_n,
                showCancel: !1
            }), !1;
            t.detail.value.checkbox = t.detail.value.checkbox.join(",");
        }
        if (1 == a.data.formsConfig.c2.c2u && 1 == a.data.formsConfig.c2.c2i) {
            if ("" == t.detail.value.c2 && 1 == a.data.formsConfig.c2.c2m) return wx.showModal({
                title: "提示",
                content: "请选择" + a.data.formsConfig.c2.c2n,
                showCancel: !1
            }), !1;
            t.detail.value.c2 = t.detail.value.c2.join(",");
        }
        if (1 == a.data.formsConfig.content_use && 1 == a.data.formsConfig.content_i && 0 == t.detail.value.content.length && 1 == a.data.formsConfig.content_must) return wx.showModal({
            title: "提示",
            content: "请输入" + a.data.formsConfig.content_n,
            showCancel: !1
        }), !1;
        if (1 == a.data.formsConfig.con2.con2u && 1 == a.data.formsConfig.con2.con2i && 0 == t.detail.value.con2.length && 1 == a.data.formsConfig.con2.con2m) return wx.showModal({
            title: "提示",
            content: "请输入" + a.data.formsConfig.con2.con2n,
            showCancel: !1
        }), !1;
        var e = t.detail.value, o = t.detail.formId;
        e.formid = o, e.openid = wx.getStorageSync("openid");
        var n = new Date(), i = n.getMonth() + 1 + "" + n.getDate() + (3600 * n.getHours() + 60 * n.getMinutes() + n.getSeconds()), s = wx.getStorageSync("mypretime");
        s ? i - s > a.data.formsConfig.subtime && wx.setStorage({
            key: "mypretime",
            data: i,
            success: function(t) {},
            fail: function(t) {}
        }) : wx.setStorage({
            key: "mypretime",
            data: i,
            success: function(t) {},
            fail: function(t) {}
        }), wx.showToast({
            title: "数据提交中...",
            icon: "loading",
            duration: 5e3
        }), app.util.request({
            url: "entry/wxapp/AddForms",
            cachetime: "30",
            data: e,
            success: function(t) {
                wx.showToast({
                    title: a.data.formsConfig.success,
                    icon: "success",
                    duration: 5e3
                });
            },
            fail: function(t) {
                wx.showModal({
                    title: "提示",
                    content: "提交失败！",
                    showCancel: !1
                });
            }
        });
    },
    playvoice: function(t) {
        var a = this, e = t.currentTarget.dataset.text;
        "" == a.data.pageset.diy_bg_music ? wx.showModal({
            title: "提示",
            content: "DIY页面暂无背景音频"
        }) : 0 == e ? (a.audioPlay1(), a.setData({
            status: 1,
            st: 2,
            sy: "music-on",
            autovoice: 1
        })) : 1 == e && (a.audioPause(), a.setData({
            status: 0,
            st: 10,
            sy: "",
            autovoice: 0
        }));
    },
    audioPlay1: function() {
        var t = this.data.pageset.diy_bg_music;
        "" != t && null != t && (this.setData({
            autovoice: 1,
            st: 2,
            sy: "music-on",
            status: 1
        }), BackgroundAudioManager.src = t, BackgroundAudioManager.title = "首页背景音乐", BackgroundAudioManager.play());
    },
    audioPause: function() {
        this.setData({
            autovoice: 0,
            st: 10,
            sy: "",
            status: 0
        }), BackgroundAudioManager.pause();
    },
    getPage: function(t) {
        var f = this;
        app.util.request({
            url: "entry/wxapp/diypage",
            data: {
                pageid: t,
                dtsearchkey: f.data.dtsearchkey
            },
            success: function(t) {
                var a = t.data.data;
                if (3 == a) return wx.showModal({
                    title: "提示",
                    content: "当前页面所在模板未启用，请修改底部菜单链接",
                    showCancel: !1
                }), !1;
                void 0 !== a.forminfo && null != _typeof(a.forminfo) && 0 != a.forminfo && f.setData({
                    forminfo: a.forminfo.tp_text,
                    formid: a.forminfo.id,
                    formname: a.forminfo.formname,
                    formdescs: a.forminfo.descs
                }), void 0 !== a.copyrights && null != _typeof(a.copyrights) && 0 != a.copyrights && f.setData({
                    copyrights: a.copyrights
                }), void 0 !== a.footmenu && null != _typeof(a.footmenu) && 0 != a.footmenu && f.setData({
                    footmenu: a.footmenu,
                    footmenuh: a.footmenuh,
                    foottext: a.foottext
                });
                var e = t.data.data.pageset;
                if (e) {
                    if (1 == e.go_home) {
                        var o = e.kp_m;
                        0 < o && (f.setData({
                            sec: o
                        }), f.countdown());
                    }
                    f.setData({
                        foot_is: e.foot_is
                    });
                } else f.setData({
                    foot_is: 1
                });
                var n = t.data.data.page, i = t.data.data.items;
                wx.setNavigationBarTitle({
                    title: n.title
                });
                var s = 1 == n.topcolor ? "#000000" : "#ffffff";
                wx.setNavigationBarColor({
                    frontColor: s,
                    backgroundColor: n.topbackground,
                    animation: {
                        duration: 400,
                        timingFunc: "easeIn"
                    }
                });
                for (var d = 0, r = 0; r < i.length; r++) if ("mlist" == i[r].id) {
                    var c = i[r].data.catelist, u = i[r].data, l = f.data.menuContent;
                    if (c) for (r = 0; r < c.length; r++) l[0].content.push(c[r].name);
                    f.setData({
                        store: u,
                        menuContent: l
                    });
                    break;
                }
                for (r = 0; r < i.length; r++) "mlist" == i[r].id && wx.getLocation({
                    type: "wgs84",
                    success: function(t) {
                        f.data.latitude = t.latitude, f.data.longitude = t.longitude, f.allShopList();
                    },
                    fail: function(t) {
                        f.getlocation();
                    }
                }), "dt2" == i[r].id && (f.setData({
                    map_scale: i[r].scale
                }), wx.getLocation({
                    type: "wgs84",
                    success: function(t) {
                        f.setData({
                            latitude: t.latitude,
                            longitude: t.longitude
                        });
                    },
                    fail: function(t) {
                        f.getlocation();
                    }
                })), "dt" == i[r].id && f.setData({
                    markers: [ {
                        iconPath: "/sudu8_page/resource/img/dtdw.png",
                        id: 0,
                        latitude: i[r].params.zzb,
                        longitude: i[r].params.hzb,
                        width: 30,
                        height: 30,
                        callout: {
                            content: i[r].params.title + i[r].params.wzmc,
                            color: "#fff",
                            fontSize: 12,
                            borderRadius: 5,
                            bgColor: "#31DC8F",
                            padding: 10,
                            display: "ALWAYS",
                            textAlign: "center"
                        }
                    } ]
                }), "richtext" == i[r].id && (0 == d && (f.setData({
                    cons: wxParse.wxParse("content0", "html", i[r].richtext, f, 0)
                }), i[r].id = "richtext0"), 1 == d && (f.setData({
                    cons: wxParse.wxParse("content1", "html", i[r].richtext, f, 0)
                }), i[r].id = "richtext1"), 2 == d && (f.setData({
                    cons: wxParse.wxParse("content2", "html", i[r].richtext, f, 0)
                }), i[r].id = "richtext2"), 3 == d && (f.setData({
                    cons: wxParse.wxParse("content3", "html", i[r].richtext, f, 0)
                }), i[r].id = "richtext3"), 4 == d && (f.setData({
                    cons: wxParse.wxParse("content4", "html", i[r].richtext, f, 0)
                }), i[r].id = "richtext4"), d++), f.setData({
                    list: i
                }), "msmk" == i[r].id && f.daojishi(r);
                f.setData({
                    pageset: e,
                    list: f.data.list,
                    background: n.background,
                    size: n.size,
                    repeat: n.repeat,
                    positionx: n.positionx,
                    positiony: n.positiony,
                    sizew: n.sizew,
                    sizeh: n.sizeh,
                    url: n.url,
                    pagetitle: n.title,
                    pagename: n.name,
                    styledata: n.styledata
                }), wx.hideLoading(), f.audioPlay1();
            },
            fail: function(t) {
                wx.hideLoading(), wx.showModal({
                    title: "提示",
                    content: "加载失败"
                });
            }
        });
    },
    daojishi: function(t) {
        var a = this, e = a.data.list[t].data2;
        if (e) {
            for (var o = 0; o < e.length; o++) {
                var n = new Date().getTime(), i = 1e3 * parseInt(e[o].sale_end_time);
                if (i <= 0) e[o].endtime = 0; else {
                    var s, d, r, c, u = i - n;
                    u <= 0 ? e[o].endtime = 0 : (0 < u && (s = Math.floor(u / 1e3 / 60 / 60 / 24), d = Math.floor(u / 1e3 / 60 / 60 % 24) < 10 ? "0" + Math.floor(u / 1e3 / 60 / 60 % 24) : Math.floor(u / 1e3 / 60 / 60 % 24), 
                    r = Math.floor(u / 1e3 / 60 % 60) < 10 ? "0" + Math.floor(u / 1e3 / 60 % 60) : Math.floor(u / 1e3 / 60 % 60), 
                    c = Math.floor(u / 1e3 % 60) < 10 ? "0" + Math.floor(u / 1e3 % 60) : Math.floor(u / 1e3 % 60)), 
                    e[o].endtime = 0 < s ? s + "天" + d + ":" + r + ":" + c : d + ":" + r + ":" + c);
                }
            }
            a.setData({
                list2: e
            });
            setTimeout(function() {
                a.daojishi(t);
            }, 1e3);
        }
    },
    refreshSessionkey: function() {
        var a = this;
        wx.login({
            success: function(t) {
                app.util.request({
                    url: "entry/wxapp/getNewSessionkey",
                    data: {
                        code: t.code
                    },
                    success: function(t) {
                        a.setData({
                            newSessionKey: t.data.data
                        });
                    }
                });
            }
        });
    },
    getPhoneNumber1: function(t) {
        var o = this, a = t.detail.iv, e = t.detail.encryptedData;
        "getPhoneNumber:ok" == t.detail.errMsg ? wx.checkSession({
            success: function() {
                app.util.request({
                    url: "entry/wxapp/jiemiNew",
                    data: {
                        newSessionKey: o.data.newSessionKey,
                        iv: a,
                        encryptedData: e
                    },
                    success: function(t) {
                        if (t.data.data) {
                            for (var a = o.data.forminfo, e = 0; e < a.length; e++) 0 == a[e].type && 5 == a[e].tp_text[0].yval && (a[e].val = t.data.data);
                            o.setData({
                                wxmobile: t.data.data,
                                forminfo: a
                            });
                        } else wx.showModal({
                            title: "提示",
                            content: "sessionKey已过期，请下拉刷新！"
                        });
                    },
                    fail: function(t) {}
                });
            },
            fail: function() {
                wx.showModal({
                    title: "提示",
                    content: "sessionKey已过期，请下拉刷新！"
                });
            }
        }) : wx.showModal({
            title: "提示",
            content: "请先授权获取您的手机号！",
            showCancel: !1
        });
    },
    weixinadd: function() {
        var s = this;
        wx.chooseAddress({
            success: function(t) {
                for (var a = t.provinceName + " " + t.cityName + " " + t.countyName + " " + t.detailInfo, e = t.userName, o = t.telNumber, n = s.data.forminfo, i = 0; i < n.length; i++) 0 == n[i].type && 2 == n[i].tp_text[0].yval && (n[i].val = e), 
                0 == n[i].type && 3 == n[i].tp_text[0].yval && (n[i].val = o), 0 == n[i].type && 4 == n[i].tp_text[0].yval && (n[i].val = a);
                s.setData({
                    myname: e,
                    mytel: o,
                    myadd: a,
                    forminfo: n
                });
            },
            fail: function(t) {
                wx.getSetting({
                    success: function(t) {
                        t.authSetting["scope.address"] || wx.openSetting({
                            success: function(t) {}
                        });
                    }
                });
            }
        });
    },
    namexz: function(t) {
        for (var a = t.currentTarget.dataset.index, e = this.data.forminfo[a], o = [], n = 0; n < e.tp_text.length; n++) {
            var i = {};
            i.keys = e.tp_text[n], i.val = 1, o.push(i);
        }
        this.setData({
            ttcxs: 1,
            formindex: a,
            xx: o,
            xuanz: 0,
            lixuanz: -1
        }), this.riqi();
    },
    riqi: function() {
        for (var t = new Date(), a = new Date(t.getTime()), e = a.getFullYear() + "-" + (a.getMonth() + 1) + "-" + a.getDate(), o = this.data.xx, n = 0; n < o.length; n++) o[n].val = 1;
        this.setData({
            xx: o
        }), this.gettoday(e);
        var i = [], s = [], d = new Date();
        for (n = 0; n < 5; n++) {
            var r = new Date(d.getTime() + 24 * n * 3600 * 1e3), c = r.getFullYear(), u = r.getMonth() + 1, l = r.getDate(), f = u + "月" + l + "日", h = c + "-" + u + "-" + l;
            i.push(f), s.push(h);
        }
        this.setData({
            arrs: i,
            fallarrs: s,
            today: e
        });
    },
    xuanzd: function(t) {
        for (var a = t.currentTarget.dataset.index, e = this.data.fallarrs[a], o = this.data.xx, n = 0; n < o.length; n++) o[n].val = 1;
        this.setData({
            xuanz: a,
            today: e,
            lixuanz: -1,
            xx: o
        }), this.gettoday(e);
    },
    goux: function(t) {
        var a = t.currentTarget.dataset.index;
        this.setData({
            lixuanz: a
        });
    },
    gettoday: function(t) {
        var n = this, a = n.data.id, e = n.data.formindex, i = n.data.xx;
        app.util.request({
            url: "entry/wxapp/Duzhan",
            data: {
                id: a,
                types: "diy",
                days: t,
                pagedatekey: e
            },
            header: {
                "content-type": "application/json"
            },
            success: function(t) {
                for (var a = t.data.data, e = 0; e < a.length; e++) i[a[e]].val = 2;
                var o = 0;
                a.length == i.length && (o = 1), n.setData({
                    xx: i,
                    isover: o
                });
            }
        });
    },
    save_nb: function() {
        var t = this, a = t.data.today, e = t.data.xx, o = t.data.lixuanz;
        if (-1 == o) return wx.showModal({
            title: "提现",
            content: "请选择预约的选项",
            showCancel: !1
        }), !1;
        var n = "已选择" + a + "，" + e[o].keys.yval, i = t.data.forminfo, s = t.data.formindex;
        i[s].val = n, i[s].days = a, i[s].indexkey = s, i[s].xuanx = o, t.setData({
            ttcxs: 0,
            forminfo: i
        });
    },
    quxiao: function() {
        this.setData({
            ttcxs: 0
        });
    },
    bindInputChange: function(t) {
        var a = t.detail.value, e = t.currentTarget.dataset.index, o = this.data.forminfo;
        o[e].val = a, this.setData({
            forminfo: o
        });
    },
    bindPickerChange: function(t) {
        var a = t.detail.value, e = t.currentTarget.dataset.index, o = this.data.forminfo, n = o[e].tp_text[a];
        o[e].val = n, this.setData({
            forminfo: o
        });
    },
    bindDateChange1: function(t) {
        var a = t.detail.value, e = t.currentTarget.dataset.index, o = this.data.forminfo;
        o[e].val = a, this.setData({
            forminfo: o
        });
    },
    bindTimeChange1: function(t) {
        var a = t.detail.value, e = t.currentTarget.dataset.index, o = this.data.forminfo;
        o[e].val = a, this.setData({
            forminfo: o
        });
    },
    checkboxChange: function(t) {
        var a = t.detail.value, e = t.currentTarget.dataset.index, o = this.data.forminfo;
        o[e].val = a, this.setData({
            forminfo: o
        });
    },
    radioChange: function(t) {
        var a = t.detail.value, e = t.currentTarget.dataset.index, o = this.data.forminfo;
        o[e].val = a, this.setData({
            forminfo: o
        });
    },
    delimg: function(t) {
        var a = t.currentTarget.dataset.index, e = t.currentTarget.dataset.id, o = this.data.forminfo, n = o[a].z_val;
        n.splice(e, 1), 0 == n.length && (n = ""), o[a].z_val = n, this.setData({
            forminfo: o
        });
    },
    formSubmit1: function(t) {
        for (var a = this.data.forminfo, e = 0; e < a.length; e++) if (1 == a[e].ismust) if (5 == a[e].type) {
            if ("" == a[e].z_val) return wx.showModal({
                title: "提醒",
                content: a[e].name + "为必填项！",
                showCancel: !1
            }), !1;
        } else if ("" == a[e].val) return wx.showModal({
            title: "提醒",
            content: a[e].name + "为必填项！",
            showCancel: !1
        }), !1;
        app.util.request({
            url: "entry/wxapp/DiyForms",
            method: "POST",
            data: {
                forminfo: JSON.stringify(a),
                formid: this.data.formid,
                form_id: t.detail.formId,
                openid: wx.getStorageSync("openid"),
                pagename: this.data.pagename
            },
            success: function(t) {
                t.data.data && wx.showModal({
                    title: "提醒",
                    content: "表单提交成功",
                    showCancel: !1,
                    success: function(t) {
                        wx.reLaunch({
                            url: "/sudu8_page/index/index"
                        });
                    }
                });
            }
        });
    },
    choiceimg1111: function(t) {
        var i = this, a = 0, s = i.data.zhixin, d = t.currentTarget.dataset.index, r = i.data.forminfo, e = r[d].val, o = r[d].tp_text[0];
        e ? a = e.length : (a = 0, e = []);
        var n = o - a, c = app.util.url("entry/wxapp/wxupimg", {
            m: "sudu8_page"
        }), u = r[d].z_val ? r[d].z_val : [];
        wx.chooseImage({
            count: n,
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(t) {
                s = !0, i.setData({
                    zhixin: s
                }), wx.showLoading({
                    title: "图片上传中"
                });
                var a = t.tempFilePaths, o = 0, n = a.length;
                !function e() {
                    wx.uploadFile({
                        url: c,
                        filePath: a[o],
                        name: "file",
                        success: function(t) {
                            var a = JSON.parse(t.data);
                            u.push(a), r[d].z_val = u, i.setData({
                                forminfo: r
                            }), ++o < n ? e() : (s = !1, i.setData({
                                zhixin: s
                            }), wx.hideLoading());
                        }
                    });
                }();
            }
        });
    },
    tabFun2: function(t) {
        var a = t.target.dataset.id, e = {};
        e.curHdIndex = a, this.setData({
            tabArr2: e
        });
    },
    audioPlay: function(t) {
        1 == this.data.yuyin ? (this.audioCtx.play(), this.setData({
            yuyin: 2
        })) : (this.audioCtx.pause(), this.setData({
            yuyin: 1
        }));
    },
    countdown: function(t) {
        var a = this;
        if (null != t && "undefined" != t) var e = t.currentTarget.dataset.close; else e = 1;
        var o = a.data.sec;
        if (0 == o || 0 == e) {
            var n = a.data.pageset;
            return null == n && (n = new Array()), n.kp_is = 2, void this.setData({
                showFad: 0,
                pageset: n
            });
        }
        setTimeout(function() {
            a.setData({
                sec: o - 1
            }), a.countdown();
        }, 1e3);
    },
    hide_tcgg: function() {
        var t = this.data.pageset;
        t.tc_is = 2, this.setData({
            show_page_tcgg: 0,
            pageset: t
        });
    }
}, "openMap", function(t) {
    wx.openLocation({
        latitude: parseFloat(this.data.baseinfo.latitude),
        longitude: parseFloat(this.data.baseinfo.longitude),
        name: this.data.baseinfo.name,
        address: this.data.baseinfo.address,
        scale: 22
    });
}), _defineProperty(_Page, "ewmshow", function(t) {
    wx.previewImage({
        current: t.currentTarget.dataset.ewm,
        urls: [ t.currentTarget.dataset.ewm ]
    });
}), _defineProperty(_Page, "swiperh", function() {
    var a = this, t = wx.createSelectorQuery();
    t.select("#mjltest").boundingClientRect(), t.exec(function(t) {
        a.setData({
            h: t[0].height
        });
    });
}), _defineProperty(_Page, "phoneshop", function(t) {
    var a = t.currentTarget.dataset.num;
    wx.makePhoneCall({
        phoneNumber: a,
        success: function() {},
        fail: function() {}
    });
}), _defineProperty(_Page, "swiperChange", function(t) {
    this.setData({
        currentSwiper: t.detail.current
    });
}), _defineProperty(_Page, "mapforum_release", function() {
    wx.navigateTo({
        url: "/sudu8_page_plugin_mapforum/release/release"
    });
}), _defineProperty(_Page, "mapforum_list", function() {
    wx.navigateTo({
        url: "/sudu8_page_plugin_mapforum/forum/forum?fid=0"
    });
}), _defineProperty(_Page, "markertap2", function(t) {
    this.setData({
        mapforum_pop: !0,
        markerId: t.markerId
    });
}), _defineProperty(_Page, "mapforum_pop_close", function() {
    this.setData({
        mapforum_pop: !1
    });
}), _defineProperty(_Page, "look_more", function(t) {
    wx.navigateTo({
        url: "/sudu8_page_plugin_mapforum/forum_page/forum_page?rid=" + t.currentTarget.dataset.rid
    });
}), _Page));