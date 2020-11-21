var _api = require("./api.js"), _rewx = require("./rewx.js");

function _defineProperty(t, a, e) {
    return a in t ? Object.defineProperty(t, a, {
        value: e,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[a] = e, t;
}

var app = getApp(), reload = {
    hasNav: function(t) {
        1 == t.detail && this.setData({
            padding: !0
        });
    },
    checkSchool: function() {
        var a = this;
        return (0, _api.SupportData)().then(function(t) {
            return a.setData({
                openSchool: t.open_school - 0
            }), a.loadGPS();
        }).then(function(t) {
            return 0 !== t ? a.setData({
                lat: t.latitude,
                lng: t.longitude
            }) : a.setData({
                lat: 0,
                lng: 0
            }), 1 != a.data.openSchool ? (0, _api.DefaultSchoolData)() : (0, _api.NearbyData)({
                lat: a.data.lat,
                lng: a.data.lng
            });
        }).then(function(t) {
            return 1 != a.data.openSchool ? 0 == t ? a.setData({
                sid: 0
            }) : a.setData({
                sid: t.id
            }) : (0 == t.length && a.setData({
                sid: 0
            }), -1 == a.data.sid && 0 != a.data.lat && a.setData({
                sid: t[0].id,
                otherDis: t[0].distance
            })), (0, _api.WeData)({
                sid: 0
            });
        }).then(function(t) {
            1 == a.data.openSchool && (0 < a.data.sid && (0, _rewx.GetDistance)(a.data.lat, a.data.lng, t.lat, t.lng) - 0 < a.data.otherDis - 0 && a.setData({
                sid: 0
            }));
            return -1 == a.data.sid && a.setData({
                sid: 0
            }), (0, _api.WeData)({
                sid: a.data.sid
            });
        }).then(function(t) {
            t.sid = a.data.sid, wx.setStorageSync("shopinfo", t);
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
                lng: t.longitude
            });
        })) : this.setData({
            gps: !1
        }), t.detail.authSetting["scope.userInfo"] ? this.onloadData({
            detail: {
                login: 1
            }
        }) : this.setData({
            login: !1
        });
    },
    onUnload: function() {
        var t = getCurrentPages(), a = t[t.length - 1].route;
        app.globalData.backUrl = a;
    },
    getUrl: function() {
        var a = this;
        return Promise.all([ (0, _api.UrlData)(), (0, _api.ColorData)() ]).then(function(t) {
            return wx.setStorageSync("color", t[1]), wx.setStorageSync("imgLink", t[0]), wx.setNavigationBarColor({
                frontColor: t[1].top_font_color,
                backgroundColor: t[1].top_color
            }), a.setData({
                imgLink: t[0]
            }), wx.setStorageSync("imgLink", t[0]), a.setData({
                imgLink: t[0]
            }), Promise.resolve(t[0]);
        });
    },
    checkUrl: function() {
        var t = wx.getStorageSync("color"), a = wx.getStorageSync("imgLink");
        return a ? (wx.setNavigationBarColor({
            frontColor: t.top_font_color,
            backgroundColor: t.top_color
        }), this.setData({
            imgLink: a
        }), Promise.resolve(a)) : this.getUrl();
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
                data: []
            }
        });
        var o = this.data.list.data.concat(t);
        t.length < this.data.list.length && this.setData(_defineProperty({}, "list.over", !0)), 
        this.setData((_defineProperty(e = {}, "list.load", !1), _defineProperty(e, "list.page", ++this.data.list.page), 
        _defineProperty(e, "list.data", o), e));
    }
};

module.exports = {
    reload: reload
};