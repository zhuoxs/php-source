function _defineProperty(t, a, e) {
    return a in t ? Object.defineProperty(t, a, {
        value: e,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[a] = e, t;
}

var App = require("/zhy/sdk/qitui/oddpush.js").oddPush(App, "App").App;

App({
    onLaunch: function() {
        var a = wx.getUpdateManager();
        a.onCheckForUpdate(function(t) {
            console.log(t.hasUpdate);
        }), a.onUpdateReady(function() {
            wx.showModal({
                title: "更新提示",
                content: "新版本已经准备好，是否重启应用？",
                success: function(t) {
                    t.confirm && a.applyUpdate();
                }
            });
        }), a.onUpdateFailed(function() {}), wx.request({
            url: this.siteInfo.siteroot + "?i=" + this.siteInfo.uniacid + "&t=undefined&v=1.0.0&from=wxapp&c=entry&a=wxapp&do=Index|getQTData&m=sqtg_sun",
            header: {
                "content-type": "application/json"
            },
            success: function(t) {
                console.log(t.data);
                var a = t.data.data;
                wx.setStorageSync("qitui", a);
            }
        });
    },
    siteInfo: require("siteinfo.js"),
    util: require("/we7/js/util.js"),
    ajax: require("/zhy/resource/js/request.js"),
    Func: require("/zhy/resource/js/func.js"),
    api: require("/zhy/resource/js/api.js"),
    tabSuccess: function() {
        this.globalData.tab = !1;
        var t = this.globalData.jump || {};
        if (t) {
            switch (t.type) {
              case "navTo":
                this.navTo(t.url);
                break;

              case "reTo":
                this.reTo(t.url);
                break;

              case "lunchTo":
                this.lunchTo(t.url);
            }
            this.globalData.jump = null;
        }
    },
    navTo: function(t) {
        var a = 1 < arguments.length && void 0 !== arguments[1] && arguments[1], e = this, o = t.split("?")[0], n = wx.getStorageSync("footNav"), s = !1;
        if (n) for (var i in n) o == n[i].link && (s = !0);
        this.globalData.tab ? a && (e.globalData.jump = {
            type: "navTo",
            url: t
        }) : (this.globalData.tab = !this.globalData.tab, s ? wx.redirectTo({
            url: t,
            complete: e.tabSuccess
        }) : wx.navigateTo({
            url: t,
            complete: e.tabSuccess
        }));
    },
    reTo: function(t) {
        var a = 1 < arguments.length && void 0 !== arguments[1] && arguments[1];
        this.globalData.tab ? a && (this.globalData.jump = {
            type: "reTo",
            url: t
        }) : (this.globalData.tab = !this.globalData.tab, wx.redirectTo({
            url: t,
            complete: this.tabSuccess
        }));
    },
    lunchTo: function(t) {
        var a = 1 < arguments.length && void 0 !== arguments[1] && arguments[1];
        this.globalData.tab ? a && (this.globalData.jump = {
            type: "lunchTo",
            url: t
        }) : (this.globalData.tab = !this.globalData.tab, wx.reLaunch({
            url: t,
            complete: this.tabSuccess
        }));
    },
    tips: function(t) {
        wx.showToast({
            title: t,
            icon: "none",
            duration: 1500
        });
    },
    checkSetting: function() {
        var t = wx.getStorageSync("appConfig");
        t ? wx.setNavigationBarColor({
            frontColor: t.fontcolor,
            backgroundColor: t.top_color
        }) : this.ajax({
            url: "Csystem|getSetting",
            success: function(t) {
                wx.setStorageSync("appConfig", t.data), wx.setNavigationBarColor({
                    frontColor: t.data.fontcolor,
                    backgroundColor: t.data.top_color
                });
            }
        });
    },
    globalData: {
        tab: !1,
        showMaskFlag: !1,
        backUrl: "",
        couponFlag: !0,
        jumpTimes: 1,
        jump: {}
    }
});

var Page_temp = Page;

Page = function(t) {
    var e = getApp();
    t.data.addressFalse = !0, t.data.list = {
        page: 1,
        length: 10,
        over: !1,
        load: !1,
        none: !1,
        data: []
    }, t.data.padding = !1, t.data.show = !1, t.data.newPage = !1;
    var o = t.onLoad;
    return t.onLoad = function(t) {
        t = e.Func.func.decodeScene(t), e.checkSetting(), o.call(this, t);
        var a = getCurrentPages();
        null == a[a.length - 2] && this.setData({
            newPage: !0
        });
    }, t.getPadding = function(t) {
        this.setData({
            padding: t.detail
        });
    }, t.dealList = function(t, a) {
        var e, o = this;
        1 == a && o.setData({
            list: {
                page: 1,
                length: 10,
                over: !1,
                load: !1,
                none: !1,
                data: []
            }
        });
        var n = o.data.list.data.concat(t);
        t.length < o.data.list.length && (o.setData(_defineProperty({}, "list.over", !0)), 
        0 === n.length && o.setData(_defineProperty({}, "list.none", !0))), o.setData((_defineProperty(e = {}, "list.load", !1), 
        _defineProperty(e, "list.page", ++o.data.list.page), _defineProperty(e, "list.data", n), 
        e));
    }, t.getAddress = function(t) {
        var a = this;
        this.data.addressFalse && wx.chooseAddress({
            success: function(t) {
                console.log(t), a.setData({
                    expressInfo: t
                }), wx.setStorageSync("expressInfo", t), a.checkFee();
            },
            fail: function(t) {
                a.setData({
                    addressFalse: !1
                });
            }
        });
    }, t.openWXSetting = function(t) {
        t.detail.authSetting["scope.address"] && (this.setData({
            addressFalse: !0
        }), this.getAddress());
    }, t.onHomeTab = function(t) {
        e.lunchTo("/sqtg_sun/pages/home/index/index");
    }, Page_temp(t);
};