var _extends = Object.assign || function(t) {
    for (var e = 1; e < arguments.length; e++) {
        var a = arguments[e];
        for (var n in a) Object.prototype.hasOwnProperty.call(a, n) && (t[n] = a[n]);
    }
    return t;
}, _reload = require("../../resource/js/reload.js"), _api = require("../../resource/js/api.js"), _rewx = require("../../resource/js/rewx.js");

function _defineProperty(t, e, a) {
    return e in t ? Object.defineProperty(t, e, {
        value: a,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[e] = a, t;
}

var app = getApp();

Page(_extends({}, _reload.reload, {
    data: {
        choose: 0,
        login: !0,
        gps: !0,
        showPage: !1
    },
    onLoad: function(t) {},
    onloadData: function() {
        var a = this;
        this.setData({
            list: {
                load: !1,
                over: !1,
                page: 1,
                length: 10,
                data: []
            }
        }), this.loadGPS().then(function(t) {
            return 0 !== t ? a.setData({
                showPage: !0,
                lat: t.latitude,
                lng: t.longitude
            }) : a.setData({
                lat: 0,
                lng: 0
            }), a.checkUrl();
        }).then(function(t) {
            return (0, _api.WeData)({
                sid: 0
            });
        }).then(function(t) {
            var e = {
                id: 0,
                pic: t.pic,
                name: t.name + "(总校)",
                tel: t.tel,
                dist: (0, _rewx.GetDistance)(a.data.lat, a.data.lng, t.lat, t.lng),
                address: t.address
            };
            a.data.list.data.unshift(e);
        }).then(function(t) {
            return a.getListData();
        }).catch(function(t) {
            -1 === t.code ? a.tips(t.msg) : a.tips("false");
        });
    },
    getListData: function() {
        var e = this;
        if (!this.data.list.over) {
            this.setData(_defineProperty({}, "list.load", !0));
            var t = {
                page: this.data.list.page,
                length: this.data.list.length,
                select_type: 1,
                lat: this.data.lat,
                lng: this.data.lng
            };
            return (0, _api.SchoolListData)(t).then(function(t) {
                e.dealList(t);
            });
        }
    },
    onReachBottom: function() {
        this.getListData();
    },
    onSchoolTab: function(t) {
        var e = t.currentTarget.dataset.idx, a = this.data.list.data[e].id;
        this.lunchTo("../home/home?schoolflag=1&sid=" + a);
    },
    closeLocal: function() {
        this.setData({
            gps: !this.data.gps
        }), wx.navigateBack({
            delta: 1
        });
    },
    getGPS: function(t) {
        var e = this;
        t.detail.authSetting["scope.userLocation"] ? (this.setData({
            gps: !0,
            showPage: !0
        }), this.loadGPS().then(function(t) {
            return e.data.gps && e.setData({
                lat: t.latitude,
                lng: t.longitude
            }), e.getListData();
        })) : this.setData({
            gps: !1
        }), t.detail.authSetting["scope.userInfo"] || this.setData({
            login: !1
        });
    },
    loadGPS: function() {
        var n = this;
        if (wx.getStorageSync("gps")) {
            var t = new Date().getTime();
            return wx.getStorageSync("gps").time - 0 + 72e5 < t ? (0, _api.gps)().then(function(a) {
                return 0 === a ? (n.setData({
                    gps: !1
                }), new Promise(function(t, e) {
                    t(0);
                })) : (n.setData({
                    gps: !0
                }), a.time = new Date().getTime(), wx.setStorageSync("gps", a), new Promise(function(t, e) {
                    t(a);
                }));
            }) : new Promise(function(t, e) {
                n.setData({
                    gps: !0
                }), t(wx.getStorageSync("gps"));
            });
        }
        return (0, _api.gps)().then(function(a) {
            return 0 === a ? (n.setData({
                gps: !1
            }), new Promise(function(t, e) {
                t(0);
            })) : (n.setData({
                gps: !0
            }), a.time = new Date().getTime(), wx.setStorageSync("gps", a), new Promise(function(t, e) {
                t(a);
            }));
        });
    },
    onShareAppMessage: function(t) {
        return {
            title: "分校列表",
            path: "/yzpx_sun/pages/schoolslist/schoolslist"
        };
    }
}));