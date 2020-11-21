var _api = require("./api.js");

function _defineProperty(a, t, o) {
    return t in a ? Object.defineProperty(a, t, {
        value: o,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : a[t] = o, a;
}

var app = getApp(), reload = {
    onUnload: function() {
        var a = getCurrentPages(), t = a[a.length - 1].route;
        app.globalData.backUrl = t;
    },
    getUrl: function() {
        var t = this;
        return Promise.all([ (0, _api.UrlData)(), (0, _api.ColorData)() ]).then(function(a) {
            return wx.setStorageSync("color", a[1]), wx.setStorageSync("url", a[0]), wx.setNavigationBarColor({
                frontColor: a[1].top_font_color,
                backgroundColor: a[1].top_color
            }), t.setData({
                imgLink: a[0]
            }), wx.setStorageSync("imgLink", a[0]), t.setData({
                imgLink: a[0]
            }), Promise.resolve(a[0]);
        });
    },
    checkUrl: function() {
        var a = wx.getStorageSync("color"), t = wx.getStorageSync("url");
        return t ? (wx.setNavigationBarColor({
            frontColor: a.top_font_color,
            backgroundColor: a.top_color
        }), this.setData({
            imgLink: t
        }), Promise.resolve(t)) : this.getUrl();
    },
    navTo: function(a) {
        app.globalData.tab || (app.globalData.tab = !app.globalData.tab, wx.navigateTo({
            url: a
        }), setTimeout(function() {
            app.globalData.tab = !app.globalData.tab;
        }, 1e3));
    },
    reTo: function(a) {
        app.globalData.tab || (app.globalData.tab = !app.globalData.tab, wx.redirectTo({
            url: a
        }), setTimeout(function() {
            app.globalData.tab = !app.globalData.tab;
        }, 1e3));
    },
    lunchTo: function(a) {
        app.globalData.tab || (app.globalData.tab = !app.globalData.tab, wx.reLaunch({
            url: a
        }), setTimeout(function() {
            app.globalData.tab = !app.globalData.tab;
        }, 1e3));
    },
    tips: function(a) {
        wx.showToast({
            title: a,
            icon: "none",
            duration: 1500
        });
    },
    dealList: function(a, t) {
        var o;
        1 == t && this.setData({
            list: {
                load: !1,
                over: !1,
                page: 1,
                length: 10,
                none: !1,
                data: []
            }
        });
        var e = this.data.list.data.concat(a);
        a.length < this.data.list.length && this.setData(_defineProperty({}, "list.over", !0)), 
        0 === e.length && this.setData(_defineProperty({}, "list.none", !0)), this.setData((_defineProperty(o = {}, "list.load", !1), 
        _defineProperty(o, "list.page", ++this.data.list.page), _defineProperty(o, "list.data", e), 
        o));
    }
};

module.exports = {
    reload: reload
};