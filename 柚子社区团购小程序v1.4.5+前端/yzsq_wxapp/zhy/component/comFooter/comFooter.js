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
        },
        cartCount: {
            type: Number,
            value: 0,
            observer: function(t, e) {}
        },
        currURL: {
            type: String,
            value: "",
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
                colorh: e.bottom_fontcolor_b ? e.bottom_fontcolor_b : "#f87d6d",
                iconbg: e.bottom_cart_color_b ? e.bottom_cart_color_b : "#e9472c",
                iconcolor: e.bottom_cart_color_a ? e.bottom_cart_color_a : "#fff"
            });
            var t = wx.getStorageSync("footNav"), o = wx.getStorageSync("cartNum");
            t ? (this.setData({
                nav: t,
                cartNum: o
            }), this.checkChoose()) : app.ajax({
                url: "Csystem|getNavicon",
                success: function(t) {
                    var e = foot.dealFootNav(t.data, t.other.img_root, 1);
                    a.setData({
                        nav: e,
                        cartNum: o
                    }), wx.setStorageSync("footNav", e), a.checkChoose();
                }
            }), wx.getSystemInfo({
                success: function(t) {
                    "iPhone X" == t.model && (console.log(t.model), a.setData({
                        isIphoneX: !0
                    }));
                }
            });
        },
        checkChoose: function() {
            var i = this, t = wx.getStorageSync("userInfo");
            if (t) app.ajax({
                url: "Cuser|myInfo",
                data: {
                    user_id: t.id
                },
                success: function(t) {
                    var e = t.data, a = getCurrentPages(), o = "/" + a[a.length - 1].route;
                    for (var r in i.data.nav) {
                        var n;
                        if ("/sqtg_sun/pages/zkx/pages/headapplication/headapplication" == i.data.nav[r].link && e.is_leader && i.setData(_defineProperty({}, "nav[" + r + "].link", "/sqtg_sun/pages/zkx/pages/headcenter/headcenter")), 
                        "/sqtg_sun/pages/zkx/pages/merchants/merchantenter/merchantenter" == i.data.nav[r].link && e.has_store && i.setData(_defineProperty({}, "nav[" + r + "].link", "/sqtg_sun/pages/zkx/pages/merchants/merchantcenter/merchantcenter")), 
                        i.data.nav[r].link == i.data.currURL || i.data.nav[r].link == o) i.setData((_defineProperty(n = {}, "nav[" + r + "].choose", !0), 
                        _defineProperty(n, "show", !0), n)), i.triggerEvent("padding", !0);
                    }
                }
            }); else {
                var e = getCurrentPages(), a = "/" + e[e.length - 1].route;
                for (var o in i.data.nav) {
                    var r;
                    if (i.data.nav[o].link == i.data.currURL || i.data.nav[o].link == a) i.setData((_defineProperty(r = {}, "nav[" + o + "].choose", !0), 
                    _defineProperty(r, "show", !0), r)), i.triggerEvent("padding", !0);
                }
            }
        },
        _onNavTab: function(t) {
            var e = getCurrentPages(), a = e[e.length - 1], o = "/" + a.route, r = t.currentTarget.dataset.index, n = this.data.nav[r].link, i = this.data.nav[r].typeid;
            n != o && "" != n && (a.setData({
                show: !1
            }), wx.setNavigationBarTitle({
                title: "玩命加载中..."
            }), setTimeout(function() {
                wx.reLaunch({
                    url: n + "?id=" + i
                });
            }, 100));
        },
        onOtherAppTab: function(t) {
            var e = t.currentTarget.dataset.id, a = t.currentTarget.dataset.path;
            wx.navigateToMiniProgram({
                appId: e,
                path: a
            });
        },
        _jumpSuccess: function(t) {},
        formSubmit_getformid: function(t) {
            var e = wx.getStorageSync("userInfo");
            app.ajax({
                url: "Index|addFormid",
                data: {
                    user_id: e.id,
                    form_id: t.detail.formId
                }
            });
        }
    }
});