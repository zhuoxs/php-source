var app = getApp();

Page({
    data: {
        page_signs: "/sudu8_page/coupon/coupon",
        couponlist: [],
        baseinfo: [],
        footer: {
            i_tel: app.globalData.i_tel,
            i_add: app.globalData.i_add,
            i_time: app.globalData.i_time,
            i_view: app.globalData.i_view,
            close: app.globalData.close,
            v_ico: app.globalData.v_ico
        }
    },
    onPullDownRefresh: function() {
        this.getBase(), this.getList(), this.couset(), this.refreshSessionkey(), wx.stopPullDownRefresh();
    },
    onLoad: function(t) {
        var a = this;
        a.setData({
            isIphoneX: app.globalData.isIphoneX
        });
        var e = 0;
        t.fxsid && (e = t.fxsid, a.setData({
            fxsid: t.fxsid
        })), a.checkvip(), a.getBase(), a.refreshSessionkey(), app.util.getUserInfo(a.getinfos, e);
    },
    getinfos: function() {
        var a = this;
        wx.getStorage({
            key: "openid",
            success: function(t) {
                a.setData({
                    openid: t.data
                }), a.getList(), a.couset();
            }
        });
    },
    checkvip: function() {
        var a = this, t = wx.getStorageSync("openid");
        wx.request({
            url: app.util.url("entry/wxapp/checkvip", {
                m: "sudu8_page"
            }),
            data: {
                kwd: "coupon",
                openid: t
            },
            success: function(t) {
                t.data.data || (a.setData({
                    needvip: !0
                }), wx.showModal({
                    title: "进入失败",
                    content: "使用本功能需先开通vip!",
                    showCancel: !1,
                    success: function(t) {
                        t.confirm && wx.redirectTo({
                            url: "/sudu8_page/register/register"
                        });
                    }
                }));
            },
            fail: function(t) {}
        });
    },
    redirectto: function(t) {
        var a = t.currentTarget.dataset.link, e = t.currentTarget.dataset.linktype;
        app.util.redirectto(a, e);
    },
    getBase: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/BaseMin",
            cachetime: "30",
            data: {
                vs1: 1
            },
            success: function(t) {
                a.setData({
                    baseinfo: t.data.data
                }), wx.setNavigationBarTitle({
                    title: "领取优惠券"
                }), wx.setNavigationBarColor({
                    frontColor: a.data.baseinfo.base_tcolor,
                    backgroundColor: a.data.baseinfo.base_color
                });
            },
            fail: function(t) {}
        });
    },
    getList: function(t) {
        var a = this;
        app.util.request({
            url: "entry/wxapp/coupon",
            data: {
                openid: a.data.openid
            },
            success: function(t) {
                a.setData({
                    couponlist: t.data.data
                }), wx.hideNavigationBarLoading(), wx.stopPullDownRefresh();
            },
            fail: function(t) {}
        });
    },
    getit: function(i) {
        var o = this;
        wx.getStorage({
            key: "openid",
            success: function(t) {
                var a = t.data;
                if (a) {
                    var e = i;
                    app.util.request({
                        url: "entry/wxapp/getcoupon",
                        data: {
                            id: e,
                            openid: a
                        },
                        success: function(t) {
                            1 == t.data.data && (wx.showToast({
                                title: "领取成功",
                                icon: "success",
                                duration: 2e3
                            }), setTimeout(function() {
                                o.getList();
                            }, 500)), 2 == t.data.data && (wx.showToast({
                                title: "领取失败",
                                icon: "loading",
                                duration: 4e3
                            }), setTimeout(function() {
                                o.getList();
                            }, 500));
                        },
                        fail: function(t) {}
                    });
                } else o.getList();
            }
        });
    },
    getit_zj: function(t) {
        var e = this, i = t.currentTarget.id;
        wx.getStorage({
            key: "openid",
            success: function(t) {
                var a = t.data;
                a ? app.util.request({
                    url: "entry/wxapp/getcoupon",
                    data: {
                        id: i,
                        openid: a
                    },
                    success: function(t) {
                        1 == t.data.data && (wx.showToast({
                            title: "领取成功",
                            icon: "success",
                            duration: 2e3
                        }), setTimeout(function() {
                            e.getList();
                        }, 500)), 2 == t.data.data && (wx.showToast({
                            title: "领取失败",
                            icon: "loading",
                            duration: 4e3
                        }), setTimeout(function() {
                            e.getList();
                        }, 500));
                    },
                    fail: function(t) {}
                }) : e.getList();
            }
        });
    },
    mycoupp: function() {
        wx.redirectTo({
            url: "/sudu8_page/mycoupon/mycoupon"
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
        return {
            title: this.data.cateinfo.name + "-" + this.data.baseinfo.name
        };
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
    getPhoneNumber: function(e) {
        var i = this, t = e.detail.iv, a = e.detail.encryptedData;
        "getPhoneNumber:ok" == e.detail.errMsg ? wx.checkSession({
            success: function() {
                app.util.request({
                    url: "entry/wxapp/jiemiNew",
                    data: {
                        encryptedData: a,
                        iv: t,
                        newSessionKey: i.data.newSessionKey
                    },
                    success: function(t) {
                        if (t.data.data) {
                            var a = t.data.data;
                            app.util.request({
                                url: "entry/wxapp/mobilesetuser",
                                data: {
                                    openid: i.data.openid,
                                    mobile: a
                                },
                                success: function(t) {
                                    var a = e.currentTarget.id;
                                    i.getit(a), i.setData({
                                        shouj: 2
                                    });
                                }
                            });
                        } else wx.showModal({
                            title: "提示",
                            content: "sessionKey已过期，请下拉刷新！"
                        });
                    }
                });
            },
            fail: function() {
                wx.showModal({
                    title: "提示",
                    content: "sessionKey已过期，请下拉刷新！"
                });
            }
        }) : wx.showModal({
            title: "提醒",
            content: "领取优惠券时，请先授权获取您的手机号！",
            showCancel: !1
        });
    },
    couset: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/couponset",
            success: function(t) {
                var a = 1;
                a = t.data.data ? t.data.data.flag : 1, e.setData({
                    kaiq: a
                });
            }
        }), app.util.request({
            url: "entry/wxapp/globaluserinfo",
            data: {
                openid: e.data.openid
            },
            success: function(t) {
                var a = 1;
                a = t.data.data.mobile ? 2 : 1, e.setData({
                    shouj: a
                });
            }
        });
    }
});