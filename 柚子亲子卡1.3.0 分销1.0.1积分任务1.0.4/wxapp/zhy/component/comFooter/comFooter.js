function _defineProperty(t, e, a) {
    return e in t ? Object.defineProperty(t, e, {
        value: a,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[e] = a, t;
}

var app = getApp(), foot = require("./dealfoot.js");

Component({
    properties: {
        chooseNav: {
            type: Number,
            value: 1,
            observer: function(t, e) {}
        },
        sid: {
            type: Number,
            value: 0,
            observer: function(t, e) {}
        }
    },
    data: {
        show: !1
    },
    attached: function() {
        this._getData();
    },
    detached: function() {},
    ready: function() {},
    methods: {
        _getData: function() {
            var a = this, e = wx.getStorageSync("appConfig");
            e || app.ajax({
                url: "Csystem|getSetting",
                success: function(t) {
                    e = t.data, wx.setStorageSync("appConfig", t.data);
                }
            }), this.setData({
                bg: e.bottom_color ? e.bottom_color : "#fff",
                color: e.bottom_fontcolor_a ? e.bottom_fontcolor_a : "#333",
                colorh: e.bottom_fontcolor_b ? e.bottom_fontcolor_b : "#f87d6d"
            });
            var t = wx.getStorageSync("footNav");
            t ? (this.setData({
                nav: t
            }), this.checkChoose()) : app.ajax({
                url: "Csystem|getNavicon",
                success: function(t) {
                    var e = foot.dealFootNav(t.data, t.other.img_root);
                    a.setData({
                        nav: e
                    }), wx.setStorageSync("footNav", e), a.checkChoose();
                }
            });
        },
        checkChoose: function() {
            var t = getCurrentPages(), e = "/" + t[t.length - 1].route;
            for (var a in this.data.nav) {
                var o;
                if (this.data.nav[a].link == e) this.setData((_defineProperty(o = {}, "nav[" + a + "].choose", !0), 
                _defineProperty(o, "show", !0), o)), this.triggerEvent("padding", !0);
            }
        },
        _onNavTab: function(t) {
            var e = getCurrentPages(), a = "/" + e[e.length - 1].route, o = t.currentTarget.dataset.index, n = this.data.nav[o].link, r = this.data.nav[o].typeid;
            n != a && "" != n && wx.reLaunch({
                url: n + "?id=" + r
            });
        },
        onOtherAppTab: function(t) {
            var e = t.currentTarget.dataset.id, a = t.currentTarget.dataset.path;
            wx.navigateToMiniProgram({
                appId: e,
                path: a
            });
        },
        _jumpSuccess: function(t) {}
    }
});