var _extends = Object.assign || function(t) {
    for (var a = 1; a < arguments.length; a++) {
        var e = arguments[a];
        for (var s in e) Object.prototype.hasOwnProperty.call(e, s) && (t[s] = e[s]);
    }
    return t;
}, _api = require("../../../resource/js/api.js"), _reload = require("../../../resource/js/reload.js");

function _defineProperty(t, a, e) {
    return a in t ? Object.defineProperty(t, a, {
        value: e,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[a] = e, t;
}

var app = getApp();

Component({
    properties: {
        chooseNav: {
            type: Number,
            value: 1,
            observer: function(t, a) {}
        },
        sid: {
            type: Number,
            value: 0,
            observer: function(t, a) {}
        }
    },
    data: {
        show: !1
    },
    attached: function() {
        var a = this;
        this.checkUrl().then(function(t) {
            a._getData(), a._getColor();
        });
    },
    ready: function() {},
    methods: _extends({}, _reload.reload, {
        _getData: function() {
            var t = wx.getStorageSync("confMsg");
            t ? (this.setData({
                foot: t
            }), 0 == this.data.chooseNav ? this._getSetting() : this.checkChoose()) : this._getSetting();
        },
        _getSetting: function() {
            var n = this;
            (0, _api.FootnavData)().then(function(t) {
                var a = [];
                if (0 != t && 0 < t.length) {
                    a = t;
                    var e = !0, s = !1, o = void 0;
                    try {
                        for (var i, r = a[Symbol.iterator](); !(e = (i = r.next()).done); e = !0) {
                            i.value.choose = !1;
                        }
                    } catch (t) {
                        s = !0, o = t;
                    } finally {
                        try {
                            !e && r.return && r.return();
                        } finally {
                            if (s) throw o;
                        }
                    }
                }
                wx.setStorageSync("confMsg", a), n.setData({
                    foot: a
                }), n.checkChoose();
            });
        },
        _getColor: function() {
            var a = this, t = wx.getStorageSync("color");
            t ? this.setData({
                color: t
            }) : (0, _api.ColorData)().then(function(t) {
                wx.setStorageSync("color", t), a.setData({
                    color: t
                });
            });
        },
        checkChoose: function() {
            var t = getCurrentPages(), a = t[t.length - 1].route;
            for (var e in this.data.foot) {
                switch (this.data.foot[e].type) {
                  case "1":
                    this.data.foot[e].url = "yzpx_sun/pages/home/home", this.data.foot[e].link = "../home/home";
                    break;

                  case "2":
                    this.data.foot[e].url = "yzpx_sun/pages/classlist/classlist", this.data.foot[e].link = "../classlist/classlist";
                    break;

                  case "3":
                    this.data.foot[e].url = "yzpx_sun/pages/activitylist/activitylist", this.data.foot[e].link = "../activitylist/activitylist";
                    break;

                  case "4":
                    this.data.foot[e].url = "yzpx_sun/pages/bargainlist/bargainlist", this.data.foot[e].link = "../bargainlist/bargainlist";
                    break;

                  case "5":
                    this.data.foot[e].url = "yzpx_sun/pages/signup/signup", this.data.foot[e].link = "../signup/signup";
                    break;

                  case "6":
                    this.data.foot[e].url = "yzpx_sun/pages/play/play", this.data.foot[e].link = "../play/play";
                    break;

                  case "7":
                    this.data.foot[e].url = "yzpx_sun/pages/about/about", this.data.foot[e].link = "../about/about";
                    break;

                  case "8":
                    this.data.foot[e].url = "yzpx_sun/pages/newstable/newstable", this.data.foot[e].link = "../newstable/newstable";
                    break;

                  case "9":
                    this.data.foot[e].url = "yzpx_sun/pages/teacherlist/teacherlist", this.data.foot[e].link = "../teacherlist/teacherlist";
                    break;

                  case "10":
                    this.data.foot[e].url = "yzpx_sun/pages/table/table", this.data.foot[e].link = "../table/table";
                    break;

                  case "11":
                    this.data.foot[e].url = "yzpx_sun/pages/mine/mine", this.data.foot[e].link = "../mine/mine";
                    break;

                  case "12":
                    this.data.foot[e].url = "yzpx_sun/pages/schoolslist/schoolslist", this.data.foot[e].link = "../schoolslist/schoolslist";
                    break;

                  case "13":
                    this.data.foot[e].url = "yzpx_sun/pages/ticketlist/ticketlist", this.data.foot[e].link = "../ticketlist/ticketlist";
                }
                var s;
                if (this.data.foot[e].url == a) this.setData((_defineProperty(s = {}, "foot[" + e + "].choose", !0), 
                _defineProperty(s, "show", !0), s)), this.triggerEvent("watch", !0);
            }
        },
        _onNavTab: function(t) {
            var a = getCurrentPages(), e = a[a.length - 1].route, s = t.currentTarget.dataset.index, o = this.data.foot[s].link;
            this.data.foot[s].url != e && wx.reLaunch({
                url: o
            });
        }
    })
});