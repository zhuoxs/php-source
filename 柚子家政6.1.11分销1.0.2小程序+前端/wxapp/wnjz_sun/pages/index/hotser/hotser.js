var app = getApp(), WxParse = require("../../../../we7/js/wxParse/wxParse.js");

Page({
    data: {
        title: "",
        is_modal_Hidden: !0,
        hidden: !0,
        indicatorDots: !1,
        autoplay: !1,
        interval: 3e3,
        duration: 800,
        hots: [],
        showModalStatus: !1,
        videoSrc: "",
        isIpx: app.globalData.isIpx
    },
    onLoad: function(t) {
        console.log(t);
        var e = this.data.title;
        this.wxauthSetting(), 10 < e.length && (e = e.substr(0, 10) + "..."), this.setData({
            orderid: t.id
        });
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
        var o = t.id, n = t.build_id;
        n && o && app.util.request({
            url: "entry/wxapp/Activeing",
            cachetime: "0",
            data: {
                id: o,
                build_id: n
            },
            success: function(t) {
                console.log(t.data), 1 == t.data ? (wx.showToast({
                    title: "内容不存在",
                    icon: "none",
                    duration: 1e3
                }), wx.reLaunch({
                    url: "/wnjz_sun/pages/index/index"
                })) : wx.setStorageSync("build_id", n);
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        var o = this, n = "";
        app.util.request({
            url: "entry/wxapp/Hotser",
            method: "GET",
            data: {
                id: o.data.orderid
            },
            success: function(t) {
                console.log(t), n = t.data.sele_name, console.log(t.data.sele_name);
                var e = t.data.video;
                o.setData({
                    hots: t.data,
                    videoSrc: e
                }), WxParse.wxParse("article", "html", t.data.content, o, 5), wx.setNavigationBarTitle({
                    title: n
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function(t) {
        var e = wx.getStorageSync("users"), o = this.data.hots, n = wx.getStorageSync("build_id"), a = wx.getStorageSync("url");
        return "button" === t.from && console.log(t.target), {
            title: o.sele_name,
            path: "wnjz_sun/pages/index/hotser/hotser?d_user_id=" + e.id + "&id=" + o.seid + "&build_id=" + n,
            imageUrl: a + o.logo,
            success: function(t) {},
            fail: function(t) {}
        };
    },
    powerDrawer: function(t) {
        var e = t.currentTarget.dataset.statu;
        this.util(e);
    },
    util: function(t) {
        var e = wx.createAnimation({
            duration: 100,
            timingFunction: "linear",
            delay: 0
        });
        (this.animation = e).opacity(0).height(0).step(), this.setData({
            animationData: e.export()
        }), setTimeout(function() {
            e.opacity(1).height("360rpx").step(), this.setData({
                animationData: e
            }), "close" == t && this.setData({
                showModalStatus: !1
            });
        }.bind(this), 200), "open" == t && this.setData({
            showModalStatus: !0
        });
    },
    toBooks: function(t) {
        wx.navigateTo({
            url: "../classify/classify"
        });
    },
    shareCanvas: function() {
        var t = wx.getStorageSync("users"), e = wx.getStorageSync("build_id"), o = wx.getStorageSync("url"), n = wx.getStorageSync("system"), a = this.data.hots, s = [];
        s.goodspicbg = n.poster_img, s.bname = a.sele_name, s.url = o, s.logo = a.logo, 
        s.pname = n.pt_name, s.scene = "d_user_id=" + t.id + "&id=" + a.seid + "&build_id=" + e, 
        console.log(s), app.creatPoster("wnjz_sun/pages/index/hotser/hotser", 430, s, 1, "shareImg"), 
        this.setData({
            showModalStatus: !1
        });
    },
    hidden: function(t) {
        this.setData({
            hidden: !0
        });
    },
    save: function() {
        var e = this;
        wx.saveImageToPhotosAlbum({
            filePath: e.data.prurl,
            success: function(t) {
                wx.showModal({
                    content: "图片已保存到相册，赶紧晒一下吧~",
                    showCancel: !1,
                    confirmText: "好哒",
                    confirmColor: "#ef8200",
                    success: function(t) {
                        t.confirm && (console.log("用户点击确定"), e.setData({
                            hidden: !0
                        }));
                    }
                });
            },
            fail: function(t) {
                console.log("失败"), wx.getSetting({
                    success: function(t) {
                        t.authSetting["scope.writePhotosAlbum"] || (console.log("进入信息授权开关页面"), wx.openSetting({
                            success: function(t) {
                                console.log("openSetting success", t.authSetting);
                            }
                        }));
                    }
                });
            }
        });
    },
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
                                var o = t.userInfo.nickName, n = t.userInfo.avatarUrl, a = t.userInfo.gender;
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
                                        wx.setStorage({
                                            key: "openid",
                                            data: e
                                        }), app.util.request({
                                            url: "entry/wxapp/Login",
                                            cachetime: "0",
                                            data: {
                                                openid: e,
                                                img: n,
                                                name: o,
                                                gender: a
                                            },
                                            success: function(t) {
                                                console.log("进入地址login"), console.log(t.data), wx.setStorageSync("users", t.data), 
                                                wx.setStorageSync("uniacid", t.data.uniacid), s.setData({
                                                    usersinfo: t.data
                                                });
                                            }
                                        });
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