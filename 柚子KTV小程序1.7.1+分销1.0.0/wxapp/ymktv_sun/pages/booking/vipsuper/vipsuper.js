var app = getApp();

Page({
    data: {
        msg: "享受会员折扣、超市会员折扣、会员积分、会员生日礼遇；在厦门区以外的欢唱KTV可享受会员折扣；如有不明之处请致电4000 917 888进行咨询。",
        authority: [ {
            imgSrc: "../../../resource/images/new/nav1.png",
            name: "超市商品9折",
            state: !0
        }, {
            imgSrc: "../../../resource/images/new/nav2.png",
            name: "包厢折扣",
            state: !0
        }, {
            imgSrc: "../../../resource/images/new/nav3.png",
            name: "生日礼品",
            state: !0
        }, {
            imgSrc: "../../../resource/images/new/nav4.png",
            name: "招待果盘2份",
            state: !0
        }, {
            imgSrc: "../../../resource/images/new/nav5.png",
            name: "会员日特惠",
            state: !0
        }, {
            imgSrc: "../../../resource/images/new/nav6.png",
            name: "美食优惠",
            state: !0
        } ],
        is_modal_Hidden: !0,
        isopen: "",
        list: []
    },
    onLoad: function(e) {
        var t = this;
        t.wxauthSetting(), app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "0",
            success: function(e) {
                wx.setStorageSync("url", e.data), t.setData({
                    url: e.data
                });
            }
        }), this.getMember();
    },
    getMember: function() {
        var t = this, e = wx.getStorageSync("openid"), n = wx.getStorageSync("userInfo");
        app.util.request({
            url: "entry/wxapp/vipRecharge",
            cachetime: "0",
            data: {
                openid: e
            },
            success: function(e) {
                console.log(e.data), console.log(e.data.recharge), t.setData({
                    list: e.data.recharge,
                    isopen: e.data.isopen,
                    details: e.data.details,
                    userInfo: n,
                    iscun: e.data.iscun
                });
            }
        });
    },
    goViptwo: function() {
        wx.getStorageSync("openid") ? wx.navigateTo({
            url: "../viptwo/viptwo"
        }) : this.wxauthSetting();
    },
    submit: function(e) {
        var t = wx.getStorageSync("openid"), n = e.currentTarget.dataset.recharge;
        if (1 != this.data.isopen) return wx.showModal({
            title: "提示",
            content: "您不是会员，是否前往普通充值！",
            success: function(e) {
                e.confirm && wx.redirectTo({
                    url: "/ymktv_sun/pages/my/mybalance/mybalance"
                });
            }
        }), !1;
        "" != n ? app.util.request({
            url: "entry/wxapp/Orderarr",
            cachetime: "30",
            data: {
                openid: t,
                price: n
            },
            success: function(e) {
                console.log(e.data);
                e.data.package;
                wx.requestPayment({
                    timeStamp: e.data.timeStamp,
                    nonceStr: e.data.nonceStr,
                    package: e.data.package,
                    signType: "MD5",
                    paySign: e.data.paySign,
                    success: function(e) {
                        app.util.request({
                            url: "entry/wxapp/Rechargeamount",
                            cachetime: "0",
                            data: {
                                openid: t,
                                total: n
                            },
                            success: function(e) {
                                1 == e.data ? (wx.showToast({
                                    title: "充值成功！",
                                    icon: "success",
                                    duration: 2e3
                                }), wx.navigateTo({
                                    url: "/ymktv_sun/pages/my/mybalance/mybalance"
                                })) : wx.showToast({
                                    title: "充值失败！",
                                    icon: "none",
                                    duration: 2e3
                                });
                            }
                        });
                    },
                    fail: function(e) {}
                });
            }
        }) : wx.showToast({
            title: "请输入金额",
            icon: "none",
            duration: 2e3
        });
    },
    onReady: function() {},
    onShow: function() {
        var t = this, e = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/UserVipData",
            cachetime: "0",
            data: {
                openid: e
            },
            success: function(e) {
                console.log(e.data), t.setData({
                    vipData: e.data
                });
            }
        }), wx.getUserInfo({
            success: function(e) {
                t.setData({
                    userInfo: e.userInfo
                });
            }
        });
    },
    goXufei: function(e) {
        wx.navigateTo({
            url: "../viptwo/viptwo"
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    goVipindex: function() {
        wx.navigateTo({
            url: "../vipindex/vipindex"
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
                })) : (console.log("scope.userInfo没有授权 1"), wx.showModal({
                    title: "获取信息失败",
                    content: "请允许授权以便为您提供给服务",
                    success: function(e) {
                        s.setData({
                            is_modal_Hidden: !1
                        });
                    }
                }));
            },
            fail: function(e) {
                console.log("获取权限失败 1"), s.setData({
                    is_modal_Hidden: !1
                });
            }
        }) : wx.login({
            success: function(e) {
                console.log("进入wx-login");
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
                                }), console.log("进入wx-getUserInfo"), console.log(e.userInfo), wx.setStorageSync("user_info", e.userInfo), 
                                wx.setStorageSync("userInfo", e.userInfo);
                                var n = e.userInfo.nickName, a = e.userInfo.avatarUrl, o = e.userInfo.gender;
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
                                        console.log(t), wx.setStorageSync("userid", e.data.openid), wx.setStorage({
                                            key: "openid",
                                            data: t
                                        }), console.log(n), app.util.request({
                                            url: "entry/wxapp/Login",
                                            cachetime: "0",
                                            data: {
                                                openid: t,
                                                img: a,
                                                name: n,
                                                gender: o
                                            },
                                            success: function(e) {
                                                console.log("进入地址login"), console.log(e.data), wx.setStorageSync("users", e.data), 
                                                wx.setStorageSync("uniacid", e.data.uniacid), s.setData({
                                                    usersinfo: e.data
                                                }), s.onShow();
                                            }
                                        });
                                    }
                                });
                            },
                            fail: function(e) {
                                console.log("进入 wx-getUserInfo 失败"), wx.showModal({
                                    title: "获取信息失败",
                                    content: "请允许授权以便为您提供给服务!",
                                    success: function(e) {
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
    }
});