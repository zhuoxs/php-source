var a = new getApp(), t = a.siteInfo.uniacid;

Page({
    data: {
        SystemInfo: a.globalData.sysData,
        isIphoneX: a.globalData.isIphoneX,
        statusBarHeight: a.globalData.statusBarHeight,
        titleBarHeight: a.globalData.titleBarHeight,
        setData: wx.getStorageSync("kundian_farm_setData"),
        weather: [],
        loading: !0,
        mockView: 4,
        user_uid: 0,
        page: [],
        tarbar: wx.getStorageSync("kundianFarmTarbar"),
        scrollTop: 0,
        is_loading: !1,
        isBarHidden: !1,
        barDistance: 0,
        showView: !1
    },
    onLoad: function(e) {
        var r = this, n = wx.getStorageSync("kundian_farm_setData"), i = wx.getStorageSync("kundianFarmTarbar");
        i && n ? a.util.setNavColor(t) : r.getMusic().then(function(e) {
            var i = e.data, s = i.tarbar, o = i.farmSetData;
            wx.setStorageSync("kundianFarmTarbar", s), wx.setStorageSync("kundian_farm_setData", o), 
            a.globalData.tarbar = s, r.setData({
                tarbar: s,
                setData: n
            }), a.util.setNavColor(t);
        }).then(function() {});
        var s = parseInt(new Date().valueOf()), o = wx.getStorageSync("kundianFarmHomePage"), u = !1;
        !o || wx.getStorageSync("kundianFarmHomePage_time" + t) < s ? r.getFirstData() : "search" == o.page[0].type && (u = !0), 
        u || (r.data.barDistance = 128, r.data.isIphoneX && (r.data.barDistance = 176));
        var d = e.user_uid || 0, c = wx.getStorageSync("kundian_farm_uid");
        void 0 != d && 0 != d && (wx.setStorageSync("farm_share_uid", d), a.loginBindParent(d, c)), 
        wx.getStorageSync("enter_is_play") && wx.removeStorageSync("enter_is_play"), r.setData({
            tarbar: i || [],
            setData: n || [],
            user_uid: d,
            page: o.page || [],
            loading: !1,
            icon: o.icon || [],
            barDistance: r.data.barDistance
        }), r.getWeatherData();
    },
    onPageScroll: function(a) {
        var t = a.scrollTop;
        this.setData({
            scrollTop: t
        });
    },
    getMusic: function() {
        return new Promise(function(e, r) {
            a.util.request({
                url: "entry/wxapp/class",
                data: {
                    op: "getCommonData",
                    control: "index",
                    uniacid: t
                },
                success: function(a) {
                    e(a);
                }
            });
        });
    },
    getWeatherData: function() {
        var e = this;
        a.util.request({
            url: "entry/wxapp/class",
            data: {
                op: "getNowWeatherData",
                uniacid: t,
                control: "index"
            },
            success: function(a) {
                e.setData({
                    weather: a.data.weather,
                    weatherSet: a.data.weatherSet
                }), wx.setStorageSync("kundian_farm_weather", a.data.weather);
            }
        });
    },
    preventTouchMove: function() {},
    intoVetInfo: function(a) {
        var t = a.currentTarget.dataset.title;
        this.data.setData.vet_title && (t = this.data.setData.vet_title), wx.navigateTo({
            url: "/kundian_farm/pages/shop/VeterinaryIntroduce/index?title=" + t
        });
    },
    onShareAppMessage: function() {
        var a = wx.getStorageSync("kundian_farm_setData");
        return {
            path: "kundian_farm/pages/HomePage/index/index?&user_uid=" + wx.getStorageSync("kundian_farm_uid"),
            success: function(a) {},
            title: a.share_home_title
        };
    },
    onPullDownRefresh: function(e) {
        wx.showLoading({
            title: "玩命加载中..."
        });
        var r = this;
        a.util.request({
            url: "entry/wxapp/class",
            data: {
                uniacid: t,
                op: "getCommonData",
                control: "index",
                refresh: !0
            },
            success: function(a) {
                wx.setStorageSync("kundianFarmTarbar", a.data.tarbar), wx.setStorageSync("kundian_farm_setData", a.data.farmSetData), 
                r.setData({
                    tarbar: a.data.tarbar,
                    setData: a.data.farmSetData
                }), r.getFirstData(), wx.stopPullDownRefresh(), wx.hideLoading();
            }
        });
    },
    getFirstData: function() {
        var e = arguments.length > 0 && void 0 !== arguments[0] && arguments[0], r = this, n = wx.getStorageSync("kundian_farm_uid");
        wx.getStorageSync("kundian_farm_setData");
        a.util.request({
            url: "entry/wxapp/class",
            data: {
                op: "getHomeData",
                control: "index",
                uniacid: t,
                uid: n,
                refresh: e
            },
            success: function(a) {
                var e = new Array();
                a.data.weather && (e = a.data.weather, wx.setStorageSync("kundian_farm_weather", e));
                var n = new Array();
                a.data.weatherSet && (n = a.data.weatherSet);
                var i = !1;
                "search" == a.data.page[0].type && (i = !0), i || (r.data.barDistance = 128, r.data.isIphoneX && (r.data.barDistance = 176));
                var s = a.data, o = s.page;
                s.icon;
                r.setData({
                    page: o,
                    weather: e,
                    loading: !1,
                    weatherSet: n,
                    icon: a.data.icon,
                    barDistance: r.data.barDistance
                }), wx.setStorageSync("kundianFarmHomePage", a.data);
                var u = parseInt(new Date().valueOf()) + 18e5;
                wx.setStorageSync("kundianFarmHomePage_time" + t, u);
            }
        });
    },
    onShow: function() {
        var t = this, e = wx.getStorageSync("kundian_farm_uid"), r = this.data.user_uid;
        void 0 != r && 0 != r && (a.loginBindParent(r, e), t.setData({
            user_uid: r
        }));
    }
});