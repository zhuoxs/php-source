var app = getApp(), template = require("../template/template.js");

Page({
    data: {
        indicatorDots: !0,
        autoplay: !0,
        interval: 5e3,
        duration: 2e3,
        circular: !0,
        statusType: [ "最多推荐", "距离最近" ],
        currentTab: 0,
        currentType: 0,
        num: 0,
        light: "",
        kong: ""
    },
    onLoad: function() {
        var i = this;
        wx.getStorage({
            key: "url",
            success: function(t) {
                i.setData({
                    url: t.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/system",
            cachetime: "0",
            success: function(t) {
                console.log(t.data), i.setData({
                    banners: t.data.platform_ad
                });
            }
        }), wx.getLocation({
            type: "wgs84",
            success: function(t) {
                console.log(t);
                var a = t.latitude, e = t.longitude;
                app.util.request({
                    url: "entry/wxapp/GetMinmumBranch",
                    cachetime: "0",
                    data: {
                        lat: a,
                        lng: e
                    },
                    success: function(t) {
                        console.log(t);
                        for (var a = [], e = [], r = t.data.data, n = 0; n < r.length; n++) {
                            a[n] = new Array(), e[n] = new Array();
                            for (var o = 0; o < t.data.data[n].stars; o++) a[n][o] = 1;
                            for (var s = 0; s < 5 - t.data.data[n].stars; s++) e[n][s] = 1;
                        }
                        for (n = 0; n < r.length; n++) r[n].star = a[n], r[n].kong = e[n];
                        console.log(r), i.setData({
                            aroundMerch: r
                        });
                    }
                }), app.util.request({
                    url: "entry/wxapp/GetMaxRecommend",
                    cachetime: "0",
                    data: {
                        lat: a,
                        lng: e
                    },
                    success: function(t) {
                        console.log(t);
                        for (var a = [], e = [], r = t.data.data, n = 0; n < r.length; n++) {
                            a[n] = new Array(), e[n] = new Array();
                            for (var o = 0; o < t.data.data[n].stars; o++) a[n][o] = 1;
                            for (var s = 0; s < 5 - t.data.data[n].stars; s++) e[n][s] = 1;
                        }
                        for (n = 0; n < r.length; n++) r[n].star = a[n], r[n].kong = e[n];
                        console.log(r), i.setData({
                            maxRecommend: t.data.data
                        });
                    }
                });
            }
        }), i.diyWinColor();
    },
    statusTap: function(t) {
        var a = t.currentTarget.dataset.index;
        this.setData({
            currentType: a
        });
    },
    goShopDetailsTap: function(t) {
        console.log(t);
        var a = t.currentTarget.dataset.store_id, e = t.currentTarget.dataset.store_name;
        wx.navigateTo({
            url: "../shopDetails/shopDetails?store_id=" + a + "&&store_name=" + e
        });
    },
    getUserInfo: function(t) {
        console.log(t), app.globalData.userInfo = t.detail.userInfo, this.setData({
            userInfo: t.detail.userInfo,
            hasUserInfo: !0
        });
    },
    diyWinColor: function(t) {
        var a = wx.getStorageSync("system");
        wx.setNavigationBarColor({
            frontColor: a.color,
            backgroundColor: a.fontcolor,
            animation: {
                duration: 400,
                timingFunc: "easeIn"
            }
        }), wx.setNavigationBarTitle({
            title: "好店"
        });
    },
    bindChange: function(t) {
        this.setData({
            currentTab: t.detail.current
        });
    },
    swichNav: function(t) {
        if (this.data.currentTab === t.target.dataset.current) return !1;
        this.setData({
            currentTab: t.target.dataset.current
        });
    },
    bindGetUserInfo: function(t) {
        console.log(t.detail.userInfo), this.setData({
            isLogin: !1
        });
    },
    onShow: function() {},
    onHide: function() {}
});