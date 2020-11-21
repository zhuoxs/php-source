var xunh, WxParse = require("../../sudu8_page/resource/wxParse/wxParse.js"), app = getApp();

Page({
    data: {
        imgUrls: [],
        indicatorDots: !0,
        autoplay: !0,
        interval: 3e3,
        duration: 1e3,
        circular: !0,
        num: 1,
        sc: 0,
        guige: 0,
        protab: 1,
        gwc: 1,
        gm: 0,
        foot: 1,
        nowcon: "con",
        is_comment: 0,
        comments: 2,
        share: 0,
        u_gwc: 0,
        xzarr: [],
        gwccount: 0,
        overtime: [],
        daojishi: [],
        heighthave: 0,
        isview: 0,
        currentSwiper: 0
    },
    onShow: function() {
        this.getPro();
    },
    onPullDownRefresh: function() {
        this.getinfos(), wx.stopPullDownRefresh();
    },
    onLoad: function(t) {
        var a = this, e = 0;
        t.fxsid && (e = t.fxsid, a.setData({
            fxsid: t.fxsid
        }));
        var i = t.id, n = t.shareid;
        n || (n = 0), a.setData({
            id: i,
            shareid: n
        });
        var o = app.util.url("entry/wxapp/BaseMin", {
            m: "sudu8_page"
        });
        wx.request({
            url: o,
            data: {
                vs1: 1
            },
            success: function(t) {
                a.setData({
                    baseinfo: t.data.data
                }), wx.setNavigationBarColor({
                    frontColor: a.data.baseinfo.base_tcolor,
                    backgroundColor: a.data.baseinfo.base_color
                });
            }
        }), app.util.getUserInfo(a.getinfos, e);
    },
    checkvip: function() {
        var a = this, t = wx.getStorageSync("openid");
        wx.request({
            url: app.util.url("entry/wxapp/checkvip", {
                m: "sudu8_page"
            }),
            data: {
                kwd: "pt",
                openid: t,
                id: a.data.id,
                gz: 1
            },
            success: function(t) {
                if (!1 === t.data.data) return a.setData({
                    needvip: !0
                }), wx.showModal({
                    title: "进入失败",
                    content: "使用本功能需先开通vip!",
                    showCancel: !1,
                    success: function(t) {
                        t.confirm && wx.redirectTo({
                            url: "/sudu8_page/register/register"
                        });
                    }
                }), !1;
                0 < t.data.data.needgrade ? (a.setData({
                    needvip: !0
                }), 0 < t.data.data.grade ? t.data.data.grade < t.data.data.needgrade ? wx.showModal({
                    title: "进入失败",
                    content: "使用本功能需成为" + t.data.data.vipname + "(" + t.data.data.needgrade + ")以上等级会员,请先升级!",
                    showCancel: !1,
                    success: function(t) {
                        t.confirm && wx.redirectTo({
                            url: "/sudu8_page/open1/open1"
                        });
                    }
                }) : a.gmget() : t.data.data.grade < t.data.data.needgrade ? wx.showModal({
                    title: "进入失败",
                    content: "使用本功能需成为" + t.data.data.vipname + "(" + t.data.data.needgrade + ")以上等级会员,请先开通会员后再升级会员等级!",
                    showCancel: !1,
                    success: function(t) {
                        t.confirm && wx.redirectTo({
                            url: "/sudu8_page/register/register"
                        });
                    }
                }) : a.gmget()) : a.gmget();
            },
            fail: function(t) {}
        });
    },
    redirectto: function(t) {
        var a = t.currentTarget.dataset.link, e = t.currentTarget.dataset.linktype;
        app.util.redirectto(a, e);
    },
    getinfo: function() {
        var e = this;
        wx.getStorage({
            key: "openid",
            success: function(t) {
                app.util.request({
                    url: "entry/wxapp/globaluserinfo",
                    data: {
                        openid: t.data
                    },
                    success: function(t) {
                        var a = t.data.data;
                        a.nickname && a.avatar || e.setData({
                            isview: 1
                        }), e.setData({
                            globaluser: t.data.data
                        });
                    }
                });
            }
        });
    },
    huoqusq: function(t) {
        var a = this, e = wx.getStorageSync("openid");
        if (t.detail.userInfo) {
            var i = t.detail.userInfo, n = i.nickName, o = i.avatarUrl, s = i.gender, r = i.province, u = i.city, d = i.country;
            app.util.request({
                url: "entry/wxapp/Useupdate",
                data: {
                    openid: e,
                    nickname: n,
                    avatarUrl: o,
                    gender: s,
                    province: r,
                    city: u,
                    country: d
                },
                header: {
                    "content-type": "application/json"
                },
                success: function(t) {
                    wx.setStorageSync("golobeuid", t.data.data.id), wx.setStorageSync("golobeuser", t.data.data), 
                    a.setData({
                        isview: 0,
                        globaluser: t.data.data
                    }), a.getinfo();
                }
            });
        } else wx.showModal({
            title: "获取失败",
            content: "请您允许授权",
            showCancel: !1,
            success: function(t) {
                t.confirm && wx.getSetting({
                    success: function(t) {
                        t.authSetting["scope.userInfo"] || wx.openSetting({
                            success: function(t) {
                                wx.reLaunch({
                                    url: "/sudu8_page_plugin_pt/products/products"
                                });
                            }
                        });
                    }
                });
            }
        });
    },
    getinfos: function() {
        var a = this;
        wx.getStorage({
            key: "openid",
            success: function(t) {
                a.setData({
                    openid: t.data
                }), a.getinfo();
            }
        });
    },
    swiperLoad: function(i) {
        var n = this;
        wx.getSystemInfo({
            success: function(t) {
                var a = i.detail.width / i.detail.height, e = t.windowWidth / a;
                n.data.heighthave || n.setData({
                    minHeight: e,
                    heighthave: 1
                });
            }
        });
    },
    getPro: function() {
        var g = this, t = (g.data.fxsid, g.data.openid), a = g.data.id, e = app.util.url("entry/wxapp/globaluserinfo", {
            m: "sudu8_page"
        });
        wx.request({
            url: e,
            data: {
                openid: t
            },
            success: function(t) {
                g.setData({
                    globaluser: t.data.data
                }), wx.stopPullDownRefresh();
            }
        }), app.util.request({
            url: "entry/wxapp/Ptproductinfo",
            data: {
                id: a,
                openid: t
            },
            success: function(t) {
                wx.setNavigationBarTitle({
                    title: t.data.data.products.title
                });
                var a = t.data.data, e = a.products, i = a.pingtuan, n = a.overtime, o = a.pingtcount;
                0 == e.show_pro && wx.showModal({
                    title: "提示",
                    content: "该商品已下架,请选择其他商品",
                    showCancel: !1,
                    success: function() {
                        wx.redirectTo({
                            url: "/sudu8_page_plugin_pt/index/index"
                        });
                    }
                }), 1 == a.collect ? g.setData({
                    sc: 1
                }) : g.setData({
                    sc: 0
                }), g.daojishi(), g.setData({
                    products: e,
                    pintuan: i,
                    imgUrls: e.imgtext,
                    guiz: a.guiz,
                    overtime: n,
                    pingtcount: o
                }), WxParse.wxParse("content", "html", e.texts, g, 5);
                for (var s = a.grouparr, r = "", u = 0; u < s.length; u++) r += s[u] + "、";
                var d = r.substring(0, r.length - 1);
                g.setData({
                    strgrouparr: d,
                    grouparr: s
                });
                var c = a.grouparr_val;
                g.setData({
                    gzjson: c
                }), g.getproinfo();
            }
        });
    },
    daojishi: function() {
        for (var t = this, a = t.data.overtime, e = [], i = 0; i < a.length; i++) {
            var n, o, s, r, u = new Date().getTime(), d = 1e3 * parseInt(a[i]) - u;
            0 <= d && (n = Math.floor(d / 1e3 / 60 / 60 / 24), o = Math.floor(d / 1e3 / 60 / 60 % 24) < 10 ? "0" + Math.floor(d / 1e3 / 60 / 60 % 24) : Math.floor(d / 1e3 / 60 / 60 % 24), 
            s = Math.floor(d / 1e3 / 60 % 60) < 10 ? "0" + Math.floor(d / 1e3 / 60 % 60) : Math.floor(d / 1e3 / 60 % 60), 
            r = Math.floor(d / 1e3 % 60) < 10 ? "0" + Math.floor(d / 1e3 % 60) : Math.floor(d / 1e3 % 60)), 
            e[i] = n + "天" + o + ":" + s + ":" + r;
        }
        t.setData({
            daojishi: e
        }), xunh = setTimeout(function() {
            t.daojishi();
        }, 1e3);
    },
    onShareAppMessage: function() {
        var t = wx.getStorageSync("openid"), a = this.data.products, e = this.data.id, i = "";
        return i = 1 == this.data.globaluser.fxs ? "/sudu8_page_plugin_pt/products/products?id=" + e : "/sudu8_page_plugin_pt/products/products?id=" + e + "&fxsid=" + t, 
        {
            title: a.title,
            path: i
        };
    },
    share111: function() {
        this.setData({
            share: 1
        });
    },
    share_close: function() {
        this.setData({
            share: 0
        });
    },
    pinglun: function(t) {
        this.setData({
            pinglun_t: t.detail.value
        });
    },
    pinglun_sub: function() {
        var t = this.data.pinglun_t, a = this.data.id, e = wx.getStorageSync("openid");
        if ("" == t || null == t) return wx.showModal({
            content: "评论不能为空"
        }), !1;
        app.util.request({
            url: "entry/wxapp/comment",
            cachetime: "30",
            data: {
                pinglun_t: t,
                id: a,
                openid: e
            },
            success: function(t) {
                1 == t.data.data.result && (wx.showToast({
                    title: "评价提交成功",
                    icon: "success",
                    duration: 2e3
                }), setTimeout(function() {
                    wx.redirectTo({
                        url: "/sudu8_page_plugin_pt/products/products?id=" + a
                    });
                }, 2e3));
            }
        });
    },
    tabChange: function(t) {
        var a = t.currentTarget.dataset.id;
        this.setData({
            nowcon: a
        });
    },
    num_add: function() {
        var t = this.data.proinfo.kc, a = this.data.num;
        t < (a += 1) && (wx.showModal({
            title: "提醒",
            content: "您的购买数量超过了库存！",
            showCancel: !1
        }), a--), this.setData({
            num: a
        });
    },
    num_jian: function() {
        var t = this.data.num;
        1 == t ? this.setData({
            num: 1
        }) : (t -= 1, this.setData({
            num: t
        }));
    },
    gm: function() {
        wx.navigateTo({
            url: "/pages/order/order"
        });
    },
    gwc_close: function() {
        this.setData({
            gwc_block: 0
        });
    },
    gwc_block: function() {
        this.setData({
            gwc_block: 1
        });
    },
    gwc_100: function() {
        this.setData({
            gwc: 1,
            gm: 0,
            guige: 1,
            foot: 0
        });
    },
    gm_100: function() {
        this.setData({
            gwc: 0,
            gm: 1,
            guige: 1,
            foot: 0
        });
    },
    guige_block: function() {
        this.setData({
            guige: 1,
            gwc: 1,
            gm: 0
        });
    },
    guige_hidden: function() {
        this.setData({
            guige: 0,
            shareid: 0
        });
    },
    color_change: function(t) {},
    collect: function() {
        var t = this.data.sc;
        0 == t ? wx.showLoading({
            title: "收藏中"
        }) : wx.showLoading({
            title: "取消收藏中"
        }), this.collects(t);
    },
    collects: function(a) {
        var e = this, t = app.util.url("entry/wxapp/Collect", {
            m: "sudu8_page"
        });
        wx.request({
            url: t,
            cachetime: "30",
            data: {
                uniacid: e.data.uniacid,
                id: e.data.id,
                openid: wx.getStorageSync("openid"),
                types: "pt"
            },
            success: function(t) {
                1 == a ? e.setData({
                    sc: 0
                }) : e.setData({
                    sc: 1
                }), wx.showToast({
                    title: t.data.data,
                    icon: "success",
                    duration: 2e3
                }), setTimeout(function() {
                    wx.hideLoading();
                }, 1e3);
            }
        });
    },
    changepro: function(t) {
        var a = t.currentTarget.dataset.id, e = (this.data.grouparr, t.currentTarget.dataset.index), i = this.data.gzjson;
        i[a].ck = e, this.setData({
            gzjson: i
        }), this.getproinfo();
    },
    getproinfo: function() {
        for (var e = this, t = e.data.gzjson, a = e.data.grouparr, i = e.data.id, n = "", o = 0; o < a.length; o++) {
            n += t[a[o]].val[t[a[o]].ck] + "\\";
        }
        var s = n.substring(0, n.length - 1);
        app.util.request({
            url: "entry/wxapp/ptpinfo",
            data: {
                str: s,
                id: i
            },
            success: function(t) {
                0 == t.data.data.baseinfo.show_pro && wx.showModal({
                    title: "提示",
                    content: "该商品已下架,请选择其他商品",
                    showCancel: !1,
                    success: function() {
                        wx.redirectTo({
                            url: "/sudu8_page_plugin_pt/index/index"
                        });
                    }
                });
                var a = t.data.data;
                e.setData({
                    proinfo: a.proinfo,
                    baseinfo2: a.baseinfo,
                    newstr: s
                });
            }
        });
    },
    gmget: function() {
        var t = this, a = t.data.proinfo, e = t.data.num, i = t.data.products, n = t.data.baseinfo2, o = t.data.gwc, s = t.data.shareid, r = t.data.guiz;
        if (0 == a.kc) return wx.showModal({
            title: "提醒",
            content: "您来晚了，已经卖完了！",
            showCancel: !1
        }), !1;
        for (var u = a.comment.split(","), d = "", c = 0; c < u.length; c++) {
            var g = c + 1;
            d += u[c] + ":" + a["type" + g] + ",";
        }
        d = d.substring(0, d.length - 1);
        if (a.ggz = d, 1 == o) var p = 1 * a.price * e; else p = 1 * a.dprice * e;
        var l = {};
        l.cid = n.cid, l.id = n.id, l.title = n.title, l.thumb = n.thumb, i.baseinfo2 = l, 
        i.proinfo = a, i.num = e, i.pvid = a.pid, i.one_bili = r.one_bili, i.two_bili = r.two_bili, 
        i.three_bili = r.three_bili, i.gmorpt = o;
        var h = [];
        h.push(i), wx.setStorage({
            key: "jsdata",
            data: h
        }), wx.setStorage({
            key: "jsprice",
            data: p
        }), clearInterval(xunh), wx.redirectTo({
            url: "/sudu8_page_plugin_pt/order/order?shareid=" + s + "&id=" + t.data.id
        });
    },
    lijct: function(t) {
        var a = this, e = t.currentTarget.dataset.index, i = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/pdmytuanorcy",
            data: {
                shareid: e,
                openid: i
            },
            success: function(t) {
                1 == t.data.data ? (clearInterval(xunh), wx.navigateTo({
                    url: "/sudu8_page_plugin_pt/pt/pt?shareid=" + e
                })) : (a.gwc_100(), a.setData({
                    shareid: e
                }));
            }
        });
    },
    swiperChange: function(t) {
        this.setData({
            currentSwiper: t.detail.current
        });
    }
});