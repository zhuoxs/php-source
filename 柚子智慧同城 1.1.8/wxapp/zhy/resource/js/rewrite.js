function t(t, e, n) {
    return e in t ? Object.defineProperty(t, e, {
        value: n,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[e] = n, t;
}

var e = Page;

module.exports = {
    basePage: function(n) {
        var a = getApp();
        n.data.show = !1, n.data.ajax = !1, n.data.reload = !1, n.data.padding = 0, n.data.padding = !1, 
        n.data.show = !1, n.data.newPage = !1, n.data.list = {
            load: !1,
            over: !1,
            page: 1,
            length: 10,
            none: !1,
            data: []
        };
        var o = n.onLoad;
        return n.onLoad = function(t) {
            wx.checkSession({
                success: function() {},
                fail: function() {
                    var t = wx.getStorageSync("session_key");
                    console.log(t), t && n.checkSessionKey();
                }
            }), getApp();
            var e = getCurrentPages();
            if (void 0 == e[e.length - 2] && this.setData({
                newPage: !0
            }), t.scene) {
                for (var a = {}, i = decodeURIComponent(t.scene).split("&"), s = 0; s < i.length; s++) {
                    var c = i[s].split("=");
                    a[c[0]] = c[1];
                }
                t = a;
            }
            t.s_id && t.s_id > 0 && wx.setStorageSync("s_id", t.s_id);
            var r = wx.getStorageSync("setting");
            r && wx.setNavigationBarColor({
                frontColor: r.config.fontcolor ? r.config.fontcolor : "#000000",
                backgroundColor: r.config.top_color ? r.config.top_color : "#ffffff"
            }), o.call(this, t);
        }, n.checkSessionKey = function() {
            wx.login({
                success: function(t) {
                    t.code && a.api.apiWxGetopenid({
                        code: t.code
                    }).then(function(t) {
                        wx.setStorageSync("session_key", t.data.session_key);
                    }).catch(function(t) {});
                }
            });
        }, n.checkLogin = function(t, e, o) {
            var i = wx.getStorageSync("yztcInfo");
            i && i.id > 0 ? o ? a.api.apiUserMyInfo({
                user_id: i.id
            }).then(function(e) {
                wx.setStorageSync("yztcInfo", e.data.userinfo), t && t(e.data.userinfo);
            }).catch(function(o) {
                return a.tips(o.msg), n.checkLogin(t, e);
            }) : t && t(i) : wx.showModal({
                title: "提示",
                content: "您未登陆，请先登陆！",
                success: function(t) {
                    if (t.confirm) {
                        e || (e = "/pages/home/home");
                        var n = encodeURIComponent(e);
                        a.reTo("/pages/login/login?id=" + n);
                    } else t.cancel && a.lunchTo("/pages/home/home");
                }
            });
        }, n.getPadding = function(t) {
            this.setData({
                padding: t.detail
            });
        }, n.reloadPrevious = function() {
            var t = getCurrentPages();
            t[t.length - 2].setData({
                reload: !0
            });
        }, n.dealList = function(e, n) {
            var a;
            1 == n && this.setData({
                list: {
                    load: !1,
                    over: !1,
                    page: 1,
                    length: 10,
                    none: !1,
                    data: []
                }
            });
            var o = this.data.list.data.concat(e);
            e.length < this.data.list.length && this.setData(t({}, "list.over", !0)), 0 === o.length && this.setData(t({}, "list.none", !0)), 
            this.setData((a = {}, t(a, "list.load", !1), t(a, "list.page", ++this.data.list.page), 
            t(a, "list.data", o), t(a, "ajax", !1), a));
        }, n.onHomeTab = function(t) {
            a.lunchTo("/pages/home/home");
        }, n.getLatLng = function(e) {
            var n = this, o = this;
            a.location().then(function(i) {
                if (i) {
                    var s;
                    n.setData((s = {}, t(s, "lng", i.lng - 0), t(s, "lat", i.lat - 0), s));
                    var c = {
                        lng: i.lng - 0,
                        lat: i.lat - 0
                    };
                    return e(c);
                }
                a.alert("定位需要获取位置信息，请去开启位置授权！", function() {
                    wx.openSetting({
                        success: function(t) {
                            t.authSetting["scope.userLocation"], o.getLatLng(e);
                        }
                    });
                }, function() {
                    return e(!1);
                });
            });
        }, n.checkDistribution = function(t) {
            var e = t.s_id, n = wx.getStorageSync("lhyInfo");
            if (e && n && n.id) {
                var o = {
                    user_id: n.id,
                    parents_id: e
                };
                a.api.apiDistributionSetDistributionParents(o).then(function(t) {}).catch(function(t) {});
            }
        }, e(n);
    }
};