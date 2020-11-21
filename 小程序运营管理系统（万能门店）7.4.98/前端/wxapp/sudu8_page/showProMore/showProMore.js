var WxParse = require("../../sudu8_page/resource/wxParse/wxParse.js"), app = getApp();

Page({
    data: {
        imgUrls: [],
        num: 1,
        indicatorDots: !0,
        autoplay: !0,
        interval: 3e3,
        duration: 1e3,
        circular: !0,
        sc: 0,
        guige: 0,
        protab: 1,
        foot: 1,
        nowcon: "con",
        is_comment: 0,
        comments: 2,
        share: 0,
        u_gwc: 0,
        xzarr: [],
        gwccount: 0,
        products: [ {
            xsl: 0
        } ],
        fxsid: 0,
        heighthave: 0,
        minHeight: 220,
        shareHome: 0,
        currentSwiper: 0
    },
    onPullDownRefresh: function() {
        var t = this;
        t.data.id;
        t.getPro(), t.gwcdata(), wx.stopPullDownRefresh();
    },
    onLoad: function(t) {
        var a = this, e = t.id;
        a.setData({
            id: e
        });
        var s = 0;
        t.fxsid && (s = t.fxsid, a.setData({
            fxsid: t.fxsid,
            shareHome: 1
        })), t.userid && a.setData({
            userid: t.userid
        }), app.util.request({
            url: "entry/wxapp/BaseMin",
            data: {
                vs1: 1
            },
            success: function(t) {
                a.setData({
                    commbase: t.data.data
                }), wx.setNavigationBarColor({
                    frontColor: a.data.commbase.base_tcolor,
                    backgroundColor: a.data.commbase.base_color
                });
            }
        }), app.util.getUserInfo(a.getinfos, s);
    },
    checkvip: function(e) {
        var s = this, t = wx.getStorageSync("openid");
        wx.request({
            url: app.util.url("entry/wxapp/checkvip", {
                m: "sudu8_page"
            }),
            data: {
                kwd: "duo",
                openid: t,
                id: s.data.id,
                gz: 1
            },
            success: function(t) {
                if (!1 === t.data.data) return s.setData({
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
                var a;
                0 < t.data.data.needgrade ? (s.setData({
                    needvip: !0
                }), 0 < t.data.data.grade ? t.data.data.grade < t.data.data.needgrade ? wx.showModal({
                    title: "进入失败",
                    content: "使用本功能需成为" + t.data.data.vipname + "(" + t.data.data.needgrade + "级)以上等级会员,请先升级!",
                    showCancel: !1,
                    success: function(t) {
                        t.confirm && wx.redirectTo({
                            url: "/sudu8_page/open1/open1"
                        });
                    }
                }) : "gwc" == (a = e.currentTarget.dataset.type) ? s.gwcget() : "gm" == a && s.gmget() : t.data.data.grade < t.data.data.needgrade ? wx.showModal({
                    title: "进入失败",
                    content: "使用本功能需成为" + t.data.data.vipname + "(" + t.data.data.needgrade + "级)以上等级会员,请先开通会员后再升级会员等级!",
                    showCancel: !1,
                    success: function(t) {
                        t.confirm && wx.redirectTo({
                            url: "/sudu8_page/register/register"
                        });
                    }
                }) : "gwc" == (a = e.currentTarget.dataset.type) ? s.gwcget() : "gm" == a && s.gmget()) : "gwc" == (a = e.currentTarget.dataset.type) ? s.gwcget() : "gm" == a && s.gmget();
            },
            fail: function(t) {}
        });
    },
    redirectto: function(t) {
        var a = t.currentTarget.dataset.link, e = t.currentTarget.dataset.linktype;
        app.util.redirectto(a, e);
    },
    getinfos: function() {
        var a = this;
        wx.getStorage({
            key: "openid",
            success: function(t) {
                a.setData({
                    openid: t.data
                }), a.getPro(), a.gwcdata(), a.givepscore();
            }
        });
    },
    getPro: function() {
        var p = this, t = p.data.fxsid, a = p.data.openid, e = p.data.id;
        app.util.request({
            url: "entry/wxapp/globaluserinfo",
            data: {
                openid: a
            },
            success: function(t) {
                p.setData({
                    globaluser: t.data.data
                }), wx.stopPullDownRefresh();
            }
        }), app.util.request({
            url: "entry/wxapp/duoproducts",
            data: {
                id: e,
                fxsid: t,
                openid: a
            },
            success: function(t) {
                var a = t.data.data, e = t.data.data.products.grade, s = t.data.data.products.discount_status;
                if (0 < e && 0 < s) {
                    var i = t.data.data.products.discount;
                    if (2 == s) {
                        if (0 < i.length) for (var o = 0; o < i.length; o++) if (e == i[o].grade) {
                            var n = i[o].discount;
                            break;
                        }
                    } else n = i;
                } else n = 0;
                var r = a.products;
                if (1 == r.is_sale) return wx.showModal({
                    title: "提示",
                    content: "该商品已下架,请选择其他商品",
                    showCancel: !1,
                    success: function() {
                        wx.redirectTo({
                            url: "/sudu8_page/index/index"
                        });
                    }
                }), !1;
                wx.setNavigationBarTitle({
                    title: r.title
                }), p.setData({
                    products: r,
                    discounts: n,
                    imgUrls: r.imgtext,
                    guiz: a.guiz
                }), r.texts && WxParse.wxParse("content", "html", r.texts, p, 5);
                var d = a.grouparr, c = "";
                for (o = 0; o < d.length; o++) c += d[o] + "、";
                var u = c.substring(0, c.length - 1);
                p.setData({
                    strgrouparr: u,
                    grouparr: d
                });
                var g = a.grouparr_val;
                p.setData({
                    gzjson: g
                }), 1 == a.shouc ? p.setData({
                    sc: 0
                }) : p.setData({
                    sc: 1
                }), p.getproinfo(), p.gwcdata();
            }
        });
    },
    swiperLoad: function(s) {
        var i = this;
        wx.getSystemInfo({
            success: function(t) {
                var a = s.detail.width / s.detail.height, e = t.windowWidth / a;
                i.data.heighthave || i.setData({
                    minHeight: e,
                    heighthave: 1
                });
            }
        });
    },
    onShareAppMessage: function() {
        var t = wx.getStorageSync("openid"), a = this.data.products, e = this.data.id, s = "";
        return s = 1 == this.data.globaluser.fxs ? "/sudu8_page/showProMore/showProMore?id=" + e + "&userid=" + t : "/sudu8_page/showProMore/showProMore?id=" + e + "&userid=" + t + "&fxsid=" + t, 
        {
            title: a.title,
            path: s,
            imageUrl: this.data.products.shareimg
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
    poster: function() {
        wx.navigateTo({
            url: "/sudu8_page/poster/poster"
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
            guige: 0
        });
    },
    color_change: function(t) {},
    collect: function() {
        var e = this, t = e.data.sc, a = e.data.id, s = e.data.baseinfo, i = wx.getStorageSync("openid");
        if (1 == s.is_sale) return wx.showModal({
            title: "提示",
            content: "该商品已下架,请选择其他商品",
            showCancel: !1,
            success: function() {
                wx.redirectTo({
                    url: "/sudu8_page/index/index"
                });
            }
        }), !1;
        0 == t ? (wx.showLoading({
            title: "收藏中"
        }), app.util.request({
            url: "entry/wxapp/Collect",
            data: {
                openid: i,
                types: "showProMore",
                id: a
            },
            header: {
                "content-type": "application/json"
            },
            success: function(t) {
                var a = t.data.data;
                "收藏成功" == a ? e.setData({
                    sc: 1
                }) : e.setData({
                    sc: 0
                }), wx.showToast({
                    title: a,
                    icon: "succes",
                    duration: 1e3,
                    mask: !0
                });
            }
        })) : (wx.showLoading({
            title: "取消收藏中"
        }), app.util.request({
            url: "entry/wxapp/Collect",
            data: {
                openid: i,
                types: "showProMore",
                id: a
            },
            header: {
                "content-type": "application/json"
            },
            success: function(t) {
                var a = t.data.data;
                "取消收藏成功" == a ? e.setData({
                    sc: 0
                }) : e.setData({
                    sc: 1
                }), wx.showToast({
                    title: a,
                    icon: "succes",
                    duration: 1e3,
                    mask: !0
                });
            }
        })), setTimeout(function() {
            wx.hideLoading();
        }, 1e3);
    },
    changepro: function(t) {
        var a = t.currentTarget.dataset.id, e = (this.data.grouparr, t.currentTarget.dataset.index), s = this.data.gzjson;
        s[a].ck = e, this.setData({
            gzjson: s
        }), this.getproinfo();
    },
    getproinfo: function() {
        for (var e = this, t = e.data.gzjson, a = e.data.grouparr, s = "", i = e.data.id, o = 0; o < a.length; o++) {
            s += t[a[o]].val[t[a[o]].ck] + "|";
        }
        var n = s.substring(0, s.length - 1);
        app.util.request({
            url: "entry/wxapp/duoproductsinfoNew",
            data: {
                str: n,
                id: i
            },
            success: function(t) {
                var a = t.data.data;
                if (e.setData({
                    proinfo: a.proinfo,
                    baseinfo: a.baseinfo,
                    newstr: n
                }), 1 == e.data.baseinfo.is_sale) return wx.showModal({
                    title: "提示",
                    content: "该商品已下架,请选择其他商品",
                    showCancel: !1,
                    success: function() {
                        wx.redirectTo({
                            url: "/sudu8_page/index/index"
                        });
                    }
                }), !1;
            }
        });
    },
    gwcget: function() {
        var a = this, t = a.data.proinfo, e = a.data.num, s = a.data.baseinfo, i = wx.getStorageSync("openid");
        return 0 == t.kc ? (wx.showModal({
            title: "提醒",
            content: "您来晚了，已经卖完了！",
            showCancel: !1
        }), !1) : 1 == s.is_sale ? (wx.showModal({
            title: "提示",
            content: "该商品已下架,请选择其他商品",
            showCancel: !1,
            success: function() {
                wx.redirectTo({
                    url: "/sudu8_page/index/index"
                });
            }
        }), !1) : void app.util.request({
            url: "entry/wxapp/gwcadd",
            data: {
                openid: i,
                id: t.id,
                prokc: e
            },
            success: function(t) {
                wx.showToast({
                    title: "加入成功",
                    icon: "success",
                    duration: 2e3,
                    success: function() {
                        a.guige_hidden(), a.gwcdata();
                    }
                });
            }
        });
    },
    gmget: function() {
        var t = this, a = t.data.proinfo, e = t.data.num, s = t.data.products, i = t.data.baseinfo, o = t.data.guiz;
        if (0 == a.kc) return wx.showModal({
            title: "提醒",
            content: "您来晚了，已经卖完了！",
            showCancel: !1
        }), !1;
        if (1 == i.is_sale) return wx.showModal({
            title: "提示",
            content: "该商品已下架,请选择其他商品",
            showCancel: !1,
            success: function() {
                wx.redirectTo({
                    url: "/sudu8_page/index/index"
                });
            }
        }), !1;
        for (var n = a.comment.split(","), r = "", d = 0; d < n.length; d++) {
            var c = d + 1;
            r += n[d] + ":" + a["type" + c] + ",";
        }
        r = r.substring(0, r.length - 1);
        a.ggz = r;
        var u = 1 * a.price * e, g = {};
        g.cid = i.cid, g.id = i.id, g.title = i.title, g.thumb = i.thumb, s.baseinfo = g, 
        s.proinfo = a, s.num = e, s.pvid = a.pid, s.one_bili = o.one_bili, s.two_bili = o.two_bili, 
        s.three_bili = o.three_bili;
        var p = [];
        p.push(s), wx.setStorage({
            key: "jsdata",
            data: p
        }), wx.setStorage({
            key: "jsprice",
            data: u
        }), wx.navigateTo({
            url: "/sudu8_page/order_more/order_more?discounts=" + t.data.discounts
        });
    },
    gwcdata: function() {
        var a = this, t = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/gwcdata",
            data: {
                openid: t
            },
            success: function(t) {
                a.setData({
                    gwccount: t.data.data
                });
            }
        });
    },
    givepscore: function() {
        var t = this.data.id, a = this.data.userid, e = wx.getStorageSync("openid");
        a != e && 0 != a && "" != a && app.util.request({
            url: "entry/wxapp/giveposcore",
            data: {
                id: t,
                types: "showProMore",
                openid: e,
                fxsid: a
            },
            success: function(t) {}
        });
    },
    swiperChange: function(t) {
        this.setData({
            currentSwiper: t.detail.current
        });
    },
    goevaluate: function() {
        var t = this.data.id;
        wx.navigateTo({
            url: "/sudu8_page/evaluate_list/evaluate_list?id=" + t + "&protype=duo"
        });
    }
});