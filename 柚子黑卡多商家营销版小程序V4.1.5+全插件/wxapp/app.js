var App = require("mzhk_sun/sdk/qitui/oddpush.js").oddPush(App, "App").App;

App({
    globalData: {
        userInfo: null,
        hasshowpopad: !1,
        loadinghidden: !1,
        timer_slideupshoworder: "",
        Plugin_distribution: "mzhk_sun_plugin_distribution",
        Plugin_eatvisit: "mzhk_sun_plugin_eatvisit",
        Plugin_scoretask: "mzhk_sun_plugin_scoretask",
        Plugin_fission: "mzhk_sun_plugin_fission",
        Plugin_redpacket: "mzhk_sun_plugin_redpacket",
        Plugin_subcard: "mzhk_sun_plugin_subcard",
        Plugin_member: "mzhk_sun_plugin_member",
        Plugin_lottery: "mzhk_sun_plugin_lottery",
        Plugin_package: "mzhk_sun_plugin_package",
        Plugin_cloud: "mzhk_sun_plugin_cloud",
        tabBar: {
            color: "#9E9E9E",
            selectedColor: "#f00",
            backgroundColor: "#fff",
            borderStyle: "#ccc",
            list: [ {
                pagePath: "/mzhk_sun/pages/index/index",
                text: "首页",
                iconPath: "/style/images/index.png",
                selectedIconPath: "/style/images/indexSele.png",
                selectedColor: "#ef8200",
                index: 0
            }, {
                pagePath: "/mzhk_sun/pages/active/active",
                text: "活动推荐",
                iconPath: "/style/images/active.png",
                selectedIconPath: "/style/images/activeSele.png",
                selectedColor: "#ef8200",
                index: 1
            }, {
                pagePath: "/mzhk_sun/pages/goods/goods",
                text: "好店推荐",
                iconPath: "/style/images/goods.png",
                selectedIconPath: "/style/images/goodsSele.png",
                selectedColor: "#ef8200",
                index: 2,
                default: 1
            }, {
                pagePath: "/mzhk_sun/pages/user/user",
                text: "我的",
                iconPath: "/style/images/user.png",
                selectedIconPath: "/style/images/userSele.png",
                selectedColor: "#ef8200",
                index: 3
            } ],
            position: "bottom"
        }
    },
    siteInfo: require("siteinfo.js"),
    util: require("/we7/js/util.js"),
    func: require("func.js"),
    distribution: require("/zhy/distribution/distribution.js"),
    onLaunch: function() {
        var t = wx.getUpdateManager();
        t.onCheckForUpdate(function(e) {
            console.log(e.hasUpdate);
        }), t.onUpdateReady(function() {
            wx.showModal({
                title: "更新提示",
                content: "新版本已经准备好，是否重启应用？",
                success: function(e) {
                    e.confirm && t.applyUpdate();
                }
            });
        }), t.onUpdateFailed(function() {}), wx.removeStorage({
            key: "tab_navdata",
            success: function(e) {}
        }), wx.removeStorage({
            key: "System",
            success: function(e) {}
        });
        this.getSiteUrl(), wx.request({
            url: this.siteInfo.siteroot + "?i=" + this.siteInfo.uniacid + "&t=undefined&v=1.0.0&from=wxapp&c=entry&a=wxapp&do=System&m=mzhk_sun",
            header: {
                "content-type": "application/json"
            },
            success: function(e) {
                wx.setStorageSync("System", e.data);
            }
        }), wx.request({
            url: this.siteInfo.siteroot + "?i=" + this.siteInfo.uniacid + "&t=undefined&v=1.0.0&from=wxapp&c=entry&a=wxapp&do=GetqtappData&m=mzhk_sun",
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
    onShow: function() {},
    editTabBar: function(t) {
        var e = getCurrentPages(), n = e[e.length - 1], o = n.__route__;
        0 != o.indexOf("/") && (o = "/" + o);
        var s = this.globalData.tabBar, i = wx.getStorageSync("tab_navdata");
        i ? (s.url = t, s.list = i, n.setData({
            tabBar: s,
            tabBar_default: 2
        })) : this.util.request({
            url: "entry/wxapp/GetadData",
            showLoading: !1,
            data: {
                position: 9
            },
            success: function(e) {
                2 != (i = e.data) ? (wx.setStorageSync("tab_navdata", i), i ? (s.url = t, s.list = i, 
                n.setData({
                    tabBar: s,
                    tabBar_default: 2
                })) : n.setData({
                    tabBar: s,
                    tabBar_default: 1
                })) : n.setData({
                    tabBar: s,
                    tabBar_default: 1
                });
            }
        });
    },
    creatPoster: function(e, t, c, r, u) {
        console.log("-------------------"), console.log(c), console.log(e);
        var g = this, n = getCurrentPages(), d = n[n.length - 1], o = (d.__route__, this.siteInfo.siteroot.split("/app/"));
        if (1 == c.codetype) var s = this.getSiteUrl(); else s = o[0] + "/attachment/";
        var i = "";
        wx.showLoading({
            title: "获取图片中..."
        });
        var a = c.gid ? c.gid : 0, l = c.scene, p = wx.getStorageSync("users"), f = c.tabletype ? c.tabletype : 0;
        wx.request({
            url: this.siteInfo.siteroot + "?i=" + this.siteInfo.uniacid + "&t=undefined&v=1.0.0&from=wxapp&c=entry&a=wxapp&do=GetwxCode&m=mzhk_sun",
            header: {
                "content-type": "application/json"
            },
            data: {
                codetype: c.codetype,
                scene: l,
                page: e,
                width: t,
                tabletype: f,
                gid: a
            },
            success: function(l) {
                console.log("获取小程序二维码"), console.log(l.data), i = l.data;
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
                }), n = new Promise(function(t, e) {
                    wx.getImageInfo({
                        src: p.img,
                        success: function(e) {
                            console.log("用户头像缓存"), t(e.path);
                        },
                        fail: function(e) {
                            console.log("用户头像缓存失败"), t(p.img), console.log(e);
                        }
                    });
                }), o = new Promise(function(t, e) {
                    var n = s + i;
                    console.log(1111111), console.log(n), wx.getImageInfo({
                        src: s + i,
                        success: function(e) {
                            1 != c.codetype && wx.request({
                                url: g.siteInfo.siteroot + "?i=" + g.siteInfo.uniacid + "&from=wxapp&c=entry&a=wxapp&do=DelwxCode&m=mzhk_sun",
                                data: {
                                    imgurl: i
                                },
                                success: function(e) {
                                    console.log(e.data);
                                }
                            }), console.log("图片缓存2"), console.log(e), t(e.path);
                        },
                        fail: function(e) {
                            1 != c.codetype && wx.request({
                                url: g.siteInfo.siteroot + "?i=" + g.siteInfo.uniacid + "&from=wxapp&c=entry&a=wxapp&do=DelwxCode&m=mzhk_sun",
                                data: {
                                    imgurl: i
                                },
                                success: function(e) {
                                    console.log(e.data);
                                }
                            }), console.log("图片2保存失败"), t(s + i), console.log(e);
                        }
                    });
                });
                Promise.all([ e, o, n, t ]).then(function(e) {
                    console.log(e), console.log("进入 promise"), console.log(l);
                    var t = wx.createCanvasContext(u), n = c.bname, o = e[0], s = e[1], i = e[2], a = e[3];
                    t.rect(0, 0, 750, 1234), t.setStrokeStyle("rgba(0,0,0,0)"), t.drawImage(a, 0, 0, 750, 1334), 
                    t.beginPath(), t.rect(30, 260, 690, 870), t.setStrokeStyle("rgba(0,0,0,0)"), t.setFillStyle("#fff"), 
                    t.fill(), t.drawImage(o, 60, 150, 630, 630), t.setFillStyle("#000"), g.drawText(n, 65, 780, 600, t), 
                    t.drawImage(i, 85, 890, 70, 70), t.setFillStyle("#222"), t.setFontSize(28), t.fillText(p.name, 180, 910), 
                    t.setFillStyle("#e5bb03"), t.setFontSize(20), t.fillText("向您推荐", 180, 945), t.setFillStyle("#e9472c"), 
                    t.setFontSize(22), t.setFillStyle("#e9472c"), t.setFontSize(32), 1 == r ? (t.fillText("营业时间", 73, 1040), 
                    t.fillText(c.starttime + "-" + c.endtime, 73, 1072)) : 2 == r ? (t.drawImage("/style/images/pt.png", 75, 995, 100, 48), 
                    t.fillText("￥", 73, 1073), t.fillText(c.ptprice, 105, 1072)) : 3 == r ? (t.drawImage("/style/images/kj.png", 75, 995, 100, 48), 
                    t.fillText("￥", 73, 1073), t.fillText(c.kjprice, 105, 1072)) : 4 == r ? (t.drawImage("/style/images/qg.png", 75, 995, 100, 48), 
                    t.fillText("￥", 73, 1073), t.fillText(c.qgprice, 105, 1072)) : 5 == r ? t.fillText("集卡赢大奖", 73, 1073) : 6 == r ? g.drawText(c.sharetitle, 73, 1020, 300, t) : 7 == r ? (t.drawImage("/style/images/md.png", 75, 995, 100, 48), 
                    t.fillText("￥", 73, 1073), t.fillText(0, 97, 1072)) : 8 == r ? "" != c.vipprice && 0 != c.vipprice ? (t.fillText("￥", 73, 1073), 
                    t.drawImage("/style/images/hy.png", 75, 995, 100, 48), t.fillText(c.vipprice, 105, 1072)) : (t.fillText("￥", 73, 1073), 
                    t.drawImage("/style/images/ptj.png", 75, 995, 100, 48), t.fillText(c.shopprice, 105, 1072)) : 9 == r && ("" != c.vipprice && 0 != c.vipprice ? (t.fillText("￥", 73, 1073), 
                    t.drawImage("/style/images/hy.png", 75, 995, 100, 48), t.fillText(c.vipprice, 105, 1073)) : (t.fillText("￥", 73, 1073), 
                    t.drawImage("/style/images/ptj.png", 75, 995, 100, 48), t.fillText(c.shopprice, 105, 1073))), 
                    t.drawImage(s, 475, 890, 200, 200), t.stroke(), t.draw(), console.log("结束 promise"), 
                    wx.hideLoading(), wx.showLoading({
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
    drawText: function(e, t, n, o, s) {
        var i = e.split(""), a = "", l = [];
        s.font = "28rpx Arial", s.fillStyle = "#222222", s.textBaseline = "middle";
        for (var c = 0; c < i.length; c++) s.measureText(a).width < o ? a += i[c] : (c--, 
        l.push(a), a = "");
        if (l.push(a), 2 < l.length) {
            var r = l.slice(0, 2), u = r[1], g = "", d = [];
            for (c = 0; c < u.length - 3 && s.measureText(g).width < o; c++) g += u[c];
            d.push(g);
            var p = d[0] + "...";
            r.splice(1, 1, p), l = r;
        }
        for (var f = 0; f < l.length; f++) s.fillText(l[f], t, n + 36 * (f + 1));
    },
    getSiteUrl: function() {
        var t = wx.getStorageSync("url");
        if (t) return t;
        wx.request({
            url: this.siteInfo.siteroot + "?i=" + this.siteInfo.uniacid + "&t=undefined&v=1.0.0&from=wxapp&c=entry&a=wxapp&do=Url&m=mzhk_sun",
            header: {
                "content-type": "application/json"
            },
            success: function(e) {
                return t = e.data, wx.setStorageSync("url", t), t;
            }
        });
    },
    getOpenid: function(e) {
        var n = this, t = wx.getStorageSync("openid");
        if (t) return t;
        wx.login({
            success: function(e) {
                var t = e.code;
                n.util.request({
                    url: "entry/wxapp/openid",
                    showLoading: !1,
                    cachetime: "120",
                    data: {
                        code: t
                    },
                    success: function(e) {
                        return wx.setStorageSync("openid", e.data.openid), e.data.openid;
                    }
                });
            }
        });
    },
    wxauthSetting: function(e) {
        var i = this, t = getCurrentPages(), a = t[t.length - 1];
        wx.login({
            success: function(e) {
                var t = e.code;
                wx.setStorageSync("code", t), i.util.request({
                    url: "entry/wxapp/openid",
                    showLoading: !1,
                    cachetime: "3600",
                    data: {
                        code: t
                    },
                    success: function(e) {
                        wx.setStorageSync("key", e.data.session_key), wx.setStorageSync("openid", e.data.openid);
                        var s = e.data.openid, t = wx.getStorageSync("share_type"), n = wx.getStorageSync("d_user");
                        console.log("授权新形象1231"), console.log(t), console.log(n), 2 == t && s != n && "" != n && (console.log("邀请好友任务"), 
                        i.util.request({
                            url: "entry/wxapp/setInvitefriends",
                            data: {
                                m: "mzhk_sun_plugin_scoretask",
                                openid: s,
                                invite_openid: n
                            },
                            showLoading: !1,
                            success: function(e) {}
                        })), wx.getSetting({
                            success: function(e) {
                                e.authSetting["scope.userInfo"] && wx.getUserInfo({
                                    success: function(e) {
                                        var t = e.userInfo.nickName, n = e.userInfo.avatarUrl, o = e.userInfo.gender;
                                        wx.setStorageSync("user_info", e.userInfo), i.util.request({
                                            url: "entry/wxapp/Login",
                                            showLoading: !1,
                                            cachetime: "3600",
                                            data: {
                                                openid: s,
                                                img: n,
                                                name: t,
                                                gender: o
                                            },
                                            success: function(e) {
                                                wx.setStorageSync("users", e.data), wx.getStorageSync("have_wxauth") || a.onShow(), 
                                                wx.setStorageSync("uniacid", e.data.uniacid), a.setData({
                                                    is_modal_Hidden: !0,
                                                    usersinfo: e.data
                                                });
                                            }
                                        });
                                    }
                                });
                            }
                        });
                    }
                });
            }
        });
    },
    onHide: function() {
        wx.removeStorage({
            key: "currentcity",
            success: function(e) {}
        });
    }
});