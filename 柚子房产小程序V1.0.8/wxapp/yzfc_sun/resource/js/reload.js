var _api = require("./api.js");

function _defineProperty(t, a, e) {
    return a in t ? Object.defineProperty(t, a, {
        value: e,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[a] = e, t;
}

var app = getApp(), data = {
    show: !1,
    imgLink: "",
    login: !0,
    gps: !0,
    list: {
        load: !1,
        over: !1,
        page: 1,
        length: 10,
        none: !1,
        data: []
    }
}, reload = {
    getUrl: function() {
        var a = this;
        return Promise.all([ (0, _api.UrlData)(), (0, _api.ColorData)(), (0, _api.NavsetData)() ]).then(function(t) {
            return wx.setStorageSync("imgLink", t[0]), wx.setNavigationBarColor({
                frontColor: t[1].top_font_color,
                backgroundColor: t[1].top_color
            }), a.setData({
                imgLink: t[0],
                passFlag: t[1].wechat_check
            }), a.delFoot(t[2], t[1]);
        });
    },
    delFoot: function(t, a) {
        var e = [ {}, {}, {}, {} ], o = {};
        t ? (o = {
            a: t.logo_name_one,
            b: t.logo_name_two,
            c: t.logo_name_three,
            d: t.logo_name_four,
            ma: null === t.logo_img_one || "" === t.logo_img_one ? "../../resource/images/main/nav1.png" : this.data.imgLink + t.logo_img_one,
            mb: null === t.logo_img_two || "" === t.logo_img_two ? "../../resource/images/main/nav2.png" : this.data.imgLink + t.logo_img_two,
            mc: null === t.logo_img_three || "" === t.logo_img_three ? "../../resource/images/main/nav3.png" : this.data.imgLink + t.logo_img_three,
            md: null === t.logo_img_four || "" === t.logo_img_four ? "../../resource/images/main/nav4.png" : this.data.imgLink + t.logo_img_four
        }, null === t.nav_img_one || "" === t.nav_img_one ? e[0].imgh = "../../../resource/images/footer/a.png" : e[0].imgh = this.data.imgLink + t.nav_img_a, 
        null === t.nav_img_one || "" === t.nav_img_one ? e[0].img = "../../../resource/images/footer/ah.png" : e[0].img = this.data.imgLink + t.nav_img_one, 
        null === t.nav_img_two || "" === t.nav_img_two ? e[1].imgh = "../../../resource/images/footer/b.png" : e[1].imgh = this.data.imgLink + t.nav_img_b, 
        null === t.nav_img_two || "" === t.nav_img_two ? e[1].img = "../../../resource/images/footer/bh.png" : e[1].img = this.data.imgLink + t.nav_img_two, 
        null === t.nav_img_three || "" === t.nav_img_three ? e[2].imgh = "../../../resource/images/footer/c.png" : e[2].imgh = this.data.imgLink + t.nav_img_c, 
        null === t.nav_img_three || "" === t.nav_img_three ? e[2].img = "../../../resource/images/footer/ch.png" : e[2].img = this.data.imgLink + t.nav_img_three, 
        null === t.nav_img_three || "" === t.nav_img_three ? e[3].imgh = "../../../resource/images/footer/d.png" : e[3].imgh = this.data.imgLink + t.nav_img_c, 
        null === t.nav_img_three || "" === t.nav_img_three ? e[3].img = "../../../resource/images/footer/dh.png" : e[3].img = this.data.imgLink + t.nav_img_three, 
        null === t.nav_name_one || "" === t.nav_name_one ? e[0].txt = "首页" : e[0].txt = t.nav_name_one, 
        null === t.nav_name_two || "" === t.nav_name_two ? e[1].txt = "新房" : e[1].txt = t.nav_name_two, 
        null === t.nav_name_three || "" === t.nav_name_three ? e[2].txt = "发现" : e[2].txt = t.nav_name_three, 
        null === t.nav_name_four || "" === t.nav_name_four ? e[3].txt = "我的" : e[3].txt = t.nav_name_four) : (e[0].imgh = "../../../resource/images/footer/a.png", 
        e[0].img = "../../../resource/images/footer/ah.png", e[1].imgh = "../../../resource/images/footer/b.png", 
        e[1].img = "../../../resource/images/footer/bh.png", e[2].imgh = "../../../resource/images/footer/c.png", 
        e[2].img = "../../../resource/images/footer/ch.png", e[3].imgh = "../../../resource/images/footer/d.png", 
        e[3].img = "../../../resource/images/footer/dh.png", e[0].txt = "首页", e[1].txt = "新房", 
        e[2].txt = "发现", e[3].txt = "我的", o = {
            a: "",
            b: "",
            c: "",
            d: "",
            ma: "",
            mb: "",
            mc: "",
            md: ""
        }), e[0].choose = !1, e[1].choose = !1, e[2].choose = !1, e[3].choose = !1;
        var n = {
            color: a,
            foot: e,
            homenav: o
        };
        return wx.setStorageSync("config", n), new Promise(function(t, a) {
            t(n);
        });
    },
    checkUrl: function() {
        var e = wx.getStorageSync("config"), t = wx.getStorageSync("imgLink");
        if (e.color && e.foot && t) {
            var a = e.color;
            return wx.setNavigationBarColor({
                frontColor: a.top_font_color,
                backgroundColor: a.top_color
            }), this.setData({
                imgLink: t
            }), new Promise(function(t, a) {
                t(e);
            });
        }
        return this.getUrl();
    },
    navTo: function(t) {
        app.globalData.tab || (app.globalData.tab = !app.globalData.tab, wx.navigateTo({
            url: t
        }), setTimeout(function() {
            app.globalData.tab = !app.globalData.tab;
        }, 1e3));
    },
    reTo: function(t) {
        app.globalData.tab || (app.globalData.tab = !app.globalData.tab, wx.redirectTo({
            url: t
        }), setTimeout(function() {
            app.globalData.tab = !app.globalData.tab;
        }, 1e3));
    },
    lunchTo: function(t) {
        app.globalData.tab || (app.globalData.tab = !app.globalData.tab, wx.reLaunch({
            url: t
        }), setTimeout(function() {
            app.globalData.tab = !app.globalData.tab;
        }, 1e3));
    },
    tips: function(t) {
        wx.showToast({
            title: t,
            icon: "none",
            duration: 1500
        });
    },
    dealList: function(t, a) {
        var e;
        1 == a && this.setData({
            list: {
                load: !1,
                over: !1,
                page: 1,
                length: 10,
                none: !1,
                data: []
            }
        });
        var o = this.data.list.data.concat(t);
        t.length < this.data.list.length && this.setData(_defineProperty({}, "list.over", !0)), 
        0 === o.length && this.setData(_defineProperty({}, "list.none", !0)), this.setData((_defineProperty(e = {}, "list.load", !1), 
        _defineProperty(e, "list.page", ++this.data.list.page), _defineProperty(e, "list.data", o), 
        e));
    },
    getPageHeight: function() {
        this.setData({
            height: wx.getSystemInfoSync().windowHeight + "px"
        });
    },
    GPSMap: function(t, a) {
        t -= 0, a -= 0, wx.openLocation({
            latitude: t,
            longitude: a,
            scale: 28
        });
    },
    onUnload: function() {
        var t = getCurrentPages(), a = t[t.length - 1].route;
        wx.setStorageSync("backUrl", a);
    },
    closeLocal: function() {
        this.setData({
            gps: !this.data.gps
        });
    },
    getGPS: function(t) {
        var a = this;
        t.detail.authSetting["scope.userLocation"] ? (this.setData({
            gps: !0,
            showPage: !0
        }), this.loadGPS().then(function(t) {
            a.data.gps && a.setData({
                lat: t.latitude,
                lng: t.longitude,
                list: {
                    load: !1,
                    over: !1,
                    page: 1,
                    length: 10,
                    none: !1,
                    data: []
                }
            }), a.onloadData({
                detail: {
                    login: 1
                }
            });
        })) : this.setData({
            gps: !1
        }), t.detail.authSetting["scope.userInfo"] || this.setData({
            login: !1
        });
    },
    loadGPS: function() {
        var o = this;
        if (wx.getStorageSync("gps")) {
            var t = new Date().getTime();
            return wx.getStorageSync("gps").time - 0 + 72e5 < t ? (0, _api.gps)().then(function(e) {
                return 0 === e ? (o.setData({
                    gps: !1
                }), new Promise(function(t, a) {
                    t(0);
                })) : (o.setData({
                    gps: !0
                }), e.time = new Date().getTime(), wx.setStorageSync("gps", e), new Promise(function(t, a) {
                    t(e);
                }));
            }) : new Promise(function(t, a) {
                o.setData({
                    gps: !0
                }), t(wx.getStorageSync("gps"));
            });
        }
        return (0, _api.gps)().then(function(e) {
            return 0 === e ? (o.setData({
                gps: !1
            }), new Promise(function(t, a) {
                t(0);
            })) : (o.setData({
                gps: !0
            }), e.time = new Date().getTime(), wx.setStorageSync("gps", e), new Promise(function(t, a) {
                t(e);
            }));
        });
    }
};

module.exports = {
    data: data,
    reload: reload
};