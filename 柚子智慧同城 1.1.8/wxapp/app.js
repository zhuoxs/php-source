App({
    onLaunch: function() {
        var t = wx.getUpdateManager();
        t.onCheckForUpdate(function(t) {}), t.onUpdateReady(function() {
            wx.showModal({
                title: "更新提示",
                content: "新版本已经准备好，是否重启应用？",
                success: function(a) {
                    a.confirm && t.applyUpdate();
                }
            });
        }), t.onUpdateFailed(function() {});
    },
    Base: require("/zhy/resource/js/rewrite.js").basePage,
    siteInfo: require("siteinfo.js"),
    util: require("/we7/js/util.js"),
    api: require("/zhy/resource/js/api.js"),
    tabSuccess: function() {
        this.globalData.tab = !1;
    },
    navTo: function(t) {
        var a = this, e = t.split("?")[0], n = wx.getStorageSync("setting").nav, o = !1;
        if (n) for (var i in n) e == n[i].link && (o = !0);
        this.globalData.tab || (this.globalData.tab = !this.globalData.tab, o ? wx.redirectTo({
            url: t,
            complete: a.tabSuccess
        }) : wx.navigateTo({
            url: t,
            complete: a.tabSuccess
        }));
    },
    reTo: function(t) {
        var a = this;
        this.globalData.tab || (this.globalData.tab = !this.globalData.tab, wx.redirectTo({
            url: t,
            complete: a.tabSuccess
        }));
    },
    lunchTo: function(t) {
        var a = this;
        this.globalData.tab || (this.globalData.tab = !this.globalData.tab, wx.reLaunch({
            url: t,
            complete: a.tabSuccess
        }));
    },
    tips: function(t) {
        wx.showToast({
            title: t,
            icon: "none",
            duration: 1500
        });
    },
    alert: function(t, a, e, n, o, i) {
        wx.showModal({
            title: n || "提示",
            content: t || "暂无提示！",
            showCancel: 0 != e,
            cancelText: o || "取消",
            confirmText: i || "确定",
            success: function(t) {
                t.confirm ? a && a() : t.cancel && e && e();
            }
        });
    },
    phone: function(t) {
        t && wx.makePhoneCall({
            phoneNumber: t
        });
    },
    map: function(t, a) {
        var e = t - 0, n = a - 0;
        wx.openLocation({
            latitude: e,
            longitude: n,
            scale: 28
        });
    },
    location: function() {
        return new Promise(function(t, a) {
            wx.getLocation({
                type: "wgs84",
                success: function(a) {
                    var e = a.latitude, n = a.longitude;
                    t({
                        lat: e,
                        lng: n
                    });
                },
                fail: function(a) {
                    t(!1);
                }
            });
        });
    },
    timePass: function(t) {
        return new Promise(function(a, e) {
            setTimeout(function() {
                a();
            }, t || 1e3);
        });
    },
    globalData: {}
});