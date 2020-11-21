var app = getApp();

Page({
    data: {
        telphone: "",
        is_modal_Hidden: !0,
        isLogin: !0,
        Immediately: !1,
        ImmediatelyOpen: !0,
        total: "",
        indicatorDots: !1,
        autoplay: !0,
        interval: 3e3,
        duration: 1e3,
        bannerList: [],
        fight: [],
        productRecommend: [],
        tabBarList: [],
        list: [ {
            id: 1,
            pic: "http://wx3.sinaimg.cn/small/005ysW6agy1ftcv28bk89j30jq0be4ba.jpg",
            status: 0,
            title: "标题啊啊啊",
            address: "地址啊",
            watch: 999,
            good: 11
        }, {
            id: 1,
            pic: "http://wx3.sinaimg.cn/small/005ysW6agy1ftcv28bk89j30jq0be4ba.jpg",
            status: 0,
            title: "标题啊啊啊",
            address: "地址啊",
            watch: 999,
            good: 11
        } ]
    },
    onLoad: function(a) {
        var o = this;
        if (wx.getStorageSync("mall_name")) {
            var t = wx.getStorageSync("mall_name");
            o.setData({
                mall_name: t
            });
        }
        if (a.is_pcfw) {
            var e = a.is_pcfw;
            o.setData({
                is_pcfw: e
            });
        }
        app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            success: function(a) {
                wx.setStorageSync("url", a.data), o.setData({
                    url: a.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/VipTime",
            cachetime: 30,
            success: function(a) {
                console.log("处理会员过期事件！");
            }
        }), app.util.request({
            url: "entry/wxapp/AccessToken",
            cachetime: 30,
            success: function(a) {
                wx.setStorageSync("access_token", a.data.access_token);
            }
        }), app.util.request({
            url: "entry/wxapp/Tab",
            cachetime: 30,
            success: function(a) {
                var t = [ {
                    img: a.data.data.courseimg,
                    state: "../../../../byjs_sun/resource/images/index/myUser.png" == a.data.data.courseimg ? "1" : "2",
                    text: a.data.data.course,
                    goUrl: "/byjs_sun/pages/product/allcourse/allcourse"
                }, {
                    img: a.data.data.coachimg,
                    state: "../../../../byjs_sun/resource/images/update/icon_coach.png" == a.data.data.coachimg ? "1" : "2",
                    text: a.data.data.coach,
                    goUrl: "/byjs_sun/pages/update/coach/coach"
                }, {
                    img: a.data.data.vipimg,
                    state: "../../../../byjs_sun/resource/images/index/Fitness.png" == a.data.data.vipimg ? "1" : "2",
                    text: a.data.data.vip,
                    goUrl: "/byjs_sun/pages/product/admission/admission"
                } ];
                console.log("" == a.data.data.courseimg), o.setData({
                    nav: t
                });
            }
        }), null == app.globalData.tabbar1.length ? app.util.request({
            url: "entry/wxapp/Tab",
            cachetime: 30,
            success: function(a) {
                var t = [ {
                    state: !0,
                    url: "goIndex",
                    publish: !1,
                    text: a.data.data.index,
                    iconPath: a.data.data.indeximg,
                    selectedIconPath: a.data.data.indeximgs
                }, {
                    state: !1,
                    url: "goChargeIndex",
                    publish: !1,
                    text: a.data.data.coupon,
                    iconPath: a.data.data.couponimg,
                    selectedIconPath: a.data.data.couponimgs
                }, {
                    state: !1,
                    url: "goPublishTxt",
                    publish: !0,
                    text: a.data.data.fans,
                    iconPath: a.data.data.fansimg,
                    selectedIconPath: a.data.data.fansimgs
                }, {
                    state: !1,
                    url: "goFindIndex",
                    publish: !1,
                    text: a.data.data.find,
                    iconPath: a.data.data.findimg,
                    selectedIconPath: a.data.data.findimgs
                }, {
                    state: !1,
                    url: "goMy",
                    publish: !1,
                    text: a.data.data.mine,
                    iconPath: a.data.data.mineimg,
                    selectedIconPath: a.data.data.mineimgs
                } ], e = [ {
                    state: !1,
                    url: "goIndex",
                    publish: !1,
                    text: a.data.data.index,
                    iconPath: a.data.data.indeximg,
                    selectedIconPath: a.data.data.indeximgs
                }, {
                    state: !0,
                    url: "goChargeIndex",
                    publish: !1,
                    text: a.data.data.coupon,
                    iconPath: a.data.data.couponimg,
                    selectedIconPath: a.data.data.couponimgs
                }, {
                    state: !1,
                    url: "goPublishTxt",
                    publish: !0,
                    text: a.data.data.fans,
                    iconPath: a.data.data.fansimg,
                    selectedIconPath: a.data.data.fansimgs
                }, {
                    state: !1,
                    url: "goFindIndex",
                    publish: !1,
                    text: a.data.data.find,
                    iconPath: a.data.data.findimg,
                    selectedIconPath: a.data.data.findimgs
                }, {
                    state: !1,
                    url: "goMy",
                    publish: !1,
                    text: a.data.data.mine,
                    iconPath: a.data.data.mineimg,
                    selectedIconPath: a.data.data.mineimgs
                } ], n = [ {
                    state: !1,
                    url: "goIndex",
                    publish: !1,
                    text: a.data.data.index,
                    iconPath: a.data.data.indeximg,
                    selectedIconPath: a.data.data.indeximgs
                }, {
                    state: !1,
                    url: "goChargeIndex",
                    publish: !1,
                    text: a.data.data.coupon,
                    iconPath: a.data.data.couponimg,
                    selectedIconPath: a.data.data.couponimgs
                }, {
                    state: !0,
                    url: "goPublishTxt",
                    publish: !0,
                    text: a.data.data.fans,
                    iconPath: a.data.data.fansimg,
                    selectedIconPath: a.data.data.fansimgs
                }, {
                    state: !1,
                    url: "goFindIndex",
                    publish: !1,
                    text: a.data.data.find,
                    iconPath: a.data.data.findimg,
                    selectedIconPath: a.data.data.findimgs
                }, {
                    state: !1,
                    url: "goMy",
                    publish: !1,
                    text: a.data.data.mine,
                    iconPath: a.data.data.mineimg,
                    selectedIconPath: a.data.data.mineimgs
                } ], d = [ {
                    state: !1,
                    url: "goIndex",
                    publish: !1,
                    text: a.data.data.index,
                    iconPath: a.data.data.indeximg,
                    selectedIconPath: a.data.data.indeximgs
                }, {
                    state: !1,
                    url: "goChargeIndex",
                    publish: !1,
                    text: a.data.data.coupon,
                    iconPath: a.data.data.couponimg,
                    selectedIconPath: a.data.data.couponimgs
                }, {
                    state: !1,
                    url: "goPublishTxt",
                    publish: !0,
                    text: a.data.data.fans,
                    iconPath: a.data.data.fansimg,
                    selectedIconPath: a.data.data.fansimgs
                }, {
                    state: !0,
                    url: "goFindIndex",
                    publish: !1,
                    text: a.data.data.find,
                    iconPath: a.data.data.findimg,
                    selectedIconPath: a.data.data.findimgs
                }, {
                    state: !1,
                    url: "goMy",
                    publish: !1,
                    text: a.data.data.mine,
                    iconPath: a.data.data.mineimg,
                    selectedIconPath: a.data.data.mineimgs
                } ], s = [ {
                    state: !1,
                    url: "goIndex",
                    publish: !1,
                    text: a.data.data.index,
                    iconPath: a.data.data.indeximg,
                    selectedIconPath: a.data.data.indeximgs
                }, {
                    state: !1,
                    url: "goChargeIndex",
                    publish: !1,
                    text: a.data.data.coupon,
                    iconPath: a.data.data.couponimg,
                    selectedIconPath: a.data.data.couponimgs
                }, {
                    state: !1,
                    url: "goPublishTxt",
                    publish: !0,
                    text: a.data.data.fans,
                    iconPath: a.data.data.fansimg,
                    selectedIconPath: a.data.data.fansimgs
                }, {
                    state: !1,
                    url: "goFindIndex",
                    publish: !1,
                    text: a.data.data.find,
                    iconPath: a.data.data.findimg,
                    selectedIconPath: a.data.data.findimgs
                }, {
                    state: !0,
                    url: "goMy",
                    publish: !1,
                    text: a.data.data.mine,
                    iconPath: a.data.data.mineimg,
                    selectedIconPath: a.data.data.mineimgs
                } ];
                app.util.request({
                    url: "entry/wxapp/SwitchBar",
                    cachetime: 0,
                    success: function(a) {
                        "0" == a.data.is_fbopen && (t.splice(2, 2), e.splice(2, 2), n.splice(2, 2), d.splice(2, 2), 
                        s.splice(2, 2)), o.setData({
                            tabBarList: t
                        }), app.globalData.tabbar1 = t, app.globalData.tabbar2 = e, app.globalData.tabbar3 = n, 
                        app.globalData.tabbar4 = d, app.globalData.tabbar5 = s;
                    }
                });
            }
        }) : o.setData({
            tabBarList: app.globalData.tabbar1
        }), 1 == app.globalData.refresh && (app.util.request({
            url: "entry/wxapp/Redpacket",
            cachetime: 0,
            success: function(a) {
                console.log(a.data), 0 == a.data ? o.setData({
                    total: "",
                    Immediately: !1
                }) : (o.setData({
                    total: a.data,
                    Immediately: !0
                }), wx.setStorageSync("total", a.data));
            }
        }), app.globalData.refresh = !1), o.wxauthSetting();
    },
    goInn: function() {
        var a = this;
        wx.navigateTo({
            url: "../../update/inn/inn?longitude_dq=" + a.data.longitude_dq + "&latitude_dq=" + a.data.latitude_dq + "&mall_name=" + a.data.mall.name
        });
    },
    goChargeIndex: function(a) {
        wx.reLaunch({
            url: "../../charge/chargeIndex/chargeIndex"
        });
    },
    goPublishTxt: function(a) {
        wx.reLaunch({
            url: "../../publishInfo/publish/publishTxt"
        });
    },
    goFindIndex: function(a) {
        wx.reLaunch({
            url: "../../find/findIndex/findIndex"
        });
    },
    goMy: function(a) {
        wx.reLaunch({
            url: "../../myUser/my/my"
        });
    },
    goCourse: function(a) {
        var t = a.currentTarget.dataset.mid;
        wx.navigateTo({
            url: "/byjs_sun/pages/product/course/course?mid=" + t
        });
    },
    goAllarticle: function(a) {
        wx.navigateTo({
            url: "../allarticle/allarticle"
        });
    },
    closeAd: function() {
        console.log(111), app.globalData.adBtn = !0, this.setData({
            is_pcfw: 2
        }), this.onShow();
    },
    onLaunch: function() {},
    onReady: function() {},
    onShow: function() {
        var d = this;
        this.setData({
            adBtn: app.globalData.adBtn
        }), 1 == d.data.is_pcfw ? app.util.request({
            url: "entry/wxapp/GetMealType",
            cachetime: "30",
            success: function(a) {
                d.setData({
                    mealType: a.data.res,
                    color: a.data.color,
                    is_pcfw: d.data.is_pcfw,
                    title: a.data.title
                });
                var t = a.data.title;
                wx.setNavigationBarTitle({
                    title: t
                });
            }
        }) : app.util.request({
            url: "entry/wxapp/IsMeal",
            cachetime: 0,
            success: function(a) {
                d.setData({
                    is_pcfw: a.data
                }), 1 == a.data ? app.util.request({
                    url: "entry/wxapp/GetMealType",
                    cachetime: "30",
                    success: function(a) {
                        d.setData({
                            mealType: a.data.res,
                            color: a.data.color,
                            title: a.data.title
                        });
                        var t = a.data.title;
                        wx.setNavigationBarTitle({
                            title: t
                        });
                    }
                }) : wx.getLocation({
                    type: "wgs84",
                    success: function(a) {
                        console.log("获取当前用户经纬度"), d.setData({
                            latitude_dq: a.latitude,
                            longitude_dq: a.longitude
                        }), app.util.request({
                            url: "entry/wxapp/GetAd",
                            cachetime: 0,
                            data: {
                                latitude_dq: d.data.latitude_dq,
                                longitude_dq: d.data.longitude_dq
                            },
                            success: function(a) {
                                console.log(a);
                                var t = a.data.system.pt_name, e = a.data.system.fontcolor, n = a.data.system.color;
                                wx.setStorageSync("color", n), wx.setStorageSync("fontcolor", e), wx.setNavigationBarTitle({
                                    title: t
                                }), d.setData({
                                    title: t
                                }), wx.setStorageSync("phone", a.data.phone), wx.setStorageSync("mall_id", a.data.data.id), 
                                d.data.mall_name ? (console.log(0xa1b01d4b1c7), app.util.request({
                                    url: "entry/wxapp/getMALLL",
                                    data: {
                                        mall: d.data.mall_name
                                    },
                                    success: function(a) {
                                        console.log(a), d.setData({
                                            fight: a.data.Course,
                                            mall: a.data.mall
                                        });
                                    }
                                })) : (d.setData({
                                    mall: a.data.data
                                }), console.log(222222222), app.util.request({
                                    url: "entry/wxapp/getCourse",
                                    data: {
                                        mall: d.data.mall.name
                                    },
                                    success: function(a) {
                                        console.log(a), d.setData({
                                            fight: a.data
                                        });
                                    }
                                })), d.setData({
                                    bannerList: a.data.banner.lb_imgs,
                                    telphone: a.data.phone,
                                    team: a.data.support,
                                    productRecommend: a.data.article,
                                    list: a.data.activity,
                                    is_pintuanopen: a.data.system.is_pintuanopen
                                }), console.log(a.data.res), d.setData({
                                    logo: a.data.res.logo
                                }), wx.setNavigationBarColor({
                                    frontColor: wx.getStorageSync("fontcolor"),
                                    backgroundColor: wx.getStorageSync("color"),
                                    animation: {
                                        duration: 0,
                                        timingFunc: "easeIn"
                                    }
                                });
                            }
                        });
                    }
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function(a) {
        if ("button" === a.from && console.log(a.target), this.data.title) var t = this.data.title; else t = "柚子健身";
        return {
            title: this.data.nickname + "邀你来到 [" + t + "]",
            path: "/byjs_sun/pages/product/index/index",
            success: function(a) {},
            fail: function(a) {}
        };
    },
    change: function() {
        var o = this;
        o.setData({
            is_pcfw: 2
        }), wx.getLocation({
            type: "wgs84",
            success: function(a) {
                console.log("获取当前用户经纬度"), o.setData({
                    latitude_dq: a.latitude,
                    longitude_dq: a.longitude
                }), console.log(a), app.util.request({
                    url: "entry/wxapp/GetAd",
                    cachetime: 0,
                    data: {
                        latitude_dq: o.data.latitude_dq,
                        longitude_dq: o.data.longitude_dq
                    },
                    success: function(a) {
                        console.log(a);
                        var t = a.data.system.pt_name;
                        o.setData({
                            title: t
                        });
                        var e = a.data.system.fontcolor, n = a.data.system.color;
                        wx.setStorageSync("color", n), wx.setStorageSync("fontcolor", e), wx.setNavigationBarTitle({
                            title: t
                        }), wx.setStorageSync("phone", a.data.phone), wx.setStorageSync("mall_id", a.data.data.id);
                        var d = o.data.mall_name;
                        d ? (console.log(0xa1b01d4b1c7), app.util.request({
                            url: "entry/wxapp/getMALLL",
                            data: {
                                mall: d
                            },
                            success: function(a) {
                                console.log(a), o.setData({
                                    fight: a.data.Course,
                                    mall: a.data.mall
                                });
                            }
                        })) : (o.setData({
                            mall: a.data.data
                        }), app.util.request({
                            url: "entry/wxapp/getCourse",
                            data: {
                                mall: o.data.mall.name
                            },
                            success: function(a) {
                                o.setData({
                                    fight: a.data
                                });
                            }
                        })), o.setData({
                            bannerList: a.data.banner.lb_imgs,
                            telphone: a.data.phone,
                            team: a.data.support,
                            productRecommend: a.data.article
                        }), 0 == a.data.res ? o.setData({
                            status: 0
                        }) : o.setData({
                            status: 1,
                            logo: a.data.res.logo
                        }), wx.setNavigationBarColor({
                            frontColor: wx.getStorageSync("fontcolor"),
                            backgroundColor: wx.getStorageSync("color"),
                            animation: {
                                duration: 0,
                                timingFunc: "easeIn"
                            }
                        });
                    }
                });
            }
        }), null == app.globalData.tabbar1.length ? app.util.request({
            url: "entry/wxapp/Tab",
            cachetime: 30,
            success: function(a) {
                var t = [ {
                    state: !0,
                    url: "goIndex",
                    publish: !1,
                    text: a.data.data.index,
                    iconPath: a.data.data.indeximg,
                    selectedIconPath: a.data.data.indeximgs
                }, {
                    state: !1,
                    url: "goChargeIndex",
                    publish: !1,
                    text: a.data.data.coupon,
                    iconPath: a.data.data.couponimg,
                    selectedIconPath: a.data.data.couponimgs
                }, {
                    state: !1,
                    url: "goPublishTxt",
                    publish: !0,
                    text: a.data.data.fans,
                    iconPath: a.data.data.fansimg,
                    selectedIconPath: a.data.data.fansimgs
                }, {
                    state: !1,
                    url: "goFindIndex",
                    publish: !1,
                    text: a.data.data.find,
                    iconPath: a.data.data.findimg,
                    selectedIconPath: a.data.data.findimgs
                }, {
                    state: !1,
                    url: "goMy",
                    publish: !1,
                    text: a.data.data.mine,
                    iconPath: a.data.data.mineimg,
                    selectedIconPath: a.data.data.mineimgs
                } ], e = [ {
                    state: !1,
                    url: "goIndex",
                    publish: !1,
                    text: a.data.data.index,
                    iconPath: a.data.data.indeximg,
                    selectedIconPath: a.data.data.indeximgs
                }, {
                    state: !0,
                    url: "goChargeIndex",
                    publish: !1,
                    text: a.data.data.coupon,
                    iconPath: a.data.data.couponimg,
                    selectedIconPath: a.data.data.couponimgs
                }, {
                    state: !1,
                    url: "goPublishTxt",
                    publish: !0,
                    text: a.data.data.fans,
                    iconPath: a.data.data.fansimg,
                    selectedIconPath: a.data.data.fansimgs
                }, {
                    state: !1,
                    url: "goFindIndex",
                    publish: !1,
                    text: a.data.data.find,
                    iconPath: a.data.data.findimg,
                    selectedIconPath: a.data.data.findimgs
                }, {
                    state: !1,
                    url: "goMy",
                    publish: !1,
                    text: a.data.data.mine,
                    iconPath: a.data.data.mineimg,
                    selectedIconPath: a.data.data.mineimgs
                } ], n = [ {
                    state: !1,
                    url: "goIndex",
                    publish: !1,
                    text: a.data.data.index,
                    iconPath: a.data.data.indeximg,
                    selectedIconPath: a.data.data.indeximgs
                }, {
                    state: !1,
                    url: "goChargeIndex",
                    publish: !1,
                    text: a.data.data.coupon,
                    iconPath: a.data.data.couponimg,
                    selectedIconPath: a.data.data.couponimgs
                }, {
                    state: !0,
                    url: "goPublishTxt",
                    publish: !0,
                    text: a.data.data.fans,
                    iconPath: a.data.data.fansimg,
                    selectedIconPath: a.data.data.fansimgs
                }, {
                    state: !1,
                    url: "goFindIndex",
                    publish: !1,
                    text: a.data.data.find,
                    iconPath: a.data.data.findimg,
                    selectedIconPath: a.data.data.findimgs
                }, {
                    state: !1,
                    url: "goMy",
                    publish: !1,
                    text: a.data.data.mine,
                    iconPath: a.data.data.mineimg,
                    selectedIconPath: a.data.data.mineimgs
                } ], d = [ {
                    state: !1,
                    url: "goIndex",
                    publish: !1,
                    text: a.data.data.index,
                    iconPath: a.data.data.indeximg,
                    selectedIconPath: a.data.data.indeximgs
                }, {
                    state: !1,
                    url: "goChargeIndex",
                    publish: !1,
                    text: a.data.data.coupon,
                    iconPath: a.data.data.couponimg,
                    selectedIconPath: a.data.data.couponimgs
                }, {
                    state: !1,
                    url: "goPublishTxt",
                    publish: !0,
                    text: a.data.data.fans,
                    iconPath: a.data.data.fansimg,
                    selectedIconPath: a.data.data.fansimgs
                }, {
                    state: !0,
                    url: "goFindIndex",
                    publish: !1,
                    text: a.data.data.find,
                    iconPath: a.data.data.findimg,
                    selectedIconPath: a.data.data.findimgs
                }, {
                    state: !1,
                    url: "goMy",
                    publish: !1,
                    text: a.data.data.mine,
                    iconPath: a.data.data.mineimg,
                    selectedIconPath: a.data.data.mineimgs
                } ], s = [ {
                    state: !1,
                    url: "goIndex",
                    publish: !1,
                    text: a.data.data.index,
                    iconPath: a.data.data.indeximg,
                    selectedIconPath: a.data.data.indeximgs
                }, {
                    state: !1,
                    url: "goChargeIndex",
                    publish: !1,
                    text: a.data.data.coupon,
                    iconPath: a.data.data.couponimg,
                    selectedIconPath: a.data.data.couponimgs
                }, {
                    state: !1,
                    url: "goPublishTxt",
                    publish: !0,
                    text: a.data.data.fans,
                    iconPath: a.data.data.fansimg,
                    selectedIconPath: a.data.data.fansimgs
                }, {
                    state: !1,
                    url: "goFindIndex",
                    publish: !1,
                    text: a.data.data.find,
                    iconPath: a.data.data.findimg,
                    selectedIconPath: a.data.data.findimgs
                }, {
                    state: !0,
                    url: "goMy",
                    publish: !1,
                    text: a.data.data.mine,
                    iconPath: a.data.data.mineimg,
                    selectedIconPath: a.data.data.mineimgs
                } ];
                app.util.request({
                    url: "entry/wxapp/SwitchBar",
                    cachetime: 0,
                    success: function(a) {
                        "0" == a.data.is_fbopen && (t.splice(2, 2), e.splice(2, 2), n.splice(2, 2), d.splice(2, 2), 
                        s.splice(2, 2)), o.setData({
                            tabBarList: t
                        }), app.globalData.tabbar1 = t, app.globalData.tabbar2 = e, app.globalData.tabbar3 = n, 
                        app.globalData.tabbar4 = d, app.globalData.tabbar5 = s;
                    }
                });
            }
        }) : o.setData({
            tabBarList: app.globalData.tabbar1
        }), 1 == app.globalData.refresh && (app.util.request({
            url: "entry/wxapp/Redpacket",
            cachetime: 0,
            success: function(a) {
                console.log(a.data), 0 == a.data ? o.setData({
                    total: "",
                    Immediately: !1
                }) : (o.setData({
                    total: a.data,
                    Immediately: !0
                }), wx.setStorageSync("total", a.data));
            }
        }), app.globalData.refresh = !1);
    },
    ImmediatelyOpen: function() {
        this.setData({
            ImmediatelyOpen: !0
        });
    },
    colse: function() {
        this.setData({
            Immediately: !1
        });
    },
    goBay: function(a) {
        var t = a.currentTarget.dataset.id, e = a.currentTarget.dataset.cid;
        console.log(e), wx.navigateTo({
            url: "/byjs_sun/pages/product/courseGoInfo/courseGoInfo?id=" + t + "&cid=" + e
        });
    },
    toDetail: function(a) {
        var t = a.currentTarget.dataset.url, e = wx.getStorageSync("users").id;
        if ("/byjs_sun/pages/product/admission/admission" == t) app.util.request({
            url: "entry/wxapp/isVip",
            data: {
                id: e
            },
            success: function(a) {
                console.log(a), 1 == a.data ? wx.navigateTo({
                    url: "/byjs_sun/pages/product/member/member?uid=" + e
                }) : wx.navigateTo({
                    url: t
                });
            }
        }); else if ("/byjs_sun/pages/product/allcourse/allcourse" == t) {
            var n = a.currentTarget.dataset.mid;
            wx.navigateTo({
                url: "/byjs_sun/pages/product/allcourse/allcourse?mid=" + n
            });
        } else wx.navigateTo({
            url: t
        });
    },
    see: function(a) {
        wx.navigateTo({
            url: "/byjs_sun/pages/myUser/myRedEnvelope/myRedEnvelope"
        });
    },
    goWritings: function(a) {
        var t = a.currentTarget.dataset.id, e = a.currentTarget.dataset.goods_id;
        wx.navigateTo({
            url: "/byjs_sun/pages/product/writings/writingsInfo/writingsInfo?id=" + t + "&goods_id=" + e
        });
    },
    wxauthSetting: function(a) {
        var s = this;
        wx.getStorageSync("openid") ? wx.getSetting({
            success: function(a) {
                console.log("进入wx.getSetting 1"), console.log(a), a.authSetting["scope.userInfo"] ? (console.log("scope.userInfo已授权 1"), 
                wx.getUserInfo({
                    success: function(a) {
                        s.setData({
                            is_modal_Hidden: !0,
                            thumb: a.userInfo.avatarUrl,
                            nickname: a.userInfo.nickName
                        });
                    }
                })) : (console.log("scope.userInfo没有授权 1"), wx.showModal({
                    title: "获取信息失败",
                    content: "请允许授权以便为您提供给服务",
                    success: function(a) {
                        s.setData({
                            is_modal_Hidden: !1
                        });
                    }
                }));
            },
            fail: function(a) {
                console.log("获取权限失败 1"), s.setData({
                    is_modal_Hidden: !1
                });
            }
        }) : wx.login({
            success: function(a) {
                console.log("进入wx-login");
                var t = a.code;
                wx.setStorageSync("code", t), wx.getSetting({
                    success: function(a) {
                        console.log("进入wx.getSetting"), console.log(a), a.authSetting["scope.userInfo"] ? (console.log("scope.userInfo已授权"), 
                        wx.getUserInfo({
                            success: function(a) {
                                s.setData({
                                    is_modal_Hidden: !0,
                                    thumb: a.userInfo.avatarUrl,
                                    nickname: a.userInfo.nickName
                                }), console.log("进入wx-getUserInfo"), console.log(a.userInfo), wx.setStorageSync("user_info", a.userInfo);
                                var e = a.userInfo.nickName, n = a.userInfo.avatarUrl, d = a.userInfo.gender;
                                app.util.request({
                                    url: "entry/wxapp/openid",
                                    cachetime: "0",
                                    data: {
                                        code: t
                                    },
                                    success: function(a) {
                                        console.log("进入获取openid"), console.log(a.data), wx.setStorageSync("key", a.data.session_key);
                                        var t = a.data.openid;
                                        wx.setStorageSync("userid", a.data.openid), wx.setStorage({
                                            key: "openid",
                                            data: t
                                        }), app.util.request({
                                            url: "entry/wxapp/Login",
                                            cachetime: "0",
                                            data: {
                                                openid: t,
                                                img: n,
                                                name: e,
                                                gender: d
                                            },
                                            success: function(a) {
                                                console.log("进入地址login"), console.log(a.data), wx.setStorageSync("users", a.data), 
                                                wx.setStorageSync("uniacid", a.data.uniacid), s.setData({
                                                    usersinfo: a.data
                                                });
                                            }
                                        });
                                    }
                                });
                            },
                            fail: function(a) {
                                console.log("进入 wx-getUserInfo 失败"), wx.showModal({
                                    title: "获取信息失败",
                                    content: "请允许授权以便为您提供给服务!",
                                    success: function(a) {
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
                    success: function(a) {
                        s.setData({
                            is_modal_Hidden: !1
                        });
                    }
                });
            }
        });
    },
    updateUserInfo: function(a) {
        console.log("授权操作更新");
        this.wxauthSetting();
    },
    callTelephone: function(a) {
        var t = this.data.telphone;
        console.log(t.phone), wx.makePhoneCall({
            phoneNumber: t.phone
        });
    },
    goActiveDet: function(a) {
        var t = a.currentTarget.dataset.id, e = wx.getStorageSync("users").id;
        app.util.request({
            url: "entry/wxapp/addLiu",
            cachetime: "0",
            data: {
                aid: t,
                uid: e
            },
            success: function(a) {
                wx.navigateTo({
                    url: "/byjs_sun/pages/product/activeDet/activeDet?aid=" + t
                });
            }
        });
    },
    goActive: function(a) {
        wx.navigateTo({
            url: "/byjs_sun/pages/product/active/active"
        });
    }
});