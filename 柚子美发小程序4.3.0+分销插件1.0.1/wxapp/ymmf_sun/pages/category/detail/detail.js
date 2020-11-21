var _Page;

function _defineProperty(e, t, o) {
    return t in e ? Object.defineProperty(e, t, {
        value: o,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : e[t] = o, e;
}

var app = getApp();

Page((_defineProperty(_Page = {
    data: {
        isIpx: app.globalData.isIpx,
        indicatorDots: !0,
        autoplay: !0,
        interval: 5e3,
        duration: 1e3,
        detImg: [ "../../../../style/images/img2.png", "../../../../style/images/img3.png" ],
        showModalStatus: !1,
        value: !1,
        is_modal_Hidden: !0,
        active: !1
    },
    onLoad: function(e) {
        var t = this;
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), console.log(e);
        var o = e.id, n = (e.build_id, e.pic);
        wx.setStorageSync("bid", e.build_id);
        var a = app.func.decodeScene(e);
        a.id && (o = a.id), a.bid && a.bid, t.setData({
            id: o,
            pic: n
        }), t.urls(), t.wxauthSetting(), t.wxauthSetting(), app.util.request({
            url: "entry/wxapp/GoodDetails",
            cachetime: "30",
            data: {
                id: o
            },
            success: function(e) {
                1 == e.data.data.nowstatus && t.setData({
                    active: !0
                }), t.setData({
                    details: e.data.data
                });
            }
        }), wx.setNavigationBarTitle({
            title: e.name
        });
    },
    urls: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/Url2",
            cachetime: "0",
            success: function(e) {
                wx.setStorageSync("url2", e.data);
            }
        }), app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "0",
            success: function(e) {
                wx.setStorageSync("url", e.data), t.setData({
                    url: e.data
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        this.wxauthSetting(), this.Branch();
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    styorder: function(e) {
        wx.navigateTo({
            url: "../../index/hairs/hairs?good_id=" + e.currentTarget.dataset.id
        });
    },
    onReachBottom: function() {},
    onShareAppMessage: function(e) {
        var t = this.data.id, o = wx.getStorageSync("users");
        return {
            title: this.data.details.goods_name,
            path: "/ymmf_sun/pages/category/detail/detail?d_user_id=" + o.id + "&id=" + t
        };
    },
    powerDrawer: function(e) {
        var t = e.currentTarget.dataset.statu;
        this.util(t);
    },
    util: function(e) {
        var t = wx.createAnimation({
            duration: 100,
            timingFunction: "linear",
            delay: 0
        });
        (this.animation = t).opacity(0).height(0).step(), this.setData({
            animationData: t.export()
        }), setTimeout(function() {
            t.opacity(1).height("360rpx").step(), this.setData({
                animationData: t
            }), "close" == e && this.setData({
                showModalStatus: !1
            });
        }.bind(this), 200), "open" == e && this.setData({
            showModalStatus: !0
        });
    },
    getPrompt: function() {
        this.setData({
            value: !0
        });
    },
    shareCanvas: function() {
        var e = this;
        setTimeout(function() {
            e.getPrompt();
        }, 2800);
        var t = wx.getStorageSync("build_id");
        console.log("你的门店id是多少" + t);
        var o = wx.getStorageSync("url"), n = wx.getStorageSync("goodspicbg"), a = (wx.getStorageSync("users"), 
        e.data.details), s = [];
        s.bname = a.goods_name, s.url = o, s.logo = this.data.pic, s.goodspicbg = n, s.price = a.goods_price, 
        s.scene = "id=" + this.data.id + "&build_id=" + t, app.Func.func.creatPoster2("ymmf_sun/pages/category/detail/detail", 430, s, 1, "shareImg"), 
        e.setData({
            shareMask: !1
        });
    },
    hidden: function(e) {
        this.setData({
            hidden: !0,
            value: !1
        });
    },
    save: function() {
        var t = this;
        console.log("你有执行吗"), wx.saveImageToPhotosAlbum({
            filePath: t.data.prurl,
            success: function(e) {
                console.log("成功"), wx.showModal({
                    content: "图片已保存到相册，赶紧晒一下吧~",
                    showCancel: !1,
                    confirmText: "好哒",
                    confirmColor: "#ef8200",
                    success: function(e) {
                        e.confirm && (console.log("用户点击确定"), t.setData({
                            hidden: !0
                        }));
                    }
                });
            },
            fail: function(e) {
                console.log("失败"), wx.getSetting({
                    success: function(e) {
                        e.authSetting["scope.writePhotosAlbum"] || (console.log("进入信息授权开关页面"), wx.openSetting({
                            success: function(e) {
                                console.log("openSetting success", e.authSetting);
                            }
                        }));
                    }
                });
            }
        });
    },
    unshare: function() {
        this.setData({
            shareMask: !1
        });
    },
    tapShare: function() {
        this.setData({
            shareMask: !0
        });
    },
    wxauthSetting: function(e) {
        var s = this, t = wx.getStorageSync("openid");
        if (t) {
            var o = wx.getStorageSync("user_info"), n = o.nickName, a = o.avatarUrl, i = o.gender;
            app.util.request({
                url: "entry/wxapp/Login",
                cachetime: "0",
                data: {
                    openid: t,
                    img: a,
                    name: n,
                    gender: i
                },
                success: function(e) {
                    s.setData({
                        usersinfo: e.data
                    });
                }
            }), wx.getSetting({
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
            });
        } else wx.login({
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
                                        wx.setStorageSync("key", e.data.session_key), wx.setStorageSync("openid", e.data.openid);
                                        var t = e.data.openid;
                                        console.log("进入获取openid"), console.log(e.data);
                                        t = e.data.openid;
                                        wx.setStorage({
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
                                                console.log("进入地址login"), console.log(e.data), console.log("ceshi-------------------------------"), 
                                                s.onShow(), console.log("ceshi-------------------------------"), wx.setStorageSync("users", e.data), 
                                                wx.setStorageSync("uniacid", e.data.uniacid), s.setData({
                                                    usersinfo: e.data
                                                });
                                            }
                                        }), s.onShow();
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
    },
    Branch: function() {
        var n = this, e = wx.getStorageSync("isSwitch"), a = wx.getStorageSync("openid");
        if (1 != e) var s = 2; else s = 1;
        wx.setStorageSync("Switch", s), a && (wx.getLocation({
            type: "gcj02",
            success: function(e) {
                var t = e.latitude, o = e.longitude;
                app.util.request({
                    url: "entry/wxapp/CurrentBranch",
                    cachetime: "0",
                    data: {
                        openid: a,
                        latitude: t,
                        longitude: o,
                        Switch: s
                    },
                    success: function(e) {
                        console.log(e.data), n.setData({
                            Branch: e.data
                        });
                    }
                });
            },
            fail: function() {
                console.log("你有打印出来吗"), n.setData({
                    jurisDiction: !0
                });
            }
        }), app.util.request({
            url: "entry/wxapp/AmountSaveVip",
            cachetime: "0",
            data: {
                openid: a
            }
        }));
    }
}, "wxauthSetting", function(e) {
    var s = this, t = wx.getStorageSync("openid");
    if (t) {
        var o = wx.getStorageSync("user_info"), n = o.nickName, a = o.avatarUrl, i = o.gender;
        app.util.request({
            url: "entry/wxapp/Login",
            cachetime: "0",
            data: {
                openid: t,
                img: a,
                name: n,
                gender: i
            },
            success: function(e) {
                s.setData({
                    usersinfo: e.data
                });
            }
        }), wx.getSetting({
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
        });
    } else wx.login({
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
                                    wx.setStorageSync("key", e.data.session_key), wx.setStorageSync("openid", e.data.openid);
                                    var t = e.data.openid;
                                    console.log("进入获取openid"), console.log(e.data);
                                    t = e.data.openid;
                                    wx.setStorage({
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
                                            console.log("进入地址login"), console.log(e.data), console.log("ceshi-------------------------------"), 
                                            s.onShow(), console.log("ceshi-------------------------------"), wx.setStorageSync("users", e.data), 
                                            wx.setStorageSync("uniacid", e.data.uniacid), s.setData({
                                                usersinfo: e.data
                                            });
                                        }
                                    }), s.onShow();
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
}), _defineProperty(_Page, "updateUserInfo", function(e) {
    console.log("授权操作更新");
    this.wxauthSetting();
}), _defineProperty(_Page, "goHome", function() {
    wx.reLaunch({
        url: "/ymmf_sun/pages/index/index"
    });
}), _defineProperty(_Page, "get", function() {
    this.setData({
        jurisDiction: !1
    }), wx.openSetting({
        success: function(e) {
            console.log(e.authSetting), e.authSetting = {
                "scope.userInfo": !0,
                "scope.userLocation": !0
            };
        }
    });
}), _defineProperty(_Page, "goindex", function(e) {
    wx.reLaunch({
        url: "/ymmf_sun/pages/index/index"
    });
}), _Page));