var app = getApp();

Page({
    data: {
        autoplay: !0,
        interval: 3e3,
        duration: 1e3,
        circular: !0,
        is_modal_Hidden: !0,
        comeIn: !0
    },
    goToBanner: function(e) {
        console.log(e);
        e.currentTarget.dataset.index;
        var t = e.currentTarget.dataset.pop_urltxt, a = e.currentTarget.dataset.pop_urltype;
        2 == a ? wx.redirectTo({
            url: "../fansCard/fansCard"
        }) : 3 == a ? wx.navigateTo({
            url: "../taoCanDetails/taoCanDetails?mealid=" + t
        }) : 4 == a ? wx.navigateTo({
            url: "../dapai-Qg/dapai-Qg?gid=" + t
        }) : 5 == a ? wx.navigateTo({
            url: "../dapai-Qg/dapai-Qg?gid=" + t + "&&buyType=3"
        }) : 6 == a && wx.navigateTo({
            url: "../shopDetails/shopDetails?store_id=" + t
        });
    },
    onLoad: function() {
        var o = this, e = wx.getStorageSync("url");
        console.log(e), e ? o.setData({
            url: e
        }) : app.util.request({
            url: "entry/wxapp/url",
            cachetime: "0",
            success: function(e) {
                console.log(e), o.setData({
                    url: e.data
                }), wx.setStorage({
                    key: "url",
                    data: e.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/system",
            cachetime: "0",
            success: function(e) {
                if (console.log(e), 0 == e.data.dapai_type) var t = [ "大牌福利", "大牌抢购" ], a = 0, n = 0; else t = [ "大牌抢购", "大牌福利" ], 
                a = 0, n = 1;
                o.setData({
                    system: e.data,
                    statusType: t,
                    currentType: a,
                    currentindex: n
                }), o.diyWinColor();
            }
        }), app.util.request({
            url: "entry/wxapp/GetCarousel",
            cachetime: "0",
            success: function(e) {
                console.log(e.data.data), o.setData({
                    banners: e.data.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/GetRecommendGoods",
            cachetime: "0",
            success: function(e) {
                console.log(e), o.setData({
                    bigSnappingUp: e.data.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/GetRecommendCaipin",
            cachetime: "0",
            success: function(e) {
                console.log(e), o.setData({
                    bigWelfare: e.data.data
                });
            }
        });
    },
    statusTap: function(e) {
        var t = e.currentTarget.dataset.index;
        if (0 == this.data.system.dapai_type) if (0 == t) var a = 0; else a = 1; else if (0 == t) a = 1; else a = 0;
        console.log(a), this.setData({
            currentType: t,
            currentindex: a
        });
    },
    getNowTap: function(e) {},
    closeTap: function(e) {
        wx.setStorageSync("comeIn", !0), this.setData({
            comeIn: !0
        });
    },
    copyTap: function(e) {
        console.log(e);
        wx.setClipboardData({
            data: e.currentTarget.dataset.chat,
            success: function(e) {
                wx.getClipboardData({
                    success: function(e) {
                        console.log(e.data);
                    }
                });
            }
        });
    },
    goDapaiTap: function(e) {
        console.log(e), "大牌福利" == e.currentTarget.dataset.title && wx.navigateTo({
            url: "../dapai-Qg/dapai-Qg?gid=" + e.currentTarget.dataset.id + "&&bid=" + e.currentTarget.dataset.bid + "&&title=" + e.currentTarget.dataset.title
        }), "大牌抢购" == e.currentTarget.dataset.title && wx.navigateTo({
            url: "../dapai-Qg/dapai-Qg?gid=" + e.currentTarget.dataset.id + "&&bid=" + e.currentTarget.dataset.bid + "&&buyType=3&&title=" + e.currentTarget.dataset.title
        });
    },
    callTap: function(e) {
        console.log(e), wx.makePhoneCall({
            phoneNumber: e.currentTarget.dataset.tel
        });
    },
    getUserInfo: function(e) {
        console.log(e), app.globalData.userInfo = e.detail.userInfo, this.setData({
            userInfo: e.detail.userInfo,
            hasUserInfo: !0
        });
    },
    diyWinColor: function(e) {
        var t = this;
        wx.setStorageSync("system", t.data.system), wx.setNavigationBarColor({
            frontColor: t.data.system.color,
            backgroundColor: t.data.system.fontcolor,
            animation: {
                duration: 400,
                timingFunc: "easeIn"
            }
        }), wx.setNavigationBarTitle({
            title: t.data.system.link_name
        });
    },
    bindChange: function(e) {
        this.setData({
            currentTab: e.detail.current
        });
    },
    swichNav: function(e) {
        if (this.data.currentTab === e.target.dataset.current) return !1;
        this.setData({
            currentTab: e.target.dataset.current
        });
    },
    bindGetUserInfo: function(e) {
        console.log(e.detail.userInfo), this.setData({
            isLogin: !1
        });
    },
    wxauthSetting: function(e) {
        var s = this;
        wx.getStorageSync("openid") ? wx.getSetting({
            success: function(e) {
                console.log("进入wx.getSetting 1"), console.log(e), e.authSetting["scope.userInfo"] ? (console.log("scope.userInfo已授权 1"), 
                wx.getUserInfo({
                    success: function(e) {
                        s.setData({
                            is_modal_Hidden: !0,
                            thumb: e.userInfo.avatarUrl,
                            nickname: e.userInfo.nickName
                        });
                    }
                })) : (console.log("scope.userInfo没有授权 1"), s.setData({
                    is_modal_Hidden: !1
                }));
            },
            fail: function(e) {
                console.log("获取权限失败 1"), s.setData({
                    is_modal_Hidden: !1
                });
            }
        }) : wx.login({
            success: function(e) {
                console.log(e.code), console.log("进入wx-login");
                var t = e.code;
                wx.setStorageSync("code", t), wx.getSetting({
                    success: function(e) {
                        console.log("进入wx.getSetting"), console.log(e), e.authSetting["scope.userInfo"] ? (console.log("scope.userInfo已授权"), 
                        wx.getUserInfo({
                            success: function(e) {
                                s.setData({
                                    is_modal_Hidden: !0,
                                    thumb: e.userInfo.avatarUrl,
                                    nickname: e.userInfo.nickName
                                }), console.log("进入wx-getUserInfo"), console.log(e.userInfo), wx.setStorageSync("user_info", e.userInfo);
                                var a = e.userInfo.nickName, n = e.userInfo.avatarUrl, o = e.userInfo.gender;
                                app.util.request({
                                    url: "entry/wxapp/openid",
                                    cachetime: "0",
                                    data: {
                                        code: t
                                    },
                                    success: function(e) {
                                        console.log("进入获取openid"), console.log(e.data), wx.setStorageSync("key", e.data.session_key), 
                                        wx.setStorageSync("openid", e.data.openid);
                                        var t = e.data.openid;
                                        app.util.request({
                                            url: "entry/wxapp/Login",
                                            cachetime: "0",
                                            data: {
                                                openid: t,
                                                img: n,
                                                name: a,
                                                gender: o
                                            },
                                            success: function(e) {
                                                console.log("进入地址login"), console.log(e.data), wx.setStorageSync("users", e.data), 
                                                wx.setStorageSync("uniacid", e.data.uniacid), s.setData({
                                                    usersinfo: e.data
                                                });
                                            }
                                        });
                                    }
                                });
                            },
                            fail: function(e) {
                                console.log("进入 wx-getUserInfo 失败"), s.setData({
                                    is_modal_Hidden: !1
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
                    success: function(e) {
                        s.setData({
                            is_modal_Hidden: !1
                        });
                    }
                });
            }
        });
    },
    updateUserInfo: function(e) {
        console.log("授权操作更新");
        this.wxauthSetting();
    },
    onShow: function() {
        var e = wx.getStorageSync("comeIn");
        this.setData({
            comeIn: e
        }), this.wxauthSetting();
    },
    onShareAppMessage: function() {}
});