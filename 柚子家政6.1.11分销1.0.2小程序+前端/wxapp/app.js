var App = require("zhy/sdk/qitui/oddpush.js").oddPush(App, "App").App;

App({
    siteInfo: require("siteinfo.js"),
    util: require("/we7/js/util.js"),
    onLaunch: function() {
        var t = this;
        wx.getSetting({
            success: function(e) {
                e.authSetting["scope.userInfo"] && wx.getUserInfo({
                    success: function(e) {
                        t.globalData.userInfo = e.userInfo, wx.setStorageSync("user_info", e.userInfo), 
                        t.userInfoReadyCallback && t.userInfoReadyCallback(e);
                    }
                });
            }
        }), wx.request({
            url: this.siteInfo.siteroot + "?i=" + this.siteInfo.uniacid + "&t=undefined&v=1.0.0&from=wxapp&c=entry&a=wxapp&do=GetqtappData&m=wnjz_sun",
            header: {
                "content-type": "application/json"
            },
            success: function(e) {
                console.log(e.data);
                var t = e.data;
                wx.setStorageSync("qitui", t);
            }
        });
    },
    onShow: function() {
        var t = this;
        wx.getSystemInfo({
            success: function(e) {
                -1 != e.model.search("iPhone X") && (t.globalData.isIpx = !0);
            }
        });
    },
    globalData: {
        userInfo: null,
        showAd: !1,
        Plugin_distribution: "wnjz_sun_plugin_distribution",
        tabBar: {
            color: "#9E9E9E",
            selectedColor: "#f00",
            backgroundColor: "#fff",
            borderStyle: "#ccc",
            list: [ {
                pagePath: "/wnjz_sun/pages/index/index",
                text: "",
                iconPath: "",
                selectedIconPath: "",
                selectedColor: "#41c2fc",
                active: !0
            }, {
                pagePath: "/wnjz_sun/pages/bargain/bargain",
                text: "",
                iconPath: "",
                selectedIconPath: "",
                selectedColor: "#41c2fc",
                active: !1
            }, {
                pagePath: "/wnjz_sun/pages/branch/branch",
                text: "",
                iconPath: "",
                selectedIconPath: "",
                selectedColor: "#41c2fc",
                active: !1
            }, {
                pagePath: "/wnjz_sun/pages/user/user",
                text: "",
                iconPath: "",
                selectedIconPath: "",
                selectedColor: "#41c2fc",
                active: !1
            } ],
            position: "bottom"
        },
        isIpx: !1
    },
    editTabBar: function() {
        var e = getCurrentPages(), t = e[e.length - 1], o = t.__route__;
        0 != o.indexOf("/") && (o = "/" + o);
        for (var n = this.globalData.tabBar, s = 0; s < n.list.length; s++) n.list[s].active = !1, 
        n.list[s].pagePath == o && (n.list[s].active = !0);
        t.setData({
            tabBar: n
        });
    },
    getNavList: function(e) {
        var t = getCurrentPages(), o = t[t.length - 1];
        this.util.request({
            url: "entry/wxapp/getNavList",
            data: {
                p: e
            },
            cachetime: "0",
            success: function(e) {
                console.log(e.data), 2 != e.data ? (o.setData({
                    nav_list: e.data
                }), e.data.nav.length <= 0 && o.setData({
                    showdefaultnav: !0
                })) : o.setData({
                    showdefaultnav: !0
                });
            }
        });
    },
    getSiteUrl: function() {
        var t = wx.getStorageSync("url");
        if (t) return console.log("图片路径缓存"), console.log(t), t;
        wx.request({
            url: this.siteInfo.siteroot + "?i=" + this.siteInfo.uniacid + "&t=undefined&v=1.0.0&from=wxapp&c=entry&a=wxapp&do=Url&m=wnjz_sun",
            header: {
                "content-type": "application/json"
            },
            success: function(e) {
                return console.log("服务器路径"), console.log(e.data), t = e.data, wx.setStorageSync("url", t), 
                t;
            }
        });
    },
    wxauthSetting: function(e) {
        var a = this, t = getCurrentPages(), i = t[t.length - 1];
        wx.login({
            success: function(e) {
                console.log("进入wx-login");
                var t = e.code;
                wx.setStorageSync("code", t), a.util.request({
                    url: "entry/wxapp/openid",
                    showLoading: !1,
                    data: {
                        code: t
                    },
                    success: function(e) {
                        console.log("进入获取openid"), console.log(e.data), wx.setStorageSync("key", e.data.session_key), 
                        wx.setStorageSync("openid", e.data.openid);
                        var s = e.data.openid;
                        wx.getSetting({
                            success: function(e) {
                                console.log("进入wx.getSetting"), console.log(e), e.authSetting["scope.userInfo"] && (console.log("scope.userInfo已授权"), 
                                wx.getUserInfo({
                                    success: function(e) {
                                        var t = e.userInfo.nickName, o = e.userInfo.avatarUrl, n = e.userInfo.gender;
                                        i.setData({
                                            is_modal_Hidden: !0,
                                            thumb: o,
                                            nickname: t
                                        }), console.log("进入wx-getUserInfo"), console.log(e.userInfo), wx.setStorageSync("user_info", e.userInfo), 
                                        a.util.request({
                                            url: "entry/wxapp/Login",
                                            showLoading: !1,
                                            cachetime: "0",
                                            data: {
                                                openid: s,
                                                img: o,
                                                name: t,
                                                gender: n
                                            },
                                            success: function(e) {
                                                i.onShow(), console.log("进入地址login"), console.log(e.data), wx.setStorageSync("users", e.data), 
                                                wx.setStorageSync("uniacid", e.data.uniacid), i.setData({
                                                    usersinfo: e.data
                                                });
                                            }
                                        });
                                    }
                                }));
                            }
                        });
                    }
                });
            }
        });
    },
    func: require("func.js"),
    distribution: require("/zhy/distribution/distribution.js"),
    creatPoster: function(e, t, c, r, u) {
        console.log("-------------------"), console.log(e);
        var g = this, o = getCurrentPages(), d = o[o.length - 1], s = (d.__route__, this.siteInfo.siteroot.split("/app/")[0] + "/attachment/"), a = "";
        wx.showLoading({
            title: "获取图片中..."
        });
        var n = c.gid ? c.gid : 0, i = c.scene, f = wx.getStorageSync("users");
        wx.request({
            url: this.siteInfo.siteroot + "?i=" + this.siteInfo.uniacid + "&t=undefined&v=1.0.0&from=wxapp&c=entry&a=wxapp&do=GetwxCode&m=wnjz_sun",
            header: {
                "content-type": "application/json"
            },
            data: {
                scene: i,
                page: e,
                width: t,
                gid: n
            },
            success: function(l) {
                console.log("获取小程序二维码"), console.log(l.data), a = l.data;
                var e = new Promise(function(t, e) {
                    wx.getImageInfo({
                        src: c.url + c.logo,
                        success: function(e) {
                            console.log("图片缓存1"), console.log(e), t(e.path);
                        },
                        fail: function(e) {
                            console.log("图片1保存失败"), t(c.url + c.logo), console.log(e);
                        }
                    });
                }), t = new Promise(function(t, e) {
                    wx.getImageInfo({
                        src: c.url + c.goodspicbg,
                        success: function(e) {
                            console.log("海报背景图成功"), t(e.path);
                        },
                        fail: function(e) {
                            console.log("海报背景图保存失败"), t(c.url + c.goodspicbg), console.log(e);
                        }
                    });
                }), o = new Promise(function(t, e) {
                    wx.getImageInfo({
                        src: f.img,
                        success: function(e) {
                            console.log("用户头像缓存"), t(e.path);
                        },
                        fail: function(e) {
                            console.log("用户头像缓存失败"), t(f.img), console.log(e);
                        }
                    });
                }), n = new Promise(function(t, e) {
                    wx.getImageInfo({
                        src: s + a,
                        success: function(e) {
                            wx.request({
                                url: g.siteInfo.siteroot + "?i=" + g.siteInfo.uniacid + "&from=wxapp&c=entry&a=wxapp&do=DelwxCode&m=wnjz_sun",
                                data: {
                                    imgurl: a
                                },
                                success: function(e) {
                                    console.log(e.data);
                                }
                            }), console.log("图片缓存2"), console.log(e), t(e.path);
                        },
                        fail: function(e) {
                            wx.request({
                                url: g.siteInfo.siteroot + "?i=" + g.siteInfo.uniacid + "&from=wxapp&c=entry&a=wxapp&do=DelwxCode&m=wnjz_sun",
                                data: {
                                    imgurl: a
                                },
                                success: function(e) {
                                    console.log(e.data);
                                }
                            }), console.log("图片2保存失败"), t(s + a), console.log(e);
                        }
                    });
                });
                Promise.all([ e, n, o, t ]).then(function(e) {
                    console.log(e), console.log("进入 promise"), console.log(l);
                    var t = wx.createCanvasContext(u), o = c.bname, n = e[0], s = e[1], a = e[2], i = e[3];
                    t.rect(0, 0, 750, 1234), t.setStrokeStyle("rgba(0,0,0,0)"), t.drawImage(i, 0, 0, 750, 1334), 
                    t.beginPath(), t.rect(30, 260, 690, 870), t.setStrokeStyle("rgba(0,0,0,0)"), t.setFillStyle("#fff"), 
                    t.fill(), t.drawImage(n, 60, 150, 630, 630), t.setFillStyle("#000"), g.drawText(o, 65, 780, 600, t), 
                    t.drawImage(a, 85, 890, 70, 70), t.setFillStyle("#222"), t.setFontSize(28), t.fillText(f.name, 180, 910), 
                    t.setFillStyle("#e5bb03"), t.setFontSize(20), t.fillText("向您推荐", 180, 945), t.setFillStyle("#e9472c"), 
                    t.setFontSize(22), t.setFillStyle("#e9472c"), t.setFontSize(32), 1 == r ? t.fillText(c.pname + "欢迎您", 73, 1040) : 2 == r && (t.drawImage("/style/images/kj.png", 75, 995, 100, 48), 
                    t.fillText("￥", 73, 1073), t.fillText(c.kjprice, 97, 1060)), t.drawImage(s, 475, 890, 200, 200), 
                    t.stroke(), t.draw(), console.log("结束 promise"), wx.hideLoading(), wx.showLoading({
                        title: "开始生成海报..."
                    }), new Promise(function(e, t) {
                        setTimeout(function() {
                            e("second ok");
                        }, 500);
                    }).then(function(e) {
                        console.log(e), wx.canvasToTempFilePath({
                            x: 0,
                            y: 0,
                            width: 750,
                            height: 1234,
                            destWidth: 750,
                            destHeight: 1234,
                            canvasId: u,
                            success: function(e) {
                                console.log("进入 canvasToTempFilePath"), d.setData({
                                    prurl: e.tempFilePath,
                                    hidden: !1
                                }), wx.hideLoading();
                            },
                            fail: function(e) {
                                console.log(e);
                            }
                        });
                    });
                });
            }
        });
    },
    drawText: function(e, t, o, n, s) {
        var a = e.split(""), i = "", l = [];
        s.font = "28rpx Arial", s.fillStyle = "#222222", s.textBaseline = "middle";
        for (var c = 0; c < a.length; c++) s.measureText(i).width < n ? i += a[c] : (c--, 
        l.push(i), i = "");
        if (l.push(i), 2 < l.length) {
            var r = l.slice(0, 2), u = r[1], g = "", d = [];
            for (c = 0; c < u.length - 3 && s.measureText(g).width < n; c++) g += u[c];
            d.push(g);
            var f = d[0] + "...";
            r.splice(1, 1, f), l = r;
        }
        for (var p = 0; p < l.length; p++) s.fillText(l[p], t, o + 36 * (p + 1));
    }
});