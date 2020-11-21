var _data, _Page;

function _defineProperty(t, e, a) {
    return e in t ? Object.defineProperty(t, e, {
        value: a,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[e] = a, t;
}

var app = getApp(), tool = require("../../../we7/js/countDown.js"), fcdInterval = 0, fcdInterval1 = 0, fcdInterval2 = 0;

Page((_defineProperty(_Page = {
    data: (_data = {
        comeIn: !1,
        canIUse: wx.canIUse("button.open-type.getUserInfo"),
        active: "",
        clock: "",
        indicatorDots: !0,
        autoplay: !0,
        interval: 3e3,
        duration: 1e3,
        circular: !0,
        statusType: [ "热销商品", "最新上架", "距离最近" ],
        currentType: 0,
        swiperCurrent: 0,
        antime: "",
        color: "red",
        page: 0,
        colored: "black"
    }, _defineProperty(_data, "active", ""), _defineProperty(_data, "no", "http://oydnzfrbv.bkt.clouddn.com/gongzuotai.png"), 
    _defineProperty(_data, "current", 0), _defineProperty(_data, "bargainList", [ {
        endTime: "",
        clock: ""
    }, {
        endTime: "",
        clock: ""
    } ]), _defineProperty(_data, "tanchuangBan", [ "../../resource/images/first/tanchuan.png" ]), 
    _defineProperty(_data, "is_modal_Hidden", !0), _data),
    chooseAddr: function(t) {
        wx.navigateTo({
            url: "../chooseAddr/chooseAddr"
        });
    },
    getlocation: function() {
        wx.getLocation({
            success: function(t) {
                return console.log(t), t;
            },
            fail: function(t) {
                console.log("获取地址失败"), wx.getSetting({
                    success: function(t) {
                        console.log(t), t.authSetting["scope.userLocation"] || console.log("授权失败进入");
                    }
                });
            }
        });
    },
    onLoad: function(t) {
        var n = this;
        n.getlocation(), t.currCity && n.setData({
            currCity: t.currCity
        });
        var e = wx.getStorageSync("url");
        console.log(e), e ? (console.log(0xf6b75ab2bc47200), n.setData({
            url: e
        })) : app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            success: function(t) {
                wx.setStorageSync("url", t.data), n.setData({
                    url: t.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/tab",
            cachetime: "30",
            success: function(t) {
                wx.setStorageSync("tab", t.data.data), 2 == t.data ? n.setData({
                    tab: ""
                }) : n.setData({
                    tab: t.data.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/system",
            cachetime: "0",
            success: function(t) {
                console.log(t.data.is_pintuanopen), wx.setStorageSync("system", t.data), wx.setStorageSync("kanjiaopen", t.data.is_kanjiaopen), 
                wx.setStorageSync("mask", t.data.mask);
                var e = t.data.version ? t.data.version : "99999";
                if (console.log("获取版本号------------"), console.log(e), console.log(app.siteInfo.version), 
                e == app.siteInfo.version) {
                    console.log("showcheck");
                    var a = t.data.psopen;
                    console.log(a);
                } else if ("99999" == e) {
                    console.log("showcheck2");
                    a = t.data.psopen;
                    console.log(a);
                } else {
                    console.log("showcheck3");
                    a = 0;
                    console.log(a);
                }
                console.log(a), n.setData({
                    showcheck: a,
                    zxopen: t.data.is_openzx,
                    sign: t.data.sign,
                    bargainshow: t.data.is_kanjiaopen,
                    is_pintuanopen: t.data.is_pintuanopen,
                    mask: t.data.mask,
                    system: t.data
                });
                t.data.pt_name ? wx.setNavigationBarTitle({
                    title: t.data.pt_name
                }) : wx.setNavigationBarTitle({
                    title: "首页"
                }), wx.setStorageSync("color", t.data.color), wx.setStorageSync("fontcolor", t.data.fontcolor), 
                wx.setNavigationBarColor({
                    frontColor: wx.getStorageSync("fontcolor"),
                    backgroundColor: wx.getStorageSync("color"),
                    animation: {
                        duration: 0,
                        timingFunc: "easeIn"
                    }
                }), n.setData({
                    jikaopen: t.data.is_jkopen,
                    link_logo: t.data.link_logo
                });
            }
        });
        var a = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/isVip",
            cachetime: "0",
            data: {
                openid: a
            },
            success: function(t) {
                console.log("************************测试会员"), 1 == t.data ? wx.setStorageSync("is_vip", t.data) : wx.setStorageSync("is_vip", "");
            }
        });
        wx.getStorageSync("tab").indeximg;
    },
    onHide: function() {
        var t = this.data.cdInterval1;
        clearInterval(t);
        var e = this.data.cdInterval2;
        clearInterval(e);
        var a = this.data.cdInterval3;
        clearInterval(a);
    },
    partbargain: function(t) {
        1 == t.currentTarget.dataset.begintime ? wx.showToast({
            title: "活动尚未开始！",
            icon: "none"
        }) : wx.navigateTo({
            url: "../kanjia-list/details?id=" + t.currentTarget.dataset.bargainid,
            success: function(t) {},
            fail: function(t) {},
            complete: function(t) {}
        });
    },
    goToToutiao: function() {
        "2" == this.data.zxopen ? wx.showToast({
            title: "该功能未开放！",
            icon: "none"
        }) : wx.navigateTo({
            url: "../toutiao/index",
            success: function(t) {},
            fail: function(t) {},
            complete: function(t) {}
        });
    },
    tiaozhuanlianjie: function(t) {
        1 == t.currentTarget.dataset.gogogo ? wx.showToast({
            title: "活动尚未开启！",
            icon: "none"
        }) : wx.navigateTo({
            url: "../pintuan-list/details?id=" + t.currentTarget.dataset.groupsid
        });
    },
    goToJika: function() {
        1 == wx.getStorageSync("system").is_jkopen ? wx.navigateTo({
            url: "../active-list/index"
        }) : wx.showToast({
            title: "该功能未开放！",
            icon: "none"
        });
    },
    goTopintuan: function() {
        1 == wx.getStorageSync("system").is_pintuanopen ? wx.navigateTo({
            url: "../pintuan-list/index"
        }) : wx.showToast({
            title: "该功能尚未开放！",
            icon: "none"
        });
    },
    goTap: function(t) {
        this.setData({
            current: t.currentTarget.dataset.index
        }), 1 == this.data.current && wx.redirectTo({
            url: "../cheap/index?currentIndex=1"
        }), 2 == this.data.current && wx.redirectTo({
            url: "../eater-card/index?currentIndex=2"
        }), 3 == this.data.current && wx.redirectTo({
            url: "../mine/index?currentIndex=3"
        });
    },
    onShow: function() {
        var t = wx.getStorageSync("comeIn");
        this.wxauthSetting();
        var e = wx.getStorageSync("user_info");
        this.setData({
            avatarUrl: e.avatarUrl,
            comeIn: t,
            goodList: [],
            page: 0,
            currentType: 0
        }), this.getSomething(), console.log("测试先后顺序-----------------22222222222");
    },
    onReachBottom: function() {
        console.log("-----------上啦触底-------------");
        var t = this.data.page, e = this.data.typeIndex;
        t++, console.log(e), this.setData({
            page: t
        }), this.getSomething(t, e);
    },
    getSomething: function(a, n) {
        var o = this;
        if (!a) a = o.data.page;
        if (!n) n = 1;
        app.get_current_county().then(function(e) {
            console.log("获取county信息"), console.log(e), wx.setStorageSync("county", e), o.setData({
                county: e,
                currCity: e.name,
                currCityId: e.id
            }), app.get_location().then(function(t) {
                app.util.request({
                    url: "entry/wxapp/GetActiveIndex",
                    cachetime: "0",
                    data: {
                        currCityId: e.id
                    },
                    success: function(t) {
                        console.log(t);
                        var a = t.data.data;
                        0 == a.length ? o.setData({
                            active: ""
                        }) : (fcdInterval && (clearInterval(fcdInterval), fcdInterval = 0), fcdInterval = setInterval(function() {
                            for (var t = 0; t < a.length; t++) {
                                var e = tool.countDown(o, a[t].antime);
                                a[t].clock = e ? e[0] + " 天 " + e[1] + " 时 " + e[3] + "分 " + e[4] + "秒 " : " 0 天 0 时 0 分 0 秒 ", 
                                o.setData({
                                    active: a
                                });
                            }
                        }, 1e3), o.setData({
                            cdInterval1: fcdInterval
                        }));
                    }
                }), app.util.request({
                    url: "entry/wxapp/GetBargainIndex",
                    cachetime: "0",
                    data: {
                        currCityId: e.id
                    },
                    success: function(t) {
                        console.log(t);
                        var a = t.data.data;
                        0 == a.length ? o.setData({
                            bargain: ""
                        }) : (fcdInterval1 && (clearInterval(fcdInterval1), fcdInterval1 = 0), fcdInterval1 = setInterval(function() {
                            console.log("fcdInterval1" + fcdInterval1);
                            for (var t = 0; t < a.length; t++) {
                                var e = tool.countDown(o, a[t].endtime);
                                a[t].clock = e ? e[0] + " 天 " + e[1] + " 时 " + e[3] + "分 " + e[4] + "秒 " : " 0 天 0 时 0 分 0 秒 ", 
                                o.setData({
                                    bargain: a
                                });
                            }
                        }, 1e3), o.setData({
                            cdInterval2: fcdInterval1
                        }));
                    }
                }), app.util.request({
                    url: "entry/wxapp/GetGroupsIndex",
                    cachetime: "0",
                    data: {
                        currCityId: e.id
                    },
                    success: function(t) {
                        console.log(t);
                        var a = t.data.data;
                        0 == a.length ? o.setData({
                            groups: ""
                        }) : (fcdInterval2 && (clearInterval(fcdInterval2), fcdInterval2 = 0), fcdInterval2 = setInterval(function() {
                            for (var t = 0; t < a.length; t++) {
                                var e = tool.countDown(o, a[t].endtime);
                                a[t].clock = e ? e[0] + " 天 " + e[1] + " 时 " + e[3] + "分 " + e[4] + "秒 " : " 0 天 0 时 0 分 0 秒 ", 
                                o.setData({
                                    groups: a
                                });
                            }
                        }, 1e3), o.setData({
                            cdInterval3: fcdInterval2
                        }));
                    }
                }), app.util.request({
                    url: "entry/wxapp/GoodList",
                    cachetime: "0",
                    data: {
                        currCityId: e.id,
                        page: a,
                        typeIndex: n,
                        latitude: t.latitude,
                        longitude: t.longitude
                    },
                    success: function(t) {
                        if (console.log("********************************************"), console.log(a), 
                        console.log(t), 2 == t.data) wx.showToast({
                            title: "已经没有内容了哦！！！",
                            icon: "none"
                        }); else {
                            var e = o.data.goodList;
                            console.log("-------------"), console.log(e), e = e ? e.concat(t.data) : t.data, 
                            console.log(e), o.setData({
                                typeIndex: n,
                                goodList: e
                            });
                        }
                    }
                });
            });
        }), app.util.request({
            url: "entry/wxapp/ZxIndex",
            cachetime: "30",
            success: function(t) {
                wx.setStorageSync("winindex", t.data.popbanner), o.setData({
                    newsData: t.data.zx,
                    swiper: t.data.banner,
                    icons: t.data.icons,
                    winindex: t.data.popbanner
                });
            }
        });
    },
    watchClassic: function(t) {
        0 == t.currentTarget.dataset.index && wx.navigateTo({
            url: "../toutiao/index?Title=" + t.currentTarget.dataset.title + "&currentType=" + t.currentTarget.dataset.index
        }), 2 == t.currentTarget.dataset.index && wx.navigateTo({
            url: "../active-list/index"
        }), 2 == t.currentTarget.dataset.index && wx.navigateTo({
            url: "../active-list/index"
        });
    },
    joinNow: function(t) {
        1 == t.currentTarget.dataset.gogogo ? wx.showToast({
            title: "该活动尚未开始！",
            icon: "none"
        }) : wx.navigateTo({
            url: "../active-list/details?id=" + t.currentTarget.dataset.activeid
        });
    },
    goDetails: function(t) {
        wx.navigateTo({
            url: "../toutiao/details?lid=" + t.currentTarget.dataset.lid
        });
    },
    goTokanjia: function(t) {
        1 == wx.getStorageSync("kanjiaopen") ? wx.navigateTo({
            url: "../kanjia-list/index"
        }) : wx.showToast({
            title: "该功能未开放！",
            icon: "none",
            duration: 2e3,
            success: function(t) {},
            fail: function(t) {},
            complete: function(t) {}
        });
    },
    statusTap: function(t) {
        this.setData({
            currentType: t.currentTarget.dataset.index
        });
        var e = t.currentTarget.dataset.index, n = this, o = n.data.currCityId;
        console.log(e), 1 == e ? wx.getLocation({
            type: "wgs84",
            success: function(t) {
                var e = t.latitude, a = t.longitude;
                app.util.request({
                    url: "entry/wxapp/GoodList",
                    cachetime: "30",
                    data: {
                        currCityId: o,
                        typeIndex: 3,
                        latitude: e,
                        longitude: a
                    },
                    success: function(t) {
                        2 == t.data ? n.setData({
                            typeIndex: 3,
                            goodList: []
                        }) : n.setData({
                            typeIndex: 3,
                            goodList: t.data
                        });
                    }
                });
            },
            fail: function(t) {
                wx.showModal({
                    title: "请授权获得地理信息",
                    content: '点击右上角...，进入关于页面，再点击右上角...，进入设置,开启"使用我的地理位置"'
                });
            }
        }) : 0 == e ? wx.getLocation({
            type: "wgs84",
            success: function(t) {
                var e = t.latitude, a = t.longitude;
                app.util.request({
                    url: "entry/wxapp/GoodList",
                    cachetime: "30",
                    data: {
                        currCityId: o,
                        typeIndex: 1,
                        latitude: e,
                        longitude: a
                    },
                    success: function(t) {
                        2 == t.data ? n.setData({
                            typeIndex: 1,
                            goodList: []
                        }) : n.setData({
                            typeIndex: 1,
                            goodList: t.data
                        });
                    }
                });
            },
            fail: function(t) {
                wx.showModal({
                    title: "请授权获得地理信息",
                    content: '点击右上角...，进入关于页面，再点击右上角...，进入设置,开启"使用我的地理位置"'
                });
            }
        }) : 2 == e && wx.getLocation({
            type: "wgs84",
            success: function(t) {
                var e = t.latitude, a = t.longitude;
                app.util.request({
                    url: "entry/wxapp/GoodList",
                    cachetime: "30",
                    data: {
                        currCityId: o,
                        typeIndex: 2,
                        latitude: e,
                        longitude: a
                    },
                    success: function(t) {
                        console.log(t), 2 == t.data ? n.setData({
                            typeIndex: 2,
                            goodList: []
                        }) : n.setData({
                            typeIndex: 2,
                            goodList: t.data
                        });
                    },
                    fail: function(t) {
                        wx.showModal({
                            title: "请授权",
                            content: ""
                        });
                    }
                });
            },
            fail: function(t) {
                wx.showModal({
                    title: "请授权获得地理信息",
                    content: '点击右上角...，进入关于页面，再点击右上角...，进入设置,开启"使用我的地理位置"'
                });
            }
        });
    },
    goGoodsDetails: function(t) {
        wx.navigateTo({
            url: "../goods-detail/index?gid=" + t.currentTarget.dataset.gid
        });
    },
    onReady: function() {},
    wxauthSetting: function(t) {
        var i = this;
        wx.getStorageSync("openid") ? wx.getSetting({
            success: function(t) {
                t.authSetting["scope.userInfo"] ? wx.getUserInfo({
                    success: function(t) {
                        i.setData({
                            is_modal_Hidden: !0,
                            thumb: t.userInfo.avatarUrl,
                            nickname: t.userInfo.nickName
                        });
                    }
                }) : i.setData({
                    is_modal_Hidden: !1
                });
            },
            fail: function(t) {
                i.setData({
                    is_modal_Hidden: !1
                });
            }
        }) : wx.login({
            success: function(t) {
                var e = t.code;
                wx.setStorageSync("code", e), wx.getSetting({
                    success: function(t) {
                        console.log(t), t.authSetting["scope.userInfo"] ? wx.getUserInfo({
                            success: function(t) {
                                i.setData({
                                    is_modal_Hidden: !0,
                                    thumb: t.userInfo.avatarUrl,
                                    nickname: t.userInfo.nickName
                                }), wx.setStorageSync("user_info", t.userInfo);
                                var a = t.userInfo.nickName, n = t.userInfo.avatarUrl, o = t.userInfo.gender;
                                app.util.request({
                                    url: "entry/wxapp/openid",
                                    cachetime: "0",
                                    data: {
                                        code: e
                                    },
                                    success: function(t) {
                                        wx.setStorageSync("key", t.data.session_key), wx.setStorageSync("openid", t.data.openid);
                                        var e = t.data.openid;
                                        app.util.request({
                                            url: "entry/wxapp/Login",
                                            cachetime: "0",
                                            data: {
                                                openid: e,
                                                img: n,
                                                name: a,
                                                gender: o
                                            },
                                            success: function(t) {
                                                wx.setStorageSync("users", t.data), wx.setStorageSync("uniacid", t.data.uniacid), 
                                                i.setData({
                                                    usersinfo: t.data
                                                });
                                            }
                                        });
                                    }
                                });
                            },
                            fail: function(t) {
                                i.setData({
                                    is_modal_Hidden: !1
                                });
                            }
                        }) : i.setData({
                            is_modal_Hidden: !1
                        });
                    }
                });
            },
            fail: function() {
                wx.showModal({
                    title: "获取信息失败",
                    content: "请允许授权以便为您提供给服务!!!",
                    success: function(t) {
                        i.setData({
                            is_modal_Hidden: !1
                        });
                    }
                });
            }
        });
    },
    updateUserInfo: function(t) {
        this.wxauthSetting();
    },
    goShopsDetails: function(t) {
        wx.navigateTo({
            url: "../goods-detail/index?gid=" + t.currentTarget.dataset.gid
        });
    },
    itemClick: function(t) {
        var e = t.currentTarget.dataset.pop_urltxt, a = t.currentTarget.dataset.pop_urltype;
        2 == a ? wx.navigateTo({
            url: "../kanjia-list/details?id=" + e
        }) : 3 == a ? wx.navigateTo({
            url: "../active-list/details?id=" + e
        }) : 4 == a ? wx.navigateTo({
            url: "../pintuan-list/details?id=" + e
        }) : 5 == a ? wx.navigateTo({
            url: "../goods-detail/index?gid=" + e
        }) : 6 == a && wx.navigateTo({
            url: "../shops/shops?id=" + e
        });
    },
    goDetailsPs: function() {
        wx.navigateTo({
            url: "../psDetails/psDetails"
        });
    },
    closeTap: function(t) {
        wx.setStorageSync("comeIn", !0), this.setData({
            comeIn: !0
        });
    },
    onUnload: function() {
        var t = this.data.cdInterval1;
        clearInterval(t);
        var e = this.data.cdInterval2;
        clearInterval(e);
        var a = this.data.cdInterval3;
        clearInterval(a);
    },
    onPullDownRefresh: function() {},
    onShareAppMessage: function() {},
    callme: function(t) {
        wx.makePhoneCall({
            phoneNumber: "0000000"
        });
    },
    callmemine: function(t) {
        wx.makePhoneCall({
            phoneNumber: t.currentTarget.dataset.tel
        });
    },
    getSearch: function(n) {
        var o = this, i = o.data.currCityId;
        n.detail.value ? wx.getLocation({
            type: "wgs84",
            success: function(t) {
                var e = t.latitude, a = t.longitude;
                app.util.request({
                    url: "entry/wxapp/GoodList",
                    cachetime: "30",
                    data: {
                        currCityId: i,
                        typeIndex: 1,
                        latitude: e,
                        longitude: a,
                        keyword: n.detail.value
                    },
                    success: function(t) {
                        console.log(t), 2 == t.data ? o.setData({
                            typeIndex: 3,
                            goodsList: []
                        }) : o.setData({
                            typeIndex: 3,
                            goodsList: t.data
                        });
                    }
                });
            },
            fail: function(t) {
                wx.showModal({
                    title: "请授权获得地理信息",
                    content: '点击右上角...，进入关于页面，再点击右上角...，进入设置,开启"使用我的地理位置"'
                });
            }
        }) : o.setData({
            goodsList: []
        });
    }
}, "goGoodsDetails", function(t) {
    wx.navigateTo({
        url: "../goods-detail/index?gid=" + t.currentTarget.dataset.gid
    });
}), _defineProperty(_Page, "hideSearch", function(t) {
    this.setData({
        goodsList: []
    });
}), _Page));