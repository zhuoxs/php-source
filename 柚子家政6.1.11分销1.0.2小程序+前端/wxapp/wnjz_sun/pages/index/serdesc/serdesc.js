var app = getApp(), WxParse = require("../../../../we7/js/wxParse/wxParse.js");

Page({
    data: {
        order: [],
        is_modal_Hidden: !0,
        url: [],
        curIndex: 0,
        comment: [],
        imgUrls: [ "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152202745503.png", "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152202745488.png", "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152202745503.png", "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/15220274544.png" ],
        isIpx: app.globalData.isIpx
    },
    onLoad: function(e) {
        var o = this;
        o.wxauthSetting(), o.getUrl(), wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), o.setData({
            orderid: e.id
        });
    },
    getUrl: function() {
        var o = this;
        app.util.request({
            url: "entry/wxapp/url",
            cachetime: "30",
            success: function(e) {
                wx.setStorageSync("url", e.data), o.setData({
                    url: e.data
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        var o = this;
        app.util.request({
            url: "entry/wxapp/Ordercheck",
            method: "GET",
            data: {
                id: o.data.orderid
            },
            success: function(e) {
                console.log(e.data);
                e.data.shopprice;
                o.setData({
                    order: e.data.goods,
                    comment: e.data.comment
                }), WxParse.wxParse("article", "html", e.data.goods.content, o, 5);
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    serviceTap: function(e) {
        var o = parseInt(e.currentTarget.dataset.index);
        this.setData({
            curIndex: o
        });
    },
    toOrder: function(e) {
        var o = e.currentTarget.dataset.gid;
        app.util.request({
            url: "entry/wxapp/CheckGoods",
            method: "GET",
            data: {
                gid: o
            },
            success: function(e) {
                wx.navigateTo({
                    url: "../order/order?id=" + o
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
                var o = e.code;
                wx.setStorageSync("code", o), wx.getSetting({
                    success: function(e) {
                        console.log("进入wx.getSetting"), console.log(e), e.authSetting["scope.userInfo"] ? (console.log("scope.userInfo已授权"), 
                        wx.getUserInfo({
                            success: function(e) {
                                s.setData({
                                    is_modal_Hidden: !0,
                                    thumb: e.userInfo.avatarUrl,
                                    nickname: e.userInfo.nickName
                                }), console.log("进入wx-getUserInfo"), console.log(e.userInfo), wx.setStorageSync("user_info", e.userInfo);
                                var t = e.userInfo.nickName, n = e.userInfo.avatarUrl, a = e.userInfo.gender;
                                app.util.request({
                                    url: "entry/wxapp/openid",
                                    cachetime: "0",
                                    data: {
                                        code: o
                                    },
                                    success: function(e) {
                                        console.log("进入获取openid"), console.log(e.data), wx.setStorageSync("key", e.data.session_key), 
                                        wx.setStorageSync("openid", e.data.openid);
                                        var o = e.data.openid;
                                        wx.setStorage({
                                            key: "openid",
                                            data: o
                                        }), app.util.request({
                                            url: "entry/wxapp/Login",
                                            cachetime: "0",
                                            data: {
                                                openid: o,
                                                img: n,
                                                name: t,
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