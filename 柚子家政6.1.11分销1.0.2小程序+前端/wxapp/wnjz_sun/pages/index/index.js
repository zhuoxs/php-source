var app = getApp(), Page = require("../../../zhy/sdk/qitui/oddpush.js").oddPush(Page).Page;

Page({
    data: {
        imgUrls: [],
        indicatorDots: !1,
        autoplay: !1,
        interval: 3e3,
        duration: 800,
        url: [],
        hot: [],
        order: [],
        hidden: !0,
        jszc: {
            js_name: "",
            js_logo: "",
            js_tel: ""
        },
        is_modal_Hidden: !0,
        showdefaultnav: !1,
        isIpx: app.globalData.isIpx,
        whichone: 1
    },
    onLoad: function(t) {
        app.editTabBar(), wx.showLoading({
            title: "加载中"
        });
        var o = this;
        console.log(t.scene), t = app.func.decodeScene(t), o.setData({
            options: t
        }), wx.setNavigationBarTitle({
            title: o.data.navTile
        }), o.getUrl();
        var n = wx.getStorageSync("openid"), e = wx.getStorageSync("isSwitch");
        if (console.log(e), 1 == e) var s = 1; else s = 2;
        wx.setStorageSync("Switch", s), wx.getLocation({
            type: "gcj02",
            success: function(t) {
                var e = t.latitude, a = t.longitude;
                app.util.request({
                    url: "entry/wxapp/CurrentBranch",
                    cachetime: "0",
                    data: {
                        openid: n,
                        latitude: e,
                        longitude: a,
                        Switch: s
                    },
                    success: function(t) {
                        var e = t.data.id;
                        app.util.request({
                            url: "entry/wxapp/Fuwu",
                            data: {
                                build_id: e
                            },
                            success: function(t) {
                                console.log(t.data), o.setData({
                                    order: t.data
                                }), o.getnewdr(), o.getBannerd(), o.getIngreat(), o.tab(), o.indexTan();
                            }
                        }), o.setData({
                            Branch: t.data
                        }), wx.setStorageSync("build_id", t.data.id);
                    }
                });
            },
            fail: function(t) {
                console.log("获取地址失败"), wx.getSetting({
                    success: function(t) {
                        t.authSetting["scope.address"] || (console.log("进入信息授权开关页面"), wx.openSetting({
                            success: function(t) {
                                console.log("openSetting success", t.authSetting);
                            }
                        }));
                    }
                });
            }
        }), o.wxauthSetting(), app.util.request({
            url: "entry/wxapp/system",
            cachetime: "0",
            success: function(t) {
                console.log(t.data), "" != t.data.js_tel && null != t.data.js_tel && (o.data.jszc.js_tel = t.data.js_tel), 
                "" != t.data.js_name && null != t.data.js_name && (o.data.jszc.js_name = t.data.js_name), 
                "" != t.data.js_logo && null != t.data.js_logo && (o.data.jszc.js_logo = t.data.js_logo), 
                console.log(o.data.jszc), o.setData({
                    shop: t.data,
                    jszc: o.data.jszc
                });
                t.data.pt_name ? wx.setNavigationBarTitle({
                    title: t.data.pt_name
                }) : wx.setNavigationBarTitle({
                    title: "首页"
                }), wx.setStorageSync("system", t.data), wx.setStorageSync("color", t.data.color), 
                wx.setStorageSync("fontcolor", t.data.fontcolor), wx.setNavigationBarColor({
                    frontColor: wx.getStorageSync("fontcolor"),
                    backgroundColor: wx.getStorageSync("color"),
                    animation: {
                        duration: 0,
                        timingFunc: "easeIn"
                    }
                }), o.setData({
                    jikaopen: t.data.is_jkopen
                });
            }
        });
    },
    onReady: function() {
        app.getNavList("");
    },
    onShow: function() {
        var t = this.data.options;
        t.d_user_id && app.distribution.distribution_parsent(app, t.d_user_id), this.setData({
            showAd: app.globalData.showAd
        });
    },
    gotoUrl: function(t) {
        var e = t.currentTarget.dataset.url, a = t.currentTarget.dataset.gotype;
        app.func.gotoUrl(app, this, e, a, []);
    },
    tab: function() {
        var e = this, a = app.globalData.tabBar, o = a.list, n = e.data.url;
        app.util.request({
            url: "entry/wxapp/Tab",
            cachetime: "0",
            success: function(t) {
                console.log(t.data), wx.setStorageSync("tab", t.data), o[0].text = t.data.index, 
                o[0].iconPath = n + t.data.indeximg, o[0].selectedIconPath = n + t.data.indeximgs, 
                o[1].text = t.data.coupon, o[1].iconPath = n + t.data.couponimg, o[1].selectedIconPath = n + t.data.couponimgs, 
                o[2].text = t.data.fans, o[2].iconPath = n + t.data.fansimg, o[2].selectedIconPath = n + t.data.fansimgs, 
                o[3].text = t.data.mine, o[3].iconPath = n + t.data.mineimg, o[3].selectedIconPath = n + t.data.mineimgs, 
                console.log(o), a.list = o, e.setData({
                    tabBar: a
                });
            }
        });
    },
    getnewdr: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/new",
            success: function(t) {
                console.log(t.data), e.setData({
                    notice: t.data
                });
            }
        });
    },
    getBannerd: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/Banner",
            cachetime: "30",
            success: function(t) {
                console.log(t.data), e.setData({
                    imgUrls: t.data
                });
            }
        });
    },
    getIngreat: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/Demand",
            success: function(t) {
                e.setData({
                    hot: t.data
                });
            }
        });
    },
    getUrl: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/url",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url", t.data), e.setData({
                    url: t.data
                });
            }
        });
    },
    indexTan: function(t) {
        var e = this;
        app.util.request({
            url: "entry/wxapp/IndexTan",
            cachetime: "0",
            success: function(t) {
                console.log(t.data), e.setData({
                    indexTan: t.data
                });
            }
        });
    },
    wxauthSetting: function(t) {
        var s = this;
        wx.getStorageSync("openid") ? wx.getSetting({
            success: function(t) {
                console.log("进入wx.getSetting 1"), console.log(t), t.authSetting["scope.userInfo"] ? (console.log("scope.userInfo已授权 1"), 
                wx.getUserInfo({
                    success: function(t) {
                        s.setData({
                            is_modal_Hidden: !0,
                            thumb: t.userInfo.avatarUrl,
                            nickname: t.userInfo.nickName
                        });
                    }
                })) : (console.log("scope.userInfo没有授权 1"), wx.showModal({
                    title: "获取信息失败",
                    content: "请允许授权以便为您提供给服务",
                    success: function(t) {
                        s.setData({
                            is_modal_Hidden: !1
                        });
                    }
                }));
            },
            fail: function(t) {
                console.log("获取权限失败 1"), s.setData({
                    is_modal_Hidden: !1
                });
            }
        }) : wx.login({
            success: function(t) {
                console.log("进入wx-login");
                var e = t.code;
                wx.setStorageSync("code", e), wx.getSetting({
                    success: function(t) {
                        console.log("进入wx.getSetting"), console.log(t), t.authSetting["scope.userInfo"] ? (console.log("scope.userInfo已授权"), 
                        wx.getUserInfo({
                            success: function(t) {
                                s.setData({
                                    is_modal_Hidden: !0,
                                    thumb: t.userInfo.avatarUrl,
                                    nickname: t.userInfo.nickName
                                }), console.log("进入wx-getUserInfo"), console.log(t.userInfo), wx.setStorageSync("user_info", t.userInfo);
                                var a = t.userInfo.nickName, o = t.userInfo.avatarUrl, n = t.userInfo.gender;
                                app.util.request({
                                    url: "entry/wxapp/openid",
                                    cachetime: "0",
                                    data: {
                                        code: e
                                    },
                                    success: function(t) {
                                        console.log("进入获取openid"), console.log(t.data), wx.setStorageSync("key", t.data.session_key), 
                                        wx.setStorageSync("openid", t.data.openid);
                                        var e = t.data.openid;
                                        wx.setStorage({
                                            key: "openid",
                                            data: e
                                        }), app.util.request({
                                            url: "entry/wxapp/Login",
                                            cachetime: "0",
                                            data: {
                                                openid: e,
                                                img: o,
                                                name: a,
                                                gender: n
                                            },
                                            success: function(t) {
                                                console.log("进入地址login"), console.log(t.data), wx.setStorageSync("users", t.data), 
                                                wx.setStorageSync("uniacid", t.data.uniacid), s.setData({
                                                    usersinfo: t.data
                                                });
                                            }
                                        });
                                    }
                                });
                            },
                            fail: function(t) {
                                console.log("进入 wx-getUserInfo 失败"), wx.showModal({
                                    title: "获取信息失败",
                                    content: "请允许授权以便为您提供给服务!",
                                    success: function(t) {
                                        s.setData({
                                            is_modal_Hidden: !1
                                        });
                                    }
                                });
                            }
                        })) : (console.log("scope.userInfo没有授权"), s.setData({
                            is_modal_Hidden: !1
                        }));
                    }
                });
            },
            fail: function() {
                wx.showModal({
                    title: "获取信息失败",
                    content: "请允许授权以便为您提供给服务!!!",
                    success: function(t) {
                        s.setData({
                            is_modal_Hidden: !1
                        });
                    }
                });
            }
        });
    },
    updateUserInfo: function(t) {
        console.log("授权操作更新");
        this.wxauthSetting();
    },
    indexTap: function(t) {
        var e = this.data.indexTan;
        wx.navigateTo({
            url: "/" + e.path1
        });
    },
    godetails: function(t) {
        var e = t.currentTarget.dataset.index, a = this.data.imgUrls;
        0 == e ? wx.navigateTo({
            url: "/" + a.url
        }) : 1 == e ? wx.navigateTo({
            url: "/" + a.url1
        }) : 2 == e ? wx.navigateTo({
            url: "/" + a.url2
        }) : wx.navigateTo({
            url: "/" + a.url3
        });
    },
    toBook: function(t) {
        wx.setStorageSync("keyword", ""), wx.navigateTo({
            url: "classify/classify"
        });
    },
    toSerdesc: function(t) {
        wx.navigateTo({
            url: "serdesc/serdesc"
        });
    },
    toOrder: function(t) {
        parseInt(t.target.dataset.productid);
        wx.navigateTo({
            url: "order/order"
        });
    },
    toAbout: function(t) {
        wx.navigateTo({
            url: "about/about"
        });
    },
    pay: function(t) {
        wx.navigateTo({
            url: "pay/pay"
        });
    },
    cards: function(t) {
        wx.navigateTo({
            url: "card/card"
        });
    },
    toHotser: function(t) {
        wx.navigateTo({
            url: "hotser/hotser"
        });
    },
    toArticle: function(t) {
        wx.navigateTo({
            url: "article/article"
        });
    },
    onShareAppMessage: function(t) {
        return {
            path: "/wnjz_sun/pages/index/index?d_user_id=" + wx.getStorageSync("users").id
        };
    },
    isLogin: function(t) {
        this.data.isLogin;
        this.setData({
            isLogin: !1
        });
    },
    dialogYZ: function(t) {
        null == this.data.shop.js_tel || "" == this.data.shop.js_tel ? wx.makePhoneCall({
            phoneNumber: "0592-666666"
        }) : wx.makePhoneCall({
            phoneNumber: this.data.shop.js_tel
        });
    },
    closeAd: function(t) {
        app.globalData.showAd = !0, this.onShow();
    },
    toMap: function(t) {
        var e = parseFloat(t.currentTarget.dataset.lat), a = parseFloat(t.currentTarget.dataset.lng);
        wx.getLocation({
            type: "gcj02",
            success: function(t) {
                wx.openLocation({
                    latitude: e,
                    longitude: a,
                    scale: 28
                });
            }
        });
    },
    inputFocus: function(t) {
        console.log(t.detail.value), this.setData({
            keyword: t.detail.value
        });
    },
    toSearch: function(t) {
        var e = this.data.keyword;
        "" == e || null == e ? wx.showToast({
            title: "请输入关键词",
            icon: "none"
        }) : (wx.setStorageSync("keyword", e), wx.navigateTo({
            url: "/wnjz_sun/pages/index/classify/classify"
        }));
    },
    kbSearch: function(t) {
        console.log(t.detail.value);
    },
    onPosterTab: function() {
        var t = wx.getStorageSync("users"), e = wx.getStorageSync("system"), a = this.data.Branch, o = [];
        o.goodspicbg = e.poster_img, o.bname = a.name, o.url = this.data.url, o.logo = a.logo, 
        o.pname = e.pt_name, o.scene = "d_user_id=" + t.id, app.creatPoster("wnjz_sun/pages/index/index", 430, o, 1, "shareImg");
    },
    createPoster: function(t) {
        console.log(t);
        var e = t.detail;
        this.setData({
            posterUrl: e.url
        }), wx.hideLoading(), console.log(5555), console.log(t.detail.url), wx.previewImage({
            current: "" + t.detail.url,
            urls: [ t.detail.url ]
        });
    },
    hidden: function(t) {
        this.setData({
            hidden: !0
        });
    },
    save: function() {
        var e = this;
        wx.saveImageToPhotosAlbum({
            filePath: e.data.prurl,
            success: function(t) {
                wx.showModal({
                    content: "图片已保存到相册，赶紧晒一下吧~",
                    showCancel: !1,
                    confirmText: "好哒",
                    confirmColor: "#ef8200",
                    success: function(t) {
                        t.confirm && (console.log("用户点击确定"), e.setData({
                            hidden: !0
                        }));
                    }
                });
            },
            fail: function(t) {
                console.log("失败"), wx.getSetting({
                    success: function(t) {
                        t.authSetting["scope.writePhotosAlbum"] || (console.log("进入信息授权开关页面"), wx.openSetting({
                            success: function(t) {
                                console.log("openSetting success", t.authSetting);
                            }
                        }));
                    }
                });
            }
        });
    }
});