var _extends = Object.assign || function(t) {
    for (var a = 1; a < arguments.length; a++) {
        var e = arguments[a];
        for (var i in e) Object.prototype.hasOwnProperty.call(e, i) && (t[i] = e[i]);
    }
    return t;
}, _reload = require("../../common/js/reload.js"), _api = require("../../common/js/api.js"), app = getApp();

Page(_extends({}, _reload.reload, {
    data: {
        login: !0,
        gps: !0,
        city: [],
        index: 0,
        cityCode: "",
        leftIndex: 0,
        list: []
    },
    onLoad: function(t) {},
    onloadData: function(t) {
        var e = this;
        t.detail.login && this.checkUrl().then(function(t) {
            return (0, _api.AllcityData)();
        }).then(function(t) {
            return e.setData({
                city: t
            }), e.loadGPS();
        }).then(function(t) {
            if (0 !== t) {
                e.setData({
                    showPage: !0,
                    lat: t.latitude,
                    lng: t.longitude
                });
                var a = {
                    lat: e.data.lat,
                    lng: e.data.lng
                };
                return Promise.all([ (0, _api.GetareaData)({
                    code: e.data.city[0].city
                }), (0, _api.FjshopData)(a) ]);
            }
            return Promise.all([ (0, _api.GetareaData)({
                code: e.data.city[0].city
            }) ]);
        }).then(function(t) {
            t[1] && e.setData({
                list: t[1]
            }), e.setData({
                area: t[0]
            });
        }).catch(function(t) {
            -1 === t.code ? e.tips(t.msg) : e.tips("false");
        });
    },
    getAreaList: function() {
        var a = this, t = {
            code: this.data.areaCode
        };
        (0, _api.AreashopData)(t).then(function(t) {
            a.setData({
                list: t
            });
        }, function(t) {
            console.log("err" + t);
        });
    },
    bindPickerChange: function(t) {
        var a = this;
        this.setData({
            index: t.detail.value,
            cityCode: this.data.city[t.detail.value].city
        });
        var e = {
            code: this.data.cityCode
        };
        (0, _api.GetareaData)(e).then(function(t) {
            a.setData({
                area: t,
                leftIndex: 1,
                areaCode: t[0].area
            }), a.getAreaList();
        }, function(t) {
            console.log("err" + t);
        });
    },
    selectArea: function(t) {
        var e = this, a = t.currentTarget.dataset.index - 0, i = a - 1;
        this.setData({
            leftIndex: a
        }), 0 == a ? (this.setData({
            list: []
        }), this.loadGPS().then(function(t) {
            if (0 !== t) {
                e.setData({
                    showPage: !0,
                    lat: t.latitude,
                    lng: t.longitude
                });
                var a = {
                    lat: e.data.lat,
                    lng: e.data.lng
                };
                (0, _api.FjshopData)(a).then(function(t) {
                    e.setData({
                        list: t
                    });
                });
            }
        }).catch(function(t) {
            -1 === t.code ? e.tips(t.msg) : e.tips("false");
        })) : (this.setData({
            areaCode: this.data.area[i].area
        }), this.getAreaList());
    },
    goStoreDetails: function(t) {
        wx.navigateTo({
            url: "../storeinfo/storeinfo?sid=" + t.currentTarget.dataset.sid
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
        var i = this;
        if (wx.getStorageSync("gps")) {
            var t = new Date().getTime();
            return wx.getStorageSync("gps").time - 0 + 72e5 < t ? (0, _api.gps)().then(function(e) {
                return 0 === e ? (i.setData({
                    gps: !1
                }), new Promise(function(t, a) {
                    t(0);
                })) : (i.setData({
                    gps: !0
                }), e.time = new Date().getTime(), wx.setStorageSync("gps", e), new Promise(function(t, a) {
                    t(e);
                }));
            }) : new Promise(function(t, a) {
                i.setData({
                    gps: !0
                }), t(wx.getStorageSync("gps"));
            });
        }
        return (0, _api.gps)().then(function(e) {
            return 0 === e ? (i.setData({
                gps: !1
            }), new Promise(function(t, a) {
                t(0);
            })) : (i.setData({
                gps: !0
            }), e.time = new Date().getTime(), wx.setStorageSync("gps", e), new Promise(function(t, a) {
                t(e);
            }));
        });
    }
}));