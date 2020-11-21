var app = getApp();

Page({
    data: {
        webflag: 0,
        page_signs: "/sudu8_page/fenxiao_center/fenxiao_center"
    },
    onPullDownRefresh: function() {
        this.fxzxdata(), this.getinfos(), wx.stopPullDownRefresh();
    },
    onLoad: function(a) {
        var e = this;
        e.setData({
            isIphoneX: app.globalData.isIphoneX
        }), wx.setNavigationBarTitle({
            title: "分销中心"
        });
        var t = 0;
        a.fxsid && (t = a.fxsid, e.setData({
            fxsid: a.fxsid
        })), app.util.request({
            url: "entry/wxapp/BaseMin",
            data: {
                vs1: 1
            },
            success: function(a) {
                e.setData({
                    baseinfo: a.data.data
                }), wx.setNavigationBarColor({
                    frontColor: e.data.baseinfo.base_tcolor,
                    backgroundColor: e.data.baseinfo.base_color
                });
            }
        }), app.util.request({
            url: "entry/wxapp/fxddchangestatus",
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(a) {}
        }), app.util.getUserInfo(e.getinfos, t);
    },
    redirectto: function(a) {
        var e = a.currentTarget.dataset.link, t = a.currentTarget.dataset.linktype;
        app.util.redirectto(e, t);
    },
    getinfos: function() {
        var t = this;
        wx.getStorage({
            key: "openid",
            success: function(a) {
                var e = a.data;
                t.setData({
                    openid: e
                }), app.util.request({
                    url: "entry/wxapp/globaluserinfo",
                    data: {
                        openid: e
                    },
                    success: function(a) {
                        var e = a.data.data;
                        e.nickname && e.avatar || t.setData({
                            isview: 1
                        }), t.setData({
                            globaluser: a.data.data
                        });
                    }
                }), t.fxzxdata();
            }
        });
    },
    fxzxdata: function() {
        var o = this, a = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/fxszhongx",
            data: {
                openid: a
            },
            success: function(a) {
                var e = a.data.data.sq, t = a.data.data.user, n = a.data.data.guiz;
                e ? (1 == e.flag && wx.redirectTo({
                    url: "/sudu8_page/fenxiao_s/fenxiao_s?type=1"
                }), 3 == e.flag && wx.redirectTo({
                    url: "/sudu8_page/fenxiao/fenxiao"
                })) : (1 == t.fxs && 1 == n.fxs_sz && wx.redirectTo({
                    url: "/sudu8_page/fenxiao/fenxiao"
                }), 1 == t.fxs && 2 == n.fxs_sz && wx.redirectTo({
                    url: "/sudu8_page/fenxiao/fenxiao"
                }), 1 == t.fxs && 3 == n.fxs_sz && wx.redirectTo({
                    url: "/sudu8_page/fenxiao_s/fenxiao_s?type=4"
                }), 1 == t.fxs && 4 == n.fxs_sz && wx.redirectTo({
                    url: "/sudu8_page/fenxiao_s/fenxiao_s?type=3"
                })), 2 == t.fxsstop && wx.showModal({
                    title: "提示",
                    content: "您的分销商身份已被禁用，点击确定重新申请",
                    showCancel: !1,
                    success: function(a) {
                        return wx.redirectTo({
                            url: "/sudu8_page/fenxiao/fenxiao"
                        }), !1;
                    }
                }), o.setData({
                    usercenter: a.data.data
                });
            }
        });
    },
    my_team: function() {
        wx.navigateTo({
            url: "/sudu8_page/fenxiao_team/fenxiao_team"
        });
    },
    fenxiao_account: function() {
        wx.navigateTo({
            url: "/sudu8_page/fenxiao_account/fenxiao_account"
        });
    },
    account_tixian: function() {
        wx.navigateTo({
            url: "/sudu8_page/fenxiao_tixian/fenxiao_tixian"
        });
    },
    fenxiao_order: function() {
        wx.navigateTo({
            url: "/sudu8_page/fenxiao_order/fenxiao_order"
        });
    },
    tixian_record: function() {
        wx.navigateTo({
            url: "/sudu8_page/fenxiao_tixian_do/fenxiao_tixian_do"
        });
    },
    huoqusq: function() {
        var u = this, f = wx.getStorageSync("openid");
        wx.getUserInfo({
            success: function(a) {
                var e = a.userInfo, t = e.nickName, n = e.avatarUrl, o = e.gender, i = e.province, s = e.city, r = e.country;
                app.util.request({
                    url: "entry/wxapp/Useupdate",
                    data: {
                        openid: f,
                        nickname: t,
                        avatarUrl: n,
                        gender: o,
                        province: i,
                        city: s,
                        country: r
                    },
                    header: {
                        "content-type": "application/json"
                    },
                    success: function(a) {
                        wx.setStorageSync("golobeuid", a.data.data.id), wx.setStorageSync("golobeuser", a.data.data), 
                        u.setData({
                            isview: 0,
                            globaluser: a.data.data
                        });
                    }
                });
            },
            fail: function() {
                app.util.selfinfoget(u.chenggfh);
            }
        });
    },
    chenggfh: function() {
        var a = wx.getStorageSync("golobeuser");
        this.setData({
            isview: 0,
            globaluser: a
        });
    },
    onShareAppMessage: function() {
        return {
            title: "分销中心"
        };
    }
});