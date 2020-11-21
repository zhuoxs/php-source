var WxParse = require("../../sudu8_page/resource/wxParse/wxParse.js"), app = getApp();

Page({
    data: {
        footer: {
            i_tel: app.globalData.i_tel,
            i_add: app.globalData.i_add,
            i_time: app.globalData.i_time
        },
        baseinfo: [],
        minHeight: 220,
        heighthave: 0
    },
    onPullDownRefresh: function() {
        this.getbaseinfo(), this.getPage(), wx.stopPullDownRefresh();
    },
    onReady: function() {},
    onLoad: function(a) {
        var e = a.cid, t = this;
        t.setData({
            isIphoneX: app.globalData.isIphoneX
        }), t.setData({
            page_sign: "page" + a.cid,
            id: e
        });
        var i = 0;
        a.fxsid && (i = a.fxsid, t.setData({
            fxsid: a.fxsid
        })), t.getbaseinfo(), app.util.getUserInfo(t.getinfos, i);
    },
    redirectto: function(a) {
        var e = a.currentTarget.dataset.link, t = a.currentTarget.dataset.linktype;
        app.util.redirectto(e, t);
    },
    getinfos: function() {
        var e = this;
        wx.getStorage({
            key: "openid",
            success: function(a) {
                e.setData({
                    openid: a.data
                }), e.getPage();
            }
        });
    },
    getbaseinfo: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/BaseMin",
            cachetime: "30",
            data: {
                vs1: 1
            },
            success: function(a) {
                e.setData({
                    baseinfo: a.data.data
                }), wx.setNavigationBarColor({
                    frontColor: e.data.baseinfo.base_tcolor,
                    backgroundColor: e.data.baseinfo.base_color
                });
            },
            fail: function(a) {}
        });
    },
    getPage: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/Page",
            cachetime: "30",
            data: {
                id: t.data.id
            },
            success: function(a) {
                var e = a.data.data;
                t.setData({
                    pagename: e.name,
                    pageename: e.ename,
                    content: WxParse.wxParse("content", "html", e.content, t, 0)
                }), wx.setNavigationBarTitle({
                    title: t.data.pagename
                }), wx.setStorageSync("isShowLoading", !1), wx.hideNavigationBarLoading(), wx.stopPullDownRefresh();
            }
        });
    },
    swiperLoad: function(i) {
        var n = this;
        wx.getSystemInfo({
            success: function(a) {
                var e = i.detail.width / i.detail.height, t = a.windowWidth / e;
                n.data.heighthave || n.setData({
                    minHeight: t,
                    heighthave: 1
                });
            }
        });
    },
    makePhoneCall: function(a) {
        var e = this.data.baseinfo.tel;
        wx.makePhoneCall({
            phoneNumber: e
        });
    },
    makePhoneCallB: function(a) {
        var e = this.data.baseinfo.tel_b;
        wx.makePhoneCall({
            phoneNumber: e
        });
    },
    openMap: function(a) {
        var e = this;
        wx.openLocation({
            latitude: parseFloat(e.data.baseinfo.latitude),
            longitude: parseFloat(e.data.baseinfo.longitude),
            name: e.data.baseinfo.name,
            address: e.data.baseinfo.address,
            scale: 22
        });
    }
});