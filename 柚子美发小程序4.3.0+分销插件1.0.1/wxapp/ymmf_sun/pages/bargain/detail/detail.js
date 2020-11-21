var _Page;

function _defineProperty(e, t, a) {
    return t in e ? Object.defineProperty(e, t, {
        value: a,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : e[t] = a, e;
}

var app = getApp(), tool = require("../../../../style/utils/countDown.js");

Page((_defineProperty(_Page = {
    data: {
        isIpx: app.globalData.isIpx,
        showModalStatus: !1,
        join: 3,
        order: [],
        imgArr: [ "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152084048151.png", "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152084048161.png" ],
        overtime: "",
        clock: "",
        br: [ "../../../../style/images/br.png" ],
        jurisDiction: !1,
        is_modal_Hidden: !0,
        active: !1
    },
    onLoad: function(e) {
        console.log(e);
        var a = this, t = e.pic, n = e.id, o = e.build_id;
        wx.setStorageSync("bid", e.build_id);
        var i = app.func.decodeScene(e);
        i.id && (n = i.id), i.bid && (o = i.bid), a.setData({
            id: n,
            pic: t
        }), a.wxauthSetting(), app.util.request({
            url: "entry/wxapp/KJdetail",
            method: "GET",
            data: {
                id: a.data.id,
                bid: o
            },
            success: function(e) {
                console.log("你的状态值的是多少" + e.data.nowstatus), 1 == e.data.nowstatus && a.setData({
                    active: !0
                }), console.log(e.data);
                e.data;
                a.setData({
                    order: e.data
                });
            }
        }), wx.setStorageSync("kanjiaid", e.id), app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "0",
            success: function(e) {
                wx.setStorageSync("url", e.data), a.setData({
                    url: e.data
                });
            }
        });
        var s = wx.getStorageSync("openid");
        n = a.data.id;
        app.util.request({
            url: "entry/wxapp/iskanjia",
            data: {
                id: n,
                openid: s
            },
            success: function(e) {
                console.log(e.data);
                var t = e.data.status;
                a.setData({
                    join: t
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        var n = this;
        n.wxauthSetting(), n.Branch();
        var e = wx.getStorageSync("openid"), t = wx.getStorageSync("bid");
        app.util.request({
            url: "entry/wxapp/KJdetail",
            method: "GET",
            data: {
                id: n.data.id,
                bid: t
            },
            success: function(e) {
                console.log("你的状态值的是多少" + e.data.nowstatus), 1 == e.data.nowstatus && n.setData({
                    active: !0
                }), console.log(e.data);
                e.data;
                n.setData({
                    order: e.data
                });
                var t = e.data, a = setInterval(function() {
                    var e = tool.countDown(n, t.endtime);
                    e ? t.clock = "离结束剩：" + e[0] + "天" + e[1] + "时" + e[3] + "分" + e[4] + "秒" : (t.clock = "已经截止", 
                    clearInterval(a)), n.setData({
                        clock: t.clock
                    });
                }, 1e3);
            }
        }), app.util.request({
            url: "entry/wxapp/kanzhu",
            cachetime: "0",
            data: {
                id: n.data.id,
                openid: e
            },
            success: function(e) {
                console.log(e.data), e.data && n.setData({
                    bargain_marster: e.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/friends",
            cachetime: "0",
            data: {
                id: n.data.id,
                openid: e
            },
            success: function(e) {
                console.log(e.data), n.setData({
                    friend: e.data
                });
            }
        });
    },
    toIndex: function(e) {
        wx.reLaunch({
            url: "/ymmf_sun/pages/index/index"
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    order: function(e) {
        var t = e.target.dataset.id, a = e.target.dataset.price;
        wx.navigateTo({
            url: "../cforder/cforder?id=" + t + "&price=" + a
        });
    },
    GotoBuyNow: function(e) {
        var t = e.target.dataset.id, a = e.target.dataset.price;
        app.util.request({
            url: "entry/wxapp/buyed",
            cachetime: "0",
            data: {
                id: t,
                openid: wx.getStorageSync("openid")
            },
            success: function(e) {
                console.log(e), e.data ? wx.showToast({
                    title: "您已购买过该商品！",
                    icon: "none"
                }) : wx.navigateTo({
                    url: "../cforder/cforder?id=" + t + "&price=" + a
                });
            }
        });
    }
}, "onShareAppMessage", function(e) {
    var t = wx.getStorageSync("openid"), a = wx.getStorageSync("kanjiaid"), n = wx.getStorageSync("system");
    if (console.log(n), "button" === e.from) {
        console.log(e.target);
        t = wx.getStorageSync("openid"), a = wx.getStorageSync("kanjiaid");
    }
    return {
        title: n.share_title,
        path: "ymmf_sun/pages/bargain/help/help?id=" + a + "&openid=" + t,
        success: function(e) {
            console.log("转发成功");
        },
        fail: function(e) {
            console.log("转发失败");
        }
    };
}), _defineProperty(_Page, "powerDrawer", function(e) {
    var t = this, a = e.currentTarget.dataset.statu;
    t.util(a);
    var n = e.currentTarget.dataset.join;
    if (t.setData({
        join: n
    }), "open" == a) {
        var o = e.currentTarget.dataset.id, i = wx.getStorageSync("openid");
        console.log(i), console.log(i), app.util.request({
            url: "entry/wxapp/kanzhu",
            data: {
                id: o,
                openid: i
            },
            success: function(e) {
                console.log(e), t.setData({
                    kanjia: e.data
                });
            }
        });
    }
}), _defineProperty(_Page, "Drawer", function(e) {
    var t = this, a = e.currentTarget.dataset.statu;
    t.util(a);
    var n = e.currentTarget.dataset.join;
    if (t.setData({
        join: n
    }), "open" == a) {
        var o = e.currentTarget.dataset.id, i = wx.getStorageSync("openid");
        console.log(i), console.log(i), app.util.request({
            url: "entry/wxapp/sskanzhu",
            data: {
                id: o,
                openid: i
            },
            success: function(e) {
                console.log(e), t.setData({
                    price: e.data
                });
            }
        });
    }
    t.onShow();
}), _defineProperty(_Page, "power", function(e) {
    var t = e.currentTarget.dataset.statu;
    this.util(t);
}), _defineProperty(_Page, "util", function(e) {
    var t = wx.createAnimation({
        duration: 200,
        timingFunction: "linear",
        delay: 0
    });
    (this.animation = t).opacity(0).height(0).step(), this.setData({
        animationData: t.export()
    }), setTimeout(function() {
        t.opacity(1).height("488rpx").step(), this.setData({
            animationData: t
        }), "close" == e && this.setData({
            showModalStatus: !1
        });
    }.bind(this), 200), "open" == e && this.setData({
        showModalStatus: !0
    });
}), _defineProperty(_Page, "help", function(e) {
    wx.updateShareMenu({
        withShareTicket: !0,
        success: function() {}
    });
}), _defineProperty(_Page, "toHelp", function(e) {
    var t = wx.getStorageSync("openid"), a = wx.getStorageSync("kanjiaid");
    wx.navigateTo({
        url: "/ymmf_sun/pages/bargain/help/help?id=" + a + "&openid=" + t
    });
}), _defineProperty(_Page, "getPrompt", function() {
    this.setData({
        value: !0
    });
}), _defineProperty(_Page, "shareCanvas", function() {
    var e = this;
    setTimeout(function() {
        e.getPrompt();
    }, 2800);
    var t = e.data.order, a = wx.getStorageSync("url"), n = wx.getStorageSync("goodspicbg"), o = (wx.getStorageSync("hbpic"), 
    wx.getStorageSync("users"), wx.getStorageSync("build_id")), i = e.data.order, s = [];
    s.bname = i.gname, s.url = a, s.logo = t.hbpic, s.br = e.data.br[0], s.goodspicbg = n, 
    s.price = i.shopprice, s.scene = "id=" + this.data.id + "&build_id=" + o, app.Func.func.creatPoster2("ymmf_sun/pages/bargain/detail/detail", 430, s, 1, "shareImg"), 
    e.setData({
        shareMask: !1
    });
}), _defineProperty(_Page, "hidden", function(e) {
    this.setData({
        hidden: !0,
        value: !1
    });
}), _defineProperty(_Page, "save", function() {
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
}), _defineProperty(_Page, "unshare", function() {
    this.setData({
        shareMask: !1
    });
}), _defineProperty(_Page, "tapShare", function() {
    this.setData({
        shareMask: !0
    });
}), _defineProperty(_Page, "wxauthSetting", function(e) {
    var i = this, t = wx.getStorageSync("openid");
    if (t) {
        var a = wx.getStorageSync("user_info"), n = a.nickName, o = a.avatarUrl, s = a.gender;
        app.util.request({
            url: "entry/wxapp/Login",
            cachetime: "0",
            data: {
                openid: t,
                img: o,
                name: n,
                gender: s
            },
            success: function(e) {
                i.setData({
                    usersinfo: e.data
                });
            }
        }), wx.getSetting({
            success: function(e) {
                console.log("进入wx.getSetting 1"), console.log(e), e.authSetting["scope.userInfo"] ? (console.log("scope.userInfo已授权 1"), 
                wx.getUserInfo({
                    success: function(e) {
                        i.setData({
                            is_modal_Hidden: !0,
                            thumb: e.userInfo.avatarUrl,
                            nickname: e.userInfo.nickName
                        });
                    }
                })) : (console.log("scope.userInfo没有授权 1"), wx.showModal({
                    title: "获取信息失败",
                    content: "请允许授权以便为您提供给服务",
                    success: function(e) {
                        i.setData({
                            is_modal_Hidden: !1
                        });
                    }
                }));
            },
            fail: function(e) {
                console.log("获取权限失败 1"), i.setData({
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
                            i.setData({
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
                                            name: a,
                                            gender: o
                                        },
                                        success: function(e) {
                                            console.log("进入地址login"), console.log(e.data), console.log("ceshi-------------------------------"), 
                                            i.onShow(), console.log("ceshi-------------------------------"), wx.setStorageSync("users", e.data), 
                                            wx.setStorageSync("uniacid", e.data.uniacid), i.setData({
                                                usersinfo: e.data
                                            });
                                        }
                                    }), i.onShow();
                                }
                            });
                        },
                        fail: function(e) {
                            console.log("进入 wx-getUserInfo 失败"), wx.showModal({
                                title: "获取信息失败",
                                content: "请允许授权以便为您提供给服务!",
                                success: function(e) {
                                    i.setData({
                                        is_modal_Hidden: !1
                                    });
                                }
                            });
                        }
                    })) : (console.log("scope.userInfo没有授权"), i.setData({
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
                    i.setData({
                        is_modal_Hidden: !1
                    });
                }
            });
        }
    });
}), _defineProperty(_Page, "updateUserInfo", function(e) {
    console.log("授权操作更新");
    this.wxauthSetting();
}), _defineProperty(_Page, "Branch", function() {
    var n = this, e = wx.getStorageSync("isSwitch"), o = wx.getStorageSync("openid");
    if (1 != e) var i = 2; else i = 1;
    wx.setStorageSync("Switch", i), o && (wx.getLocation({
        type: "gcj02",
        success: function(e) {
            var t = e.latitude, a = e.longitude;
            app.util.request({
                url: "entry/wxapp/CurrentBranch",
                cachetime: "0",
                data: {
                    openid: o,
                    latitude: t,
                    longitude: a,
                    Switch: i
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
            openid: o
        }
    }));
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