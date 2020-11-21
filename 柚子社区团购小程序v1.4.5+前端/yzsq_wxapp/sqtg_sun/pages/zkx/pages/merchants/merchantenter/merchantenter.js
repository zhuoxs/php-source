var WxParse = require("../../../../../../zhy/template/wxParse/wxParse.js"), foot = require("../../../../../../zhy/component/comFooter/dealfoot.js"), app = getApp();

Page({
    data: {
        hasread: !0,
        mystore: {
            check_state: 0
        },
        protect: !0
    },
    onLoad: function(t) {
        var e = this;
        1 == getCurrentPages().length && e.setData({
            showFoot: !0
        });
        var a = wx.getStorageSync("userInfo");
        a ? e.setData({
            uInfo: a
        }) : wx.showModal({
            title: "提示",
            content: "您未登陆，请先登陆！",
            success: function(t) {
                if (t.confirm) {
                    var e = encodeURIComponent("/sqtg_sun/pages/zkx/pages/merchants/merchantenter/merchantenter");
                    app.reTo("/sqtg_sun/pages/home/login/login?id=" + e);
                } else t.cancel && app.lunchTo("/sqtg_sun/pages/home/index/index");
            }
        });
        var n = wx.getStorageSync("linkaddress");
        n ? (e.setData({
            linkaddress: n
        }), app.api.getCartCount({
            user_id: a.id,
            leader_id: n.id
        }).then(function(t) {
            e.setData({
                cartCount: t
            });
        }), e.getmystore()) : app.reTo("/sqtg_sun/pages/zkx/pages/nearleaders/nearleaders");
    },
    getmystore: function() {
        var r = this;
        app.ajax({
            url: "Cstore|getMyStore",
            data: {
                user_id: r.data.uInfo.id
            },
            success: function(t) {
                if (t.data && 2 == t.data.check_state) app.reTo("../merchantcenter/merchantcenter"); else {
                    var e = t.other.apply_detail;
                    WxParse.wxParse("detail", "html", e, r, 0);
                    var a = {
                        show: !0
                    };
                    if (t.data) {
                        var n = t.data, s = n.latitude + "," + n.longitude;
                        t.data = t.data || {}, a.mystore = n, a.address = n.address, a.coordinates = s;
                    }
                    r.setData(a);
                    var o = foot.dealFootNav(t.other.swipers, t.other.img_root);
                    r.setData({
                        banner: o
                    }), wx.setNavigationBarTitle({
                        title: "商家入驻"
                    });
                }
            }
        });
    },
    formBindsubmit: function(t) {
        var e = this, a = e.data.protect, n = t.detail.value.id, s = e.data.uInfo.id, o = t.detail.value.storename, r = t.detail.value.storetel, i = t.detail.value.distance, d = e.data.address, u = e.data.latitude || t.detail.value.latitude, c = e.data.longitude || t.detail.value.longitude;
        console.log(s, o, r, i, d, u, c), o && r && d && i && u && c ? 1 != this.data.hasread ? 1 == a && (e.setData({
            protect: !1
        }), app.ajax({
            url: "Cstore|applyStore",
            data: {
                id: n,
                name: o,
                tel: r,
                address: d,
                longitude: c,
                latitude: u,
                user_id: s,
                distance: i
            },
            success: function(t) {
                e.setData({
                    protect: !0,
                    mystore: t.data
                });
            },
            fail: function(t) {
                e.setData({
                    protect: !0
                });
            }
        })) : app.tips("请先阅读申请规则") : wx.showToast({
            title: "有参数未填写",
            icon: "none",
            duration: 2e3
        });
    },
    chooseaddress: function(t) {
        var a = this;
        wx.chooseLocation({
            type: "wgs84",
            success: function(t) {
                t.latitude, t.longitude, t.speed, t.accuracy;
                var e = t.latitude + "," + t.longitude;
                a.setData({
                    address: t.address,
                    coordinates: e,
                    latitude: t.latitude,
                    longitude: t.longitude
                });
            },
            fail: function(t) {
                wx.getSetting({
                    success: function(t) {
                        t.authSetting["scope.userLocation"] || (console.log("进入信息授权开关页面"), wx.openSetting({
                            success: function(t) {
                                console.log("openSetting success", t.authSetting);
                            }
                        }));
                    }
                });
            }
        });
    },
    tapreadFirst: function() {
        this.setData({
            hasread: !0,
            hasreadWind: !0
        });
    },
    tapRulebtn: function() {
        this.setData({
            hasread: !1,
            hasreadWind: !1
        });
    },
    _onNavTab1: function(t) {
        var e = getCurrentPages(), a = "/" + e[e.length - 1].route, n = t.currentTarget.dataset.index, s = this.data.banner[n].link, o = this.data.banner[n].typeid;
        s != a && "" != s && app.navTo(s + "?id=" + o);
    },
    _onNavTab2: function(t) {
        var e = getCurrentPages(), a = "/" + e[e.length - 1].route, n = t.currentTarget.dataset.index, s = this.data.nav[n].link, o = this.data.nav[n].typeid;
        s != a && "" != s && app.navTo(s + "?id=" + o);
    },
    _onNavTab3: function(t) {
        var e = getCurrentPages(), a = "/" + e[e.length - 1].route, n = t.currentTarget.dataset.index, s = this.data.centerAd[n].link, o = this.data.centerAd[n].typeid;
        s != a && "" != s && app.navTo(s + "?id=" + o);
    }
});