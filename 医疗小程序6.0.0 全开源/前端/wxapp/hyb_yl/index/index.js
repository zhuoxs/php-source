var _Page;

function _defineProperty(e, t, a) {
    return t in e ? Object.defineProperty(e, t, {
        value: a,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : e[t] = a, e;
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
        formIdArray: [],
        star: 0,
        starMap: [ 1, 2, 3, 4, 5 ],
        shouquan: !1,
        array1: [],
        footer: [],
        ps: !0,
        a: !1
    },
    saveFormId: function(e) {
        var t = e.detail.formId, a = wx.getStorageSync("openid"), i = e.detail.value.id, n = e.detail.value.u_id;
        app.util.request({
            url: "entry/wxapp/UserFormId",
            data: {
                form_id: t,
                openid: a
            },
            success: function(e) {
                console.log(e), wx.navigateTo({
                    url: "/hyb_yl/zhuanjiazhuye/zhuanjiazhuye?id=" + i + "&u_id=" + n
                });
            }
        });
    },
    yf: function(e) {
        var t = e.currentTarget.dataset.id, a = e.currentTarget.dataset.title;
        app.util.request({
            url: "entry/wxapp/Zenzxdj",
            data: {
                id: t
            },
            success: function(e) {
                console.log(e);
            }
        }), wx.navigateTo({
            url: "/hyb_yl/zixunanlixq/zixunanlixq?id=" + t + "&title=" + a
        });
    },
    hzanl: function(e) {
        var t = e.currentTarget.dataset.hz_id, a = e.currentTarget.dataset.title;
        app.util.request({
            url: "entry/wxapp/Zenjdj",
            data: {
                hz_id: t
            },
            success: function(e) {
                console.log(e);
            }
        }), wx.navigateTo({
            url: "/hyb_yl/anlixq/anlixq?hz_id=" + t + "&title=" + a
        });
    },
    linkLIst: function(e) {
        var t = e.detail.formId, a = e.detail.value.ser_lujing, i = parseInt(e.detail.value.ser_type), n = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/UserFormId",
            data: {
                form_id: t,
                openid: n
            },
            success: function(e) {
                1 == i ? wx.navigateTo({
                    url: a
                }) : wx.reLaunch({
                    url: "/hyb_yl/zhuanjialiebiao/zhuanjialiebiao"
                });
            }
        });
    },
    getMytid: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/Seldocuid",
            data: {
                docopenid: wx.getStorageSync("openid")
            },
            success: function(e) {
                var t = e.data.data.u_id;
                a.setData({
                    tid: t
                });
            }
        });
    },
    lylx: function(e) {
        var o = this, t = e.detail.formId, a = wx.getStorageSync("openid"), r = e.detail.value.webviewurl, u = e.detail.value.id;
        app.util.request({
            url: "entry/wxapp/UserFormId",
            data: {
                form_id: t,
                openid: a
            },
            success: function(e) {
                if (console.log(r), "" !== r) wx.navigateTo({
                    url: "../webview/webview?id=" + u
                }); else {
                    var t = JSON.parse(o.data.latitude), a = JSON.parse(o.data.longitude), i = o.data.yy_address, n = o.data.yy_title;
                    wx.openLocation({
                        latitude: t,
                        longitude: a,
                        scale: 18,
                        name: n,
                        address: i
                    });
                }
            }
        });
    },
    myStarChoose: function(e) {
        var t = parseInt(e.target.dataset.star) || 0;
        this.setData({
            star: t
        });
    },
    hzyy: function(e) {
        var t = e.detail.formId, a = e.detail.value.webviewurl, i = wx.getStorageSync("openid"), n = e.detail.value.id;
        app.util.request({
            url: "entry/wxapp/UserFormId",
            data: {
                form_id: t,
                openid: i
            },
            success: function(e) {
                "" !== a ? wx.navigateTo({
                    url: "../webview/webview?id=" + n
                }) : wx.navigateTo({
                    url: "/hyb_yl/hezuoyiyuan/hezuoyiyuan"
                });
            }
        });
    },
    zhuanjialiebiao: function(e) {
        var t = e.currentTarget.dataset.title;
        wx.navigateTo({
            url: "/hyb_yl/keshilist/keshilist?title=" + t
        });
    },
    tijianClick: function(e) {
        var t = e.detail.formId, a = e.detail.value.ser_lujing, i = parseInt(e.detail.value.ser_type), n = wx.getStorageSync("openid"), o = JSON.parse(decodeURIComponent(JSON.stringify(e.detail.value.ser_name)));
        console.log(o), app.util.request({
            url: "entry/wxapp/UserFormId",
            data: {
                form_id: t,
                openid: n
            },
            success: function(e) {
                1 == i ? wx.navigateTo({
                    url: a + "?biaoti3=" + o
                }) : wx.navigateTo({
                    url: "../tijian/tijian"
                });
            }
        });
    },
    jibing: function(e) {
        console.log(e);
        var t = e.currentTarget.dataset.data;
        wx.navigateTo({
            url: "/hyb_yl/jibing/jibing?biaoti3=" + t
        });
    },
    mapClick: function(e) {
        wx.navigateTo({
            url: "/hyb_yl/jiangzuo/jiangzuo"
        });
    },
    yyjs: function(e) {
        console.log(e);
        var t = e.detail.formId, a = e.detail.value.webviewurl, i = wx.getStorageSync("openid"), n = e.detail.value.fuwu_name, o = e.detail.value.id;
        app.util.request({
            url: "entry/wxapp/UserFormId",
            data: {
                form_id: t,
                openid: i
            },
            success: function(e) {
                "" !== a ? wx.navigateTo({
                    url: "../webview/webview?id=" + o
                }) : wx.navigateTo({
                    url: "/hyb_yl/yiyuanjieshao/yiyuanjieshao?title=" + n
                });
            }
        });
    },
    ljClick: function(e) {
        var t = e.detail.formId, a = e.detail.value.webviewurl, i = e.detail.value.id, n = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/UserFormId",
            data: {
                form_id: t,
                openid: n
            },
            success: function(e) {
                console.log(a), "" !== a ? wx.navigateTo({
                    url: "../webview/webview?id=" + i
                }) : wx.navigateTo({
                    url: "../bingliku/bingliku"
                });
            }
        });
    },
    yuzhenClick: function(e) {
        var t = e.detail.formId, a = wx.getStorageSync("openid"), i = e.detail.value.ser_lujing, n = e.detail.value.ser_type;
        app.util.request({
            url: "entry/wxapp/Getfutj",
            success: function(e) {
                console.log(e), app.globalData.getfutj = e.data.data;
            }
        }), app.util.request({
            url: "entry/wxapp/Alltjself",
            success: function(e) {
                app.globalData.quickCheck = e.data.data;
            }
        }), app.util.request({
            url: "entry/wxapp/UserFormId",
            data: {
                form_id: t,
                openid: a
            },
            success: function(e) {
                "1" == n && wx.reLaunch({
                    url: i
                }), setTimeout(function() {
                    wx.navigateTo({
                        url: "/hyb_yl/yuzhen/yuzhen"
                    });
                }, 350);
            }
        });
    },
    bindGetUserInfo: function(a) {
        console.log(a);
        var e = a.detail.userInfo;
        a.detail.formId;
        "getUserInfo:fail auth deny" !== a.detail.errMsg && wx.login({
            success: function(e) {
                e.code ? app.util.request({
                    url: "entry/wxapp/GetUid",
                    cachetime: "0",
                    data: {
                        code: e.code
                    },
                    success: function(e) {
                        if (console.log(), !e.data.errno) {
                            wx.setStorageSync("openid", e.data.data.openid);
                            var t = a.detail.userInfo;
                            wx.setStorageSync("userInfo", a.detail.userInfo), app.util.request({
                                url: "entry/wxapp/TyMember",
                                data: {
                                    u_name: t.nickName,
                                    u_thumb: t.avatarUrl,
                                    openid: e.data.data.openid
                                },
                                success: function(e) {
                                    wx.getStorageSync("openid");
                                }
                            });
                        }
                    },
                    fail: function(e) {
                        console.log(e);
                    }
                }) : console.log("获取用户登录态失败！" + e.errMsg);
            }
        }), wx.setStorage({
            key: "userInfo",
            data: a.detail.userInfo
        }), this.setData({
            shouquan: !0,
            userInfo: e
        });
    },
    onLoad: function(e) {
        var t = this;
        wx.showLoading({
            title: "加载中"
        });
        var a = wx.getStorageSync("userInfo");
        app.util.request({
            url: "entry/wxapp/Selectord3",
            success: function(e) {
                t.setData({
                    selectord: e.data.data
                });
            }
        }), t.setData({
            userInfo: a
        });
    },
    toast: function() {
        wx.redirectTo({
            url: "/hyb_yl/index/index"
        });
    },
    toast1: function(e) {
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
        var t = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/Myphone",
            data: {
                openid: t
            },
            success: function(e) {
                app.globalData.myphone = e.data.data, app.globalData.openid = t;
            },
            fail: function(e) {
                console.log(e);
            }
        }), setTimeout(function() {
            wx.redirectTo({
                url: "/hyb_yl/my/my"
            });
        }, 350);
    },
    help: function(e) {
        var t = e.detail.target.dataset.id;
        console.log(e);
        var a = e.detail.formId, i = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/UserFormId",
            data: {
                form_id: a,
                openid: i
            },
            success: function(e) {
                wx.navigateTo({
                    url: "/hyb_yl/jibingyufang/jibingyufang?id=" + t
                });
            }
        });
    },
    onReady: function() {
        this.getPianlist(), this.getFuwu(), this.getMyser(), this.getZhuanjia(), this.getZixun(), 
        this.getHzal(), this.getVideo(), this.getScurl(), this.getFenli(), this.getBiaoti1(), 
        this.getBase(), this.getMytid(), this.getVideoer(), this.getZixuner(), this.getHzaler();
    }
}, "mapClick", function() {
    wx.navigateTo({
        url: "/hyb_yl/jiangzuo/jiangzuo"
    });
}), _defineProperty(_Page, "onShow", function() {
    wx.hideNavigationBarLoading();
}), _defineProperty(_Page, "onHide", function() {}), _defineProperty(_Page, "onUnload", function() {}), 
_defineProperty(_Page, "onPullDownRefresh", function() {
    this.getFuwu(), this.getMyser(), this.getZhuanjia(), this.getZixun(), this.getHzal(), 
    this.getVideo(), this.getScurl(), this.getFenli(), this.getBiaoti1(), this.getBase(), 
    this.getVideoer(), this.getZixuner(), this.getHzaler(), wx.hideNavigationBarLoading(), 
    wx.stopPullDownRefresh();
}), _defineProperty(_Page, "tell", function() {
    var e = this.data.tell;
    wx.makePhoneCall({
        phoneNumber: e
    });
}), _defineProperty(_Page, "onReachBottom", function() {}), _defineProperty(_Page, "onShareAppMessage", function() {}), 
_defineProperty(_Page, "getFenli", function() {
    var t = this;
    app.util.request({
        url: "entry/wxapp/Fenli",
        success: function(e) {
            t.setData({
                fenli: e.data.data
            });
        },
        fail: function(e) {
            console.log(e);
        }
    });
}), _defineProperty(_Page, "getScurl", function() {
    var t = this;
    app.util.request({
        url: "entry/wxapp/Scurl",
        success: function(e) {
            t.setData({
                dataurl: e.data.data
            });
        },
        fail: function(e) {
            console.log(e);
        }
    });
}), _defineProperty(_Page, "getFuwu", function() {
    var t = this;
    app.util.request({
        url: "entry/wxapp/Fuwu",
        cachetime: "0",
        success: function(e) {
            t.setData({
                fuwu: e.data.data,
                fuwulength: e.data.data.length
            });
        },
        fail: function(e) {
            console.log(e);
        }
    });
}), _defineProperty(_Page, "getMyser", function() {
    var t = this;
    app.util.request({
        url: "entry/wxapp/Myser",
        success: function(e) {
            t.setData({
                myser: e.data.data,
                fuwulength: e.data.data.length
            });
        },
        fail: function(e) {
            console.log(e);
        }
    });
}), _defineProperty(_Page, "yishiClick", function(e) {
    var t = e.detail.formId, a = wx.getStorageSync("openid"), i = (e.detail.value.webviewurl, 
    e.detail.value.fuwu_name);
    console.log(e), app.util.request({
        url: "entry/wxapp/UserFormId",
        data: {
            form_id: t,
            openid: a
        },
        success: function(e) {
            wx.navigateTo({
                url: "/hyb_yl/keshilist/keshilist?title=" + i
            });
        }
    });
}), _defineProperty(_Page, "getZhuanjia", function() {
    var o = this;
    o.data.array1;
    app.util.request({
        url: "entry/wxapp/zhuanjia",
        cachetime: "0",
        success: function(e) {
            for (var i = e.data.data, t = [], a = 0; a < i.length; a++) {
                var n = i[a].openid;
                t.push(n);
            }
            app.util.request({
                url: "entry/wxapp/Alldcouid",
                data: {
                    nArr: t
                },
                success: function(e) {
                    for (var t = e.data.data, a = 0; a < t.length; a++) Object.assign(i[a], t[a]);
                    o.setData({
                        zhuanjia: i
                    });
                }
            });
        },
        fail: function(e) {
            console.log(e);
        }
    });
}), _defineProperty(_Page, "getZixun", function() {
    var t = this;
    app.util.request({
        url: "entry/wxapp/Zixun",
        cachetime: "0",
        success: function(e) {
            t.setData({
                zixun: e.data.data
            });
        },
        fail: function(e) {
            console.log(e);
        }
    });
}), _defineProperty(_Page, "getZixuner", function() {
    var t = this;
    app.util.request({
        url: "entry/wxapp/Zixuner",
        cachetime: "0",
        success: function(e) {
            t.setData({
                zixuner: e.data.data
            });
        },
        fail: function(e) {
            console.log(e);
        }
    });
}), _defineProperty(_Page, "getHzal", function() {
    var t = this;
    app.util.request({
        url: "entry/wxapp/Hzal",
        cachetime: "0",
        success: function(e) {
            t.setData({
                hzal: e.data.data
            });
        },
        fail: function(e) {
            console.log(e);
        }
    });
}), _defineProperty(_Page, "getHzaler", function() {
    var t = this;
    app.util.request({
        url: "entry/wxapp/Hzaler",
        cachetime: "0",
        success: function(e) {
            t.setData({
                hzaler: e.data.data
            });
        },
        fail: function(e) {
            console.log(e);
        }
    });
}), _defineProperty(_Page, "getBase", function() {
    var a = this;
    app.util.request({
        url: "entry/wxapp/Base",
        success: function(e) {
            "1" == e.data.data.pstatus ? (wx.hideLoading(), a.setData({
                ps: !0,
                a: !0
            }), a.getPiandaohang()) : (wx.hideLoading(), a.setData({
                ps: !1,
                a: !0
            }));
            var t = e.data.data.ztcolor;
            a.setData({
                tell: e.data.data.yy_telphone,
                yy_title: e.data.data.yy_title,
                yy_address: e.data.data.yy_address,
                latitude: e.data.data.latitude,
                longitude: e.data.data.longitude,
                baseinfo: e.data.data,
                show_title: e.data.data.show_title,
                bq_thumb: e.data.data.bq_thumb,
                bq_name: e.data.data.bq_name
            }), wx.setNavigationBarTitle({
                title: e.data.data.show_title
            }), wx.setNavigationBarColor({
                frontColor: "#ffffff",
                backgroundColor: t
            }), wx.setStorage({
                key: "color",
                data: t
            });
        },
        fail: function(e) {
            console.log(e);
        }
    });
}), _defineProperty(_Page, "getVideo", function() {
    var t = this;
    app.util.request({
        url: "entry/wxapp/Tjvideo",
        data: {},
        cachetime: "0",
        success: function(e) {
            t.setData({
                tjvideo: e.data.data
            });
        },
        fail: function(e) {
            console.log(e);
        }
    });
}), _defineProperty(_Page, "getVideoer", function() {
    var t = this;
    app.util.request({
        url: "entry/wxapp/Tjvideoer",
        data: {},
        cachetime: "0",
        success: function(e) {
            t.setData({
                tjvideos: e.data.data
            });
        },
        fail: function(e) {
            console.log(e);
        }
    });
}), _defineProperty(_Page, "video", function(e) {
    var t = e.currentTarget.dataset.id;
    app.util.request({
        url: "entry/wxapp/Person",
        data: {
            id: t
        },
        success: function(e) {},
        fail: function(e) {
            console.log(e);
        }
    });
}), _defineProperty(_Page, "getBiaoti1", function() {
    var t = this;
    app.util.request({
        url: "entry/wxapp/Biaoti1",
        success: function(e) {
            t.setData({
                biaoti1: e.data.data.fw_title,
                biaoti2: e.data.data.fw_title2,
                biaoti3: e.data.data.fw_thumb
            });
        },
        fail: function(e) {
            console.log(e);
        }
    });
}), _defineProperty(_Page, "getPiandaohang", function() {
    var a = this;
    app.util.request({
        url: "entry/wxapp/Piandaohang",
        success: function(e) {
            console.log(e);
            var t = e.data.data;
            a.setData({
                footer: t
            });
        }
    });
}), _defineProperty(_Page, "getPianlist", function() {
    var t = this;
    app.util.request({
        url: "entry/wxapp/Pianlist",
        success: function(e) {
            t.setData({
                pianlist: e.data.data
            });
        }
    });
}), _defineProperty(_Page, "link_detail_ps", function(e) {
    wx.navigateTo({
        url: "/hyb_yl/about_us/about_us?id=" + e.currentTarget.dataset.id
    });
}), _Page));