var _Page;

function _defineProperty(e, a, t) {
    return a in e ? Object.defineProperty(e, a, {
        value: t,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : e[a] = t, e;
}

var WxParse = require("../../sudu8_page/resource/wxParse/wxParse.js"), app = getApp();

Page((_defineProperty(_Page = {
    data: {
        baseinfo: [],
        page_signs: "/sudu8_page/copy/copy"
    },
    onLoad: function(e) {
        var a = e.id;
        this.setData({
            id: a
        });
    },
    onPullDownRefresh: function() {
        this.getbaseinfo(), wx.stopPullDownRefresh();
    }
}, "onLoad", function(e) {
    var a = this, t = 0;
    e.fxsid && (t = e.fxsid, a.setData({
        fxsid: e.fxsid
    })), a.getbaseinfo(), app.util.getUserInfo(a.getinfos, t);
}), _defineProperty(_Page, "redirectto", function(e) {
    var a = e.currentTarget.dataset.link, t = e.currentTarget.dataset.linktype;
    app.util.redirectto(a, t);
}), _defineProperty(_Page, "getinfos", function() {
    var a = this;
    wx.getStorage({
        key: "openid",
        success: function(e) {
            a.setData({
                openid: e.data
            });
        }
    });
}), _defineProperty(_Page, "getbaseinfo", function() {
    var a = this;
    app.util.request({
        url: "entry/wxapp/BaseMin",
        cachetime: "30",
        data: {
            vs1: 1
        },
        success: function(e) {
            a.setData({
                base_tcolor: e.data.data.base_tcolor,
                base_color: e.data.data.base_color,
                copyname: e.data.data.copyright,
                copytel: e.data.data.tel_b
            }), wx.setNavigationBarTitle({
                title: a.data.copyname
            }), wx.setNavigationBarColor({
                frontColor: a.data.base_tcolor,
                backgroundColor: a.data.base_color
            });
        },
        fail: function(e) {}
    }), app.util.request({
        url: "entry/wxapp/copycon",
        cachetime: "30",
        data: {
            id: a.data.id
        },
        success: function(e) {
            a.setData({
                copycon: WxParse.wxParse("copycon", "html", e.data.data.copycon, a, 0)
            });
        },
        fail: function(e) {}
    });
}), _defineProperty(_Page, "onShareAppMessage", function() {
    return {
        title: this.data.copyname
    };
}), _Page));