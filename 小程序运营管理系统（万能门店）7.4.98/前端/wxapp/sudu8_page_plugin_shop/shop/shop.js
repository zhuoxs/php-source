var WxParse = require("../../sudu8_page/resource/wxParse/wxParse.js"), app = getApp();

Page({
    data: {
        page_sign: "store",
        footer: {
            i_tel: app.globalData.i_tel,
            i_add: app.globalData.i_add,
            i_time: app.globalData.i_time
        },
        baseinfo: [],
        minHeight: 220,
        lat: "",
        lon: "",
        address: "",
        content: ""
    },
    onPullDownRefresh: function() {
        var a = this.data.id;
        this.getbaseinfo(), this.getAbout(a), wx.stopPullDownRefresh();
    },
    onLoad: function(a) {
        var t = this;
        t.setData({
            isIphoneX: app.globalData.isIphoneX
        });
        var e = a.scene;
        if (0 < e) t.setData({
            id: e
        }); else {
            var o = a.cid;
            t.setData({
                id: o
            });
        }
        var s = 0;
        a.fxsid && (s = a.fxsid, t.setData({
            fxsid: a.fxsid
        })), t.getbaseinfo(), app.util.getUserInfo(t.getinfos, s);
    },
    redirectto: function(a) {
        var t = a.currentTarget.dataset.link, e = a.currentTarget.dataset.linktype;
        app.util.redirectto(t, e);
    },
    getinfos: function() {
        var e = this;
        wx.getStorage({
            key: "openid",
            success: function(a) {
                e.setData({
                    openid: a.data
                });
                var t = e.data.id;
                e.getAbout(t);
            }
        });
    },
    getbaseinfo: function() {
        var t = this, a = app.util.url("entry/wxapp/Base", {
            m: "sudu8_page"
        });
        wx.request({
            url: a,
            data: {
                vs1: 1
            },
            success: function(a) {
                t.setData({
                    baseinfo: a.data.data
                }), wx.setNavigationBarColor({
                    frontColor: t.data.baseinfo.base_tcolor,
                    backgroundColor: t.data.baseinfo.base_color
                });
            },
            fail: function(a) {}
        });
    },
    getAbout: function(a) {
        var e = this;
        app.util.request({
            url: "entry/wxapp/showstore",
            data: {
                id: a
            },
            success: function(a) {
                var t = a.data.data;
                e.setData({
                    aboutinfo: a.data.data,
                    lat: a.data.data.latitude,
                    lon: a.data.data.longitude,
                    address: a.data.data.address,
                    content: WxParse.wxParse("content", "html", t.descp, e, 0)
                }), wx.setNavigationBarTitle({
                    title: e.data.aboutinfo.name
                }), wx.setStorageSync("isShowLoading", !1), wx.hideNavigationBarLoading(), wx.stopPullDownRefresh();
            }
        });
    },
    dianPhoneCall: function(a) {
        var t = a.currentTarget.dataset.index;
        wx.makePhoneCall({
            phoneNumber: t
        });
    },
    openMap: function() {
        var a = this;
        wx.openLocation({
            latitude: parseFloat(a.data.lat),
            longitude: parseFloat(a.data.lon),
            name: a.data.aboutinfo.name,
            address: a.data.address,
            scale: 22
        });
    },
    onShareAppMessage: function() {
        return {
            title: this.data.aboutinfo.title
        };
    },
    imgYu: function(a) {
        var t = a.currentTarget.dataset.src, e = a.currentTarget.dataset.list;
        wx.previewImage({
            current: t,
            urls: e
        });
    },
    goshoppay: function() {
        wx.navigateTo({
            url: "/sudu8_page/shoppay/shoppay?sid=" + this.data.id
        });
    }
});