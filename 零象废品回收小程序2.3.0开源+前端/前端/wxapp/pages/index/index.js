var a, t = require("../../utils/qqmap-wx-jssdk.min.js"), e = getApp();

Page({
    data: {
        list: [],
        banner: [],
        info: [],
        isShow: !1,
        uid: "",
        keys: "",
        tiaozhuan: []
    },
    onLoad: function(n) {
        var i = this;
        i.vUpdate(), e.util.getUserInfo(function(a) {
            a.memberInfo ? (i.setData({
                uid: a.memberInfo.uid
            }), wx.setStorageSync("uid", a.memberInfo.uid)) : i.hideDialog();
        }), e.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_reclaim",
                r: "home.index"
            },
            success: function(a) {
                a.data.data && (wx.setNavigationBarTitle({
                    title: a.data.data.info.title
                }), i.setData({
                    banner: a.data.data.banner,
                    rule: a.data.data.rule,
                    type: a.data.data.type,
                    info: a.data.data.info,
                    tiaozhuan: a.data.data.tiaozhuan
                }));
            }
        }), a = new t({
            key: "XC2BZ-OGTRJ-AEDFB-FMHHP-XMOEO-KWBAM"
        }), wx.getLocation({
            type: "wgs84",
            success: function(a) {
                i.getCity(a.latitude, a.longitude);
            }
        });
    },
    onShow: function() {},
    goType: function(a) {
        wx.navigateTo({
            url: "/pages/need/pages/home/index?id=" + a.currentTarget.dataset.id + "&type=" + a.currentTarget.dataset.type
        });
    },
    goother: function(a) {
        var t = this.data.tiaozhuan[a.currentTarget.dataset.index];
        "" != t.appid && void 0 != t.appid ? wx.navigateToMiniProgram({
            appId: t.appid,
            path: t.pages,
            extraData: {
                foo: "bar"
            },
            success: function(a) {}
        }) : wx.navigateTo({
            url: t.pages
        });
    },
    hideDialog: function() {
        this.setData({
            isShow: !this.data.isShow
        });
    },
    updateUserInfo: function(a) {
        var t = this;
        t.hideDialog(), e.util.getUserInfo(function(a) {
            t.setData({
                uid: res.memberInfo.uid
            }), wx.setStorageSync("uid", a.memberInfo.uid);
        }, a.detail);
    },
    onPullDownRefresh: function() {
        var a = this;
        e.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_reclaim",
                r: "home.index"
            },
            success: function(t) {
                t.data.data && (wx.setNavigationBarTitle({
                    title: t.data.data.info.name
                }), a.setData({
                    banner: t.data.data.banner,
                    list: t.data.data.list,
                    nav: t.data.data.nav,
                    info: t.data.data.info,
                    tiaozhuan: t.data.data.tiaozhuan
                })), wx.stopPullDownRefresh();
            }
        });
    },
    onShareAppMessage: function() {},
    vUpdate: function() {
        var a = wx.getUpdateManager();
        a.onCheckForUpdate(function(a) {
            console.log(a.hasUpdate);
        }), a.onUpdateReady(function() {
            wx.showModal({
                title: "更新提示",
                content: "新版本已经准备好，是否重启应用？",
                success: function(t) {
                    t.confirm && a.applyUpdate();
                }
            });
        });
    },
    goWxapp: function(a) {
        wx.navigateToMiniProgram({
            appId: "wx582bece42111ec7d",
            path: "",
            extraData: {
                foo: "bar"
            },
            success: function(a) {}
        });
    },
    call: function(a) {
        console.log(a), wx.makePhoneCall({
            phoneNumber: a.currentTarget.dataset.phone
        });
    },
    getCity: function(t, e) {
        var n = this;
        a.reverseGeocoder({
            location: {
                latitude: t,
                longitude: e
            },
            success: function(a) {
                var a = a.result, t = [];
                t.push({
                    title: a.address_component.city
                }), n.setData({
                    title: t[0].title
                });
            },
            fail: function(a) {
                console.error(a);
            }
        });
    }
});