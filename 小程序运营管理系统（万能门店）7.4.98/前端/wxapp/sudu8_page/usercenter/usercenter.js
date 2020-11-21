var app = getApp();

Page({
    data: {
        page_signs: "/sudu8_page/usercenter/usercenter",
        member_card: "1",
        isview: 0,
        money: 0,
        score: 0,
        coupon: 0,
        vipset: 1,
        viptext: "6688",
        flag: !1,
        vipflag: 1
    },
    onLoad: function(a) {
        var t = this;
        t.setData({
            isIphoneX: app.globalData.isIphoneX
        }), wx.setNavigationBarTitle({
            title: "个人中心"
        });
        var e = 0;
        a.fxsid && (e = a.fxsid, t.setData({
            fxsid: a.fxsid
        })), t.getBase(), app.util.getUserInfo(t.getinfos, e);
    },
    redirectto: function(a) {
        var t = a.currentTarget.dataset.link, e = a.currentTarget.dataset.linktype;
        app.util.redirectto(t, e);
    },
    getinfos: function() {
        var t = this;
        wx.getStorage({
            key: "openid",
            success: function(a) {
                t.setData({
                    openid: a.data
                }), t.getinfo(), t.peizhi();
            }
        });
    },
    getBase: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/BaseMin",
            cachetime: "30",
            data: {
                vs1: 1
            },
            success: function(a) {
                t.setData({
                    baseinfo: a.data.data
                }), wx.setNavigationBarColor({
                    frontColor: t.data.baseinfo.base_tcolor,
                    backgroundColor: t.data.baseinfo.base_color
                });
            },
            fail: function(a) {}
        });
    },
    getinfo: function() {
        var e = this;
        wx.getStorage({
            key: "openid",
            success: function(a) {
                app.util.request({
                    url: "entry/wxapp/globaluserinfo",
                    data: {
                        openid: a.data
                    },
                    success: function(a) {
                        var t = a.data.data;
                        t.nickname && t.avatar || e.setData({
                            isview: 1
                        }), e.setData({
                            globaluser: a.data.data
                        });
                    }
                }), app.util.request({
                    url: "entry/wxapp/mymoney",
                    data: {
                        openid: a.data
                    },
                    success: function(a) {
                        "2" != a.data.data.vipset || a.data.data.vipid ? a.data.data.vipid ? e.setData({
                            viptext: a.data.data.vipid.substr(12, 4),
                            isvip: !0
                        }) : (3 == a.data.data.vipflag ? e.setData({
                            vipflag: 3
                        }) : 2 == a.data.data.vipflag ? e.setData({
                            vipflag: 2
                        }) : 4 == a.data.data.vipflag && e.setData({
                            vipflag: 1
                        }), e.setData({
                            isvip: !1
                        })) : (3 == a.data.data.vipflag ? e.setData({
                            vipflag: 3
                        }) : 2 == a.data.data.vipflag ? e.setData({
                            vipflag: 2
                        }) : 4 == a.data.data.vipflag && e.setData({
                            vipflag: 4
                        }), e.setData({
                            needVip: !0
                        })), e.setData({
                            userbg: a.data.data.userbg,
                            money: a.data.data.money,
                            score: a.data.data.score,
                            coupon: a.data.data.couponNum,
                            cardname: a.data.data.cardname,
                            grade: a.data.data.grade,
                            vipname: a.data.data.vipname,
                            is: a.data.data.is,
                            equity_flag: a.data.data.is.flag,
                            vipset: a.data.data.vipset
                        });
                    }
                });
            }
        });
    },
    peizhi: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/updatausersetnew",
            success: function(a) {
                t.setData({
                    fxzzd: a.data.data.arrs,
                    myorder: a.data.data.myorder,
                    mysign: a.data.data.mysign
                });
            }
        });
    },
    onReady: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        this.getinfos(), wx.stopPullDownRefresh();
    },
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    makePhoneCall: function(a) {
        var t = this.data.baseinfo.tel;
        wx.makePhoneCall({
            phoneNumber: t
        });
    },
    makePhoneCallB: function(a) {
        var t = this.data.baseinfo.tel_b;
        wx.makePhoneCall({
            phoneNumber: t
        });
    },
    openMap: function(a) {
        var t = this;
        wx.openLocation({
            latitude: parseFloat(t.data.baseinfo.latitude),
            longitude: parseFloat(t.data.baseinfo.longitude),
            name: t.data.baseinfo.name,
            address: t.data.baseinfo.address,
            scale: 22
        });
    },
    refreshSessionkey: function() {
        var t = this;
        wx.login({
            success: function(a) {
                app.util.request({
                    url: "entry/wxapp/getNewSessionkey",
                    data: {
                        code: a.code
                    },
                    success: function(a) {
                        t.setData({
                            newSessionKey: a.data.data
                        });
                    }
                });
            }
        });
    },
    huoqusq: function(a) {
        var t = this, e = wx.getStorageSync("openid");
        if (a.detail.userInfo) {
            var n = a.detail.userInfo, i = n.nickName, s = n.avatarUrl, o = n.gender, d = n.province, r = n.city, u = n.country;
            app.util.request({
                url: "entry/wxapp/Useupdate",
                data: {
                    openid: e,
                    nickname: i,
                    avatarUrl: s,
                    gender: o,
                    province: d,
                    city: r,
                    country: u
                },
                header: {
                    "content-type": "application/json"
                },
                success: function(a) {
                    wx.setStorageSync("golobeuid", a.data.data.id), wx.setStorageSync("golobeuser", a.data.data), 
                    t.setData({
                        isview: 0,
                        globaluser: a.data.data
                    }), t.getinfo();
                }
            });
        } else wx.showModal({
            title: "获取失败",
            content: "请您允许授权",
            showCancel: !1,
            success: function(a) {
                a.confirm && wx.getSetting({
                    success: function(a) {
                        a.authSetting["scope.userInfo"] || wx.openSetting({
                            success: function(a) {
                                wx.reLaunch({
                                    url: "/sudu8_page/usercenter/usercenter"
                                });
                            }
                        });
                    }
                });
            }
        });
    },
    toRegisterVIP: function() {
        wx.navigateTo({
            url: "/sudu8_page/register/register"
        });
    },
    toSign: function() {
        wx.navigateTo({
            url: "/sudu8_page_plugin_sign/index/index"
        });
    },
    toRegisterSuccess: function() {
        wx.navigateTo({
            url: "/sudu8_page/register_success/register_success?fr=1"
        });
    },
    setVipText: function(a) {
        this.setData({
            viptext: a
        });
    },
    cancel: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/changeReceive",
            data: {
                id: t.data.is.id
            },
            success: function(a) {
                t.setData({
                    equity_flag: 1
                });
            }
        });
    }
});