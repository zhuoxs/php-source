var app = getApp();

Page({
    data: {
        goods_id: "",
        centText: [],
        aid: "",
        is_modal_Hidden: !0,
        isLogin: !0
    },
    onLoad: function(o) {
        console.log(o);
        var e = o.id, n = o.goods_id, t = this;
        t.setData({
            goods_id: n,
            aid: e
        }), t.wxauthSetting(), app.util.request({
            url: "entry/wxapp/GoodsArticle",
            data: {
                id: e
            },
            success: function(o) {
                t.setData({
                    centText: o.data.article
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function(o) {
        var e = this.data.aid, n = this.data.goods_id;
        return "button" === o.from && console.log(o.target), {
            title: "文章推荐",
            path: "/byjs_sun/pages/product/writings/writingsInfo/writingsInfo?id=" + e + "&goods_id=" + n,
            desc: "最好的健身小程序",
            success: function(o) {},
            fail: function(o) {}
        };
    },
    toIndex: function(o) {
        wx.redirectTo({
            url: "/byjs_sun/pages/product/index/index"
        });
    },
    toActive: function(o) {
        wx.navigateTo({
            url: "/byjs_sun/pages/product/active/active"
        });
    },
    goProductInfo: function(o) {
        if (0 == this.data.goods_id) wx.showModal({
            title: "提示",
            content: "商品还未上架"
        }); else {
            var e = o.currentTarget.dataset.id;
            wx.navigateTo({
                url: "/byjs_sun/pages/charge/chargeProductInfo/chargeProductInfo?id=" + e
            });
        }
    },
    wxauthSetting: function(o) {
        var a = this;
        wx.getStorageSync("openid") ? wx.getSetting({
            success: function(o) {
                console.log("进入wx.getSetting 1"), console.log(o), o.authSetting["scope.userInfo"] ? (console.log("scope.userInfo已授权 1"), 
                wx.getUserInfo({
                    success: function(o) {
                        a.setData({
                            is_modal_Hidden: !0,
                            thumb: o.userInfo.avatarUrl,
                            nickname: o.userInfo.nickName
                        });
                    }
                })) : (console.log("scope.userInfo没有授权 1"), wx.showModal({
                    title: "获取信息失败",
                    content: "请允许授权以便为您提供给服务",
                    success: function(o) {
                        a.setData({
                            is_modal_Hidden: !1
                        });
                    }
                }));
            },
            fail: function(o) {
                console.log("获取权限失败 1"), a.setData({
                    is_modal_Hidden: !1
                });
            }
        }) : wx.login({
            success: function(o) {
                console.log("进入wx-login");
                var e = o.code;
                wx.setStorageSync("code", e), wx.getSetting({
                    success: function(o) {
                        console.log("进入wx.getSetting"), console.log(o), o.authSetting["scope.userInfo"] ? (console.log("scope.userInfo已授权"), 
                        wx.getUserInfo({
                            success: function(o) {
                                a.setData({
                                    is_modal_Hidden: !0,
                                    thumb: o.userInfo.avatarUrl,
                                    nickname: o.userInfo.nickName
                                }), console.log("进入wx-getUserInfo"), console.log(o.userInfo), wx.setStorageSync("user_info", o.userInfo);
                                var n = o.userInfo.nickName, t = o.userInfo.avatarUrl, s = o.userInfo.gender;
                                app.util.request({
                                    url: "entry/wxapp/openid",
                                    cachetime: "0",
                                    data: {
                                        code: e
                                    },
                                    success: function(o) {
                                        console.log("进入获取openid"), console.log(o.data), wx.setStorageSync("key", o.data.session_key);
                                        var e = o.data.openid;
                                        wx.setStorageSync("userid", o.data.openid), wx.setStorage({
                                            key: "openid",
                                            data: e
                                        }), app.util.request({
                                            url: "entry/wxapp/Login",
                                            cachetime: "0",
                                            data: {
                                                openid: e,
                                                img: t,
                                                name: n,
                                                gender: s
                                            },
                                            success: function(o) {
                                                console.log("进入地址login"), console.log(o.data), wx.setStorageSync("users", o.data), 
                                                wx.setStorageSync("uniacid", o.data.uniacid), a.setData({
                                                    usersinfo: o.data
                                                });
                                            }
                                        });
                                    }
                                });
                            },
                            fail: function(o) {
                                console.log("进入 wx-getUserInfo 失败"), wx.showModal({
                                    title: "获取信息失败",
                                    content: "请允许授权以便为您提供给服务!",
                                    success: function(o) {
                                        a.setData({
                                            is_modal_Hidden: !1
                                        });
                                    }
                                });
                            }
                        })) : (console.log("scope.userInfo没有授权"), a.setData({
                            is_modal_Hidden: !1
                        }));
                    }
                });
            },
            fail: function() {
                wx.showModal({
                    title: "获取信息失败",
                    content: "请允许授权以便为您提供给服务!!!",
                    success: function(o) {
                        a.setData({
                            is_modal_Hidden: !1
                        });
                    }
                });
            }
        });
    },
    updateUserInfo: function(o) {
        console.log("授权操作更新");
        this.wxauthSetting();
    }
});