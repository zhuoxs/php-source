var app = getApp();

Page({
    data: {
        current: 0,
        titleWord: [ "在线预约", "免费咨询", "付费咨询", "电话预约" ],
        num: 0,
        light: "",
        kong: "",
        is_modal_Hidden: !0,
        autoplay: !0,
        interval: 5e3,
        duration: 1e3
    },
    onLoad: function(t) {
        var a = this;
        a.url(), a.wxauthSetting(), t.currentIndex && a.setData({
            current: t.currentIndex
        }), app.util.request({
            url: "entry/wxapp/Indexpic",
            cachetime: "30",
            success: function(t) {
                a.data.url;
                var e = t.data.data;
                t.data.data.pt_name ? wx.setNavigationBarTitle({
                    title: t.data.data.pt_name
                }) : wx.setNavigationBarTitle({
                    title: "柚子律师"
                }), console.log(e), a.setData({
                    shopData: e
                });
            }
        }), a.shiwu();
        var e = wx.getStorageSync("userInfo");
        wx.getStorage({
            key: "openid",
            success: function(t) {
                app.util.request({
                    url: "entry/wxapp/Addopen",
                    cachetime: "0",
                    data: {
                        nickName: e.nickName,
                        avatarUrl: e.avatarUrl,
                        openid: t.data
                    },
                    success: function(t) {
                        a.onShow();
                    }
                });
            }
        });
    },
    shiwu: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/GoodList",
            cachetime: "0",
            success: function(t) {
                e.setData({
                    business: t.data.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/banner",
            cachetime: "0",
            success: function(t) {
                console.log(t.data.data), e.setData({
                    banners: t.data.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/Shop",
            cachetime: "0",
            success: function(t) {
                console.log(t), wx.setStorageSync("color", t.data.data.color), wx.setStorageSync("fontcolor", t.data.data.fontcolor), 
                wx.setNavigationBarColor({
                    frontColor: wx.getStorageSync("fontcolor"),
                    backgroundColor: wx.getStorageSync("color"),
                    animation: {
                        duration: 0,
                        timingFunc: "easeIn"
                    }
                });
            }
        });
    },
    lawyers: function(t) {
        var n = this;
        wx.getStorageSync("openid") && wx.getLocation({
            type: "gcj02",
            success: function(t) {
                var e = t.latitude, a = t.longitude;
                wx.setStorageSync("lat", e), wx.setStorageSync("lng", a), app.util.request({
                    url: "entry/wxapp/lawyers",
                    cachetime: "0",
                    data: {
                        latitude: e,
                        longitude: a
                    },
                    success: function(t) {
                        console.log(t.data.data), n.setData({
                            lawyers: t.data.data
                        });
                    }
                });
            }
        });
    },
    closeTap: function(t) {
        app.globalData.comeIn = !0, this.setData({
            comeIn: !0
        });
    },
    goTap: function(t) {
        console.log(t);
        var e = this;
        e.setData({
            current: t.currentTarget.dataset.index
        }), 1 == e.data.current && wx.redirectTo({
            url: "../article/index?currentIndex=1"
        }), 2 == e.data.current && wx.redirectTo({
            url: "/zhls_sun/pages/lvshiList/lvshiList?currentIndex=2"
        }), 3 == e.data.current && wx.redirectTo({
            url: "../mine/index?currentIndex=3"
        });
    },
    url: function(t) {
        var e = this;
        app.util.request({
            url: "entry/wxapp/Url2",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url2", t.data);
            }
        }), app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url", t.data), e.setData({
                    url: t.data
                });
            }
        });
    },
    xxjiaoliu: function(t) {
        console.log(t), 0 == t.currentTarget.dataset.status ? wx.navigateTo({
            url: "../lvshiList/lvshiList"
        }) : wx.navigateTo({
            url: "../consult/index?currentIndex=2"
        });
    },
    freeConsult: function(t) {
        wx.navigateTo({
            url: "../consult/free"
        });
    },
    watchClassic: function(t) {
        0 == t.currentTarget.dataset.index && wx.navigateTo({
            url: "../yuyue/online"
        }), 2 == t.currentTarget.dataset.index && wx.navigateTo({
            url: "../consult/fufei"
        }), 3 == t.currentTarget.dataset.index && wx.makePhoneCall({
            phoneNumber: this.data.shopData.tel,
            success: function(t) {
                console.log("-----拨打电话成功-----");
            },
            fail: function(t) {
                console.log("-----拨打电话失败-----");
            }
        });
    },
    joinNow: function() {
        wx.navigateTo({
            url: "../active-list/details"
        });
    },
    goHongBao: function(t) {
        wx.navigateTo({
            url: "../hongbao/index"
        });
    },
    goQuestion: function(t) {
        wx.navigateTo({
            url: "../consult/fufei?id=" + t.currentTarget.dataset.id
        });
    },
    gofreeQues: function(t) {
        wx.navigateTo({
            url: "../consult/free"
        });
    },
    toYewuDetails: function(t) {
        console.log(t), wx.navigateTo({
            url: "../yewuDetails/yewuDetails?id=" + t.currentTarget.dataset.id
        });
    },
    watchMore: function(t) {
        wx.navigateTo({
            url: "../lvshiList/lvshiList"
        });
    },
    goLvshiIntro: function(t) {
        wx.navigateTo({
            url: "../lvshi-intro/lvshi-intro?id=" + t.currentTarget.dataset.id
        });
    },
    onReady: function() {},
    onShow: function() {
        var n = this;
        n.setData({
            comeIn: app.globalData.comeIn
        }), app.util.request({
            url: "entry/wxapp/userData",
            cachetime: "0",
            success: function(t) {
                console.log(t.data), n.setData({
                    user: t.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/tab",
            cachetime: "10",
            success: function(t) {
                n.setData({
                    tab: t.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/indexTan",
            cachetime: "0",
            success: function(t) {
                console.log(t.data);
                for (var e = Array(), a = 0; a < t.data.lb_img.length; a++) e[a] = t.data.lb_img[a];
                n.setData({
                    imgs: e,
                    indexTan: t.data
                });
            }
        }), n.lawyers();
    },
    itemClick: function(t) {
        var e = t.currentTarget.dataset.index, a = this.data.imgs;
        wx.navigateTo({
            url: "/" + a[e].path
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
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
                                var a = t.userInfo.nickName, n = t.userInfo.avatarUrl, o = t.userInfo.gender;
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
                                        wx.setStorageSync("userid", t.data.openid), wx.setStorage({
                                            key: "openid",
                                            data: e
                                        }), app.util.request({
                                            url: "entry/wxapp/Login",
                                            cachetime: "0",
                                            data: {
                                                openid: e,
                                                img: n,
                                                name: a,
                                                gender: o
                                            },
                                            success: function(t) {
                                                console.log("进入地址login"), console.log(t.data), wx.setStorageSync("users", t.data), 
                                                wx.setStorageSync("uniacid", t.data.uniacid), s.setData({
                                                    usersinfo: t.data
                                                });
                                            }
                                        }), s.lawyers();
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
    }
});