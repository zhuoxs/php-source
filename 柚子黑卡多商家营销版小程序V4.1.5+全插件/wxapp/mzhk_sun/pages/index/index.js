var _Page;

function _defineProperty(e, t, a) {
    return t in e ? Object.defineProperty(e, t, {
        value: a,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : e[t] = a, e;
}

var app = getApp(), Page = require("../../sdk/qitui/oddpush.js").oddPush(Page).Page;

Page((_defineProperty(_Page = {
    data: {
        indexstyle: 999,
        imgUrls: [],
        url: "",
        topbg: "#ffd842",
        currentindex: 1,
        indicatorDots: !1,
        autoplay: !1,
        interval: 3e3,
        duration: 800,
        activeList: [],
        activeList_two: [],
        welfareList: [],
        orders: 0,
        rporders: 0,
        hklogo: "../../../style/images/hklogo.png",
        hkname: "首页",
        currentcity: "厦门",
        hk_bgimg: "",
        usersinfo: [],
        is_modal_Hidden: !0,
        searchCont: "",
        openaddress: !1,
        phoneGrant: !1,
        opentel: !1,
        technical: {
            tech_img: "../../../style/images/support1.png",
            tech_title: "柚子团队出品",
            tech_phone: "0592-66666666"
        },
        operation: [ {
            title: "砍价",
            src: "../../../style/images/2.png",
            bind: "toBargain"
        }, {
            title: "集卡",
            src: "../../../style/images/1.png",
            bind: "toCards"
        }, {
            title: "抢购",
            src: "../../../style/images/3.png",
            bind: "toTimebuy"
        }, {
            title: "拼团",
            src: "../../../style/images/4.png",
            bind: "toGroup"
        }, {
            title: "专题",
            src: "../../../style/images/5.png",
            bind: "toNews"
        } ],
        page: 1,
        adimg: [],
        adflashimg: [],
        adtbbannerimg: [],
        haveadtbbannerimg: 0,
        adadoneimg: [],
        adadtwoimg: !1,
        adhomebuoy: [],
        showAd: 0,
        Popimg: [],
        showcheck: 0,
        tabBar_default: 2,
        otherApplets: [],
        is_hyopen: 2,
        whichone: 0,
        whichonetwo: 15,
        is_homeshow_circle: 0,
        bargain: [],
        sunburn: [],
        loadinghidden: app.globalData.loadinghidden,
        wxappletscode: "",
        showPublic: 0,
        wxappletscode_cache: "/mzhk_sun/pages/user/welfare/welfare",
        foot_nav: [ {
            name: "营业执照"
        }, {
            name: "icp许可证"
        }, {
            name: "服务协议"
        }, {
            name: "隐私政策"
        } ],
        currenttab: 0,
        banIndex: 1,
        fassion_indexname: "裂变券专区"
    },
    onLoad: function(e) {
        var t = wx.getStorageSync("iscloseadmire");
        this.setData({
            iscloseadmire: t
        });
        var h = this, a = wx.getStorageSync("goodskeyword");
        e = app.func.decodeScene(e), h.setData({
            options: e,
            kw: a,
            loadinghidden: !!app.globalData.loadinghidden
        });
        var f = app.getSiteUrl();
        f ? (app.editTabBar(f), h.setData({
            url: f
        }), app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            showLoading: !1,
            success: function(e) {
                wx.setStorageSync("url", e.data), f = e.data, h.setData({
                    url: f
                });
            }
        })) : app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            showLoading: !1,
            success: function(e) {
                wx.setStorageSync("url", e.data), f = e.data, app.editTabBar(f), h.setData({
                    url: f
                });
            }
        }), app.wxauthSetting();
        wx.getStorageSync("System");
        app.util.request({
            url: "entry/wxapp/System",
            showLoading: app.globalData.loadinghidden,
            success: function(e) {
                console.log(e), wx.setStorageSync("System", e.data);
                var t = e.data.attachurl;
                h.data.openaddress;
                wx.setStorageSync("url", t), h.setData({
                    isbusiness: e.data.isbusiness,
                    opennotice: e.data.opennotice,
                    opensearch: e.data.opensearch,
                    opennavtype: e.data.opennavtype
                }), 1 == e.data.opennotice && app.util.request({
                    url: "entry/wxapp/GetNews",
                    cachetime: "30",
                    success: function(e) {
                        console.log("专题数据"), console.log(e.data), 2 == e.data ? h.setData({
                            news: []
                        }) : h.setData({
                            news: e.data
                        });
                    }
                }), 1 == e.data.openaddress && h.setData({
                    openaddress: e.data.openaddress
                }), 1 == e.data.opentel && h.setData({
                    opentel: e.data.opentel
                }), wx.setNavigationBarColor({
                    frontColor: e.data.fontcolor ? e.data.fontcolor : "#000000",
                    backgroundColor: e.data.color ? e.data.color : "#ffffff",
                    animation: {
                        duration: 0,
                        timingFunc: "easeIn"
                    }
                }), wx.setNavigationBarTitle({
                    title: e.data.pt_name ? e.data.pt_name : h.data.hkname
                });
                var a = {
                    tech_img: t + e.data.tech_img,
                    tech_title: e.data.tech_title,
                    tech_phone: e.data.tech_phone,
                    is_show_tech: e.data.is_show_tech,
                    is_show_tel: e.data.is_show_tel
                }, n = e.data.hk_logo ? t + e.data.hk_logo : "", o = e.data.hk_tubiao ? e.data.hk_tubiao : "", i = e.data.subheading ? e.data.subheading : "", r = e.data.topbg ? e.data.topbg : "#ffd842", s = e.data.is_open_pop ? e.data.is_open_pop : 0, d = e.data.version ? e.data.version : "99999";
                if (d == app.siteInfo.version) var c = e.data.showcheck ? e.data.showcheck : 0; else if ("99999" == d) c = e.data.showcheck ? e.data.showcheck : 0; else c = 0;
                var u = e.data.is_homeshow_circle, p = e.data.hometheme ? e.data.hometheme : 0, g = e.data.home_circle_name ? e.data.home_circle_name : "";
                1 == p && 1 == u && app.util.request({
                    url: "entry/wxapp/GetIndexCircle",
                    showLoading: !1,
                    data: {
                        position: 1
                    },
                    success: function(e) {
                        2 != e.data && h.setData({
                            sunburn: e.data
                        });
                    }
                }), app.globalData.loadinghidden = !0;
                var l = e.data.wxappletscode ? f + e.data.wxappletscode : "";
                h.setData({
                    openblackcard: e.data.openblackcard,
                    logo: n,
                    pt_name: o,
                    subheading: i,
                    topbg: r,
                    tel_pt_name: e.data.pt_name,
                    hk_bgimg: e.data.hk_bgimg ? t + e.data.hk_bgimg : "",
                    hk_namecolor: e.data.hk_namecolor ? e.data.hk_namecolor : "#f5ac32",
                    technical: a,
                    showAd: s,
                    showcheck: c,
                    indexstyle: p,
                    is_homeshow_circle: u,
                    home_circle_name: g,
                    loadinghidden: !0,
                    wxappletscode: l
                }), l && wx.getImageInfo({
                    src: l,
                    success: function(e) {
                        h.setData({
                            wxappletscode_cache: e.path
                        });
                    }
                });
            }
        });
        var n = wx.getStorageSync("currentcity");
        n ? h.setData({
            currentcity: n
        }) : h.getcurrentcity();
        app.util.request({
            url: "entry/wxapp/GetadData",
            showLoading: !1,
            data: {
                inpos: "1,2,8,10,11,13,15"
            },
            success: function(e) {
                var t = e.data;
                if (console.log(t), app.globalData.hasshowpopad ? h.setData({
                    showAd: 0
                }) : (app.globalData.hasshowpopad = !0, h.setData({
                    adimg: t.pop ? t.pop : []
                })), 2 != t) {
                    var a = 5, n = 10;
                    if (t.tbbanner) {
                        var o = 1;
                        a = Math.ceil(t.tbbanner.length / 5), n = Math.ceil(t.tbbanner.length / 10);
                    } else o = 2;
                    var i = !1;
                    1 < a && (i = !0), console.log(a), console.log(n), app.globalData.loadinghidden = !0, 
                    h.setData({
                        adbackcardimg: t.backcard ? t.backcard : [],
                        adflashimg: t.flash ? t.flash : [],
                        adtbbannerimg: t.tbbanner ? t.tbbanner : [],
                        adadoneimg: t.adone ? t.adone : [],
                        adadtwoimg: !!t.adtwo && t.adtwo[0],
                        haveadtbbannerimg: o,
                        adhomebuoy: !!t.homebuoy && t.homebuoy[0],
                        loadinghidden: !0,
                        indicatorDots: i,
                        adtLen: a,
                        adtLen1: n
                    });
                } else h.setData({
                    haveadtbbannerimg: 2
                });
            }
        }), app.util.request({
            url: "entry/wxapp/GetOtherApplets",
            showLoading: !1,
            data: {
                position: 1
            },
            success: function(e) {
                h.setData({
                    otherApplets: e.data.wxappjump,
                    otherAppletsurl: e.data.url,
                    is_hyopen: e.data.is_hyopen
                });
            }
        }), app.util.request({
            url: "entry/wxapp/CheckGroup",
            showLoading: !1,
            success: function(e) {}
        }), app.util.request({
            url: "entry/wxapp/Plugin",
            data: {
                type: 4
            },
            showLoading: !1,
            success: function(e) {
                var t = 2 != e.data && e.data;
                1 == t.open_fission && (app.util.request({
                    url: "entry/wxapp/GetFission",
                    showLoading: !1,
                    data: {
                        type: 1,
                        m: app.globalData.Plugin_fission
                    },
                    success: function(e) {
                        h.setData({
                            fassion: e.data
                        });
                    }
                }), app.util.request({
                    url: "entry/wxapp/GetSet",
                    showLoading: !1,
                    data: {
                        m: app.globalData.Plugin_fission
                    },
                    success: function(e) {
                        e.data.index_name && h.setData({
                            fassion_indexname: e.data.index_name
                        });
                    }
                })), h.setData({
                    open_scoretask: t
                });
            }
        });
    },
    closeIndexAdmire: function() {
        wx.setStorageSync("iscloseadmire", !0), this.setData({
            iscloseadmire: !0
        });
    },
    closeAd: function(e) {
        this.setData({
            showAd: !1
        });
    },
    closePublic: function(e) {
        this.setData({
            showPublic: 0
        });
    },
    publicimgsave: function() {
        var t = this;
        if ("" == t.data.wxappletscode_cache) return wx.showToast({
            title: "图片未加载完，请稍后",
            icon: "none",
            duration: 800
        }), !1;
        wx.saveImageToPhotosAlbum({
            filePath: t.data.wxappletscode_cache,
            success: function(e) {
                console.log("成功"), wx.showModal({
                    content: "图片已保存到相册，赶紧晒一下吧~",
                    showCancel: !1,
                    confirmText: "好哒",
                    confirmColor: "#ef8200",
                    success: function(e) {
                        e.confirm && (console.log("用户点击确定"), t.setData({
                            showPublic: 0
                        }));
                    }
                });
            },
            fail: function(e) {
                console.log(e), console.log("失败"), wx.getSetting({
                    success: function(e) {
                        e.authSetting["scope.writePhotosAlbum"] || (console.log("进入信息授权开关页面"), wx.openSetting({
                            success: function(e) {
                                console.log("openSetting success", e.authSetting);
                            }
                        }));
                    }
                });
            }
        });
    },
    GotootherApplets: function(e) {
        var t = this.data.otherApplets;
        wx.navigateToMiniProgram({
            appId: t.appid,
            path: t.path,
            extarData: {
                open: "auth"
            },
            envVersion: "develop",
            success: function(e) {
                console.log(e), console.log("跳转成功"), 0 <= t.path.indexOf("mzhk_sun") && wx.navigateTo({
                    url: "/" + t.path
                });
            },
            fail: function(e) {
                console.log("跳转失败");
            }
        });
    },
    goDetails: function(e) {
        wx.navigateTo({
            url: "psDetails/psDetails"
        });
    },
    formid_one: function(e) {
        console.log("搜集第一个formid"), console.log(e), app.util.request({
            url: "entry/wxapp/SaveFormid",
            showLoading: !1,
            cachetime: "0",
            data: {
                user_id: wx.getStorageSync("users").id,
                form_id: e.detail.formId,
                openid: wx.getStorageSync("openid")
            },
            success: function(e) {}
        });
    },
    onShow: function() {
        var t = this;
        app.func.islogin(app, t), t.getActive(), t.getOrders(), app.util.request({
            url: "entry/wxapp/Plugin",
            data: {
                type: 5
            },
            showLoading: !1,
            success: function(e) {
                2 != e.data && e.data && t.getRpOrders();
            }
        });
        var e = t.data.options;
        e.d_user_id && app.distribution.distribution_parsent(app, e.d_user_id), t.getFree(), 
        t.GetVip(), app.util.request({
            url: "entry/wxapp/Getuser",
            showLoading: !1,
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(e) {
                2 == e.data ? t.setData({
                    phoneGrant: !0
                }) : t.setData({
                    phoneGrant: !1
                });
            }
        });
    },
    onReady: function() {},
    onUnload: function() {
        clearTimeout(app.globalData.timer_slideupshoworder);
    },
    GetVip: function() {
        var t = this, e = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/ISVIP",
            showLoading: !1,
            data: {
                openid: e
            },
            success: function(e) {
                wx.setStorageSync("viptype", e.data), t.setData({
                    viptype: e.data
                });
            }
        });
    },
    onPullDownRefresh: function() {
        this.onShow(), wx.stopPullDownRefresh();
    },
    callphone: function(e) {
        var t = e.currentTarget.dataset.phone;
        wx.makePhoneCall({
            phoneNumber: t
        });
    },
    getUrl: function() {
        var t = this, a = app.getSiteUrl("index-get");
        a ? t.setData({
            url: a
        }) : app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            showLoading: !1,
            success: function(e) {
                wx.setStorageSync("url", e.data), a = e.data, t.setData({
                    url: a
                });
            }
        });
    },
    getActive: function() {
        var s = this;
        wx.getLocation({
            type: "wgs84",
            success: function(e) {
                var t = e.latitude, a = e.longitude;
                wx.setStorageSync("location", e), app.util.request({
                    url: "entry/wxapp/Activity",
                    showLoading: !1,
                    data: {
                        lat: t,
                        lon: a,
                        openid: wx.getStorageSync("openid")
                    },
                    success: function(e) {
                        if (console.log("活动数据"), console.log(e), e.data.activeList_three) {
                            var t = e.data.activeList_three;
                            s.setData({
                                activeList_three: t
                            });
                        } else if (e.data.activeList_four) {
                            var a = e.data.activeList_four;
                            s.setData({
                                activeList_four: a
                            });
                        } else {
                            for (var n = e.data.activeList, o = e.data.activeList_two, i = {}, r = 0; r < n.length; r++) (i = n[r]).n = 0, 
                            n[r] = i;
                            s.setData({
                                activeList: n,
                                activeList_two: o
                            });
                        }
                    }
                });
            },
            fail: function(e) {
                wx.getSetting({
                    success: function(e) {
                        e.authSetting["scope.userLocation"] || (console.log("进入信息授权开关页面"), wx.openSetting({
                            success: function(e) {
                                console.log("openSetting success", e.authSetting);
                            }
                        }));
                    }
                });
            }
        });
    },
    getFree: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/Free",
            showLoading: !1,
            data: {
                page: 0,
                openid: wx.getStorageSync("openid")
            },
            success: function(e) {
                console.log("会员优惠券"), console.log(e.data), 2 == e.data ? t.setData({
                    welfareList: []
                }) : t.setData({
                    welfareList: e.data,
                    page: 1
                });
            }
        });
    },
    onReachBottom: function() {
        var n = this, o = n.data.page, i = n.data.activeList_four, r = n.data.currenttab, e = n.data.showcheck, t = n.data.indexstyle;
        0 == e && 3 == t && wx.getLocation({
            type: "wgs84",
            success: function(e) {
                var t = e.latitude, a = e.longitude;
                app.util.request({
                    url: "entry/wxapp/Activity",
                    showLoading: !1,
                    data: {
                        page: o,
                        lat: t,
                        lon: a,
                        typeid: r,
                        openid: wx.getStorageSync("openid")
                    },
                    success: function(e) {
                        if (console.log("上拉数据"), console.log(e), 0 < e.data.activeList_four[2].goods.length) {
                            var t = e.data.activeList_four[2].goods;
                            i[2].goods = i[2].goods.concat(t), n.setData({
                                activeList_four: i,
                                page: o + 1
                            });
                        } else wx.showToast({
                            title: "已经没有内容了哦！！！",
                            icon: "none"
                        });
                    }
                });
            },
            fail: function(e) {
                wx.getSetting({
                    success: function(e) {
                        e.authSetting["scope.userLocation"] || (console.log("进入信息授权开关页面"), wx.openSetting({
                            success: function(e) {
                                console.log("openSetting success", e.authSetting);
                            }
                        }));
                    }
                });
            }
        });
    },
    onShareAppMessage: function(e) {
        return {
            path: "/mzhk_sun/pages/index/index?d_user_id=" + wx.getStorageSync("users").id
        };
    }
}, "callphone", function(e) {
    var t = e.currentTarget.dataset.phone;
    wx.makePhoneCall({
        phoneNumber: t
    });
}), _defineProperty(_Page, "toCards", function(e) {
    wx.navigateTo({
        url: "cards/cards"
    });
}), _defineProperty(_Page, "toBargain", function(e) {
    wx.navigateTo({
        url: "bargain/bargain"
    });
}), _defineProperty(_Page, "toTimebuy", function(e) {
    wx.navigateTo({
        url: "timebuy/timebuy"
    });
}), _defineProperty(_Page, "toGroup", function(e) {
    wx.navigateTo({
        url: "group/group"
    });
}), _defineProperty(_Page, "toMember", function(e) {
    wx.navigateTo({
        url: "../member/member"
    });
}), _defineProperty(_Page, "togroupdet", function(e) {
    wx.navigateTo({
        url: "groupdet/groupdet"
    });
}), _defineProperty(_Page, "tocardsdet", function(e) {
    wx.navigateTo({
        url: "cardsdet/cardsdet"
    });
}), _defineProperty(_Page, "toPackage", function(e) {
    wx.navigateTo({
        url: "package/package"
    });
}), _defineProperty(_Page, "toBardet", function(e) {
    wx.navigateTo({
        url: "bardet/bardet"
    });
}), _defineProperty(_Page, "toFree", function(e) {
    wx.navigateTo({
        url: "free/free"
    });
}), _defineProperty(_Page, "toNews", function() {
    wx.navigateTo({
        url: "news/news"
    });
}), _defineProperty(_Page, "putongbon", function(e) {
    var t = e.currentTarget.dataset.id;
    wx.navigateTo({
        url: "../index/goods/goods?gid=" + t
    });
}), _defineProperty(_Page, "ptbon", function(e) {
    var t = e.currentTarget.dataset.id;
    wx.navigateTo({
        url: "../index/groupdet/groupdet?id=" + t
    });
}), _defineProperty(_Page, "kjbon", function(e) {
    var t = e.currentTarget.dataset.id;
    console.log(t), wx.navigateTo({
        url: "../index/bardet/bardet?id=" + t
    });
}), _defineProperty(_Page, "qgbon", function(e) {
    var t = e.currentTarget.dataset.id;
    wx.navigateTo({
        url: "../index/package/package?id=" + t
    });
}), _defineProperty(_Page, "mdbon", function(e) {
    var t = e.currentTarget.dataset.id;
    wx.navigateTo({
        url: "../index/freedet/freedet?id=" + t
    });
}), _defineProperty(_Page, "jkbon", function(e) {
    var t = e.currentTarget.dataset.id;
    wx.navigateTo({
        url: "../index/cardsdet/cardsdet?gid=" + t
    });
}), _defineProperty(_Page, "toWelfare", function(e) {
    var t = e.currentTarget.dataset.id;
    console.log(t), wx.navigateTo({
        url: "welfare/welfare?id=" + t
    });
}), _defineProperty(_Page, "ckbon", function(e) {
    var t = e.currentTarget.dataset.id;
    wx.navigateTo({
        url: "/mzhk_sun/plugin2/secondary/detail/detail?id=" + t
    });
}), _defineProperty(_Page, "gotoadinfo", function(e) {
    var t = e.currentTarget.dataset.tid, a = e.currentTarget.dataset.id, n = e.currentTarget.dataset.url;
    console.log(n), console.log(t), console.log(a), app.func.gotourl(app, t, a, this);
}), _defineProperty(_Page, "gotoimgUrls", function(e) {
    var t = e.currentTarget.dataset.tyid, a = e.currentTarget.dataset.gid;
    console.log(t + "--" + a);
    var n = "";
    2 == t ? n = "/mzhk_sun/pages/index/bargain/bargain" : 3 == t ? n = "/mzhk_sun/pages/index/cards/cards" : 4 == t ? n = "/mzhk_sun/pages/index/timebuy/timebuy" : 5 == t ? n = "/mzhk_sun/pages/index/group/group" : 6 == t ? n = "/mzhk_sun/pages/index/shop/shop?id=" + a : 7 == t ? n = "/mzhk_sun/pages/index/bardet/bardet?id=" + a : 8 == t ? n = "/mzhk_sun/pages/index/cardsdet/cardsdet?id=" + a : 9 == t ? n = "/mzhk_sun/pages/index/package/package?id=" + a : 10 == t ? n = "/mzhk_sun/pages/index/groupdet/groupdet?id=" + a : 11 == t && (n = "/mzhk_sun/pages/index/welfare/welfare?id=" + a), 
    "" != n && wx.navigateTo({
        url: n
    });
}), _defineProperty(_Page, "gotopopurl", function(e) {
    var t = e.currentTarget.dataset.pop_urltype, a = e.currentTarget.dataset.pop_urltxt, n = "";
    2 == t ? n = "/mzhk_sun/pages/index/bargain/bargain" : 3 == t ? n = "/mzhk_sun/pages/index/cards/cards" : 4 == t ? n = "/mzhk_sun/pages/index/timebuy/timebuy" : 5 == t ? n = "/mzhk_sun/pages/index/group/group" : 6 == t ? n = "/mzhk_sun/pages/index/shop/shop?id=" + a : 7 == t ? n = "/mzhk_sun/pages/index/bardet/bardet?id=" + a : 8 == t ? n = "/mzhk_sun/pages/index/cardsdet/cardsdet?id=" + a : 9 == t ? n = "/mzhk_sun/pages/index/package/package?id=" + a : 10 == t ? n = "/mzhk_sun/pages/index/groupdet/groupdet?id=" + a : 11 == t && (n = "/mzhk_sun/pages/index/welfare/welfare?id=" + a), 
    "" != n && wx.navigateTo({
        url: n
    });
}), _defineProperty(_Page, "updateUserInfo", function(e) {
    app.wxauthSetting();
}), _defineProperty(_Page, "showSearch", function(e) {
    this.setData({
        showSearch: !0
    });
}), _defineProperty(_Page, "hideSearch", function(e) {
    this.setData({
        showSearch: !1
    });
}), _defineProperty(_Page, "onHide", function() {
    this.hideSearch();
}), _defineProperty(_Page, "getSearch", function(e) {
    this.setData({
        searchCont: e.detail.value
    });
}), _defineProperty(_Page, "searchkeyword", function(e) {
    var a = this, t = e.currentTarget.dataset.word;
    if ("" == t) return wx.showModal({
        title: "提示",
        content: "参数错误",
        showCancel: !1
    }), !1;
    var n = wx.getStorageSync("goodskeyword"), o = 0;
    if (n) {
        for (var i = [], r = [], s = 0, d = 0; d < n.length; d++) n[d] != t && (r[s] = n[d], 
        s++);
        o = 4 < r.length ? 4 : r.length;
        for (d = 0; d < o; d++) i[d] = r[d];
        i.unshift(t);
    } else i = [ t ];
    wx.setStorageSync("goodskeyword", i), a.setData({
        searchCont: t,
        kw: i
    }), app.util.request({
        url: "entry/wxapp/Sactives",
        data: {
            gname: t
        },
        success: function(e) {
            console.log("活动数据"), console.log(e);
            var t = e.data;
            2 != t ? a.setData({
                bargain: t
            }) : a.setData({
                bargain: []
            });
        }
    });
}), _defineProperty(_Page, "commitSearch", function(e) {
    var a = this, t = this.data.searchCont;
    if ("" == t) return wx.showModal({
        title: "提示",
        content: "请输入要搜索的商品名称",
        showCancel: !1
    }), !1;
    var n = wx.getStorageSync("goodskeyword"), o = 0;
    if (console.log(n), n) {
        for (var i = [], r = [], s = 0, d = 0; d < n.length; d++) n[d] != t && (r[s] = n[d], 
        s++);
        o = 4 < r.length ? 4 : r.length;
        for (d = 0; d < o; d++) i[d] = r[d];
        i.unshift(t);
    } else i = [ t ];
    wx.setStorageSync("goodskeyword", i), a.setData({
        kw: i
    }), app.util.request({
        url: "entry/wxapp/Sactives",
        data: {
            gname: t,
            openid: wx.getStorageSync("openid")
        },
        success: function(e) {
            console.log("活动数据"), console.log(e);
            var t = e.data;
            2 != t ? a.setData({
                bargain: t
            }) : a.setData({
                bargain: []
            });
        }
    });
}), _defineProperty(_Page, "getcurrentcity", function() {
    var o = this;
    wx.getLocation({
        success: function(e) {
            var t = e.latitude, a = e.longitude, n = wx.getStorageSync("System").developkey;
            o.getcity(t, a, n);
        }
    });
}), _defineProperty(_Page, "getcity", function(e, t, a) {
    var s = this, n = require("../../sdk/qqmap/qqmap-wx.js");
    a && new n({
        key: a
    }).reverseGeocoder({
        location: {
            latitude: e,
            longitude: t
        },
        success: function(e) {
            var t = e.result.ad_info.province, a = e.result.ad_info.city, n = e.result.ad_info.district, o = e.result.ad_info.location.lat, i = e.result.ad_info.location.lng, r = wx.getStorageSync("openid");
            app.util.request({
                url: "entry/wxapp/Setcurrentcity",
                data: {
                    province: t,
                    city: a,
                    district: n,
                    lat: o,
                    lng: i,
                    openid: r
                },
                success: function(e) {
                    s.data.currentcity;
                    wx.setStorageSync("currentcity", e.data.currentcity), s.setData({
                        currentcity: e.data.currentcity
                    });
                }
            });
        },
        fail: function(e) {
            console.log(e);
        },
        complete: function(e) {
            console.log(e);
        }
    });
}), _defineProperty(_Page, "getPhoneNumber", function(e) {
    var t = this, a = wx.getStorageSync("key"), n = wx.getStorageSync("users");
    t.data.opentel;
    a && app.util.request({
        url: "entry/wxapp/decrypt",
        cachetime: "0",
        data: {
            data: e.detail.encryptedData,
            iv: e.detail.iv,
            key: a
        },
        success: function(e) {
            e.data.phoneNumber && (t.setData({
                cardNum: e.data.phoneNumber,
                phoneGrant: !1,
                opentel: !1
            }), app.util.request({
                url: "entry/wxapp/UpdateUser",
                cachetime: "0",
                data: {
                    id: n.id,
                    tel: e.data.phoneNumber
                },
                success: function(e) {
                    e ? wx.setStorageSync("users", e.data) : wx.reLaunch({
                        url: "/mzhk_sun/pages/index/index"
                    });
                }
            }));
        }
    });
}), _defineProperty(_Page, "getcurrentindex", function(e) {
    this.data.currentindex;
    var t = e.detail.current;
    (e.detail.source = "touch") && this.setData({
        currentindex: t + 1
    });
}), _defineProperty(_Page, "toZhuanti", function(e) {
    var t = e.currentTarget.dataset.id;
    wx.navigateTo({
        url: "../index/article/article?id=" + t
    });
}), _defineProperty(_Page, "toDetail", function(e) {
    var t = parseInt(e.currentTarget.dataset.id), a = parseInt(e.currentTarget.dataset.bid);
    wx.navigateTo({
        url: "/mzhk_sun/plugin/fission/detail/detail?id=" + t + "&bid=" + a
    });
}), _defineProperty(_Page, "toFassion", function(e) {
    wx.navigateTo({
        url: "/mzhk_sun/plugin/fission/index/index"
    });
}), _defineProperty(_Page, "toIsbusiness", function(e) {
    var t = e.currentTarget.dataset.index;
    wx.navigateTo({
        url: "/mzhk_sun/pages/index/sbusiness/sbusiness?index=" + t
    });
}), _defineProperty(_Page, "onTab", function(e) {
    var n = this, o = parseInt(e.currentTarget.dataset.tabid);
    n.data.page;
    wx.getLocation({
        type: "wgs84",
        success: function(e) {
            var t = e.latitude, a = e.longitude;
            app.util.request({
                url: "entry/wxapp/Activity",
                showLoading: !1,
                data: {
                    lat: t,
                    lon: a,
                    typeid: o,
                    openid: wx.getStorageSync("openid")
                },
                success: function(e) {
                    if (console.log("活动数据"), console.log(e), e.data.activeList_four) {
                        var t = e.data.activeList_four;
                        n.setData({
                            activeList_four: t,
                            currenttab: o,
                            page: 1
                        });
                    }
                }
            });
        },
        fail: function(e) {
            wx.getSetting({
                success: function(e) {
                    e.authSetting["scope.userLocation"] || (console.log("进入信息授权开关页面"), wx.openSetting({
                        success: function(e) {
                            console.log("openSetting success", e.authSetting);
                        }
                    }));
                }
            });
        }
    });
}), _defineProperty(_Page, "rotationEvents", function(e) {
    this.setData({
        banIndex: e.detail.current + 1
    });
}), _defineProperty(_Page, "getOrders", function() {
    var t = this;
    t.data.orders;
    app.util.request({
        url: "entry/wxapp/getOrders",
        showLoading: !1,
        data: {
            openid: wx.getStorageSync("openid")
        },
        success: function(e) {
            0 < e.data ? t.setData({
                orders: e.data
            }) : t.setData({
                orders: 0
            });
        }
    });
}), _defineProperty(_Page, "toUser", function(e) {
    wx.reLaunch({
        url: "/mzhk_sun/pages/user/user"
    });
}), _defineProperty(_Page, "getRpOrders", function() {
    var t = this;
    t.data.rporders;
    app.util.request({
        url: "entry/wxapp/getRpOrders",
        showLoading: !1,
        data: {
            openid: wx.getStorageSync("openid")
        },
        success: function(e) {
            console.log(e.data), 0 < e.data ? t.setData({
                rporders: e.data
            }) : t.setData({
                rporders: 0
            });
        }
    });
}), _defineProperty(_Page, "toMyRp", function(e) {
    wx.navigateTo({
        url: "/mzhk_sun/plugin/redpacket/packageList/packageList"
    });
}), _defineProperty(_Page, "formSubmit", function(e) {
    var t = wx.getStorageSync("openid"), a = e.detail.value.gid, n = e.detail.formId;
    app.util.request({
        url: "entry/wxapp/SetQgFormid",
        showLoading: !1,
        data: {
            gid: a,
            formId: n,
            openid: t
        },
        success: function(e) {
            console.log(e.data), 2 != e.data ? wx.showModal({
                title: "提示",
                content: "开启成功",
                success: function(e) {
                    e.confirm ? wx.reLaunch({
                        url: "/mzhk_sun/pages/index/index"
                    }) : e.cancel && wx.reLaunch({
                        url: "/mzhk_sun/pages/index/index"
                    });
                }
            }) : wx.showModal({
                title: "提示",
                content: "开启失败",
                showCancel: !1
            });
        }
    });
}), _defineProperty(_Page, "toActive", function(e) {
    wx.reLaunch({
        url: "/mzhk_sun/pages/active/active"
    });
}), _defineProperty(_Page, "toCoupon", function(e) {
    wx.navigateTo({
        url: "../index/coupon/coupon"
    });
}), _Page));