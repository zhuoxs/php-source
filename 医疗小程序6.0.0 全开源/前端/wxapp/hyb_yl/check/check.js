var WxParse = require("../wxParse/wxParse.js"), app = getApp();

Page({
    data: {},
    onLoad: function(t) {
        var a = this, n = wx.getStorageSync("color");
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: n
        });
        var e = t.id, i = t.title;
        wx.setNavigationBarTitle({
            title: i
        }), a.setData({
            id: e
        }), app.util.request({
            url: "entry/wxapp/Base",
            success: function(t) {
                t.data.data.ztcolor, a.setData({
                    base: t.data.data
                });
            },
            fail: function(t) {
                console.log(t);
            }
        }), this.getSeflinfo();
    },
    returnClick: function() {
        wx.switchTab({
            url: "/hyb_yl/index/index"
        });
    },
    onReady: function() {
        this.getAllyzfuwu(), this.getAllzzanli();
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    getSeflinfo: function() {
        var a = this, t = a.data.id;
        app.util.request({
            url: "entry/wxapp/Seflinfo",
            data: {
                id: t
            },
            success: function(t) {
                a.setData({
                    seflinfo: t.data.data
                }), WxParse.wxParse("articles", "html", t.data.data.ksdesc, a, 5);
            },
            fail: function(t) {
                console.log(t);
            }
        });
    },
    getAllyzfuwu: function() {
        var a = this, t = a.data.id;
        app.util.request({
            url: "entry/wxapp/Allyzfuwu",
            data: {
                parid: t
            },
            success: function(t) {
                a.setData({
                    yzfuwu: t.data.data
                });
            },
            fail: function(t) {
                console.log(t);
            }
        });
    },
    getAllzzanli: function() {
        var a = this, t = a.data.id;
        app.util.request({
            url: "entry/wxapp/Allzzanli",
            data: {
                parid: t
            },
            success: function(t) {
                a.setData({
                    zzanli: t.data.data
                });
            },
            fail: function(t) {
                console.log(t);
            }
        });
    },
    tjdoc: function(t) {
        var a = t.currentTarget.dataset.id;
        wx.navigateTo({
            url: "/hyb_yl/zhuanjiazhuye/zhuanjiazhuye?id=" + a
        });
    },
    tijianDetail: function(t) {
        var a = t.currentTarget.dataset.f_id;
        wx.navigateTo({
            url: "/hyb_yl/tijian_detail/tijian_detail?f_id=" + a
        });
    },
    tt_detail: function(t) {
        var a = t.currentTarget.dataset.hz_id, n = t.currentTarget.dataset.hz_name;
        wx.navigateTo({
            url: "/hyb_yl/tt_detail/tt_detail?hz_id=" + a + "&hz_name=" + n
        });
    }
});