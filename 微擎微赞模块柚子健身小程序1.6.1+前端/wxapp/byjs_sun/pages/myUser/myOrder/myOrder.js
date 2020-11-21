var app = getApp();

Page({
    data: {
        order: [],
        is_modal_Hidden: !0,
        isLogin: !0,
        goId: 1
    },
    onLoad: function(e) {
        var t = this;
        t.wxauthSetting(), app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            success: function(e) {
                wx.setStorageSync("url", e.data), t.setData({
                    url: e.data
                });
            }
        });
        var o = wx.getStorageSync("users").id;
        app.util.request({
            url: "entry/wxapp/OrderMy",
            data: {
                goId: 1,
                user_id: o
            },
            cachetime: 0,
            success: function(e) {
                console.log(e), t.setData({
                    order: e.data,
                    total: e.data.money
                });
            }
        });
    },
    onReady: function() {},
    gohome: function() {
        wx.redirectTo({
            url: "../../product/index/index"
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    orderTab: function(e) {
        var t = this;
        console.log(e);
        var o = Number(e.currentTarget.dataset.id), n = wx.getStorageSync("users").id;
        app.util.request({
            url: "entry/wxapp/OrderMy",
            data: {
                goId: o,
                user_id: n
            },
            cachetime: 0,
            success: function(e) {
                t.setData({
                    order: e.data,
                    total: e.data.money
                });
            }
        }), t.setData({
            goId: o
        });
    },
    goPay: function(e) {
        var o = e.currentTarget.dataset.id, n = e.currentTarget.dataset.money;
        e.currentTarget.dataset.name, wx.getStorageSync("users").user_name, wx.getStorageSync("users").user_tel;
        wx.getStorage({
            key: "openid",
            success: function(e) {
                var t = e.data;
                console.log(t), app.util.request({
                    url: "entry/wxapp/Orderarr",
                    cachetime: "30",
                    data: {
                        price: n,
                        openid: t
                    },
                    success: function(e) {
                        wx.getStorageSync("users").id;
                        console.log("-----直接购买=------");
                        var t = o;
                        console.log(t), wx.requestPayment({
                            timeStamp: e.data.timeStamp,
                            nonceStr: e.data.nonceStr,
                            package: e.data.package,
                            signType: "MD5",
                            paySign: e.data.paySign,
                            success: function(e) {
                                wx.showToast({
                                    title: "支付成功",
                                    icon: "success",
                                    duration: 2e3
                                }), app.util.request({
                                    url: "entry/wxapp/PayOrder",
                                    cachetime: "0",
                                    data: {
                                        order_id: t
                                    },
                                    success: function(e) {}
                                }), wx.navigateTO({
                                    url: "../../product/index/index"
                                });
                            },
                            fail: function(e) {
                                console.log(e + "ssssss");
                            }
                        });
                    }
                });
            }
        });
    },
    goToCall: function(e) {
        wx.showLoading({
            title: "商家收到提醒"
        }), setTimeout(function() {
            wx.hideLoading();
        }, 2e3);
    },
    goToPay: function(e) {
        var t = e.currentTarget.dataset.id;
        app.util.request({
            url: "entry/wxapp/ConfirmR",
            data: {
                id: t
            },
            cachetime: 0,
            success: function(e) {
                wx.redirectTo({
                    url: "../my/my"
                });
            }
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
                                }), console.log("进入wx-getUserInfo"), console.log(e.userInfo), wx.setStorageSync("user_info", e.userInfo);
                                var o = e.userInfo.nickName, n = e.userInfo.avatarUrl, a = e.userInfo.gender;
                                app.util.request({
                                    url: "entry/wxapp/openid",
                                    cachetime: "0",
                                    data: {
                                        code: t
                                    },
                                    success: function(e) {
                                        console.log("进入获取openid"), console.log(e.data), wx.setStorageSync("key", e.data.session_key);
                                        var t = e.data.openid;
                                        wx.setStorageSync("userid", e.data.openid), wx.setStorage({
                                            key: "openid",
                                            data: t
                                        }), app.util.request({
                                            url: "entry/wxapp/Login",
                                            cachetime: "0",
                                            data: {
                                                openid: t,
                                                img: n,
                                                name: o,
                                                gender: a
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