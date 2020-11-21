var WxParse = require("../../../../../zhy/template/wxParse/wxParse.js"), foot = require("../../../../../zhy/component/comFooter/dealfoot.js"), app = getApp();

Page({
    data: {
        hasread: !0,
        myleader: {
            check_state: 0
        },
        protect: !0
    },
    onLoad: function(e) {
        var t = this;
        1 == getCurrentPages().length && t.setData({
            showFoot: !0
        });
        var a = wx.getStorageSync("userInfo");
        a && 0 < a.id ? t.setData({
            uInfo: a
        }) : wx.showModal({
            title: "提示",
            content: "您未登陆，请先登陆！",
            success: function(e) {
                if (e.confirm) {
                    var t = encodeURIComponent("/sqtg_sun/pages/zkx/pages/headapplication/headapplication?id=0");
                    app.navTo("/sqtg_sun/pages/home/login/login?id=" + t);
                } else e.cancel && app.lunchTo("/sqtg_sun/pages/home/index/index");
            }
        });
        var n = wx.getStorageSync("linkaddress");
        n && app.api.getCartCount({
            user_id: a.id,
            leader_id: n.id
        }).then(function(e) {
            t.setData({
                cartCount: e
            });
        }), t.getmyleader();
    },
    getmyleader: function() {
        var i = this;
        app.ajax({
            url: "Cleader|getMyLeader",
            data: {
                user_id: i.data.uInfo.id
            },
            success: function(e) {
                if (console.log(e), e.data && 2 == e.data.check_state) app.reTo("../headcenter/headcenter"); else {
                    var t = e.other.apply_detail;
                    WxParse.wxParse("detail", "html", t, i, 0);
                    var a = e.data || {}, n = a.latitude ? a.latitude + "," + a.longitude : "";
                    a.leadercommunity = a.community, e.data = e.data || {}, console.log(e.other.swipers), 
                    i.setData({
                        show: !0,
                        myleader: a,
                        address: a.address || "请填写详细地址",
                        coordinates: n,
                        imgRoot: e.other.img_root
                    });
                    var d = foot.dealFootNav(e.other.swipers, e.other.img_root);
                    i.setData({
                        banner: d
                    }), wx.setNavigationBarTitle({
                        title: "团长申请"
                    });
                }
            }
        });
    },
    formBindsubmit: function(e) {
        var t = this, a = t.data.protect, n = t.data.uInfo.id, d = e.detail.value.id, i = e.detail.value.leadername, o = e.detail.value.leadertel, s = e.detail.value.leadercommunity, r = e.detail.value.leaderaddress, l = t.data.latitude || e.detail.value.latitude, u = t.data.longitude || e.detail.value.longitude;
        i && o && s && r && l && u ? 1 != this.data.hasread ? 1 == a && (t.setData({
            protect: !1
        }), app.ajax({
            url: "Cleader|applyLeader",
            data: {
                id: d,
                name: i,
                tel: o,
                community: s,
                address: r,
                longitude: u,
                latitude: l,
                user_id: n
            },
            success: function(e) {
                t.setData({
                    protect: !0,
                    myleader: e.data.data
                }), t.getmyleader();
            },
            fail: function(e) {
                t.setData({
                    protect: !0
                });
            }
        })) : app.tips("请先阅读申请规则") : wx.showToast({
            title: "有参数未填写",
            icon: "none",
            duration: 2e3
        });
    },
    chooseaddress: function(e) {
        var a = this;
        wx.chooseLocation({
            type: "wgs84",
            success: function(e) {
                e.latitude, e.longitude, e.speed, e.accuracy;
                var t = e.latitude + "," + e.longitude;
                a.setData({
                    address: e.address,
                    coordinates: t,
                    latitude: e.latitude,
                    longitude: e.longitude
                });
            },
            fail: function(e) {
                wx.getSetting({
                    success: function(e) {
                        e.authSetting["scope.userLocation"] || (console.log("进入信息授权开关页面"), wx.openSetting({
                            success: function(e) {
                                console.log("openSetting success", e.authSetting);
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
    _onNavTab1: function(e) {
        var t = getCurrentPages(), a = "/" + t[t.length - 1].route, n = e.currentTarget.dataset.index, d = this.data.banner[n].link, i = this.data.banner[n].typeid;
        d != a && "" != d && app.navTo(d + "?id=" + i);
    },
    _onNavTab2: function(e) {
        var t = getCurrentPages(), a = "/" + t[t.length - 1].route, n = e.currentTarget.dataset.index, d = this.data.nav[n].link, i = this.data.nav[n].typeid;
        d != a && "" != d && app.navTo(d + "?id=" + i);
    },
    _onNavTab3: function(e) {
        var t = getCurrentPages(), a = "/" + t[t.length - 1].route, n = e.currentTarget.dataset.index, d = this.data.centerAd[n].link, i = this.data.centerAd[n].typeid;
        d != a && "" != d && app.navTo(d + "?id=" + i);
    }
});