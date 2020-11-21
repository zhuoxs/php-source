function t(t, o, a) {
    return o in t ? Object.defineProperty(t, o, {
        value: a,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[o] = a, t;
}

var o = Object.assign || function(t) {
    for (var o = 1; o < arguments.length; o++) {
        var a = arguments[o];
        for (var e in a) Object.prototype.hasOwnProperty.call(a, e) && (t[e] = a[e]);
    }
    return t;
}, a = getApp(), e = require("./dealfoot.js");

Component({
    properties: {
        reload: {
            type: Boolean,
            value: !1
        },
        sid: {
            type: Number,
            value: 0,
            observer: function(t, o) {}
        }
    },
    data: {
        show: !1,
        isX: !1
    },
    attached: function() {
        this._getData();
    },
    detached: function() {},
    ready: function() {},
    methods: {
        _getData: function() {
            var t = this, n = this;
            wx.getSystemInfo({
                success: function(t) {
                    -1 == t.model.search("iPhone X") && -1 == t.model.search("iPhone11") || n.setData({
                        isX: !0
                    });
                }
            }), this.data.reload && this.data.isMine && wx.removeStorageSync("setting");
            var r = wx.getStorageSync("setting");
            r ? (this.setData({
                nav: r.nav,
                bg: r.config.bottom_color ? r.config.bottom_color : "#fff",
                color: r.config.bottom_fontcolor_a ? r.config.bottom_fontcolor_a : "#999",
                colorh: r.config.bottom_fontcolor_b ? r.config.bottom_fontcolor_b : "#FEAF64"
            }), this.triggerEvent("setting", r), this.checkChoose()) : Promise.all([ a.api.apiIndexSystemSet(), a.api.apiIndexNavIcon() ]).then(function(a) {
                var n = e.dealFootNav(a[1].data, a[1].other.img_root), r = {
                    config: a[0].data,
                    nav: n
                };
                wx.setStorageSync("setting", r), t.triggerEvent("setting", r), wx.setNavigationBarColor({
                    frontColor: r.config.fontcolor ? r.config.fontcolor : "#000000",
                    backgroundColor: r.config.top_color ? r.config.top_color : "#ffffff"
                });
                var i = o({}, r, {
                    bg: a[0].data.bottom_color ? a[0].data.bottom_color : "#fff",
                    color: a[0].data.bottom_fontcolor_a ? a[0].data.bottom_fontcolor_a : "#999",
                    colorh: a[0].data.bottom_fontcolor_b ? a[0].data.bottom_fontcolor_b : "#FEAF64"
                });
                t.setData(i), t.checkChoose();
            }).catch(function(t) {
                a.tips(t.msg);
            });
        },
        checkChoose: function() {
            var o = getCurrentPages(), a = "/" + o[o.length - 1].route;
            for (var e in this.data.nav) if (this.data.nav[e].link == a) {
                var n;
                this.setData((n = {}, t(n, "nav[" + e + "].choose", !0), t(n, "show", !0), n)), 
                this.data.isX ? this.triggerEvent("padding", 160) : this.triggerEvent("padding", 120);
            }
        },
        _onNavTab: function(t) {
            var o = getCurrentPages(), a = "/" + o[o.length - 1].route, e = t.currentTarget.dataset.index, n = this.data.nav[e].link, r = this.data.nav[e].typeid;
            n != a && "" != n && wx.reLaunch({
                url: n + "?id=" + r
            });
        },
        _jumpSuccess: function(t) {}
    }
});