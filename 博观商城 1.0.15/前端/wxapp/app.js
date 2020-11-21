var e = require("boguan_mall/utils/token.js"), t = require("api.js"), a = new e.Token();

App({
    onLaunch: function() {
        this.siteinfo(), this.version(), a.verify(this.globalData.api_root);
    },
    onShow: function() {},
    onHide: function() {},
    onError: function(e) {
        console.log(e);
    },
    onPageNotFound: function(e) {},
    pageOnLoad: function() {
        this.getTabBar(), this.getInformation();
    },
    updateToken: function(e) {
        a.getTokenFromServer(this.globalData.api_root, function(t) {
            console.log("token更新", t), e && e(t);
        });
    },
    version: function() {
        if (wx.canIUse("getUpdateManager")) {
            var e = wx.getUpdateManager();
            e.onCheckForUpdate(function(t) {
                t.hasUpdate && (e.onUpdateReady(function() {
                    wx.showModal({
                        title: "更新提示",
                        content: "新版本已经准备好，是否启用？",
                        showCancel: !1,
                        success: function(t) {
                            t.confirm && e.applyUpdate();
                        }
                    });
                }), e.onUpdateFailed(function() {
                    wx.showModal({
                        title: "提示",
                        content: "新版本已经上线啦，请您删除当前小程序，重新搜索打开"
                    });
                }));
            });
        } else wx.showModal({
            title: "提示",
            content: "当前微信版本过低，无法使用该功能，请升级到最新微信版本后重试。"
        });
    },
    getTabBar: function() {
        var e = this;
        wx.getStorageSync("tabbar") && this.editTabBar(), wx.request({
            url: this.globalData.api_root + t.default.navBottom,
            data: {},
            method: "POST",
            header: {
                "content-type": "application/json",
                token: wx.getStorageSync("token"),
                uniacid: this.siteInfo.uniacid
            },
            success: function(t) {
                wx.setStorageSync("tabbar", t.data.data), e.editTabBar();
            }
        });
    },
    editTabBar: function(e) {
        (e = wx.getStorageSync("tabbar")).backHome = !1;
        var t = getCurrentPages(), a = [], o = t[t.length - 1], n = o.options, i = o.__route__;
        0 != i.indexOf("/") && (i = "/" + i);
        for (var s in e.list) if (-1 != e.list[s].pagePath.indexOf("?") && (a[s] = e.list[s].pagePath, 
        e.list[s].pagePath = e.list[s].pagePath.split("?")[0]), e.list[s].selected = !1, 
        e.list[s].pagePath == i && n.plinkId == Number(s) + 1 || "/boguan_mall/pages/Tab/index/index" == i) {
            e.list[s].selected = !0;
            break;
        }
        for (var r in this.tabbarPages) if (i == this.tabbarPages[r]) {
            e.tabbarOpen = !0;
            break;
        }
        for (var l in this.detailsPages) if (i == this.detailsPages[l] && t.length <= 1 && 0 == e.switch) {
            e.backHome = !0;
            break;
        }
        for (var s in e.list) if (e.navs = !1, i == e.list[s].pagePath) {
            e.navs = !0;
            break;
        }
        if (a.length > 0) for (var c in a) for (var s in e.list) s == c && (e.list[s].pagePath = a[c]);
        o.setData({
            tabbar: e
        });
    },
    tabbarPages: [ "/boguan_mall/pages/Tab/index/index", "/boguan_mall/pages/Tab/category/category", "/boguan_mall/pages/Tab/cart/cart", "/boguan_mall/pages/Tab/user/user", "/boguan_mall/pages/Home/new_list/new_list", "/boguan_mall/pages/Tab/index_diy/index_diy", "/boguan_mall/pages/Home/list/list", "/boguan_mall/pages/Home/coupon/coupon_list/coupon_list", "/boguan_mall/pages/User/collection/collection", "/boguan_mall/pages/User/footprint/footprint", "/boguan_mall/pages/User/order/order/order", "/boguan_mall/pages/User/help/help" ],
    detailsPages: [ "/boguan_mall/pages/Home/address/address", "/boguan_mall/pages/Home/goods/goods", "/boguan_mall/pages/Home/new_detail/new_detail", "/boguan_mall/pages/Home/coupon/coupon_card/coupon_card", "/boguan_mall/pages/User/helpdetail/helpdetail", "/boguan_mall/pages/Tab/index_diy/index_diy" ],
    navClick: function(e, t) {
        var a = e.currentTarget.dataset.linktype, o = e.currentTarget.dataset.url, n = e.currentTarget.dataset.type || "", i = e.currentTarget.dataset.appid, s = e.currentTarget.dataset.path;
        if ("phone" == a) wx.makePhoneCall({
            phoneNumber: o
        }); else if ("appid" == a) wx.navigateToMiniProgram({
            appId: i,
            path: s
        }); else if ("coordinates" == a) {
            var r = o.split("&#amp"), l = r[0].split(",");
            wx.openLocation({
                longitude: parseFloat(l[0]),
                latitude: parseFloat(l[1]),
                name: r[1],
                address: r[2]
            });
        } else "copy" == a ? wx.setClipboardData({
            data: o
        }) : "" != o && ("redirect" == n ? wx.redirectTo({
            url: o
        }) : wx.navigateTo({
            url: o
        }));
    },
    getUserInfo: function(e) {
        wx.login({
            success: function(e) {
                e.code;
                wx.getSetting({
                    success: function(e) {
                        e.authSetting["scope.userInfo"] ? wx.getUserInfo({
                            success: function(e) {
                                wx.setStorageSync("userInfo", e.userInfo);
                            }
                        }) : wx.redirectTo({
                            url: "/boguan_mall/pages/Tab/login/login"
                        });
                    },
                    fail: function(e) {}
                });
            }
        });
    },
    userInfoAuth: function(e) {
        wx.login({
            success: function(t) {
                t.code;
                wx.getSetting({
                    success: function(t) {
                        t.authSetting["scope.userInfo"] ? ("function" == typeof e && e(!0), wx.getUserInfo({
                            success: function(e) {
                                wx.setStorageSync("userInfo", e.userInfo);
                            }
                        })) : "function" == typeof e && e(!1);
                    }
                });
            }
        });
    },
    getUserLocation: function(e, t) {
        wx.getSetting({
            success: function(a) {
                console.log("res=》", a.authSetting[e]), a.authSetting[e] ? "function" == typeof t && t(!0) : "function" == typeof t && t(!1);
            }
        });
    },
    getSystemInfo: function() {
        wx.getSystemInfo({
            success: function(e) {
                console.log(e), wx.setStorageSync("SystemInfo", e);
            }
        });
    },
    siteInfo: require("siteinfo.js"),
    siteinfo: function() {
        var e = this.siteInfo.siteroot.replace("app/index.php", "");
        e += "addons/boguan_mall/boguan/index.php/api/v1/", this.globalData.api_root = e, 
        this.globalData.uniacid = this.siteInfo.uniacid;
    },
    getInformation: function(e) {
        wx.request({
            url: this.globalData.api_root + t.default.store_info,
            data: {},
            method: "POST",
            header: {
                "content-type": "application/json",
                token: wx.getStorageSync("token"),
                uniacid: this.siteInfo.uniacid
            },
            success: function(t) {
                console.log("商城基本信息=>", t.data.data), e && e(t.data.data), 1 == t.data.errorCode && wx.setStorage({
                    key: "store_info",
                    data: t.data.data
                });
            }
        });
    },
    bind: function(t) {
        console.log("参数", t);
        var a = wx.getStorageSync("token") || "";
        "-1" != t && (a ? getApp().bindParent(t) : (new e.Token().verify(this.globalData.api_root), 
        getApp().bindParent(t)));
    },
    bindParent: function(e) {
        console.log("转码后的参数", decodeURIComponent(e));
        var a = [], o = decodeURIComponent(e).split("&");
        for (var n in o) {
            var i = o[n].split("=");
            a.push(i);
        }
        var s = {};
        for (var r in a) s = {
            parentId: a[0][1],
            id: a[1][1],
            type: a[2][1]
        };
        console.log("转码后的参数obj", s), "undefined" != s.parentId && "" != s.parentId && wx.request({
            url: this.globalData.api_root + t.default.bind_parent,
            data: {
                parentId: s.parentId
            },
            header: {
                "content-type": "application/json",
                token: wx.getStorageSync("token"),
                uniacid: this.siteInfo.uniacid
            },
            method: "GET",
            success: function(e) {
                console.log("绑定情况=>", e.data);
            },
            fail: function(e) {
                console.log("绑定失败=>", e);
            }
        });
    },
    globalData: {
        userInfo: null,
        tipHidden: !1,
        api_root: null,
        uniacid: null,
        tabbar: {
            backHome: !1,
            defaultColor: "#999999",
            selectedColor: "#ad0e11",
            bgColor: "#ffffff",
            tabbarOpen: !1,
            navs: !1,
            list: [],
            position: "bottom"
        }
    }
});