var _Page;

function _defineProperty(t, e, a) {
    return e in t ? Object.defineProperty(t, e, {
        value: a,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[e] = a, t;
}

var app = getApp();

Page((_defineProperty(_Page = {
    data: {
        swiper: [ "lb1", "lb2", "lb3" ],
        serve: [ {
            name: "我们的服务",
            notice: "看了看到领导就爱仕达",
            serveLeft: {
                id: 0,
                img: "tijian",
                title1: "健康体检",
                title2: "更加了解自己",
                title3: "早发现早治疗"
            }
        } ],
        star: 0,
        starMap: [ 1, 2, 3, 4, 5 ],
        shouquan: !1
    },
    asd: function() {
        wx.navigateTo({
            url: "../webview/webview?src=https://m.sxhsjsyxgs.com"
        });
    },
    linkLIst: function() {
        wx.navigateTo({
            url: "/hyb_yl/zhuanjialiebiao/zhuanjialiebiao"
        });
    },
    lylx: function(t) {
        var e = this, a = JSON.parse(e.data.latitude), i = JSON.parse(e.data.longitude), n = e.data.yy_address, o = e.data.yy_title;
        wx.openLocation({
            latitude: a,
            longitude: i,
            scale: 18,
            name: o,
            address: n
        });
    },
    myStarChoose: function(t) {
        var e = parseInt(t.target.dataset.star) || 0;
        this.setData({
            star: e
        });
    },
    hzyy: function() {
        wx.navigateTo({
            url: "/hyb_yl/hezuoyiyuan/hezuoyiyuan"
        });
    },
    zhuanjialiebiao: function() {
        wx.navigateTo({
            url: "/hyb_yl/keshilist/keshilist"
        });
    },
    tijianClick: function() {
        wx.navigateTo({
            url: "../tijian/tijian"
        });
    },
    jibing: function() {
        wx.navigateTo({
            url: "/hyb_yl/jibing/jibing"
        });
    },
    mapClick: function() {
        wx.navigateTo({
            url: "/hyb_yl/jiangzuo/jiangzuo"
        });
    },
    yyjs: function() {
        wx.navigateTo({
            url: "/hyb_yl/yiyuanjieshao/yiyuanjieshao"
        });
    },
    ljClick: function() {
        wx.navigateTo({
            url: "../bingliku/bingliku",
            success: function(t) {},
            fail: function(t) {},
            complete: function(t) {}
        });
    },
    bindGetUserInfo: function(t) {
        var e = t.detail.userInfo;
        "getUserInfo:fail auth deny" !== t.detail.errMsg && wx.login({
            success: function(t) {
                t.code ? app.util.request({
                    url: "entry/wxapp/GetUid",
                    cachetime: "0",
                    data: {
                        code: t.code
                    },
                    success: function(a) {
                        a.data.errno || (wx.setStorageSync("openid", a.data.data.openid), wx.getUserInfo({
                            success: function(t) {
                                var e = t.userInfo;
                                wx.setStorageSync("userInfo", t.userInfo), app.util.request({
                                    url: "entry/wxapp/TyMember",
                                    data: {
                                        u_name: e.nickName,
                                        u_thumb: e.avatarUrl,
                                        openid: a.data.data.openid
                                    }
                                });
                            }
                        }));
                    },
                    fail: function(t) {
                        console.log(t);
                    }
                }) : console.log("获取用户登录态失败！" + t.errMsg);
            }
        }), wx.setStorage({
            key: "userInfo",
            data: t.detail.userInfo
        });
        this.setData({
            shouquan: !0,
            userInfo: e
        });
    },
    onLoad: function(t) {
        var e = this, a = wx.getStorageSync("userInfo");
        app.util.request({
            url: "entry/wxapp/Base",
            success: function(t) {
                e.setData({
                    tell: t.data.data.yy_telphone,
                    yy_title: t.data.data.yy_title,
                    yy_address: t.data.data.yy_address,
                    latitude: t.data.data.latitude,
                    longitude: t.data.data.longitude,
                    baseinfo: t.data.data,
                    show_title: t.data.data.show_title
                }), wx.setStorage({
                    key: "title",
                    data: t.data.data.show_title
                });
            },
            fail: function(t) {
                console.log(t);
            }
        });
        var i = wx.getStorageSync("title");
        wx.setNavigationBarTitle({
            title: i
        }), app.util.request({
            url: "entry/wxapp/Selectord3",
            success: function(t) {
                e.setData({
                    selectord: t.data.data
                });
            }
        }), e.setData({
            userInfo: a
        });
    },
    toast: function() {
        wx.redirectTo({
            url: "/hyb_yl/index/index"
        });
    },
    toast1: function() {
        wx.redirectTo({
            url: "/hyb_yl/zhuanjialiebiao/zhuanjialiebiao"
        });
    },
    toast2: function() {
        wx.redirectTo({
            url: "/hyb_yl/faxian/faxian"
        });
    },
    toast3: function() {
        wx.redirectTo({
            url: "/hyb_yl/my/my"
        });
    },
    help: function(t) {
        t.currentTarget.dataset.id;
        wx.navigateTo({
            url: "/hyb_yl/jibingyufang/jibingyufang?id=" + t.currentTarget.dataset.id
        });
    },
    onReady: function() {
        this.getFuwu(), this.getZhuanjia(), this.getZixun(), this.getHzal(), this.getVideo(), 
        this.getScurl(), this.getFenli(), this.getBiaoti1();
        var t = wx.getStorageSync("title");
        wx.setNavigationBarTitle({
            title: t
        });
    }
}, "mapClick", function() {
    wx.navigateTo({
        url: "/hyb_yl/jiangzuo/jiangzuo"
    });
}), _defineProperty(_Page, "onShow", function() {}), _defineProperty(_Page, "onHide", function() {}), 
_defineProperty(_Page, "onUnload", function() {}), _defineProperty(_Page, "onPullDownRefresh", function() {
    this.getFuwu(), this.getZhuanjia(), this.getZixun(), this.getHzal(), this.getVideo(), 
    this.getScurl(), this.getFenli(), this.getBiaoti1();
    var t = wx.getStorageSync("title");
    wx.setNavigationBarTitle({
        title: t
    }), wx.hideNavigationBarLoading(), wx.stopPullDownRefresh();
}), _defineProperty(_Page, "tell", function() {
    var t = this.data.tell;
    wx.makePhoneCall({
        phoneNumber: t
    });
}), _defineProperty(_Page, "onReachBottom", function() {}), _defineProperty(_Page, "onShareAppMessage", function() {}), 
_defineProperty(_Page, "getFenli", function() {
    var e = this;
    app.util.request({
        url: "entry/wxapp/Fenli",
        success: function(t) {
            e.setData({
                fenli: t.data.data
            });
        },
        fail: function(t) {
            console.log(t);
        }
    });
}), _defineProperty(_Page, "getScurl", function() {
    var e = this;
    app.util.request({
        url: "entry/wxapp/Scurl",
        success: function(t) {
            e.setData({
                dataurl: t.data.data
            });
        },
        fail: function(t) {
            console.log(t);
        }
    });
}), _defineProperty(_Page, "getFuwu", function() {
    var e = this;
    app.util.request({
        url: "entry/wxapp/Fuwu",
        cachetime: "0",
        success: function(t) {
            e.setData({
                fuwu: t.data.data,
                fuwulength: t.data.data.length
            });
        },
        fail: function(t) {
            console.log(t);
        }
    });
}), _defineProperty(_Page, "yishiClick", function() {
    wx.navigateTo({
        url: "/hyb_yl/keshilist/keshilist",
        success: function(t) {},
        fail: function(t) {},
        complete: function(t) {}
    });
}), _defineProperty(_Page, "getZhuanjia", function() {
    var e = this;
    app.util.request({
        url: "entry/wxapp/zhuanjia",
        cachetime: "0",
        success: function(t) {
            e.setData({
                zhuanjia: t.data.data
            });
        },
        fail: function(t) {
            console.log(t);
        }
    });
}), _defineProperty(_Page, "getZixun", function() {
    var e = this;
    app.util.request({
        url: "entry/wxapp/Zixun",
        cachetime: "0",
        success: function(t) {
            e.setData({
                zixun: t.data.data
            });
        },
        fail: function(t) {
            console.log(t);
        }
    });
}), _defineProperty(_Page, "getHzal", function() {
    var e = this;
    app.util.request({
        url: "entry/wxapp/Hzal",
        cachetime: "0",
        success: function(t) {
            e.setData({
                hzal: t.data.data
            });
        },
        fail: function(t) {
            console.log(t);
        }
    });
}), _defineProperty(_Page, "getVideo", function() {
    var e = this;
    app.util.request({
        url: "entry/wxapp/Tjvideo",
        data: {},
        cachetime: "0",
        success: function(t) {
            e.setData({
                tjvideo: t.data.data
            });
        },
        fail: function(t) {
            console.log(t);
        }
    });
}), _defineProperty(_Page, "getBiaoti1", function() {
    var e = this;
    app.util.request({
        url: "entry/wxapp/Biaoti1",
        success: function(t) {
            e.setData({
                biaoti1: t.data.data.fw_title,
                biaoti2: t.data.data.fw_title2,
                biaoti3: t.data.data.fw_thumb
            });
        },
        fail: function(t) {
            console.log(t);
        }
    });
}), _Page));