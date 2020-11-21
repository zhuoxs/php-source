var t, a = require("../../components/wxSearch/wxSearch.js"), e = require("../../utils/qqmap-wx-jssdk.min.js"), n = !0, i = getApp();

Page({
    data: {
        list: [],
        banner: [],
        info: [],
        isShow: !1,
        uid: "",
        keys: ""
    },
    onLoad: function() {
        var a = this;
        wx.createInterstitialAd && ((n = wx.createInterstitialAd({
            adUnitId: "adunit-93cd8663a25858e4"
        })).onLoad(function() {}), n.onError(function(t) {}), n.onClose(function() {})), 
        a.seachTag(), a.vUpdate(), i.util.getUserInfo(function(t) {
            t.memberInfo ? (a.setData({
                uid: t.memberInfo.uid
            }), wx.setStorageSync("uid", t.memberInfo.uid)) : a.hideDialog();
        }), i.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_master",
                r: "home.index"
            },
            success: function(n) {
                if (n.data.data) {
                    wx.setNavigationBarTitle({
                        title: n.data.data.info.name
                    });
                    t = new e({
                        key: n.data.data.key
                    }), wx.getLocation({
                        type: "wgs84",
                        success: function(t) {
                            a.getCity(t.latitude, t.longitude);
                        }
                    }), a.setData({
                        banner: n.data.data.banner,
                        list: n.data.data.list,
                        nav: n.data.data.nav,
                        info: n.data.data.info
                    });
                }
            }
        });
    },
    onShow: function() {
        n && n.show().catch(function(t) {
            console.error(t);
        });
    },
    hideDialog: function() {
        this.setData({
            isShow: !this.data.isShow
        });
    },
    updateUserInfo: function(t) {
        var a = this;
        a.hideDialog(), i.util.getUserInfo(function(t) {
            a.setData({
                uid: res.memberInfo.uid
            }), wx.setStorageSync("uid", t.memberInfo.uid);
        }, t.detail);
    },
    onPullDownRefresh: function() {
        var t = this;
        i.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_master",
                r: "home.index"
            },
            success: function(a) {
                a.data.data && (wx.setNavigationBarTitle({
                    title: a.data.data.info.name
                }), t.setData({
                    banner: a.data.data.banner,
                    list: a.data.data.list,
                    nav: a.data.data.nav,
                    info: a.data.data.info
                })), wx.stopPullDownRefresh();
            }
        });
    },
    goType: function(t) {
        var a = this;
        i.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_master",
                r: "me.add_formid",
                uid: a.data.uid,
                formid: t.detail.formId
            }
        }), wx.navigateTo({
            url: "/pages/index/serviceList/index?type=" + t.target.dataset.id
        });
    },
    onShareAppMessage: function() {},
    gofenlei: function(t) {
        var a = this;
        i.util.request({
            url: "entry/wxapp/Api",
            showLoading: !1,
            data: {
                m: "ox_master",
                r: "me.add_formid",
                uid: a.data.uid,
                formid: t.detail.formId
            }
        }), wx.navigateTo({
            url: "/pages/need/pages/home/index?type_value=" + t.target.dataset.name
        });
    },
    vUpdate: function() {
        var t = wx.getUpdateManager();
        t.onCheckForUpdate(function(t) {
            console.log(t.hasUpdate);
        }), t.onUpdateReady(function() {
            wx.showModal({
                title: "更新提示",
                content: "新版本已经准备好，是否重启应用？",
                success: function(a) {
                    a.confirm && t.applyUpdate();
                }
            });
        });
    },
    wxSearchFn: function(t) {},
    wxSearchInput: function(t) {
        var e = this;
        a.wxSearchInput(t, e);
    },
    wxSerchFocus: function(t) {
        var e = this;
        a.wxSearchFocus(t, e);
    },
    wxSearchBlur: function(t) {
        var e = this;
        a.wxSearchBlur(t, e);
    },
    wxSearchKeyTap: function(t) {
        wx.navigateTo({
            url: "/pages/need/pages/home/index?type_value=" + t.target.dataset.key
        });
    },
    wxSearchDeleteKey: function(t) {
        var e = this;
        a.wxSearchDeleteKey(t, e);
    },
    wxSearchDeleteAll: function(t) {
        var e = this;
        a.wxSearchDeleteAll(e);
    },
    wxSearchTap: function(t) {
        var e = this;
        a.wxSearchHiddenPancel(e);
    },
    seachTag: function(t) {
        var e = this;
        i.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_master",
                r: "home.hotTag",
                uid: e.data.uid
            },
            success: function(t) {
                if (t.data.data) {
                    var n = t.data.data.list, i = t.data.data.hot;
                    a.init(e, 46, i), a.initMindKeys(n);
                }
            }
        });
    },
    getCity: function(a, e) {
        var n = this;
        t.reverseGeocoder({
            location: {
                latitude: a,
                longitude: e
            },
            success: function(t) {
                var t = t.result, a = [];
                a.push({
                    title: t.address_component.city
                }), n.setData({
                    title: a[0].title
                });
            },
            fail: function(t) {
                console.error(t);
            }
        });
    }
});