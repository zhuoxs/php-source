function _defineProperty(a, t, e) {
    return t in a ? Object.defineProperty(a, t, {
        value: e,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : a[t] = e, a;
}

var common = require("commer.js"), util = require("../../../utils/util.js"), app = getApp();

Page({
    data: {
        indicatorDots: !1,
        autoplay: !0,
        interval: 5e3,
        duration: 1e3,
        circular: !0,
        previousmargin: "50rpx",
        nextmargin: "50rpx",
        indicatordots: !0,
        swiperCurrent: 0,
        tuhight: 0,
        thiseven: 0,
        gun: !0,
        pageNum: 0,
        text: [ "综合", "佣金比例", "销量", "价格" ],
        zoor: 0,
        paper: 0,
        shouquan: 0,
        loding: !0,
        isHideTitleBar: !1,
        parameter: 0,
        jingxu_index: 0,
        jingxu: "",
        fix: !1,
        lefOrRigOne: !0,
        leftTwo: "383rpx",
        flag: !0,
        animationData: {},
        jump: 0,
        bacolor: "",
        nav: []
    },
    helloMINA: function() {
        common.sayHello("MINA");
    },
    bindchange: function(a) {
        this.setData({
            tuhight: a.detail.current
        });
    },
    bindchangeto: function(a) {
        if (0 == a.detail.current) {
            var t = this.data.Indexcolorbox[a.detail.current].color;
            this.setData({
                tuhight: a.detail.current,
                bacolor: t
            });
        } else {
            t = this.data.Indexcolorbox[a.detail.current].color;
            this.setData({
                tuhight: a.detail.current,
                bacolor: t
            });
        }
    },
    joggle: function() {
        var a = this, t = a.data.parameter;
        if (0 == t) var e = "entry/wxapp/Goodslist", i = "../../resource/images/pd.png"; else if (1 == t) e = "entry/wxapp/Mogugoodslist", 
        i = "../../resource/images/mg.png"; else if (2 == t) e = "entry/wxapp/Jdgoodslist", 
        i = "../../resource/images/jd.png";
        a.setData({
            Goodslist: e,
            sahngf_view_img: i
        }), a.shangpin();
    },
    threeterminal: function(a) {
        var t = a.currentTarget.dataset.index;
        this.setData({
            jingxu_index: t,
            parameter: t,
            pageNum: 0
        }), this.joggle();
    },
    submitInfo: function(a) {
        console.log("获取id"), console.log(a.detail.target.dataset.name);
        var t = this;
        t.Mogugoodslist();
        var e = a.detail.formId;
        console.log(e), console.log("获取formid结束"), t.setData({
            formid: e
        }), app.util.request({
            url: "entry/wxapp/formid",
            method: "POST",
            data: {
                user_id: app.globalData.user_id,
                formid: t.data.formid
            },
            success: function(a) {
                app.util.request({
                    url: "entry/wxapp/Canyusccess",
                    method: "POST",
                    data: {
                        user_id: app.globalData.user_id
                    },
                    success: function(a) {
                        console.log(a);
                    }
                });
            }
        });
    },
    zai: function() {
        this.data.shenhe;
        this.setData({
            shouquan: 0
        });
    },
    submitIntijiao: function(a) {
        this.submitInfotwo(a), this.fenlei(a);
    },
    submitInsearch: function(a) {
        this.submitInfotwo(a), this.search();
    },
    submitIntinan: function(a) {
        this.submitInfotwo(a), this.zhuti();
    },
    submitInjinri: function(a) {
        this.submitInfotwo(a), this.screen(a);
    },
    submitInfodetails: function(a) {
        this.submitInfotwo(a), this.details(a);
    },
    as: function() {
        app.util.request({
            url: "entry/wxapp/Jdgoodslist",
            method: "POST",
            success: function(a) {}
        });
    },
    submitInxauioxi: function(a) {
        this.submitInfotwo(a), this.xauioxi(a);
    },
    submitInfolopes: function(a) {
        this.submitInfotwo(a), this.Redenvelopes();
    },
    submitIngroom: function(a) {
        this.submitInfotwo(a), this.groom(a);
    },
    submitInfotwo: function(a) {
        console.log("获取id");
        var t = a.detail.formId;
        console.log(t), console.log("获取formid结束"), this.setData({
            formid: t
        }), app.util.request({
            url: "entry/wxapp/formid",
            method: "POST",
            data: {
                user_id: app.globalData.user_id,
                formid: this.data.formid
            },
            success: function(a) {
                app.util.request({
                    url: "entry/wxapp/Formid",
                    method: "POST",
                    data: {
                        user_id: app.globalData.user_id
                    },
                    success: function(a) {
                        console.log(a);
                    }
                });
            }
        });
    },
    preventTouchMove: function() {},
    more: function(a) {
        wx.reLaunch({
            url: "../groom/groom"
        });
    },
    groom: function(a) {
        var t = a.currentTarget.dataset.id;
        wx.reLaunch({
            url: "../groom/groom?currentTab=" + t
        });
    },
    getUserInfo: function(t) {
        var e = this;
        wx.getSetting({
            success: function(a) {
                console.log(a), a.authSetting["scope.userInfo"] ? e.login(t) : wx.showModal({
                    title: "提示",
                    content: "获取用户信息失败,需要授权才能继续使用！",
                    showCancel: !1,
                    confirmText: "授权",
                    success: function(a) {
                        a.confirm && wx.openSetting({
                            success: function(a) {
                                a.authSetting["scope.userInfo"] ? wx.showToast({
                                    title: "授权成功"
                                }) : wx.showToast({
                                    title: "未授权..."
                                });
                            }
                        });
                    }
                });
            },
            fail: function(a) {
                console.log(a);
            }
        });
    },
    login: function(e) {
        var i = this;
        app.globalData.userInfo ? ("function" == typeof cb && cb(app.globalData.userInfo), 
        i.register(function(a) {})) : wx.login({
            success: function(a) {
                var t = e.detail;
                app.globalData.userInfo = t.userInfo, t.act = "autologin", t.code = a.code, app.util.request({
                    url: "entry/wxapp/getopenid",
                    method: "post",
                    dataType: "json",
                    data: t,
                    success: function(a) {
                        0 == a.data.errno && (t.openid = a.data.data.openid, t.session_key = a.data.data.session_key, 
                        app.globalData.userInfo = t, app.globalData.openid = a.data.data.openid, app.globalData.session_key = a.data.data.session_key, 
                        wx.setStorageSync("user", e), "function" == typeof cb && cb(app.globalData.userInfo), 
                        i.register(function(a) {}), i.setData({
                            session_key: a.data.data.session_key
                        }));
                    }
                });
            },
            fail: function(a) {
                console.log("获取失败");
            }
        });
    },
    onLoad: function(a) {
        this.setData({
            qieone: 0,
            qietwo: 0,
            qiethree: 0
        }), this.Indexcolorbox();
        var t = a.user_id;
        this.setData({
            activation: t
        });
    },
    Mogugoodslist: function() {
        app.util.request({
            url: "entry/wxapp/Mogugoodslist",
            method: "POST",
            success: function(a) {}
        });
    },
    geezer: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/Shenhe",
            method: "POST",
            success: function(a) {
                1 == a.data.data.shenhe ? wx.reLaunch({
                    url: "../trial/trial"
                }) : t.home();
            },
            fail: function(a) {
                console.log("失败" + a);
            }
        });
    },
    shangpin: function() {
        var i = this;
        app.util.request({
            url: i.data.Goodslist,
            method: "POST",
            data: {
                user_id: app.globalData.user_id
            },
            success: function(a) {
                var t = a.data.data.list, e = a.data.data.toplist;
                i.setData({
                    goodsist: t,
                    toplist: e
                });
            },
            fail: function(a) {
                console.log("失败" + a);
            }
        });
    },
    zhuti: function() {
        0 == this.data.theme.jump ? wx.navigateTo({
            url: "../Preferential/Preferential"
        }) : wx.navigateTo({
            url: "../Extension/Extension"
        });
    },
    screen: util.throttle(function(a) {
        var t = a.currentTarget.dataset.id;
        wx.navigateTo({
            url: "../screen/screen?screen_id=" + t
        });
    }, 2e3),
    xauioxi: function() {
        wx.navigateTo({
            url: "../logs/logs"
        });
    },
    tu: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/Share",
            method: "POST",
            success: function(a) {
                var t = a.data.data.fenxtu;
                e.setData({
                    fenxtu: t
                });
            }
        });
    },
    fenlei: function(a) {
        var t = a.currentTarget.dataset.cateid, e = a.currentTarget.dataset.jump;
        0 == e ? t && wx.navigateTo({
            url: "../classify/classify?cateid=" + t
        }) : 1 == e ? wx.navigateTo({
            url: "../ties/ties"
        }) : 2 == e ? wx.navigateTo({
            url: "../inspector/inspector"
        }) : 3 == e ? wx.navigateTo({
            url: "../../component/pages/changtu/changtu"
        }) : 4 == e && wx.navigateTo({
            url: "../redpacket/redpacket"
        });
    },
    jaizai: function(a) {
        var i = this, o = i.data.goodsist;
        app.util.request({
            url: i.data.Goodslist,
            method: "POST",
            data: {
                pageNum: a,
                user_id: app.globalData.user_id
            },
            success: function(a) {
                for (var t = a.data.data.list, e = 0; e < t.length; e++) o.push(t[e]);
                i.setData({
                    goodsist: o,
                    loding: !0
                });
            }
        });
    },
    onReady: function() {
        var a = wx.createAnimation({
            duration: 200,
            timingFunction: "linear"
        });
        this.animation = a;
    },
    conScroll: function(a) {
        var t, e = this.data.nav.length, i = wx.getSystemInfoSync().windowWidth, o = i / 750 * (148 * e) - i;
        this.data.flag ? (t = 40 + a.detail.scrollLeft / o * 28 + "rpx", console.log("true" + a.detail.scrollLeft)) : t = 40 + (o - a.detail.scrollLeft) / o * 28 + "rpx", 
        this.animation.width(t).step(), this.setData({
            animationData: this.animation.export()
        });
    },
    conScrLower: function(a) {
        this.animation.width("40rpx").step(), this.setData({
            lefOrRigOne: !1,
            leftTwo: "335rpx",
            animationData: this.animation.export(),
            flag: !1
        });
    },
    conScrUpper: function(a) {
        this.animation.width("40rpx").step(), this.setData({
            lefOrRigOne: !0,
            leftTwo: "383rpx",
            animationData: this.animation.export(),
            flag: !0
        });
    },
    onReachBottom: function() {
        console.log(this.data.goods);
        var a = this.data.pageNum;
        a++, this.jaizai(a), this.setData({
            loding: !1,
            pageNum: a
        });
    },
    details: function(a) {
        var t = a.currentTarget.dataset.id, e = (a.currentTarget.dataset.jump, a.currentTarget.dataset.hui, 
        a.currentTarget.dataset.itemurl), i = a.currentTarget.dataset.skuid, o = this.data.parameter, n = a.currentTarget.dataset.materialurl, s = a.currentTarget.dataset.couponurl;
        0 == o ? wx.navigateTo({
            url: "../details/details?goods_id=" + t + "&parameter=" + o
        }) : 1 == o ? wx.navigateTo({
            url: "../details/details?itemUrl=" + e + "&parameter=" + o
        }) : 2 == o && (app.globalData.couponUrl = s, wx.navigateTo({
            url: "../details/details?skuId=" + i + "&parameter=" + o + "&materialUrl=" + n
        }));
    },
    detailsaa: function(a) {
        var t = a.currentTarget.dataset.id, e = a.currentTarget.dataset.jump, i = a.currentTarget.dataset.hui;
        if (1 == e) "" != t && wx.navigateTo({
            url: "../details/details?goods_id=" + t + "&hui=" + i
        }); else if (2 == e) wx.navigateTo({
            url: "../classify/classify?cateid=" + t
        }); else if (3 == e) {
            var o = a.currentTarget.dataset.appid, n = a.currentTarget.dataset.path;
            wx.navigateToMiniProgram({
                appId: o,
                path: n,
                extraData: {
                    user_id: this.data.user_id
                },
                envVersion: "release",
                success: function(a) {
                    console.log("成功");
                },
                fail: function(a) {
                    console.log(a);
                }
            });
        } else if (4 == e) wx.reLaunch({
            url: "../soso/soso"
        }); else if (5 == e) {
            var s = a.currentTarget.dataset.diypic;
            wx.navigateTo({
                url: "../danye/danye?diypic=" + s
            });
        } else 6 == e ? wx.navigateTo({
            url: "../../component/pages/changtu/changtu"
        }) : 8 == e && wx.reLaunch({
            url: "../inspector/inspector?ov=1"
        });
    },
    search: function() {
        wx.navigateTo({
            url: "../search/search"
        });
    },
    dianji: function(a) {
        var t = this, e = t.data.cateid;
        null == e && (e = "");
        var i = a.currentTarget.dataset.index;
        if (0 == i) {
            t.data.qieone;
            0 == t.data.qieone ? (t.setData({
                qieone: 0
            }), t.paixu(0, e)) : (t.setData({
                qieone: 1
            }), t.paixu(1, e));
        }
        if (1 == i) {
            t.data.qieone;
            1 == t.data.qieone ? (t.setData({
                qieone: 2
            }), t.paixu(2, e)) : (t.setData({
                qieone: 1
            }), t.paixu(1, e));
        } else 1 != i && t.setData({
            qieone: 0
        });
        if (2 == i) {
            t.data.qietwo;
            1 == t.data.qietwo ? (t.setData({
                qietwo: 2
            }), t.paixu(6, e)) : (t.setData({
                qietwo: 1
            }), t.paixu(5, e));
        } else 2 != i && t.setData({
            qietwo: 0
        });
        if (3 == i) {
            t.data.qiethree;
            1 == t.data.qiethree ? (t.setData({
                qiethree: 2
            }), t.paixu(4, e)) : (t.setData({
                qiethree: 1
            }), t.paixu(3, e));
        } else 2 != i && t.setData({
            qiethree: 0
        });
        t.setData({
            thiseven: a.currentTarget.dataset.index
        });
    },
    qirw: function(a) {
        this.setData({
            zoor: a.currentTarget.dataset.index
        });
    },
    Indexcolorbox: function() {
        var i = this;
        wx.showToast({
            title: this.data.bacolor,
            icon: "loading",
            duration: 1e4
        }), app.util.request({
            url: "entry/wxapp/Indexcolorbox",
            method: "POST",
            success: function(a) {
                var t = a.data.data;
                if (i.data.Indexcolorbox) t = i.data.Indexcolorbox;
                var e = t[0].color;
                i.setData({
                    Indexcolorbox: t,
                    bacolor: e
                });
            }
        });
    },
    tiao: function() {
        wx.navigateTo({
            url: "../../component/pages/changtu/changtu"
        });
    },
    paixu: function(a, t) {
        var e = this;
        app.util.request({
            url: e.data.Goodslist,
            method: "POST",
            data: {
                rankno: a,
                cateid: t,
                user_id: app.globalData.user_id
            },
            success: function(a) {
                var t = a.data.data.list;
                e.setData({
                    goodsist: t
                });
            }
        });
    },
    Baokuanlist: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/Baokuanlist",
            method: "POST",
            success: function(a) {
                var t = a.data.data.goodslist;
                e.setData({
                    Baokuanlist: t
                });
            }
        });
    },
    Navlist: function() {
        var s = this;
        app.util.request({
            url: "entry/wxapp/Navlist",
            method: "POST",
            success: function(a) {
                for (var t = a.data.data.nav, e = a.data.data.banner, i = [], o = 0, n = t.length; o < n; o += 2) i.push(t.slice(o, o + 2));
                i.length / 2 == 0 || i[i.length - 1].push([]), console.log(i), s.setData({
                    nav: i,
                    banner: e
                });
            }
        });
    },
    Headcolor: function() {
        var x = this;
        app.util.request({
            url: "entry/wxapp/Headcolor",
            method: "POST",
            data: {
                user_id: app.globalData.user_id
            },
            success: function(a) {
                var t, e = a.data.data.yesno, i = a.data.data.config.search_color, o = a.data.data.config.share_icon;
                a.data.data.config.head_color;
                app.globalData.Headcolor = a.data.data.config.head_color;
                var n = a.data.data.config.title;
                app.globalData.title = a.data.data.config.title;
                var s = a.data.data.show, r = a.data.data.config.shenhe, u = a.data.data.config.kaiguan, d = a.data.data.config.text, l = a.data.data.theme, c = a.data.data.config, p = (c.enable, 
                a.data.data.hongbao), g = a.data.data.hb, f = a.data.data.is_daili, h = a.data.data.icon;
                s = a.data.data.show;
                if (0 == u) var m = [ "拼多多" ]; else if (1 == u) m = [ "拼多多", "蘑菇街" ]; else if (2 == u) m = [ "拼多多", "京东" ]; else if (3 == u) m = [ "拼多多", "蘑菇街", "京东" ];
                x.setData((_defineProperty(t = {
                    yesno: e,
                    show: s,
                    search_color: i,
                    share_icon: o,
                    backgroundColor: app.globalData.Headcolor,
                    shenhe: r
                }, "show", s), _defineProperty(t, "text", d), _defineProperty(t, "theme", l), _defineProperty(t, "config", c), 
                _defineProperty(t, "hongbao", p), _defineProperty(t, "config", c), _defineProperty(t, "hb", g), 
                _defineProperty(t, "is_daili", f), _defineProperty(t, "icon", h), _defineProperty(t, "jingxu", m), 
                _defineProperty(t, "kaiguan", u), _defineProperty(t, "jingxu", m), t)), wx.setNavigationBarTitle({
                    title: n
                });
            },
            fail: function(a) {
                console.log("失败" + a);
            }
        });
    },
    Redenvelopes: function() {
        this.data.paper;
        this.setData({
            paper: 0
        }), app.util.request({
            url: "entry/wxapp/Hblog",
            method: "POST",
            data: {
                user_id: app.globalData.user_id
            },
            success: function(a) {},
            fail: function(a) {
                console.log("失败" + a);
            }
        }), this.Hongbaolist();
    },
    Hongbaolist: function() {
        var i = this;
        app.util.request({
            url: "entry/wxapp/Hongbaolist",
            method: "POST",
            data: {
                user_id: app.globalData.user_id,
                hbmoney: i.data.hbmoney
            },
            success: function(a) {
                var t = a.data.data.list, e = a.data.data;
                i.setData({
                    goodsist: t,
                    goodsistcsa: e
                }), wx.navigateTo({
                    url: "../redpacket/redpacket?goodsistcsa=" + e.hongbao.end_time + "&hubo=" + !0 + "&endtime=" + i.data.hb.endtime
                });
            },
            fail: function(a) {
                console.log("失败" + a);
            }
        });
    },
    fenxaiocsdad: function() {
        this.setData({
            showModalStatus: !1
        });
    },
    home: function() {
        var t = this;
        wx.getSetting({
            success: function(a) {
                if (a.authSetting["scope.userInfo"]) wx.checkSession({
                    success: function(a) {
                        t.register(function(a) {});
                    },
                    fail: function(a) {
                        t.data.shouquan;
                        t.setData({
                            shouquan: 1
                        });
                    }
                }); else {
                    t.data.shouquan;
                    t.setData({
                        shouquan: 1
                    });
                }
            }
        });
    },
    register: function(l) {
        var c = this;
        wx.getStorage({
            key: "user",
            success: function(a) {
                var t = a.data.detail.userInfo;
                app.globalData.openId = a.data.detail.openid, app.globalData.userInfo = a.data.detail.userInfo;
                var e = a.data.detail.openid;
                app.globalData.openId = a.data.detail.openid;
                var i = a.data.detail.session_key;
                app.globalData.session_key = a.data.detail.session_key;
                var o = (t = a.data.detail.userInfo).country, n = t.province, s = t.city, r = t.gender, u = t.nickName, d = t.avatarUrl;
                app.util.request({
                    url: "entry/wxapp/zhuce",
                    method: "post",
                    dataType: "json",
                    data: {
                        openid: e,
                        session_key: i,
                        nickname: u,
                        gender: r,
                        country: o,
                        province: n,
                        city: s,
                        avatar: d
                    },
                    success: function(a) {
                        c.data.shouquan;
                        c.setData({
                            shouquan: 0
                        }), app.globalData.user_id = a.data.data, c.Headcolor(), c.joggle(), c.hinf(), c.Shenhelist(), 
                        "function" == typeof l && l(a.data.data);
                    }
                });
            },
            fail: function(a) {
                c.data.shouquan;
                c.setData({
                    shouquan: 1
                });
            }
        });
    },
    onShow: function() {
        this.geezer(), this.Baokuanlist(), this.joggle(), this.Navlist();
    },
    Shenhelist: function() {
        var i = this;
        app.util.request({
            url: "entry/wxapp/Treelist",
            method: "POST",
            data: {
                user_id: app.globalData.user_id
            },
            success: function(a) {
                for (var t = a.data.data.data, e = 0; e < t.length; e++) t[e] = t[e].reverse();
                app.globalData.liswet = t, app.globalData.liswesacast = a.data.data, i.setData({
                    liswet: t
                });
            }
        });
    },
    hinf: function() {
        var i = this;
        app.util.request({
            url: "entry/wxapp/Headcolor",
            method: "POST",
            data: {
                user_id: app.globalData.user_id
            },
            success: function(a) {
                var t = a.data.data.hongbao, e = t.is_open;
                i.setData({
                    hongbao: t,
                    paper: e
                });
            },
            fail: function(a) {
                console.log("失败" + a);
            }
        });
    },
    onPageScroll: function(a) {
        if (400 < a.scrollTop) {
            if (this.data.isHideTitleBar) return;
            this.setData({
                isHideTitleBar: !0,
                fix: !0
            });
        } else this.setData({
            isHideTitleBar: !1,
            fix: !1
        });
    },
    mobtap: function() {
        var t = this, a = wx.createSelectorQuery();
        a.select("#affix").boundingClientRect(), a.exec(function(a) {
            console.log(a[0].top), t.setData({
                menuTop: a[0].top
            });
        });
    },
    mark: function(a) {
        1 == a.currentTarget.dataset.type ? wx.navigateTo({
            url: "../../game/pages/mark/mark"
        }) : wx.navigateTo({
            url: "../Preferential/Preferential"
        });
    },
    onShareAppMessage: function(a) {
        if ("button" === a.from) {
            var t = this, e = a.target.dataset.src, i = a.target.dataset.id, o = a.target.dataset.name, n = a.target.dataset.goods_title, s = a.target.dataset.itemurl, r = a.target.dataset.skuid, u = t.data.parameter, d = a.target.dataset.materialurl, l = a.target.dataset.couponurl;
            if (t.setData({
                goods_src: e,
                goods_id: i,
                goods_name: o,
                goods_title: n
            }), 0 == u) var c = "hc_pdd/pages/details/details?goods_id=" + i + "&parameter=" + u + "&user_id=" + app.globalData.user_id; else if (1 == u) c = "hc_pdd/pages/details/details?itemUrl=" + s + "&parameter=" + u + "&user_id=" + app.globalData.user_id; else if (2 == u) c = "hc_pdd/pages/details/details?skuId=" + r + "&parameter=" + u + "&materialUrl=" + d + "&couponUrl=" + l + "&user_id=" + app.globalData.user_id;
            return {
                title: t.data.goods_title,
                path: c,
                imageUrl: t.data.goods_src,
                success: function(a) {},
                fail: function(a) {}
            };
        }
        var p = (t = this).data.config;
        return t.setData({
            config: p
        }), 0 == t.data.is_daili ? {
            title: t.data.config.indextitle,
            path: "hc_pdd/pages/index/index",
            imageUrl: t.data.config.indexpic,
            success: function(a) {},
            fail: function(a) {}
        } : {
            title: t.data.config.indextitle,
            path: "hc_pdd/pages/index/index?user_id=" + app.globalData.user_id,
            imageUrl: t.data.config.indexpic,
            success: function(a) {},
            fail: function(a) {}
        };
    }
});